<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>buscar cancion</title>
    
</head>
<body>
    <h1>buscar cancion</h1>
    <form action="{{ route('search') }}" method="GET">
        <input type="text" name="term" placeholder="Enter song name">
        <button type="submit">Search</button>
    </form>

    @if ($songs->isEmpty())
        <p>ninguna cancion encontrada "{{ $term }}".</p>
    @else
        <h2>resultados"{{ $term }}"</h2>
        <ul>
            @foreach ($songs as $song)
                <li>{{ $song->name }}</li>
                <!-- Mostrar más detalles de la canción si es necesario -->
            @endforeach
        </ul>
    @endif
</body>
</html>
