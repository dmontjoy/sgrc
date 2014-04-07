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
include_once '../../../informacion/propuesta/class.ipropuesta.php';
include_once '../../../informacion/reclamo/class.ireclamo_tipo.php';
include_once '../../../informacion/reclamo/class.ireclamo.php';
include_once '../../../informacion/propuesta/class.ipropuesta.php';
include_once '../../../informacion/compromiso/class.icompromiso_estado.php';
include_once '../../../informacion/compromiso/class.icompromiso_prioridad.php';
include_once '../../../informacion/compromiso/class.icompromiso.php';
include_once '../../../informacion/calificacion/class.idimension_matriz_sh.php';
include_once '../../../programas/persona/persona/ver_persona.php';
include_once '../../../programas/tag/tag/ver_tag.php';
include_once '../../../programas/mensajes.php';
include_once '../../../programas/reclamo/reclamo/ver_cabecera_reclamo.php';

//print_r($_REQUEST);

$ayudante = new Ayudante();
$op_propuesta = $_REQUEST["op_propuesta"];

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
//propuesta

$inicio = $_REQUEST[inicio];

$prioridades = $_REQUEST['prioridades'];
$tipos = $_REQUEST['tipos'];
$fecha_del = $_REQUEST['fecha_del'];
$fecha_al = $_REQUEST['fecha_al'];

$idmodulo_propuesta = $_REQUEST['idmodulo_propuesta'];



$idpropuesta_archivo = $_REQUEST[idpropuesta_archivo];



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

$idpropuesta = $_REQUEST[idpropuesta];
$idmodulo_propuesta = $_REQUEST[idmodulo_propuesta];
$propuesta = $_REQUEST[propuesta];
$fecha_propuesta = $_REQUEST[fecha_propuesta];
$idpropuesta_archivo = $_REQUEST[idpropuesta_archivo];
$presenta = $_REQUEST[presenta]; //si hace un echo o retorna una cadena
$persona = $_REQUEST[persona]; //varible que me indica : 1 si es sh, 2 si es rc
$tabla_propuesta = $_REQUEST[tabla_propuesta]; // variable que me indica si construyo la tabla o solo un bloque
$persona = $_REQUEST[persona];
$idpersona_tipo = $_REQUEST['idpersona_tipo'];
$tiene_cabecera = $_REQUEST['tiene_cabecera'];
$radio_estado = $_REQUEST[radio_estado];
$comentario_realizado = $_REQUEST[comentario_realizado];

if (!$seguridad->verificaSesion()) {
    $mensaje = "Ingrese su usuario y contraseña";
    header("Location: ../../../index.php?mensaje=$mensaje");
}


/* session_start();

  $_SESSION[idusu] = 1;
  $_SESSION[idmodulo_a] = 1;
  $_SESSION[idmodulo_a] = 1; */
//echo $op_stakeholder;
switch ($op_propuesta) {
    
    case "actualizar_propuesta_stakeholder":actualizar_propuesta_stakeholder($idpropuesta, $idmodulo_propuesta, $propuesta, $fecha_propuesta,$idpropuesta_archivo,$radio_estado,$comentario_realizado);
        break;
    case "guardar_propuesta_stakeholder": guardar_propuesta_stakeholder($idevaluacion, $idmodulo_evaluacion, $propuesta, $fecha_propuesta,$radio_estado,$comentario_realizado);        
        break;
    case "ver_propuesta_stakeholder_complejo":ver_propuesta_stakeholder_complejo($idpropuesta,$idmodulo_propuesta,$idreclamo ,$idmodulo_reclamo , $idevaluacion, $idmodulo_evaluacion , $presenta);
        break;
    case "eliminar_propuesta_stakeholder":eliminar_propuesta_stakeholder($idpropuesta, $idmodulo_propuesta,$idreclamo,$idmodulo_reclamo);
        break;
   

}




