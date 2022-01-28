<?php 
ob_start();
<<<<<<< HEAD
    isset($param['carrito']) ? $carrito=$param['carrito'] : $carrito="";
    isset($param['datosCompra']) ? $datosCompra=$param['datosCompra'] : $datosCompra ="";
    isset($param['msg']) ? $msg=$param['msg'] : $msg="";
    isset($param['msg2']) ? $msg2=$param['msg2'] : $msg2="";
    isset($param['class']) ? $class=$param['class'] : $class ="";
?>
    <h2 class="color">Compra realizada</h2>
    <p class="<?=$class?>"><?=$msg?></p>
    <p class="<?=$class?>"><?=$msg2?></p>
        <?php
            // reference the Dompdf namespace
            use Dompdf\Dompdf;

            // instantiate and use the dompdf class
            $dompdf = new Dompdf();

            $dompdf->loadHtml(Helpers::crearFactura($datosCompra,$carrito));

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            $output = $dompdf->output();

            file_put_contents('assets/tmp/Factura.pdf', $output);

            ?>
            <iframe src="assets/tmp/Factura.pdf#view=fit" frameborder="0"></iframe>
        
        <form action="index.php?ctl=descargarFactura" method="post">
            <input type="hidden" name="cadenaFactura" value="<?=Helpers::crearFactura($datosCompra,$carrito)?>">
            <input class="boton" type="submit" value="Descargar factura">
        </form>

=======
?>
    <h2>Compra realizada</h2>
>>>>>>> e57dd3efec2cd048f898da38dea3a5f7041364cc
<?php 
$contenido = ob_get_clean();
include 'layouts/ly_login.php'; ?>
