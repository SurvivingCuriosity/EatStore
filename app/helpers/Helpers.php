<?php

class Helpers{

    public static function crearEmail($datosCompra, $carrito){
        return "creandoEmail";
    }

    public static function crearFactura($datosCompra, $carrito){
        $cadenaFactura= "<h1'>Compra realizada</h1>";
        $cadenaFactura.= "<h2'>Cliente: ".$_SESSION['nombre']." : ".$_SESSION['correoe']."</h2>";
        $cadenaFactura.= "<h3>Detalles de compra</h3>";
        foreach ($carrito as $producto) {
            $totalProducto = intval($producto->precio*$producto->cantidad);
            $cadenaFactura.= "<p>";
            $cadenaFactura.=($producto->nombre." (".$producto->precio."€) x ".$producto->cantidad." = ".$totalProducto."€");
            $cadenaFactura.= "</p>";
        }
        $cadenaFactura.= "<h3>Detalles de compra</h3>";
        $cadenaFactura.= "<hr>";
        $cadenaFactura.= "<p>Método de pago: ".ucwords($datosCompra['metodoPago'])."</p>";
        $cadenaFactura.= "<p>Total (sin descuento): ".$datosCompra['total_sinDescuento']."€</p>";
        $cadenaFactura.= "<p>Descuento aplicado: ".$datosCompra['descuento']."%</p>";
        $cadenaFactura.= "<p>Total ".$datosCompra['total']."€</p>";
        $cadenaFactura.= "<p>Gracias por confiar en nuestro servicio</p>";
        $cadenaFactura.= "<hr>";

        return $cadenaFactura;
    }


}