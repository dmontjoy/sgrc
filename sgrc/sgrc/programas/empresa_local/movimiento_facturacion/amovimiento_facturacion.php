<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * =
 *
 */

include_once '../../include_utiles.php';
include_once '../../../informacion/persona/class.ipersona.php';
include_once '../../../informacion/empresa_local/class.imovimiento_facturacion.php';
include_once '../../../informacion/empresa_local/class.iperiodo.php';
include_once '../../../gestion/empresa_local/class.gempresa_local.php';

include_once '../../../programas/mensajes.php';

$idpersona     = $_REQUEST['idpersona'];
$idmodulo      = $_REQUEST['idmodulo'];
$idperiodo     =$_REQUEST['idperiodo'];
$idperiodo_sub =$_REQUEST['idperiodo_sub'];

//print_r($_REQUEST);

$op_empresa_local = $_REQUEST[op_empresa_local];

switch ($op_empresa_local) {
    case "ver_periodo_movimiento_facturacion":ver_periodo_movimiento_facturacion($idpersona, $idmodulo);
    break;
    case "editar_movimiento_facturacion":editar_movimiento_facturacion($idpersona,$idmodulo,$idperiodo,$idperiodo_sub);
    break;
    case "ver_editar_periodo":ver_editar_periodo($idpersona,$idmodulo,$idperiodo);
    break;
}

function ver_editar_periodo($idpersona,$idmodulo,$idperiodo){
    $plantilla = new DmpTemplate("../../../plantillas/empresa_local/movimiento_facturacion/ver_editar_movimiento_facturacion.html");
    $omovimiento_facturacion = new imovimiento_facturacion();
    $amovimiento_facturacion = $omovimiento_facturacion->get_movimiento_facturacion($idpersona, $idmodulo,$idperiodo);

    $plantilla->reemplaza("op_empresa_local","editar_movimiento_facturacion");
    $plantilla->reemplaza("idpersona",$idpersona);
    $plantilla->reemplaza("idmodulo",$idmodulo);
    $plantilla->reemplaza("idperiodo",$idperiodo);

    foreach ($amovimiento_facturacion[periodo] as $idperiodo => $periodo) {
        $plantilla->reemplaza("periodo",$periodo);

        foreach ($amovimiento_facturacion[periodo_sub][$idperiodo] as $idmovimiento_complejo => $periodo_sub) {
            /*echo $periodo_sub . "<br>";
            echo $amovimiento_facturacion[monto][$idmovimiento_complejo] . "<br>";*/
            $plantilla->iniciaBloque("mes");
            $plantilla->reemplazaEnBloque("periodo_sub",$periodo_sub,"mes");

            $plantilla->reemplazaEnBloque("idperiodo_sub",$amovimiento_facturacion[idperiodo_sub][$idmovimiento_complejo],"mes");

            $plantilla->reemplazaEnBloque("monto",number_format($amovimiento_facturacion[monto][$idmovimiento_complejo], 4, '.', ''),"mes");
        }   /*
        number_format($amovimiento_facturacion[monto][$idmovimiento_complejo], 2, ',', ' ')
            */

    }

    $plantilla->presentaPlantilla();
}

function ver_periodo_movimiento_facturacion($idpersona, $idmodulo) {

    $plantilla = new DmpTemplate("../../../plantillas/empresa_local/movimiento_facturacion/movimiento_facturacion.html");

    $operiodo = new iperiodo();

    $result_periodo = $operiodo->get_periodo_total($idpersona, $idmodulo);

    if (mysql_num_rows($result_periodo) > 0) {
        while ($fila = mysql_fetch_array($result_periodo)) {

            $plantilla->iniciaBloque("periodo_menu");
            $plantilla->reemplazaEnBloque("periodo", $fila[descripcion], "periodo_menu");
            $plantilla->reemplazaEnBloque("total",  $fila[total], "periodo_menu");
            $plantilla->reemplazaEnBloque("idperiodo",  $fila[idperiodo], "periodo_menu");
        }
    } else {

    }

    $plantilla->presentaPlantilla();

}

function editar_movimiento_facturacion($idpersona,$idmodulo,$idperiodo,$idperiodo_sub) {
   $oempresa_local = new gempresa_local();
   $error=$oempresa_local-> editar_movimiento($idpersona,$idmodulo,$idperiodo,$idperiodo_sub);
   //echo "error".$error;
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del periodo ");
        $data['idmodulo'] = $idmodulo;
        $data['idpersona'] = $idpersona;
        $data['idperiodo'] = $idperiodo;
        $data['idperiodo_sub'] = $idperiodo_sub;
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del periodo ");
    }

    echo json_encode($data);


}

function eliminar_hogar($idsh_hogar, $idmodulo_sh_hogar, $idpersona, $idmodulo) {
    $hogar = new ghogar();

    $error = $hogar->eliminar($idsh_hogar, $idmodulo_sh_hogar);
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " del hogar ");
        $data['idmodulo'] = $idmodulo;
        $data['idpersona'] = $idpersona;
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " del hogar ");
    }
    echo json_encode($data);
}

?>

