<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * =
 *
 */

include_once '../../include_utiles.php';
include_once '../../../informacion/reporte/class.ireporte.php';
include_once '../../../informacion/tag/class.itag.php';
include_once '../../../informacion/stakeholder/class.istakeholder.php';



$op_reporte = $_REQUEST["op_reporte"];
$rango_reporte = $_REQUEST["rango_reporte"];
$vista_reporte = $_REQUEST["vista_reporte"];
$fecha_reporte = $_REQUEST["fecha_reporte"];
$tipo = $_REQUEST["tipo"];
$tabla = $_REQUEST["tabla"];
$idfase = $_REQUEST["idfase"];
$idinteraccion_complejo_tag = $_REQUEST["idinteraccion_complejo_tag"];

$x1 = $_REQUEST["x1"];
$y1 = $_REQUEST["y1"];
$z1 = $_REQUEST["z1"];

$x2 = $_REQUEST["x2"];
$y2 = $_REQUEST["y2"];
$z2 = $_REQUEST["z2"];

$rango_posicion_tiempo = $_REQUEST["rango_posicion_tiempo"];
$rango_interaccion_tiempo = $_REQUEST["rango_interaccion_tiempo"];

$idpersona_compuesto = $_REQUEST["idpersona_compuesto"];

$fecha_del = $_REQUEST['fecha_del'];
$fecha_al = $_REQUEST['fecha_al'];
$idestadistico_complejo_tag = $_REQUEST['idestadistico_complejo_tag'];

$idtag_compuesto = $_REQUEST["idtag_compuesto"];

if (!$seguridad->verificaSesion()) {
    $mensaje = "Ingrese su usuario y contraseña";
    header("Location: ../../../index.php?mensaje=$mensaje");
}

switch ($op_reporte) {
    case 'listar_sh_cuadrante':listar_sh_cuadrante($x1, $y1, $z1, $x2, $y2, $z2, $idinteraccion_complejo_tag);
        break;
    case 'listar_sh_importancia':listar_sh_importancia($x1, $y1, $x2, $y2, $idinteraccion_complejo_tag);
        break;
    case 'posicion_importancia':posicion_importancia($tipo, $idinteraccion_complejo_tag);
        break;
    case 'ver_posicion_tiempo':ver_posicion_tiempo();
        break;
    case 'ver_interaccion_tiempo':ver_interaccion_tiempo();
        break;
    case 'obtener_posicion_tiempo':obtener_posicion_tiempo($rango_posicion_tiempo);
        break;
    case 'obtener_interaccion_tiempo':obtener_interaccion_tiempo($rango_interaccion_tiempo, $idpersona_compuesto);
        break;
    case 'interes_poder' : interes_poder($tipo, $idinteraccion_complejo_tag);
        break;
    case 'ver_reporte_estadistico':ver_reporte_estadistico($rango_reporte, $vista_reporte, $fecha_del, $fecha_al, $idestadistico_complejo_tag);
        break;
    case 'ver_reclamo_estadistico':ver_reclamo_estadistico($rango_reporte, $vista_reporte);
        break;
    case 'ver_mas_tag':ver_mas_tag($fecha_del, $tabla, $fecha_al, $idestadistico_complejo_tag);
        break;
    case 'ver_mas_tag_reclamo':ver_mas_tag_reclamo($fecha_reporte);
        break;
    case 'ver_mas_usuario':ver_mas_usuario($fecha_del, $fecha_al, $idestadistico_complejo_tag);
        break;
    case 'ver_mas_stakeholder':ver_mas_stakeholder($fecha_del, $fecha_al, $idestadistico_complejo_tag);
        break;
    case 'ver_mas_interaccion':ver_mas_interaccion($fecha_del, $fecha_al, $idestadistico_complejo_tag);
        break;
        break;
    case 'ver_estado_fase_reclamo':ver_estado_fase_reclamo($fecha_reporte, $idfase);
        break;
    case 'ver_reporte_tag_stakeholder_interaccion':ver_reporte_tag_stakeholder_interaccion($fecha_del, $fecha_al, $idtag_compuesto);
        break;
    case 'ver_reporte_tag_interaccion': ver_reporte_tag_interaccion();
        break;
    case 'obtener_interaccion_tiempo_tag':obtener_interaccion_tiempo_tag($rango_interaccion_tiempo, $idpersona_compuesto);
        break;
}

function listar_sh_cuadrante($x1, $y1, $z1, $x2, $y2, $z2, $idinteraccion_complejo_tag = array()) {
    //$plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/lista_cuadrante.html");
    $ireporte = new ireporte();
    $result = $ireporte->listar_sh_cuadrante($x1, $y1, $z1, $x2, $y2, $z2, $idinteraccion_complejo_tag);
    $count = 0;
    $datos = array();
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        /*
          $plantilla->iniciaBloque("stakeholder");
          $plantilla->reemplazaEnBloque("numero", $count, "stakeholder");
          $plantilla->reemplazaEnBloque("nombre", $fila[apellido_p] . " " . $fila[apellido_m] . " , " . $fila[nombre], "stakeholder");
          $plantilla->reemplazaEnBloque("idsh", $fila[idsh] , "stakeholder");
          $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo] , "stakeholder");
          $plantilla->reemplazaEnBloque("idpersona_tipo", $fila[idpersona_tipo] , "stakeholder");
          $plantilla->reemplazaEnBloque("importancia", $fila[importancia] , "stakeholder");
          $plantilla->reemplazaEnBloque("poder", $fila[puntaje1] , "stakeholder");
          $plantilla->reemplazaEnBloque("interes", $fila[puntaje2] , "stakeholder");
         * 
         */

        $datos[] = array(
            "paterno" => utf8_encode($fila[apellido_p]),
            "materno" => utf8_encode($fila[apellido_m]),
            "nombre" => utf8_encode($fila[nombre]),
            "importancia" => $fila[importancia],
            "poder" => $fila[puntaje1],
            "interes" => $fila[puntaje2]);
    }
    //$plantilla->presentaPlantilla();
    echo json_encode($datos);
}

function interes_poder($tipo = 0, $idinteraccion_complejo_tag = array()) {
    //interes poder
    if ($tipo > 0)
        $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/interes_poder.html");
    else
        $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/cuerpo_reporte_poder.html");
    $ireporte = new ireporte();
    $cantidad1 = 0;
    $result1 = $ireporte->calcular_sh(4, 5, 2, 4, 5, 3, $idinteraccion_complejo_tag);
    if ($fila1 = mysql_fetch_array($result1)) {
        $cantidad1 = $fila1[cantidad];
    }
    $plantilla->reemplaza("IQ", $cantidad1);

    $cantidad2 = 0;
    $result2 = $ireporte->calcular_sh(0, 3, 2, 4, 5, 3, $idinteraccion_complejo_tag);
    if ($fila2 = mysql_fetch_array($result2)) {
        $cantidad2 = $fila2[cantidad];
    }
    $plantilla->reemplaza("IIQ", $cantidad2);

    $cantidad3 = 0;
    $result3 = $ireporte->calcular_sh(0, 3, 2, 0, 3, 3, $idinteraccion_complejo_tag);
    if ($fila3 = mysql_fetch_array($result3)) {
        $cantidad3 = $fila3[cantidad];
    }
    $plantilla->reemplaza("IIIQ", $cantidad3);

    $cantidad4 = 0;
    $result4 = $ireporte->calcular_sh(4, 5, 2, 0, 3, 3, $idinteraccion_complejo_tag);
    if ($fila4 = mysql_fetch_array($result4)) {
        $cantidad4 = $fila4[cantidad];
    }
    $plantilla->reemplaza("IVQ", $cantidad4);

    $plantilla->presentaPlantilla();
    //return $plantilla->getPlantillaCadena();
}

