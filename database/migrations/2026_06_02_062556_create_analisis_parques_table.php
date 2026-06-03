<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analisis_parque', function (Blueprint $table) {
            $table->id();

            $table->foreignId('atraccion_id')
                ->constrained('atracciones')
                ->onDelete('cascade');

            $table->foreignId('visita_id')
                ->constrained('visitas')
                ->onDelete('cascade');

            $table->integer('visitantes_registrados');
            $table->integer('capacidad_maxima');
            $table->decimal('porcentaje_ocupacion', 6, 2);
            $table->string('nivel_demanda');
            $table->string('recomendacion');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analisis_parque');
    }
};