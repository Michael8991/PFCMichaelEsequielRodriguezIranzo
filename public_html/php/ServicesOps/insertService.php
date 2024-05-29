<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header("location: login.php");
    }
    require '../conexion.php'; // Incluir el archivo de conexión

    $nombreUsuario = $_SESSION['user'];

    try {
        $sqlCompany = "SELECT CompanyID FROM Users WHERE user = :userName";
        $stmt = $conn->prepare($sqlCompany);
        $stmt->bindParam(":userName", $nombreUsuario, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $CompanyID = $resultado['CompanyID'];

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $ServiceName = $_POST['service_name'];
    $ServiceDescription = $_POST['service_description'];
    $UnitPrice = $_POST['unit_price'];
    $UnitFormat = $_POST['unit_format'];


    try{
        $sqlInsert = "INSERT INTO Services (ServiceName, ServiceDescription, UnitPrice, UnitFormat, CompanyID) VALUES (:ServiceName, :ServiceDescription, :UnitPrice, :UnitFormat, :CompanyID)";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bindParam(":ServiceName", $ServiceName, PDO::PARAM_STR);
        $stmt->bindParam(":ServiceDescription", $ServiceDescription, PDO::PARAM_STR);
        $stmt->bindParam(":UnitPrice", $UnitPrice, PDO::PARAM_STR);
        $stmt->bindParam(":UnitFormat", $UnitFormat, PDO::PARAM_STR);
        $stmt->bindParam(":CompanyID", $CompanyID, PDO::PARAM_STR);

        $stmt->execute();
    }catch(PDOException $e){
        echo 'Error al insertar un nuevo servicio'.$e->getMessage();
    }

    header("Location: ../views/servicesPage.php");
    exit;
?>