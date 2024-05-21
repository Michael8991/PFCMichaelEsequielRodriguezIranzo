<?php
// session_start();

// if (!isset($_SESSION['user'])) {
//     $nombreUsuario = $_SESSION['user'];
//     header("location: login.php");
// }

// require '..conexion.php'; // Incluir el archivo de conexión


// $consultaCompleta = "SELECT * FROM Presupuestos
//                     JOIN Clientes ON Presupuestos.ClienteAsociadoID  = Clientes.ClienteID
//                     JOIN users ON Presupuestos.UsuarioCreadorID = users.ID;";

// $ejConsCompleta = mysqli_query($conexion, $consultaCompleta);

// if (!$ejConsCompleta) {
//     die("Error al ejecutar la consulta: " . mysqli_error($conexion));
// }

session_start();

if (!isset($_SESSION['user'])) {
    $nombreUsuario = $_SESSION['user'];
    header("location: login.php");
}

require '../conexion.php'; // Incluir el archivo de conexión

try {
    // Preparar la consulta SQL
    $stmt = $conexion->prepare("SELECT * FROM Budgets
                                JOIN Customers ON Budgets.BudgetAssociatedCustomerID = Customers.CustomerID
                                JOIN users ON Budgets.BudgetAssociatedCustomerID = users.ID");
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener los resultados como un array asociativo
    $presupuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterar sobre los resultados y mostrar la información
    foreach ($presupuestos as $presupuesto) {
        // Aquí puedes acceder a los datos de cada presupuesto
        // Por ejemplo: $presupuesto['NombreDelCampo']
    }
} catch (PDOException $e) {
    // Si hay un error en la conexión o la consulta, mostrar un mensaje de error
    echo "Error al ejecutar la consulta: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Factura</title>
    <link rel="shortcut icon" href="../imagenes/Logos/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../css/headerDashBoardFocus.css">
    <link rel="stylesheet" href="../css/aniadirFacturaPage.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Bootstrap JavaScript y dependencias Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
        <div class="logoContainer">
            <a href="/php/dashboard.php">
                <img src="../imagenes/Logos/LogoSimple.png" alt="">
            </a>
            <div class="logoText">
                <strong class="left">CONSTRUCCIONES & REFORMAS</strong>
                <span class="left">Especialistas en Alicatados y Solados </span>
            </div>
        </div>
        <div class="userNavContainer">
            <div class="dropdown">
                <button class="dropbtn">
                    <a class="titleBottonUser" href="">
                        <?php $nombreUsuario = $_SESSION['user']; echo $nombreUsuario ?>
                        <i class="fa-solid fa-angle-down"></i>
                    </a>
                </button>
                <div class="dropdown-content">
                    <a href="dashboardHome.php"><i class="fa-solid fa-house"></i> Inicio</a>
                    <a href=""><i class="fa-solid fa-gauge-high"></i> DashBoard</a>
                    <a href="facturas.php"><i class="fa-solid fa-file-invoice-dollar"></i> Facturas</a>
                    <a href=""><i class="fa-solid fa-clipboard-list"></i> Presupuestos</a>
                    <a href="controlGaleria.php"><i class="fa-regular fa-images"></i> Galería</a>
                    <a href=""><i class="fa-solid fa-envelope"></i> Mensajes</a>
                    <a href=""><i class="fa-solid fa-house"></i> Calendario</a>
                    <a href=""><i class="fa-solid fa-list-check"></i> Tareas</a>
                    <a href=""><i class="fa-solid fa-ticket"></i> Tickets</a>
                    <a href=""><i class="fa-regular fa-user"></i> Perfil</a>
                    <a href="../php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</a>
                </div>
            </div>
            <div class="userPhoto">
                <img src="../imagenes/admin/FotoMichaelCV.JPG" alt="">
            </div>  
        </div>
    </header>
    <div class="home">
        <div class="home-container">
            <div class="navegador">
            <h6><a href="facturas.php">Facturación</a> > Añadir factura</h6>
            </div>

        </div>
    </div>
</body>
</html>