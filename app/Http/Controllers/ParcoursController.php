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
        // On récupère les défis liés à ce parcours
        $defis = $parcours->defis()->orderBy('niveau')->get();
        
        // On calcule la progression de l'utilisateur 
        $progression = $parcours->calculerProgressionGlobale(auth()->id());

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