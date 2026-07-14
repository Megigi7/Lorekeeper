@extends('layout.layout')

@section('content')
<div class="dashboard-wrapper" style="display: flex; min-height: 85vh; font-family: 'Courier New', Courier, monospace; background: #fafafa; border: 3px solid #000; box-shadow: 10px 10px 0px #000; border-radius: 12px; margin: 20px; overflow: hidden;">
    
    <aside class="sidebar" style="width: 260px; background: #fff; border-right: 3px solid #000; padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <h2 style="font-size: 1.3rem; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center;">👑 SILLY ADMIN</h2>
            <nav style="display: flex; flex-direction: column; gap: 12px;">
                <button onclick="switchTab('tab-characters')" id="btn-tab-characters" class="tab-btn active-tab">🐾 Characters</button>
                <button onclick="switchTab('tab-relationships')" id="btn-tab-relationships" class="tab-btn">💞 Relationships</button>
                <button onclick="switchTab('tab-species')" id="btn-tab-species" class="tab-btn">🌿 Species</button>
                <button onclick="switchTab('tab-reltypes')" id="btn-tab-reltypes" class="tab-btn">🔗 Rel. Types</button>
            </nav>
        </div>
        
        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
            @csrf
            <button type="submit" class="logout-btn" style="width: 100%; padding: 10px; background: #ffdee2; color: #ff0033; border: 2px solid #000; font-weight: bold; border-radius: 6px; cursor: pointer; box-shadow: 3px 3px 0px #000;">
                🚪 Meow Out
            </button>
        </form>
    </aside>

    <main class="content-area" style="flex: 1; padding: 30px; position: relative;">
        
        @if(session('success'))
            <div style="background: #d4edda; border: 2px solid #155724; color: #155724; padding: 12px; margin-bottom: 20px; border-radius: 6px; font-weight: bold;">
                😸 {{ session('success') }}
            </div>
        @endif
        @if($errors->any() || session('error'))
            <div style="background: #f8d7da; border: 2px solid #721c24; color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 6px; font-weight: bold;">
                🙀 {{ session('error') ?? 'Please check the form inputs.' }}
            </div>
        @endif

        <section id="tab-characters" class="dashboard-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">Character Management</h2>
                <button onclick="openCreateCharacterModal()" class="add-btn">+ Add New Character</button>
            </div>
            
            <table class="retro-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Species</th>
                        <th>Gender</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($characters as $character)
                    <tr>
                        <td>
                            @if($character->image)
                                <img src="{{ asset('storage/' . $character->image) }}" style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #000; object-fit: cover;">
                            @else
                                <span style="font-size: 1.5rem;">🐾</span>
                            @endif
                        </td>
                        <td><strong>{{ $character->name }}</strong></td>
                        <td>{{ $character->species ?? 'None' }}</td>
                        <td>{{ $character->gender }}</td>
                        <td>
                            <button onclick="openEditCharacterModal({{ json_encode($character) }})" class="edit-btn">Edit</button>
                            <form action="{{ route('characters.destroy', ['id' => $character->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete {{ $character->name }}? This action is irreversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section id="tab-relationships" class="dashboard-section" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">Relationships Management</h2>
                <button onclick="openCreateRelationshipModal()" class="add-btn">+ Add New Relationship</button>
            </div>
            
            <table class="retro-table">
                <thead>
                    <tr>
                        <th>Partner 1</th>
                        <th>Partner 2</th>
                        <th>Relationship Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($relationships as $relationship)
                    <tr>
                        <td><strong>{{ $relationship->character1->name ?? 'Unknown' }}</strong></td>
                        <td><strong>{{ $relationship->character2->name ?? 'Unknown' }}</strong></td>
                        <td><span style="background: #eef; border: 1px solid #000; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">{{ $relationship->relationship_type }}</span></td>
                        <td>
                            <button onclick="openEditRelationshipModal({{ json_encode($relationship) }})" class="edit-btn">Edit</button>
                            <form action="{{ route('relationships.destroy', ['id' => $relationship->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this relationship?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section id="tab-species" class="dashboard-section" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">Species Library</h2>
                <button onclick="openCreateSpeciesModal()" class="add-btn">+ Add New Species</button>
            </div>
            
            <table class="retro-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Species Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($species as $sp)
                    <tr>
                        <td>#{{ $sp->id }}</td>
                        <td><strong>{{ $sp->name }}</strong></td>
                        <td>
                            <button onclick="openEditSpeciesModal({{ json_encode($sp) }})" class="edit-btn">Edit</button>
                            <form action="{{ route('character_species.destroy', ['id' => $sp->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section id="tab-reltypes" class="dashboard-section" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">Relationship Types</h2>
                <button onclick="openCreateRelTypeModal()" class="add-btn">+ Add New Type</button>
            </div>
            
            <table class="retro-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($relationship_types as $type)
                    <tr>
                        <td>#{{ $type->id }}</td>
                        <td><strong>{{ $type->name }}</strong></td>
                        <td>
                            <button onclick="openEditRelTypeModal({{ json_encode($type) }})" class="edit-btn">Edit</button>
                            <form action="{{ route('relationship_types.destroy', ['id' => $type->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

    </main>
