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


    //Iniciamos sesión sin datos
    !isset ($_SESSION['nombre']) ? session_start(): NULL;

    $map = array(
        'index' => array(
            'controller' => 'MainController',
            'action' => 'index'
        ),
        'checkLogin' => array(
            'controller' => 'UsersController',
            'action' => 'checkLogin'
        ),
        'logout' => array(
            'controller' => 'UsersController',
            'action' => 'logout'
        ),
        'registro' => array(
            'controller' => 'UsersController',
            'action' => 'registro'
        ),
        'platos' => array(
            'controller' => 'ProductsController',
            'action' => 'mostrarPlatos'
        ),
        'categorias' => array(
            'controller' => 'ProductsController',
            'action' => 'mostrarCategorias'
        ),
        'perfil' => array(
            'controller' => 'UsersController',
            'action' => 'verPerfil'
        ),
        'resumenCompra' => array(
            'controller' => 'CompraController',
            'action' => 'resumenCompra'
        ),
        'borrarCuenta' => array(
            'controller' => 'UsersController',
            'action' => 'borrarCuenta'
        ),
        'docapi' => array(
            'controller' => 'MainController',
            'action' => 'verDocApi'
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
    