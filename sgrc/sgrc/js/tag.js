
function ver_ultimos() {
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_ultimos_tags',
        success: function(data) {
            $("#resultado_tag").html(data);

        }
    });
}

function ver_ordenados() {
    
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_arbol_tags',
        dataType: "json",        
        beforeSend: function() {

            $("#resultado_tag").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
        success: function(data) {
            
            $("#resultado_tag").html(data.html);
            
            
           

            //$('<table id="list2"></table>').appendTo('#resultado_tag');

            var grid = jQuery("#list2");
            grid.jqGrid({
                datastr: data.tags.response,
                datatype: "jsonstring",
                height: "auto",
                //loadui: "disable",
                gridview: true,
                colNames: ["id","No","Tag","Acci&oacute;n"],
                colModel: [
                    {name: "id",index:'id',width:1, hidden:true, key:true},
                    {name:'num',index:'num', width:30, sorttype:'number'},
                    {name: "tag",index:'tag', width:250, resizable: false, sortable:false},
                    {name: "accion",index:'accion', width:50, resizable: false, sorttype:'text'}
                ],
                treeGrid: true,
                treeGridModel: "adjacency",
                treedatatype:"local",
                ExpandColumn: "tag",
                autowidth: true,
                rowNum: 10000,
                sortname: 'num',
                sortorder: 'asc',
                pager : "#ptreegrid2",
                //ExpandColClick: true,
                treeIcons: {leaf:'ui-icon-document-b'},
                jsonReader: {
                    repeatitems: false,
                    root: function (obj) { return obj; },
                    page: function (obj) { return 1; },
                    total: function (obj) { return 1; },
                    records: function (obj) { return obj.length; }
                }
            });         
                       
        }
    });
    
   
}

function ver_todos() {
    
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_todos_tags',
        dataType: "json",        
        beforeSend: function() {

            $("#resultado_tag").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
        success: function(data) {
            
            $("#resultado_tag").html(data.html);
           
            //$('<table id="list2"></table>').appendTo('#resultado_tag');

            var grid = jQuery("#list2");
            grid.jqGrid({
                data: data.tags.response,
                datatype: "local",
                height: "100%", 
                width: "800",
                shrinkToFit:false,
                 rowNum:20,
                 rowList:[10,20,30],                  
                 rownumWidth: 30,
                 sortname: 'ruta',
                 sortorder: 'asc',
                 viewrecords: true,
                 gridview:true,
                 loadonce: true,
                colNames: ["id","No","Tag","Ruta","Nivel","Hijos","Acci&oacute;n","Entidad"],
                colModel: [
                    {name: "id",index:'id',width:1, hidden:true, key:true},
                    {name:'num',index:'num', width:30, sorttype:'number'},
                    {name: "tag",index:'tag', width:200, resizable: false, sorttype:'text'},
                    {name: "ruta",index:'ruta', width:300, resizable: false, sorttype:'text'},
                    {name:'level',index:'level', width:40, sorttype:'number', align:"center"},
                    {name:'hijos',index:'hijos', width:40, sorttype:'number', align:"center"},
                    {name: "accion",index:'accion', width:50, resizable: false, sorttype:'text',align:"center"},
                    {name: "entidad",index:'entidad', width:200, resizable: false, sorttype:'text',align:"center"}
                ],
                
                autowidth: true,               
                pager : "#ptreegrid2"
            });  
            
            grid.jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,defaultSearch : "cn"});
                       
        }
    });
    
   
}

function ver_stakeholders(idtag, idmodulo_tag, tag) {

    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_tags_persona&idtag=' + idtag + '&idmodulo_tag=' + idmodulo_tag,        
        beforeSend: function() {

            $("#stakeholder").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
        success: function(data) {
            $("#stakeholder").html(data);
            $('html,body').animate({
                scrollTop: $("#stakeholder").offset().top
            }, 2000);

        }
    });
}

