<?php
session_start();

if(!isset($_SESSION['user'])){
   header("location: login.php");
}else{
    require 'conexion.php'; // Archivo de conexión a la base de datos

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
        $username = mysqli_real_escape_string($conexion, $_POST['username']);
        
        // Insertar la información en la tabla de reformas
        $sql_reforma = "INSERT INTO galeriaReformas (tituloReforma, descReforma, userName) VALUES ('$titulo', '$descripcion','$username')";
        if (mysqli_query($conexion, $sql_reforma)) {
            $reforma_id = mysqli_insert_id($conexion); // Obtener el ID de la reforma recién insertada
            
            // Procesar imágenes
            $imagenes = $_FILES['imagenes'];
            $carpeta_destino = '../imagenes/works/'; // Carpeta donde se guardarán las imágenes
            
            foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
                $nombre_archivo = pathinfo($imagenes['name'][$key], PATHINFO_FILENAME);
                $extension = pathinfo($imagenes['name'][$key], PATHINFO_EXTENSION);
                $nombre_archivo_hash = md5($nombre_archivo . time()); // Generar un hash único
                
                $ruta_imagen = $carpeta_destino . $nombre_archivo_hash . '.' . $extension;
                move_uploaded_file($tmp_name, $ruta_imagen);
                
                // Insertar la ruta de la imagen en la tabla de imágenes
                $sql_imagen = "INSERT INTO imagenes (ruta_imagen, reforma_id) VALUES ('$ruta_imagen', $reforma_id)";
                if (!mysqli_query($conexion, $sql_imagen)) {
                    echo "Error al agregar imagen: " . mysqli_error($conexion);
                    // Puedes manejar el error según tus necesidades
                }
            }
            
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            echo "Error al agregar reforma: " . mysqli_error($conexion);
        }
    } else {
        echo "Acceso denegado.";
    }
}

mysqli_close($conexion);
?>
