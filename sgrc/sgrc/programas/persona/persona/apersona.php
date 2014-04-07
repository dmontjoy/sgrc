<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * =
 *
 */

include_once '../../include_utiles.php';
include_once '../../../informacion/persona/class.idocumento_identificacion.php';
include_once '../../../informacion/persona/class.itipo.php';
include_once '../../../informacion/persona/class.ipersona.php';
include_once '../../../informacion/persona/class.icargo.php';
include_once '../../../informacion/persona/class.iestado_civil.php';

include_once '../../../gestion/stakeholder/class.gstakeholder.php';
include_once '../../../gestion/persona/class.gpersona.php';
include_once '../../../gestion/relacionista_comunitario/class.grelacionista_comunitario.php';

include_once '../../../programas/persona/persona/ver_persona.php';
include_once '../../../programas/persona/persona/buscar_persona.php';
include_once '../../../programas/mensajes.php';
include_once '../../../informacion/calificacion/class.idimension_matriz_sh.php';

$ayudante = new Ayudante();

$rol = $ayudante->caracter($_REQUEST['rol']);

$idseguridad_permiso = $_REQUEST['idseguridad_permiso'];
$idrol = $_REQUEST['idrol'];

$tipo = $_REQUEST['tipo'];

$idpersona = $_REQUEST['idpersona'];
$idmodulo = $_REQUEST['idmodulo'];
$nombre = $ayudante->caracter($_REQUEST['nombre']);
$apaterno = $ayudante->caracter($_REQUEST['apaterno']);
$amaterno = $ayudante->caracter($_REQUEST['amaterno']);
//$idtipo = $_REQUEST['idtipo'];
$filtro = $_REQUEST['filtro'];
$idpersona_documento_identificacion = $_REQUEST['idpersona_documento_identificacion'];
$numero_documento = $_REQUEST['numero_documento'];
$select_documento_identificacion = $_REQUEST['select_documento_identificacion'];
$persona_telefono = $_REQUEST['persona_telefono'];
$idpersona_telefono = $_REQUEST['idpersona_telefono'];
$idpersona_cargo = $_REQUEST['idpersona_cargo'];
$idestado_civil = $_REQUEST['idestado_civil'];
$persona_mail = $_REQUEST['persona_mail'];
$idpersona_mail = $_REQUEST['idpersona_mail'];
$persona_direccion = $_REQUEST['persona_direccion'];
$idpersona_direccion = $_REQUEST['idpersona_direccion'];
$comentario = $ayudante->caracter($_REQUEST['comentario']);
$background = $ayudante->caracter($_REQUEST['background']);
$fecha_nacimiento = $ayudante->caracter($_REQUEST['fecha_nacimiento']);
$sexo = $_REQUEST['sexo'];
$idpersona_organizacion = $_REQUEST['idpersona_organizacion'];
$idpersona_tipo = $_REQUEST['idpersona_tipo'];
$es_stakeholder = $_REQUEST['es_stakeholder'];
$idinteraccion_complejo_tag = $_REQUEST['idinteraccion_complejo_tag'];
$idinteraccion_complejo_sh = $_REQUEST['idinteraccion_complejo_sh'];
$criterio = $_REQUEST['criterio'];
$dimensiones = $_REQUEST['dimensiones'];
$operadores = $_REQUEST['operadores'];
$puntajes = $_REQUEST['puntajes'];
$busca_rapida = $_REQUEST["busca_rapida"];
$idprioridad_complejo_tag = $_REQUEST['idprioridad_complejo_tag'];

if (!$seguridad->verificaSesion()) {
    $mensaje = "Ingrese su usuario y contraseña";
    header("Location: ../../../index.php?mensaje=$mensaje");
}

