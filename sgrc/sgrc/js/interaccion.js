function eliminar_interaccion(idinteraccion, idmodulo_interaccion) {

    $("#pantalla_aux_principal").dialog({
                            title: "Eliminar interacci&oacute;n ",
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
                                        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=eliminar_interaccion_stakeholder&idinteraccion=' + idinteraccion + '&idmodulo_interaccion=' + idmodulo_interaccion,
                                        dataType: "json",
                                        beforeSend: function() {
                                            $("#pantalla_aux_principal").append('<br/><div><img src="../../../img/bar-ajax-loader.gif" /></div>');

                                        },
                                        success: function(data) {
                                            $("#pantalla_aux_principal").dialog("close");
                                            if (data.success) {
                                                $('#interaccion_'+idinteraccion+'_'+idmodulo_interaccion).hide();
                                                $('#form_buscar_interaccion').submit();
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
    $("#pantalla_aux_principal").html(" &Aacute;sta seguro que desea eliminar la interacci&oacute;n?");
    $("#pantalla_aux_principal").dialog("open");
    $("#pantalla_aux_principal").center();



}


function ver_mas_interaccion(cantidad, idpersona, idmodulo, presenta, persona, modo) {

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_bloque_interaccion&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&inicio=' + cantidad + '&presenta=' + presenta + '&persona=' + persona +'&modo='+modo,

        beforeSend: function() {

            if($("#bloque_interaccion").length)
                $("#bloque_interaccion").html('<table width="100%"><tr><td align="center"><img src="../../../img/bar-ajax-loader.gif"></td></tr></table>');
            else
                $("#idhtml_cabecera_stakeholder").html('<img src="../../../img/bar-ajax-loader.gif">');

        },
        success: function(data) {

            if($("#bloque_interaccion").length)
                $("#bloque_interaccion").html(data);
            else
                $("#idhtml_cabecera_stakeholder").html(data);

            //$("#idhtml_cabecera_stakeholder").html(data);

        }
    });


}




function borrar_interaccion_complejo_tag() {
    $("#buscar_interaccion_complejo_tag").val("");
}


function busqueda_rapida_interacccion_complejo_tag() {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();


    $("#buscar_interaccion_complejo_tag").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_tag&idtag_entidad=1',
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
                $("#img_complejo_buscar_sh_rc").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#buscar_interaccion_complejo_tag").val("");
            if(b.item.value!='nuevo_tag')
                agrega_celda_tag('interaccion_complejo_tag', b.item, 'idinteraccion_complejo_tag', 'nume_celda_interaccion_tag_complejo', 'nume_fila_interaccion_tag_complejo');
            return false;
        }
    });
}




function borrar_interaccion_tag() {
    $("#buscar_interaccion_tag").val("");
}



function busqueda_rapida_interacccion_tag(idtag_entidad) {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();


    $("#buscar_interaccion_tag").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_tag&idtag_entidad='+idtag_entidad,
                 beforeSend: function() {
                    $("#img_buscar_sh_rc").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    $("#img_buscar_sh_rc").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#buscar_interaccion_tag").val("");
            if(b.item.value!='nuevo_tag')
                agrega_celda_tag('interaccion_tag', b.item, 'idinteraccion_complejo_tag', 'nume_celda_interaccion_tag', 'nume_fila_interaccion_tag');
            return false;
        }
    });
}


function guardar_interaccion_stakeholder() {

    //alert("After - action = "+$("#guardar_interaccion_stakeholder").attr("action"));

    $("#guardar_interaccion_stakeholder").submit();
    //$.jGrowl($("#iframe_interaccion").html(), {theme: 'verde'});
    /*
    $.ajax({
        type: "POST",
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?idpersona=' + idpersona + '&idmodulo=' + idmodulo,
        data: datastring,
        dataType: "json",
        error: function(objeto, quepaso, otro) {
            //alert('q');
        },
        success: function(datos) {
            //console.log(datos);
            if (datos.success) {
                $('#tabs').tabs('load', 0);
                $.jGrowl(datos.mensaje, {theme: 'verde'});
            } else {
                $.jGrowl(datos.mensaje, {theme: 'rojo'});

            }

        }
    });
    */
}

