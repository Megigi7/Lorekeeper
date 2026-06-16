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
        <div id="species-container">
            <label>Especies del Personaje:</label>

            @if($type == 'new' || $character->species->isEmpty())
                <div class="species-group mb-2 d-flex align-items-center">
                    <select name="species[]" class="form-control">
                        @foreach($species as $specie)
                            <option value="{{ $specie->id }}" {{ in_array($specie->id, old('species', [])) ? 'selected' : '' }}>
                                {{ $specie->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-danger btn-sm ms-2 remove-species-btn" style="display:none;">X</button>
                </div>
            @else
                @foreach($character->species as $characterSpecie)
                    <div class="species-group mb-2 d-flex align-items-center">
                        <select name="species[]" class="form-control">
                            @foreach($species as $specie)
                                <option value="{{ $specie->id }}" {{ $specie->id == $characterSpecie->id ? 'selected' : '' }}>
                                    {{ $specie->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-danger btn-sm ms-2 remove-species-btn">X</button>
                    </div>
                @endforeach
            @endif
        </div>

        <button type="button" id="add-species-btn" class="btn btn-secondary btn-sm mt-2">+ Añadir Especie</button>


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

    document.getElementById('add-species-btn').addEventListener('click', function() {
        const container = document.getElementById('species-container');
        
        // Obtenemos el primer grupo de especie para clonarlo
        const firstGroup = container.querySelector('.species-group');
        const newGroup = firstGroup.cloneNode(true);
        
        // Limpiamos la selección del nuevo clon (para que no herede el "selected" del primero)
        const select = newGroup.querySelector('select');
        select.selectedIndex = 0;
        
        // Nos aseguramos de que el botón "X" de borrado sea visible en el nuevo clon
        const removeBtn = newGroup.querySelector('.remove-species-btn');
        removeBtn.style.display = 'block';
        
        // Añadimos el nuevo grupo al contenedor
        container.appendChild(newGroup);
    });

    // Lógica para que el botón "X" elimine su fila correspondiente
    document.getElementById('species-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-species-btn')) {
            const groups = document.querySelectorAll('.species-group');
            // Evitamos que el usuario borre el último selector que queda vivo
            if (groups.length > 1) {
                e.target.closest('.species-group').remove();
            } else {
                alert('Character must have at least one species.');
            }
        }
    });



</script>


@endsection