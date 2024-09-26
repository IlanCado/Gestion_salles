<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Affiche la liste des salles.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle salle.
     */
    public function create()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Accès refusé. Vous n\'avez pas les permissions nécessaires.');
        }

        return view('rooms.create');
    }

    /**
     * Enregistre une nouvelle salle dans la base de données.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Accès refusé. Vous n\'avez pas les permissions nécessaires.');
        }

        $request->validate([
            'name' => 'required|unique:rooms|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $room = new Room();
        $room->name = $request->name;
        $room->description = $request->description;
        $room->capacity = $request->capacity;

        // Gestion de l'upload de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('room_images', 'public');
            $room->image = $imagePath;
        }

        $room->save();

        return redirect()->route('rooms.index')->with('success', 'Salle créée avec succès');
    }

    /**
     * Affiche les détails d'une salle spécifique.
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * Affiche le formulaire de modification d'une salle existante.
     */
    public function edit(Room $room)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Accès refusé. Vous n\'avez pas les permissions nécessaires.');
        }

        return view('rooms.edit', compact('room'));
    }

    /**
     * Met à jour les informations d'une salle existante.
     */
    public function update(Request $request, Room $room)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Accès refusé. Vous n\'avez pas les permissions nécessaires.');
        }

        $request->validate([
            'name' => 'required|max:255|unique:rooms,name,' . $room->id,
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $room->name = $request->name;
        $room->description = $request->description;
        $room->capacity = $request->capacity;

        // Gestion de l'upload de la nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }

            $imagePath = $request->file('image')->store('room_images', 'public');
            $room->image = $imagePath;
        }

        $room->save();

        return redirect()->route('rooms.index')->with('success', 'Salle mise à jour avec succès');
    }

    /**
     * Supprime une salle de la base de données.
     */
    public function destroy(Room $room)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Accès refusé. Vous n\'avez pas les permissions nécessaires.');
        }

        // Supprimer l'image associée s'il y en a une
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Salle supprimée avec succès');
    }
}
