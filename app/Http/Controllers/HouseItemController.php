<?php

namespace App\Http\Controllers;

use App\Models\Character; // Importa el modelo
use App\Models\HouseItem; // Importa el modelo de HouseItem
use Illuminate\Http\Request;

class HouseItemController extends Controller
{

    /* Display a listing of the resource.*/
    public function index($characterId){
        return view('character_house', ['houseItems' => HouseItem::getHouseItemsByCharacterId($characterId), 
                                          'character' => Character::getCharacterById($characterId),
                                          'houseItemsType' => [['furniture', 'Furniture'], ['room', 'Room'], ['exterior', 'Exterior'], ['other', 'Other'] ] // Tipos de imágenes de la casa
                                        ]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){
        $data = $request->all();
        
        // Si hay una imagen, la guardamos en storage/app/public/characters
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters/house', 'public');
            $data['image'] = $path; // Guardamos la ruta en el array $data
        }

        $gallery_item = HouseItem::createHouseItem($data);
        if ($gallery_item) {
            return redirect()->route('house.index', ['id' => $data['character_id']])->with('success', 'House item created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create house item.');
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        $characterId = HouseItem::getHouseItemById($id)->character_id;
        //después de confirmación, se elimina la tarea especificada
        $house_item = HouseItem::deleteHouseItem($id);
        if ($house_item) {
            return redirect()->route('house.index', ['id' => $characterId])->with('success', 'House item deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}
