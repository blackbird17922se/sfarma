<?php
include '../models/lote.php';
$lote = new Lote();

if($_POST['funcion']=='crear'){

    $lote_id_prod = $_POST['lote_id_prod'];
    $lote_id_prov = $_POST['lote_id_prov'];
    $stock = $_POST['stock'];
    $vencim = $_POST['vencim'];

    $lote->crear($lote_id_prod,$lote_id_prov,$stock,$vencim);
}

/* BUSCAR */
if($_POST['funcion']=='buscar'){
    $lote->buscar();
    $json=array();
    date_default_timezone_set('America/Bogota');
    $fecha = date('Y-m-d H:i:s');

    /* operaciones de fechas */
    $fecha_actual = new DateTime($fecha);
    foreach($lote->objetos as $objeto){
        $vencimiento = new DateTime($objeto->vencim);
        $diferencia = $vencimiento->diff($fecha_actual);

        /* pasarrle parametros para que calcule la diferencia en meses o dias */
        $mes = $diferencia->m;
        $dia = $diferencia->d;
        /* esto soluciona el problema cuando la fecha exedio la fecha de vencimiento, pero muestra estado light */
        $verificado = $diferencia->invert;

        if($verificado == 0){
            $estado = 'danger';
            $mes = $mes*(-1);
            $dia = $dia*(-1);
        }else{
            if($mes>3){
                $estado = 'light';
            }
            if($mes<=3){
                $estado = 'warning';
            }
        }

        $json[]=array(

            /* '' =>$objeto->ALIAS ASIGNADO */
            'id_lote'=>$objeto->id_lote,
            'nombre'=>$objeto->prod_nom,
            'compos'=>$objeto->compos,
            'adici'=>$objeto->adici,
            'vencim'=>$objeto->vencim,
            'prov_nom'=>$objeto->prov_nom,
            'stock'=>$objeto->stock,
            'laboratorio'=>$objeto->lab_nom,
            'tipo'=>$objeto->tipo_nom,
            'presentacion'=>$objeto->pre_nom,
            'mes' => $mes,
            'dia' => $dia,
            'estado' => $estado,
            /* si es 1, la diferencia es positiva, si es 0 indica diferencia negativa. o sea los dias que lleva de vencido */
            'invert' => $verificado
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}


if($_POST['funcion']=='editar'){

    $lote_id_prod = $_POST['lote_id_prod'];
    $stock = $_POST['stock'];

    $lote->editar($lote_id_prod,$stock);
}


if($_POST['funcion'] =='borrar'){
    /* OJO: $_POST['ID'] viene desde presentratorio.js en la const ID = $(ELEM).attr('presentId'); */
    $id_lote = $_POST['ID'];
    $lote->borrar($id_lote);
}