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
            if($fila){
                $contra = $fila['contras'];
                // if(password_verify($pass, $fila['contras'])){
                if(password_verify($pass, $contra)){        
                    self::$usuario['id'] = $fila['idcliente'];
                    self::$usuario['dni'] = $fila['dni'];
                    self::$usuario['nombre'] = $fila['nombre'];
                    self::$usuario['direccion'] = $fila['direccion'];
                    self::$usuario['correoe'] = $fila['correoe'];
                    return  self::$usuario;       
                }else{
                    return false;
                } 
            }else{
                return false;
            }
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function registro($datos){
        try {
            $con = Conectar::conexion();
            $pass = password_hash($datos['password'],PASSWORD_DEFAULT);
            $sql = "INSERT INTO cliente (dni,nombre,direccion,correoe,contras) VALUES (?, ?, ?, ?,?)";
            $resultado=$con->prepare($sql)->execute([$datos['dni'],$datos['nombre'],$datos['direccion'],$datos['correoe'],$pass]);
            
            if($resultado){
                return $con->lastInsertId();
            }else{
                return 0;
            }
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
}





