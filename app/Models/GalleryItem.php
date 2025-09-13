<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    // Define the table associated with the model
    protected $table = 'gallery_item';

    // Define the primary key for the table
    protected $primaryKey = 'id';

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'character_id',
        'image',
        'type',
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
    public static function getAllGalleryItems()
    {
        return self::all();
    }


    // Method to get a gallery item by ID
    public static function getGalleryItemById($id)
    {
        return self::find($id);
    }

    // Method to get all character gallery items
    public static function getGalleryItemsByCharacterId($characterId)
    {
        return self::where('character_id', $characterId)->get();
    }

    // Method to create a new gallery item
    public static function createGalleryItem($data)
    {
        return self::create($data);
    }

    // // Method to update a gallery item by ID
    // public static function updateCharacter($id, $data)
    // {
    //     $character = self::find($id);
    //     if ($character) {
    //         $character->update($data);
    //         return $character;
    //     }
    //     return null;
    // }

    // Method to delete a gallery item by ID
    public static function deleteGalleryItem($id)
    {
        $galleryitem = self::find($id);
        if ($galleryitem) {
            $galleryitem->delete();
            return true;
        }
        return false;
    }
}

