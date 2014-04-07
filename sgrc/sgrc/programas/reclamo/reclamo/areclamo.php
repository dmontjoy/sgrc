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
include_once '../../../informacion/reclamo/class.ireclamo.php';
include_once '../../../informacion/apelacion/class.iapelacion.php';
include_once '../../../informacion/propuesta/class.ipropuesta.php';
include_once '../../../informacion/reclamo/class.ireclamo_tipo.php';
include_once '../../../informacion/evaluacion/class.ievaluacion_estado.php';
include_once '../../../informacion/evaluacion/class.ievaluacion_prioridad.php';
include_once '../../../informacion/evaluacion/class.ievaluacion.php';
include_once '../../../informacion/calificacion/class.idimension_matriz_sh.php';
include_once '../../../programas/persona/persona/ver_persona.php';
include_once '../../../programas/reclamo/reclamo/ver_cabecera_reclamo.php';
include_once '../../../programas/tag/tag/ver_tag.php';
include_once '../../../programas/mensajes.php';

//print_r($_REQUEST);


$ayudante = new Ayudante();
$op_reclamo = $_REQUEST["op_reclamo"];

$modo = $_REQUEST['modo'];

$nombre = $_REQUEST['nombre'];

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
//reclamo

$inicio = $_REQUEST[inicio];

$prioridades = $_REQUEST['prioridades'];
$tipos = $_REQUEST['tipos'];
$fecha_del = $_REQUEST['fecha_del'];
$fecha_al = $_REQUEST['fecha_al'];

$idmodulo_reclamo = $_REQUEST['idmodulo_reclamo'];

$idreclamo_archivo = $_REQUEST[idreclamo_archivo];

$idreclamo_previo = $_REQUEST[idreclamo_previo];

$idreclamo_fase = $_REQUEST[idreclamo_fase];

$busca_rapida_reclamo=$_REQUEST[busca_rapida_reclamo];

//reclamo
$reclamo = $_REQUEST[reclamo];

$fecha_reclamo = $_REQUEST[fecha_reclamo];
$idreclamo_tipo = $_REQUEST[idreclamo_tipo];
$fecha_cierre = $_REQUEST[fecha_cierre];
$idreclamo_estado = $_REQUEST[idreclamo_estado];

$comentario_reclamo = $ayudante->caracter($_REQUEST[comentario_reclamo]);
$idreclamo_complejo_tag = $_REQUEST[idreclamo_complejo_tag];
$idreclamo_complejo_sh = $_REQUEST[idreclamo_complejo_sh];
$idreclamo_rc = $_REQUEST[idreclamo_rc];
$idreclamo_complejo_rc = $_REQUEST[idreclamo_complejo_rc];
$fecha_complejo = $_REQUEST[fecha_complejo];
$idreclamo = $_REQUEST[idreclamo];

$evaluacion = $_REQUEST[evaluacion];

$idevaluacion = $_REQUEST[idevaluacion];
$idmodulo_evaluacion = $_REQUEST[idmodulo_evaluacion];

$radio_evaluacion = $_REQUEST[radio_evaluacion];

$tipo_reporte = $_REQUEST[tipo_reporte];

$identidad = $_REQUEST[identidad];
$idmodulo_entidad = $_REQUEST[idmodulo_entidad];
$entidad = $_REQUEST[entidad];

$plazo = $_REQUEST[plazo];

$presenta = $_REQUEST[presenta]; //si hace un echo o retorna una cadena
$persona = $_REQUEST[persona]; //varible que me indica : 1 si es sh, 2 si es rc
$tabla_reclamo = $_REQUEST[tabla_reclamo]; // variable que me indica si construyo la tabla o solo un bloque
$persona = $_REQUEST[persona];
$idpersona_tipo = $_REQUEST['idpersona_tipo'];
$tiene_cabecera = $_REQUEST['tiene_cabecera'];

if (!$seguridad->verificaSesion()) {
    $mensaje = "Ingrese su usuario y contraseña";
    header("Location: ../../../index.php?mensaje=$mensaje");
}

switch ($op_reclamo) {
    
    case "ver_reclamo_stakeholder":ver_reclamo_stakeholder($idpersona, $idmodulo, $idreclamo, $idmodulo_reclamo, $persona, $presenta);
        break;
    case "guardar_reclamo_stakeholder": guardar_reclamo_stakeholder($idpersona, $idmodulo, $reclamo, $fecha_reclamo,  $idreclamo_tipo, $idreclamo_complejo_tag, $idreclamo_rc,  $idreclamo_complejo_sh,$idreclamo_complejo_rc, $fecha_complejo, $comentario_reclamo, $evaluacion, $radio_evaluacion, $idreclamo_previo);        
        break;
    case "ver_reclamo_stakeholder_complejo": ver_reclamo_stakeholder_complejo($idpersona , $idmodulo , $idreclamo , $idmodulo_reclamo , $persona , $presenta);
        break;
    case "actualizar_reclamo_stakeholder":actualizar_reclamo_stakeholder($idreclamo, $idmodulo_reclamo, $idreclamo_complejo_tag, $idreclamo_rc, $idreclamo_complejo_rc,$fecha_complejo, $idreclamo_complejo_sh, $idreclamo_archivo, $comentario_reclamo, $fecha_reclamo, $idreclamo_tipo, $reclamo, $evaluacion, $radio_evaluacion, $idreclamo_previo,$idreclamo_estado,$fecha_cierre);
    break;
    case "ver_evaluacion_stakeholder_complejo":ver_evaluacion_stakeholder_complejo($idevaluacion,$idmodulo_evaluacion, $presenta);
    break;
    case "actualizar_evaluacion_stakeholder":actualizar_evaluacion_stakeholder($idevaluacion, $idmodulo_evaluacion, $evaluacion);
    break;
    case "eliminar_reclamo_stakeholder":eliminar_reclamo_stakeholder($idreclamo, $idmodulo_reclamo);
    break;
    case "busqueda_rapida_reclamo":busqueda_rapida_reclamo($busca_rapida_reclamo);
    break;
    case "exportar_pdf_reclamo":exportar_pdf_reclamo($idreclamo,$idmodulo_reclamo,$tipo_reporte);
    break;
    case "ver_buscar_reclamo":ver_buscar_reclamo();
    break;
    case "buscar_reclamo":buscar_reclamo($identidad,$idmodulo_entidad, $entidad,$idreclamo_fase,$idreclamo_tipo,$idreclamo_estado,$fecha_del , $fecha_al, $idreclamo_complejo_tag,$idreclamo_complejo_sh,$idreclamo_rc,$idreclamo_complejo_rc, $plazo );
    break;
    case "exportar_reclamo": exportar_reclamo($identidad,$idmodulo_entidad,$entidad,$idreclamo_fase,$idreclamo_tipo,$idreclamo_estado,$fecha_del , $fecha_al,$idreclamo_complejo_tag,$idreclamo_complejo_sh,$idreclamo_rc, $idreclamo_complejo_rc, $plazo);
    break;  
    case "ver_bloque_reclamo":ver_bloque_reclamo($nombre,$idpersona, $idmodulo, $inicio, $persona, $presenta, $modo);
    break;
    case "eliminar_evaluacion_stakeholder":eliminar_evaluacion_stakeholder($idevaluacion, $idmodulo_evaluacion);
    break;

}


function ver_reclamo_stakeholder($idpersona = "", $idmodulo = "", $idreclamo = "", $idmodulo_reclamo = "", $persona = "", $presenta) {
    $seguridad = new Seguridad();
    //echo $idpersona." ".$idmodulo;
    $plantilla = new DmpTemplate("../../../plantillas/reclamo/reclamo/reclamo.html");
    
    $plantilla->reemplaza("idpersona", $idpersona);
    $plantilla->reemplaza("idmodulo", $idmodulo);
    $plantilla->reemplaza("persona", $persona);
    //$plantilla->reemplaza("idreclamo_sh", $idpersona . "---" . $idmodulo);
    //echo $_SESSION[idusu] . "---" . $_SESSION[idmodulo_a];
    //$plantilla->reemplaza("idreclamo_rc", $_SESSION[idpersona] . "---" . $_SESSION[idmodulo_persona]);
   
    if(!$seguridad->verifica_permiso("Crear", "Reclamo"))
            $plantilla->iniciaBloque ("crear_reclamo");
   
            
    $plantilla->reemplaza("maximo", 2);

    $plantilla->reemplaza("fecha_reclamo", date('d/m/Y'));
    //echo "idreclamo".$idreclamo." idmodulo".$idmodulo_reclamo;
  
    $ireclamo_tipo = new ireclamo_tipo();

    $result_reclamo_tipo = $ireclamo_tipo->lista_reclamo_tipo();

    while (!!$fila = mysql_fetch_array($result_reclamo_tipo)) {

        $plantilla->iniciaBloque("reclamo_tipo");
        $plantilla->reemplazaEnBloque("idreclamo_tipo", $fila[idreclamo_tipo], "reclamo_tipo");
        $plantilla->reemplazaEnBloque("tipo", $fila[tipo], "reclamo_tipo");
    }
    

                        
    $plantilla->reemplaza("cant_sh", "1");
    
    $plantilla->reemplaza("count_receptor", "1");
    
    $plantilla->iniciaBloque("receptor");
        $plantilla->reemplazaEnBloque("rc", $_SESSION["apellido_p"]." ".$_SESSION["apellido_m"].", ".$_SESSION[nombre], "receptor");
        $plantilla->reemplazaEnBloque("idrc", $_SESSION["idpersona"], "receptor");
        $plantilla->reemplazaEnBloque("idmodulo_rc", $_SESSION["idmodulo_persona"], "receptor");
        $plantilla->reemplazaEnBloque("idpersona_tipo", $_SESSION["idpersona_tipo"], "receptor");
               
    $ipersona=new ipersona();
     
    $result_persona = $ipersona->get_persona($idpersona, $idmodulo);
    $fila_sh = mysql_fetch_array($result_persona);

    $plantilla->iniciaBloque("tr_sh_reclamo");
    $plantilla->iniciaBloque("td_sh_reclamo");
    $plantilla->reemplazaEnBloque("sh", $fila_sh[apellido_p] . " " . $fila_sh[apellido_m] . ", " . $fila_sh[nombre], "td_sh_reclamo");
    $plantilla->reemplazaEnBloque("idsh", $fila_sh[idpersona], "td_sh_reclamo");
    $plantilla->reemplazaEnBloque("idmodulo", $fila_sh[idmodulo], "td_sh_reclamo");
    $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_reclamo");
    $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_reclamo");
    
     $plantilla->iniciaBloque("eliminar_sh_reclamo");
    //***1 el estado activo, al cambiar a 0, el estado desactivo

    $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "eliminar_sh_reclamo");
    $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "eliminar_sh_reclamo");

    $plantilla->iniciaBloque("idreclamo_complejo_sh");

    $plantilla->reemplazaEnBloque("idreclamo_complejo_sh", $fila_sh[idpersona] . "---" . $fila_sh[idmodulo] .'---1', "idreclamo_complejo_sh");
    $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "idreclamo_complejo_sh");
    $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "idreclamo_complejo_sh");

    for ($cont_sh_celda = 2; $cont_sh_celda <= 5; $cont_sh_celda++) {
        $plantilla->iniciaBloque("td_sh_reclamo");
        $plantilla->reemplazaEnBloque("sh", "&nbsp;", "td_sh_reclamo");
        $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_reclamo");
        $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_reclamo");
    }

    $plantilla->reemplaza("nume_fila_reclamo_sh", 1);
    $plantilla->reemplaza("nume_celda_reclamo_sh", 2);

   
        
    //listar reclamo stakeholder
    $plantilla_reclamo = ver_bloque_reclamo('',$idpersona, $idmodulo, 20, $persona, $presenta);

    $plantilla->reemplaza("tabla_reclamo", $plantilla_reclamo);

    if ($presenta == 0) {
        $plantilla->presentaPlantilla();
    } else {
        return $plantilla->getPlantillaCadena();
    }
}

