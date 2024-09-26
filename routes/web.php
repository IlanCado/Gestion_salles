<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;


// Page d'accueil qui liste les salles
Route::get('/', [RoomController::class, 'index'])->name('home');

// Routes pour la gestion des salles (nécessite une authentification)
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::resource('rooms', RoomController::class);
});


// Routes pour la gestion des réservations (nécessite une authentification)
Route::middleware(['auth'])->group(function () {
    Route::resource('reservations', ReservationController::class);
});

// Route pour le profil de l'utilisateur connecté
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.edit');
});

// Routes d'authentification
require __DIR__ . '/auth.php';
