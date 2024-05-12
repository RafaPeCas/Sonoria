"use strict"

let spotifyLink = document.querySelector("#sLink")
let userId= Number(document.querySelector("#userId").innerHTML);

console.log(userId)

if (localStorage.getItem("user") && localStorage.getItem("userId") == userId) {
    if (JSON.parse(localStorage.getItem("user")).display_name && JSON.parse(localStorage.getItem("userId"))) {
        spotifyLink.style.background = "#1c1c1cab";
        spotifyLink.style.color = "#585858";
        spotifyLink.setAttribute("href", "#")
        spotifyLink.innerHTML = "Spotify vinculado"
    }
}

