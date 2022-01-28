<?php
class Config{
//BASE DE DATOS
    static public $host = 'localhost';
    static public $database  = 'eatstore';
    static public $username = 'root';
    static public $password    = '';
    static public $charset    = 'utf8mb4';
    static public $port    = '3306';

//RUTAS
    static public $rutaLayouts    = 'app/views/layouts/';
    static public $rutaCSS    = 'assets/styles/';
    static public $rutaJS    = 'assets/js/';
    static public $rutaIMG ='assets/img/';
    static public $rutaHelpers ='app/helpers/';
    static public $rutaParts ='app/views/parts/';

//TITULO
    static public $titulo ='Ñam ñam';
    static public $defaultRoute ='verPlatos';
    static public $carpeta ='EatStore';
}
?>