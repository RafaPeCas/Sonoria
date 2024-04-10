@php
    $user = Auth::user();
    $lastSong = $user->lastSong;
@endphp

<section id="reproductionPanel">
    <section id="reproductionPanel">
        @if ($lastSong)
            <div id="songInfo">
                <div class="d-flex custom align-items-center h-100 pl-2">
                    <div>
                        <img src="{{ $lastSong->album->image }}" alt="">
                    </div>
                    <div>
                        <div class="songTitle">
                            <div>
                                <h2>{{ $lastSong->name }}</h2>
                            </div>

                        </div>
                        <p>{{ $lastSong->album->name }}</p>
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
