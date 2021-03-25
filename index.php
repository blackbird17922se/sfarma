<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <!-- font awess -->
    <link rel="stylesheet" href="public/css/css/all.min.css">
</head>
<?php
session_start();
// si session esta vacia..
if(!empty($_SESSION['rol'])){
    header("Location: controllers/loginController.php");
}else{
    session_destroy();

?>
<body id="body-login">
<div class="contenedor-login">
    <form action="controllers/loginController.php" method="POST">
    <h2>Farmacia</h2>
        <div class="input-div correo">
            <div class="i">
                <i class="fas fa-user"></i>
            </div>
            <div class="div">
                <h5>DNI</h5>
                <input type="number" name="user" class="input">
            </div>
        </div>

        <div class="input-div pass">
            <div class="i">
                <i class="fas fa-lock"></i>
            </div>
            <div class="div">
                <h5>contraseña</h5>
                <input type="password" name="pass" class="input">
            </div>
        </div>
        <input type="submit" class="btn" value="iniciar sesion">
    
    </form>
</div>

    
</body>
</html>
<?php
}

?>