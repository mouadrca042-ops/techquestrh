<?php

namespace App\Http\Controllers;

use App\Models\Parcours;
use App\Models\Progression;
use App\Models\Badge;
use App\Support\TestGlobal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParcoursController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $inscritIds = $user->parcours()->pluck('parcours.id');
        $avecProgressionIds = Parcours::whereHas('defis.progressions', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('id');
        $dejaCommenceesIds = $inscritIds->merge($avecProgressionIds)->unique()->all();

        $parcours = Parcours::withCount([
                'defis as defis_debutant'      => fn($q) => $q->where('niveau', 'debutant'),
                'defis as defis_intermediaire' => fn($q) => $q->where('niveau', 'intermediaire'),
                'defis as defis_expert'        => fn($q) => $q->where('niveau', 'expert'),
            ])
            ->get();

        return view('parcours.index', compact('parcours', 'dejaCommenceesIds'));
    }

    public function show(Parcours $parcours): View
    {
        $user   = auth()->user();
        $userId = $user->id;

        $pivotParcours = $user->parcours()->where('parcours_id', $parcours->id)->first();
        $inscrit       = $pivotParcours !== null;
        $niveauDepart  = $pivotParcours?->pivot->niveau_depart ?? null;

        $defisIds = $parcours->defis()->pluck('id');

        $progressions = Progression::where('user_id', $userId)
            ->whereIn('defi_id', $defisIds)
            ->get()
            ->keyBy('defi_id');

        $modules = $parcours->defis()
            ->orderBy('ordre')
            ->orderBy('id')
            ->get()
            ->map(function ($defi) use ($progressions) {
                $p = $progressions->get($defi->id);
                $contenu = is_string($defi->contenu_json) 
                    ? json_decode($defi->contenu_json, true) 
                    : $defi->contenu_json;
                $defi->contenu_json      = $contenu;
                $defi->est_complete      = $p && $p->completed_at !== null;
                $defi->question_courante = $p->question_courante ?? 0;
                $defi->nb_questions      = count($contenu['questions'] ?? [$contenu]);
                $defi->en_cours          = $p && !$defi->est_complete && ($p->question_courante ?? 0) > 0;
                return $defi;
            })
            ->values();

        $ordreNiveaux  = ['debutant' => 0, 'intermediaire' => 1, 'expert' => 2];
        $parNiveau     = $modules->groupBy('niveau');
        $niveauComplet = [];
        foreach (['debutant', 'intermediaire', 'expert'] as $niv) {
            $grp = $parNiveau->get($niv, collect());
            $niveauComplet[$niv] = $grp->isNotEmpty() && $grp->every(fn($m) => $m->est_complete);
        }
        $modules->each(function ($m) use ($ordreNiveaux, $niveauComplet, $inscrit) {
            $rang = $ordreNiveaux[$m->niveau] ?? 0;
            if (!$inscrit) {
                $m->verrouille = true;
            } elseif ($rang === 0) {
                $m->verrouille = false;
            } elseif ($rang === 1) {
                $m->verrouille = !($niveauComplet['debutant'] ?? false);
            } else {
                $m->verrouille = !($niveauComplet['intermediaire'] ?? false);
            }
            if ($m->est_complete) {
                $m->verrouille = false;
            }
        });

        $total       = $modules->count();
        $completes   = $modules->where('est_complete', true)->count();
        $progression = $total > 0 ? round(($completes / $total) * 100) : 0;

        $tousTermines = $total > 0 && $completes >= $total;
        $secret       = Badge::where('condition_type', 'secret')->first();
        $examenReussi = $secret && $user->badges()->where('badge_id', $secret->id)->exists();

        return view('parcours.show', compact(
            'parcours', 'modules', 'progression', 'inscrit', 'niveauDepart',
            'total', 'completes', 'tousTermines', 'examenReussi'
        ));
    }

    public function positionnement(Parcours $parcours)
    {
        return redirect()->route('parcours.show', $parcours);
    }

    public function testFinal(Parcours $parcours)
    {
        $user     = auth()->user();
        $defisIds = $parcours->defis()->pluck('id');
        $total    = $defisIds->count();
        $completes = Progression::where('user_id', $user->id)
            ->whereIn('defi_id', $defisIds)
            ->whereNotNull('completed_at')
            ->count();

        if ($total === 0 || $completes < $total) {
            return redirect()->route('parcours.show', $parcours)
                ->with('error', "Terminez d'abord tous les modules.");
        }

        return redirect()->route('parcours.show', $parcours)
            ->with('success', 'Test final bientôt disponible !');
    }

    public function testFinalCheck(Request $request, Parcours $parcours)
    {
        return redirect()->route('parcours.show', $parcours);
    }

    public function choisir(Parcours $parcours)
    {
        $user = auth()->user();

        if (!$user->parcours()->where('parcours_id', $parcours->id)->exists()) {
            $user->parcours()->attach($parcours->id, ['statut' => 'en_cours']);
        }

        return redirect()->route('parcours.show', $parcours);
    }
}