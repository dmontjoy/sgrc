<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * =
 *
 */

include_once '../../../informacion/persona/class.idocumento_identificacion.php';
include_once '../../../informacion/persona/class.itipo.php';
include_once '../../../informacion/persona/class.ipersona.php';
include_once '../../../informacion/persona/class.icargo.php';
include_once '../../../informacion/tag/class.itag.php';

if (!$seguridad->verificaSesion()) {
    $mensaje = "Ingrese su usuario y contraseña";
    header("Location: ../../../index.php?mensaje=$mensaje");
}

function ver_buscar_persona($es_stakeholder,$idpersona_tipo) {

    if($idpersona_tipo<=1){
        $plantilla = new DmpTemplate("../../../plantillas/persona/persona/buscar.html");
    }else{
        $plantilla = new DmpTemplate("../../../plantillas/persona/persona/buscar_organizacion.html");
    }
    $plantilla->reemplaza("es_stakeholder", $es_stakeholder);
    
    if ($es_stakeholder == 0) {
        $plantilla->reemplaza("donde", "persona + RC");
        
        
    } elseif($es_stakeholder == 1) {
        $plantilla->reemplaza("donde", "persona - SH");
        
    }else{
        $plantilla->reemplaza("donde", "persona - RC - usuario");
    }
    
    if($es_stakeholder!=2){
        $persona_tipo = new itipo();
        $tipo_result = $persona_tipo->lista_persona_tipo();
        $plantilla->iniciaBloque("persona_tipo");
        while (!!$fila = mysql_fetch_array($tipo_result)) {

            $plantilla->iniciaBloque("persona_tipo_opcion");
            $plantilla->reemplazaEnBloque("idtipo", $fila[idpersona_tipo], "persona_tipo_opcion");
            $plantilla->reemplazaEnBloque("tipo", utf8_encode($fila[tipo]), "persona_tipo_opcion");
            if($idpersona_tipo==$fila[idpersona_tipo]){
                $plantilla->reemplazaEnBloque("selected", "selected", "persona_tipo_opcion");
            }
        }
         if($idpersona_tipo==0){
                $plantilla->reemplazaEnBloque("selected_todos", "selected","persona_tipo");
        }
        if($es_stakeholder == 0){
            $plantilla->iniciaBloque("filtro");
            $plantilla->reemplazaEnBloque("tipo", "SH","filtro");
            
            
        }else{
            $plantilla->iniciaBloque("filtro");
            $plantilla->reemplazaEnBloque("tipo", "RC","filtro");
            
            $plantilla->iniciaBloque("persona_tag");
            $plantilla->iniciaBloque("persona_criterio");
            $idimension_matriz_sh = new idimension_matriz_sh();
            $result= $idimension_matriz_sh->lista_dimension();
            while($fila=  mysql_fetch_array($result)){
                $plantilla->iniciaBloque("dimension");
                $plantilla->reemplazaEnBloque("iddimension",$fila['iddimension_matriz_sh'],"dimension");
                $plantilla->reemplazaEnBloque("dimension",$fila['dimension'],"dimension");
                
            }
            
            for($i=1;$i<=10;$i++){
                $plantilla->iniciaBloque("puntaje");
                $plantilla->reemplazaEnBloque("puntaje",$i,"puntaje");
                
            }
        }
        
    }
    $plantilla->presentaPlantilla();
}

function ver_buscar_persona_prioridad($es_stakeholder,$idpersona_tipo) {

    if($idpersona_tipo<=1){
        $plantilla = new DmpTemplate("../../../plantillas/persona/persona/buscar_prioridad.html");
    }else{
        $plantilla = new DmpTemplate("../../../plantillas/persona/persona/buscar_organizacion_prioridad.html");
    }
    $plantilla->reemplaza("es_stakeholder", $es_stakeholder);
    
    if ($es_stakeholder == 0) {
        $plantilla->reemplaza("donde", "persona + RC");
        
        
    } elseif($es_stakeholder == 1) {
        $plantilla->reemplaza("donde", "persona - SH");
        
    }else{
        $plantilla->reemplaza("donde", "persona - RC - usuario");
    }
    
    if($es_stakeholder!=2){
        $persona_tipo = new itipo();
        $tipo_result = $persona_tipo->lista_persona_tipo();
        $plantilla->iniciaBloque("persona_tipo");
        while (!!$fila = mysql_fetch_array($tipo_result)) {

            $plantilla->iniciaBloque("persona_tipo_opcion");
            $plantilla->reemplazaEnBloque("idtipo", $fila[idpersona_tipo], "persona_tipo_opcion");
            $plantilla->reemplazaEnBloque("tipo", utf8_encode($fila[tipo]), "persona_tipo_opcion");
            if($idpersona_tipo==$fila[idpersona_tipo]){
                $plantilla->reemplazaEnBloque("selected", "selected", "persona_tipo_opcion");
            }
        }
         if($idpersona_tipo==0){
                $plantilla->reemplazaEnBloque("selected_todos", "selected","persona_tipo");
        }
        if($es_stakeholder == 0){
            $plantilla->iniciaBloque("filtro");
            $plantilla->reemplazaEnBloque("tipo", "SH","filtro");
            
            
        }else{
            $plantilla->iniciaBloque("filtro");
            $plantilla->reemplazaEnBloque("tipo", "RC","filtro");
            
            $plantilla->iniciaBloque("persona_tag");
            $plantilla->iniciaBloque("persona_criterio");
            $idimension_matriz_sh = new idimension_matriz_sh();
            $result= $idimension_matriz_sh->lista_dimension();
            while($fila=  mysql_fetch_array($result)){
                $plantilla->iniciaBloque("dimension");
                $plantilla->reemplazaEnBloque("iddimension",$fila['iddimension_matriz_sh'],"dimension");
                $plantilla->reemplazaEnBloque("dimension",$fila['dimension'],"dimension");
                
            }
            
            for($i=1;$i<=10;$i++){
                $plantilla->iniciaBloque("puntaje");
                $plantilla->reemplazaEnBloque("puntaje",$i,"puntaje");
                
            }
        }
        
    }
    $plantilla->presentaPlantilla();
}