function posicion_importancia($tipo, $idinteraccion_complejo_tag) {
    //posicion importancia
    if ($tipo > 0)
        $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/posicion_importancia.html");
    else
        $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/cuerpo_reporte_importancia.html");

    $ireporte = new ireporte();
    $cantidad1 = 0;
    $result1 = $ireporte->calcular_sh_importancia(4, 5, 5, 10, $idinteraccion_complejo_tag);
    if ($fila1 = mysql_fetch_array($result1)) {
        $cantidad1 = $fila1[cantidad];
    }

    $plantilla->reemplaza("IQ", $cantidad1);


    $cantidad2 = 0;
    $result2 = $ireporte->calcular_sh_importancia(4, 5, 0, 5, $idinteraccion_complejo_tag);
    if ($fila2 = mysql_fetch_array($result2)) {
        $cantidad2 = $fila2[cantidad];
    }
    $plantilla->reemplaza("IIQ", $cantidad2);

    $cantidad3 = 0;
    $result3 = $ireporte->calcular_sh_importancia(0, 3, 0, 5, $idinteraccion_complejo_tag);
    if ($fila3 = mysql_fetch_array($result3)) {
        $cantidad3 = $fila3[cantidad];
    }
    $plantilla->reemplaza("IIIQ", $cantidad3);

    $cantidad4 = 0;
    $result4 = $ireporte->calcular_sh_importancia(0, 3, 5, 10, $idinteraccion_complejo_tag);
    if ($fila4 = mysql_fetch_array($result4)) {
        $cantidad4 = $fila4[cantidad];
    }
    $plantilla->reemplaza("IVQ", $cantidad4);



    $plantilla->presentaPlantilla();
    //return $plantilla->getPlantillaCadena();
}

function ver_posicion_tiempo() {
    //posicion importancia

    $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/posicion_tiempo.html");


    $plantilla->presentaPlantilla();
    //return $plantilla->getPlantillaCadena();
}

function ver_interaccion_tiempo() {
    //posicion importancia

    $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/interaccion_tiempo.html");


    $plantilla->presentaPlantilla();
    //return $plantilla->getPlantillaCadena();
}

function obtener_posicion_tiempo($rango_posicion_tiempo) {
    $dia = date('d-m-Y');
    $data = array();
    $ratio = array();
    $datos = array();
    $ireporte = new ireporte();

    for ($i = 0; $i < $rango_posicion_tiempo * 4; $i++) {

        $x = 1000 * strtotime($dia);
        $fecha = date('Y-m-d', strtotime($dia));
        $y = 0;
        $sh_clave = 0;
        $sh_total = 0;
        $result = $ireporte->promedio_sh_clave_posicion($fecha);
        if ($fila = mysql_fetch_array($result)) {
            $y = $fila[0];
        }
        $result = $ireporte->contar_sh_clave($fecha);
        if ($fila = mysql_fetch_array($result)) {
            $sh_clave = $fila[0];
        }
        $result = $ireporte->contar_sh($fecha);
        if ($fila = mysql_fetch_array($result)) {
            $sh_total = $fila[0];
        }
        $par = array($x, $y);
        $data[] = $par;
        $ratio[] = number_format($sh_clave, 0) . "/" . number_format($sh_total, 0);
        $dia = date('d-m-Y', strtotime("-3 month" . $dia));
    }
    $datos["data"] = $data;
    $datos["ratio"] = $ratio;
    echo json_encode($datos);
}

function obtener_interaccion_tiempo($rango, $idpersona_compuesto) {
    $dia = date('d-m-Y');
    $data = array();
    $ratio = array();
    $datos = array();
    $ireporte = new ireporte();

    if ($rango == 'week') {
        $format_sql = "%x%v";
        $format_php = "YW";
        $format_x = "d/m";
        $dia = date('d-m-Y');

        if (date('D') != "Mon") {
            $dia = date("d-m-Y", strtotime($dia . " last Monday "));
        }
    } elseif ($rango == 'month') {
        $format_sql = "%x%m";
        $format_php = "Ym";
        $format_x = "m/Y";
        $dia = date('01-m-Y');
    } elseif ($rango == 'year') {
        $format_sql = "%x";
        $format_php = "Y";
        $format_x = "Y";
        $dia = date('01-01-Y');
    } else {
        $format_sql = "%x%m%d";
        $format_php = "Ymd";
        $format_x = "d/m/Y";
        $dia = date('d-m-Y');
    }


    $result = $ireporte->listar_interacciones($format_sql, $idpersona_compuesto, 12);

    $aresult = array();


    //$max = 0;

    while ($fila = mysql_fetch_array($result)) {
        $key = $fila[periodo];
        $aresult[$key] = $fila[cantidad];
        /*
          if($fila[cantidad]>$max)
          $max = $fila[cantidad];
         * 
         */
    }

    //print_r($aresult);

    for ($i = 0; $i < 12; $i++) {

        //$x = 1000 * strtotime($dia);

        $key = date($format_php, strtotime($dia));
        $x = date($format_x, strtotime($dia));
        if (array_key_exists($key, $aresult))
            $y = 0 + $aresult[$key];
        else
            $y = 0;

        //$par = array($x,$y);
        $datos["x"][$i] = $x;
        $datos["y"][$i] = 0 + $y;
        //$data[]=$par;

        $dia = date('d-m-Y', strtotime("-1 $rango" . $dia));
    }

    $datos["x"] = array_reverse($datos["x"]);
    $datos["y"] = array_reverse($datos["y"]);
    //$max = round(120*($max+1)/100,0);
    //print_r($data);
    //$datos["max"]=$max;
    //$datos["data"]=$data;

    echo json_encode($datos);
}

function obtener_interaccion_tiempo_tag($rango, $idpersona_compuesto) {
    $dia = date('d-m-Y');
    $data = array();
    $ratio = array();
    $datos = array();
    $ireporte = new ireporte();

    if ($rango == 'week') {
        $format_sql = "%x%v";
        $format_php = "YW";
        $format_x = "d/m";
        $dia = date('d-m-Y');

        if (date('D') != "Mon") {
            $dia = date("d-m-Y", strtotime($dia . " last Monday "));
        }
    } elseif ($rango == 'month') {
        $format_sql = "%x%m";
        $format_php = "Ym";
        $format_x = "m/Y";
        $dia = date('01-m-Y');
    } elseif ($rango == 'year') {
        $format_sql = "%x";
        $format_php = "Y";
        $format_x = "Y";
        $dia = date('01-01-Y');
    } else {
        $format_sql = "%x%m%d";
        $format_php = "Ymd";
        $format_x = "d/m/Y";
        $dia = date('d-m-Y');
    }

    $dias = array();
    $categorias = array();

    for ($i = 0; $i < 12; $i++) {

        //$x = 1000 * strtotime($dia);

        $dias[$i] = $dia;
        $categorias[$i] = date($format_x, strtotime($dia));

        $dia = date('d-m-Y', strtotime("-1 $rango" . $dia));
    }

    $dias = array_reverse($dias);
    $categorias = array_reverse($categorias);
    $ayudante = new Ayudante();
    $aresult = $ireporte->listar_interacciones_tag($format_sql, $idpersona_compuesto, $ayudante->FechaRevez($dias[0]));


    //print_r($aresult);
    $count = 0;
    $series = array();
    foreach ($aresult as $tag => $periodos) {

        $series[$count]['name'] = $tag;

        foreach ($dias as $dia) {

            $key = date($format_php, strtotime($dia));

            if (array_key_exists($key, $periodos))
                $y = 0 + $periodos[$key];
            else
                $y = 0;

            $series[$count]['data'][] = 0 + $y;
        }
        $count++;
    }

    $datos["series"] = $series;
    $datos["categorias"] = $categorias;

    echo json_encode($datos);
}

