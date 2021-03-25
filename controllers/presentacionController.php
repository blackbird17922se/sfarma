<?php
include '../models/presentacion.php';
$present = new Presentacion();

if($_POST['funcion']=='crear'){
    $nom = $_POST['nom_present'];
    $present->crear($nom);
}

if($_POST['funcion']=='editar'){
    $nom_present = $_POST['nom_present'];
    $id_editado = $_POST['id_editado'];
    $present->editar($nom_present,$id_editado);
}

if($_POST['funcion']=='buscar'){
    $present->buscar();
    $json=array();
    foreach($present->objetos as $objeto){
        $json[]=array(
            'id_present'=>$objeto->id_present,
            'nom'=>$objeto->nom
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if($_POST['funcion'] =='borrar'){
    /* OJO: $_POST['ID'] viene desde presentratorio.js en la const ID = $(ELEM).attr('presentId'); */
    $id_present = $_POST['ID'];
    $present->borrar($id_present);
}