<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RelationshipGalleryItem extends Model
{
    // Define the table associated with the model
    protected $table = 'relationship_gallery_item';

    // Define the primary key for the table
    protected $primaryKey = 'id';

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'relationship_id',
        'image',
        'type',
        'created_at',
        'updated_at'
    ];

    
    // Define the relationship with the Character model
    // A gallery item belongs to a character
    // This allows us to access the character associated with a gallery item
    public function relationship()
    {
        return $this->belongsTo(Relationship::class);
    }

    // Method to get all gallery items
    public static function getAllRelationshipGalleryItems()
    {
        return self::all();
    }


    // Method to get a gallery item by ID
    public static function getRelationshipGalleryItemById($id)
    {
        return self::find($id);
    }

    // Method to get all character gallery items
    public static function getRelationshipGalleryItemsByRelationshipId($relationshipId)
    {
        return self::where('relationship_id', $relationshipId)->get();
    }

    // Method to create a new gallery item
    public static function createRelationshipGalleryItem($data)
    {
        return self::create($data);
    }


    // Method to delete a gallery item by ID
    public static function deleteRelationshipGalleryItem($id)
    {
        $galleryitem = self::find($id);
        if ($galleryitem) {
            $galleryitem->delete();
            return true;
        }
        return false;
    }
}

