<section id="reproductionPanel">
    <section id="reproductionPanel">
        @if (Auth::user()->last_song)
            <div id="songInfo">
                <div class="d-flex custom align-items-center h-100 pl-2">
                    <div>
                        <img src="" alt="">
                    </div>
                    <div>
                        <h2>Absolution</h2>
                        <p>Muse</p>
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
                    <img src="/img/cover/test.jpg" alt="">
                </div>
                <div>
                    <h2>Absolution</h2>
                    <p>Muse</p>
                </div>
            </div>
        </div>
        <div id="mediaPlayer">
            <div class="d-flex custom align-items-center h-100 pl-2">
                <div>
                    <h1>Aquí hay que meter el temita del reproductor de música
                    </h1>
                </div>
                <div>

                </div>
            </div>
        </div>
        @endif


    </section>
</section>
