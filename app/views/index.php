<?php 
ob_start();
?>
<h1>Logged</h1>
    <?php isset($param['msg']) ? $msg=$param['msg'] : $msg="" ?>
    <?php isset($param['class']) ? $class=$param['class'] : $clas =""?>
    <p class="<?=$class?>"><?=$msg?></p>
<?php 
$contenido = ob_get_clean();
include 'layouts/ly_login.php'; ?>
