let carrito={
    'precioTotal':0,
    'precioTotalDescuento':0,
    'itemsTotal':0,
    'productos':[]
};
if(sessionStorage.getItem('carrito')){
    carrito=JSON.parse(sessionStorage.getItem('carrito'));
    pintaCarrito();
}

const divCarrito=document.querySelector("#productosEnCarrito");//utilizo jquyery
const botonesComprar = document.querySelectorAll(".botonComprar");
const botonVaciarCarrito = document.querySelector("#carrito_vaciar");

//listeners a botones eliminar y vaciar
if(isInPage(botonVaciarCarrito)) botonVaciarCarrito.addEventListener("click",vaciarCarrito);
botonesComprar.forEach(boton => {
	if(isInPage(boton)){
		boton.addEventListener("click",agregarAlCarrito);
	}
});

function agregarAlCarrito(e){
    const producto = JSON.parse(e.target.nextElementSibling.textContent);
    producto.cantidad=1;

    let repetido=false;
    if(carrito.productos.length>0){
        carrito.productos.forEach(productoEnCarrito => {
            if(productoEnCarrito.id==producto.id){
                repetido=true;
            }
        });
    }else{
        repetido=false;
    }

    if(repetido){
        carrito.productos.forEach(productoEnCarrito => {
            if(productoEnCarrito.id==producto.id){
                productoEnCarrito.cantidad++;
            }
        });
    }else{
        carrito.productos.push(producto);
    }
    pintaCarrito();
}

function eliminarProducto(e){
    //el boton de eliminar tiene id= e_4 siendo 4 el id del producto a eliminar
    let idEliminar=e.target.id+"";
    idEliminar=idEliminar.substr(2,idEliminar.length);

    carrito.productos.forEach(producto => {
        if(producto.id==idEliminar){
            producto.cantidad--;
            if(producto.cantidad==0){
                //elimina ese producto del carrito
                carrito.productos.splice(carrito.productos.findIndex(e => e.id == idEliminar),1);
            } 
        }
    });
    pintaCarrito();
}

function vaciarCarrito(){
    carrito.productos=[];
    pintaCarrito();
}

function getPrecioTotal(){
    let precioTotal=0;
    carrito.productos.forEach(producto => {
        precioTotal+=(producto.precio*producto.cantidad);
    });
    return precioTotal;
}

function getProductosTotales(){
    let productosTotales=0;
    carrito.productos.forEach(producto => {
        productosTotales+=producto.cantidad;
    });
    return productosTotales;
}

//recorre los elementos del carrito y los pinta en HTML
function pintaCarrito(){
    carrito.itemsTotal=getProductosTotales();
    carrito.precioTotal=getPrecioTotal();
    carrito.precioTotalDescuento=carrito.precioTotal;
    sessionStorage.setItem('carrito',JSON.stringify(carrito));
    $("#iconoCarritoCompleto").effect( "shake", {times:1,distance:5}, 100 );

    $("#productosEnCarrito").empty();
    carrito.productos.forEach(producto => {
        $("#productosEnCarrito").append(creaTarjetaProductoCarrito(producto));
    });
    $("#carrito_precioTotal").text(carrito.precioTotal);
    $("#itemsCarrito").text(carrito.itemsTotal);
    
    //una vez generados los botones de eliminar les agrego el listener
    let botonesEliminar = document.querySelectorAll(".botonEliminar");
	botonesEliminar.forEach(e => {
        if(isInPage(e))
		    e.addEventListener("click",eliminarProducto)
	});
}

function creaTarjetaProductoCarrito(producto){
	cadena = `
        <div id="${producto.nombre}" class="productoEnCarrito">
        <p class="nombre_producto_carrito">${producto.nombre}</p>
        <p class="precio_producto_carrito">${producto.precio}€</p>
        <p class="cantidad_producto_carrito">${producto.cantidad}</p>
        <p style="display:none;">${producto.id}</p>
        <button id="e_${producto.id}" class="boton botonEliminar">Eliminar</button>
        </div>
	`;
	return cadena;
}


