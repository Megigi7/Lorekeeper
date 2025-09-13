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
            $table->unsignedBigInteger('character_id'); // Foreign key to characters table
            $table->string('image'); // Path to the image file
            $table->string('character_name'); // Name of the character in the inspo
            $table->string('media'); // Media where the character is from
            $table->foreign('character_id')->references('id')->on('character')->onDelete('cascade');

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
