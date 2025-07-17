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
        Schema::create('user_laborales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('turno_id')->constrained('turnos')->nullOnDelete();
            $table->foreignId('sede_id')->constrained('sedes')->nullOnDelete();
            $table->foreignId('estado_usuario_id')->constrained('estado_usuarios')->nullOnDelete();
            $table->string('codigo_trabajador', 20)->unique();
            $table->date('fecha_contratacion_inicio');
            $table->date('fecha_contratacion_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_laborales');
    }
};
