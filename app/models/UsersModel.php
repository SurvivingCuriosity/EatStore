<?php

class UsersModel {

    use FiltrarTraitMatriz;    
    
    public static $usuario = array();

    public function __construct() {
        $this->conexion = Conectar::conexion();
        $this->usuario = array();
    }

    public static function checkLogin($email, $pass) {
        try {
            $sql = "SELECT * FROM cliente WHERE correoe=:email"; 
            $consulta = Conectar::conexion()->prepare($sql);
            $consulta->bindParam(':email', $email, PDO::PARAM_STR, 50);
            $consulta->execute();
            $fila = $consulta->fetch(PDO::FETCH_ASSOC);
            // if(password_verify($pass, $fila['contras'])){
            if(password_verify($pass, $fila['contras'])){
                self::$usuario['dni'] = $fila['dni'];
                self::$usuario['nombre'] = $fila['nombre'];
                self::$usuario['direccion'] = $fila['direccion'];
                self::$usuario['correoe'] = $fila['correoe'];
                return  self::$usuario;       
            } 
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function registro($datos){
        try {
            $pass = password_hash($datos['password'],PASSWORD_DEFAULT);
            $sql = "INSERT INTO cliente (dni,nombre,direccion,correoe,contras) VALUES (?, ?, ?, ?,?)";
            $resultado=Conectar::conexion()->prepare($sql)->execute([$datos['dni'],$datos['nombre'],$datos['direccion'],$datos['correoe'],$pass]);
            return $resultado;//1 o 0
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public static function borrarCuenta($email){
        try {
            $sql = 'DELETE FROM cliente WHERE correoe = :c';
            $statement = Conectar::conexion()->prepare($sql);
            $statement->bindParam(':c', $email);
            
            if ($statement->execute()) {
                return true;
            }else return false;
            
        } catch (Exception $e) {
            die($e->getMessage());
        }


        

        // prepare the statement for execution
        

        // execute the statement
        if ($statement->execute()) {
            echo 'publisher id ' . $publisher_id . ' was deleted successfully.';
        }
    }
    public static function campoNoRepetido($campo, $tabla, $nuevoValor){
        try {
            $sql = "SELECT $campo FROM $tabla"; 
            $consulta = Conectar::conexion()->prepare($sql);
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

    public static function getUser($correo) {
        try {
            $sql = "SELECT * FROM cliente WHERE correoe=:c";
            $consulta = Conectar::conexion()->prepare($sql);
            $consulta->bindParam(':c', $correo, PDO::PARAM_STR, 50);
            $consulta->execute();
            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
                return $fila;
            }   
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }
    
/*Este metodo (YA NO, ESTA EN OTRO FICHERO) se usa con ajax, asi que devolveré mensajes para mostrarlos en la vista
    public static function updateCampo($campo,$nuevoValor){
        try {
            $data = [
                'c' => $nuevoValor,
                'correo' => $_SESSION['correoe'],
            ];
            $sql = "UPDATE cliente SET $campo=:c WHERE correoe=:correo";
            $stmt=  Conectar::conexion()->prepare($sql);
            $resultado=$stmt->execute($data);
            if($resultado){
                echo "$campo actualizado.";
            }else{
                echo "Algo fue mal al actualizar $campo.";
            }
             
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
        
    }*/



    public static function getAlias($dni) {
        try {
            $sql = "SELECT * FROM alias_clave WHERE DNI=:dni";
            $consulta = Conectar::conexion()->prepare($sql);
            $consulta->bindParam(':dni', $dni, PDO::PARAM_STR, 50);
            $consulta->execute();
            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
                return $fila['alias'];
            }   
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    //devuelve true si el alias no esta cogido
    public static function aliasUnico($nuevoAlias){
        try {
            $sql = "SELECT alias FROM alias_clave";
            $consulta = Conectar::conexion()->prepare($sql);
            $consulta->bindParam(':dni', $dni, PDO::PARAM_STR, 50);
            $consulta->execute();
            if ($fila = $consulta->fetchAll(PDO::FETCH_ASSOC)){
                foreach ($fila as $alias) {
                    if($nuevoAlias==$alias['alias']) {
                        return false;
                    }
                }
                return true;
            }   
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function updateAlias($dni,$nuevoValor){
        try {
            $data = [
                'alias' => $nuevoValor,
                'dni' => $dni,
            ];
            $sql = "UPDATE alias_clave SET alias=:alias WHERE dni=:dni";
            $stmt=  Conectar::conexion()->prepare($sql);
            $resultado=$stmt->execute($data);

             
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
        
    }

    public static function updateImg($dni,$nuevoValor){
        try {
            $data = [
                'img' => $nuevoValor,
                'dni' => $dni,
            ];
            $sql = "UPDATE persona SET avatar=:img WHERE dni=:dni";
            $stmt=  Conectar::conexion()->prepare($sql);
            $resultado=$stmt->execute($data);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
        
    }

    //devuelve una lista de las notas que ha puesto o ha obtenido el profe o alumno logeado
    public static function getNotasFiltradas($asignatura){
        try {
            $dni = $_SESSION['dni'];
            if($_SESSION['tipo']=="alumno"){
                if($asignatura=="todas"){
                    $sql = "SELECT DISTINCT asignaturas.nombre as nombreA,
                    asignaturas.idAsignatura as id, evaluacion, calificacion
                    FROM asignaturas
                    JOIN notas ON asignaturas.idAsignatura = notas.idAsignatura
                    WHERE notas.dni = $dni
                    ORDER BY nombreA, evaluacion;";
                }else{
                    $sql = "SELECT DISTINCT asignaturas.nombre as nombreA,
                    asignaturas.idAsignatura as id, evaluacion, calificacion
                    FROM asignaturas
                    JOIN notas ON asignaturas.idAsignatura = notas.idAsignatura
                    WHERE notas.dni = $dni
                    AND asignaturas.nombre='$asignatura'
                    ORDER BY nombreA, evaluacion;";
                }
            }else{
                if($asignatura=="todas"){
                    $sql = "SELECT DISTINCT asignaturas.nombre as nombreA,
                    asignaturas.idAsignatura as id, evaluacion, calificacion, notas.DNI as dniAlumno, persona.Nombre
                    FROM asignaturas
                    JOIN notas ON asignaturas.idAsignatura = notas.idAsignatura
                    JOIN persona ON persona.DNI = notas.DNI
                    WHERE asignaturas.dniprofesor = $dni";
                }else{
                    $sql = "SELECT DISTINCT asignaturas.nombre as nombreA,
                    asignaturas.idAsignatura as id, evaluacion, calificacion, notas.DNI as dniAlumno, persona.Nombre
                    FROM asignaturas
                    JOIN notas ON asignaturas.idAsignatura = notas.idAsignatura
                    JOIN persona ON persona.DNI = notas.DNI
                    WHERE asignaturas.dniprofesor = $dni AND asignaturas.nombre='$asignatura'";
                }
                
            }

            $consulta = Conectar::conexion()->prepare($sql);
            $consulta->execute();
            if ($fila = $consulta->fetchAll(PDO::FETCH_ASSOC)){
                return($fila);
            }   
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    //devuelve una lista de las asignaturas que estudia el alumno logeado
    public static function getAsignaturasAlumno(){
        try {
            $dni = $_SESSION['dni'];
            $sql = "SELECT DISTINCT asignaturas.nombre as nombreA
            FROM asignaturas
            JOIN notas ON asignaturas.idAsignatura = notas.idAsignatura
            WHERE notas.dni = $dni";

            $consulta = Conectar::conexion()->prepare($sql);
            $resultado = $consulta->execute();
            if ($fila = $consulta->fetchAll(PDO::FETCH_ASSOC)){
                return($fila);
            }   
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    //devuelve una lista de las asignaturas que impoarte el profesor logeado
    public static function getAsignaturasProfe(){
        try {
            $dni = $_SESSION['dni'];
            $sql = "SELECT DISTINCT nombre as nombreA FROM asignaturas WHERE dniprofesor = $dni";

            $consulta = Conectar::conexion()->prepare($sql);
            $resultado = $consulta->execute();
            if ($fila = $consulta->fetchAll(PDO::FETCH_ASSOC)){
                return($fila);
            }   
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }
    
}





