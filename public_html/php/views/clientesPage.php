<?php
session_start();

if (!isset($_SESSION['user'])) {
    $nombreUsuario = $_SESSION['user'];
    header("location: login.php");
}

require 'conexion.php'; // Incluir el archivo de conexión


$consulta = "SELECT * FROM Clientes";

$ejCons = mysqli_query($conexion, $consulta);

if (!$ejCons) {
    die("Error al ejecutar la consulta: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="shortcut icon" href="../imagenes/Logos/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../css/headerDashBoardFocus.css">
    <link rel="stylesheet" href="../css/clientesPage.css">

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
                    <a href="dashboardPage.php"><i class="fa-solid fa-gauge-high"></i> DashBoard</a>
                    <a href="factuasPage.php"><i class="fa-solid fa-file-invoice-dollar"></i> Facturas</a>
                    <a href="presupuestosPage.php"><i class="fa-solid fa-clipboard-list"></i> Presupuestos</a>
                    <a href="controlGaleria.php"><i class="fa-regular fa-images"></i> Galería</a>
                    <a href="https://mail.hostinger.com/"><i class="fa-solid fa-envelope"></i> Mensajes</a>
                    <a href="calendarioPage.php"><i class="fa-solid fa-house"></i> Calendario</a>
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

    <div class="facturas">
        <div class="facturas-container">
            <h5>Facturación</h5>
                <nav class="navbar navbar-light">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Buscar..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                    <div class="aniadirElementoButton">
                        <a class="aniadirElementoButtonContainer" href="aniadirPresupuestoPage.php">
                            + Añadir
                        </a>
                    </div>
                </nav>
            <table class="tablaReformas"> 
                    <tr class="filaTablaReforma">
                        <th>ID Cliente</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                        
                    </tr>
                    <?php
                        mysqli_data_seek($ejCons, 0);//Reinicio de puntero
                
                        while ($row = mysqli_fetch_assoc($ejCons)) {

                            $elementoId = $row['ClienteID']; 
                            $nombre = $row['Nombre']; 
                            $apellido = $row['Apellido'];
                            $telefonoCliente = $row['Telefono'];
                            $email = $row['Email'];
                            $direccion = $row['Direccion'];
    
                            
        
                
                            // Imprime la lista de elementos con el atributo data-id configurado
                            echo '<tr class="filaTablaReforma">';
                                echo '<td>' .$elementoId. '</td>';
                                echo '<td>' .$nombre. '</td>';
                                echo '<td>' .$apellido. '</td>';
                                echo '<td>' .$telefonoCliente. '</td>';
                                echo '<td>' .$email. '</td>';
                                echo '<td>' .$direccion. '</td>';
                                echo '<td><a class="editar" href=""> <i class="fa-regular fa-pen-to-square"></i> </a> <a class="borrar" href="../js/dashBoard.js" data-id="' .$elementoId. '"> <i class="fa-solid fa-trash"></i> </a> </td>';
                            echo '</tr>';
                        }
                    ?>
                </table>
                <nav class="justify-content-center" aria-label="...">
                    <ul class="pagination pagination-sm">
                        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                    </ul>
                </nav>
                <!-- </ul> -->
            </div>
        </div>
        Button trigger modal
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
    Launch demo modal
    </button>

<!-- Modal -->
    <div class="modal fade" id="confirmarEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6class="modal-title" id="exampleModalLongTitle">¿Estás seguro de que quieres eliminar este elemento?</h6>
                </div>
                
                <div class="modal-footer">
                    <form id="confirmarEliminarForm" action="operacionEliminarElementoGaleria.php" method="POST">
                        <!-- Campo oculto para almacenar el ID del elemento a eliminar -->
                        <input type="hidden" id="elementoIdInput" name="elemento_id" value="">
                        <button type="submit" class="btn btn-primary">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</body>
</html>