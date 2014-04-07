/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function habilitar_registrar_reclamo(){
    if($("#reclamo_stakeholder_simple").is(':visible')){
        $("#reclamo_stakeholder_simple").hide();
        $("#enlace_habilitar_reclamo_simple").show();
    }else{
        $("#reclamo_stakeholder_simple").show();
        $("#enlace_habilitar_reclamo_simple").hide();
    }
}

function habilitar_mostrar_reclamo(){
    if($("#reclamo_stakeholder_complejo").is(':visible')){
        $("#reclamo_stakeholder_complejo").hide();
        $("#enlace_ocultar_reclamo_complejo").hide();
        $("#enlace_mostrar_reclamo_complejo").show();
    }else{
        $("#reclamo_stakeholder_complejo").show();
        $("#enlace_ocultar_reclamo_complejo").show();
        $("#enlace_mostrar_reclamo_complejo").hide();
    }
}

function borrar_reclamo_tag() {
    $("#buscar_reclamo_tag").val("");
}

function busqueda_rapida_reclamo_tag() {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();


    $("#buscar_reclamo_tag").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 1,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_tag: request.term
                },
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_tag&idtag_entidad=3',
                 beforeSend: function() {
                    $("#img_buscar_reclamo_tag").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    $("#img_buscar_reclamo_tag").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#buscar_reclamo_tag").val("");
            if(b.item.value!='nuevo_tag')
                agrega_celda('reclamo_tag', b.item, 'idreclamo_complejo_tag', 'nume_celda_reclamo_tag', 'nume_fila_reclamo_tag');
            return false;
        }
    });
}

function borrar_reclamo_sh_buscar() {

    $("#reclamo_sh_buscar").val("");
}

function borrar_reclamo_rc1_buscar() {

    $("#reclamo_rc1_buscar").val("");
}

function busqueda_rapida_reclamo_sh_buscar() {

    $("#reclamo_sh_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_stakeholder: request.term
                },
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=busqueda_rapida_stakeholder',
                beforeSend: function() {
                    $("#img_buscar_reclamo_sh").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                
                    $("#img_buscar_reclamo_sh").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#reclamo_sh_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda('reclamo_sh', b.item, 'idreclamo_complejo_sh', 'nume_celda_reclamo_sh', 'nume_fila_reclamo_sh','count_sh')
                return false;

            }

            return false;
        }
    });
}


function busqueda_rapida_reclamo_rc1_buscar() {

    $("#reclamo_rc1_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_rc: request.term
                },
                url: '../../../programas/rc/rc/arc.php?op_rc=busqueda_rapida_rc',
                beforeSend: function() {
                    $("#img_buscar_reclamo_rc1").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    
                    $("#img_buscar_reclamo_rc1").attr("src","../../../img/serach.png");
               
                }
            });
        },
        focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#reclamo_rc1_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                //alert (b.item.label+" "+b.item.value);
                $("#reclamo_receptor").html(b.item.label+"<img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" style=\"margin-left:10px;vertical-align: middle;\" onclick=\"borrar_receptor()\">" + 
                    "<input type=\"hidden\" name=\"idreclamo_rc\" id=\"idreclamo_rc\" value=\""+b.item.value+"\"/>");
                $("#count_receptor").val(1);
                
                return false;

            }

            return false;
        }
    });
}

function borrar_receptor(){
     $("#reclamo_receptor").html("");
     $("#count_receptor").val(0);
     
    if ($('#rango_interaccion_tiempo').length){
        eval($("#rango_interaccion_tiempo").attr("onChange"));
    }

}

function borrar_reclamo_rc2_buscar() {

    $("#reclamo_rc2_buscar").val("");
}

function busqueda_rapida_reclamo_rc2_buscar() {

    $("#reclamo_rc2_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_rc: request.term
                },
                url: '../../../programas/rc/rc/arc.php?op_rc=busqueda_rapida_rc',
                beforeSend: function() {
                    $("#img_buscar_reclamo_rc2").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    
                    $("#img_buscar_reclamo_rc2").attr("src","../../../img/serach.png");
               
                }
            });
        },
        focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#reclamo_rc2_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda_rc('reclamo_rc', b.item, 'idreclamo_complejo_rc', 'nume_celda_reclamo_rc', 'nume_fila_reclamo_rc','count_rc')
                return false;

            }

            return false;
        }
    });
}

