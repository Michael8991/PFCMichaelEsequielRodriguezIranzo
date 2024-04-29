<?php
include("conexion.php");
require 'conexion.php';

session_start();

if(!isset($_SESSION['user'])){
   header("location: login.php");
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['elemento_id'])) {
        $elementoId = $_POST['elemento_id'];

        $query = "DELETE FROM galeriaReformas WHERE nReferencia='$elementoId'";
        $resultado = $conexion->query($query);
        
        if(!$resultado) {
            echo "Elemento no eliminado";
        } else {
            // Después de eliminar, redireccionar a la página deseada
            header('Location: dashboard.php');
        }
    } else {
        // Manejar el caso en el que no se proporcionó el ID del elemento
        echo "Error: No se proporcionó un ID de elemento válido.";
    }
}

mysqli_close($conexion);
?>
