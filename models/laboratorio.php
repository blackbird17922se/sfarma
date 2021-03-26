<?php
include 'conexion.php';
class Laboratorio{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }

    function crear($nom_lab){
        $sql = "SELECT id_lab FROM laboratorio WHERE nom_lab = :nom_lab";
        $query = $this->acceso->prepare($sql);
        $query->execute(array('nom_lab' => $nom_lab));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }else{
            $sql = "INSERT INTO laboratorio(nom_lab) VALUES (:nom_lab)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array('nom_lab' => $nom_lab));
            echo 'add';
        }
    }

    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta = $_POST['consulta'];
            $sql="SELECT * FROM laboratorio WHERE nom_lab LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql = "SELECT * FROM laboratorio WHERE nom_lab NOT LIKE '' ORDER BY id_lab";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }

    function borrar($id_lab){
        $sql = "DELETE FROM laboratorio WHERE id_lab=:id_lab";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_lab' => $id_lab));
        // echo 'borrado';

        if(!empty($query->execute(array(':id_lab' => $id_lab)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }

    }

    function editar($nom_lab,$id_editado){
        $sql = "UPDATE laboratorio SET nom_lab = :nom_lab WHERE id_lab=:id_lab";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_lab' => $id_editado,':nom_lab' => $nom_lab));
        echo 'edit';
    }

    function listar_labs(){
        // $consulta = $_POST['consulta'];
        $sql="SELECT * FROM laboratorio ORDER BY nom_lab ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}