function busqueda_rapida_reclamo_rc_buscar() {

    $("#reclamo_rc2_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_rc: request.term
                },
                url: '../../../programas/rc/rc/arc.php?op_rc=busqueda_rapida_rc',
                beforeSend: function() {
                    $("#img_buscar_reclamo_rc2").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    
                    $("#img_buscar_reclamo_rc2").attr("src","../../../img/serach.png");
              
                }
            });
        },
        focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#reclamo_rc2_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda('reclamo_rc', b.item, 'idreclamo_complejo_rc', 'nume_celda_reclamo_rc', 'nume_fila_reclamo_rc','count_rc')
                return false;

            }

            return false;
        }
    });
}

function vista_avanzada_reclamo(presenta) {
                        

    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();


        $.ajax({
            url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=ver_reclamo_stakeholder_complejo&idpersona=' + idpersona + '&idmodulo=' + idmodulo+ '&presenta=' + presenta,
            beforeSend: function() {
                $("#pantalla_aux_principal").dialog({
                    title: "Reclamo",
                    autoOpen: false,
                    height: "auto",
                    width: "auto",
                    modal: true,
                    position: ['center', 'center'],
                    create: function(event, ui) {

                    },
                    open: function(event, ui) {

                        $("#comp_fecha_reclamo").blur();
                        //$("#comp_interaccion").focus();
                    },
                    close: function(event, ui) {
                        $("#pantalla_aux_principal").html("");
                        $("#pantalla_aux_principal").dialog("destroy");
                    },
                });
                $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');
                $("#pantalla_aux_principal").dialog("open");
                $("#pantalla_aux_principal").center();

            },
            success: function(datos) {
                $("#pantalla_aux_principal").dialog("close");
                $("#pantalla_aux_principal").dialog({
                    title: "Reclamo",
                    autoOpen: false,
                    height: "auto",
                    width: "auto",
                    modal: true,
                    position: ['center', 'center'],
                    create: function(event, ui) {

                    },
                    open: function(event, ui) {

                        $("#comp_fecha_reclamo").blur();
                        //$("#comp_interaccion").focus();
                    },
                    close: function(event, ui) {
                        $("#pantalla_aux_principal").html("");
                        $("#pantalla_aux_principal").dialog("destroy");
                    },
                });
                $("#pantalla_aux_principal").html(datos);
                
                $("#comp_fecha_reclamo").blur();
                
                $("#pantalla_aux_principal").dialog("open");
                $("#pantalla_aux_principal").center();

            }
        });

}

function borrar_reclamo_complejo_tag() {
    $("#buscar_reclamo_complejo_tag").val("");
}

function busqueda_rapida_reclamo_complejo_tag() {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();


    $("#buscar_reclamo_complejo_tag").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 1,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_tag: request.term
                },
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_tag&idtag_entidad=3',
                 beforeSend: function() {
                    $("#img_complejo_buscar_sh_rc").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                $("#img_reclamo_complejo_buscar_tag").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#buscar_reclamo_complejo_tag").val("");
            if(b.item.value!='nuevo_tag')
                agrega_celda('reclamo_complejo_tag', b.item, 'idreclamo_complejo_tag', 'nume_celda_reclamo_tag_complejo', 'nume_fila_reclamo_tag_complejo','cant_complejo_tag');
            return false;
        }
    });
}

function borrar_reclamo_sh_buscar() {

    $("#reclamo_sh_buscar").val("");
}

function busqueda_rapida_reclamo_complejo_sh_buscar() {

    $("#reclamo_complejo_sh_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_stakeholder: request.term
                },
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=busqueda_rapida_stakeholder',
                beforeSend: function() {
                    $("#img_buscar_reclamo_complejo_sh").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    
                    $("#img_buscar_reclamo_complejo_sh").attr("src","../../../img/serach.png");
                

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#reclamo_complejo_sh_buscar").val("");
            

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda('reclamo_complejo_sh', b.item, 'idreclamo_complejo_sh', 'nume_celda_reclamo_sh_complejo', 'nume_fila_reclamo_sh_complejo','cant_complejo_sh');
                return false;

            }

            return false;
        }
    });
}


