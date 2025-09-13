<?php

namespace App\Http\Controllers;

use App\Models\Relationship; // Importa el modelo
use App\Models\RelationshipGalleryItem; // Importa el modelo de GalleryItem
use Illuminate\Http\Request;

class RelationshipGalleryItemController extends Controller
{

    /* Display a listing of the resource.*/
    public function index($relationshipId){
        return view('relationship_gallery', ['galleryItems' => RelationshipGalleryItem::getRelationshipGalleryItemsByRelationshipId($relationshipId), 
                                          'relationship' => Relationship::getRelationshipById($relationshipId),
                                          'galleryItemsType' => [['drawing', 'Drawing'], ['picrew', 'Picrew / Similar'], ['other', 'Other']] // Tipos de imágenes
                                        ]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){
        $data = $request->all();
        
        // Si hay una imagen, la guardamos en storage/app/public/characters
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('relationships/gallery', 'public');
            $data['image'] = $path; // Guardamos la ruta en el array $data
        }

        $gallery_item = RelationshipGalleryItem::createRelationshipGalleryItem($data);
        if ($gallery_item) {
            return redirect()->route('relationship_gallery.index', ['id' => $data['relationship_id']])->with('success', 'Gallery item created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create gallery item.');
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        $relationshipId = RelationshipGalleryItem::getRelationshipGalleryItemById($id)->relationship_id;
        //después de confirmación, se elimina la tarea especificada
        $gallery_item = RelationshipGalleryItem::deleteRelationshipGalleryItem($id);
        if ($gallery_item) {
            return redirect()->route('relationship_gallery.index', ['id' => $relationshipId])->with('success', 'Gallery item deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}
