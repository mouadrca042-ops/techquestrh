<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\DefiController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\DashboardRHController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Page d'accueil
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/test-role', function() {
    return "Mon rôle actuel est : " . auth()->user()->role;
})->middleware('auth');

// -------------------------------------------------------------
// ROUTES EMPLOYÉ (Protégées par Auth et Rôle Employé)
// -------------------------------------------------------------
Route::middleware(['auth', 'role:employe'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Parcours
    Route::get('/parcours', [ParcoursController::class, 'index'])->name('parcours.index');
    Route::get('/parcours/{parcours}', [ParcoursController::class, 'show'])->name('parcours.show');
    Route::post('/parcours/{parcours}/choisir', [ParcoursController::class, 'choisir'])->name('parcours.choisir');

    // Test final et positionnement
    Route::get('/parcours/{parcours}/test', [ParcoursController::class, 'testFinal'])->name('parcours.test');
    Route::post('/parcours/{parcours}/test', [ParcoursController::class, 'testFinalCheck'])->name('parcours.test.check');
    Route::get('/parcours/{parcours}/positionnement', [ParcoursController::class, 'positionnement'])->name('positionnement.show');

    // Défis
    Route::get('/defis/{id}', [DefiController::class, 'show'])->name('defis.show');

    Route::post('/defis/{id}/check', function (Request $request, $id) {
        $defi = \App\Models\Defi::findOrFail($id);
        $contenu = $defi->contenu_json;

        $user = auth()->user();

        $progression = \App\Models\Progression::firstOrCreate(
            ['user_id' => $user->id, 'defi_id' => $defi->id],
            ['score' => 0, 'tentatives' => 0, 'question_courante' => 0]
        );

        $questions = $contenu['questions'] ?? [];
        $qIndex = (int) $request->input('question_index', 0);
        $question = $questions[$qIndex] ?? null;

        if (!$question) {
            return back()->with('reponse_correcte', false)->with('message', 'Question introuvable.');
        }

        $progression->tentatives += 1;

        if ($question['type'] === 'qcm') {
            $reponseCorrecte = ((int) $request->reponse === (int) $question['bonne_reponse']);
        } else {
            $reponseCorrecte = ($request->reponse == $question['bonne_reponse']);
        }

        if (!$reponseCorrecte) {
            $progression->save();

            $messages = [
                'Pas de panique, tu peux réessayer ! Chaque tentative te rapproche de la réussite.',
                'Presque ! Relis bien la question et réessaie, tu vas y arriver !',
                "Ce n'est pas grave, l'important c'est d'apprendre. Réessaie !",
                'Continue d\'essayer, tu es sur la bonne voie !',
            ];

            return back()
                ->with('reponse_correcte', false)
                ->with('message', $messages[array_rand($messages)]);
        }

        $prochainIndex = $qIndex + 1;
        $nbQuestions = count($questions);
        $nouveauxBadges = [];

        if ($prochainIndex >= $nbQuestions) {
            $dejaComplete = $progression->completed_at !== null;
            $progression->completed_at = now();
            $progression->score = 100;
            $progression->question_courante = $qIndex;
            $progression->save();

            if (!$dejaComplete) {
                $user->xp_total += $defi->xp_recompense;
                $user->save();
                $user->monterDeNiveau();

                $badgesObtenusIds = $user->badges()->pluck('badges.id')->toArray();

                $totalCompletes = \App\Models\Progression::where('user_id', $user->id)
                    ->whereNotNull('completed_at')
                    ->count();

                if ($totalCompletes == 1) {
                    $badge = \App\Models\Badge::where('condition_type', 'premier_defi')->first();
                    if ($badge && !in_array($badge->id, $badgesObtenusIds)) {
                        $user->badges()->attach($badge->id, ['obtenu_at' => now()]);
                        $nouveauxBadges[] = ['type' => 'premier_defi', 'titre' => $badge->titre];
                    }
                }

                $completesCetteSemaine = \App\Models\Progression::where('user_id', $user->id)
                    ->whereNotNull('completed_at')
                    ->whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->count();

                if ($completesCetteSemaine >= 5) {
                    $badge = \App\Models\Badge::where('condition_type', 'assidu')->first();
                    if ($badge && !in_array($badge->id, $badgesObtenusIds)) {
                        $user->badges()->attach($badge->id, ['obtenu_at' => now()]);
                        $nouveauxBadges[] = ['type' => 'assidu', 'titre' => $badge->titre];
                    }
                }

                $dernieresProgressions = \App\Models\Progression::where('user_id', $user->id)
                    ->whereNotNull('completed_at')
                    ->orderByDesc('completed_at')
                    ->take(3)
                    ->pluck('score');

                if ($dernieresProgressions->count() === 3 && $dernieresProgressions->every(fn($s) => $s == 100)) {
                    $badge = \App\Models\Badge::where('condition_type', 'maitrise')->first();
                    if ($badge && !in_array($badge->id, $badgesObtenusIds)) {
                        $user->badges()->attach($badge->id, ['obtenu_at' => now()]);
                        $nouveauxBadges[] = ['type' => 'maitrise', 'titre' => $badge->titre];
                    }
                }

                $parcours = $defi->parcours;
                $defisIdsDuParcours = $parcours->defis()->pluck('id');
                $completesDuParcours = \App\Models\Progression::where('user_id', $user->id)
                    ->whereIn('defi_id', $defisIdsDuParcours)
                    ->whereNotNull('completed_at')
                    ->count();

                if ($completesDuParcours >= $defisIdsDuParcours->count()) {
                    $badge = \App\Models\Badge::where('condition_type', 'explorateur')->first();
                    if ($badge && !in_array($badge->id, $badgesObtenusIds)) {
                        $user->badges()->attach($badge->id, ['obtenu_at' => now()]);
                        $nouveauxBadges[] = ['type' => 'explorateur', 'titre' => $badge->titre];
                    }
                }
            }
        } else {
            $progression->question_courante = $prochainIndex;
            $progression->save();
        }

        $redirect = back()
            ->with('reponse_correcte', true)
            ->with('message', 'Bonne réponse !');

        if (!empty($nouveauxBadges)) {
            $redirect->with('nouveaux_badges', $nouveauxBadges);
        }

        return $redirect;

    })->name('defis.check');

    // Badges
    Route::get('/badges', [BadgeController::class, 'index'])->name('badges.index');
});

