<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * =
 *
 */

include_once '../../include_utiles.php';

include_once '../../../gestion/tag/class.gtag.php';
include_once '../../../gestion/stakeholder/class.gstakeholder.php';
include_once '../../../informacion/tag/class.itag.php';

include_once '../../../programas/mensajes.php';
$ayudante = new Ayudante();
$op_tag = $_REQUEST["op_tag"];
//tag

$tag = $ayudante->caracter($_REQUEST["tag"]);
//echo $tag;exit;
$idtag = $_REQUEST["idtag"];
$idpersona = $_REQUEST["idpersona"];
$idmodulo = $_REQUEST["idmodulo"];
$idmodulo_tag = $_REQUEST["idmodulo_tag"];
//analisis red
$idtag_padre_compuesto = $_REQUEST["idtag_padre_compuesto"];
$idtag_entidad = $_REQUEST["idtag_entidad"];

$tipo_check=$_REQUEST["tipo_check"];


if (!$seguridad->verificaSesion()) {
    $mensaje = "Ingrese su usuario y contraseña";
    header("Location: ../../../index.php?mensaje=$mensaje");
}

//echo $op_stakeholder;
switch ($op_tag) {
    case "ver_buscar_tag":ver_buscar_tag();
        break;
    case "ver_crear_tag":ver_crear_tag();
        break;
    case "guardar_tag":guardar_tag_stakeholder($tag, $idpersona, $idmodulo);
        break;
    case "crear_tag":crear_tag($tag,$idtag_padre_compuesto,$idtag_entidad);
        break;
    case "buscar_tag":buscar_tag($tag, $idtag, $idmodulo_tag);
        break;
    case "ver_ultimos_tags":ver_ultimos_tags();
        break;
    case "ver_tags":ver_tags();
        break;
    case "ver_tags_persona":ver_tags_persona($idtag, $idmodulo_tag);
        break;
    case "editar_tag":editar_tag($idtag, $idmodulo_tag, $tag,$idtag_entidad,$idtag_padre_compuesto);
        break;
    case "confirmar_tag":confirmar_tag();
        break;
    case "eliminar_tag":eliminar_tag($idtag, $idmodulo_tag);
        break;
    case "ver_tag_unico":ver_tag_unico($idtag, $idmodulo_tag, $tag);
        break;
    case "refrescar_tag_stakeholder":refrescar_tag_stakeholder($idpersona_tag, $idpersona, $idmodulo);
        break;
    case "ver_arbol_tags":ver_arbol_tags();break;
    case "ver_todos_tags":ver_todos_tags();break;
    case "ver_arbol_tags_check":ver_arbol_tags_check($tipo_check);break;
    case "ver_editar_tag":ver_editar_tag($idtag, $idmodulo_tag);break;
}

function ver_crear_tag() {

    $plantilla = new DmpTemplate('../../../plantillas/stakeholder/tag/crear_tag.html');
    
    $itag = new itag();
    $result = $itag->lista_tag_nivel();
    
    while($fila = mysql_fetch_array($result)){
        $plantilla->iniciaBloque("tag");
        $fila[tag]=  utf8_encode($fila[tag]);
        for($i=0;$i<$fila[nivel];$i++){
            $fila[tag]="&nbsp;&nbsp;&nbsp;".$fila[tag];
        }
        $plantilla->reemplazaEnBloque("tag", $fila[tag], "tag");        
        $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "tag");
        $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "tag");
    }
    
    $result = $itag->lista_tag_entidad();
    
    while($fila = mysql_fetch_array($result)){
        $plantilla->iniciaBloque("tag_entidad");
        
        $plantilla->reemplazaEnBloque("idtag_entidad", $fila[idtag_entidad], "tag_entidad");        
        $plantilla->reemplazaEnBloque("entidad", utf8_encode($fila[entidad]), "tag_entidad");
        
    }

    $plantilla->presentaPlantilla();
}

