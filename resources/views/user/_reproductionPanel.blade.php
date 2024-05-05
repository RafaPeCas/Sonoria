<section id="reproductionPanel">
    @if (1 == 0)
        <div id="songInfo">
            <div class="d-flex custom align-items-center h-100 pl-2">
                <div>
                    <img class="coverImg" src="{{ $lastSong->album->image }}" alt="">
                </div>
                <div>
                    <div class="songTitle">
                        <div>
                            <h2></h2>
                        </div>
                        <p id="albumNameRepro"></p>

                    </div>

                </div>
            </div>
        </div>
        <div id="mediaPlayer">
            <div class="d-flex custom align-items-center h-100 pl-2">
                <div>
                    <h1>
                    </h1>
                </div>
                <div>

                </div>
            </div>
        </div>
    @else
        <div id="songInfo">
            <div class="d-flex custom align-items-center h-100 pl-2">
                <div>
                <img class="coverImg" src="{{ $album->image ? 'data:image/jpeg;base64,'.$album->image : asset('img/cover/test.jpg') }}" alt="{{ $album->name }}">
                </div>
                <div>
                    <div class="songTitle">
                        <div>
                            <h2></h2>
                        </div>
                    </div>
                    <p id="albumNameRepro"></p>
                </div>
            </div>
        </div>
        <div id="mediaPlayer">
            <div class="d-flex custom align-items-center h-100 pl-2">
                <div class="custom-audio-player">
                    <audio controls="controls" autobuffer="autobuffer" autoplay="autoplay" id="audio-player">
                        <!-- Aquí puedes colocar la fuente de audio -->
                        Tu navegador no soporta audio.
                    </audio>
                    <div class="audio-controls">
                        <button class="play-pause">Play/Pause</button>
                        <button class="seek-backward">«</button>
                        <button class="seek-forward">»</button>
                        <button class="prev-song-btn"><</button>
                        <button class="next-song-btn">></button>
                        <button class="random-mode-btn">Aleatorio</button>

                        <input type="range" class="volume-slider" min="0" max="100" value="100">
                    </div>

                    <div class="progress-container">
                        <div class="progress-bar"></div>
                    </div>
                </div>

                <div>

                </div>
            </div>
        </div>
    @endif


</section>
