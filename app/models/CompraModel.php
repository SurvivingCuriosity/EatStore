<?php

class CompraModel {

    use FiltrarTraitMatriz;    
    
    public function __construct() {
        $this->conexion = Conectar::conexion();
    }

    public static function nuevaCompra($datos){
        try {
            $conexion = Conectar::conexion();
            $descuento = $datos['descuento'];
            $formaPago = $datos['metodoPago'];
            $total = $datos['total'];
            $totalsin = $datos['total_sinDescuento'];
            $idCliente = $_SESSION['idCliente'];
            $sql = "INSERT INTO compra (idcliente, descuento, formapago, total_sinDescuento, total) VALUES ('$idCliente', '$descuento', '$formaPago', '$totalsin', '$total')";
            $resultado=$conexion->prepare($sql)->execute();
            if($resultado){
                return $conexion->lastInsertId();
            } else return 0;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public static function crearDetallesCompra($datos, $idCompra){
        try {
            $idplato=$datos->id;
            $cantidad=$datos->cantidad;
            $precio=$datos->precio;
            $sql = "INSERT INTO detalle_compra (idplato,idcompra,cantidad,precio) VALUES ($idplato, $idCompra, $cantidad, $precio)";
            $resultado=Conectar::conexion()->prepare($sql)->execute();
            return $resultado;//1 o 0
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}





