<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * =
 *
 */

include_once '../../include_utiles.php';
include_once '../../../informacion/persona/class.ipersona.php';
include_once '../../../informacion/mapa/class.imapa.php';
include_once '../../../informacion/reclamo/class.ireclamo.php';
include_once '../../../informacion/persona/class.iestado_civil.php';
include_once '../../../gestion/stakeholder/class.gstakeholder.php';

include_once '../../../gestion/calificacion/class.gdimension_matriz_sh.php';

include_once '../../../gestion/stakeholder/class.ghogar.php';
include_once '../../../informacion/stakeholder/class.ihogar.php';
include_once '../../../informacion/persona/class.ipersona_parentesco.php';

include_once '../../../informacion/stakeholder/class.istakeholder.php';
include_once '../../../informacion/interaccion/class.iinteraccion.php';
include_once '../../../informacion/interaccion/class.iinteraccion_tipo.php';
include_once '../../../informacion/interaccion/class.iinteraccion_estado.php';
include_once '../../../informacion/compromiso/class.icompromiso_estado.php';
include_once '../../../informacion/compromiso/class.icompromiso_prioridad.php';
include_once '../../../informacion/compromiso/class.icompromiso.php';
include_once '../../../informacion/calificacion/class.idimension_matriz_sh.php';
include_once '../../../programas/persona/persona/ver_persona.php';
include_once '../../../programas/tag/tag/ver_tag.php';
include_once '../../../programas/stakeholder/stakeholder/abusca_rapida_sh.php';
include_once '../../../programas/stakeholder/stakeholder/astakeholder_interaccion.php';
include_once '../../../programas/predio/predio/apredio_mapa.php';

include_once '../../../programas/mensajes.php';

//print_r($_REQUEST);



$ayudante = new Ayudante();
$op_stakeholder = $_REQUEST["op_stakeholder"];

$idmodulo = $_REQUEST[idmodulo];
$idpersona = $_REQUEST[idpersona];
$idpersona_compuesto = $_REQUEST[idpersona_compuesto];

$nombre = $ayudante->caracter($_REQUEST[nombre]);

$es_stakeholder = $_REQUEST['es_stakeholder'];

$modo = $_REQUEST['modo'];

$folder = $_REQUEST['folder'];

$busca_rapida_stakeholder = $_REQUEST[busca_rapida_stakeholder];
$busca_rapida_predio_stakeholder = $_REQUEST[busca_rapida_predio_stakeholder];

$busca_rapida_tag = $_REQUEST[busca_rapida_tag];
$idtag_compuesto = $_REQUEST[idtag_compuesto];
$idpersona_tag = $_REQUEST[idpersona_tag]; //eliminar tag

$idpersona_red = $_REQUEST[idpersona_red];
$idmodulo_red = $_REQUEST[idmodulo_red];
$idpersona_compuesto_red = $_REQUEST[idpersona_compuesto_red];
$idpersona_red_stakeholder = $_REQUEST[idpersona_red_stakeholder];
$idmodulo_persona_red = $_REQUEST[idmodulo_persona_red];
//interaccion
$interaccion = $_REQUEST[interaccion];

$inicio = $_REQUEST[inicio];
$fecha_interaccion = $_REQUEST[fecha_interaccion];
$idinteraccion_estado = $_REQUEST[idinteraccion_estado];
$idinteraccion_tipo = $_REQUEST[idinteraccion_tipo];
$idinteraccion_prioridad = $_REQUEST[idinteraccion_prioridad];
$prioridades = $_REQUEST['prioridades'];
$tipos = $_REQUEST['tipos'];
$fecha_del = $_REQUEST['fecha_del'];
$fecha_al = $_REQUEST['fecha_al'];

$orden_complejo_tag = $_REQUEST[orden_complejo_tag];

$idinteraccion = $ayudante->caracter($_REQUEST['idinteraccion']);
$idmodulo_interaccion = $_REQUEST['idmodulo_interaccion'];
$idinteraccion_complejo_tag = $_REQUEST[idinteraccion_complejo_tag];
$idinteraccion_complejo_rc = $_REQUEST[idinteraccion_complejo_rc];
$idinteraccion_complejo_sh = $_REQUEST[idinteraccion_complejo_sh];
$idinteraccion_archivo = $_REQUEST[idinteraccion_archivo];
$comentario_interaccion = $ayudante->caracter($_REQUEST[comentario_interaccion]);

$ruta = $_REQUEST['ruta'];
$programa = $_REQUEST['programa'];
//compromiso
$idcompromiso = $_REQUEST['idcompromiso'];
$idmodulo_compromiso = $_REQUEST['idmodulo_compromiso'];

$fecha_compromiso = $_REQUEST[fecha_compromiso];
$fecha_fin_compromiso = $_REQUEST[fecha_fin_compromiso];
$compromiso = $ayudante->caracter($_REQUEST[compromiso]);
$idcompromiso_estado = $_REQUEST[idcompromiso_estado];

$idcompromiso_prioridad = $_REQUEST[idcompromiso_prioridad];
$idcompromiso_rc = $_REQUEST[idcompromiso_rc];
$idcompromiso_sh = $_REQUEST[idcompromiso_sh];
$idcompromiso_archivo = $_REQUEST[idcompromiso_archivo];
$comentario_compromiso = $ayudante->caracter($_REQUEST[comentario_compromiso]);
$hora_compromiso = $_REQUEST[hora_compromiso];
$minuto_compromiso = $_REQUEST[minuto_compromiso];
$hora_fin_compromiso = $_REQUEST[hora_fin_compromiso];
$minuto_fin_compromiso = $_REQUEST[minuto_fin_compromiso];

$limite = $_REQUEST[limite];

$idsh_dimension = $_REQUEST[idsh_dimension];
$idmodulo_sh_dimension = $_REQUEST[idmodulo_sh_dimension];



//calificacion
$fecha = $_REQUEST[fecha];
$dimension = $_REQUEST[dimension];
$comentario = $ayudante->caracter($_REQUEST[comentario]);

$idsh_dimension_matriz_sh = $_REQUEST[idsh_dimension_matriz_sh];
//tag
$tag = $_REQUEST[tag];
$tags = $_REQUEST[tags];
$idtag = $_REQUEST[idtag];
$idmodulo_tag = $_REQUEST[idmodulo_tag];
$idmodulo_persona_tag = $_REQUEST[idmodulo_persona_tag];
//analisis red
$rango_fecha = $_REQUEST[rango_fecha];

$presenta = $_REQUEST[presenta]; //si hace un echo o retorna una cadena
$persona = $_REQUEST[persona]; //varible que me indica : 1 si es sh, 2 si es rc
$tabla_interaccion = $_REQUEST[tabla_interaccion]; // variable que me indica si construyo la tabla o solo un bloque
$persona = $_REQUEST[persona];
$idpersona_tipo = $_REQUEST['idpersona_tipo'];
$tiene_cabecera = $_REQUEST['tiene_cabecera'];

$idpredio = $_REQUEST['idpredio'];
$idpredio_archivo = $_REQUEST['idpredio_archivo'];
$comentario_predio = $_REQUEST['comentario_predio'];

$idsh_compuesto = $_REQUEST['idsh_compuesto'];

$idtag_entidad = $_REQUEST[idtag_entidad];

$identidad = $_REQUEST[identidad];

$entidad = $_REQUEST[entidad];

$idgis_item = $_REQUEST[idgis_item];

$fid_string = $_REQUEST[fid_string];

$idpredio_complejo_tag = $_REQUEST[idpredio_complejo_tag];

$idstakeholder_complejo_tag = $_REQUEST[idstakeholder_complejo_tag];

$idmapa = $_REQUEST[idmapa];

$tags_predio = $_REQUEST[tags_predio];

$intensidad = $_REQUEST[intensidad];
$idmodulo_predio = $_REQUEST[idmodulo_predio];

//hogar
$idhogar_complejo_sh = $_REQUEST['idhogar_complejo_sh'];
$fecha_hogar = $_REQUEST['fecha_hogar'];
$comentario_hogar = $_REQUEST['comentario_hogar'];
$idsh_hogar = $_REQUEST['idsh_hogar'];
$idmodulo_sh_hogar = $_REQUEST['idmodulo_sh_hogar'];
$idpersona_parentesco = $_REQUEST['idpersona_parentesco'];

$minuto_dura_interaccion=$_REQUEST['minuto_dura_interaccion'];
/*
  if (!$seguridad->verificaSesion()) {
  $mensaje = "Ingrese su usuario y contraseña";
  header("Location: ../../../index.php?mensaje=$mensaje");
  } */

//echo "permiso: "; print_r($_SESSION["permiso"]); exit;

/* session_start();

  $_SESSION[idusu] = 1;
  $_SESSION[idmodulo_a] = 1;
  $_SESSION[idmodulo_a] = 1; */
//echo $op_stakeholder;
switch ($op_stakeholder) {

    case "ver_cabecera_stakeholder" :ver_cabecera_stakeholder($idpersona, $idmodulo, $idpersona_compuesto);
        break;
    case "busqueda_rapida_stakeholder":busqueda_rapida_stakeholder($busca_rapida_stakeholder);
        break;
    case "busqueda_rapida_stakeholder_tag":busqueda_rapida_stakeholder_tag($busca_rapida_stakeholder);
        break;
    case "busqueda_rapida_predio_stakeholder":busqueda_rapida_predio_stakeholder($busca_rapida_predio_stakeholder);
        break;
    case "ver_editar_persona":
        echo ver_editar_persona($es_stakeholder, $idpersona, $idmodulo, $idpersona_compuesto, $idpersona_tipo, $tiene_cabecera);
        break;
    case "ver_tag":ver_tag($busca_rapida_tag, $idtag_entidad);
        break;
    case "ver_tag_stakeholder":
        ver_tag_stakeholder($idpersona, $idmodulo);
        break;
    case "ver_editar_tag_stakeholder":
        ver_editar_tag_stakeholder($idpersona, $idmodulo);
        break;
    case "guardar_tag_stakeholder":guardar_tag_stakeholder($idstakeholder_complejo_tag, $orden_complejo_tag, $idpersona, $idmodulo);
        break;
    case "eliminar_tag_stakeholder":eliminar_tag_stakeholder($idpersona_tag, $idpersona, $idmodulo, $idmodulo_persona_tag);
        break;
    case "ver_tab_stakeholder":ver_tab_stakeholder($idpersona, $idmodulo, $idpersona_tipo, $idpersona_compuesto);
        break;
    case "ver_editar_red_stakeholder":ver_editar_red_stakeholder($idpersona, $idmodulo);
        break;
    case "guardar_red_stakeholder":guardar_red_stakeholder($idpersona_compuesto_red, $idpersona, $idmodulo);
        break;
    case "eliminar_red_stakeholder":eliminar_red_stakeholder($idpersona_red_stakeholder, $idpersona, $idmodulo, $idmodulo_persona_red);
        break;
    case "ver_interaccion_stakeholder":ver_interaccion_stakeholder($idpersona, $idmodulo, $idinteraccion, $idmodulo_interaccion, $persona, $presenta);
        break;
    case "ver_bloque_interaccion":ver_bloque_interaccion($idpersona_tipo, $nombre, $idpersona, $idmodulo, $inicio, $persona, $presenta, $modo, $idsh_compuesto);
        break;

    case "eliminar_interaccion_stakeholder":eliminar_interaccion_stakeholder($idinteraccion, $idmodulo_interaccion);
        break;
    case "guardar_interaccion_stakeholder":guardar_interaccion_stakeholder($idpersona, $idmodulo, $interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $idinteraccion_complejo_tag, $idinteraccion_prioridad, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $comentario_interaccion, $orden_complejo_tag,'',$minuto_dura_interaccion);
        break;
    case "ver_interaccion_stakolder_complejo":ver_interaccion_stakolder_complejo($idpersona, $idmodulo, $idinteraccion, $idmodulo_interaccion, $persona, $presenta);
        break;
    case "actualizar_interaccion_stakeholder":
        actualizar_interaccion_stakeholder($idinteraccion, $idmodulo_interaccion, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $idinteraccion_archivo, $comentario_interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $idinteraccion_prioridad, $interaccion, $idpersona, $idmodulo, $persona, $presenta, $orden_complejo_tag,'',$minuto_dura_interaccion);
        break;
    case "ver_compromiso_stakeholder":ver_compromiso_stakeholder($idpersona, $idmodulo, $idinteraccion, $idmodulo_interaccion, $idcompromiso, $idmodulo_compromiso);
        break;
    case "ver_editar_compromiso_stakeholder":ver_editar_compromiso_stakeholder($idcompromiso, $idmodulo_compromiso, $idpersona, $idmodulo);
        break;
    case "guardar_compromiso_stakeholder":guardar_compromiso_stakeholder($idinteraccion, $idmodulo_interaccion, $fecha_compromiso, $hora_compromiso, $minuto_compromiso, $fecha_fin_compromiso, $hora_fin_compromiso, $minuto_fin_compromiso, $compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $idcompromiso_rc, $idcompromiso_sh, $comentario_compromiso, $idpersona, $idmodulo);
        break;
    case "eliminar_compromiso_stakeholder":eliminar_compromiso_stakeholder($idcompromiso, $idmodulo_compromiso);
        break;
    case "ver_calificacion_stakeholder":ver_calificacion_stakeholder($idpersona, $idmodulo, $idusu_c, $idmodulo_c);
        break;
    case "mostrar_calificacion_stakeholder":mostrar_calificacion_stakeholder($idpersona, $idmodulo);
        break;
    case "guardar_calificacion_stakeholder":guardar_calificacion_stakeholder($idpersona, $idmodulo, $fecha, $dimension, $comentario);
        break;
    case "obtener_calificacion_stakeholder":obtener_calificacion_stakeholder($idpersona, $idmodulo, $fecha_del, $fecha_al);
        break;
    case "eliminar_calificacion_stakeholder":eliminar_calificacion_stakeholder($idpersona, $idmodulo, $idsh_dimension, $idmodulo_sh_dimension);
        break;
    case "actualizar_compromiso_stakeholder":actualizar_compromiso_stakeholder($idcompromiso, $idmodulo_compromiso, $fecha_compromiso, $hora_compromiso, $minuto_compromiso, $fecha_fin_compromiso, $hora_fin_compromiso, $minuto_fin_compromiso, $compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $idcompromiso_rc, $idcompromiso_sh, $idcompromiso_archivo, $comentario_compromiso);
        break;
    case "ver_dimension_matriz":ver_dimension_matriz();
        break;
    case "refrescar_tag_stakeholder":refrescar_tag_stakeholder($idpersona, $idmodulo);
        break;
    case "ver_analisis_red":ver_analisis_red($idpersona, $idmodulo, $rango_fecha);
        break;
    case "actualizar_analisis_red":actualizar_analisis_red($idpersona, $idmodulo, $rango_fecha);
        break;
    case "ver_item_compromiso":ver_item_compromiso($idcompromiso, $idmodulo_compromiso);
        break;
    case "ver_cuerpo_compromiso": ver_cuerpo_compromiso($idpersona, $idmodulo, $inicio);
        break;
    case "descargar": descargar($programa, $ruta);
        break;
    case "ver_buscar_interaccion":ver_buscar_interaccion();
        break;
    case "buscar_interaccion":buscar_interaccion($idinteraccion, $idmodulo_interaccion, $idinteraccion_estado, $prioridades, $tipos, $fecha_del, $fecha_al, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $interaccion);
        break;
    case "exportar_interaccion":exportar_interaccion($idinteraccion_estado, $prioridades, $tipos, $fecha_del, $fecha_al, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $interaccion);
        break;
    case "exportar_pdf_interaccion":exportar_pdf_interaccion($idinteraccion, $idmodulo_interaccion);
        break;
    case "exportar_pdf_compromiso":exportar_pdf_compromiso($idcompromiso, $idmodulo_compromiso);
        break;
    case "exportar_pdf_organizacion":exportar_pdf_organizacion($idpersona, $idmodulo);
        break;
    case "ver_buscar_compromiso":ver_buscar_compromiso();
        break;
    case "buscar_compromiso":buscar_compromiso($idcompromiso, $idmodulo_compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $fecha_del, $fecha_al, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $compromiso);
        break;
    case "exportar_compromiso":exportar_compromiso($idcompromiso_estado, $idcompromiso_prioridad, $fecha_del, $fecha_al, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $compromiso);
        break;
    case "ver_buscar_red":ver_buscar_red();
        break;

    case "ver_cuerpo_reclamo":echo ver_cuerpo_reclamo($todos, $flag_estado, $limite);
        break;

    case "createThumbs":createThumbs($folder);
        break;

    case "ver_buscar_mapa":ver_buscar_mapa($fid_string, $presenta, $idmapa, $intensidad);
        break;

    case "ver_editar_predio_stakeholder":ver_editar_predio_stakeholder($idpersona, $idmodulo, $idmapa);
        break;

    case "guardar_predio_stakeholder":guardar_predio_stakeholder($idpredio, $idpersona, $idmodulo);
        break;

    case "consultar_indentificadores_geograficos": consultar_indentificadores_geograficos($idtag_compuesto, $tags, $tags_predio);
        break;

    case "ver_predio_persona": ver_predio_persona($idgis_item);
        break;

    case "ver_predio_stakolder_complejo":ver_predio_stakolder_complejo($idpredio, $idmodulo_predio, $nombre);
        break;

    case "actualizar_predio_stakeholder":actualizar_predio_stakeholder($idpredio, $idmodulo_predio, $idpredio_archivo, $comentario_predio, $idpredio_complejo_tag, $orden_complejo_tag);
        break;

    case "ver_reporte_predio_entidad":ver_reporte_predio_entidad($entidad, $identidad, $idmodulo);
        break;

    case "ver_predio_entidad":ver_predio_entidad($fid_string, $intensidad);
        break;
    case "ver_editar_hogar":ver_editar_hogar($idsh_hogar, $idmodulo_sh_hogar, $idpersona, $idmodulo);
        break;
    case "ver_nuevo_hogar":ver_nuevo_hogar($idpersona, $idmodulo);
        break;
    case "ver_nuevo_editar_hogar":ver_nuevo_editar_hogar($idpersona, $idmodulo);
        break;
    case "guardar_hogar":guardar_hogar($fecha_hogar, $idhogar_complejo_sh, $idpersona, $idmodulo, $comentario_hogar, $idpersona_parentesco);
        break;
    case "eliminar_hogar":eliminar_hogar($idsh_hogar, $idmodulo_sh_hogar, $idpersona, $idmodulo);
        break;
    case "editar_hogar":editar_hogar($idsh_hogar, $idmodulo_sh_hogar, $fecha_hogar, $idhogar_complejo_sh, $idpersona, $idmodulo, $comentario_hogar, $idpersona_parentesco);
        break;
    case "exportar_pdf_sh":exportar_pdf_sh($idpersona, $idmodulo);
        break;
     case "ver_mapa":ver_mapa($idpersona, $idmodulo, $nombre, $modo);
        break;
    default : 
        
        ver_cuerpo_inicial($idpersona, $idmodulo, $nombre, $modo);
        
        
        break;
}

function ver_mapa($idpersona, $idmodulo, $nombre, $modo) {
 
    $seguridad = new Seguridad();
    echo "<br/><div id='cargando' style='width: 100px; margin:0 auto;'><img src='../../../img/bar-ajax-loader.gif'></div><br/>";
    flush();
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/cuerpo.html");

    $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre");
    //$tiempo ="Bienvenido ".date("G");

    if (date("G") >= 4 && date("G") <= 11) {
        $tiempo = "Buenos d&iacute;as ";
    }
    if (date("G") > 11 && date("G") <= 19) {
        $tiempo = "Buenas tardes ";
    }
    if (date("G") > 19 && date("G") <= 24) {
        $tiempo = "Buenas noches ";
    }
    $plantilla->reemplaza("version", version);
    $plantilla->reemplaza("idpersona", $_SESSION[idpersona]);
    $plantilla->reemplaza("idusuario", $_SESSION[idusuario]);
    $plantilla->reemplaza("idmodulo", $_SESSION[idmodulo_persona]);
    $plantilla->reemplaza("idmodulo_usuario", $_SESSION[idmodulo_usuario]);
    $plantilla->reemplaza("quien", "<span style=\"font-weight: normal;\">" . $tiempo . "</span>" . substr($_SESSION[nombre], 0, 12) . " <span style=\"font-weight: normal;\">bienvenido a</span> " . strtoupper($_SESSION['proyecto']));
    $plantilla->reemplaza("fecha", $dias[date('w')] . ", " . date("j") . " de " . $meses[date('n')] . " del " . date("Y"));
    $plantilla->reemplaza("sesion", $_SESSION[sesion]);
    $plantilla->reemplaza("idproyecto", $_SESSION[idproyecto]);
    $plantilla->reemplaza("zona", date_default_timezone_get());


    if ($seguridad->verifica_permiso("Crear", "Relacionista"))
        $plantilla->iniciaBloque("crear_rc");

    if ($seguridad->verifica_permiso("Crear", "Stakeholder"))
        $plantilla->iniciaBloque("crear_sh");

    if ($seguridad->verifica_permiso("Crear", "Tag"))
        $plantilla->iniciaBloque("crear_tag");

    if ($seguridad->verifica_permiso("Crear", "Interaccion"))
        $plantilla->iniciaBloque("crear_interaccion");

    if ($seguridad->verifica_permiso("Crear", "Reclamo"))
        $plantilla->iniciaBloque("crear_reclamo");



    if ($seguridad->verifica_permiso("Ver", "Sincronizacion"))
        $plantilla->iniciaBloque("ver_sincronizacion");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Estadistico"))
        $plantilla->iniciaBloque("ver_stakeholder_estadistico");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Interes-Poder"))
        $plantilla->iniciaBloque("ver_interes_poder");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Posicion-Importancia"))
        $plantilla->iniciaBloque("ver_posicion_importancia");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Posicion-Tiempo"))
        $plantilla->iniciaBloque("ver_posicion_tiempo");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Interaccion-Tiempo"))
        $plantilla->iniciaBloque("ver_interaccion_tiempo");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Buscar-Interaccion"))
        $plantilla->iniciaBloque("ver_buscar_interaccion");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Buscar-Compromiso"))
        $plantilla->iniciaBloque("ver_buscar_compromiso");

    if ($seguridad->verifica_permiso("Ver", "Reclamo-Estadistico"))
        $plantilla->iniciaBloque("ver_reclamo_estadistico");

    if ($seguridad->verifica_permiso("Ver", "Reclamo-Buscar"))
        $plantilla->iniciaBloque("ver_reclamo_buscar");

    if ($seguridad->verifica_permiso("Administrar", "Usuario-Rol"))
        $plantilla->iniciaBloque("ver_rol");

$plantilla->reemplaza("ver_mapa","ver_buscar_mapa()");
    if (!isset($modo)) {
        $modo = 1;
    }

    //

    if (isset($nombre) && $nombre != "") {
        $plantilla->reemplaza("cuerpo_interaccion", ver_bloque_interaccion(1, $nombre, $idpersona, $idmodulo, 50, 2, 0, $modo)); //persona 2 ve las interacciones del relacionista comunitario
    } else {
        $plantilla->reemplaza("cuerpo_interaccion", ver_bloque_interaccion($_SESSION["idpersona_tipo"], $_SESSION[nombre], $_SESSION[idpersona], $_SESSION[idmodulo_a], 50, 2, 0, $modo)); //persona 2 ve las interacciones del relacionista comunitario
    }

    echo $plantilla->getPlantillaCadena();
}


