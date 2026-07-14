<?php

namespace App\Http\Controllers;

use App\Models\RelationshipType;
use Illuminate\Http\Request;
use Exception;

class RelationshipTypeController extends Controller
{
    /**
     * Guardar un nuevo tipo de relación
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:relationship_types,name'
        ], [
            'name.required' => 'Relationship type name cannot be empty.',
            'name.unique' => 'This relationship type already exists.'
        ]);

        RelationshipType::create($data);

        // Redirigimos explícitamente al index de la configuración
        return redirect()->route('app_configuration.index')->with('success', 'Relationship type created successfully.');
    }

    public function update(Request $request,$id)
    {
        $type = RelationshipType::findOrFail($id);

        $data =$request->validate([
            'name' => 'required|unique:relationship_types,name,' . $id
        ], [
            'name.required' => 'Relationship type name cannot be empty.',
            'name.unique' => 'This relationship type already exists.'
        ]);

        $type->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Relationship type updated successfully.');
    }


    /**
     * Eliminar un tipo de relación con control de alertas de seguridad
     */
    public function destroy(Request $request, $id)
    {
        $type = RelationshipType::findOrFail($id);

        // ⚠️ CONTROL DE ADVERTENCIA: Si no viene confirmado, buscamos los nombres
        if (!$request->has('confirmed')) {
            
            // 1. Nos traemos las relaciones que usan este tipo, cargando de golpe sus personajes
            $affectedRelations = $type->relationships()
                ->with(['character_1', 'character_2']) 
                ->get();

            if ($affectedRelations->isNotEmpty()) {
                
                // 2. Transformamos la colección en el formato de nombres: [['Sora', 'Riku'], ['Riku', 'Kairi']]
                $formattedRelationships = $affectedRelations->map(function ($relation) {
                    return [
                        $relation->character_1->name ?? 'Unknown Character',
                        $relation->character_2->name ?? 'Unknown Character'
                    ];
                })->toArray();

                // 3. Lanzamos la alerta a la sesión con el array estructurado
                return redirect()->back()->with([
                    'show_relationship_delete_warning' => true,
                    'relationship_type_id' => $type->id,
                    'affected_relationships' => $formattedRelationships, // 👈 Aquí va tu array
                ]);
            }
        }

        try {
            // Si no había relaciones o ya confirmó, borramos el tipo de relación
            $type->delete(); 
            return redirect()->route('admin.dashboard')->with('success', 'Relationship type deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}