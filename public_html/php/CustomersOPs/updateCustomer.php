<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
require '../conexion.php'; // Incluir el archivo de conexión

$nombreUsuario = $_SESSION['user'];
$customerID = $_POST['CustomerID'];

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
    $sqlCompany = "SELECT CompanyID FROM Customers WHERE CustomerID = :customerID";
    $stmt = $conn->prepare($sqlCompany);
    $stmt->bindParam(":customerID", $customerID, PDO::PARAM_STR);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $CompanyID_customer = $resultado['CompanyID'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if($CompanyID_customer != $CompanyID){
    header("location: clientesPage.php");
    // echo $CompanyID_customer . ' - ' . $CompanyID;
    exit;
}

$FirstName = $_POST['first_name'];
$LastName = $_POST['last_name'];
$Email = $_POST['email'];
$PhoneNumber = $_POST['phone_number'];
$Address = $_POST['address'];

try {
    $sqlUpdate = "UPDATE Customers SET FirstName = :FirstName, LastName = :LastName, Email = :Email, PhoneNumber = :PhoneNumber, Address = :Address WHERE CustomerID = :CustomerID";

    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bindParam(":FirstName", $FirstName, PDO::PARAM_STR);
    $stmt->bindParam(":LastName", $LastName, PDO::PARAM_STR);
    $stmt->bindParam(":Email", $Email, PDO::PARAM_STR);
    $stmt->bindParam(":PhoneNumber", $PhoneNumber, PDO::PARAM_STR);
    $stmt->bindParam(":Address", $Address, PDO::PARAM_STR);
    $stmt->bindParam(":CustomerID", $customerID, PDO::PARAM_INT); 

    $stmt->execute();
} catch (PDOException $e) {
    echo 'Error al actualizar el cliente: ' . $e->getMessage();
}

        header("Location: ../views/clientesPage.php");
        exit;
?>