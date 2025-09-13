<?php

namespace App\Http\Controllers;

use App\Models\Character; // Importa el modelo
use App\Models\GalleryItem; // Importa el modelo de GalleryItem
use Illuminate\Http\Request;

class GalleryItemController extends Controller
{

    /* Display a listing of the resource.*/
    public function index($characterId){
        return view('character_gallery', ['galleryItems' => GalleryItem::getGalleryItemsByCharacterId($characterId), 
                                          'character' => Character::getCharacterById($characterId),
                                          'galleryItemsType' => [['drawing', 'Drawing'], ['picrew', 'Picrew / Similar'], ['other', 'Other']] // Tipos de imágenes
                                        ]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){
        $data = $request->all();
        
        // Si hay una imagen, la guardamos en storage/app/public/characters
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters/gallery', 'public');
            $data['image'] = $path; // Guardamos la ruta en el array $data
        }

        $gallery_item = GalleryItem::createGalleryItem($data);
        if ($gallery_item) {
            return redirect()->route('gallery.index', ['id' => $data['character_id']])->with('success', 'Gallery item created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create gallery item.');
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        $characterId = GalleryItem::getGalleryItemById($id)->character_id;
        //después de confirmación, se elimina la tarea especificada
        $gallery_item = GalleryItem::deleteGalleryItem($id);
        if ($gallery_item) {
            return redirect()->route('gallery.index', ['id' => $characterId])->with('success', 'Gallery item deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}
