@extends('layout.layout')

@section('content')
<div class="character-list">
    <h2>Characters</h2>
    
    <ul>
        @foreach ($characters as $character)
            <li>
                <a href="{{ url('characters/' . $character->id) }}">{{ $character->name }}</a>
            </li>
        @endforeach
    </ul>

    <p><a href="{{ url('characters/create') }}">New character</a></p>

</div>
    
@endsection