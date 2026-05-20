<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\DefiController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\DashboardRHController;
use App\Http\Controllers\DashboardController; // Majuscule corrigée ici
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Test rapide de rôle
Route::get('/test-role', function() {
    return "Mon rôle actuel est : " . auth()->user()->role;
});

// -------------------------------------------------------------
// ROUTES EMPLOYÉ (Protégées par Auth et Rôle Employé)
// -------------------------------------------------------------
Route::middleware(['auth', 'role:employe'])->group(function () {
    
    // Le dashboard appelle ENFIN ton contrôleur fascinant !
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Parcours
    Route::get('/parcours', [ParcoursController::class, 'index'])->name('parcours.index');
    Route::get('/parcours/{parcours}', [ParcoursController::class, 'show'])->name('parcours.show');
    Route::post('/parcours/{parcours}/choisir', [ParcoursController::class, 'choisir'])->name('parcours.choisir');

    // Défis
    Route::get('/defis/{id}', [DefiController::class, 'show'])->name('defis.show');
    Route::post('/defis/{id}/check', function (Request $request, $id) {
        $defi = \App\Models\Defi::findOrFail($id);
        $contenu = json_decode($defi->contenu_json);
        
        if ($request->reponse == $contenu->reponse) {
            \App\Models\Progression::updateOrCreate(
                ['user_id' => auth()->id(), 'defi_id' => $defi->id],
                ['score' => 100]
            );
            return redirect()->route('parcours.show', $defi->parcours_id)->with('success', 'Bien joué !');
        }

        return back()->with('error', 'Mauvaise réponse, réessaie !');
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

require __DIR__.'/auth.php';