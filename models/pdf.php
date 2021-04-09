<?php
include_once 'venta.php';

function getHtml($id_venta){
    $venta = new Venta();


    $total = 0;
    $vendedor = "";
    $basetotal = 0;
    $ivatotal= 0;
    $nFact= 0;
    $fecha = "";

    $venta->buscar_id($id_venta);

    $contador = 0;
    foreach ($venta->objetos as $objeto) {
        $contador++;
        $total = $objeto->total;
        $vendedor = $objeto->vendedor;
        $basetotal = $objeto->basetotal;
        $ivatotal = $objeto->ivatotal;
        $nFact = $objeto->id_venta;
        $fecha = $objeto->fecha;

    }

    // $venta->ver($id_venta);
    // $contadorV = 0;
    // foreach ($venta->objetos as $objeto) {
    //     $contadorV++;
    //     $vendedor = $objeto->vendedor;
    // }

    


    $plantilla='
        <header class="clearfix">
            <h2>FARMACIA VILLA LUZ</h2>
            <h2>Cra 3 #6-54</h2>
            <h2>NIT 1.074.557.664-1</h2>
        </header>

        <table class="theads">
            <thead>
                <tr>
                <th class="service">Código</th>
                    <th class="service theads">Descripción</th>
                    <th class="service theads">Cant.</th>
                    <th class="service">Valor</th>
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
                    <th class="service">'.$objeto->prod_id_prod.'</th>
                    <th class="service">'.$objeto->producto.'</th>
                    <th class="service">'.$objeto->cant.'</th>
                    <th class="service">'.$objeto->precio.'</th>
                </tr>
   
        ';
    }

    $plantilla.='
                <tr>
                    <th class="service">SUBTOTAL</th>
                    <th class="service"></th>
                    <th class="service"></th>
                    <th class="service">$'.$total.'</th>
                </tr>
            </tbody>
        </table>

        <h2>RESUMEN DE IMPUESTOS</h2>
        <table>
            <thead>
                <tr>
                    <th class="service theads">ID</th>
                    <th class="service theads">TOTAL</th>
                    <th class="service">BASE</th>
                    <th class="service">IVA</th>
                </tr>
            </thead>
            <tbody> 
    ';

    $venta->buscar_id($id_venta);
    $contador2 = 0;
    foreach ($venta->objetos as $objeto) {
        $contador2++;

        $plantilla.='

                <!-- Total de los que no tienen IVA -->
                <tr>
                    <th class="service">E</th>
                    <th class="service">'.$objeto->totivaex.'</th>
                    <th class="service">'.$objeto->totbaseivaex.'</th>
                    <th class="service">'.$objeto->valivaex.'</th>
                </tr>
                
                <!-- Total de los que aplican tienen IVA -->
                <tr>
                    <th class="service">A</th>
                    <th class="service">'.$objeto->totivaap.'</th>
                    <th class="service">'.$objeto->totbaseivaap.'</th>
                    <th class="service">'.$objeto->valivaap.'</th>
                </tr>

        ';
    }

    $plantilla.='
                <!-- Totales -->
                <tr>
                    <th class="service"></th>
                    <th class="service"></th>
                    <th class="service">'.$basetotal.'</th>
                    <th class="service">'.$ivatotal.'</th>
                </tr>

            </tbody>
        </table>
        <p class="texto">E=Exento, A=19%</p>

        <div class="datVenta">
            <p class="texto">ATENDIDO POR: '.$vendedor.'</p>
            <p class="texto">FACTURA DE VENTA '.$nFact.'</p>
            <p class="texto">'.$fecha.'</p>
        </div>
    ';
    return $plantilla;
}