<?php
// include_once 'venta.php';
include_once 'ventaProducto.php';

function getHtml($id_venta){
    // $venta = new Venta();
    $venta_producto = new VentaProducto();
    // $venta->buscar_id($id_venta);
    $venta_producto->ver($id_venta);

   
    $plantilla = '
            <header class="clearfix">
                <h1>XXX</h1>
            </header>
            <table>
                <thead>
                    <tr>
                        <th class="service">producto</th>
                        <th class="service">concentracion</th>
                        <th class="service">adicional</th>
                        <th class="service">laboratorio</th>
                        <th class="service">presentacion</th>
                        <th class="service">tipo</th>
                        <th class="service">precio</th>
                    </tr>
                </thead>
                <tbody>
                        
    ';

                $contador = 0;

                foreach ($venta_producto->objetos as $objeto) {
                    $contador++;

                    $plantilla.= '
                        <tr>
                            <th class="service">'.$objeto->producto.'</th>
                        </tr>
                    ';
                    echo $objeto->producto;

                }
           
                $plantilla.= '
                    
              
                        </tbody>
                    </table>            
        
                ';
    
    return $plantilla;
}