function buscar_persona($apaterno = "", $amaterno = "", $nombre = "", $idpersona_tipo="",$es_stakeholder = "", $filtro="",$idinteraccion_complejo_tag=array(),$criterio="",$dimensiones=array(),$operadores=array(),$puntajes=array()) {
    //echo "apaterno = $apaterno amaterno=$amaterno  nombre=$nombre idpersona_tipo=$idpersona_tipo es_stakeholder=$es_stakeholder";
    //es_stakeholder 2 rc_usuario
    //echo $es_stakeholder;
    $seguridad = new Seguridad();
    $ipersona = new ipersona();
    if ($es_stakeholder == 1) {
        if($filtro==1){
            $apersona = $ipersona->lista_sh($apaterno, $amaterno, $nombre,$idpersona_tipo,"left outer",1,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes);
        }else{
            $apersona = $ipersona->lista_sh($apaterno, $amaterno, $nombre,$idpersona_tipo,"",0,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes);
        }
    } elseif($es_stakeholder == 0) {
        if($filtro==1){
            $apersona = $ipersona->lista_rc($apaterno, $amaterno, $nombre,$idpersona_tipo, "left outer",1,$idinteraccion_complejo_tag);
        }else{
            $apersona = $ipersona->lista_rc($apaterno, $amaterno, $nombre,$idpersona_tipo, "",0,$idinteraccion_complejo_tag);
        }
    }else{
        $apersona = $ipersona->lista_rc($apaterno, $amaterno, $nombre,'','',0);
    }
    $plantilla = new DmpTemplate("../../../plantillas/persona/persona/resultado.html");

    $plantilla->iniciaBloque("resultado");
    $i = 1;
    $datos=array();
    while ($fila = mysql_fetch_array($apersona)) {
        $plantilla->iniciaBloque("resultado_persona");
        $plantilla->reemplazaEnBloque("i", $i, "resultado_persona");                
        $plantilla->reemplazaEnBloque("apellido_p", $fila[apellido_p], "resultado_persona");        
        $plantilla->reemplazaEnBloque("apellido_m", $fila[apellido_m], "resultado_persona");
        $plantilla->reemplazaEnBloque("nombre", $fila[nombre], "resultado_persona");
        
        $paterno=$fila[apellido_p];
        $materno=$fila[apellido_m];
        $nombre=$fila[nombre];
        
        $accion ="<div id='opcion_persona_$fila[idpersona]_$fila[idmodulo]' style='float:left;'>";
        
        if ($es_stakeholder == 1 && $fila[sh_rc_activo] == 1 ) {
            $plantilla->reemplazaEnBloque("inicio", "<a href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >", "resultado_persona");            
            $plantilla->reemplazaEnBloque("fin","</a>", "resultado_persona");
            
            $paterno="<a  href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >".$fila[apellido_p]."</a>";
            $materno="<a href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >".$fila[apellido_m]."</a>";
            $nombre="<a  href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >".$fila[nombre]."</a>";
        }
        if($es_stakeholder == 0 && $fila[sh_rc_activo] == 1 ){
            $plantilla->reemplazaEnBloque("inicio", "<a href=\"javascript:cargar_relacionista($fila[idpersona_tipo],$es_stakeholder,$fila[idpersona],$fila[idmodulo])\" >", "resultado_persona");            
            $plantilla->reemplazaEnBloque("fin","</a>", "resultado_persona");
            
            $paterno="<a  href='../stakeholder/astakeholder.php?nombre=$fila[nombre]&idpersona=$fila[idpersona]&idmodulo=$fila[idmodulo]' >".$fila[apellido_p]."</a>";
            $materno="<a  href='../stakeholder/astakeholder.php?nombre=$fila[nombre]&idpersona=$fila[idpersona]&idmodulo=$fila[idmodulo]' >".$fila[apellido_m]."</a>";
            $nombre="<a   href='../stakeholder/astakeholder.php?nombre=$fila[nombre]&idpersona=$fila[idpersona]&idmodulo=$fila[idmodulo]' >".$fila[nombre]."</a>";
            if($seguridad->verifica_permiso("Editar", "Relacionista", $fila[idusu_c], $fila[idmodulo_c]))
                $accion.="<a title='Editar' href='javascript:cargar_relacionista($fila[idpersona_tipo],$es_stakeholder,$fila[idpersona],$fila[idmodulo])'><img src='../../../img/edit.png' alt='Editar'/></a> ";
            //revisar este permiso
            
        }
         $accion.= "<a title='Ver PDF' href=\"javascript:exportar_pdf_sh('frame2',$fila[idpersona],$fila[idmodulo])\"><img alt='PDF' src='../../../img/pdf.png'>";
       // $accion.="<a title='Editar' href='javascript:cargar_relacionista($fila[idpersona_tipo],$es_stakeholder,$fila[idpersona],$fila[idmodulo])'><img src='../../../img/edit.png' alt='Editar'/></a> ";
               
        $plantilla->reemplazaEnBloque("idpersona", $fila[idpersona], "resultado_persona");
        $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "resultado_persona");
        
        
        
        if ($fila[sh_rc_activo] == 1 ) {
            
            if($es_stakeholder < 2){
                $plantilla->iniciaBloque("eliminar_persona");
                $plantilla->reemplazaEnBloque("idpersona", $fila[idpersona], "eliminar_persona");
                $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "eliminar_persona");
                $plantilla->reemplazaEnBloque("es_stakeholder", $es_stakeholder, "eliminar_persona");
                
                if($seguridad->verifica_permiso("Eliminar", "Relacionista", $fila[idusu_c], $fila[idmodulo_c]) && $es_stakeholder == 0)
                    $accion.="<a title='Desactivar' href='javascript:eliminar_sh_rc($fila[idpersona],$fila[idmodulo],$es_stakeholder,$i,$fila[idpersona_tipo])'><img src='../../../img/delete.png' alt='Eliminar'/></a> ";
                
                if($seguridad->verifica_permiso("Eliminar", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c]) && $es_stakeholder == 1)
                    $accion.="<a title='Desactivar' href='javascript:eliminar_sh_rc($fila[idpersona],$fila[idmodulo],$es_stakeholder,$i,$fila[idpersona_tipo])'><img src='../../../img/delete.png' alt='Eliminar'/></a> ";
            }
              
             
        } else{
            
            if($es_stakeholder < 2){ 
            
                $plantilla->iniciaBloque("agregar_persona");
                $plantilla->reemplazaEnBloque("idpersona", $fila[idpersona], "agregar_persona");
                $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "agregar_persona");
                $plantilla->reemplazaEnBloque("es_stakeholder", $es_stakeholder, "agregar_persona");
                
                if($seguridad->verifica_permiso("Crear", "Relacionista", $fila[idusu_c], $fila[idmodulo_c])  && $es_stakeholder == 0 )
                    $accion.="<a title='Activar' href='javascript:agregar_sh_rc($fila[idpersona],$fila[idmodulo],$es_stakeholder,$i,$fila[idpersona_tipo])'><img src='../../../img/add.png' alt='Agregar'/></a> ";
                if($seguridad->verifica_permiso("Crear", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c])  && $es_stakeholder == 1 )
                    $accion.="<a title='Activar' href='javascript:agregar_sh_rc($fila[idpersona],$fila[idmodulo],$es_stakeholder,$i,$fila[idpersona_tipo])'><img src='../../../img/add.png' alt='Agregar'/></a> ";
            }
             
        }
        
        $accion.="</div><div  style='float:left;'>";
        
        if($es_stakeholder==2){
            $plantilla->iniciaBloque("agregar_usuario");
            $plantilla->reemplazaEnBloque("idpersona", $fila[idpersona], "agregar_usuario");
            $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "agregar_usuario");
            $plantilla->reemplazaEnBloque("es_stakeholder", $es_stakeholder, "agregar_usuario");
            
            if($seguridad->verifica_permiso("Crear", "Usuario") )
                $accion="<a title='Registrar Usuario' href='javascript:modal_registrar_usuario($fila[idpersona],$fila[idmodulo])'><img src='../../../img/add_user.png' alt='Agregar' title='Agregar Usuario'/></a> ";
            
            $plantilla->iniciaBloque("ver_usuario");
            $plantilla->reemplazaEnBloque("idpersona", $fila[idpersona], "ver_usuario");
            $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "ver_usuario");
            $plantilla->reemplazaEnBloque("es_stakeholder", $es_stakeholder, "ver_usuario");
            
            $accion.="<a title='Ver Usuarios' href='javascript:modal_ver_usuario($fila[idpersona],$fila[idmodulo])'><img src='../../../img/serach.png' alt='' title='Ver Usuarios'/></a> ";
            
        }
        
        if($seguridad->verifica_permiso("Eliminar", "Relacionista", $fila[idusu_c], $fila[idmodulo_c]) && $es_stakeholder == 0)
            $accion.="<a title='Eliminar' href='javascript:eliminar_persona($fila[idpersona],$fila[idmodulo],$i)'><img src='../../../img/trash.png' alt='Eliminar'/></a>";
        
        if($seguridad->verifica_permiso("Eliminar", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c]) && $es_stakeholder == 1)
            $accion.="<a title='Eliminar' href='javascript:eliminar_persona($fila[idpersona],$fila[idmodulo],$i)'><img src='../../../img/trash.png' alt='Eliminar'/></a>";
        
        $accion.="</div>";
        
        $datos["data"][]=array("paterno"=>utf8_encode($paterno),"materno"=>utf8_encode($materno),"nombre" => utf8_encode($nombre), "accion"=>$accion);
        $i++;
        if(isset($fila[idgis_item])){
            $datos['idgis_item'][$fila[idgis_item]]=$fila[idgis_item];
        }
        
    }
    
    $fid_string=" ";
    
    foreach ($datos['idgis_item'] as $idgis_item){
        $fid_string .= $idgis_item.",";
    }
    
    
    $fid_string = substr($fid_string, 0, -1);
    
    $datos["fid_string"]=$fid_string;
    
    //$plantilla->presentaPlantilla();
    echo json_encode($datos);
}