// -------------------------------------------------------------
// ROUTES MANAGER RH
// -------------------------------------------------------------
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/dashboard-rh', [DashboardRHController::class, 'index'])->name('dashboard.rh');
    Route::get('/dashboard-rh/export', [DashboardRHController::class, 'exportPDF'])->name('dashboard.export');
});

// -------------------------------------------------------------
// ROUTES PROFIL (Accessibles à tous les utilisateurs connectés)
// -------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Routes Admin ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Parcours
    Route::get('/parcours', [AdminController::class, 'parcours'])->name('parcours');
    Route::get('/parcours/create', [AdminController::class, 'createParcours'])->name('parcours.create');
    Route::post('/parcours', [AdminController::class, 'storeParcours'])->name('parcours.store');
    Route::get('/parcours/{parcours}/edit', [AdminController::class, 'editParcours'])->name('parcours.edit');
    Route::put('/parcours/{parcours}', [AdminController::class, 'updateParcours'])->name('parcours.update');
    Route::delete('/parcours/{parcours}', [AdminController::class, 'destroyParcours'])->name('parcours.destroy');

    // Défis
    Route::get('/defis', [AdminController::class, 'defis'])->name('defis');
    Route::get('/defis/create', [AdminController::class, 'createDefi'])->name('defis.create');
    Route::post('/defis', [AdminController::class, 'storeDefi'])->name('defis.store');
    Route::get('/defis/{defi}/edit', [AdminController::class, 'editDefi'])->name('defis.edit');
    Route::put('/defis/{defi}', [AdminController::class, 'updateDefi'])->name('defis.update');
    Route::delete('/defis/{defi}', [AdminController::class, 'destroyDefi'])->name('defis.destroy');

    // Badges
    Route::get('/badges', [AdminController::class, 'badges'])->name('badges');
    Route::get('/badges/create', [AdminController::class, 'createBadge'])->name('badges.create');
    Route::post('/badges', [AdminController::class, 'storeBadge'])->name('badges.store');
    Route::get('/badges/{badge}/edit', [AdminController::class, 'editBadge'])->name('badges.edit');
    Route::put('/badges/{badge}', [AdminController::class, 'updateBadge'])->name('badges.update');
    Route::delete('/badges/{badge}', [AdminController::class, 'destroyBadge'])->name('badges.destroy');

    // Utilisateurs
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
});

require __DIR__.'/auth.php';