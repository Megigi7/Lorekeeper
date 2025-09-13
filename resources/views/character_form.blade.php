@extends('layout.layout')

@section('content')

    <h2>Character form</h2>

    <form @if($type=='new')
            action="{{ url('/characters/store') }}"
          @else 
            action="{{ url('/characters/' . $character->id . '/update') }}"
        @endif method="post" enctype="multipart/form-data">
        @csrf


        <p><b>Name</b> |
        <input type="text" name="name" 
                    @if($type=='new')
                        value= "{{ old('name') }}"
                    @else 
                        value= "{{ $character->name }}"
                    @endif></p>

        <!-- Select -->
        <p><b>Gender</b> |
        <select name="gender">
            <option value="Female" 
            @if(($type=='new' && old('gender')=='Female') || ($type!='new' && $character->gender=='Female')) selected @endif>
            Female
            </option>
            <option value="Male" 
            @if(($type=='new' && old('gender')=='Male') || ($type!='new' && $character->gender=='Male')) selected @endif>
            Male
            </option>
            <option value="Non-binary" 
            @if(($type=='new' && old('gender')=='Non-binary') || ($type!='new' && $character->gender=='Non-binary')) selected @endif>
            Non-binary
            </option>            
            <option value="Other" 
            @if(($type=='new' && old('gender')=='Other') || ($type!='new' && $character->gender=='Other')) selected @endif>
            Other
            </option>
        </select>
        </p>

              
        <!-- Number -->
        <p><b>Age</b> |
        <input type="number" name="age" id="age"
                @if($type=='new')
                value= "{{ old('age') }}"
                @else 
                value= "{{ $character->age }}"
                @endif></p>
        
        
        <!-- Calendario (sin año) -->
        <p><b>Birthday</b> |
        <input type="date" name="birthday" id="birthday"
                @if($type=='new')
                value="{{ old('birthday') }}"
                @else 
                value= "{{ $character->birthday }}"
                @endif onchange="calculateAge()"></p>


        <!-- Number (decimal) -->
        <p><b>Height</b> <i>(cm)</i> |
        <input type="number" name="height" 
                    @if($type=='new')
                        value="{{ old('height') }}"
                    @else 
                        value= "{{ $character->height }}"
                    @endif></p>

        <!-- Select -->
        <p><b>Species</b> |
        <select name="species">
            @foreach($species as $specie)
                <option value="{{ $specie }}" 
                @if(($type=='new' && old('species')==$specie) || ($type!='new' && $character->species==$specie)) selected @endif>
                {{ $specie }}
                </option>
            @endforeach
        </select>
        </p>



        <p><b>Occupation</b> |
        <input type="text" name="occupation" 
                    @if($type=='new')
                        value="{{ old('occupation') }}"
                    @else 
                        value= "{{ $character->occupation }}"
                    @endif></p>
                

        <p><b>Image</b> |
        <input type="file" name="image" 
                    @if($type=='new')
                        value="{{ old('image') }}"
                    @else 
                        value= "{{ $character->image }}"
                    @endif ></p>
            

        <!-- Select -->
        <p><b>Sexual Orientation</b> |
        <select name="sexual_orientation">
            @foreach($sexualities as $sexuality)
                <option value="{{ $sexuality }}" 
                @if(($type=='new' && old('sexual_orientation')==$sexuality) || ($type!='new' && $character->sexual_orientation==$sexuality)) selected @endif>
                {{ $sexuality }}
                </option>
            @endforeach
        </select>
        </p>

                        
        <!-- Select (MBTI) y añadir enneagrama? -->
        <p><b>Personality</b> |
        <select name="personality">
            @foreach($personalities as $mbti)
                <option value="{{ $mbti }}" 
                @if(($type=='new' && old('personality')==$mbti) || ($type!='new' && $character->personality==$mbti)) selected @endif>
                {{ $mbti }}
                </option>
            @endforeach
        </select>
        </p>

        <p><b>Pinterest board</b> <i>(url)</i> |
        <input type="text" name="pinterest_board" 
                    @if($type=='new')
                        value="{{ old('pinterest_board') }}"
                    @else 
                        value= "{{ $character->pinterest_board }}"
                    @endif>
        </p>

        <p><b>Spotify playlist</b> <i>(url)</i> |
        <input type="text" name="spotify_playlist" 
                    @if($type=='new')
                        value="{{ old('spotify_playlist') }}"
                    @else 
                        value= "{{ $character->spotify_playlist }}"
                    @endif>
        </p>
        


        <input type="submit" value="Guardar">
    </form>


<script>
    function calculateAge() {
        const birthday = document.getElementById('birthday').value;
        if (!birthday) return;
        const birthDate = new Date(birthday);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        document.getElementById('age').value = age;
        }
</script>


@endsection