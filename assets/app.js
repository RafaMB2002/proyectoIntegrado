/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import $ from 'jquery';
//const $ = require('./jquery-3.6.4');
require('./bootstrap');

$(document).ready(function() {
    $("#btnPrueba").click(function(){
        console.log("holaaaa mundo");
    })
});

console.log("JS cargado correctamente");

// start the Stimulus application
//import './bootstrap';
