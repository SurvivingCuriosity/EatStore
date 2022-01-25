<div id="filtros">
    <a href="#" id="resetFiltros" class="boton">Resetear filtros</a>
    <div class="unFiltro">
    <?php
        foreach ($nombresCategorias as $cat) { ?>
            <span class="linea-flex">
            <input class="checkFiltros" type="checkbox" id="<?=$cat['nombre']?>" name="<?=$cat['nombre']?>" value="<?=$cat['nombre']?>" checked>
        <label for="<?=$cat['nombre']?>"><?=$cat['nombre']?></label><br>
        </span>
        <?php }
    ?>
    </div>
    <div class="unFiltro">
        <p id="precioMax" style="display:none;"><?=$precio[0]['maximo']?></p>
        <p id="precioMin" style="display:none;"><?=$precio[0]['minimo']?></p>
        <output id="rangeSlider"></output>
        <p style="margin-left: 6px;" id="textoSlider"><?=$precio[0]['minimo']?>-<?=$precio[0]['maximo']?></p>
    </div>
</div>
<p id="infoFiltros"></p>