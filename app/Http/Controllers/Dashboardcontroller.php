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

        // 1. Calcul spécifique pour le parcours Excel
        $defisExcelTotaux = 3; 
        $defisExcelReussis = Progression::where('user_id', $user->id)
            ->whereIn('defi_id', [1, 2, 3]) 
            ->where('score', 100)
            ->count();
        $progressionExcel = $defisExcelTotaux > 0 ? round(($defisExcelReussis / $defisExcelTotaux) * 100) : 0;

        // 2. Calcul spécifique pour le parcours Teams
        $defisTeamsTotaux = 2; 
        $defisTeamsReussis = Progression::where('user_id', $user->id)
            ->whereIn('defi_id', [4, 5]) 
            ->where('score', 100)
            ->count();
        $progressionTeams = $defisTeamsTotaux > 0 ? round(($defisTeamsReussis / $defisTeamsTotaux) * 100) : 0;

        // 3. Complétion globale moyenne
        $progressionGlobale = round(($progressionExcel + $progressionTeams) / 2);

        // 4. Récupérer les parcours pour les boutons de reprise (Notation officielle de tes collègues)
        $parcoursEnCours = Parcours::take(2)->get();

        return view('dashboard', compact(
            'user', 
            'progressionGlobale', 
            'progressionExcel', 
            'progressionTeams', 
            'parcoursEnCours'
        ));
    } // <-- L'accolade de la fonction index était mal placée ou manquante ici !
}