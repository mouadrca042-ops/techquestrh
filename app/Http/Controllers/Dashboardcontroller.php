<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcours;
use App\Models\Progression;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Calcul spécifique pour le parcours Excel (ID 1 par exemple)
        // Compte le nombre de défis réussis par l'utilisateur sur le parcours 1
        $defisExcelTotaux = 3; // Ajuste selon ton seeder (ex: 3 défis)
        $defisExcelReussis = Progression::where('user_id', $user->id)
            ->whereIn('defi_id', [1, 2, 3]) // IDs de tes défis Excel
            ->where('score', 100)
            ->count();
        $progressionExcel = $defisExcelTotaux > 0 ? round(($defisExcelReussis / $defisExcelTotaux) * 100) : 0;

        // 2. Calcul spécifique pour le parcours Teams (ID 2 par exemple)
        $defisTeamsTotaux = 2; // Ajuste selon ton seeder (ex: 2 défis)
        $defisTeamsReussis = Progression::where('user_id', $user->id)
            ->whereIn('defi_id', [4, 5]) // IDs de tes défis Teams
            ->where('score', 100)
            ->count();
        $progressionTeams = $defisTeamsTotaux > 0 ? round(($defisTeamsReussis / $defisTeamsTotaux) * 100) : 0;

        // 3. Complétion globale moyenne pour la barre violette
        $progressionGlobale = round(($progressionExcel + $progressionTeams) / 2);

        // 4. Récupérer les parcours pour les boutons de reprise
        $parcoursEnCours = Parcours::take(2)->get();

        return view('dashboard', compact(
            'user', 
            'progressionGlobale', 
            'progressionExcel', 
            'progressionTeams', 
            'parcoursEnCours'
        ));
    }
}