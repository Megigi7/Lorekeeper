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
            $table->unsignedBigInteger('relationship_id');
            $table->string('image'); // Ruta de la imagen
            $table->string('type'); // Nuevo campo para el tipo de imagen
            $table->foreign('relationship_id')->references('id')->on('relationship')->onDelete('cascade');

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
