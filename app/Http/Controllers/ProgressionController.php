<?php

namespace App\Http\Controllers;

use App\Models\Progression;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressionController extends Controller
{
    /**
     * Affiche l'historique des défis complétés
     * CDC : F06 - Historique des défis avec date et score
     */
    public function historique()
    {
        $user = Auth::user();

        // Récupère toutes les progressions avec les défis associés
        // orderBy : les plus récents en premier
        $progressions = Progression::where('user_id', $user->id)
            ->with('defi.parcours') // charge le défi ET son parcours
            ->orderBy('completed_at', 'desc')
            ->get();

        return view('progressions.historique', compact('progressions'));
    }
}