function buscar_persona_prioridad($apaterno = "", $amaterno = "", $nombre = "", $idpersona_tipo="",$es_stakeholder = "", $filtro="",$idinteraccion_complejo_tag=array(),$criterio="",$dimensiones=array(),$operadores=array(),$puntajes=array(),$idprioridad_complejo_tag) {
    //echo "apaterno = $apaterno amaterno=$amaterno  nombre=$nombre idpersona_tipo=$idpersona_tipo es_stakeholder=$es_stakeholder";
    //es_stakeholder 2 rc_usuario
    //echo $es_stakeholder;
    $seguridad = new Seguridad();
    $ipersona = new ipersona();
    $itag = new itag();
    $atag = $itag->get_array_tag($idprioridad_complejo_tag);
    if ($es_stakeholder == 1) {
        if($filtro==1){
            $apersona = $ipersona->lista_sh($apaterno, $amaterno, $nombre,$idpersona_tipo,"left outer",1,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes,$atag);
        }else{
            $apersona = $ipersona->lista_sh($apaterno, $amaterno, $nombre,$idpersona_tipo,"",0,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes,$atag);
        }
    } elseif($es_stakeholder == 0) {
        if($filtro==1){
            $apersona = $ipersona->lista_rc($apaterno, $amaterno, $nombre,$idpersona_tipo, "left outer",1,$idinteraccion_complejo_tag);
        }else{
            $apersona = $ipersona->lista_rc($apaterno, $amaterno, $nombre,$idpersona_tipo, "",0,$idinteraccion_complejo_tag);
        }
    }else{
        $apersona = $ipersona->lista_rc($apaterno, $amaterno, $nombre,'','',0);
    }
    
    $i = 0;
    $datos=array();
    $aresult=array();
    while ($fila = mysql_fetch_array($apersona)) {
        $aresult[$fila[idpersona].'-'.$fila[idmodulo]]=$fila;
        if(isset($fila[idgis_item])){
            $datos['idgis_item'][$fila[idgis_item]]=$fila[idgis_item];
        }
        
    }
    foreach ($aresult as $key => $fila) {
                   
        $paterno=$fila[apellido_p];
        $materno=$fila[apellido_m];
        $nombre=$fila[nombre];
        
        $accion ="<div id='opcion_persona_$fila[idpersona]_$fila[idmodulo]' style='float:left;'>";
        
        if ($es_stakeholder == 1 && $fila[sh_rc_activo] == 1 ) {
            
            
            $paterno="<a  href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >".$fila[apellido_p]."</a>";
            $materno="<a href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >".$fila[apellido_m]."</a>";
            $nombre="<a  href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >".$fila[nombre]."</a>";
        }
        if($es_stakeholder == 0 && $fila[sh_rc_activo] == 1 ){
           
            
            $paterno="<a  href='../stakeholder/astakeholder.php?nombre=$fila[nombre]&idpersona=$fila[idpersona]&idmodulo=$fila[idmodulo]' >".$fila[apellido_p]."</a>";
            $materno="<a  href='../stakeholder/astakeholder.php?nombre=$fila[nombre]&idpersona=$fila[idpersona]&idmodulo=$fila[idmodulo]' >".$fila[apellido_m]."</a>";
            $nombre="<a   href='../stakeholder/astakeholder.php?nombre=$fila[nombre]&idpersona=$fila[idpersona]&idmodulo=$fila[idmodulo]' >".$fila[nombre]."</a>";
            if($seguridad->verifica_permiso("Editar", "Relacionista", $fila[idusu_c], $fila[idmodulo_c]))
                $accion.="<a title='Editar' href='javascript:cargar_relacionista($fila[idpersona_tipo],$es_stakeholder,$fila[idpersona],$fila[idmodulo])'><img src='../../../img/edit.png' alt='Editar'/></a> ";
        }
                                               
        
        if ($fila[sh_rc_activo] == 1 ) {
            
            if($es_stakeholder < 2){                
                
                if($seguridad->verifica_permiso("Eliminar", "Relacionista", $fila[idusu_c], $fila[idmodulo_c]) && $es_stakeholder == 0)
                    $accion.="<a title='Desactivar' href='javascript:eliminar_sh_rc($fila[idpersona],$fila[idmodulo],$es_stakeholder,$i,$fila[idpersona_tipo])'><img src='../../../img/delete.png' alt='Eliminar'/></a> ";
                
                if($seguridad->verifica_permiso("Eliminar", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c]) && $es_stakeholder == 1)
                    $accion.="<a title='Desactivar' href='javascript:eliminar_sh_rc($fila[idpersona],$fila[idmodulo],$es_stakeholder,$i,$fila[idpersona_tipo])'><img src='../../../img/delete.png' alt='Eliminar'/></a> ";
            }
              
             
        } else{
            
            if($es_stakeholder < 2){ 
          
                
                if($seguridad->verifica_permiso("Crear", "Relacionista", $fila[idusu_c], $fila[idmodulo_c])  && $es_stakeholder == 0 )
                    $accion.="<a title='Activar' href='javascript:agregar_sh_rc($fila[idpersona],$fila[idmodulo],$es_stakeholder,$i,$fila[idpersona_tipo])'><img src='../../../img/add.png' alt='Agregar'/></a> ";
                if($seguridad->verifica_permiso("Crear", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c])  && $es_stakeholder == 1 )
                    $accion.="<a title='Activar' href='javascript:agregar_sh_rc($fila[idpersona],$fila[idmodulo],$es_stakeholder,$i,$fila[idpersona_tipo])'><img src='../../../img/add.png' alt='Agregar'/></a> ";
            }
             
        }
        
        $accion.="</div><div  style='float:left;'>";
        
        if($es_stakeholder==2){
   
            
            if($seguridad->verifica_permiso("Crear", "Usuario") )
                $accion="<a title='Registrar Usuario' href='javascript:modal_registrar_usuario($fila[idpersona],$fila[idmodulo])'><img src='../../../img/add_user.png' alt='Agregar' title='Agregar Usuario'/></a> ";
            
        
            
            $accion.="<a title='Ver Usuarios' href='javascript:modal_ver_usuario($fila[idpersona],$fila[idmodulo])'><img src='../../../img/serach.png' alt='' title='Ver Usuarios'/></a> ";
            
        }
        
        if($seguridad->verifica_permiso("Eliminar", "Relacionista", $fila[idusu_c], $fila[idmodulo_c]) && $es_stakeholder == 0)
            $accion.="<a title='Eliminar' href='javascript:eliminar_persona($fila[idpersona],$fila[idmodulo],$i)'><img src='../../../img/trash.png' alt='Eliminar'/></a>";
        
        if($seguridad->verifica_permiso("Eliminar", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c]) && $es_stakeholder == 1)
            $accion.="<a title='Eliminar' href='javascript:eliminar_persona($fila[idpersona],$fila[idmodulo],$i)'><img src='../../../img/trash.png' alt='Eliminar'/></a>";
        
        $accion.="</div>";
        
        $datos["data"][$i]["paterno"]=utf8_encode($paterno);
        $datos["data"][$i]["materno"]=utf8_encode($materno);
        $datos["data"][$i]["nombre"] = utf8_encode($nombre);
        foreach ($atag as $key_tag => $tag) {
            $datos["data"][$i][$key_tag] = 0+$fila[$key_tag];
        }
        $datos["data"][$i]["accion"]=$accion;
        
        $i++;
        if(isset($fila[idgis_item])){
            $datos['idgis_item'][$fila[idgis_item]]=$fila[idgis_item];
        }
        
    }
    
    $fid_string=" ";
    
    foreach ($datos['idgis_item'] as $idgis_item){
        $fid_string .= $idgis_item.",";
    }
    
    
    $fid_string = substr($fid_string, 0, -1);
    
    $datos["fid_string"]=$fid_string;
    
    $i=0;
      
    
                       
    $datos["colNames"][$i]="Ap. Paterno";
    $datos["colModel"][$i]=array('name'=>'paterno','index'=>'paterno', 'width'=>190, 'sorttype'=>"text");
    $i++;
    $datos["colNames"][$i]="Ap. Materno";
    $datos["colModel"][$i]=array('name'=>'materno','index'=>'materno', 'width'=>190, 'sorttype'=>"text");
    $i++;
    $datos["colNames"][$i]="Nombre";
    $datos["colModel"][$i]=array('name'=>'nombre','index'=>'nombre', 'width'=>190, 'sorttype'=>"text");
    $i++;
    foreach ($atag as $key_tag => $tag) {
        $datos["colNames"][$i]=  utf8_encode($tag);
        $datos["colModel"][$i]=array('name'=>"$key_tag",'index'=>"$key_tag", 'width'=>190, 'sorttype'=>"text");
        $i++;
    }
    $datos["colNames"][$i]="Accion";
    $datos["colModel"][$i]=array('name'=>'accion','index'=>'accion', 'width'=>100, 'sortable'=>false);
    $i++;
    //$plantilla->presentaPlantilla();
    echo json_encode($datos);
}

