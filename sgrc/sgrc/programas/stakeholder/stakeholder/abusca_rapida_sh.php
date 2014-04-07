<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function busqueda_rapida_stakeholder($busca_rapida_stakeholder) {
    $arrayElementos = array();
    $stakeholder = new istakeholder();
    $ayudante = new Ayudante();
    $busca_rapida_stakeholder = $ayudante->caracter($busca_rapida_stakeholder);
    $result_stakeholder = $stakeholder->lista($busca_rapida_stakeholder, '1');
    //if(mysql_num_rows($result_stakeholder)>0){
    
    $count=0;
    while ($fila = mysql_fetch_array($result_stakeholder)) {
        $count++;
        array_push($arrayElementos, new autocompletar(utf8_encode($fila["nombre_completo"]), $fila["idpersona_compuesto"]));
    }
    //}else{
    //}

    //array_push($arrayElementos, new autocompletar(utf8_encode(" -- NUEVO STAKEHOLDER --"), 'nuevo_stake_holder'));
    if($count==0)
        array_push($arrayElementos, new autocompletar(utf8_encode("No se hallaron resultados"), 'nuevo_stake_holder'));

    print_r(json_encode($arrayElementos));
    //json_encode($arrayElementos);
}


function busqueda_rapida_stakeholder_tag($busca_rapida_stakeholder) {
    $arrayElementos = array();
    $stakeholder = new istakeholder();
    $ayudante = new Ayudante();
    $busca_rapida_stakeholder = $ayudante->caracter($busca_rapida_stakeholder);
    $result_stakeholder = $stakeholder->lista_stakeholder_tag($busca_rapida_stakeholder, '1');
    //if(mysql_num_rows($result_stakeholder)>0){
    
    $count=0;
    while ($fila = mysql_fetch_array($result_stakeholder)) {
        $count++;
        array_push($arrayElementos, new autocompletar(utf8_encode($fila["nombre_completo"]), $fila["idpersona_compuesto"]));
    }
    //}else{
    //}

    //array_push($arrayElementos, new autocompletar(utf8_encode(" -- NUEVO STAKEHOLDER --"), 'nuevo_stake_holder'));
    if($count==0)
        array_push($arrayElementos, new autocompletar(utf8_encode("No se hallaron resultados"), 'nuevo_stake_holder'));

    print_r(json_encode($arrayElementos));
    //json_encode($arrayElementos);
}

?>