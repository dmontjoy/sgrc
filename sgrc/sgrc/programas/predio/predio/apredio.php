<?php

include_once '../../include_utiles.php';
include_once '../../../programas/mensajes.php';
include_once '../../../informacion/predio/class.ipredio.php';
include_once '../../../informacion/interaccion/class.iinteraccion.php';

include_once '../../../gestion/predio/class.gpredio.php';

include_once '../../../informacion/interaccion/class.iinteraccion_tipo.php';
include_once '../../../informacion/interaccion/class.iinteraccion_estado.php';
include_once '../../../informacion/stakeholder/class.istakeholder.php';
include_once '../../../informacion/predio/class.ipredio_tipo_tenencia.php';
include_once '../../../programas/tag/tag/ver_tag.php';
include_once '../../../programas/stakeholder/stakeholder/abusca_rapida_sh.php';
include_once '../../../gestion/stakeholder/class.gstakeholder.php';

include_once '../../../informacion/compromiso/class.icompromiso_estado.php';
include_once '../../../informacion/compromiso/class.icompromiso_prioridad.php';
include_once '../../../informacion/compromiso/class.icompromiso.php';
include_once '../../../programas/stakeholder/stakeholder/astakeholder_interaccion.php';
include_once '../../../informacion/mapa/class.imapa.php';
include_once '../../../programas/predio/predio/apredio_mapa.php';

$ayudante = new Ayudante();
$op_predio = $_REQUEST["op_predio"];
$idpredio=$_REQUEST["idpredio"];
$idmodulo_predio=$_REQUEST["idmodulo_predio"];
$busca_rapida_tag=$_REQUEST["busca_rapida_tag"];
$idtag_entidad=$_REQUEST["idtag_entidad"];
$idpredio_tipo_tenencia=$_REQUEST["idpredio_tipo_tenencia"];
$idpredio_proceso_pasos=$_REQUEST["idpredio_proceso_pasos"];

$idpredio_complejo_tag=$_REQUEST["idpredio_complejo_tag"]; //los tag de buscar
$idpredio_sh_complejo=$_REQUEST["idpredio_sh_complejo"];
$codigo_predio=$_REQUEST["codigo_predio"];
$buscar_predio_sh=$_REQUEST["buscar_predio_sh"];

/*****/
    
$interaccion = $_REQUEST[interaccion];

$inicio = $_REQUEST[inicio];
$fecha_interaccion = $_REQUEST[fecha_interaccion];
$idinteraccion_estado = $_REQUEST[idinteraccion_estado];
$idinteraccion_tipo = $_REQUEST[idinteraccion_tipo];
$idinteraccion_prioridad = $_REQUEST[idinteraccion_prioridad];
//$prioridades = $_REQUEST['prioridades'];
//$tipos = $_REQUEST['tipos'];
//$fecha_del = $_REQUEST['fecha_del'];
//$fecha_al = $_REQUEST['fecha_al'];

$orden_complejo_tag = $_REQUEST[orden_complejo_tag];

$idinteraccion = $ayudante->caracter($_REQUEST['idinteraccion']);
$idmodulo_interaccion = $_REQUEST['idmodulo_interaccion'];
$idinteraccion_complejo_tag = $_REQUEST[idinteraccion_complejo_tag];
$idinteraccion_complejo_rc = $_REQUEST[idinteraccion_complejo_rc];
$idinteraccion_complejo_sh = $_REQUEST[idinteraccion_complejo_sh];
$idinteraccion_archivo = $_REQUEST[idinteraccion_archivo];
$comentario_interaccion = $ayudante->caracter($_REQUEST[comentario_interaccion]);

//$ruta = $_REQUEST['ruta'];
//$programa = $_REQUEST['programa'];


/***Predio_sh**/
$idpredio_sh_compuesto=$_REQUEST[idpredio_sh_compuesto];
$idpredio_sh=$_REQUEST[idpredio_sh];
$idmodulo_predio_sh=$_REQUEST[idmodulo_predio_sh];
$idpredio_archivo=$_REQUEST[idpredio_archivo];
//print_r($idpredio_archivo);exit;
/***Predio datum**/
$predio_datum=$_REQUEST[predio_datum];
$predio_comentario=$_REQUEST[predio_comentario];
$predio_direccion=$_REQUEST[predio_direccion];

///actualizar pasos

$idpredio_proceso_pasos_complejo=$_REQUEST[idpredio_proceso_pasos_complejo];
//echo "ver ". $idpredio_proceso_pasos_complejo;
$idpredio_tipo_tenencia_complejo=$_REQUEST[idpredio_tipo_tenencia_complejo];

if (!$seguridad->verificaSesion()) {
   $mensaje = "Ingrese su usuario y contraseña";
   header("Location: ../../../index.php?mensaje=$mensaje");
}

switch ($op_predio) {
    case "ver_interaccion_predio":ver_interaccion_predio($idpredio,$idmodulo_predio);
        break;
    case "ver_buscar_predio":ver_buscar_predio();
        break;
    case "ver_editar_ficha_predio":ver_editar_ficha_predio($idpredio,$idmodulo_predio);
        break;
    case "ver_editar_predio_sh":ver_editar_predio_sh($idpredio,$idmodulo_predio);
        break;
    case "ver_editar_predio_datos":ver_editar_predio_datos($idpredio,$idmodulo_predio);
        break;
    case "actualizar_predio_datum":actualizar_predio_datum($idpredio,$idmodulo_predio,$predio_datum,$idpredio_archivo,$predio_comentario,$predio_direccion);
        break;
    case "buscar_predio":buscar_predio($codigo_predio,$idpredio_complejo_tag,$idpredio_sh_complejo,$idpredio_tipo_tenencia,$idpredio_proceso_pasos);
        break;
    case "ver_tag":ver_tag($busca_rapida_tag,$idtag_entidad);
        break;
    case "busqueda_rapida_stakeholder":busqueda_rapida_stakeholder($buscar_predio_sh);
        break;
    case "guardar_interaccion_predio":guardar_interaccion_stakeholder('', '', $interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $idinteraccion_complejo_tag, $idinteraccion_prioridad, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $comentario_interaccion, $orden_complejo_tag,$idpredio,$idmodulo_predio);
        break;
    case "ver_interaccion_predio_complejo":ver_interaccion_stakolder_complejo('', '', $idinteraccion, $idmodulo_interaccion, $persona, $presenta,1);
        break;
    case "actualizar_interaccion_predio":actualizar_interaccion_stakeholder($idinteraccion, $idmodulo_interaccion, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $idinteraccion_archivo, $comentario_interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $idinteraccion_prioridad, $interaccion, $idpersona, $idmodulo, $persona, $presenta, $orden_complejo_tag,1);
     break;
    case "exportar_pdf_interaccion":exportar_pdf_interaccion($idinteraccion,$idmodulo_interaccion);
        break;
    case "guardar_predio_sh":guardar_predio_sh($idpredio, $idmodulo_predio, $idpredio_sh_compuesto);
        break;
    case "eliminar_predio_sh":eliminar_predio_sh($idpredio_sh,$idmodulo_predio_sh);
        break;
    case "ver_editar_predio_tag":ver_editar_predio_tag($idpredio, $idmodulo_predio);
        break;
    case "guardar_predio_tag":guardar_predio_tag($idpredio_complejo_tag, $orden_complejo_tag, $idpredio, $idmodulo_predio);
        break;
    case "ver_tag_predio":ver_tag_predio($idpredio, $idmodulo_predio);
        break;
    case "editar_proceso_pasos":editar_proceso_pasos($idpredio,$idmodulo_predio,$idpredio_proceso_pasos_complejo);
        break;
    case "editar_predio_tipo_tenencia":editar_predio_tipo_tenencia($idpredio_tipo_tenencia_complejo);
        break;
    case "ver_editar_predio_mapa":ver_editar_predio_mapa($idpredio,$idmodulo_predio);
        break;
}

