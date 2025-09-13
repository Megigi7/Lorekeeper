@extends('layout.layout')

@section('content')

<div class="character-house">
    <h1>{{ $character->name }}'s House</h1>
    <form action="{{ url('/characters/'. $character->id .'/house/store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="character_id" value="{{ $character->id }}">
        <input type="file" name="image" accept="image/*" required>
        <select name="type" required>
            @foreach($houseItemsType as $type)
                <option value="{{ $type[0] }}">{{ $type[1] }}</option>
            @endforeach
        </select>
        <button type="submit">Add Image</button>
    </form>


    <div class="house-tabs">
        <!-- Pestañas -->
        <ul class="tab-list">
            <li><a href="#all" class="tab-link active" onclick="showTab(event, 'all')">All</a></li>
            @foreach($houseItemsType as $type)
            <li><a href="#{{ $type[0] }}" class="tab-link active" onclick="showTab(event, '{{ $type[0] }}')">{{ $type[1] }}</a></li>
            @endforeach
        </ul>
        <!-- Contenido de las pestañas -->
    <!-- CSS SECCION CON OVERFLOW Y -->
        <div id="all" class="tab-content" style="display:block;">
            <div class="house-items">
                @foreach($houseItems as $item)
                    <div class="house-item">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="House Image" width="200">
                        <form action="{{ route('house.destroy', ['id' => $item->id]) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        @foreach($houseItemsType as $type)
        <div id="{{ $type[0] }}" class="tab-content" style="display:block;">
            <div class="house-items">
                @foreach($houseItems->where('type', $type[0]) as $item)
                    <div class="house-item">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="House Image" width="200">
                        <form action="{{ route('house.destroy', ['id' => $item->id]) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>


    <p><a href="{{ url('characters/' . $character->id) }}">Back to Character Sheet</a></p>

</div>



<script>
    function showTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.classList.add("active");
    }
    showTab(event, 'all'); // Mostrar la pestaña "All" por defecto

</script>
<style>
    /* .gallery-tabs { margin-top: 20px; }
    .tab-list { list-style: none; padding: 0; display: flex; gap: 10px; }
    .tab-link { padding: 8px 16px; background: #eee; border-radius: 5px; text-decoration: none; color: #333; cursor: pointer; }
    .tab-link.active { background: #ccc; }
    .tab-content { margin-top: 15px; }
    .gallery-item { display: inline-block; margin: 10px; vertical-align: top; } */
</style>


    
@endsection