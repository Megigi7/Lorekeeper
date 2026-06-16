@extends('layout.layout')

@section('content')

<div class="character-gallery">
    <h1>{{ $character->name }}'s Gallery</h1>
    
    <button type="button" onclick="openAddModal()">Add</button>

    <div class="gallery-tabs" style="margin-top: 20px;">
        <ul class="tab-list" style="display: flex; list-style: none; padding: 0; gap: 10px;">
            <li><a href="#all" class="tab-link active" onclick="showTab(event, 'all')">All</a></li>
            @foreach($galleryItemsType as $type)
                <li><a href="#{{ $type[0] }}" class="tab-link" onclick="showTab(event, '{{ $type[0] }}')">{{ $type[1] }}</a></li>
            @endforeach
        </ul>
        
        <hr>

        <div id="all" class="tab-content" style="display:block;">
            <div class="gallery-feed" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                @foreach($galleryItems as $item)
                    <div class="feed-item" style="cursor: pointer;" 
                         onclick="openDetailModal('{{ asset('storage/' . $item->image) }}', '{{ $character->name }}', '{{ $item->captured_at }}', '{{ $item->id }}')">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Gallery Image" width="100%" style="object-fit: cover; height: 200px; border-radius: 5px;">
                    </div>
                @endforeach
            </div>
        </div>

        @foreach($galleryItemsType as $type)
        <div id="{{ $type[0] }}" class="tab-content" style="display:none;">
            <div class="gallery-feed" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                @foreach($galleryItems->where('type', $type[0]) as $item)
                    <div class="feed-item" style="cursor: pointer;" 
                         onclick="openDetailModal('{{ asset('storage/' . $item->image) }}', '{{ $character->name }}', '{{ $item->captured_at }}', '{{ $item->id }}')">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Gallery Image" width="100%" style="object-fit: cover; height: 200px; border-radius: 5px;">
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <p style="margin-top: 30px;"><a href="{{ url('characters/' . $character->id) }}">Back to Character Sheet</a></p>
</div>

<div id="addModal" class="custom-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="background: white; width: 400px; margin: 10% auto; padding: 20px; border-radius: 8px; position: relative;">
        <span onclick="closeAddModal()" style="position: absolute; top: 10px; right: 15px; cursor: pointer; font-size: 20px;">&times;</span>
        
        <h3>Add New Image</h3>
        <form action="{{ url('/characters/'. $character->id .'/gallery/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="character_id" value="{{ $character->id }}">
            
            <div style="margin-bottom: 10px;">
                <label>Image:</label>
                <input type="file" name="image" id="image-input" accept="image/*" required>
            </div>
            
            <div style="margin-bottom: 10px;">
                <label>Type:</label>
                <select name="type" required>
                    @foreach($galleryItemsType as $type)
                        <option value="{{ $type[0] }}">{{ $type[1] }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 10px;">
                <label for="captured_at">Creation Date:</label>
                <input type="date" name="captured_at" id="captured_at">
                <span id="exif-loader" style="display:none; color: blue; font-size: 0.8em;">Scanning EXIF...</span>
            </div>

            <button type="submit">Save</button>
        </form>
    </div>
</div>

<div id="detailModal" class="custom-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000;">
    <div style="background: white; width: 500px; margin: 5% auto; padding: 20px; border-radius: 8px; position: relative; text-align: center;">
        <span onclick="closeDetailModal()" style="position: absolute; top: 10px; right: 15px; cursor: pointer; font-size: 20px;">&times;</span>
        
        <img id="modal-img" src="" alt="Detail" style="max-width: 100%; max-height: 300px; object-fit: contain; margin-bottom: 15px; border-radius: 4px;">
        
        <p><strong>Character:</strong> <span id="modal-character"></span></p>
        
        <hr>

        <form id="modal-update-form" action="" method="POST" style="margin-bottom: 15px;">
            @csrf
            @method('PATCH')
            <div style="margin-bottom: 10px;">
                <label><strong>Date:</strong></label>
                <input type="date" name="captured_at" id="modal-date-input">
            </div>
            <button type="submit">Editar</button>
        </form>

        <form id="modal-delete-form" action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
            @csrf
            @method('DELETE')
            <button type="submit" style="background: red; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px;">Eliminar</button>
        </form>
    </div>
</div>

<script>
    // --- TU FUNCIÓN ORIGINAL DE PESTAÑAS RECUPERADA ---
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

    // --- CONTROL MODAL CREAR ---
    function openAddModal() {
        document.getElementById('addModal').style.display = 'block';
    }
    if(typeof closeAddModal !== 'function') {
        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }
    }

    // --- CONTROL MODAL DETALLE (Asignación dinámica) ---
    function openDetailModal(imageSrc, characterName, capturedAt, itemId) {
        document.getElementById('modal-img').src = imageSrc;
        document.getElementById('modal-character').innerText = characterName;
        document.getElementById('modal-date-input').value = capturedAt;

        // Inyección de rutas dinámicas
        const updateRoute = "{{ route('gallery.updateDate', ['id' => ':id']) }}".replace(':id', itemId);
        const deleteRoute = "{{ route('gallery.destroy', ['id' => ':id']) }}".replace(':id', itemId);
        
        document.getElementById('modal-update-form').action = updateRoute;
        document.getElementById('modal-delete-form').action = deleteRoute;

        document.getElementById('detailModal').style.display = 'block';
    }
    
    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // --- ESCUCHADOR EXIF EN SEGUNDO PLANO ---
    document.getElementById('image-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const loader = document.getElementById('exif-loader');
        const dateInput = document.getElementById('captured_at');

        loader.style.display = 'inline';

        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("gallery.checkExif") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            loader.style.display = 'none';
            if (data.date) {
                dateInput.value = data.date;
            } else {
                dateInput.value = '';
            }
        })
        .catch(error => {
            loader.style.display = 'none';
            console.error('Error checking EXIF:', error);
        });
    });
</script>

<style>
    /* Estilos mínimos para que se distinga la pestaña activa */
    .tab-link { padding: 8px 16px; background: #eee; border-radius: 5px; text-decoration: none; color: #333; cursor: pointer; }
    .tab-link.active { background: #ccc; font-weight: bold; }
</style>

@endsection