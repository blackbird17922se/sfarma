<?php
include_once "../models/usuario.php";
session_start();
$user = $_POST['user'];
$pass = $_POST['pass'];

$usuario = new Usuario();
$usuario->logIn($user,$pass);
foreach($usuario->objetos as $objeto){
    print_r($objeto);
}
// echo "";
// echo $user;
// echo "";
// echo $pass;
// loginController