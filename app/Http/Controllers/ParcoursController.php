<?php

namespace App\Http\Controllers;

use App\Models\Parcours;
use App\Models\Progression;
use App\Models\Badge;
use App\Support\TestGlobal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParcoursController extends Controller
{
    // Affiche le catalogue : TOUTES les formations.
    // Les formations déjà commencées affichent « Continuer », les autres « Commencer ».
    public function index(): View
    {
        $user = auth()->user();

        // IDs des formations déjà commencées (inscription pivot OU progression existante).
        $inscritIds = $user->parcours()->pluck('parcours.id');
        $avecProgressionIds = Parcours::whereHas('defis.progressions', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('id');
        $dejaCommenceesIds = $inscritIds->merge($avecProgressionIds)->unique()->all();

        // Catalogue = toutes les formations, avec le compte de défis par niveau (les « modules »)
        $parcours = Parcours::withCount([
                'defis as defis_debutant'      => fn($q) => $q->where('niveau', 'debutant'),
                'defis as defis_intermediaire' => fn($q) => $q->where('niveau', 'intermediaire'),
                'defis as defis_expert'        => fn($q) => $q->where('niveau', 'expert'),
            ])
            ->get();

        return view('parcours.index', compact('parcours', 'dejaCommenceesIds'));
    }

    // Affiche les défis d'un parcours
    public function show(Parcours $parcours): View
    {
        $user   = auth()->user();
        $userId = $user->id;

        $pivotParcours = $user->parcours()->where('parcours_id', $parcours->id)->first();
        $inscrit       = $pivotParcours !== null;
        $niveauDepart  = $pivotParcours?->pivot->niveau_depart;

        $defisIds = $parcours->defis()->pluck('id');

        // Progressions de l'utilisateur sur les modules de ce parcours (indexées par defi_id)
        $progressions = \App\Models\Progression::where('user_id', $userId)
            ->whereIn('defi_id', $defisIds)
            ->get()
            ->keyBy('defi_id');

        // Les modules sont présentés dans l'ordre du programme (Module 1, 2, 3…).
        $modules = $parcours->defis()
            ->orderBy('ordre')
            ->orderBy('id')
            ->get()
            ->map(function ($defi) use ($progressions) {
                $p = $progressions->get($defi->id);
                $defi->est_complete      = $p && $p->completed_at !== null;
                $defi->question_courante = $p->question_courante ?? 0;
                $defi->nb_questions      = count($defi->contenu_json['questions'] ?? []);
                // « en cours » = quiz entamé mais module pas encore validé
                $defi->en_cours          = $p && ! $defi->est_complete && $p->question_courante > 0;
                return $defi;
            })
            ->values();

        // ── Verrouillage par niveau : un niveau s'ouvre quand le niveau inférieur est 100 % terminé ──
        $ordreNiveaux  = ['debutant' => 0, 'intermediaire' => 1, 'expert' => 2];
        $parNiveau     = $modules->groupBy('niveau');
        $niveauComplet = [];
        foreach (['debutant', 'intermediaire', 'expert'] as $niv) {
            $grp = $parNiveau->get($niv, collect());
            $niveauComplet[$niv] = $grp->isNotEmpty() && $grp->every(fn($m) => $m->est_complete);
        }
        $modules->each(function ($m) use ($ordreNiveaux, $niveauComplet, $inscrit) {
            $rang = $ordreNiveaux[$m->niveau] ?? 0;
            if (! $inscrit) {
                $m->verrouille = true;                                  // pas inscrit → tout verrouillé
            } elseif ($rang === 0) {
                $m->verrouille = false;                                 // débutant toujours ouvert
            } elseif ($rang === 1) {
                $m->verrouille = ! ($niveauComplet['debutant'] ?? false);
            } else {
                $m->verrouille = ! ($niveauComplet['intermediaire'] ?? false);
            }
            if ($m->est_complete) {
                $m->verrouille = false;                                 // un module terminé reste consultable
            }
        });

        $total       = $modules->count();
        $completes   = $modules->where('est_complete', true)->count();
        $progression = $total > 0 ? round(($completes / $total) * 100) : 0;

        // Test global : débloqué quand TOUS les modules sont terminés
        $tousTermines = $total > 0 && $completes >= $total;
        $secret       = Badge::where('condition_type', 'secret')->first();
        $examenReussi = $secret && $user->badges()->where('badge_id', $secret->id)->exists();

        return view('parcours.show', compact(
            'parcours', 'modules', 'progression', 'inscrit', 'niveauDepart',
            'total', 'completes', 'tousTermines', 'examenReussi'
        ));
    }

    /**
     * Affiche le test global (examen final) de la formation.
     * Accessible uniquement quand tous les modules sont terminés.
     */
    public function testFinal(Parcours $parcours): View|\Illuminate\Http\RedirectResponse
    {
        $user     = auth()->user();
        $defisIds = $parcours->defis()->pluck('id');
        $total    = $defisIds->count();
        $completes = Progression::where('user_id', $user->id)
            ->whereIn('defi_id', $defisIds)
            ->whereNotNull('completed_at')
            ->count();

        if ($total === 0 || $completes < $total) {
            return redirect()->route('parcours.show', $parcours)
                ->with('error', "Terminez d'abord tous les modules pour accéder au test final.");
        }

        $questions = TestGlobal::pour($parcours->outil);

        return view('parcours.test-final', compact('parcours', 'questions'));
    }

    /**
     * Corrige le test global ; si réussi (≥ 70 %), attribue le badge secret.
     */
    public function testFinalCheck(Request $request, Parcours $parcours)
    {
        $user      = auth()->user();
        $questions = TestGlobal::pour($parcours->outil);

        if (empty($questions)) {
            return redirect()->route('parcours.show', $parcours);
        }

        $reponses    = $request->input('reponses', []);
        $resultats   = [];
        $nbCorrectes = 0;

        foreach ($questions as $q) {
            $rep = $reponses[$q['id']] ?? null;
            $ok  = ($rep !== null && $rep == $q['bonne_reponse']);
            if ($ok) {
                $nbCorrectes++;
            }
            $resultats[$q['id']] = [
                'correct'       => $ok,
                'reponse_user'  => $rep,
                'bonne_reponse' => $q['bonne_reponse'],
                'explication'   => $q['explication'] ?? null,
            ];
        }

        $score  = (int) round(($nbCorrectes / count($questions)) * 100);
        $reussi = $score >= 70;

        $badgeSecret = null;
        if ($reussi) {
            $secret = Badge::where('condition_type', 'secret')->first();
            if ($secret && ! $user->badges()->where('badge_id', $secret->id)->exists()) {
                $secret->notifierObtention($user);
                $badgeSecret = $secret;
            }
        }

        $redirect = redirect()->route('parcours.test', $parcours)
            ->with('resultats_examen', $resultats)
            ->with('score_examen', $score)
            ->with('examen_reussi', $reussi);

        if ($badgeSecret) {
            $redirect->with('badge_secret', ['titre' => $badgeSecret->titre, 'type' => $badgeSecret->condition_type]);
        }

        return $redirect;
    }

    // L'employé s'inscrit à un parcours puis passe le test de positionnement
    public function choisir(Parcours $parcours)
    {
        $user = auth()->user();

        if (!$user->parcours()->where('parcours_id', $parcours->id)->exists()) {
            $user->parcours()->attach($parcours->id, ['statut' => 'en_cours']);
        }

        // Si un test de positionnement est configuré → rediriger vers le test
        if (!empty($parcours->test_positionnement['questions'])) {
            return redirect()->route('positionnement.show', $parcours);
        }

        return redirect()->route('parcours.show', $parcours);
    }
}