switch ($_REQUEST["op_persona"]) {
    default :ver_nueva_persona($idpersona_tipo, $es_stakeholder);
        break;
    case "editar_rol":editar_rol($idrol,$rol,$idseguridad_permiso);
        break;
    case "ver_crear_rol":ver_crear_rol();
        break;
    case "ver_editar_rol":ver_editar_rol($idrol,$rol);
        break;
    case "crear_rol":crear_rol($rol,$idseguridad_permiso);
    break;
    case "buscar_rol":buscar_rol($idrol);
        break;
    case "guardar":guardar($es_stakeholder, $idmodulo, $nombre, $apaterno, $amaterno, $idpersona_tipo, $comentario, $fecha_nacimiento, $sexo, $background, $persona_direccion, $idpersona_direccion, $persona_telefono, $idpersona_telefono, $persona_mail, $idpersona_mail, $idpersona_organizacion, $idpersona_cargo, $idpersona_documento_identificacion, $select_documento_identificacion, $numero_documento, $es_stakeholder, $idestado_civil);
        break;
    case "ver_editar_persona" :ver_editar_persona($es_stakeholder, $idpersona, $idmodulo, "", "", 1);
        break;
     case "mostrar_editar_persona" :echo ver_editar_persona($es_stakeholder,$idpersona, $idmodulo, "", $idpersona_tipo, 1);
        //echo "es_stakeholder=$es_stakeholder idpersona=$idpersona idmodulo=$idmodulo idpersona_tipo=$idpersona_tipo";
        break;
    case "editar":editar($es_stakeholder, $idpersona, $idmodulo, $nombre, $apaterno, $amaterno, $idpersona_tipo, $comentario, $fecha_nacimiento, $sexo, $background, $persona_direccion, $idpersona_direccion, $persona_telefono, $idpersona_telefono, $persona_mail, $idpersona_mail, $idpersona_organizacion, $idpersona_cargo, $idpersona_documento_identificacion, $select_documento_identificacion, $numero_documento, $idestado_civil);
        break;
    case "ver_buscar_persona":ver_buscar_persona($es_stakeholder,$idpersona_tipo);
        break;
    case "ver_buscar_persona_prioridad":ver_buscar_persona_prioridad($es_stakeholder,$idpersona_tipo);
        break;
    case "buscar_persona":buscar_persona($apaterno, $amaterno, $nombre,$idpersona_tipo, $es_stakeholder,$filtro,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes);
        break;
    case "buscar_persona_prioridad":buscar_persona_prioridad($apaterno, $amaterno, $nombre,$idpersona_tipo, $es_stakeholder,$filtro,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes,$idprioridad_complejo_tag);
        break;
     case "buscar_persona_red":buscar_persona_red($idinteraccion_complejo_sh);
        break;
    case "exportar_persona":exportar_persona($apaterno, $amaterno, $nombre,$idpersona_tipo, $es_stakeholder,$filtro,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes);
        break;
    case "exportar_persona_red":exportar_persona_red($idinteraccion_complejo_sh);
        break;
    case "exportar_pdf_persona":exportar_pdf_persona($apaterno, $amaterno, $nombre,$idpersona_tipo, $es_stakeholder,$filtro,$idinteraccion_complejo_tag,$criterio,$dimensiones,$operadores,$puntajes);
        break;
    case "asignar_sh":asignar_sh($idpersona, $idmodulo);
        break;
    case "eliminar_sh":eliminar_sh($idpersona, $idmodulo);
        break;
    case "asignar_rc": asignar_rc($idpersona, $idmodulo);
        break;
    case "eliminar_rc": eliminar_rc($idpersona, $idmodulo);
        break;
    case "eliminar":eliminar($idpersona, $idmodulo);
        break;
    case "validar_nombre":validar_nombre($apaterno , $amaterno,$nombre, $idpersona, $idmodulo, $idpersona_tipo, $tipo);
        break;
    case "busqueda_rapida":busqueda_rapida($busca_rapida);
        break;
}

function editar_rol($idrol,$rol,$idseguridad_permiso) {
    
    $respuesta = 0;
    //guardar el tag y mostrar el mensaje
    $gpersona = new gpersona();

    $respuesta = $gpersona->editar_rol($idrol,$rol,$idseguridad_permiso);
    $arespuesta = explode("***", $respuesta);

    if ($arespuesta[0] == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " del rol ");
        //$data['mensaje'] = $mensaje;
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " del rol, puede que ya exista.");
        //$data['mensaje'] = $mensaje;
    }
    echo json_encode($data);
}

function crear_rol($rol,$idseguridad_permiso) {

    $respuesta = 0;
    //guardar el tag y mostrar el mensaje
    $gpersona = new gpersona();

    $respuesta = $gpersona->crear_rol($rol,$idseguridad_permiso);
    $arespuesta = explode("***", $respuesta);

    if ($arespuesta[0] == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del rol ");
        //$data['mensaje'] = $mensaje;
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del rol, puede que ya exista.");
        //$data['mensaje'] = $mensaje;
    }
    echo json_encode($data);
}

