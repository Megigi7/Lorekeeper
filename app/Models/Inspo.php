<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inspo extends Model
{
    // Define the table associated with the model
    protected $table = 'character_inspo';

    // Define the primary key for the table
    protected $primaryKey = 'id';

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'character_id',
        'image',
        'character_name',
        'media',
        'created_at',
        'updated_at'
    ];

    
    // Define the relationship with the Character model
    // A gallery item belongs to a character
    // This allows us to access the character associated with a gallery item
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    // Method to get all gallery items
    public static function getAllInspo()
    {
        return self::all();
    }


    // Method to get a gallery item by ID
    public static function getInspoById($id)
    {
        return self::find($id);
    }

    // Method to get all character gallery items
    public static function getInsposByCharacterId($characterId)
    {
        return self::where('character_id', $characterId)->get();
    }

    // Method to create a new gallery item
    public static function createInspo($data)
    {
        return self::create($data);
    }

    // Method to delete a gallery item by ID
    public static function deleteInspo($id)
    {
        $inspo = self::find($id);
        if ($inspo) {
            $inspo->delete();
            return true;
        }
        return false;
    }
}

