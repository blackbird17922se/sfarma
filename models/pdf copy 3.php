<?php
include_once 'venta.php';
// include_once 'ventaProducto.php';

function getHtml($id_venta){
    $venta = new Venta();
    // $venta_producto = new VentaProducto();
    $venta->buscar_id($id_venta);
    // $venta_producto->ver($id_venta);

    $plantilla='
 
 
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

    $contador2 = 0;
    foreach ($venta->objetos as $objeto) {
        $contador2++;

        $plantilla.='
            <tr>
                <th class="service">'.$objeto->totivaap.'</th>
                <th class="service">'.$objeto->totbaseivaap.'</th>
                <th class="service">'.$objeto->valivaap.'</th>
            </tr>
        ';

    }
           
    $plantilla.='
            </tbody>
        </table> 

       
    ';

    
    return $plantilla;
}