<?php 
    $servername="localhost";
    $dbname="u598759793_JJRerformas";
    $username="root";
    $password="root";

    try {
        // Establecer conexión PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Establecer el modo de error de PDO a excepción
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>
