"use strict";

var tabButtons = document.querySelectorAll(".tab-button");

tabButtons.forEach(button => {
    button.addEventListener("click", switchTab);
});

function switchTab(e) {
    var targetTabId = e.target.dataset.tab;
    var tabContent = document.querySelector(".tabContent");

    // Ocultar todos los contenidos de los tabs
    tabContent.querySelectorAll(".tab").forEach(tab => {
        tab.classList.add("hidden");
    });

    // Mostrar el contenido del tab correspondiente
    var targetTab = tabContent.querySelector("#" + targetTabId);
    targetTab.classList.remove("hidden");

    // Eliminar la clase "shadow" de todos los botones
    tabButtons.forEach(button => {
        button.classList.remove("shadow");
    });

    // Agregar la clase "shadow" al botón clickeado
    e.target.classList.add("shadow");
}