function listar_sh_importancia($x1, $y1, $x2, $y2, $idinteraccion_complejo_tag) {
    //$plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/lista_importancia.html");
    $ireporte = new ireporte();
    $result = $ireporte->listar_sh_importancia($x1, $y1, $x2, $y2, $idinteraccion_complejo_tag);
    $count = 0;
    $datos = array();
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        /*
          $plantilla->iniciaBloque("stakeholder");
          $plantilla->reemplazaEnBloque("numero", $count, "stakeholder");
          $plantilla->reemplazaEnBloque("nombre", $fila[apellido_p] . " " . $fila[apellido_m] . " , " . $fila[nombre], "stakeholder");
          $plantilla->reemplazaEnBloque("idsh", $fila[idsh] , "stakeholder");
          $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo] , "stakeholder");
          $plantilla->reemplazaEnBloque("idpersona_tipo", $fila[idpersona_tipo] , "stakeholder");
          $plantilla->reemplazaEnBloque("importancia", $fila[importancia] , "stakeholder");
          $plantilla->reemplazaEnBloque("posicion", $fila[puntaje] , "stakeholder");
         * 
         */

        $datos[] = array(
            "paterno" => utf8_encode($fila[apellido_p]),
            "materno" => utf8_encode($fila[apellido_m]),
            "nombre" => utf8_encode($fila[nombre]),
            "importancia" => $fila[importancia],
            "posicion" => $fila[puntaje]);
    }
    //$plantilla->presentaPlantilla();
    echo json_encode($datos);
}

