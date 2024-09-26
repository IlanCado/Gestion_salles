@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la réservation</h1>
    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="room_id" class="form-label">Salle</label>
            <select name="room_id" id="room_id" class="form-control" required>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ $reservation->room_id == $room->id ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $reservation->title }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $reservation->description }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="start_time" class="form-label">Date de début</label>
            <input type="datetime-local" name="start_time" id="start_time" class="form-control" 
                   value="{{ \Carbon\Carbon::parse($reservation->start_time)->format('Y-m-d\TH:i') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="end_time" class="form-label">Date de fin</label>
            <input type="datetime-local" name="end_time" id="end_time" class="form-control" 
                   value="{{ \Carbon\Carbon::parse($reservation->end_time)->format('Y-m-d\TH:i') }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