function eliminar_hogar($idsh_hogar, $idmodulo_sh_hogar, $idpersona, $idmodulo) {
    $hogar = new ghogar();

    $error = $hogar->eliminar($idsh_hogar, $idmodulo_sh_hogar);
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " del hogar ");
        $data['idmodulo'] = $idmodulo;
        $data['idpersona'] = $idpersona;
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " del hogar ");
    }
    echo json_encode($data);
}

function ver_nuevo_editar_hogar($idpersona, $idmodulo) {

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/hogar/nuevo_editar_hogar.html");
    $plantilla->reemplaza("idpersona", $idpersona);
    $plantilla->reemplaza("idmodulo", $idmodulo);
    $ihogar = new ihogar();

    $ahogar = $ihogar->get_hogar_sh($idpersona, $idmodulo);

    if (sizeof($ahogar[fecha_hogar]) > 0) {

        foreach ($ahogar[fecha_hogar] as $idhogar_complejo => $fecha_hogar) {
            $cont = 1;
            $plantilla->iniciaBloque("hogar");
            $plantilla->reemplazaEnBloque("fecha_hogar", $fecha_hogar, "hogar");

            $plantilla->iniciaBloque("eliminar_hogar");
            $adhogar_complejo = explode("---", $idhogar_complejo);
            $plantilla->reemplazaEnBloque("idsh_hogar", $adhogar_complejo[0], "eliminar_hogar");
            $plantilla->reemplazaEnBloque("idmodulo_sh_hogar", $adhogar_complejo[1], "eliminar_hogar");

            $plantilla->iniciaBloque("editar_hogar");
            $plantilla->reemplazaEnBloque("idsh_hogar", $adhogar_complejo[0], "editar_hogar");
            $plantilla->reemplazaEnBloque("idmodulo_sh_hogar", $adhogar_complejo[1], "editar_hogar");

            foreach ($ahogar[sh][$idhogar_complejo] as $idhogar_sh_complejo => $nombre_sh) {

                $plantilla->iniciaBloque("tr_sh_hogar");

                $plantilla->iniciaBloque("td_sh_hogar");


                $plantilla->reemplazaEnBloque("sh", $nombre_sh, "td_sh_hogar");

                $idhogar_sh = explode('---', $idhogar_sh_complejo);
                $plantilla->reemplazaEnBloque("idsh", $idhogar_sh[0], "td_sh_hogar");
                $plantilla->reemplazaEnBloque("idmodulo", $idhogar_sh[1], "td_sh_hogar");

                $plantilla->iniciaBloque("idhogar_complejo_sh");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont, "idhogar_complejo_sh");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "idhogar_complejo_sh");


                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont, "td_sh_hogar");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_hogar");

                $plantilla->reemplazaEnBloque("parentesco", $ahogar[parentesco][$idhogar_complejo][$idhogar_sh_complejo], "td_sh_hogar");




                $cont++;
            }
        }
    }


    echo utf8_encode($plantilla->getPlantillaCadena());
}

function editar_hogar($idsh_hogar, $idmodulo_sh_hogar, $fecha_hogar, $idhogar_complejo_sh, $idpersona, $idmodulo, $comentario_hogar, $idpersona_parentesco) {
    $hogar = new ghogar();

    $error = $hogar->editar($idsh_hogar, $idmodulo_sh_hogar, $fecha_hogar, $comentario_hogar, $idpersona, $idmodulo, $idhogar_complejo_sh, $idpersona_parentesco);

    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del hogar ");
        $data['idmodulo'] = $idmodulo;
        $data['idpersona'] = $idpersona;
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del hogar ");
    }
    echo json_encode($data);
}

function guardar_hogar($fecha_hogar, $idhogar_complejo_sh, $idpersona, $idmodulo, $comentario_hogar, $idpersona_parentesco) {

    $hogar = new ghogar();

    $error = $hogar->agregar($fecha_hogar, $comentario_hogar, $idpersona, $idmodulo, $idhogar_complejo_sh, $idpersona_parentesco);

    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del hogar ");
        $data['idmodulo'] = $idmodulo;
        $data['idpersona'] = $idpersona;
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del hogar ");
    }
    echo json_encode($data);
}

function ver_editar_hogar($idsh_hogar, $idmodulo_sh_hogar, $idpersona, $idmodulo) {
    $ihogar = new ihogar();
    $ahogar = $ihogar->get_hogar($idsh_hogar, $idmodulo_sh_hogar);
    $ipersona_parentesco = new ipersona_parentesco();
    $result_persona_parentesco = $ipersona_parentesco->get_persona_parentesco();
    $n_registros = sizeof($ahogar[fecha_hogar]);

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/hogar/hogar.html");
    $plantilla->iniciaBloque("editar_hogar");
    $plantilla->reemplazaEnBloque("idsh_hogar", $idsh_hogar, "editar_hogar");
    $plantilla->reemplazaEnBloque("idmodulo_sh_hogar", $idmodulo_sh_hogar, "editar_hogar");


    $plantilla->reemplaza("op_hogar_stakeholder", "editar_hogar");
    //$plantilla->reemplaza("idpersona", $ahogar[idsh]);
    //$plantilla->reemplaza("idmodulo", $ahogar[idmodulo]);
    $plantilla->reemplaza("idpersona", $idpersona);
    $plantilla->reemplaza("idmodulo", $idmodulo);
    //echo $n_registros;
    $cont = 0;
    if ($n_registros >= 1) {
        foreach ($ahogar[fecha_hogar] as $idhogar_complejo => $fecha_hogar) {
            $cont = 1;

            $plantilla->reemplaza("fecha_hogar", $fecha_hogar);

            foreach ($ahogar[sh][$idhogar_complejo] as $idhogar_sh_complejo => $nombre_sh) {

                $plantilla->iniciaBloque("tr_sh_hogar");

                //celda_nume_fila_sh
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont, "tr_sh_hogar");
                $plantilla->iniciaBloque("td_sh_hogar");

                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont, "td_sh_hogar");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_hogar");
                $plantilla->reemplazaEnBloque("sh", $nombre_sh, "td_sh_hogar");
                $idhogar_sh = explode('---', $idhogar_sh_complejo);
                $plantilla->reemplazaEnBloque("idsh", $idhogar_sh[0], "td_sh_hogar");
                $plantilla->reemplazaEnBloque("idmodulo", $idhogar_sh[1], "td_sh_hogar");
                //echo $ahogar[idsh]." hogar ".$idhogar_sh[0] ." /n";
                //echo $ahogar[idmodulo]." hogar ".$idhogar_sh[1] ." /";
                $plantilla->iniciaBloque("idhogar_complejo_sh");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont, "idhogar_complejo_sh");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "idhogar_complejo_sh");

                $plantilla->reemplazaEnBloque("idhogar_complejo_sh", $idhogar_sh[0] . "---" . $idhogar_sh[1] . "---1", "idhogar_complejo_sh");

                if ($idhogar_sh[0] . '---' . $idhogar_sh[1] != $ahogar[idsh] . '---' . $ahogar[idmodulo]) {
                    $plantilla->iniciaBloque("eliminar_sh_hogar");
                    $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont, "eliminar_sh_hogar");
                    $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "eliminar_sh_hogar");
                }

                mysql_data_seek($result_persona_parentesco, 0);
                while ($fila = mysql_fetch_array($result_persona_parentesco)) {

                    $plantilla->iniciaBloque("persona_parentesco");
                    $plantilla->reemplazaEnBloque("descripcion", $fila['descripcion'], "persona_parentesco");
                    $plantilla->reemplazaEnBloque("idpersona_parentesco", $fila['idpersona_parentesco'], "persona_parentesco");

                    if ($ahogar[idpersona_parentesco][$idhogar_complejo][$idhogar_sh_complejo] == $fila[idpersona_parentesco]) {
                        $plantilla->reemplazaEnBloque("selected", "selected", "persona_parentesco");
                    }
                }

                $cont++;
            }
        }
        $plantilla->reemplaza("nume_fila_hogar_sh", $cont - 1);
        $plantilla->reemplaza("cant_hogar", $cont - 1);
        $plantilla->reemplaza("nume_fila_hogar_sh_complejo", $cont);
        $plantilla->reemplaza("nume_celda_hogar_sh_complejo", 1);
    }

    echo utf8_encode($plantilla->getPlantillaCadena());
}

function ver_nuevo_hogar($idpersona, $idmodulo) {
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/hogar/hogar.html");
    $plantilla->reemplaza("op_hogar_stakeholder", "guardar_hogar");

    $plantilla->reemplaza("idpersona", $idpersona);
    $plantilla->reemplaza("idmodulo", $idmodulo);
    $ipersona = new ipersona();
    $result_persona = $ipersona->get_persona($idpersona, $idmodulo);

    $ipersona_parentesco = new ipersona_parentesco();
    $result_persona_parentesco = $ipersona_parentesco->get_persona_parentesco();

    if ($fila = mysql_fetch_array($result_persona)) {
        $nombre = $fila['nombre'];
        $apellido_p = $fila['apellido_p'];
        $apellido_m = $fila['apellido_m'];
    }
    $plantilla->reemplaza("fecha_hogar", date('d/m/Y'));
    $plantilla->reemplaza("cant_sh", 1);

    $plantilla->iniciaBloque("tr_sh_hogar");

    $plantilla->iniciaBloque("td_sh_hogar");


    $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_hogar");
    $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_hogar");
    $plantilla->reemplazaEnBloque("sh", $nombre . " " . $apellido_p . " " . $apellido_m, "td_sh_hogar");
    $plantilla->reemplazaEnBloque("idsh", $idpersona, "td_sh_hogar");
    $plantilla->reemplazaEnBloque("idmodulo", $idmodulo, "td_sh_hogar");
    $plantilla->iniciaBloque("idhogar_complejo_sh");
    $plantilla->reemplazaEnBloque("idhogar_complejo_sh", $idpersona . '---' . $idmodulo, "idhogar_complejo_sh");
    $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "idhogar_complejo_sh");
    $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "idhogar_complejo_sh");


    $plantilla->reemplaza("nume_fila_hogar_sh_complejo", 1);
    $plantilla->reemplaza("nume_celda_hogar_sh_complejo", 1);


    mysql_data_seek($result_persona_parentesco, 0);
    while ($fila = mysql_fetch_array($result_persona_parentesco)) {

        $plantilla->iniciaBloque("persona_parentesco");
        $plantilla->reemplazaEnBloque("descripcion", $fila['descripcion'], "persona_parentesco");
        $plantilla->reemplazaEnBloque("idpersona_parentesco", $fila['idpersona_parentesco'], "persona_parentesco");
    }

    $plantilla->reemplaza("maximo", 1);


    echo utf8_encode($plantilla->getPlantillaCadena());
}

function actualizar_compromiso_stakeholder($idcompromiso, $idmodulo_compromiso, $fecha_compromiso, $hora_compromiso, $minuto_compromiso, $fecha_fin_compromiso, $hora_fin_compromiso, $minuto_fin_compromiso, $compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $idcompromiso_rc, $idcompromiso_sh, $idcompromiso_archivo, $comentario_compromiso) {
    //echo "verrr".$idcompromiso."-".$idmodulo_compromiso;
    $gstakeholder = new gstakeholder();

    $error = $gstakeholder->actualizar_compromiso($idcompromiso, $idmodulo_compromiso, $fecha_compromiso, $hora_compromiso, $minuto_compromiso, $fecha_fin_compromiso, $hora_fin_compromiso, $minuto_fin_compromiso, $compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $idcompromiso_rc, $idcompromiso_sh, $idcompromiso_archivo, $comentario_compromiso);

    $aerror = explode("---", $error);

    if ($aerror[2] == 0) {
        $count = 0;
        $archivos = array();

        foreach ($_FILES["archivos"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                $archivo = $_FILES["archivos"]["name"][$key];

                $uploadfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "compromiso" . DIRECTORY_SEPARATOR . $aerror[0] . '_' . $archivo;
                $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "compromiso" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $aerror[0] . '_' . $archivo;

                //echo $uploadfile." ";

                if (move_uploaded_file($tmp_name, $uploadfile)) {
                    $archivos[] = $archivo;
                    $count++;
                    $thumb = new thumb();
                    if ($thumb->loadImage($uploadfile)) {

                        $thumb->resize(100, 'height');
                        $thumb->save($thumbfile);
                    }
                }
            }
        }

        if ($count > 0) {
            $gstakeholder->agregar_archivo_compromiso($aerror[0], $aerror[1], $archivos);
        }

        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " del compromiso ");
        $data['idcompromiso'] = $idcompromiso;
        $data['idmodulo_compromiso'] = $idmodulo_compromiso;
        $data['data'] = utf8_encode(ver_item_compromiso($idcompromiso, $idmodulo_compromiso));
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " del compromiso ");
    }
    $data['op_stakeholder'] = true;

    echo json_encode($data);

    // echo $aerror[0]." ".$aerror[1];
    //ver_editar_compromiso_stakeholder($aerror[0],$aerror[1],$idpersona,$idmodulo);
}

function guardar_compromiso_stakeholder($idinteraccion, $idmodulo_interaccion, $fecha_compromiso, $hora_compromiso, $minuto_compromiso, $fecha_fin_compromiso, $hora_fin_compromiso, $minuto_fin_compromiso, $compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $idcompromiso_rc, $idcompromiso_sh, $comentario_compromiso, $idpersona, $idmodulo) {
    $gstakeholder = new gstakeholder();

    $error = $gstakeholder->agregar_compromiso($idinteraccion, $idmodulo_interaccion, $fecha_compromiso, $hora_compromiso, $minuto_compromiso, $fecha_fin_compromiso, $hora_fin_compromiso, $minuto_fin_compromiso, $compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $idcompromiso_rc, $idcompromiso_sh, $comentario_compromiso, $idpersona, $idmodulo);

    $aerror = explode("---", $error);

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/compromiso/nuevo_compromiso.html");

    $plantilla->iniciaBloque("item_compromiso");
    $plantilla->reemplazaEnBloque("fecha_compromiso", $fecha_compromiso, "item_compromiso");
    $plantilla->reemplazaEnBloque("compromiso", $compromiso, "item_compromiso");
    $plantilla->reemplazaEnBloque("idcompromiso", $aerror[0], "item_compromiso");
    $plantilla->reemplazaEnBloque("idmodulo_compromiso", $_SESSION["idmodulo"], "item_compromiso");

    // echo $aerror[0]." ".$aerror[1];
    //ver_editar_compromiso_stakeholder($aerror[0],$aerror[1],$idpersona,$idmodulo);
    if ($aerror[2] == 0) {

        $count = 0;
        $archivos = array();

        foreach ($_FILES["archivos"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                $archivo = $_FILES["archivos"]["name"][$key];

                $uploadfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "compromiso" . DIRECTORY_SEPARATOR . $aerror[0] . '_' . $archivo;
                $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "compromiso" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $aerror[0] . '_' . $archivo;

                //echo $uploadfile." ";

                if (move_uploaded_file($tmp_name, $uploadfile)) {
                    $archivos[] = $archivo;
                    $count++;
                    $thumb = new thumb();
                    if ($thumb->loadImage($uploadfile)) {

                        $thumb->resize(100, 'height');
                        $thumb->save($thumbfile);
                    }
                }
            }
        }

        if ($count > 0) {
            $gstakeholder->agregar_archivo_compromiso($aerror[0], $aerror[1], $archivos);
        }

        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del compromiso ");
        $data['idinteraccion'] = $idinteraccion;
        $data['idmodulo_interaccion'] = $idmodulo_interaccion;
        $data['html'] = utf8_encode($plantilla->getPlantillaCadena());
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del compromiso ");
    }
    $data['op_stakeholder'] = false;

    echo json_encode($data);
}

function eliminar_compromiso_stakeholder($idcompromiso, $idmodulo_compromiso) {
    $gstakeholder = new gstakeholder();
    $respuesta = $gstakeholder->eliminar_compromiso($idcompromiso, $idmodulo_compromiso);
    if ($respuesta == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " del compromiso ");
    } else {
        $data['success'] = fale;
        $data['mensaje'] = coloca_mensaje("elimina_error", " del compromiso ");
    }
    echo json_encode($data);
}

function mostrar_calificacion_stakeholder($idpersona, $idmodulo) {
    echo ver_calificacion_stakeholder($idpersona, $idmodulo);
}

function ver_calificacion_stakeholder($idpersona, $idmodulo, $idusu_c, $idmodulo_c) {
    $seguridad = new Seguridad();

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/calificacion/ver_calificacion_stakeholder.html");

    $idimension_matriz_sh = new idimension_matriz_sh();

    $result = $idimension_matriz_sh->lista_dimension_matriz_sh($idpersona, $idmodulo);
    $votos = array();
    $count = 0;
    while ($fila1 = mysql_fetch_array($result)) {
        $count++;
        $votos[$fila1[iddimension_matriz_sh]] = $fila1;
    }

    if ($count > 0 && $seguridad->verifica_permiso("Ver", "Stakeholder-Calificacion")) {
        $plantilla->iniciaBloque("tr_calificacion");
        $plantilla->reemplazaEnBloque("posicion", ruta_images . $votos[1][valor], "tr_calificacion");
        $plantilla->reemplazaEnBloque("idpersona", $idpersona, "tr_calificacion");
        $plantilla->reemplazaEnBloque("idmodulo", $idmodulo, "tr_calificacion");
        $plantilla->reemplazaEnBloque("comentario", $votos[1][comentario], "tr_calificacion");

        $plantilla->iniciaBloque("tr_dimension");
        $plantilla->reemplazaEnBloque("dimension", $votos[2][dimension], "tr_dimension");
        $plantilla->reemplazaEnBloque("valor", ruta_images . $votos[2][valor], "tr_dimension");
        $plantilla->reemplazaEnBloque("comentario", $votos[2][comentario], "tr_dimension");

        $plantilla->iniciaBloque("tr_dimension");
        $plantilla->reemplazaEnBloque("dimension", $votos[3][dimension], "tr_dimension");
        $plantilla->reemplazaEnBloque("valor", ruta_images . $votos[3][valor], "tr_dimension");
        $plantilla->reemplazaEnBloque("comentario", $votos[3][comentario], "tr_dimension");
    } else {
        $plantilla->iniciaBloque("tr_calificacion");
        $plantilla->reemplazaEnBloque("posicion", ruta_images . "00.png", "tr_calificacion");
        $plantilla->reemplazaEnBloque("idpersona", $idpersona, "tr_calificacion");
        $plantilla->reemplazaEnBloque("idmodulo", $idmodulo, "tr_calificacion");


        $plantilla->iniciaBloque("tr_dimension");
        $plantilla->reemplazaEnBloque("dimension", "Poder", "tr_dimension");
        $plantilla->reemplazaEnBloque("valor", ruta_images . "0.png", "tr_dimension");

        $plantilla->iniciaBloque("tr_dimension");
        $plantilla->reemplazaEnBloque("dimension", "Interes", "tr_dimension");
        $plantilla->reemplazaEnBloque("valor", ruta_images . "0.png", "tr_dimension");
    }

    if ($seguridad->verifica_permiso("Crear", "Stakeholder-Calificacion")) {
        $plantilla->iniciaBloque("crear_calificacion_sh");
        $plantilla->reemplazaEnBloque("idpersona", $idpersona, "crear_calificacion_sh");
        $plantilla->reemplazaEnBloque("idmodulo", $idmodulo, "crear_calificacion_sh");
    }

    if ($seguridad->verifica_permiso("Eliminar", "Stakeholder-Calificacion")) {
        $plantilla->iniciaBloque("eliminar_calificacion_sh");
        $plantilla->reemplazaEnBloque("idpersona", $idpersona, "eliminar_calificacion_sh");
        $plantilla->reemplazaEnBloque("idmodulo", $idmodulo, "eliminar_calificacion_sh");
    }

    return $plantilla->getPlantillaCadena();
}

