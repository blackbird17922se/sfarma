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
                        <th class="service">cantidad</th>
                        <th class="service">precio</th>
                    </tr>
                </thead>
                        /* sigue el tbody ... FALTA MAS INFO PARA COMPLETAR */
            </table>
        </main>
    </body>
 
    ';
}