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
$(document).ready(function() {
   
    $('#nameInput').on('input', function() {
        var name = $(this).val();
        var maxLength = 60;

        if (name.length > maxLength || name.length<2) {
            $('#nameCorrect').text('');
            $('#nameError').text('El nombre no puede tener más de ' + maxLength + ' caracteres, ni menos de 2 caracteres');
            
        } else {
            $('#nameError').text('');
            $('#nameCorrect').text('El nombre es válido.');
        }
    });


    $('#emailInput').on('input', function() {
        var email = $(this).val();
        var maxLength = 255;
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|edu|gov)$/i;

        if (email.length > maxLength) {
            $('#emailError').text('El E-mail debe tener como máximo ' + maxLength + ' caracteres.');
            $('#emailCorrect').text('');
        } else if (!emailPattern.test(email)) {
            $('#emailError').text('El email debe ser una dirección de correo válida y terminar en ".com, .net, .org, .edu, .gov".');
            $('#emailCorrect').text('');
        } else {
            $('#emailError').text('');
            $('#emailCorrect').text('El email es válido.');
        }
    });
});

  
   


