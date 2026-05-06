<?php

namespace App\Http\Controllers;

use App\Models\Defi;
use App\Models\Parcours;
use App\Models\Progression;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefiController extends Controller
{
    /**
     * Affiche la liste des défis d'un parcours
     * CDC : F08 - Afficher la liste des défis disponibles
     */
    public function index($parcoursId)
    {
        // Récupère le parcours
        $parcours = Parcours::findOrFail($parcoursId);

        // Récupère tous les défis de ce parcours
        $defis = Defi::where('parcours_id', $parcoursId)->get();

        // Pour chaque défi, vérifie s'il est verrouillé
        // CDC F11 : défis bloqués selon le niveau
        $user = Auth::user();
        $defis = $defis->map(function($defi) use ($user) {
            $defi->verrouille = $defi->estVerrouille($user->id);
            return $defi;
        });

        return view('defis.index', compact('parcours', 'defis'));
    }

    /**
     * Affiche un défi spécifique
     * CDC : F09 - QCM / F10 - Vrai Faux
     */
    public function show($id)
    {
        $defi = Defi::findOrFail($id);
        $user = Auth::user();

        // Vérifie si le défi est verrouillé
        // CDC F11 : niveau insuffisant
        if ($defi->estVerrouille($user->id)) {
            return redirect()->back()
                ->with('error', 'Ce défi n\'est pas encore disponible pour votre niveau.');
        }

        // Récupère la progression existante si elle existe
        $progression = Progression::where('user_id', $user->id)
                                  ->where('defi_id', $id)
                                  ->first();

        return view('defis.show', compact('defi', 'progression'));
    }

    /**
     * Valide la réponse d'un défi
     * CDC : F09 - Calcul score / F12 - Attribution XP / F14 - Message encourageant
     */
    public function valider(Request $request, $id)
    {
        $defi = Defi::findOrFail($id);
        $user = Auth::user();
        $reponse = $request->input('reponse');

        // Vérifie si la réponse est correcte
        $correct = $defi->verifierReponse($reponse);
        $score   = $correct ? 100 : 0;

        // Récupère ou crée la progression
        // CDC F13 : recommencer sans pénalité
        $progression = Progression::firstOrNew([
            'user_id' => $user->id,
            'defi_id' => $defi->id,
        ]);

        // Incrémente les tentatives (CDC F13)
        $progression->tentatives   = ($progression->tentatives ?? 0) + 1;
        $progression->score        = $score;
        $progression->completed_at = now();
        $progression->save();

        // Ajoute les XP si correct (CDC F12)
        if ($correct) {
            $user->xp_total += $defi->xp_recompense;
            $user->save();
            // Met à jour le niveau (CDC F11)
            $user->monterDeNiveau();
        }

        // Vérifie et attribue les badges (CDC F16)
        $this->verifierBadges($user->id);

        // Récupère l'explication bienveillante (CDC F14)
        $explication = $defi->donnerExplicationBienveillante();

        return view('defis.resultat', compact(
            'defi',
            'correct',
            'score',
            'explication',
            'progression'
        ));
    }

    /**
     * Vérifie et attribue les badges après chaque défi
     * CDC : F16, F17, F18, F19, F20
     */
    private function verifierBadges(int $userId): void
    {
        $badges = Badge::all();
        foreach ($badges as $badge) {
            $badge->attribuerBadge($userId);
        }
    }
}