function modal_ver_stakeholders(idtag, idmodulo_tag, tag) {

    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_tags_persona&idtag=' + idtag + '&idmodulo_tag=' + idmodulo_tag,
        beforeSend: function() {

            $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');

            $("#pantalla_aux_principal").dialog({
                title: "Stakholders Tag "+tag,
                autoOpen: false,
                height: 'auto',
                width: 'auto',
                modal: true,
                close: function(event, ui) {
                    $("this").dialog("destroy");
                    $("#pantalla_aux_principal").html('');
                },
                create: function(event, ui) {
                    ;
                    


                },
                open: function(event, ui) {

                    


                }
                
            });
            
            $("#pantalla_aux_principal").dialog("open");
            

        },
        success: function(data) {
            
            $("#pantalla_aux_principal").html(data);

            $("#pantalla_aux_principal").dialog({
                title: "Stakholders Tag "+tag,
                autoOpen: false,
                height: 'auto',
                width: 'auto',
                modal: true,
                close: function(event, ui) {
                    $("this").dialog("destroy");
                    $("#pantalla_aux_principal").html('');
                },
                create: function(event, ui) {
                    ;
                    


                },
                open: function(event, ui) {

                    


                }
                
            });
            
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();
            

        }
    });
}

function modal_mostrar_crear_tag() {
    //cargar div edit via ajax

    $.ajax({
        url: '../../../plantillas/stakeholder/tag/edit_tag.html',
        success: function(data) {
            $("#pantalla_aux_principal").html(data);

            $("#pantalla_aux_principal").dialog({
                title: "Crear Tag ",
                autoOpen: false,
                height: 150,
                width: 200,
                modal: true,
                close: function(event, ui) {
                                $("#pantalla_aux_principal").html("");
                                $("#pantalla_aux_principal").dialog("destroy");
                            },
                create: function(event, ui) {
                    ;
                    


                },
                open: function(event, ui) {

                    


                },
                buttons: {
                    "Guardar": function() {
                        var idpersona = $("#idpersona").val();
                        var idmodulo = $("#idmodulo").val();
                        var tag = $("#actualiza_tag").val();
                        var datastring = $("#formulario_tag").serialize();
                        $.ajax({
                            url: '../../../programas/tag/tag/atag.php?op_tag=guardar_tag&idpersona='+idpersona+'&idmodulo='+idmodulo ,
                            data: datastring,
                            dataType: "json",
                            success: function(data) {
                                if (data.success) {
                                    $.jGrowl(data.mensaje, {theme: 'verde'});
                                    refrescar_tag_stakeholder();
                                } else {
                                    $.jGrowl(data.mensaje, {theme: 'rojo'});
                                }
                                $("#pantalla_aux_principal").dialog("close");
                            }
                        });
                    },
                    "Cancel": function() {
                        $("#pantalla_aux_principal").dialog("close");
                    }

                }
            });

            $("#pantalla_aux_principal").dialog("open");

        }
    });



}


function modal_mostrar_editar_tag(idtag, idmodulo, tag, vista) {
    //cargar div edit via ajax

    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_editar_tag&idtag=' + idtag + '&idmodulo_tag=' + idmodulo,
        success: function(data) {
            $("#pantalla_aux_principal").html(data);
            $("#input_tag").val(tag);

            $("#pantalla_aux_principal").dialog({
                title: "Editar Tag ",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
               close: function(event, ui) {
                                $("#pantalla_aux_principal").html("");
                                $("#pantalla_aux_principal").dialog("destroy");
                            },
                
                buttons: {
                    "Guardar": function() {
                        var datastring = $("#formulario_tag").serialize();
                        
                        if($("#formulario_tag").valid()){

                            $.ajax({
                                url: '../../../programas/tag/tag/atag.php?op_tag=editar_tag&idtag=' + idtag + '&idmodulo_tag=' + idmodulo,
                                data: datastring,
                                dataType: "json",
                                success: function(data) {
                                    if (data.success) {
                                        $.jGrowl(data.mensaje, {theme: 'verde'});
                                        if(vista>1){
                                            //alert('refrescar');
                                            //$("#columna_" + idtag + '_' + idmodulo).html('<a href="javascript:ver_stakeholders( ' + idtag + ',' + idmodulo + ',\'' + tag + '\'  )">' + tag + '</a>');
                                            //$("#enlace_" + idtag + '_' + idmodulo).html('<a href="javascript:modal_mostrar_editar_tag( ' + idtag + ',' + idmodulo + ',\'' + tag + '\' , 2 )"><img src="../../../img/edit.png" alt="Editar"/></a>' + ' <a href="javascript:mostrar_eliminar_tag( ' + idtag + ',' + idmodulo + ' )">	<img src="../../../img/trash.png" alt="Eliminar"/></a>');
                                           ver_ordenados();
                                        }else{
                                            //alert('refrescar');
                                            refrescar_tag_stakeholder();
                                        }
                                    } else {
                                        $.jGrowl(data.mensaje, {theme: 'rojo'});
                                    }
                                    $("#pantalla_aux_principal").dialog("close");
                                }
                            });
                        }
                    },
                    "Cancel": function() {
                        $("#pantalla_aux_principal").dialog("close");
                    }

                }
            });

            $("#pantalla_aux_principal").dialog("open");

        }
    });



}

