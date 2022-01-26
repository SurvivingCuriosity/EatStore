<?php

class MainController{
    public static $conexion;

    public function __construct() {
        self::$conexion = Conectar::conexion();
    }

    //evalua si ha iniciado sesion, lo manda al formulario de login o al inicio
    public static function index() {
        if(!isset($_SESSION["nombre"])){
            require 'app/views/login_form.php';
        }else{
            header("Location: index.php?ctl=platos");
        }
    }
    public static function verDocApi(){
        require 'app/views/docApi.php';
    }
}