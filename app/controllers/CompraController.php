<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
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
<<<<<<< HEAD
                self::mandarEmail($datosCompra,$carrito);

                
                
                
=======
                $param['class']='success';
                $param['msg']='Su compra ha sido realizada.';
                require_once 'app/views/successCompra.php';
>>>>>>> e57dd3efec2cd048f898da38dea3a5f7041364cc
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

<<<<<<< HEAD
    public static function mandarEmail($datosCompra,$carrito){
        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function

        //Create an instance; passing `true` enables exceptions
        

        try {
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Mailer = "smtp";
            $mail->CharSet = 'UTF-8';
            // $mail->SMTPDebug  = 1;  
            $mail->SMTPAuth   = TRUE;
            $mail->SMTPSecure = "tls";
            $mail->Port       = 587;
            $mail->Host       = "smtp.gmail.com";
            $mail->Username   = "namnameatstore@gmail.com";
            $mail->Password   = "qwerty123#";
            $mail->addAttachment('assets/tmp/Factura.pdf');
            $mail->IsHTML(true);
            $mail->AddAddress("namnameatstore@gmail.com", "recipient-name");
            $mail->SetFrom("namnameatstore@gmail.com", "ÑamÑamEatStore");
            $mail->AddReplyTo("namnameatstore@gmail.com", "ÑamÑamEatStore");
            $mail->AddCC("namnameatstore@gmail.com", "cc-recipient-name");
            $mail->Subject = "Confirmación del pedido";

            $content = Helpers::crearEmail($datosCompra,$carrito);

            $mail->MsgHTML($content); 
            if(!$mail->Send()) {
                $param['class']='error';
                $param['msg2']='Hubo un error al mandar el email.';
                require_once 'app/views/successCompra.php';

            } else {
                $param['datosCompra']=$datosCompra;
                $param['carrito']=$carrito;
                $param['class']='success2';
                $param['msg2']='Hemos mandado un email con la factura.';
                $param['class']='success2';
                $param['msg']='Su compra ha sido realizada.';
                require_once 'app/views/successCompra.php';
            }

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

=======
>>>>>>> e57dd3efec2cd048f898da38dea3a5f7041364cc

}