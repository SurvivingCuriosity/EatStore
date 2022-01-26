<?php ob_start();?>
    <h2><?=Config::$titulo?> Api</h2>
    <hr>
    <?php 
        if(isset($_SESSION["nombre"])){
    ?>
    <ul id="listaDocApi">
        <li><span class="color">GET:</span> Todos los platos</li>
        <p>http://localhost/eatstore/api/v1/platos</p>
        <li><span class="color">GET:</span> Un plato</li>
        <p>http://localhost/eatstore/api/v1/platos/3</p>
        <li><span class="color">GET:</span> Un plato de una categoría, en orden</li>
        <p>http://localhost/eatstore/api/v1/platos?categoria=$categoria&orden=DESC</p>
        <li><span class="color">POST:</span> Insertar un plato (sin imagen)</li>
        <p>http://localhost/eatstore/api/v1/platos</p>
        <li><span class="color">POST:</span> Insertar la imagen de un plato</li>
        <p>http://localhost/eatstore/api/v1/platos/4</p>
        <li><span class="color">PUT:</span> Actualizar un plato existente</li>
        <p>http://localhost/eatstore/api/v1/platos/3</p>
        <li><span class="color">DELETE:</span> Eliminar un plato existente</li>
        <p>http://localhost/eatstore/api/v1/platos/3</p>
    </ul>
    <?php } else{
        $redirect = Config::$host;
        $carpeta = Config::$carpeta;
        header("Location: app/views/errors/403.php");
    }?>
<?php 
$contenido = ob_get_clean();
include 'layouts/ly_login.php'; ?>