function borrar_reclamo_complejo_sh_buscar() {

    $("#reclamo_complejo_sh_buscar").val("");
}

function borrar_reclamo_complejo_rc1_buscar() {

    $("#reclamo_complejo_rc1_buscar").val("");
}

function borrar_reclamo_complejo_previo_buscar() {

    $("#reclamo_complejo_previo_buscar").val("");
}

function borrar_reclamo_complejo_rc2_buscar() {

    $("#reclamo_complejo_rc2_buscar").val("");
}


function busqueda_rapida_reclamo_complejo_rc1_buscar() {

    $("#reclamo_complejo_rc1_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_rc: request.term
                },
                url: '../../../programas/rc/rc/arc.php?op_rc=busqueda_rapida_rc',
                beforeSend: function() {
                    $("#img_buscar_reclamo_complejo_rc1").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    
                    $("#img_buscar_reclamo_complejo_rc1").attr("src","../../../img/serach.png");
               
                }
            });
        },
        focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#reclamo_complejo_rc1_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                //alert (b.item.label+" "+b.item.value);
                $("#reclamo_complejo_receptor").html(b.item.label+"<img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" style=\"margin-left:10px;vertical-align: middle;\" onclick=\"borrar_receptor_complejo()\">" + 
                    "<input type=\"hidden\" name=\"idreclamo_rc\" id=\"idreclamo_rc\" value=\""+b.item.value+"\"/>");
                
                $("#count_receptor_complejo").val(1);
                
                return false;

            }

            return false;
        }
    });
}


function borrar_receptor_complejo(){
     $("#reclamo_complejo_receptor").html("");
     $("#count_receptor_complejo").val(0);

}

function busqueda_rapida_reclamo_complejo_rc2_buscar() {

    $("#reclamo_complejo_rc2_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_rc: request.term
                },
                url: '../../../programas/rc/rc/arc.php?op_rc=busqueda_rapida_rc',
                beforeSend: function() {
                    $("#img_buscar_reclamo_complejo_rc2").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    
                    $("#img_buscar_reclamo_complejo_rc2").attr("src","../../../img/serach.png");
               
                }
            });
        },
        focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#reclamo_complejo_rc2_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda_rc('reclamo_complejo_rc', b.item, 'idreclamo_complejo_rc', 'nume_celda_reclamo_rc2_complejo', 'nume_fila_reclamo_rc2_complejo','cant_complejo_rc2')
                return false;

            }

            return false;
        }
    });
}


