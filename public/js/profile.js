"use strict"

console.log("Una hamburguesita?????")

var tabButtons = document.querySelector(".tabs").children

Array.from(tabButtons).forEach(button => {
    button.addEventListener("click", removeShadow);
});

function removeShadow(e) {
    var tabContent = document.querySelector(".tabContent")
    Array.from(tabButtons).forEach(button => {
        if (button.classList.contains("shown")){
            button.classList.remove("shown")
        }
    });
    Array.from(tabContent.children).forEach(button => {
        if (!button.classList.contains("hidden")){
            button.classList.add("hidden")
        }
    });
    e.srcElement.classList.toggle("shadow")
    tabContent.querySelector("#"+e.srcElement.innerHTML).classList.toggle("hidden")
    e.srcElement.classList.toggle("shown")
}