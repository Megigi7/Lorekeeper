<?php

namespace App\Http\Controllers;

use App\Models\Relationship; 
use App\Models\RelationshipType; // 🌟 1. Importamos el modelo de los tipos
use App\Models\Character;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    /* Display a listing of the resource.*/
    public function index(){
        return view('relationship_all', ['relationships' => Relationship::getAllRelationships()]);
    }

    /* Show the form for creating a new resource.*/
    public function create(){
        // 🌟 2. Traemos todos los tipos ordenados alfabéticamente desde la BBDD
        return view('relationship_form', [
            'type' => 'new',
            'characters' => Character::getAllCharacters(),
            'relationship_types' => RelationshipType::orderBy('name')->get() 
        ]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){
        // Añadimos una pequeña validación formal antes de procesar
        $request->validate([
            'character_1' => 'required',
            'character_2' => 'required',
            'relationship_type_id' => 'required|exists:relationship_types,id' // 👈 Validamos que el ID exista
        ]);

        $data = $request->all();

        // Validar que una relacion no sea consigo mismo
        if ($data['character_1'] == $data['character_2']) {
            return redirect()->back()->with('error', 'A character cannot have a relationship with themselves.');
        }

        // 🌟 3. Ajustamos el control de duplicados para que use 'relationship_type_id'
        $existingRelationship = Relationship::where(function ($query) use ($data) {
            $query->where('character_1', $data['character_1'])
                  ->where('character_2', $data['character_2'])
                  ->where('relationship_type_id', $data['relationship_type_id']);
        })->orWhere(function ($query) use ($data) {
            $query->where('character_1', $data['character_2'])
                  ->where('character_2', $data['character_1'])
                  ->where('relationship_type_id', $data['relationship_type_id']);
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
        return view('relationship_sheet', ['relationship' => Relationship::getRelationshipById($id)]);
    }

    public function showByCharacter(string $characterId){
        return view('relationship_list', [
            'relationships' => Relationship::getRelationshipsByCharacterId($characterId),
            'character' => Character::getCharacterById($characterId)
        ]);
    }

    /* Show the form for editing the specified resource. */
    public function edit(string $id){
        // 🌟 4. También pasamos los tipos de la BBDD a la vista de edición
        return view('relationship_form', [
            'type' => 'mod', 
            'relationship' => Relationship::getRelationshipById($id),
            'relationship_types' => RelationshipType::orderBy('name')->get(),
            'characters' => Character::getAllCharacters()
        ]);
    }

    /* Update the specified resource in storage. */
    public function update(Request $request, string $id){
        $request->validate([
            'relationship_type_id' => 'required|exists:relationship_types,id'
        ]);

        $data = $request->all();

        // Nota: Si necesitas validar duplicados al editar, se haría aquí de forma similar al store

        $relationship = Relationship::updateRelationship($id, $data);
        if ($relationship) { 
            return redirect()->route('relationships.show', ['id' => $id])->with('success', 'Relationship updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Relationship not found.');
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        $relationship = Relationship::deleteRelationship($id);
        if ($relationship) {
            return redirect()->route('characters.index')->with('success', 'Relationship deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}