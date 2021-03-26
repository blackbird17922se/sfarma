<?php
include 'conexion.php';
class Producto{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }

    function crear($nombre,$compos,$adici,$precio,$prod_lab,$prod_tipo,$prod_pres){
        $sql = "SELECT id_prod FROM producto WHERE
        -- $nombre,$compos,$adici,$precio,$prod_lab,$prod_tipo,$prod_pres
                nombre = :nombre 
            AND compos = :compos 
            AND adici = :adici 
            -- AND precio = :precio 
            AND prod_lab = :prod_lab 
            AND prod_tipo = :prod_tipo 
            AND prod_pres = :prod_pres
        ";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':nombre'       => $nombre,
            ':compos'       => $compos,
            ':adici'        => $adici,
            // ':precio'       => $precio,
            ':prod_lab'     => $prod_lab,
            ':prod_tipo'    => $prod_tipo,
            ':prod_pres' => $prod_pres
            // 'nom_lab' => $nom_lab,
        ));
        $this->objetos=$query->fetchall();
        /* Si encuentra el producto entonces no agregarlo */
        if(!empty($this->objetos)){
            echo 'noadd';
        }else{
            $sql = "INSERT INTO producto(nombre, compos, adici, precio, prod_lab, prod_tipo, prod_pres) 
            VALUES (:nombre, :compos, :adici, :precio, :prod_lab, :prod_tipo, :prod_pres)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':nombre'       => $nombre,
                ':compos'       => $compos,
                ':adici'        => $adici,
                ':precio'       => $precio,
                ':prod_lab'     => $prod_lab,
                ':prod_tipo'    => $prod_tipo,
                ':prod_pres' => $prod_pres
            ));
            echo 'add';
        }
    }

    function buscar(){
        if(!empty($_POST['consulta'])){
            /* si el imput de bsiqueda esta lleno entonces */
            $consulta = $_POST['consulta'];
            $sql="SELECT id_prod, producto.nombre as nombre, compos, adici, precio, laboratorio.nom_lab AS laboratorio, tipo_prod.nom AS tipo, present.nom AS presentacion, prod_lab, prod_tipo, prod_pres
            FROM producto
            JOIN laboratorio ON prod_lab = id_lab
            JOIN tipo_prod ON prod_tipo = id_tipo_prod
            JOIN present ON prod_pres = id_present AND producto.nombre LIKE :consulta
            ";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            // $sql = "SELECT id_prod, producto.nombre as nombre, compos, adici, precio, laboratorio.nom_lab AS laboratorio, tipo_prod.nom AS tipo, present.nom AS presentacion, prod_pres, prod_lab, prod_tipo, prod_pres
            $sql = "SELECT id_prod, producto.nombre as nombre, compos, adici, precio, laboratorio.nom_lab AS laboratorio, tipo_prod.nom AS tipo, present.nom AS presentacion, prod_lab, prod_tipo, prod_pres
            FROM producto
            JOIN laboratorio ON prod_lab = id_lab
            JOIN tipo_prod ON prod_tipo = id_tipo_prod
            JOIN present ON prod_pres = id_present AND producto.nombre NOT LIKE ''
            ORDER BY producto.nombre
            ";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }

    // function borrar($id_lab){
    //     $sql = "DELETE FROM laboratorio WHERE id_lab=:id_lab";
    //     $query = $this->acceso->prepare($sql);
    //     $query->execute(array(':id_lab' => $id_lab));
    //     // echo 'borrado';

    //     if(!empty($query->execute(array(':id_lab' => $id_lab)))){
    //         echo 'borrado';
    //     }else{
    //         echo 'noborrado';
    //     }

    // }

    // function editar($nom_lab,$id_editado){
    //     $sql = "UPDATE laboratorio SET nom_lab = :nom_lab WHERE id_lab=:id_lab";
    //     $query = $this->acceso->prepare($sql);
    //     $query->execute(array(':id_lab' => $id_editado,':nom_lab' => $nom_lab));
    //     echo 'edit';
    // }

    // function listar_labs(){
    //     // $consulta = $_POST['consulta'];
    //     $sql="SELECT * FROM laboratorio ORDER BY nom_lab ASC";
    //     $query = $this->acceso->prepare($sql);
    //     $query->execute();
    //     $this->objetos=$query->fetchall();
    //     return $this->objetos;
    // }
}

