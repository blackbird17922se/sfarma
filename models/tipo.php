<?php
include 'conexion.php';
class Tipo{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }

    function crear($nom){
        $sql = "SELECT id_tipo_prod FROM tipo_prod WHERE nom = :nom";
        $query = $this->acceso->prepare($sql);
        $query->execute(array('nom' => $nom));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }else{
            $sql = "INSERT INTO tipo_prod(nom) VALUES (:nom)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array('nom' => $nom));
            echo 'add';
        }
    }

    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta = $_POST['consulta'];
            $sql="SELECT * FROM tipo_prod WHERE nom LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql = "SELECT * FROM tipo_prod WHERE nom NOT LIKE '' ORDER BY id_tipo_prod";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }

    function borrar($id_tipo_prod){
        $sql = "DELETE FROM tipo_prod WHERE id_tipo_prod=:id_tipo_prod";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_tipo_prod' => $id_tipo_prod));
        // echo 'borrado';

        if(!empty($query->execute(array(':id_tipo_prod' => $id_tipo_prod)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }

    }

    function editar($nom,$id_editado){
        $sql = "UPDATE tipo_prod SET nom = :nom WHERE id_tipo_prod=:id_tipo_prod";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_tipo_prod' => $id_editado,':nom' => $nom));
        echo 'edit';
    }

    function listar_tipos(){
        // $consulta = $_POST['consulta'];
        $sql="SELECT * FROM tipo_prod ORDER BY nom ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}