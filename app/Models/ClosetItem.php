<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ClosetItem extends Model
{
    // Define the table associated with the model
    protected $table = 'closet_item';

    // Define the primary key for the table
    protected $primaryKey = 'id';

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'character_id',
        'image',
        'created_at',
        'updated_at'
    ];

    
    // Define the relationship with the Character model
    // A Closet item belongs to a character
    // This allows us to access the character associated with a Closet item
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    // Method to get all Closet items
    public static function getAllClosetItems()
    {
        return self::all();
    }


    // Method to get a Closet item by ID
    public static function getClosetItemById($id)
    {
        return self::find($id);
    }

    // Method to get all character Closet items
    public static function getClosetItemsByCharacterId($characterId)
    {
        return self::where('character_id', $characterId)->get();
    }

    // Method to create a new Closet item
    public static function createClosetItem($data)
    {
        return self::create($data);
    }

    // Method to delete a Closet item by ID
    public static function deleteClosetItem($id)
    {
        $closetitem = self::find($id);
        if ($closetitem) {
            $closetitem->delete();
            return true;
        }
        return false;
    }
}