function ver_reporte_estadistico($rango_reporte, $vista_reporte, $fecha_del, $fecha_al, $idestadistico_complejo_tag) {
    //print_r($idestadistico_complejo_tag);echo "entra";exit;

    $plantilla1 = new DmpTemplate("../../../plantillas/reporte/stakeholder/cuerpo_reporte_estadistico.html");
    $plantilla2 = new DmpTemplate("../../../plantillas/reporte/stakeholder/reporte_estadistico.html");
    //echo "strp ".strpos($idestadistico_complejo_tag, '---tag.');
    if(strpos($idestadistico_complejo_tag, '---tag.')==false){
        //echo $idestadistico_complejo_tag;
    }else{
        $parte=explode("---",$idestadistico_complejo_tag);
        $idestadistico_complejo_tag=$parte[0]."---".$parte[1];
    }
    $ayudante = new Ayudante();
    if ($rango_reporte > 0) {
        $fecha = date('Y-m-d');
        $fecha_al = $fecha;

        switch ($rango_reporte) {
            case 0:$fecha = '0000-00-00';
                break;
            case 1:$fecha = date('Y-m-d', strtotime("-1 week" . $fecha));
                break;
            case 2:$fecha = date('Y-m-d', strtotime("-1 month" . $fecha));
                break;
            case 3:$fecha = date('Y-m-d', strtotime("-3 month" . $fecha));
                break;
            case 4:$fecha = date('Y-m-d', strtotime("-6 month" . $fecha));
                break;
            case 5:$fecha = date('Y-m-d', strtotime("-1 year" . $fecha));
                break;
            case 6:$fecha = date('Y-m-d', strtotime("-3 year" . $fecha));
                break;
            case 7:$fecha = date('Y-m-d', strtotime("-5 year" . $fecha));
                break;
            default : $fecha = date('Y-m-d', strtotime("-1 month" . $fecha));
                break;
        }
        $fecha_del = $fecha;
    } else {

        $fecha_del = $ayudante->FechaRevezMysql($fecha_del, "/");
        $fecha_al = $ayudante->FechaRevezMysql($fecha_al, "/");
    }

    $plantilla1->reemplaza("fecha_del", $ayudante->FechaRevez($fecha_del, "-"));
    $plantilla1->reemplaza("fecha_al", $ayudante->FechaRevez($fecha_al, "-"));

    $plantilla1->reemplaza("text_stakeholders", $GLOBALS['dicc']['text']['stakeholders']);
    $plantilla1->reemplaza("text_Stakeholder", $GLOBALS['dicc']['text']['Stakeholder']);
    $plantilla1->reemplaza("text_Stakeholders", $GLOBALS['dicc']['text']['Stakeholders']);

    $istakeholder = new istakeholder();


    $plantilla1->reemplaza("cantidad_tsh", $istakeholder->total());

    $ireporte = new ireporte();

    $result = $ireporte->contar_interacciones($fecha_del, $fecha_al, $idestadistico_complejo_tag);
    //dos resulados del union, primero con la cantidad de interacciones, segundo con la cantidad de 
    if ($fila = mysql_fetch_array($result)) {

        $plantilla1->reemplaza("interacciones", $fila[cantidad]);
    }
    if ($fila = mysql_fetch_array($result)) {
        $plantilla1->reemplaza("stakeholders", $fila[cantidad]);
    }
    if ($fila = mysql_fetch_array($result)) {
        $plantilla1->reemplaza("cantidad_ti", $fila[cantidad]);
    }

    //Interacciones registradas en stakeholders, lo he borrado pues tomaba stakeholder registrados a la fecha.
    //$result = $ireporte->contar_interacciones_sh($fecha_del,$fecha_al,$idestadistico_complejo_tag);
    //$fila=  mysql_fetch_array($result);
    //$plantilla1->reemplaza("stakeholders",$fila[cantidad]);
    $itag = new itag();
    $ntag = $itag->total();
    //tag sh
    $plantilla1->reemplaza("cantidad_tt", $fila[cantidad_tt]);
    $result = $ireporte->listar_tag_sh_cantidad(4, $fecha_del, $fecha_al, $idestadistico_complejo_tag);

    $count = 0;
    $total = array();
    $datos = array();
    $total_total = 0;
    while ($fila = mysql_fetch_array($result)) {

        $datos[$count]["tag"] = utf8_encode($fila[tag]);
        $datos[$count]["cantidad"] = $fila[cantidad1] + $fila[cantidad2];

        //el primero es de el padre, de menor nivel
        if ($fila["idtag_padre"] == '') {
            $fila["idtag_padre"] = 0;
        }

        $datos[$count]["idpadre_compuesto"] = $fila["idtag_padre"] . '---' . $fila['idmodulo_tag_padre'];
        if ($count == 0) {
            $super_nivel = $fila[nivel];
        }
        //}//asumiendo que solo vienen 
        //echo "ctag".$result[ctag];
        //if ($fila[nivel] == 0) {
        if ($total[$fila["idtag_padre"] . '---' . $fila['idmodulo_tag_padre']] == '') {

            $total[$fila["idtag_padre"] . '---' . $fila['idmodulo_tag_padre']] = 0;
        }
        if ($fila[nivel] == $super_nivel) {
            $total_total = $total_total + $datos[$count]["cantidad"];
        }
        $total[$fila["idtag_padre"] . '---' . $fila['idmodulo_tag_padre']] = $total[$fila["idtag_padre"] . '---' . $fila['idmodulo_tag_padre']] + $datos[$count]["cantidad"];
        //}
        $count++;
    }

    $i = 0;
    while ($i < $count) {

        $plantilla1->iniciaBloque("tag_sh");
        $plantilla1->reemplazaEnBloque("tag", $datos[$i]["tag"], "tag_sh");
        $plantilla1->reemplazaEnBloque("cantidad", $datos[$i]["cantidad"], "tag_sh");
        $plantilla1->reemplazaEnBloque("porcentaje", round(($datos[$i]["cantidad"] / $total[$datos[$i]["idpadre_compuesto"]]) * 100), "tag_sh");
        //$plantilla1->reemplazaEnBloque("porcentaje", round(($datos[$i]["cantidad"] / $datos[$count]["idpadre_compuesto"]) * 100), "tag_sh");

        $i++;
    }

    $plantilla1->reemplaza("total2", $total_total);
    //if ($total > 0) {
    $plantilla1->iniciaBloque("reporte_ver_mas_tag_sh");
    $plantilla1->reemplazaEnBloque("fecha_del", $fecha_del, "reporte_ver_mas_tag_sh");
    $plantilla1->reemplazaEnBloque("fecha_al", $fecha_al, "reporte_ver_mas_tag_sh");
    //donde coloco los extras
    //}
    //tag interaccion mas frecuente,el que esta fallando
    //tag interaccion ok
    $result = $ireporte->listar_tag_interaccion_cantidad(4, $fecha_del, $fecha_al, $idestadistico_complejo_tag);

    $count = 0;
    $total = 0;
    $datos = array();
    while ($fila = mysql_fetch_array($result)) {

        $datos[$count]["tag"] = utf8_encode($fila[tag]);
        $datos[$count]["cantidad"] = $fila[cantidad1] + $fila[cantidad2];
        if ($count == 0) {
            //por el orden de la consulta primero vienen los de nivel mas bajo.
            $super_nivel = $fila[nivel];
        }
        if ($fila[nivel] == $super_nivel) {
            $total = $total + $datos[$count]["cantidad"];
        }
        $count++;
    }

    $i = 0;
    while ($i < $count) {

        //print_r($fila);
        $plantilla1->iniciaBloque("tag_interaccion");
        $plantilla1->reemplazaEnBloque("tag", $datos[$i]["tag"], "tag_interaccion");
        $plantilla1->reemplazaEnBloque("cantidad", $datos[$i]["cantidad"], "tag_interaccion");
        $plantilla1->reemplazaEnBloque("porcentaje", round(($datos[$i]["cantidad"] / $total) * 100), "tag_interaccion");
        $i++;
    }
    $plantilla1->reemplaza("total3", $total);
    //if($count>=4){
    $plantilla1->iniciaBloque("reporte_ver_mas_tag_interaccion");
    $plantilla1->reemplazaEnBloque("fecha_del", $fecha_del, "reporte_ver_mas_tag_interaccion");
    $plantilla1->reemplazaEnBloque("fecha_al", $fecha_al, "reporte_ver_mas_tag_interaccion");
    //extra
    //}
    //reporte normalizador
    //tag sh
    $aresult = $ireporte->listar_interaccion_tag_sh($fecha_del, $fecha_al, $idestadistico_complejo_tag);

    $count = 0;
    $total = 0;
    $denominador = 0;
    foreach ($aresult['importancia_sh'] as $importancia) {
        $denominador = $denominador + $importancia;
    }
    $aux = array();
    $temp = array();

    foreach ($aresult['tag']as $key => $tag) {
        $count++;
        $numerador = 0;
        //print_r($fila);
        //$plantilla1->iniciaBloque("interaccion_tag_sh");
        //$plantilla1->reemplazaEnBloque("tag",$tag, "interaccion_tag_sh");
        if (sizeof($aresult['interaccion_tag']) > 0) {
            $acum = 0;
            foreach ($aresult['interaccion_tag_sh'][$key] as $key_sh => $tag_sh) {

                $numerador = $numerador + (sizeof($aresult['interaccion_tag_sh'][$key][$key_sh]) / sizeof($aresult['interaccion_sh'][$key_sh])) * 100 * ($aresult['importancia_sh'][$key_sh]);
                $acum = $acum + sizeof($aresult['interaccion_tag_sh'][$key][$key_sh]);

                //$aresult['interaccion_tag_sh'][$fila[idtag] . "-" . $fila[idmodulo_tag]][$fila[idsh] . "-" . $fila[idmodulo]][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]]
            }

            $cantidad = $numerador / $denominador;

            $aux[$tag] = $cantidad;
            $temp[$tag] = $acum;

            //$plantilla1->reemplazaEnBloque("cantidad",round($cantidad,2), "interaccion_tag_sh");   
            //$plantilla1->reemplazaEnBloque("porcentaje",round($cantidad,2), "interaccion_tag_sh");
        } else {
            //$plantilla1->reemplazaEnBloque("cantidad",0, "interaccion_tag_sh");   
            //$plantilla1->reemplazaEnBloque("porcentaje",0, "interaccion_tag_sh");
        }
    }

    arsort($aux);
    $count = 0;
    foreach ($aux as $key => $value) {
        $count++;
        $plantilla1->iniciaBloque("interaccion_tag_sh");
        $plantilla1->reemplazaEnBloque("tag", utf8_encode($key), "interaccion_tag_sh");
        //$plantilla1->reemplazaEnBloque("cantidad",$temp[$key], "interaccion_tag_sh");
        $plantilla1->reemplazaEnBloque("porcentaje", number_format(round($value, 2), 2), "interaccion_tag_sh");
        if ($count == 4)
            break;
    }
    $plantilla1->reemplaza("total4", $total);
    if ($count >= 4) {
        $plantilla1->iniciaBloque("reporte_ver_mas_interaccion_tag_sh");
        $plantilla1->reemplazaEnBloque("fecha_del", $fecha_del, "reporte_ver_mas_interaccion_tag_sh");
        $plantilla1->reemplazaEnBloque("fecha_al", $fecha_al, "reporte_ver_mas_interaccion_tag_sh");
    }

    //cinco
    $result = $ireporte->listar_rc_interaccion(4, $fecha_del, $fecha_al, $idestadistico_complejo_tag);
    //exit;
    $count = 0;
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        //print_r($fila);
        $plantilla1->iniciaBloque("usuario");
        $plantilla1->reemplazaEnBloque("idpersona", $fila[idrc], "usuario");
        $plantilla1->reemplazaEnBloque("idmodulo", $fila[idmodulo], "usuario");
        $plantilla1->reemplazaEnBloque("nombre", $fila[nombre], "usuario");
        $plantilla1->reemplazaEnBloque("usuario", utf8_encode($fila[apellido_p] . " " . $fila[apellido_m] . ", " . $fila[nombre]), "usuario");
        $plantilla1->reemplazaEnBloque("cantidad", $fila[cantidad], "usuario");
        $plantilla1->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "usuario");
    }
    if ($count >= 4) {
        $plantilla1->iniciaBloque("reporte_ver_mas_rc");
        $plantilla1->reemplazaEnBloque("fecha_del", $fecha_del, "reporte_ver_mas_rc");
        $plantilla1->reemplazaEnBloque("fecha_al", $fecha_al, "reporte_ver_mas_rc");
    }


    $result = $ireporte->listar_sh_interaccion(4, $fecha_del, $fecha_al, $idestadistico_complejo_tag);

    $count = 0;

    while ($fila = mysql_fetch_array($result)) {
        $count++;
        //print_r($fila);

        $plantilla1->iniciaBloque("interaccion_sh");
        $plantilla1->reemplazaEnBloque("idpersona_compuesto", $fila[idsh] . "---" . $fila[idmodulo] . "---" . $fila[idpersona_tipo], "interaccion_sh");
        if ($fila[idpersona_tipo] > 1) {
            $plantilla1->reemplazaEnBloque("nombre", utf8_encode($fila[apellido_p]), "interaccion_sh");
        } else {
            $plantilla1->reemplazaEnBloque("nombre", utf8_encode($fila[apellido_p] . " " . $fila[apellido_m] . ", " . $fila[nombre]), "interaccion_sh");
        }
        $plantilla1->reemplazaEnBloque("cantidad", $fila[cantidad], "interaccion_sh");
        $plantilla1->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "interaccion_sh");
    }
    if ($count >= 4) {
        $plantilla1->iniciaBloque("reporte_ver_mas_interaccion");
        $plantilla1->reemplazaEnBloque("fecha_del", $fecha_del, "reporte_ver_mas_interaccion");
        $plantilla1->reemplazaEnBloque("fecha_al", $fecha_al, "reporte_ver_mas_interaccion");
    }

    $result = $ireporte->listar_estado_compromiso($fecha_del, $fecha_al);


    $count = 0;

    while ($fila = mysql_fetch_array($result)) {
        $count++;
        //print_r($fila);
        $plantilla1->reemplaza("compromisos_registrados", $fila[total]);

        $plantilla1->iniciaBloque("compromiso");
        $plantilla1->reemplazaEnBloque("estado", $fila[compromiso_estado], "compromiso");
        $plantilla1->reemplazaEnBloque("cantidad", $fila[cantidad], "compromiso");
        $plantilla1->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "compromiso");
    }

    //debe estar etiquetado 
    $result = $ireporte->listar_sh_clave(4, $fecha_del, $fecha_al, $idestadistico_complejo_tag);
    $count = 0;

    while ($fila = mysql_fetch_array($result)) {


        $count++;
        //print_r($fila);

        $estado = "";
        if ($fila[importancia] > $fila[promedio]) {
            $estado = "creciente";
            $imagen = "status_up.gif";
        } elseif ($fila[importancia] = $fila[promedio]) {
            $estado = "constante";
            $imagen = "status_generic.gif";
        } else {
            $estado = "decreciente";
            $imagen = "status_down.gif";
        }
        $plantilla1->iniciaBloque("stakeholder");
        $plantilla1->reemplazaEnBloque("idsh", $fila[idsh] . "---" . $fila[idmodulo], "stakeholder");
        $plantilla1->reemplazaEnBloque("nombre", $fila[apellido_p] . " " . $fila[apellido_m] . ", " . $fila[nombre], "stakeholder");
        $plantilla1->reemplazaEnBloque("estado", $estado, "stakeholder");
        $plantilla1->reemplazaEnBloque("imagen", $imagen, "stakeholder");
        $plantilla1->reemplazaEnBloque("importancia", number_format($fila[importancia], 0), "stakeholder");
    }
    if ($count >= 4) {
        $plantilla1->iniciaBloque("ver_mas_stakeholder");
        $plantilla1->reemplazaEnBloque("fecha_del", $fecha_del, "ver_mas_stakeholder");
        $plantilla1->reemplazaEnBloque("fecha_al", $fecha_al, "ver_mas_stakeholder");
    }

    if ($vista_reporte > 0) {
        $plantilla2->reemplaza("cuerpo_reporte_estadistico", $plantilla1->getPlantillaCadena());
        $plantilla2->presentaPlantilla();
    } else {
        $plantilla1->presentaPlantilla();
    }
}