function actualizar_interaccion_stakeholder_erase() {

    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();
    var persona = $("#persona").val();
    datastring = $("#form_modal_interaccion").serialize();

    url = "";
    if (typeof(idpersona) != "undefined") {
        url = url + '?idpersona==' + idpersona + '&idmodulo=' + idmodulo;
    }
    $.ajax({
        type: "POST",
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php' + url,
        data: datastring,
        dataType: "json",
        error: function(objeto, quepaso, otro) {
            alert(otro);
        },
        success: function(datos) {

            if (datos.op_stakeholder) {
                $("#modal_interaccion").dialog("close");
                var idinteraccion = $("#idinteraccion").val();

                if (datos.success) {
                    $("#interaccion_" + datos.idinteraccion + "_" + datos.idmodulo_interaccion).html(datos.data);
                    $.jGrowl(datos.mensaje, {theme: 'verde'});
                } else {
                    $.jGrowl(datos.mensaje, {theme: 'rojo'});

                }
            } else {

                if (datos.success) {
                    $('#tabs').tabs('load', 0);
                    $.jGrowl(datos.mensaje, {theme: 'verde'});
                } else {
                    $.jGrowl(datos.mensaje, {theme: 'rojo'});

                }
            }

        }
    });
}

function modal_interaccion(idinteraccion, idmodulo_interaccion, persona) {
    var url = "";
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();

    if (typeof(idinteraccion) != "undefined") {
        url = url + '&idinteraccion=' + idinteraccion + '&idmodulo_interaccion=' + idmodulo_interaccion;
    }

    if (typeof(idmodulo_interaccion) != "undefined") {
        url = url + '&idmodulo_interaccion=' + idmodulo_interaccion;
    }

    if (typeof(idpersona) != "undefined") {

        url = url + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo;
    }


    url = url + '&persona=' + persona;

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_interaccion_stakolder_complejo' + url,
        error: function(objeto, quepaso, otro) {
            alert(otro);
        },
        beforeSend: function() {

            $("#pantalla_aux_principal").dialog({
                title: $("<label>Interacci&oacute;n</label>").html(),
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                position: ['center', 'center'],
                create: function(event, ui) {



                },
                open: function(event, ui) {

                    $("#comp_fecha_interaccion").blur();
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
                title: $("<label>Interacci&oacute;n "+idinteraccion+"-"+idmodulo_interaccion+"</label>").html(),
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                position: ['center', 'center'],
                create: function(event, ui) {



                },
                open: function(event, ui) {

                    $("#comp_fecha_interaccion").blur();
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

function habilitar_registrar_interaccion(){
    if($("#interaccion_stakeholder_simple").is(':visible')){
        $("#interaccion_stakeholder_simple").hide();
        $("#enlace_habilitar_interaccion_simple").show();
    }else{
        $("#interaccion_stakeholder_simple").show();
        $("#enlace_habilitar_interaccion_simple").hide();
    }
}

function habilitar_mostrar_interaccion(){
    if($("#interaccion_stakeholder_compromiso").is(':visible')){
        $("#interaccion_stakeholder_compromiso").hide();
        $("#enlace_habilitar_interaccion").show();
    }else{
        $("#interaccion_stakeholder_compromiso").show();
        $("#enlace_habilitar_interaccion").hide();
    }
}

function cambiar_visibilidad(idbloque){
    if($("#"+idbloque).is(':visible')){
        $("#"+idbloque).hide();
    }else{
        $("#"+idbloque).show();
    }
}

function cambiar_visibilidad_clase(idclase){
    if($("."+idclase).is(':visible')){
        $("."+idclase).hide();
    }else{
        $("."+idclase).show();
    }
}



function agregar_campo_archivo(bloque){
    $("#"+bloque+"_archivo").append("<div><input type='file' name='archivos[]' ></div><br/>");

}

function populateIframe(id,programa,ruta) {
    var ifrm = document.getElementById(id);
    ifrm.src = "../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=descargar&programa="+programa+"&ruta="+ruta;
}

function ver_buscar_interaccion() {
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_buscar_interaccion',
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);


        }
    });
}

var total_interacciones;
var gis_interacciones;

function buscar_interaccion() {

    datastring = $("#form_buscar_interaccion").serialize();
    $.ajax({
        type: "POST",
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=buscar_interaccion',
        dataType: "json",
        beforeSend: function() {
            $("#resultado_interaccion").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        data: datastring,
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        success: function(datos) {

            total_entidad = datos.total;

            gis_entidad = jQuery.extend({}, datos.idgis_item);
            //$("#resultado_persona").html(datos);
            $("#resultado_interaccion").html("<br/><table id='lista'></table><div id='pager'></div>");

            $("#fid_string").val(datos.fid_string);

            jQuery("#lista").jqGrid({
                datatype: "local",
                data: datos.data,
                height: "100%",
                width: "700",
                colNames:['Interaccion','Estado','Prioridad','Tipo','Fecha','Accion'],
                colModel:[
                            {name:'interaccion',index:'interaccion', width:200, sorttype:"text"},
                            {name:'estado',index:'estado', width:50, sorttype:"text"},
                            {name:'prioridad',index:'prioridad', width:50, sorttype:"int"},
                            {name:'tipo',index:'tipo', width:40, sorttype:"text"},
                            {name:'fecha',index:'fecha', width:50, sorttype:"date"},
                            {name:'accion',index:'accion', width:60, sorteable:false}
                        ],
                 rowNum:20,
                 rowList:[10,20,30],
                 pager: '#pager',
                 rownumbers: true,
                 rownumWidth: 30,

                 viewrecords: true,
                 gridview:true
            });

            jQuery("#lista").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,defaultSearch : "cn"});

            /*
            for(var i=0;i<=datos.length;i++)
                jQuery("#lista").jqGrid('addRowData',i+1,datos[i]);
            */
            jQuery("#lista").jqGrid('navGrid', '#pager',{view:false, del:false, add:false, edit:false, refresh:false, search:false});
            jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"Excel",
                                title:"Exportar",
                                buttonicon:"ui-icon-disk",
                                onClickButton: function(){
                                  exportar_excel_interaccion('frame3')
                                },
                                position:"last"
                            });

            jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"GIS",
                                title:"GIS",
                                buttonicon:"ui-icon-search",
                                onClickButton: function(){
                                  ver_predio_entidad('Interaccion')
                                },
                                position:"last"
                            });

        }
    });

}

