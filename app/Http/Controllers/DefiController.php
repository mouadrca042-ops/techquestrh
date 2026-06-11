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
     * Quiz question par question :
     * - on valide UNE seule question à la fois ;
     * - tant que la réponse est fausse, on reste sur la même question (tentatives
     *   illimitées, non pénalisantes), avec un message encourageant ;
     * - dès qu'elle est correcte, on avance ; à la dernière, le module est validé.
     * La question en cours est sauvegardée (point de situation).
     */
    public function check(Request $request, $id)
    {
        $defi      = Defi::findOrFail($id);
        $questions = $defi->contenu_json['questions'];
        $nb        = count($questions);
        $user      = auth()->user();

        $progression = Progression::firstOrCreate(
            ['user_id' => $user->id, 'defi_id' => $defi->id],
            ['score' => 0, 'tentatives' => 0, 'question_courante' => 0]
        );

        // Module déjà terminé → rien à revalider.
        if ($progression->completed_at !== null) {
            return redirect()->route('defis.show', $defi->id);
        }

        // Question concernée (celle envoyée, sinon celle sauvegardée).
        $index    = (int) $request->input('question_index', $progression->question_courante);
        $index    = max(0, min($index, $nb - 1));
        $question = $questions[$index];

        $reponse = $request->input('reponse');
        $correct = ($reponse !== null && $reponse == $question['bonne_reponse']);

        // ── Mauvaise réponse : on reste sur la question, sans pénalité ──
        if (! $correct) {
            return redirect()->route('defis.show', $defi->id)
                ->with('reponse_correcte', false)
                ->with('message', Defi::messageMotivant(0));
        }

        // ── Bonne réponse ──
        $estDerniere = ($index >= $nb - 1);

        if ($estDerniere) {
            // Toutes les questions réussies → module validé
            $progression->question_courante = $nb;
            $progression->score             = 100;
            $progression->completed_at      = now();
            $progression->save();

            $user->xp_total += $defi->xp_recompense;
            $user->save();

            $nouveauxBadges = Badge::attribuerSelonProgression($user);

            $redirect = redirect()->route('defis.show', $defi->id)
                ->with('module_termine', true);

            if ($nouveauxBadges->isNotEmpty()) {
                $redirect->with('nouveaux_badges', $nouveauxBadges->map(fn ($b) => [
                    'titre' => $b->titre,
                    'type'  => $b->condition_type,
                ])->all());
            }

            return $redirect;
        }

        // On passe à la question suivante (progression sauvegardée).
        $progression->question_courante = $index + 1;
        $progression->save();

        return redirect()->route('defis.show', $defi->id)
            ->with('reponse_correcte', true)
            ->with('message', 'Bonne réponse ! Continue comme ça 💪');
    }
}