function ver_editar_predio_mapa($idpredio,$idmodulo_predio){
   $seguridad = new Seguridad();

    $plantilla = new DmpTemplate("../../../plantillas/predio/predio/predio_mapa.html");
    
    $plantilla->reemplaza("idpredio", $idpredio);
    $plantilla->reemplaza("idmodulo_predio", $idmodulo_predio);
    $plantilla->iniciaBloque("asignar_predio_stakeholder");       
    
    
    $ipredio = new ipredio();
    
    $apredio = $ipredio->lista_predio_gis($idpredio, $idmodulo_predio, $idmapa);

    $num=0;
    foreach ($apredio['idpredio'] as $key => $predio) {

        //stakeholder
        $num++;
        $plantilla->iniciaBloque("detalle_predio");
        $plantilla->reemplazaEnBloque('idpredio', $key, "detalle_predio");        
        $plantilla->reemplazaEnBloque('numero', $num, "detalle_predio");
        $plantilla->reemplazaEnBloque('nombre_predio', $predio, "detalle_predio");
        
        $fid_string=' ';
        $aux=0;
        //print_r($apredio['idgis_item']);
        foreach ( $apredio['idgis_item_predio'][$key] as $item_key => $idgis_item){
            //echo $idgis_item;
            $aux++;
            $fid_string.="$idgis_item";
            if($aux<count($apredio['idgis_item_predio'][$key])){
                $fid_string.=",";
            }
        }
        
        $plantilla->reemplazaEnBloque('fid_string', $fid_string, "detalle_predio");

        
        //imagenes
       /* if (sizeof($apredio['archivo'][$key]) > 0) {

                foreach ($apredio['archivo'][$key] as $archivo_key => $archivo) {
                    $thumbfile  = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."predio".DIRECTORY_SEPARATOR."thumbnail".DIRECTORY_SEPARATOR.$key.'_'.$archivo;
                    $thumb = new thumb();
                    if($thumb->loadImage($thumbfile)){
                        $plantilla->iniciaBloque("imagen");
                        $plantilla->reemplazaEnBloque("proyecto", $_SESSION['proyecto'], "imagen");
                        $plantilla->reemplazaEnBloque("archivo", $key.'_'.$archivo, "imagen");
                        $plantilla->reemplazaEnBloque("nombre", $archivo, "imagen");
                    }

                    
                }
            }
            
            $archivos = array();
            
            if (sizeof($apredio['archivo'][$key]) > 0) {

                foreach ($apredio['archivo'][$key] as $archivo_key => $archivo) {
                    $thumbfile  = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."predio".DIRECTORY_SEPARATOR."thumbnail".DIRECTORY_SEPARATOR.$key.'_'.$archivo;
                    $thumb = new thumb();
                    if(!$thumb->loadImage($thumbfile)){
                        $archivos[] = $key.'_'.$archivo;                        
                    }                    
                }
                $aux = 0;
                foreach ( $archivos as $archivo){
                    $aux++;
                    $plantilla->iniciaBloque("archivo");
                    $plantilla->reemplazaEnBloque("archivo", $archivo , "archivo");
                    if($aux<count($archivos)){
                        $plantilla->reemplazaEnBloque("coma", " , " , "archivo");
                    }
                }
            }
            
            */
             

    }
    $fid_string=' ';
    $aux=0;
    //print_r($apredio['idgis_item']);
    foreach ( $apredio['idgis_item'] as $key => $idgis_item){
        //echo $idgis_item;
        $aux++;
        $fid_string.="$idgis_item";
        if($aux<count($apredio['idgis_item'])){
            $fid_string.=",";
        }
    }
    
    $plantilla->reemplazaEnBloque('fid_string', $fid_string, "detalle_predio");
        
    $plantilla->reemplaza("ver_mapa", ver_buscar_mapa($fid_string,0,$idmapa));

    $plantilla->presentaPlantilla();    
    
}

function ver_interaccion_predio($idpredio,$idmodulo_predio){
    
    $seguridad = new Seguridad();
    $plantilla = new DmpTemplate("../../../plantillas/predio/interaccion/interaccion.html");
    $plantilla->reemplaza("idpredio", $idpredio);
    $plantilla->reemplaza("idmodulo_predio", $idmodulo_predio);
    if(!$seguridad->verifica_permiso("Crear", "Interaccion"))
            $plantilla->iniciaBloque ("crear_interaccion");

    $plantilla_interaccion = new DmpTemplate("../../../plantillas/predio/interaccion/bloque_interaccion.html");

    //$plantilla->reemplaza("persona", $persona);

    $plantilla->iniciaBloque("tr_rc_interaccion");
        $plantilla->iniciaBloque("td_rc_interaccion");
        $plantilla->reemplazaEnBloque("rc", $_SESSION[apellido_p] . " " . $_SESSION[apellido_m] . ", " . $_SESSION[nombre], "td_rc_interaccion");
        $plantilla->reemplazaEnBloque("celda_nume_fila_rc", 1, "td_rc_interaccion");
        $plantilla->reemplazaEnBloque("celda_nume_celda_rc", 1, "td_rc_interaccion");
        
        $plantilla->reemplaza("cant_rc", 1);

        $plantilla->iniciaBloque("idinteraccion_complejo_rc");
        $plantilla->reemplazaEnBloque("idinteraccion_complejo_rc", $_SESSION[idpersona] . "---" . $_SESSION[idmodulo_persona], "idinteraccion_complejo_rc");
        $plantilla->reemplazaEnBloque("celda_nume_fila_rc", 1, "idinteraccion_complejo_rc");
        $plantilla->reemplazaEnBloque("celda_nume_celda_rc", 1, "idinteraccion_complejo_rc");
        
        $plantilla->iniciaBloque("eliminar_rc_interaccion");
        $plantilla->reemplazaEnBloque("celda_nume_fila_rc", 1, "eliminar_rc_interaccion");
        $plantilla->reemplazaEnBloque("celda_nume_celda_rc", 1, "eliminar_rc_interaccion");

        for ($cont_rc_celda = 2; $cont_rc_celda <= 5; $cont_rc_celda++) {
            $plantilla->iniciaBloque("td_rc_interaccion");
            $plantilla->reemplazaEnBloque("rc", "&nbsp;", "td_rc_interaccion");
            $plantilla->reemplazaEnBloque("celda_nume_fila_rc", 1, "td_rc_interaccion");
            $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "td_rc_interaccion");
        }
                 
    $ipredio=new ipredio();
     
    $result_predio = $ipredio->lista_predio($idpredio, $idmodulo_predio);
    $fila_sh = mysql_fetch_array($result_predio);
    
    $plantilla->iniciaBloque("tr_sh_interaccion");
   
     foreach ($result_predio['sh'][$idpredio."***".$idmodulo_predio] as $idcompuesto_persona => $persona){
            list($idsh,$idmodulo_sh)=explode("***",$idcompuesto_persona);
            $plantilla->iniciaBloque("td_sh_interaccion");
            $plantilla->reemplazaEnBloque("sh", $persona, "td_sh_interaccion");
            $plantilla->reemplazaEnBloque("idsh", $idsh, "td_sh_interaccion");
            $plantilla->reemplazaEnBloque("idmodulo", $idmodulo_sh, "td_sh_interaccion");
            $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_interaccion");
            $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_interaccion");
            
            $plantilla->reemplaza("cant_sh", 1);

            $plantilla->iniciaBloque("idinteraccion_complejo_sh");

            $plantilla->reemplazaEnBloque("idinteraccion_complejo_sh", $idsh . "---" . $idmodulo_sh, "idinteraccion_complejo_sh");
            $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "idinteraccion_complejo_sh");
            $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "idinteraccion_complejo_sh");
            
            $plantilla->iniciaBloque("eliminar_sh_interaccion");
            //***1 el estado activo, al cambiar a 0, el estado desactivo

            $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "eliminar_sh_interaccion");
            $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "eliminar_sh_interaccion");

            for ($cont_sh_celda = 2; $cont_sh_celda <= 5; $cont_sh_celda++) {
                $plantilla->iniciaBloque("td_sh_interaccion");
                $plantilla->reemplazaEnBloque("sh", "&nbsp;", "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_interaccion");
            }

            $plantilla->reemplaza("nume_fila_interaccion_sh_complejo", 1);
            $plantilla->reemplaza("nume_celda_interaccion_sh_complejo", 2);
     }  
            
    $plantilla->reemplaza("maximo", 2);

    $plantilla->reemplaza("fecha_interaccion", date('d/m/Y'));
    //echo "idinteraccion".$idinteraccion." idmodulo".$idmodulo_interaccion;


    $iinteraccion_estado = new iinteraccion_estado();

    $result_interaccion_estado = $iinteraccion_estado->lista_interaccion_estado();

    while (!!$fila = mysql_fetch_array($result_interaccion_estado)) {

        $plantilla->iniciaBloque("interaccion_estado");
        $plantilla->reemplazaEnBloque("idinteraccion_estado", $fila[idinteraccion_estado], "interaccion_estado");
        $plantilla->reemplazaEnBloque("interaccion_estado", $fila[interaccion_estado], "interaccion_estado");
    }

    $iinteraccion_tipo = new iinteraccion_tipo();

    $result_interaccion_tipo = $iinteraccion_tipo->lista_interaccion_tipo();

    while (!!$fila = mysql_fetch_array($result_interaccion_tipo)) {

        $plantilla->iniciaBloque("interaccion_tipo");
        $plantilla->reemplazaEnBloque("idinteraccion_tipo", $fila[idinteraccion_tipo], "interaccion_tipo");
        $plantilla->reemplazaEnBloque("interaccion_tipo", utf8_encode($fila[interaccion_tipo]), "interaccion_tipo");
    }
    //listar interaccion stakeholder
    //he puesto 0 despues de 50. En ese lugar estaba $persona, que lo utilizo como nombre de variable en el bucle
    $plantilla_interaccion = ver_bloque_interaccion_predio( $fila_sh[idpersona_tipo],$fila_sh[apellido_p] . " " . $fila_sh[apellido_m] . ", " . $fila_sh[nombre] ,$idpersona, $idmodulo, 50, 0, $presenta,0,'',$idpredio,$idmodulo_predio);

    $plantilla->reemplaza("tabla_interaccion", $plantilla_interaccion);

    if ($presenta == 0) {
        $plantilla->presentaPlantilla();
    } else {
        return $plantilla->getPlantillaCadena();
    }
}

