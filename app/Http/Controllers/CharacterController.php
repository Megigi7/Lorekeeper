<?php

namespace App\Http\Controllers;

use App\Models\Character; // Importa el modelo
use App\Models\CharacterSpecies; // Importa el modelo de especies
use Illuminate\Http\Request;


class CharacterController extends Controller
{
    // PASAR MAS ADELANTE A BASE DE DATOS
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
                                       'species' => CharacterSpecies::all(),
                                       'sexualities' => $this->sexualities,
                                       'personalities' => $this->mbti]);
    }

    /* Store a newly created resource in storage.*/
    public function store(Request $request){
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters/icons', 'public');
            $data['image'] = $path;
        }

        // 1. Creamos el personaje (esto guarda nombre, edad, etc., en la tabla 'character')
        $character = Character::createCharacter($data);
        
        if ($character) {
            // 2. ¡NUEVO! Si vienen especies desde el formulario, las asociamos en el pivote
            // Si tu select solo envía un ID (no un array), Laravel es tan listo que sync([$id]) funciona igual.
            if ($request->has('species')) {
                $character->species()->sync($request->input('species'));
            }

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
                                      'species' => CharacterSpecies::all(),
                                      'sexualities' => $this->sexualities,
                                      'personalities' => $this->mbti]);
    }

    /* Update the specified resource in storage. */
    public function update(Request $request, string $id){
        $data = $request->all();

        // Obtenemos el personaje para poder borrar su imagen antigua si se sube una nueva
        $character = Character::find($id);



        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('characters/icons', 'public');
            $data['image'] = $path;
        }

        // 1. Actualizamos los datos básicos en la tabla 'character'
        $character = Character::updateCharacter($id, $data);
        
        if ($character) {
            // 2. ¡NUEVO! Sincronizamos las especies en la tabla intermedia
            // El método sync() es mágico: borra las que ya no estén seleccionadas y añade las nuevas.
            // Si el usuario desmarca todas, pasamos un array vacío [] para que limpie el pivote.
            $speciesIds = $request->input('species', []);
            $character->species()->sync($speciesIds);

            return redirect()->route('characters.show', ['id' => $id])->with('success', 'Character updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id){
        //después de confirmación, se elimina la tarea especificada
        $character = Character::find($id);
            if ($character && $character->image) {
                // Si el personaje tiene una imagen, la eliminamos del almacenamiento
                $fullPath = 'characters/icons/' . $character->image;
    
                // Comprobamos si el archivo realmente existe en /public/storage/characters/icons/
                if (Storage::disk('public')->exists($fullPath)) {
                    Storage::disk('public')->delete($fullPath);
                }
            }

        $character = Character::deleteCharacter($id);
        if ($character) {
            return redirect()->route('characters.index')->with('success', 'Character deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Character not found.');
        }
    }
}
