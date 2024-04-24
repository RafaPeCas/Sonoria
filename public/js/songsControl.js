"use strict";

document.addEventListener('DOMContentLoaded', function() {
    // Obtener el elemento <audio>
    const audioPlayer = document.querySelector('audio');

    // Verificar si existe una cookie para songId
    const songIdCookie = document.cookie.split(';').find(cookie => cookie.trim().startsWith('songId='));

    if (songIdCookie) {
        // Si existe la cookie, obtener la ID de la canción almacenada
        const songId = songIdCookie.split('=')[1];

        console.log(`Canción reproducida automáticamente con ID: ${songId}`);

        // Obtener el enlace de la canción correspondiente a partir de la ID
        const songLink = document.querySelector(`.song-link[data-id="${songId}"]`);

        if (songLink) {
            // Obtener la URL de la canción del atributo data-src
            const songSrc = songLink.getAttribute('data-src');

            // Establecer el atributo src del elemento <audio> con la URL de la canción seleccionada
            audioPlayer.src = songSrc;

            // Verificar si hay una cookie para currentTime
            const currentTimeCookie = document.cookie.split(';').find(cookie => cookie.trim().startsWith('currentTime='));

            if (currentTimeCookie) {
                // Si existe la cookie, obtener el tiempo almacenado
                const currentTime = parseFloat(currentTimeCookie.split('=')[1]);
                console.log("1");

                // Establecer el currentTime del audioPlayer
                audioPlayer.currentTime = currentTime;
            }else{
                console.log("2");
            }
            // Reproducir la canción automáticamente
            audioPlayer.play();
        }

    }

    // Obtener todos los enlaces de canción
    const songLinks = document.querySelectorAll('.song-link');

    // Verificar si existe una cookie para currentTime
    const currentTimeCookie = document.cookie.split(';').find(cookie => cookie.trim().startsWith('currentTime='));
    let initialTime = 0; // Tiempo inicial predeterminado si no hay cookie

    if (currentTimeCookie) {
        // Si existe la cookie, obtener el currentTime almacenado
        initialTime = parseFloat(currentTimeCookie.split('=')[1]);
    }

// Iterar sobre cada enlace de canción
songLinks.forEach(function(link) {
    // Manejar el clic en el enlace de canción
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir el comportamiento por defecto del enlace

        const songSrc = this.getAttribute('data-src'); // Obtener la URL de la canción del atributo data-src

        // Obtener la ID de la canción del atributo data-id
        const songId = this.getAttribute('data-id');

        // Guardar la cookie songId
        document.cookie = `songId=${songId}; expires=${new Date(Date.now() + (365 * 24 * 60 * 60 * 1000)).toUTCString()}; path=/`;

        // Actualizar el atributo src del elemento <audio> con la URL de la canción seleccionada
        audioPlayer.src = songSrc;

        // Establecer el currentTime del audioPlayer
        audioPlayer.currentTime = 0;

        // Reproducir la nueva canción automáticamente (si se desea) cuando el usuario haga clic
        audioPlayer.play();
    });
});



    // Manejar el evento timeupdate para actualizar el currentTime y hacer un console.log cada segundo
    audioPlayer.addEventListener('timeupdate', function() {
        // Obtener el currentTime de la canción
        const currentTime = audioPlayer.currentTime;

        document.cookie = `currentTime=${currentTime}; expires=${new Date(Date.now() + (365 * 24 * 60 * 60 * 1000)).toUTCString()}; path=/`;
        console.log("Cookie de tiempo guardada:", currentTime);
    });


    document.querySelectorAll('.delete-song-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var songId = this.getAttribute('data-id');
            deleteSongById(songId);
        });
    });

    function deleteSongById(id) {
        fetch('/song/' + id+'/delete', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.err) {

                var row = document.getElementById('song_' + id);
                if (row) {
                    row.remove();
                }
            } else {
                alert('Error al eliminar la canción: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al eliminar la canción:', error);
        });
    }

});
