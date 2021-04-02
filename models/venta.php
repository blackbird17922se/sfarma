<?php
include 'conexion.php';
class Venta{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }

    function crear($nombre,$total,$fecha, $vendedor){
        $sql = "INSERT INTO venta(fecha, cliente, total, vendedor) 
        VALUES (:fecha, :cliente, :total, :vendedor)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':fecha'       => $fecha,
            ':cliente'       => $nombre,
            ':total'        => $total,
            ':vendedor'       => $vendedor
        ));
        echo 'add';
    }

    function ultimaVenta(){
        $sql="SELECT MAX(id_venta) AS ultima_venta FROM venta";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }

    function borrar($idVenta){
        $sql = "DELETE FROM venta WHERE id_venta=:id_venta";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_venta' => $idVenta));

    }

    function buscar(){
        $sql="SELECT id_venta,fecha,cliente,total, CONCAT(usuario.nom,' ',usuario.ape) AS vendedor FROM venta 
        JOIN usuario ON vendedor = id_usu";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }


    /* ESTA FUNCON SE TIENE QUE MODIFICAR PARA LA GENERACION DE PDF */
    function buscar_id($id){
        // $sql="SELECT id_prod, producto.nombre as nombre, compos, adici, precio, laboratorio.nom_lab AS laboratorio, tipo_prod.nom AS tipo, present.nom AS presentacion, prod_lab, prod_tipo, prod_pres
        // FROM producto
        // JOIN laboratorio ON prod_lab = id_lab
        // JOIN tipo_prod ON prod_tipo = id_tipo_prod
        // JOIN present ON prod_pres = id_present WHERE id_prod = :id
        // ";
        // $query = $this->acceso->prepare($sql);
        // $query->execute(array(':id'=>$id));
        // $this->objetos=$query->fetchall();
        // return $this->objetos;
    }
}