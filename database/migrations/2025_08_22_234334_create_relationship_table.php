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
        Schema::create('relationship', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_1'); // fk Character
            $table->unsignedBigInteger('character_2'); // fk Character
            $table->string('relationship_type');
            $table->string('spotify_playlist')->nullable();
            $table->foreign('character_1')->references('id')->on('character')->onDelete('cascade');
            $table->foreign('character_2')->references('id')->on('character')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationship');
    }
};
