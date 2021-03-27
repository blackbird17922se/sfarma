<?php
include '../models/proveed.php';
$proveed = new Proveed();

if($_POST['funcion']=='crear'){
    /* datos recibid_provos desde proveedo.js >>> $.post('../controllers/proveedoController.php',{fu... */
    $nom = $_POST['nom'];
    $telef = $_POST['telef'];
    $correo = $_POST['correo'];
    $direc = $_POST['direc'];

    $proveed->crear($nom,$telef,$correo,$direc);
}

if($_POST['funcion']=='editar'){
    /* datos recibid_provos desde proveedo.js >>> $.post('../controllers/proveedoController.php',{fu... */
    $id_prov = $_POST['id_prov'];
    $nom = $_POST['nom'];
    $telef = $_POST['telef'];
    $correo = $_POST['correo'];
    $direc = $_POST['direc'];

    $proveed->editar($id_prov,$nom,$telef,$correo,$direc);
}

if($_POST['funcion']=='buscar'){
    $proveed->buscar();
    $json=array();
    foreach($proveed->objetos as $objeto){
        $json[]=array(
            'id_prov'=>$objeto->id_prov,
            'nom'=>$objeto->nom,
            'telef'=>$objeto->telef,
            'correo'=>$objeto->correo,
            'direc'=>$objeto->direc,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if($_POST['funcion'] =='borrar'){
    /* OJO: $_POST['id_prov'] viene desde labratorio.js en la const id_prov = $(ELEM).attr('labid_prov'); */
    $id_prov = $_POST['ID'];
    $proveed->borrar($id_prov);
}

if($_POST['funcion'] =='listar_proveeds'){
    $proveed->listar_proveeds();
    $json=array();
    foreach($proveed->objetos as $objeto){
        $json[]=array(
            'id_proveed'=>$objeto->id_prov,
            'nom_proveed'=>$objeto->nom
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}