function ver_editar_compromiso_stakeholder($idcompromiso, $idmodulo_compromiso, $idpersona = "", $idmodulo = "") {

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/compromiso/compromiso.html");

    $plantilla_interaccion = new DmpTemplate("../../../plantillas/stakeholder/interaccion/vista_interaccion.html");

    $plantilla->reemplaza("op_stakeholder", "actualizar_compromiso_stakeholder");
    $compromiso_estado = new icompromiso_estado();
    $oicompromiso = new icompromiso();
    $acompromiso = $oicompromiso->get_compromiso($idcompromiso, $idmodulo_compromiso);
    $result = $compromiso_estado->lista_compromiso_estado();

    $plantilla_interaccion->reemplaza("interaccion", $acompromiso['interaccion']);
    $plantilla_interaccion->reemplaza("fecha_interaccion", date("d/m/Y", strtotime($acompromiso['fecha_interaccion'])));

    $plantilla->reemplaza("contenido_interaccion", $plantilla_interaccion->getPlantillaCadena());
    ///echo $acompromiso['compromiso'][$idcompromiso."-".$idmodulo_compromiso];
    $plantilla->reemplaza("idcompromiso", $idcompromiso);
    $plantilla->reemplaza("idmodulo_compromiso", $idmodulo_compromiso);

    $plantilla->reemplaza("compromiso", $acompromiso['compromiso'][$idcompromiso . "-" . $idmodulo_compromiso]);

    $plantilla->reemplaza("compromiso_comentario", $acompromiso['comentario'][$idcompromiso . "-" . $idmodulo_compromiso]);

    while ($fila = mysql_fetch_array($result)) {
        $plantilla->iniciaBloque("compromiso_estado");
        $plantilla->reemplazaEnBloque("compromiso_estado", $fila[compromiso_estado], "compromiso_estado");
        $plantilla->reemplazaEnBloque("idcompromiso_estado", $fila[idcompromiso_estado], "compromiso_estado");
        if ($acompromiso['idcompromiso_estado'][$idcompromiso . "-" . $idmodulo_compromiso] == $fila[idcompromiso_estado]) {
            $plantilla->reemplazaEnBloque("selected", "selected", "compromiso_estado");
        }
    }

    $compromiso_prioridad = new icompromiso_prioridad();
    $result = $compromiso_prioridad->lista_compromiso_prioridad();

    while ($fila = mysql_fetch_array($result)) {
        $plantilla->iniciaBloque("compromiso_prioridad");
        $plantilla->reemplazaEnBloque("compromiso_prioridad", $fila[compromiso_prioridad], "compromiso_prioridad");
        $plantilla->reemplazaEnBloque("idcompromiso_prioridad", $fila[idcompromiso_prioridad], "compromiso_prioridad");
        if ($acompromiso['idcompromiso_prioridad'][$idcompromiso . "-" . $idmodulo_compromiso] == $fila[idcompromiso_prioridad]) {

            $plantilla->reemplazaEnBloque("selected", "selected", "compromiso_prioridad");
        }
    }
    $plantilla->reemplaza("fecha_compromiso", $acompromiso['fecha'][$idcompromiso . "-" . $idmodulo_compromiso]);

    if ($acompromiso['fecha_fin'][$idcompromiso . "-" . $idmodulo_compromiso] != "00/00/0000")
        $plantilla->reemplaza("fecha_fin_compromiso", $acompromiso['fecha_fin'][$idcompromiso . "-" . $idmodulo_compromiso]);

    for ($h = 0; $h < 24; $h++) {
        $plantilla->iniciaBloque("hora_compromiso");
        $hora = "";
        if ($h > 9) {
            $hora.=$h;
        } else {
            $hora.= "0" . $h;
        }
        $plantilla->reemplazaEnBloque("hora", $hora, "hora_compromiso");
        if ($hora == $acompromiso['hora'][$idcompromiso . "-" . $idmodulo_compromiso]) {
            $plantilla->reemplazaEnBloque("selected", "selected", "hora_compromiso");
        }

        $hora_fin = "";
        $plantilla->iniciaBloque("hora_fin_compromiso");
        if ($h > 9) {
            $hora_fin.=$h;
        } else {
            $hora_fin.="0" . $h;
        }
        $plantilla->reemplazaEnBloque("hora", $hora_fin, "hora_fin_compromiso");
        if ($hora_fin == $acompromiso['hora_fin'][$idcompromiso . "-" . $idmodulo_compromiso]) {
            $plantilla->reemplazaEnBloque("selected", "selected", "hora_fin_compromiso");
        }
    }
    for ($m = 0; $m < 6; $m++) {
        $plantilla->iniciaBloque("minuto_compromiso");
        if ($m * 10 > 9) {
            $plantilla->reemplazaEnBloque("minuto", ($m * 10), "minuto_compromiso");
        } else {
            $plantilla->reemplazaEnBloque("minuto", "0" . ($m * 10), "minuto_compromiso");
        }
        if (($m * 10) == $acompromiso['minuto'][$idcompromiso . "-" . $idmodulo_compromiso]) {
            $plantilla->reemplazaEnBloque("selected", "selected", "minuto_compromiso");
        }

        $plantilla->iniciaBloque("minuto_fin_compromiso");
        if ($m * 10 > 9) {
            $plantilla->reemplazaEnBloque("minuto", ($m * 10), "minuto_fin_compromiso");
        } else {
            $plantilla->reemplazaEnBloque("minuto", "0" . ($m * 10), "minuto_fin_compromiso");
        }
        if (($m * 10) == $acompromiso['minuto_fin'][$idcompromiso . "-" . $idmodulo_compromiso]) {
            $plantilla->reemplazaEnBloque("selected", "selected", "minuto_fin_compromiso");
        }
    }
    ###########################################################
    //RC
    $cont_rc_fila = 0;
    $cont_rc = 0;
    if (sizeof($acompromiso['rc'][$idcompromiso . "-" . $idmodulo_compromiso] > 0)) {

        foreach ($acompromiso['rc'][$idcompromiso . "-" . $idmodulo_compromiso] as $key => $rc) {
            if ($cont_rc % 5 == 0) {
                $plantilla->iniciaBloque("tr_rc_compromiso");
                $cont_rc_fila++;
                $cont_rc_celda = 0;
            }


            $plantilla->iniciaBloque("td_rc_compromiso");
            $plantilla->reemplazaEnBloque("rc", $rc, "td_rc_compromiso");
            $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "td_rc_compromiso");
            $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "td_rc_compromiso");

            $plantilla->iniciaBloque("idcompromiso_complejo_rc");

            $plantilla->reemplazaEnBloque("idcompromiso_complejo_rc", $acompromiso['idcompromiso_rc'][$idcompromiso . "-" . $idmodulo_compromiso][$key] . "***" . $acompromiso['idmodulo_compromiso_rc'][$idcompromiso . "-" . $idmodulo_compromiso][$key] . "***1", "idcompromiso_complejo_rc");
            $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "idcompromiso_complejo_rc");
            $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "idcompromiso_complejo_rc");

            //if ($_SESSION[idusu] . "-" . $_SESSION[idmodulo_a] != $acompromiso['idrc'][$idcompromiso . "-" . $idmodulo_compromiso][$key] . "-" . $acompromiso['rc_idmodulo'][$idcompromiso . "-" . $idmodulo_compromiso][$key]) {
            $plantilla->iniciaBloque("eliminar_rc_compromiso");
            $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "eliminar_rc_compromiso");
            $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "eliminar_rc_compromiso");
            //}

            $cont_rc_celda++;
            $cont_rc++;
        }
    }

    $plantilla->reemplaza("cant_rc", $cont_rc);

    ////antes coloco el numero real de celdas y filas
    $plantilla->reemplaza("nume_fila_compromiso_rc", $cont_rc_fila);
    $plantilla->reemplaza("nume_celda_compromiso_rc", $cont_rc_celda);

    ///
    while ($cont_rc_celda < 5) {
        $plantilla->iniciaBloque("td_rc_compromiso");
        $plantilla->reemplazaEnBloque("rc", "&nbsp;", "td_rc_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "td_rc_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "td_rc_compromiso");

        $cont_rc_celda++;
    }
    //sh
    $cont_sh = 0;
    $cont_sh_fila = 0;

    if (sizeof($acompromiso['sh'][$idcompromiso . "-" . $idmodulo_compromiso] > 0)) {

        foreach ($acompromiso['sh'][$idcompromiso . "-" . $idmodulo_compromiso] as $key => $sh) {

            if ($cont_sh % 5 == 0) {
                $plantilla->iniciaBloque("tr_sh_compromiso");
                $cont_sh_fila++;
                $cont_sh_celda = 0;
            }


            $plantilla->iniciaBloque("td_sh_compromiso");
            $plantilla->reemplazaEnBloque("sh", $sh, "td_sh_compromiso");
            $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "td_sh_compromiso");
            $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_compromiso");

            $plantilla->iniciaBloque("idcompromiso_complejo_sh");

            $plantilla->reemplazaEnBloque("idcompromiso_complejo_sh", $acompromiso['idcompromiso_sh'][$idcompromiso . "-" . $idmodulo_compromiso][$key] . "***" . $acompromiso['idmodulo_compromiso_sh'][$idcompromiso . "-" . $idmodulo_compromiso][$key] . "***1", "idcompromiso_complejo_sh");
            $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "idcompromiso_complejo_sh");
            $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "idcompromiso_complejo_sh");

            if ($idpersona . "-" . $idmodulo != $acompromiso['idsh'][$idcompromiso . "-" . $idmodulo_compromiso][$key] . "-" . $acompromiso['sh_idmodulo'][$idcompromiso . "-" . $idmodulo_compromiso][$key]) {
                $plantilla->iniciaBloque("eliminar_sh_compromiso");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "eliminar_sh_compromiso");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "eliminar_sh_compromiso");
            }

            $cont_sh_celda++;
            $cont_sh++;
        }
    }

    $plantilla->reemplaza("cant_sh", $cont_sh);

    $plantilla->reemplaza("nume_fila_compromiso_sh", $cont_sh_fila);
    $plantilla->reemplaza("nume_celda_compromiso_sh", $cont_sh_celda);

    ///
    while ($cont_sh_celda < 5) {
        $plantilla->iniciaBloque("td_sh_compromiso");
        $plantilla->reemplazaEnBloque("sh", "&nbsp;", "td_sh_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "td_sh_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_compromiso");

        $cont_sh_celda++;
    }

    //documento

    $result = $oicompromiso->lista_archivo($idcompromiso, $idmodulo_compromiso);

    while ($fila = mysql_fetch_array($result)) {
        $plantilla->iniciaBloque("archivo");
        $plantilla->reemplazaEnBloque("idcompromiso_archivo", $fila[idcompromiso_archivo], "archivo");
        $plantilla->reemplazaEnBloque("idmodulo_compromiso_archivo", $fila[idmodulo_compromiso_archivo], "archivo");
        $plantilla->reemplazaEnBloque("archivo", $fila[archivo], "archivo");
        $plantilla->reemplazaEnBloque("activo", $fila[activo], "archivo");
        $plantilla->reemplazaEnBloque("ruta", $idcompromiso . '_' . $fila[archivo], "archivo");
        $plantilla->reemplazaEnBloque("fecha", date("d/m/Y", strtotime($fila[fecha_c])), "archivo");
    }


    $plantilla->reemplaza("idmodulo_interaccion_compromiso", "$idmodulo_interaccion");

    $plantilla->reemplaza("idinteraccion_compromiso", "$idinteraccion");


    $plantilla->presentaPlantilla();

    ###########################################################
}

function ver_compromiso_stakeholder($idpersona, $idmodulo, $idinteraccion = "", $idmodulo_interaccion = "", $idcompromiso = "", $idmodulo_compromiso = "") {

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/compromiso/compromiso.html");
    $plantilla->reemplaza("fecha_compromiso", date('d/m/Y'));
    $plantilla->reemplaza("op_stakeholder", "guardar_compromiso_stakeholder");
    $compromiso_estado = new icompromiso_estado();
    $result = $compromiso_estado->lista_compromiso_estado();

    while ($fila = mysql_fetch_array($result)) {
        $plantilla->iniciaBloque("compromiso_estado");
        $plantilla->reemplazaEnBloque("compromiso_estado", $fila[compromiso_estado], "compromiso_estado");
        $plantilla->reemplazaEnBloque("idcompromiso_estado", $fila[idcompromiso_estado], "compromiso_estado");
    }

    $max_upload = (int) (ini_get('upload_max_filesize'));
    $max_post = (int) (ini_get('post_max_size'));
    $memory_limit = (int) (ini_get('memory_limit'));
    $upload_mb = min($max_upload, $max_post, $memory_limit);

    $plantilla->reemplaza("maximo", $upload_mb);


    $compromiso_prioridad = new icompromiso_prioridad();
    $result = $compromiso_prioridad->lista_compromiso_prioridad();

    while ($fila = mysql_fetch_array($result)) {
        $plantilla->iniciaBloque("compromiso_prioridad");
        $plantilla->reemplazaEnBloque("compromiso_prioridad", $fila[compromiso_prioridad], "compromiso_prioridad");
        $plantilla->reemplazaEnBloque("idcompromiso_prioridad", $fila[idcompromiso_prioridad], "compromiso_prioridad");
    }

    for ($h = 0; $h < 24; $h++) {
        $plantilla->iniciaBloque("hora_compromiso");
        if ($h > 9) {
            $plantilla->reemplazaEnBloque("hora", $h, "hora_compromiso");
        } else {
            $plantilla->reemplazaEnBloque("hora", "0" . $h, "hora_compromiso");
        }
        $plantilla->iniciaBloque("hora_fin_compromiso");
        if ($h > 9) {
            $plantilla->reemplazaEnBloque("hora", $h, "hora_fin_compromiso");
        } else {
            $plantilla->reemplazaEnBloque("hora", "0" . $h, "hora_fin_compromiso");
        }
    }
    for ($m = 0; $m < 6; $m++) {
        $plantilla->iniciaBloque("minuto_compromiso");
        if ($m * 10 > 9) {
            $plantilla->reemplazaEnBloque("minuto", ($m * 10), "minuto_compromiso");
        } else {
            $plantilla->reemplazaEnBloque("minuto", "0" . ($m * 10), "minuto_compromiso");
        }
        $plantilla->iniciaBloque("minuto_fin_compromiso");
        if ($m * 10 > 9) {
            $plantilla->reemplazaEnBloque("minuto", ($m * 10), "minuto_fin_compromiso");
        } else {
            $plantilla->reemplazaEnBloque("minuto", "0" . ($m * 10), "minuto_fin_compromiso");
        }
    }

    //rc
    $ointeraccion = new iinteraccion();
    $result_rc = $ointeraccion->lista_interaccion_rc($idinteraccion, $idmodulo_interaccion);
    $cont_rc = 0;
    $cont_rc_fila = 0;

    while (!!$fila_rc = mysql_fetch_array($result_rc)) {
        if ($cont_rc % 5 == 0) {
            $plantilla->iniciaBloque("tr_rc_compromiso");
            $cont_rc_fila++;
            $cont_rc_celda = 0;
        }

        $plantilla->iniciaBloque("td_rc_compromiso");
        $plantilla->reemplazaEnBloque("rc", utf8_encode($fila_rc[nombre] . " " . $fila_rc[apellido_p] . " " . $fila_rc[apellido_m]), "td_rc_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "td_rc_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "td_rc_compromiso");

        $plantilla->iniciaBloque("idcompromiso_complejo_rc");

        $plantilla->reemplazaEnBloque("idcompromiso_complejo_rc", $fila_rc[idpersona] . "---" . $fila_rc[idmodulo], "idcompromiso_complejo_rc");
        $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "idcompromiso_complejo_rc");
        $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "idcompromiso_complejo_rc");

        //if ($_SESSION[idusu] . "-" . $_SESSION[idmodulo_a] != $fila_rc[idpersona] . "-" . $fila_rc[idmodulo]) {
        $plantilla->iniciaBloque("eliminar_rc_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "eliminar_rc_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "eliminar_rc_compromiso");
        //}
        $cont_rc++;
        $cont_rc_celda++;
    }

    $plantilla->reemplaza("cant_rc", $cont_rc);
    ////antes coloco el numero real de celdas y filas
    $plantilla->reemplaza("nume_fila_compromiso_rc", $cont_rc_fila);
    $plantilla->reemplaza("nume_celda_compromiso_rc", $cont_rc_celda);

    ///
    while ($cont_rc_celda < 5) {
        $plantilla->iniciaBloque("td_rc_compromiso");
        $plantilla->reemplazaEnBloque("rc", "&nbsp;", "td_rc_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "td_rc_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "td_rc_compromiso");

        $cont_rc_celda++;
    }


    //sh
    $resulta_sh = $ointeraccion->lista_interaccion_sh($idinteraccion, $idmodulo_interaccion);
    $cont_sh = 0;
    $cont_sh_fila = 0;
    while (!!$fila_sh = mysql_fetch_array($resulta_sh)) {
        if ($cont_sh % 5 == 0) {
            $plantilla->iniciaBloque("tr_sh_compromiso");
            $cont_sh_fila++;
            $cont_sh_celda = 0;
        }
        $plantilla->iniciaBloque("td_sh_compromiso");
        $plantilla->reemplazaEnBloque("sh", utf8_encode($fila_sh[nombre] . " " . $fila_sh[apellido_p] . " " . $fila_sh[apellido_m]), "td_sh_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "td_sh_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_compromiso");

        $plantilla->iniciaBloque("idcompromiso_complejo_sh");
        $plantilla->reemplazaEnBloque("idcompromiso_complejo_sh", $fila_sh[idpersona] . "---" . $fila_sh[idmodulo], "idcompromiso_complejo_sh");
        $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "idcompromiso_complejo_sh");
        $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "idcompromiso_complejo_sh");


        //if ($idpersona . "-" . $idmodulo != $fila_sh[idpersona] . "-" . $fila_sh[idmodulo]) {
        $plantilla->iniciaBloque("eliminar_sh_compromiso");
        //***1 el estado activo, al cambiar a 0, el estado desactivo

        $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "eliminar_sh_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "eliminar_sh_compromiso");
        //}
        $cont_sh++;
        $cont_sh_celda++;
    }

    $plantilla->reemplaza("cant_sh", $cont_sh);

    $plantilla->reemplaza("nume_fila_compromiso_sh", $cont_sh_fila);
    $plantilla->reemplaza("nume_celda_compromiso_sh", $cont_sh_celda);

    $max_upload = (int) (ini_get('upload_max_filesize'));
    $max_post = (int) (ini_get('post_max_size'));
    $memory_limit = (int) (ini_get('memory_limit'));
    $upload_mb = min($max_upload, $max_post, $memory_limit);

    $plantilla->reemplaza("maximo", $upload_mb);

    ///
    while ($cont_sh_celda < 5) {
        $plantilla->iniciaBloque("td_sh_compromiso");
        $plantilla->reemplazaEnBloque("rc", "&nbsp;", "td_sh_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "td_sh_compromiso");
        $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_compromiso");

        $cont_sh_celda++;
    }
    $plantilla->reemplaza("idmodulo_interaccion_compromiso", "$idmodulo_interaccion");

    $plantilla->reemplaza("idinteraccion_compromiso", "$idinteraccion");


    $plantilla->presentaPlantilla();
}

function eliminar_interaccion_stakeholder($idinteraccion, $idmodulo_interaccion) {
    $gstakeholder = new gstakeholder();
    $respuesta = $gstakeholder->eliminar_interaccion($idinteraccion, $idmodulo_interaccion);

    if ($respuesta[0] == 0) {
        if ($respuesta[1] == 0) {
            $data['success'] = true;
            $data['mensaje'] = coloca_mensaje("elimina_ok", " de la interaccion ");
        } else {
            $data['success'] = false;
            $data['mensaje'] = "No se puede eliminar la interaccion porque tiene compromisos";
        }
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " de la interaccion ");
    }

    echo json_encode($data);
}

function createThumbs($folder) {

    $pathToImages = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR;
    // open the directory
    $dir = opendir($pathToImages);

    // loop through it, looking for any/all JPG files:
    while (false !== ($fname = readdir($dir))) {
        // parse path for the extension
        $thumb = new thumb();

        // continue only if this is a JPEG image
        if ($thumb->loadImage($pathToImages . $fname)) {
            echo "Creating thumbnail for {$fname} <br />";
            $thumbfile = $pathToImages . "thumbnail" . DIRECTORY_SEPARATOR . $fname;
            $thumb->resize(100, 'height');
            $thumb->save($thumbfile);
        }
    }
    // close the directory
    closedir($dir);
}

