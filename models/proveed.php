<?php
include 'conexion.php';
class Proveed{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }

    function crear($nom,$telef,$correo,$direc){
        $sql = "SELECT id_prov FROM proveed WHERE
                nom = :nom 
            AND telef = :telef 
            AND correo = :correo 
            AND direc = :direc
        ";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':nom'       => $nom,
            ':telef'       => $telef,
            ':correo'        => $correo,
            ':direc'     => $direc
        ));
        $this->objetos=$query->fetchall();
        /* Si encuentra el proveed entonces no agregarlo */
        if(!empty($this->objetos)){
            echo 'noadd';
        }else{
            $sql = "INSERT INTO proveed (nom, telef, correo, direc) 
            VALUES (:nom, :telef, :correo, :direc)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':nom'     => $nom,
                ':telef'   => $telef,
                ':correo'  => $correo,
                ':direc'   => $direc
            ));
            echo 'add';
        }
    }

    function buscar(){
        if(!empty($_POST['consulta'])){
            /* si el imput de bsiqueda esta lleno entonces */
            $consulta = $_POST['consulta'];
            $sql="SELECT * FROM proveed WHERE nom LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql = "SELECT * FROM proveed WHERE nom NOT LIKE '' ORDER BY id_prov";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }

    function editar($id_prov,$nom,$telef,$correo,$direc){
        $sql = "SELECT id_prov FROM proveed WHERE id_prov != :id_prov
            AND nom = :nom 
            AND telef = :telef 
            AND correo = :correo 
            AND direc = :direc
        ";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id_prov' => $id_prov,
            ':nom'     => $nom,
            ':telef'   => $telef,
            ':correo'  => $correo,
            ':direc'   => $direc
        ));
        $this->objetos=$query->fetchall();
        /* Si encuentra el proveed entonces no agregarlo */
        if(!empty($this->objetos)){
            echo 'noedit';
        }else{
            $sql = "UPDATE proveed SET
                 nom = :nom, 
                 telef = :telef, 
                 correo = :correo, 
                 direc = :direc
                WHERE id_prov = :id_prov";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':id_prov' => $id_prov,
                ':nom'     => $nom,
                ':telef'   => $telef,
                ':correo'  => $correo,
                ':direc'   => $direc
            ));
            echo 'edit';
        }
    }

    function borrar($id_prov){
        $sql = "DELETE FROM proveed WHERE id_prov = :id_prov";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_prov' => $id_prov));

        if(!empty($query->execute(array(':id_prov' => $id_prov)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }
    }

    function listar_proveeds(){
        $sql="SELECT * FROM proveed";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}

