<?php
include 'conexion.php';
class Venta{
    var $objetos;
    public function __construct()
    {
        $db = new Conexion();
        $this->acceso=$db->pdo;
    }

    function crear($nombre,$total,$totIvaEx,$totBaseIvaEx,$valIvaEx,$totIvaAp,$totBaseIvaAp,$valIvaAp,$baseTotal,$ivaTotal,$fecha,$vendedor){
            // funcion,total,totIvaEx,totBaseIvaEx,valIvaEx,totIvaAp,totBaseIvaAp,valIvaAp,baseTotal,ivaTotal,json,nombre

        $sql = "INSERT INTO venta(fecha, cliente, total,totIvaEx,totBaseIvaEx,valIvaEx,totIvaAp,totBaseIvaAp,valIvaAp,baseTotal,ivaTotal, vendedor) 
        VALUES (:fecha, :cliente, :total, :totIvaEx, :totBaseIvaEx, :valIvaEx, :totIvaAp, :totBaseIvaAp, :valIvaAp, :baseTotal, :ivaTotal,:vendedor)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':fecha'       => $fecha,
            ':cliente'       => $nombre,
            ':total'        => $total,
            ':totIvaEx'   => $totIvaEx,
            ':totBaseIvaEx' => $totBaseIvaEx,
            ':valIvaEx'   => $valIvaEx,
            ':totIvaAp' => $totIvaAp,
            ':totBaseIvaAp'   => $totBaseIvaAp,
            ':valIvaAp' => $valIvaAp,
            ':baseTotal'  => $baseTotal,
            ':ivaTotal' => $ivaTotal,
            ':vendedor'  => $vendedor
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
        // $id = 31;
        $sql="SELECT * FROM venta WHERE id_venta = :id
        ";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }


    /* XP VENTA PRODUCTO */
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
}