function ver_crear_rol() {

    $plantilla = new DmpTemplate('../../../plantillas/persona/persona/crear_rol.html');
    $ipersona = new ipersona();
    //$result = $itag->get_coincidencias_cadena($tag);
    
    $plantilla->reemplaza("op_persona", "crear_rol");
    $plantilla->reemplaza("titulo", "Nuevo");
    
    $apermiso = $ipersona->listar_permiso();
    
    $count = 1;
    foreach ($apermiso as $key => $permiso) {
                            
        $plantilla->iniciaBloque("fila_permiso");
        $plantilla->reemplazaEnBloque("clase_server", "celdaSimple", "fila_permiso");
        $plantilla->reemplazaEnBloque("clase_cliente", "celdaSimple", "fila_permiso");
        
        if(isset($permiso[1])){
            $plantilla->iniciaBloque("item_permiso_server");
            $plantilla->reemplazaEnBloque("numero_server", "$count.", "fila_permiso");
            $plantilla->reemplazaEnBloque("idpermiso_server", $permiso[1], "fila_permiso");
            $plantilla->reemplazaEnBloque("idpermiso", $permiso[1], "item_permiso_server");        
            $plantilla->reemplazaEnBloque("valor", $permiso[1], "item_permiso_server");
            $plantilla->reemplazaEnBloque("permiso_server", $key, "fila_permiso");
            
        }
        
        if(isset($permiso[0])){
            $plantilla->iniciaBloque("item_permiso_cliente");
            $plantilla->reemplazaEnBloque("numero_cliente", "$count.", "fila_permiso");
            $plantilla->reemplazaEnBloque("idpermiso_cliente", $permiso[0], "fila_permiso");
            $plantilla->reemplazaEnBloque("idpermiso", $permiso[0], "item_permiso_cliente");        
            $plantilla->reemplazaEnBloque("valor", $permiso[0], "item_permiso_cliente"); 
            $plantilla->reemplazaEnBloque("permiso_cliente", $key, "fila_permiso");            
        }
            
        $count++;
    }


    $plantilla->presentaPlantilla();
}


