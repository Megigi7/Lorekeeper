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
        Schema::create('relationship_gallery_item', function (Blueprint $table) {
            $table->id();
            
            // 🌟 Optimizado al estilo moderno de Laravel
            $table->foreignId('relationship_id')
                ->constrained('relationship')
                ->onDelete('cascade');

            $table->string('image'); 
            $table->string('type'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationship_gallery_item');
    }
};
