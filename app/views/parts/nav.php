<nav id ="nav">
    <ul>
        <li><a id="enlacePlatos" class="enlaceNavegable" href="index.php?ctl=platos">Platos</a></li>
        <li><a id="enlaceCategorias" class="enlaceNavegable" href="index.php?ctl=categorias">Categorias</a></li>
        <?php if(!isset($_SESSION['nombre'])){ ?>
            <li><a id="enlaceCategorias" class="enlaceNavegable" href="index.php?ctl=index">Comprar</a></li>
        <?php }?>
        <?php if(isset($_SESSION['nombre'])){ ?>
            <li><a class="enlaceNavegable" href="index.php?ctl=docapi">API</a></li>
       <?php }?>
    </ul>
</nav>