function guardar_propuesta_stakeholder($idevaluacion, $idmodulo_evaluacion, $propuesta, $fecha_propuesta, $radio_estado, $comentario_realizado) {
   
   
    //echo "llega".$fecha_propuesta;exit;
    $greclamo = new greclamo();
    //echo "verr".$idpropuesta_complejo_rc." ".$idpropuesta_complejo_sh;exit;
    $respuesta = $greclamo->agregar_propuesta($idevaluacion, $idmodulo_evaluacion, $propuesta, $fecha_propuesta, $radio_estado, $comentario_realizado);
        
    $arespuesta = split("---", $respuesta);
    if ($arespuesta[2] == 0) {
        
        $error_archivo = false;
        
        $count = 0;
        $archivos =array();
   
        foreach ($_FILES["archivos"]["error"] as $key => $error) {
             if ($error == UPLOAD_ERR_OK) {
                 $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                 $archivo = $_FILES["archivos"]["name"][$key];

                 $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."propuesta".DIRECTORY_SEPARATOR.$arespuesta[0].'_'.$archivo; 
                 
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
            $greclamo->agregar_archivo_propuesta($arespuesta[0],$arespuesta[1],$archivos);
        }
                 
        $data['success'] = true;
        $data['error_archivo'] = $error_archivo;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del acuerdo ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del acuerdo ");
        
    }
    
    if( isset($radio_evaluacion) ){
        
        $data['op_stakeholder'] = $radio_evaluacion;
        
        
    }else{
        $data['op_stakeholder'] = 0;
    }

    echo json_encode($data);
    //echo $respuesta;
}

function ver_propuesta_stakeholder_complejo($idpropuesta,$idmodulo_propuesta,$idreclamo ,$idmodulo_reclamo, $idevaluacion, $idmodulo_evaluacion , $presenta) {
    
    $ayudante = new Ayudante();

    $plantilla = new DmpTemplate("../../../plantillas/reclamo/propuesta/propuesta.html");
    
    //echo "$idpropuesta,$idmodulo_propuesta";

    $max_upload = (int)(ini_get('upload_max_filesize'));
    $max_post = (int)(ini_get('post_max_size'));
    $memory_limit = (int)(ini_get('memory_limit'));
    $upload_mb = min($max_upload, $max_post, $memory_limit);

    $plantilla->reemplaza("maximo", $upload_mb);
    
    ///actualizar
    if ($idpropuesta != "") {//solo uno xq se sobre entiende que viene el idmodulo

        
        $plantilla->reemplaza("idpropuesta", $idpropuesta);
        $plantilla->reemplaza("idmodulo_propuesta", $idmodulo_propuesta);
        $plantilla->reemplaza("op_propuesta", "actualizar_propuesta_stakeholder");
        //$plantilla->reemplaza("tabla_propuesta", 0); //$tabla_propuesta
        $plantilla->reemplaza("persona", $persona);
        $ipropuesta = new ipropuesta();
        $result = $ipropuesta->get_propuesta($idpropuesta, $idmodulo_propuesta);

        if($fila = mysql_fetch_array($result)) {
            $plantilla->reemplaza("propuesta", $fila[propuesta]);
            $plantilla->reemplaza("fecha_propuesta", $fila[fecha]);
            
            $plantilla->reemplaza("reclamo_cabecera", ver_cabecera_reclamo($fila[idreclamo], $fila[idmodulo_reclamo]));
            
            if(isset($fila[se_cumple])){
                $plantilla->reemplaza("checked$fila[se_cumple]", "checked");
                $plantilla->reemplaza("comentario_realizado", $fila[comentario_realizado]);
                if($fila[se_cumple]==4){
                    $plantilla->reemplaza("estilo", "display:none;");
                }
                
            }else{
                $plantilla->reemplaza("estilo", "display:none;");
            }
            
            //documento
            
            $result = $ipropuesta->lista_archivo($idpropuesta, $idmodulo_propuesta);
            
            while($fila=  mysql_fetch_array($result)){
                $plantilla->iniciaBloque("archivo");
                $plantilla->reemplazaEnBloque("idpropuesta_archivo", $fila[idpropuesta_archivo], "archivo");
                $plantilla->reemplazaEnBloque("idmodulo_propuesta_archivo", $fila[idmodulo_propuesta_archivo], "archivo");
                $plantilla->reemplazaEnBloque("archivo", $fila[archivo], "archivo");
                $plantilla->reemplazaEnBloque("activo", $fila[activo], "archivo");
                $plantilla->reemplazaEnBloque("ruta", $idpropuesta.'_'.$fila[archivo], "archivo");
                $plantilla->reemplazaEnBloque("fecha", date("d/m/Y", strtotime($fila[fecha_c]) ), "archivo");
            }
                                 
        }
        $plantilla->iniciaBloque("propuesta_pdf");
        $plantilla->reemplazaEnBloque("idpropuesta",$idpropuesta,"propuesta_pdf");
        $plantilla->reemplazaEnBloque("idmodulo_propuesta",$idmodulo_propuesta ,"propuesta_pdf");
    } else {

        $plantilla->reemplaza("op_propuesta", "guardar_propuesta_stakeholder");
        $plantilla->reemplaza("idevaluacion", $idevaluacion);
        $plantilla->reemplaza("idmodulo_evaluacion", $idmodulo_evaluacion);
        
        //echo "idreclamo : ".$idreclamo;
        
        
        $plantilla->reemplaza("fecha_propuesta", date('d/m/Y'));
        
        $plantilla->reemplaza("reclamo_cabecera", ver_cabecera_reclamo($idreclamo, $idmodulo_reclamo));

        
            
            
        
    }

    $plantilla->presentaPlantilla();
}

function actualizar_propuesta_stakeholder($idpropuesta, $idmodulo_propuesta, $propuesta, $fecha_propuesta,$idpropuesta_archivo,$radio_estado,$comentario_realizado) {
    //echo "llega $idevaluacion, $idmodulo_evaluacion, $evaluacion";exit;
    $greclamo = new greclamo();
    $respuesta = $greclamo->actualizar_propuesta($idpropuesta, $idmodulo_propuesta, $propuesta, $fecha_propuesta,$idpropuesta_archivo,$radio_estado,$comentario_realizado);
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

                 $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."propuesta".DIRECTORY_SEPARATOR.$arespuesta[0].'_'.$archivo; 
                 
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
            $greclamo->agregar_archivo_propuesta($arespuesta[0],$arespuesta[1],$archivos);
        }
                 
        
        $data['error_archivo'] = $error_archivo;
        
        
        $data['op_stakeholder'] = true;
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " del acuerdo ");
        $data['idpropuesta'] = $idpropuesta;
        $data['idmodulo_propuesta'] = $idmodulo_propuesta;
        //ver_bloque_reclamo($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1)
        $data['data'] = utf8_encode(ver_item_propuesta($idpropuesta, $idmodulo_propuesta, $propuesta, $fecha_propuesta));

        //ver_bloque_reclamo($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1, $tabla_reclamo = 1)
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " del acuerdo ");
    }

    echo json_encode($data);
}


function ver_item_propuesta($idpropuesta, $idmodulo_propuesta,$propuesta, $fecha_propuesta) {

    $plantilla = new DmpTemplate("../../../plantillas/reclamo/propuesta/item_propuesta.html");
    //listar reclamo stakeholder
    
    
    $plantilla->reemplaza("propuesta", $propuesta);
    $plantilla->reemplaza("fecha_propuesta", $fecha_propuesta);
    $plantilla->reemplaza("idpropuesta", $idpropuesta);
    $plantilla->reemplaza("idmodulo_propuesta", $idmodulo_propuesta);

    return $plantilla->getPlantillaCadena();
    //return $plantilla->presentaPlantilla();
}

function eliminar_propuesta_stakeholder($idpropuesta, $idmodulo_propuesta,$idreclamo,$idmodulo_reclamo) {
    $greclamo = new greclamo();
    $respuesta = $greclamo->eliminar_propuesta($idpropuesta, $idmodulo_propuesta,$idreclamo,$idmodulo_reclamo);

    if ($respuesta == 0) {
  
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " de la propuesta ");
      
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " de la propuesta ");
    }

    echo json_encode($data);
}





?>

