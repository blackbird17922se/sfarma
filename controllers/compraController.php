<?php

include '../models/venta.php';
include_once '../models/conexion.php';

$venta = new Venta();
session_start();
$vendedor = $_SESSION['usuario'];
if($_POST['funcion'] == 'registrarCompra'){
    $total = $_POST['total'];
    $nombre = $_POST['nombre'];
    $productos = json_decode($_POST['json']);
    date_default_timezone_set('America/Bogota');
    $fecha = date('Y-m-d H:i:s');

    $venta->crear($nombre,$total,$fecha,$vendedor);

    /* obtener id de la venta */
    $venta->ultimaVenta();
    foreach($venta->objetos as $objeto){
        $idVenta = $objeto->ultima_venta;
        echo $idVenta;
    }

    try {
        $db = new Conexion();
        $conexion = $db->pdo;
        $conexion->beginTransaction();
        /* Recorrer todos losproductos...  ->cantidad es traida desde el localStorage */
        foreach ($productos as $prod) {
            $cantidad = $prod->cantidad;

            /* recorer cada producto */
            while ($cantidad != 0) {
                /* seleccionael lote mas proximo a vencer */
                $sql="SELECT * FROM lote WHERE vencim = (SELECT MIN(vencim) FROM lote WHERE lote_id_prod = :id) AND lote_id_prod = :id";
                $query = $conexion->prepare($sql);
                $query->execute(array(
                    ':id'=>$prod->id_prod
                ));

                $lote = $query->fetchall();
                foreach ($lote as $lote) {
                    if($cantidad < $lote->stock){
                        $sql = "INSERT INTO det_venta(det_cant,det_vencim,id_det_lote,id_det_prod,lote_id_prov,id_det_venta) 
                            VALUES(
                                '$cantidad',
                                '$lote->vencim',
                                '$lote->id_lote',
                                '$prod->id_prod',
                                '$lote->lote_id_prov',
                                '$idVenta'         
                            )
                        ";
                        $conexion->exec($sql);
                        $conexion->exec("UPDATE lote SET stock = stock - '$cantidad' WHERE id_lote = '$lote->id_lote'");
                        $cantidad = 0;
                    }

                    /* Cantidad pedida es igual a la cantidad en el stock */
                    if($cantidad == $lote->stock){
                        $sql = "INSERT INTO det_venta(det_cant,det_vencim,id_det_lote,id_det_prod,lote_id_prov,id_det_venta) 
                            VALUES(
                                '$cantidad',
                                '$lote->vencim',
                                '$lote->id_lote',
                                '$prod->id_prod',
                                '$lote->lote_id_prov',
                                '$idVenta'         
                            )
                        ";
                        $conexion->exec($sql);
                        $conexion->exec("DELETE FROM lote WHERE id_lote = '$lote->id_lote'");
                        $cantidad = 0;
                    }

                    /* Cuaando la cantidad pedida es superior a la cantidad del stock de un lote
                        y debe eliminar ese lote y consumir los productos del siguiente lote*/
                    if($cantidad > $lote->stock){
                        $sql = "INSERT INTO det_venta(det_cant,det_vencim,id_det_lote,id_det_prod,lote_id_prov,id_det_venta) 
                        VALUES(
                            '$lote->stock',
                            '$lote->vencim',
                            '$lote->id_lote',
                            '$prod->id_prod',
                            '$lote->lote_id_prov',
                            '$idVenta'         
                        )
                    ";
                    $conexion->exec($sql);

                        $conexion->exec("DELETE FROM lote WHERE id_lote = '$lote->id_lote'");
                        $cantidad -= $lote->stock;
                    }
                }
            }
            $subtotal = $prod->cantidad * $prod->precio;
            /* INSERTAR EL REGISTRO DE LA VENTA */
            $conexion->exec(
                "INSERT INTO venta_prod(cant,subtotal,prod_id_prod,venta_id_venta) 
                VALUES(
                    '$prod->cantidad',
                    '$subtotal',
                    '$prod->id_prod',
                    '$idVenta'
                )
            ");
        }

        $conexion->commit();

        } catch (Exception $error) {
            $conexion->rollBack();
            $venta->borrar($idVenta);
        echo $error->getMessage();
    }

}
