<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liaison à la table users
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // Liaison à la table rooms
            $table->date('date'); // Champ pour la date de la réservation
            $table->time('start_time'); // Champ pour l'heure de début de la réservation
            $table->time('end_time');   // Champ pour l'heure de fin de la réservation
            $table->timestamps(); // Horodatage automatique de Laravel (created_at, updated_at)
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
