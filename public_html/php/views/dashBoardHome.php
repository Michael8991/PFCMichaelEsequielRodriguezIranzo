<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        $nombreUsuario = $_SESSION['user'];
        header("location: login.php");
    }

    require '../conexion.php'; // Incluir el archivo de conexión

    try {
        // Consulta SQL
        $consulta = "SELECT * FROM galeriaReformas";
        
        // Preparar la consulta
        $stmt = $conn->prepare($consulta);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados como un array asociativo
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Si deseas hacer algo con los resultados, puedes iterar sobre $resultados
        foreach ($resultados as $fila) {
            // Haz algo con cada fila, por ejemplo, imprimir el ID de la galería
            echo $fila['idGaleria'];
        }
    } catch (PDOException $e) {
        // Manejar errores de consulta
        echo "Error al ejecutar la consulta: " . $e->getMessage();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../imagenes/Logos/LogoSimpleBlanco.svg" type="image/x-icon">
    <title>DashBoard Home</title>

    <link rel="stylesheet" href="../../css/dashboardHome.css">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JavaScript y dependencias Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="logoContainer">
            <a href="/php/dashboard.php">
                <img src="../../imagenes/Logos/LogoSimple.png" alt="">
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
                        <a href=""><i class="fa-regular fa-user"></i> Perfil</a>
                        <a href="../../php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</a>
                    </div>
                </div>
                <div class="userPhoto">
                    <img src="../../imagenes/admin/FotoMichaelCV.JPG" alt="">
                </div>  
        </div>
    </header>
    <div class="home">
        <div class="homeContainer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="dashboardPage.php">
                            <i class="fa-solid fa-gauge-high"></i>
                            <p>DashBoard</p>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="facturasPage.php">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <p>Facturas</p>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="presupuestosPage.php">
                            <i class="fa-solid fa-clipboard-list"></i>
                            <p>Presupuestos</p>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="controlGaleria.php">
                            <i class="fa-regular fa-images"></i>
                            <p>Galería</p>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="https://mail.hostinger.com">
                            <i class="fa-solid fa-envelope"></i>
                            <p>Mensajes</p>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="calendarioPage.php">
                            <i class="fa-solid fa-house"></i>
                            <p>Calendario</p>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="">
                            <i class="fa-solid fa-list-check"></i>
                            <p>Tareas</p>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="">
                            <i class="fa-solid fa-ticket"></i>
                            <p>Tickets</p>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="clientesPage.php">
                            <i class="fa-solid fa-users"></i>
                            <p>Clientes</p>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="botonesNavegador" href="projectsPage.php">
                            <i class="fa-solid fa-folder-open"></i>
                            <p>Proyectos</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>