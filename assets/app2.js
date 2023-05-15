/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
/* import './styles/app.scss'; */
/* import $ from 'jquery'; */
//const $ = require('./jquery-3.6.4');
/* require('../../assets/bootstrap'); */

$(document).ready(function() {
    $("#btnPrueba").click(function(){
        console.log("holaaaa mundo");
    })
});

window.addEventListener('DOMContentLoaded', event => {
    const listHoursArray = document.body.querySelectorAll('.list-hours li');
    listHoursArray[new Date().getDay()].classList.add(('today'));
})

console.log("JS cargado correctamente");

var qrcode = new QRCode(document.getElementById("codigo-qr"), {
    text: "www.twitch.tv/ramplayer13",
    width: 128,
    height: 128,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
  });

// start the Stimulus application
//import './bootstrap';
