<?php

namespace App\Http\Controllers;

use App\Models\CharacterSpecies;
use App\Models\RelationshipType;
use Illuminate\Http\Request;

class AppConfigurationController extends Controller
{
    /**
     * Muestra la pantalla centralizada de configuración
     */
    public function index()
    {
        // Este controlador es el "camarero" que te trae todas las cartas a la mesa
        return view('app_configuration', [
            'species' => CharacterSpecies::all(),
            'relationshipTypes' => RelationshipType::all()
        ]);
    }
}