function ver_bloque_interaccion_predio($idpersona_tipo,$nombre,$idpersona, $idmodulo, $inicio, $persona = 0, $presenta, $modo,$idsh_compuesto,$idpredio='',$idmodulo_predio='') {
    // $presenta = 1;
    //$tabla_interaccion = 1;
    //persona 2 ve las interacciones del relacionista comunitario, usuario
    //persona 1 ve las interacciones del stakeholder
    //con cuerpo, si incluye los div y la tabla de interaccion
    //por defecto modo 0, depende donde se muestren los datos; en modo cargo los datos de idperson y idmodulo de la session
    //echo "nombre : $nombre";
    //echo "predio".$idpredio;
    //echo "modulo_predio".$idmodulo_predio;
    /*echo "persona ".$persona;

    echo "modo : $modo";
    echo "valor presenta".$presenta;*/
    $seguridad = new Seguridad();

    $plantilla = new DmpTemplate("../../../plantillas/predio/interaccion/bloque_interaccion.html");
    $plantilla_tabla = new DmpTemplate("../../../plantillas/predio/interaccion/tabla_interaccion.html");
    $flag=false;
    
    if(!is_array($idsh_compuesto) && count($idsh_compuesto)==0){
        $idsh_compuesto=array();
        $flag=true;
    }
    
    //listar interaccion stakeholder
    $istakeholder = new istakeholder();
    //depende si estoy en la pantalla principal o vengo de organizaciones
    if($seguridad->verifica_permiso("Ver", "Inicio-Interacciones") && $modo==1 ){
        $ainteraccion = $istakeholder->lista_stakeholder_interaccion($idpersona, $idmodulo, $inicio, 0);
    }elseif( $modo==2){
        $ipersona = new ipersona();
        $result = $ipersona->lista_organizacion_sh($idpersona, $idmodulo);
        $count=0;
        while($fila=  mysql_fetch_array($result)){
            //print_r($fila);
            if($fila['idpersona_tipo']>1){
                $datos['sh'][$count]['level']=0;
                $datos['sh'][$count]['sh']=  utf8_encode($fila['apellido_p']);
                $id=$fila['idpersona'].'-'.$fila['idmodulo'];
                $valor=$id;
            }else{
                $id=$fila['idpersona'].'-'.$fila['idmodulo'].'-'.$fila['idorganizacion'].'-'.$fila['idmodulo_organizacion'];
                $valor=$fila['idpersona'].'-'.$fila['idmodulo'];
            }
            
            $datos['sh'][$count]['id']=$id;
            
            $datos['sh'][$count]['sh']=  utf8_encode($fila['apellido_p']." ".$fila['apellido_m']." ".$fila['nombre']);
            $datos['sh'][$count]['check']=  "<input id=\"$id\" type=\"checkbox\" name=\"shs[]\"  value=\"$valor\" class=\"$valor\" onclick=\"actualiza_estado_sh('$id')\" checked /><input id=\"id$id\" type=\"hidden\"   value=\"$valor\" name=\"idsh_compuesto[]\" />";
            $datos['sh'][$count]['level']=1;
            
            $datos['sh'][$count]['loaded']=true;
            $datos['sh'][$count]['parent']=null;
            if($datos['sh'][$count]['level']>0){
                $datos['sh'][$count]['parent']=$fila['idorganizacion'].'-'.$fila['idmodulo_organizacion'];
                //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
            }
            $datos['sh'][$count]['isLeaf']=true;
            $datos['sh'][$count]['expanded']=false;        
            if($fila['idpersona_tipo']>1){
                $datos['sh'][$count]['isLeaf']=false;
                $datos['sh'][$count]['expanded']=true;            
            }
            if($flag){
                $idsh_compuesto[]=$valor;                
            }
            $count++;
        }
         
        $ainteraccion = $istakeholder->lista_stakeholder_interaccion($idpersona, $idmodulo, $inicio, 0, $idsh_compuesto);
    }else{
        //modo 0, cuando es predio entra
        $ainteraccion = $istakeholder->lista_stakeholder_interaccion($idpersona, $idmodulo, $inicio, $persona,"",$idpredio,$idmodulo_predio);
    }
    //lo cambio para ordenarlo
    if (sizeof($ainteraccion[interaccion]) > 0) {
        
        $numero = 0;

        foreach ($ainteraccion[interaccion] as $key => $interaccion) {
            
            $numero++;

            $plantilla->iniciaBloque("item_interaccion");
            /*
            if (strlen($interaccion) > 400) {

                $interaccion = substr($interaccion, 0, 400) . "......";
            }
             * 
             */
            $plantilla->reemplazaEnBloque("fecha_interaccion", $ainteraccion[fecha][$key], "item_interaccion");
            $plantilla->reemplazaEnBloque("numero", $numero, "item_interaccion");
            $plantilla->reemplazaEnBloque("interaccion", $interaccion, "item_interaccion");
            

            $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "item_interaccion");
            //echo "iddd".$ainteraccion[idinteraccion][$key];
            $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "item_interaccion");
            $plantilla->reemplazaEnBloque("persona", $persona, "item_interaccion");
            //$plantilla->reemplazaEnBloque("tabla_interaccion", $tabla_interaccion, "item_interaccion");
            if($seguridad->verifica_permiso("Crear", "Compromiso")){
                $plantilla->iniciaBloque("crear_compromiso");
                $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "crear_compromiso");
                //echo "Editar ". " Interaccion ". $ainteraccion[idusu_c][$key] ." , ". $ainteraccion[idmodulo_c][$key];
                $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "crear_compromiso");
                
            }
            
            if($seguridad->verifica_permiso("Editar", "Interaccion", $ainteraccion[idusu_c][$key], $ainteraccion[idmodulo_c][$key])){
                $plantilla->iniciaBloque("editar_interaccion");
                $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "editar_interaccion");
                //echo "Editar ". " Interaccion ". $ainteraccion[idusu_c][$key] ." , ". $ainteraccion[idmodulo_c][$key];
                $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "editar_interaccion");
                $plantilla->reemplazaEnBloque("persona", $persona, "editar_interaccion");
            }
            
            if($seguridad->verifica_permiso("Eliminar", "Interaccion", $ainteraccion[idusu_c][$key], $ainteraccion[idmodulo_c][$key])){
                $plantilla->iniciaBloque("eliminar_interaccion");
                $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "eliminar_interaccion");                
                $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "eliminar_interaccion");
                
            }
            
            
            //imagenes
            if (sizeof($ainteraccion['archivo'][$key]) > 0) {

                foreach ($ainteraccion['archivo'][$key] as $archivo_key => $archivo) {
                    $thumbfile  = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."interaccion".DIRECTORY_SEPARATOR."thumbnail".DIRECTORY_SEPARATOR.$ainteraccion[idinteraccion][$key].'_'.$archivo;
                    $thumb = new thumb();
                    if($thumb->loadImage($thumbfile)){
                        $plantilla->iniciaBloque("imagen");
                        $plantilla->reemplazaEnBloque("proyecto", $_SESSION['proyecto'], "imagen");
                        $plantilla->reemplazaEnBloque("archivo", $ainteraccion[idinteraccion][$key].'_'.$archivo, "imagen");
                        $plantilla->reemplazaEnBloque("nombre", $archivo, "imagen");
                    }

                    
                }
            }
            
            $archivos = array();
            //archivos
            if (sizeof($ainteraccion['archivo'][$key]) > 0) {

                foreach ($ainteraccion['archivo'][$key] as $archivo_key => $archivo) {
                    $thumbfile  = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."interaccion".DIRECTORY_SEPARATOR."thumbnail".DIRECTORY_SEPARATOR.$ainteraccion[idinteraccion][$key].'_'.$archivo;
                    $thumb = new thumb();
                    if(!$thumb->loadImage($thumbfile)){
                        $archivos[] = $ainteraccion[idinteraccion][$key].'_'.$archivo;                        
                    }                    
                }
                $aux = 0;
                foreach ( $archivos as $archivo){
                    $aux++;
                    $plantilla->iniciaBloque("archivo");
                    $plantilla->reemplazaEnBloque("archivo", $archivo , "archivo");
                    if($aux<count($archivos)){
                        $plantilla->reemplazaEnBloque("coma", " , " , "archivo");
                    }
                }
            }
             
             
            
            $cant = sizeof($ainteraccion['idcompromiso'][$key]);
            $count=0;
            if ( $cant > 0) {

                foreach ($ainteraccion['compromiso'][$key] as $compromiso_key => $compromiso) {
                    $count++;

                    $plantilla->iniciaBloque("item_compromiso");
                    if($count>1){
                        $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "item_compromiso");
                        $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "item_compromiso");
                        $plantilla->reemplazaEnBloque("estilo", "display:none;","item_compromiso");
                    }
                    $plantilla->reemplazaEnBloque("fecha_compromiso", $ainteraccion['fecha_compromiso'][$key][$compromiso_key], "item_compromiso");
                    $plantilla->reemplazaEnBloque("compromiso", $compromiso, "item_compromiso");
                    $plantilla->reemplazaEnBloque("idcompromiso", $ainteraccion['idcompromiso'][$key][$compromiso_key], "item_compromiso");
                    $plantilla->reemplazaEnBloque("idmodulo_compromiso", $ainteraccion['idmodulo_compromiso'][$key][$compromiso_key], "item_compromiso");
                    if($seguridad->verifica_permiso("Editar", "Compromiso", $ainteraccion['compromiso_idusu_c'][$key][$compromiso_key], $ainteraccion['compromiso_idmodulo_c'][$key][$compromiso_key])){
                        $plantilla->iniciaBloque("editar_compromiso");
                        $plantilla->reemplazaEnBloque("idcompromiso", $ainteraccion['idcompromiso'][$key][$compromiso_key], "editar_compromiso");
                        $plantilla->reemplazaEnBloque("idmodulo_compromiso", $ainteraccion['idmodulo_compromiso'][$key][$compromiso_key], "editar_compromiso");
                    }
                    
                    if($seguridad->verifica_permiso("Eliminar", "Compromiso", $ainteraccion['compromiso_idusu_c'][$key][$compromiso_key], $ainteraccion['compromiso_idmodulo_c'][$key][$compromiso_key])){
                        $plantilla->iniciaBloque("eliminar_compromiso");
                        $plantilla->reemplazaEnBloque("idcompromiso", $ainteraccion['idcompromiso'][$key][$compromiso_key], "eliminar_compromiso");
                        $plantilla->reemplazaEnBloque("idmodulo_compromiso", $ainteraccion['idmodulo_compromiso'][$key][$compromiso_key], "eliminar_compromiso");
                    }
                }
                
            }
            
            $plantilla->iniciaBloque("menu_compromiso");
            $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "menu_compromiso");
            $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "menu_compromiso");
            if($count>1){
                $plantilla->iniciaBloque("boton_ocultar");
                $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "boton_ocultar");
                $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "boton_ocultar");
            }
                

            //RC
            if (sizeof($ainteraccion['rc'][$key]) > 0) {

                $aux=0;
                foreach ($ainteraccion['rc'][$key] as $rc_key => $rc) {
                    if($rc_key=="$idpersona-$idmodulo"){
                        $nombre=$rc;
                    }
                    $aux++;
                    $plantilla->iniciaBloque("rc_interaccion");
                    $plantilla->reemplazaEnBloque("rc", $rc, "rc_interaccion");
                    if($aux<sizeof($ainteraccion['rc'][$key])-1){
                        $plantilla->reemplazaEnBloque("coma", " , ", "rc_interaccion");
                    }elseif($aux==sizeof($ainteraccion['rc'][$key])-1){
                        $plantilla->reemplazaEnBloque("coma", " y ", "rc_interaccion");
                    }else{
                        $plantilla->reemplazaEnBloque("coma", ".", "rc_interaccion");
                    }
                }
            }
            ///sh
            if (sizeof($ainteraccion['sh'][$key]) > 0) {

                foreach ($ainteraccion['sh'][$key] as $sh_key => $sh) {
                    //echo "sh: $sh";
                    $tokens = preg_split("/[-]+/", $sh);
                    $plantilla->iniciaBloque("sh_interaccion");
                    $plantilla->reemplazaEnBloque("idsh", $tokens[0], "sh_interaccion");
                    $plantilla->reemplazaEnBloque("idmodulo", $tokens[1], "sh_interaccion");
                    $plantilla->reemplazaEnBloque("sh", $tokens[2], "sh_interaccion");
                    
                    $plantilla->reemplazaEnBloque("idpersona_tipo", $tokens[3], "sh_interaccion");
                    if($tokens[4]!=""){
                        $plantilla->reemplazaEnBloque("imagen", "../../../archivo/".$_SESSION['proyecto']."/imagen/".$tokens[4], "sh_interaccion");
                    }else{
                        $plantilla->reemplazaEnBloque("imagen", "../../../img/imagen.png", "sh_interaccion");
                    }
                }
            }
        }
    }
    //echo "tabla in" . $tabla_interaccion;
    if ($persona < 3) {
        
        $plantilla_tabla->reemplaza("bloque_interaccion", $plantilla->getPlantillaCadena());
       
        if($modo==1){
            $plantilla_tabla->iniciaBloque("enlaces");
            //´plkk$plantilla_tabla->reemplazaEnBloque("nombre", $nombre, "enlaces");
            $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona, "enlaces");
            $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo, "enlaces");
            if($seguridad->verifica_permiso("Crear", "Interaccion"))
                $plantilla_tabla->iniciaBloque ("crear_interaccion");
            /*
             if($seguridad->verifica_permiso("Crear", "Reclamo"))
                $plantilla_tabla->iniciaBloque ("crear_reclamo");
             * 
             */
        }else{
            $plantilla_tabla->reemplaza("titulo", "Interacciones");
            $plantilla_tabla->iniciaBloque("ver_organizacion");            
            $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona, "ver_organizacion");
            $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo, "ver_organizacion");
            $plantilla_tabla->reemplazaEnBloque("idpersona_tipo", $idpersona_tipo, "ver_organizacion");
            
        }
        
        //echo "numero $numero total $ainteraccion[total]";
        
         if($numero > 0){
             $plantilla_tabla->reemplaza("numero", $numero);
             $plantilla_tabla->reemplaza("de", "de");
             $plantilla_tabla->reemplaza("total", $ainteraccion['total'] );
            if($numero < $ainteraccion['total']){
         
                $plantilla_tabla->iniciaBloque("ver_mas");
                $plantilla_tabla->reemplazaEnBloque("inicio", $inicio + 10,"ver_mas");
                //$plantilla_tabla->reemplazaEnBloque("nombre", $nombre, "ver_mas");
                $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona , "ver_mas");
                $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo , "ver_mas");
                $plantilla_tabla->reemplazaEnBloque("persona", $persona , "ver_mas"); // ver mas
                $plantilla_tabla->reemplazaEnBloque("presenta", 1, "ver_mas"); // ver mas
                $plantilla_tabla->reemplazaEnBloque("modo", $modo, "ver_mas"); // ver mas
            }
        }
        
        if($numero==0){
            $plantilla_tabla->iniciaBloque("mensaje");
        }
        
        $plantilla = $plantilla_tabla;
    }


    if ($presenta == 1) {
        $plantilla->presentaPlantilla();
    }elseif($presenta == 2){
        $datos["html"] = $plantilla->getPlantillaCadena();
        echo json_encode($datos);
    }else {
        return $plantilla->getPlantillaCadena();
    }
}
    
    


