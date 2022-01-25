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
		m.style.visibility="hidden";
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
		url:   'app/controllers/Updateuser_ajax.php', //archivo que recibe la peticion
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

//Fin editar formulario y AJAX
$(function(){
	carrito = new carrito({iconoCarrito:'myDropdown2',ls:true,jq:true,titulo:'Carrito'});
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
	if(sessionStorage.getItem('compra')!="" && sessionStorage.getItem('compra')!=null ){
		let carroEnSesion = JSON.parse(sessionStorage.getItem('compra'));
		carroEnSesion.forEach(c => {
			let cadena = creaTarjetaProducto(c);
			$("#productosEnCarrito").append(cadena);
		});
		actualizarDatosCarrito();
	}
	//si estoy en la pagina de resumen compra
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

//devuelve un array con los productos del carrito
function getProductosEnCarrito(){
	let productos = new Array();
	$(".productoEnCarrito").each(function(index){
		let producto={
			'nombre':this.children[0].textContent,
			'precio':this.children[1].textContent.slice(0,-1), //slice quita el '€'
			'cantidad':this.children[2].textContent
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


