<?php

namespace Database\Seeders;

use App\Models\CharacterSpecies;
use Illuminate\Database\Seeder;

class CharacterSpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tu lista de especies por defecto
        $species = [
            'Human',
            'Elf',
            'Mermaid',
            'Fairy',
            'Angel',
            'Vampire',
            'Demon',
            'Alien',
            'Cyborg',
            'Ghost',
            'Werewolf',
            'Zombie',
            'Dragon',
            'Kitsune',
            'Centaur',
            'Faun',
            'Fox',
        ];

        foreach ($species as $name) {
            CharacterSpecies::firstOrCreate(['name' => $name]);
        }

        $relationshipTypes = [
            'Friends',
            'Couple',
            'Enemies',
            'Ex-couple (Good Termns)',
            'Ex-couple (Bad Terms)',
            'Siblings',
            'Cousins',
            'Colleagues',
            'Family',
        ];

        foreach ($relationshipTypes as $name) {
            RelationshipType::firstOrCreate(['name' => $name]);
        }

    }
}