function exportar_persona($apaterno = "", $amaterno = "", $nombre = "", $idpersona_tipo="",$es_stakeholder = "", $filtro="",$idinteraccion_complejo_tag=array(),$criterio="",$dimensiones=array(),$operadores=array(),$puntajes=array()){
    
    $ipersona = new ipersona();
    if ($es_stakeholder == 1) {
        $titulo = "Stakeholders";
        if($filtro==1){
            $apersona = $ipersona->lista_sh_excel($apaterno, $amaterno, $nombre,$idpersona_tipo,"left outer",1,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes);
        }else{
            $apersona = $ipersona->lista_sh_excel($apaterno, $amaterno, $nombre,$idpersona_tipo,"",0,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes);
        }
    } elseif($es_stakeholder == 0) {
        $titulo = "Relacionistas Comunitarios";
        if($filtro==1){
            $apersona = $ipersona->lista_rc_excel($apaterno, $amaterno, $nombre,$idpersona_tipo, "left outer",1,$idinteraccion_complejo_tag);
        }else{
            $apersona = $ipersona->lista_rc_excel($apaterno, $amaterno, $nombre,$idpersona_tipo, "",0,$idinteraccion_complejo_tag);
        }
    }else{
        $titulo = "Relacionistas Comunitarios";
        $apersona = $ipersona->lista_rc_excel($apaterno, $amaterno, $nombre,'','',0);
    }
   
    $i = 1;
    $datos=array();
   
    foreach ($apersona['apellido_p'] as $persona_key => $persona) {      
        
        $paterno=$apersona['apellido_p'][$persona_key];
        $materno=$apersona['apellido_m'][$persona_key];
        $nombre=$apersona['nombre'][$persona_key];                               
        $background=$apersona['background'][$persona_key];
        $fecha=$apersona['fecha'][$persona_key];
        $sexo=$apersona['sexo'][$persona_key];
        
        $tags="";
        
        $count=0;
        foreach ($apersona['tag'][$persona_key] as $tag_key => $tag) {
            $count++;
            $tags.= $tag;
            if($count<sizeof($apersona['tag'][$persona_key])){
                $tags.=" , ";
            }
        }
        
        $tipo=$apersona['tipo'][$persona_key];
        $documento=$apersona['documento'][$persona_key];
        $numero=$apersona['numero'][$persona_key];
        
        $direcciones="";
        
        $count=0;
        foreach ($apersona['direccion'][$persona_key] as $direccion_key => $direccion) {
            $count++;
            $direcciones.= $direccion;
            if($count<sizeof($apersona['direccion'][$persona_key])){
                $direcciones.=" / ";
            }
        }
        
        $telefonos="";
        
        $count=0;
        foreach ($apersona['telefono'][$persona_key] as $telefono_key => $telefono) {
            $count++;
            $telefonos.= $telefono;
            if($count<sizeof($apersona['telefono'][$persona_key])){
                $telefonos.=" / ";
            }
        }
        
        $mails="";
        
        $count=0;
        foreach ($apersona['mail'][$persona_key] as $mail_key => $mail) {
            $count++;
            $mails.= $mail;
            if($count<sizeof($apersona['mail'][$persona_key])){
                $mails.=" / ";
            }
        }
        
        $organizaciones="";
        
        $count=0;
        foreach ($apersona['organizacion'][$persona_key] as $organizacion_key => $organizacion) {
            $count++;
            $organizaciones.= $organizacion;
            if($count<sizeof($apersona['organizacion'][$persona_key])){
                $organizaciones.=" / ";
            }
        }
        
        $comentario=$apersona['comentario'][$persona_key];
        
        $datos[]=array("paterno"=>utf8_encode($paterno),"materno"=>utf8_encode($materno),"nombre" => utf8_encode($nombre),"background" => utf8_encode($background), "fecha"=>$fecha, "sexo"=>$sexo, "tags" => utf8_encode($tags), "tipo"=>  utf8_encode($tipo), "documento" => utf8_encode($documento), "numero"=>  utf8_encode($numero), "direcciones" => utf8_encode($direcciones), "telefonos" => utf8_encode($telefonos), "mails" => utf8_encode($mails), "organizaciones" => utf8_encode($organizaciones), "comentario" => utf8_encode($comentario) );
        $i++;
        
    }
    
    $fecha = date('d-m-Y');
   
    //objeto de PHP Excel
    $objPHPExcel = new PHPExcel();

    //algunos datos sobre autoría
    $objPHPExcel->getProperties()->setCreator("Francisco Mora(@Itrativo)");
    $objPHPExcel->getProperties()->setLastModifiedBy("Francisco Mora(@itrativo)");
    $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Reporte de Clientes");
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Reporte de Clientes");
    $objPHPExcel->getProperties()->setDescription("Reporte de Clientes para Office 2007 XLSX, Usando PHPExcel.");

    //Trabajamos con la hoja activa principal
    $objPHPExcel->setActiveSheetIndex(0);
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Test Logo');
    $objDrawing->setDescription('Test Logo');
    $objDrawing->setPath('../../../img/logo2.png');
    $objDrawing->setCoordinates('P1');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    $objPHPExcel->getActiveSheet()->SetCellValue("A1", "Social Capital Group");
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:P2');
    $objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
    
    $objPHPExcel->getActiveSheet()->SetCellValue("A4", "Reporte de $titulo al $fecha");
    $objPHPExcel->getActiveSheet()->getStyle("A4:P4")->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('A4:P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle("A4")->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->mergeCells('A4:P4');
    
    $count=8;
    
    $objPHPExcel->getActiveSheet()->SetCellValue("A".$count, "Numero");
    $objPHPExcel->getActiveSheet()->SetCellValue("B".$count, "Apellido Paterno");
    $objPHPExcel->getActiveSheet()->SetCellValue("C".$count, "Apellido Materno");
    $objPHPExcel->getActiveSheet()->SetCellValue("D".$count, "Nombre");
    $objPHPExcel->getActiveSheet()->SetCellValue("E".$count, "Background");
    $objPHPExcel->getActiveSheet()->SetCellValue("F".$count, "Fecha de Nacimiento");
    $objPHPExcel->getActiveSheet()->SetCellValue("G".$count, "Sexo");
    $objPHPExcel->getActiveSheet()->SetCellValue("H".$count, "Tag");
    $objPHPExcel->getActiveSheet()->SetCellValue("I".$count, "Tipo de Persona");
    $objPHPExcel->getActiveSheet()->SetCellValue("J".$count, "Tipo Documento");
    $objPHPExcel->getActiveSheet()->SetCellValue("K".$count, "Numero Documento");
    $objPHPExcel->getActiveSheet()->SetCellValue("L".$count, "Direcciones");
    $objPHPExcel->getActiveSheet()->SetCellValue("M".$count, "Telefonos");
    $objPHPExcel->getActiveSheet()->SetCellValue("N".$count, "E-mails");
    $objPHPExcel->getActiveSheet()->SetCellValue("O".$count, "Organizaciones");
    $objPHPExcel->getActiveSheet()->SetCellValue("P".$count, "Comentario");
    
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle("A".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("B".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("C".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("D".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("E".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("F".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("G".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("H".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("I".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("J".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("K".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("L".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("M".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("N".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("O".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("P".$count)->applyFromArray($styleArray);
    //iteramos para los resultados
    $count++;
    foreach($datos as $row){
        $objPHPExcel->getActiveSheet()->SetCellValue("A".$count, ($count-8));
        $objPHPExcel->getActiveSheet()->SetCellValue("B".$count, $row["paterno"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("C".$count, $row["materno"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("D".$count, $row["nombre"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("E".$count, $row["background"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("F".$count, $row["fecha"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("G".$count, $row["sexo"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("H".$count, $row["tags"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("I".$count, $row["tipo"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("J".$count, $row["documento"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("K".$count, $row["numero"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("L".$count, $row["direcciones"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("M".$count, $row["telefonos"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("N".$count, $row["mails"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("O".$count, $row["organizaciones"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("P".$count, $row["comentario"]);
        $count++;
    }

    //Titulo del libro y seguridad 
    $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    $objPHPExcel->getSecurity()->setLockWindows(true);
    $objPHPExcel->getSecurity()->setLockStructure(true);
   
    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="reportePersonas.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
    
   ob_clean();
   flush();
   //readfile($fichero);
   $objWriter->save('php://output');   
   exit;
}

function exportar_persona_red($idinteraccion_complejo_sh=array()){
    
    $ipersona = new ipersona();
    $apersona = $ipersona->lista_sh_red($idinteraccion_complejo_sh);
   
    $i = 1;
    $datos=array();
    while ($fila = mysql_fetch_array($apersona)) {      
        
        $paterno=$fila[apellido_p];
        $materno=$fila[apellido_m];
        $nombre=$fila[nombre];                               
        $cantidad=$fila[cantidad];
        
        $datos[]=array("paterno"=>utf8_encode($paterno),"materno"=>utf8_encode($materno),"nombre" => utf8_encode($nombre), "cantidad" => $cantidad );
        $i++;
        
    }
   
    //objeto de PHP Excel
    $objPHPExcel = new PHPExcel();

    //algunos datos sobre autoría
    $objPHPExcel->getProperties()->setCreator("Francisco Mora(@Itrativo)");
    $objPHPExcel->getProperties()->setLastModifiedBy("Francisco Mora(@itrativo)");
    $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Reporte de Clientes");
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Reporte de Clientes");
    $objPHPExcel->getProperties()->setDescription("Reporte de Clientes para Office 2007 XLSX, Usando PHPExcel.");

    //Trabajamos con la hoja activa principal
    $objPHPExcel->setActiveSheetIndex(0);
    
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Test Logo');
    $objDrawing->setDescription('Test Logo');
    $objDrawing->setPath('../../../img/logo2.png');
    $objDrawing->setCoordinates('H1');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    $objPHPExcel->getActiveSheet()->SetCellValue("A1", "Social Capital Group");
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
    $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
    
    $objPHPExcel->getActiveSheet()->SetCellValue("A4", "Reporte de Red");
    $objPHPExcel->getActiveSheet()->getStyle("A4:I4")->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle("A4")->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
    
    $count=8;
    
    $objPHPExcel->getActiveSheet()->SetCellValue("B".$count, "Ap. Paterno");
    $objPHPExcel->getActiveSheet()->SetCellValue("C".$count, "Ap. Materno");
    $objPHPExcel->getActiveSheet()->SetCellValue("D".$count, "Nombre");
    $objPHPExcel->getActiveSheet()->SetCellValue("E".$count, "Red");
    
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle("B".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("C".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("D".$count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("E".$count)->applyFromArray($styleArray);
    //iteramos para los resultados
    $count++;
    foreach($datos as $row){
        $objPHPExcel->getActiveSheet()->SetCellValue("B".$count, $row["paterno"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("C".$count, $row["materno"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("D".$count, $row["nombre"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("E".$count, $row["cantidad"]);
        $count++;
    }

    //Titulo del libro y seguridad 
    $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    $objPHPExcel->getSecurity()->setLockWindows(true);
    $objPHPExcel->getSecurity()->setLockStructure(true);
   
    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="reportePersonasRed.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
    
   ob_clean();
   flush();
   //readfile($fichero);
   $objWriter->save('php://output');   
   exit;
}

function exportar_pdf_persona($apaterno = "", $amaterno = "", $nombre = "", $idpersona_tipo="",$es_stakeholder = "", $filtro="",$idinteraccion_complejo_tag=array(),$criterio="",$dimensiones=array(),$operadores=array(),$puntajes=array()){
    
    $ipersona = new ipersona();
    if ($es_stakeholder == 1) {
        if($filtro==1){
            $apersona = $ipersona->lista_sh($apaterno, $amaterno, $nombre,$idpersona_tipo,"left outer",1,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes);
        }else{
            $apersona = $ipersona->lista_sh($apaterno, $amaterno, $nombre,$idpersona_tipo,"",0,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes);
        }
    } elseif($es_stakeholder == 0) {
        if($filtro==1){
            $apersona = $ipersona->lista_rc($apaterno, $amaterno, $nombre,$idpersona_tipo, "left outer",1,$idinteraccion_complejo_tag);
        }else{
            $apersona = $ipersona->lista_rc($apaterno, $amaterno, $nombre,$idpersona_tipo, "",0,$idinteraccion_complejo_tag);
        }
    }else{
        $apersona = $ipersona->lista_rc($apaterno, $amaterno, $nombre,'','',0);
    }
   
    $i = 1;
    $datos=array();
    while ($fila = mysql_fetch_array($apersona)) {      
        
        $paterno=$fila[apellido_p];
        $materno=$fila[apellido_m];
        $nombre=$fila[nombre];                               
        
        $datos[]=array("paterno"=>$paterno,"materno"=>$materno,"nombre" => $nombre);
        $i++;
        
    }
   
    $pdf = new FPDF();
    // Títulos de las columnas
    $header = array('Ap. Paterno', 'Ap. Materno', 'Nombre');
    // Carga de datos    
    $pdf->SetFont('Arial','',12);
    $pdf->AddPage();
    // Colores, ancho de línea y fuente en negrita
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(128,0,0);
    $pdf->SetLineWidth(.3);
    $pdf->SetFont('','B');
    // Cabecera
    $w = array(60, 60, 60);
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $pdf->Ln();
    // Restauración de colores y fuentes
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    // Datos
    $fill = false;
    foreach($datos as $row)
    {
        $pdf->Cell($w[0],6,$row["paterno"],'LR',0,'L',$fill);
        $pdf->Cell($w[1],6,$row["materno"],'LR',0,'L',$fill);
        $pdf->Cell($w[2],6,$row["nombre"],'LR',0,'L',$fill);
        
        $pdf->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $pdf->Cell(array_sum($w),0,'','T');
    // ---------------------------------------------------------
    
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output('reporte.pdf','D');

    //============================================================+
    // END OF FILE
    //============================================================+

}

function buscar_persona_red($idinteraccion_complejo_sh=array()) {
    //echo "apaterno = $apaterno amaterno=$amaterno  nombre=$nombre idpersona_tipo=$idpersona_tipo es_stakeholder=$es_stakeholder";
    //es_stakeholder 2 rc_usuario
    //echo $es_stakeholder;
    $ipersona = new ipersona();
    $apersona = $ipersona->lista_sh_red($idinteraccion_complejo_sh);
    
    $datos=array();
    while ($fila = mysql_fetch_array($apersona)) {
        
        $paterno=$fila[apellido_p];
        $materno=$fila[apellido_m];
        $nombre=$fila[nombre];
        $cantidad=$fila[cantidad];
        
         $paterno="<a  href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >".$fila[apellido_p]."</a>";
            $materno="<a href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >".$fila[apellido_m]."</a>";
            $nombre="<a  href=\"javascript:cargar_stakeholder('$fila[idpersona]---$fila[idmodulo]---$fila[idpersona_tipo]')\" >".$fila[nombre]."</a>";
        
        $datos[]=array("paterno"=>utf8_encode($paterno),"materno"=>utf8_encode($materno),"nombre" => utf8_encode($nombre), "red"=>$cantidad);
    
        
    }
    //$plantilla->presentaPlantilla();
    echo json_encode($datos);
}

?>