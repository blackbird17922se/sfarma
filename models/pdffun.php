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
                <h1>FARMACIA VILLA LUZ</h1>
                <h2>Cra 3 #6-54</h2>
                <h2>NIT 1.074.557.664-1</h2>
            </header>
            


            ---------------- RESUMEN DE IMPUESTOS----------------
        <table class="theads">
                <thead>
                    <tr>
                        <th class="service theads">TOTAL</th>
                        <th class="service">BASE</th>
                        <th class="service">IVA</th>
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
            <tr>
                <th class="service">'.$objeto->totivaex.'</th>
                <th class="service">'.$objeto->totbaseivaex.'</th>
                <th class="service">'.$objeto->valivaex.'</th>
            </tr>
        ';

    }
           
    $plantilla.='
            </tbody>
        </table> 




        ---------------PRODUCTOS---------------------
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

$venta->ver($id_venta);
$contador3 = 0;
foreach ($venta->objetos as $objeto) {
$contador3++;

$plantilla.='
    <tr>
        <th class="service">'.$objeto->producto.'</th>
        <th class="service">'.$objeto->laboratorio.'</th>
        <th class="service">'.$objeto->precio.'</th>
    </tr>
';

}
   
$plantilla.='
    </tbody>
</table> 

       
    ';

    
    return $plantilla;
}