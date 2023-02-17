
<?php

use Dompdf\Dompdf;

require __DIR__ . "/../../assets/vendor/autoload.php";

$dompdf = new Dompdf;

$dompdf->loadHtml("Hello World");

$dompdf->render();

$dompdf->stream("pdf", ["Attachment" => 0]);