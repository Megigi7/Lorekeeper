<?php

namespace App\Http\Controllers;

use App\Models\Character; // Importa el modelo
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    // PASAR MAS ADELANTE A BASE DE DATOS
    protected $species = [
        'Human',
        'Elf',
        'Mermaid',
        'Half-Mermaid',
        'Fairy',
        'Half-Fairy',
        'Half-Fox',
    ];

    protected $sexualities = [
        'Straight',
        'Gay',
        'Lesbian',
        'Bisexual',
    ];

    protected $mbti = [
        'INTJ', 'INTP', 'ENTJ', 'ENTP',
        'INFJ', 'INFP', 'ENFJ', 'ENFP',
        'ISTJ', 'ISFJ', 'ESTJ', 'ESFJ',
        'ISTP', 'ISFP', 'ESTP', 'ESFP'
    ];


    /* Display a listing of the resource.*/
    public function index(){
        return view('character_list', ['characters' => Character::getAllCharacters()]);
    }

    /* Show the form for creating a new resource.*/
    public function create(){
        //recoger de la base de datos los datos de la tabla cliente y empleados y pasarlo como parametro a la vista
        return view('character_form', ['type' => 'new',
                                       'species' => $this->species,
                                       'sexualities' => $this->sexualities,
                                       'personalities' => $this->mbti]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){


        $data = $request->all();
        
        // Si hay una imagen, la guardamos en storage/app/public/characters
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters/icons', 'public');
            $data['image'] = $path; // Guardamos la ruta en el array $data
        }

        $character = Character::createCharacter($data);
        if ($character) {
            return redirect()->route('characters.index')->with('success', 'Character created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create character.');
        }

        

    }

    /* Display the specified resource. */
    public function show(string $id){
        //depende del id, se muestra la tarea de dicho id
        return view('character_sheet', ['character' => Character::getCharacterById($id)]);
    }

    /* Show the form for editing the specified resource. */
    public function edit(string $id){
        //mostramos el formulario de edicion de la tarea especificada
        return view('character_form', ['type' => 'mod', 
                                      'character' => Character::getCharacterById($id),
                                      'species' => $this->species,
                                      'sexualities' => $this->sexualities,
                                      'personalities' => $this->mbti]);
    }

    /* Update the specified resource in storage. */
    public function update(Request $request, string $id){

        $data = $request->all();

        // Si hay una imagen, la guardamos en storage/app/public/characters
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters/icons', 'public');
            $data['image'] = $path; // Guardamos la ruta en el array $data
        }

        $character = Character::updateCharacter($id, $data);
        if ($character) {
            return redirect()->route('characters.show', ['id' => $id])->with('success', 'Character updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
        
        
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        //después de confirmación, se elimina la tarea especificada
        $character = Character::deleteCharacter($id);
        if ($character) {
            return redirect()->route('characters.index')->with('success', 'Character deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}
