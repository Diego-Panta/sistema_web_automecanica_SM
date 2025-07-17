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
        Schema::create('config_asignaciones', function (Blueprint $table) {
            $table->id('config_id');
            $table->foreignId('tipo_lead_id')->nullable()->constrained('tipo_leads')->nullOnDelete();
            $table->foreignId('sede_id')->nullable()->constrained('sedes')->nullOnDelete();
            $table->integer('max_leads_por_asesor')->default(10);
            $table->enum('prioridad_rotacion', ['equitativa', 'carga_trabajo', 'ubicacion']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_asignaciones');
    }
};
