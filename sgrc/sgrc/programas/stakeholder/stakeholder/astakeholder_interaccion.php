<?php

function guardar_interaccion_stakeholder($idpersona, $idmodulo, $interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $idinteraccion_complejo_tag, $idinteraccion_prioridad, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $comentario_interaccion, $orden_complejo_tag, $idpredio = '', $idmodulo_predio = '', $minuto_dura_interaccion) {

    //echo "llega".$fecha_interaccion;exit;
    $gstakeholder = new gstakeholder();
    //echo "verr".$idinteraccion_complejo_rc." ".$idinteraccion_complejo_sh;exit;
    $respuesta = $gstakeholder->agregar_interaccion($idpersona, $idmodulo, $interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $idinteraccion_complejo_tag, $idinteraccion_prioridad, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $comentario_interaccion, $orden_complejo_tag, $idpredio, $idmodulo_predio, $minuto_dura_interaccion);



    $arespuesta = split("---", $respuesta);
    if ($arespuesta[2] == 0) {

        $error_archivo = false;

        $count = 0;
        $archivos = array();

        foreach ($_FILES["archivos"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                $archivo = $_FILES["archivos"]["name"][$key];

                $uploadfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "interaccion" . DIRECTORY_SEPARATOR . $arespuesta[0] . '_' . $archivo;
                $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "interaccion" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $arespuesta[0] . '_' . $archivo;
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
            } else {
                $error_archivo = true;
            }
        }

        if ($count > 0) {
            $gstakeholder->agregar_archivo_interaccion($arespuesta[0], $arespuesta[1], $archivos);
        }

        $data['success'] = true;
        $data['error_archivo'] = $error_archivo;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " de la interaccion ");
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " de la interaccion ");
    }
    $data['op_stakeholder'] = false;

    echo json_encode($data);
    //echo $respuesta;
}

