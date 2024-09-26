<!-- resources/views/rooms/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Centrer et styliser le titre H1 -->
    <h1 class="mb-4 text-center" style="font-size: 2.5rem; font-weight: bold; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px;">Liste des salles</h1>

    <!-- Affiche le bouton "Ajouter une salle" uniquement pour les administrateurs -->
    @if(Auth::check() && Auth::user()->is_admin)
        <a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">Ajouter une salle</a>
    @endif

    <!-- Affichage des salles sous forme de cartes horizontales -->
    <div class="row">
        @foreach($rooms as $room)
            <div class="col-12 mb-4">
                <div class="card shadow-sm d-flex flex-row align-items-stretch" style="padding: 10px;">
                    <!-- Section Image -->
                    <div style="flex: 0 0 250px; margin-right: 15px;"> 
                        @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" class="img-fluid rounded-start" alt="Image de la salle" style="max-width: 100%; height: auto; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-room.jpg') }}" class="img-fluid rounded-start" alt="Image par défaut" style="max-width: 100%; height: auto; object-fit: cover;">
                        @endif
                    </div>

                    <!-- Section Informations -->
                    <div class="flex-grow-1 d-flex flex-column justify-content-between p-3">
                        <div>
                            <h5 class="card-title" style="font-size: 1.75rem; font-weight: bold; color: #34495e; text-transform: capitalize; letter-spacing: 0.5px;">{{ $room->name }}</h5> <!-- Stylisation du nom de la salle -->
                            <p class="card-text" style="font-size: 1rem; line-height: 1.4; color: #7f8c8d; font-style: italic;">{{ $room->description }}</p> <!-- Stylisation de la description de la salle -->
                            <p class="card-text"><small class="text-muted">Capacité : {{ $room->capacity }} personnes</small></p>
                        </div>
                        
                        <div class="mt-auto d-flex">
                            <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-success me-2">Obtenir une réservation</a>
                            
                            @if(Auth::check() && Auth::user()->is_admin)
                                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning btn-sm me-2">Modifier</a>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection


<style>
/* Styles pour l'image et la carte */
.card {
    display: flex;
    align-items: stretch;
    border: none;
}

.card img {
    border-radius: 10px; /* Ajoute des coins arrondis à l'image */
    max-width: 100%; /* Assure que l'image ne dépasse pas de son conteneur */
    height: auto; /* Maintient les proportions de l'image */
}

/* Ajustements du texte */
.card-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.card-text {
    font-size: 0.95rem;
    line-height: 1.4; /* Ajoute un peu plus d'espace entre les lignes de texte */
}

/* Style du bouton "Obtenir une réservation" */
.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    font-size: 0.9rem;
    padding: 6px 12px;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
</style>