function ver_editar_tag($idtag, $idmodulo_tag) {

   $plantilla = new DmpTemplate('../../../plantillas/stakeholder/tag/edit_tag.html');
    
    $itag = new itag();
    
    $result=$itag->get_idtag($idtag, $idmodulo_tag);

    while($fila = mysql_fetch_array($result)){
        //$tag=$fila[tag];
       $idmodulo_tag_padre=$fila[idmodulo_tag_padre];
        $idtag_padre=$fila[idtag_padre];
    }     
    
   
    $result = $itag->lista_tag_nivel();
    
    while($fila = mysql_fetch_array($result)){
        $plantilla->iniciaBloque("tag");
        $fila[tag]=  utf8_encode($fila[tag]);
        for($i=0;$i<$fila[nivel];$i++){
            $fila[tag]="&nbsp;&nbsp;&nbsp;".$fila[tag];
        }
        //echo $idtag_padre." ".$fila[idtag]."<br>";
        if($idtag_padre==$fila[idtag]){
          
            $plantilla->reemplazaEnBloque("selected", "selected", "tag"); 
        }
        $plantilla->reemplazaEnBloque("tag", $fila[tag], "tag");        
        $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "tag");
        $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "tag");
    }    
    
    $result = $itag->lista_tag_entidad_tag($idtag, $idmodulo_tag);
    
    while($fila = mysql_fetch_array($result)){
        $plantilla->iniciaBloque("tag_entidad");
        if(isset($fila[activo])){
            $plantilla->reemplazaEnBloque("checked", "checked", "tag_entidad"); 
            $plantilla->reemplazaEnBloque("valor", $fila[idtag_entidad]."***1", "tag_entidad");
        }else{
            $plantilla->reemplazaEnBloque("valor", $fila[idtag_entidad]."###0", "tag_entidad");
        }
        $plantilla->reemplazaEnBloque("idtag_entidad", $fila[idtag_entidad], "tag_entidad");        
        $plantilla->reemplazaEnBloque("entidad", utf8_encode($fila[entidad]), "tag_entidad");
        
    }

    $plantilla->presentaPlantilla();
}

function crear_tag($tag,$idtag_padre_compuesto,$idtag_entidad) {

    $respuesta = 0;
    //guardar el tag y mostrar el mensaje
    $gtag = new gtag();

    $respuesta = $gtag->crear_tag($tag,$idtag_padre_compuesto,$idtag_entidad);
    $arespuesta = explode("***", $respuesta);

    if ($arespuesta[0] == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del tag ");
        //$data['mensaje'] = $mensaje;
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del tag, puede que ya exista.");
        //$data['mensaje'] = $mensaje;
    }
    echo json_encode($data);
}

function guardar_tag_stakeholder($tag, $idpersona, $idmodulo) {
    //se crea el tag y se guarda
    $idmodulo_tag = $_SESSION[idmodulo];

    $respuesta = 0;
    //$mensaje="flag1";
    //guardar el tag y mostrar el mensaje
    $gtag = new gtag();
    $itag = new itag();

    $gstakeholder = new gstakeholder();

    $respuesta = $gtag->crear_tag($tag);
    $arespuesta = explode("***", $respuesta);

    if ($arespuesta[0] == 0) {

        $respuesta = $gstakeholder->agregar_tag($arespuesta[1], $idmodulo_tag, $idpersona, $idmodulo);
    }

    //$plantilla->reemplaza("mensaje", $mensaje);//mostrar el mensaje adecuado
    //$plantilla->presentaPlantilla();
    if ($respuesta == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del tag ");
        $data['data'] = $idtag . "---" . $idmodulo_tag;
        //$data['mensaje'] = $mensaje;
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del tag");
        //$data['mensaje'] = $mensaje;
    }
    echo json_encode($data);
}

