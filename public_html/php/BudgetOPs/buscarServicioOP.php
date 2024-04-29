<?php
    include '../conexion.php';

    try {
        if(isset($_GET['term']) || $_GET['term'] != ''){
            // $searchTerm = $_GET['term'];
            $searchTerm = '%' . $_GET['term'] . '%';
            // Preparar la consulta SQL
            $stmt = $conn->prepare("SELECT * FROM Services WHERE ServiceName LIKE :searchTerm");
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
            // Ejecutar la consulta
            $stmt->execute();
            // Obtener los resultados como un array asociativo
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            // Preparar la consulta SQL
            $stmt = $conn->prepare("SELECT * FROM Services");
            // Ejecutar la consulta
            $stmt->execute();
            // Obtener los resultados como un array asociativo
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Devolver los proyectos como JSON
        echo json_encode($projects);
    } catch(PDOException $e) {
        // Si hay un error en la conexión o la consulta, devolver un mensaje de error
        echo json_encode(array("error" => "Error al preparar la consulta."));
    }
?>
