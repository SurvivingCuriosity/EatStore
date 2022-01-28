<?php 
ob_start();

?>
<?php isset($param['msg']) ? $msg=$param['msg'] : $msg="" ?>
<?php isset($param['class']) ? $class=$param['class'] : $class =""?>
    <script src="https://www.paypal.com/sdk/js?client-id=AQ4KPhOB9BAylqYDuTLSDJ5TjmmupvJl7Y6Lz4u64MGgMmh30LV_VcZlVD1uH72CyhdckJXe5BkbyfY2&currency=USD"></script>
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


        <div style="width:60%; font-size:0.8em;" id="paypal-button-container"></div>

        <script>
            paypal.Buttons({
                // Sets up the transaction when a payment button is clicked
                createOrder: function(data, actions) {
                    return actions.order.create({
                    purchase_units: [{
                        amount: {
<<<<<<< HEAD
                            value: carrito.precioTotalDescuento
=======
                        value: carrito.precioTotalDescuento // Can reference variables or functions. Example: `value: document.getElementById('...').value`
>>>>>>> e57dd3efec2cd048f898da38dea3a5f7041364cc
                        }
                    }]
                    });
                },
                // Finalize the transaction after payer approval
                onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    let transaction = orderData.purchase_units[0].payments.captures[0];
<<<<<<< HEAD
                    
                    procesarCompra();
                    vaciarCarrito();
                    
=======
                    vaciarCarrito();
                    procesarCompra();
>>>>>>> e57dd3efec2cd048f898da38dea3a5f7041364cc
                    document.querySelector("#botonFinal").click();
                });
                },
                onCancel: function (data) {
<<<<<<< HEAD
                    document.querySelector("#infoResultadoPaypal").classList.add("error");
                    document.querySelector("#infoResultadoPaypal").textContent="Has cancelado la compra";
                }
            }).render('#paypal-button-container');
        </script>
        <p id="infoResultadoPaypal"></p>
=======
                    // Show a cancel page, or return to cart
                }
            }).render('#paypal-button-container');
        </script>
        
>>>>>>> e57dd3efec2cd048f898da38dea3a5f7041364cc
        <!-- Una vez que se ha pagado, se envía este formulario para guardar los datos en bbdd -->
        <form style="display:none;" id="formPago" action="index.php?ctl=confirmarCompra" method="post">
            <input id="hiddenResumenCompra" type="hidden" name="compra">
            <input  class="boton" id="botonFinal" type="submit" value="Pagar">
        </form>
        
        </div>
<?php 
$contenido = ob_get_clean();
include 'layouts/ly_login.php'; ?>
