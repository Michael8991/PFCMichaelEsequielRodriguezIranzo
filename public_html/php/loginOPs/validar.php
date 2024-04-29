<?php
    require '../conexion.php';
    session_start();

    // Obtener datos del formulario de manera segura
    $username = $_POST['user'];
    $password = $_POST['password'];

    // Consulta parametrizada para evitar la inyección de SQL
    $stmt = $conn->prepare("SELECT COUNT(*) as contar FROM users WHERE user = :user AND password = :password");
    $stmt->bindParam(":user", $username); // Asignar valor al parámetro :user
    $stmt->bindParam(":password", $password); // Asignar valor al parámetro :password
    $stmt->execute(); // Ejecutar la consulta
    $contar = $stmt->fetchColumn(); // Obtener el valor de la columna contar
    $stmt->closeCursor(); // Cerrar el cursor del conjunto de resultados

    echo 'la variable contar tiene:', $contar;
    if ($contar > 0) {
        $_SESSION['user'] = $username;
        header("location: ../views/dashboardHome.php");
    } else {
        echo "Datos incorrectos";
    }
?>