function ver_predio_stakolder_complejo($idpredio, $idmodulo_predio, $nombre) {

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/predio_complejo.html");

    $max_upload = (int) (ini_get('upload_max_filesize'));
    $max_post = (int) (ini_get('post_max_size'));
    $memory_limit = (int) (ini_get('memory_limit'));
    $upload_mb = min($max_upload, $max_post, $memory_limit);

    $plantilla->reemplaza("maximo", $upload_mb);

    ///actualizar
    //solo uno xq se sobre entiende que viene el idmodulo
    $plantilla->reemplaza("idpredio", $idpredio);
    $plantilla->reemplaza("idmodulo_predio", $idmodulo_predio);


    $plantilla->reemplaza("op_stakeholder", "actualizar_predio_stakeholder");


    $ostakeholder = new istakeholder();

    //tag
    $result_tag = $ostakeholder->lista_tag_predio($idpredio, $idmodulo_predio);
    $cont_tag = 0;
    $cont_tag_fila = 0;
    $cont_tag_celda = 0;

    while (!!$fila_tag = mysql_fetch_array($result_tag)) {
        if ($cont_tag % 5 == 0) {
            $plantilla->iniciaBloque("tr_tag_predio");
            $cont_tag_fila++;
            $cont_tag_celda = 0;
        }
        $plantilla->iniciaBloque("td_tag_predio");
        $plantilla->reemplazaEnBloque("tag", utf8_encode($fila_tag[tag]), "td_tag_predio");
        $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "td_tag_predio");
        $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "td_tag_predio");
        $plantilla->iniciaBloque("spinner_tag_predio");
        $plantilla->reemplazaEnBloque("prioridad", $fila_tag[prioridad], "spinner_tag_predio");

        $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "spinner_tag_predio");
        $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "spinner_tag_predio");
        $plantilla->iniciaBloque("eliminar_tag_predio");
        $plantilla->reemplazaEnBloque("predio_complejo_tag", $fila_tag[idpredio_tag] . "***" . $fila_tag[idmodulo_predio_tag] . "***1", "eliminar_tag_predio");

        $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "eliminar_tag_predio");
        $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "eliminar_tag_predio");


        $cont_tag++;
        $cont_tag_celda++;
    }

    ////antes coloco el numero real de celdas y filas
    $plantilla->reemplaza("nume_fila_predio_tag_complejo", $cont_tag_fila);
    $plantilla->reemplaza("nume_celda_predio_tag_complejo", $cont_tag_celda);

    ///
    while ($cont_tag_celda < 5) {
        $plantilla->iniciaBloque("td_tag_predio");
        $plantilla->reemplazaEnBloque("tag", "&nbsp;", "td_tag_predio");
        $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "td_tag_predio");
        $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "td_tag_predio");

        $cont_tag_celda++;
    }

    $result = $ostakeholder->get_predio($idpredio, $idmodulo_predio);

    if ($fila = mysql_fetch_array($result)) {

        $plantilla->reemplaza("comentario_predio", utf8_encode($fila[comentario]));

        //documento

        $result = $ostakeholder->lista_archivo_predio($idpredio);

        while ($fila = mysql_fetch_array($result)) {
            $plantilla->iniciaBloque("archivo");
            $plantilla->reemplazaEnBloque("idpredio_archivo", $fila[idpredio_archivo], "archivo");
            $plantilla->reemplazaEnBloque("idmodulo_predio_archivo", $fila[idmodulo_predio_archivo], "archivo");
            $plantilla->reemplazaEnBloque("archivo", $fila[archivo], "archivo");
            $plantilla->reemplazaEnBloque("activo", $fila[activo], "archivo");
            $plantilla->reemplazaEnBloque("ruta", $idpredio . '_' . $fila[archivo], "archivo");
            //$plantilla->reemplazaEnBloque("fecha", date("d/m/Y", strtotime($fila[fecha_c]) ), "archivo");
        }
    }


    $plantilla->presentaPlantilla();
}

function ver_item_compromiso($idcompromiso, $idmodulo_compromiso) {

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/compromiso/item_compromiso.html");
    //listar interaccion stakeholder
    $icompromiso = new icompromiso();


    $acompromiso = $icompromiso->lista_item_compromiso($idcompromiso, $idmodulo_compromiso);

    $seguridad = new Seguridad();

    if (count($acompromiso) > 0) {
        $numero = 0;
        foreach ($acompromiso[idcompromiso] as $key => $valor) {
            $count++;
            $numero ++;

            $plantilla->iniciaBloque("item_compromiso");
            $plantilla->reemplazaEnBloque("numero", $numero, "item_compromiso");
            $plantilla->reemplazaEnBloque("fecha_compromiso", $acompromiso['fecha'][$key], "item_compromiso");
            $plantilla->reemplazaEnBloque("compromiso", $acompromiso['compromiso'][$key], "item_compromiso");
            $plantilla->reemplazaEnBloque("idcompromiso", $acompromiso['idcompromiso'][$key], "item_compromiso");
            $plantilla->reemplazaEnBloque("idmodulo_compromiso", $acompromiso['idmodulo_compromiso'][$key], "item_compromiso");


            //RC
            if (sizeof($acompromiso['rc'][$key]) > 0) {

                foreach ($acompromiso['rc'][$key] as $rc_key => $rc) {
                    if ($rc_key == "$idpersona-$idmodulo") {
                        $nombre = $rc;
                    }

                    $plantilla->iniciaBloque("rc_compromiso");
                    $plantilla->reemplazaEnBloque("rc", $rc, "rc_compromiso");
                }
            }

            ///sh
            if (sizeof($acompromiso['sh'][$key]) > 0) {

                foreach ($acompromiso['sh'][$key] as $sh_key => $sh) {
                    //echo "sh: $sh";

                    $plantilla->iniciaBloque("sh_compromiso");
                    $plantilla->reemplazaEnBloque("idsh", $acompromiso['idsh'][$key][$sh_key], "sh_compromiso");
                    $plantilla->reemplazaEnBloque("idmodulo", $acompromiso['sh_idmodulo'][$key][$sh_key], "sh_compromiso");
                    $plantilla->reemplazaEnBloque("sh", $sh, "sh_compromiso");

                    $plantilla->reemplazaEnBloque("idpersona_tipo", $acompromiso['sh_idpersona_tipo'][$key][$sh_key], "sh_compromiso");
                    if ($acompromiso['sh_imagen'][$key][$sh_key] != "") {
                        $plantilla->reemplazaEnBloque("imagen", "../../../archivo/" . $_SESSION['proyecto'] . "/imagen/" . $acompromiso['sh_imagen'][$key][$sh_key], "sh_compromiso");
                    } else {
                        $plantilla->reemplazaEnBloque("imagen", "../../../img/imagen.png", "sh_compromiso");
                    }
                }
            }

            //imagenes
            if (sizeof($acompromiso['archivo'][$key]) > 0) {

                foreach ($acompromiso['archivo'][$key] as $archivo_key => $archivo) {
                    $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "compromiso" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $acompromiso[idcompromiso][$key] . '_' . $archivo;
                    $thumb = new thumb();
                    if ($thumb->loadImage($thumbfile)) {
                        $plantilla->iniciaBloque("imagen");
                        $plantilla->reemplazaEnBloque("proyecto", $_SESSION['proyecto'], "imagen");
                        $plantilla->reemplazaEnBloque("archivo", $acompromiso[idcompromiso][$key] . '_' . $archivo, "imagen");
                        $plantilla->reemplazaEnBloque("nombre", $archivo, "imagen");
                    }
                }
            }

            $archivos = array();
            //archivos
            if (sizeof($acompromiso['archivo'][$key]) > 0) {

                foreach ($acompromiso['archivo'][$key] as $archivo_key => $archivo) {
                    $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "compromiso" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $acompromiso[idcompromiso][$key] . '_' . $archivo;
                    $thumb = new thumb();
                    if (!$thumb->loadImage($thumbfile)) {
                        $archivos[] = $acompromiso[idcompromiso][$key] . '_' . $archivo;
                    }
                }
                $aux = 0;
                foreach ($archivos as $archivo) {
                    $aux++;
                    $plantilla->iniciaBloque("archivo");
                    $plantilla->reemplazaEnBloque("archivo", $archivo, "archivo");
                    if ($aux < count($archivos)) {
                        $plantilla->reemplazaEnBloque("coma", " , ", "archivo");
                    }
                }
            }


            if ($seguridad->verifica_permiso("Editar", "Compromiso", $acompromiso['idusu_c'][$key], $acompromiso['idmodulo_c'][$key])) {
                $plantilla->iniciaBloque("editar_compromiso");
                $plantilla->reemplazaEnBloque("idcompromiso", $acompromiso['idcompromiso'][$key], "editar_compromiso");
                $plantilla->reemplazaEnBloque("idmodulo_compromiso", $acompromiso['idmodulo_compromiso'][$key], "editar_compromiso");
            }

            if ($seguridad->verifica_permiso("Eliminar", "Compromiso", $acompromiso['idusu_c'][$key], $acompromiso['idmodulo_c'][$key])) {
                $plantilla->iniciaBloque("eliminar_compromiso");
                $plantilla->reemplazaEnBloque("idcompromiso", $acompromiso['idcompromiso'][$key], "eliminar_compromiso");
                $plantilla->reemplazaEnBloque("idmodulo_compromiso", $acompromiso['idmodulo_compromiso'][$key], "eliminar_compromiso");
            }
        }
    }


    return $plantilla->getPlantillaCadena();
    //return $plantilla->presentaPlantilla();
}

function ver_cuerpo_compromiso($idpersona, $idmodulo, $inicio) {
    $modo = 1;
    $limite = $inicio;
    $seguridad = new Seguridad();
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/compromiso/lateral_compromiso.html");
    $count = 0;
    $icompromiso = new icompromiso();
    if ($seguridad->verifica_permiso("Ver", "Inicio-Compromisos") && $modo == 1) {
        $acompromiso = $icompromiso->lista_compromiso($idpersona, $idmodulo, $inicio, 1);
    } else {
        $acompromiso = $icompromiso->lista_compromiso($idpersona, $idmodulo, $inicio, 0);
    }


    $seguridad = new Seguridad();

    if (count($acompromiso) > 0) {
        $numero = 0;
        foreach ($acompromiso[idcompromiso] as $key => $valor) {
            $count++;
            $numero ++;
            if ($count < $limite) {
                $plantilla->iniciaBloque("item_compromiso");
                $plantilla->reemplazaEnBloque("numero", $numero, "item_compromiso");
                $plantilla->reemplazaEnBloque("fecha_compromiso", $acompromiso['fecha'][$key], "item_compromiso");
                $plantilla->reemplazaEnBloque("compromiso", $acompromiso['compromiso'][$key], "item_compromiso");
                $plantilla->reemplazaEnBloque("idcompromiso", $acompromiso['idcompromiso'][$key], "item_compromiso");
                $plantilla->reemplazaEnBloque("idmodulo_compromiso", $acompromiso['idmodulo_compromiso'][$key], "item_compromiso");


                //RC
                if (sizeof($acompromiso['rc'][$key]) > 0) {
                    $aux = 0;
                    foreach ($acompromiso['rc'][$key] as $rc_key => $rc) {
                        $aux++;
                        if ($rc_key == "$idpersona-$idmodulo") {
                            $nombre = $rc;
                        }

                        $plantilla->iniciaBloque("rc_compromiso");
                        $plantilla->reemplazaEnBloque("rc", $rc, "rc_compromiso");
                        if ($aux < sizeof($acompromiso['rc'][$key]) - 1) {
                            $plantilla->reemplazaEnBloque("coma", " , ", "rc_compromiso");
                        } elseif ($aux == sizeof($acompromiso['rc'][$key]) - 1) {
                            $plantilla->reemplazaEnBloque("coma", " y ", "rc_compromiso");
                        } else {
                            $plantilla->reemplazaEnBloque("coma", ".", "rc_compromiso");
                        }
                    }
                }

                ///sh
                if (sizeof($acompromiso['sh'][$key]) > 0) {

                    foreach ($acompromiso['sh'][$key] as $sh_key => $sh) {
                        //echo "sh: $sh";

                        $plantilla->iniciaBloque("sh_compromiso");
                        $plantilla->reemplazaEnBloque("idsh", $acompromiso['idsh'][$key][$sh_key], "sh_compromiso");
                        $plantilla->reemplazaEnBloque("idmodulo", $acompromiso['sh_idmodulo'][$key][$sh_key], "sh_compromiso");
                        $plantilla->reemplazaEnBloque("sh", $sh, "sh_compromiso");

                        $plantilla->reemplazaEnBloque("idpersona_tipo", $acompromiso['sh_idpersona_tipo'][$key][$sh_key], "sh_compromiso");
                        if ($acompromiso['sh_imagen'][$key][$sh_key] != "") {
                            $plantilla->reemplazaEnBloque("imagen", "../../../archivo/" . $_SESSION['proyecto'] . "/imagen/" . $acompromiso['sh_imagen'][$key][$sh_key], "sh_compromiso");
                        } else {
                            $plantilla->reemplazaEnBloque("imagen", "../../../img/imagen.png", "sh_compromiso");
                        }
                    }
                }

                //imagenes
                if (sizeof($acompromiso['archivo'][$key]) > 0) {

                    foreach ($acompromiso['archivo'][$key] as $archivo_key => $archivo) {
                        $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "compromiso" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $acompromiso[idcompromiso][$key] . '_' . $archivo;
                        $thumb = new thumb();
                        if ($thumb->loadImage($thumbfile)) {
                            $plantilla->iniciaBloque("imagen");
                            $plantilla->reemplazaEnBloque("proyecto", $_SESSION['proyecto'], "imagen");
                            $plantilla->reemplazaEnBloque("archivo", $acompromiso[idcompromiso][$key] . '_' . $archivo, "imagen");
                            $plantilla->reemplazaEnBloque("nombre", $archivo, "imagen");
                        }
                    }
                }

                $archivos = array();
                //archivos
                if (sizeof($acompromiso['archivo'][$key]) > 0) {

                    foreach ($acompromiso['archivo'][$key] as $archivo_key => $archivo) {
                        $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "compromiso" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $acompromiso[idcompromiso][$key] . '_' . $archivo;
                        $thumb = new thumb();
                        if (!$thumb->loadImage($thumbfile)) {
                            $archivos[] = $acompromiso[idcompromiso][$key] . '_' . $archivo;
                        }
                    }
                    $aux = 0;
                    foreach ($archivos as $archivo) {
                        $aux++;
                        $plantilla->iniciaBloque("archivo");
                        $plantilla->reemplazaEnBloque("archivo", $archivo, "archivo");
                        if ($aux < count($archivos)) {
                            $plantilla->reemplazaEnBloque("coma", " , ", "archivo");
                        }
                    }
                }


                if ($seguridad->verifica_permiso("Editar", "Compromiso", $acompromiso['idusu_c'][$key], $acompromiso['idmodulo_c'][$key])) {
                    $plantilla->iniciaBloque("editar_compromiso");
                    $plantilla->reemplazaEnBloque("idcompromiso", $acompromiso['idcompromiso'][$key], "editar_compromiso");
                    $plantilla->reemplazaEnBloque("idmodulo_compromiso", $acompromiso['idmodulo_compromiso'][$key], "editar_compromiso");
                }

                if ($seguridad->verifica_permiso("Eliminar", "Compromiso", $acompromiso['idusu_c'][$key], $acompromiso['idmodulo_c'][$key])) {
                    $plantilla->iniciaBloque("eliminar_compromiso");
                    $plantilla->reemplazaEnBloque("idcompromiso", $acompromiso['idcompromiso'][$key], "eliminar_compromiso");
                    $plantilla->reemplazaEnBloque("idmodulo_compromiso", $acompromiso['idmodulo_compromiso'][$key], "eliminar_compromiso");
                }
            }
        }
    }
    if ($count == $limite) {
        $limite = $limite + 10;
        $plantilla->reemplaza("limite", $limite);
        $plantilla->reemplaza("ver_mas", "ver m&aacute;s");
    }


    $plantilla_tabla = new DmpTemplate("../../../plantillas/stakeholder/compromiso/tabla_compromiso.html");
    $plantilla_tabla->reemplaza("bloque_compromiso", $plantilla->getPlantillaCadena());
    $plantilla_tabla->reemplaza("inicio", $inicio + 10);
    $plantilla_tabla->reemplaza("idpersona", $idpersona);
    $plantilla_tabla->reemplaza("idmodulo", $idmodulo);
    $plantilla_tabla->reemplaza("persona", $persona); // ver mas
    $plantilla_tabla->reemplaza("presenta", 1); // ver mas

    if ($modo == 1) {
        $plantilla_tabla->iniciaBloque("enlaces");
        $plantilla_tabla->reemplazaEnBloque("nombre", $nombre, "enlaces");
        $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona, "enlaces");
        $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo, "enlaces");
        /*
          if($seguridad->verifica_permiso("Crear", "Interaccion"))
          $plantilla_tabla->iniciaBloque ("crear_interaccion");
          if($seguridad->verifica_permiso("Crear", "Reclamo"))
          $plantilla_tabla->iniciaBloque ("crear_reclamo");
         * 
         */
    } else {
        //$plantilla_tabla->reemplaza("titulo", "Compromisos");
    }

    if ($numero > 0) {

        $plantilla_tabla->reemplazaEnBloque("numero", $numero, "enlaces");
        $plantilla_tabla->reemplazaEnBloque("de", "de", "enlaces");
        $plantilla_tabla->reemplazaEnBloque("total", $acompromiso['total'], "enlaces");
        if ($numero < $acompromiso['total']) {
            /*
              $plantilla_tabla->iniciaBloque("ver_mas");
              $plantilla_tabla->reemplazaEnBloque("inicio", $inicio + 10,"ver_mas");
              //$plantilla_tabla->reemplazaEnBloque("nombre", $nombre, "ver_mas");
              $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona , "ver_mas");
              $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo , "ver_mas");
              $plantilla_tabla->reemplazaEnBloque("persona", $persona , "ver_mas"); // ver mas
              $plantilla_tabla->reemplazaEnBloque("presenta", 1, "ver_mas"); // ver mas
              $plantilla_tabla->reemplazaEnBloque("modo", $modo, "ver_mas"); // ver mas
             * 
             */
        }
    }

    if ($numero == 0) {
        $plantilla_tabla->iniciaBloque("mensaje");
    }

    $plantilla = $plantilla_tabla;


    $plantilla->presentaPlantilla();
    //return $plantilla->getPlantillaCadena();
}

function ver_cuerpo_reclamo($todos = 0, $flag_estado = 1, $limite = "") {

    $plantilla = new DmpTemplate("../../../plantillas/reclamo/reclamo/lateral_reclamo.html");
    $count = 0;
    $ireclamo = new ireclamo();
    $areclamo = $ireclamo->lista_relacionista_reclamo($_SESSION["idpersona"], $_SESSION["idmodulo_persona"], $limite);

    $seguridad = new Seguridad();

    if (count($areclamo) > 0) {

        foreach ($areclamo[idreclamo] as $key => $valor) {
            $count++;
            if ($count < $limite) {
                $plantilla->iniciaBloque("item_reclamo");
                $plantilla->reemplazaEnBloque("fecha_reclamo", $areclamo['fecha'][$key], "item_reclamo");
                $plantilla->reemplazaEnBloque("reclamo", $areclamo['reclamo'][$key], "item_reclamo");
                $plantilla->reemplazaEnBloque("idreclamo", $areclamo['idreclamo'][$key], "item_reclamo");
                $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo['idmodulo_reclamo'][$key], "item_reclamo");
                if ($seguridad->verifica_permiso("Editar", "Reclamo", $areclamo['idusu_c'][$key], $areclamo['idmodulo_c'][$key])) {
                    $plantilla->iniciaBloque("editar_reclamo");
                    $plantilla->reemplazaEnBloque("idreclamo", $areclamo['idreclamo'][$key], "editar_reclamo");
                    $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo['idmodulo_reclamo'][$key], "editar_reclamo");
                }

                if ($seguridad->verifica_permiso("Eliminar", "Reclamo", $areclamo['idusu_c'][$key], $areclamo['idmodulo_c'][$key])) {
                    $plantilla->iniciaBloque("eliminar_reclamo");
                    $plantilla->reemplazaEnBloque("idreclamo", $areclamo['idreclamo'][$key], "eliminar_reclamo");
                    $plantilla->reemplazaEnBloque("idmodulo_reclamo", $areclamo['idmodulo_reclamo'][$key], "eliminar_reclamo");
                }
            }
        }
    }
    if ($count == $limite) {
        $limite = $limite + 10;
        $plantilla->reemplaza("limite", $limite);
        $plantilla->reemplaza("ver_mas", "ver m&aacute;s");
    }
    //echo $plantilla->presentaPlantilla();
    return $plantilla->getPlantillaCadena();
}

