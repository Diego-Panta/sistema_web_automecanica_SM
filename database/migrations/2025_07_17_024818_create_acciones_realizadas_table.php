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
        Schema::create('acciones_realizadas', function (Blueprint $table) {
            $table->id('accion_realizada_id');
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->nullOnDelete();
            $table->foreignId('accion_id')->constrained('acciones')->restrictOnDelete();
            $table->timestamp('fecha')->useCurrent();
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones_realizadas');
    }
};
