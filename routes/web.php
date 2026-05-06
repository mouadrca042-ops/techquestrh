<?php

use App\Http\Controllers\DefiController;
use App\Http\Controllers\ProgressionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Routes authentifiées (tout le monde connecté)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard général
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |------------------------------------------------------------------
    | Routes Défis (CDC F08, F09, F10, F11)
    | Toi → Tu travailles sur ces routes
    |------------------------------------------------------------------
    */

    // Liste des défis d'un parcours
    // URL : /parcours/1/defis
    Route::get('/parcours/{parcoursId}/defis', [DefiController::class, 'index'])
         ->name('defis.index');

    // Afficher un défi spécifique
    // URL : /defis/1
    Route::get('/defis/{id}', [DefiController::class, 'show'])
         ->name('defis.show');

    // Valider la réponse d'un défi
    // URL : POST /defis/1/valider
    Route::post('/defis/{id}/valider', [DefiController::class, 'valider'])
         ->name('defis.valider');

    /*
    |------------------------------------------------------------------
    | Routes Progression (CDC F06)
    | Toi → Tu travailles sur ces routes
    |------------------------------------------------------------------
    */

    // Historique des défis complétés
    // URL : /historique
    Route::get('/historique', [ProgressionController::class, 'historique'])
         ->name('progressions.historique');

    /*
    |------------------------------------------------------------------
    | Routes Parcours (CDC F04, F05)
    | Membre 2 → Il travaillera sur ces routes
    |------------------------------------------------------------------
    */
    // Route::get('/parcours', [ParcoursController::class, 'index'])->name('parcours.index');
    // Route::get('/parcours/{id}', [ParcoursController::class, 'show'])->name('parcours.show');

    /*
    |------------------------------------------------------------------
    | Routes Dashboard RH (CDC F24, F25, F26)
    | Membre 3 → Il travaillera sur ces routes
    |------------------------------------------------------------------
    */
    // Route::get('/dashboard/rh', [DashboardController::class, 'index'])
    //      ->middleware('role:manager')
    //      ->name('dashboard.rh');

});

// Routes Auth générées par Breeze
require __DIR__.'/auth.php';