function ver_interaccion_stakeholder($idpersona = "", $idmodulo = "", $idinteraccion = "", $idmodulo_interaccion = "", $persona = "", $presenta) {
    $seguridad = new Seguridad();
    //echo $idpersona." ".$idmodulo;
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/interaccion/interaccion.html");

    if (!$seguridad->verifica_permiso("Crear", "Interaccion"))
        $plantilla->iniciaBloque("crear_interaccion");

    $plantilla_interaccion = new DmpTemplate("../../../plantillas/stakeholder/interaccion/bloque_interaccion.html");
    $plantilla->reemplaza("idpersona", $idpersona);
    $plantilla->reemplaza("idmodulo", $idmodulo);
    $plantilla->reemplaza("persona", $persona);
    //$plantilla->reemplaza("idinteraccion_sh", $idpersona . "---" . $idmodulo);
    //echo $_SESSION[idusu] . "---" . $_SESSION[idmodulo_a];
    //$plantilla->reemplaza("idinteraccion_rc", $_SESSION[idpersona] . "---" . $_SESSION[idmodulo_persona]);
    $plantilla->iniciaBloque("tr_rc_interaccion");
    $plantilla->iniciaBloque("td_rc_interaccion");
    $plantilla->reemplazaEnBloque("rc", $_SESSION[nombre] . " " . $_SESSION[apellido_p] . " " . $_SESSION[apellido_m], "td_rc_interaccion");
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

    $ipersona = new ipersona();

    $result_persona = $ipersona->get_persona($idpersona, $idmodulo);
    $fila_sh = mysql_fetch_array($result_persona);

    $plantilla->iniciaBloque("tr_sh_interaccion");
    $plantilla->iniciaBloque("td_sh_interaccion");
    $plantilla->reemplazaEnBloque("sh", $fila_sh[nombre] . " " . $fila_sh[apellido_p] . " " . $fila_sh[apellido_m], "td_sh_interaccion");
    $plantilla->reemplazaEnBloque("idsh", $fila_sh[idpersona], "td_sh_interaccion");
    $plantilla->reemplazaEnBloque("idmodulo", $fila_sh[idmodulo], "td_sh_interaccion");
    $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_interaccion");
    $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_interaccion");

    $plantilla->reemplaza("cant_sh", 1);

    $plantilla->iniciaBloque("idinteraccion_complejo_sh");

    $plantilla->reemplazaEnBloque("idinteraccion_complejo_sh", $fila_sh[idpersona] . "---" . $fila_sh[idmodulo], "idinteraccion_complejo_sh");
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
    $plantilla_interaccion = ver_bloque_interaccion($fila_sh[idpersona_tipo], $fila_sh[apellido_p] . " " . $fila_sh[apellido_m] . ", " . $fila_sh[nombre], $idpersona, $idmodulo, 50, $persona, $presenta, 0);

    $plantilla->reemplaza("tabla_interaccion", $plantilla_interaccion);

    if ($presenta == 0) {
        $plantilla->presentaPlantilla();
    } else {
        return $plantilla->getPlantillaCadena();
    }
}

function ver_bloque_interaccion($idpersona_tipo, $nombre, $idpersona, $idmodulo, $inicio, $persona = 1, $presenta, $modo, $idsh_compuesto) {
    // $presenta = 1;
    //$tabla_interaccion = 1;
    //persona 2 ve las interacciones del relacionista comunitario, usuario
    //persona 1 ve las interacciones del stakeholder
    //con cuerpo, si incluye los div y la tabla de interaccion
    //echo "nombre : $nombre";
    //echo "modo : $modo";

    $seguridad = new Seguridad();

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/interaccion/bloque_interaccion.html");
    $plantilla_tabla = new DmpTemplate("../../../plantillas/stakeholder/interaccion/tabla_interaccion.html");

    $flag = false;

    if (!is_array($idsh_compuesto) && count($idsh_compuesto) == 0) {
        $idsh_compuesto = array();
        $flag = true;
    }

    //listar interaccion stakeholder
    $istakeholder = new istakeholder();
    //depende si estoy en la pantalla principal o vengo de organizaciones
    if ($seguridad->verifica_permiso("Ver", "Inicio-Interacciones") && $modo == 1) {
        $ainteraccion = $istakeholder->lista_stakeholder_interaccion($idpersona, $idmodulo, $inicio, 0);
    } elseif ($modo == 2) {
        $ipersona = new ipersona ();
        $result = $ipersona->lista_organizacion_sh($idpersona, $idmodulo);
        $count = 0;
        while ($fila = mysql_fetch_array($result)) {
            //print_r($fila);
            if ($fila['idpersona_tipo'] > 1) {
                $datos['sh'][$count]['level'] = 0;
                $datos['sh'][$count]['sh'] = utf8_encode($fila['apellido_p']);
                $id = $fila['idpersona'] . '-' . $fila['idmodulo'];
                $valor = $id;
            } else {
                $id = $fila['idpersona'] . '-' . $fila['idmodulo'] . '-' . $fila['idorganizacion'] . '-' . $fila['idmodulo_organizacion'];
                $valor = $fila['idpersona'] . '-' . $fila['idmodulo'];
            }

            $datos['sh'][$count]['id'] = $id;

            $datos['sh'][$count]['sh'] = utf8_encode($fila['apellido_p'] . " " . $fila['apellido_m'] . " " . $fila['nombre']);
            $datos['sh'][$count]['check'] = "<input id=\"$id\" type=\"checkbox\" name=\"shs[]\"  value=\"$valor\" class=\"$valor\" onclick=\"actualiza_estado_sh('$id')\" checked /><input id=\"id$id\" type=\"hidden\"   value=\"$valor\" name=\"idsh_compuesto[]\" />";
            $datos['sh'][$count]['level'] = 1;

            $datos['sh'][$count]['loaded'] = true;
            $datos['sh'][$count]['parent'] = null;
            if ($datos['sh'][$count]['level'] > 0) {
                $datos['sh'][$count]['parent'] = $fila['idorganizacion'] . '-' . $fila['idmodulo_organizacion'];
                //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
            }
            $datos['sh'][$count]['isLeaf'] = true;
            $datos['sh'][$count]['expanded'] = false;
            if ($fila['idpersona_tipo'] > 1) {
                $datos['sh'][$count]['isLeaf'] = false;
                $datos['sh'][$count]['expanded'] = true;
            }
            if ($flag) {
                $idsh_compuesto[] = $valor;
            }
            $count++;
        }

        /*
          $plantilla_tabla->iniciaBloque("ver_filtro");

          $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona, "ver_filtro");
          $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo, "ver_filtro");
          $plantilla_tabla->reemplazaEnBloque("idpersona_tipo", $idpersona_tipo, "ver_filtro");
         */

        $ainteraccion = $istakeholder->lista_stakeholder_interaccion($idpersona, $idmodulo, $inicio, 0, $idsh_compuesto);
    } elseif ($modo == 3) {
        $ihogar = new ihogar ();
        $ahogar = $ihogar->get_hogar_sh($idpersona, $idmodulo);
        $count = 0;
        $aux_hogar = array();
        foreach ($ahogar[fecha_hogar] as $idhogar_complejo => $fecha_hogar) {
            //print_r($fila);

            foreach ($ahogar[sh][$idhogar_complejo] as $idhogar_sh_complejo => $nombre_sh) {
                $idhogar_sh = explode('---', $idhogar_sh_complejo);
                $id = $idhogar_sh[0] . '-' . $idhogar_sh[1];
                $valor = $idhogar_sh[0] . '-' . $idhogar_sh[1];

                if ($aux_hogar[$id] != $id) {
                    $aux_hogar[$id]=$id;
                    $datos['sh'][$count]['id'] = $id;

                    $datos['sh'][$count]['sh'] = utf8_encode($nombre_sh);
                    $datos['sh'][$count]['check'] = "<input id=\"$id\" type=\"checkbox\" name=\"shs[]\"  value=\"$valor\" class=\"$valor\" onclick=\"actualiza_estado_sh('$id')\" checked /><input id=\"id$id\" type=\"hidden\"   value=\"$valor\" name=\"idsh_compuesto[]\" />";
                    $datos['sh'][$count]['level'] = 1;

                    $datos['sh'][$count]['loaded'] = true;
                    $datos['sh'][$count]['parent'] = null;
                    //if ($datos['sh'][$count]['level'] > 0) {
                    //$datos['sh'][$count]['parent'] = $fila['idorganizacion'] . '-' . $fila['idmodulo_organizacion'];
                    //$datos['tags']['response'][$count]['parent']=$fila['idtag_padre'];
                    //}
                    $datos['sh'][$count]['isLeaf'] = true;
                    $datos['sh'][$count]['expanded'] = false;
                    if ($fila['idpersona_tipo'] > 1) {
                        $datos['sh'][$count]['isLeaf'] = false;
                        $datos['sh'][$count]['expanded'] = true;
                    }
                    if ($flag) {
                        $idsh_compuesto[] = $valor;
                    }
                    $count++;
                }
            }
        }
        $ainteraccion = $istakeholder->lista_stakeholder_interaccion($idpersona, $idmodulo, $inicio, 0, $idsh_compuesto);
    } else {
        //en predio esta entrando a este
        $ainteraccion = $istakeholder->lista_stakeholder_interaccion($idpersona, $idmodulo, $inicio, $persona);
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
            if ($seguridad->verifica_permiso("Crear", "Compromiso")) {
                $plantilla->iniciaBloque("crear_compromiso");
                $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "crear_compromiso");
                //echo "Editar ". " Interaccion ". $ainteraccion[idusu_c][$key] ." , ". $ainteraccion[idmodulo_c][$key];
                $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "crear_compromiso");
            }

            if ($seguridad->verifica_permiso("Editar", "Interaccion", $ainteraccion[idusu_c][$key], $ainteraccion[idmodulo_c][$key])) {
                $plantilla->iniciaBloque("editar_interaccion");
                $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "editar_interaccion");
                //echo "Editar ". " Interaccion ". $ainteraccion[idusu_c][$key] ." , ". $ainteraccion[idmodulo_c][$key];
                $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "editar_interaccion");
                $plantilla->reemplazaEnBloque("persona", $persona, "editar_interaccion");
            }

            if ($seguridad->verifica_permiso("Eliminar", "Interaccion", $ainteraccion[idusu_c][$key], $ainteraccion[idmodulo_c][$key])) {
                $plantilla->iniciaBloque("eliminar_interaccion");
                $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "eliminar_interaccion");
                $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "eliminar_interaccion");
            }


            //imagenes
            if (sizeof($ainteraccion['archivo'][$key]) > 0) {

                foreach ($ainteraccion['archivo'][$key] as $archivo_key => $archivo) {
                    $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "interaccion" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $ainteraccion[idinteraccion][$key] . '_' . $archivo;
                    $thumb = new thumb();
                    if ($thumb->loadImage($thumbfile)) {
                        $plantilla->iniciaBloque("imagen");
                        $plantilla->reemplazaEnBloque("proyecto", $_SESSION['proyecto'], "imagen");
                        $plantilla->reemplazaEnBloque("archivo", $ainteraccion[idinteraccion][$key] . '_' . $archivo, "imagen");
                        $plantilla->reemplazaEnBloque("nombre", $archivo, "imagen");
                    }
                }
            }

            $archivos = array();
            //archivos
            if (sizeof($ainteraccion['archivo'][$key]) > 0) {

                foreach ($ainteraccion['archivo'][$key] as $archivo_key => $archivo) {
                    $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "interaccion" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $ainteraccion[idinteraccion][$key] . '_' . $archivo;
                    $thumb = new thumb();
                    if (!$thumb->loadImage($thumbfile)) {
                        $archivos[] = $ainteraccion[idinteraccion][$key] . '_' . $archivo;
                    }
                }
                $aux = 0;
                foreach ($archivos as $archivo) {
                    $aux++;
                    $plantilla->iniciaBloque("archivo");
                    $plantilla->reemplazaEnBloque("archivo", $archivo, "archivo");
                    if ($aux < count($archivos)) {
                        $plantilla->reemplazaEnBloque("coma", " , ", "archivo");
                    }
                }
            }



            $cant = sizeof($ainteraccion['idcompromiso'][$key]);
            $count = 0;
            if ($cant > 0) {
                 
                foreach ($ainteraccion['compromiso'][$key] as $compromiso_key => $compromiso) {
                    $count++;

                    $plantilla->iniciaBloque("item_compromiso");
                    if ($count > 1) {
                        $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "item_compromiso");
                        $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "item_compromiso");
                        $plantilla->reemplazaEnBloque("estilo", "display:none;", "item_compromiso");
                    }
                    $plantilla->reemplazaEnBloque("fecha_compromiso", $ainteraccion['fecha_compromiso'][$key][$compromiso_key], "item_compromiso");
                    //echo $compromiso;
                    $plantilla->reemplazaEnBloque("compromiso", $compromiso, "item_compromiso");
                    $plantilla->reemplazaEnBloque("idcompromiso", $ainteraccion['idcompromiso'][$key][$compromiso_key], "item_compromiso");
                    $plantilla->reemplazaEnBloque("idmodulo_compromiso", $ainteraccion['idmodulo_compromiso'][$key][$compromiso_key], "item_compromiso");
                    if ($seguridad->verifica_permiso("Editar", "Compromiso", $ainteraccion['compromiso_idusu_c'][$key][$compromiso_key], $ainteraccion['compromiso_idmodulo_c'][$key][$compromiso_key])) {
                        $plantilla->iniciaBloque("editar_compromiso");
                        $plantilla->reemplazaEnBloque("idcompromiso", $ainteraccion['idcompromiso'][$key][$compromiso_key], "editar_compromiso");
                        $plantilla->reemplazaEnBloque("idmodulo_compromiso", $ainteraccion['idmodulo_compromiso'][$key][$compromiso_key], "editar_compromiso");
                    }

                    if ($seguridad->verifica_permiso("Eliminar", "Compromiso", $ainteraccion['compromiso_idusu_c'][$key][$compromiso_key], $ainteraccion['compromiso_idmodulo_c'][$key][$compromiso_key])) {
                        $plantilla->iniciaBloque("eliminar_compromiso");
                        $plantilla->reemplazaEnBloque("idcompromiso", $ainteraccion['idcompromiso'][$key][$compromiso_key], "eliminar_compromiso");
                        $plantilla->reemplazaEnBloque("idmodulo_compromiso", $ainteraccion['idmodulo_compromiso'][$key][$compromiso_key], "eliminar_compromiso");
                    }
                }
            }

            $plantilla->iniciaBloque("menu_compromiso");
            $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "menu_compromiso");
            $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "menu_compromiso");
            if ($count > 1) {
                $plantilla->iniciaBloque("boton_ocultar");
                $plantilla->reemplazaEnBloque("idinteraccion", $ainteraccion[idinteraccion][$key], "boton_ocultar");
                $plantilla->reemplazaEnBloque("idmodulo_interaccion", $ainteraccion[idmodulo_interaccion][$key], "boton_ocultar");
            }


            //RC
            if (sizeof($ainteraccion['rc'][$key]) > 0) {

                $aux = 0;
                foreach ($ainteraccion['rc'][$key] as $rc_key => $rc) {
                    if ($rc_key == "$idpersona-$idmodulo") {
                        $nombre = $rc;
                        $rc= ucwords(strtolower($rc));
                    }
                    $aux++;
                    $plantilla->iniciaBloque("rc_interaccion");
                    $plantilla->reemplazaEnBloque("rc", $rc, "rc_interaccion");
                    if ($aux < sizeof($ainteraccion['rc'][$key]) - 1) {
                        $plantilla->reemplazaEnBloque("coma", " , ", "rc_interaccion");
                    } elseif ($aux == sizeof($ainteraccion['rc'][$key]) - 1) {
                        $plantilla->reemplazaEnBloque("coma", " y ", "rc_interaccion");
                    } else {
                        $plantilla->reemplazaEnBloque("coma", ".", "rc_interaccion");
                    }
                }
            }
            ///sh
            if (sizeof($ainteraccion['sh'][$key]) > 0) {

                foreach ($ainteraccion['sh'][$key] as $sh_key => $sh) {
                    //echo "sh: $sh";
                    
                    //$sh=  ucfirst(strtolower($sh));
                    $tokens = preg_split("/[-]+/", $sh);
                    $plantilla->iniciaBloque("sh_interaccion");
                    $plantilla->reemplazaEnBloque("idsh", $tokens[0], "sh_interaccion");
                    $plantilla->reemplazaEnBloque("idmodulo", $tokens[1], "sh_interaccion");
                   
                    $plantilla->reemplazaEnBloque("sh", ucwords(strtolower($tokens[2])), "sh_interaccion");

                    $plantilla->reemplazaEnBloque("idpersona_tipo", $tokens[3], "sh_interaccion");
                    if ($tokens[4] != "") {
                        $plantilla->reemplazaEnBloque("imagen", "../../../archivo/" . $_SESSION['proyecto'] . "/imagen/" . $tokens[4], "sh_interaccion");
                    } else {
                        $plantilla->reemplazaEnBloque("imagen", "../../../img/imagen.png", "sh_interaccion");
                    }
                }
            }
        }
    }
    //echo "tabla in" . $tabla_interaccion;
    if ($persona < 3) {

        $plantilla_tabla->reemplaza("bloque_interaccion", $plantilla->getPlantillaCadena());

        if ($modo == 1) {
            $plantilla_tabla->iniciaBloque("enlaces");
            //´plkk$plantilla_tabla->reemplazaEnBloque("nombre", $nombre, "enlaces");
            $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona, "enlaces");
            $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo, "enlaces");
            if ($seguridad->verifica_permiso("Crear", "Interaccion"))
                $plantilla_tabla->iniciaBloque("crear_interaccion");
            /*
              if($seguridad->verifica_permiso("Crear", "Reclamo"))
              $plantilla_tabla->iniciaBloque ("crear_reclamo");
             * 
             */
        }else {
            $plantilla_tabla->reemplaza("titulo", "Interacciones");
            $plantilla_tabla->iniciaBloque("ver_organizacion");
            $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona, "ver_organizacion");
            $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo, "ver_organizacion");
            $plantilla_tabla->reemplazaEnBloque("idpersona_tipo", $idpersona_tipo, "ver_organizacion");
        }

        //echo "numero $numero total $ainteraccion[total]";

        if ($numero > 0) {
            $plantilla_tabla->reemplaza("numero", $numero);
            $plantilla_tabla->reemplaza("de", "de");
            $plantilla_tabla->reemplaza("total", $ainteraccion['total']);
            if ($numero < $ainteraccion['total']) {

                $plantilla_tabla->iniciaBloque("ver_mas");
                $plantilla_tabla->reemplazaEnBloque("inicio", $inicio + 10, "ver_mas");
                //$plantilla_tabla->reemplazaEnBloque("nombre", $nombre, "ver_mas");
                $plantilla_tabla->reemplazaEnBloque("idpersona", $idpersona, "ver_mas");
                $plantilla_tabla->reemplazaEnBloque("idmodulo", $idmodulo, "ver_mas");
                $plantilla_tabla->reemplazaEnBloque("persona", $persona, "ver_mas"); // ver mas
                $plantilla_tabla->reemplazaEnBloque("presenta", 1, "ver_mas"); // ver mas
                $plantilla_tabla->reemplazaEnBloque("modo", $modo, "ver_mas"); // ver mas
            }
        }

        if ($numero == 0) {
            $plantilla_tabla->iniciaBloque("mensaje");
        }

        $plantilla = $plantilla_tabla;
    }


    if ($presenta == 1) {
        $plantilla->presentaPlantilla();
    } elseif ($presenta == 2) {
        $datos["html"] = $plantilla->getPlantillaCadena();
        echo json_encode($datos);
    } else {
        return $plantilla->getPlantillaCadena();
    }
}

function eliminar_red_stakeholder($idpersona_red_stakeholder, $idpersona, $idmodulo, $idmodulo_persona_red) {

    $gstake_holder = new gstakeholder();
    $error = $gstake_holder->eliminar_red($idpersona_red_stakeholder, $idmodulo_persona_red);
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " de la red ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " de la red");
    }
    echo json_encode($data);
    //ver_editar_red_stakeholder($idpersona, $idmodulo);
}

function guardar_red_stakeholder($idpersona_compuesto_red, $idpersona, $idmodulo) {

    $idmodulo_a = $_SESSION[idmodulo_a];
    $apersona_red = split("---", $idpersona_compuesto_red);
    $idpersona_red = $apersona_red[0];
    $idmodulo_red = $apersona_red[1];
    $gstakeholder = new gstakeholder();
    $error = $gstakeholder->agregar_red($idpersona, $idmodulo, $idpersona_red, $idmodulo_red, $idmodulo_a);


    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " de la red ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " de la red");
    }
    echo json_encode($data);
    //ver_editar_red_stakeholder($idpersona,$idmodulo);
}

function guardar_predio_stakeholder($idpredio, $idpersona, $idmodulo) {

    $idmodulo_predio_sh = $_SESSION[idmodulo];

    $gstakeholder = new gstakeholder();
    $error = $gstakeholder->agregar_predio($idpersona, $idmodulo, $idpredio, $idmodulo_predio_sh);


    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del predio ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del predio ");
    }
    echo json_encode($data);
    //ver_editar_red_stakeholder($idpersona,$idmodulo);
}

