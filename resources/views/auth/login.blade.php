@extends('layout.layout')

@section('content')
<div class="login-wrapper" style="display: flex; justify-content: center; align-items: center; min-height: 70vh; padding: 20px; font-family: 'Courier New', Courier, monospace;">
    
    <div class="login-card" style="background: #ffffff; border: 3px solid #000000; box-shadow: 8px 8px 0px #000000; border-radius: 12px; width: 100%; max-width: 450px; padding: 30px; text-align: center; position: relative; overflow: hidden;">
        
        <div class="cat-ear-left" style="position: absolute; top: -10px; left: 30px; width: 40px; height: 40px; background: #000; transform: rotate(-15deg); border-radius: 6px; z-index: -1;"></div>
        <div class="cat-ear-right" style="position: absolute; top: -10px; right: 30px; width: 40px; height: 40px; background: #000; transform: rotate(15deg); border-radius: 6px; z-index: -1;"></div>

        <h1 style="font-size: 1.8rem; margin-bottom: 5px; color: #111;">🐾 SILLY WIWI PORTAL 🐾</h1>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px; font-style: italic;">"Only the true Supreme Creator can pass."</p>

        <div class="meme-container" style="margin-bottom: 20px; border: 2px solid #000; border-radius: 8px; overflow: hidden; background: #f0f0f0; height: 200px; display: flex; align-items: center; justify-content: center;">
            @if($errors->any())
                <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExbWZzZ3B4bWZkd3Q1M3E2bHBlbW81b2xtZWJyeTNuY2t3ZXNhd3A5NiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/unQ3IJU2rg76/giphy.gif" 
                     alt="Silly cat judging your password" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExbWZ6ZGN0dzF4M2h0Zno4ZmV6N2FqMHV0NXNoNjdxd2M2b2xtZDVrMCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/JIX9t2j0ZTN9S/giphy.gif" 
                     alt="Wiwi typing on computer" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            @endif
        </div>

        @if($errors->any())
            <div style="background: #ffdee2; border: 2px solid #ff0033; color: #cc0000; padding: 10px; margin-bottom: 20px; border-radius: 6px; font-size: 0.85rem; font-weight: bold; text-align: left;">
                @foreach ($errors->all() as $error)
                    <div>🙀 { { $error } }</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" style="text-align: left;">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; font-weight: bold; margin-bottom: 5px; font-size: 0.9rem;">📧 Creator Email:</label>
                <input type="email" name="email" id="email" required placeholder="your-email@wiwi.com" value="{{ old('email') }}"
                       style="width: 93%; padding: 10px; border: 2px solid #000; border-radius: 6px; font-size: 1rem; box-shadow: 3px 3px 0px #000000; outline: none; font-family: inherit;">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="password" style="display: block; font-weight: bold; margin-bottom: 5px; font-size: 0.9rem;">🔑 Secret Password:</label>
                <input type="password" name="password" id="password" required placeholder="••••••••••••"
                       style="width: 93%; padding: 10px; border: 2px solid #000; border-radius: 6px; font-size: 1rem; box-shadow: 3px 3px 0px #000000; outline: none; font-family: inherit;">
            </div>

            <button type="submit" class="silly-btn"
                    style="width: 100%; padding: 12px; background: #ffe600; color: #000; font-weight: bold; font-size: 1.1rem; border: 3px solid #000; border-radius: 8px; box-shadow: 4px 4px 0px #000; cursor: pointer; transition: all 0.2s ease; font-family: inherit;">
                ⚡ MEOW-IN ⚡
            </button>
        </form>

        <div style="margin-top: 15px; font-size: 0.75rem; color: #888;">
            <p>Warning: Intruders will be turned into bread loaves 🍞</p>
        </div>

    </div>
</div>

<style>
    /* Efecto "Press" para el botón estilo retro comic book */
    .silly-btn:hover {
        background: #f4db00 !important;
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0px #000 !important;
    }
    .silly-btn:active {
        transform: translate(4px, 4px);
        box-shadow: 0px 0px 0px #000 !important;
    }
</style>
@endsection