function ver_bloque_reclamo($nombre,$idpersona, $idmodulo, $inicio, $persona = 1, $presenta, $modo) {
    // $presenta = 1;
    //$tabla_reclamo = 1;
    //persona 2 ve las reclamoes del relacionista comunitario, usuario
    //persona 1 ve las reclamoes del stakeholder
    //con cuerpo, si incluye los div y la tabla de reclamo
    
    $seguridad = new Seguridad();

    $plantilla = new DmpTemplate("../../../plantillas/reclamo/reclamo/bloque_reclamo.html");
    //listar reclamo stakeholder
    $ireclamo = new ireclamo();
    if($seguridad->verifica_permiso("Ver", "Inicio-Reclamos") && $modo==1){
        $areclamo = $ireclamo->lista_stakeholder_reclamo($idpersona, $idmodulo, $inicio, 0);
    }else{
        $areclamo = $ireclamo->lista_stakeholder_reclamo($idpersona, $idmodulo, $inicio, $persona);
    }
    
    //lo cambio para ordenarlo
    if (sizeof($areclamo[reclamo]) > 0) {
        
        
        $numero =0;

        foreach ($areclamo[reclamo] as $key => $reclamo) {
            
            $numero++;

            $plantilla->iniciaBloque("item_reclamo");
            if (strlen($reclamo) > 400) {

                $reclamo = substr($reclamo, 0, 400) . "......";
            }
            $plantilla->reemplazaEnBloque("numero", $numero, "item_reclamo");
            $plantilla->reemplazaEnBloque("fecha_reclamo", $areclamo[fecha][$key], "item_reclamo");

            $plantilla->reemplazaEnBloque("reclamo",$reclamo, "item_reclamo");
            

            $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "item_reclamo");
            //echo "iddd".$areclamo[idreclamo][$key];
            $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "item_reclamo");
            
            if($seguridad->verifica_permiso("Editar", "Reclamo", $areclamo['idusu_c'][$key], $areclamo['idmodulo_c'][$key])){
                    $plantilla->iniciaBloque("editar_reclamo");
                    $plantilla->reemplazaEnBloque("idreclamo", $areclamo['idreclamo'][$key], "editar_reclamo");
                    $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo['idmodulo_reclamo'][$key], "editar_reclamo");
                    if(isset($persona))
                        $plantilla->reemplazaEnBloque("persona", $persona, "editar_reclamo");
                    else
                        $plantilla->reemplazaEnBloque("persona", 1, "editar_reclamo");
                        }
                
                 if($seguridad->verifica_permiso("Eliminar", "Reclamo", $areclamo['idusu_c'][$key], $areclamo['idmodulo_c'][$key])){
                    $plantilla->iniciaBloque("eliminar_reclamo");
                    $plantilla->reemplazaEnBloque("idreclamo", $areclamo['idreclamo'][$key], "eliminar_reclamo");
                    $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo['idmodulo_reclamo'][$key], "eliminar_reclamo");
                }
            
            if(isset($persona))
                $plantilla->reemplazaEnBloque("persona", $persona, "item_reclamo");
            else
                $plantilla->reemplazaEnBloque("persona", 1, "item_reclamo");
            
            $plantilla->reemplazaEnBloque("tabla_reclamo", $tabla_reclamo, "item_reclamo");
            $cant = sizeof($areclamo['idevaluacion'][$key]);
            $plantilla->reemplazaEnBloque("evaluacion", $cant, "item_reclamo");
            $count=0;
            if ( $cant > 0) {
                
                foreach ($areclamo['evaluacion'][$key] as $evaluacion_key => $evaluacion) {
                    $count++;

                    $plantilla->iniciaBloque("item_evaluacion");
                    if($count>1){
                        $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "item_evaluacion");
                        $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "item_evaluacion");
                        //$plantilla->reemplazaEnBloque("estilo", "display:none;","item_evaluacion");
                    }
                    $plantilla->reemplazaEnBloque("fecha_evaluacion", $areclamo['fecha_evaluacion'][$key][$evaluacion_key], "item_evaluacion");
                    $plantilla->reemplazaEnBloque("evaluacion", wordwrap($evaluacion, 110, "<br />", true), "item_evaluacion");
                    $plantilla->reemplazaEnBloque("idevaluacion", $areclamo['idevaluacion'][$key][$evaluacion_key], "item_evaluacion");
                    $plantilla->reemplazaEnBloque("idmodulo_evaluacion", $areclamo['idmodulo_evaluacion'][$key][$evaluacion_key], "item_evaluacion");
                    
                    if($seguridad->verifica_permiso("Editar", "Reclamo-Evaluacion", $areclamo['idusu_c_evaluacion'][$key][$evaluacion_key], $areclamo['idmodulo_c_evaluacion'][$key][$evaluacion_key])){
                        $plantilla->iniciaBloque("editar_evaluacion");                        
                        $plantilla->reemplazaEnBloque("idmodulo_evaluacion", $areclamo['idmodulo_evaluacion'][$key][$evaluacion_key], "editar_evaluacion");
                        $plantilla->reemplazaEnBloque("idevaluacion", $areclamo['idevaluacion'][$key][$evaluacion_key], "editar_evaluacion");
                    }
                    
                    if($seguridad->verifica_permiso("Eliminar", "Reclamo-Evaluacion", $areclamo['idusu_c_evaluacion'][$key][$evaluacion_key], $areclamo['idmodulo_c_evaluacion'][$key][$evaluacion_key])){
                        $plantilla->iniciaBloque("eliminar_evaluacion");                        
                        $plantilla->reemplazaEnBloque("idmodulo_evaluacion", $areclamo['idmodulo_evaluacion'][$key][$evaluacion_key], "eliminar_evaluacion");
                        $plantilla->reemplazaEnBloque("idevaluacion", $areclamo['idevaluacion'][$key][$evaluacion_key], "eliminar_evaluacion");
                    }
                    
                    $cant = sizeof($areclamo['idpropuesta'][$key][$evaluacion_key]);
                //echo "Cant : ".$cant."<br>";

                    if ( $cant > 0) {

                        foreach ($areclamo['propuesta'][$key][$evaluacion_key] as $propuesta_key => $propuesta) {
                            $count++;

                            $plantilla->iniciaBloque("item_propuesta");

                            $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "item_propuesta");
                            $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "item_propuesta");
                                //$plantilla->reemplazaEnBloque("estilo", "display:none;","item_propuesta");

                            $plantilla->reemplazaEnBloque("fecha_propuesta", $areclamo['fecha_propuesta'][$key][$evaluacion_key][$propuesta_key], "item_propuesta");
                            $plantilla->reemplazaEnBloque("propuesta", wordwrap($propuesta, 110, "<br />", true), "item_propuesta");
                            $plantilla->reemplazaEnBloque("idpropuesta", $areclamo['idpropuesta'][$key][$evaluacion_key][$propuesta_key], "item_propuesta");
                            $plantilla->reemplazaEnBloque("idmodulo_propuesta", $areclamo['idmodulo_propuesta'][$key][$evaluacion_key][$propuesta_key], "item_propuesta");
                            
                            if($seguridad->verifica_permiso("Editar", "Reclamo-Acuerdo", $areclamo['idusu_c_propuesta'][$key][$evaluacion_key][$propuesta_key], $areclamo['idmodulo_c_propuesta'][$key][$evaluacion_key][$propuesta_key])){
                                $plantilla->iniciaBloque("editar_propuesta");                        
                                $plantilla->reemplazaEnBloque("idmodulo_propuesta", $areclamo['idmodulo_propuesta'][$key][$evaluacion_key][$propuesta_key], "editar_propuesta");
                                $plantilla->reemplazaEnBloque("idpropuesta", $areclamo['idpropuesta'][$key][$evaluacion_key][$propuesta_key], "editar_propuesta");
                            }
                            
                             if($seguridad->verifica_permiso("Eliminar", "Reclamo-Acuerdo", $areclamo['idusu_c_propuesta'][$key][$evaluacion_key][$propuesta_key], $areclamo['idmodulo_c_propuesta'][$key][$evaluacion_key][$propuesta_key])){
                                $plantilla->iniciaBloque("eliminar_propuesta");                        
                                $plantilla->reemplazaEnBloque("idmodulo_propuesta", $areclamo['idmodulo_propuesta'][$key][$evaluacion_key][$propuesta_key], "eliminar_propuesta");
                                $plantilla->reemplazaEnBloque("idpropuesta", $areclamo['idpropuesta'][$key][$evaluacion_key][$propuesta_key], "eliminar_propuesta");
                             }
                        }

                    }

                    $plantilla->iniciaBloque("menu_propuesta");
                    $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "menu_propuesta");
                    $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "menu_propuesta");


                    $cant = sizeof($areclamo['idapelacion'][$key][$evaluacion_key]);
                    //echo "Cant : ".$cant."<br>";
                    $count=0;
                    if ( $cant > 0) {

                        foreach ($areclamo['apelacion'][$key][$evaluacion_key] as $apelacion_key => $apelacion) {
                            $count++;

                            $plantilla->iniciaBloque("item_apelacion");
                            
                            $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "item_apelacion");
                            $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "item_apelacion");
                            //$plantilla->reemplazaEnBloque("estilo", "display:none;","item_apelacion");
                            
                            $plantilla->reemplazaEnBloque("fecha_apelacion", $areclamo['fecha_apelacion'][$key][$evaluacion_key][$apelacion_key], "item_apelacion");
                            $plantilla->reemplazaEnBloque("apelacion", wordwrap($apelacion, 110, "<br />", true), "item_apelacion");
                            $plantilla->reemplazaEnBloque("idapelacion", $areclamo['idapelacion'][$key][$evaluacion_key][$apelacion_key], "item_apelacion");
                            $plantilla->reemplazaEnBloque("idmodulo_apelacion", $areclamo['idmodulo_apelacion'][$key][$evaluacion_key][$apelacion_key], "item_apelacion");
                            
                            if($seguridad->verifica_permiso("Editar", "Reclamo-Apelacion", $areclamo['idusu_c_apelacion'][$key][$evaluacion_key][$apelacion_key], $areclamo['idmodulo_c_apelacion'][$key][$evaluacion_key][$apelacion_key])){
                                $plantilla->iniciaBloque("editar_apelacion");                        
                                $plantilla->reemplazaEnBloque("idmodulo_apelacion", $areclamo['idmodulo_apelacion'][$key][$evaluacion_key][$apelacion_key], "editar_apelacion");
                                $plantilla->reemplazaEnBloque("idapelacion", $areclamo['idapelacion'][$key][$evaluacion_key][$apelacion_key], "editar_apelacion");
                            }
                            
                            if($seguridad->verifica_permiso("Eliminar", "Reclamo-Apelacion", $areclamo['idusu_c_apelacion'][$key][$evaluacion_key][$apelacion_key], $areclamo['idmodulo_c_apelacion'][$key][$evaluacion_key][$apelacion_key])){
                                $plantilla->iniciaBloque("eliminar_apelacion");                        
                                $plantilla->reemplazaEnBloque("idmodulo_apelacion", $areclamo['idmodulo_apelacion'][$key][$evaluacion_key][$apelacion_key], "eliminar_apelacion");
                                $plantilla->reemplazaEnBloque("idapelacion", $areclamo['idapelacion'][$key][$evaluacion_key][$apelacion_key], "eliminar_apelacion");
                            }
                        }

                    }

                    $plantilla->iniciaBloque("menu_apelacion");
                    $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "menu_apelacion");
                    $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "menu_apelacion");

                    if($count>1){
                        $plantilla->iniciaBloque("boton_ocultar");
                        $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "boton_ocultar");
                        $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "boton_ocultar");
                    }
                    
                    
                    
                    
                }
                
            }
            
            $plantilla->iniciaBloque("menu_evaluacion");
            $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "menu_evaluacion");
            $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "menu_evaluacion");
            
            
                
                

            //RC
            if (sizeof($areclamo['rc'][$key]) > 0) {

                foreach ($areclamo['rc'][$key] as $rc_key => $rc) {

                    $tokens = preg_split("/[-]+/", $rc);
                    if($tokens[1]==2){
                        $plantilla->iniciaBloque("rc_reclamo");
                        $plantilla->reemplazaEnBloque("rc", $tokens[0], "rc_reclamo");
                    }else{
                        $plantilla->reemplazaEnBloque("rc", $tokens[0], "item_reclamo");
                    }
                    
                    if($rc_key=="$idpersona-$idmodulo-1" || $rc_key=="$idpersona-$idmodulo-2"){
                        $nombre=$tokens[0];
                    }
                    
                    //echo $rc_key ." ";
                }
            }
            ///sh
            if (sizeof($areclamo['sh'][$key]) > 0) {

                foreach ($areclamo['sh'][$key] as $sh_key => $sh) {

                    $tokens = preg_split("/[-]+/", $sh);
                    $plantilla->iniciaBloque("sh_reclamo");
                    $plantilla->reemplazaEnBloque("idsh", $tokens[0], "sh_reclamo");
                    $plantilla->reemplazaEnBloque("idmodulo", $tokens[1], "sh_reclamo");
                    $plantilla->reemplazaEnBloque("sh", $tokens[2], "sh_reclamo");
                    $plantilla->reemplazaEnBloque("idpersona_tipo", $tokens[3], "sh_reclamo");
                    if($tokens[4]!=""){
                        $plantilla->reemplazaEnBloque("imagen", "../../../archivo/".$_SESSION['proyecto']."/imagen/".$tokens[4], "sh_reclamo");
                    }else{
                        $plantilla->reemplazaEnBloque("imagen", "../../../img/imagen.png", "sh_reclamo");
                    }
                }
            }
        }
    }
    //echo "tabla in" . $tabla_reclamo;
    if ($persona != 0) {
        $plantilla_tabla = new DmpTemplate("../../../plantillas/reclamo/reclamo/tabla_reclamo.html");
        $plantilla_tabla->reemplaza("bloque_reclamo", $plantilla->getPlantillaCadena());
        $plantilla_tabla->reemplaza("inicio", $inicio + 10);
        $plantilla_tabla->reemplaza("idpersona", $idpersona);
        $plantilla_tabla->reemplaza("idmodulo", $idmodulo);
        $plantilla_tabla->reemplaza("persona", $persona); // ver mas
        $plantilla_tabla->reemplaza("presenta", 1); // ver mas
        if($modo==1){
            $plantilla_tabla->iniciaBloque("enlaces");
            $plantilla_tabla->reemplazaEnBloque("nombre", $nombre, "enlaces");
            $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona, "enlaces");
            $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo, "enlaces");
            /*
            if($seguridad->verifica_permiso("Crear", "Interaccion"))
                $plantilla_tabla->iniciaBloque ("crear_interaccion");
             * 
             */
            if($seguridad->verifica_permiso("Crear", "Reclamo"))
                $plantilla_tabla->iniciaBloque ("crear_reclamo");
        }else{
            $plantilla_tabla->reemplaza("titulo", "Reclamos");
        }
        $plantilla = $plantilla_tabla;
    }


    if ($presenta == 1) {
        $plantilla->presentaPlantilla();
    } else {
        return $plantilla->getPlantillaCadena();
    }
}