function ver_editar_rol($idrol, $rol) {

    $plantilla = new DmpTemplate('../../../plantillas/persona/persona/crear_rol.html');
    $ipersona = new ipersona();
    //$result = $itag->get_coincidencias_cadena($tag);
    
    $plantilla->reemplaza("op_persona", "editar_rol");
    $plantilla->reemplaza("idrol", $idrol);
    $plantilla->reemplaza("rol", $rol);
    //reemplazar idrol
    
    $plantilla->reemplaza("titulo", "Editar");
    
    $apermiso = $ipersona->listar_permiso_rol($idrol);
    
    //print_r($apermiso);
    
    $count = 1;
    foreach ($apermiso[idseguridad_permiso] as $key => $permiso) {
                            
        $plantilla->iniciaBloque("fila_permiso");
        
        if($apermiso[idseguridad_rol][$key][1]==$idrol){            
            $plantilla->reemplazaEnBloque("clase_server", "permiso", "fila_permiso");            
        }else{
            $plantilla->reemplazaEnBloque("clase_server", "celdaSimple", "fila_permiso");            
        }
        
        if($apermiso[idseguridad_rol][$key][0]==$idrol){
            $plantilla->reemplazaEnBloque("clase_cliente", "permiso", "fila_permiso");            
        }else{
            $plantilla->reemplazaEnBloque("clase_cliente", "celdaSimple", "fila_permiso");            
        }
        
        if(isset($permiso[1])){
            $plantilla->iniciaBloque("item_permiso_server");
            $plantilla->reemplazaEnBloque("numero_server", "$count.", "fila_permiso");
            $plantilla->reemplazaEnBloque("idpermiso_server", $permiso[1], "fila_permiso");
            $plantilla->reemplazaEnBloque("idpermiso", $permiso[1], "item_permiso_server");        
            if($apermiso[idseguridad_rol][$key][1]==$idrol){
                $plantilla->reemplazaEnBloque("checked", "checked" , "item_permiso_server");                
                $plantilla->reemplazaEnBloque("valor", $permiso[1]."***1", "item_permiso_server");
            }else{                
                $plantilla->reemplazaEnBloque("valor", $permiso[1], "item_permiso_server");
            }
            $plantilla->reemplazaEnBloque("permiso_server", $key, "fila_permiso");
            
        }
        
        if(isset($permiso[0])){
            $plantilla->iniciaBloque("item_permiso_cliente");
            $plantilla->reemplazaEnBloque("numero_cliente", "$count.", "fila_permiso");
            $plantilla->reemplazaEnBloque("idpermiso_cliente", $permiso[0], "fila_permiso");
            $plantilla->reemplazaEnBloque("idpermiso", $permiso[0], "item_permiso_cliente");        
            if($apermiso[idseguridad_rol][$key][0]==$idrol){
                $plantilla->reemplazaEnBloque("checked", "checked" , "item_permiso_cliente");                
                $plantilla->reemplazaEnBloque("valor", $permiso[0]."***1", "item_permiso_cliente");
            }else{                
                $plantilla->reemplazaEnBloque("valor", $permiso[0], "item_permiso_cliente");
            }
            $plantilla->reemplazaEnBloque("permiso_cliente", $key, "fila_permiso");            
        }
            
        $count++;
    }
    /*
    $count = 0;
    while ($fila = mysql_fetch_array($result)) {
        
        if($count % 2 == 0){
            $plantilla->iniciaBloque("fila_permiso");
        }
        $plantilla->iniciaBloque("item_permiso");
        $plantilla->reemplazaEnBloque("numero", ($count+1), "item_permiso");
        $plantilla->reemplazaEnBloque("idpermiso", $fila[idseguridad_permiso], "item_permiso");
        $plantilla->reemplazaEnBloque("permiso", $fila[nombre], "item_permiso");
        if($fila[idseguridad_rol]==$idrol){
            $plantilla->reemplazaEnBloque("checked", "checked" , "item_permiso");
            $plantilla->reemplazaEnBloque("clase", "permiso", "item_permiso");
            $plantilla->reemplazaEnBloque("valor", $fila[idseguridad_permiso]."***1", "item_permiso");
        }else{
            $plantilla->reemplazaEnBloque("clase", "celdaSimple", "item_permiso");
            $plantilla->reemplazaEnBloque("valor", $fila[idseguridad_permiso], "item_permiso");
        }
        $count++;
    }
     * 
     */


    $plantilla->presentaPlantilla();
}


function buscar_rol($idrol) {
    $plantilla = new DmpTemplate("../../../plantillas/persona/persona/resultado_buscar_rol.html");
    //echo "idrol " . $idrol;
    $mensaje = "";
    $anterior = "";
    $ipersona = new ipersona();
    //$result = $itag->get_coincidencias_cadena($tag);
    
    $result = $ipersona->listar_rol();
    
    //  $mensaje = "Se encontraron " . $fila[coincidencias] . " coincidencias";
    $count = 0;
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        
        $plantilla->iniciaBloque("resultado_rol");
        $plantilla->reemplazaEnBloque("numero", $count, "resultado_rol");
        $plantilla->reemplazaEnBloque("rol", $fila[rol], "resultado_rol");
        if(isset($idrol) && $idrol == $fila[idrol] ){
            $plantilla->reemplazaEnBloque("clase", "permiso", "resultado_rol");
        }else{
            $plantilla->reemplazaEnBloque("clase", "celdaSimple", "resultado_rol");
        }
        $plantilla->reemplazaEnBloque("idrol", $fila[idrol], "resultado_rol");
        $plantilla->reemplazaEnBloque("idmodulo_rol", $fila[idmodulo_rol], "resultado_rol");
    }

    if(isset($idrol)){
        $plantilla_usuario = new DmpTemplate("../../../plantillas/persona/persona/resultado_usuario_rol.html");
        $result = $ipersona->listar_usuario_rol($idrol);
    
        //  $mensaje = "Se encontraron " . $fila[coincidencias] . " coincidencias";
        $count = 0;
        while ($fila = mysql_fetch_array($result)) {
            $count++;

            $plantilla_usuario->iniciaBloque("usuario_rol");
            $plantilla_usuario->reemplazaEnBloque("numero", $count, "usuario_rol");
            $plantilla_usuario->reemplazaEnBloque("nombre", $fila[apellido_p] ." ".$fila[apellido_m] ." ".$fila[nombre], "usuario_rol");
            $plantilla_usuario->reemplazaEnBloque("usuario", $fila[usuario], "usuario_rol");
           
        }
        if($count==0){
            $plantilla_usuario->reemplaza("mensaje", "No se encontraron resultados");
        }
        $plantilla->reemplaza("bloque_usuarios", $plantilla_usuario->getPlantillaCadena());
    }

    //$plantilla->reemplaza("mensaje", $mensaje); //mostrar el mensaje adecuado
    $plantilla->presentaPlantilla();
}

