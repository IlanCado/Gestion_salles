    @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer une réservation</h1>
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="room_id" class="form-label">Salle</label>
            <select name="room_id" id="room_id" class="form-control" required>
                @foreach($rooms as $room)
                <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Date de début</label>
            <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="end_time" class="form-label">Date de fin</label>
            <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
