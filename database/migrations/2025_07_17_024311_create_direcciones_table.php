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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained()->onDelete('cascade');
            $table->string('tipo_via', 50);
            $table->string('nombre_via', 100);
            $table->string('numero', 20)->nullable();
            $table->string('urbanizacion', 100)->nullable();
            $table->string('distrito', 100);
            $table->string('provincia', 100);
            $table->string('departamento', 100);
            $table->string('tipo')->default('principal'); // 'principal', 'taller', 'almacén'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
