<!-- resources/views/rooms/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la salle</h1>
    <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nom de la salle</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $room->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $room->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacité</label>
            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ $room->capacity }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image de la salle</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}" class="img-fluid mt-2" style="max-width: 200px;" alt="Image actuelle de la salle">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