function buscar_tag($tag = "", $idtag = "", $idmodulo_tag = "") {
	$seguridad = new Seguridad();
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/tag/resultado_buscar_tag.html");
    //echo "tag " . $tag;
    $mensaje = "";
    $anterior = "";
    $itag = new itag();
    //$result = $itag->get_coincidencias_cadena($tag);
    if (!empty($idtag) && !empty($idmodulo_tag)) {
        //echo "ver " . $idtag . "----" . $idmodulo_tag;

        $result = $itag->get_idtag($idtag, $idmodulo_tag);
    } else {

        $result = $itag->listar_tag($tag);
    }

    //  $mensaje = "Se encontraron " . $fila[coincidencias] . " coincidencias";
    $count = 0;
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        $letra = substr($fila[tag], 0, 1);
        if ($letra != $anterior) {
            $plantilla->iniciaBloque("letra_tag");
            $plantilla->reemplazaEnBloque("letra", strtoupper($letra), "letra_tag");
            $anterior = $letra;
        }
        $plantilla->iniciaBloque("resultado_tag");
        $plantilla->reemplazaEnBloque("numero", $count, "resultado_tag");
        $plantilla->reemplazaEnBloque("tag", $fila[tag], "resultado_tag");
        $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "resultado_tag");
        $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "resultado_tag");
		
		if($seguridad->verifica_permiso("Editar", "Tag", $fila[idusu_c], $fila[idmodulo_c])){
            $plantilla->iniciaBloque ("editar_tag");
            $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "editar_tag");
            $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "editar_tag");
            $plantilla->reemplazaEnBloque("tag", $fila[tag], "editar_tag");
        }
        
        if($seguridad->verifica_permiso("Eliminar", "Tag", $fila[idusu_c], $fila[idmodulo_c])){
            $plantilla->iniciaBloque ("eliminar_tag");
            $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "eliminar_tag");
            $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "eliminar_tag");
            $plantilla->reemplazaEnBloque("tag", $fila[tag], "eliminar_tag");
        }
    }


    //$plantilla->reemplaza("mensaje", $mensaje); //mostrar el mensaje adecuado
    $plantilla->presentaPlantilla();
}

function ver_buscar_tag() {

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/tag/buscar_tag.html");
    //echo "tag " . $tag;
    $plantilla->presentaPlantilla();
}

function ver_ultimos_tags() {
    $seguridad = new Seguridad();
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/tag/resultado_buscar_tag.html");
    $itag = new itag();
    $result = $itag->listar_tag("", 1);
    $count = 0;
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        $letra = substr($fila[tag], 0, 1);
        if ($letra != $anterior) {
            $plantilla->iniciaBloque("letra_tag");
            $plantilla->reemplazaEnBloque("letra", strtoupper($letra), "letra_tag");
            $anterior = $letra;
        }

        $plantilla->iniciaBloque("resultado_tag");
        $plantilla->reemplazaEnBloque("numero", $count, "resultado_tag");
        $plantilla->reemplazaEnBloque("tag", utf8_encode($fila[tag]), "resultado_tag");
        $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "resultado_tag");
        $plantilla->reemplazaEnBloque("fecha", "( " . $fila[fecha_a] . " )", "resultado_tag");
        $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "resultado_tag");
        
        if($seguridad->verifica_permiso("Editar", "Tag", $fila[idusu_c], $fila[idmodulo_c])){
            $plantilla->iniciaBloque ("editar_tag");
            $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "editar_tag");
            $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "editar_tag");
            $plantilla->reemplazaEnBloque("tag", utf8_encode($fila[tag]), "editar_tag");
        }
        
        if($seguridad->verifica_permiso("Eliminar", "Tag", $fila[idusu_c], $fila[idmodulo_c])){
            $plantilla->iniciaBloque ("eliminar_tag");
            $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "eliminar_tag");
            $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "eliminar_tag");
            $plantilla->reemplazaEnBloque("tag", utf8_encode($fila[tag]), "eliminar_tag");
        }
    }



    $plantilla->presentaPlantilla();
}

