@extends('layout.layout')

@section('content')
<div class="relationship-list">
    <h2>{{ $character->name }}'s Relationships</h2>
    
    <ul>
        @foreach ($relationships as $relationship)
            <li>
                <a href="{{ url('relationships/' . $relationship->id) }}">
                    @if ($relationship->character_1 == $character->id)
                        {{ $relationship->character2->name }}
                    @else
                        {{ $relationship->character1->name }}
                    @endif
                </a>
            </li>
        @endforeach
    </ul>

    <p><a href="{{ url('relationships/create') }}">New Relationship</a></p>

</div>
    
@endsection