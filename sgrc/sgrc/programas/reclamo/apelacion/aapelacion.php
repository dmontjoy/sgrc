<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * =
 *
 */

include_once '../../include_utiles.php';
include_once '../../../informacion/persona/class.ipersona.php';
include_once '../../../informacion/persona/class.iestado_civil.php';
include_once '../../../gestion/stakeholder/class.gstakeholder.php';
include_once '../../../gestion/reclamo/class.greclamo.php';
include_once '../../../gestion/calificacion/class.gdimension_matriz_sh.php';
include_once '../../../informacion/stakeholder/class.istakeholder.php';
include_once '../../../informacion/interaccion/class.iinteraccion.php';
include_once '../../../informacion/reclamo/class.ireclamo_tipo.php';
include_once '../../../informacion/reclamo/class.ireclamo.php';
include_once '../../../informacion/compromiso/class.icompromiso_estado.php';
include_once '../../../informacion/compromiso/class.icompromiso_prioridad.php';
include_once '../../../informacion/compromiso/class.icompromiso.php';
include_once '../../../informacion/calificacion/class.idimension_matriz_sh.php';
include_once '../../../programas/persona/persona/ver_persona.php';
include_once '../../../programas/tag/tag/ver_tag.php';
include_once '../../../programas/mensajes.php';
include_once '../../../programas/reclamo/reclamo/ver_cabecera_reclamo.php';
include_once '../../../informacion/apelacion/class.iapelacion.php';

//print_r($_REQUEST);

$ayudante = new Ayudante();
$op_apelacion = $_REQUEST["op_apelacion"];

$idmodulo = $_REQUEST[idmodulo];
$idpersona = $_REQUEST[idpersona];
$idpersona_compuesto = $_REQUEST[idpersona_compuesto];

$es_stakeholder = $_REQUEST['es_stakeholder'];

$busca_rapida_stakeholder = $_REQUEST[busca_rapida_stakeholder];

$busca_rapida_tag = $_REQUEST[busca_rapida_tag];
$idtag_compuesto = $_REQUEST[idtag_compuesto];
$idpersona_tag = $_REQUEST[idpersona_tag]; //eliminar tag

$idpersona_red = $_REQUEST[idpersona_red];
$idmodulo_red = $_REQUEST[idmodulo_red];
$idpersona_compuesto_red = $_REQUEST[idpersona_compuesto_red];
$idpersona_red_stakeholder = $_REQUEST[idpersona_red_stakeholder];
$idmodulo_persona_red = $_REQUEST[idmodulo_persona_red];
//interaccion

$inicio = $_REQUEST[inicio];

$prioridades = $_REQUEST['prioridades'];
$tipos = $_REQUEST['tipos'];
$fecha_del = $_REQUEST['fecha_del'];
$fecha_al = $_REQUEST['fecha_al'];

$idmodulo_interaccion = $_REQUEST['idmodulo_interaccion'];



$idinteraccion_archivo = $_REQUEST[idinteraccion_archivo];



//reclamo
$reclamo = $_REQUEST[reclamo];

$idreclamo_tipo = $_REQUEST[idreclamo_tipo];
$comentario_reclamo = $ayudante->caracter($_REQUEST[comentario_reclamo]);
$idreclamo_complejo_tag = $_REQUEST[idreclamo_complejo_tag];
$idreclamo_complejo_sh = $_REQUEST[idreclamo_complejo_sh];
$idreclamo_rc = $_REQUEST[idreclamo_rc];
$idreclamo_complejo_rc = $_REQUEST[idreclamo_complejo_rc];
$fecha_complejo = $_REQUEST[fecha_complejo];
$idreclamo = $_REQUEST[idreclamo];
$idmodulo_reclamo = $_REQUEST[idmodulo_reclamo];

$evaluacion = $_REQUEST[evaluacion];
$idevaluacion = $_REQUEST[idevaluacion];
$idmodulo_evaluacion = $_REQUEST[idmodulo_evaluacion];
$radio_evaluacion = $_REQUEST[radio_evaluacion];

$idapelacion = $_REQUEST[idapelacion];
$idmodulo_apelacion = $_REQUEST[idmodulo_apelacion];
$apelacion = $_REQUEST[apelacion];
$fecha_apelacion = $_REQUEST[fecha_apelacion];
$idapelacion_archivo = $_REQUEST[idapelacion_archivo];

$presenta = $_REQUEST[presenta]; //si hace un echo o retorna una cadena
$persona = $_REQUEST[persona]; //varible que me indica : 1 si es sh, 2 si es rc
$tabla_interaccion = $_REQUEST[tabla_interaccion]; // variable que me indica si construyo la tabla o solo un bloque
$persona = $_REQUEST[persona];
$idpersona_tipo = $_REQUEST['idpersona_tipo'];
$tiene_cabecera = $_REQUEST['tiene_cabecera'];