function ver_editar_red_stakeholder($idpersona, $idmodulo) {

    $seguridad = new Seguridad();

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/red.html");

    if ($seguridad->verifica_permiso("Crear", "Stakeholder-Redes")) {
        $plantilla->iniciaBloque("crear_red_stakeholder");
    }

    $istakeholder = new istakeholder();
    $persona = new ipersona();
    $result_stakeholder = $istakeholder->lista_stakeholder_red($idpersona, $idmodulo);

    if (mysql_num_rows($result_stakeholder)) {
        while (!!$fila = mysql_fetch_array($result_stakeholder)) {

            //stakeholder
            $plantilla->iniciaBloque("detalle_red");
            $nombre_stakeholder = "";
            if ($fila[nombre] != "") {
                $nombre_stakeholder = $fila[nombre];
            }
            $nombre_stakeholder = $nombre_stakeholder . " " . $fila[apellido_p] . " " . $fila[apellido_m];
            $plantilla->reemplazaEnBloque('nombre_stakeholder', $fila[apellido_p] . " " . $fila[apellido_m] . ", " . $fila[nombre], "detalle_red");
            $plantilla->reemplazaEnBloque("idpersona", $fila[idpersona_red], "detalle_red");
            $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo_red], "detalle_red");
            $plantilla->reemplazaEnBloque("idpersona_tipo", $fila[idpersona_tipo], "detalle_red");

            if ($fila[imagen] != "") {
                $plantilla->reemplazaEnBloque("imagen", "../../../archivo/" . $_SESSION['proyecto'] . "/imagen/" . $fila[imagen], "detalle_red");
            } else {
                $plantilla->reemplazaEnBloque("imagen", "../../../img/imagen.png", "detalle_red");
            }

            //organizacion
            /* $apersona_organizacion=$persona->get_persona_organizacion($fila[idpersona_red], $fila[idmodulo_red]);
              while(!!$fila_organizacion=mysql_fetch_array($apersona_organizacion)){
              organizacion
              $plantilla->iniciaBloque("organizacion");
              $plantilla->reemplazaEnBloque("organizacion",$fila_organizacion[razon_social]." (".$fila_organizacion[nombre_comercial].")","organizacion");
              $plantilla->reemplazaEnBloque("cargo",$fila_organizacion[cargo],"organizacion");
              } */

            //tag
            /* $result_tag=$persona->get_persona_tag($fila[idpersona_red], $fila[idmodulo_red]);
              $cont_tag=0;
              while($fila_tag=mysql_fetch_array($result_tag)){
              if($cont_tag%4==0){
              $plantilla->iniciaBloque("tr_tag");
              }
              $plantilla->iniciaBloque("td_tag");


              $plantilla->reemplazaEnBloque("tag", $fila_tag[tag].$entro, "td_tag");
              $cont_tag++;
              }
             */
            //Calificacion
            $idimension_matriz_sh = new idimension_matriz_sh();
            $result = $idimension_matriz_sh->lista_dimension_matriz_sh($fila[idpersona_red], $fila[idmodulo_red]);
            $votos = array();
            $count = 0;
            while ($fila1 = mysql_fetch_array($result)) {
                $count++;
                $votos[$fila1[iddimension_matriz_sh]] = $fila1;
            }

            $valor1 = ruta_images . "00.png";
            $valor2 = ruta_images . "0.png";
            $valor3 = ruta_images . "0.png";

            if ($count > 0) {

                $valor1 = ruta_images . $votos[1][valor];
                $valor2 = ruta_images . $votos[2][valor];
                $valor3 = ruta_images . $votos[3][valor];
            }

            $plantilla->iniciaBloque("tr_calificacion");
            $plantilla->reemplazaEnBloque("posicion", $valor1, "tr_calificacion");
            $plantilla->reemplazaEnBloque("idpersona", $fila[idpersona_red], "tr_calificacion");
            $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo_red], "tr_calificacion");
            $plantilla->reemplazaEnBloque('idpersona_red_stakeholder', $fila[idred], "tr_calificacion");
            $plantilla->reemplazaEnBloque('idmodulo_persona_red', $fila[idmodulo_persona_red], "tr_calificacion");


            $plantilla->iniciaBloque("tr_dimension");
            $plantilla->reemplazaEnBloque("valor", $valor2, "tr_dimension");

            $plantilla->iniciaBloque("tr_dimension");
            $plantilla->reemplazaEnBloque("valor", $valor3, "tr_dimension");

            if ($seguridad->verifica_permiso("Editar", "Stakeholder-Redes")) {
                $plantilla->iniciaBloque("eliminar_red_stakeholder");
                $plantilla->reemplazaEnBloque('idpersona_red_stakeholder', $fila[idred], "eliminar_red_stakeholder");
                $plantilla->reemplazaEnBloque('idmodulo_persona_red', $fila[idmodulo_persona_red], "eliminar_red_stakeholder");
            }
        }
    }


    $plantilla->presentaPlantilla();
}

function ver_editar_predio_stakeholder($idpersona, $idmodulo, $idmapa) {

    $seguridad = new Seguridad();

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/predio.html");

    $plantilla->iniciaBloque("asignar_predio_stakeholder");

    $istakeholder = new istakeholder();

    $apredio = $istakeholder->lista_stakeholder_predio($idpersona, $idmodulo, $idmapa);

    $num = 0;
    foreach ($apredio['idpredio'] as $key => $predio) {

        //stakeholder
        $num++;
        $plantilla->iniciaBloque("detalle_predio");

        $akey = explode('***', $key);
        $plantilla->reemplazaEnBloque('idpredio', $akey[0], "detalle_predio");
        $plantilla->reemplazaEnBloque('idmodulo_predio', $akey[1], "detalle_predio");
        $plantilla->reemplazaEnBloque('numero', $num, "detalle_predio");
        $plantilla->reemplazaEnBloque('nombre_predio', $predio, "detalle_predio");
        $plantilla->reemplazaEnBloque('direccion', $apredio['direccion'][$key], "detalle_predio");
        $fid_string = ' ';
        $aux = 0;
        //print_r($apredio['idgis_item']);
        foreach ($apredio['idgis_item_predio'][$key] as $item_key => $idgis_item) {
            //echo $idgis_item;
            $aux++;
            $fid_string.="$idgis_item";
            if ($aux < count($apredio['idgis_item_predio'][$key])) {
                $fid_string.=",";
            }
        }

        $plantilla->reemplazaEnBloque('fid_string', $fid_string, "detalle_predio");

        if (sizeof($apredio['tag'][$key]) > 0) {
            $plantilla->iniciaBloque("tag");
            $count = 0;
            foreach ($apredio['tag'][$key] as $tag_key => $tag) {
                $count++;
                $plantilla->iniciaBloque("detalle_tag");
                $plantilla->reemplazaEnBloque('tag', $tag, "detalle_tag");
                if ($count < sizeof($apredio['tag'][$key])) {
                    $plantilla->reemplazaEnBloque('coma', " , ", "detalle_tag");
                } else {
                    $plantilla->reemplazaEnBloque('coma', " . ", "detalle_tag");
                }
            }
        }

        //imagenes
        if (sizeof($apredio['archivo'][$key]) > 0) {

            foreach ($apredio['archivo'][$key] as $archivo_key => $archivo) {
                $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "predio" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $key . '_' . $archivo;
                $thumb = new thumb();
                if ($thumb->loadImage($thumbfile)) {
                    $plantilla->iniciaBloque("imagen");
                    $plantilla->reemplazaEnBloque("proyecto", $_SESSION['proyecto'], "imagen");
                    $plantilla->reemplazaEnBloque("archivo", $key . '_' . $archivo, "imagen");
                    $plantilla->reemplazaEnBloque("nombre", $archivo, "imagen");
                }
            }
        }

        $archivos = array();
        //archivos
        if (sizeof($apredio['archivo'][$key]) > 0) {

            foreach ($apredio['archivo'][$key] as $archivo_key => $archivo) {
                $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "predio" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $key . '_' . $archivo;
                $thumb = new thumb();
                if (!$thumb->loadImage($thumbfile)) {
                    $archivos[] = $key . '_' . $archivo;
                }
            }
            $aux = 0;
            foreach ($archivos as $archivo) {
                $aux++;
                $plantilla->iniciaBloque("archivo");
                $plantilla->reemplazaEnBloque("archivo", $archivo, "archivo");
                if ($aux < count($archivos)) {
                    $plantilla->reemplazaEnBloque("coma", " , ", "archivo");
                }
            }
        }
    }
    $fid_string = ' ';
    $aux = 0;
    //print_r($apredio['idgis_item']);
    foreach ($apredio['idgis_item'] as $key => $idgis_item) {
        //echo $idgis_item;
        $aux++;
        $fid_string.="$idgis_item";
        if ($aux < count($apredio['idgis_item'])) {
            $fid_string.=",";
        }
    }

    $plantilla->reemplazaEnBloque('fid_string', $fid_string, "detalle_predio");

    $plantilla->reemplaza("ver_mapa", ver_buscar_mapa($fid_string, 0, $idmapa));

    $plantilla->presentaPlantilla();
}

function ver_reporte_predio_entidad($entidad, $identidad, $idmodulo) {

    $seguridad = new Seguridad();




    $istakeholder = new istakeholder();

    $apredio = $istakeholder->lista_predio_entidad($entidad, $identidad, $idmodulo);

    $fid_string = ' ';
    $aux = 0;
    //print_r($apredio['idgis_item']);
    foreach ($apredio['idgis_item'] as $key => $idgis_item) {
        //echo $idgis_item;
        $aux++;
        $fid_string.="$idgis_item";
        if ($aux < count($apredio['idgis_item'])) {
            $fid_string.=",";
        }
    }

    //echo $fid_string;

    ver_buscar_mapa($fid_string, 1);
}

function ver_predio_entidad($fid_string, $intensidad) {

    $seguridad = new Seguridad();

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/mapa/ver_mapa.html");

    ver_buscar_mapa($fid_string, 1, 0, $intensidad);
}

function ver_tab_stakeholder($idpersona = "", $idmodulo = "", $idpersona_tipo = "", $idpersona_compuesto = "") {
    $seguridad = new Seguridad();
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/tab.html");
    $apersona = split("---", $idpersona_compuesto);
    $idpersona = $apersona[0];
    $idmodulo = $apersona[1];
    $idpersona_tipo = $apersona[2]; // ver si carga persona u organizacion
    $plantilla->reemplaza("idpersona", $idpersona);
    $plantilla->reemplaza("idmodulo", $idmodulo);
    $plantilla->reemplaza("idpersona_tipo", $idpersona_tipo);

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Redes")) {
        $plantilla->iniciaBloque("ver_red_stakeholder");
        $plantilla->reemplazaEnBloque("idpersona", $idpersona, "ver_red_stakeholder");
        $plantilla->reemplazaEnBloque("idmodulo", $idmodulo, "ver_red_stakeholder");
    }

    $plantilla->presentaPlantilla();
}

function ver_tag_stakeholder($idpersona, $idmodulo) {
    $seguridad = new Seguridad();

    $plantilla_ver_tag = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/ver_tag.html");
    $persona = new ipersona();
    $result_tag = $persona->get_persona_tag($idpersona, $idmodulo);
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

    if ($seguridad->verifica_permiso("Editar", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c]))
        $plantilla_ver_tag->iniciaBloque("editar_tag_sh");


    $plantilla_ver_tag->presentaPlantilla();
}

function ver_editar_tag_stakeholder($idpersona, $idmodulo) {
    $seguridad = new Seguridad();
    $plantilla_editar_tag = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/editar_tag.html");
    $persona = new ipersona();
    $result_tag = $persona->get_persona_tag($idpersona, $idmodulo);
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
        $plantilla_editar_tag->reemplazaEnBloque("idpersona_tag", $fila_tag[idpersona_tag], "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idmodulo_persona_tag", $fila_tag[idmodulo_persona_tag], "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idpersona", $idpersona, "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idmodulo", $idmodulo, "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idtag", $fila_tag[idtag], "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("tag", utf8_encode($fila_tag[tag]), "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("idmodulo_tag", $fila_tag[idmodulo_tag], "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "td_editar_tag");
        $plantilla_editar_tag->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "td_editar_tag");
        if ($seguridad->verifica_permiso("Editar", "Tag", $fila_tag[idusu_c], $fila_tag[idmodulo_c])) {
            $plantilla_editar_tag->iniciaBloque("editar_tag");
            $plantilla_editar_tag->reemplazaEnBloque("tag", $fila_tag[tag], "editar_tag");
            $plantilla_editar_tag->reemplazaEnBloque("idmodulo_tag", $fila_tag[idmodulo_tag], "editar_tag");
            $plantilla_editar_tag->reemplazaEnBloque("idtag", $fila_tag[idtag], "editar_tag");
            $plantilla_editar_tag->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "editar_tag");
            $plantilla_editar_tag->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "editar_tag");

            $plantilla_editar_tag->iniciaBloque("spinner_tag");
            $plantilla_editar_tag->reemplazaEnBloque("prioridad", $fila_tag[prioridad], "spinner_tag");

            $plantilla_editar_tag->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "spinner_tag");
            $plantilla_editar_tag->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "spinner_tag");
        }

        if ($seguridad->verifica_permiso("Eliminar", "Tag", $fila_tag[idusu_c], $fila_tag[idmodulo_c])) {
            $plantilla_editar_tag->iniciaBloque("eliminar_tag");
            $plantilla_editar_tag->reemplazaEnBloque("idpersona_tag", $fila_tag[idpersona_tag], "eliminar_tag");
            $plantilla_editar_tag->reemplazaEnBloque("idmodulo_persona_tag", $fila_tag[idmodulo_persona_tag], "eliminar_tag");
            $plantilla_editar_tag->reemplazaEnBloque("stakeholder_complejo_tag", $fila_tag[idpersona_tag] . "***" . $fila_tag[idmodulo_persona_tag] . "***1", "eliminar_tag");

            $plantilla_editar_tag->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "eliminar_tag");
            $plantilla_editar_tag->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "eliminar_tag");
        }

        $cont_tag++;
        $cont_tag_celda++;
    }

    ////antes coloco el numero real de celdas y filas
    $plantilla_editar_tag->reemplaza("nume_fila_stakeholder_tag_complejo", $cont_tag_fila);
    $plantilla_editar_tag->reemplaza("nume_celda_stakeholder_tag_complejo", $cont_tag_celda);

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

function guardar_tag_stakeholder($idstakeholder_complejo_tag, $orden_complejo_tag, $idpersona, $idmodulo) {
    $idmodulo_a = $_SESSION[idmodulo_a];

    //echo "ver ".$idtag_compuesto." ".$atag[0]." ".$atag[1];
    $gstake_holder = new gstakeholder();

    $respuesta = $gstake_holder->agregar_tag_complejo($idstakeholder_complejo_tag, $orden_complejo_tag, $idpersona, $idmodulo, $idmodulo_a);
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

function eliminar_tag_stakeholder($idpersona_tag, $idpersona, $idmodulo, $idmodulo_persona_tag) {

    $gstake_holder = new gstakeholder();

    $respuesta = $gstake_holder->eliminar_tag($idpersona_tag, $idmodulo_persona_tag);

    if ($respuesta == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " del tag ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " del tag");
    }
    echo json_encode($data);

    //ver_tag_stakeholder($idpersona, $idmodulo);
}

function busqueda_rapida_predio_stakeholder($busca_rapida_predio_stakeholder) {
    $arrayElementos = array();
    $stakeholder = new istakeholder();
    $ayudante = new Ayudante();
    $busca_rapida_predio_stakeholder = $ayudante->caracter($busca_rapida_predio_stakeholder);

    $result_predio = $stakeholder->lista_predio($busca_rapida_predio_stakeholder);
    //if(mysql_num_rows($result_stakeholder)>0){

    $count = 0;
    while ($fila = mysql_fetch_array($result_predio)) {
        $count++;
        array_push($arrayElementos, new autocompletar(utf8_encode($fila["nombre"]), $fila["idpredio"]));
    }
    //}else{
    //}
    //array_push($arrayElementos, new autocompletar(utf8_encode(" -- NUEVO STAKEHOLDER --"), 'nuevo_stake_holder'));
    if ($count == 0)
        array_push($arrayElementos, new autocompletar(utf8_encode("No se hallaron resultados"), 'nuevo_stake_holder'));

    print_r(json_encode($arrayElementos));
    //json_encode($arrayElementos);
}

function ver_cuerpo_inicial($idpersona, $idmodulo, $nombre, $modo) {
    $seguridad = new Seguridad();
    echo "<br/><div id='cargando' style='width: 100px; margin:0 auto;'><img src='../../../img/bar-ajax-loader.gif'></div><br/>";
    flush();
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/cuerpo.html");

    $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre");
    //$tiempo ="Bienvenido ".date("G");

    if (date("G") >= 4 && date("G") <= 11) {
        $tiempo = "Buenos d&iacute;as ";
    }
    if (date("G") > 11 && date("G") <= 19) {
        $tiempo = "Buenas tardes ";
    }
    if (date("G") > 19 && date("G") <= 24) {
        $tiempo = "Buenas noches ";
    }
    $plantilla->reemplaza("version", version);
    $plantilla->reemplaza("idpersona", $_SESSION[idpersona]);
    $plantilla->reemplaza("idusuario", $_SESSION[idusuario]);
    $plantilla->reemplaza("idmodulo", $_SESSION[idmodulo_persona]);
    $plantilla->reemplaza("idmodulo_usuario", $_SESSION[idmodulo_usuario]);
    $plantilla->reemplaza("quien", "<span style=\"font-weight: normal;\">" . $tiempo . "</span>" . substr($_SESSION[nombre], 0, 12) . " <span style=\"font-weight: normal;\">bienvenido a</span> " . strtoupper($_SESSION['proyecto']));
    $plantilla->reemplaza("fecha", $dias[date('w')] . ", " . date("j") . " de " . $meses[date('n')] . " del " . date("Y"));
    $plantilla->reemplaza("sesion", $_SESSION[sesion]);
    $plantilla->reemplaza("idproyecto", $_SESSION[idproyecto]);
    $plantilla->reemplaza("zona", date_default_timezone_get());


    if ($seguridad->verifica_permiso("Crear", "Relacionista"))
        $plantilla->iniciaBloque("crear_rc");

    if ($seguridad->verifica_permiso("Crear", "Stakeholder"))
        $plantilla->iniciaBloque("crear_sh");

    if ($seguridad->verifica_permiso("Crear", "Tag"))
        $plantilla->iniciaBloque("crear_tag");

    if ($seguridad->verifica_permiso("Crear", "Interaccion"))
        $plantilla->iniciaBloque("crear_interaccion");

    if ($seguridad->verifica_permiso("Crear", "Reclamo"))
        $plantilla->iniciaBloque("crear_reclamo");



    if ($seguridad->verifica_permiso("Ver", "Sincronizacion"))
        $plantilla->iniciaBloque("ver_sincronizacion");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Estadistico"))
        $plantilla->iniciaBloque("ver_stakeholder_estadistico");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Interes-Poder"))
        $plantilla->iniciaBloque("ver_interes_poder");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Posicion-Importancia"))
        $plantilla->iniciaBloque("ver_posicion_importancia");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Posicion-Tiempo"))
        $plantilla->iniciaBloque("ver_posicion_tiempo");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Interaccion-Tiempo"))
        $plantilla->iniciaBloque("ver_interaccion_tiempo");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Buscar-Interaccion"))
        $plantilla->iniciaBloque("ver_buscar_interaccion");

    if ($seguridad->verifica_permiso("Ver", "Stakeholder-Buscar-Compromiso"))
        $plantilla->iniciaBloque("ver_buscar_compromiso");

    if ($seguridad->verifica_permiso("Ver", "Reclamo-Estadistico"))
        $plantilla->iniciaBloque("ver_reclamo_estadistico");

    if ($seguridad->verifica_permiso("Ver", "Reclamo-Buscar"))
        $plantilla->iniciaBloque("ver_reclamo_buscar");

    if ($seguridad->verifica_permiso("Administrar", "Usuario-Rol"))
        $plantilla->iniciaBloque("ver_rol");


    if (!isset($modo)) {
        $modo = 1;
    }

    //

    if (isset($nombre) && $nombre != "") {
        $plantilla->reemplaza("cuerpo_interaccion", ver_bloque_interaccion(1, $nombre, $idpersona, $idmodulo, 50, 2, 0, $modo)); //persona 2 ve las interacciones del relacionista comunitario
    } else {
        $plantilla->reemplaza("cuerpo_interaccion", ver_bloque_interaccion($_SESSION["idpersona_tipo"], $_SESSION[nombre], $_SESSION[idpersona], $_SESSION[idmodulo_a], 50, 2, 0, $modo)); //persona 2 ve las interacciones del relacionista comunitario
    }

    echo $plantilla->getPlantillaCadena();
}

function ver_cabecera_stakeholder($idpersona = "", $idmodulo = "", $idpersona_compuesto = "") {

    $seguridad = new Seguridad();

    if ($idpersona_compuesto != "") {
        $apersona_compuesto = split("---", $idpersona_compuesto);
        $idpersona = $apersona_compuesto[0];
        $idmodulo = $apersona_compuesto[1];
    }
    $plantilla_cabecera = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/cabecera.html");
    $plantilla_cuerpo_cabecera_tag = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/cuerpo_cabecera_tag.html");
    $plantilla_ver_tag = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/ver_tag.html");
    $plantilla_cabecera->reemplaza("idpersona", $idpersona);
    $plantilla_cabecera->reemplaza("idmodulo", $idmodulo);
    $persona = new ipersona();
    $result_persona = $persona->get_persona($idpersona, $idmodulo);


    if ($fila = mysql_fetch_array($result_persona)) {
        $nombre_stakeholder = "";
        if ($fila[nombre] != "") {
            $nombre_stakeholder = $fila[nombre];
        }
        $nombre_stakeholder = $nombre_stakeholder . " " . $fila[apellido_p] . " " . $fila[apellido_m];
        if ($fila[idpersona_tipo] > 1) {
            $nombre_stakeholder = $fila[apellido_p];
        }
        $plantilla_cabecera->reemplaza('nombre_stakeholder', utf8_encode($nombre_stakeholder));

        $result_organizacion = $persona->get_persona_organizacion($idpersona, $idmodulo);

        while ($fila_organizacion = mysql_fetch_array($result_organizacion)) {
            $plantilla_cabecera->iniciaBloque("organizacion");
            if ($fila_organizacion[apellido_m] != "") {
                $nombre_comercial = " (" . $fila_organizacion[apellido_m] . ")";
            }
            $nombre_organizacion = $fila_organizacion[apellido_p] . $nombre_comercial;

            $plantilla_cabecera->reemplazaEnBloque("idpersona", $fila_organizacion['idorganizacion'], "organizacion");
            $plantilla_cabecera->reemplazaEnBloque("idmodulo", $fila_organizacion['idmodulo_organizacion'], "organizacion");
            $plantilla_cabecera->reemplazaEnBloque("idpersona_tipo", $fila_organizacion['idpersona_tipo'], "organizacion");
            $plantilla_cabecera->reemplazaEnBloque("organizacion", utf8_encode($nombre_organizacion), "organizacion");
            $plantilla_cabecera->reemplazaEnBloque("cargo", utf8_encode($fila_organizacion[cargo]), "organizacion");
        }

        $result_tag = $persona->get_persona_tag($idpersona, $idmodulo);
        $cont_tag = 0;

        if ($seguridad->verifica_permiso("Editar", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c]))
            $plantilla_ver_tag->iniciaBloque("editar_tag_sh");

        while ($fila_tag = mysql_fetch_array($result_tag)) {
            if ($cont_tag % 4 == 0) {
                $plantilla_ver_tag->iniciaBloque("tr_tag");
                //$plantilla_editar_tag->iniciaBloque("tr_editar_tag");
            }
            $plantilla_ver_tag->iniciaBloque("td_tag");

            $plantilla_ver_tag->reemplazaEnBloque("tag", utf8_encode($fila_tag[tag]), "td_tag");
            $plantilla_ver_tag->reemplazaEnBloque("prioridad", $fila_tag[prioridad], "td_tag");
            $plantilla_ver_tag->reemplazaEnBloque("idmodulo_tag", $fila_tag[idmodulo_tag], "td_tag");
            $plantilla_ver_tag->reemplazaEnBloque("idtag", $fila_tag[idtag], "td_tag");


            $cont_tag++;
        }
        if ($fila[imagen] != "") {
            $plantilla_cabecera->reemplaza("imagen", "../../../archivo/" . $_SESSION['proyecto'] . "/imagen/" . $fila[imagen]);
        } else {
            $plantilla_cabecera->reemplaza("imagen", "../../../img/imagen.png");
        }

        $plantilla_cabecera->reemplaza("ver_calificacion_stakeholder", ver_calificacion_stakeholder($idpersona, $idmodulo, $fila[idusu_c], $fila[idmodulo_c]));

        $plantilla_cuerpo_cabecera_tag->reemplaza("ver_tag", $plantilla_ver_tag->getPlantillaCadena());

        $plantilla_cabecera->reemplaza("cuerpo_cabecera_tag", $plantilla_cuerpo_cabecera_tag->getPlantillaCadena());
    }

    $plantilla_cabecera->presentaPlantilla();
}

