"use strict";

let audioPlayer = document.getElementById('audio-player');
let playPauseButton = document.querySelector('.play-pause');
let seekBackwardButton = document.querySelector('.seek-backward');
let seekForwardButton = document.querySelector('.seek-forward');
let volumeSlider = document.querySelector('.volume-slider');
let progressBar = document.querySelector('.progress-bar');
let progressContainer = document.querySelector('.progress-container');
let isDragging = false;
let prevSongButton = document.querySelector('.prev-song-btn');
let nextSongButton = document.querySelector('.next-song-btn');
let randomModeButton = document.querySelector('.random-mode-btn');
let isRandomMode = false;
let songTitle;

document.addEventListener('DOMContentLoaded', function () {
    // Obtener el elemento <audio>
    const audioPlayer = document.querySelector('audio');

    loadVolumeSliderState();

    // Verificar si existe una cookie para songId
    const songIdCookie = document.cookie.split(';').find(cookie => cookie.trim().startsWith('songId='));

    const songTitleCookie = document.cookie.split(';').find(cookie => cookie.trim().startsWith('songTitle='));
    updateAlbumName();

    if (songTitleCookie) {
        // Si existe la cookie, obtener el título almacenado
        const songTitle = songTitleCookie.split('=')[1];

    }

    if (songIdCookie) {
        // Si existe la cookie, obtener la ID de la canción almacenada
        const songId = songIdCookie.split('=')[1];

        // Obtener el enlace de la canción correspondiente a partir de la ID
        const songLink = document.querySelector(`.song-link[data-id="${songId}"]`);

        if (songLink) {
            // Obtener la URL de la canción del atributo data-src
            const songSrc = songLink.getAttribute('data-src');

            // Establecer el atributo src del elemento <audio> con la URL de la canción seleccionada
            audioPlayer.src = songSrc;
            updateSongInfo(songTitle);

            // Verificar si hay una cookie para currentTime
            const currentTimeCookie = document.cookie.split(';').find(cookie => cookie.trim().startsWith('currentTime='));

            if (currentTimeCookie) {
                // Si existe la cookie, obtener el tiempo almacenado
                const currentTime = parseFloat(currentTimeCookie.split('=')[1]);


                // Establecer el currentTime del audioPlayer
                audioPlayer.currentTime = currentTime;
            } else {

            }
            // Reproducir la canción automáticamente
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
    songLinks.forEach(function (link) {
        // Manejar el clic en el enlace de canción
        link.addEventListener('click', function (event) {
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

            const songTitle = this.textContent.trim();
            document.cookie = `songTitle=${songTitle}; expires=${new Date(Date.now() + (365 * 24 * 60 * 60 * 1000)).toUTCString()}; path=/`;

            updateSongInfo(songTitle);
            // Restablecer el resaltado de todas las canciones
            resetSongHighlights();

            // Resaltar la canción actual
            highlightCurrentSong(this);
            // Reproducir la nueva canción automáticamente (si se desea) cuando el usuario haga clic
            registerReproduction(songId);

            audioPlayer.play();
        });
    });



    // Manejar el evento timeupdate para actualizar el currentTime y hacer un console.log cada segundo
    audioPlayer.addEventListener('timeupdate', function () {
        // Obtener el currentTime de la canción
        const currentTime = audioPlayer.currentTime;

        document.cookie = `currentTime=${currentTime}; expires=${new Date(Date.now() + (365 * 24 * 60 * 60 * 1000)).toUTCString()}; path=/`;
    });


    document.querySelectorAll('.delete-song-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            let songId = this.getAttribute('data-id');
            deleteSongById(songId);
        });
    });

    document.querySelectorAll('.delete-song').forEach(function (button) {
        button.addEventListener('click', function () {
            let songId = this.getAttribute('data-id');
            let playlistId = this.getAttribute('data-playlist-id'); // Asumiendo que tienes un atributo data-playlist-id en tus botones
            deleteSongById2(songId, playlistId);
        });
    });

    function deleteSongById2(songId, playlistId) {
        fetch('/playlist/' + playlistId + {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (!data.err) {
                    let row = document.getElementById('song_' + songId);
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

    function deleteSongById(id) {
        fetch('/song/' + id + '/delete', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (!data.err) {

                    let row = document.getElementById('song_' + id);
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


    function registerReproduction(songId) {
        fetch('/song/' + songId + '/reproduction', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al registrar la reproducción');
                }
                console.log('Reproducción registrada correctamente');
            })
            .catch(error => {
                console.error('Error al registrar la reproducción:', error);
            });
    }

    playPauseButton.addEventListener('click', function () {
        if (audioPlayer.paused) {
            audioPlayer.play();
        } else {
            audioPlayer.pause();
        }
    });

    seekBackwardButton.addEventListener('click', function () {
        audioPlayer.currentTime -= 10; // Retrocede 10 segundos
    });

    seekForwardButton.addEventListener('click', function () {
        audioPlayer.currentTime += 10; // Avanza 10 segundos
    });

    volumeSlider.addEventListener('input', function () {
        audioPlayer.volume = volumeSlider.value / 100;
    });

    audioPlayer.addEventListener('timeupdate', function () {
        let progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        progressBar.style.width = progress + '%';
    });


    // Controlar el inicio del arrastre cuando el usuario hace clic en el contenedor de la barra de progreso
    progressContainer.addEventListener('mousedown', function (event) {
        isDragging = true;
        updateProgress(event);
        audioPlayer.pause(); // Pausar la reproducción mientras se arrastra la barra de progreso
    });

    // Controlar el arrastre mientras el usuario mueve el ratón
    document.addEventListener('mousemove', function (event) {
        if (isDragging) {
            updateProgress(event);
        }
    });

    // Controlar el fin del arrastre cuando el usuario suelta el clic del ratón
    document.addEventListener('mouseup', function () {
        if (isDragging) {
            isDragging = false;
            audioPlayer.currentTime = (parseFloat(progressBar.style.width) / 100) * audioPlayer.duration; // Ajustar la posición de reproducción
            audioPlayer.play(); // Continuar la reproducción desde la nueva posición
        }
    });

    progressContainer.addEventListener('click', function (event) {
        let rect = progressContainer.getBoundingClientRect();
        let offsetX = event.clientX - rect.left;
        let width = rect.right - rect.left;
        let percentage = (offsetX / width) * 100;

        if (percentage >= 0 && percentage <= 100) {
            progressBar.style.width = percentage + '%';
            audioPlayer.currentTime = (percentage / 100) * audioPlayer.duration;
        }
    });
    // Función para actualizar la posición de reproducción del audio y la barra de progreso
    function updateProgress(event) {
        let rect = progressContainer.getBoundingClientRect();
        let offsetX = event.clientX - rect.left;
        let width = rect.right - rect.left;
        let percentage = (offsetX / width) * 100;

        if (percentage >= 0 && percentage <= 100) {
            progressBar.style.width = percentage + '%';
        }
    }

    audioPlayer.addEventListener('timeupdate', function () {
        let progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        progressBar.style.width = progress + '%';
    });

    // Manejar el clic en el botón de retroceso
    prevSongButton.addEventListener('click', function () {
        // Obtener el índice actual de la canción reproducida
        let currentSongIndex = getCurrentSongIndex();

        // Obtener el índice de la canción anterior
        let prevSongIndex = currentSongIndex - 1;

        // Reproducir la canción anterior si existe
        if (prevSongIndex >= 0) {
            playSongByIndex(prevSongIndex);
        }
    });

    // Manejar el clic en el botón de avance
    nextSongButton.addEventListener('click', function () {
        if (isRandomMode) { // Verificar si el modo aleatorio está activado
            let currentSongIndex = getCurrentSongIndex();
            let randomIndex;

            // Generar un índice aleatorio diferente al índice de la canción actual
            do {
                randomIndex = Math.floor(Math.random() * songLinks.length);
            } while (randomIndex === currentSongIndex);

            // Reproducir la canción aleatoria
            playSongByIndex(randomIndex);
        } else {
            // Si el modo aleatorio no está activado, reproducir la siguiente canción en la lista
            let nextSongIndex = getCurrentSongIndex() + 1;
            if (nextSongIndex < songLinks.length) {
                playSongByIndex(nextSongIndex);
            }
        }
    });

    // Función para obtener el índice de la canción actualmente reproducida
    function getCurrentSongIndex() {
        let currentSongSrc = audioPlayer.src;
        for (let i = 0; i < songLinks.length; i++) {
            if (songLinks[i].getAttribute('data-src') === currentSongSrc) {
                return i;
            }
        }
        return -1;
    }

    audioPlayer.addEventListener('ended', function () {
        if (isRandomMode) {
            let currentSongIndex = getCurrentSongIndex();
            let randomIndex;

            // Generar un índice aleatorio diferente al índice de la canción actual
            do {
                randomIndex = Math.floor(Math.random() * songLinks.length);
            } while (randomIndex === currentSongIndex);

            // Reproducir la canción aleatoria
            playSongByIndex(randomIndex);

        } else {
            // Si el modo aleatorio no está activado, reproducir la siguiente canción en la lista
            let nextSongIndex = getCurrentSongIndex() + 1;
            if (nextSongIndex < songLinks.length) {
                playSongByIndex(nextSongIndex);
            } else {
                audioPlayer.pause();
            }
        }
    });


    // Función para reproducir una canción por su índice en la lista de enlaces de canciones
    function playSongByIndex(index) {
        resetSongHighlights();

        let songLink = songLinks[index];
        let songSrc = songLink.getAttribute('data-src');
        let songId = songLink.getAttribute('data-id');
        let songTitle = songLink.textContent.trim();

        // Guardar la cookie songId
        document.cookie = `songId=${songId}; expires=${new Date(Date.now() + (365 * 24 * 60 * 60 * 1000)).toUTCString()}; path=/`;
        document.cookie = `songTitle=${songTitle}; expires=${new Date(Date.now() + (365 * 24 * 60 * 60 * 1000)).toUTCString()}; path=/`;
        // Actualizar el atributo src del elemento <audio> con la URL de la nueva canción seleccionada
        audioPlayer.src = songSrc;

        // Establecer el currentTime del audioPlayer
        audioPlayer.currentTime = 0;
        updateSongInfo(songTitle);

        highlightCurrentSong(songLink);
        // Reproducir la nueva canción automáticamente (si se desea) cuando el usuario haga clic
        registerReproduction(songId);

        audioPlayer.play();
    }

    randomModeButton.addEventListener('click', function () {
        // Cambiar el estado del modo aleatorio
        isRandomMode = !isRandomMode;

        // Actualizar el texto del botón según el estado del modo aleatorio
        if (isRandomMode) {
            randomModeButton.textContent = 'Aleatorio (activado)';
        } else {
            randomModeButton.textContent = 'Aleatorio';
        }
    });


    function updateSongInfo(songTitle) {
        let songTitleElement = document.querySelector('.songTitle h2'); // Elemento del título de la canción

        songTitleElement.textContent = songTitle;
    }

    function updateAlbumName() {
        // Obtener el elemento h1 con la clase albumName
        let albumNameElement = document.querySelector('.albumName');

        // Obtener el texto del nombre del álbum
        let albumName = albumNameElement.textContent.trim();

        // Obtener el elemento p con el id albumNameRepro
        let albumNameReproElement = document.getElementById('albumNameRepro');

        // Establecer el texto del nombre del álbum en el elemento p
        albumNameReproElement.textContent = albumName;
    }

    function resetSongHighlights() {
        const songLinks = document.querySelectorAll('.song-link');
        songLinks.forEach(function (link) {
            link.classList.remove('active'); // Quita la clase 'active' de todos los enlaces de canciones
        });
    }

    function highlightCurrentSong(link) {
        link.classList.add('active'); // Agrega la clase 'active' al enlace de la canción actual
    }

    function loadVolumeSliderState() {
        // Obtener la cookie que contiene el valor anterior del control deslizante de volumen
        const volumeSliderValueCookie = document.cookie.split(';').find(cookie => cookie.trim().startsWith('volumeSliderValue='));

        if (volumeSliderValueCookie) {
            // Si la cookie existe, obtener el valor almacenado del control deslizante de volumen
            const volumeValue = parseFloat(volumeSliderValueCookie.split('=')[1]);

            // Establecer el valor del control deslizante de volumen en el valor almacenado
            volumeSlider.value = volumeValue;
        }
    }

    function saveVolumeSliderState() {
        // Obtener el valor actual del control deslizante de volumen
        const volumeValue = volumeSlider.value;

        // Guardar el valor del control deslizante de volumen en una cookie
        document.cookie = `volumeSliderValue=${volumeValue}; expires=${new Date(Date.now() + (365 * 24 * 60 * 60 * 1000)).toUTCString()}; path=/`;
    }

    volumeSlider.addEventListener('input', saveVolumeSliderState);


});

