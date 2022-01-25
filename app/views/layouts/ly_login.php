<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;300;500;700;900&display=swap" rel="stylesheet"> 

    <!-- JQuery     -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="<?=Config::$rutaJS?>jquery-ui.js"></script>

    <link rel="stylesheet" href="<?=Config::$rutaCSS?>jquery-ui.css">
    <link rel="stylesheet" href="<?=Config::$rutaCSS?>jquery-ui.structure.css">
    <link rel="stylesheet" href="<?=Config::$rutaCSS?>jquery-ui.theme.css">
    
    <!-- <script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.js"></script> -->
    
    <!-- Mi CSS -->
    <link rel="stylesheet" href="<?=Config::$rutaCSS?>reset.css">
    <link rel="stylesheet" href="<?=Config::$rutaCSS?>style.css">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">

    <title><?=Config::$titulo?></title>
</head>
<body>
    <div class="makeFooterStickToBottom">
    <?php 
        if (isset($_SESSION['nombre'])){?>
            <nav id="topNav">
                <p style="color:black;">Bienvenido, <?=$_SESSION['nombre']?></p>
                <ul>
                        <li>
                            <img id="imgPerfil" class="dropbtn" onclick="muestraOpcionesPerfil()" src="<?=Config::$rutaIMG?>user.png" alt="Icono usuario" style="width:40px;height:40px;">
                                <div class="dropdown-content" id="myDropdown">
                                    <a href="index.php?ctl=perfil">Mi perfil</a>
                                    <a href="index.php?ctl=logout" class="texto-rojo" >Cerrar sesión</a>
                                </div>
                        </li>
                        <li>
                            <div id="iconoCarritoCompleto"><p id="itemsCarrito">0</p><img id="imgCarrito" class="dropbtn2" onclick="muestraCarrito()" src="<?=Config::$rutaIMG?>carrito.png" alt="Icono carrito" style="width:40px;height:40px;"></div>
                            
                                <div class="dropdown-content" id="myDropdown2">
                                    <div id="carrito">
                                        <div id="cabecerasCarrito">
                                            <p class="cabeceraCarrito">Nombre</p>
                                            <p class="cabeceraCarrito">Precio</p>
                                            <p class="cabeceraCarrito">Cantidad</p>
                                            
                                        </div>
                                        <div id="productosEnCarrito">

                                        </div>
                                        <hr class="hrnegro">
                                        <span class="linea-flexCentro">
                                            <p class="cabeceraCarrito">Total: <p id="carrito_precioTotal">0</p>€</p>
                                            <a id="carrito_vaciar" class="botonCarro">Vaciar carrito</a>
                                            <a class="botonCarro" href="index.php?ctl=resumenCompra">Procesar compra</a>
                                        </span>
                                    </div>
                                </div>
                        </li>
                </ul>
            </nav>
        <?php }?>

    <?php include(Config::$rutaParts."header.php")?>
    
    <?php include(Config::$rutaParts."nav.php")?>
    <main>
        <div class="mainContainer">
            <?= $contenido ?>
        </div>
    </main>
    </div>

    <?php include(Config::$rutaParts."footer.php")?>

    <script src="<?=Config::$rutaJS?>app.js"></script>
    <script src="<?=Config::$rutaJS?>filtrosProductos.js"></script>
</body>
</html>