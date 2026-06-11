<?php

namespace App\Http\Controllers;

use App\Models\Parcours;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParcoursController extends Controller
{
    // Affiche le catalogue : TOUTES les formations.
    // Les formations déjà commencées affichent « Continuer », les autres « Commencer ».
    public function index(): View
    {
        $user = auth()->user();

        // IDs des formations déjà commencées (inscription pivot OU progression existante).
        $inscritIds = $user->parcours()->pluck('parcours.id');
        $avecProgressionIds = Parcours::whereHas('defis.progressions', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('id');
        $dejaCommenceesIds = $inscritIds->merge($avecProgressionIds)->unique()->all();

        // Catalogue = toutes les formations, avec le compte de défis par niveau (les « modules »)
        $parcours = Parcours::withCount([
                'defis as defis_debutant'      => fn($q) => $q->where('niveau', 'debutant'),
                'defis as defis_intermediaire' => fn($q) => $q->where('niveau', 'intermediaire'),
                'defis as defis_expert'        => fn($q) => $q->where('niveau', 'expert'),
            ])
            ->get();

        return view('parcours.index', compact('parcours', 'dejaCommenceesIds'));
    }

    // Affiche les défis d'un parcours
    public function show(Parcours $parcours): View
    {
        $user   = auth()->user();
        $userId = $user->id;

        $pivotParcours = $user->parcours()->where('parcours_id', $parcours->id)->first();
        $inscrit       = $pivotParcours !== null;
        $niveauDepart  = $pivotParcours?->pivot->niveau_depart;

        $defisCompletesIds = \App\Models\Progression::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->pluck('defi_id')
            ->toArray();

        // Les modules sont présentés dans l'ordre du programme (Module 1, 2, 3…).
        $modules = $parcours->defis()
            ->orderBy('ordre')
            ->orderBy('id')
            ->get()
            ->map(function ($defi) use ($defisCompletesIds) {
                $defi->est_complete = in_array($defi->id, $defisCompletesIds);
                return $defi;
            })
            ->values();

        $total       = $modules->count();
        $completes   = $modules->where('est_complete', true)->count();
        $progression = $total > 0 ? round(($completes / $total) * 100) : 0;

        return view('parcours.show', compact(
            'parcours', 'modules', 'progression', 'inscrit', 'niveauDepart', 'total', 'completes'
        ));
    }

    // L'employé s'inscrit à un parcours puis passe le test de positionnement
    public function choisir(Parcours $parcours)
    {
        $user = auth()->user();

        if (!$user->parcours()->where('parcours_id', $parcours->id)->exists()) {
            $user->parcours()->attach($parcours->id, ['statut' => 'en_cours']);
        }

        // Si un test de positionnement est configuré → rediriger vers le test
        if (!empty($parcours->test_positionnement['questions'])) {
            return redirect()->route('positionnement.show', $parcours);
        }

        return redirect()->route('parcours.show', $parcours);
    }
}