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
        $sql="SELECT venta_prod.precio AS precio, cant, producto.nombre AS producto, compos,adici, laboratorio.nom_lab AS laboratorio,
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


    /* BORRAR VENTAS */
    function borrar($idVenta){
        $sql = "DELETE FROM venta_prod WHERE venta_id_venta=:id_venta";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_venta' => $idVenta));
    }

}