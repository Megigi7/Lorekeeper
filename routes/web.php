<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\GalleryItemController;
use App\Http\Controllers\ClosetItemController;
use App\Http\Controllers\HouseItemController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\RelationshipGalleryItemController;
use App\Http\Controllers\CharacterSpeciesController;
use App\Http\Controllers\AppConfigurationController;
use App\Http\Controllers\RelationshipTypeController;
use App\Http\Controllers\Auth\LoginController;

// 1. PÁGINA DE INICIO (PÚBLICA)
Route::get('/', function () { return view('welcome'); })->name('welcome');

// 2. RUTAS PÚBLICAS (Solo lectura para visitantes) ------------------------------

// Personajes (Público - ¡Aquí mantenemos tu listado!)
Route::get('/characters', [CharacterController::class, 'index'])->name('characters.index');
Route::get('/characters/{id}', [CharacterController::class, 'show'])->name('characters.show');

// Armario / Closet (Público)
Route::get('/closet', [ClosetItemController::class, 'index'])->name('closet.index');
Route::get('/closet/{id}', [ClosetItemController::class, 'show'])->name('closet.show');

// Casas (Público)
Route::get('/house', [HouseItemController::class, 'index'])->name('house.index');
Route::get('/house/{id}', [HouseItemController::class, 'show'])->name('house.show');

// Inspo (Público)
Route::get('/characters/{id}/inspo', [App\Http\Controllers\InspoController::class, 'index'])->name('inspo.index');

// Relaciones (Público)
Route::get('/relationships', [RelationshipController::class, 'index'])->name('relationships.index');
Route::get('/relationships/{id}', [RelationshipController::class, 'show'])->name('relationships.show');
Route::get('character/{characterId}/relationships', [RelationshipController::class, 'showByCharacter'])->name('relationships.showByCharacter');
Route::get('/relationships/{id}/gallery', [RelationshipGalleryItemController::class, 'index'])->name('relationship_gallery.index');


// 3. LA PUERTA SECRETA DE LOG IN (Silly wiwi portal) ---------------------
Route::get('/silly-wiwi-portal', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/silly-wiwi-portal', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// 4. EL PANEL DE CONTROL /ADMIN (Backend 100% Protegido) -----------------------
Route::middleware(['auth'])->group(function () {

    Route::get('/admin', function () {
    return view('admin.dashboard', [
        'characters' => \App\Models\Character::getAllCharacters(),
        'relationships' => \App\Models\Relationship::all(), // Reemplaza por tu método si tienes un getAll
        'species' => \App\Models\CharacterSpecies::all(),
        'relationship_types' => \App\Models\RelationshipType::orderBy('name')->get(),
        
        // Datos necesarios para los formularios de creación rápidos del modal
        'sexualities' => ['Straight', 'Gay', 'Lesbian', 'Bisexual'],
        'personalities' => [
            'INTJ', 'INTP', 'ENTJ', 'ENTP',
            'INFJ', 'INFP', 'ENFJ', 'ENFP',
            'ISTJ', 'ISFJ', 'ESTJ', 'ESFJ',
            'ISTP', 'ISFP', 'ESTP', 'ESFP'
        ]
    ]);
    })->middleware('auth')->name('admin.dashboard');

    // Configuración General (La vista app_configuration)
    Route::get('/admin/configuration', [AppConfigurationController::class, 'index'])->name('app_configuration.index');
    Route::post('/admin/character_species/store', [CharacterSpeciesController::class, 'store'])->name('character_species.store');
    Route::post('/admin/character_species/{id}/update', [CharacterSpeciesController::class, 'update'])->name('character_species.update');
    Route::delete('/admin/character_species/{id}/delete', [CharacterSpeciesController::class, 'destroy'])->name('character_species.destroy');
    Route::post('/admin/relationship_types/store', [RelationshipTypeController::class, 'store'])->name('relationship_types.store');
    Route::post('/admin/relationship_types/{id}/update', [RelationshipTypeController::class, 'update'])->name('relationship_types.update');
    Route::delete('/admin/relationship_types/{id}/delete', [RelationshipTypeController::class, 'destroy'])->name('relationship_types.destroy');

    // Gestión de Personajes (Escribir/Editar/Borrar)
    Route::get('/admin/characters/create', [CharacterController::class, 'create'])->name('characters.create');
    Route::post('/admin/characters/store', [CharacterController::class, 'store'])->name('characters.store');
    Route::get('/admin/characters/{id}/edit', [CharacterController::class, 'edit'])->name('characters.edit');
    Route::post('/admin/characters/{id}/update', [CharacterController::class, 'update'])->name('characters.update');
    Route::delete('/admin/characters/{id}/delete', [CharacterController::class, 'destroy'])->name('characters.destroy');

    // Gestión de Galería de Personajes (Escribir/Borrar/Editar fecha)
    Route::post('/admin/gallery/store', [GalleryItemController::class, 'store'])->name('gallery.store');
    Route::post('/admin/gallery/check-exif', [GalleryItemController::class, 'checkExif'])->name('gallery.checkExif');
    Route::patch('/admin/gallery/{id}/date', [GalleryItemController::class, 'updateDate'])->name('gallery.updateDate');
    Route::delete('/admin/gallery/{id}/delete', [GalleryItemController::class, 'destroy'])->name('gallery.destroy');

    // Gestión de Armario / Closet (Escribir/Borrar)
    Route::post('/admin/closet/store', [ClosetItemController::class, 'store'])->name('closet.store');
    Route::delete('/admin/closet/{id}/delete', [ClosetItemController::class, 'destroy'])->name('closet.destroy');

    // Gestión de Casas (Escribir/Borrar)
    Route::post('/admin/house/store', [HouseItemController::class, 'store'])->name('house.store');
    Route::delete('/admin/house/{id}/delete', [HouseItemController::class, 'destroy'])->name('house.destroy');

    // Gestión de Inspo (Escribir/Borrar)
    Route::post('/admin/inspo/store', [App\Http\Controllers\InspoController::class, 'store'])->name('inspo.store');
    Route::delete('/admin/inspo/{id}/delete', [App\Http\Controllers\InspoController::class, 'destroy'])->name('inspo.destroy');

    // Gestión de Relaciones entre Personajes (Escribir/Editar/Borrar)
    Route::get('/admin/relationships/create', [RelationshipController::class, 'create'])->name('relationships.create');
    Route::post('/admin/relationships/store', [RelationshipController::class, 'store'])->name('relationships.store');
    Route::get('/admin/relationships/{id}/edit', [RelationshipController::class, 'edit'])->name('relationships.edit');
    Route::post('/admin/relationships/{id}/update', [RelationshipController::class, 'update'])->name('relationships.update');
    Route::delete('/admin/relationships/{id}/delete', [RelationshipController::class, 'destroy'])->name('relationships.destroy');
    Route::post('/admin/relationships/{id}/gallery/store', [RelationshipGalleryItemController::class, 'store'])->name('relationship_gallery.store');
    Route::delete('/admin/relationship_gallery/{id}/delete', [RelationshipGalleryItemController::class, 'destroy'])->name('relationship_gallery.destroy');

});