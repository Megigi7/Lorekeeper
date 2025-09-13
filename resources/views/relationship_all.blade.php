@extends('layout.layout')

@section('content')
<div class="relationship-list">
    <h2>Relationships list</h2>
    
    <ul>
        @foreach ($relationships as $relationship)
            <li>
                <a href="{{ url('relationships/' . $relationship->id) }}">
                        {{ $relationship->character2->name }} & {{ $relationship->character1->name }}
                </a>
            </li>
        @endforeach
    </ul>

    <p><a href="{{ url('relationships/create') }}">New Relationship</a></p>

</div>
    
@endsection