function ver_tags() {
    $seguridad = new Seguridad();
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/tag/resultado_buscar_tag.html");
    $itag = new itag();
    $result = $itag->listar_tag("", 0);
    $count = 0;
    $anterior = "";
    while ($fila = mysql_fetch_array($result)) {

        $count++;
        $letra = substr($fila[tag], 0, 1);
        if ($letra != $anterior) {
            $plantilla->iniciaBloque("letra_tag");
            $plantilla->reemplazaEnBloque("letra", strtoupper($letra), "letra_tag");
            $anterior = $letra;
        }

        $plantilla->iniciaBloque("resultado_tag");
        $plantilla->reemplazaEnBloque("numero", $count, "resultado_tag");
        $plantilla->reemplazaEnBloque("tag", $fila[tag], "resultado_tag");
        $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "resultado_tag");
        $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "resultado_tag");
        
        if($seguridad->verifica_permiso("Editar", "Tag", $fila[idusu_c], $fila[idmodulo_c])){
            $plantilla->iniciaBloque ("editar_tag");
            $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "editar_tag");
            $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "editar_tag");
            $plantilla->reemplazaEnBloque("tag", $fila[tag], "editar_tag");
        }
        
        if($seguridad->verifica_permiso("Eliminar", "Tag", $fila[idusu_c], $fila[idmodulo_c])){
            $plantilla->iniciaBloque ("eliminar_tag");
            $plantilla->reemplazaEnBloque("idtag", $fila[idtag], "eliminar_tag");
            $plantilla->reemplazaEnBloque("idmodulo_tag", $fila[idmodulo_tag], "eliminar_tag");
            $plantilla->reemplazaEnBloque("tag", $fila[tag], "eliminar_tag");
        }
        
    }

    $plantilla->presentaPlantilla();
}

function ver_arbol_tags_check($tipo_check=""){
    $itag = new itag();    
    
    $datos = array();
    
    $count=0;
    
    $result= $itag->lista_tag_nivel_sh();
    
    while($fila=  mysql_fetch_array($result)){
        $id=$fila['idtag'].'-'.$fila['idmodulo_tag'];
        $datos['tags_sh'][$count]['id']=$id;
        //$datos['tags']['response'][$count]['id']=$fila['idtag'];
        $datos['tags_sh'][$count]['tag']=  utf8_encode("<a href=\"javascript:modal_ver_stakeholders(".$fila['idtag'].",".$fila['idmodulo_tag'].",'".$fila['tag']."')\">".$fila['tag']."</a>");        
        $tag = utf8_encode($fila[tag])." [".$fila[sh]."]";
        $datos['tags_sh'][$count]['num']=($count+1);
        if(isset($tipo_check) && $tipo_check==1){
            $datos['tags_sh'][$count]['check']=  "<input id=\"$id\" type=\"checkbox\" class=\"tags_sh\" onclick=\"actualiza_identificador_geografico()\" value=\"$id\" name=\"idtag_compuesto[]\"  />";
        }else{
            $datos['tags_sh'][$count]['check']=  "<input id=\"$id\" type=\"checkbox\" name=\"tags[]\"  value=\"$idtag\" class=\"tags_sh_todos\" onclick=\"actualiza_estado_tag('$id','$tag')\" checked /><input id=\"id$id\" type=\"hidden\"   value=\"$id\" name=\"idtag_compuesto[]\" />";
        }
        $datos['tags_sh'][$count]['level']=$fila['nivel'];
        $datos['tags_sh'][$count]['ruta']=  utf8_encode($fila['tag_ruta']);
        $datos['tags_sh'][$count]['loaded']=true;
        $datos['tags_sh'][$count]['parent']=null;
        if($fila['nivel']>0){
            $datos['tags_sh'][$count]['parent']=$fila['idtag_padre'].'-'.$fila['idmodulo_tag_padre'];
            //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
        }
        $datos['tags_sh'][$count]['isLeaf']=true;
        $datos['tags_sh'][$count]['expanded']=false;        
        if($fila['hijos']>0){
            $datos['tags_sh'][$count]['isLeaf']=false;
            $datos['tags_sh'][$count]['expanded']=true;            
        }
        
        $count++;
    }
    
    $count=0;
    
    $result= $itag->lista_tag_nivel_interaccion();
    
    while($fila=  mysql_fetch_array($result)){
        $id=$fila['idtag'].'-'.$fila['idmodulo_tag'];
        $datos['tags'][$count]['id']=$id;
        //$datos['tags']['response'][$count]['id']=$fila['idtag'];
        $datos['tags'][$count]['tag']=  utf8_encode("<a href=\"javascript:modal_ver_stakeholders(".$fila['idtag'].",".$fila['idmodulo_tag'].",'".$fila['tag']."')\">".$fila['tag']."</a>");        
        $tag = utf8_encode($fila[tag]);
        $datos['tags'][$count]['num']=($count+1);
        if(isset($tipo_check) && $tipo_check==1){
            $datos['tags'][$count]['check']=  "<input id=\"$id\" type=\"checkbox\" class=\"tags\" onclick=\"actualiza_identificador_geografico()\" value=\"$id\" name=\"tags[]\"  />";
        }else{
            $datos['tags'][$count]['check']=  "<input type=\"checkbox\" class=\"tags_todos\" onclick=\"cambiar_serie('$tag')\" checked />";
        }
        
        $datos['tags'][$count]['level']=$fila['nivel'];
        $datos['tags'][$count]['ruta']=  utf8_encode($fila['tag_ruta']);
        $datos['tags'][$count]['loaded']=true;
        $datos['tags'][$count]['parent']=null;
        if($fila['nivel']>0){
            $datos['tags'][$count]['parent']=$fila['idtag_padre'].'-'.$fila['idmodulo_tag_padre'];
            //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
        }
        $datos['tags'][$count]['isLeaf']=true;
        $datos['tags'][$count]['expanded']=false;        
        if($fila['hijos']>0){
            $datos['tags'][$count]['isLeaf']=false;
            $datos['tags'][$count]['expanded']=true;            
        }
        
        $count++;
    }
    
    $count=0;
    
    $result= $itag->lista_tag_nivel_predio();
    
    while($fila=  mysql_fetch_array($result)){
        $id=$fila['idtag'].'-'.$fila['idmodulo_tag'];
        $datos['tags_predio'][$count]['id']=$id;
        //$datos['tags']['response'][$count]['id']=$fila['idtag'];
        $datos['tags_predio'][$count]['tag']=  utf8_encode("<a href=\"javascript:modal_ver_stakeholders(".$fila['idtag'].",".$fila['idmodulo_tag'].",'".$fila['tag']."')\">".$fila['tag']."</a>");        
        $tag = utf8_encode($fila[tag]);
        $datos['tags_predio'][$count]['num']=($count+1);
        if(isset($tipo_check) && $tipo_check==1){
            $datos['tags_predio'][$count]['check']=  "<input id=\"$id\" type=\"checkbox\" class=\"tags_predio\" onclick=\"actualiza_identificador_geografico()\" value=\"$id\" name=\"tags_predio[]\"  />";
        }else{
            $datos['tags_predio'][$count]['check']=  "<input type=\"checkbox\" class=\"tags_todos\" onclick=\"cambiar_serie('$tag')\" checked />";
        }
        
        $datos['tags_predio'][$count]['level']=$fila['nivel'];
        $datos['tags_predio'][$count]['ruta']=  utf8_encode($fila['tag_ruta']);
        $datos['tags_predio'][$count]['loaded']=true;
        $datos['tags_predio'][$count]['parent']=null;
        if($fila['nivel']>0){
            $datos['tags_predio'][$count]['parent']=$fila['idtag_padre'].'-'.$fila['idmodulo_tag_padre'];
            //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
        }
        $datos['tags_predio'][$count]['isLeaf']=true;
        $datos['tags_predio'][$count]['expanded']=false;        
        if($fila['hijos']>0){
            $datos['tags_predio'][$count]['isLeaf']=false;
            $datos['tags_predio'][$count]['expanded']=true;            
        }
        
        $count++;
    }
    
    //print_r($datos);
    echo json_encode($datos);
}