function ver_reporte_tag_stakeholder_interaccion($fecha_del, $fecha_al, $idtag_compuesto) {

    //$plantilla=new DmpTemplate("../../../plantillas/reporte/tag/bloque_tag.html");



    $ireporte = new ireporte();

    $aresult = $ireporte->listar_persona_interaccion_tag_sh($fecha_del, $fecha_al);

    $cantidad_tag_stakeholder = array();

    $flag = false;

    if (!is_array($idtag_compuesto) && count($idtag_compuesto) == 0) {
        $idtag_compuesto = array();
        $flag = true;
    }


    foreach ($aresult['tag_interaccion'] as $key_interaccion => $tag_interaccion) {

        foreach ($aresult['tag_stakeholder'] as $key_stakeholder => $tag_stakholder) {

            if (isset($aresult['tag_stakeholder_interaccion'][$key_stakeholder][$key_interaccion])) {
                $interacciones = 0 + $aresult['tag_stakeholder_interaccion'][$key_stakeholder][$key_interaccion];
            } else {
                $interacciones = 0;
            }
            $cantidad_tag_stakeholder[$key_stakeholder] = $cantidad_tag_stakeholder[$key_stakeholder] + $interacciones;

            if ($flag) {
                $idtag_compuesto[$key_stakeholder] = $key_stakeholder;
            }
        }
    }

    arsort($cantidad_tag_stakeholder);

    $i = 0;
    $ticks = array();
    $interacciones = array();
    foreach ($cantidad_tag_stakeholder as $key_stakeholder => $cantidad) {


        //$plantilla->iniciaBloque("tag_sh");
        //$plantilla->reemplazaEnBloque("idtag_compuesto", $key_stakeholder, "tag_sh");        
        //$plantilla->reemplazaEnBloque("tag", $aresult['tag_stakeholder'][$key_stakeholder], "tag_sh");
        if (array_key_exists($key_stakeholder, $idtag_compuesto) || in_array($key_stakeholder, $idtag_compuesto)) {
            //$plantilla->reemplazaEnBloque("checked", "checked", "tag_sh");
            //$plantilla->reemplazaEnBloque("valor", $key_stakeholder, "tag_sh");

            $ticks[$i] = $aresult['tag_stakeholder'][$key_stakeholder];
            $interacciones[$i] = 0;
            if (isset($aresult['interaccion_tag_stakeholder'][$key_stakeholder])) {
                $interacciones[$i] = $aresult['interaccion_tag_stakeholder'][$key_stakeholder];
            }
            $i++;
        }
        //echo $key_stakeholder;
    }

    //print_r($plantilla);

    $datos["ticks"] = $ticks;
    $datos["interacciones"] = $interacciones;


    $m = 0;
    foreach ($aresult['tag_interaccion'] as $key_interaccion => $tag_interaccion) {
        $datos["datos"][$m]["name"] = $tag_interaccion;
        $n = 0;
        $aux = array();
        foreach ($cantidad_tag_stakeholder as $key_stakeholder => $cantidad) {

            if (array_key_exists($key_stakeholder, $idtag_compuesto) || in_array($key_stakeholder, $idtag_compuesto)) {

                if (isset($aresult['tag_stakeholder_interaccion'][$key_stakeholder][$key_interaccion])) {
                    $interacciones = 0 + $aresult['tag_stakeholder_interaccion'][$key_stakeholder][$key_interaccion];
                } else {
                    $interacciones = 0;
                }


                $aux[$n]['m'] = $m;
                $aux[$n]['n'] = $n;
                $aux[$n]['y'] = $interacciones;
                $aux[$n]['interacciones'] = $datos["interacciones"][$n];

                $n++;
            }
        }

        $datos["datos"][$m]["data"] = $aux;
        $m++;
    }



    //$datos["html"]=  $plantilla->getPlantillaCadena();


    echo json_encode($datos);
}

function ver_mas_stakeholder($fecha_del, $fecha_al, $idestadistico_complejo_tag) {
    $ayudante = new Ayudante();
    $fecha_del = $ayudante->FechaRevezMysql($fecha_del, "/");
    $fecha_al = $ayudante->FechaRevezMysql($fecha_al, "/");
    $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/reporte_stakeholder.html");
    $ireporte = new ireporte();
    $result = $ireporte->listar_sh_clave(0, $fecha_del, $fecha_al, $idestadistico_complejo_tag);


    $count = 0;

    while ($fila = mysql_fetch_array($result)) {
        $count++;
        //print_r($fila);

        $estado = "";
        if ($fila[importancia] > $fila[promedio]) {
            $estado = "creciente";
        } elseif ($fila[importancia] = $fila[promedio]) {
            $estado = "constante";
        } else {
            $estado = "decreciente";
        }
        $plantilla->iniciaBloque("stakeholder");
        $plantilla->reemplazaEnBloque("idsh", $fila[idsh] . "---" . $fila[idmodulo], "stakeholder");
        $plantilla->reemplazaEnBloque("nombre", $fila[apellido_p] . " " . $fila[apellido_m] . ", " . $fila[nombre], "stakeholder");
        $plantilla->reemplazaEnBloque("estado", $estado, "stakeholder");
    }


    $plantilla->presentaPlantilla();
}

