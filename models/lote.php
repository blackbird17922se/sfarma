<?php
include 'conexion.php';
class Lote{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }

    function crear($lote_id_prod,$lote_id_prov,$stock,$vencim){

        $sql = "INSERT INTO lote (lote_id_prod,lote_id_prov,stock,vencim) 
        VALUES (:lote_id_prod,:lote_id_prov,:stock,:vencim)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':lote_id_prod'     => $lote_id_prod,
            ':lote_id_prov'     => $lote_id_prov,
            ':stock'            => $stock,
            ':vencim'           => $vencim
        ));
        echo 'add';
    }
}

