<?php

class VistasController{
    
    /*LOGIN Y REGISTRO*/
    public static function verFormLogin(){
        require 'app/views/login_form.php';
    }

    public static function verFormularioRegistro(){
        require 'app/views/reg_form.php';
    }

    public static function verDocApi(){
        require 'app/views/docApi.php';
    }

    public static function verFormPago(){
        require 'app/views/form_pago.php';
    }
}