function ver_mas_tag($fecha_del, $tabla, $fecha_al, $idestadistico_complejo_tag) {
    //$plantilla=new DmpTemplate("../../../plantillas/reporte/stakeholder/reporte_tag.html");  
    $ayudante = new Ayudante();
    //echo "fecha del ".$fecha_del;
    $fecha_del = $ayudante->FechaRevezMysql($fecha_del, "/");
    //echo "fecha del ".$fecha_del;
    $fecha_al = $ayudante->FechaRevezMysql($fecha_al, "/");
    $ireporte = new ireporte();
    $data = array();
    if ($tabla == 'SH') {
        //$plantilla->reemplaza("titulo", " 2. Tags - ".$GLOBALS[dicc][text][Stakeholder]." m&aacute;s frecuentes");
        $data["titulo"] = " 2. Tags - " . $GLOBALS[dicc][text][Stakeholder] . " m&aacute;s frecuentes";
        $result = $ireporte->listar_tag_sh_cantidad(0, $fecha_del, $fecha_al, $idestadistico_complejo_tag);
    } elseif ($tabla == 'Interaccion') {
        //$plantilla->reemplaza("titulo", " 3. Tags - Interacci&oacute;n m&aacute;s frecuentes");
        $data["titulo"] = " 3. Tags - Interacci&oacute;n m&aacute;s frecuentes";
        $result = $ireporte->listar_tag_interaccion_cantidad(0, $fecha_del, $fecha_al, $idestadistico_complejo_tag);
    } else {
        //$plantilla->reemplaza("titulo", " 4. % Temas Tratados en  Interacciones de los ".$GLOBALS[dicc][text][Stakeholders]);
        $data["titulo"] = " 4. % Temas Tratados en  Interacciones de los " . $GLOBALS[dicc][text][Stakeholders];
        //$result = $ireporte->listar_tag_cantidad(0,$fecha_reporte);
        $aresult = $ireporte->listar_interaccion_tag_sh($fecha_del, $fecha_al, $idestadistico_complejo_tag);
        $count = 0;
        $denominador = 0;
        foreach ($aresult['importancia_sh'] as $importancia) {
            $denominador = $denominador + $importancia;
        }
        $aux = array();

        foreach ($aresult['tag']as $key => $tag) {
            $count++;
            $numerador = 0;
            //print_r($fila);
            //$plantilla1->iniciaBloque("interaccion_tag_sh");
            //$plantilla1->reemplazaEnBloque("tag",$tag, "interaccion_tag_sh");
            if (sizeof($aresult['interaccion_tag']) > 0) {
                foreach ($aresult['interaccion_tag_sh'][$key] as $key_sh => $tag_sh) {
                    $numerador = $numerador + (sizeof($aresult['interaccion_tag_sh'][$key][$key_sh]) / sizeof($aresult['interaccion_sh'][$key_sh])) * 100 * ($aresult['importancia_sh'][$key_sh]);
                    //$aresult['interaccion_tag_sh'][$fila[idtag] . "-" . $fila[idmodulo_tag]][$fila[idsh] . "-" . $fila[idmodulo]][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]]
                }

                $cantidad = $numerador / $denominador;

                $aux[$tag] = $cantidad;

                //$plantilla1->reemplazaEnBloque("cantidad",round($cantidad,2), "interaccion_tag_sh");   
                //$plantilla1->reemplazaEnBloque("porcentaje",round($cantidad,2), "interaccion_tag_sh");
            } else {
                //$plantilla1->reemplazaEnBloque("cantidad",0, "interaccion_tag_sh");   
                //$plantilla1->reemplazaEnBloque("porcentaje",0, "interaccion_tag_sh");
            }
        }

        arsort($aux);
        $count = 0;
        foreach ($aux as $key => $value) {
            $data["datos"][$count]["tag"] = utf8_encode($key);
            $data["datos"][$count]["cantidad"] = round($value, 2);
            $porcentaje = round($value);

            $data["datos"][$count]["porcentaje"] = "<span style=\"width:50px;display:inline-block;text-align:right\">" . number_format(round($value, 2), 2) . "%</span> <IMG SRC='../../../img/green_bar_point.gif' WIDTH='$porcentaje' HEIGHT='10' BORDER='0'>";
            $data["datos"][$count]['id'] = $fila['idtag'] . '_' . $fila['idmodulo_tag'];
            //$datos['tags']['response'][$count]['id']=$fila['idtag'];                
            $data["datos"][$count]['level'] = $fila['nivel'];
            $data["datos"][$count]['loaded'] = true;
            $data["datos"][$count]['parent'] = null;
            if ($fila['nivel'] > 0) {
                $data["datos"][$count]['parent'] = $fila['idtag_padre'] . '_' . $fila['idmodulo_tag_padre'];
                //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
            }
            $data["datos"][$count]['isLeaf'] = true;
            $data["datos"][$count]['expanded'] = false;
            if ($fila['cantidad_hijos'] > 0) {
                $data["datos"][$count]['isLeaf'] = false;
                $data["datos"][$count]['expanded'] = true;
            }

            $count++;
            /*
              $plantilla->iniciaBloque("tag");
              $plantilla->reemplazaEnBloque("tag",$key, "tag");
              $plantilla->reemplazaEnBloque("porcentaje",round($value,2), "tag");
             */
        }
    }
    $count = 0;

    $total = 0;

    $subtotal = array();
    $super_nivel=0;
    while ($fila = mysql_fetch_array($result)) {
        
        if($count==0){
          $super_nivel=$fila[nivel];  
        } 
        
        if ($fila['nivel'] == $super_nivel && $tabla == 'SH') {
            //$plantilla->reemplaza("resumen", "<strong>$fila[total]</strong> tags han sido asignados a ".$GLOBALS[dicc][text][stakeholders].".");
            $total = $total + $fila[cantidad1] + $fila[cantidad2];

            $data["resumen"] = "<strong>$total</strong> tags han sido asignados a " . $GLOBALS[dicc][text][stakeholders] . ".";
        }

        if ($fila['nivel'] == $super_nivel  && $tabla == 'Interaccion') {
      
            //$plantilla->reemplaza("resumen", "<strong>$fila[total]</strong> tags han sido asignados a interacciones.");            
            $total = $total + $fila[cantidad1] + $fila[cantidad2];
            $data["resumen"] = "<strong>$total</strong> tags han sido asignados a interacciones.";
        }



        //print_r($fila);
        //$plantilla->iniciaBloque("tag");
        //$plantilla->reemplazaEnBloque("tag",$fila[tag], "tag");        
        //$plantilla->reemplazaEnBloque("cantidad",$fila[cantidad], "tag");  
        //$plantilla->reemplazaEnBloque("porcentaje",round(($fila[cantidad]/$fila[total])*100), "tag");



        $data["datos"][$count]["tag"] = utf8_encode($fila['tag']);
        $data["datos"][$count]["cantidad"] = $fila[cantidad1] + $fila[cantidad2];

        $data["datos"][$count]['id'] = $fila['idtag'] . '_' . $fila['idmodulo_tag'];
        //$datos['tags']['response'][$count]['id']=$fila['idtag'];                
        $data["datos"][$count]['level'] = $fila['nivel'];
        $data["datos"][$count]['loaded'] = true;
        $data["datos"][$count]['parent'] = null;
        if ($fila['nivel'] > 0) {
            $data["datos"][$count]['parent'] = $fila['idtag_padre'] . '_' . $fila['idmodulo_tag_padre'];
            //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
        }
        $data["datos"][$count]['isLeaf'] = true;
        $data["datos"][$count]['expanded'] = false;
        if ($fila['cantidad_hijos'] > 0) {
            $data["datos"][$count]['isLeaf'] = false;
            $data["datos"][$count]['expanded'] = true;
            $subtotal[$fila['idtag'] . '_' . $fila['idmodulo_tag']] = $data["datos"][$count]["cantidad"];
        }

        $count++;
    }


    $i = 0;
    while ($i < $count) {
     
        if ($data["datos"][$i]["level"] == $super_nivel) {
            $porcentaje = round(($data["datos"][$i]["cantidad"] / $total) * 100);
        } else {
            $porcentaje = round(($data["datos"][$i]["cantidad"] / $subtotal[$data["datos"][$i]['parent']]) * 100);
        }
        /*echo "dividendo ".$data["datos"][$i]["cantidad"];
        echo "divisor ".$subtotal[$data["datos"][$i]['parent']];*/
        $data["datos"][$i]["porcentaje"] = "<span style=\"width:40px;display:inline-block;text-align:right\">$porcentaje%</span> <IMG SRC='../../../img/green_bar_point.gif' WIDTH='$porcentaje' HEIGHT='10' BORDER='0'>";
        $i++;
    }

    echo json_encode($data);

    //$plantilla->presentaPlantilla();
}

