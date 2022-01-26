//AGREGAR CLASE ACTIVE A ENLACES
let enlacesNavegables=document.querySelectorAll(".enlaceNavegable");
enlacesNavegables.forEach(e => {
	e.addEventListener("click",ponClaseActive);
});
const enlacePlatos = document.querySelector("#enlacePlatos");
const enlaceCategorias = document.querySelector("#enlaceCategorias");

function ponClaseActive(){
	let cadena=window.location+"";
	cadena=cadena.substring(cadena.lastIndexOf("=")+1, cadena.length);
	switch(cadena){
		case "platos":
			if(!enlacePlatos.classList.contains("active")){
				enlacePlatos.classList.add("active");
			}
			enlaceCategorias.classList.remove("active");
			break;
		case "categorias":
			if(!enlaceCategorias.classList.contains("active")){
				enlaceCategorias.classList.add("active");
			}
			enlacePlatos.classList.remove("active");
			break;
	}
}

//FIN AGREGAR CLASE ACTIVE A ENLACES
//Desplegar opciones imagen perfil
function muestraOpcionesPerfil() {
	document.getElementById("myDropdown").classList.toggle("show");
}
function muestraCarrito() {
	document.getElementById("myDropdown2").classList.toggle("show");
}
  
window.onclick = function(e) {
	//userimg
	if (!e.target.matches('.dropbtn')) {
		let myDropdown = document.getElementById("myDropdown");
		//compruebo que el elemento existe (si no login, no está)
		if(myDropdown){
			if (myDropdown.classList.contains('show')) {
				myDropdown.classList.remove('show');
			}
		}
	}
	//carrito	
	if (!e.target.matches('.dropbtn2') && !e.target.matches('.botonEliminar') && !e.target.matches('.botonComprar') && !e.target.matches('#carrito_vaciar')) {
		let myDropdown = document.getElementById("myDropdown2");
		if(myDropdown){
			if (myDropdown.classList.contains('show')) {
				myDropdown.classList.remove('show');
			}
		}
	}	
}
//FinDesplegar opciones imagen perfil
//Eliminar mensajes tras 3 segundos
window.setTimeout(borraAlertasTemporales,3000);
function borraAlertasTemporales(){
	let mensajes = document.querySelectorAll(".warn, .error, .success");
	mensajes.forEach(m => {
		m.style.opacity=0;
	});
}
//FinEliminar mensajes tras 3 segundos
//Formulario editar perfil y AJAX
let datosPerfilUsuario = document.querySelectorAll(".dato");
datosPerfilUsuario.forEach(e => {
	e.addEventListener('click',toggleEditarValor);
});

let clickCounter=0;
function toggleEditarValor(e){
	clickCounter++;
	if (clickCounter==2){
		updatePerfil();
		clickCounter=0;
	}
	if(e.target.classList.contains('pass')){
		e.target.nextElementSibling.classList.toggle('desaparece');
		e.target.nextElementSibling.nextElementSibling.classList.toggle('desaparece');
		e.target.nextElementSibling.nextElementSibling.nextElementSibling.classList.toggle('desaparece');
	}else{
		e.target.nextElementSibling.nextElementSibling.classList.toggle('desaparece');
		e.target.nextElementSibling.classList.toggle('desaparece');
	}
}
//los inputs de ajax -> los vacio porque el autocompletado hace que actualize campos que no he rellenado
const inputs = document.querySelectorAll(".compruebaContenido");
inputs.forEach(i => {
	i.value="";
});

const updatePerfil = () =>{
	let nombre = $("#xnombre").val();
	let dni = $("#xdni").val();
	let direccion = $("#xdireccion").val();
	let correoe = $("#xcorreoe").val();
	let contras = $("#xpassword").val();
	let ccontras = $("#xcpassword").val();
	let correoactual = document.querySelector("#correoActual").textContent;

	const data = {
		'nombre' : nombre,
		'dni' : dni,
		'direccion' : direccion,
		'correoe' : correoe,
		'contras' : contras,
		'ccontras' : ccontras,
		'correoactual' : correoactual
	}

	$.ajax({
		data:  data, //datos que se envian a traves de ajax
		url:   'app/controllers/ajax/Updateuser_ajax.php', //archivo que recibe la peticion
		type:  'post', //método de envio
		beforeSend: function () {
				$("#resultadoajax").text("Procesando, espere por favor...");
		},
		success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
			//window.location.href = "index.php?ctl=perfil";
			$("#resultadoajax").text(response);
		}
	});
	
	//me aseguro de que ningun input tenga valor (suelen ser los autocompletados de los navegadores)
	inputs.forEach(i => {
		i.value="";
	});
}
const botonCerrarSesion = document.getElementById("botonCerrarSesion");
if(botonCerrarSesion)
	botonCerrarSesion.addEventListener("click",vaciaSessionStorage);
