<?php 

trait FiltrarTraitMatriz {

    public static function filtrarM(&$array) {
        foreach ($array as $indice => $dato) {
            $array[$indice] = trim($dato);
            $array[$indice] = stripslashes($dato);
            $array[$indice] = htmlspecialchars($dato);
            $array[$indice] = strip_tags($dato);
        }
    }

    public static function filtrarV(&$variable) {
        $variable = trim($variable);
        $variable= stripslashes($variable);
        $variable= htmlspecialchars($variable);
        $variable = strip_tags($variable);       
    }
    
}

?>