function guardar_reclamo_stakeholder($idpersona, $idmodulo, $reclamo, $fecha_reclamo, $idreclamo_tipo, $idreclamo_complejo_tag, $idreclamo_rc, $idreclamo_complejo_sh, $idreclamo_complejo_rc,$fecha_complejo, $comentario_reclamo, $evaluacion, $radio_evaluacion, $idreclamo_previo) {
   
   
    //echo "llega".$fecha_reclamo;exit;
    $greclamo = new greclamo();
    //echo "verr".$idreclamo_complejo_rc." ".$idreclamo_complejo_sh;exit;
    $respuesta = $greclamo->agregar($idpersona, $idmodulo, $reclamo, $fecha_reclamo, $idreclamo_tipo, $idreclamo_complejo_tag, $idreclamo_rc,  $idreclamo_complejo_sh,  $idreclamo_complejo_rc,$fecha_complejo,$comentario_reclamo, $evaluacion, $radio_evaluacion , $idreclamo_previo);
        
    $arespuesta = split("---", $respuesta);
    if ($arespuesta[2] == 0) {
        
        $error_archivo = false;
        
        $count = 0;
        $archivos =array();
   
        foreach ($_FILES["archivos"]["error"] as $key => $error) {
             if ($error == UPLOAD_ERR_OK) {
                 $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                 $archivo = $_FILES["archivos"]["name"][$key];

                 $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."reclamo".DIRECTORY_SEPARATOR.$arespuesta[0].'_'.$archivo; 
                 
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
            $greclamo->agregar_archivo_reclamo($arespuesta[0],$arespuesta[1],$archivos);
        }
        
        if( isset($radio_evaluacion) ){
        
            $data['op_stakeholder'] = $radio_evaluacion;
            $data['idevaluacion'] =$arespuesta[3];
            $data['idmodulo_evaluacion'] =$arespuesta[4];

        }else{
            $data['op_stakeholder'] = 0;
        }
        $data['idreclamo'] =$arespuesta[0];
        $data['idmodulo_reclamo'] =$arespuesta[1];
        $data['success'] = true;
        $data['error_archivo'] = $error_archivo;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del reclamo ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del reclamo ");
        $data['op_stakeholder'] = 0;
    }
    
    

    echo json_encode($data);
    //echo $respuesta;
}

function ver_reclamo_stakeholder_complejo($idpersona = "", $idmodulo = "", $idreclamo = "", $idmodulo_reclamo = "", $persona = "", $presenta) {
    
    $seguridad = new Seguridad();

    $plantilla = new DmpTemplate("../../../plantillas/reclamo/reclamo/reclamo_complejo.html");

    $max_upload = (int)(ini_get('upload_max_filesize'));
    $max_post = (int)(ini_get('post_max_size'));
    $memory_limit = (int)(ini_get('memory_limit'));
    $upload_mb = min($max_upload, $max_post, $memory_limit);

    $plantilla->reemplaza("maximo", $upload_mb);
    
    ///actualizar
    
    if ($idreclamo != "") {//solo uno xq se sobre entiende que viene el idmodulo
       
        $plantilla->reemplaza("idreclamo", $idreclamo);
        $plantilla->reemplaza("idmodulo_reclamo", $idmodulo_reclamo);
        $plantilla->reemplaza("op_reclamo", "actualizar_reclamo_stakeholder");
        $plantilla->reemplaza("tabla_reclamo", 0); //$tabla_reclamo
        $plantilla->reemplaza("persona", $persona);
        $oreclamo = new ireclamo();
        $result = $oreclamo->get_reclamo($idreclamo, $idmodulo_reclamo);

        if ($fila = mysql_fetch_array($result)) {
            $plantilla->reemplaza("reclamo", $fila[reclamo]);
            $plantilla->reemplaza("comentario_reclamo", $fila[comentario]);
            $plantilla->reemplaza("fecha_reclamo", $fila[fecha]);
            
                                  
            $ireclamo_tipo = new ireclamo_tipo();

            $result_reclamo_tipo = $ireclamo_tipo->lista_reclamo_tipo();

            while (!!$fila_tipo = mysql_fetch_array($result_reclamo_tipo)) {

                $plantilla->iniciaBloque("reclamo_tipo");
                $plantilla->reemplazaEnBloque("idreclamo_tipo", $fila_tipo[idreclamo_tipo], "reclamo_tipo");
                $plantilla->reemplazaEnBloque("tipo", $fila_tipo[tipo], "reclamo_tipo");
                if($fila[idreclamo_tipo]==$fila_tipo[idreclamo_tipo]){                    
                    $plantilla->reemplazaEnBloque("selected" ,"selected","reclamo_tipo");
                }
            }
            
            $result_reclamo_fase = $oreclamo->get_fase($idreclamo,$idmodulo_reclamo);

            $fila_fase = mysql_fetch_array($result_reclamo_fase);

            $plantilla->iniciaBloque("reclamo_fase");
            $plantilla->reemplazaEnBloque("estado", $fila[estado], "reclamo_fase");
            $plantilla->reemplazaEnBloque("nombre_tipo", $fila[nombre_tipo], "reclamo_fase");
            $plantilla->reemplazaEnBloque("fase", $fila_fase[fase], "reclamo_fase");
            $plantilla->reemplazaEnBloque("orden", $fila_fase[idfase], "reclamo_fase");
            $plantilla->reemplazaEnBloque("total", $fila_fase[total], "reclamo_fase");

            $fecha_ini = $fila_fase[fecha_fase];
            //validar diferencia de hora de migracion...

            $interval = time()-strtotime($fecha_ini);
            $diff = floor($interval / (60*60*24));

            $plantilla->reemplazaEnBloque("dias", $diff, "reclamo_fase");
            if($fila[tipo_estado]>0){
                $diff = $fila_fase[dias_max] - $diff;
            }else{
                $diff = 0;
            }

            $plantilla->reemplazaEnBloque("faltan", $diff, "reclamo_fase");
                
            


            //tag
            $result_tag = $oreclamo->lista_tag_reclamo($idreclamo, $idmodulo_reclamo);
            $cont_tag = 0;
            $cont_tag_fila = 0;

            while (!!$fila_tag = mysql_fetch_array($result_tag)) {
                if ($cont_tag % 5 == 0) {
                    $plantilla->iniciaBloque("tr_tag_reclamo");
                    $cont_tag_fila++;
                    $cont_tag_celda = 0;
                }
                $plantilla->iniciaBloque("td_tag_reclamo");
                $plantilla->reemplazaEnBloque("tag", $fila_tag[tag], "td_tag_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "td_tag_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "td_tag_reclamo");
                $plantilla->iniciaBloque("eliminar_tag_reclamo");
                $plantilla->reemplazaEnBloque("reclamo_complejo_tag", $fila_tag[idreclamo_tag] . "***" . $fila_tag[idmodulo_reclamo_tag] . "***1", "eliminar_tag_reclamo");

                $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "eliminar_tag_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "eliminar_tag_reclamo");


                $cont_tag++;
                $cont_tag_celda++;
            }

            ////antes coloco el numero real de celdas y filas
            $plantilla->reemplaza("nume_fila_reclamo_tag_complejo", $cont_tag_fila);
            $plantilla->reemplaza("nume_celda_reclamo_tag_complejo", $cont_tag_celda);

            ///
            while ($cont_tag_celda < 5) {
                $plantilla->iniciaBloque("td_tag_reclamo");
                $plantilla->reemplazaEnBloque("tag", "&nbsp;", "td_tag_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "td_tag_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "td_tag_reclamo");

                $cont_tag_celda++;
            }
            //rc
            $result_rc = $oreclamo->lista_reclamo_rc($idreclamo, $idmodulo_reclamo);
            $cont_rc = 0;
            $cont_rc_fila = 0;
            $count_receptor = 0;

            while (!!$fila_rc = mysql_fetch_array($result_rc)) {
                if ($cont_rc % 1 == 0) {
                    $plantilla->iniciaBloque("tr_rc_reclamo");
                    $cont_rc_fila++;
                    $cont_rc_celda = 0;
                }
                
                if($fila_rc[idrol]==2){

                    $plantilla->iniciaBloque("td_rc_reclamo");
                    $plantilla->reemplazaEnBloque("rc", $fila_rc[apellido_p] . " " . $fila_rc[apellido_m] . ", " . $fila_rc[nombre], "td_rc_reclamo");
                    $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "td_rc_reclamo");
                    $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "td_rc_reclamo");

                    $plantilla->iniciaBloque("idreclamo_complejo_rc");

                    $plantilla->reemplazaEnBloque("idreclamo_complejo_rc", $fila_rc[idreclamo_rc] . "***" . $fila_rc[idmodulo_reclamo_rc] . "***1", "idreclamo_complejo_rc");
                    $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "idreclamo_complejo_rc");
                    $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "idreclamo_complejo_rc");

                    //if ($_SESSION[idusu] . "-" . $_SESSION[idmodulo_a] != $fila_rc[idpersona] . "-" . $fila_rc[idmodulo]) {
                    $plantilla->iniciaBloque("eliminar_rc_reclamo");
                    $plantilla->reemplazaEnBloque("fecha", $fila_rc[fecha] , "eliminar_rc_reclamo");
                    $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "eliminar_rc_reclamo");
                    $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "eliminar_rc_reclamo");
                    //}
                    $cont_rc++;
                    $cont_rc_celda++;
                }else{
                    $count_receptor++;
                    $plantilla->iniciaBloque("rc_reclamo");
                    $plantilla->reemplazaEnBloque("rc", $fila_rc[apellido_p] . " " . $fila_rc[apellido_m] . ", " . $fila_rc[nombre], "rc_reclamo");
                    $plantilla->reemplazaEnBloque("idrc", $fila_rc[idreclamo_rc], "rc_reclamo");
                    $plantilla->reemplazaEnBloque("idmodulo_rc", $fila_rc[idmodulo_reclamo_rc] , "rc_reclamo");
                    
                }
            }
            
            $plantilla->reemplaza("count_receptor", $count_receptor);
            
            $plantilla->reemplaza("cant_rc", $cont_rc);
            ////antes coloco el numero real de celdas y filas
            $plantilla->reemplaza("nume_fila_reclamo_rc2_complejo", $cont_rc_fila);
            $plantilla->reemplaza("nume_celda_reclamo_rc2_complejo", $cont_rc_celda);

            ///
            while ($cont_rc_celda < 1) {
                $plantilla->iniciaBloque("td_rc_reclamo");
                $plantilla->reemplazaEnBloque("rc", "&nbsp;", "td_rc_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "td_rc_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "td_rc_reclamo");

                $cont_rc_celda++;
            }
            
            if(isset($fila[idreclamo_previo]) && $fila[idreclamo_previo]>0){
                $plantilla->iniciaBloque("reclamo_previo");
                $plantilla->reemplazaEnBloque("idreclamo", $fila[idreclamo_previo], "reclamo_previo");
                $plantilla->reemplazaEnBloque("idmodulo_reclamo", $fila[idmodulo_reclamo_previo], "reclamo_previo");
            }
            
            
            //sh
            $resulta_sh = $oreclamo->lista_reclamo_sh($idreclamo, $idmodulo_reclamo);
            $cont_sh = 0;
            $cont_sh_fila = 0;
            while (!!$fila_sh = mysql_fetch_array($resulta_sh)) {
                if ($cont_sh % 5 == 0) {
                    $plantilla->iniciaBloque("tr_sh_reclamo");
                    $cont_sh_fila++;
                    $cont_sh_celda = 0;
                }
               
                $plantilla->iniciaBloque("td_sh_reclamo");
                $plantilla->reemplazaEnBloque("sh", $fila_sh[apellido_p] . " " . $fila_sh[apellido_m] . ", " . $fila_sh[nombre], "td_sh_reclamo");
                $plantilla->reemplazaEnBloque("idsh", $fila_sh[idsh], "td_sh_reclamo");
                $plantilla->reemplazaEnBloque("idmodulo", $fila_sh[idmodulo], "td_sh_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "td_sh_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_reclamo");

                $plantilla->iniciaBloque("idreclamo_complejo_sh");

                $plantilla->reemplazaEnBloque("idreclamo_complejo_sh", $fila_sh[idreclamo_sh] . "***" . $fila_sh[idmodulo_reclamo_sh] . "***1", "idreclamo_complejo_sh");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "idreclamo_complejo_sh");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "idreclamo_complejo_sh");

                //if ($idpersona . "-" . $idmodulo != $fila_sh[idpersona] . "-" . $fila_sh[idmodulo]) {
                    $plantilla->iniciaBloque("eliminar_sh_reclamo");
                    //***1 el estado activo, al cambiar a 0, el estado desactivo

                    $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "eliminar_sh_reclamo");
                    $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "eliminar_sh_reclamo");
                //}
                $cont_sh++;
                $cont_sh_celda++;
            }
            
            $plantilla->reemplaza("cant_sh", $cont_sh);

            ////antes coloco el numero real de celdas y filas
            $plantilla->reemplaza("nume_fila_reclamo_sh_complejo", $cont_sh_fila);
            $plantilla->reemplaza("nume_celda_reclamo_sh_complejo", $cont_sh_celda);

            ///
            while ($cont_sh_celda < 5) {
                $plantilla->iniciaBloque("td_sh_reclamo");
                $plantilla->reemplazaEnBloque("sh", "&nbsp;", "td_sh_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "td_sh_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_reclamo");

                $cont_sh_celda++;
            }
            
            $plantilla->reemplaza("comentario_reclamo", $fila[comentario]);
            
            //documento
            
            
            $result = $oreclamo->lista_archivo($idreclamo, $idmodulo_reclamo);
            
            while($fila_archivo=  mysql_fetch_array($result)){
                $plantilla->iniciaBloque("archivo");
                $plantilla->reemplazaEnBloque("idreclamo_archivo", $fila_archivo[idreclamo_archivo], "archivo");
                $plantilla->reemplazaEnBloque("idmodulo_reclamo_archivo", $fila_archivo[idmodulo_reclamo_archivo], "archivo");
                $plantilla->reemplazaEnBloque("archivo", $fila_archivo[archivo], "archivo");
                $plantilla->reemplazaEnBloque("activo", $fila_archivo[activo], "archivo");
                $plantilla->reemplazaEnBloque("ruta", $idreclamo.'_'.$fila_archivo[archivo], "archivo");
                $plantilla->reemplazaEnBloque("fecha", date("d/m/Y", strtotime($fila_archivo[fecha]) ), "archivo");
            }
            
             //documento
            
            
            $areclamo = $oreclamo->lista_stakeholder_reclamo($idreclamo, $idmodulo_reclamo,0,0,1);
            
            $key = $idreclamo .'-'. $idmodulo_reclamo;
            
            foreach ($areclamo['evaluacion'][$key] as $evaluacion_key => $evaluacion) {
                    $count++;

                    $plantilla->iniciaBloque("evaluacion");
                    if($count>1){
                        $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "evaluacion");
                        $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "evaluacion");
                        //$plantilla->reemplazaEnBloque("estilo", "display:none;","item_evaluacion");
                    }
                    $plantilla->reemplazaEnBloque("fecha_evaluacion", $areclamo['fecha_evaluacion'][$key][$evaluacion_key], "evaluacion");
                    $plantilla->reemplazaEnBloque("evaluacion", wordwrap($evaluacion, 110, "<br />", true), "evaluacion");
                    $plantilla->reemplazaEnBloque("idevaluacion", $areclamo['idevaluacion'][$key][$evaluacion_key], "evaluacion");
                    $plantilla->reemplazaEnBloque("idmodulo_evaluacion", $areclamo['idmodulo_evaluacion'][$key][$evaluacion_key], "evaluacion");
                    
                    if($seguridad->verifica_permiso("Editar", "Reclamo-Evaluacion", $areclamo['idusu_c_evaluacion'][$key][$evaluacion_key], $areclamo['idmodulo_c_evaluacion'][$key][$evaluacion_key])){
                        $plantilla->iniciaBloque("editar_evaluacion");                        
                        $plantilla->reemplazaEnBloque("idmodulo_evaluacion", $areclamo['idmodulo_evaluacion'][$key][$evaluacion_key], "editar_evaluacion");
                        $plantilla->reemplazaEnBloque("idevaluacion", $areclamo['idevaluacion'][$key][$evaluacion_key], "editar_evaluacion");
                    }
                    
                    $cant = sizeof($areclamo['idpropuesta'][$key][$evaluacion_key]);
                //echo "Cant : ".$cant."<br>";

                    if ( $cant > 0) {

                        foreach ($areclamo['propuesta'][$key][$evaluacion_key] as $propuesta_key => $propuesta) {
                            $count++;

                            $plantilla->iniciaBloque("propuesta");

                            $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "propuesta");
                            $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "propuesta");
                                //$plantilla->reemplazaEnBloque("estilo", "display:none;","item_propuesta");

                            $plantilla->reemplazaEnBloque("fecha_propuesta", $areclamo['fecha_propuesta'][$key][$evaluacion_key][$propuesta_key], "propuesta");
                            $plantilla->reemplazaEnBloque("propuesta", wordwrap($propuesta, 110, "<br />", true), "propuesta");
                            $plantilla->reemplazaEnBloque("idpropuesta", $areclamo['idpropuesta'][$key][$evaluacion_key][$propuesta_key], "propuesta");
                            $plantilla->reemplazaEnBloque("idmodulo_propuesta", $areclamo['idmodulo_propuesta'][$key][$evaluacion_key][$propuesta_key], "propuesta");
                            
                             if($seguridad->verifica_permiso("Editar", "Reclamo-Acuerdo", $areclamo['idusu_c_propuesta'][$key][$evaluacion_key][$propuesta_key], $areclamo['idmodulo_c_propuesta'][$key][$evaluacion_key][$propuesta_key])){
                                $plantilla->iniciaBloque("editar_propuesta");                        
                                $plantilla->reemplazaEnBloque("idmodulo_propuesta", $areclamo['idmodulo_propuesta'][$key][$evaluacion_key][$propuesta_key], "editar_propuesta");
                                $plantilla->reemplazaEnBloque("idpropuesta", $areclamo['idpropuesta'][$key][$evaluacion_key][$propuesta_key], "editar_propuesta");
                             }
                             
                            
                        }

                    }

                    


                    $cant = sizeof($areclamo['idapelacion'][$key][$evaluacion_key]);
                    //echo "Cant : ".$cant."<br>";
                    $count=0;
                    if ( $cant > 0) {

                        foreach ($areclamo['apelacion'][$key][$evaluacion_key] as $apelacion_key => $apelacion) {
                            $count++;

                            $plantilla->iniciaBloque("apelacion");
                            
                            $plantilla->reemplazaEnBloque("idreclamo", $areclamo[idreclamo][$key], "apelacion");
                            $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo[idmodulo_reclamo][$key], "apelacion");
                            //$plantilla->reemplazaEnBloque("estilo", "display:none;","item_apelacion");
                            
                            $plantilla->reemplazaEnBloque("fecha_apelacion", $areclamo['fecha_apelacion'][$key][$evaluacion_key][$apelacion_key], "apelacion");
                            $plantilla->reemplazaEnBloque("apelacion", wordwrap($apelacion, 110, "<br />", true), "apelacion");
                            $plantilla->reemplazaEnBloque("idapelacion", $areclamo['idapelacion'][$key][$evaluacion_key][$apelacion_key], "apelacion");
                            $plantilla->reemplazaEnBloque("idmodulo_apelacion", $areclamo['idmodulo_apelacion'][$key][$evaluacion_key][$apelacion_key], "apelacion");
                            
                             if($seguridad->verifica_permiso("Editar", "Reclamo-Apelacion", $areclamo['idusu_c_apelacion'][$key][$evaluacion_key][$apelacion_key], $areclamo['idmodulo_c_apelacion'][$key][$evaluacion_key][$apelacion_key])){
                                $plantilla->iniciaBloque("editar_apelacion");                        
                                $plantilla->reemplazaEnBloque("idmodulo_apelacion", $areclamo['idmodulo_apelacion'][$key][$evaluacion_key][$apelacion_key], "editar_apelacion");
                                $plantilla->reemplazaEnBloque("idapelacion", $areclamo['idapelacion'][$key][$evaluacion_key][$apelacion_key], "editar_apelacion");
                            }
                        }

                    }

                    
                }
        }
        $plantilla->iniciaBloque("reclamo_pdf");
        $plantilla->reemplazaEnBloque("idreclamo",$idreclamo,"reclamo_pdf");
        $plantilla->reemplazaEnBloque("idmodulo_reclamo",$idmodulo_reclamo ,"reclamo_pdf");
        
        if($fila[idreclamo_estado]==3 || $fila[idreclamo_estado]==1 ){
            $plantilla->iniciaBloque("nueva_evaluacion");
        }
        
        if($fila[idreclamo_estado]<4){
            $plantilla->iniciaBloque("acuerdo");            
        }
        
        if($fila[idfase] < $fila_fase[total]){
            $plantilla->iniciaBloque("apelacion");            
        }
        
        if($fila[tipo_estado]==1){
            $plantilla->iniciaBloque("cierre");
            $plantilla->reemplazaEnBloque("fecha_cierre", date('d/m/Y'),"cierre");
        }
        
        
    } else {

        $plantilla->reemplaza("op_reclamo", "guardar_reclamo_stakeholder");
        $plantilla->reemplaza("fecha_reclamo", date('d/m/Y'));
        
        

        //tipo
         $ireclamo_tipo = new ireclamo_tipo();

        $result_reclamo_tipo = $ireclamo_tipo->lista_reclamo_tipo();

        while (!!$fila = mysql_fetch_array($result_reclamo_tipo)) {

            $plantilla->iniciaBloque("reclamo_tipo");
            $plantilla->reemplazaEnBloque("idreclamo_tipo", $fila[idreclamo_tipo], "reclamo_tipo");
            $plantilla->reemplazaEnBloque("tipo", $fila[tipo], "reclamo_tipo");
        }
        $ipersona = new ipersona();
        
        $plantilla->reemplaza("count_receptor", 0);
                        
        $plantilla->reemplaza("cant_sh", $presenta);
        
        $plantilla->reemplaza("nume_fila_reclamo_rc2_complejo", 0);
        $plantilla->reemplaza("nume_celda_reclamo_rc2_complejo", 0);
        
        if($presenta>0){

            $result_persona = $ipersona->get_persona($idpersona, $idmodulo);
            $fila_sh = mysql_fetch_array($result_persona);

            $plantilla->iniciaBloque("tr_sh_reclamo");
            $plantilla->iniciaBloque("td_sh_reclamo");
            $plantilla->reemplazaEnBloque("sh", $fila_sh[apellido_p] . " " . $fila_sh[apellido_m] . ", " . $fila_sh[nombre], "td_sh_reclamo");
            $plantilla->reemplazaEnBloque("idsh", $fila_sh[idpersona], "td_sh_reclamo");
            $plantilla->reemplazaEnBloque("idmodulo", $fila_sh[idmodulo], "td_sh_reclamo");
            $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_reclamo");
            $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_reclamo");

            $plantilla->iniciaBloque("idreclamo_complejo_sh");

            $plantilla->reemplazaEnBloque("idreclamo_complejo_sh", $fila_sh[idpersona] . "---" . $fila_sh[idmodulo], "idreclamo_complejo_sh");

            for ($cont_sh_celda = 2; $cont_sh_celda <= 5; $cont_sh_celda++) {
                $plantilla->iniciaBloque("td_sh_reclamo");
                $plantilla->reemplazaEnBloque("sh", "&nbsp;", "td_sh_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_reclamo");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_reclamo");
            }

            $plantilla->reemplaza("nume_fila_reclamo_sh_complejo", 1);
            $plantilla->reemplaza("nume_celda_reclamo_sh_complejo", 2);
            
            $plantilla->iniciaBloque("eliminar_sh_reclamo");
            //***1 el estado activo, al cambiar a 0, el estado desactivo

            $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "eliminar_sh_reclamo");
            $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "eliminar_sh_reclamo");
            
            
        }
        
        $cont_rc=0;
        $plantilla->reemplaza("cant_rc", $cont_rc);
        
        $plantilla->iniciaBloque("nueva_evaluacion");
       
        $plantilla->iniciaBloque("acuerdo");            
       
        $plantilla->iniciaBloque("apelacion");            
        
    }

    $plantilla->presentaPlantilla();
}