function ver_buscar_predio(){
    $plantilla = new DmpTemplate('../../../plantillas/predio/predio/ver_buscar_predio.html');
    $apredio_tipo_tenencia=new ipredio_tipo_tenencia();
    $ipredio=new ipredio();
    
    $result=$apredio_tipo_tenencia->lista();
           
    while (!!$fila = mysql_fetch_array($result)) {
        $plantilla->iniciaBloque("bloque_predio_tipo_tenencia");
        $plantilla->reemplazaEnBloque("idpredio_tipo_tenencia", $fila[idpredio_tipo_tenencia], "bloque_predio_tipo_tenencia");
        $plantilla->reemplazaEnBloque("predio_tipo_tenencia", $fila[descripcion], "bloque_predio_tipo_tenencia");
    }
    
     $result_lista_predio_proceso_pasos=$ipredio->lista_predio_proceso_pasos();

    while (!!$fila = mysql_fetch_array($result_lista_predio_proceso_pasos)) {
        $plantilla->iniciaBloque("bloque_predio_proceso_pasos");
        $plantilla->reemplazaEnBloque("predio_proceso_pasos", $fila[predio_proceso_pasos], "bloque_predio_proceso_pasos");
        $plantilla->reemplazaEnBloque("idpredio_proceso_pasos", $fila[idpredio_proceso_pasos], "bloque_predio_proceso_pasos");

    }
    
    $plantilla->presentaPlantilla();     
    
}

