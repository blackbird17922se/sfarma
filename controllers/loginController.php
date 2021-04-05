<?php
include_once "../models/usuario.php";
session_start();
$user = $_POST['user'];
$pass = $_POST['pass'];

$usuario = new Usuario();

// si hay una sesion en curso..
if(!empty($_SESSION['rol'])){
    switch ($_SESSION['rol']) {
        // enrutar
        case 1:
            header("Location: ../views/adm_cat.php");
        break;
        case 2:
            header("Location: ../views/adm_cat.php");
        break;
    }  

}else{

    // ejecutar consulta
    if(!empty($usuario->logIn($user,$pass)=="logueado")){
        $usuario->obtenerDatosLog($user);
        foreach($usuario->objetos as $objeto){
            $_SESSION['usuario'] = $objeto->id_usu;
            $_SESSION['rol'] = $objeto->rol;
            $_SESSION['nom'] = $objeto->nom;
        }
        switch ($_SESSION['rol']) {
            // admin
            case 1:
                header("Location: ../views/adm_cat.php");
            break;
            case 2:
                header("Location: ../views/adm_cat.php");
            break;
        }  
    }else{
        header("Location: ../index.php");
    }
}