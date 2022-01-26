//el funcionamiento es muy sencillo:
//interactuar con el slider modifica el valor de las variables minimo y maximo
//getCategoriasPermitidas obtiene qué categorias estan seleccionadas

//mover el slider e interactuar con los checkboxes llama a filtrarProductos, funcion que muestra los productos
//que coinciden con minimo, maximo y las categorias que devuelve getCategoriasPermitidas
const checkBoxesFiltros = document.querySelectorAll(".checkFiltros");
const contenedorProductos = document.querySelector(".productsContainerTodos");
const botonResetFiltros = document.querySelector("#resetFiltros");
if(isInPage(botonResetFiltros)){
    botonResetFiltros.addEventListener("click",resetFiltros);
}
function resetFiltros(e){
    e.preventDefault();
    checkBoxesFiltros.forEach(e => {
        e.checked=true;
    });
    $( "#rangeSlider" ).slider( "values", [$("#precioMin").text()*1,$("#precioMax").text()*1] );
    $("#textoSlider").text($('#rangeSlider').slider('values',0)+"-"+$('#rangeSlider').slider('values',1));
        minimo = Number($('#rangeSlider').slider('values',0));
        maximo = Number($('#rangeSlider').slider('values',1));
    filtraProductos();
}
let minimo =$("#precioMin").text()*1;//se corresponde con el menor precio de los productos de la bbdd
let maximo= $("#precioMax").text()*1;

checkBoxesFiltros.forEach(e => {
    e.checked=true;
});
checkBoxesFiltros.forEach(e => {
    if(isInPage(e)){
        e.addEventListener("change",filtraProductos);
    }
});


function getCategoriasPermitidas(){
    let categoriasAMostrar=new Array();
    checkBoxesFiltros.forEach(e => {
        if(e.checked){
            categoriasAMostrar.push(e.value);
        }
    });
    return categoriasAMostrar;
}

function filtraProductos(){
    let productos = contenedorProductos.children;

    for (let e = 0; e < productos.length; e++) {
        const producto = productos[e];
        let precioProducto = producto.firstElementChild.nextElementSibling.nextElementSibling.firstElementChild.textContent;
        precioProducto = precioProducto.slice(0,-1)*1;

        let categoria = producto.classList;
        categoria.remove('producto');
        //categoria=categoria del producto
        categoria=categoria.value;

        if(precioProducto>=minimo && precioProducto<=maximo && getCategoriasPermitidas().includes(categoria)){
            producto.style.display="flex";
            producto.classList.add("producto");
        }else{
            producto.style.display="none";
        }
        
        let hayProductos=false;
        for (let e = 0; e < productos.length; e++) {
            const pro = productos[e];
            if(pro.style.display!="none"){
                hayProductos=true;
            }
        }
        if(!hayProductos){
            $("#infoFiltros").text("Ningun elemento coincide con los filtros");
        }else{
            $("#infoFiltros").text("");
        }
    }
}

if($("#rangeSlider").length){
    let precioMinimo = $("#precioMin").text()*1;
    let precioMaximo = $("#precioMax").text()*1;
    $("#rangeSlider").slider({
        min: precioMinimo,
        max: precioMaximo,
        step:1,
        values: [precioMinimo,precioMaximo],
        range:true,
        slide: function (){
            $("#textoSlider").text($('#rangeSlider').slider('values',0)+"-"+$('#rangeSlider').slider('values',1));
            minimo = Number($('#rangeSlider').slider('values',0));
            maximo = Number($('#rangeSlider').slider('values',1));
            filtraProductos();
        }
    });
}

function isInPage(node) {
    return (node === document.body) ? false : document.body.contains(node);
}