function modal_reclamo(idreclamo, idmodulo_reclamo, persona) {
    var url = "";
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();

    if (typeof(idreclamo) != "undefined") {
        url = url + '&idreclamo=' + idreclamo ;
    }

    if (typeof(idmodulo_reclamo) != "undefined") {
        url = url + '&idmodulo_reclamo=' + idmodulo_reclamo;
    }

    if (typeof(idpersona) != "undefined") {

        url = url + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo;
    }


    url = url + '&persona=' + persona + '&presenta=0' ;
    
   

    $.ajax({
        url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=ver_reclamo_stakeholder_complejo' + url,
        error: function(objeto, quepaso, otro) {
            alert(otro);
        },
        beforeSend: function() {

            $("#pantalla_aux_principal").dialog({
                title: "Reclamo",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                position: ['center', 'center'],
                create: function(event, ui) {
                    


                },
                open: function(event, ui) {

                    $("#comp_fecha_reclamo").blur();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif">');
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();

        },
        success: function(datos) {
            $("#pantalla_aux_principal").dialog("close");
           
            
            $("#pantalla_aux_principal").dialog({
                title: "Reclamo "+idreclamo+"-"+idmodulo_reclamo,
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                position: ['center', 'center'],
                create: function(event, ui) {
                    


                },
                open: function(event, ui) {
            
                    //$(this).dialog("option", "position", {my: "center", at: "center", of: window});

                    $("#comp_fecha_reclamo").blur();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            
            $("#pantalla_aux_principal").html(datos);
            $("#comp_fecha_interaccion").blur();
            $("#comp_fecha_interaccion").datepicker({changeYear: true, changeMonth: true});
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();
           
        }
    });
}


function modal_editar_evaluacion(idevaluacion, idmodulo_evaluacion) {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=ver_evaluacion_stakeholder_complejo&idevaluacion=' + idevaluacion + '&idmodulo_evaluacion=' + idmodulo_evaluacion,
        beforeSend: function() {
            $("#pantalla_aux_principal").dialog({
                title: "Evaluación",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                create: function(event, ui) {


                },
                open: function(event, ui) {
                    //$("#fecha_compromiso").blur();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();


        },
        success: function(datos) {
            $("#pantalla_aux_principal").dialog("close");

            $("#pantalla_aux_principal").dialog({
                title: "Evaluación",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                create: function(event, ui) {


                },
                open: function(event, ui) {
                    //$("#fecha_compromiso").blur();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html(datos);
           
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();




        }
    });
}

function modal_editar_propuesta(idpropuesta, idmodulo_propuesta) {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/reclamo/propuesta/apropuesta.php?op_propuesta=ver_propuesta_stakeholder_complejo&idpropuesta=' + idpropuesta + '&idmodulo_propuesta=' + idmodulo_propuesta,
        beforeSend: function() {
            $("#pantalla_aux_principal").dialog({
                title: "Acuerdo",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                create: function(event, ui) {


                },
                open: function(event, ui) {
                    $("#fecha_propuesta").blur();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();


        },
        success: function(datos) {
            $("#pantalla_aux_principal").dialog("close");

            $("#pantalla_aux_principal").dialog({
                title: "Acuerdo",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                create: function(event, ui) {


                },
                open: function(event, ui) {
                    $("#fecha_propuesta").blur();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html(datos);
            $("#fecha_propuesta").blur();
            $("#fecha_propuesta").datepicker({changeYear: true, changeMonth: true});
            

            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();
            
        }
    });
}

function modal_editar_apelacion(idapelacion, idmodulo_apelacion) {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/reclamo/apelacion/aapelacion.php?op_apelacion=ver_apelacion_stakeholder_complejo&idapelacion=' + idapelacion + '&idmodulo_apelacion=' + idmodulo_apelacion,
        beforeSend: function() {
            $("#pantalla_aux_principal").dialog({
                title: "Apelación",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                create: function(event, ui) {


                },
                open: function(event, ui) {
                    $("#fecha_apelacion").blur();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();


        },
        success: function(datos) {
            $("#pantalla_aux_principal").dialog("close");

            $("#pantalla_aux_principal").dialog({
                title: "Apelación",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                create: function(event, ui) {


                },
                open: function(event, ui) {
                    $("#fecha_apelacion").blur();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html(datos);
            $("#fecha_apelacion").blur();
            $("#fecha_apelacion").datepicker({changeYear: true, changeMonth: true});
            

            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();
            
        }
    });
}



function eliminar_reclamo(idreclamo, idmodulo_reclamo) {
  
    $("#pantalla_aux_principal").dialog({
                            title: "Eliminar reclamo ",
                            autoOpen: false,
                            height: "auto",
                            width: "auto",
                            modal: true,
                            close: function(event, ui) {
                                $("#pantalla_aux_principal").html("");
                                $("#pantalla_aux_principal").dialog("destroy");
                            },
                            buttons: {
                                "Aceptar": function() {
                                    $.ajax({
                                        url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=eliminar_reclamo_stakeholder&idreclamo=' + idreclamo + '&idmodulo_reclamo=' + idmodulo_reclamo,
                                        dataType: "json",
                                        
                                        beforeSend: function() {
                                            $("#pantalla_aux_principal").append('<br/><div><img src="../../../img/bar-ajax-loader.gif" /></div>');

                                        },
                                        success: function(data) {
                                            $("#pantalla_aux_principal").dialog("close");
                                            if (data.success) {
                                                $('#reclamo_'+idreclamo+'_'+idmodulo_reclamo).hide();
                                                $.jGrowl(data.mensaje, {theme: 'verde'});
                                            } else {
                                                $.jGrowl(data.mensaje, {theme: 'rojo'});
                                            }

                                        }
                                    });
                                    
                                },
                                "Cancel": function() {
                                    $(this).dialog("close");
                                }

                            }
                        });
    $("#pantalla_aux_principal").html("Esta seguro que desea eliminar el reclamo?");
    $("#pantalla_aux_principal").dialog("open");
    $("#pantalla_aux_principal").center();



}


function eliminar_propuesta(idpropuesta, idmodulo_propuesta, idreclamo, idmodulo_reclamo) {
  
    $("#pantalla_aux_principal").dialog({
                            title: "Eliminar acuerdo",
                            autoOpen: false,
                            height: "auto",
                            width: "auto",
                            modal: true,
                            close: function(event, ui) {
                                $("#pantalla_aux_principal").html("");
                                $("#pantalla_aux_principal").dialog("destroy");
                            },
                            buttons: {
                                "Aceptar": function() {
                                    $.ajax({
                                        url: '../../../programas/reclamo/propuesta/apropuesta.php?op_propuesta=eliminar_propuesta_stakeholder&idpropuesta=' + idpropuesta + '&idmodulo_propuesta=' + idmodulo_propuesta + '&idreclamo=' +idreclamo + '&idmodulo_reclamo=' + idmodulo_reclamo,
                                        dataType: "json",
                                        
                                        beforeSend: function() {
                                            $("#pantalla_aux_principal").append('<br/><div><img src="../../../img/bar-ajax-loader.gif" /></div>');

                                        },
                                        success: function(data) {
                                            $("#pantalla_aux_principal").dialog("close");
                                            if (data.success) {
                                                $('.propuesta_reclamo_'+idpropuesta+'_'+idmodulo_propuesta).hide();
                                                $.jGrowl(data.mensaje, {theme: 'verde'});
                                            } else {
                                                $.jGrowl(data.mensaje, {theme: 'rojo'});
                                            }

                                        }
                                    });
                                    
                                },
                                "Cancel": function() {
                                    $(this).dialog("close");
                                }

                            }
                        });
    $("#pantalla_aux_principal").html("Esta seguro que desea eliminar el acuerdo?");
    $("#pantalla_aux_principal").dialog("open");
    $("#pantalla_aux_principal").center();



}



function eliminar_apelacion(idapelacion, idmodulo_apelacion) {
  
    $("#pantalla_aux_principal").dialog({
                            title: "Eliminar apelacion ",
                            autoOpen: false,
                            height: "auto",
                            width: "auto",
                            modal: true,
                            close: function(event, ui) {
                                $("#pantalla_aux_principal").html("");
                                $("#pantalla_aux_principal").dialog("destroy");
                            },
                            buttons: {
                                "Aceptar": function() {
                                    $.ajax({
                                        url: '../../../programas/reclamo/apelacion/aapelacion.php?op_apelacion=eliminar_apelacion_stakeholder&idapelacion=' + idapelacion + '&idmodulo_apelacion=' + idmodulo_apelacion,
                                        dataType: "json",
                                        
                                        beforeSend: function() {
                                            $("#pantalla_aux_principal").append('<br/><div><img src="../../../img/bar-ajax-loader.gif" /></div>');

                                        },
                                        success: function(data) {
                                            $("#pantalla_aux_principal").dialog("close");
                                            if (data.success) {
                                                $('.apelacion_reclamo_'+idapelacion+'_'+idmodulo_apelacion).hide();
                                                $.jGrowl(data.mensaje, {theme: 'verde'});
                                            } else {
                                                $.jGrowl(data.mensaje, {theme: 'rojo'});
                                            }

                                        }
                                    });
                                    
                                },
                                "Cancel": function() {
                                    $(this).dialog("close");
                                }

                            }
                        });
    $("#pantalla_aux_principal").html("Esta seguro que desea eliminar el apelacion?");
    $("#pantalla_aux_principal").dialog("open");
    $("#pantalla_aux_principal").center();



}

function eliminar_evaluacion(idevaluacion, idmodulo_evaluacion) {
  
    $("#pantalla_aux_principal").dialog({
                            title: "Eliminar evaluacion ",
                            autoOpen: false,
                            height: "auto",
                            width: "auto",
                            modal: true,
                            close: function(event, ui) {
                                $("#pantalla_aux_principal").html("");
                                $("#pantalla_aux_principal").dialog("destroy");
                            },
                            buttons: {
                                "Aceptar": function() {
                                    $.ajax({
                                        url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=eliminar_evaluacion_stakeholder&idevaluacion=' + idevaluacion + '&idmodulo_evaluacion=' + idmodulo_evaluacion,
                                        dataType: "json",
                                        
                                        beforeSend: function() {
                                            $("#pantalla_aux_principal").append('<br/><div><img src="../../../img/bar-ajax-loader.gif" /></div>');

                                        },
                                        success: function(data) {
                                            $("#pantalla_aux_principal").dialog("close");
                                            if (data.success) {
                                                $('.evaluacion_reclamo_'+idevaluacion+'_'+idmodulo_evaluacion).hide();
                                                $.jGrowl(data.mensaje, {theme: 'verde'});
                                            } else {
                                                $.jGrowl(data.mensaje, {theme: 'rojo'});
                                            }

                                        }
                                    });
                                    
                                },
                                "Cancel": function() {
                                    $(this).dialog("close");
                                }

                            }
                        });
    $("#pantalla_aux_principal").html("Esta seguro que desea eliminar la evaluacion?");
    $("#pantalla_aux_principal").dialog("open");
    $("#pantalla_aux_principal").center();



}


function busqueda_rapida_reclamo_complejo_previo_buscar() {

    $("#reclamo_complejo_previo_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_reclamo: request.term
                },
                url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=busqueda_rapida_reclamo',
                beforeSend: function() {
                    $("#img_buscar_reclamo_complejo_previo").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    
                    $("#img_buscar_reclamo_complejo_previo").attr("src","../../../img/serach.png");
               
                }
            });
        },
        focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#reclamo_complejo_previo_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                //alert (b.item.label+" "+b.item.value);
                $("#reclamo_complejo_previo").html(b.item.label+"<img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" style=\"margin-left:10px;vertical-align: middle;\" onclick=\"borrar_previo_complejo()\">" + 
                    "<input type=\"hidden\" name=\"idreclamo_previo\" id=\"idreclamo_previo\" value=\""+b.item.value+"\"/>");
                
                
                
                return false;

            }

            return false;
        }
    });
}


function borrar_previo_complejo(){
     $("#reclamo_complejo_previo").html("");
     

}


function exportar_pdf_reclamo(idframe,idreclamo,idmodulo_reclamo, tipo_reporte){
   var ifrm = document.getElementById(idframe);
    ifrm.src = "../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=exportar_pdf_reclamo&idreclamo="+idreclamo+"&idmodulo_reclamo="+idmodulo_reclamo+"&tipo_reporte="+tipo_reporte;
    //ifrm.src = "";        
}

function ver_buscar_reclamo() {
    $.ajax({
        url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=ver_buscar_reclamo',
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);


        }
    });
}

function buscar_reclamo() {
    
    if(!$("#form_buscar_reclamo").valid()){
        return false;
    }

    datastring = $("#form_buscar_reclamo").serialize();
    $.ajax({
        type: "POST",
        url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=buscar_reclamo',
        dataType: "json",
        beforeSend: function() {
            $("#resultado_reclamo").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        data: datastring,
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        success: function(datos) {
        var result="";
        
        total_entidad = datos.total;
            
            gis_entidad = jQuery.extend({}, datos.idgis_item);
               
            //$("#resultado_persona").html(datos);
            $("#resultado_reclamo").html("<br/><table id='lista'></table><div id='pager'></div>");
            
            $("#fid_string").val(datos.fid_string);
            
            jQuery("#lista").jqGrid({ 
                datatype: "local",
                data: datos.data,
                height: "100%", 
                width: "700", 
                colNames:['Codigo','Fase','Estado','Fecha','Plazo','Reclamante','Responsable','Accion'], 
                colModel:[                              
                            {name:'codigo',index:'codigo', width:10, sorttype:"text"},
                            {name:'fase',index:'fase', width:10, sorttype:"text"},
                            {name:'estado',index:'estado', width:10, sorttype:"text"},
                            {name:'fecha',index:'fecha', width:10, sorttype:"text"},
                            {name:'plazo',index:'plazo', width:10, sorttype:"text"},
                            {name:'reclamante',index:'reclamante', width:15, sorttype:"text"},
                            {name:'responsable',index:'responsable', width:15, sorttype:"text"},
                            {name:'accion',index:'accion', width:15, sorteable:false}
                        ],
                 rowNum:20,
                 rowList:[10,20,30],
                 pager: '#pager',
                 rownumbers: true, 
                 rownumWidth: 30,
                 sortname: 'codigo',
                 sortorder: 'asc',
                 viewrecords: true,
                 gridview:true
            }); 
            
            jQuery("#lista").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,defaultSearch : "cn"});
            
            jQuery("#lista").jqGrid('navGrid', '#pager',{view:false, del:false, add:false, edit:false, refresh:false, search:false});
            jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"Excel",
                                title:"Exportar",
                                buttonicon:"ui-icon-disk", 
                                onClickButton: function(){ 
                                  exportar_excel_reclamo('frame4')
                                }, 
                                position:"last"
                            });
                        
                        
            jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"GIS",
                                title:"GIS",
                                buttonicon:"ui-icon-search", 
                                onClickButton: function(){ 
                                  ver_predio_entidad('Reclamo')
                                }, 
                                position:"last"
                            });
                            
           
            
        }
    });

}

function exportar_excel_reclamo(id){
   var ifrm = document.getElementById(id);
    ifrm.src = "../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=exportar_reclamo&"+$("#form_buscar_reclamo").serialize();
    //ifrm.src = "";
    
    
}


function cuerpo_ver_mas_reclamo(limite) {

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_cuerpo_reclamo&limite='+limite,
        beforeSend: function() {
            $("#cuerpo_reclamo").html('<img src="../../../img/bar-ajax-loader.gif">');
        },
        success: function(data) {           
            $("#cuerpo_reclamo").html(data);            
        }
    });


}

function ver_mas_reclamo(cantidad, idpersona, idmodulo, presenta, persona) {

    $.ajax({
        url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=ver_bloque_reclamo&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&inicio=' + cantidad + '&presenta=' + presenta + '&persona=' + persona,
        beforeSend: function() {

            $("#bloque_reclamo").html('<img src="../../../img/bar-ajax-loader.gif">');

        },
        success: function(data) {

            $("#bloque_reclamo").html(data);

        }
    });


}

function ver_bloque_reclamo(cantidad, idpersona, idmodulo, presenta, persona, modo) {

    $.ajax({
        url: '../../../programas/reclamo/reclamo/areclamo.php?op_reclamo=ver_bloque_reclamo&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&inicio=' + cantidad + '&presenta=' + presenta + '&persona=' + persona + '&modo=' + modo,
        beforeSend: function() {

            $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {

            $("#idhtml_cabecera_stakeholder").html(data);

        }
    });

}

function ver_bloque_stakeholder(cantidad, idpersona, idmodulo, presenta, persona, modo) {

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_bloque_interaccion&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&inicio=' + cantidad + '&presenta=' + presenta + '&persona=' + persona + '&modo=' + modo,
        beforeSend: function() {

            $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {

            $("#idhtml_cabecera_stakeholder").html(data);

        }
    });

}

function ver_bloque_compromiso(cantidad, idpersona, idmodulo, presenta, persona, modo) {

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_cuerpo_compromiso&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&inicio=' + cantidad + '&presenta=' + presenta + '&persona=' + persona + '&modo=' + modo,
        beforeSend: function() {

            $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {

            $("#idhtml_cabecera_stakeholder").html(data);

        }
    });

}