function ver_mas_tag_reclamo($fecha_reporte) {
    $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/reporte_tag.html");
    $ireporte = new ireporte();
    $result = $ireporte->listar_tag_reclamo(0, $fecha_reporte);
    $count = 0;
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        //print_r($fila);
        $plantilla->iniciaBloque("tag");
        $plantilla->reemplazaEnBloque("tag", $fila[tag], "tag");
        $plantilla->reemplazaEnBloque("cantidad", $fila[cantidad], "tag");
        $plantilla->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "tag");
    }


    $plantilla->presentaPlantilla();
}

function ver_estado_fase_reclamo($fecha_reporte, $idfase) {
    $plantilla = new DmpTemplate("../../../plantillas/reporte/reclamo/reporte_fase_estado.html");
    $ireporte = new ireporte();
    $result = $ireporte->listar_estado_reclamo($fecha_reporte, $idfase);
    $count = 0;
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        //print_r($fila);
        $plantilla->reemplaza("fase", $fila[fase]);
        $plantilla->iniciaBloque("estado");
        $plantilla->reemplazaEnBloque("estado", $fila[estado], "estado");
        $plantilla->reemplazaEnBloque("cantidad", $fila[cantidad], "estado");
        $plantilla->reemplazaEnBloque("total", $fila[total], "estado");
    }


    $plantilla->presentaPlantilla();
}

function ver_mas_interaccion($fecha_del, $fecha_al, $idestadistico_complejo_tag) {
    $ayudante = new Ayudante();
    $fecha_del = $ayudante->FechaRevezMysql($fecha_del, "/");
    $fecha_al = $ayudante->FechaRevezMysql($fecha_al, "/");
    $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/reporte_interaccion.html");
    $ireporte = new ireporte();
    $result = $ireporte->listar_sh_interaccion(0, $fecha_del, $fecha_al, $idestadistico_complejo_tag);


    $count = 0;

    while ($fila = mysql_fetch_array($result)) {
        $count++;
        //print_r($fila);


        $plantilla->iniciaBloque("interaccion_sh");
        $plantilla->reemplazaEnBloque("idpersona_compuesto", $fila[idsh] . "---" . $fila[idmodulo] . "---" . $fila[idpersona_tipo], "interaccion_sh");
        $plantilla->reemplazaEnBloque("nombre", utf8_encode($fila[apellido_p] . " " . $fila[apellido_m] . ", " . $fila[nombre]), "interaccion_sh");
        $plantilla->reemplazaEnBloque("cantidad", $fila[cantidad], "interaccion_sh");
        $plantilla->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "interaccion_sh");
    }


    $plantilla->presentaPlantilla();
}

function ver_mas_usuario($fecha_del, $fecha_al, $idestadistico_complejo_tag) {
    $ayudante = new Ayudante();
    $fecha_del = $ayudante->FechaRevezMysql($fecha_del, "/");
    $fecha_al = $ayudante->FechaRevezMysql($fecha_al, "/");
    $plantilla = new DmpTemplate("../../../plantillas/reporte/stakeholder/reporte_usuario.html");
    $ireporte = new ireporte();
    $result = $ireporte->listar_rc_interaccion(0, $fecha_del, $fecha_al, $idestadistico_complejo_tag);
    $count = 0;
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        //print_r($fila);
        $plantilla->iniciaBloque("usuario");
        $plantilla->reemplazaEnBloque("idpersona", $fila[idrc], "usuario");
        $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "usuario");
        $plantilla->reemplazaEnBloque("nombre", utf8_encode($fila[nombre]), "usuario");
        $plantilla->reemplazaEnBloque("usuario", utf8_encode($fila[apellido_p] . " " . $fila[apellido_m] . ", " . $fila[nombre]), "usuario");
        $plantilla->reemplazaEnBloque("cantidad", $fila[cantidad], "usuario");
        $plantilla->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "usuario");
    }


    $plantilla->presentaPlantilla();
}

function ver_reclamo_estadistico($rango_reporte, $vista_reporte) {

    $plantilla1 = new DmpTemplate("../../../plantillas/reporte/reclamo/cuerpo_reporte_estadistico.html");
    $plantilla2 = new DmpTemplate("../../../plantillas/reporte/reclamo/reporte_estadistico.html");

    $fecha = date('Y-m-d');

    switch ($rango_reporte) {
        case 0:$fecha = '0000-00-00';
            break;
        case 1:$fecha = date('Y-m-d', strtotime("-1 week" . $fecha));
            break;
        case 2:$fecha = date('Y-m-d', strtotime("-1 month" . $fecha));
            break;
        case 3:$fecha = date('Y-m-d', strtotime("-3 month" . $fecha));
            break;
        case 4:$fecha = date('Y-m-d', strtotime("-6 month" . $fecha));
            break;
        case 5:$fecha = date('Y-m-d', strtotime("-1 year" . $fecha));
            break;
        case 6:$fecha = date('Y-m-d', strtotime("-3 year" . $fecha));
            break;
        case 7:$fecha = date('Y-m-d', strtotime("-5 year" . $fecha));
            break;

        default : $fecha = date('Y-m-d', strtotime("-1 month" . $fecha));
            break;
    }

    $plantilla1->reemplaza("fecha", $fecha);

    $ireporte = new ireporte();
    $result = $ireporte->listar_tag_reclamo(4, $fecha);
    $count = 0;
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        //print_r($fila);
        $plantilla1->iniciaBloque("tag");
        $plantilla1->reemplazaEnBloque("tag", $fila[tag], "tag");
        $plantilla1->reemplazaEnBloque("cantidad", $fila[cantidad], "tag");
        $plantilla1->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "tag");
    }
    if ($count >= 4) {
        $plantilla1->iniciaBloque("reporte_ver_mas_tag");
        $plantilla1->reemplazaEnBloque("fecha", $fecha, "reporte_ver_mas_tag");
    }
    $result = $ireporte->listar_reclamo($fecha, 0, 5, 0);

    $resueltos = 0;
    while ($fila = mysql_fetch_array($result)) {
        $plantilla1->iniciaBloque("reclamo_resuelto");
        $plantilla1->reemplazaEnBloque("fase", $fila[fase], "reclamo_resuelto");
        $plantilla1->reemplazaEnBloque("cantidad", $fila[cantidad], "reclamo_resuelto");
        $plantilla1->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "reclamo_resuelto");
        $resueltos = $resueltos + $fila[cantidad];
    }

    $plantilla1->reemplaza("resueltos", $resueltos);

    if ($resueltos == 1) {
        $plantilla1->reemplaza("unidad_resueltos", "reclamo  resuelto");
    } else {
        $plantilla1->reemplaza("unidad_resueltos", "reclamos  resueltos");
    }

    $result = $ireporte->listar_reclamo($fecha, 1);

    $abiertos = 0;
    while ($fila = mysql_fetch_array($result)) {
        $plantilla1->iniciaBloque("reclamo_abierto");
        $plantilla1->reemplazaEnBloque("fase", $fila[fase], "reclamo_abierto");
        $plantilla1->reemplazaEnBloque("cantidad", $fila[cantidad], "reclamo_abierto");
        $plantilla1->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "reclamo_abierto");
        $abiertos = $abiertos + $fila[cantidad];
    }

    $plantilla1->reemplaza("abiertos", $abiertos);

    if ($abiertos == 1) {
        $plantilla1->reemplaza("unidad_abiertos", "reclamo  abierto");
    } else {
        $plantilla1->reemplaza("unidad_abiertos", "reclamos  abiertos");
    }

    $result = $ireporte->listar_reclamo($fecha, 0, 5, 1);

    $cerrados = 0;
    while ($fila = mysql_fetch_array($result)) {
        $plantilla1->iniciaBloque("reclamo_cerrado");
        $plantilla1->reemplazaEnBloque("fase", $fila[fase], "reclamo_cerrado");
        $plantilla1->reemplazaEnBloque("cantidad", $fila[cantidad], "reclamo_cerrado");
        $plantilla1->reemplazaEnBloque("porcentaje", round(($fila[cantidad] / $fila[total]) * 100), "reclamo_cerrado");
        $plantilla1->reemplazaEnBloque("fecha", $fecha, "reclamo_cerrado");
        $plantilla1->reemplazaEnBloque("idfase", $fila[idfase], "reclamo_cerrado");
        $cerrados = $cerrados + $fila[cantidad];
    }

    $plantilla1->reemplaza("cerrados", $cerrados);

    if ($cerrados == 1) {
        $plantilla1->reemplaza("unidad_cerrados", "reclamo  cerrado");
    } else {
        $plantilla1->reemplaza("unidad_cerrados", "reclamos  cerrados");
    }

    if ($vista_reporte > 0) {
        $plantilla2->reemplaza("cuerpo_reporte_estadistico", $plantilla1->getPlantillaCadena());
        $plantilla2->presentaPlantilla();
    } else {
        $plantilla1->presentaPlantilla();
    }
}

