<?php
require 'conexion.php';
session_start();


$consultaReformas = "SELECT * FROM galeriaReformas";
$ejConsReformas = mysqli_query($conexion, $consultaReformas);

if (!$ejConsReformas) {
    die("Error al ejecutar la consulta: " . mysqli_error($conexion));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria</title>

    

    <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>
  
    
   
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Krona One">

    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/galeria.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
    <header id="miCabecera" style="position: static;">
        <div id="contenedor">
            <div class="company-logo">
                <a href="../index.html">
                    <img src="../imagenes/Logos/LogoSimple.png" alt="">
                    
                </a>
                <div class="logoText">
                    <strong class="left">CONSTRUCCIONES & REFORMAS</strong>
                    <span class="left">Especialistas en Alicatados y Solados </span>
                </div>
            </div>
            <div class="navbar">
                <div class="nav-items" >
                  <li class="nav-item">
                      <a href="../index.html#home" class="smoothscroll"><i class="fa-sharp fa-solid fa-circle"></i>Inicio</a>
                  </li>
                  <li class="nav-item">
                      <a href="../index.html#aboutus" class="smoothscroll"><i class="fa-sharp fa-solid fa-circle"></i>Nosotros</a>
                  </li>
                  <li class="nav-item">
                      <a class="active" href="../index.html#works" class="smoothscroll"><i class="fa-sharp fa-solid fa-circle"></i>Nuestos Trabajos</a>
                  </li>
                  <li class="nav-item">
                      <a class="" href="contacta.php"><i class="fa-sharp fa-solid fa-circle"></i>Contáctanos</a>
                  </li>
              </div>
            </div>
             <!-- navegador para movil y tablets -->
             <nav class="navham">
                <div id="menuToggle">
                    <input type="checkbox" />
                    <span></span>
                    <span></span>
                    <span></span>
                    <ul id="menu">
                    <li class="nav-item">
                            <a href="../index.html" class="smoothscroll">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a href="../index.html#aboutus" class="smoothscroll">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a href="../index.html#works" class="smoothscroll">Nuestos Trabajos</a>
                        </li>
                        <li class="nav-item">
                            <a href="contacta.php">Contáctanos</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- navegador para movil y tablets -->
        </div>
      </header>
        <div class="gallery">
            <div class="galleryContainer">
                <div class="container">
                    <div class="row">
                    <?php
                    while ($rowReformas = mysqli_fetch_assoc($ejConsReformas)) {
                        $reformaId = $rowReformas['nReferencia']; 
                        $consultaImagenes = "SELECT ruta_imagen FROM imagenes WHERE reforma_id = $reformaId";
                        $ejConsImagenes = mysqli_query($conexion, $consultaImagenes);
                        
                        if (!$ejConsImagenes) {
                            die("Error al ejecutar la consulta de imágenes: " . mysqli_error($conexion));
                        }
                        
                        $rowImagenes = mysqli_fetch_assoc($ejConsImagenes);
                        $primeraImagen = $rowImagenes['ruta_imagen'];
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card" id="card">
                            <a href="/html/galeriadetalle.html">
                                <h1><img src="<?php echo $primeraImagen; ?>" alt="Imagen de la reforma"></h1>
                            </a>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <footer>
        <div class="container">
            <div class="row">
                <a href="">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-facebook"></i>
                </a>
            </div>
            <div class="row">
                <li>
                    <a href="">Terminos de uso</a>
                </li>
                <li>
                    <a href="">Politicas de privacidad</a>
                </li>
           <!-- </div>
            <div class="row">-->
                <span>© 2023 Marca registrada</span>
            <!-- </div>
            <div class="row">--> 
                Diseñado por Michael
            </div>
        </div>
    </footer>
</body>
</html>

<?php
mysqli_close($conexion);
?>