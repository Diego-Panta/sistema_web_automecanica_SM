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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('cliente_id');
            $table->foreignId('estado_cliente_id')->constrained('estado_clientes')->restrictOnDelete();;
            $table->string('nombre', 100);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50)->nullable();
            $table->string('dni', 8)->unique()->nullable();
            $table->string('celular', 9)->nullable();
            $table->string('celular_alterno', 9)->nullable();
            $table->string('correo', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
