<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atracciones', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('tipo')->nullable();
            $table->integer('capacidad_hora');
            $table->string('estado')->default('Activa');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atracciones');
    }
};