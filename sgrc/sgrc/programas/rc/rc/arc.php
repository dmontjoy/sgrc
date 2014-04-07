<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * =
 *
 */

include_once '../../include_utiles.php';
include_once '../../../informacion/rc/class.irc.php';

$ayudante = new Ayudante();
$op_rc = $_REQUEST["op_rc"];
$busca_rapida_rc = $_REQUEST["busca_rapida_rc"];

if (!$seguridad->verificaSesion()) {
    $mensaje = "Ingrese su usuario y contraseña";
    header("Location: ../../../index.php?mensaje=$mensaje");
}
switch ($op_rc) {

    case "busqueda_rapida_rc":busqueda_rapida_rc($busca_rapida_rc);
        break;
}

function busqueda_rapida_rc($busca_rapida_rc) {
    $arrayElementos = array();
    $rc = new irc();
    $ayudante = new Ayudante();
    $result_rc = $rc->lista($busca_rapida_rc, '1');
    //if(mysql_num_rows($result_stakeholder)>0){
    
    $count=0;
    while ($fila = mysql_fetch_array($result_rc)) {
        $count++;
        array_push($arrayElementos, new autocompletar(utf8_encode($fila["nombre_completo"]), $fila["idpersona_compuesto"]));
    }
    //}else{
    //}

    //array_push($arrayElementos, new autocompletar(utf8_encode(" -- NUEVO RC --"), 'nuevo_stake_holder'));
    if($count==0)
        array_push($arrayElementos, new autocompletar(utf8_encode("No se hallaron resultados"), 'nuevo_stake_holder'));


    print_r(json_encode($arrayElementos));
    //json_encode($arrayElementos);
}
?>

