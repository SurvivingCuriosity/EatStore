<?php 
ob_start();

?>
<?php isset($param['msg']) ? $msg=$param['msg'] : $msg="" ?>
<?php isset($param['class']) ? $class=$param['class'] : $class =""?>
    <p class="<?=$class?>"><?=$msg?></p>
    <h2>Resumen de la compra</h2>
    <p>Si modificas el carro antes de confirmar la compra, actualiza la página primero</p>
    <div id="resumenCompra">
        <h3 class="h3" id="resumenCompra_articulos">Articulos:</h3>
            <div class="grid4">
                <p class="cabeceraCarrito">Nombre</p>
                <p class="cabeceraCarrito">Precio</p>
                <p class="cabeceraCarrito">Cantidad</p>
                <p class="cabeceraCarrito">Total articulo</p>
            </div>
            <div class="linea-flex">
                <h4>Total: <h4 id="resumenCompra_displayPrecioTotal" class="color"></h4></h4>
            </div>
            <hr>
        
        <h3 class="h3">Descuentos</h3>
            <span class="linea-flex">
                <label for="descuentos">Código promocional</label>
                <input type="text" name="codigo" id="descuentos">
            </span>
            <p id="ajaxDescuento"></p>
            <button style="display:none;" id="botonAplicarDescuento" class="boton">Aplicar descuento</button>
        
        
        
            <h3 class="h3">Método de pago</h3>
            <span class="linea-flexStart">
                <input class="inputPago" type="radio" name="pago" id="efectivo" checked>
                <label for="efectivo">Efectivo</label>
            </span>
            <span class="linea-flexStart">
                <input class="inputPago" type="radio" name="pago" id="tarjeta">
                <label for="tarjeta">Tarjeta</label>
            </span>
            <span class="linea-flexStart">
                <input class="inputPago" type="radio" name="pago" id="paypal">
                <label for="paypal">Pay-Pal</label>
            </span>
            <hr>
            <div class="linea-flex grande">
                <h4>Total: <h4 id="resumenCompra_displayPrecioTotal2" class="color"></h4></h4>
            </div>
        <form action="index.php?ctl=procesarCarrito" method="post">
                <input id="hiddenResumenCompra" type="hidden" name="compra">
                <input  class="boton" id="botonFinal" type="submit" value="Confirmar compra">
        </form>
        
    </div>
<?php 
$contenido = ob_get_clean();
include 'layouts/ly_login.php'; ?>
