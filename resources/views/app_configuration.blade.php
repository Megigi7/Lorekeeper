@extends('layout.layout')

@section('content')
<div class="configuration-container" style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <h1>App Configuration</h1>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 4px;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('show_species_delete_warning'))
        <div class="delete-warning-box" style="background: #fff3cd; border: 1px solid #ffeeba; color: #856404; padding: 20px; margin-bottom: 25px; border-radius: 6px;">
            <h4>⚠️ Warning: Characters Affected!</h4>
            <p>The species you want to delete is currently assigned to the following characters:</p>
            <ul style="margin-bottom: 15px;">
                @foreach(session('affected_characters') as $charName)
                    <li><strong>{{ $charName }}</strong></li>
                @endforeach
            </ul>
            <p>If you proceed, they will automatically be reassigned as <strong>Human</strong>. Do you want to continue?</p>
            
            <div style="display: flex; gap: 10px;">
                <form action="{{ route('character_species.destroy', ['id' => session('species_id')]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="confirmed" value="1">
                    <button type="submit" style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">
                        Yes, delete anyway
                    </button>
                </form>
                <a href="{{ route('app_configuration.index') }}" style="background: #6c757d; color: white; text-decoration: none; padding: 8px 15px; border-radius: 4px; display: inline-block;">
                    Cancel
                </a>
            </div>
        </div>
    @endif


    @if(session('show_relationship_delete_warning'))
        <div class="delete-warning-box" style="background: #fff3cd; border: 1px solid #ffeeba; color: #856404; padding: 20px; margin-bottom: 25px; border-radius: 6px;">
            <h4>⚠️ Warning: Active Bonds Affected!</h4>
            <p>The relationship type you want to delete is currently active between the following characters:</p>
            
            <ul style="margin-bottom: 15px;">
                @foreach(session('affected_relationships') as $pair)
                    <li>
                        <strong>{{ $pair[0] }}</strong> & <strong>{{ $pair[1] }}</strong>
                    </li>
                @endforeach
            </ul>
            
            <p>If you proceed, these relationships will be permanently removed. Do you want to continue?</p>
            
            <div style="display: flex; gap: 10px;">
                <form action="{{ route('relationship_types.destroy', ['id' => session('relationship_type_id')]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="confirmed" value="1">
                    <button type="submit" style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">
                        Yes, delete anyway
                    </button>
                </form>
                <a href="{{ route('app_configuration.index') }}" style="background: #6c757d; color: white; text-decoration: none; padding: 8px 15px; border-radius: 4px; display: inline-block;">
                    Cancel
                </a>
            </div>
        </div>
    @endif



    <div class="tabs-navigation" style="margin-bottom: 20px;">
        <button id="btn-tab-species" class="tab-btn active" onclick="switchTab('tab-species')">Species</button>
        <button id="btn-tab-relationships" class="tab-btn" onclick="switchTab('tab-relationships')">Relationships</button>
    </div>

    <hr>

    <div id="tab-species" class="tab-content" style="display: block; margin-top: 20px;">
        <div style="display: flex; gap: 40px;">
            
            <div style="flex: 1.5;">
                <h3>Existing Species</h3>
                <ul style="list-style: none; padding: 0;">
                    @foreach($species as $spec)
                        <li style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; border-bottom: 1px solid #eee; background: #fff;">
                            <span>{{ $spec->name }}</span>
                            
                            <form action="{{ route('character_species.destroy', ['id' => $spec->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove the species \'{{ $spec->name }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc3545; font-size: 1.2em; cursor: pointer; font-weight: bold; padding: 0 5px;">
                                    &times;
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div style="flex: 1; background: #f9f9f9; padding: 15px; border-radius: 6px; border: 1px solid #eee; height: fit-content;">
                <h3>Add New Species</h3>
                <form action="{{ route('character_species.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 12px;">
                        <input type="text" name="name" placeholder="Species name..." style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                        @error('name')
                            <span style="color: red; font-size: 0.85em; display: block; margin-top: 5px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" style="width: 96%; padding: 8px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        Add Species
                    </button>
                </form>
            </div>

        </div>
    </div>

    <div id="tab-relationships" class="tab-content" style="display: none; margin-top: 20px;">
        <div style="display: flex; gap: 40px;">
            
            <div style="flex: 1.5;">
                <h3>Existing Relationship Types</h3>
                @if($relationshipTypes->isEmpty())
                    <p style="color: #666; font-style: italic;">No relationship types created yet.</p>
                @else
                    <ul style="list-style: none; padding: 0;">
                        @foreach($relationshipTypes as $type)
                            <li style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; border-bottom: 1px solid #eee; background: #fff;">
                                <span>{{ $type->name }}</span>
                                
                                <form action="{{ route('relationship_types.destroy', ['id' => $type->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove the relationship type \'{{ $type->name }}\'?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #dc3545; font-size: 1.2em; cursor: pointer; font-weight: bold; padding: 0 5px;">
                                        &times;
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div style="flex: 1; background: #f9f9f9; padding: 15px; border-radius: 6px; border: 1px solid #eee; height: fit-content;">
                <h3>Add New Type</h3>
                <form action="{{ route('relationship_types.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 12px;">
                        <input type="text" name="name" placeholder="e.g., Brother, Friend, Enemy..." style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                        @error('name')
                            <span style="color: red; font-size: 0.85em; display: block; margin-top: 5px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" style="width: 96%; padding: 8px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        Add Type
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>

<script>
    /**
     * Cambia de pestaña de forma manual o programática
     */
    function switchTab(tabId) {
        var i, tabcontent, tablinks;
        
        // 1. Ocultar todos los contenidos
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        
        // 2. Quitar el estado activo a todos los botones
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        
        // 3. Mostrar la pestaña seleccionada
        document.getElementById(tabId).style.display = "block";
        
        // 4. Activar el botón correspondiente usando su ID
        if (tabId === 'tab-species') {
            document.getElementById('btn-tab-species').classList.add('active');
        } else if (tabId === 'tab-relationships') {
            document.getElementById('btn-tab-relationships').classList.add('active');
        }
        
        // 5. Guardar en la memoria del navegador qué pestaña está abierta
        localStorage.setItem('activeConfigTab', tabId);
    }

    /**
     * Al terminar de cargar la página, decidimos qué pestaña mostrar
     */
    document.addEventListener("DOMContentLoaded", function() {
        // 🧠 Truco Pro: Si Laravel acaba de lanzar la alerta de relaciones, 
        // obligamos a abrir la pestaña de relaciones sí o sí.
        @if(session('show_relationship_delete_warning'))
            switchTab('tab-relationships');
        
        // Si Laravel lanzó la alerta de especies, obligamos a abrir especies
        @elseif(session('show_species_delete_warning'))
            switchTab('tab-species');
        
        // Si no hay alertas de borrado, respetamos lo que el usuario tenía abierto antes de recargar
        @else
            let savedTab = localStorage.getItem('activeConfigTab') || 'tab-species';
            switchTab(savedTab);
        @endif
    });
</script>

<style>
    .tab-btn {
        padding: 10px 20px;
        background: #f1f1f1;
        border: 1px solid #ccc;
        cursor: pointer;
        font-weight: bold;
        border-radius: 4px 4px 0 0;
        margin-right: 5px;
    }
    .tab-btn.active {
        background: #fff;
        border-bottom: 1px solid #fff;
        position: relative;
        z-index: 2;
    }
</style>
@endsection