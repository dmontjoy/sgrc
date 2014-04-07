<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../../include_utiles.php';

include_once '../../../informacion/tag/class.itag.php';

function ver_tag($busca_rapida_tag,$idtag_entidad){
    
    $arrayElementos = array();
    $atag=new itag();
    $result_tag=$atag->get_tag($busca_rapida_tag,$idtag_entidad);
    $count=0;
    while($fila=  mysql_fetch_array($result_tag)){
        $count++;
         array_push($arrayElementos, new autocompletar(utf8_encode($fila["tag"]), $fila["idtag_compuesto"]));

    }
    if($count==0)
        array_push($arrayElementos, new autocompletar(utf8_encode("No se hallaron resultados"), 'nuevo_tag'));

    
   print_r(json_encode($arrayElementos));
   //json_encode($arrayElementos);
}
?>
