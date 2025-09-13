<?php

namespace App\Http\Controllers;

use App\Models\Relationship; // Importa el modelo
use Illuminate\Http\Request;
use \App\Models\Character;

class RelationshipController extends Controller
{
    // PASAR MAS ADELANTE A BASE DE DATOS
    protected $relationship_type = [
        'Friends',
        'Couple',
        'Enemies',
        'Ex-couple (Good Termns)',
        'Ex-couple (Bad Terms)',
        'Siblings',
        'Cousins',
        'Colleagues',
        'Family',
    ];


    /* Display a listing of the resource.*/
    public function index(){
        return view('relationship_all', ['relationships' => Relationship::getAllRelationships()]);
    }

    /* Show the form for creating a new resource.*/
    public function create(){
        //recoger de la base de datos los datos de la tabla cliente y empleados y pasarlo como parametro a la vista
        return view('relationship_form', ['type' => 'new',
                                          'characters' => Character::getAllCharacters(),
                                          'relationship_types' => $this->relationship_type]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){
        $data = $request->all();
        // validar que una relacion no sea consigo mismo
        if ($data['character_1'] == $data['character_2']) {
            return redirect()->back()->with('error', 'A character cannot have a relationship with themselves.');
        }

        // validar que una relación no se repita
        $existingRelationship = Relationship::where(function ($query) use ($data) {
            $query->where('character_1', $data['character_1'])
                  ->where('character_2', $data['character_2'])
                  ->where('relationship_type', $data['relationship_type']);
        })->orWhere(function ($query) use ($data) {
            $query->where('character_1', $data['character_2'])
                  ->where('character_2', $data['character_1'])
                  ->where('relationship_type', $data['relationship_type']);
        })->first();
        if ($existingRelationship) {
            return redirect()->back()->with('error', 'This relationship already exists.');
        }

        $relationship = Relationship::createRelationship($data);
        if ($relationship) {
            return redirect()->route('relationships.show', ['id' => $relationship])->with('success', 'Relationship created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create relationship.');
        }
    }

    /* Display the specified resource. */
    public function show(string $id){
        //depende del id, se muestra la tarea de dicho id
        return view('relationship_sheet', ['relationship' => Relationship::getRelationshipById($id)]);
    }

    public function showByCharacter(string $characterId){
        //depende del id, se muestra la tarea de dicho id
        return view('relationship_list', ['relationships' => Relationship::getRelationshipsByCharacterId($characterId),
                                          'character' => Character::getCharacterById($characterId)]);
    }

    /* Show the form for editing the specified resource. */
    public function edit(string $id){
        //mostramos el formulario de edicion de la tarea especificada
        return view('relationship_form', ['type' => 'mod', 
                                          'relationship' => Relationship::getRelationshipById($id),
                                          'relationship_types' => $this->relationship_type]);
    }

    /* Update the specified resource in storage. */
    public function update(Request $request, string $id){
        $data = $request->all();

        $relationship = Relationship::updateRelationship($id, $data);
        if ($relationship) { 
            return redirect()->route('relationships.show', ['id' => $id])->with('success', 'Relationship updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Relationship not found.');
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        //después de confirmación, se elimina la tarea especificada
        $relationship = Relationship::deleteRelationship($id);
        if ($relationship) {
            return redirect()->route('characters.index')->with('success', 'Relationship deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}
