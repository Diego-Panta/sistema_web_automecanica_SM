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
        Schema::create('prediccion_pnls', function (Blueprint $table) {
            $table->id('prediccion_id');
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->string('categoria_predicha', 100);
            $table->decimal('probabilidad', 5, 2);
            $table->text('detalle_entrada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediccion_pnls');
    }
};
