<?php

namespace App\Http\Controllers;

use App\Models\CharacterSpecies;
use Illuminate\Http\Request;
use Exception;

class CharacterSpeciesController extends Controller
{
    // Limpiamos los métodos index y create. Solo dejamos la lógica de guardar y borrar.

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:character_species,name'
        ], [
            'name.required' => 'Species name cannot be empty.',
            'name.unique' => 'Species already exists.'
        ]);

        CharacterSpecies::create($data);

        // Importante: redirigimos a la ruta de la configuración, no a la suya propia
        return redirect()->route('app_configuration.index')->with('success', 'Species created successfully.');
    }

    public function update(Request $request,$id)
    {
        $species = CharacterSpecies::findOrFail($id);
        
        $data =$request->validate([
            'name' => 'required|unique:character_species,name,' . $id
        ], [
            'name.required' => 'Species name cannot be empty.',
            'name.unique' => 'Species already exists.'
        ]);

        $species->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Species updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $species = CharacterSpecies::findOrFail($id);

        if (!$request->has('confirmed')) {
            $affectedCharacters = $species->characters()->pluck('name');

            if ($affectedCharacters->isNotEmpty()) {
                return redirect()->back()->with([
                    'show_species_delete_warning' => true,
                    'species_id' => $species->id,
                    'affected_characters' => $affectedCharacters,
                ]);
            }
        }

        try {
            $species->delete(); 
            return redirect()->route('admin.dashboard')->with('success', 'Species deleted. The affected characters are now Humans.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}