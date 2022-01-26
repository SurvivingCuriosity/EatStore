<?php
//EXCEPCIONALMENTE ESTA PAGINA NO UTILIZA NINGUN MODELO, CONTROLADOR NI VARIABLE GLOBAL (NO HE SIDO CAPAZ)
//LA CONEXION A LA BASE DE DATOS SE REALIZA EN ESTA PAGINA Y ESTAN DEFINIDAS OTRA VEZ LAS VARIABLES DE CONEXION
//OJO AL CAMBIARLAS
    if(!$_POST['nombre']==""){
        updateCampo('nombre',$_POST['nombre']);
    }

    if(!$_POST['dni']==""){
        if (dniValido($_POST['dni'])){
            if(campoNoRepetido('dni','cliente', $_POST['dni'])){
                updateCampo('dni',$_POST['dni']);
            }else{
                echo "Error: DNI existente";
            }
        }else{
            echo "Error: DNI no válido";
        }
    }

    if(!$_POST['correoe']==""){
        if(campoNoRepetido('correoe','cliente', $_POST['correoe'])){
            updateCampo('correoe',$_POST['correoe']);
        }else{
            echo "Error: E-mail existente";
        }
    }

    if(!$_POST['direccion']==""){
        updateCampo('direccion',$_POST['direccion']);
    }

    if(!$_POST['contras']==""){
        if($_POST['contras']==$_POST['ccontras']){
            $error_clave="";
            if(contraValida($_POST['contras'],$error_clave)){
                updateCampo('direccion',$_POST['direccion']);
            }else{
                echo $error_clave;
            }
        }else{
            echo "Las contraseñas no coinciden";
        }
    }

    function updateCampo($campo,$nuevoValor){
        $host="localhost";
        $database="eatstore";
        $port="3306";
        $charset="utf8mb4";
        $username="root";
        $password="";
        try {           
            $conexion = new PDO('mysql:host=' . $host. ';dbname=' . $database . ';port=' . $port . ';charset=' . $charset, $username, $password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
            try {
                $correo = $_POST['correoactual'];
                $sql = "UPDATE cliente SET $campo='$nuevoValor' WHERE correoe='$correo'";
                //$sql = "UPDATE cliente SET dni='a' WHERE correoe=':correo'";
                $stmt=  $conexion->prepare($sql);
                $resultado=$stmt->execute();
                if($resultado){
                    $_SESSION[$campo]=$nuevoValor;

                    $respuesta= ucwords($campo)." actualizado.";
                    //$respuesta = htmlspecialchars($respuesta);
                    echo  $respuesta;
                    $conexion = null;
                }else{
                    $respuesta= "Error al actualizar ".ucwords($campo);
                    //$respuesta = htmlspecialchars($respuesta);
                    echo  $respuesta;
                    $conexion = null;
                }
                 
            } catch (PDOException $e) {
                exit("Error: " . $e->getMessage());
            }


        } catch (PDOException $e) {
            echo "<br>Error: " . $e->getMessage();
            echo "<br>Código del error: " . $e->getCode();
            echo "<br>Fichero error: " . $e->getFile();
            echo "<br>Línea del error: " . $e->getLine();
            exit;
        } 
    }

    /*FUNCIONES DE CONTROL*/
    function dniValido($dni){
        $letra = substr($dni, -1);
        $numeros = substr($dni, 0, -1);
        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 ){
          return true;
        }else{
          return false;
        }
    }

    function contraValida($clave,&$error_clave){
        if(strlen($clave) < 6){
           $error_clave = "La clave debe tener al menos 6 caracteres";
           return false;
        }
        if(strlen($clave) > 16){
           $error_clave = "La clave no puede tener más de 16 caracteres";
           return false;
        }
        if (!preg_match('`[a-z]`',$clave)){
           $error_clave = "La clave debe tener al menos una letra minúscula";
           return false;
        }
        if (!preg_match('`[A-Z]`',$clave)){
           $error_clave = "La clave debe tener al menos una letra mayúscula";
           return false;
        }
        if (!preg_match('`[0-9]`',$clave)){
           $error_clave = "La clave debe tener al menos un caracter numérico";
           return false;
        }
        $error_clave = "";
        return true;
    }
     
    function campoNoRepetido($campo, $tabla, $nuevoValor){
        $host="localhost";
        $database="eatstore";
        $port="3306";
        $charset="utf8mb4";
        $username="root";
        $password="";
        try {
            $conexion = new PDO('mysql:host=' . $host. ';dbname=' . $database . ';port=' . $port . ';charset=' . $charset, $username, $password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT $campo FROM $tabla"; 
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            $fila = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach ($fila as $valorExistente) {
                if($nuevoValor == $valorExistente[$campo]) return false;
            }
            return true;
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    






?>