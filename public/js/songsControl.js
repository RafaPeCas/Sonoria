"use strict"


document.addEventListener('DOMContentLoaded', function() {
    // Obtener el elemento <audio>
    const audioPlayer = document.querySelector('audio');

    // Obtener todos los enlaces de canción
    const songLinks = document.querySelectorAll('.song-link');

    // Iterar sobre cada enlace de canción
    songLinks.forEach(function(link) {
        // Manejar el clic en el enlace de canción
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del enlace

            const songSrc = this.getAttribute('data-src'); // Obtener la URL de la canción del atributo data-src

            // Actualizar el atributo src del elemento <audio> con la URL de la canción seleccionada
            audioPlayer.src = songSrc;

            // Reproducir la nueva canción automáticamente (si se desea)
            audioPlayer.play();
        });
    });
});