</div>

<div id="modal-character" class="modal-overlay">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close-btn" onclick="closeModal('modal-character')">&times;</span>
        <h2 id="char-modal-title">Create Character</h2>
        <form id="char-form" action="{{ route('characters.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="char-form-method" value="POST">

            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="char-name" required>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" id="char-gender">
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                        <option value="Non-binary">Non-binary</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="age" id="char-age">
                </div>
                <div class="form-group">
                    <label>Birthday</label>
                    <input type="date" name="birthday" id="char-birthday">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Height (cm)</label>
                    <input type="number" step="0.01" name="height" id="char-height">
                </div>
                <div class="form-group">
                    <label>Occupation</label>
                    <input type="text" name="occupation" id="char-occupation">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Sexual Orientation</label>
                    <select name="sexual_orientation" id="char-sexuality">
                        @foreach($sexualities as $sex)
                            <option value="{{ $sex }}">{{ $sex }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Personality (MBTI)</label>
                    <select name="personality" id="char-personality">
                        @foreach($personalities as $mbti)
                            <option value="{{ $mbti }}">{{ $mbti }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Species</label>
                <div id="species-container">
                    <div class="species-group" style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <select name="species[]" class="species-select" style="flex: 1;">
                            @foreach($species as $sp)
                                <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="remove-species-btn" style="background: #ffdee2; border: 2px solid #000; cursor: pointer; padding: 5px 10px; font-weight: bold;">X</button>
                    </div>
                </div>
                <button type="button" id="add-species-btn" style="background: #a2e8dd; border: 2px solid #000; padding: 5px 10px; cursor: pointer; font-weight: bold; margin-top: 5px;">+ Add another species</button>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Pinterest Board URL</label>
                    <input type="text" name="pinterest_board" id="char-pinterest">
                </div>
                <div class="form-group">
                    <label>Spotify Playlist URL</label>
                    <input type="text" name="spotify_playlist" id="char-spotify">
                </div>
            </div>

            <div class="form-group">
                <label>Character Icon / Image</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button type="submit" class="save-btn">⚡ SAVE CHARACTER ⚡</button>
        </form>
    </div>
</div>


<div id="modal-relationship" class="modal-overlay">
    <div class="modal-content" style="max-width: 500px;">
        <span class="close-btn" onclick="closeModal('modal-relationship')">&times;</span>
        <h2 id="rel-modal-title">Create Relationship</h2>
        <form id="rel-form" action="{{ route('relationships.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="rel-form-method" value="POST">

            <div class="form-group" id="rel-partners-select">
                <label>Character 1</label>
                <select name="character_1" id="rel-char1">
                    @foreach ($characters as $char)
                        <option value="{{ $char->id }}">{{ $char->name }}</option>
                    @endforeach
                </select>
                
                <label style="margin-top: 15px; display: block;">Character 2</label>
                <select name="character_2" id="rel-char2">
                    @foreach ($characters as $char)
                        <option value="{{ $char->id }}">{{ $char->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Relationship Type</label>
                <select name="relationship_type" id="rel-type">
                    @foreach ($relationship_types as $type)
                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Spotify Playlist URL</label>
                <input type="text" name="spotify_playlist" id="rel-spotify">
            </div>

            <button type="submit" class="save-btn">⚡ SAVE RELATIONSHIP ⚡</button>
        </form>
    </div>
</div>


<div id="modal-species" class="modal-overlay">
    <div class="modal-content" style="max-width: 400px;">
        <span class="close-btn" onclick="closeModal('modal-species')">&times;</span>
        <h2 id="species-modal-title">Create Species</h2>
        <form id="species-form" action="{{ route('character_species.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="species-form-method" value="POST">

            <div class="form-group">
                <label>Species Name</label>
                <input type="text" name="name" id="species-name" required placeholder="E.g. Elfe, Demon...">
            </div>

            <button type="submit" class="save-btn">⚡ SAVE SPECIES ⚡</button>
        </form>
    </div>
</div>


<div id="modal-reltype" class="modal-overlay">
    <div class="modal-content" style="max-width: 400px;">
        <span class="close-btn" onclick="closeModal('modal-reltype')">&times;</span>
        <h2 id="reltype-modal-title">Create Relationship Type</h2>
        <form id="reltype-form" action="{{ route('relationship_types.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="reltype-form-method" value="POST">

            <div class="form-group">
                <label>Type Name</label>
                <input type="text" name="name" id="reltype-name" required placeholder="E.g. Rivals, Lovers...">
            </div>

            <button type="submit" class="save-btn">⚡ SAVE TYPE ⚡</button>
        </form>
    </div>
</div>


@if(session('show_species_delete_warning'))
<div id="modal-warning-species" class="modal-overlay" style="display: flex;">
    <div class="modal-content" style="max-width: 500px; border-color: #ff0033; background: #fffcfc;">
        <span class="close-btn" onclick="closeModal('modal-warning-species')">&times;</span>
        <h2 style="color: #ff0033; margin-top: 0;">⚠️ Warning: Characters Affected!</h2>
        <p>The species you want to delete is currently assigned to these characters:</p>
        
        <ul style="background: #fff; border: 2px solid #000; padding: 15px 30px; border-radius: 6px; margin: 15px 0;">
            @foreach(session('affected_characters') as $charName)
                <li><strong>{{ $charName }}</strong></li>
            @endforeach
        </ul>
        
        <p style="font-size: 0.9rem;">Deleting this species will set all affected characters back to <strong>Human</strong> species automatically.</p>
        
        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <form action="{{ route('character_species.destroy', ['id' => session('species_id')]) }}" method="POST" style="flex: 1;">
                @csrf
                @method('DELETE')
                <input type="hidden" name="confirmed" value="1">
                <button type="submit" class="save-btn" style="background: #ffdee2; color: #ff0033; border-color: #ff0033; margin-top: 0;">Yes, delete anyway</button>
            </form>
            <button onclick="closeModal('modal-warning-species')" class="add-btn" style="flex: 1; background: #fff;">Cancel</button>
        </div>
    </div>
</div>
@endif


@if(session('show_relationship_delete_warning'))
<div id="modal-warning-reltype" class="modal-overlay" style="display: flex;">
    <div class="modal-content" style="max-width: 500px; border-color: #ff0033; background: #fffcfc;">
        <span class="close-btn" onclick="closeModal('modal-warning-reltype')">&times;</span>
        <h2 style="color: #ff0033; margin-top: 0;">⚠️ Warning: Active Relationships!</h2>
        <p>The following relationships will be permanently removed if you delete this relationship type:</p>
        
        <ul style="background: #fff; border: 2px solid #000; padding: 15px 30px; border-radius: 6px; margin: 15px 0;">
            @foreach(session('affected_relationships') as $names)
                <li><strong>{{ $names[0] }}</strong> & <strong>{{ $names[1] }}</strong></li>
            @endforeach
        </ul>
        
        <p style="font-size: 0.9rem;">Are you absolutely sure you want to proceed? This cannot be undone.</p>
        
        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <form action="{{ route('relationship_types.destroy', ['id' => session('relationship_type_id')]) }}" method="POST" style="flex: 1;">
                @csrf
                @method('DELETE')
                <input type="hidden" name="confirmed" value="1">
                <button type="submit" class="save-btn" style="background: #ffdee2; color: #ff0033; border-color: #ff0033; margin-top: 0;">Yes, delete anyway</button>
            </form>
            <button onclick="closeModal('modal-warning-reltype')" class="add-btn" style="flex: 1; background: #fff;">Cancel</button>
        </div>
    </div>
</div>
@endif


<style>
    /* Pestañas laterales */
    .tab-btn {
        width: 100%;
        padding: 12px;
        background: #f1f1f1;
        border: 2px solid #000;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        text-align: left;
        font-family: inherit;
        transition: all 0.15s ease;
    }
    .tab-btn:hover {
        background: #eee;
        transform: translate(2px, 2px);
    }
    .active-tab {
        background: #ffe600 !important;
        box-shadow: 3px 3px 0px #000;
    }

    /* Tablas retro estilo cómic */
    .retro-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        border: 2px solid #000;
        background: #fff;
    }
    .retro-table th, .retro-table td {
        border: 2px solid #000;
        padding: 12px;
        text-align: left;
    }
    .retro-table th {
        background: #f3f3f3;
    }

    /* Botones de acción */
    .add-btn { background: #a2e8dd; border: 2px solid #000; padding: 8px 15px; font-weight: bold; cursor: pointer; box-shadow: 3px 3px 0px #000; font-family: inherit; }
    .edit-btn { background: #ffe600; border: 2px solid #000; padding: 5px 10px; font-weight: bold; cursor: pointer; margin-right: 5px; font-family: inherit; }
    .delete-btn { background: #ffdee2; color: #ff0033; border: 2px solid #000; padding: 5px 10px; font-weight: bold; cursor: pointer; font-family: inherit; }
    .save-btn { width: 100%; padding: 12px; background: #ffe600; border: 3px solid #000; font-size: 1.1rem; font-weight: bold; cursor: pointer; box-shadow: 4px 4px 0px #000; font-family: inherit; margin-top: 15px; }

    .add-btn:hover, .edit-btn:hover, .delete-btn:hover, .save-btn:hover { transform: translate(1px, 1px); }

    /* Modales flotantes */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.4);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        background: #fff;
        border: 3px solid #000;
        box-shadow: 8px 8px 0px #000;
        border-radius: 12px;
        padding: 25px;
        position: relative;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }
    .close-btn {
        position: absolute;
        top: 10px; right: 15px;
        font-size: 1.8rem;
        font-weight: bold;
        cursor: pointer;
    }

    /* Layout del formulario en los modales */
    .form-row { display: flex; gap: 15px; margin-bottom: 12px; }
    .form-group { display: flex; flex-direction: column; flex: 1; margin-bottom: 12px; }
    .form-group label { font-weight: bold; margin-bottom: 5px; font-size: 0.9rem; }
    .form-group input, .form-group select { padding: 8px; border: 2px solid #000; border-radius: 6px; outline: none; font-family: inherit; }
</style>

<script>
    // 1. Intercambio de Pestañas
    function switchTab(tabId) {
        document.querySelectorAll('.dashboard-section').forEach(section => section.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active-tab'));
        
        document.getElementById(tabId).style.display = 'block';
        document.getElementById('btn-' + tabId).classList.add('active-tab');
        
        localStorage.setItem('adminActiveTab', tabId);
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Alerta de borrado redirige automáticamente a la pestaña correspondiente
        @if(session('show_species_delete_warning'))
            switchTab('tab-species');
        @elseif(session('show_relationship_delete_warning'))
            switchTab('tab-reltypes');
        @else
            let activeTab = localStorage.getItem('adminActiveTab') || 'tab-characters';
            switchTab(activeTab);
        @endif
    });

    // 2. Control de Modales
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    // --- MODALES PERSONAJE ---
    function openCreateCharacterModal() {
        document.getElementById('char-modal-title').innerText = "Create Character";
        document.getElementById('char-form').action = "{{ route('characters.store') }}";
        document.getElementById('char-form-method').value = "POST";
        document.getElementById('char-form').reset();
        openModal('modal-character');
    }

    function openEditCharacterModal(character) {
        document.getElementById('char-modal-title').innerText = "Edit Character: " + character.name;
        document.getElementById('char-form').action = "/admin/characters/" + character.id + "/update";
        document.getElementById('char-form-method').value = "POST";

        document.getElementById('char-name').value = character.name;
        document.getElementById('char-gender').value = character.gender || 'Female';
        document.getElementById('char-age').value = character.age || '';
        document.getElementById('char-birthday').value = character.birthday || '';
        document.getElementById('char-height').value = character.height || '';
        document.getElementById('char-occupation').value = character.occupation || '';
        document.getElementById('char-sexuality').value = character.sexual_orientation || 'Straight';
        document.getElementById('char-personality').value = character.personality || 'INTJ';
        document.getElementById('char-pinterest').value = character.pinterest_board || '';
        document.getElementById('char-spotify').value = character.spotify_playlist || '';

        const container = document.getElementById('species-container');
        container.innerHTML = '';
        
        if(character.species_ids && character.species_ids.length > 0) {
            character.species_ids.forEach(spId => {
                addSpeciesRow(spId);
            });
        } else {
            addSpeciesRow();
        }

        openModal('modal-character');
    }

    // --- MODALES RELACIONES ---
    function openCreateRelationshipModal() {
        document.getElementById('rel-modal-title').innerText = "Create Relationship";
        document.getElementById('rel-form').action = "{{ route('relationships.store') }}";
        document.getElementById('rel-form-method').value = "POST";
        document.getElementById('rel-partners-select').style.display = "block";
        document.getElementById('rel-form').reset();
        openModal('modal-relationship');
    }

    function openEditRelationshipModal(relation) {
        document.getElementById('rel-modal-title').innerText = "Edit Relationship";
        document.getElementById('rel-form').action = "/admin/relationships/" + relation.id + "/update";
        document.getElementById('rel-form-method').value = "POST";
        document.getElementById('rel-partners-select').style.display = "none";

        document.getElementById('rel-type').value = relation.relationship_type;
        document.getElementById('rel-spotify').value = relation.spotify_playlist || '';

        openModal('modal-relationship');
    }

    // --- MODALES ESPECIES ---
    function openCreateSpeciesModal() {
        document.getElementById('species-modal-title').innerText = "Create Species";
        document.getElementById('species-form').action = "{{ route('character_species.store') }}";
        document.getElementById('species-form-method').value = "POST";
        document.getElementById('species-form').reset();
        openModal('modal-species');
    }

    function openEditSpeciesModal(species) {
        document.getElementById('species-modal-title').innerText = "Edit Species";
        document.getElementById('species-form').action = "/admin/character_species/" + species.id + "/update";
        document.getElementById('species-form-method').value = "POST";
        document.getElementById('species-name').value = species.name;
        openModal('modal-species');
    }

    // --- MODALES TIPOS DE RELACIÓN ---
    function openCreateRelTypeModal() {
        document.getElementById('reltype-modal-title').innerText = "Create Relationship Type";
        document.getElementById('reltype-form').action = "{{ route('relationship_types.store') }}";
        document.getElementById('reltype-form-method').value = "POST";
        document.getElementById('reltype-form').reset();
        openModal('modal-reltype');
    }

    function openEditRelTypeModal(type) {
        document.getElementById('reltype-modal-title').innerText = "Edit Relationship Type";
        document.getElementById('reltype-form').action = "/admin/relationship_types/" + type.id + "/update";
        document.getElementById('reltype-form-method').value = "POST";
        document.getElementById('reltype-name').value = type.name;
        openModal('modal-reltype');
    }

    // --- Lógica clonadora de especies ---
    function addSpeciesRow(selectedId = null) {
        const container = document.getElementById('species-container');
        const row = document.createElement('div');
        row.className = 'species-group';
        row.style.display = 'flex';
        row.style.gap = '10px';
        row.style.marginBottom = '10px';

        let optionsHtml = '';
        @foreach($species as $sp)
            optionsHtml += `<option value="{{ $sp->id }}" ${selectedId == {{ $sp->id }} ? 'selected' : ''}>{{ $sp->name }}</option>`;
        @endforeach

        row.innerHTML = `
            <select name="species[]" class="species-select" style="flex: 1;">
                ${optionsHtml}
            </select>
            <button type="button" class="remove-species-btn" style="background: #ffdee2; border: 2px solid #000; cursor: pointer; padding: 5px 10px; font-weight: bold;">X</button>
        `;
        container.appendChild(row);
    }

    document.getElementById('add-species-btn').addEventListener('click', () => addSpeciesRow());

    document.getElementById('species-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-species-btn')) {
            const rows = document.querySelectorAll('.species-group');
            if (rows.length > 1) {
                e.target.closest('.species-group').remove();
            } else {
                alert('Character must have at least one species.');
            }
        }
    });
</script>