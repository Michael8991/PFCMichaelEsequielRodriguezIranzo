<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contactanos</title>
  
  <link rel="stylesheet" href="../css/header.css">

  <link rel="stylesheet" href="../css/contacta.css">

  <link rel="stylesheet" href="/css/footer.css">

  <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 

  <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Krona One">
</head>
  <body>
    <header id="miCabecera">
        <div id="contenedor">
            <div class="company-logo">
                <a href="/index.html">
                    <img src="../imagenes/Logos/LogoSimple.png" alt="">
                    
                </a>
                <div class="logoText">
                    <strong class="left">CONSTRUCCIONES & REFORMAS</strong>
                    <span class="left">Especialistas en Alicatados y Solados </span>
                </div>
            </div>
            <div class="navbar">
                <ul class="nav-item-container" >
                    <div class="nav-items">
                        <li class="nav-item">
                            <a href="../index.html" class="smoothscroll"><i class="fa-sharp fa-solid fa-circle"></i>Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a href="../index.html#aboutus" class="smoothscroll"><i class="fa-sharp fa-solid fa-circle"></i>Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a href="../index.html#works" class="smoothscroll"><i class="fa-sharp fa-solid fa-circle"></i>Nuestos Trabajos</a>
                        </li>
                    </div>
                    <li class="nav-item">
                        <a class="active" href="php/contacta.php"><i class="fa-sharp fa-solid fa-circle"></i>Contáctanos</a>
                    </li>
                </ul>
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
                            <a href="php/contacta.php">Contáctanos</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- navegador para movil y tablets -->

        </div>
    </header>
    <div class="formulario">
        <div class="contenedor">
            <div class="formContainer">
                <form action="mail.php" method="POST">
                    <h2>Escribenos</h2>
                    <p>Nuestro formulario de contacto es el primer paso para expresar tus necesidades en una reforma. Simplemente cuéntanos brevemente lo que tienes en mente, y nos comunicaremos contigo para hablar más a fondo sobre tu proyecto.</p>
                    <input class="inputs" type="text" id="nombre" name="nombre" placeholder="Nombre y Apellido" required>
                
                    <br>

                    <input class="inputs" type="tel" id="telefono" name="telefono" placeholder="Teléfono" required>
                    
                    <br>

                    <input class="inputs" type="email" id="email" name="email" placeholder="Correo Electrónico" required>
                    <br>

                    <textarea class="inputs" id="mensaje" name="mensaje" rows="4" placeholder="Escribe aquí tu mensaje" required></textarea>
                    <br>

                    <button class="learn-more">
                        <span class="circle" aria-hidden="true">
                            <span class="icon arrow"></span>
                        </span>
                        <span class="button-text">Enviar<input class="inputSend" type="submit" value=""></span>
                    </button>
                    
                    
                    

                </form>
            </div>
                <div class="form-overlay"></div>
                <div class="icon fa fa-phone" id="form-container">
                    <span class="icon fa fa-close" id="form-close"></span>
                    <div id="form-content">
                        <div id="form-head">
                            <h2>Te llamamos</h2>
                            <p>Introduce tu número y nos pondremos en contacto contigo.</p>
                        </div>
                        <form action="mailphone.php" method="POST">
                            <input class="inputs" type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                            <br>
                            <input class="inputs" type="tel" id="telefono" name="telefono" placeholder="Teléfono" required>
                            <br>
                            <button class="learn-more">
                                <span class="circle" aria-hidden="true">
                                    <span class="icon arrow"></span>
                                </span>
                                <span class="button-text">Enviar<input class="inputSend" type="submit" value=""></span>
                            </button>
                        </form>
                        <div class="whatsapp">
                            <h4>Estamos en Whatsapp</h4>
                            <div class="whatsappQR"><img src="../imagenes/contact/qrwhatsappmichael-removebg-preview.png" alt=""></div>
                            <p>Escanea el código QR con la aplicación de WhatsApp para añadirnos.</p>
                        </div>
                    </div>
                </div>

            <div class="nosotrosContactamos">
                <h2>Te llamamos</h2>
                <p>Introduce tu número y nos pondremos en contacto contigo.</p>
                <form action="mailphone.php" method="POST">
                    
                    <input class="inputs" type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                    <br>
            
                    <input class="inputs" type="tel" id="telefono" name="telefono" placeholder="Teléfono" required>
                    <br>
                    
                    <button class="learn-more">
                        <span class="circle" aria-hidden="true">
                            <span class="icon arrow"></span>
                        </span>
                        <span class="button-text">Enviar<input class="inputSend" type="submit" value=""></span>
                    </button>
                    
                </form>
                <div class="whatsapp">
                    <h4>Estamos en Whatsapp</h4>
                    <div class="whatsappQR"><img src="../imagenes/contact/qrwhatsappmichael-removebg-preview.png" alt=""></div>
                    <p>Escanea el código QR con la aplicación de WhatsApp para añadirnos.</p>
                </div>
            </div>
            <div class="redes">
                <div class="socialMedia-container">
                    <ul class="wrapper">
                        <li class="icon facebook">
                          <span class="tooltip">Facebook</span>
                          <span><i class="fab fa-facebook-f"></i></span>
                        </li>
                        <li class="icon twitter">
                          <span class="tooltip">Twitter</span>
                          <span><i class="fab fa-twitter"></i></span>
                        </li>
                        <li class="icon instagram">
                          <span class="tooltip">Instagram</span>
                          <span><i class="fab fa-instagram"></i></span>
                        </li>
                        <li class="icon github">
                          <span class="tooltip">Github</span>
                          <span><i class="fab fa-github"></i></span>
                        </li>
                        <li class="icon youtube">
                          <span class="tooltip">Youtube</span>
                          <span><i class="fab fa-youtube"></i></span>
                        </li>
                      </ul>
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
    <script src="../js/expandingContact.js"></script>
  </body>
  
</html>