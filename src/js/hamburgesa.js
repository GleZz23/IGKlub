document.querySelector(".bars__menu").addEventListener("click", animateBars);

var line1_bars = document.querySelector(".line1__bars-menu");
var line2_bars = document.querySelector(".line2__bars-menu");
var line3_bars = document.querySelector(".line3__bars-menu");

function animateBars(){
line1_bars.classList.toggle("activeline1__bars-menu");
line2_bars.classList.toggle("activeline2__bars-menu");
line3_bars.classList.toggle("activeline3__bars-menu");

}