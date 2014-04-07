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
include_once '../../../informacion/persona/class.iestado_civil.php';

function ver_editar_persona($es_stakeholder, $idpersona, $idmodulo, $idpersona_compuesto = "", $idpersona_tipo = "", $tiene_cabecera = "1") {
    //echo "$es_stakeholder $idpersona  $idmodulo  $idpersona_tipo"; exit;
    $seguridad = new Seguridad();
    $ayudante = new Ayudante();
    if ($idpersona_compuesto != "") {
        $apersona_compuesto = split("---", $idpersona_compuesto);
        $idpersona = $apersona_compuesto[0];
        $idmodulo = $apersona_compuesto[1];
    }

    $persona = new ipersona();
    $apersona = $persona->get_persona($idpersona, $idmodulo);
    if (!!$fila = mysql_fetch_array($apersona)) {
        if ($idpersona_tipo == "") {
            //  echo "entra";
            $idpersona_tipo = $fila[idpersona_tipo];
        }
        if ($idpersona_tipo == 1) {
            if ($es_stakeholder == 1) {

                $plantilla = new DmpTemplate("../../../plantillas/persona/persona/persona.html");
                if ($seguridad->verifica_permiso("Editar", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c]))
                    $plantilla->iniciaBloque("editar_sh");
            } else {
                $plantilla = new DmpTemplate("../../../plantillas/persona/persona/persona_rc.html");
                if ($seguridad->verifica_permiso("Editar", "Relacionista", $fila[idusu_c], $fila[idmodulo_c]))
                    $plantilla->iniciaBloque("editar_rc");
            }
        } else {
            if ($es_stakeholder == 1) {

                $plantilla = new DmpTemplate("../../../plantillas/persona/persona/organizacion.html");
                if ($seguridad->verifica_permiso("Editar", "Stakeholder", $fila[idusu_c], $fila[idmodulo_c]))
                    $plantilla->iniciaBloque("editar_sh");
            } else {
                $plantilla = new DmpTemplate("../../../plantillas/persona/persona/organizacion_rc.html");
                if ($seguridad->verifica_permiso("Editar", "Relacionista", $fila[idusu_c], $fila[idmodulo_c]))
                    $plantilla->iniciaBloque("editar_rc");
            }
        }


        $plantilla->reemplaza("op_persona", "editar");


        $plantilla->reemplaza("idpersona", $idpersona);
        $plantilla->reemplaza("idmodulo", $idmodulo);
        $plantilla->reemplaza("idpersona_tipo", $idpersona_tipo);
        $plantilla->reemplaza("es_stakeholder", $es_stakeholder);
        $plantilla->IniciaBloque("ver_ficha");
        $plantilla->reemplazaEnBloque("idpersona", $idpersona, "ver_ficha");
        $plantilla->reemplazaEnBloque("idmodulo", $idmodulo, "ver_ficha");
        $plantilla->reemplazaEnBloque("idpersona_tipo", $idpersona_tipo, "ver_ficha");


        $plantilla->reemplaza("cambiar_tipo_persona", "cambiar_tipo_persona($idpersona, $idmodulo, 0)");
        //if ($tiene_cabecera == 1) {
        $plantilla->reemplaza("clase", "class='bloque'");
        $plantilla->reemplaza("tr", "thead");
        //} else {
        //    $plantilla->reemplaza("clase_celda", "class = 'celda_titulo'");
        //    $plantilla->reemplaza("tr", "tr");
        //}

        $plantilla->reemplaza("apaterno", utf8_encode($fila[apellido_p]));
        $plantilla->reemplaza("amaterno", utf8_encode($fila[apellido_m]));
        $plantilla->reemplaza("nombre", utf8_encode($fila[nombre]));

        if (isset($fila[imagen]) && $fila[imagen] != "") {
            $plantilla->reemplaza("imagen", "../../../archivo/" . $_SESSION['proyecto'] . "/imagen/" . $fila[imagen]);
        } else {
            $plantilla->reemplaza("imagen", "../../../img/imagen.png");
        }

        $max_upload = (int) (ini_get('upload_max_filesize'));
        $max_post = (int) (ini_get('post_max_size'));
        $memory_limit = (int) (ini_get('memory_limit'));
        $upload_mb = min($max_upload, $max_post, $memory_limit);

        $plantilla->reemplaza("maximo", $upload_mb);

        if ($fila[sexo] == 1) {
            $plantilla->reemplaza("checkedM", "checked");
        } else {
            $plantilla->reemplaza("checkedF", "checked");
        }
        $plantilla->reemplaza("background", utf8_encode($fila[background]));
        $plantilla->reemplaza("comentario", utf8_encode($fila[comentario]));
        $plantilla->reemplaza("fecha_nacimiento", $fila[fecha_nacimiento]);
        //////tipo
        $persona_tipo = new itipo();
        $tipo_result = $persona_tipo->lista_persona_tipo();

        while (!!$fila_tipo = mysql_fetch_array($tipo_result)) {

            $plantilla->iniciaBloque("persona_tipo");
            $plantilla->reemplazaEnBloque("idtipo", $fila_tipo[idpersona_tipo], "persona_tipo");
            $plantilla->reemplazaEnBloque("tipo", utf8_encode($fila_tipo[tipo]), "persona_tipo");
            //echo "persona tipo" . $idpersona_tipo;


            if ($fila_tipo[idpersona_tipo] == $idpersona_tipo) {
                $plantilla->reemplazaEnBloque("selected", "selected", "persona_tipo");
            }
        }
    }
