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
    <!-- Mi CSS -->
    <link rel="stylesheet" href="<?=Config::$rutaCSS?>reset.css">
    <link rel="stylesheet" href="<?=Config::$rutaCSS?>style.css">
    <title><?=Config::$titulo?></title>
</head>
<body>
    <div style="height: calc(100vh - 50px);">
    <img id="imgFondoWelcome" src="<?=Config::$rutaIMG?>fondo.png" alt="Imagen de bienvenida">
    <div id="welcomeContainer">
        <div id="welcomeSubContainer">
            <?= $contenido ?>
        </div>
    </div>
    </div>
    <?php include(Config::$rutaParts."footer.php"); ?>
    <script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
    <script src="<?=Config::$rutaJS?>app.js"></script>
</body>
</html>