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

        // 1. « Mon apprentissage » : uniquement les formations DÉJÀ COMMENCÉES par l'utilisateur.
        //    Une formation est « commencée » si l'utilisateur s'y est inscrit (pivot parcours_user)
        //    OU s'il a déjà une progression sur l'un de ses défis.
        $inscritIds = $user->parcours()->pluck('parcours.id');

        $avecProgressionIds = Parcours::whereHas('defis.progressions', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('id');

        $commenceesIds = $inscritIds->merge($avecProgressionIds)->unique();

        $monApprentissage = Parcours::whereIn('id', $commenceesIds)
            ->withCount([
                'defis as defis_debutant'      => fn($q) => $q->where('niveau', 'debutant'),
                'defis as defis_intermediaire' => fn($q) => $q->where('niveau', 'intermediaire'),
                'defis as defis_expert'        => fn($q) => $q->where('niveau', 'expert'),
            ])
            ->get()
            ->map(function ($parcours) use ($user) {
                $parcours->progression = $parcours->calculerProgressionGlobale($user->id);
                return $parcours;
            });

        // 2. Progression globale = moyenne des progressions des formations commencées.
        $progressionGlobale = $monApprentissage->isNotEmpty()
            ? (int) round($monApprentissage->avg('progression'))
            : 0;

        return view('dashboard', compact(
            'user',
            'progressionGlobale',
            'monApprentissage'
        ));
    }
}