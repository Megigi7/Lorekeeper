@extends('layout.layout')

@section('content')

    <h2>Relationship form</h2>

    @if ($type=='mod')
        <h3>{{ $relationship->character1->name }} & {{ $relationship->character2->name }}</h3>
    @endif

    <form @if($type=='new')
            action="{{ url('/relationships/store') }}"
          @else 
            action="{{ url('/relationships/' . $relationship->id . '/update') }}"
        @endif method="post" enctype="multipart/form-data">
        @csrf

        @if ($type=='new')
            <select name="character_1">
                @foreach ($characters as $character)
                    <option value="{{ $character->id }}" 
                    @if(($type=='new' && old('character_1')==$character->id) || ($type!='new' && $relationship->character_1_id==$character->id)) selected @endif>
                    {{ $character->name }}
                    </option>
                @endforeach
            </select>

            <select name="character_2">
                @foreach ($characters as $character)
                    <option value="{{ $character->id }}" 
                    @if(($type=='new' && old('character_2')==$character->id) || ($type!='new' && $relationship->character_2_id==$character->id)) selected @endif>
                    {{ $character->name }}
                    </option>
                @endforeach
            </select>
        @endif

        <!-- Select -->
        <p><b>Relationship type</b> |
        <select name="relationship_type">
            @foreach ($relationship_types as $type_option)
                <option value="{{ $type_option }}" 
                @if(($type=='new' && old('relationship_type')==$type_option) || ($type!='new' && $relationship->relationship_type==$type_option)) selected @endif>
                {{ $type_option }}
                </option>
            @endforeach
        </select>
        </p>


        <p><b>Spotify playlist</b> <i>(url)</i> |
        <input type="text" name="spotify_playlist" 
                    @if($type=='new')
                        value="{{ old('spotify_playlist') }}"
                    @else 
                        value= "{{ $relationship->spotify_playlist }}"
                    @endif>
        </p>


        @if (isset($error))
            <p style="color:red">{{ $error }}</p>
        @endif


        <input type="submit" value="Guardar">



    </form>




@endsection