function buscar_predio($codigo_predio,$idpredio_complejo_tag,$idpredio_sh_complejo,$idpredio_tipo_tenencia,$idpredio_proceso_pasos){
    $ipredio = new ipredio();    
    //echo "predio tipo".$idpredio_tipo_tenencia;
    $aresult= $ipredio->lista_predio('','',$codigo_predio,$idpredio_complejo_tag,$idpredio_sh_complejo,$idpredio_tipo_tenencia,$idpredio_proceso_pasos);
    $cont=0;
    $adata=array();
    if(sizeof($aresult['nombre_predio'])){
        foreach($aresult['nombre_predio'] as $id => $value){
            $adata["data"][$cont]["id"]=utf8_encode($id);

            $adata["data"][$cont]["num"]=utf8_encode($cont);
            //$adata["data"][]=array("id"=>utf8_encode($id),"num"=>utf8_encode($cont));


            $adata["data"][$cont][nombre_predio]=utf8_encode($value);

            $adata["data"][$cont][direccion]=utf8_encode($aresult['direccion'][$id]);

            $adata["data"][$cont][sh]="";
            /****SH**/
            foreach($aresult['sh'][$id] as $idsh => $value_sh){
                $adata["data"][$cont][sh].=utf8_encode("$value_sh").", ";
            }
            if( strlen($adata["data"][$cont][sh])>0){
                $adata["data"][$cont][sh]=substr($adata["data"][$cont][sh], 0,  strlen($adata["data"][$cont][sh])-2);
            }

            /***TAG**/  

            $adata["data"][$cont][tag]="";
            foreach($aresult['tag'][$id] as $idtag => $value_tag){
                $adata["data"][$cont][tag].=utf8_encode($value_tag).", ";
            }
            if( strlen($adata["data"][$cont][tag])>0){
                $adata["data"][$cont][tag]=substr($adata["data"][$cont][tag], 0,  strlen($adata["data"][$cont][tag])-2);
            }

            /********/

            list($idpredio,$idmodulo_predio)=explode('***',$id);

            $adata["data"][$cont][accion]=utf8_encode("<a title='Ver predio' href='javascript:ver_editar_ficha_predio($idpredio,$idmodulo_predio)'><img src='../../../img/serach.png' alt='' title='Ver predio'/>");


            $cont++;
        }
    }
    echo json_encode($adata);
    
}

