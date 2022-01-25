<?php

class CompraController{
    public static $conexion;
    
    public function __construct() {
        self::$conexion = Conectar::conexion();
    }
//CAMPOS TABLA cliente: idcliente, dni, nombre, direccion, correoe contras 
    use FiltrarTraitMatriz;

    public static function resumenCompra($cat=""){
        $platos = ProductsModel::getPlatos();
        require_once('app/views/resumenCompra.php');
    }

    //muestra los platos de todas las categorias o los de una en funcion de $_GET['cat]
    public static function mostrarCategorias(){
        if(isset($_GET['cat'])){
            $categoria = $_GET['cat'];
            $platos = ProductsModel::getPlatos();
        }
        //devuelve nombre y descripcion
        $categorias = ProductsModel::getCategorias();

        //añado el campo platos (de cada categoria)
        for ($i=0; $i < sizeof($categorias); $i++) { 
            $categorias[$i]['platos']=ProductsModel::getPlatos($categorias[$i]['nombre']);
        }
        
        require_once('app/views/categorias.php');
    }
}