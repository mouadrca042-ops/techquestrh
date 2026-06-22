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

        // Parcours inscrits ou avec progression
        $inscritIds = $user->parcours()->pluck('parcours.id');

        $avecProgressionIds = Parcours::whereHas('defis.progressions', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('id');

        $commenceesIds = $inscritIds->merge($avecProgressionIds)->unique();

        $parcoursEnCours = Parcours::whereIn('id', $commenceesIds)->get();

        // Progression par parcours
        $progressionExcel = 0;
        $progressionTeams = 0;

        foreach ($parcoursEnCours as $p) {
            $total = $p->defis()->count();
            $completes = Progression::where('user_id', $user->id)
                ->whereIn('defi_id', $p->defis()->pluck('id'))
                ->whereNotNull('completed_at')
                ->count();
            $prog = $total > 0 ? round(($completes / $total) * 100) : 0;

            if ($p->outil === 'Excel') $progressionExcel = $prog;
            if ($p->outil === 'Teams') $progressionTeams = $prog;

            $p->progression = $prog;
        }

        // Progression globale
        $progressionGlobale = $parcoursEnCours->isNotEmpty()
            ? (int) round($parcoursEnCours->avg('progression'))
            : 0;

        return view('dashboard', compact(
            'user',
            'progressionGlobale',
            'progressionExcel',
            'progressionTeams',
            'parcoursEnCours'
        ));
    }
}