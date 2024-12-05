<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calendar', function (Blueprint $table) {
            $table->id();
            $table->string('title');              // Título del evento
            $table->text('description')->nullable(); // Descripción del evento
            $table->datetime('date');            // Fecha y hora de inicio
            $table->decimal('amount', 10, 2)->default(0.00); // Monto
            $table->string('color')->nullable();   // Color del evento en el calendario
            $table->foreignId('user_id')          // Usuario que creó el evento
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendar');
    }
};