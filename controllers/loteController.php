<?php
include '../models/lote.php';
$lote = new Lote();

// funcion,lote_id_prod,nom_lote_lote,stock,vencim

if($_POST['funcion']=='crear'){

    $lote_id_prod = $_POST['lote_id_prod'];
    $lote_id_prov = $_POST['lote_id_prov'];
    $stock = $_POST['stock'];
    $vencim = $_POST['vencim'];

    $lote->crear($lote_id_prod,$lote_id_prov,$stock,$vencim);
}