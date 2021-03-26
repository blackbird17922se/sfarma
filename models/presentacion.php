<?php
include 'conexion.php';
class Presentacion{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }

    function crear($nom){
        $sql = "SELECT id_present FROM present WHERE nom = :nom";
        $query = $this->acceso->prepare($sql);
        $query->execute(array('nom' => $nom));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }else{
            $sql = "INSERT INTO present(nom) VALUES (:nom)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array('nom' => $nom));
            echo 'add';
        }
    }

    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta = $_POST['consulta'];
            $sql="SELECT * FROM present WHERE nom LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql = "SELECT * FROM present WHERE nom NOT LIKE '' ORDER BY id_present";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }

    function borrar($id_present){
        $sql = "DELETE FROM present WHERE id_present=:id_present";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_present' => $id_present));
        // echo 'borrado';

        if(!empty($query->execute(array(':id_present' => $id_present)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }

    }

    function editar($nom,$id_editado){
        $sql = "UPDATE present SET nom = :nom WHERE id_present=:id_present";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_present' => $id_editado,':nom' => $nom));
        echo 'edit';
    }

    function listar_presents(){
        // $consulta = $_POST['consulta'];
        $sql="SELECT * FROM present ORDER BY nom ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}