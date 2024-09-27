<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

// Page d'accueil qui liste les salles
Route::get('/', [RoomController::class, 'index'])->name('home');

// Routes pour la gestion des salles (consultation par tous, modification par les admins)
Route::middleware(['auth'])->group(function () {
    Route::get('rooms/{room}', [RoomController::class, 'show'])->name('rooms.show'); // Détail de la salle accessible à tous les utilisateurs connectés
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::resource('rooms', RoomController::class)->except(['show']); // CRUD complet pour les admins sauf la méthode show
});

// Routes pour la gestion des réservations (nécessite une authentification)
Route::middleware(['auth'])->group(function () {
    Route::resource('reservations', ReservationController::class)->only(['store']); // Ajout de réservations
});

// Route pour le profil de l'utilisateur connecté
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.edit');
});

// Route pour lister les réservations de l'utilisateur
Route::middleware(['auth'])->group(function () {
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index'); // Affiche les réservations de l'utilisateur
    Route::resource('reservations', ReservationController::class)->only(['store']);
});


// Routes d'authentification
require __DIR__ . '/auth.php';
