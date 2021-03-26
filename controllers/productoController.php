<?php
include '../models/producto.php';
$product = new Producto();

if($_POST['funcion']=='crear'){
    /* datos recibidos desde producto.js >>> $.post('../controllers/productoController.php',{fu... */
    // nombre,compos,adici,precio,prod_lab,prod_tipo,prod_present
    $nombre = $_POST['nombre'];
    $compos = $_POST['compos'];
    $adici = $_POST['adici'];
    $precio = $_POST['precio'];
    $prod_lab = $_POST['prod_lab'];
    $prod_tipo = $_POST['prod_tipo'];
    $prod_present = $_POST['prod_present'];
    // $nombre = $_POST['nombre'];
    $product->crear($nombre,$compos,$adici,$precio,$prod_lab,$prod_tipo,$prod_present);
}

if($_POST['funcion']=='editar'){
    /* datos recibidos desde producto.js >>> $.post('../controllers/productoController.php',{fu... */
    // nombre,compos,adici,precio,prod_lab,prod_tipo,prod_present
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $compos = $_POST['compos'];
    $adici = $_POST['adici'];
    $precio = $_POST['precio'];
    $prod_lab = $_POST['prod_lab'];
    $prod_tipo = $_POST['prod_tipo'];
    $prod_present = $_POST['prod_present'];
    // $nombre = $_POST['nombre'];
    $product->editar($id,$nombre,$compos,$adici,$precio,$prod_lab,$prod_tipo,$prod_present);
}

if($_POST['funcion']=='buscar'){
    $product->buscar();
    $json=array();
    foreach($product->objetos as $objeto){
        $json[]=array(
            // $nombre,$compos,$adici,$precio,$prod_lab,$prod_tipo,$prod_present

            'id_prod'=>$objeto->id_prod,
            'nombre'=>$objeto->nombre,
            'compos'=>$objeto->compos,
            'adici'=>$objeto->adici,
            'precio'=>$objeto->precio,
            'stock'=>'stock',
            /* '' =>$objeto->ALIAS ASIGNADO */
            'laboratorio'=>$objeto->laboratorio,
            'tipo'=>$objeto->tipo,
            'presentacion'=>$objeto->presentacion,
            'lab_id'=>$objeto->prod_lab,
            'tipo_id'=>$objeto->prod_tipo,
            'pres_id'=>$objeto->prod_pres
            // 'nom_lab'=>$objeto->nom_lab,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if($_POST['funcion'] =='borrar'){
    /* OJO: $_POST['ID'] viene desde labratorio.js en la const ID = $(ELEM).attr('labId'); */
    $id = $_POST['ID'];
    $product->borrar($id);
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