//estado civil
    $oestado_civil = new iestado_civil();
    $aestado_civil = $oestado_civil->lista_estado_civil();
    while (!!$fila_civil = mysql_fetch_array($aestado_civil)) {
        $plantilla->iniciaBloque("estado_civil");
        $plantilla->reemplazaEnBloque("idestado_civil", $fila_civil[idpersona_estado_civil], "estado_civil");
        $plantilla->reemplazaEnBloque("estado_civil", $fila_civil[descripcion], "estado_civil");


        if ($fila_civil[idpersona_estado_civil] == $fila[idestado_civil]) {
            $plantilla->reemplazaEnBloque("selected", "selected", "estado_civil");
        }
    }
    //direccion
    $apersona_direccion = $persona->get_persona_direccion($idpersona, $idmodulo);
    $cont = 0;
    while (!!$fila = mysql_fetch_array($apersona_direccion)) {

        if ($cont == 0) {
            $plantilla->reemplaza("persona_direccion", utf8_encode($fila[direccion]));
            $plantilla->reemplaza("idpersona_direccion", $fila[idpersona_direccion] . "***" . $fila[idmodulo_persona_direccion] . "***1");
        } else {
            $plantilla->iniciaBloque("direccion");
            $plantilla->reemplazaEnBloque("idpersona_direccion", $fila[idpersona_direccion] . "***" . $fila[idmodulo_persona_direccion] . "***1", "direccion");
            $plantilla->reemplazaEnBloque("persona_direccion", utf8_encode($fila['direccion']), "direccion");
            $plantilla->reemplazaEnBloque("i", $cont, "direccion");
        }

        $cont++;
    }
    if ($cont == 0) {
        $cont++;
        $plantilla->reemplaza("idpersona_direccion", "1");
    }
    $plantilla->reemplaza("nume_fila_direccion", $cont);
    ////telefono
    $apersona_telefono = $persona->get_persona_telefono($idpersona, $idmodulo);
    $cont = 0;
    while (!!$fila = mysql_fetch_array($apersona_telefono)) {

        if ($cont == 0) {
            $plantilla->reemplaza("persona_telefono", $fila[telefono]);
            $plantilla->reemplaza("idpersona_telefono", $fila[idpersona_telefono] . "***" . $fila[idmodulo_persona_telefono] . "***1");
        } else {
            $plantilla->iniciaBloque("telefono");
            $plantilla->reemplazaEnBloque("idpersona_telefono", $fila[idpersona_telefono] . "***" . $fila[idmodulo_persona_telefono] . "***1", "telefono");
            $plantilla->reemplazaEnBloque("persona_telefono", $fila[telefono], "telefono");
            $plantilla->reemplazaEnBloque("i", $cont, "telefono");
        }

        $cont++;
    }
    if ($cont == 0) {
        $cont++;
        $plantilla->reemplaza("idpersona_telefono", "1");
    }
    $plantilla->reemplaza("nume_fila_telefono", $cont);

    ///////email

    $apersona_mail = $persona->get_persona_email($idpersona, $idmodulo);
    $cont = 0;
    while (!!$fila = mysql_fetch_array($apersona_mail)) {

        if ($cont == 0) {
            $plantilla->reemplaza("persona_mail", $fila[mail]);
            $plantilla->reemplaza("idpersona_mail", $fila[idpersona_mail] . "***" . $fila[idmodulo_persona_mail] . "***1");
        } else {
            $plantilla->iniciaBloque("mail");
            $plantilla->reemplazaEnBloque("idpersona_mail", $fila[idpersona_mail] . "***" . $fila[idmodulo_persona_mail] . "***1", "mail");

            $plantilla->reemplazaEnBloque("persona_mail", $fila[mail], "mail");
            $plantilla->reemplazaEnBloque("i", $cont, "mail");
        }

        $cont++;
    }
    if ($cont == 0) {
        $cont++;
        $plantilla->reemplaza("idpersona_mail", "1");
    }
    $plantilla->reemplaza("nume_fila_mail", $cont);

    /////////////organizacion
    $apersona_organizacion = $persona->get_persona_organizacion($idpersona, $idmodulo);
    $cont = 0;
    $cargo = new icargo();
    $result_cargo = $cargo->lista_cargo();
    while (!!$fila = mysql_fetch_array($apersona_organizacion)) {

        $plantilla->iniciaBloque("organizacion");
        $plantilla->reemplazaEnBloque("idpersona_organizacion", $fila[idpersona_organizacion] . "***" . $fila[idmodulo_persona_organizacion] . "***1", "organizacion");
        $plantilla->reemplazaEnBloque("organizacion", utf8_encode($fila[apellido_p] . " (" . $fila[apellido_m] . ")"), "organizacion");
        $plantilla->reemplazaEnBloque("i", $cont, "organizacion");
        mysql_data_seek($result_cargo, 0);
        //echo "cargo".$fila[idpersona_cargo];
        while (!!$fila_cargo = mysql_fetch_array($result_cargo)) {

            $plantilla->iniciaBloque("cargo");
            $plantilla->reemplazaEnBloque("cargo", utf8_encode($fila_cargo[cargo]), "cargo");
            $plantilla->reemplazaEnBloque("idcargo", $fila_cargo[idpersona_cargo], "cargo");
            $plantilla->reemplazaEnBloque("i", $cont, "cargo");

            if ($fila_cargo[idpersona_cargo] == $fila[idpersona_cargo]) {
                $plantilla->reemplazaEnBloque("selected", "selected", "cargo");
            }
        }

        $cont++;
    }
    if ($cont == 0) {
        //$cont++;
        $plantilla->reemplaza("idpersona_organizacion", "1");
    }
    $plantilla->reemplaza("nume_fila", $cont);


    ////////documento de identificacion
    $apersona_documento_identificacion = $persona->get_persona_documento_identificacion($idpersona, $idmodulo);
    $cont = 0;
    $documento_identificacion = new idocumento_identificacion();
    $di_result = $documento_identificacion->lista_documento_identificacion();

    while (!!$fila = mysql_fetch_array($apersona_documento_identificacion)) {

        mysql_data_seek($di_result, 0);
        if ($cont == 0) {
            //echo $fila[documento_identificacion];
            $plantilla->reemplaza("numero_documento", $fila[documento_identificacion]);
            $plantilla->reemplaza("idpersona_documento_identificacion", $fila[idpersona_documento_identificacion] . "***" . $fila[idmodulo_persona_documento_identificacion] . "***1");

            while (!!$fila_di = mysql_fetch_array($di_result)) {

                $plantilla->iniciaBloque("documento_identificacion");
                $plantilla->reemplazaEnBloque("documento_identificacion", $fila_di[documento_identificacion], "documento_identificacion");
                $plantilla->reemplazaEnBloque("iddocumento_identificacion", $fila_di[iddocumento_identificacion], "documento_identificacion");

                if ($fila_di[iddocumento_identificacion] == $fila[iddocumento_identificacion]) {
                    $plantilla->reemplazaEnBloque("selected", "selected", "documento_identificacion");
                }
            }
        } else {
            $plantilla->iniciaBloque("item_documento_identificacion");
            $plantilla->reemplazaEnBloque("numero_documento", $fila[documento_identificacion], "item_documento_identificacion");
            $plantilla->reemplazaEnBloque("idpersona_documento_identificacion", $fila[idpersona_documento_identificacion] . "***" . $fila[idmodulo_persona_documento_identificacion] . "***1", "item_documento_identificacion");

            $plantilla->reemplazaEnBloque("i", $cont, "item_documento_identificacion");

            while (!!$fila_di = mysql_fetch_array($di_result)) {

                $plantilla->iniciaBloque("item_tipo_documento_identificacion");
                $plantilla->reemplazaEnBloque("documento_identificacion", $fila_di[documento_identificacion], "item_tipo_documento_identificacion");
                $plantilla->reemplazaEnBloque("iddocumento_identificacion", $fila_di[iddocumento_identificacion], "item_tipo_documento_identificacion");
                if ($fila_di[iddocumento_identificacion] == $fila[iddocumento_identificacion]) {
                    $plantilla->reemplazaEnBloque("selected", "selected", "item_tipo_documento_identificacion");
                }
            }
        }
        $cont++;
    }
    //para el caso que no se haya registrado ningun dni la primera vez
    if ($cont == 0) {
        $cont++;
        $plantilla->reemplaza("idpersona_documento_identificacion", "1");

        $di_result = $documento_identificacion->lista_documento_identificacion();
        while (!!$fila_di = mysql_fetch_array($di_result)) {

            $plantilla->iniciaBloque("documento_identificacion");

            $plantilla->reemplazaEnBloque("documento_identificacion", $fila_di[documento_identificacion], "documento_identificacion");
            $plantilla->reemplazaEnBloque("iddocumento_identificacion", $fila_di[iddocumento_identificacion], "documento_identificacion");
        }
    }
    $plantilla->reemplaza("nume_fila_documento_identificacion", $cont);

    //$plantilla->presentaPlantilla();
    return ($plantilla->getPlantillaCadena());
}