function exportar_excel_interaccion(id){
   var ifrm = document.getElementById(id);
    ifrm.src = "../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=exportar_interaccion&"+$("#form_buscar_interaccion").serialize();
    //ifrm.src = "";


}

function exportar_pdf_interaccion(idframe,idinteraccion,idmodulo_interaccion,depredio){
   var ifrm = document.getElementById(idframe);

   if (typeof(depredio) == "undefined") {
       ifrm.src = "../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=exportar_pdf_interaccion&idinteraccion="+idinteraccion+"&idmodulo_interaccion="+idmodulo_interaccion;
   }else{
       ifrm.src = "../../../programas/predio/predio/apredio.php?op_predio=exportar_pdf_interaccion&idinteraccion="+idinteraccion+"&idmodulo_interaccion="+idmodulo_interaccion;
   }


    //ifrm.src = "";
}

function borrar_interaccion_complejo_rc_buscar() {

    $("#interaccion_complejo_rc_buscar").val("");
}

function borrar_interaccion_rc_buscar() {

    $("#interaccion_rc_buscar").val("");
}

function busquedarapida_interaccion_complejo_rc_buscar() {

    $("#interaccion_complejo_rc_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                    $("#img_buscar_interaccion_complejo_rc").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                $("#img_buscar_interaccion_complejo_rc").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#interaccion_complejo_rc_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda('interaccion_complejo_rc', b.item, 'idinteraccion_complejo_rc', 'nume_celda_interaccion_rc_complejo', 'nume_fila_interaccion_rc_complejo', 'cant_complejo_rc')
                return false;

            }

            return false;
        }
    });
}

