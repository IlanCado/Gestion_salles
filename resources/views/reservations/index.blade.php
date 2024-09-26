@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mes réservations</h1>
    <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-3">Créer une réservation</a>

    <table class="table">
        <thead>
            <tr>
                <th>Salle</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->room->name }}</td>
                <td>{{ $reservation->title }}</td>
                <td>{{ $reservation->description }}</td>
                <td>{{ $reservation->start_time }}</td>
                <td>{{ $reservation->end_time }}</td>
                <td>
                    <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
