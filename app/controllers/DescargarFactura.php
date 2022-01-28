<?php
    // reference the Dompdf namespace
    use Dompdf\Dompdf;

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    (isset($_POST['cadenaFactura'])) ? $cadenaFactura=$_POST['cadenaFactura'] : $cadenaFactura="Error";

    $dompdf->loadHtml($cadenaFactura);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    $dompdf->stream();
?>
    