<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Exception;

class CharacterSpecies extends Model
{
    protected $table = 'character_species';
    protected $fillable = ['name'];

    /**
     * Relación Muchos a Muchos con Personajes
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_species_pivot');
    }

    /**
     * Evento automático que se dispara al borrar una especie
     */
    protected static function booted()
    {
        static::deleting(function ($species) {
            $defaultSpecies = self::firstOrCreate(['name' => 'Human']);

            if ($species->id === $defaultSpecies->id) {
                throw new Exception("No se puede eliminar la especie por defecto 'Human'.");
            }

            // Desvincular personajes y rescatar a los que se queden con 0 especies
            $affectedCharacters = $species->characters;

            foreach ($affectedCharacters as $character) {
                $character->species()->detach($species->id);

                if ($character->species()->count() === 0) {
                    $character->species()->attach($defaultSpecies->id);
                }
            }
        });
    }
}