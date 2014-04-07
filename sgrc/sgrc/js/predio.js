

function ver_editar_ficha_predio(idpredio,idmodulo_predio) {
    //alert(idmodulo_predio+idpredio)
    $.ajax({
        url: '../../../programas/predio/predio/apredio.php?op_predio=ver_editar_ficha_predio&idpredio='+idpredio+'&idmodulo_predio='+idmodulo_predio,
        beforeSend: function() {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);
            $("#tabs").tabs();


        }
    });

}

function buscar_predio() {
    var datastring = $("#form_consulta_reporte_estadistico").serialize();

    $.ajax({
        type: "POST",
        url: '../../../programas/predio/predio/apredio.php?op_predio=buscar_predio',
        dataType: "json", 
        data: datastring,
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        beforeSend: function() {

            $("#resultado_buscar_predio").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
        success: function(datos) {
           
            $("#resultado_buscar_predio").html("<table width='710px' align='center'><tr><td valign='top' width='100%'><table id='table_resultado_buscar_predio'></table> <div id='pie_table_resultado_buscar_predio'></div></td></tr></table>");

            //$('<table id="list2"></table>').appendTo('#resultado_tag');
            /*
             *                     {name: "sh",index:'stakeholder', width:300, resizable: false, sorttype:'text'},
                    {name: "tag",index:'stakeholder', width:300, resizable: false, sorttype:'text'}
             * @type type
             *                     {name: "nombre_predio",index:'nombre_predio', width:200, resizable: false, sorttype:'text'}

             */
            var grid = jQuery("#table_resultado_buscar_predio");
            grid.jqGrid({
                datatype: "local",
                data: datos.data,
                width: "800",
                shrinkToFit:false,
                 colNames: ["id","C&oacute;digo Predio","Direcci&oacute;n","Stakeholder","Tags","Acci&oacute;n"],
                 colModel: [
                    {name: "id",index:'id',width:1, hidden:true, key:true},
                    {name: "nombre_predio",index:'nombre_predio', width:150, resizable: true, sorttype:'text'},
                    {name: "direccion",index:'direccion', width:200, resizable: true, sorttype:'text'},
                    {name: "sh",index:'sh', width:200, resizable: true, sorttype:'text'},
                    {name: "tag",index:'tag', width:200, resizable: true, sorttype:'text'},
                    {name: "accion",index:'accion', width:100, resizable: true, sorttype:'text'}
                ],
                 rowNum:20,
                 rowList:[10,20,30],
                 rownumbers: true, 
                 rownumWidth: 30,
                 sortname: 'nombre_predio',
                 sortorder: 'asc',
                 viewrecords: true,
                 gridview:true,
                 loadonce: true,
                 autowidth: true,               
                 pager : "#pie_table_resultado_buscar_predio"
          
       
            });  
            
            grid.jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,defaultSearch : "cn"});
                       
        }
    });
    
   
}
function ver_buscar_predio(){
    
        $.ajax({
        url: '../../../programas/predio/predio/apredio.php?op_predio=ver_buscar_predio',
        beforeSend: function() {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);
            //$("#tabs").tabs();


        }
    });

    
}


function busqueda_rapida_predio_tag(idtag_entidad) {
    //idtag_entidad
    $("#busca_rapida_tag").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                url: '../../../programas/predio/predio/apredio.php?op_predio=ver_tag&idtag_entidad='+idtag_entidad,
                 beforeSend: function() {
                    $("#img_buscar_tag").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    $("#img_buscar_tag").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#busca_rapida_tag").val("");
            if(b.item.value!='nuevo_tag')
                agrega_celda_tag('tabla_predio_tag_complejo', b.item, 'idpredio_complejo_tag', 'nume_celda_predio_tag', 'nume_fila_predio_tag');
            return false;
        }
    });
}


function borrar_predio_tag() {
    $("#busca_rapida_tag").val("");
}

function borrar_predio_sh() {
    $("#buscar_predio_sh").val("");
}

function borrar_busqueda_rapida_predio_sh_buscar() {
    $("#busqueda_rapida_predio_sh").val("");
}

function busqueda_rapida_predio_sh() {
    //idtag_entidad

    $("#buscar_predio_sh").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 1,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    buscar_predio_sh: request.term
                },
                url: '../../../programas/predio/predio/apredio.php?op_predio=busqueda_rapida_stakeholder',
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
            $("#buscar_predio_sh").val("");
            if(b.item.value!='nuevo_predio_sh')
                agrega_celda_tag('tabla_predio_sh', b.item, 'idpredio_sh_complejo', 'nume_celda_predio_sh', 'nume_fila_predio_sh');
            return false;
        }
    });
}

