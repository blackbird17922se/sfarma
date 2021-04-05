<?php
// include_once 'venta.php';
include_once 'ventaProducto.php';

function getHtml($id_venta){
    // $venta = new Venta();
    $venta_producto = new VentaProducto();
    // $venta->buscar_id($id_venta);
    $venta_producto->ver($id_venta);

    foreach ($venta_producto->objetos as $objeto) {
    $plantilla = '
        <body>
            <header class="clearfix">
                <h1>'.$objeto->producto.'</h1>
        
            </header>
            
        </body>
    ';
    }
    return $plantilla;
}