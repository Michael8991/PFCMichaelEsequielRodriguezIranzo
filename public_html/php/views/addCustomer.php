<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
require '../conexion.php'; // Incluir el archivo de conexión

$nombreUsuario = $_SESSION['user'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Cliente</title>
    <link rel="shortcut icon" href="../../imagenes/Logos/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../../css/headerDashBoardFocus.css">
    <link rel="stylesheet" href="../../css/aniadirPresupuestoPage.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap JavaScript y dependencias Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>

</head>
<body>
<svg id="visual2" viewBox="0 0 900 900" width="900" height="900" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
        <rect x="0" y="0" width="900" height="900" fill="#fff"></rect>
        <defs>
            <linearGradient id="grad1_0" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="30%" stop-color="#f2622e" stop-opacity="1"></stop>
                <stop offset="70%" stop-color="#f2622e" stop-opacity="1"></stop>
            </linearGradient>
        </defs>
        <defs>
            <linearGradient id="grad1_1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="30%" stop-color="#f2622e" stop-opacity="1"></stop>
                <stop offset="70%" stop-color="#ffffff" stop-opacity="1"></stop>
            </linearGradient>
        </defs>
        <g transform="translate(900, 0)">
            <path d="M0 286.4C-28.8 263.1 -57.5 239.9 -95.3 230C-133.1 220.2 -179.8 223.9 -202.5 202.5C-225.2 181.1 -223.8 134.7 -233.7 96.8C-243.7 58.9 -265 29.4 -286.4 0L0 0Z" fill="#ffb294"></path>
            <path d="M0 143.2C-14.4 131.6 -28.8 119.9 -47.6 115C-66.5 110.1 -89.9 111.9 -101.2 101.3C-112.6 90.6 -111.9 67.4 -116.9 48.4C-121.9 29.4 -132.5 14.7 -143.2 0L0 0Z" fill="#f2622e"></path>
        </g>
    </svg>

    <svg id="visual1" viewBox="0 0 900 900" width="900" height="900" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
        <rect x="0" y="0" width="900" height="900" fill="#fff"></rect>
        <defs>
            <linearGradient id="grad2_0" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="30%" stop-color="#f2622e" stop-opacity="1"></stop>
                <stop offset="70%" stop-color="#f2622e" stop-opacity="1"></stop>
            </linearGradient>
        </defs>
        <defs>
            <linearGradient id="grad2_1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="30%" stop-color="#ffffff" stop-opacity="1"></stop>
                <stop offset="70%" stop-color="#f2622e" stop-opacity="1"></stop>
            </linearGradient>
        </defs>
        <g transform="translate(0, 900)">
            <path d="M0 -286.4C32.1 -271.1 64.3 -255.8 101.4 -244.8C138.5 -233.9 180.7 -227.3 202.5 -202.5C224.3 -177.7 225.9 -134.7 236.5 -98C247.1 -61.2 266.7 -30.6 286.4 0L0 0Z" fill="#ffb294"></path>
            <path d="M0 -143.2C16.1 -135.5 32.1 -127.9 50.7 -122.4C69.3 -116.9 90.3 -113.6 101.2 -101.2C112.2 -88.9 113 -67.4 118.3 -49C123.6 -30.6 133.4 -15.3 143.2 0L0 0Z" fill="#f2622e"></path>
        </g>
    </svg>
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
                    <a href="dashboardHome.php"><i class="fa-solid fa-house"></i> Inicio</a>
                    <a href=""><i class="fa-solid fa-gauge-high"></i> DashBoard</a>
                    <a href="presupuestosPage.php"><i class="fa-solid fa-file-invoice-dollar"></i> Facturas</a>
                    <a href=""><i class="fa-solid fa-clipboard-list"></i> Presupuestos</a>
                    <a href="controlGaleria.php"><i class="fa-regular fa-images"></i> Galería</a>
                    <a href=""><i class="fa-solid fa-envelope"></i> Mensajes</a>
                    <a href=""><i class="fa-solid fa-house"></i> Calendario</a>
                    <a href=""><i class="fa-solid fa-list-check"></i> Tareas</a>
                    <a href=""><i class="fa-solid fa-ticket"></i> Tickets</a>
                    <a href=""><i class="fa-regular fa-user"></i> Perfil</a>
                    <a href="../logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</a>
                </div>
            </div>
            <div class="userPhoto">
                <img src="../../imagenes/admin/FotoMichaelCV.JPG" alt="">
            </div>  
        </div>
    </header>
    <div class="home">
    
        <div class="header-title mx-auto my-3" style="width:70%; position:relative;">
            <h2>Crear cliente</h2>
        </div>
        <div class="home-container">    
            <div class="form-container">
                <form class="addBudgetForm" id="addProjectForm" action="../CustomersOPs/insertCustomer.php" method="POST">
                    <div class="section-form" id="generalDatasSection">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Número de Teléfono:</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>

                    <div class="rowBudget align-center" style="z-index:2;">
                        <button type="button" class="btn btn-primary btn-success ms-auto" id="btnSubmitBudgetForm" onclick="openSaveModal()" data-toggle="modal">Guardar</button>
                        <button type="button" class="btn btn-secondary btn-danger ms-auto" data-toggle="modal" onclick="openCancelModal()">Cancelar</button>
                    </div>
                    
                </form>

                
            </div>
        </div>
        <div class="modal fade" id="confirmSaveModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Guardar formulario</h5>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas guardar los cambios? Los cambios se reflejarán en el listado de presupuestos.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeSaveModal()">Continuar</button>
                                <button type="submit" class="btn btn-primary btn-success" form="addProjectForm">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="confirmCancelModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmCancelModalLabel">Cancelar presupuesto</h5>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas cancelar el formulario?<br>Perderás el proceso y volverás al inicio.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCancelModal()">Continuar</button>
                                <a class="btn btn-primary btn-danger" href="./dashBoardHome.php" >Aceptar</a>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    <script src="../../js/Project/addProject.js"></script>
</body>
</html>