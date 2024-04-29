//Antiguo

<?php
session_start();

if (!isset($_SESSION['user'])) {
    $nombreUsuario = $_SESSION['user'];
    header("location: login.php");
}

require 'conexion.php'; // Incluir el archivo de conexión

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
        echo $fila['galeriaID'];
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
    <title>Panel de Administrador JJ</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="../css/dashboardv2.css">
    <!-- ICONOS FONTAWESOME -->
    <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>

    <!-- REJILLAS BOOTSTRAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
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
                    <button class="dropbtn"><a class="titleBottonUser" href=""><?php $nombreUsuario = $_SESSION['user']; echo $nombreUsuario ?> <i class="fa-solid fa-angle-down"></i></a></button>
                    <div class="dropdown-content">
                        <a href=""><i class="fa-regular fa-user"></i> Perfil</a>
                        <a href="../php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</a>
                    </div>
                </div>
                <div class="userPhoto">
                    <img src="../imagenes/admin/FotoMichaelCV.JPG" alt="">
                </div>  
        </div>
    </header>
    <div class="dashBoard">
        <div class="dashBoardContainer">
            <div class="navDashBoard">
                <div class="navDashBoardContainer">
                    <a class="active" data-target="#slide-0"><i class="fa-solid fa-gauge-high"></i>Dashboard <div class="seccionActiva"></div></a>
                    <a class="" data-target="#slide-1"><i class="fa-regular fa-images"></i>Galeria <div class="seccionActiva"></div></a>
                    <a class="" data-target="#slide-2"><i class="fa-solid fa-envelope"></i>Mensajes <div class="seccionActiva"></div></a>
                    <a class="" data-target="#slide-3"><i class="fa-solid fa-calendar-days"></i>Calendario <div class="seccionActiva"></div></a>
                    <a class="" data-target="#slide-4"><i class="fa-solid fa-list-check"></i>Tareas <div class="seccionActiva"></div></a>
                    <a class="" data-target="#slide-5"><i class="fa-regular fa-file-excel"></i>Presupuestos <div class="seccionActiva"></div></a>
                    <a class="" data-target="#slide-6"><i class="fa-solid fa-ticket"></i>Notas y Mensajes internos <div class="seccionActiva"></div></a>
                </div>
            </div>
            <div class="sliderContainer">
                <div class="slider-wrapper">
                    <div class="slider">
                        <!-- DASHBOAD -->
                        <div class="paneles" id="#slide-0"></div>
                        <!-- GALERIA -->
                        <div class="paneles" id="#slide-1"> 
                            <p>Galeria de reformas</p>
                            <ul>
                                <?php
                                    mysqli_data_seek($ejCons, 0);//Reinicio de puntero
                            
                                    while ($row = mysqli_fetch_assoc($ejCons)) {
                                        $elementoId = $row['nReferencia']; 
                                        $tituloReforma = $row['tituloReforma']; 
                                        $fechaPublicacion = $row['fecha_publicacion'];
                                        $authorUserName = $row['userName'];$authorUserName = $row['userName'];
                                        $consultaImagenes = "SELECT ruta_imagen FROM imagenes WHERE reforma_id = $elementoId";
                                        $ejConsImagenes = mysqli_query($conexion, $consultaImagenes);
                                        
                            
                                        if (!$ejConsImagenes) {
                                            die("Error al ejecutar la consulta de imágenes: " . mysqli_error($conexion));
                                        }
                                        $caracteresMaximos = 35; // Número máximo de caracteres que deseas mostrar

                                        // Verificar la longitud del texto
                                        if (strlen($tituloReforma) > $caracteresMaximos) {
                                            // Si el texto es más largo que el límite, truncarlo y agregar puntos suspensivos
                                            $tituloRecortado = substr($tituloReforma, 0, $caracteresMaximos) . '...';
                                        } else {
                                            // Si el texto es igual o más corto que el límite, mantenerlo igual
                                            $tituloRecortado = $tituloReforma;
                                        }
                                        $rowImagenes = mysqli_fetch_assoc($ejConsImagenes);
                                        $primeraImagen = $rowImagenes['ruta_imagen'];
                            
                                        // Imprime la lista de elementos con el atributo data-id configurado
                                        echo '<li>';
                                        echo '<div class="vistaPreviaElementoReformaGaleria" data-id="' . $elementoId . '">';
                                        echo '<img src="' . $primeraImagen . '" alt="Imagen de la reforma">';
                                        echo '<p>' .$authorUserName. '</p>';
                                        echo '<p>' . $tituloRecortado . '</p>';
                                        echo '<p>Fecha de publicación: ' . $fechaPublicacion . '</p>';
                                        echo '<div class="accionesReformaExistente">';
                                        echo '<a class="editar" href=""> <i class="fa-regular fa-pen-to-square"></i> </a>';
                                        echo '<a class="borrar" href="../js/dashBoard.js" data-id="' . $elementoId . '"> <i class="fa-solid fa-trash"></i> </a>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</li>';
                                    }
                                ?>
                                <div class="aniadirElementoButton">
                                    <a class="aniadirElementoButtonContainer" href="">
                                        <i class="fa-solid fa-plus"></i>AÑADIR ELEMENTO
                                    </a>
                                </div>
                            </ul>
                        </div>
                        <!-- MENSAJES -->
                        <div class="paneles" id="#slide-2">
                            <div class="tituloMensajeContainer"><h1>Comprobemos desde el webMail si hay correos nuevos, accede al siguiente enlace e introduce los credenciales.</h1></div>
                            <button class="webMailButton">
                                <a href="https://mail.hostinger.com/">
                                <div class="svg-wrapper-1">
                                  <div class="svg-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                      <path fill="none" d="M0 0h24v24H0z"></path>
                                      <path fill="currentColor" d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path>
                                    </svg>
                                  </div>
                                </div>
                                <span>Vamos a comprobar el correo</span>
                            </a>
                              </button>
                        </div>
                        <!-- CALENDARIO -->
                        <div class="paneles" id="#slide-3"></div>
                        <!-- TAREAS -->
                        <div class="paneles" id="#slide-4"></div>
                        <!-- PRESUPUSTOS -->
                        <div class="paneles" id="#slide-5"></div>
                        <!-- MENSAJES INTERNOS -->
                        <div class="paneles" id="#slide-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="confirmarEliminar" class="modal">
        <div class="modal-content">
            <h2>¿Estás seguro de que quieres eliminar este elemento?</h2>
            <form id="confirmarEliminarForm" action="operacionEliminarElementoGaleria.php" method="POST">
                <!-- Campo oculto para almacenar el ID del elemento a eliminar -->
                <input type="hidden" id="elementoIdInput" name="elemento_id" value="">
                <button type="submit">Eliminar</button>
                <button type="button" onclick="cerrarModal()">Cancelar</button>
            </form>
        </div>
    </div>
    <div id="formularioAgregar" class="modal">
        <div class="modal-content">
            <h2>Formulario para Agregar Reformas</h2>
            <form id="formularioAgregarForm" action="operacionAniadirGaleria.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="username" value="<?php $username = $_SESSION['user']; echo $username; ?>">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required><br>
                
                <label for="descripcion">Descripción:</label><br>
                <textarea id="descripcion" name="descripcion" rows="4" cols="50" required></textarea><br>

                <label for="imagenes">Imágenes:</label>
                <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*" required><br>

                <input type="submit" value="Agregar Reforma">
                <button type="button" onclick="cerrarModalAgregar()">Cancelar</button>
            </form>
        </div>
    </div>

    <script src="../js/dashBoard.js"></script>
    
</body>
</html>