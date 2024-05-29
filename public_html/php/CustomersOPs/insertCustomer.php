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

$FirstName = $_POST['first_name'];
$LastName = $_POST['last_name'];
$Email = $_POST['email'];
$PhoneNumber = $_POST['phone_number'];
$Address = $_POST['address'];

try{
    $sqlInsert = "INSERT INTO Customers (FirstName, LastName, Email, PhoneNumber, Address, CompanyID) VALUES (:FirstName, :LastName, :Email, :PhoneNumber, :Address, :CompanyID)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bindParam(":FirstName", $FirstName, PDO::PARAM_STR);
    $stmt->bindParam(":LastName", $LastName, PDO::PARAM_STR);
    $stmt->bindParam(":Email", $Email, PDO::PARAM_STR);
    $stmt->bindParam(":PhoneNumber", $PhoneNumber, PDO::PARAM_STR);
    $stmt->bindParam(":Address", $Address, PDO::PARAM_STR);
    $stmt->bindParam(":CompanyID", $CompanyID, PDO::PARAM_STR);

    $stmt->execute();
}catch(PDOException $e){
    echo 'Error al insertar un nuevo cliente'.$e->getMessage();
}

header("Location: ../views/projectsPage.php");
        exit;
?>