function vaciaSessionStorage(){
	alert("El carrito se vaciará");
	sessionStorage.removeItem('compra');
}
//Fin editar formulario y AJAX
$(function(){
	//vacio los inputs del formulario ajax
	inputs.forEach(i => {
		i.value="";
	});
	//pongo la clase active a productos o categorias en funcion de donde este
	ponClaseActive();
	//agrego listeners
	$(".botonComprar").on("click", agregarAlCarrito);
	$("#carrito_vaciar").on("click",vaciarCarrito);

	//recupero el carrito del session storage (compruebo que no está vacio ni es null)
	if(sessionStorage.getItem('compra')){
		let carroEnSesion = JSON.parse(sessionStorage.getItem('compra'));
		carroEnSesion.forEach(c => {
			let cadena = creaTarjetaProducto(c);
			$("#productosEnCarrito").append(cadena);
		});
		actualizarDatosCarrito();
	}
	//si estoy en la pagina de resume compra
	if($('#resumenCompra').length) {
		let carroEnSesion = JSON.parse(sessionStorage.getItem('compra'));
		carroEnSesion.forEach(c => {
			let cadena = creaTarjetaProductoParaCompra(c);
			$(".grid4").append(cadena);
		});
		$("#resumenCompra_displayPrecioTotal").append(getPrecioTotal()+"€");
		$("#resumenCompra_displayPrecioTotal2").append(getPrecioTotal()+"€");
	}
});

function vaciarCarrito(){
	$("#productosEnCarrito").empty();
	sessionStorage.removeItem('compra');
	actualizarDatosCarrito();
}

function eliminarProducto(e){
	productoAEliminar=getProducto(e.target.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.textContent);
	if(productoAEliminar){
		actualizaCantidad(productoAEliminar,'resta');
	} 
	actualizarDatosCarrito();

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

//devuelve un array con los productos del carrito
function getProductosEnCarrito(){
	let productos = new Array();
	$(".productoEnCarrito").each(function(index){
		let producto={
			'nombre':this.children[0].textContent,
			'precio':this.children[1].textContent.slice(0,-1), //slice quita el '€'
			'cantidad':this.children[2].textContent,
			'id':this.children[3].textContent,
		}
		productos.push(producto)
	});
	return productos;
}

//devuelve un producto segun su nombre
function getProducto(nombre){
	let producto;
	$(".productoEnCarrito").each(function(index){
		if(this.children[0].textContent==nombre){
			producto={
				'nombre':this.children[0].textContent,
				'precio':this.children[1].textContent.slice(0,-1), //slice quita el '€'
				'cantidad':this.children[2].textContent
			}
		}
	});
	return producto;
}

function getPrecioTotal(){
	let productosCarrito=getProductosEnCarrito();
	precioPorCantidad=0;
	precioTotal=0;
	productosCarrito.forEach(e => {
		precioPorCantidad = (e.precio*1) * (e.cantidad*1);
		precioTotal+=precioPorCantidad;
	});
	return precioTotal;
}
let productosTotales=0;
let precioTotal=0;

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
	<p style="display:none;">${producto.id}</p>
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
	<p style="display:none;" class="cantidad_producto_carrito">${producto.id}</p>
	<p class="cantidad_producto_carrito">${precioTotalArticulo}€</p>
	`;
	
	return cadena;
}

function obtenerJSONCompra(){
	return JSON.stringify(getProductosEnCarrito());
}


//CODIGO PROMOCIONAL AJAX Y FIN DE COMPRA
const inputCodigoDescuento = document.querySelector("#descuentos");
if(inputCodigoDescuento)
inputCodigoDescuento.addEventListener('input',checkCodigo);

let descuento=0;
function checkCodigo(){
	let codigo = inputCodigoDescuento.value;

	const data = {
		'codigo' : codigo,
	}

	$.ajax({
		data:  data, //datos que se envian a traves de ajax
		url:   'app/controllers/ajax/checkDescuento_ajax.php', //archivo que recibe la peticion
		type:  'post', //método de envio
		beforeSend: function () {
				$("#ajaxDescuento").text("El código introducido no tiene descuento");
		},
		success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
			//window.location.href = "index.php?ctl=perfil";
			descuento=response;
			if(response){
				$("#ajaxDescuento").text('El código introducido tiene descuento del '+response+'%');
				$("#botonAplicarDescuento").css('display','block');
			}else{
				descuento=0;
				$("#ajaxDescuento").text('El código introducido no tiene descuento');
				$("#botonAplicarDescuento").css('display','none');
			}
			
		}
	});
}
$("#botonAplicarDescuento").click(hazDescuento);
function hazDescuento(){
	if(descuento!=0){
		let precioActual = getPrecioTotal();
		let precioFinal = precioActual - ((precioActual*descuento)/100);
		$("#resumenCompra_displayPrecioTotal").text(precioFinal+"€");
		$("#resumenCompra_displayPrecioTotal2").text(precioFinal+"€");
	}
}

$("#botonFinal").click(procesarCompra);
function procesarCompra(){
	let precioFinal = getPrecioTotal() - ((getPrecioTotal()*descuento)/100);
	let radiosPago = document.querySelectorAll(".inputPago");
	let metodoPago="";
	radiosPago.forEach(radio => {
		if(radio.checked){
			metodoPago=radio.id;
		}
	});
	const datosCompra = {
		'carrito' : JSON.stringify(getProductosEnCarrito()),
		'total_sinDescuento' : getPrecioTotal(),
		'total' : precioFinal,
		'descuento' : descuento,
		'metodoPago' : metodoPago
	}
	$("#hiddenResumenCompra").val(JSON.stringify(datosCompra));
}