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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->restrictOnDelete();
            $table->foreignId('canal_id')->constrained('canales')->restrictOnDelete();
            $table->foreignId('tipo_id')->constrained('tipo_leads')->restrictOnDelete();
            $table->foreignId('estado_actual_id')->constrained('estado_leads')->restrictOnDelete();
            $table->foreignId('resultado_id')->nullable()->constrained('resultado_leads')->nullOnDelete();
            $table->foreignId('usuario_creador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('medio_contacto_id')->constrained('medio_contactos')->restrictOnDelete();
            $table->foreignId('forma_registro_id')->constrained('forma_registros')->restrictOnDelete();
            $table->foreignId('modelo_id')->nullable()->constrained('modelo_vehiculos')->nullOnDelete();
            $table->foreignId('tipo_servicio_id')->nullable()->constrained('tipo_servicios')->nullOnDelete(); // Nuevo
            $table->boolean('financiamiento')->default(false);
            $table->string('tiempo_compra', 100)->nullable();
            $table->string('numero_placa', 10)->nullable(); // Nuevo
            $table->integer('kilometraje')->nullable(); // Nuevo
            $table->timestamp('fecha_cita')->nullable(); // Nuevo
            $table->string('horario_cita', 50)->nullable(); // Nuevo
            $table->text('observacion')->nullable();
            $table->text('consulta')->nullable(); // Nuevo
            $table->timestamp('fecha_cierre')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
