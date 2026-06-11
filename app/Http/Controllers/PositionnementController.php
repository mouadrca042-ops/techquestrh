<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcours;

class PositionnementController extends Controller
{
    public function show(Parcours $parcours)
    {
        $user  = auth()->user();
        $pivot = $user->parcours()->where('parcours_id', $parcours->id)->first()?->pivot;

        // Pas inscrit → retour au parcours (choisir() doit être appelé avant)
        if (!$pivot) {
            return redirect()->route('parcours.show', $parcours);
        }

        // Déjà positionné → retour au parcours
        if ($pivot->niveau_depart !== null) {
            return redirect()->route('parcours.show', $parcours);
        }

        // Pas de test configuré → retour au parcours
        if (empty($parcours->test_positionnement['questions'])) {
            return redirect()->route('parcours.show', $parcours);
        }

        $questions = $parcours->test_positionnement['questions'];
        return view('positionnement.show', compact('parcours', 'questions'));
    }

    public function check(Request $request, Parcours $parcours)
    {
        $user      = auth()->user();
        $questions = $parcours->test_positionnement['questions'] ?? [];

        $reponses    = $request->input('reponses', []);
        $nbCorrectes = 0;

        foreach ($questions as $q) {
            if (isset($reponses[$q['id']]) && $reponses[$q['id']] == $q['bonne_reponse']) {
                $nbCorrectes++;
            }
        }

        // 0-1/3 → debutant | 2/3 → intermediaire | 3/3 → expert
        $niveauDepart = match (true) {
            $nbCorrectes === count($questions) => 'expert',
            $nbCorrectes >= 2                  => 'intermediaire',
            default                            => 'debutant',
        };

        $user->parcours()->updateExistingPivot($parcours->id, [
            'niveau_depart' => $niveauDepart,
        ]);

        $labels = [
            'debutant'      => 'Débutant — commencez depuis le début, pas de panique !',
            'intermediaire' => 'Intermédiaire — vous avez de bonnes bases, continuez !',
            'expert'        => 'Expert — vous maîtrisez déjà l\'essentiel, perfectionnez-vous !',
        ];

        return redirect()->route('parcours.show', $parcours)
            ->with('positionnement', $niveauDepart)
            ->with('positionnement_message', $labels[$niveauDepart]);
    }
}