if (!$seguridad->verificaSesion()) {
    $mensaje = "Ingrese su usuario y contraseña";
    header("Location: ../../../index.php?mensaje=$mensaje");
}


/* session_start();

  $_SESSION[idusu] = 1;
  $_SESSION[idmodulo_a] = 1;
  $_SESSION[idmodulo_a] = 1; */
//echo $op_stakeholder;
switch ($op_apelacion) {
     case "actualizar_apelacion_stakeholder":actualizar_apelacion_stakeholder($idapelacion, $idmodulo_apelacion, $apelacion, $fecha_apelacion,$idapelacion_archivo);
        break;
    case "guardar_apelacion_stakeholder": guardar_apelacion_stakeholder($idevaluacion, $idmodulo_evaluacion, $apelacion,$fecha_apelacion);        
        break;
    case "ver_apelacion_stakeholder_complejo":ver_apelacion_stakeholder_complejo($idapelacion,$idmodulo_apelacion,$idreclamo ,$idmodulo_reclamo , $idevaluacion, $idmodulo_evaluacion , $presenta);
        break;
     case "eliminar_apelacion_stakeholder":eliminar_apelacion_stakeholder($idapelacion, $idmodulo_apelacion);
        break;

}

function actualizar_apelacion_stakeholder($idapelacion, $idmodulo_apelacion, $apelacion, $fecha_apelacion,$idapelacion_archivo) {
    //echo "llega $idevaluacion, $idmodulo_evaluacion, $evaluacion";exit;
    $greclamo = new greclamo();
    $respuesta = $greclamo->actualizar_apelacion($idapelacion, $idmodulo_apelacion, $apelacion, $fecha_apelacion,$idapelacion_archivo);
    //echo $respuesta;reclamo
    //$arespuesta=split("---", $respuesta);
    //ver_reclamo_stakolder_complejo("","",$idreclamo,$idmodulo_reclamo);
    $arespuesta = split("---", $respuesta);


    //$data['op_stakeholder'] = true;
    
    if ($arespuesta[2] == 0) {
        
        $error_archivo = false;
        
        $count = 0;
        $archivos =array();
   
        foreach ($_FILES["archivos"]["error"] as $key => $error) {
             if ($error == UPLOAD_ERR_OK) {
                 $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                 $archivo = $_FILES["archivos"]["name"][$key];

                 $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."apelacion".DIRECTORY_SEPARATOR.$arespuesta[0].'_'.$archivo; 
                 
                 //echo $uploadfile." ";
                 
                 if(move_uploaded_file($tmp_name, $uploadfile)){
                     $archivos[] = $archivo;
                     $count++;
                 }
             }else{
                 $error_archivo=true;
             }
         }
         
        if( $count>0 ){
            $greclamo->agregar_archivo_apelacion($arespuesta[0],$arespuesta[1],$archivos);
        }
                 
        
        $data['error_archivo'] = $error_archivo;
        
        
        $data['op_stakeholder'] = true;
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " del acuerdo ");
        $data['idapelacion'] = $idapelacion;
        $data['idmodulo_apelacion'] = $idmodulo_apelacion;
        //ver_bloque_reclamo($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1)
        $data['data'] = utf8_encode(ver_item_apelacion($idapelacion, $idmodulo_apelacion, $apelacion, $fecha_apelacion));

        //ver_bloque_reclamo($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1, $tabla_reclamo = 1)
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " del acuerdo ");
    }

    echo json_encode($data);
}



function guardar_apelacion_stakeholder($idevaluacion, $idmodulo_evaluacion, $apelacion, $fecha_apelacion) {
   
   
    //echo "llega".$fecha_interaccion;exit;
    $greclamo = new greclamo();
    //echo "verr".$idinteraccion_complejo_rc." ".$idinteraccion_complejo_sh;exit;
    $respuesta = $greclamo->agregar_apelacion($idevaluacion, $idmodulo_evaluacion, $apelacion, $fecha_apelacion);
        
    $arespuesta = split("---", $respuesta);
    if ($arespuesta[2] == 0) {
        
        $error_archivo = false;
        
        $count = 0;
        $archivos =array();
   
        foreach ($_FILES["archivos"]["error"] as $key => $error) {
             if ($error == UPLOAD_ERR_OK) {
                 $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                 $archivo = $_FILES["archivos"]["name"][$key];

                 $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."apelacion".DIRECTORY_SEPARATOR.$arespuesta[0].'_'.$archivo; 
                 
                 //echo $uploadfile." ";
                 
                 if(move_uploaded_file($tmp_name, $uploadfile)){
                     $archivos[] = $archivo;
                     $count++;
                 }
             }else{
                 $error_archivo=true;
             }
         }
         
        if( $count>0 ){
            $greclamo->agregar_archivo_apelacion($arespuesta[0],$arespuesta[1],$archivos);
        }
                 
        $data['success'] = true;
        $data['error_archivo'] = $error_archivo;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " de la apelacion ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " de la apelacion ");
        
    }
    
    if( isset($radio_evaluacion) ){
        
        $data['op_stakeholder'] = $radio_evaluacion;
        
        
    }else{
        $data['op_stakeholder'] = 0;
    }

    echo json_encode($data);
    //echo $respuesta;
}