function ver_dimension_matriz() {
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/calificacion/ver_dimension_matriz.html");
    $idimension_matriz_sh = new idimension_matriz_sh();

    $result1 = $idimension_matriz_sh->lista_dimension();

    $fila1 = mysql_fetch_array($result1);

    $plantilla->iniciaBloque("dimension_relevancia");
    $plantilla->reemplazaEnBloque("nombre_dimension", utf8_encode($fila1[dimension]), "dimension_relevancia");
    $plantilla->reemplazaEnBloque("id_dimension", $fila1[iddimension_matriz_sh], "dimension_relevancia");

    $result2 = $idimension_matriz_sh->lista_dimension_valor($fila1[iddimension_matriz_sh]);
    while ($fila2 = mysql_fetch_array($result2)) {

        //print_r($fila2);
        $plantilla->iniciaBloque("dimension_relevancia_valor");
        $plantilla->reemplazaEnBloque("valor_dimension", $fila2[valor], "dimension_relevancia_valor");
        $plantilla->reemplazaEnBloque("ruta_dimension", ruta_images, "dimension_relevancia_valor");
        $plantilla->reemplazaEnBloque("iddimension_matriz", $fila2[iddimension_matriz_sh_valor], "dimension_relevancia_valor");
        $plantilla->reemplazaEnBloque("id_dimension", $fila1[iddimension_matriz_sh], "dimension_relevancia_valor");
    }


    while ($fila1 = mysql_fetch_array($result1)) {

        $plantilla->iniciaBloque("dimension_matriz_sh");
        $plantilla->reemplazaEnBloque("nombre_dimension", $fila1[dimension], "dimension_matriz_sh");
        $plantilla->reemplazaEnBloque("id_dimension", $fila1[iddimension_matriz_sh], "dimension_matriz_sh");

        $result2 = $idimension_matriz_sh->lista_dimension_valor($fila1[iddimension_matriz_sh]);
        while ($fila2 = mysql_fetch_array($result2)) {

            //print_r($fila2);
            $plantilla->iniciaBloque("dimension_matriz_sh_valor");
            $plantilla->reemplazaEnBloque("valor_dimension", $fila2[valor], "dimension_matriz_sh_valor");
            $plantilla->reemplazaEnBloque("ruta_dimension", ruta_images, "dimension_matriz_sh_valor");
            $plantilla->reemplazaEnBloque("iddimension_matriz", $fila2[iddimension_matriz_sh_valor], "dimension_matriz_sh_valor");
            $plantilla->reemplazaEnBloque("id_dimension", $fila1[iddimension_matriz_sh], "dimension_matriz_sh_valor");
        }
    }

    $plantilla->presentaPlantilla();
    //return $plantilla->getPlantillaCadena();
}

function guardar_calificacion_stakeholder($idpersona, $idmodulo, $fecha, $dimension, $comentario) {

    $gdimension_matriz_sh = new gdimension_matriz_sh();

    $idmodulo_a = $_SESSION[idmodulo_a];

    $respuesta = $gdimension_matriz_sh->agregar_calificacion($idpersona, $idmodulo, $idmodulo_a, $fecha, $dimension, $comentario);

    if ($respuesta == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del voto ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del voto");
    }
    echo json_encode($data);

    //echo ver_calificacion_stakeholder($idpersona, $idmodulo);
}

function eliminar_calificacion_stakeholder($idpersona, $idmodulo, $idsh_dimension, $idmodulo_sh_dimension) {
    $gdimension_matriz_sh = new gdimension_matriz_sh();
    //echo ("idpersona: $idpersona,idmodulo: $idmodulo,idsh_dimension: $idsh_dimension,idmodulo_sh_dimension: $idmodulo_sh_dimension");
    $respuesta = $gdimension_matriz_sh->eliminar_calificacion($idpersona, $idmodulo, $idsh_dimension, $idmodulo_sh_dimension);
    if ($respuesta == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " del voto ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " del voto");
    }
    echo json_encode($data);
}

function refrescar_tag_stakeholder($idpersona, $idmodulo) {

    ver_tag_stakeholder($idpersona, $idmodulo);
}

function ver_analisis_red($idpersona, $idmodulo, $rango_fecha) {
    $plantilla1 = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/analisis_red.html");
    $plantilla2 = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/legend.html");
    $plantilla3 = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/tabla_analisis_red.html");

    $idimension_matriz_sh = new idimension_matriz_sh();

    $result1 = $idimension_matriz_sh->lista_dimension();


    $count = 0;

    while ($fila1 = mysql_fetch_array($result1)) {

        $count++;

        $plantilla2->iniciaBloque("dimension_sh");
        $plantilla2->reemplazaEnBloque("dimension", $fila1[dimension], "dimension_sh");


        $result2 = $idimension_matriz_sh->lista_dimension_puntaje($fila1[iddimension_matriz_sh]);
        while ($fila2 = mysql_fetch_array($result2)) {

            //print_r($fila2);
            $plantilla2->iniciaBloque("dimension_sh_valor");
            $plantilla2->reemplazaEnBloque("comentario", $fila2[comentario], "dimension_sh_valor");
            if ($count == 1) {
                $plantilla2->reemplazaEnBloque("valor", $fila2[valor], "dimension_sh_valor");
                $plantilla2->reemplazaEnBloque("ruta", ruta_images, "dimension_sh_valor");
            }
            if ($count > 1) {
                $plantilla2->reemplazaEnBloque("puntaje", $fila2[puntaje], "dimension_sh_valor");
            }
        }
    }
    $plantilla1->reemplaza("legend", $plantilla2->getPlantillaCadena());

    $format = 'YW';

    $date = date($format);

    $days = array();

    $dia = date('d/m/y');
    $dia_aux = date('d-m-Y');
    // - 7 days from today

    for ($i = 1; $i < 7; $i++) {

        $days[] = $date;
        $plantilla3->iniciaBloque("td_fecha");
        $plantilla3->reemplazaEnBloque("fecha", $dia, "td_fecha");
        $dia = date('d/m/y', strtotime("-$rango_fecha week" . $dia_aux));
        $date = date($format, strtotime($dia));
    }

    $persona = new ipersona();
    $result = $persona->get_analisis_red_semana($idpersona, $idmodulo);

    $results = array();

    while ($fila = mysql_fetch_array($result)) {
        $results[] = $fila;
    }

    $result = $persona->get_persona($idpersona, $idmodulo);

    //print_r($results);
    $nombre = "";
    if ($fila = mysql_fetch_array($result)) {
        if ($fila[idpersona_tipo] > 1) {
            $nombre = $fila[apellido_p];
        } else {
            $nombre = $fila[apellido_p] . " " . $fila[apellido_m] . ", " . $fila[nombre];
        }
    }

    $comentario = "";

    foreach ($days as $day) {

        $valor_1 = "00.png";
        $puntaje_2 = "?";
        $puntaje_3 = "?";
        foreach ($results as $result) {
            //echo $result[periodo]." vs ".$day."<br/>";
            if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 1) {
                $valor_1 = $result[valor];
                $comentario = $result[comentario];
            }
            if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 2) {
                $puntaje_2 = $result[puntaje];
                $comentario = $result[comentario];
            }
            if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 3) {
                $puntaje_3 = $result[puntaje];
                $comentario = $result[comentario];
            }
        }


        $plantilla3->iniciaBloque("td_dimension");
        $plantilla3->reemplazaEnBloque("posicion", $valor_1, "td_dimension");
        $plantilla3->reemplazaEnBloque("ruta", ruta_images, "td_dimension");
        $plantilla3->reemplazaEnBloque("poder", $puntaje_2, "td_dimension");
        $plantilla3->reemplazaEnBloque("interes", $puntaje_3, "td_dimension");
        $plantilla3->reemplazaEnBloque("comentario", $comentario, "td_dimension");
    }

    $plantilla3->reemplaza("nombre", utf8_encode($nombre));
    $plantilla3->reemplaza("idpersona", $fila[idpersona]);
    $plantilla3->reemplaza("idmodulo", $fila[idmodulo]);
    $plantilla3->reemplaza("idpersona_tipo", $fila[idpersona_tipo]);


    $result1 = $persona->lista_persona_red($idpersona, $idmodulo);
    $count = 0;
    while ($fila1 = mysql_fetch_array($result1)) {
        $count++;
        $result2 = $persona->get_analisis_red_semana($fila1[idpersona], $fila1[idmodulo]);
        $results = array();
        while ($fila2 = mysql_fetch_array($result2)) {
            $results[] = $fila2;
        }
        $plantilla3->iniciaBloque("tr_red");
        $plantilla3->reemplazaEnBloque("numero_red", $count, "tr_red");
        $plantilla3->reemplazaEnBloque("nombre_red", utf8_encode($fila1[nombre] . " " . $fila1[apellido_p] . " " . $fila1[apellido_m]), "tr_red");
        $plantilla3->reemplazaEnBloque("idpersona", $fila1[idpersona], "tr_red");
        $plantilla3->reemplazaEnBloque("idmodulo", $fila1[idmodulo], "tr_red");
        $plantilla3->reemplazaEnBloque("idpersona_tipo", $fila1[idpersona_tipo], "tr_red");

        $comentario = "";
        foreach ($days as $day) {

            $valor_1 = "00.png";
            $puntaje_2 = "?";
            $puntaje_3 = "?";
            foreach ($results as $result) {
                //echo $result[periodo]." vs ".$day."<br/>";
                if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 1) {
                    $valor_1 = $result[valor];
                    $comentario = $result[comentario];
                }
                if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 2) {
                    $puntaje_2 = $result[puntaje];
                    $comentario = $result[comentario];
                }
                if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 3) {
                    $puntaje_3 = $result[puntaje];
                    $comentario = $result[comentario];
                }
            }


            $plantilla3->iniciaBloque("td_red");
            $plantilla3->reemplazaEnBloque("posicion", $valor_1, "td_red");
            $plantilla3->reemplazaEnBloque("ruta", ruta_images, "td_red");
            $plantilla3->reemplazaEnBloque("poder", $puntaje_2, "td_red");
            $plantilla3->reemplazaEnBloque("interes", $puntaje_3, "td_red");
            $plantilla3->reemplazaEnBloque("comentario", $comentario, "td_red");
        }
    }

    $plantilla1->reemplaza("analisis_red", $plantilla3->getPlantillaCadena());
    $plantilla1->presentaPlantilla();
}

function actualizar_analisis_red($idpersona, $idmodulo, $rango_fecha) {

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/stakeholder/tabla_analisis_red.html");
    $format = 'Ym';
    $date = date($format);
    $days = array();
    $dia = date('d-m-Y');

    // - 7 days from today

    for ($i = 1; $i < 7; $i++) {

        $days[] = $date;
        $plantilla->iniciaBloque("td_fecha");
        $plantilla->reemplazaEnBloque("fecha", $dia, "td_fecha");
        $dia = date('d-m-Y', strtotime("-$rango_fecha week" . $dia));
        $date = date($format, strtotime($dia));
    }

    $persona = new ipersona();
    $result = $persona->get_analisis_red_mes($idpersona, $idmodulo);

    $results = array();

    while ($fila = mysql_fetch_array($result)) {
        $results[] = $fila;
    }

    $result = $persona->get_persona($idpersona, $idmodulo);

    //print_r($results);
    $nombre = "";
    if ($fila = mysql_fetch_array($result)) {
        $nombre = $fila[apellido_p] . " " . $fila[apellido_m] . ", " . $fila[nombre];
    }
    $comentario = "";
    foreach ($days as $day) {

        $valor_1 = "00.png";
        $puntaje_2 = "?";
        $puntaje_3 = "?";
        foreach ($results as $result) {
            //echo $result[periodo]." vs ".$day."<br/>";
            if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 1) {
                $valor_1 = $result[valor];
                $comentario = $result[comentario];
            }
            if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 2) {
                $puntaje_2 = $result[puntaje];
                $comentario = $result[comentario];
            }
            if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 3) {
                $puntaje_3 = $result[puntaje];
                $comentario = $result[comentario];
            }
        }


        $plantilla->iniciaBloque("td_dimension");
        $plantilla->reemplazaEnBloque("posicion", $valor_1, "td_dimension");
        $plantilla->reemplazaEnBloque("ruta", ruta_images, "td_dimension");
        $plantilla->reemplazaEnBloque("poder", $puntaje_2, "td_dimension");
        $plantilla->reemplazaEnBloque("interes", $puntaje_3, "td_dimension");
        $plantilla->reemplazaEnBloque("comentario", $comentario, "td_dimension");
    }

    $plantilla->reemplaza("nombre", $nombre);
    $plantilla->reemplaza("idpersona", $fila[idpersona]);
    $plantilla->reemplaza("idmodulo", $fila[idmodulo]);
    $plantilla->reemplaza("idpersona_tipo", $fila[idpersona_tipo]);

    $result1 = $persona->lista_persona_red($idpersona, $idmodulo);
    $count = 0;
    while ($fila1 = mysql_fetch_array($result1)) {
        $count++;
        $result2 = $persona->get_analisis_red_mes($fila1[idpersona_red], $fila1[idmodulo_red]);
        $results = array();
        while ($fila2 = mysql_fetch_array($result2)) {
            $results[] = $fila2;
        }
        $plantilla->iniciaBloque("tr_red");
        $plantilla->reemplazaEnBloque("numero_red", $count, "tr_red");
        $plantilla->reemplazaEnBloque("nombre_red", $fila1[apellido_p] . " " . $fila1[apellido_m] . ", " . $fila1[nombre], "tr_red");
        $plantilla->reemplazaEnBloque("idpersona", $fila1[idpersona], "tr_red");
        $plantilla->reemplazaEnBloque("idmodulo", $fila1[idmodulo], "tr_red");
        $plantilla->reemplazaEnBloque("idpersona_tipo", $fila1[idpersona_tipo], "tr_red");
        $comenatrio = "";
        foreach ($days as $day) {

            $valor_1 = "00.png";
            $puntaje_2 = "?";
            $puntaje_3 = "?";
            foreach ($results as $result) {
                //echo $result[periodo]." vs ".$day."<br/>";
                if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 1) {
                    $valor_1 = $result[valor];
                    $comentario = $result[comentario];
                }
                if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 2) {
                    $puntaje_2 = $result[puntaje];
                    $comentario = $result[comentario];
                }
                if ($result[periodo] == $day && $result[iddimension_matriz_sh] == 3) {
                    $puntaje_3 = $result[puntaje];
                    $comentario = $result[comentario];
                }
            }

            $nombre = $result[nombre] . " " . $result[apellido_p];
            $plantilla->iniciaBloque("td_red");
            $plantilla->reemplazaEnBloque("posicion", $valor_1, "td_red");
            $plantilla->reemplazaEnBloque("ruta", ruta_images, "td_red");
            $plantilla->reemplazaEnBloque("poder", $puntaje_2, "td_red");
            $plantilla->reemplazaEnBloque("interes", $puntaje_3, "td_red");
            $plantilla->reemplazaEnBloque("comentario", $comentario, "td_red");
        }
    }



    $plantilla->presentaPlantilla();
}

function ver_buscar_interaccion() {


    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/interaccion/buscar.html");

    //tipo
    $iinteraccion_tipo = new iinteraccion_tipo();

    $result_interaccion_tipo = $iinteraccion_tipo->lista_interaccion_tipo();

    while (!!$fila_tipo = mysql_fetch_array($result_interaccion_tipo)) {

        $plantilla->iniciaBloque("interaccion_tipo");
        $plantilla->reemplazaEnBloque("idinteraccion_tipo", $fila_tipo[idinteraccion_tipo], "interaccion_tipo");
        $plantilla->reemplazaEnBloque("interaccion_tipo", utf8_encode($fila_tipo[interaccion_tipo]), "interaccion_tipo");
    }

    //estado
    $iinteraccion_estado = new iinteraccion_estado();

    $result_interaccion_estado = $iinteraccion_estado->lista_interaccion_estado();

    while (!!$fila_estado = mysql_fetch_array($result_interaccion_estado)) {

        $plantilla->iniciaBloque("interaccion_estado");
        $plantilla->reemplazaEnBloque("idinteraccion_estado", $fila_estado[idinteraccion_estado], "interaccion_estado");
        $plantilla->reemplazaEnBloque("interaccion_estado", $fila_estado[interaccion_estado], "interaccion_estado");
    }

    $plantilla->presentaPlantilla();
}

function buscar_interaccion($idinteraccion, $idmodulo_interaccion, $idinteraccion_estado, $prioridades, $tipos, $fecha_del, $fecha_al, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $interaccion) {

    $seguridad = new Seguridad();

    $ayudante = new Ayudante();

    $iinteraccion = new iinteraccion();

    $result_interaccion = $iinteraccion->lista($idinteraccion, $idmodulo_interaccion, $idinteraccion_estado, $prioridades, $tipos, $fecha_del, $fecha_al, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $interaccion);
    $total = 0;
    $datos = array();
    $aux_cursor = "X";
    while ($fila = mysql_fetch_array($result_interaccion)) {
        if ($aux_cursor != ($fila[idinteraccion] . '---' . $fila[idmodulo_interaccion])) {
            $total++;
            $idinteraccion = $fila[idinteraccion];
            $idmodulo_interaccion = $fila[idmodulo_interaccion];
            $interaccion = $fila[interaccion];
            $prioridad = $fila[idinteraccion_prioridad];
            $estado = $fila[interaccion_estado];
            $tipo = $fila[interaccion_tipo];
            $fecha = $ayudante->FechaRevez($fila[fecha]);

            $accion = "<a href='javascript:modal_ver_predio_entidad(\"interaccion\",$idinteraccion,$idmodulo_interaccion)' title='Ver GIS'><img src='../../../img/layers.png' alt='GIS'/></a>";
            $accion.="<a href='javascript:exportar_pdf_interaccion(\"frame3\",$idinteraccion,$idmodulo_interaccion)' title='Ver PDF'><img src='../../../img/pdf.png' alt='PDF'/></a>";

            if ($seguridad->verifica_permiso("Editar", "Interaccion", $fila[idusu_c], $fila[idmodulo_c]))
                $accion.="<a href='javascript:modal_interaccion($idinteraccion,$idmodulo_interaccion,2)' title='Editar interacci&oacute;n'><img src='../../../img/edit.png' alt='Editar'/></a>";

            if ($seguridad->verifica_permiso("Eliminar", "Interaccion", $fila[idusu_c], $fila[idmodulo_c]))
                $accion.="<a href='javascript:eliminar_interaccion($idinteraccion,$idmodulo_interaccion)' title='Eliminar interacci&oacute;n'><img src='../../../img/trash.png' alt='Eliminar'/></a>";

            if ($fila[archivos] > 0)
                $accion.="<img src='../../../img/attach.png' alt='adjuntos'/>";

            if (isset($fila[idgis_item]) && $fila[idgis_item] != "") {
                $datos['idgis_item'][$fila[idgis_item]] = $fila[interacciones];
            }

            $datos["data"][] = array("interaccion" => utf8_encode($interaccion), "estado" => $estado, "prioridad" => $prioridad, "tipo" => utf8_encode($tipo), "fecha" => $fecha, "accion" => $accion);


            $aux_cursor = $fila[idinteraccion] . '---' . $fila[idmodulo_interaccion];
        }
    }
    $datos["total"] = $total;

    $fid_string = " ";

    foreach ($datos['idgis_item'] as $idgis_item => $interacciones) {
        $fid_string .= $idgis_item . ",";
    }


    $fid_string = substr($fid_string, 0, -1);

    $datos["fid_string"] = $fid_string;
    //$plantilla->presentaPlantilla();
    echo json_encode($datos);
}

