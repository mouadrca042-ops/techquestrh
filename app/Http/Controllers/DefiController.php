<?php

namespace App\Http\Controllers;

use App\Models\Defi;
use App\Models\Progression;
use App\Models\Badge;
use Illuminate\Http\Request;

class DefiController extends Controller
{
    /**
     * Affiche un module (défi) : leçon en sous-modules + quiz.
     */
    public function show($id)
    {
        $defi = Defi::findOrFail($id);

        $progression = Progression::where('user_id', auth()->id())
            ->where('defi_id', $defi->id)
            ->first();

        return view('defis.show', compact('defi', 'progression'));
    }

    /**
     * Corrige le quiz, calcule le score, attribue l'XP et garde le meilleur score.
     */
    public function check(Request $request, $id)
    {
        $defi      = Defi::findOrFail($id);
        $contenu   = $defi->contenu_json; // array via cast
        $questions = $contenu['questions'];
        $user      = auth()->user();

        $progression = Progression::firstOrCreate(
            ['user_id' => $user->id, 'defi_id' => $defi->id],
            ['score' => 0, 'tentatives' => 0]
        );
        $progression->tentatives += 1;

        $reponses_user = $request->input('reponses', []);
        $resultats     = [];
        $nbCorrectes   = 0;

        foreach ($questions as $question) {
            $qid          = $question['id'];
            $reponse_user = $reponses_user[$qid] ?? null;
            // Comparaison souple : "1" == 1 (qcm index), "Vrai" == "Vrai" (vrai_faux)
            $correct = ($reponse_user == $question['bonne_reponse']);
            if ($correct) {
                $nbCorrectes++;
            }
            $resultats[$qid] = [
                'correct'       => $correct,
                'reponse_user'  => $reponse_user,
                'bonne_reponse' => $question['bonne_reponse'],
                'explication'   => $question['explication'] ?? null,
            ];
        }

        $score = (int) round(($nbCorrectes / count($questions)) * 100);

        // On garde le meilleur score (lu par le dashboard)
        $progression->score = max($progression->score, $score);

        $dejaComplete = $progression->completed_at !== null;
        if ($score >= 70 && !$dejaComplete) {
            $progression->completed_at = now();
            $user->xp_total += $defi->xp_recompense;
            $user->save();
        }
        $progression->save();

        // Attribution automatique des badges selon la progression de l'employé.
        // Renvoie les badges nouvellement débloqués (pour l'affichage).
        $nouveauxBadges = Badge::attribuerSelonProgression($user);

        $redirect = redirect()->route('defis.show', $defi->id)
            ->with('resultats', $resultats)
            ->with('score', $score);

        // Annonce des badges fraîchement débloqués (titre + type pour l'icône)
        if ($nouveauxBadges->isNotEmpty()) {
            $redirect->with('nouveaux_badges', $nouveauxBadges->map(fn ($b) => [
                'titre' => $b->titre,
                'type'  => $b->condition_type,
            ])->all());
        }

        // Message d'encouragement si le module n'est pas encore validé (< 70 %).
        if ($score < 70) {
            $redirect->with('message_motivant', Defi::messageMotivant($score));
        }

        return $redirect;
    }
}
