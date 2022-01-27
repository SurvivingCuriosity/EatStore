<?php 
ob_start();
?>
    <h2>Compra realizada</h2>
<?php 
$contenido = ob_get_clean();
include 'layouts/ly_login.php'; ?>
