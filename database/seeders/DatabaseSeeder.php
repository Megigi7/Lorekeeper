<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamamos a tu seeder de especies
        $this->call([
            CharacterSpeciesSeeder::class,
            AdminUserSeeder::class
        ]);
    }
}