function ver_arbol_tags() {
    $seguridad = new Seguridad();
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/tag/resultado_buscar_arbol_tag.html");
    $itag = new itag();    
    
    $datos['html'] = utf8_encode($plantilla->getPlantillaCadena());
    $count=0;
    
    $result= $itag->lista_tag_nivel();
    
    while($fila=  mysql_fetch_array($result)){
        $datos['tags']['response'][$count]['id']=$fila['idtag'].'_'.$fila['idmodulo_tag'];
        //$datos['tags']['response'][$count]['id']=$fila['idtag'];
        $datos['tags']['response'][$count]['tag']=  utf8_encode("<a href=\"javascript:ver_stakeholders(".$fila['idtag'].",".$fila['idmodulo_tag'].",'".$fila['tag']."')\">".$fila['tag']."</a>");
        if($seguridad->verifica_permiso("Editar", "Tag", $fila[idusu_c], $fila[idmodulo_c]))
            $datos['tags']['response'][$count]['accion'].=  utf8_encode("<a href=\"javascript:modal_mostrar_editar_tag(".$fila['idtag'].",".$fila['idmodulo_tag'].",'".$fila['tag']."',2)\"><img src=\"../../../img/edit.png\" alt=\"Editar\"/></a>");
        if($seguridad->verifica_permiso("Eliminar", "Tag", $fila[idusu_c], $fila[idmodulo_c]))
            $datos['tags']['response'][$count]['accion'].=  utf8_encode("<a href=\"javascript:mostrar_eliminar_tag(".$fila['idtag'].",".$fila['idmodulo_tag'].")\"><img src=\"../../../img/trash.png\" alt=\"Editar\"/></a>");
        $datos['tags']['response'][$count]['num']=  ($count+1);
        $datos['tags']['response'][$count]['level']=$fila['nivel'];
        $datos['tags']['response'][$count]['loaded']=true;
        $datos['tags']['response'][$count]['parent']=null;
        if($fila['nivel']>0){
            $datos['tags']['response'][$count]['parent']=$fila['idtag_padre'].'_'.$fila['idmodulo_tag_padre'];
            //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
        }
        $datos['tags']['response'][$count]['isLeaf']=true;
        $datos['tags']['response'][$count]['expanded']=false;        
        if($fila['hijos']>0){
            $datos['tags']['response'][$count]['isLeaf']=false;
            $datos['tags']['response'][$count]['expanded']=true;            
        }
        
        $count++;
    }
    
    /*
    $datos['tags']['response'][0]['id']='1';
    $datos['tags']['response'][0]['elementName']='Grouping';
    $datos['tags']['response'][0]['level']='0';
    $datos['tags']['response'][0]['parent']='';
    $datos['tags']['response'][0]['isLeaf']=false;
    $datos['tags']['response'][0]['expanded']=false;
    $datos['tags']['response'][0]['loaded']=false;
    
    $datos['tags']['response'][1]['id']='1_1';
    $datos['tags']['response'][1]['elementName']='Simple Grouping';
    $datos['tags']['response'][1]['level']='1';
    $datos['tags']['response'][1]['parent']='1';
    $datos['tags']['response'][1]['isLeaf']=true;
    $datos['tags']['response'][1]['expanded']=false;
    $datos['tags']['response'][1]['loaded']=true;
    
    $datos['tags']['response'][2]['id']='1_2';
    $datos['tags']['response'][2]['elementName']='May be some other grouping';
    $datos['tags']['response'][2]['level']='1';
    $datos['tags']['response'][2]['parent']='1';
    $datos['tags']['response'][2]['isLeaf']=true;
    $datos['tags']['response'][2]['expanded']=false;
    $datos['tags']['response'][2]['loaded']=true;
    
    $datos['tags']['response'][3]['id']='2';
    $datos['tags']['response'][3]['elementName']='CustomFormater';
    $datos['tags']['response'][3]['level']='0';
    $datos['tags']['response'][3]['parent']='';
    $datos['tags']['response'][3]['isLeaf']=false;
    $datos['tags']['response'][3]['expanded']=true;
    $datos['tags']['response'][3]['loaded']=true;
    
    $datos['tags']['response'][4]['id']='2_1';
    $datos['tags']['response'][4]['elementName']='Image Formatter';
    $datos['tags']['response'][4]['level']='1';
    $datos['tags']['response'][4]['parent']='2';
    $datos['tags']['response'][4]['isLeaf']=true;
    $datos['tags']['response'][4]['expanded']=false;
    $datos['tags']['response'][4]['loaded']=true;
    
    $datos['tags']['response'][5]['id']='2_2';
    $datos['tags']['response'][5]['elementName']='Anchor Formatter';
    $datos['tags']['response'][5]['level']='1';
    $datos['tags']['response'][5]['parent']='2';
    $datos['tags']['response'][5]['isLeaf']=true;
    $datos['tags']['response'][5]['expanded']=false;
    $datos['tags']['response'][5]['loaded']=true; 
     * 
     */             
    
    echo json_encode($datos);
}

