<?php 
ob_start();
?>
    <h2>Resumen de la compra</h2>
    <p>Si modificas el carro antes de confirmar la compra, actualiza la página primero</p>
    <div id="resumenCompra">
        <h2 id="resumenCompra_articulos">Articulos:</h2>
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
        <h3 class="h3">Método de pago</h3 class="h3">
        <span class="linea-flexStart">
            <input type="radio" name="pago" id="efectivo" checked>
            <label for="efectivo">Efectivo</label>
        </span>
        <span class="linea-flexStart">
            <input type="radio" name="pago" id="tarjeta">
            <label for="tarjeta">Tarjeta</label>
        </span>
        <span class="linea-flexStart">
            <input type="radio" name="pago" id="paypal">
            <label for="paypal">Pay-Pal</label>
        </span>
        <span class="linea-flexStart">
            <input type="radio" name="pago" id="favor">
            <label for="favor">Favores se****les</label>
        </span>
        <hr>
        <h3 class="h3">Descuentos</h3 class="h3">
        <span class="linea-flex">
            <label for="descuentos">Código promocional</label>
            <input type="text" name="codigo" id="descuentos">
        </span>
        <div class="linea-flex grande">
            <h4>Total: <h4 id="resumenCompra_displayPrecioTotal2" class="color"></h4></h4>
        </div>
        <input class="boton" id="botonFinal" type="submit" value="Confirmar compra">
    </div>
<?php 
$contenido = ob_get_clean();
include 'layouts/ly_login.php'; ?>
