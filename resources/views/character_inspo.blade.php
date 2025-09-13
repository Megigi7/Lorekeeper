@extends('layout.layout')

@section('content')

<div class="character-inspo">
    <h1>{{ $character->name }}'s Inspo</h1>
    <form action="{{ url('/characters/'. $character->id .'/inspo/store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="character_id" value="{{ $character->id }}">
        <input type="file" name="image" accept="image/*" required>
        <p>Character name: 
            <input type="text" name="character_name" required>
        </p>
        <p>Media:
            <input type="text" name="media" required>
        </p>
        <button type="submit">Add character inspo</button>
    </form>

    <div class="inspo-items">
        @foreach($inspos as $inspo)
            <div class="inspo-item">
                <img src="{{ asset('storage/' . $inspo->image) }}" alt="Inspo Image" width="200">
                <p> Character: {{ $inspo->character_name }} </p>
                <p> Media: {{ $inspo->media }} </p>
                <form action="{{ route('inspo.destroy', ['id' => $inspo->id]) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        @endforeach
    </div>


    <p><a href="{{ url('characters/' . $character->id) }}">Back to Character Sheet</a></p>

</div>



    
@endsection