function ver_todos_tags() {
    $seguridad = new Seguridad();
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/tag/resultado_buscar_todos_tag.html");
    $itag = new itag();    
    
    $datos['html'] = utf8_encode($plantilla->getPlantillaCadena());
    $count=0;
    
    $aresult= $itag->lista_tag_nivel_entidad();
    
    foreach($aresult['tag'] as $id => $tag){
        $datos['tags']['response'][$count]['id']=$id;
        //$datos['tags']['response'][$count]['id']=$fila['idtag'];
        $datos['tags']['response'][$count]['tag']=  utf8_encode("<a href=\"javascript:modal_ver_stakeholders(".$aresult['idtag'][$id].",".$aresult['idmodulo_tag'][$id].",'".$tag."')\">".$tag."</a>");
        if($seguridad->verifica_permiso("Editar", "Tag", $fila[idusu_c], $fila[idmodulo_c]))
            $datos['tags']['response'][$count]['accion'].=  utf8_encode("<a href=\"javascript:modal_mostrar_editar_tag(".$aresult['idtag'][$id].",".$aresult['idmodulo_tag'][$id].",'".$tag."',2)\"><img src=\"../../../img/edit.png\" alt=\"Editar\"/></a>");
        if($seguridad->verifica_permiso("Eliminar", "Tag", $fila[idusu_c], $fila[idmodulo_c]))
            $datos['tags']['response'][$count]['accion'].=  utf8_encode("<a href=\"javascript:mostrar_eliminar_tag(".$aresult['idtag'][$id].",".$aresult['idmodulo_tag'][$id].")\"><img src=\"../../../img/trash.png\" alt=\"Editar\"/></a>");
        $datos['tags']['response'][$count]['num']=  ($count+1);
        $datos['tags']['response'][$count]['level']=$aresult['nivel'][$id];
        $datos['tags']['response'][$count]['hijos']=$aresult['hijos'][$id];
        $datos['tags']['response'][$count]['ruta']=  utf8_encode($aresult['tag_ruta'][$id]);
        $datos['tags']['response'][$count]['loaded']=true;
        $datos['tags']['response'][$count]['parent']=null;
        if($fila['nivel']>0){
            $datos['tags']['response'][$count]['parent']=$aresult['idtag_padre'][$id].'_'.$aresult['idmodulo_tag_padre'][$id];
            //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
        }
        $datos['tags']['response'][$count]['isLeaf']=true;
        $datos['tags']['response'][$count]['expanded']=false;        
        if($fila['cantidad_hijos']>0){
            $datos['tags']['response'][$count]['isLeaf']=false;
            $datos['tags']['response'][$count]['expanded']=true;            
        }
        
        $datos['tags']['response'][$count]['entidad']="";
        
        $i=0;
        foreach ($aresult['entidad'][$id] as $entidad) {
            $datos['tags']['response'][$count]['entidad'].=utf8_encode($entidad);
            $i++;
            if($i<  sizeof($aresult['entidad'][$id])){
                $datos['tags']['response'][$count]['entidad'].=" , ";
            }
            
        }
        
        $count++;
    }
    
    /*
    $datos['tags']['response'][0]['id']='1';
    $datos['tags']['response'][0]['elementName']='Grouping';
    $datos['tags']['response'][0]['level']='0';
    $datos['tags']['response'][0]['parent']='';
    $datos['tags']['response'][0]['isLeaf']=false;
    $datos['tags']['response'][0]['expanded']=false;
    $datos['tags']['response'][0]['loaded']=false;
    
    $datos['tags']['response'][1]['id']='1_1';
    $datos['tags']['response'][1]['elementName']='Simple Grouping';
    $datos['tags']['response'][1]['level']='1';
    $datos['tags']['response'][1]['parent']='1';
    $datos['tags']['response'][1]['isLeaf']=true;
    $datos['tags']['response'][1]['expanded']=false;
    $datos['tags']['response'][1]['loaded']=true;
    
    $datos['tags']['response'][2]['id']='1_2';
    $datos['tags']['response'][2]['elementName']='May be some other grouping';
    $datos['tags']['response'][2]['level']='1';
    $datos['tags']['response'][2]['parent']='1';
    $datos['tags']['response'][2]['isLeaf']=true;
    $datos['tags']['response'][2]['expanded']=false;
    $datos['tags']['response'][2]['loaded']=true;
    
    $datos['tags']['response'][3]['id']='2';
    $datos['tags']['response'][3]['elementName']='CustomFormater';
    $datos['tags']['response'][3]['level']='0';
    $datos['tags']['response'][3]['parent']='';
    $datos['tags']['response'][3]['isLeaf']=false;
    $datos['tags']['response'][3]['expanded']=true;
    $datos['tags']['response'][3]['loaded']=true;
    
    $datos['tags']['response'][4]['id']='2_1';
    $datos['tags']['response'][4]['elementName']='Image Formatter';
    $datos['tags']['response'][4]['level']='1';
    $datos['tags']['response'][4]['parent']='2';
    $datos['tags']['response'][4]['isLeaf']=true;
    $datos['tags']['response'][4]['expanded']=false;
    $datos['tags']['response'][4]['loaded']=true;
    
    $datos['tags']['response'][5]['id']='2_2';
    $datos['tags']['response'][5]['elementName']='Anchor Formatter';
    $datos['tags']['response'][5]['level']='1';
    $datos['tags']['response'][5]['parent']='2';
    $datos['tags']['response'][5]['isLeaf']=true;
    $datos['tags']['response'][5]['expanded']=false;
    $datos['tags']['response'][5]['loaded']=true; 
     * 
     */             
    
    echo json_encode($datos);
}