function asignar_sh($idpersona, $idmodulo) {
    $ostakeholder = new gstakeholder();
    $error = $ostakeholder->asignar($idpersona, $idmodulo);
}

function eliminar_sh($idpersona, $idmodulo) {

    $ostakeholder = new gstakeholder();
    $error = $ostakeholder->eliminar($idpersona, $idmodulo);
}

function eliminar($idpersona, $idmodulo) {

    $ostakeholder = new gstakeholder();
    $error = $ostakeholder->eliminar_persona($idpersona, $idmodulo);
    
    if($error==0){
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " de la persona ");
    }else{
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " de la persona ");
    }
    
    echo json_encode($data);
}

function asignar_rc($idpersona, $idmodulo) {
    $orc = new grelacionista_comunitario();
    $error = $orc->asignar($idpersona, $idmodulo);
}

function eliminar_rc($idpersona, $idmodulo) {
    $orc = new grelacionista_comunitario();
    $error = $orc->eliminar($idpersona, $idmodulo);
}

function editar($es_stakeholder, $idpersona, $idmodulo, $nombre, $apaterno, $amaterno, $idpersona_tipo, $comentario, $fecha_nacimiento, $sexo, $background, $persona_direccion, $idpersona_direccion, $persona_telefono, $idpersona_telefono, $persona_mail, $idpersona_mail, $idpersona_organizacion, $idpersona_cargo, $idpersona_documento_identificacion, $select_documento_identificacion, $numero_documento, $idestado_civil) {
    $archivo ="";

   
     if ($_FILES["archivo"]["error"] == UPLOAD_ERR_OK) {
         $tmp_name = $_FILES["archivo"]["tmp_name"];
         $name = mt_rand()."_".$_FILES["archivo"]["name"];

         $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."imagen".DIRECTORY_SEPARATOR.$name;

         //echo $uploadfile." ";

         if(move_uploaded_file($tmp_name, $uploadfile)){
             $archivo = $name;             
         }
     }
    
    
    $gpersona = new gpersona();

    $respuesta = $gpersona->editar($idpersona, $idmodulo, $nombre, $apaterno, $amaterno, $archivo, $idpersona_tipo, $comentario, $fecha_nacimiento, $sexo, $background, $persona_direccion, $idpersona_direccion, $persona_telefono, $idpersona_telefono, $persona_mail, $idpersona_mail, $idpersona_organizacion, $idpersona_cargo, $idpersona_documento_identificacion, $select_documento_identificacion, $numero_documento, $idestado_civil);
    
    $arespuesta = explode("***", $respuesta);
    
    $data['success'] = false;
    
    $data['mensaje'] = coloca_mensaje("actualiza_error", " de la persona ");

    $data['html'] = ver_editar_persona($es_stakeholder, $idpersona, $idmodulo, "");
    
    if($arespuesta[2]==0){

        $data['mensaje'] = coloca_mensaje("actualiza_ok", " de la persona ");
        
        $data['success'] = true;
    }

    echo json_encode($data);
}

