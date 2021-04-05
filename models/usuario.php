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

        $sql = "SELECT * FROM usuario inner join rol on rol=id_rol WHERE dni_us = :dni";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':dni' => $dni
        ));
        $objetos = $query->fetchall();
        foreach($objetos as $objeto){
            $contrasActual = $objeto->contras;
        }
        if(strpos($contrasActual, '$2y$10$')===0){
            if(password_verify($pass, $contrasActual)){
                return 'logueado';
            }
        }else{
            if($pass == $contrasActual){                
                return 'logueado';
            }
        }
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


    function obtenerDatosLog($dni){   
        $sql = "SELECT * FROM usuario JOIN rol ON rol = id_rol AND dni_us = :dni";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':dni' => $dni,
        ));
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
        $sql = "SELECT * FROM usuario WHERE id_usu = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id' => $id_usu
        ));
        $this->objetos = $query->fetchall();
        foreach($this->objetos as $objeto){
            $contrasActual = $objeto->contras;
        }
        if(strpos($contrasActual, '$2y$10$')===0){
            if(password_verify($oldpass, $contrasActual)){
                $pass = password_hash($newpass,PASSWORD_BCRYPT,['cost'=>10]);
                $sql = "UPDATE usuario SET contras = :newpass WHERE id_usu=:id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(
                    ':id' => $id_usu,
                    ':newpass' => $pass
                ));
                echo 'update';
            }else{
                echo 'noupdate';
            }
        }else{
            if($oldpass == $contrasActual){
                $pass = password_hash($newpass,PASSWORD_BCRYPT,['cost'=>10]);
                $sql = "UPDATE usuario SET contras = :newpass WHERE id_usu=:id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(
                    ':id' => $id_usu,
                    ':newpass' => $pass
                ));
                echo 'update';


            }else{
                echo 'noupdate';
            }

        }

        // /* Verificar si el fechall encontro resultados */
        // if(!empty($this->objetos)){
        //     $sql = "UPDATE usuario SET contras = :newpass WHERE id_usu=:id";
        //     $query = $this->acceso->prepare($sql);
        //     $query->execute(array(
        //         ':id' => $id_usu,
        //         ':newpass' => $newpass,
        //     ));
        //     echo 'update';
        // }else{
        // }
    }
    // function cambiarContras($oldpass,$newpass,$id_usu){

    //     /* Verifica si el id y el pass son iguales a los de la bd */
    //     $sql = "SELECT * FROM usuario WHERE id_usu = :id AND contras = :oldpass";
    //     $query = $this->acceso->prepare($sql);
    //     $query->execute(array(
    //         ':id' => $id_usu,
    //         ':oldpass' => $oldpass,
    //     ));
    //     $this->objetos = $query->fetchall();

    //     /* Verificar si el fechall encontro resultados */
    //     if(!empty($this->objetos)){
    //         $sql = "UPDATE usuario SET contras = :newpass WHERE id_usu=:id";
    //         $query = $this->acceso->prepare($sql);
    //         $query->execute(array(
    //             ':id' => $id_usu,
    //             ':newpass' => $newpass,
    //         ));
    //         echo 'update';
    //     }else{
    //         echo 'noupdate';
    //     }
    // }


    function buscar(){
        session_start();
            $usu_actual = $_SESSION['usuario'];
        if(!empty($_POST['consulta'])){
            



            $consulta = $_POST['consulta'];
            $sql="SELECT * FROM usuario JOIN rol ON rol = id_rol WHERE nom LIKE :consulta AND id_usu != :usu_actual";
            $query = $this->acceso->prepare($sql);
            /* %% Pasa  la variable $consulta como una cadena al LIKE */
            $query->execute(array(
                ':consulta'=>"%$consulta%",
                ':usu_actual' => $usu_actual
                ));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql = "SELECT * FROM usuario JOIN rol ON rol = id_rol WHERE nom NOT LIKE '' AND id_usu != :usu_actual ORDER BY nom";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':usu_actual' => $usu_actual));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }


    function crearUsuario($nom,$ape,$dni_us,$contras,$rol){
        /* Verificar si el usuario ya existe con ese dni */
        $sql = "SELECT id_usu FROM usuario WHERE dni_us = :dni_us";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':dni_us' => $dni_us
        ));
        $this->objetos=$query->fetchall();
        /* Si ya existe un usuario registrado con ese DNI entonces no registrar y generar mensaje */
        if(!empty($this->objetos)){
            echo 'noadd';
        }else{
            /* Sino, entoces agregar usuario */
            $sql = "INSERT INTO usuario(nom, ape, contras, rol, dni_us) 
            VALUES (:nom, :ape, :contras, :rol, :dni_us)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':nom'       => $nom,
                ':ape'       => $ape,
                ':contras'   => $contras,
                ':rol'       => $rol,
                ':dni_us'    => $dni_us
            ));
            echo 'add';
        }
    }


    function listarRoles(){
        $sql="SELECT * FROM rol ORDER BY nom_rol ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }


    function borrar($id){
        $sql = "DELETE FROM usuario WHERE id_usu = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));

        if(!empty($query->execute(array(':id' => $id)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }
    }
}