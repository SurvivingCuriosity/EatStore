<?php

class CompraController{
    public static $conexion;

    public function __construct() {
        self::$conexion = Conectar::conexion();
    }
//CAMPOS TABLA cliente: idcliente, dni, nombre, direccion, correoe contras 
    use FiltrarTraitMatriz;

    public static function resumenCompra(){
        require_once('app/views/resumenCompra.php');
    }

    //una vez que se confirma el pago
    public static function procesarCarrito(){
        if(isset($_POST['compra']) && ($_POST['compra']!="")){

            $resumenCompra = json_decode($_POST['compra']);
            
            $carrito = json_decode($resumenCompra->carrito);
            $total_sinDescuento = $resumenCompra->total_sinDescuento;
            $total = $resumenCompra->total;
            $metodoPago = $resumenCompra->metodoPago;
            $descuento = $resumenCompra->descuento;

            $datosCompra = [
                'descuento'=>$descuento,
                'metodoPago'=>$metodoPago,
                'total_sinDescuento'=>$total_sinDescuento,
                'total'=>$total
            ];
            if($idCompra=CompraModel::nuevaCompra($datosCompra)){
                foreach ($carrito as $producto) {
                    if(!CompraModel::crearDetallesCompra($producto, $idCompra)){
                        $param['class']='error';
                        $param['msg']='Error al procesar los detalles de la compra';
                        require_once 'app/views/resumenCompra.php';
                    }
                }
                $param['class']='success';
                $param['msg']='Su compra ha sido realizada.';
                require_once 'app/views/successCompra.php';
            }else{
                $param['class']='error';
                $param['msg']='Error al procesar la compra';
                require_once 'app/views/resumenCompra.php';
            }
            

        }else{
            $param['class']='error';
            $param['msg']='Error al procesar la compra';
            require_once 'app/views/resumenCompra.php';
        }
    }


}