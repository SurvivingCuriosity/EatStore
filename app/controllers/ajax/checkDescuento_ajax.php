<?php
//EXCEPCIONALMENTE ESTA PAGINA NO UTILIZA NINGUN MODELO, CONTROLADOR NI VARIABLE GLOBAL (NO HE SIDO CAPAZ)
//LA CONEXION A LA BASE DE DATOS SE REALIZA EN ESTA PAGINA Y ESTAN DEFINIDAS OTRA VEZ LAS VARIABLES DE CONEXION
//OJO AL CAMBIARLAS
    if($_POST['codigo']!=""){
        checkCodigo($_POST['codigo']);
    }

//recibe un codigo y comprueba si existe y devuelve el valor del descuento
    function checkCodigo($codigo){
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
                $sql = "SELECT porcentaje FROM descuento WHERE codigo = '$codigo'"; 
            
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                if($resultado){
                    echo ($resultado['porcentaje']);       
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

    






?>