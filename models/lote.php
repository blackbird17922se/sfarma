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


    function buscar(){
        if(!empty($_POST['consulta'])){
            /* si el imput de bsiqueda esta lleno entonces */
            $consulta = $_POST['consulta'];
            $sql="SELECT id_lote, stock, vencim, producto.nombre as prod_nom, compos, adici, 
            laboratorio.nom_lab AS lab_nom, tipo_prod.nom AS tipo_nom, present.nom AS pre_nom, proveed.nom AS prov_nom
            FROM lote
            JOIN proveed ON lote_id_prov = id_prov
            JOIN producto ON lote_id_prod = id_prod
            JOIN laboratorio ON prod_lab = id_lab
            JOIN tipo_prod ON prod_tipo = id_tipo_prod
            JOIN present ON prod_pres = id_present AND producto.nombre LIKE :consulta ORDER BY producto.nombre";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql="SELECT id_lote, stock, vencim, producto.nombre as prod_nom, compos, adici, 
            laboratorio.nom_lab AS lab_nom, tipo_prod.nom AS tipo_nom, present.nom AS pre_nom, proveed.nom AS prov_nom
            FROM lote
            JOIN proveed ON lote_id_prov = id_prov
            JOIN producto ON lote_id_prod = id_prod
            JOIN laboratorio ON prod_lab = id_lab
            JOIN tipo_prod ON prod_tipo = id_tipo_prod
            JOIN present ON prod_pres = id_present AND producto.nombre NOT LIKE '' ORDER BY producto.nombre";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }

    function editar($lote_id_prod,$stock){
        $sql = "UPDATE lote SET
            stock = :stock

        WHERE id_lote = :id_lote";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id_lote' => $lote_id_prod,
            ':stock'     => $stock
            
        ));
        echo 'edit';
    }


    function borrar($id){
        $sql = "DELETE FROM lote WHERE id_lote = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));

        if(!empty($query->execute(array(':id' => $id)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }
    }
}
