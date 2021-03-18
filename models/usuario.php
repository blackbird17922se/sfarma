<?php
include_once "conexion.php";
class Usuario{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function logIn($dni, $pass){

        $sql = "SELECT * FROM usuario inner join rol on rol=id_rol WHERE dni_us = :dni AND contras = :pass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':dni' => $dni,':pass' => $pass));
        $this->objetos = $query->fetchall();
        return $this->objetos;

    }
}