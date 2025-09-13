<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link  rel="stylesheet" type="text/css" href="{{ asset('css/layout.css') }}">
    <title>Lorekeeper</title>
</head>
<body>
    <div class="header">
        <!-- Descripción corta -->
        <h1>Lorekeeper</h1>
        <div class="menu">
            <a href="{{ url('/') }}"> ▸ Home</a>
            <a href="{{ url('characters') }}"> ▸ Characters</a>
            <a href="{{ url('relationships') }}"> ▸ Relationships</a>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>
    <!-- <div class="footer">
        <p>&copy; 2024 Proyecto PHP. Todos los derechos reservados.</p>
    </div> -->
</body>
</html>