function actualizar_reclamo_stakeholder($idreclamo, $idmodulo_reclamo, $idreclamo_complejo_tag, $idreclamo_rc, $idreclamo_complejo_rc,$fecha_complejo, $idreclamo_complejo_sh, $idreclamo_archivo, $comentario_reclamo, $fecha_reclamo, $idreclamo_tipo, $reclamo,$evaluacion, $radio_evaluacion,$idreclamo_previo,$idreclamo_estado,$fecha_cierre) {
    //echo "llega".$fecha_reclamo;exit;
    $greclamo = new greclamo();
    $respuesta = $greclamo->actualizar_reclamo($idreclamo, $idmodulo_reclamo, $idreclamo_complejo_tag, $idreclamo_rc, $idreclamo_complejo_rc,$fecha_complejo, $idreclamo_complejo_sh, $idreclamo_archivo, $comentario_reclamo, $fecha_reclamo, $idreclamo_tipo, $reclamo,$evaluacion,$idreclamo_previo,$idreclamo_estado,$fecha_cierre);
    //echo $respuesta;reclamo
    //$arespuesta=split("---", $respuesta);
    //ver_reclamo_stakolder_complejo("","",$idreclamo,$idmodulo_reclamo);
    $arespuesta = split("---", $respuesta);


    $data['op_stakeholder'] = 4;
    if ($arespuesta[2] == 0) {
        
        $count = 0;
        $archivos =array();
   
        foreach ($_FILES["archivos"]["error"] as $key => $error) {
             if ($error == UPLOAD_ERR_OK) {
                 $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                 $archivo = $_FILES["archivos"]["name"][$key];

                 $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."reclamo".DIRECTORY_SEPARATOR.$arespuesta[0].'_'.$archivo; 
                 
                 //echo $uploadfile." ";
                 
                 if(move_uploaded_file($tmp_name, $uploadfile)){
                     $archivos[] = $archivo;
                     $count++;
                 }
             }
         }
         
        if( $count>0 ){
            $greclamo->agregar_archivo_reclamo($arespuesta[0],$arespuesta[1],$archivos);
        }
        $data['radio_evaluacion'] =0;
        if(isset($radio_evaluacion))
            $data['radio_evaluacion'] = $radio_evaluacion;
        
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " del reclamo ");
        $data['idreclamo'] = $idreclamo;
        $data['idmodulo_reclamo'] = $idmodulo_reclamo;
        $data['idevaluacion'] = $arespuesta[3];
        $data['idmodulo_evaluacion'] = $arespuesta[4];
        //ver_bloque_reclamo($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1)
        $data['data'] = utf8_encode(ver_bloque_reclamo($idreclamo, $idmodulo_reclamo, 20, $persona, 0));

        //ver_bloque_reclamo($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1, $tabla_reclamo = 1)
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " del reclamo ");
    }

    echo json_encode($data);
}

