<?php

use StampPDF\Watermark\WatermarkPDF;

require_once "./vendor/autoload.php";


$w = new WatermarkPDF('my_pdf.pdf');
$w->watermarked('Maria Eduarda Silva', 'maria.silva@gmail.com', '123456789')->savePdf();
