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
        Schema::create('modelo_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marca_id')->constrained('marca_vehiculos')->restrictOnDelete();
            $table->foreignId('tipo_id')->constrained('tipo_vehiculos')->restrictOnDelete();
            $table->string('nombre_modelo', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelo_vehiculos');
    }
};
