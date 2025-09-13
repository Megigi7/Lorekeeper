<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    // Define the table associated with the model
    protected $table = 'relationship';

    // Define the primary key for the table
    protected $primaryKey = 'id';

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'character_1', // fk Character
        'character_2', // fk Character
        'relationship_type',
        'spotify_playlist',
    ];
    
    // Define the relationship with the Character model
    // A gallery item belongs to two characters
    // This allows us to access the character associated with a gallery item
    public function character1(){
        return $this->belongsTo(Character::class, 'character_1');
    }

    public function character2(){
        return $this->belongsTo(Character::class, 'character_2');
    }


    // Method to get all clients
    public static function getAllRelationships()
    {
        return self::all();
    }


    // Method to get a client by ID
    public static function getRelationshipById($id)
    {
        return self::find($id);
    }

    public static function getRelationshipsByCharacterId($characterId)
    {
        return self::where('character_1', $characterId)
                    ->orWhere('character_2', $characterId)
                    ->get();
    }

    // Method to create a new relationship returning id of the new relationship 
    public static function createRelationship($data)
    {
        $relationship = self::create($data);
        return $relationship->id;  
    }

    // Method to update a client by ID
    public static function updateRelationship($id, $data)
    {
        $relationship = self::find($id);
        if ($relationship) {
            $relationship->update($data);
            return $relationship;
        }
        return null;
    }

    // Method to delete a client by ID
    public static function deleteRelationship($id)
    {
        $relationship = self::find($id);
        if ($relationship) {
            $relationship->delete();
            return true;
        }
        return false;
    }
}