function ver_editar_predio_datos($idpredio,$idmodulo_predio){
   
    $plantilla = new DmpTemplate('../../../plantillas/predio/predio/ver_editar_predio_datos.html');
    $ipredio=new ipredio();
    $aresult= $ipredio->lista_predio($idpredio,$idmodulo_predio);
    //$result_lista_predio_proceso_pasos=$ipredio->lista_predio_proceso_pasos();
    $predio_sh_num=1;
    foreach($aresult['nombre_predio'] as $id => $value){
           //datos valor

        $plantilla->reemplaza("predio_direccion",  $aresult['direccion'][$id]);
        $plantilla->reemplaza("predio_comentario",  $aresult['predio_comentario'][$id]);

        foreach($aresult['predio_datum_valor'][$id] as $idpredio_datum_valor => $predio_datum_valor){
            
            $plantilla->iniciaBloque("predio_datum");
            
            $plantilla->reemplazaEnBloque("predio_datum_valor",utf8_encode($predio_datum_valor),"predio_datum");
            //$plantilla->reemplazaEnBloque("idpredio_datum_valor",$idpredio_datum_valor,"predio_datum");
            //junto: idpredio_datum_valor / idpredio_datum
            $plantilla->reemplazaEnBloque("idpredio_datum",$aresult['idpredio_datum'][$id][$idpredio_datum_valor]."***".$idpredio_datum_valor,"predio_datum");
            $plantilla->reemplazaEnBloque("predio_datum",utf8_encode($aresult['predio_datum'][$id][$idpredio_datum_valor]),"predio_datum");
            $plantilla->reemplazaEnBloque("simbolo","(".utf8_encode($aresult['simbolo'][$id][$idpredio_datum_valor].")"),"predio_datum");
            //
        }
                        foreach ($apredio['archivo'][$key] as $archivo_key => $archivo) {
                    $thumbfile  = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."predio".DIRECTORY_SEPARATOR."thumbnail".DIRECTORY_SEPARATOR.$key.'_'.$archivo;
                    $thumb = new thumb();
                    if($thumb->loadImage($thumbfile)){
                        $plantilla->iniciaBloque("imagen");
                        $plantilla->reemplazaEnBloque("proyecto", $_SESSION['proyecto'], "imagen");
                        $plantilla->reemplazaEnBloque("archivo", $key.'_'.$archivo, "imagen");
                        $plantilla->reemplazaEnBloque("nombre", $archivo, "imagen");
                    }

                    
                }
//             $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."predio".DIRECTORY_SEPARATOR.$idpredio.'_'.$idmodulo_predio.'_'.$archivo; 
               //$thumbfile  = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."predio".DIRECTORY_SEPARATOR."thumbnail".DIRECTORY_SEPARATOR.$idpredio.'_'.$idmodulo_predio.'_'.$archivo; 
               //$thumbfile  = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."predio".DIRECTORY_SEPARATOR."thumbnail".DIRECTORY_SEPARATOR.$idpredio.'_'.$idmodulo_predio.'_'.$archivo;
                    
//        //archivo
        foreach($aresult['archivo'][$id] as $idpredio_archivo_compuesto => $predio_archivo){
            
            
            $plantilla->iniciaBloque("archivo");
            $aidpredio_archivo=explode('-',$idpredio_archivo_compuesto);
           
            $plantilla->reemplazaEnBloque("idpredio_archivo",$aidpredio_archivo[0],"archivo");
            //$plantilla->reemplazaEnBloque("idpredio_datum_valor",$idpredio_datum_valor,"predio_datum");
            //junto: idpredio_datum_valor / idpredio_datum
            $plantilla->reemplazaEnBloque("idmodulo_predio_archivo",$aidpredio_archivo[1],"archivo");
            $plantilla->reemplazaEnBloque("ruta",$aidpredio_archivo[0].'_'.$aidpredio_archivo[1].'_'.$predio_archivo,"archivo");
            $plantilla->reemplazaEnBloque("archivo",$predio_archivo, "archivo");
            $plantilla->reemplazaEnBloque("activo",1,"archivo");
            //
        }        
        
    }
    

    $plantilla->presentaPlantilla();    
}

function ver_editar_ficha_predio($idpredio,$idmodulo_predio){
    //echo "datos: ".$idpredio." -- ".$idmodulo_predio;
    $plantilla = new DmpTemplate('../../../plantillas/predio/predio/ver_editar_ficha_predio.html');
    $plantilla_tag = new DmpTemplate('../../../plantillas/predio/predio/ver_tag.html');

    $plantilla->reemplaza("idmodulo_predio", $idmodulo_predio);
    $plantilla->reemplaza("idpredio", $idpredio);
    $ipredio = new ipredio();    
    
    $aresult= $ipredio->lista_predio($idpredio,$idmodulo_predio);
    $cont=0;
    
    $result_lista_predio_proceso_pasos=$ipredio->lista_predio_proceso_pasos();
    $predio_sh_num=1;
    foreach($aresult['nombre_predio'] as $id => $value){
        $plantilla->reemplaza("codigo_predio",utf8_encode($value));
        $plantilla->reemplaza("direccion",utf8_encode($aresult['direccion'][$id]));
        $flag_entro=0;
        
        //print_r($aresult['sh']);
        foreach($aresult['sh'][$id] as $idsh => $value_sh){
            
            $plantilla->iniciaBloque("predio_sh");
            $plantilla->reemplazaEnBloque("predio_sh_nombre",utf8_encode($value_sh),"predio_sh");
            $plantilla->reemplazaEnBloque("predio_sh_num",utf8_encode($predio_sh_num),"predio_sh");            
            $plantilla->reemplazaEnBloque("predio_tipo_tenencia",utf8_encode($aresult['tipo_tenencia'][$id][$idsh]),"predio_sh");
            
            mysql_data_seek($result_lista_predio_proceso_pasos, 0);
            while (!!$fila = mysql_fetch_array($result_lista_predio_proceso_pasos)) {
                $plantilla->iniciaBloque("bloque_predio_procesos_pasos");
                //echo $fila[idpredio_proceso_pasos]."<br>";
                //echo $idsh;
                ///                $apredio['idpredio_sh'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]=$fila[idpredio_sh];
                //$apredio['idmodulo_predio_sh'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]=$fila[idmodulo_predio_sh];

                //
                // //$aresult[predio_proceso_pasos][$id][$idsh],$idsh."***".$aresult[idpredio_proceso_pasos][$id][$idsh]
                $plantilla->reemplazaEnBloque("predio_proceso_pasos", $fila[predio_proceso_pasos], "bloque_predio_procesos_pasos");
                $plantilla->reemplazaEnBloque("idpredio_proceso_pasos_complejo", $aresult['idpredio_sh'][$id][$idsh]."***".$aresult['idmodulo_predio_sh'][$id][$idsh]."***".$fila[idpredio_proceso_pasos], "bloque_predio_procesos_pasos");
                //echo "valor".$aresult['idpredio_proceso_pasos'][$id][$idsh];
                if($fila[idpredio_proceso_pasos]== $aresult['idpredio_proceso_pasos'][$id][$idsh]){
                   
                   $plantilla->reemplazaEnBloque("selected","selected","bloque_predio_procesos_pasos"); 
                }
                
            }

            
            
            $predio_sh_num=$predio_sh_num+1;         
        }
        
        $plantilla_tag->iniciaBloque("editar_predio_tag");
        $cont_tag=0;
        foreach($aresult['tag'][$id] as $idtag => $value_tag){
           if($cont_tag%5==0){
              $plantilla_tag->iniciaBloque("tr_tag"); 
           }
            $plantilla_tag->iniciaBloque("td_tag");
            if($flag_entro==0){
                $value_tag=utf8_encode($value_tag);
            }else{
                $value_tag=", ".utf8_encode($value_tag);
            }
            $flag_entro=1;
            $plantilla_tag->reemplazaEnBloque("tag",$value_tag,"td_tag");
            $plantilla_tag->reemplazaEnBloque("prioridad",$aresult['prioridad'][$id][$idtag],"td_tag");
            $cont_tag++;
        }
        $plantilla->reemplaza("tabla_predio_tag", $plantilla_tag->getPlantillaCadena());
        
        foreach($aresult['predio_datum_valor'][$id] as $idpredio_datum_valor => $predio_datum_valor){
            
            $plantilla->iniciaBloque("predio_datum");
            
            $plantilla->reemplazaEnBloque("predio_datum_valor",utf8_encode($predio_datum_valor),"predio_datum");
            $plantilla->reemplazaEnBloque("predio_datum",utf8_encode($aresult['predio_datum'][$id][$idpredio_datum_valor]),"predio_datum");
            $plantilla->reemplazaEnBloque("simbolo","(".utf8_encode($aresult['simbolo'][$id][$idpredio_datum_valor].")"),"predio_datum");

        }

    }

    $plantilla->presentaPlantilla();

}

