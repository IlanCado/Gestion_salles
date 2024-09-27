<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Importation de Carbon pour faciliter la gestion des dates

class ReservationController extends Controller
{
    /**
     * Enregistre une nouvelle réservation dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Vérification si la date de réservation est un jour de semaine (lundi à vendredi)
        $reservationDate = Carbon::parse($request->date);
        if ($reservationDate->isWeekend()) {
            return back()->with('error', 'Les réservations ne sont autorisées que du lundi au vendredi.');
        }

        // Vérification que l'heure de début est après 07:00 et l'heure de fin avant 20:00
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);

        $openingTime = Carbon::createFromTime(7, 0);
        $closingTime = Carbon::createFromTime(20, 0);

        if ($startTime->lt($openingTime) || $endTime->gt($closingTime)) {
            return back()->with('error', 'Les réservations sont autorisées uniquement entre 7h00 et 20h00.');
        }

        // Vérification des conflits de réservation
        $existingReservation = Reservation::where('room_id', $request->room_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        if ($existingReservation) {
            return back()->with('error', 'Cette salle est déjà réservée pour ce créneau horaire.');
        }

        // Création de la réservation
        Reservation::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('rooms.show', $request->room_id)->with('success', 'Réservation effectuée avec succès.');
    }

    public function index()
{
    $reservations = Reservation::where('user_id', Auth::id())->with('room')->get(); // Charger les réservations de l'utilisateur avec les détails de la salle
    return view('reservations.index', compact('reservations'));
}

}