function ver_apelacion_stakeholder_complejo($idapelacion,$idmodulo_apelacion,$idreclamo ,$idmodulo_reclamo, $idevaluacion, $idmodulo_evaluacion , $presenta) {
    
    $ayudante = new Ayudante();

    $plantilla = new DmpTemplate("../../../plantillas/reclamo/apelacion/apelacion.html");
       
    $max_upload = (int)(ini_get('upload_max_filesize'));
    $max_post = (int)(ini_get('post_max_size'));
    $memory_limit = (int)(ini_get('memory_limit'));
    $upload_mb = min($max_upload, $max_post, $memory_limit);

    $plantilla->reemplaza("maximo", $upload_mb);
    
    ///actualizar
    if ($idapelacion != "") {//solo uno xq se sobre entiende que viene el idmodulo
        $plantilla->reemplaza("idapelacion", $idapelacion);
        $plantilla->reemplaza("idmodulo_apelacion", $idmodulo_apelacion);
        $plantilla->reemplaza("op_apelacion", "actualizar_apelacion_stakeholder");
        //$plantilla->reemplaza("tabla_apelacion", 0); //$tabla_apelacion
        $plantilla->reemplaza("persona", $persona);
        $iapelacion= new iapelacion();
        $result = $iapelacion->get_apelacion($idapelacion, $idmodulo_apelacion);

        if ($fila = mysql_fetch_array($result)) {
           $plantilla->reemplaza("apelacion", $fila[apelacion]);
           $plantilla->reemplaza("fecha_apelacion", $fila[fecha]);
                                                 
           $plantilla->reemplaza("reclamo_cabecera", ver_cabecera_reclamo($fila[idreclamo], $fila[idmodulo_reclamo])); 
            //documento
            
            $result = $iapelacion->lista_archivo($idapelacion, $idmodulo_apelacion);
            
            while($fila=  mysql_fetch_array($result)){
                $plantilla->iniciaBloque("archivo");
                $plantilla->reemplazaEnBloque("idapelacion_archivo", $fila[idapelacion_archivo], "archivo");
                $plantilla->reemplazaEnBloque("idmodulo_apelacion_archivo", $fila[idmodulo_apelacion_archivo], "archivo");
                $plantilla->reemplazaEnBloque("archivo", $fila[archivo], "archivo");
                $plantilla->reemplazaEnBloque("activo", $fila[activo], "archivo");
                $plantilla->reemplazaEnBloque("ruta", $idapelacion.'_'.$fila[archivo], "archivo");
                $plantilla->reemplazaEnBloque("fecha", date("d/m/Y", strtotime($fila[fecha_c]) ), "archivo");
            }
                                    
        }
        $plantilla->iniciaBloque("apelacion_pdf");
        $plantilla->reemplazaEnBloque("idapelacion",$idapelacion,"apelacion_pdf");
        $plantilla->reemplazaEnBloque("idmodulo_apelacion",$idmodulo_apelacion ,"apelacion_pdf");
    } else {

        $plantilla->reemplaza("op_apelacion", "guardar_apelacion_stakeholder");
        $plantilla->reemplaza("idevaluacion", $idevaluacion);
        $plantilla->reemplaza("idmodulo_evaluacion", $idmodulo_evaluacion);
        
        //echo "idreclamo : ".$idreclamo;
        
        
        $plantilla->reemplaza("fecha_apelacion", date('d/m/Y'));
        
        $plantilla->reemplaza("reclamo_cabecera", ver_cabecera_reclamo($idreclamo, $idmodulo_reclamo));

        
        
    }

    $plantilla->presentaPlantilla();
}

 function ver_item_apelacion($idapelacion, $idmodulo_apelacion,$apelacion, $fecha_apelacion) {

    $plantilla = new DmpTemplate("../../../plantillas/reclamo/apelacion/item_apelacion.html");
    //listar reclamo stakeholder
    
    
    $plantilla->reemplaza("apelacion", $apelacion);
    $plantilla->reemplaza("fecha_apelacion", $fecha_apelacion);
    $plantilla->reemplaza("idapelacion", $idapelacion);
    $plantilla->reemplaza("idmodulo_apelacion", $idmodulo_apelacion);

    return $plantilla->getPlantillaCadena();
    //return $plantilla->presentaPlantilla();
}
        
function eliminar_apelacion_stakeholder($idapelacion, $idmodulo_apelacion) {
    $greclamo = new greclamo();
    $respuesta = $greclamo->eliminar_apelacion($idapelacion, $idmodulo_apelacion);

    if ($respuesta == 0) {
  
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " de la apelacion ");
      
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " de la apelacion ");
    }

    echo json_encode($data);
}


?>

