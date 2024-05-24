<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header("location: login.php");
    }
    require '../conexion.php'; 
    include '../projectsOPs/searchProjects.php';

    $nombreUsuario = $_SESSION['user'];

    try{
        $sql = "SELECT CompanyID, ID FROM Users Where user = :userName";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userName", $nombreUsuario, PDO::PARAM_STR);
        $stmt->execute();
    }catch(PDOException $e){
        echo 'error'. $e->getMessage();
    }
    if($stmt){
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $company_id = $row[0]['CompanyID'];
        $user_id = $row[0]['ID'];
    }else{
        echo "error de usuario";
    }

    function truncateString($string, $length = 25, $trailing = '...') {
        // Si la longitud del string es mayor que el límite definido
        if (strlen($string) > $length) {
            // Truncar el string a 23 caracteres y agregar el sufijo
            return substr($string, 0, $length - strlen($trailing)) . $trailing;
        } else {
            // Si no es mayor, devolver el string tal cual
            return $string;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="shortcut icon" href="../../imagenes/Logos/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../../css/headerDashBoardFocus.css">
    <link rel="stylesheet" href="../../css/projectsPage.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap JavaScript y dependencias Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
        <div class="logoContainer">
            <a href="php/dashboard.php">
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
                    <a href="dashboardPage.php"><i class="fa-solid fa-gauge-high"></i> DashBoard</a>
                    <a href="facturasPage.php"><i class="fa-solid fa-file-invoice-dollar"></i> Facturas</a>
                    <a href="presupuestosPage.php"><i class="fa-solid fa-clipboard-list"></i> Presupuestos</a>
                    <a href="presupuestosPage.php"><i class="fa-solid fa-users"></i> Clientes</a>
                    <a href="presupuestosPage.php"><i class="fa-solid fa-briefcase"></i> Servicios</a>
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
                <img src="../../imagenes/admin/FotoMichaelCV.JPG" alt="">
            </div>  
        </div>
    </header>

    <div class="facturas">
        <div class="facturas-container">
            <h5>Proyectos</h5>
                <nav class="navbar navbar-light">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Buscar..." aria-label="Search"id="searchInput">
                    </form>
                    <div class="aniadirElementoButton">
                        <a class="aniadirElementoButtonContainer" href="addProjectPage.php">
                            Añadir
                        </a>
                    </div>
                </nav>
            <table class="tablaReformas"> 
                <thead>
                    <tr class="filaTablaReforma rounded-top-2 px-2 border-bottom" id="tableHeader">
                        <th>
                            <i class="fa-solid fa-folder-open mx-1"></i>
                            Nombre del Proyecto
                        </th>
                        <th>
                            <i class="fa-solid fa-user mx-1"></i>
                            Cliente
                        </th>
                        <th class="text-center">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Prioridad
                        </th>
                        <th class="text-center">
                            <i class="fa-solid fa-calendar-xmark mx-1"></i>
                            Fecha Límite
                        </th>
                        <th class="text-center">
                            <i class="fa-solid fa-spinner mx-1"></i>
                            Estado
                        </th>
                        <th class="text-center">
                            <i class="fa-solid fa-location-pin mx-1"></i>
                            Ubicación
                        </th>
                        <th class="text-center">
                            <i class="fa-solid fa-ellipsis-vertical mx-1"></i>
                            Acciones
                        </th>
                    </tr>
                </thead>
                    <tbody id="budgetsTbody">
                        <?php
                            foreach($records as $resultado){
                                $projectID = $resultado['ProjectID'];
                                $projectName = truncateString($resultado['ProjectName'], 30); 
                                $customerName = truncateString($resultado['CustomerName'], 30); 
                                $projectPriority = $resultado['ProjectPriority'];
                                $exp_date = $resultado['EndDate'];
                                $projectLocation = truncateString($resultado['Place'], 25);
                                $estadoPresupuesto = $resultado['ProjectStatus'];

                                echo '<tr class="filaTablaReforma px-2 border-bottom">';
                                    echo '<td>' .$projectName. '</td>';
                                    echo '<td>' .$customerName.'</td>';
                                    echo '<td class="text-center d-flex align-items-center"> <p class="prioridad-'.$projectPriority.'">' .$projectPriority. '</p></td>';
                                    echo '<td class="text-center">' .$exp_date. '</td>';
                                    echo '<td class="text-center d-flex align-items-center"> <p class="estado-'.$estadoPresupuesto.'">' .$estadoPresupuesto. '</p></td>';
                                    echo '<td class="text-center">' .$projectLocation. '</td>';
                                    echo '<td>
                                            <a class="editar ms-auto me-2 text-success" href="projectDetails.php?id=' . $projectID . '"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <a class="borrar me-auto ms-2 text-danger" id="deleteProjectInput" onclick="deleteProject(' .$projectID. ')" data-id="' .$projectID. '"><i class="fa-solid fa-trash"></i></a>
                                            </td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>

                <nav class="justify-content-center">
                    <ul class="pagination pagination-sm">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">Anterior</a>
                            </li>
                        <?php endif; ?>

                        <?php
                        $range = 3;
                        $start = max(1, $page - $range);
                        $end = min($total_pages, $page + $range);

                        for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'activePag' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Siguiente</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>

<!-- Modal -->
    <div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6class="modal-title" id="exampleModalLongTitle">¿Estás seguro de que quieres eliminar este elemento? Eliminarás sus presupuestos y facturas</h6>
                </div>
                
                <div class="modal-footer">
                    <form id="confirmarEliminarForm" action="../ProjectsOPs/deleteProject.php" method="POST">
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
    <script src="../../js/Project/searchProject.js"></script>
    <script src="../../js/Project/projectsInterfacePage.js"></script>
    <script src="../../js/Project/deleteProject.js"></script>
</body>
</html>