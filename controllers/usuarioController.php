<?php
include '../models/usuario.php';
$usuario = new Usuario();

/* FUNCION buscarUsuario */
if($_POST['funcion'] == 'buscarUsuario'){

    /* Crear un json que sera utilizado luego */
    $json=array();

    /* Invocar una funcion del modelo paraobtener la informacion del usuario */
    $usuario->obtenerDatos($_POST['id']);
    /* Usar un foreach para recorrer todos los datos obtenidos de obtenerDatos() */
    /* $usuario->objetos >>> Proviene del return de la funcion obtenerDatos*/
    foreach ($usuario->objetos as $objeto) {
        /*  */
        $json[] = array(
            /* 'nombreLlave' => $objetoretornado -> nombre campo de la base de datos (o alias asignado) */
            'nom' => $objeto->nom,
            'ape' => $objeto->ape,
            'dni_us' => $objeto->dni_us,
            'rol' => $objeto->nom_rol
        );
    }

    /* Enviarle los datos a usuario.js en formato JSON. y le pasara el primer resultado que encuentre (indice 0) [0]
    ya que en el js no se hara un foreach ya que sse espera que de la consuta a la bd solo encuentre un
    solo registro del usuario que se esta buscando*/
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}


/* FUNCION para capturar datos */
if($_POST['funcion'] == 'capturarDatos'){

    $json=array();
    $id_usu = $_POST['id_usu'];

    $usuario->obtenerDatos($id_usu);

    foreach ($usuario->objetos as $objeto) {
        /*  */
        $json[] = array(
            'nom' => $objeto->nom,
            'ape' => $objeto->ape,
        );
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}


/* Ediatr */
if($_POST['funcion']=='editarUsuario'){
    $nom = $_POST['nom'];
    $ape = $_POST['ape'];
    $id_usu = $_POST['id_usu'];
    $usuario->editar($nom,$ape,$id_usu);
    echo 'editado';
}


/* Editar Password */
if($_POST['funcion']=='cambiarContras'){
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $id_usu = $_POST['id_usu'];
    $usuario->cambiarContras($oldpass,$newpass,$id_usu);
}


/* BUSQUEDA Y CARGA DE USUARIOS */
if($_POST['funcion'] == 'cargarUsuarios'){

    $json=array();

    $usuario->buscar();

    foreach ($usuario->objetos as $objeto) {
        /*  */
        $json[] = array(
            /* 'nombreLlave' => $objetoretornado -> nombre campo de la base de datos (o alias asignado) */
            'id_usu' =>$objeto->id_usu,
            'nom' => $objeto->nom,
            'ape' => $objeto->ape,
            'dni_us' => $objeto->dni_us,
            'rol' => $objeto->nom_rol
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}


/* CREAR USUARIOS */
if($_POST['funcion']=='crearUsuario'){

    $nom = $_POST['nom'];
    $ape = $_POST['ape'];
    $dni_us = $_POST['dni_us'];
    $contras = $_POST['contras'];
    $rol = $_POST['rol'];

    $usuario->crearUsuario($nom,$ape,$dni_us,$contras,$rol);
}


/* LISTAR EN EL FORMULARIO DE CREAR USUARIO LA LISTA DE ROLES */
if($_POST['funcion'] =='listarRoles'){
    $usuario->listarRoles();
    $json=array();
    foreach($usuario->objetos as $objeto){
        $json[]=array(
            'id_rol'=>$objeto->id_rol,
            'nom_rol'=>$objeto->nom_rol
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}


/* ELIMINAR USUARIO */
if($_POST['funcion'] =='borrar'){
    /* OJO: $_POST['ID'] viene desde labratorio.js en la const ID = $(ELEM).attr('labId'); */
    $id = $_POST['ID'];
    $usuario->borrar($id);
}


/* CONSULTAR USUARIO PARA OCULTA O O EL BORTON ELIMINAR (EXPERIMENTO ADANDONADO) */
if($_POST['funcion'] =='consultarRol'){
    session_start();

    $json=array();

    $json[] = array(

        'rol' => $_SESSION['rol']
    );

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;

}

