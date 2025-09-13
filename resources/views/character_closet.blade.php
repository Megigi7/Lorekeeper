@extends('layout.layout')

@section('content')

<div class="character-closet">
    <h1>{{ $character->name }}'s Closet</h1>
    <form action="{{ url('/characters/'. $character->id .'/closet/store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="character_id" value="{{ $character->id }}">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Image</button>
    </form>

    <div class="closet-items">
        @foreach($closetItems as $item)
            <div class="closet-item">
                <img src="{{ asset('storage/' . $item->image) }}" alt="Closet Image" width="200">
                <form action="{{ route('closet.destroy', ['id' => $item->id]) }}" method="POST" class="delete-form">
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