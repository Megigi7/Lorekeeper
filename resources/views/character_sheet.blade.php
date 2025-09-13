@extends('layout.layout')

@section('content')

<script async type="text/javascript" src="https://assets.pinterest.com/js/pinit.js"></script>

<div class="character-sheet">
    <h2>Ficha de Personaje</h2>

    <div>
        <p> <a href="{{ url('characters/'. $character->id .'/gallery') }}">Gallery</a></p>
        <p> <a href="{{ url('characters/'. $character->id .'/closet') }}">Closet</a></p>
        <p> <a href="{{ url('characters/'. $character->id .'/house') }}">House</a></p>
        <p> <a href="{{ url('characters/'. $character->id .'/inspo') }}">Inspo</a></p>
        <p> <a href="{{ url('character/' . $character->id . '/relationships') }}">Relationships</a></p>
    </div>

    
    @if($character->image)
        <img src="{{ asset('storage/' . $character->image) }}" width="250">
    @endif

    <p><strong>Name:</strong> {{ $character->name }}</p>
    <p><strong>Age:</strong> {{ $character->age }}</p>
    <p><strong>Birthday:</strong> {{ $character->birthday }} 
</p>
    <p><strong>Height:</strong> {{ $character->height }} cm </p> 
    <p><strong>Species:</strong> {{ $character->species }}</p>
    <p><strong>Occupation:</strong> {{ $character->occupation }}</p>
    <p><strong>Sexual Orientation:</strong> {{ $character->sexual_orientation }}</p>
    <p><strong>Personality:</strong> {{ $character->personality }}</p>


    <!-- Pinterest -->
    @if($character->pinterest_board)
        <a data-pin-do="embedBoard" 
        href="{{ $character->pinterest_board }}" 
        data-pin-scale-width="150" data-pin-scale-height="300" data-pin-board-width="600" ></a>
    @endif

    <!-- Spotify -->
    @if($character->spotify_playlist)
        <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/{{ $character->spotify_playlist }}?utm_source=generator&theme=0" 
        width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
    @endif


    <!-- BOTONES  -->
    <a href="{{ url('characters/' . $character->id . '/edit') }}">Editar Personaje</a>
    
    <!-- Añadir confirmación -->
    <form action="{{ url('characters/' . $character->id . '/delete') }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este personaje?');">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar Personaje</button>
    </form>


</div>
    
@endsection