function guardar($es_stakeholder, $idmodulo, $nombre, $apaterno, $amaterno, $idpersona_tipo, $comentario, $fecha_nacimiento, $sexo, $background, $persona_direccion, $idpersona_direccion, $persona_telefono, $idpersona_telefono, $persona_mail, $idpersona_mail, $idpersona_organizacion, $idpersona_cargo, $idpersona_documento_identificacion, $select_documento_identificacion, $numero_documento, $es_stakeholder, $idestado_civil) {
    //print_r($select_documento_identificacion);
  
    $archivo ="";

   
     if ($_FILES["archivo"]["error"] == UPLOAD_ERR_OK) {
         $tmp_name = $_FILES["archivo"]["tmp_name"];
         $name = mt_rand()."_".$_FILES["archivo"]["name"];

         $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."imagen".DIRECTORY_SEPARATOR.$name;

         //echo $uploadfile." ";

         if(move_uploaded_file($tmp_name, $uploadfile)){
             $archivo = $name;             
         }
     }
             
    $gpersona = new gpersona();

    $respuesta = $gpersona->agregar($idmodulo, $nombre, $apaterno, $amaterno, $archivo, $idpersona_tipo, $comentario, $fecha_nacimiento, $sexo, $background, $persona_direccion, $idpersona_direccion, $persona_telefono, $idpersona_telefono, $persona_mail, $idpersona_mail, $idpersona_organizacion, $idpersona_cargo, $idpersona_documento_identificacion, $select_documento_identificacion, $numero_documento, $es_stakeholder, $idestado_civil);
    //echo $respuesta;
    $arespuesta = explode("***", $respuesta);
    
    $data['success'] = false;
    
    $data['mensaje'] = coloca_mensaje("guarda_error", " de la persona ");
    
    $data['html'] = ver_editar_persona($es_stakeholder, $arespuesta[0], $arespuesta[1], "", "", 1);
    
    if($arespuesta[2]==0){
        
        $data['mensaje'] = coloca_mensaje("guarda_ok", " de la persona ");
        
        $data['success'] = true;
    }

    echo json_encode($data);
}

function ver_nueva_persona($idpersona_tipo = "", $es_stakeholder = "") {

    //echo $idpersona_tipo;
    $seguridad = new Seguridad();


    if ($idpersona_tipo == 1) {
        if ($es_stakeholder == 2) {
            $plantilla = new DmpTemplate("../../../plantillas/persona/persona/persona_rc.html");
            $plantilla->reemplaza("es_stakeholder", "2");
            if($seguridad->verifica_permiso("Crear", "Relacionista"))
                        $plantilla->iniciaBloque ("editar_rc");
        } else {
            $plantilla = new DmpTemplate("../../../plantillas/persona/persona/persona.html");
            $plantilla->reemplaza("es_stakeholder", "1");
            if($seguridad->verifica_permiso("Crear", "Stakeholder"))
                        $plantilla->iniciaBloque ("editar_sh");
        }
    } else {
        if ($es_stakeholder == 2) {
            $plantilla = new DmpTemplate("../../../plantillas/persona/persona/organizacion_rc.html");
            if($seguridad->verifica_permiso("Crear", "Relacionista"))
                        $plantilla->iniciaBloque ("editar_rc");
        }else{
            $plantilla = new DmpTemplate("../../../plantillas/persona/persona/organizacion.html");
            if($seguridad->verifica_permiso("Crear", "Stakeholder"))
                        $plantilla->iniciaBloque ("editar_sh");
        }
        $plantilla->reemplaza("es_stakeholder", $es_stakeholder);
    }
    $plantilla->reemplaza("clase", "class='bloque'");
    $plantilla->reemplaza("tr", "thead");
    $persona_tipo = new itipo();
    $tipo_result = $persona_tipo->lista_persona_tipo();
    $plantilla->reemplaza("fecha_nacimiento", '01/01/1980');
    $plantilla->reemplaza("checkedM", "checked");
    $plantilla->reemplaza("op_persona", "guardar");
    $plantilla->reemplaza("nume_fila_direccion", 1);
    $plantilla->reemplaza("nume_fila_telefono", 1);
    $plantilla->reemplaza("nume_fila_mail", 1);
    $plantilla->reemplaza("nume_fila", 1); //organizacion
    $plantilla->reemplaza("nume_fila_documento_identificacion", 1);
    $plantilla->reemplaza("imagen", "../../../img/imagen.png");
    
    $max_upload = (int)(ini_get('upload_max_filesize'));
    $max_post = (int)(ini_get('post_max_size'));
    $memory_limit = (int)(ini_get('memory_limit'));
    $upload_mb = min($max_upload, $max_post, $memory_limit);
    
    $plantilla->reemplaza("maximo", $upload_mb);
    
/////ids iniciales
    $plantilla->reemplaza("idpersona_documento_identificacion", "1");
    $plantilla->reemplaza("idpersona_organizacion", "1");
    $plantilla->reemplaza("idpersona_mail", "1");
    $plantilla->reemplaza("idpersona_telefono", "1");
    $plantilla->reemplaza("idpersona_direccion", "1");
    $plantilla->reemplaza("cambiar_tipo_persona", "cambiar_tipo_persona(0, 0, 1)");
    while (!!$fila = mysql_fetch_array($tipo_result)) {

        $plantilla->iniciaBloque("persona_tipo");
        $plantilla->reemplazaEnBloque("idtipo", $fila[idpersona_tipo], "persona_tipo");
        $plantilla->reemplazaEnBloque("tipo", utf8_encode($fila[tipo]), "persona_tipo");

        if ($idpersona_tipo != "") {
            if ($fila[idpersona_tipo] == $idpersona_tipo) {
                $plantilla->reemplazaEnBloque("selected", "selected", "persona_tipo");
            }
        }
    }

    $oestado_civil = new iestado_civil();
    $aestado_civil = $oestado_civil->lista_estado_civil();
    while (!!$fila = mysql_fetch_array($aestado_civil)) {

        $plantilla->iniciaBloque("estado_civil");
        $plantilla->reemplazaEnBloque("idestado_civil", $fila[idpersona_estado_civil], "estado_civil");
        $plantilla->reemplazaEnBloque("estado_civil", $fila[descripcion], "estado_civil");
    }


    $documento_identificacion = new idocumento_identificacion();
    $di_result = $documento_identificacion->lista_documento_identificacion();
    while (!!$fila = mysql_fetch_array($di_result)) {

        $plantilla->iniciaBloque("documento_identificacion");
        $plantilla->reemplazaEnBloque("iddocumento_identificacion", $fila[iddocumento_identificacion], "documento_identificacion");
        $plantilla->reemplazaEnBloque("documento_identificacion", $fila[documento_identificacion], "documento_identificacion");
    }



    $plantilla->presentaPlantilla();
}

