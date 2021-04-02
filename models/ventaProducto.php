<?php
include 'conexion.php';
class VentaProducto{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }
    
    /* JOIN nimbreTabla(que contiene la llave primaria) ON llaveforanea = llave primaria de nimbreTabla*/
    function ver($id){
        // echo $id;
        $sql="SELECT precio, cant, producto.nombre AS producto, compos,adici, laboratorio.nom_lab AS laboratorio,
        present.nom as presentacion, tipo_prod.nom as tipo, subtotal 
        FROM venta_prod 
        JOIN producto ON prod_id_prod = id_prod AND venta_id_venta = :id
        JOIN laboratorio ON prod_lab = id_lab
        JOIN tipo_prod ON prod_tipo = id_tipo_prod
        JOIN present ON prod_pres = id_present
        ";

        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }

    // function crear($nombre,$total,$fecha, $vendedor){
    //     $sql = "INSERT INTO venta(fecha, cliente, total, vendedor) 
    //     VALUES (:fecha, :cliente, :total, :vendedor)";
    //     $query = $this->acceso->prepare($sql);
    //     $query->execute(array(
    //         ':fecha'       => $fecha,
    //         ':cliente'       => $nombre,
    //         ':total'        => $total,
    //         ':vendedor'       => $vendedor
    //     ));
    //     echo 'add';
    // }

    // function ultimaVenta(){
    //     $sql="SELECT MAX(id_venta) AS ultima_venta FROM venta";
    //     $query = $this->acceso->prepare($sql);
    //     $query->execute();
    //     $this->objetos=$query->fetchall();
    //     return $this->objetos;
    // }

    // function borrar($idVenta){
    //     $sql = "DELETE FROM venta WHERE id_venta=:id_venta";
    //     $query = $this->acceso->prepare($sql);
    //     $query->execute(array(':id_venta' => $idVenta));

    // }

}