function actualizar_evaluacion_stakeholder($idevaluacion, $idmodulo_evaluacion, $evaluacion) {
    //echo "llega $idevaluacion, $idmodulo_evaluacion, $evaluacion";exit;
    $greclamo = new greclamo();
    $respuesta = $greclamo->actualizar_evaluacion($idevaluacion, $idmodulo_evaluacion, $evaluacion);
    //echo $respuesta;reclamo
    //$arespuesta=split("---", $respuesta);
    //ver_reclamo_stakolder_complejo("","",$idreclamo,$idmodulo_reclamo);
    $arespuesta = split("---", $respuesta);


    //$data['op_stakeholder'] = true;
    
    if ($arespuesta[2] == 0) {
        
        $count = 0;
        
        
        //$data['op_stakeholder'] = 4;
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " de la evaluacion ");
        $data['idevaluacion'] = $idevaluacion;
        $data['idmodulo_evaluacion'] = $idmodulo_evaluacion;
        //ver_bloque_reclamo($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1)
        $data['data'] = utf8_encode(ver_item_evaluacion($idevaluacion, $idmodulo_evaluacion, $evaluacion));

        //ver_bloque_reclamo($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1, $tabla_reclamo = 1)
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " de la evaluacion ");
    }

    echo json_encode($data);
}