function busquedarapida_interaccion_rc_buscar() {

    $("#interaccion_rc_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                    $("#img_buscar_interaccion_rc").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));

                    $("#img_buscar_interaccion_rc").attr("src","../../../img/serach.png");



                }
            });
        },
        focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#interacciono_rc_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda('interaccion_rc', b.item, 'idinteraccion_complejo_rc', 'nume_celda_interaccion_rc', 'nume_fila_interaccion_rc','cant_rc')
                return false;

            }

            return false;
        }
    });
}

function borrar_interaccion_sh_buscar() {

    $("#interaccion_sh_buscar").val("");
}

function busquedarapida_interaccion_sh_buscar() {

    $("#interaccion_sh_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                    $("#img_buscar_interaccion_sh").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));

                    $("#img_buscar_interaccion_sh").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#interaccion_sh_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda('interaccion_sh', b.item, 'idinteraccion_complejo_sh', 'nume_celda_interaccion_sh', 'nume_fila_interaccion_sh','cant_sh')
                return false;

            }

            return false;
        }
    });
}


function borrar_interaccion_complejo_sh_buscar() {

    $("#interaccion_complejo_sh_buscar").val("");
}

function busquedarapida_interaccion_complejo_sh_buscar() {

    $("#interaccion_complejo_sh_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                    $("#img_buscar_interaccion_complejo_sh").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));

                    $("#img_buscar_interaccion_complejo_sh").attr("src","../../../img/serach.png");


                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#interaccion_complejo_sh_buscar").val("");


            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda('interaccion_complejo_sh', b.item, 'idinteraccion_complejo_sh', 'nume_celda_interaccion_sh_complejo', 'nume_fila_interaccion_sh_complejo','cant_complejo_sh');
                return false;

            }

            return false;
        }
    });
}

function vista_avanzada_interaccion(presenta) {


    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();


        $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_interaccion_stakolder_complejo&idpersona=' + idpersona + '&idmodulo=' + idmodulo+ '&presenta=' + presenta,
            beforeSend: function() {
                $("#pantalla_aux_principal").dialog({
                    title: $("<label>Interacci&oacute;n</label>").html(),
                    autoOpen: false,
                    height: "auto",
                    width: "auto",
                    modal: true,
                    position: ['center', 'center'],
                    create: function(event, ui) {



                    },
                    open: function(event, ui) {

                        $("#comp_fecha_interaccion").blur();
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
                    title: $("<label>Interacci&oacute;n</label>").html(),
                    autoOpen: false,
                    height: "auto",
                    width: "auto",
                    modal: true,
                    position: ['center', 'center'],
                    create: function(event, ui) {



                    },
                    open: function(event, ui) {

                        $("#comp_fecha_interaccion").blur();
                        //$("#comp_interaccion").focus();
                    },
                    close: function(event, ui) {
                        $("#pantalla_aux_principal").html("");
                        $("#pantalla_aux_principal").dialog("destroy");
                    },
                });
                $("#pantalla_aux_principal").html(datos);
                $("#comp_fecha_interaccion").blur();

                $("#pantalla_aux_principal").dialog("open");
                $("#pantalla_aux_principal").center();
                $("#comp_fecha_interaccion").datepicker({changeYear: true, changeMonth: true});


            }
        });



}



