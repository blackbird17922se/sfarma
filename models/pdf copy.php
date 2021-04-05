<?php
include_once 'venta.php';
include_once 'ventaProducto.php';

function getHtml($id_venta){
    $venta = new Venta();
    $venta_producto = new VentaProducto();
    $venta->buscar_id($id_venta);
    $venta_producto->ver($id_venta);

    $plantilla = '
    <body>
        <header class="clearfix">
            <h1>Factura</h1>
            <div id="company" class="clearfix">
                <div id="negocio">Farmacia X</div>
                <!-- otros campos informacion -->
            </div>';
            foreach ($venta->objetos as $objeto) {
                $plantilla = '
              
                    <div id="project">
                        <div><span>Codigo venta: </span>'.$objeto->id_venta.'</div>
                        <div><span>Cliente: </span>'.$objeto->cliente.'</div>
                        <div><span>Fecha: </span>'.$objeto->fecha.'</div>
                        <div><span>Vendedor: </span>'.$objeto->vendedor.'</div>
                    </div>
                ';
            }
            // <th class="service">cantidad</th>

            $plantilla = '
        </header>
        <main>
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
            ';
                foreach ($venta_producto->objetos as $objeto) {
                    $plantilla = '
                <tbody>
                    <tr>
                        <th class="service">'.$objeto->nombre.'</th>
                        <th class="service">'.$objeto->compos.'</th>
                        <th class="service">'.$objeto->adici.'</th>
                        <th class="service">'.$objeto->laboratorio.'</th>
                        <th class="service">'.$objeto->presentacion.'</th>
                        <th class="service">'.$objeto->tipo.'</th>
                        <th class="service">'.$objeto->precio.'</th>
                    </tr>
                </tbody>
                ';
                }
                $plantilla = '

            </table>
        </main>
    </body>
 
    ';
    return $plantilla;
}