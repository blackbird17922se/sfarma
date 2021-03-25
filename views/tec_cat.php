<?php
session_start();
if(!empty($_SESSION['rol']==2)){

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
</head>
<body>
<h1>Tec</h1>
<a href="../controllers/logout.php">Cerrar</a>
    
</body>
</html>

<?php

}else{
    // session_destroy();
    header("Location: ../views/login.php");
}
?>