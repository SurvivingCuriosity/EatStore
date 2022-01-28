<nav id ="nav">
    <ul>
        <li><a id="enlacePlatos" class="enlaceNavegable" href="index.php?ctl=verPlatos">Platos</a></li>
        <li><a id="enlaceCategorias" class="enlaceNavegable" href="index.php?ctl=verCategorias">Categorias</a></li>
        <?php if(!isset($_SESSION['nombre'])){ ?>
            <li><a class="enlaceNavegable" href="index.php?ctl=index">Comprar</a></li>
        <?php }?>
        <?php if(isset($_SESSION['nombre'])){ ?>
            <li><a id="enlaceApi" class="enlaceNavegable" href="index.php?ctl=verDocapi">API</a></li>
       <?php }?>
    </ul>
</nav>