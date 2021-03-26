<?php
include '../models/laboratorio.php';
// include 'models/laboratorio.php';
$lab = new Laboratorio();
if($_POST['funcion']=='crear'){
    $nom = $_POST['nom_lab'];
    $lab->crear($nom);
}

if($_POST['funcion']=='editar'){
    $nom_lab = $_POST['nom_lab'];
    $id_editado = $_POST['id_editado'];
    $lab->editar($nom_lab,$id_editado);
}

if($_POST['funcion']=='buscar'){
    $lab->buscar();
    $json=array();
    foreach($lab->objetos as $objeto){
        $json[]=array(
            'id_lab'=>$objeto->id_lab,
            'nom_lab'=>$objeto->nom_lab
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if($_POST['funcion'] =='borrar'){
    /* OJO: $_POST['ID'] viene desde labratorio.js en la const ID = $(ELEM).attr('labId'); */
    $id_lab = $_POST['ID'];
    $lab->borrar($id_lab);
}

if($_POST['funcion'] =='listar_labs'){
    $lab->listar_labs();
    $json=array();
    foreach($lab->objetos as $objeto){
        $json[]=array(
            'id_lab'=>$objeto->id_lab,
            'nom_lab'=>$objeto->nom_lab
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}