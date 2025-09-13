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
        Schema::create('character', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->date('birthday')->nullable();
            $table->float('height')->nullable();
            $table->string('species')->nullable();
            $table->string('occupation')->nullable();
            $table->string('image')->nullable();
            $table->string('sexual_orientation')->nullable();
            $table->text('personality')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character');
    }
};