function exportar_interaccion($idinteraccion_estado, $prioridades, $tipos, $fecha_del, $fecha_al, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $interaccion) {

    $ayudante = new Ayudante();

    $iinteraccion = new iinteraccion();
    $ipersona = new ipersona();

    $result_interaccion = $iinteraccion->lista("", "", $idinteraccion_estado, $prioridades, $tipos, $fecha_del, $fecha_al, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $interaccion);

    $datos = array();
    while ($fila = mysql_fetch_array($result_interaccion)) {

        $idinteraccion = $fila[idinteraccion];
        $idmodulo_interaccion = $fila[idmodulo_interaccion];
        $interaccion = $fila[interaccion];
        $estado = $fila[interaccion_estado];
        $prioridad = $fila[idinteraccion_prioridad];
        $tipo = utf8_encode($fila[interaccion_tipo]);
        $fecha = $ayudante->FechaRevez($fila[fecha]);
        $tags = "   ";
        $result = $iinteraccion->lista_tag_interaccion($idinteraccion, $idmodulo_interaccion);
        while ($fila = mysql_fetch_array($result)) {
            $tags.= $fila[tag] . " , ";
        }
        $tags = substr($tags, 0, -3);
        $rcs = "   ";
        $result = $iinteraccion->lista_interaccion_rc($idinteraccion, $idmodulo_interaccion);
        while ($fila = mysql_fetch_array($result)) {
            $rcs.= $fila[apellido_p] . " " . $fila[apellido_m] . " " . $fila[nombre] . " , ";
        }
        $rcs = substr($rcs, 0, -3);
        
        $shs = "   ";
        $atag_sh=array();
        $result = $iinteraccion->lista_interaccion_sh($idinteraccion, $idmodulo_interaccion);
        while ($fila = mysql_fetch_array($result)) {
            $posicion='';
            if($fila[posicion]!=''){
                $posicion=" ( $fila[posicion] )";
            }
            $shs.= $fila[apellido_p] . " " . $fila[apellido_m] . " " . $fila[nombre].$posicion. " , ";
            
            $result_tag_sh=$ipersona->get_persona_tag($fila[idpersona], $fila[idmodulo]);
            
            while ($fila_tag_sh = mysql_fetch_array($result_tag_sh)) {
                
                $atag_sh[$fila_tag_sh[tag]]=$fila_tag_sh[tag];
            }
            
        }
        $shs = substr($shs, 0, -3);
        
        $tag_sh="";
        foreach ($atag_sh as $tag_value) {
            $tag_sh.=utf8_encode($tag_value). " , ";
        }
        $tag_sh = substr($tag_sh, 0, -3);
        $datos[] = array("interaccion" => utf8_encode($interaccion), "estado" => $estado, "prioridad" => $prioridad, "tipo" => $tipo, "fecha" => $fecha, "tags" => utf8_encode($tags), "rcs" => utf8_encode($rcs), "shs" => utf8_encode($shs),"tag_sh"=>($tag_sh));
    }

    $fecha = date('d-m-Y');

    //objeto de PHP Excel
    $objPHPExcel = new PHPExcel();

    //algunos datos sobre autoría
    $objPHPExcel->getProperties()->setCreator("Daniel Montjoy");
    $objPHPExcel->getProperties()->setLastModifiedBy("Daniel Montjoy");
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

    $objPHPExcel->getActiveSheet()->SetCellValue("A4", "Reporte de Interacciones al $fecha");
    $objPHPExcel->getActiveSheet()->getStyle("A4:I4")->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle("A4")->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->mergeCells('A4:H4');

    $count = 9;
    $objPHPExcel->getActiveSheet()->SetCellValue("B" . $count, "Fecha");
    $objPHPExcel->getActiveSheet()->SetCellValue("C" . $count, "Tag Stakeholder");
   $objPHPExcel->getActiveSheet()->SetCellValue("D" . $count, "Stakeholder");

    $objPHPExcel->getActiveSheet()->SetCellValue("E" . $count, "Tipo");
    
    $objPHPExcel->getActiveSheet()->SetCellValue("F" . $count, "Prioridad");
    
    $objPHPExcel->getActiveSheet()->SetCellValue("G" . $count, utf8_encode("Tags interacción"));
    $objPHPExcel->getActiveSheet()->SetCellValue("H" . $count, utf8_encode("Interacción"));
       

    $objPHPExcel->getActiveSheet()->SetCellValue("I" . $count, "Estado");
    $objPHPExcel->getActiveSheet()->SetCellValue("J" . $count, "Relacionista");
    
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle("B" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("C" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("D" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("E" . $count)->applyFromArray($styleArray);
    
   
    
   
    
    $objPHPExcel->getActiveSheet()->getStyle("F" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("G" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("H" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("I" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("J" . $count)->applyFromArray($styleArray);

   
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(150);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);


    
    //iteramos para los resultados
    $count++;
    foreach ($datos as $row) {
        $objPHPExcel->getActiveSheet()->SetCellValue("B" . $count, $row["fecha"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("C" . $count, $row["tag_sh"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("D" . $count, $row["shs"]);
     
        $objPHPExcel->getActiveSheet()->SetCellValue("E" . $count, $row["tipo"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("F" . $count, $row["prioridad"]);
    
        
       
        
      
        
        $objPHPExcel->getActiveSheet()->SetCellValue("G" . $count, $row["tags"]);

        $objPHPExcel->getActiveSheet()->SetCellValue("H" . $count, $row["interaccion"]);
       
        $objPHPExcel->getActiveSheet()->SetCellValue("I" . $count, $row["estado"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("J" . $count, $row["rcs"]);
        $count++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('B1:B' . $objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

    //Titulo del libro y seguridad 
    $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    $objPHPExcel->getSecurity()->setLockWindows(true);
    $objPHPExcel->getSecurity()->setLockStructure(true);


    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=reporte_interacciones_al_$fecha.xlsx ");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    ob_clean();
    flush();
    //readfile($fichero);
    $objWriter->save('php://output');


    exit;
}

function exportar_pdf_organizacion($idpersona, $idmodulo) {

    $ipersona = new ipersona();

    $personas = "";
    //$rcs= substr($rcs, 0, -3);
    $result = $ipersona->lista_persona_organizacion($idpersona, $idmodulo);
    $i = 1;
    while ($fila = mysql_fetch_array($result)) {
        $personas.= "$i. " . $fila[apellido_p] . " " . $fila[apellido_m] . " " . $fila[nombre] . " ( " . $fila[cargo] . " ) \n";
        $i++;
    }

    $result = $ipersona->lista_organizacion($idpersona, $idmodulo);
    $organizacion = "";
    if ($fila = mysql_fetch_array($result)) {
        $organizacion = $fila[apellido_p];
    }


    $pdf = new PDF();
    // Primera página
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(0, 10, 'Lista de Miembros de la Organizacion', 0, 1, 'C');
    $pdf->Cell(0, 10, "$organizacion", 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln(10);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, ' Miembros :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(120, 5, $personas, 0, 'L');
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output("Organizacion_$idpersona-$idmodulo.pdf", 'D');

    //============================================================+
    // END OF FILE
    //============================================================+
}

function exportar_pdf_compromiso($idcompromiso, $idmodulo_compromiso) {

    $icompromiso = new icompromiso();


    $acompromiso = $icompromiso->get_compromiso($idcompromiso, $idmodulo_compromiso);

    $codigo = "";
    $compromiso = "";
    $estado = "";
    $prioridad = "";
    $tipo = "";
    $fecha = "";
    $fecha_fin = "";
    $tags = "";
    $rcs = "";
    $shs = "";
    $archivos = "";
    $interaccion = "";

    $codigo = $idcompromiso . "-" . $idmodulo_compromiso;
    $compromiso = utf8_decode($acompromiso['compromiso'][$idcompromiso . "-" . $idmodulo_compromiso]);
    $estado = $acompromiso['estado'][$idcompromiso . "-" . $idmodulo_compromiso];
    $prioridad = $acompromiso['prioridad'][$idcompromiso . "-" . $idmodulo_compromiso];
    $fecha = $acompromiso['fecha'][$idcompromiso . "-" . $idmodulo_compromiso] . " " . $acompromiso['hora'][$idcompromiso . "-" . $idmodulo_compromiso] . ":" . $acompromiso['minuto'][$idcompromiso . "-" . $idmodulo_compromiso] . "h";
    $fecha_fin = $acompromiso['fecha_fin'][$idcompromiso . "-" . $idmodulo_compromiso] . " " . $acompromiso['hora_fin'][$idcompromiso . "-" . $idmodulo_compromiso] . ":" . $acompromiso['minuto_fin'][$idcompromiso . "-" . $idmodulo_compromiso] . "h";
    $interaccion = $acompromiso['idinteraccion'][$idcompromiso . "-" . $idmodulo_compromiso] . "-" . $acompromiso['idmodulo_interaccion'][$idcompromiso . "-" . $idmodulo_compromiso];

    foreach ($acompromiso['rc'][$idcompromiso . "-" . $idmodulo_compromiso] as $fila) {
        $rcs.= "- " . $fila . "\n";
    }

    foreach ($acompromiso['sh'][$idcompromiso . "-" . $idmodulo_compromiso] as $fila) {
        $shs.= "- " . $fila . "\n";
    }

    $result = $icompromiso->lista_archivo($idcompromiso, $idmodulo_compromiso);
    while ($fila = mysql_fetch_array($result)) {
        $archivos.= "- " . $fila[archivo] . "\n";
    }

    $pdf = new PDF();
    // Primera página
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(0, 10, 'Compromiso', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln(10);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, '1. Código :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(30, 10, $codigo, 0, 0, 'L');
    $pdf->Cell(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, 'Código de Interacción :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $interaccion, 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, '2. Compromiso :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(150, 5, $compromiso, 0, 'J');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, '3. Prioridad :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $prioridad, 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10);
    $pdf->Cell(30, 10, 'Estado :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $estado, 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, '4. Fecha :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $fecha, 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10);
    $pdf->Cell(30, 10, 'Fecha Fin :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $fecha_fin, 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, '5. Relacionistas :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(120, 5, utf8_decode($rcs), 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, '6. Stakeholders :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(120, 5, utf8_decode($shs), 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, '7. Archivos :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(120, 5, $archivos, 0, 'L');


    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output("Compromiso_$idcompromiso-$idmodulo_compromiso.pdf", 'D');

    //============================================================+
    // END OF FILE
    //============================================================+
}

function ver_buscar_compromiso() {


    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/compromiso/buscar.html");

    $icompromiso_estado = new icompromiso_estado();

    $result = $icompromiso_estado->lista_compromiso_estado();

    while ($fila = mysql_fetch_array($result)) {

        $plantilla->iniciaBloque("compromiso_estado");
        $plantilla->reemplazaEnBloque("idcompromiso_estado", $fila[idcompromiso_estado], "compromiso_estado");
        $plantilla->reemplazaEnBloque("compromiso_estado", $fila[compromiso_estado], "compromiso_estado");
    }

    $icompromiso_prioridad = new icompromiso_prioridad();

    $result = $icompromiso_prioridad->lista_compromiso_prioridad();

    while ($fila = mysql_fetch_array($result)) {

        $plantilla->iniciaBloque("compromiso_prioridad");
        $plantilla->reemplazaEnBloque("idcompromiso_prioridad", $fila[idcompromiso_prioridad], "compromiso_prioridad");
        $plantilla->reemplazaEnBloque("compromiso_prioridad", $fila[compromiso_prioridad], "compromiso_prioridad");
    }

    $plantilla->presentaPlantilla();
}

function buscar_compromiso($idcompromiso, $idmodulo_compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $fecha_del, $fecha_al, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $compromiso) {

    $icompromiso = new icompromiso();
    $seguridad = new Seguridad();

    $result = $icompromiso->lista($idcompromiso, $idmodulo_compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $fecha_del, $fecha_al, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $compromiso);

    $total = 0;
    $datos = array();
    while ($fila = mysql_fetch_array($result)) {

        $total++;
        $idcompromiso = $fila[idcompromiso];
        $idmodulo_compromiso = $fila[idmodulo_compromiso];
        $compromiso = $fila[compromiso];

        $compromiso_estado = $fila[compromiso_estado];
        $compromiso_prioridad = $fila[compromiso_prioridad];
        $fecha = $fila[fecha];
        $accion = "<a href='javascript:modal_ver_predio_entidad(\"compromiso\",$idcompromiso,$idmodulo_compromiso)' title='Ver GIS'><img src='../../../img/layers.png' alt='GIS'/></a>";
        $accion.="<a href='javascript:exportar_pdf_compromiso(\"frame4\",$idcompromiso,$idmodulo_compromiso)' title='Ver PDF'><img src='../../../img/pdf.png' alt='PDF'/></a>";

        if ($seguridad->verifica_permiso("Editar", "Compromiso", $fila[idusu_c], $fila[idmodulo_c]))
            $accion.="<a href='javascript:modal_editar_compromiso($idcompromiso,$idmodulo_compromiso)' title='Editar compromiso'><img src='../../../img/edit.png' alt='Editar'/></a>";

        if ($fila[archivos] > 0)
            $accion.="<img src='../../../img/attach.png' alt='adjuntos'/>";

        if (isset($fila[idgis_item])) {
            $datos['idgis_item'][$fila[idgis_item]] = $fila[compromisos];
        }

        $datos["data"][] = array("compromiso" => utf8_encode($compromiso), "estado" => $compromiso_estado, "prioridad" => $compromiso_prioridad, "fecha" => $fecha, "accion" => $accion);
    }

    $datos["total"] = $total;

    $fid_string = " ";

    foreach ($datos['idgis_item'] as $idgis_item => $compromiso) {
        $fid_string .= $idgis_item . ",";
    }


    $fid_string = substr($fid_string, 0, -1);

    $datos["fid_string"] = $fid_string;
    //$plantilla->presentaPlantilla();
    echo json_encode($datos);
}

function exportar_compromiso($idcompromiso_estado, $idcompromiso_prioridad, $fecha_del, $fecha_al, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $compromiso) {

    $ayudante = new Ayudante();

    $icompromiso = new icompromiso();

    $result_compromiso = $icompromiso->lista("", "", $idcompromiso_estado, $idcompromiso_prioridad, $fecha_del, $fecha_al, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $compromiso);

    $datos = array();
    while ($fila = mysql_fetch_array($result_compromiso)) {

        $idcompromiso = $fila[idcompromiso];
        $idmodulo_compromiso = $fila[idmodulo_compromiso];
        $compromiso = $fila[compromiso];

        $compromiso_estado = $fila[compromiso_estado];
        $compromiso_prioridad = $fila[compromiso_prioridad];
        $fecha = $fila[fecha];

        $rcs = "   ";
        $result = $icompromiso->lista_compromiso_rc($idcompromiso, $idmodulo_compromiso);
        while ($fila = mysql_fetch_array($result)) {
            $rcs.= $fila[apellido_p] . " " . $fila[apellido_m] . " " . $fila[nombre] . " , ";
        }
        $rcs = substr($rcs, 0, -3);

        $shs = "   ";
        $result = $icompromiso->lista_compromiso_sh($idcompromiso, $idmodulo_compromiso);
        while ($fila = mysql_fetch_array($result)) {
            $shs.= $fila[apellido_p] . " " . $fila[apellido_m] . " " . $fila[nombre] . " , ";
        }
        $shs = substr($shs, 0, -3);


        $datos[] = array("compromiso" => utf8_encode($compromiso), "estado" => $compromiso_estado, "prioridad" => $compromiso_prioridad, "fecha" => $fecha, "rcs" => utf8_encode($rcs), "shs" => utf8_encode($shs));
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
    $objPHPExcel->getActiveSheet()->mergeCells('A1:H2');
    $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

    $objPHPExcel->getActiveSheet()->SetCellValue("A4", "Reporte de Compromisos al $fecha");
    $objPHPExcel->getActiveSheet()->getStyle("A4:H4")->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle("A4")->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->mergeCells('A4:H4');

    $count = 8;

    $objPHPExcel->getActiveSheet()->SetCellValue("B" . $count, "Compromiso");
    $objPHPExcel->getActiveSheet()->SetCellValue("C" . $count, "Estado");
    $objPHPExcel->getActiveSheet()->SetCellValue("D" . $count, "Prioridad");
    $objPHPExcel->getActiveSheet()->SetCellValue("E" . $count, "Fecha");
    $objPHPExcel->getActiveSheet()->SetCellValue("F" . $count, "RC");
    $objPHPExcel->getActiveSheet()->SetCellValue("G" . $count, "SH");

    $styleArray = array(
        'font' => array(
            'bold' => true
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle("B" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("C" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("D" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("E" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("F" . $count)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle("G" . $count)->applyFromArray($styleArray);
    //iteramos para los resultados
    $count++;
    foreach ($datos as $row) {
        $objPHPExcel->getActiveSheet()->SetCellValue("B" . $count, $row["compromiso"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("C" . $count, $row["estado"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("D" . $count, $row["prioridad"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("E" . $count, $row["fecha"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("F" . $count, $row["rcs"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("G" . $count, $row["shs"]);
        $count++;
    }

    //Titulo del libro y seguridad 
    $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    $objPHPExcel->getSecurity()->setLockWindows(true);
    $objPHPExcel->getSecurity()->setLockStructure(true);



    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=reporte_compromisos_al_$fecha.xlsx ");
    header('Cache-Control: max-age=0');


    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    ob_clean();
    flush();
    //readfile($fichero);
    $objWriter->save('php://output');


    exit;
}

function obtener_calificacion_stakeholder($idpersona, $idmodulo, $fecha_del, $fecha_al) {
    $iidimension = new idimension_matriz_sh();
    $ayudante = new Ayudante();
    $fecha_del = $ayudante->FechaRevezMysql($fecha_del, "/");
    $fecha_al = $ayudante->FechaRevezMysql($fecha_al, "/");

    $result = $iidimension->lista_calificacion($idpersona, $idmodulo, $fecha_del, $fecha_al);

    $datos = array();


    while ($fila = mysql_fetch_array($result)) {
        $fecha = $fila[fecha];
        $posicion = $fila[posicion];
        $poder = $fila[poder];
        $interes = $fila[interes];
        $idsh_dimension = $fila[idsh_dimension];
        $idmodulo_sh_dimension = $fila[idmodulo_sh_dimension];

        $accion = "<a href=\"javascript:eliminar_calificacion($idsh_dimension,$idmodulo_sh_dimension)\" ><img src=\"../../../img/trash.png\" /></a>";
        $data = array("fecha" => $fecha, "posicion" => $posicion, "poder" => $poder, "interes" => $interes, "accion" => $accion);
        $datos[] = $data;
    }

    echo json_encode($datos);
}

function ver_buscar_red() {


    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/red/buscar.html");


    $plantilla->presentaPlantilla();
}

function consultar_indentificadores_geograficos($idtag_compuesto, $tags, $tags_predio) {



    $istakeholder = new istakeholder();

    $result = $istakeholder->lista_stakeholder_predio_tag($idtag_compuesto, $tags, $tags_predio);

    $fid_string = " ";

    while ($fila = mysql_fetch_array($result)) {
        $fid_string .= $fila[idgis_item] . ",";
    }

    $datos = array();

    $fid_string = substr($fid_string, 0, -1);

    $datos["fid_string"] = $fid_string;

    echo json_encode($datos);
}

function ver_predio_persona($idgis_item) {

    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/mapa/ver_predio_persona.html");
    $istakeholder = new istakeholder();
    $result = $istakeholder->listar_predio_persona($idgis_item);
    $count = 0;

    while ($fila = mysql_fetch_array($result)) {

        $count++;

        $plantilla->iniciaBloque("persona");
        $plantilla->reemplazaEnBloque("numero", $count, "persona");
        if ($fila[idpersona_tipo] > 1) {
            $plantilla->reemplazaEnBloque("nombre", utf8_encode($fila[apellido_p]), "persona");
        } else {
            $plantilla->reemplazaEnBloque("nombre", utf8_encode($fila[nombre] . " " . $fila[apellido_p] . " " . $fila[apellido_m]), "persona");
        }
        $plantilla->reemplazaEnBloque("idpersona_compuesto", $fila[idpersona] . "---" . $fila[idmodulo], "persona");
    }

    $plantilla->presentaPlantilla();
}

function actualizar_predio_stakeholder($idpredio, $idmodulo_predio, $idpredio_archivo, $comentario_predio, $idpredio_complejo_tag, $orden_complejo_tag) {

    $gstakeholder = new gstakeholder();
    $respuesta = $gstakeholder->actualizar_predio($idpredio, $idmodulo_predio, $comentario_predio, $idpredio_archivo, $idpredio_complejo_tag, $orden_complejo_tag);

    $arespuesta = split("---", $respuesta);

    $data['op_stakeholder'] = true;



    if ($arespuesta[1] == 0) {

        $count = 0;
        $archivos = array();

        foreach ($_FILES["archivos"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                $archivo = $_FILES["archivos"]["name"][$key];

                $uploadfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "predio" . DIRECTORY_SEPARATOR . $idpredio . '_' . $archivo;
                $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "predio" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $idpredio . '_' . $archivo;
                //echo $uploadfile." ";

                if (move_uploaded_file($tmp_name, $uploadfile)) {
                    $archivos[] = $archivo;
                    $count++;
                    $thumb = new thumb();
                    if ($thumb->loadImage($uploadfile)) {

                        $thumb->resize(100, 'height');
                        $thumb->save($thumbfile);
                    }
                }
            }
        }

        if ($count > 0) {
            $gstakeholder->agregar_archivo_predio($idpredio, $archivos);
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
?>

