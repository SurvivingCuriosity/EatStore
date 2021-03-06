
if(isInPage(document.querySelector("#resumenCompra"))){
    carrito.productos.forEach(producto => {
        $(".grid4").append(creaTarjetaProductoParaCompra(producto));
    });
    $("#resumenCompra_displayPrecioTotal").text(carrito.precioTotal+"€");
    $("#resumenCompra_displayPrecioTotal2").text(carrito.precioTotal+"€");
}

//cuando termina el pago de paypal (satisfactoriamente) se ejecuta esta funcion
function procesarCompra(){
	let radiosPago = document.querySelectorAll(".inputPago");
	let metodoPago="";
	radiosPago.forEach(radio => {
		if(radio.checked){
			metodoPago=radio.id;
		}
	});
	if(!descuento) descuento=0;
	const datosCompra = {
		'carrito' : JSON.stringify(carrito.productos),
		'total_sinDescuento' : carrito.precioTotal,
		'total' : carrito.precioTotalDescuento,
		'descuento' : descuento,
		'metodoPago' : metodoPago
	}
	console.log(JSON.stringify(datosCompra));
	
	$("#hiddenResumenCompra").val(JSON.stringify(datosCompra));
}

function creaTarjetaProductoParaCompra(producto){
	let precioTotalArticulo= (producto.precio*1)*(producto.cantidad*1);
	cadena = `
	<p class="nombre_producto_carrito">${producto.nombre}</p>
	<p class="precio_producto_carrito">${producto.precio}€</p>
	<p class="cantidad_producto_carrito">${producto.cantidad}</p>
	<p style="display:none;" class="cantidad_producto_carrito">${producto.id}</p>
	<p class="cantidad_producto_carrito">${precioTotalArticulo}€</p>
	`;
	
	return cadena;
}