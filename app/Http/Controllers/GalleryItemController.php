<?php

namespace App\Http\Controllers;

use App\Models\Character; 
use App\Models\GalleryItem; 
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // 🌟 NUEVO: Para leer metadatos
use Carbon\Carbon; // 🌟 NUEVO: Para formatear la fecha correctamente
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    /* Display a listing of the resource.*/
    public function index($characterId){
        return view('character_gallery', [
            'galleryItems' => GalleryItem::getGalleryItemsByCharacterId($characterId), 
            'character' => Character::getCharacterById($characterId),
            'galleryItemsType' => [['drawing', 'Drawing'], ['picrew', 'Picrew / Similar'], ['other', 'Other']]
        ]);
    }

    /* 🌟 NUEVO: Este método lee el EXIF y responde con JSON al formulario */
    public function checkExif(Request $request)
    {
        if ($request->hasFile('image')) {
            try {
                $img = Image::make($request->file('image'));
                $exifDate = $img->exif('DateTimeOriginal');

                if ($exifDate) {
                    $formattedDate = Carbon::createFromFormat('Y:m:d H:i:s', $exifDate)->format('Y-m-d');
                    return response()->json(['date' => $formattedDate]);
                }
            } catch (\Exception $e) {
                // Si falla o no tiene EXIF, no pasa nada
            }
        }
        return response()->json(['date' => null]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters/gallery', 'public');
            $data['image'] = $path;
        }

        // Aligeramos el store: la fecha viene directamente del input del formulario, 
        // ya sea la que se autorellenó o la que el usuario modificó a mano.
        $data['captured_at'] = $request->input('captured_at'); 

        $gallery_item = GalleryItem::createGalleryItem($data);
        if ($gallery_item) {
            return redirect()->route('gallery.index', ['id' => $data['character_id']])->with('success', 'Gallery item created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create gallery item.');
        }
    }

    /* 🌟 NUEVO MÉTODO: Update specifically for the date */
    public function updateDate(Request $request, string $id){
        // Asumiendo que usas Eloquent normal para actualizar. 
        // Si tienes un método estático en tu modelo tipo UpdateGalleryItem, úsalo aquí.
        $item = GalleryItem::find($id);
        
        if ($item) {
            $item->captured_at = $request->input('captured_at');
            $item->save();
            return redirect()->back()->with('success', 'Date updated successfully.');
        }
        
        return redirect()->back()->with('error', 'Item not found.');
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        $gallery_item = GalleryItem::find($id); 

        if (!$gallery_item) {
            return redirect()->back()->with('error', 'Gallery item not found.');
        }

        $characterId = $gallery_item->character_id;
        
        $fileName = $gallery_item->image; 

        if ($fileName) {
            // Unimos la carpeta exacta con el nombre del archivo
            $fullPath = 'characters/gallery/' . $fileName;

            // Comprobamos si el archivo realmente existe en /public/storage/characters/gallery/
            if (Storage::disk('public')->exists($fullPath)) {
                Storage::disk('public')->delete($fullPath);
            }
        }

        $gallery_item = GalleryItem::deleteGalleryItem($id);
        if ($gallery_item) {
            return redirect()->route('gallery.index', ['id' => $characterId])->with('success', 'Gallery item deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}