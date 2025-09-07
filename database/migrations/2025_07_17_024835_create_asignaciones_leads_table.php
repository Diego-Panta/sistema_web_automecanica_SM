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
        Schema::create('asignaciones_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->foreignId('usuario_asignador_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('usuario_asignado_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('fecha_asignacion');
            $table->text('observacion')->nullable();
            $table->boolean('activo')->default(true); // Asegúrate de tener esta columna
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones_leads');
    }
};