function actualizar_predio_tipo_tenencia(idpredio_tipo_tenencia_complejo){
    
    var idpredio = $("#idpredio").val();
    var idmodulo_predio = $("#idmodulo_predio").val();    
    //alert(idpredio_proceso_pasos_complejo);
    $.ajax({
        type: "GET",
        url: '../../../programas/predio/predio/apredio.php?op_predio=editar_predio_tipo_tenencia&idpredio_tipo_tenencia_complejo='+idpredio_tipo_tenencia_complejo,
        dataType: "json",
        error: function(objeto, quepaso, otro) {
            alert(otro);
        },
        success: function(datos) {

               if (datos.success) {
                    $.jGrowl(datos.mensaje, {theme: 'verde'});
                          $.ajax({
                            url: '../../../programas/predio/predio/apredio.php?op_predio=ver_editar_ficha_predio' + '&idpredio=' + idpredio + '&idmodulo_predio=' + idmodulo_predio,
                            success: function(datos) {
                              $("#predio_sh").html(datos);

                                console.log(datos);
                            },
                            beforeSend: function() {
                                $("#idhtml_cabecera_stakeholder").html("");
                                $("#idhtml_tab_stakeholder").html('<img src="../../../img/bar-ajax-loader.gif" />');

                            },
                            success: function(datos) {
                                $("#idhtml_cabecera_stakeholder").html("");
                                $("#idhtml_tab_stakeholder").html(datos);
                               
                                $('#tabs').tabs({ active: 1 });
                            }                            
                        });
                } else {
                    $.jGrowl(datos.mensaje, {theme: 'rojo'});
                }
                //console.log(datos);
          

        }
    });
}

function actualizar_predio_sh_proceso_paso(idpredio_proceso_pasos_complejo){
    var idpredio = $("#idpredio").val();
    var idmodulo_predio = $("#idmodulo_predio").val();    
    //alert(idpredio_proceso_pasos_complejo);
    $.ajax({
        type: "GET",
        url: '../../../programas/predio/predio/apredio.php?op_predio=editar_proceso_pasos&idpredio='+idpredio+'&idmodulo_predio='+idmodulo_predio+'&idpredio_proceso_pasos_complejo='+idpredio_proceso_pasos_complejo,
        dataType: "json",
        error: function(objeto, quepaso, otro) {
            alert(otro);
        },
        success: function(datos) {

               if (datos.success) {
                    $.jGrowl(datos.mensaje, {theme: 'verde'});
                          $.ajax({
                            url: '../../../programas/predio/predio/apredio.php?op_predio=ver_editar_ficha_predio' + '&idpredio=' + idpredio + '&idmodulo_predio=' + idmodulo_predio,
                            success: function(datos) {
                              $("#predio_sh").html(datos);

                                console.log(datos);
                            },
                            beforeSend: function() {
                                $("#idhtml_cabecera_stakeholder").html("");
                                $("#idhtml_tab_stakeholder").html('<img src="../../../img/bar-ajax-loader.gif" />');

                            },
                            success: function(datos) {
                                $("#idhtml_cabecera_stakeholder").html("");
                                $("#idhtml_tab_stakeholder").html(datos);
                               
                                $('#tabs').tabs({ active: 1 });
                            }                            
                        });
                } else {
                    $.jGrowl(datos.mensaje, {theme: 'rojo'});
                }
                //console.log(datos);
          

        }
    });
}

function actualizar_predio_datum() {

    var idpredio = $("#idpredio").val();
    var idmodulo_predio = $("#idmodulo_predio").val();
 
    //var persona = $("#persona").val();
    datastring = $("#form_predio_datum").serialize();
  
    $.ajax({
        type: "POST",
        url: '../../../programas/predio/predio/apredio.php?idpredio='+idpredio+'&idmodulo_predio='+idmodulo_predio,
        data: datastring,
        dataType: "json",
        error: function(objeto, quepaso, otro) {
            alert(otro);
        },
        success: function(datos) {

               if (datos.success) {
                    $.jGrowl(datos.mensaje, {theme: 'verde'});
                    
                } else {
                    $.jGrowl(datos.mensaje, {theme: 'rojo'});
                }
                //console.log(datos);
          

        }
    });
}


