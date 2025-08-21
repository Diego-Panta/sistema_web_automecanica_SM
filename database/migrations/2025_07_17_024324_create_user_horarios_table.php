<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_laborale_id')->constrained('user_laborales')->cascadeOnDelete();
            $table->foreignId('sede_id')->constrained('sedes')->cascadeOnDelete();
            $table->string('dia_semana', 15); // Ejemplo: Lunes, Martes, ...
            $table->foreignId('turno_id')->constrained('turnos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_horarios');
    }
};
