<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ProfileController extends Controller
{
    /**
     * Affiche les informations du profil de l'utilisateur connecté.
     */
    public function show()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer les réservations de l'utilisateur
        $reservations = Reservation::where('user_id', $user->id)->get();

        return view('profile.edit', compact('user', 'reservations'));
    }
}
