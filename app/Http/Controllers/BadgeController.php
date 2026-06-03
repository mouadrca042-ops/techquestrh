<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    public function index()
    {
        // On récupère tous les badges créés avec le seeder
        $allBadges = Badge::all();

        // On récupère les IDs des badges déjà obtenus par l'utilisateur connecté
        $userBadgesIds = Auth::user()->badges()->pluck('badge_id')->toArray();

        return view('badges.index', compact('allBadges', 'userBadgesIds'));
    }
}