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
        Schema::table('character', function (Blueprint $table) {
            $table->string('pinterest_board')->nullable()->after('personality');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('character', function (Blueprint $table) {
            $table->dropColumn('pinterest_board');
        });
    }
};
