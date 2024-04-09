<script setup>

</script>

<template>
    <div class="d-flex flex-column h-100 w-100">
        <div class="header w-100 d-flex align-items-center">
            <div class="logoContainer">
                <img src="img/logos/logo_texto.png" alt="">
            </div>
            <div class="links d-flex">
                <a href="/login">Log in</a>
                <a href="/register">Register</a>
            </div>
        </div>
        <div class="body">
            <div class="mainLogo">
                <img src="img/logos/logo_texto.png" alt="">
            </div>
        </div>
    </div>
</template>

<style scoped>
.mainLogo {
    background-color: rgba(128, 128, 128, 0.288);
    border-radius: 30px;
    margin-top: 60px;
    height: 30%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.mainLogo img {
    animation: spin 6s infinite ease-in-out;
    width: 50%;
}

@keyframes spin {
    0% {
        transform: translateY(0px);
    }

    50% {
        transform: translateY(-20px);
    }

    100% {
        transform: translateY(0px);
    }
}

.body {
    overflow: auto;
    flex-grow: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

article {
    width: 60%;

}

.header {
    height: 80px;
    background-color: #161616;
    z-index: 200;
    justify-content: space-between;
}

a {
    text-decoration: none;
    color: white;
}

a:hover {
    color: rgb(199, 0, 206);
}

.links {
    width: 150px;
    justify-content: space-around;
    margin-right: 30px;
}

.logoContainer {
    height: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 30px;
}

.logoContainer img {
    height: 50px;
}
</style>