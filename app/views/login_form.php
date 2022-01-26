<?php 
ob_start();
?>
    <?php isset($param['msg']) ? $msg=$param['msg'] : $msg="" ?>
    <?php isset($param['class']) ? $class=$param['class'] : $class =""?>
    <?php isset($param['correoe']) ? $correo=$param['correoe'] : $correo =""?>
    
    <h1 id="welcome_titulo"><?=Config::$titulo?></h1>
            <p>No tenemos miedo a tus antojos...¡Lo tenemos!</p>
            <p>Échale un vistazo a nuestros <a class="color" href="index.php?ctl=verPlatos">platos.</a></p>
        <!-- FORMULARIO LOGIN -->
    <form id="formLogin" action="index.php?ctl=checkLogin" method="POST" autocomplete="off">
        <span class="linea-flex">
            <input type="email" name="correoe" id="l_correoe" placeholder="Introduce el e-mail" value="<?=$correo?>">
        </span>
        <span class="linea-flex">
            <input type="password" name="password" id="l_password" placeholder="Introduce la contraseña">
        </span>
        <input class="boton" type="submit" value="Iniciar sesión">
    </form>
    <p>¿Aún no tienes cuenta? <a class="color" href="index.php?ctl=verRegistro">Registrate</a></p>
    <p class="<?=$class?>"><?=$msg?></p>
<?php 
$contenido = ob_get_clean();
include 'layouts/welcome.php'; ?>
