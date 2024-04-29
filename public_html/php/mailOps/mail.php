<?php
if($_SERVER['REQUEST_METHOD'] != 'POST' ){
    header("Location: contacta.php" );
}

$nombre = $_POST['nombre'];
$mensaje = $_POST['mensaje'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];

if( empty(trim($nombre)) ) $nombre = 'anonimo';

$body = <<<HTML
    <h2>Correo desde la web</h2>
    <h3>Mensaje</h3>
    $mensaje
    <p>De: $nombre / $telefono / $email</p>
HTML;

$headers = "MIME-Version: 1.0 \r\n";
$headers.= "Content-type: text/html; charset=utf-8 \r\n";
$headers.= "From: $email \r\n";
$headers.= "To: Sitio web <contacta@jjreformasnerja.com> \r\n";

$rta = mail('contacta@jjreformasnerja.com', "Mensaje web de $nombre", $body, $headers );


header("Location: contacta.php" );