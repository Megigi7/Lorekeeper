<?php

namespace App\Http\Controllers;

use App\Models\Character; // Importa el modelo
use App\Models\ClosetItem; // Importa el modelo de GalleryItem
use Illuminate\Http\Request;

class ClosetItemController extends Controller
{

    /* Display a listing of the resource.*/
    public function index($characterId){
        return view('character_closet', ['closetItems' => ClosetItem::getClosetItemsByCharacterId($characterId), 
                                          'character' => Character::getCharacterById($characterId)]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){
        $data = $request->all();
        
        // Si hay una imagen, la guardamos en storage/app/public/characters
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters/closet', 'public');
            $data['image'] = $path; // Guardamos la ruta en el array $data
        }

        $closet_item = ClosetItem::createClosetItem($data);
        if ($closet_item) {
            return redirect()->route('closet.index', ['id' => $data['character_id']])->with('success', 'Closet item created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create closet item.');
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        $characterId = ClosetItem::getClosetItemById($id)->character_id;
        //después de confirmación, se elimina la tarea especificada
        $closet_item = ClosetItem::deleteClosetItem($id);
        if ($closet_item) {
            return redirect()->route('closet.index', ['id' => $characterId])->with('success', 'Closet item deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}
