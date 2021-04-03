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
        $query->execute(array(
            ':dni' => $dni,
            ':pass' => $pass
        ));
        $this->objetos = $query->fetchall();
        return $this->objetos;

    }


    function obtenerDatos($id){   
        $sql = "SELECT * FROM usuario
        /* Arrejuntar >> TablaPrim ON Llave foranea en usuario = Llaver primaria de TablaRol 
         y que busque los datos en usuario siempre y cuando sea el usuario que se le mando por el paraemtro
        */
        JOIN rol ON rol = id_rol AND id_usu = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id' => $id,
        ));
        /* fetchall >> buscara todas las coincidencias de la consulta, el resultado se le asigna a $this->objetos */
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }


    function editar($nom,$ape,$id_usu){
        $sql = "UPDATE usuario SET nom = :nom, ape = :ape WHERE id_usu=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id' => $id_usu,
            ':nom' => $nom,
            ':ape' => $ape
        ));
    }


    function cambiarContras($oldpass,$newpass,$id_usu){

        /* Verifica si el id y el pass son iguales a los de la bd */
        $sql = "SELECT * FROM usuario WHERE id_usu = :id AND contras = :oldpass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id' => $id_usu,
            ':oldpass' => $oldpass,
        ));
        $this->objetos = $query->fetchall();

        /* Verificar si el fechall encontro resultados */
        if(!empty($this->objetos)){
            $sql = "UPDATE usuario SET contras = :newpass WHERE id_usu=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':id' => $id_usu,
                ':newpass' => $newpass,
            ));
            echo 'update';
        }else{
            echo 'noupdate';
        }
    }
}