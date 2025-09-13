<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    // Define the table associated with the model
    protected $table = 'character';

    // Define the primary key for the table
    protected $primaryKey = 'id';

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'name',
        'gender',
        'age',
        'birthday',
        'height',
        'species',
        'occupation',
        'image',
        'sexual_orientation',
        'personality',
        'pinterest_board',  //añadido
        'spotify_playlist'
    ];

    
    // Method to get all clients
    public static function getAllCharacters()
    {
        return self::all();
    }


    // Method to get a client by ID
    public static function getCharacterById($id)
    {
        return self::find($id);
    }

    // Method to create a new client
    public static function createCharacter($data)
    {
        return self::create($data);
    }

    // Method to update a client by ID
    public static function updateCharacter($id, $data)
    {
        $character = self::find($id);
        if ($character) {
            $character->update($data);
            return $character;
        }
        return null;
    }

    // Method to delete a client by ID
    public static function deleteCharacter($id)
    {
        $character = self::find($id);
        if ($character) {
            $character->delete();
            return true;
        }
        return false;
    }
}

