//enlaces del nav
const enlacesNavegables=document.querySelectorAll(".enlaceNavegable");
const enlacePlatos = document.querySelector("#enlacePlatos");
const enlaceCategorias = document.querySelector("#enlaceCategorias");
const enlaceApi = document.querySelector("#enlaceApi");
//iconos topnav
const topnav_iconoPerfil = document.getElementById("myDropdown");
const botonCerrarSesion = document.getElementById("botonCerrarSesion");
const topnav_iconoCarrito = document.getElementById("myDropdown2");
//mensajes de alerta
const mensajes = document.querySelectorAll(".warn, .error, .success");
const datosPerfilUsuario = document.querySelectorAll(".dato");

window.addEventListener('DOMContentLoaded',init);
function init(){
	ponClaseActive();

	borraAlertasTemporales();


	//quito autocompletado
	// $("input").val("");
}

function ponClaseActive(){
	let cadena=window.location+"";
	cadena=cadena.substring(cadena.lastIndexOf("=")+1, cadena.length);
	switch(cadena){
		case "verPlatos":
			if(!enlacePlatos.classList.contains("active")){
				enlacePlatos.classList.add("active");
			}
			enlaceCategorias.classList.remove("active");
			break;
		case "verCategorias":
			if(!enlaceCategorias.classList.contains("active")){
				enlaceCategorias.classList.add("active");
			}
			enlacePlatos.classList.remove("active");
			break;
		case "verDocapi":
			if(!enlaceApi.classList.contains("active")){
				enlaceApi.classList.add("active");
			}
			enlacePlatos.classList.remove("active");
			break;
	}
}

function muestraOpcionesPerfil() {
	topnav_iconoPerfil.classList.toggle("show");
}
function muestraCarrito() {
	topnav_iconoCarrito.classList.toggle("show");
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

function borraAlertasTemporales(){
	window.setTimeout(()=>{
		mensajes.forEach(m => {
			m.style.opacity=0;
		});
	},3000);
}



//Formulario editar perfil

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

function isInPage(node) {
    return (node === document.body) ? false : document.body.contains(node);
}