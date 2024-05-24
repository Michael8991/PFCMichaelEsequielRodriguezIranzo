<?php
require 'vendor/autoload.php';

use mikehaertl\wkhtmlto\Pdf;

function convertUrlToPdf($url, $outputPath) {
    // Crear una instancia de Pdf y establecer la URL
    $pdf = new Pdf($url);

    // Guardar el archivo PDF
    if (!$pdf->saveAs($outputPath)) {
        // Devolver el error en caso de fallo
        return $pdf->getError();
    } else {
        return "PDF generado y guardado en $outputPath";
    }
}

// Ejemplo de uso de la función
$url = 'http://localhost:8888/PFC_Michael_Esequiel_Rodriguez_Iranzo/PFCMichaelEsequielRodriguezIranzo/public_html/php/views/projectsPage.php';
$outputPath = 'output.pdf';
$result = convertUrlToPdf($url, $outputPath);
echo $result;

?>