function ver_buscar_tag() {
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_buscar_tag',        
        beforeSend: function() {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
        success: function(datos) {
            
            $("#idhtml_tab_stakeholder").html(datos);
            
            ver_todos();


        }
    });
}

function buscar_id_tag(idtag, idmodulo_tag) {

    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=buscar_tag&idtag=' + idtag + '&idmodulo_tag=' + idmodulo_tag,
        //data: datastring,
        type: "GET",
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        success: function(data) {

            $("#resultado_tag").html(data);
        }
    });
}

function buscar_tag() {
    

    datastring = $("#form_buscar_tag").serialize();
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=buscar_tag&tag=' + tag,
        data: datastring,
        type: "POST",
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        success: function(data) {

            $("#resultado_tag").html(data);
        }
    });

}

function ver_crear_tag() {
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_crear_tag',
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);


        }
    });

}

function guardar_tag() {
    //cargar div edit via ajax
    if( $("#form_guardar_tag").valid() ){
        datastring = $("#form_guardar_tag").serialize();
        $.ajax({
            url: '../../../programas/tag/tag/atag.php?op_tag=crear_tag',
            data: datastring,
            dataType: "json",
            type: "POST",
            beforeSend: function() {

                $("#guardar_tag").html('<img src="../../../img/bar-ajax-loader.gif" />');

            },
            success: function(data) {
        
                $("#guardar_tag").html('<input  type="submit" value="Guardar"/>');

                $("#tag").val("");
                if (data.success) {
                    $.jGrowl(data.mensaje, {theme: 'verde'});
                } else {
                    $.jGrowl(data.mensaje, {theme: 'rojo'});
                }

            }
        });
    }

}


function mostrar_eliminar_tag(idtag, idmodulo) {
    
    $("#pantalla_aux_principal").html("Esta seguro que desea eliminar el Tag?");
    $("#pantalla_aux_principal").dialog({
                            title: "Eliminar Tag ",
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
                                                url: '../../../programas/tag/tag/atag.php?op_tag=eliminar_tag&idtag=' + idtag + '&idmodulo_tag=' + idmodulo,
                                                dataType: "json",                                                
                                                beforeSend: function() {
                                                    $("#pantalla_aux_principal").append('<div><img src="../../../img/bar-ajax-loader.gif" /></div>');

                                                },
                                                success: function(data) {
                                                     $("#pantalla_aux_principal").dialog("close");
                                                    if (data.success) {
                                                        $.jGrowl(data.mensaje, {theme: 'verde'});
                                                        
                                                        if ($("#fila_" + idtag + '_' + idmodulo).length) {
 
                                                        // Do something
                                                            $("#fila_" + idtag + '_' + idmodulo).hide();

                                                        }else{
                                                            ver_buscar_tag();
                                                        }
                                                        //validar si hay grilla reload grilla

                                                    } else {
                                                        $.jGrowl(data.mensaje, {theme: 'rojo'});
                                                    }
                                                    $("#delete-form").dialog("close");

                                                    //location.reload(true);

                                                }
                                            });
                                },
                                "Cancel": function() {
                                    $(this).dialog("close");
                                }

                            }
                        });
    
    $("#pantalla_aux_principal").dialog("open");
    $("#pantalla_aux_principal").center();
    /*
    $('html,body').animate({
                scrollTop: $("#pantalla_aux_principal").offset().top
            }, 2000);
  
    */

}