function ver_interaccion_stakolder_complejo($idpersona = "", $idmodulo = "", $idinteraccion = "", $idmodulo_interaccion = "", $persona = "", $presenta, $depredio = '') {

    if (empty($depredio)) {
        $plantilla = new DmpTemplate("../../../plantillas/stakeholder/interaccion/interaccion_complejo.html");
    } else {
        $plantilla = new DmpTemplate("../../../plantillas/predio/interaccion/interaccion_complejo.html");
    }

    $max_upload = (int) (ini_get('upload_max_filesize'));
    $max_post = (int) (ini_get('post_max_size'));
    $memory_limit = (int) (ini_get('memory_limit'));
    $upload_mb = min($max_upload, $max_post, $memory_limit);

    $plantilla->reemplaza("maximo", $upload_mb);

    ///actualizar
    if ($idinteraccion != "") {//solo uno xq se sobre entiende que viene el idmodulo
        $plantilla->reemplaza("idinteraccion", $idinteraccion);
        $plantilla->reemplaza("idmodulo_interaccion", $idmodulo_interaccion);
        $plantilla->reemplaza("op_stakeholder", "actualizar_interaccion_stakeholder");
        $plantilla->reemplaza("tabla_interaccion", 0); //$tabla_interaccion
        $plantilla->reemplaza("persona", $persona);


        $ointeraccion = new iinteraccion();
        $result = $ointeraccion->get_interaccion($idinteraccion, $idmodulo_interaccion);

        while ($fila = mysql_fetch_array($result)) {
            if (!empty($fila[idpredio])) {
                $plantilla->reemplaza("idpredio", $fila[idpredio]);
                $plantilla->reemplaza("idmodulo_predio", $fila[idmodulo_predio]);

                $plantilla->reemplaza("op_predio", "actualizar_interaccion_predio");
            }
            $plantilla->reemplaza("interaccion", utf8_encode($fila[interaccion]));
            $plantilla->reemplaza("fecha_interaccion", $fila[fecha]);
            $plantilla->reemplaza("minuto_dura_interaccion", $fila[duracion_minutos]);
            $iinteraccion_estado = new iinteraccion_estado();

            $result_interaccion_estado = $iinteraccion_estado->lista_interaccion_estado();

            while (!!$fila_estado = mysql_fetch_array($result_interaccion_estado)) {

                $plantilla->iniciaBloque("interaccion_estado");
                $plantilla->reemplazaEnBloque("idinteraccion_estado", $fila_estado[idinteraccion_estado], "interaccion_estado");
                $plantilla->reemplazaEnBloque("interaccion_estado", $fila_estado[interaccion_estado], "interaccion_estado");
                //echo "estado".$fila[idinteraccion_estado]."xxxxx".$fila_estado[idinteraccion_estado];
                if ($fila_estado[idinteraccion_estado] == $fila[idinteraccion_estado]) {

                    $plantilla->reemplazaEnBloque("selected", "selected", "interaccion_estado");
                }
            }


            //tipo
            $iinteraccion_tipo = new iinteraccion_tipo();

            $result_interaccion_tipo = $iinteraccion_tipo->lista_interaccion_tipo();

            while (!!$fila_tipo = mysql_fetch_array($result_interaccion_tipo)) {

                $plantilla->iniciaBloque("interaccion_tipo");
                $plantilla->reemplazaEnBloque("idinteraccion_tipo", $fila_tipo[idinteraccion_tipo], "interaccion_tipo");
                $plantilla->reemplazaEnBloque("interaccion_tipo", utf8_encode($fila_tipo[interaccion_tipo]), "interaccion_tipo");
                if ($fila_tipo[idinteraccion_tipo] == $fila[idinteraccion_tipo]) {

                    $plantilla->reemplazaEnBloque("selected", "selected", "interaccion_tipo");
                }
            }

            //prioridad
            $plantilla->reemplaza("selected" . $fila[idinteraccion_prioridad], "selected");


            //tag
            $result_tag = $ointeraccion->lista_tag_interaccion($idinteraccion, $idmodulo_interaccion);
            $cont_tag = 0;
            $cont_tag_fila = 0;

            while (!!$fila_tag = mysql_fetch_array($result_tag)) {
                if ($cont_tag % 5 == 0) {
                    $plantilla->iniciaBloque("tr_tag_interaccion");
                    $cont_tag_fila++;
                    $cont_tag_celda = 0;
                }
                $plantilla->iniciaBloque("td_tag_interaccion");
                $plantilla->reemplazaEnBloque("tag", utf8_encode($fila_tag[tag]), "td_tag_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "td_tag_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "td_tag_interaccion");
                $plantilla->iniciaBloque("spinner_tag_interaccion");
                $plantilla->reemplazaEnBloque("prioridad", $fila_tag[prioridad], "spinner_tag_interaccion");

                $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "spinner_tag_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "spinner_tag_interaccion");
                $plantilla->iniciaBloque("eliminar_tag_interaccion");
                $plantilla->reemplazaEnBloque("interaccion_complejo_tag", $fila_tag[idinteraccion_tag] . "***" . $fila_tag[idmodulo_interaccion_tag] . "***1", "eliminar_tag_interaccion");

                $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "eliminar_tag_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "eliminar_tag_interaccion");


                $cont_tag++;
                $cont_tag_celda++;
            }

            ////antes coloco el numero real de celdas y filas
            $plantilla->reemplaza("nume_fila_interaccion_tag_complejo", $cont_tag_fila);
            $plantilla->reemplaza("nume_celda_interaccion_tag_complejo", $cont_tag_celda);

            ///
            while ($cont_tag_celda < 5) {
                $plantilla->iniciaBloque("td_tag_interaccion");
                $plantilla->reemplazaEnBloque("tag", "&nbsp;", "td_tag_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_fila", $cont_tag_fila, "td_tag_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda", $cont_tag_celda, "td_tag_interaccion");

                $cont_tag_celda++;
            }
            //rc
            $result_rc = $ointeraccion->lista_interaccion_rc($idinteraccion, $idmodulo_interaccion);
            $cont_rc = 0;
            $cont_rc_fila = 0;

            while (!!$fila_rc = mysql_fetch_array($result_rc)) {
                if ($cont_rc % 5 == 0) {
                    $plantilla->iniciaBloque("tr_rc_interaccion");
                    $cont_rc_fila++;
                    $cont_rc_celda = 0;
                }

                $plantilla->iniciaBloque("td_rc_interaccion");
                $plantilla->reemplazaEnBloque("rc", utf8_encode($fila_rc[apellido_p] . " " . $fila_rc[apellido_m] . ", " . $fila_rc[nombre]), "td_rc_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "td_rc_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "td_rc_interaccion");

                $plantilla->iniciaBloque("idinteraccion_complejo_rc");

                $plantilla->reemplazaEnBloque("idinteraccion_complejo_rc", $fila_rc[idinteraccion_rc] . "***" . $fila_rc[idmodulo_interaccion_rc] . "***1", "idinteraccion_complejo_rc");
                $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "idinteraccion_complejo_rc");
                $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "idinteraccion_complejo_rc");

                //if ($_SESSION[idusu] . "-" . $_SESSION[idmodulo_a] != $fila_rc[idpersona] . "-" . $fila_rc[idmodulo]) {
                $plantilla->iniciaBloque("eliminar_rc_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "eliminar_rc_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "eliminar_rc_interaccion");
                //}
                $cont_rc++;
                $cont_rc_celda++;
            }

            $plantilla->reemplaza("cant_rc", $cont_rc);
            ////antes coloco el numero real de celdas y filas
            $plantilla->reemplaza("nume_fila_interaccion_rc_complejo", $cont_rc_fila);
            $plantilla->reemplaza("nume_celda_interaccion_rc_complejo", $cont_rc_celda);

            ///
            while ($cont_rc_celda < 5) {
                $plantilla->iniciaBloque("td_rc_interaccion");
                $plantilla->reemplazaEnBloque("rc", "&nbsp;", "td_rc_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_fila_rc", $cont_rc_fila, "td_rc_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda_rc", $cont_rc_celda, "td_rc_interaccion");

                $cont_rc_celda++;
            }
            //sh
            $resulta_sh = $ointeraccion->lista_interaccion_sh($idinteraccion, $idmodulo_interaccion);
            $cont_sh = 0;
            $cont_sh_fila = 0;
            while (!!$fila_sh = mysql_fetch_array($resulta_sh)) {
                if ($cont_sh % 5 == 0) {
                    $plantilla->iniciaBloque("tr_sh_interaccion");
                    $cont_sh_fila++;
                    $cont_sh_celda = 0;
                }

                $plantilla->iniciaBloque("td_sh_interaccion");
                if ($fila_sh[idpersona_tipo] > 1) {
                    $plantilla->reemplazaEnBloque("sh", utf8_encode($fila_sh[apellido_p]), "td_sh_interaccion");
                } else {
                    $plantilla->reemplazaEnBloque("sh", utf8_encode($fila_sh[apellido_p] . " " . $fila_sh[apellido_m] . ", " . $fila_sh[nombre]), "td_sh_interaccion");
                }

                $plantilla->reemplazaEnBloque("idsh", $fila_sh[idsh], "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("idmodulo", $fila_sh[idmodulo], "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("idpersona_tipo", $fila_sh[idpersona_tipo], "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_interaccion");

                $plantilla->iniciaBloque("idinteraccion_complejo_sh");

                $plantilla->reemplazaEnBloque("idinteraccion_complejo_sh", $fila_sh[idinteraccion_sh] . "***" . $fila_sh[idmodulo_interaccion_sh] . "***1", "idinteraccion_complejo_sh");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "idinteraccion_complejo_sh");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "idinteraccion_complejo_sh");

                //if ($idpersona . "-" . $idmodulo != $fila_sh[idpersona] . "-" . $fila_sh[idmodulo]) {
                $plantilla->iniciaBloque("eliminar_sh_interaccion");
                //***1 el estado activo, al cambiar a 0, el estado desactivo

                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "eliminar_sh_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "eliminar_sh_interaccion");
                //}
                $cont_sh++;
                $cont_sh_celda++;
            }

            $plantilla->reemplaza("cant_sh", $cont_sh);

            ////antes coloco el numero real de celdas y filas
            $plantilla->reemplaza("nume_fila_interaccion_sh_complejo", $cont_sh_fila);
            $plantilla->reemplaza("nume_celda_interaccion_sh_complejo", $cont_sh_celda);

            ///
            while ($cont_sh_celda < 5) {
                $plantilla->iniciaBloque("td_sh_interaccion");
                $plantilla->reemplazaEnBloque("sh", "&nbsp;", "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", $cont_sh_fila, "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", $cont_sh_celda, "td_sh_interaccion");

                $cont_sh_celda++;
            }

            $plantilla->reemplaza("comentario_interaccion", utf8_encode($fila[comentario]));

            //documento

            $result = $ointeraccion->lista_archivo($idinteraccion, $idmodulo_interaccion);

            while ($fila = mysql_fetch_array($result)) {
                $plantilla->iniciaBloque("archivo");
                $plantilla->reemplazaEnBloque("idinteraccion_archivo", $fila[idinteraccion_archivo], "archivo");
                $plantilla->reemplazaEnBloque("idmodulo_interaccion_archivo", $fila[idmodulo_interaccion_archivo], "archivo");
                $plantilla->reemplazaEnBloque("archivo", $fila[archivo], "archivo");
                $plantilla->reemplazaEnBloque("activo", $fila[activo], "archivo");
                $plantilla->reemplazaEnBloque("ruta", $idinteraccion . '_' . $fila[archivo], "archivo");
                $plantilla->reemplazaEnBloque("fecha", date("d/m/Y", strtotime($fila[fecha_c])), "archivo");
            }
        }
        $plantilla->iniciaBloque("interaccion_pdf");
        $plantilla->reemplazaEnBloque("idinteraccion", $idinteraccion, "interaccion_pdf");
        $plantilla->reemplazaEnBloque("idmodulo_interaccion", $idmodulo_interaccion, "interaccion_pdf");
    } else {
        if (!empty($idpredio)) {
            $plantilla->reemplaza("idpredio", $idpredio);
            $plantilla->reemplaza("idmodulo_predio", $idmodulo_predio);
        }
        $plantilla->reemplaza("op_stakeholder", "guardar_interaccion_stakeholder");
        $plantilla->reemplaza("fecha_interaccion", date('d/m/Y'));

        $iinteraccion_estado = new iinteraccion_estado();

        $result_interaccion_estado = $iinteraccion_estado->lista_interaccion_estado();

        while (!!$fila_estado = mysql_fetch_array($result_interaccion_estado)) {

            $plantilla->iniciaBloque("interaccion_estado");
            $plantilla->reemplazaEnBloque("idinteraccion_estado", $fila_estado[idinteraccion_estado], "interaccion_estado");
            $plantilla->reemplazaEnBloque("interaccion_estado", $fila_estado[interaccion_estado], "interaccion_estado");
        }
        //tipo
        $iinteraccion_tipo = new iinteraccion_tipo();

        $result_interaccion_tipo = $iinteraccion_tipo->lista_interaccion_tipo();

        while (!!$fila_tipo = mysql_fetch_array($result_interaccion_tipo)) {

            $plantilla->iniciaBloque("interaccion_tipo");
            $plantilla->reemplazaEnBloque("idinteraccion_tipo", $fila_tipo[idinteraccion_tipo], "interaccion_tipo");
            $plantilla->reemplazaEnBloque("interaccion_tipo", utf8_encode($fila_tipo[interaccion_tipo]), "interaccion_tipo");
        }
        $persona = new ipersona();
        $result_persona = $persona->get_persona($_SESSION[idpersona], $_SESSION[idmodulo_persona]);
        $fila_rc = mysql_fetch_array($result_persona);
        $plantilla->iniciaBloque("tr_rc_interaccion");
        $plantilla->iniciaBloque("td_rc_interaccion");
        $plantilla->reemplazaEnBloque("rc", utf8_encode($fila_rc[apellido_p] . " " . $fila_rc[apellido_m] . ", " . $fila_rc[nombre]), "td_rc_interaccion");
        $plantilla->reemplazaEnBloque("celda_nume_fila_rc", 1, "td_rc_interaccion");
        $plantilla->reemplazaEnBloque("celda_nume_celda_rc", 1, "td_rc_interaccion");

        $plantilla->reemplaza("cant_rc", 1);

        $plantilla->iniciaBloque("idinteraccion_complejo_rc");
        $plantilla->reemplazaEnBloque("idinteraccion_complejo_rc", $fila_rc[idpersona] . "---" . $fila_rc[idmodulo], "idinteraccion_complejo_rc");
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

        $plantilla->reemplaza("nume_fila_interaccion_rc_complejo", 1);
        $plantilla->reemplaza("nume_celda_interaccion_rc_complejo", 2);

        $plantilla->reemplaza("cant_sh", $presenta);

        if ($presenta > 0) {

            $result_persona = $persona->get_persona($idpersona, $idmodulo);
            $fila_sh = mysql_fetch_array($result_persona);

            $plantilla->iniciaBloque("tr_sh_interaccion");
            $plantilla->iniciaBloque("td_sh_interaccion");
            $plantilla->reemplazaEnBloque("sh", utf8_encode($fila_sh[apellido_p] . " " . $fila_sh[apellido_m] . ", " . $fila_sh[nombre]), "td_sh_interaccion");
            $plantilla->reemplazaEnBloque("idsh", $fila_sh[idpersona], "td_sh_interaccion");
            $plantilla->reemplazaEnBloque("idmodulo", $fila_sh[idmodulo], "td_sh_interaccion");
            $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_interaccion");
            $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_interaccion");

            $plantilla->iniciaBloque("idinteraccion_complejo_sh");

            $plantilla->reemplazaEnBloque("idinteraccion_complejo_sh", $fila_sh[idpersona] . "---" . $fila_sh[idmodulo], "idinteraccion_complejo_sh");

            for ($cont_sh_celda = 2; $cont_sh_celda <= 5; $cont_sh_celda++) {
                $plantilla->iniciaBloque("td_sh_interaccion");
                $plantilla->reemplazaEnBloque("sh", "&nbsp;", "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "td_sh_interaccion");
                $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "td_sh_interaccion");
            }

            $plantilla->reemplaza("nume_fila_interaccion_sh_complejo", 1);
            $plantilla->reemplaza("nume_celda_interaccion_sh_complejo", 2);

            $plantilla->iniciaBloque("eliminar_sh_interaccion");
            //***1 el estado activo, al cambiar a 0, el estado desactivo

            $plantilla->reemplazaEnBloque("celda_nume_fila_sh", 1, "eliminar_sh_interaccion");
            $plantilla->reemplazaEnBloque("celda_nume_celda_sh", 1, "eliminar_sh_interaccion");
        }
    }

    $plantilla->presentaPlantilla();
}

