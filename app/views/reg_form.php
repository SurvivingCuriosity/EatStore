<?php 
ob_start();
?>

    <?php isset($param['msg']) ? $msg=$param['msg'] : $msg="" ?>
    <?php isset($param['class']) ? $class=$param['class'] : $class =""?>
    
    <?php isset($param['nombre']) ? $nombre=$param['nombre'] : $nombre =""?>
    <?php isset($param['direccion']) ? $direccion=$param['direccion'] : $direccion =""?>
    <?php isset($param['dni']) ? $dni=$param['dni'] : $dni =""?>
    <?php isset($param['correoe']) ? $correoe=$param['correoe'] : $correoe =""?>

    <p class="<?=$class?>"><?=$msg?></p>
    <h1 id="welcome_titulo"><?=Config::$titulo?></h1>
        <!-- FORMULARIO REGISTRO -->
    <form id="formularioRegistro" action="index.php?ctl=registro" method="POST" autocomplete="off">
        <span class="linea-flex">
            <label for="dni">DNI:</label>
            <input type="text" name="dni" id="dni" placeholder="Introduce el DNI" value="<?=$dni?>">
        </span>
        <span class="linea-flex">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Introduce el nombre" value="<?=$nombre?>">
        </span>
        <span class="linea-flex">
            <label for="direccion">Direccion:</label>
            <input type="text" name="direccion" id="direccion" placeholder="Introduce la dirección" value="<?=$direccion?>">
        </span>
        <span class="linea-flex">
            <label for="correoe">Email:</label>
            <input type="email" name="correoe" id="correoe" placeholder="Introduce el e-mail" value="<?=$correoe?>">
        </span>
        <span class="linea-flex">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" placeholder="Introduce la contraseña">
        </span>
        <span class="linea-flex">
            <label for="cpassword">Confirmar contraseña:</label>
            <input type="password" name="cpassword" id="cpassword" placeholder="Introduce la contraseña">
        </span>
        <input class="boton" type="submit" value="Registrarme">
        <p>¿Ya tienes cuenta?<a class="color" href="index.php?ctl=verFormLogin">Inicia sesión</a></p>
    </form>
<?php 
$contenido = ob_get_clean();
include 'layouts/welcome.php'; ?>
