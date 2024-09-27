<!-- resources/views/rooms/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center" style="font-size: 2.5rem; font-weight: bold; color: #2c3e50;">{{ $room->name }}</h1>

    <div class="row">
        <div class="col-md-6">
            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}" class="img-fluid rounded" alt="Image de la salle">
            @else
                <img src="{{ asset('images/default-room.png') }}" class="img-fluid rounded" alt="Image par défaut">
            @endif
        </div>

        <div class="col-md-6">
            <h4>Description</h4>
            <p>{{ $room->description }}</p>
            
            <h4>Capacité</h4>
            <p>{{ $room->capacity }} personnes</p>
            
            <h4>Réserver cette salle</h4>
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                
                <div class="mb-3">
                    <label for="date" class="form-label">Date de réservation</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="start_time" class="form-label">Heure de début</label>
                    <input type="time" name="start_time" id="start_time" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="end_time" class="form-label">Heure de fin</label>
                    <input type="time" name="end_time" id="end_time" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-success">Réserver</button>
            </form>
        </div>
    </div>

    <div class="mt-5">
        <h4>Calendrier des Réservations</h4>
        <div id="calendar"></div>
    </div>
</div>
@endsection