/***cuerpo**/

function mostrar_editar_tag() {
    $('#tabla_editar_tag').show();
    $('#tabla_persona_tag').hide();

}

function mostrar_tag() {
    $('#tabla_persona_tag').show();
    $('#tabla_editar_tag').hide();

}

function borrar_tag() {
    $("#tag_buscar").val("");
}


function busqueda_rapida_tag() {

    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();

    $("#tag_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_tag&idtag_entidad=2',                
                 beforeSend: function() {
                    $("#img_buscar_sh_tag").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    $("#img_buscar_sh_tag").attr("src","../../../img/serach.png");
                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#tag_buscar").val("");
            //alert(b.item.value);
            //guardar_tag_stakeholder(b.item.value);
            agrega_celda_tag('stakeholder_complejo_tag', b.item, 'idstakeholder_complejo_tag', 'nume_celda_stakeholder_tag_complejo', 'nume_fila_stakeholder_tag_complejo');
            return false;
        }
    });

}

function guardar_tag_stakeholder(idtag_compuesto) {
    idpersona = $("#idpersona").val();
    idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=guardar_tag_stakeholder&idtag_compuesto=' + idtag_compuesto + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
        dataType: 'json',
        success: function(datos) {
            //$("#subbloque_editar_tag").html(datos);
            if (datos.success) {
                $.jGrowl(datos.mensaje, {theme: 'verde'});
            } else {
                $.jGrowl(datos.mensaje, {theme: 'rojo'});
            }
            $.ajax({
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_tag_stakeholder&idtag_compuesto=' + idtag_compuesto + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
                dataType: 'json',
                success: function(datos) {
                    $("#subbloque_editar_tag").html(datos.editar_tag);
                    $("#tabla_persona_tag").html(datos.ver_tag);

                }
            });

        }
    });
    $("#tag_buscar").focus();
}

function eliminar_tag_stakeholder(idpersona_tag, idmodulo_persona_tag) {
    idpersona = $("#idpersona").val();
    idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=eliminar_tag_stakeholder&idpersona_tag=' + idpersona_tag + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&idmodulo_persona_tag=' + idmodulo_persona_tag,
        dataType: 'json',
        success: function(datos) {
            //$("#subbloque_editar_tag").html(datos);

            $.ajax({
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_tag_stakeholder&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
                dataType: 'json',
                error: function(objeto, quepaso, otro) {
                    //alert(otro);
                },
                success: function(data) {
                    //alert(respuesta.ver_tag);
                    $("#subbloque_editar_tag").html(data.editar_tag);
                    //$("#tabla_persona_tag").html("");
                    $("#tabla_persona_tag").html(data.ver_tag);

                }
            });

        }
    });
    $("#tag_buscar").focus();
}


function actualiza_valor(nombre_celda) {
    var n, valor_nombre_celda;
    //alert('id' + nombre_celda);
    valor_nombre_celda = document.getElementById('id' + nombre_celda).value;
            
    if (valor_nombre_celda.indexOf('***') != -1) {
        n = valor_nombre_celda.split('***');
        if (n[1] == 0) {
            n[1] = 1;                       
        } else {
            n[1] = 0;                        
        }
        valor_nombre_celda = n[0] + "***" + n[1];
    } 
    
    
    if (valor_nombre_celda.indexOf('###') != -1) {

        n = valor_nombre_celda.split('###');
        if (n[1] == 0) {
            n[1] = 1;                       
        } else {
            n[1] = 0;                        
        }
        valor_nombre_celda = n[0] + "###" + n[1];
        
    }
    
    document.getElementById('id' + nombre_celda).value = valor_nombre_celda;
    
    
}