function ver_editar_predio_sh($idpredio,$idmodulo_predio){
    
  $ipredio = new ipredio();    
  $ipredio_tipo_tenencia = new ipredio_tipo_tenencia();
  $aresult= $ipredio->lista_predio($idpredio,$idmodulo_predio); 
  $plantilla = new DmpTemplate('../../../plantillas/predio/predio/ver_editar_predio_sh.html');
  $plantilla->iniciaBloque("crear_predio_sh");
  $predio_sh_num=1;
  $result_lista_predio_proceso_pasos=$ipredio->lista_predio_proceso_pasos();
  $result_itipo_tenencia=$ipredio_tipo_tenencia->lista();
  foreach($aresult['nombre_predio'] as $id => $value){
     
        foreach($aresult['sh'][$id] as $idsh => $value_sh){
 
             $plantilla->iniciaBloque("predio_sh");
             $aidsh=explode("***",$idsh);
             $plantilla->reemplazaEnBloque("predio_sh_nombre",utf8_encode($value_sh),"predio_sh");
             $plantilla->reemplazaEnBloque("predio_sh_num",utf8_encode($predio_sh_num),"predio_sh");
              $plantilla->reemplazaEnBloque("idmodulo",$aidsh[1],"predio_sh");
             $plantilla->reemplazaEnBloque("idpersona",$aidsh[0],"predio_sh");

             while(!!$fila=  mysql_fetch_array($result_itipo_tenencia)){
                 $plantilla->iniciaBloque("bloque_predio_tipo_tenencia");
                 
                 $plantilla->reemplazaEnBloque("predio_tipo_tenencia",$fila[descripcion],"bloque_predio_tipo_tenencia");
                 $plantilla->reemplazaEnBloque("idpredio_tipo_tenencia_complejo",$aresult['idpredio_sh'][$id][$idsh]."***".$aresult['idmodulo_predio_sh'][$id][$idsh]."***".$fila[idpredio_tipo_tenencia],"bloque_predio_tipo_tenencia");
                 if($fila[idpredio_tipo_tenencia]== $aresult['idpredio_tipo_tenencia'][$id][$idsh]){
                   $plantilla->reemplazaEnBloque("selected","selected","bloque_predio_tipo_tenencia"); 
                }                
                // $plantilla->reemplazaEnBloque("predio_tipo_tenencia",utf8_encode($aresult['tipo_tenencia'][$id][$idsh]),"bloque_predio_tipo_tenencia");

             }
             
             
             
             mysql_data_seek($result_lista_predio_proceso_pasos, 0);
             while (!!$fila = mysql_fetch_array($result_lista_predio_proceso_pasos)) {
                 $plantilla->iniciaBloque("bloque_predio_procesos_pasos");
                 $plantilla->reemplazaEnBloque("predio_proceso_pasos", $fila[predio_proceso_pasos], "bloque_predio_procesos_pasos");
                 $plantilla->reemplazaEnBloque("idpredio_proceso_pasos_complejo", $aresult['idpredio_sh'][$id][$idsh]."***".$aresult['idmodulo_predio_sh'][$id][$idsh]."***".$fila[idpredio_proceso_pasos], "bloque_predio_procesos_pasos");
                 
                if($fila[idpredio_proceso_pasos]== $aresult['idpredio_proceso_pasos'][$id][$idsh]){
                   $plantilla->reemplazaEnBloque("selected","selected","bloque_predio_procesos_pasos"); 
                }
             }
            $plantilla->iniciaBloque("eliminar_predio_sh");
         
            $plantilla->reemplazaEnBloque("idpredio_sh",$aresult[idpredio_sh][$id][$idsh],"eliminar_predio_sh");
            $plantilla->reemplazaEnBloque("idmodulo_predio_sh",$aresult[idmodulo_predio_sh][$id][$idsh],"eliminar_predio_sh");
            $predio_sh_num=$predio_sh_num+1;         
      }
   
  }  
 $plantilla->presentaPlantilla();  
}

function eliminar_predio_sh($idpredio_sh, $idmodulo_predio_sh){
    $gpredio = new gpredio();
    $error = $gpredio->eliminar_predio_sh($idpredio_sh,$idmodulo_predio_sh);

    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " del predio ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " del predio ");
    }
    echo json_encode($data);   
    
}
function guardar_predio_sh($idpredio, $idmodulo_predio, $idpredio_sh_compuesto){
    $idmodulo_predio_sh = $_SESSION[idmodulo];
    $apredio_sh_compuesto=explode("---",$idpredio_sh_compuesto);
    
    $gstakeholder = new gstakeholder();
    $error = $gstakeholder->agregar_predio($apredio_sh_compuesto[0], $apredio_sh_compuesto[1], $idpredio, $idmodulo_predio,$idmodulo_predio_sh);

    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del predio ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del predio ");
    }
    echo json_encode($data);    
    
    
}

function actualizar_predio_datum($idpredio,$idmodulo_predio,$predio_datum,$idpredio_archivo,$predio_comentario,$predio_direccion){

    $gpredio=new gpredio();
          
    $respuesta = $gpredio->actualizar_predio_datum($idpredio,$idmodulo_predio,$predio_datum,$idpredio_archivo,$predio_comentario,$predio_direccion);
    
    $arespuesta = split("---", $respuesta);
        
    //$data['op_stakeholder'] = true;
    if ($arespuesta[1] == 0) {
        
        $count = 0;
        $archivos =array();
        foreach ($_FILES["archivos"]["error"] as $key => $error) {
            
             if ($error == UPLOAD_ERR_OK) {
                 $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                 $archivo = $_FILES["archivos"]["name"][$key];

                 $uploadfile = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."predio".DIRECTORY_SEPARATOR.$idpredio.'_'.$idmodulo_predio.'_'.$archivo; 
                 $thumbfile  = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR."archivo".DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR."predio".DIRECTORY_SEPARATOR."thumbnail".DIRECTORY_SEPARATOR.$idpredio.'_'.$idmodulo_predio.'_'.$archivo; 
                 //echo $uploadfile." ";
                 
                 if(move_uploaded_file($tmp_name, $uploadfile)){
                     $archivos[] = $archivo;
                     $count++;
                     $thumb = new thumb();
                     if($thumb->loadImage($uploadfile)){
                         
                         $thumb->resize(100, 'height');
                         $thumb->save($thumbfile);
                         
                     }
                 }
             }
         }
         
        if( $count>0 ){
            $gpredio->agregar_archivo($idpredio,$idmodulo_predio,$archivos);
        }
        
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " del predio ");
        $data['idpredio'] = $idpredio;
        
        //$data['data'] = ver_bloque_interaccion(1,"",$idinteraccion, $idmodulo_interaccion, 0, 3, 0);

        //ver_bloque_interaccion($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1, $tabla_interaccion = 1)
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " del predio ");
    }
    
    

    echo json_encode($data);
 
    
}



