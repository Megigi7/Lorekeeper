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
        // 1. CREAMOS PRIMERO LA TABLA DE ESPECIES
        // Tiene que ir primero porque el pivote la va a necesitar para la clave foránea
        Schema::create('character_species', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // 2. CREAMOS LA TABLA PIVOTE
        Schema::create('character_species_pivot', function (Blueprint $table) {
            $table->id();
            
            // Relación con Personajes (que ya existe en tu SQLite)
            $table->foreignId('character_id')
                  ->constrained('character')
                  ->onDelete('cascade');

            // Relación con Especies (la que acabamos de crear arriba)
            $table->foreignId('character_species_id')
                  ->constrained('character_species')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Al deshacer la migración, el orden se invierte:
        // Primero borramos el pivote (hijo) y luego la de especies (padre)
        Schema::dropIfExists('character_species_pivot');
        Schema::dropIfExists('character_species');
    }
};