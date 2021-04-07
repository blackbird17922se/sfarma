<?php
// include_once 'venta.php';
include_once 'ventaProducto.php';

function getHtml($id_venta){
    // $venta = new Venta();
    $venta_producto = new VentaProducto();
    // $venta->buscar_id($id_venta);
    $venta_producto->ver($id_venta);
    // echo $objeto->producto;

    $plantilla='
 
    <html>


    <body>
        <header class="clearfix">
            <h1>Farmacia Villa Luz</h1>
            <h2>NIT: 1074557664_1</h2>
            <h2>DIR: Cra 3#6-54</h2>
        </header>
        <table class="theads">
            <thead>
                <tr>
                    <th class="service theads">producto</th>
                    <th class="service">laboratorio</th>
                    <th class="service">precio</th>
                </tr>
    </thead>
    <tbody>
              
    ';

    $contador = 0;
    foreach ($venta_producto->objetos as $objeto) {
        $contador++;

        $plantilla.='
            <tr>
                <th class="service">'.$objeto->producto.'</th>
                <th class="service">'.$objeto->laboratorio.'</th>
                <th class="service">'.$objeto->subtotal.'</th>
            </tr>
        ';
    }
           
    $plantilla.='
            </tbody>
        </table> 
        </body>
        </html>         
    ';
    
    return $plantilla;
}