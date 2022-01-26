<?php

class ProductsModel {

    use FiltrarTraitMatriz;    
    
    public function __construct() {
        $this->conexion = Conectar::conexion();
    }

    public static function getPlatos($cat=""){
        try {
            if($cat==""){
                 //todos los platos
                $sql = "SELECT plato.idplato as id, plato.nombre as nombre,plato.foto as foto, plato.descripcion as descripcion, plato.precio as precio,
                categoria.nombre as categoria
                FROM plato
                JOIN categoria ON categoria.idcategoria = plato.idcategoria"; 
            }else{
                //los de una categoria
                $sql = "SELECT plato.idplato as id, plato.nombre as nombre,plato.foto as foto, plato.descripcion as descripcion, plato.precio as precio,
                categoria.nombre as categoria
                FROM plato
                JOIN categoria ON categoria.idcategoria = plato.idcategoria WHERE categoria.nombre='$cat'"; 
            }
            
            $consulta = Conectar::conexion()->prepare($sql);
            $consulta->execute();
            $platos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i < sizeof($platos); $i++) { 
                $platos[$i]['json']=json_encode($platos[$i]);
            }
            return  $platos;       
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getCategorias(){
        try {
            $sql = "SELECT nombre, descripcion FROM categoria"; 
            
            $consulta = Conectar::conexion()->prepare($sql);
            $consulta->execute();
            $categorias = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return  $categorias;       
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getNombresCategorias(){
        try {
            $sql = "SELECT nombre FROM categoria"; 
            
            $consulta = Conectar::conexion()->prepare($sql);
            $consulta->execute();
            $categorias = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return  $categorias;       
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }
    
    public static function getPrecioMaxMin(){
        try {
            $sql = "SELECT min(precio) as minimo, max(precio) as maximo FROM plato"; 
            
            $consulta = Conectar::conexion()->prepare($sql);
            $consulta->execute();
            $precio = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return  $precio;       
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }
}