function ver_tags_persona($idtag, $idmodulo_tag) {

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/tag/ver_tags_persona.html");
    $itag = new itag();
    $result = $itag->listar_tags_persona($idtag, $idmodulo_tag);
    $count = 0;

    while ($fila = mysql_fetch_array($result)) {

        $count++;

        $plantilla->iniciaBloque("persona");
        $plantilla->reemplazaEnBloque("numero", $count, "persona");
        if($fila[idpersona_tipo]>1){
            $plantilla->reemplazaEnBloque("nombre", utf8_encode($fila[apellido_p] ), "persona");
        }else{
            $plantilla->reemplazaEnBloque("nombre", utf8_encode($fila[apellido_p] . " " . $fila[apellido_m] . " , " . $fila[nombre]), "persona");
        }
        $plantilla->reemplazaEnBloque("idpersona_compuesto", $fila[idpersona] . "---" . $fila[idmodulo], "persona");
    }

    $plantilla->presentaPlantilla();
}

function ver_tag_unico($idtag, $idmodulo, $tag) {
    $plantilla1 = new DmpTemplate("../../../plantillas/stakeholder/tag/buscar_tag.html");
    $plantilla2 = new DmpTemplate("../../../plantillas/stakeholder/tag/ver_tags_persona.html");
    $itag = new itag();
    $result = $itag->listar_tags_persona($idtag);
    $count = 0;

    while ($fila = mysql_fetch_array($result)) {

        $count++;
        //print_r($fila);
        if ($count % 2 == 0) {
            $plantilla2->reemplazaEnBloque("clase", "odd", "persona");
        }
        $plantilla2->iniciaBloque("persona");
        $plantilla2->reemplazaEnBloque("numero", $count, "persona");
        $plantilla2->reemplazaEnBloque("nombre", $fila[nombre], "persona");
    }
    $plantilla1->reemplaza("mensaje_resultado", "Mostrando resultados para '$tag' ");
    $plantilla1->reemplaza("ver_tags_persona", $plantilla2->getPlantillaCadena());
    $plantilla1->presentaPlantilla();
}

function editar_tag($idtag, $idmodulo_tag, $tag, $idtag_entidad,$idtag_padre_compuesto) {
    $gtag = new gtag();
    $error = $gtag->actualizar($idtag, $idmodulo_tag, $tag,$idtag_entidad,$idtag_padre_compuesto);
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " del tag ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " del tag ");
    }


    echo json_encode($data);
}

function confirmar_tag() {

    echo coloca_mensaje("confirma", " del tag ");
}

function eliminar_tag($idtag, $idmodulo_tag) {
    $gtag = new gtag();
    $error = $gtag->eliminar($idtag, $idmodulo_tag);
    
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " del tag ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " del tag ");
    }


    echo json_encode($data);
}

function refrescar_tag_stakeholder($idpersona_tag, $idpersona, $idmodulo) {

    ver_tag_stakeholder($idpersona, $idmodulo);
}

?>