function ver_evaluacion_stakeholder_complejo($idevaluacion,$idmodulo_evaluacion, $presenta) {
    
    $ayudante = new Ayudante();

    $plantilla = new DmpTemplate("../../../plantillas/reclamo/reclamo/evaluacion.html");
    
   

    $max_upload = (int)(ini_get('upload_max_filesize'));
    $max_post = (int)(ini_get('post_max_size'));
    $memory_limit = (int)(ini_get('memory_limit'));
    $upload_mb = min($max_upload, $max_post, $memory_limit);

    $plantilla->reemplaza("maximo", $upload_mb);
    
    ///actualizar
    if ($idevaluacion != "") {//solo uno xq se sobre entiende que viene el idmodulo
        $plantilla->reemplaza("idevaluacion", $idevaluacion);
        $plantilla->reemplaza("idmodulo_evaluacion", $idmodulo_evaluacion);
        $plantilla->reemplaza("op_reclamo", "actualizar_evaluacion_stakeholder");
        //$plantilla->reemplaza("tabla_reclamo", 0); //$tabla_reclamo
        $plantilla->reemplaza("persona", $persona);
        
        $ireclamo = new ireclamo();
        
        $result = $ireclamo->get_evaluacion($idevaluacion,$idmodulo_evaluacion);
        
        if($fila = mysql_fetch_array($result)){
            $plantilla->reemplaza("reclamo_cabecera", ver_cabecera_reclamo($fila[idreclamo], $fila[idmodulo_reclamo]));
            $plantilla->reemplaza("evaluacion", $fila[evaluacion]);
        }
        
        
        
        
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

function ver_item_evaluacion($idevaluacion, $idmodulo_evaluacion,$evaluacion) {

    $plantilla = new DmpTemplate("../../../plantillas/reclamo/reclamo/item_evaluacion.html");
    //listar reclamo stakeholder
    
    
    $plantilla->reemplaza("evaluacion", $evaluacion);
    $plantilla->reemplaza("idevaluacion", $idevaluacion);
    $plantilla->reemplaza("idmodulo_evaluacion", $idmodulo_evaluacion);

    return $plantilla->getPlantillaCadena();
    //return $plantilla->presentaPlantilla();
}

function eliminar_reclamo_stakeholder($idreclamo, $idmodulo_reclamo) {
    $greclamo = new greclamo();
    $respuesta = $greclamo->eliminar_reclamo($idreclamo, $idmodulo_reclamo);

    if ($respuesta[0] == 0) {
        if ($respuesta[1] == 0) {
            $data['success'] = true;
            $data['mensaje'] = coloca_mensaje("elimina_ok", " del reclamo ");
        } else {
            $data['success'] = false;
            $data['mensaje'] = "No se puede eliminar el reclamo porque tiene evaluacion pendiente";
        }
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " del reclamo ");
    }

    echo json_encode($data);
}

function busqueda_rapida_reclamo($busca_rapida_reclamo) {
    $arrayElementos = array();
    $ireclamo = new ireclamo();
    $ayudante = new Ayudante();
    $result= $ireclamo->lista($busca_rapida_reclamo, '1');
    //if(mysql_num_rows($result_stakeholder)>0){
    
    $count=0;
    while ($fila = mysql_fetch_array($result)) {
        $count++;
        array_push($arrayElementos, new autocompletar(utf8_encode($fila["idreclamo_compuesto"]), $fila["idreclamo_compuesto"]));
    }
    //}else{
    //}

    //array_push($arrayElementos, new autocompletar(utf8_encode(" -- NUEVO RC --"), 'nuevo_stake_holder'));
    if($count==0)
        array_push($arrayElementos, new autocompletar(utf8_encode("No se hallaron resultados"), 'nuevo_stake_holder'));


    print_r(json_encode($arrayElementos));
    //json_encode($arrayElementos);
}


function exportar_pdf_reclamo($idreclamo,$idmodulo_reclamo,$tipo_reporte){
    
    $ireclamo = new ireclamo();   
    
    $pdf = new PDF();
    
    
    $areclamo=$ireclamo->lista_stakeholder_reclamo($idreclamo, $idmodulo_reclamo,0,0,1);
    
    ver_pdf_reclamo($areclamo,$pdf,$tipo_reporte);                              
    
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output("Reclamo_$idreclamo-$idmodulo_reclamo.pdf",'D');

    //============================================================+
    // END OF FILE
    //============================================================+

}


function ver_pdf_reclamo($areclamo,$pdf,$tipo_reporte){
    
    $codigo="";
    $interaccion="";
    $estado="";
    $prioridad="";
    $tipo="";
    $fecha="";
    $tags="";
    $rc1="";
    $rc2="";
    $shs="";
    $archivos="";
    $evaluaciones="";
    
    $ireclamo = new ireclamo(); 
    $ipropuesta = new ipropuesta();
    $iapelacion = new iapelacion();
    
    foreach ($areclamo[reclamo] as $key => $reclamo) { 
        
        if( isset($areclamo[idreclamo_previo][$key]) && $areclamo[idreclamo_previo][$key]>0 && $tipo_reporte>2){
            $idreclamo_previo = $areclamo[idreclamo_previo][$key];
            $idmodulo_reclamo_previo = $areclamo[idmodulo_reclamo_previo][$key];
            $areclamo_previo=$ireclamo->lista_stakeholder_reclamo($idreclamo_previo, $idmodulo_reclamo_previo,0,0,1);
            ver_pdf_reclamo($areclamo_previo,$pdf,$tipo_reporte);
        }
        
        
        $codigo=$areclamo[idreclamo][$key]."-".$areclamo[idmodulo_reclamo][$key];
        
        $estado=$areclamo[estado][$key];
        $tipo=$areclamo[tipo][$key];
        $fecha=$areclamo[fecha][$key];
        
        $result=$ireclamo->lista_tag_reclamo($areclamo[idreclamo][$key], $areclamo[idmodulo_reclamo][$key]);
        while($fila=  mysql_fetch_array($result)){
            $tags.= $fila[tag]. " , ";
        }
        $tags= substr($tags, 0, -3);
        
        foreach ($areclamo['rc'][$key] as $rc_key => $rc) {

            $tokens = preg_split("/[-]+/", $rc);
            if($tokens[1]==2){
                $rc2.= "- ".$tokens[0]."\n";
            }else{
                $rc1.= "- ".$tokens[0]."\n";
            }
        }
       
        //$rcs= substr($rcs, 0, -3);
                
        foreach ($areclamo['sh'][$key] as $sh_key => $sh) {

            $tokens = preg_split("/[-]+/", $sh);
            $shs.= "- ".$tokens[2]. "\n";
            
        }
                
        //$shs= substr($shs, 0, -3);
        
        
        $result=$ireclamo->lista_archivo($areclamo[idreclamo][$key], $areclamo[idmodulo_reclamo][$key]);
        while($fila=  mysql_fetch_array($result)){
            $archivos.= "- ".$fila[archivo]. "\n";
        }
        
        //$archivos= substr($archivos, 0, -3);
        
        
                
        
         // Primera página
        $pdf->AddPage();

        $pdf->SetFont('Arial','B',14);

        $pdf->Cell(0,10,'Reclamo',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Ln(10);
        $pdf->Cell(20);


        $pdf->Cell(30,10,'1. Código :',0,0,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,10,$codigo,0,0,'L');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(10);
        
        $pdf->Cell(30,10,'Estado :',0,0,'L');
        $pdf->SetFont('Arial','',12);       
        $pdf->Cell(50,10,$estado,0,1,'L');
        $pdf->SetFont('Arial','B',12);         
        $pdf->Cell(20);
        
        
        $pdf->Cell(30,10,'2. Descripción :',0,1,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(20);
        $pdf->MultiCell(150,5,$reclamo,0,'J');
        $pdf->SetFont('Arial','B',12);    
        $pdf->Cell(20);
        
                
        $pdf->Cell(30,10,'3. Tipo :',0,0,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,10,$tipo,0,1,'L');
        $pdf->SetFont('Arial','B',12);    
        $pdf->Cell(20);
        $pdf->Cell(30,10,'4. Fecha :',0,0,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,10,$fecha,0,1,'L');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(20);
        
        
        $pdf->Cell(30,10,'5. Tags :',0,1,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(20);
        $pdf->MultiCell(120,10,$tags,0,'L');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(20);
        
        
        $pdf->Cell(30,10,'6. Reclamante :',0,1,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(20);
        $pdf->MultiCell(120,5,$shs,0,'L');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(20);
        
        
        $pdf->Cell(30,10,'7. Recibido por :',0,1,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(20);
        $pdf->MultiCell(120,5,$rc1,0,'L');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(20);
        
        $pdf->Cell(30,10,'7. Responsable :',0,1,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(20);
        $pdf->MultiCell(120,5,$rc2,0,'L');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(20);
        
        
        $pdf->Cell(30,10,'8. Archivos :',0,1,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(20);
        $pdf->MultiCell(120,5,$archivos,0,'L');
        
        
        $count=0;
        foreach ($areclamo['evaluacion'][$key] as $evaluacion_key => $evaluacion) {
            //$evaluaciones.= "- Evaluacion N° ".$areclamo['idevaluacion'][$key][$evaluacion_key]."-".$areclamo['idmodulo_evaluacion'][$key][$evaluacion_key].", ".$evaluacion. "\n";
            $count++;
            
            if($tipo_reporte%2==0){
                $pdf->Ln(10);
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(20);
                $pdf->Cell(0,10,"Evaluación $count del Reclamo N° $codigo",1,1,'C');            
                $pdf->SetFont('Arial','',12);
                $pdf->Cell(20);
                $pdf->MultiCell(0,5,$evaluacion,1,'L');
            }
            
            foreach ($areclamo['apelacion'][$key][$evaluacion_key] as $apelacion_key => $apelacion) {
                
                $archivos="";
                $result=$iapelacion->lista_archivo($areclamo['idapelacion'][$key][$evaluacion_key][$apelacion_key], $areclamo['idmodulo_apelacion'][$key][$evaluacion_key][$apelacion_key]);
                
                while($fila=  mysql_fetch_array($result)){
                    $archivos.= "- ".$fila[archivo]. "\n";
                }
                
                $pdf->Ln(10);
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(20);
                $pdf->Cell(0,10,$areclamo['fecha_apelacion'][$key][$evaluacion_key][$apelacion_key]." Apelación $count del Reclamo N° $codigo",1,1,'C');            
                $pdf->SetFont('Arial','',12);
                $pdf->Cell(20);
                $pdf->MultiCell(0,5,$apelacion ."\n\n"."Archivos: \n\n".$archivos,1,'L');
            }
            
            foreach ($areclamo['propuesta'][$key][$evaluacion_key] as $propuesta_key => $propuesta) {
                $pdf->Ln(10);
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(20);
                $pdf->Cell(0,10,$areclamo['fecha_propuesta'][$key][$evaluacion_key][$propuesta_key]." Acuerdo del Reclamo N° $codigo",1,1,'C');            
                $pdf->SetFont('Arial','',12);
                $pdf->Cell(20);
                $pdf->MultiCell(0,5,$propuesta."\n\n"."$estado: \n\n".$areclamo['comentario_realizado'][$key][$evaluacion_key][$propuesta_key],1,'L');
            }
            
        }
        
       
    }
    
   //echo "tipo_reporte: $tipo_reporte";
    
   
}

function ver_buscar_reclamo() {

    
    $plantilla = new DmpTemplate("../../../plantillas/reclamo/reclamo/buscar.html");
    
    
    $ireclamo= new ireclamo();
    
    $result = $ireclamo->lista_fase();

    while ($fila = mysql_fetch_array($result)) {
        
        $plantilla->iniciaBloque("reclamo_fase");
        $plantilla->reemplazaEnBloque("orden", $fila[idfase], "reclamo_fase");
        $plantilla->reemplazaEnBloque("fase", $fila[fase], "reclamo_fase");
        
    }
    
    $result = $ireclamo->lista_tipo();

    while ($fila = mysql_fetch_array($result)) {
        
        $plantilla->iniciaBloque("reclamo_tipo");
        $plantilla->reemplazaEnBloque("idreclamo_tipo", $fila[idreclamo_tipo], "reclamo_tipo");
        $plantilla->reemplazaEnBloque("tipo", $fila[tipo], "reclamo_tipo");
        
    }
    
    $result = $ireclamo->lista_estado();

    while ($fila = mysql_fetch_array($result)) {
        
        $plantilla->iniciaBloque("reclamo_estado");
        $plantilla->reemplazaEnBloque("idreclamo_estado", $fila[idreclamo_estado], "reclamo_estado");
        $plantilla->reemplazaEnBloque("estado", $fila[estado], "reclamo_estado");
        
    }
    
    $plantilla->presentaPlantilla();
}

function buscar_reclamo($identidad,$idmodulo_entidad,$entidad,$idreclamo_fase,$idreclamo_tipo,$idreclamo_estado,$fecha_del , $fecha_al,$idreclamo_complejo_tag,$idreclamo_complejo_sh,$idreclamo_rc, $idreclamo_complejo_rc, $plazo ){
    
    $seguridad = new Seguridad();
    
    $ireclamo = new ireclamo();
    
    $areclamo = $ireclamo->lista_reporte($identidad,$idmodulo_entidad,$entidad,$idreclamo_fase,$idreclamo_tipo,$idreclamo_estado,$fecha_del , $fecha_al, $idreclamo_complejo_tag,$idreclamo_complejo_sh,$idreclamo_rc, $idreclamo_complejo_rc, $plazo );

    $datos=array();
    
    $total=0;
    
    foreach ($areclamo[reclamo] as $key => $reclamo) {
        
        $total++;
        
        //RC
            $rc="";
            if (sizeof($areclamo['rc'][$key]) > 0) {

                foreach ($areclamo['rc'][$key] as $rc_key => $rc_value) {
                    if(isset($rc_value)){
                        $tokens = preg_split("/[-]+/", $rc_value);
                        if($tokens[1]==2)
                            $rc .= " ".$tokens[0]. ",";
                    }
                }
                $rc = substr($rc, 0, -1);
            }
            
            
            ///sh
            $sh="";
            if (sizeof($areclamo['sh'][$key]) > 0) {

                foreach ($areclamo['sh'][$key] as $sh_key => $sh_value) {

                    $tokens = preg_split("/[-]+/", $sh_value);
                    
                    $sh .= " ".$tokens[2]. ",";
                    
                   
                }
                $sh = substr($sh, 0, -1);
                
            }
        
        if($entidad=="reclamo"){
            $codigo = $areclamo[idreclamo][$key]."-".$areclamo[idmodulo_reclamo][$key];
            $fase   = $areclamo[idfase][$key];
            
            if($areclamo[tipo_estado][$key]==0){
                $plazo=0;
            }else{
                $plazo   = $areclamo[plazo][$key];
            }
            $estado   = $areclamo[estado][$key];
            $fecha   = $areclamo[fecha][$key];
            $accion="<a href='javascript:modal_ver_predio_entidad(\"reclamo\",".$areclamo[idreclamo][$key].",".$areclamo[idmodulo_reclamo][$key].")' title='Ver GIS'><img src='../../../img/layers.png' alt='GIS'/></a>";
            $accion.="<a href='javascript:exportar_pdf_reclamo(\"frame4\",".$areclamo[idreclamo][$key].",".$areclamo[idmodulo_reclamo][$key].",4)' title='Ver PDF'><img src='../../../img/pdf.png' alt='PDF'/></a>";
            if($seguridad->verifica_permiso("Editar", "Reclamo", $areclamo['idusu_c'][$key], $areclamo['idmodulo_c'][$key]))
                $accion.="<a href='javascript:modal_reclamo(".$areclamo[idreclamo][$key].",".$areclamo[idmodulo_reclamo][$key].")' title='Editar reclamo'><img src='../../../img/edit.png' alt='Editar'/></a>";
            
            if($areclamo[archivos][$key]>0)
                $accion.="<img src='../../../img/attach.png' alt='adjuntos'/>";
           
            $datos["data"][]=array("codigo"=>$codigo,"fase"=>$fase,"estado"=>$estado,"fecha"=>$fecha,"plazo"=>$plazo,"reclamante"=>  utf8_encode($sh),"responsable"=>utf8_encode($rc),"accion"=>$accion);
                        
            
        }
        
        $count=1;
        
        foreach ($areclamo['evaluacion'][$key] as $evaluacion_key => $evaluacion) {
            
                     if ( $entidad=="apelacion" ) {

                        foreach ($areclamo['apelacion'][$key][$evaluacion_key] as $apelacion_key => $apelacion) {                            

                            $codigo =$areclamo['idapelacion'][$key][$evaluacion_key][$apelacion_key]."-".$areclamo['idmodulo_apelacion'][$key][$evaluacion_key][$apelacion_key];
                            $fase=$count;
                            if($fase == $areclamo[idfase][$key] && $areclamo[tipo_estado][$key]>0 ){
                                $plazo = $areclamo[plazo][$key];
                            }else{
                                $plazo = 0;
                            }
                            $estado   = $areclamo[estado][$key];
                            $fecha = $areclamo['fecha_apelacion'][$key][$evaluacion_key][$apelacion_key];
                            $accion="<a href='javascript:exportar_pdf_reclamo(\"frame4\",".$areclamo[idreclamo][$key].",".$areclamo[idmodulo_reclamo][$key].",4)' title='Ver PDF'><img src='../../../img/pdf.png' alt='PDF'/></a>";
                            if($seguridad->verifica_permiso("Editar", "Reclamo", $areclamo['idusu_c'][$key], $areclamo['idmodulo_c'][$key]))
                                $accion.="<a href='javascript:modal_reclamo(".$areclamo[idreclamo][$key].",".$areclamo[idmodulo_reclamo][$key].")' title='Editar reclamo'><img src='../../../img/edit.png' alt='Editar'/></a>";

                            if(isset($idreclamo_fase) && is_array($idreclamo_fase)){
                
                                if(in_array($fase, $idreclamo_fase)){
                                    $datos["data"][]=array("codigo"=>$codigo,"fase"=>$fase,"estado"=>$estado,"fecha"=>$fecha,"plazo"=>$plazo,"reclamante"=>  utf8_encode($sh),"responsable"=>utf8_encode($rc),"accion"=>$accion);
                                }

                            }else{
                                $datos["data"][]=array("codigo"=>$codigo,"fase"=>$fase,"estado"=>$estado,"fecha"=>$fecha,"plazo"=>$plazo,"reclamante"=>  utf8_encode($sh),"responsable"=>utf8_encode($rc),"accion"=>$accion);
                            }
                            $count++;
                        }

                    }
                                
                    if ( $entidad=="propuesta" ) {

                        foreach ($areclamo['propuesta'][$key][$evaluacion_key] as $propuesta_key => $propuesta) {
                            
                            $codigo =$areclamo['idpropuesta'][$key][$evaluacion_key][$propuesta_key]."-".$areclamo['idmodulo_propuesta'][$key][$evaluacion_key][$propuesta_key];
                            $fase   = $areclamo[idfase][$key];
                            $fecha =$areclamo['fecha_propuesta'][$key][$evaluacion_key][$propuesta_key];
                            $plazo   = 0;
                            $accion="<a href='javascript:exportar_pdf_reclamo(\"frame4\",".$areclamo[idreclamo][$key].",".$areclamo[idmodulo_reclamo][$key].",4)' title='Ver PDF'><img src='../../../img/pdf.png' alt='PDF'/></a>";
                            if($seguridad->verifica_permiso("Editar", "Reclamo", $areclamo['idusu_c'][$key], $areclamo['idmodulo_c'][$key]))
                                $accion.="<a href='javascript:modal_reclamo(".$areclamo[idreclamo][$key].",".$areclamo[idmodulo_reclamo][$key].")' title='Editar reclamo'><img src='../../../img/edit.png' alt='Editar'/></a>";
                            $estado   = $areclamo[estado][$key];
                            
                            $datos["data"][]=array("codigo"=>$codigo,"fase"=>$fase,"estado"=>$estado,"fecha"=>$fecha,"plazo"=>$plazo,"reclamante"=>  utf8_encode($sh),"responsable"=>utf8_encode($rc),"accion"=>$accion);
                            
                            
                        }

                    }
                                   
            
            
            }
        
        
        
    }
    
    $fid_string=" ";
    
    foreach ($areclamo['idgis_item'] as $idgis_item => $reclamo){
        
            $datos['idgis_item'][$idgis_item]=$reclamo;
        
        $fid_string .= $idgis_item.",";
    }
    
    
    $fid_string = substr($fid_string, 0, -1);
    
    $datos["fid_string"]=$fid_string;
    
   
        
        
        
  
    echo json_encode($datos);
    
}

function exportar_reclamo($identidad,$idmodulo_entidad,$entidad,$idreclamo_fase,$idreclamo_tipo,$idreclamo_estado,$fecha_del , $fecha_al,$idreclamo_complejo_tag,$idreclamo_complejo_sh,$idreclamo_rc, $idreclamo_complejo_rc, $plazo){
    
    $ireclamo = new ireclamo();
    
    if($entidad==""){
        //primero mostraremos los datos del reclamo, luego obtendremos los ids en caso de otras entidades
    }
    
    $areclamo = $ireclamo->lista_reporte($identidad,$idmodulo_entidad,$entidad,$idreclamo_fase,$idreclamo_tipo,$idreclamo_estado,$fecha_del , $fecha_al, $idreclamo_complejo_tag,$idreclamo_complejo_sh,$idreclamo_rc, $idreclamo_complejo_rc, $plazo );

    $datos=array();
    
    foreach ($areclamo[reclamo] as $key => $reclamo) {
        
        //RC
            $rc1="";
            $rc2="";
            if (sizeof($areclamo['rc'][$key]) > 0) {

                foreach ($areclamo['rc'][$key] as $rc_key => $rc_value) {
                    if(isset($rc_value)){
                        $tokens = preg_split("/[-]+/", $rc_value);
                        if($tokens[1]==1){
                            $rc1 .= " ".$tokens[0]. ",";
                        }elseif($tokens[1]==2){
                            $rc2 .= " ".$tokens[0]. ",";
                        }else{
                            
                        }
                    }
                }
                if(strlen($rc1)>0)
                    $rc1 = substr($rc1, 0, -1);
                if(strlen($rc2)>0)
                    $rc2 = substr($rc2, 0, -1);
            }
            
            
            ///sh
            $sh="";
            if (sizeof($areclamo['sh'][$key]) > 0) {

                foreach ($areclamo['sh'][$key] as $sh_key => $sh_value) {

                    $tokens = preg_split("/[-]+/", $sh_value);
                    
                    $sh .= " ".$tokens[2]. ",";
                    
                   
                }
                $sh = substr($sh, 0, -1);
                
            }
        
        
        $codigo = $areclamo[idreclamo][$key]."-".$areclamo[idmodulo_reclamo][$key];
        $fase   = $areclamo[idfase][$key];

        if($areclamo[tipo_estado][$key]==0){
            $plazo=0;
        }else{
            $plazo   = $areclamo[plazo][$key];
        }
        $estado   = $areclamo[estado][$key];
        $fecha   = $areclamo[fecha][$key];
      
        $count=0;
        
        $apelaciones=array();
        $evaluaciones=array();
        $propuestas = array();
        
        foreach ($areclamo['evaluacion'][$key] as $evaluacion_key => $evaluacion) {
            
            $count++;
            
            $evaluaciones[$count] =  utf8_encode($evaluacion);
                                 
            foreach ($areclamo['apelacion'][$key][$evaluacion_key] as $apelacion_key => $apelacion) {                            

                $fecha_apelacion = $areclamo['fecha_apelacion'][$key][$evaluacion_key][$apelacion_key];                            
                $apelaciones[$count][apelacion] =  utf8_encode($apelacion);
                $apelaciones[$count][fecha] =  $fecha_apelacion;
                
            }

            foreach ($areclamo['propuesta'][$key][$evaluacion_key] as $propuesta_key => $propuesta) {

                $fecha_propuesta =$areclamo['fecha_propuesta'][$key][$evaluacion_key][$propuesta_key];
                $propuestas[propuesta] = utf8_encode($propuesta);
                $propuestas[fecha]=$fecha_propuesta;
            }
                    
        }
            
            $datos[]=array("codigo"=>$codigo,"fase"=>$fase,"estado"=>$estado,"fecha"=>$fecha,"plazo"=>$plazo,"reclamante"=>  utf8_encode($sh),"receptor"=>utf8_encode($rc1),"responsable"=>utf8_encode($rc2),"reclamo"=>$reclamo,"evaluaciones"=>$evaluaciones,"apelaciones"=>$apelaciones,"propuestas"=>$propuestas,"accion"=>$accion);
                        
    }
    
   
    echo json_encode($datos);
    
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
    $objDrawing->setCoordinates('H1');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    $objPHPExcel->getActiveSheet()->SetCellValue("A1", "Social Capital Group");
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );
    
    $columns = range('A','Z');
    
    $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
    $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
    
    $objPHPExcel->getActiveSheet()->SetCellValue("A4", "Reporte de Reclamos al $fecha");
    $objPHPExcel->getActiveSheet()->getStyle("A4:I4")->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle("A4")->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
    
    //numero de evaluaciones primero estatico luego dinamico.
    
    
    $count=8;
    
    $objPHPExcel->getActiveSheet()->SetCellValue("B".$count, utf8_encode("N°") );
    $objPHPExcel->getActiveSheet()->SetCellValue("C".$count, utf8_encode("Código"));
    $objPHPExcel->getActiveSheet()->SetCellValue("D".$count, "Reclamante");
    $objPHPExcel->getActiveSheet()->SetCellValue("E".$count, "Receptor");    
    $objPHPExcel->getActiveSheet()->SetCellValue("F".$count, utf8_encode("Descripción"));
    $objPHPExcel->getActiveSheet()->SetCellValue("G".$count, "Fecha");
    $objPHPExcel->getActiveSheet()->SetCellValue("H".$count, utf8_encode("Evaluación"));
    $objPHPExcel->getActiveSheet()->SetCellValue("I".$count, utf8_encode("1° Instancia"));    
    $objPHPExcel->getActiveSheet()->SetCellValue("J".$count, "Fecha");
    $objPHPExcel->getActiveSheet()->SetCellValue("K".$count, utf8_encode("Evaluación"));
    $objPHPExcel->getActiveSheet()->SetCellValue("L".$count, utf8_encode("2° Instancia"));
    $objPHPExcel->getActiveSheet()->SetCellValue("M".$count, "Fecha");
    $objPHPExcel->getActiveSheet()->SetCellValue("N".$count, utf8_encode("Evaluación"));
    $objPHPExcel->getActiveSheet()->SetCellValue("O".$count, utf8_encode("3° Instancia"));
    $objPHPExcel->getActiveSheet()->SetCellValue("P".$count, "Fecha");
    $objPHPExcel->getActiveSheet()->SetCellValue("Q".$count, utf8_encode("Evaluación"));
    $objPHPExcel->getActiveSheet()->SetCellValue("R".$count, "Acuerdo");
    $objPHPExcel->getActiveSheet()->SetCellValue("S".$count, "Fecha");
    $objPHPExcel->getActiveSheet()->SetCellValue("T".$count, "Estado Final");
    
    
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );
    
    foreach ($columns as $column) {
        $objPHPExcel->getActiveSheet()->getStyle("$column".$count)->applyFromArray($styleArray);
    }
    
        
    //$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
    //iteramos para los resultados
    $count++;
    foreach($datos as $row){
        $objPHPExcel->getActiveSheet()->SetCellValue("B".$count, ($count-8));
        $objPHPExcel->getActiveSheet()->SetCellValue("C".$count, $row["codigo"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("D".$count, $row["reclamante"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("E".$count, $row["receptor"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("F".$count, $row["reclamo"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("G".$count, $row["fecha"]);
        $i=7;
        foreach ($row["evaluaciones"] as $evaluacion){
            $objPHPExcel->getActiveSheet()->SetCellValue("$columns[$i]".$count, $evaluacion);
            $i = $i + 3;
        }
        $i=8;
        foreach ($row["apelaciones"] as $apelacion){
            $objPHPExcel->getActiveSheet()->SetCellValue("$columns[$i]".$count, $apelacion[apelacion]);
            $i++;
            $objPHPExcel->getActiveSheet()->SetCellValue("$columns[$i]".$count, $apelacion[fecha]);
            $i = $i + 2;
        }
        $objPHPExcel->getActiveSheet()->SetCellValue("$columns[17]".$count, $row["propuestas"][propuesta]);
        $objPHPExcel->getActiveSheet()->SetCellValue("$columns[18]".$count, $row["propuestas"][fecha]);
        $count++;
    }
    
    //$objPHPExcel->getActiveSheet()->getStyle('B1:B'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 

    //Titulo del libro y seguridad 
    $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    $objPHPExcel->getSecurity()->setLockWindows(true);
    $objPHPExcel->getSecurity()->setLockStructure(true);
    
    
    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=reporte_reclamos_al_$fecha.xlsx ");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
    
   ob_clean();
   flush();
   //readfile($fichero);
   $objWriter->save('php://output');   
    
     
   exit;
}

function eliminar_evaluacion_stakeholder($idevaluacion, $idmodulo_evaluacion) {
    $greclamo = new greclamo();
    $respuesta = $greclamo->eliminar_evaluacion($idevaluacion, $idmodulo_evaluacion);

    if ($respuesta == 0) {
  
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " de la evaluacion ");
      
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " de la evaluacion ");
    }

    echo json_encode($data);
}


?>

