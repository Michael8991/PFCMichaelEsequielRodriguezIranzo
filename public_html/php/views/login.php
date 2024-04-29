<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../../css/login.css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <img src="../../imagenes/Logos/LogoSimple.png" alt="">
            <h1>Panel de Administrador</h1>
            <p>Inicio al panel de control</p>
            <form class="login-form" action= "../loginOPs/validar.php" method="POST">
                <input type="text" name="user" placeholder="Usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required> 
                <input class="confirmButton" type="submit" value="Acceder">
            </form>
        </div>
    </div>

      <script src="../../js/login.js"></script>
</body>
</html>