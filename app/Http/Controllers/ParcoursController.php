<?php

namespace App\Http\Controllers;

use App\Models\Parcours;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParcoursController extends Controller
{
    // Affiche la liste des parcours
    public function index(): View
    {
        $parcours = Parcours::all();
        return view('parcours.index', compact('parcours'));
    }

    // Affiche les défis d'un parcours 
    public function show(Parcours $parcours): View
    {
        $userId = auth()->id();
        
        // Récupérer les IDs des défis complétés par l'utilisateur
        $defisCompletesIds = \App\Models\Progression::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->pluck('defi_id')
            ->toArray();

        // Récupérer les défis et ajouter est_complete sur chacun
        $defis = $parcours->defis()->orderBy('niveau')->get()->map(function ($defi) use ($defisCompletesIds) {
            $defi->est_complete = in_array($defi->id, $defisCompletesIds);
            return $defi;
        });

        // Calculer la progression
        $total = $defis->count();
        $completes = $defis->where('est_complete', true)->count();
        $progression = $total > 0 ? round(($completes / $total) * 100) : 0;

        return view('parcours.show', compact('parcours', 'defis', 'progression'));
    }
    
    // L'employé s'inscrit à un parcours
    public function choisir(Parcours $parcours)
    {
        $user = auth()->user();
        
        // On attache le parcours à l'utilisateur s'il n'y est pas déjà
        if (!$user->parcours()->where('parcours_id', $parcours->id)->exists()) {
            $user->parcours()->attach($parcours->id, ['statut' => 'en_cours']);
        }

        return redirect()->route('parcours.show', $parcours);
    }
}