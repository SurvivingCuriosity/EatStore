
//===============================ACTUALIZAR PERFIL
//los inputs de ajax -> los vacio porque el autocompletado hace que actualize campos que no he rellenado
const inputsModificarPerfil = document.querySelectorAll(".compruebaContenido");
const inputCodigoDescuento = document.querySelector("#descuentos");
vaciaInputsModificarPerfil();
function vaciaInputsModificarPerfil(){
	//Vacio inputs (evitar errores por autocompletado)
	inputsModificarPerfil.forEach(i => {
		if(isInPage(i))
			i.value="";
	});
}
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
	

}

//===============================CODIGO PROMOCIONAL

//CODIGO PROMOCIONAL AJAX Y FIN DE COMPRA

if(isInPage(inputCodigoDescuento)){
	inputCodigoDescuento.addEventListener('input',checkCodigo);
}

let descuento=undefined;
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
			if(response){
				descuento=response*1;
				$("#ajaxDescuento").text('El código introducido tiene descuento del '+descuento+'%');
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
		let precioActual = carrito.precioTotal;
		let precioFinal = precioActual - ((precioActual*descuento)/100);
		carrito.precioTotalDescuento=precioFinal;
		$("#resumenCompra_displayPrecioTotal").text(precioFinal+"€");
		$("#resumenCompra_displayPrecioTotal2").text(precioFinal+"€");
	}else{
		carrito.precioTotalDescuento=carrito.precioTotal;
	}
}