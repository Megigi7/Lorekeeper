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
        Schema::create('character_inspo', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('character_id')
                  ->constrained('character')
                  ->onDelete('cascade');

            $table->string('image'); 
            $table->string('character_name'); 
            $table->string('media'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_inspo');
    }
};
