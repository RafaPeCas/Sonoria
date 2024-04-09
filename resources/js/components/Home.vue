<script setup>
let userImage = "/img/userPictures/default.png"
</script>

<template>
    <aside>
        <div class="display d-flex flex-column align-items-center">
            <button>Buscador</button>
            <button>Tu biblioteca</button>
            <button>Inicio</button>
            <button>Cutiño</button>
            <button>Maricón</button>
        </div>
    </aside>

    <section id="content">
        <div class="contentHeader d-flex align-items-center">
            <div>
                <img :src=userImage alt="" class="userIcon">
            </div>
        </div>
        <div class="contentBody">
            <div class="d-flex flex-column gap-5">
                <div>
                    <h1>Tus mixes</h1>
                    <hr>
                </div>

                <div class="d-flex gap-5">
                    <button class="mixButton">

                    </button>
                    <button class="mixButton">

                    </button>
                    <button class="mixButton">

                    </button>
                    <button class="mixButton">

                    </button>
                    <button class="mixButton">

                    </button>
                </div>
                <div class="d-flex gap-5">
                    <button class="mixButton">

                    </button>
                    <button class="mixButton">

                    </button>
                    <button class="mixButton">

                    </button>
                    <button class="mixButton">

                    </button>
                    <button class="mixButton">

                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
aside {
    width: 400px;
    height: 100%;
    background-color: #d9d9d97b;

    @media (max-width: 1023px) {
        width: 100px;
    }
}

#content {
    flex-grow: 1;
    padding-bottom: 150px;
    display: flex;
    flex-direction: column;
    overflow: auto;
}

.contentHeader {
    width: 100%;
    height: 100px;
    flex-direction: row-reverse;
    padding-right: 30px;
}

.userIcon {
    width: 70px;
    height: 70px;
    border-radius: 100%;
    background-color: white;
}

.contentBody {
    width: 100%;
    height: 100%;
    padding-left: 50px;
    padding-right: 50px;
    color: white;
}

.mixButton {
    width: 25%;
    height: 150px;
    border-radius: 15px;
    border: none;
    box-shadow: rgb(0, 0, 0) 5px 5px 5px;
}

hr {
    margin-top: 0;
}

.display {
    width: 100%;
    height: 100%;
    justify-content: space-around;
    padding-bottom: 150px;
}

.display button {
    width: 70%;
    height: 60px;
    border-radius: 15px;
    box-shadow: rgb(52, 52, 52) 5px 5px 5px 5px;
    border: none;
}

</style>