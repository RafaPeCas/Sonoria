"use strict"

let spotifyLink = document.querySelector("#sLink")

if (localStorage.getItem("user") && localStorage.getItem("userId")) {
    console.log("hola")
    if (JSON.parse(localStorage.getItem("user")).display_name && JSON.parse(localStorage.getItem("userId"))) {
        spotifyLink.style.background = "#1c1c1cab";
        spotifyLink.style.color = "#585858";
        spotifyLink.setAttribute("href", "#")
        spotifyLink.innerHTML = "Spotify vinculado"
    }
}

