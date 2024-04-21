<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar canción</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>Buscar canción</h1>
    <form id="searchForm">
        <input type="text" id="searchInput" name="term" placeholder="Ingrese el nombre de la canción">
        <!-- Quitamos el botón de enviar -->
    </form>

    <div id="searchResults">
        <!-- Aquí se mostrarán los resultados de la búsqueda -->
    </div>

    <script>
        var typingTimer;
        var doneTypingInterval = 500; // Intervalo de tiempo en milisegundos

        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                clearTimeout(typingTimer); // Limpiar el temporizador en cada entrada

                var term = $(this).val();
                if (term.length >= 3) {
                    typingTimer = setTimeout(function() {
                        realizarBusqueda(term); // Llamar a la función de búsqueda después del intervalo de tiempo
                    }, doneTypingInterval);
                } else {
                    $('#searchResults').html(''); // Limpiar los resultados si el término es corto
                }
            });
        });

        function realizarBusqueda(term) {
            $.ajax({
                url: "{{ route('searchSong') }}",
                method: "POST",
                data: { term: term, _token: '{{ csrf_token() }}' },
                beforeSend: function() {
                    // Puedes mostrar un mensaje de carga aquí
                },
                success: function(response) {
                    $('#searchResults').html(response);
                },
                complete: function() {
                    // Aquí puedes ocultar el mensaje de carga si lo muestras
                }
            });
        }
    </script>

</body>
</html>
