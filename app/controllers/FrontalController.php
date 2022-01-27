<?php
//registro las rutas de los controladores, base de datos y modelos, si existen, los importo
    spl_autoload_register(function ($clase) {
        $pathConfig = 'config/Config.php';
        $pathControllers = 'app/controllers/' . $clase . '.php';
        $pathBD = 'app/db/' . $clase . '.php';
        $pathModels = 'app/models/' . $clase . '.php';
        
        if (file_exists($pathConfig)) {
            require_once $pathConfig;
        }
        if (file_exists($pathControllers)) {
            require_once $pathControllers;
        }
        if (file_exists($pathBD)) {
            require_once $pathBD;
        }
        if (file_exists($pathModels)) {
            require_once $pathModels;
        }
    });
    require_once('vendor/autoload.php');
    require_once('app/libraries/Omnipaygateway.php');


    //Iniciamos sesión sin datos
    !isset ($_SESSION['nombre']) ? session_start(): NULL;

    $map = array(
        'index' => array(
            'controller' => 'MainController',
            'action' => 'index'
        ),
        'verFormLogin' => array(
            'controller' => 'VistasController',
            'action' => 'verFormLogin'
        ),
        'checkLogin' => array(
            'controller' => 'UsersController',
            'action' => 'checkLogin'
        ),
        'verRegistro' => array(
            'controller' => 'VistasController',
            'action' => 'verFormularioRegistro'
        ),
        'registro' => array(
            'controller' => 'UsersController',
            'action' => 'registro'
        ),
        'logout' => array(
            'controller' => 'UsersController',
            'action' => 'logout'
        ),
        'verPlatos' => array(
            'controller' => 'ProductsController',
            'action' => 'mostrarPlatos'
        ),
        'verCategorias' => array(
            'controller' => 'ProductsController',
            'action' => 'mostrarCategorias'
        ),
        'verPerfil' => array(
            'controller' => 'UsersController',
            'action' => 'verPerfil'
        ),
        'verResumenCompra' => array(
            'controller' => 'CompraController',
            'action' => 'resumenCompra'
        ),
        'borrarCuenta' => array(
            'controller' => 'UsersController',
            'action' => 'borrarCuenta'
        ),
        'verDocapi' => array(
            'controller' => 'VistasController',
            'action' => 'verDocApi'
        ),
        'confirmarCompra' => array(
            'controller' => 'CompraController',
            'action' => 'procesarCarrito'
        ),
        'verFormPago' => array(
            'controller' => 'VistasController',
            'action' => 'verFormPago'
        )
    );

    //Parseo de la ruta $_REQUEST['ctl]=buscarLibro (por ejemplo)
    if (isset($_REQUEST['ctl'])) {
        //si existe dentro de mi lista
        if (isset($map[$_REQUEST['ctl']])) {
            $ruta = $_REQUEST['ctl'];            
        } else {
            header("Location: app/views/errors/404.php");
        }
    } else {
        $ruta = Config::$defaultRoute;
    }
    $controlador = $map[$ruta];

    // Ejecución del controlador asociado a la ruta
    if (method_exists($controlador['controller'], $controlador['action'])) {
        call_user_func(
            array(
                $controlador['controller'],
                $controlador['action']
            )
        );
    } else {
        header("Location: app/views/errors/404.php");
    }
    