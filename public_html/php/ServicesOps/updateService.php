<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header("location: login.php");
    }
    require '../conexion.php'; // Incluir el archivo de conexión

    $nombreUsuario = $_SESSION['user'];
    $ServiceID = $_POST['ServiceID'];

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


    try {
        $sqlCompany = "SELECT CompanyID FROM Services WHERE ServiceID = :serviceID";
        $stmt = $conn->prepare($sqlCompany);
        $stmt->bindParam(":serviceID", $ServiceID, PDO::PARAM_INT);
        $stmt->execute();
    
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $CompanyID_service = $resultado['CompanyID'];
    
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    if($CompanyID_service != $CompanyID){
        header("location: ../views/servicesPage.php");
        // echo 'Erro compañía id: '. $CompanyID_service . ' - ' .$CompanyID;
        exit;
    }

    $ServiceName = $_POST['service_name'];
    $ServiceDescription = $_POST['service_description'];
    $UnitPrice = $_POST['unit_price'];
    $UnitFormat = $_POST['unit_format'];


    try{
        $sqlUpdate = "UPDATE Services SET ServiceName = :ServiceName, ServiceDescription = :ServiceDescription, UnitPrice = :UnitPrice, UnitFormat = :UnitFormat WHERE ServiceID = :ServiceID";

        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bindParam(":ServiceID", $ServiceID, PDO::PARAM_INT);
        $stmt->bindParam(":ServiceName", $ServiceName, PDO::PARAM_STR);
        $stmt->bindParam(":ServiceDescription", $ServiceDescription, PDO::PARAM_STR);
        $stmt->bindParam(":UnitPrice", $UnitPrice, PDO::PARAM_STR);
        $stmt->bindParam(":UnitFormat", $UnitFormat, PDO::PARAM_STR);

        $stmt->execute();
    }catch(PDOException $e){
        echo 'Error al actualizar un servicio'.$e->getMessage();
    }

    header("Location: ../views/servicesPage.php");
    exit;
?>