function editar_predio_tipo_tenencia($idpredio_tipo_tenencia_complejo){
    $gpredio = new gpredio();
 
    $apredio_tipo_tenencia=explode("***",$idpredio_tipo_tenencia_complejo);
    //echo "entra";exit;
    $respuesta = $gpredio->editar_predio_tipo_tenencia($apredio_tipo_tenencia[0], $apredio_tipo_tenencia[1],$apredio_tipo_tenencia[2]);
    //ver_tag_stakeholder($idpersona, $idmodulo,$idtag_compuesto);
    
    if ($respuesta == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del predio ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del predio");
    }
    echo json_encode($data);     
    
}
function editar_proceso_pasos($idpredio,$idmodulo_predio,$idpredio_proceso_pasos_complejo){
    $gpredio = new gpredio();
 
    $apredio_proceso_pasos=explode("***",$idpredio_proceso_pasos_complejo);
    //echo "entra";exit;
    $respuesta = $gpredio->editar_proceso_pasos($apredio_proceso_pasos[0], $apredio_proceso_pasos[1],$apredio_proceso_pasos[2] ,$idpredio, $idmodulo_predio);
    //ver_tag_stakeholder($idpersona, $idmodulo,$idtag_compuesto);
    
    if ($respuesta == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del tag ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del tag");
    }
    echo json_encode($data);    
}


function guardar_predio_tag($idpredio_complejo_tag, $orden_complejo_tag, $idpredio, $idmodulo_predio) {
    $idmodulo_a = $_SESSION[idmodulo_a];
    //echo "entraaaa";exit;
    //echo "ver ".$idtag_compuesto." ".$atag[0]." ".$atag[1];
    $gpredio = new gpredio();

    $respuesta = $gpredio->agregar_tag_complejo($idpredio_complejo_tag, $orden_complejo_tag, $idpredio, $idmodulo_predio, $idmodulo_a);
    //ver_tag_stakeholder($idpersona, $idmodulo,$idtag_compuesto);
    if ($respuesta == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del tag ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del tag");
    }
    echo json_encode($data);
}


function  ver_editar_predio_tag($idpredio, $idmodulo_predio) {
    $seguridad = new Seguridad();    
    $plantilla_editar_tag = new DmpTemplate("../../../plantillas/predio/predio/editar_tag.html");    
    $ipredio = new ipredio();
    $result_tag = $ipredio->lista_tag($idpredio, $idmodulo_predio);
    $cont_tag = 0;
    $cont_tag_fila = 0;
    
    while ($fila_tag = mysql_fetch_array($result_tag)) {

        if ($cont_tag % 5 == 0) {            
            $plantilla_editar_tag->iniciaBloque("tr_editar_tag");
            $cont_tag_fila++;
            $cont_tag_celda = 0;
        }
                                                                                                    
        $plantilla_editar_tag->iniciaBloque("td_editar_tag");
        
        //print_r($fila_tag);
        $plantilla_editar_tag->reemplazaEnBloque("idpredio_tag", $fila_tag[idpredio_tag], "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idmodulo_predio_tag", $fila_tag[idmodulo_predio_tag], "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idpredio", $idpredio, "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idmodulo_predio", $idmodulo_predio, "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idtag", $fila_tag[idtag], "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("tag", utf8_encode($fila_tag[tag]), "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idmodulo_tag", $fila_tag[idmodulo_tag], "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "td_editar_tag");
        //if($seguridad->verifica_permiso("Editar", "Tag", $fila_tag[idusu_c], $fila_tag[idmodulo_c])){
                //$plantilla_editar_tag->iniciaBloque("editar_tag");
                //$plantilla_editar_tag->reemplazaEnBloque("tag", $fila_tag[tag], "editar_tag");
                //$plantilla_editar_tag->reemplazaEnBloque("idmodulo_tag", $fila_tag[idmodulo_tag], "editar_tag");
                //$plantilla_editar_tag->reemplazaEnBloque("idtag", $fila_tag[idtag], "editar_tag");
                //$plantilla_editar_tag->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "editar_tag");
                //$plantilla_editar_tag->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "editar_tag");
                
                $plantilla_editar_tag->iniciaBloque("spinner_tag");
                $plantilla_editar_tag->reemplazaEnBloque("prioridad", $fila_tag[prioridad], "spinner_tag");

                $plantilla_editar_tag->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "spinner_tag");
                $plantilla_editar_tag->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "spinner_tag");
         //}
         
         //if($seguridad->verifica_permiso("Eliminar", "Tag", $fila_tag[idusu_c], $fila_tag[idmodulo_c])){
                $plantilla_editar_tag->iniciaBloque("eliminar_tag");
                $plantilla_editar_tag->reemplazaEnBloque("idpredio_tag", $fila_tag[idpredio_tag], "eliminar_tag");
                $plantilla_editar_tag->reemplazaEnBloque("idmodulo_predio_tag", $fila_tag[idmodulo_predio_tag], "eliminar_tag");
                $plantilla_editar_tag->reemplazaEnBloque("predio_complejo_tag", $fila_tag[idpredio_tag] . "***" . $fila_tag[idmodulo_predio_tag] . "***1", "eliminar_tag");

                $plantilla_editar_tag->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "eliminar_tag");
                $plantilla_editar_tag->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "eliminar_tag");
         //}

        $cont_tag++;
        $cont_tag_celda++;
    }
    
     ////antes coloco el numero real de celdas y filas
            $plantilla_editar_tag->reemplaza("nume_fila_predio_tag", $cont_tag_fila);
            $plantilla_editar_tag->reemplaza("nume_celda_predio_tag", $cont_tag_celda);

            ///
            while ($cont_tag_celda < 5) {
                $plantilla_editar_tag->iniciaBloque("td_editar_tag");
                $plantilla_editar_tag->reemplazaEnBloque("tag", "&nbsp;", "td_editar_tag");
                $plantilla_editar_tag->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "td_editar_tag");
                $plantilla_editar_tag->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "td_editar_tag");

                $cont_tag_celda++;
            }
          

    $plantilla_editar_tag->presentaPlantilla();
     
}

function  ver_tag_predio($idpredio, $idmodulo_predio) {
    $seguridad = new Seguridad();
        
    $plantilla_ver_tag = new DmpTemplate("../../../plantillas/predio/predio/ver_tag.html");
    $ipredio = new ipredio();
    $result_tag = $ipredio->lista_tag($idpredio, $idmodulo_predio);
    $cont_tag = 0;

    
    while ($fila_tag = mysql_fetch_array($result_tag)) {

        if ($cont_tag % 4 == 0) {
            $plantilla_ver_tag->iniciaBloque("tr_tag");
            
        }
        $plantilla_ver_tag->iniciaBloque("td_tag");

        $plantilla_ver_tag->reemplazaEnBloque("tag", utf8_encode($fila_tag[tag]), "td_tag");
        $plantilla_ver_tag->reemplazaEnBloque("prioridad", $fila_tag[prioridad], "td_tag");
        $plantilla_ver_tag->reemplazaEnBloque("idmodulo_tag", $fila_tag[idmodulo_tag], "td_tag");
        $plantilla_ver_tag->reemplazaEnBloque("idtag", $fila_tag[idtag], "td_tag");
                       
        $cont_tag++;
    }

     //if($seguridad->verifica_permiso("Editar", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c]))
    $plantilla_ver_tag->iniciaBloque ("editar_predio_tag");
     
    
    $plantilla_ver_tag->presentaPlantilla();

}