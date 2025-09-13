@extends('layout.layout')

@section('content')

<div class="character-sheet">
    <h2>{{ $relationship->character1->name }} & {{ $relationship->character2->name }}'s relationship</h2>

    <a href="{{ url('relationships/' . $relationship->id . '/gallery') }}">Gallery</a>

    <a href="{{ url('characters/' . $relationship->character_1 ) }}"> 
        @if($relationship->character1->image)
            <img src="{{ asset('storage/' . $relationship->character1->image ) }}" width="250">
        @endif
            <p> {{ $relationship->character1->name }} </p>
    </a>

    <a href="{{ url('characters/' . $relationship->character_2 ) }}"> 
        @if($relationship->character2->image)
            <img src="{{ asset('storage/' . $relationship->character2->image ) }}" width="250"> 
        @endif
        <p> {{ $relationship->character2->name }} </p>
    </a>

    <p><strong>Relationship type:</strong> {{ $relationship->relationship_type }}</p>

    <!-- Spotify -->
    @if($relationship->spotify_playlist)
        <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/{{ $relationship->spotify_playlist }}?utm_source=generator&theme=0" 
        width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
    @endif


    <!-- BOTONES  -->
    <a href="{{ url('relationships/' . $relationship->id . '/edit') }}">Edit relationship</a>
    
    <!-- Añadir confirmación -->
    <form action="{{ url('relationships/' . $relationship->id . '/delete') }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this relationship?');">
        @csrf
        @method('DELETE')
        <button type="submit">Delete relationship</button>
    </form>


</div>
    
@endsection