function actualizar_interaccion_stakeholder($idinteraccion, $idmodulo_interaccion, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $idinteraccion_archivo, $comentario_interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $idinteraccion_prioridad, $interaccion, $idpersona = "", $idmodulo = "", $persona, $presenta, $orden_complejo_tag, $depredio = "", $minuto_dura_interaccion) {
    //echo "llega".$fecha_interaccion;exit;
    $gstakeholder = new gstakeholder();
    //echo "minutos".$minuto_dura_interaccion;
    $respuesta = $gstakeholder->actualizar_interaccion($idinteraccion, $idmodulo_interaccion, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $idinteraccion_archivo, $comentario_interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $idinteraccion_prioridad, $interaccion, $orden_complejo_tag, $minuto_dura_interaccion);
    //echo $respuesta;
    //$arespuesta=split("---", $respuesta);
    //ver_interaccion_stakolder_complejo("","",$idinteraccion,$idmodulo_interaccion);
    $arespuesta = split("---", $respuesta);

    if (empty($depredio)) {
        $data['op_stakeholder'] = true;
    } else {
        $data['op_predio'] = true;
    }

    if ($arespuesta[2] == 0) {

        $count = 0;
        $archivos = array();

        foreach ($_FILES["archivos"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
                $archivo = $_FILES["archivos"]["name"][$key];

                $uploadfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "interaccion" . DIRECTORY_SEPARATOR . $arespuesta[0] . '_' . $archivo;
                $thumbfile = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . "interaccion" . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . $arespuesta[0] . '_' . $archivo;
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
            $gstakeholder->agregar_archivo_interaccion($arespuesta[0], $arespuesta[1], $archivos);
        }



        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " de la interaccion ");
        $data['idinteraccion'] = $idinteraccion;
        $data['idmodulo_interaccion'] = $idmodulo_interaccion;
        //ver_bloque_interaccion($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1)
        if (empty($depredio)) {
            $data['data'] = ver_bloque_interaccion(1, "", $idinteraccion, $idmodulo_interaccion, 0, 3, 0);
        } else {
            $data['data'] = ver_bloque_interaccion_predio(1, "", $idinteraccion, $idmodulo_interaccion, 0, 3, 0);
        }
        //ver_bloque_interaccion($idpersona, $idmodulo, $inicio, $presenta = 1, $persona = 1, $tabla_interaccion = 1)
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " de la interaccion ");
    }

    echo json_encode($data);
}

