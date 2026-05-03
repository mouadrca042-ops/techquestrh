<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\DefiController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\DashboardRHController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';