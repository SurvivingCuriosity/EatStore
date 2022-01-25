//{ls:true, jq:true, }
function Carrito (configuracion) {
	const {iconoCarrito=undefined, ls=false, jq=false, titulo='Carrito de la compra'} = configuracion;
	if(!!iconoCarrito){
		console.error("ID del icono del carrito REQUERIDO");
		return null;
	}
    this.pedido = [];
	this.iconoCarrito=iconoCarrito;
	this.ls=ls;
	this.jq=jq;
	this.titulo=titulo;
	this.inicializarCarrito();
}

function muestraCarrito() {
	document.getElementById(this.iconoCarrito).classList.toggle("show");
}

function vaciarCarrito(){
	pedido=[];
	pintaHTML();
	// $("#productosEnCarrito").empty();
	// sessionStorage.removeItem('compra');
	// actualizarDatosCarrito();
}

function eliminarProducto(e){
	productoAEliminar=getProducto(e.target.previousElementSibling.previousElementSibling.previousElementSibling.textContent);
	if(productoAEliminar){
		// actualizaCantidad(productoAEliminar,'resta');
		productoAEliminar.cantidad--;
	} 
	// actualizarDatosCarrito();
	pintaHTML();

}

function actualizarDatosCarrito(){
	precioTotal=0;
	productosTotales=0;
	productosCarrito=getProductosEnCarrito();
	if(productosCarrito.length==0){
		precioTotal=0;
		productosTotales=0;
	}else{
		productosCarrito.forEach(e => {
			precioPorCantidad = e.precio*1 * e.cantidad*1;
			precioTotal+=precioPorCantidad;
			productosTotales+=e.cantidad*1;
		});
	}
	$("#carrito_precioTotal").text(precioTotal);
	$("#itemsCarrito").text(productosTotales);
	
	sessionStorage.setItem('compra',JSON.stringify(productosCarrito));
	let botonesEliminar = document.querySelectorAll(".botonEliminar");
	botonesEliminar.forEach(e => {
		e.addEventListener("click",eliminarProducto)
	});
}

function actualizaCantidad(producto,accion){
	console.log("actualizando cantidad");
	let cantidadActual;
	switch(accion){
		case 'suma':
			cantidadActual= getProducto(producto.nombre).cantidad;
			cantidadActual++;
			document.getElementById(producto.nombre).firstChild.nextElementSibling.nextElementSibling.nextElementSibling.textContent=cantidadActual;
			break;
			case 'resta':
				cantidadActual= getProducto(producto.nombre).cantidad;
				cantidadActual=cantidadActual-1;
				if(cantidadActual==0){
					document.getElementById(producto.nombre).remove();
			}else{
				document.getElementById(producto.nombre).firstChild.nextElementSibling.nextElementSibling.nextElementSibling.textContent=cantidadActual;
			}
		}
}

function creaTarjetaProducto(producto){
	cadena = `
	<div id="${producto.nombre}" class="productoEnCarrito">
	<p class="nombre_producto_carrito">${producto.nombre}</p>
	<p class="precio_producto_carrito">${producto.precio}€</p>
	<p class="cantidad_producto_carrito">${producto.cantidad}</p>
	<button class="boton botonEliminar">Eliminar</button>
	</div>
	`;
	return cadena;
}

function creaTarjetaProductoParaCompra(producto){
	let precioTotalArticulo= (producto.precio*1)*(producto.cantidad*1);
	cadena = `
	<p class="nombre_producto_carrito">${producto.nombre}</p>
	<p class="precio_producto_carrito">${producto.precio}€</p>
	<p class="cantidad_producto_carrito">${producto.cantidad}</p>
	<p class="cantidad_producto_carrito">${precioTotalArticulo}€</p>
	`;
	
	return cadena;
}

Carrito.prototype.inicializarCarrito=function(){
	if(this.ls){
		this.pedido = JSON.parse(sessionStorage.getItem('compra')) || [];
	}

	const div= document.createElement("div");
	div.innerHTML=`
	<div id="cabecerasCarrito">
		<p class="cabeceraCarrito">Nombre</p>
		<p class="cabeceraCarrito">Precio</p>
		<p class="cabeceraCarrito">Cantidad</p>
	</div>
	<div id="productosEnCarrito">

	</div>
	<hr class="hrnegro">
	<span class="linea-flexCentro">
		<p class="cabeceraCarrito">Total: <p id="carrito_precioTotal">0</p>€</p>
		<a id="carrito_vaciar" class="botonCarro">Vaciar carrito</a>
		<a class="botonCarro" href="index.php?ctl=resumenCompra">Procesar compra</a>
	</span>`;

	div.id="carrito";
	document.body.appendChild(div);

	if(this.jq) {
		//el modal del carrito con jquery
	}
}

Carrito.prototype.anadirProducto = function (){

}



//se lanza al dar a un boton de comprar
function agregarAlCarrito(e){
	//efecto visual
	$("#iconoCarritoCompleto").effect( "shake", {times:1,distance:5}, 100 );
	
	//obtengo el producto
	const productoAAgregar = JSON.parse(e.target.nextElementSibling.textContent);
	let repetido;
	let productosEnCarrito = getProductosEnCarrito();

	//console.log(productosEnCarrito);
	if(productosEnCarrito.length==0){
		repetido=false;
	}else{
		for (let i = 0; i < productosEnCarrito.length; i++) {
			const productoEnCarrito = productosEnCarrito[i];
			if(productoEnCarrito.nombre==productoAAgregar.nombre){
				repetido=true;
			}
			if(repetido) continue;
		}
	}
	
	if(repetido){
		actualizaCantidad(productoAAgregar,'suma');
	}else{
		productoAAgregar.cantidad=1;
		let cadena = creaTarjetaProducto(productoAAgregar);
		$("#productosEnCarrito").append(cadena);
	}
	actualizarDatosCarrito();
}


function obtenerJSONCompra(){
	return JSON.stringify(getProductosEnCarrito());
}

function pintaHTML(){
	pedido.forEach(productoEnCarrito => {
		$("#productosEnCarrito").append(creaTarjetaProducto(productoEnCarrito));
	});
}