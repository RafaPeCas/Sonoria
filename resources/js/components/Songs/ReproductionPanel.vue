<script setup>
let image = "/img/cover/test.jpg";
</script>

<template>
    <section id="reproductionPanel">
        <div id="songInfo">
            <div class="d-flex custom align-items-center h-100 pl-2">
                <div>
                    <img :src=image alt="">
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
    </section>
</template>

<style scoped>
img {
    width: 100px;
    height: 100px;
}

.custom {
    justify-content: space-evenly;
    color: white;
}

#songInfo{
    width: 400px;
}

#mediaPlayer{
    flex-grow: 1;
}

</style>