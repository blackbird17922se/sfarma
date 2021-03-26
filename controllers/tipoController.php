<?php
include '../models/tipo.php';
// include 'models/tipo.php';
$tipo = new Tipo();
if($_POST['funcion']=='crear'){
    $nom = $_POST['nom_tipo'];
    $tipo->crear($nom);
}

if($_POST['funcion']=='editar'){
    $nom_tipo = $_POST['nom_tipo'];
    $id_editado = $_POST['id_editado'];
    $tipo->editar($nom_tipo,$id_editado);
}

if($_POST['funcion']=='buscar'){
    $tipo->buscar();
    $json=array();
    foreach($tipo->objetos as $objeto){
        $json[]=array(
            'id_tipo_prod'=>$objeto->id_tipo_prod,
            'nom'=>$objeto->nom
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if($_POST['funcion'] =='borrar'){
    /* OJO: $_POST['ID'] viene desde tiporatorio.js en la const ID = $(ELEM).attr('tipoId'); */
    $id_tipo = $_POST['ID'];
    $tipo->borrar($id_tipo);
}

if($_POST['funcion'] =='listar_tipos'){
    $tipo->listar_tipos();
    $json=array();
    foreach($tipo->objetos as $objeto){
        $json[]=array(
            'id_tipo'=>$objeto->id_tipo_prod,
            /* OJO: ...=> $objeto->NOMBRE DEL CAMPO EL LA BD */
            'nom_tipo'=>$objeto->nom
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}