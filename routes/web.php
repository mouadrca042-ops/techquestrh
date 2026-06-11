<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\DefiController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\DashboardRHController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PositionnementController;
use Illuminate\Support\Facades\Route;

// -------------------------------------------------------------
// PAGE D'ACCUEIL
// -------------------------------------------------------------
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/test-role', function () {
    return "Mon rôle actuel est : " . auth()->user()->role;
})->middleware('auth');

// -------------------------------------------------------------
// ROUTES EMPLOYÉ
// -------------------------------------------------------------
Route::middleware(['auth', 'role:employe'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Parcours / Formations
    Route::get('/parcours', [ParcoursController::class, 'index'])->name('parcours.index');
    Route::get('/parcours/{parcours}', [ParcoursController::class, 'show'])->name('parcours.show');
    Route::post('/parcours/{parcours}/choisir', [ParcoursController::class, 'choisir'])->name('parcours.choisir');

    // Test de positionnement
    Route::get('/parcours/{parcours}/positionnement', [PositionnementController::class, 'show'])->name('positionnement.show');
    Route::post('/parcours/{parcours}/positionnement', [PositionnementController::class, 'check'])->name('positionnement.check');

    // Test global (examen final de la formation → badge secret)
    Route::get('/parcours/{parcours}/test-final', [ParcoursController::class, 'testFinal'])->name('parcours.test');
    Route::post('/parcours/{parcours}/test-final', [ParcoursController::class, 'testFinalCheck'])->name('parcours.test.check');

    // Modules / défis (quiz multi-questions via le contrôleur)
    Route::get('/defis/{id}', [DefiController::class, 'show'])->name('defis.show');
    Route::post('/defis/{id}/check', [DefiController::class, 'check'])->name('defis.check');

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
// ROUTES PROFIL (tous les utilisateurs connectés)
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
