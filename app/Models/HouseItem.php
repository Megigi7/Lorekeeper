<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HouseItem extends Model
{
    // Define the table associated with the model
    protected $table = 'house_item';

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
    public static function getAllHouseItems()
    {
        return self::all();
    }


    // Method to get a gallery item by ID
    public static function getHouseItemById($id)
    {
        return self::find($id);
    }

    // Method to get all character gallery items
    public static function getHouseItemsByCharacterId($characterId)
    {
        return self::where('character_id', $characterId)->get();
    }

    // Method to create a new gallery item
    public static function createHouseItem($data)
    {
        return self::create($data);
    }

    // Method to delete a gallery item by ID
    public static function deleteHouseItem($id)
    {
        $houseitem = self::find($id);
        if ($houseitem) {
            $houseitem->delete();
            return true;
        }
        return false;
    }
}