function exportar_pdf_interaccion($idinteraccion, $idmodulo_interaccion) {
    $iinteraccion = new iinteraccion();

    $result = $iinteraccion->get_interaccion($idinteraccion, $idmodulo_interaccion);

    $codigo = "";
    $interaccion = "";
    $estado = "";
    $prioridad = "";
    $tipo = "";
    $fecha = "";
    $tags = "";
    $rcs = "";
    $shs = "";
    $archivos = "";
    if ($fila = mysql_fetch_array($result)) {

        $codigo = $fila[idinteraccion] . "-" . $fila[idmodulo_interaccion];
        $interaccion = $fila[interaccion];
        $estado = $fila[interaccion_estado];
        $prioridad = $fila[idinteraccion_prioridad];
        $tipo = $fila[interaccion_tipo];
        $fecha = $fila[fecha];
        $predio_nombre = $fila[nombre];
        $predio_direccion = $fila[direccion];
        $duracion_minutos = $fila[duracion_minutos];

        $result = $iinteraccion->lista_tag_interaccion($idinteraccion, $idmodulo_interaccion);
        while ($fila = mysql_fetch_array($result)) {
            $tags.= $fila[tag] . " (" . $fila[prioridad] . ") , ";
        }
        $tags = substr($tags, 0, -3);
        $result = $iinteraccion->lista_interaccion_rc($idinteraccion, $idmodulo_interaccion);
        while ($fila = mysql_fetch_array($result)) {
            $rcs.= "- " . $fila[apellido_p] . " " . $fila[apellido_m] . " " . $fila[nombre] . "\n";
        }
        //$rcs= substr($rcs, 0, -3);
        $result = $iinteraccion->lista_interaccion_sh($idinteraccion, $idmodulo_interaccion);
        $cont_sh = 0;

        while ($fila = mysql_fetch_array($result)) {
            $ash[idpersona][$cont_sh] = $fila[idpersona];
            $ash[idmodulo][$cont_sh] = $fila[idmodulo];
            if ($fila[idpersona_tipo] > 1) {
                $shs.= "- " . $fila[apellido_p] . "\n";
            } else {
                $shs.= "- " . $fila[apellido_p] . " " . $fila[apellido_m] . " " . $fila[nombre] . "\n";
            }
            $cont_sh++;
        }
        //$shs= substr($shs, 0, -3);
        $result = $iinteraccion->lista_archivo($idinteraccion, $idmodulo_interaccion);
        while ($fila = mysql_fetch_array($result)) {
            $archivos.= "- " . $fila[archivo] . "\n";
        }
        $archivos = substr($archivos, 0, -3);
    }

    $pdf = new PDF();
    // Primera página
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(0, 10, 'Interacción', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln(10);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, 'Código :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $codigo, 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10);
    $pdf->Cell(30, 10, 'Estado :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $estado, 0, 1, 'L');
    if (!empty($predio_nombre)) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(30, 10, 'Predio :', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, $predio_nombre, 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10);
        $pdf->Cell(30, 10, 'Dirección :', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, $predio_direccion, 0, 1, 'L');
    }


    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, 'Interacción :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(150, 5, $interaccion, 0, 'J');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, 'Prioridad :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $prioridad, 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, 'Tipo :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $tipo, 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, 'Fecha :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $fecha, 0, 0, 'L');
    /*     * *************** */
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10);
    $pdf->Cell(50, 10, 'Duración en minutos :', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, $duracion_minutos, 0, 1, 'L');
    /*     * *************** */
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, 'Tags :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(120, 10, $tags, 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, 'Relacionistas :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(120, 5, $rcs, 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, 'Stakeholders :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(120, 5, $shs, 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20);
    $pdf->Cell(30, 10, 'Archivos :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20);
    $pdf->MultiCell(120, 5, $archivos, 0, 'L');
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    ////////compromiso
    $icompromiso = new icompromiso();

    $acompromiso = $icompromiso->lista_interaccion_compromiso($idinteraccion, $idmodulo_interaccion);

    foreach ($acompromiso[compromiso] as $key => $compromiso) {

        $idcompromiso = $acompromiso['idcompromiso'][$key];
        $idmodulo_compromiso = $acompromiso['idmodulo_compromiso'][$key];
        $fecha_inicio = $acompromiso['fecha_compromiso'][$key];
        if ($acompromiso['fecha_fin'][$key] != "00/00/0000")
            $fecha_fin = $acompromiso['fecha_fin'][$key];
        else
            $fecha_fin = "";

        $estado = $acompromiso['compromiso_estado'][$key];
        $prioridad = $acompromiso['compromiso_prioridad'][$key];

        $rcs = "";
        foreach ($acompromiso['rc'][$key] as $rc_key => $rc) {

            $rcs.= "- " . $rc . "\n";
        }

        //$rcs= substr($rcs, 0, -3);
        $shs = "";
        foreach ($acompromiso['sh'][$key] as $sh_key => $sh) {


            $shs.= "- " . $sh . "\n";
        }

        //$shs= substr($shs, 0, -3);

        /*
          $result=$ireclamo->lista_archivo($areclamo[idreclamo][$key], $areclamo[idmodulo_reclamo][$key]);
          while($fila=  mysql_fetch_array($result)){
          $archivos.= "- ".$fila[archivo]. "\n";
          }
         */
        //$archivos= substr($archivos, 0, -3);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(0, 10, "Compromiso N° $idcompromiso-$idmodulo_compromiso ", 1, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(30, 5, "Fecha Inicio ", 'L', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 5, $fecha_inicio, 0, 0, 'L');
        $pdf->Cell(50);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 5, "Fecha Fin ", 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 5, $fecha_fin, 'R', 1, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(30, 5, "Estado ", 'L', 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 5, $estado, 0, 0, 'L');
        $pdf->Cell(50, 5, '', 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 5, "Prioridad", 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 5, $prioridad, 'R', 1, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(0, 5, "Relacionistas", 'LRT', 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(0, 5, $rcs, 'LR', 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(0, 5, "Stakeholders", 'LRT', 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(0, 5, $shs, 'LR', 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(0, 5, $compromiso, 1, 'L');
    }


    ///////compromiso
    $persona = new ipersona();
    foreach ($ash[idpersona] as $cont_sh => $idpersona) {
        //echo $ash[idpersona][$cont_sh];
        //echo $ash[idmodulo][$cont_sh];
        exportar_pdf_sh($ash[idpersona][$cont_sh], $ash[idmodulo][$cont_sh],$pdf);
        //$apersona = $persona->get_persona($ash[idpersona][$cont_sh], $ash[idmodulo][$cont_sh]);
    }
   $pdf->Output("Interaccion_$idinteraccion-$idmodulo_interaccion.pdf", 'D');
}

function descargar($programa, $ruta) {
    $fichero = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . "archivo" . DIRECTORY_SEPARATOR . $_SESSION['proyecto'] . DIRECTORY_SEPARATOR . $programa . DIRECTORY_SEPARATOR . $ruta;
    //echo $uploadfile;

    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $ruta);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fichero));
    ob_clean();
    flush();
    readfile($fichero);
    exit;
}

?>