function ver_reporte_tag_interaccion() {
    //$plantilla=new DmpTemplate("../../../plantillas/reporte/tag/reporte_interaccion_relevancia.html");
    //$plantilla1=new DmpTemplate("../../../plantillas/reporte/stakeholder/cuerpo_reporte_estadistico.html");
    //$plantilla2=new DmpTemplate("../../../plantillas/reporte/stakeholder/reporte_estadistico.html"); 

    /*
      $fecha = date('Y-m-d');

      switch ($rango_reporte) {
      case 0:$fecha = '0000-00-00';break;
      case 1:$fecha = date('Y-m-d', strtotime("-1 week" . $fecha));break;
      case 2:$fecha = date('Y-m-d', strtotime("-1 month" . $fecha));break;
      case 3:$fecha = date('Y-m-d', strtotime("-3 month" . $fecha));break;
      case 4:$fecha = date('Y-m-d', strtotime("-6 month" . $fecha));break;
      case 5:$fecha = date('Y-m-d', strtotime("-1 year" . $fecha));break;
      case 6:$fecha = date('Y-m-d', strtotime("-3 year" . $fecha));break;
      case 7:$fecha = date('Y-m-d', strtotime("-5 year" . $fecha));break;

      default : $fecha = date('Y-m-d', strtotime("-1 month" . $fecha));break;


      }

      if($vista_reporte>0){

      $plantilla2->reemplaza("cuerpo_reporte_estadistico",$plantilla1->getPlantillaCadena());
      $plantilla2->presentaPlantilla();

      }else{
      $plantilla1->presentaPlantilla();
      }
     * 
     */

    $ireporte = new ireporte();
    $aresult = $ireporte->listar_tag_interaccion_relevancia();

    $cero = 0;
    $primero = 0;
    $segundo = 0;
    $tercero = 0;
    $cuarto = 0;

    $datos = array();

    foreach ($aresult["tag"] as $key => $tag) {
        if (isset($aresult["tag_interaccion"][$key][0])) {
            $cero = $cero + $aresult["tag_interaccion"][$key][0];
        } else {
            $aresult["tag_interaccion"][$key][0] = 0;
        }

        if (isset($aresult["tag_interaccion"][$key][1])) {
            $primero = $primero + $aresult["tag_interaccion"][$key][1];
        } else {
            $aresult["tag_interaccion"][$key][1] = 0;
        }

        if (isset($aresult["tag_interaccion"][$key][2])) {
            $segundo = $segundo + $aresult["tag_interaccion"][$key][2];
        } else {
            $aresult["tag_interaccion"][$key][2] = 0;
        }

        if (isset($aresult["tag_interaccion"][$key][3])) {
            $tercero = $tercero + $aresult["tag_interaccion"][$key][3];
        } else {
            $aresult["tag_interaccion"][$key][3] = 0;
        }

        if (isset($aresult["tag_interaccion"][$key][4])) {
            $cuarto = $cuarto + $aresult["tag_interaccion"][$key][4];
        } else {
            $aresult["tag_interaccion"][$key][4] = 0;
        }
    }
    //$count=0;
    $datos["cero"] = $cero;
    $datos["primero"] = $primero;
    $datos["segundo"] = $segundo;
    $datos["tercero"] = $tercero;
    $datos["cuarto"] = $cuarto;

    foreach ($aresult["tag"] as $key => $tag) {
        //$count++;
        /*
          $plantilla->iniciaBloque("tag");
          $plantilla->reemplazaEnBloque("tag",ucfirst($tag),"tag");
          $plantilla->reemplazaEnBloque("numero","$count.","tag");
          $plantilla->reemplazaEnBloque("primero",$aresult["tag_interaccion"][$key][1],"tag");
          $plantilla->reemplazaEnBloque("segundo",$aresult["tag_interaccion"][$key][2],"tag");
          $plantilla->reemplazaEnBloque("tercero",$aresult["tag_interaccion"][$key][3],"tag");
         * 
         */
        $porcentaje0 = round(($aresult["tag_interaccion"][$key][0] / $cero) * 100);
        $porcentaje1 = round(($aresult["tag_interaccion"][$key][1] / $primero) * 100);
        $porcentaje2 = round(($aresult["tag_interaccion"][$key][2] / $segundo) * 100);
        $porcentaje3 = round(($aresult["tag_interaccion"][$key][3] / $tercero) * 100);
        $porcentaje4 = round(($aresult["tag_interaccion"][$key][4] / $cuarto) * 100);
        $datos["data"][] = array("tag" => utf8_encode(ucfirst($tag)), "cero" => $aresult["tag_interaccion"][$key][0], "porcentaje0" => " {$porcentaje0}% <IMG SRC=\"../../../img/green_bar_point.gif\" WIDTH=\"$porcentaje0\" HEIGHT=\"10\" BORDER=\"0\">", "primero" => $aresult["tag_interaccion"][$key][1], "porcentaje1" => " {$porcentaje1}% <IMG SRC=\"../../../img/green_bar_point.gif\" WIDTH=\"$porcentaje1\" HEIGHT=\"10\" BORDER=\"0\">", "segundo" => $aresult["tag_interaccion"][$key][2], "porcentaje2" => " {$porcentaje2}% <IMG SRC=\"../../../img/blue_bar_point.gif\" WIDTH=\"$porcentaje2\" HEIGHT=\"10\" BORDER=\"0\">", "tercero" => $aresult["tag_interaccion"][$key][3], "porcentaje3" => " {$porcentaje3}% <IMG SRC=\"../../../img/green_bar_point.gif\" WIDTH=\"$porcentaje3\" HEIGHT=\"10\" BORDER=\"0\">", "cuarto" => $aresult["tag_interaccion"][$key][4], "porcentaje4" => " {$porcentaje4}% <IMG SRC=\"../../../img/green_bar_point.gif\" WIDTH=\"$porcentaje4\" HEIGHT=\"10\" BORDER=\"0\">");
    }

    //$plantilla->presentaPlantilla();
    echo json_encode($datos);
}

?>
