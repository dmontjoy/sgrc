<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("../../include_utiles.php");
include_once ("../../../informacion/persona/class.ipersona.php");
include_once ("../../../informacion/persona/class.icargo.php");

/* para dar mayor rapidez
 * if(!$seguridad->verificaSesion()){
  $mensaje="Ingrese su usuario y contraseña";
  header("Location: ../../../index.php?mensaje=$mensaje");
  } */
$op_persona_organizacion = $_REQUEST["op_persona_organizacion"];
$busca = $_REQUEST['busca'];
$caja_busqueda = $_REQUEST['caja_busqueda'];

switch ($op_persona_organizacion) {

    case "busqueda_rapida": apersona_busqueda_rapida($busca, $caja_busqueda);
        break;

    default: echo "roche";
        break;
}

function apersona_busqueda_rapida($busca, $caja_busqueda) {
    $plantilla = new DmpTemplate("../../../plantillas/result.html");

    $apersona = new ipersona();
    $apersona_cargo = new icargo();
    $result = $apersona_cargo->lista_cargo();
    $combo_cargo = "<select name='idpersona_cargo[##]'>";
    while (!!$fila = mysql_fetch_array($result)) {
        $combo_cargo.="<option value='" . $fila[idpersona_cargo] . "'>" . $fila[cargo] . "</option>";
    }
    $combo_cargo.="</select>";

    //echo $combo_cargo;

    $tipo_result = $apersona->lista_organizacion_nombre($busca, 1);
    /*
      $cont=1;
      while(!!$fila=mysql_fetch_array($tipo_result)){

      $amostrar=$fila["nombre_comercial"]." ".$fila["razon_social"];
      //$idpersona=$fila["idpersona"]." ".$fila["idmodulo"];
      $idorganizacion=$fila["idpersona"]."---".$fila["idmodulo"];

      $arrayNombre.= "\"".$amostrar."\",";//lo que muestra en el desplegable
      //$arrayNombre.= "\"".$per_apellido_p." ".$per_apellido_m." ,".$per_nombres." ".$dni."\",";//lo que muestra en el desplegable
      $arrayId.= "\""." * <input type='hidden' name='idorganizacion[]' id='idorganizacion[]' value='".$idorganizacion."'>"."**".$idpersona."**".$amostrar."**".$combo_cargo."\",";//lo q muestra en la tabla

      if(max_br_m<$cont){

      break;
      }
      }

      $arrayNombre = substr($arrayNombre,0, strlen($arrayNombre) - 1);
      $arrayId = substr($arrayId,0, strlen($arrayId) - 1);
      $plantilla->iniciaBloque("xx");
      $plantilla->reemplazaEnBloque("txtSearch","txtSearch","xx");
      $plantilla->reemplazaEnBloque("nombres", $arrayNombre, "xx");
      $plantilla->reemplazaEnBloque("ids", $arrayId, "xx");

      $arrayElementos = array(); */

    //if(mysql_num_rows($result_stakeholder)>0){
    $arrayElementos = array();
    while ($fila = mysql_fetch_array($tipo_result)) {

        $amostrar = $fila["apellido_p"] . " " . $fila["apellido_m "];
        $idorganizacion = $fila["idpersona"] . "---" . $fila["idmodulo"];
        $arrayId = " " . "**" . $idorganizacion . "**" . $amostrar . "**" . $combo_cargo; //lo q muestra en la tabla
        array_push($arrayElementos, new autocompletar(utf8_encode($amostrar), utf8_encode($arrayId)));
    }

    array_push($arrayElementos, new autocompletar(utf8_encode(" -- NUEVA ORGANIZACION --"), utf8_encode('nueva_organizacion')));

    print_r(json_encode($arrayElementos));
    //json_encode($arrayElementos);
}

?>
