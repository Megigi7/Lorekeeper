<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\GalleryItemController;
use App\Http\Controllers\ClosetItemController;
use App\Http\Controllers\HouseItemController;
use App\Http\Controllers\RelationshipController;

Route::get('/', function () { return view('welcome'); })->name('welcome');

// Character routes ------------------------------
// Listado de personajes
Route::resource('/characters', CharacterController::class);
// Crear un nuevo personaje
Route::get('/characters/create', [CharacterController::class, 'create'])->name('characters.create');
// Almacenar un nuevo personaje
Route::post('/characters/store', [CharacterController::class, 'store'])->name('characters.store');
// Obtener un personaje por ID
Route::get('/characters/{id}', [CharacterController::class, 'show'])->name('characters.show');
// Editar un personaje
Route::get('/characters/{id}/edit', [CharacterController::class, 'edit'])->name('characters.edit');
// Guardar cambios de un personaje
Route::post('/characters/{id}/update', [CharacterController::class, 'update'])->name('characters.update');
// Eliminar un personaje
Route::delete('/characters/{id}/delete', [CharacterController::class, 'destroy'])->name('characters.destroy');

// Gallery routes ------------------------------
// Listado de items de galería de un personaje
Route::get('/characters/{id}/gallery', [GalleryItemController::class, 'index'])->name('gallery.index') ; //index;
// Guardar un nuevo item de galería
Route::post('/characters/{id}/gallery/store', [GalleryItemController::class, 'store'])->name('gallery.store');
// Eliminar un item de galería
Route::delete('/gallery/{id}/delete', [GalleryItemController::class, 'destroy'])->name('gallery.destroy');  


// Closet routes ------------------------------
// Listado de items de galería de un personaje
Route::get('/characters/{id}/closet', [ClosetItemController::class, 'index'])->name('closet.index') ; //index;
// Guardar un nuevo item de galería
Route::post('/characters/{id}/closet/store', [ClosetItemController::class, 'store'])->name('closet.store');
// Eliminar un item de galería
Route::delete('/closet/{id}/delete', [ClosetItemController::class, 'destroy'])->name('closet.destroy');  

// House routes ------------------------------
// Listado de items de galería de un personaje
Route::get('/characters/{id}/house', [HouseItemController::class, 'index'])->name('house.index') ; //index;
// Guardar un nuevo item de galería
Route::post('/characters/{id}/house/store', [HouseItemController::class, 'store'])->name('house.store');
// Eliminar un item de galería
Route::delete('/house/{id}/delete', [HouseItemController::class, 'destroy'])->name('house.destroy');  

// Inspo routes ------------------------------
// Listado de items de galería de un personaje
Route::get('/characters/{id}/inspo', [App\Http\Controllers\InspoController::class, 'index'])->name('inspo.index') ; //index;
// Guardar un nuevo item de galería
Route::post('/characters/{id}/inspo/store', [App\Http\Controllers\InspoController::class, 'store'])->name('inspo.store');
// Eliminar un item de galería
Route::delete('/inspo/{id}/delete', [App\Http\Controllers\InspoController::class, 'destroy'])->name('inspo.destroy');



// Relationship routes ------------------------------
// Listado de relaciones
Route::get('/relationships', [App\Http\Controllers\RelationshipController::class, 'index'])->name('relationships.index');
// Crear una nueva relación
Route::get('/relationships/create', [App\Http\Controllers\RelationshipController::class, 'create'])->name('relationships.create');
// Almacenar una nueva relación
Route::post('/relationships/store', [App\Http\Controllers\RelationshipController::class, 'store'])->name('relationships.store');
// Obtener una relación por ID 
Route::get('/relationships/{id}', [App\Http\Controllers\RelationshipController::class, 'show'])->name('relationships.show');
// Obtener relaciones por ID de personaje
Route::get('character/{characterId}/relationships', [App\Http\Controllers\RelationshipController::class, 'showByCharacter'])->name('relationships.showByCharacter');
// Editar una relación
Route::get('/relationships/{id}/edit', [App\Http\Controllers\RelationshipController::class, 'edit'])->name('relationships.edit');
// Guardar cambios de una relación
Route::post('/relationships/{id}/update', [App\Http\Controllers\RelationshipController::class, 'update'])->name('relationships.update');
// Eliminar una relación
Route::delete('/relationships/{id}/delete', [App\Http\Controllers\RelationshipController::class, 'destroy'])->name('relationships.destroy'); 
// Listado de items de galería de una relación
Route::get('/relationships/{id}/gallery', [App\Http\Controllers\RelationshipGalleryItemController::class, 'index'])->name('relationship_gallery.index') ; //index;
// Guardar un nuevo item de galería de una relación
Route::post('/relationships/{id}/gallery/store', [App\Http\Controllers\RelationshipGalleryItemController::class, 'store'])->name('relationship_gallery.store');
// Eliminar un item de galería de una relación
Route::delete('/relationship_gallery/{id}/delete', [App\Http\Controllers\RelationshipGalleryItemController::class, 'destroy'])->name('relationship_gallery.destroy');