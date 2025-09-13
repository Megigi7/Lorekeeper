<?php

namespace App\Http\Controllers;

use App\Models\Character; // Importa el modelo
use App\Models\Inspo; // Importa el modelo de Inspo
use Illuminate\Http\Request;

class InspoController extends Controller
{

    /* Display a listing of the resource.*/
    public function index($characterId){
        return view('character_inspo', ['inspos' => Inspo::getInsposByCharacterId($characterId), 
                                        'character' => Character::getCharacterById($characterId),
                                        ]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){
        $data = $request->all();
        
        // Si hay una imagen, la guardamos en storage/app/public/characters
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters/inspo', 'public');
            $data['image'] = $path; // Guardamos la ruta en el array $data
        }

        $gallery_item = Inspo::createInspo($data);
        if ($gallery_item) {
            return redirect()->route('inspo.index', ['id' => $data['character_id']])->with('success', 'Character inspo created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create character inspo.');
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        $characterId = Inspo::getInspoById($id)->character_id;
        //después de confirmación, se elimina la tarea especificada
        $inspo = Inspo::deleteInspo($id);
        if ($inspo) {
            return redirect()->route('inspo.index', ['id' => $characterId])->with('success', 'Character inspo deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}