function exportar_pdf_sh($idpersona, $idmodulo,&$pdf='') {

    $ayudante = new Ayudante();
    $persona = new ipersona();
    $apersona = $persona->get_persona($idpersona, $idmodulo);

    if ($fila = mysql_fetch_array($apersona)) {
        /*         * ***** */

        $idpersona_tipo = $fila[idpersona_tipo];
        $nombre = utf8_encode($fila[nombre]) . " " . utf8_encode($fila[apellido_p]) . " " . utf8_encode($fila[apellido_m]);
        $background = utf8_encode($fila[background]);
        $comentario = utf8_encode($fila[comentario]);
        $fecha_nacimiento = $fila[fecha_nacimiento];
        $tipo_persona = utf8_encode($fila_tipo[tipo]);
        $estado_civil = $fila_civil[descripcion];
        /*
          if(isset($fila[imagen]) && $fila[imagen]!=""){
          $plantilla->reemplaza("imagen", "../../../archivo/".$_SESSION['proyecto']."/imagen/".$fila[imagen]);
          }else{
          $plantilla->reemplaza("imagen", "../../../img/imagen.png");

          } */
        //direccion
        $apersona_direccion = $persona->get_persona_direccion($idpersona, $idmodulo);
        $cont = 0;
        while (!!$fila = mysql_fetch_array($apersona_direccion)) {
            $direccion.=utf8_encode($fila[direccion]) . " ,";
        }
        $direccion = substr($direccion, 0, -2) . ".";

        ////telefono
        $apersona_telefono = $persona->get_persona_telefono($idpersona, $idmodulo);
        $cont = 0;
        while (!!$fila = mysql_fetch_array($apersona_telefono)) {
            $telefono.=$fila[telefono] . " ,";
        }
        $telefono = substr($telefono, 0, -2) . ".";

        ///////email

        $apersona_mail = $persona->get_persona_email($idpersona, $idmodulo);

        while (!!$fila = mysql_fetch_array($apersona_mail)) {
            $mail.=utf8_encode($fila[mail]) . " ,";
        }
        $mail = substr($mail, 0, -2) . ".";

        /////////////organizacion
        $apersona_organizacion = $persona->get_persona_organizacion($idpersona, $idmodulo);

        while (!!$fila = mysql_fetch_array($apersona_organizacion)) {
            $aux_cargo=utf8_encode($fila[cargo]);
            $organizacion.=utf8_encode($fila[apellido_p] . " (" . $fila[apellido_m] . ")") . " $fila[cargo]" . " ,";
        }
        $organizacion = substr($organizacion, 0, -2) . ".";


        ////////documento de identificacion
        $apersona_documento_identificacion = $persona->get_persona_documento_identificacion($idpersona, $idmodulo);

        while (!!$fila = mysql_fetch_array($apersona_documento_identificacion)) {

            //mysql_data_seek($di_result, 0);
            $documento_identificacion.= $fila[tipo_documento_identificacion] . ": " . $fila[documento_identificacion] . " ,";
        }
        $documento_identificacion = substr($documento_identificacion, 0, -2) . ".";

        ///////persona tag
        $apersona_tag = $persona->get_persona_tag($idpersona, $idmodulo);
        while (!!$fila = mysql_fetch_array($apersona_tag)) {

            //mysql_data_seek($di_result, 0);
            $ctag.= utf8_encode($fila[tag]) . " ,";
        }
        $ctag = substr($ctag, 0, -2) . ".";

        /////PDF
        $pdf_null=0;
        if(empty($pdf)){
            $pdf = new PDF();
            $pdf_null=1;
        }
        //$pdf = new PDF();
  
        // Primera página
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->MultiCell(150, 5, $nombre, 0, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(50, 10, 'Documento identificación :', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(120, 10, $documento_identificacion, 0, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(30, 10, 'Fecha nacimiento :', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(50, 10, $fecha_nacimiento, 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(30, 10, 'Estado civil :', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(50, 10, $estado_civil, 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(50, 10, 'Dirección :', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(120, 10, $direccion, 0, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(50, 10, 'Telefóno :', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(120, 10, $telefono, 0, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(50, 10, 'Correo electrónico :', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(120, 10, $mail, 0, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(50, 10, 'Organización', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(120, 10, $organizacion, 0, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(50, 10, 'Background :', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(120, 10, $background, 0, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20);
        $pdf->Cell(50, 10, 'Comentario :', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->MultiCell(120, 10, $comentario, 0, 'L');
    }

    if($pdf_null==1){
      $pdf->Output("Persona_$nombre.pdf", 'D');  
    }
      
  
    
}

?>