<!-- resources/views/rooms/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une salle</h1>
    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom de la salle</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacité</label>
            <input type="number" name="capacity" id="capacity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image de la salle</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
