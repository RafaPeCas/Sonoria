"use strict";

document.addEventListener('DOMContentLoaded', function() {
    // Obtener el elemento <audio>
    const audioPlayer = document.querySelector('audio');

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

            // Actualizar el atributo src del elemento <audio> con la URL de la canción seleccionada
            audioPlayer.src = songSrc;

            // Establecer el currentTime del audioPlayer
            audioPlayer.currentTime = initialTime;

            // Reproducir la nueva canción automáticamente (si se desea)
            audioPlayer.play();

            // Establecer el intervalo para almacenar el currentTime en una cookie cada 5 segundos
            setInterval(function() {
                // Obtener el currentTime de la canción
                const currentTime = audioPlayer.currentTime;

                // Almacenar el currentTime en una cookie
                document.cookie = `currentTime=${currentTime}; expires=${new Date(Date.now() + 5 * 1000).toUTCString()}; path=/`;
            }, 5000);
        });
    });

    // Manejar el evento timeupdate para actualizar el currentTime y hacer un console.log cada segundo
    audioPlayer.addEventListener('timeupdate', function() {
        // Obtener el currentTime de la canción
        const currentTime = audioPlayer.currentTime;

        // Hacer un console.log del currentTime cada segundo
        console.log(currentTime);
    });
});
