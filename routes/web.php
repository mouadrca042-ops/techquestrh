<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\DefiController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\DashboardRHController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/defis/{id}/check', function (Request $request, $id) {
    // Juste pour tester si ça arrive ici
    return "Données reçues ! Réponse choisie : " . $request->reponse;
})->name('defis.check');

Route::get('/test-role', function() {
    return "Mon rôle actuel est : " . auth()->user()->role;
});

//page d'accueil
Route::get('/', function () {
    return view('welcome');
});

//routes Employé
Route::middleware(['auth', 'role:employe'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/parcours', [ParcoursController::class, 'index'])->name('parcours.index');
    Route::get('/parcours/{parcours}', [ParcoursController::class, 'show'])->name('parcours.show');
    Route::post('/parcours/{parcours}/choisir', [ParcoursController::class, 'choisir'])->name('parcours.choisir');

    Route::get('/defis/{defi}', [DefiController::class, 'show'])->name('defis.show');
    Route::post('/defis/{defi}/repondre', [DefiController::class, 'repondre'])->name('defis.repondre');

    Route::get('/badges', [BadgeController::class, 'index'])->name('badges.index');
});

// routes Manager RH
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/dashboard-rh', [DashboardRHController::class, 'index'])->name('dashboard.rh');
    Route::get('/dashboard-rh/export', [DashboardRHController::class, 'exportPDF'])->name('dashboard.export');
});

// routes Profil (auth uniquement)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/defis/{id}', [App\Http\Controllers\DefiController::class, 'show'])->name('defis.show');
Route::get('/defis/{id}', function ($id) {
    $defi = \App\Models\Defi::findOrFail($id);
    return view('defis.show', compact('defi'));
})->middleware(['auth'])->name('defis.show'); 
Route::post('/defis/{id}/check', function (Request $request, $id) {
    $defi = \App\Models\Defi::findOrFail($id);
    $contenu = json_decode($defi->contenu_json);
    
    // Vérification de la réponse
    if ($request->reponse == $contenu->reponse) {
        // Enregistrer la progression
        \App\Models\Progression::updateOrCreate(
            ['user_id' => auth()->id(), 'defi_id' => $defi->id],
            ['score' => 100]
        );
        return redirect()->route('parcours.show', $defi->parcours_id)->with('success', 'Bien joué !');
    }

    return back()->with('error', 'Mauvaise réponse, réessaie !');
})->name('defis.check');
require __DIR__.'/auth.php';