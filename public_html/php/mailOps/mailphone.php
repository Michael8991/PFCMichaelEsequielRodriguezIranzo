<?php
if($_SERVER['REQUEST_METHOD'] != 'POST' ){
    header("Location: contacta.php" );
}

$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];

if( empty(trim($nombre)) ) $nombre = 'anonimo';

$body = <<<HTML
    <h2>Contacto desde la web, para llamada por telefono.</h2>
    <p>Llama a $nombre al $telefono.</p>
HTML;

$headers = "MIME-Version: 1.0 \r\n";
$headers.= "Content-type: text/html; charset=utf-8 \r\n";
$headers.= "From: $nombre \r\n";
$headers.= "To: Sitio web <contacta@jjreformasnerja.com> \r\n";

$rta = mail('contacta@jjreformasnerja.com', "Solicita llamada de teléfono", $body, $headers );


header("Location: contacta.php" );