function nueva_persona() {

}

function lista_documento_identificacion() {

}

function validar_nombre($apaterno , $amaterno,$nombre, $idpersona, $idmodulo, $idpersona_tipo, $tipo){
    
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/lista.html");
    $ipersona = new ipersona();
    
    if($idpersona!="")
        $result=$ipersona->valida_persona($apaterno , $amaterno , $nombre , $idpersona, $idmodulo, $idpersona_tipo);
    else
        $result=$ipersona->valida_persona($apaterno , $amaterno , $nombre , 0, 0, $idpersona_tipo);
    
    $count = 0;
    while($fila = mysql_fetch_array($result)){
        //print_r($fila);
        $plantilla->iniciaBloque("sh_resultado");                
        
        if($tipo=='sh' && isset($fila[idsh])){
            $plantilla->iniciaBloque("sh_nombre");
            $plantilla->reemplazaEnBloque("idsh", $fila[idsh], "sh_nombre");
            $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "sh_nombre");
            $plantilla->reemplazaEnBloque("idpersona_tipo", $fila[idpersona_tipo], "sh_nombre");
            $plantilla->reemplazaEnBloque("nombres", $fila[nombres], "sh_nombre");
        }elseif($tipo=='rc' && isset($fila[idrc])){
            $plantilla->iniciaBloque("rc_nombre");
            $plantilla->reemplazaEnBloque("idrc", $fila[idrc], "rc_nombre");
            $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "rc_nombre");
            $plantilla->reemplazaEnBloque("idpersona_tipo", $fila[idpersona_tipo], "rc_nombre");
            $plantilla->reemplazaEnBloque("nombres", $fila[nombres], "rc_nombre");
            
        }else{
            $plantilla->iniciaBloque("nombre");
            $plantilla->reemplazaEnBloque("nombres", $fila[nombres], "nombre");
            
        }
        
        if(isset($fila[idsh])){
            $plantilla->iniciaBloque("sh");            
        }
        
        if(isset($fila[idrc])){
            $plantilla->iniciaBloque("rc");
        }
        
        $count++;
        $plantilla->reemplazaEnBloque("numero", $count, "sh_resultado");
    }
    
    $datos["html"]= utf8_encode($plantilla->getPlantillaCadena());
    $datos["rows"]= $count;
    
    echo json_encode($datos);
    
    
}

function busqueda_rapida($busca_rapida) {
    $arrayElementos = array();
    $ipersona = new ipersona();
    $ayudante = new Ayudante();
    $result = $ipersona->lista($busca_rapida, '1');
    //if(mysql_num_rows($result_stakeholder)>0){
    
    $count=0;
    while ($fila = mysql_fetch_array($result)) {
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