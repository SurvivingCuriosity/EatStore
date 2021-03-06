<?php
//CAMPOS TABLA cliente: idcliente, dni, nombre, direccion, correoe contras 

class UsersController{
    public static $conexion;
    
    public function __construct() {
        self::$conexion = Conectar::conexion();
    }
    use FiltrarTraitMatriz;

    //evalua si ha iniciado sesion, lo manda al formulario de login o al inicio
    public static function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $param = array();
            self::filtrarM($_REQUEST);
            $param['correoe'] = $_POST['correoe'];
            $param['password'] = $_POST['password'];

            if ($param['correoe'] != '' && $param['password'] != '') {
                if($datosUser=UsersModel::checkLogin($param['correoe'],  $param['password'])){
                    $param['dni']=$datosUser['dni'];
                    $param['nombre']=$datosUser['nombre'];
                    $param['direccion']=$datosUser['direccion'];
                    $param['correoe']=$datosUser['correoe'];
                    $param['idCliente']=$datosUser['id'];
                    self::crearSesion($param['dni'],$param['nombre'],$param['direccion'],$param['correoe'],$param['idCliente']);

                    self::$conexion=null;
                    $param['class']='success';
                    $param['msg']='Login correcto';
                    header("Location: index.php?ctl=verPlatos");
                }else{
                    self::$conexion=null;
                    $param['msg']='Email o contraseña incorrectos';
                    $param['class']='error';
                    require_once 'app/views/login_form.php';
                }
            }else{
                self::$conexion=null;
                $param['class']='error';
                $param['msg']='Rellena los campos del formulario';
                require_once 'app/views/login_form.php';
            }
            
        }   
       
        //require 'app/vista/formularioValidar.php';
    }

    public static function registro(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $param = array();
            self::filtrarM($_REQUEST);
            $param['correoe'] = $_POST['correoe'];
            $param['nombre'] = $_POST['nombre'];
            $param['dni'] = $_POST['dni'];
            $param['direccion'] = $_POST['direccion'];

            if (self::camposNoVacios($_POST)) {
                if(UsersModel::campoNoRepetido('dni','cliente',$_POST['dni'])){
                    if(UsersModel::campoNoRepetido('correoe','cliente',$_POST['correoe'])){
                        //si coinciden las contraseñas
                        if($_POST['password']==$_POST['cpassword']){
                            if(self::dniValido($_POST['dni'])){
                                $error_clave="";
                                if(self::contraValida($_POST["password"],$error_clave)){
                                    if($id=UsersModel::registro($_POST)){
                                        $param['class']='success';
                                        $param['msg']='Registrado con éxito';
                                        self::crearSesion($param['dni'],$param['nombre'],$param['direccion'],$param['correoe'],$id);
                                        self::$conexion=null;
                                        header("Location: index.php?ctl=verPlatos");
                                    }else{
                                        self::$conexion=null;
                                        $param['msg']='Error al registrar';
                                        $param['class']='error';
                                        require_once 'app/views/login_form.php';
                                    }
                                }else{
                                    self::$conexion=null;
                                    $param['msg']=$error_clave;
                                    $param['class']='error';
                                    require_once 'app/views/login_form.php';
                                }
                            }else{
                                self::$conexion=null;
                                $param['msg']='DNI no válido';
                                $param['class']='error';
                                require_once 'app/views/login_form.php';
                            }
                        }else{
                            self::$conexion=null;
                            $param['msg']='Las contraseñas no coinciden';
                            $param['class']='error';
                            require_once 'app/views/login_form.php';
                        }
                    }else{
                        self::$conexion=null;
                        $param['msg']='El correo introducido ya está en uso';
                        $param['class']='error';
                        require_once 'app/views/login_form.php';
                    }
                }else{
                    self::$conexion=null;
                    $param['msg']='El DNI introducido ya está en uso';
                    $param['class']='error';
                    require_once 'app/views/login_form.php';
                }
            }else{
                self::$conexion=null;
                $param['class']='error';
                $param['msg']='Rellena los campos del formulario';
                require_once 'app/views/login_form.php';
            }
            
    
        }
    }

    public static function borrarCuenta(){
        if(isset($_GET['correoe'])){
            if(UsersModel::borrarCuenta($_GET['correoe'])){
                $param['class']='success';
                $param['msg']='Cuenta eliminada';
                require_once 'app/views/login_form.php';
                self::$conexion=null;
            }else{
                $param['class']='error';
                $param['msg']='Error interno al borrar la cuenta.';
                require_once 'app/views/login_form.php';
                self::$conexion=null;
            }
        }else{
            $param['class']='error';
            $param['msg']='Algo ha ido mal al borrar la cuenta.';
            require_once 'app/views/login_form.php';
            self::$conexion=null;
        }
    }
    
    private static function crearSesion($dni,$nombre,$direccion,$correoe,$id) {
        $_SESSION['dni'] = $dni;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['direccion'] = $direccion;
        $_SESSION['correoe'] = $correoe;
        $_SESSION['idCliente'] = $id;
    }

    public static function logout() {
        session_destroy();
        $param['msg']='Sesión cerrada';
        $param['class']='warn';
        require_once 'app/views/login_form.php';
    }

    

    


    public static function verPerfil(){
        $datosActuales = UsersModel::getUser($_SESSION['correoe']);
        require_once('app/views/perfil.php');
    }
    
    
    /*FUNCIONES DE CONTROL*/
    public static function contraValida($clave,&$error_clave){
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

    public static function camposNoVacios($array){
        foreach ($array as $a) {
            if($a=="") return false;
        }
        return true;
    }
    
    public static function dniValido($dni){
        $letra = substr($dni, -1);
        $numeros = substr($dni, 0, -1);
        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 ){
          return true;
        }else{
          return false;
        }
    }
}