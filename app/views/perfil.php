<?php ob_start();?>
<?php isset($param['msg']) ? $msg=$param['msg'] : $msg="" ?>
<?php isset($param['class']) ? $class=$param['class'] : $class =""?>

<?php isset($param['nombre']) ? $nombre=$param['nombre'] : $nombre =""?>
<?php isset($param['direccion']) ? $direccion=$param['direccion'] : $direccion =""?>
<?php isset($param['dni']) ? $dni=$param['dni'] : $dni =""?>
<?php isset($param['correoe']) ? $correoe=$param['correoe'] : $correoe =""?>

<div class="miPerfil">
    <h2>MI PERFIL</h2>
        
        <span class="linea-flexStart">
            <label for="dni">DNI:</label>
            <p class="color"><?=$datosActuales['dni']?></p>
        </span>
        <span class="linea-flexStart">
            <label for="nombre">Nombre:</label>
            <p class="color"><?=$datosActuales['nombre']?></p>
        </span>
        <span class="linea-flexStart">
            <label for="direccion">Direccion:</label>
            <p class="color"><?=$datosActuales['direccion']?></p>
        </span>
        <span class="linea-flexStart">
            <label for="correoe">Email:</label>
            <p id="correoActual" class="color"><?=$datosActuales['correoe']?></p>
        </span>
        <span class="linea-flexStart">
            <label for="password">Contraseña:</label>
            <p class="color">*************</p>
        </span>


        <hr>
        <h2>EDITAR MIS DATOS</h2>
        <p>Haz click sobre 'Cambiar DNI' para cambiar el DNI.</p>
        <p>Vuelve a hacer click para cambiar el valor.</p>
        <br><br>
        <form id="ajaxform" action="index.php?ctl=updatePerfil" method="POST" autocomplete="off">
                <span class="linea-flexStart">
                    <label class="dato" for="dni">Cambiar DNI:</label>
                    <p class="color"><?=$datosActuales['dni']?></p>
                    <input class="compruebaContenido desaparece" type="text" name="dni" id="xdni" placeholder="Introduce el nuevo DNI">
                </span>
                <span class="linea-flexStart">
                    <label class="dato" for="nombre">Cambiar nombre:</label>
                    <p class="color"><?=$datosActuales['nombre']?></p>
                    <input class="compruebaContenido desaparece" type="text" name="nombre" id="xnombre" placeholder="Introduce el nuevo nombre">
                </span>
                <span class="linea-flexStart">
                    <label class="dato" for="direccion">Cambiar direccion:</label>
                    <p class="color"><?=$datosActuales['direccion']?></p>
                    <input class="compruebaContenido desaparece" type="text" name="direccion" id="xdireccion" placeholder="Introduce la nueva dirección">
                </span>
                <span class="linea-flexStart">
                    <label class="dato" for="correoe">Cambiar email:</label>
                    <p id="correoActual" class="color"><?=$datosActuales['correoe']?></p>
                    <input autocomplete="off" class="compruebaContenido desaparece" type="email" name="correoe" id="xcorreoe" placeholder="Introduce el nuevo e-mail">
                    <input type="hidden" name="correoe" id="correoActual" value="<?=$correoe?>">
                </span>
                <span class="linea-flexStart">
                    <label class="dato pass" for="password">Cambiar contraseña:</label>
                    <p class="color">*************</p>
                    <input autocomplete="off" class="compruebaContenido desaparece" type="password" name="password" id="xpassword" placeholder="Introduce la nueva contraseña">
                    <input autocomplete="off" class="compruebaContenido desaparece" type="password" name="cpassword" id="xcpassword" placeholder="Repite la nueva contraseña">
                </span>
            </form>
            <p class="warn2" id="resultadoajax"></p>
            <a class="rojo" href="index.php?ctl=borrarCuenta&correoe=<?=$_SESSION["correoe"]?>">Eliminar mi cuenta</a>
            <hr>
            <p>Debes actualizar la pagina para observar los cambios.</p>
</div>
    

<?php 
$contenido = ob_get_clean();
include 'layouts/ly_login.php'; ?>
