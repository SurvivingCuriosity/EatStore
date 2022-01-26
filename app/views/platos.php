<?php 
ob_start();
?>

    <?php include("parts/filtros.php")?>

    <div class="productsContainerTodos">
    <?php 
        foreach ($platos as $plato) { ?>
            <div class="producto <?=$plato['categoria']?>">
            <a class="producto_categoria <?=$plato['categoria']?>" href="index.php?ctl=verCategorias#<?=$plato['categoria']?>"><?=$plato['categoria']?></a>
                <div class="producto_div_info_foto">
                    <div>
                        <span style="display:none;"><?=$plato['id']?></span>
                        <h4 class="producto_nombre"><?=$plato['nombre']?></h4>
                        <p class="producto_descripcion"><?=$plato['descripcion']?></p>
                    </div>
                    <img src="<?=Config::$rutaIMG?>platos/default.png" alt="Icono comida" style="width:70px; height:70px;">
                </div>
                <div class="linea-flex">
                    <h4 class="producto_precio"><?=$plato['precio'].'€'?></h4>
                    <?php 
                        if(isset($_SESSION['nombre'])){?>
                            <button class="boton botonComprar">Añadir</button>
                        <?php }
                    ?>
                    <p id="json_plato" style="display:none;"><?=$plato['json']?></p>
                </div>
            </div>
       <?php }
    ?>
    </div>
    

<?php 
$contenido = ob_get_clean();
include 'layouts/ly_login.php'; ?>