function actualizar_interaccion_predio() {

    var idpredio = $("#predio").val();
    var idmodulo_predio = $("#idmodulo_predio").val();
    //var persona = $("#persona").val();
    datastring = $("#form_modal_interaccion").serialize();
    url = "";
    if (typeof(idpredio) != "undefined") {
        url = url + '?idpersona==' + idpredio + '&idmodulo_predio=' + idmodulo_predio;
    }
    $.ajax({
        type: "POST",
        url: '../../../programas/predio/predio/apredio.php' + url,
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


function modal_predio_interaccion(idinteraccion, idmodulo_interaccion, persona) {
    var url = "";
    var idpredio = $("#idpredio").val();
    var idmodulo_predio = $("#idmodulo_predio").val();

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
        url: '../../../programas/predio/predio/apredio.php?op_predio=ver_interaccion_predio_complejo' + url,
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

function eliminar_predio_sh(idpredio_sh,idmodulo_predio_sh){
    //alert("entra"+ idpredio_sh +" " +idmodulo_predio_sh)
    idpredio = $("#idpredio").val();
    idmodulo_predio = $("#idmodulo_predio").val(); 
    $.ajax({
        url: '../../../programas/predio/predio/apredio.php?op_predio=eliminar_predio_sh&idpredio_sh=' + idpredio_sh + '&idmodulo_predio_sh=' + idmodulo_predio_sh + '&idmodulo_predio=' + idmodulo_predio,
        dataType: "json",
        beforeSend: function() {
            $("#predio_sh").html('<img src="../../../img/loading.gif" />');

        },
        success: function(datos) {
            //$("#red_stakeholder").html(datos);
            if (datos.success) {
                $.jGrowl(datos.mensaje, {theme: 'verde'});
            } else {
                $.jGrowl(datos.mensaje, {theme: 'rojo'});
            }
            //console.log(datos);

            $.ajax({
                url: '../../../programas/predio/predio/apredio.php?op_predio=ver_editar_predio_sh' + '&idpredio=' + idpredio + '&idmodulo_predio=' + idmodulo_predio,
                success: function(datos) {
                    $("#predio_sh").html(datos);

                    console.log(datos);
                }
            });
        }
    });
    $("#busqueda_rapida_predio_sh").focus();    
}

function guardar_predio_sh(idpredio_sh_compuesto) {

    idpredio = $("#idpredio").val();
    idmodulo_predio = $("#idmodulo_predio").val();
    
    $.ajax({
        url: '../../../programas/predio/predio/apredio.php?op_predio=guardar_predio_sh&idpredio_sh_compuesto=' + idpredio_sh_compuesto + '&idpredio=' + idpredio + '&idmodulo_predio=' + idmodulo_predio,
        dataType: "json",
        beforeSend: function() {
            $("#predio_sh").html('<img src="../../../img/loading.gif" />');

        },
        success: function(datos) {
            //$("#red_stakeholder").html(datos);
            if (datos.success) {
                $.jGrowl(datos.mensaje, {theme: 'verde'});
            } else {
                $.jGrowl(datos.mensaje, {theme: 'rojo'});
            }
            //console.log(datos);

            $.ajax({
                url: '../../../programas/predio/predio/apredio.php?op_predio=ver_editar_predio_sh' + '&idpredio=' + idpredio + '&idmodulo_predio=' + idmodulo_predio,
                success: function(datos) {
                    $("#predio_sh").html(datos);

                    console.log(datos);
                }
            });
        }
    });
    $("#busqueda_rapida_predio_sh").focus();


}

function busqueda_rapida_predio_sh_buscar() {
    $("#busqueda_rapida_predio_sh").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    buscar_predio_sh: request.term
                },
                url: '../../../programas/predio/predio/apredio.php?op_predio=busqueda_rapida_stakeholder',
                beforeSend: function() {
                    
                    $("#img_busqueda_rapida_predio_sh").html('<img src="../../../img/loading.gif" />');
                   
                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));

                }
            });
        }, focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        }, select: function(a, b) {
            $("#busqueda_rapida_predio_sh").val("Buscar stakeholder por apellido paterno apellido materno nombre");

            if (b.item.value == 'nuevo_stake_holder') {

            } else {
                guardar_predio_sh(b.item.value);
                //alert(b.item.value);
            }

            return false;
        }
    });
}

function modal_predio_tag() {
    
    var idpredio = $("#idpredio").val();
    var idmodulo_predio = $("#idmodulo_predio").val();

   
    $.ajax({
        url: '../../../programas/predio/predio/apredio.php?op_predio=ver_editar_predio_tag&idpredio='+idpredio+'&idmodulo_predio='+idmodulo_predio,
        error: function(objeto, quepaso, otro) {
            alert(otro);
        },
        beforeSend: function() {

            $("#pantalla_aux_principal").dialog({
                title: $("<label>Predio - Tag</label>").html(),
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                position: ['center', 'center'],
                create: function(event, ui) {
                    


                },
                open: function(event, ui) {

                    
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
                title: $("<label>Predio - Tag</label>").html(),
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                position: ['center', 'center'],
                create: function(event, ui) {
                    


                },
                open: function(event, ui) {

                 
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