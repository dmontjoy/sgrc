function busqueda_rapida_organizacion(tabla, fila, adatos, nume_fila) {

    $("#txtSearch").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca: request.term
                },
                url: '../../../programas/persona/persona/apersona_organizacion.php?op_persona_organizacion=busqueda_rapida',
                beforeSend: function() {
                    $("#img_buscar_organizacion").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    $("#img_buscar_organizacion").attr("src","../../../img/serach.png");
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            if (b.item.value == 'nueva_organizacion') {
                $.ajax({
                    url: '../../../programas/persona/persona/apersona.php?idpersona_tipo=2',
                    success: function(datos) {
                        $("#idhtml_cabecera_stakeholder").html("");
                        $("#idhtml_tab_stakeholder").html(datos);
                        $("#fecha_nacimiento").datepicker({changeYear: true, changeMonth: true});


                    }
                });
            } else {
                agregafila(tabla, fila, b.item.value, adatos, nume_fila)

            }
            $("#txtSearch").focus();
            $("#txtSearch").val("");
            return false;
        }
    });

}

function cambiar_tipo_persona(idpersona, idmodulo, nuevo) {
    var idpersona_tipo = $("#idpersona_tipo").val();
    var es_stakeholder = $("#es_stakeholder").val();
    var apaterno, amaterno;
    if (nuevo == 0) {
        desc_url = '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_editar_persona' + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&idpersona_tipo=' + idpersona_tipo + '&es_stakeholder=' + es_stakeholder;
    } else {
        desc_url = '../../../programas/persona/persona/apersona.php?idpersona_tipo=' + idpersona_tipo + '&es_stakeholder=' + es_stakeholder;
    }
    $.ajax({
        url: desc_url,
        beforeSend: function() {
            apaterno = $("#apaterno").val();
            amaterno = $("#amaterno").val();
            $("#persona_div").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(datos) {
            $("#persona_div").html(datos);
            $("#apaterno").val(apaterno);
            $("#amaterno").val(amaterno);

            //console.log(datos);
        }
    });

}



function buscar_persona() {

    datastring = $("#form_buscar_persona").serialize();
    $.ajax({
        type: "POST",
        url: '../../../programas/persona/persona/apersona.php?op_persona=buscar_persona',
        dataType: "json",
        beforeSend: function() {
            $("#resultado_persona").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        data: datastring,
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        success: function(datos) {

            //$("#resultado_persona").html(datos);
            $("#resultado_persona").html("<br/><table id='lista'></table><div id='pager'></div>");
            
            $("#fid_string").val(datos.fid_string);
            
            jQuery("#lista").jqGrid({ 
                datatype: "local",
                data: datos.data,
                height: "100%", 
                width: "700", 
                colNames:['Ap. Paterno','Ap. Materno','Nombre', 'Accion'], 
                colModel:[  
                            {name:'paterno',index:'paterno', width:190, sorttype:"text"},
                            {name:'materno',index:'materno', width:190, sorttype:"text"},
                            {name:'nombre',index:'nombre', width:190, sorttype:"text"},
                            {name:'accion',index:'accion', width:100, sortable:false}
                        ],
                 rowNum:20,
                 rowList:[10,20,30],
                 pager: '#pager',
                 rownumbers: true, 
                 rownumWidth: 30,
                 sortname: 'paterno',
                 sortorder: 'asc',
                 viewrecords: true,
                 gridview:true,
                 loadonce: true,
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
                                  exportar_excel_persona('frame2')
                                }, 
                                position:"last"
                            });
                        
             jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"GIS",
                                title:"GIS",
                                buttonicon:"ui-icon-search", 
                                onClickButton: function(){ 
                                  ver_predio_entidad(' ')
                                }, 
                                position:"last"
                            });            
                        
             /*
             jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"PDF",
                                title:"Exportar",
                                buttonicon:"ui-icon-disk", 
                                onClickButton: function(){ 
                                  exportar_pdf_persona('frame2')
                                }, 
                                position:"last"
                            });
              */
            
        }
    });

}

function buscar_persona_prioridad() {

    datastring = $("#form_buscar_persona").serialize();
    $.ajax({
        type: "POST",
        url: '../../../programas/persona/persona/apersona.php?op_persona=buscar_persona_prioridad',
        dataType: "json",
        beforeSend: function() {
            $("#resultado_persona").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        data: datastring,
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        success: function(datos) {

            //$("#resultado_persona").html(datos);
            $("#resultado_persona").html("<br/><table id='lista'></table><div id='pager'></div>");
            
            $("#fid_string").val(datos.fid_string);
            
            jQuery("#lista").jqGrid({ 
                datatype: "local",
                data: datos.data,
                height: "100%", 
                width: "700", 
                colNames:datos.colNames, 
                colModel:datos.colModel,
                shrinkToFit:false,
                 rowNum:20,
                 rowList:[10,20,30],
                 pager: '#pager',
                 rownumbers: true, 
                 rownumWidth: 30,
                 sortname: 'paterno',
                 sortorder: 'asc',
                 viewrecords: true,
                 gridview:true,
                 loadonce: true,
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
                                  exportar_excel_persona('frame2')
                                }, 
                                position:"last"
                            });
                        
             jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"GIS",
                                title:"GIS",
                                buttonicon:"ui-icon-search", 
                                onClickButton: function(){ 
                                  ver_predio_entidad(' ')
                                }, 
                                position:"last"
                            });            
                        
             /*
             jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"PDF",
                                title:"Exportar",
                                buttonicon:"ui-icon-disk", 
                                onClickButton: function(){ 
                                  exportar_pdf_persona('frame2')
                                }, 
                                position:"last"
                            });
              */
            
        }
    });

}



function guardar_persona(es_stakeholder) {

    op_persona = $("#op_persona").val();
    datastring = $("#form_persona").serialize();
    
    if($("#form_persona").valid()){
       
        $.ajax({
            type: "POST",
            url: '../../../programas/persona/persona/apersona.php?es_stakeholder=' + es_stakeholder,
            data: datastring,
            dataType: "json",
            beforeSend: function() {
                if (op_persona == 'guardar') {
                    $("#idhtml_tab_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                } else {
                    $("#persona_div").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            },
            success: function(datos) {
                //console.log(datos);
                if (op_persona == 'guardar') {
                    $("#idhtml_tab_stakeholder").html(datos.html);
                    $.jGrowl(datos.mensaje, {theme: 'verde'});
                } else {
                    $("#persona_div").html(datos.html);
                }

            }
        });
    }
}

function cambiar_busqueda_persona() {
    var es_stakeholder = $("#es_stakeholder").val();
    var idpersona_tipo = $("#idpersona_tipo").val();

    $.ajax({
        type: "POST",
        url: '../../../programas/persona/persona/apersona.php?op_persona=ver_buscar_persona&es_stakeholder=' + es_stakeholder + '&idpersona_tipo=' + idpersona_tipo,
        beforeSend: function() {

            $("#idhtml_tab_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        error: function(request, status, error) {
            alert(request.responseText);
        },
        success: function(datos) {
            //console.log(datos);

            $("#idhtml_tab_stakeholder").html(datos);


        }
    });
}

function cambiar_busqueda_persona_prioridad() {
    var es_stakeholder = $("#es_stakeholder").val();
    var idpersona_tipo = $("#idpersona_tipo").val();

    $.ajax({
        type: "POST",
        url: '../../../programas/persona/persona/apersona.php?op_persona=ver_buscar_persona_prioridad&es_stakeholder=' + es_stakeholder + '&idpersona_tipo=' + idpersona_tipo,
        beforeSend: function() {

            $("#idhtml_tab_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        error: function(request, status, error) {
            alert(request.responseText);
        },
        success: function(datos) {
            //console.log(datos);

            $("#idhtml_tab_stakeholder").html(datos);


        }
    });
}

function ver_datos_relacionista(idpersona_tipo,es_stakeholder, idpersona, idmodulo) {
    
    $("#idhtml_tab_stakeholder").html("");
    if($("#pantalla_aux_principal").hasClass('ui-dialog-content') && $("#pantalla_aux_principal").dialog('isOpen')){
        $("#pantalla_aux_principal").dialog("close");
    }
    if($("#modal_interaccion").hasClass('ui-dialog-content') &&  $("#modal_interaccion").dialog('isOpen')){
        $("#modal_interaccion").dialog("close");
    }
    
    cargar_relacionista(idpersona_tipo,es_stakeholder, idpersona, idmodulo);
  
}

function cargar_relacionista(idpersona_tipo,es_stakeholder, idpersona, idmodulo) {
    $.ajax({
        type: "POST",
        url: '../../../programas/persona/persona/apersona.php?op_persona=mostrar_editar_persona&es_stakeholder=' + es_stakeholder + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&idpersona_tipo='+idpersona_tipo,
        beforeSend: function() {

            $("#idhtml_tab_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        error: function(request, status, error) {
            alert(request.responseText);
        },
        success: function(datos) {
            //console.log(datos);

            $("#idhtml_tab_stakeholder").html(datos);


        }
    });
}

function eliminar_persona(idpersona, idmodulo) {
    var gr = jQuery("#lista").jqGrid('getGridParam','selrow');
    
    var result = jQuery("#lista").jqGrid('delGridRow',
                                        gr,
                                        {
                                               reloadAfterSubmit:true,
                                               url: '../../../programas/persona/persona/apersona.php?op_persona=eliminar&idpersona='+idpersona+'&idmodulo='+idmodulo,
                                               afterShowForm: function(idform){ 
                                                   $("#delhdlista").center();
                                                   return [true, "", ""]; 
                                               },
                                               afterSubmit: function(response){ 
                                                   var obj = JSON.parse(response.responseText);
                                                   if (obj.success) {
                                                        $.jGrowl(obj.mensaje, {theme: 'verde'});                                                                                                                                                                     
                                                        buscar_persona();
                                                    } else {
                                                        $.jGrowl(obj.mensaje, {theme: 'rojo'});
                                                    }
                                                
                                                    
                                                   return [true, "", ""]; 
                                               }
                                       }
                                   );
    
   
}

function agregar_criterio_sh(){
    var condiciones=0;
    condiciones = $("#condiciones").val();
    condiciones++;
    $("#condiciones").val(condiciones);
    $("#condicion").append("<div id='condicion_"+condiciones+"'>"+$("#condicion_1").html()+"<a href='javascript:quitar_criterio_sh("+condiciones+")'><img src='../../../img/trash.png'  title='Eliminar' alt='Borrar' width='16' height='16' border='0' class='icono'  ></a> </div>");
    
}

function quitar_criterio_sh(condiciones){
    //alert(condiciones); 
    $("#condicion_"+condiciones).empty();
}

  function eliminar_sh_rc(idpersona, idmodulo, es_stakeholder, idfila,idpersona_tipo) {
      
                    var gr = jQuery("#lista").jqGrid('getGridParam','selrow');

                    var nombre="";
                    if(es_stakeholder==1){
                        nombre="stakeholer";
                    }else{
                        nombre="relacionista comunitario";
                    }
                    $("#pantalla_aux_principal").html("Esta seguro que desea desactivar los datos del "+nombre+"?");
                    $("#pantalla_aux_principal").dialog({
                            title: "Desactivar "+nombre,
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
                                  if (es_stakeholder == 1) {
                                        $.ajax({
                                            url: '../../../programas/persona/persona/apersona.php?op_persona=eliminar_sh&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
                                            beforeSend: function() {
                                                $("#opcion_persona_" + idpersona + "_" + idmodulo).html('<img src="../../../img/add_user.png" /> ');
                                            },
                                            success: function(datos) {
                                                $("#opcion_persona_" + idpersona + "_" + idmodulo).html("<a title=\"Activar\" href=\"javascript:agregar_sh_rc(" + idpersona + " ," + idmodulo + "," + es_stakeholder +"," + idfila+"," + idpersona_tipo+ ")\"><img src=\"../../../img/add.png\" /></a> ");
                                                var rowData = jQuery("#lista").jqGrid('getRowData',gr);
                                                rowData.paterno=extraer_cadena(rowData.paterno);
                                                rowData.materno=extraer_cadena(rowData.materno);
                                                rowData.nombre=extraer_cadena(rowData.nombre);
                                               var result=jQuery("#lista").jqGrid('setRowData',gr,rowData);
                                               
                                                
                                            }
                                        });
                                    } else {
                                        $.ajax({
                                            url: '../../../programas/persona/persona/apersona.php?op_persona=eliminar_rc&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
                                            beforeSend: function() {
                                                $("#opcion_persona_" + idpersona + "_" + idmodulo).html('<img src="../../../img/add_user.png" /> ');
                                            },
                                            success: function(datos) {
                                                $("#opcion_persona_" + idpersona + "_" + idmodulo).html("<a title=\"Activar\" href=\"javascript:agregar_sh_rc(" + idpersona + " ," + idmodulo + "," + es_stakeholder +"," + idfila+"," + idpersona_tipo+ ")\"><img src=\"../../../img/add.png\" /></a> ");
                                                var rowData = jQuery("#lista").jqGrid('getRowData',gr);
                                                rowData.paterno=extraer_cadena(rowData.paterno);
                                                rowData.materno=extraer_cadena(rowData.materno);
                                                rowData.nombre=extraer_cadena(rowData.nombre);
                                                var result=jQuery("#lista").jqGrid('setRowData',gr,rowData);
                                                
                                            }
                                        });
                                    }
                                    $("#pantalla_aux_principal").dialog("close");
                                },
                                "Cancel": function() {
                                    $(this).dialog("close");
                                }

                            }
                        });
    
                        $("#pantalla_aux_principal").dialog("open");
                         $("#pantalla_aux_principal").center();

                    }
                
                 function agregar_sh_rc(idpersona, idmodulo, es_stakeholder, idfila, idpersona_tipo) {
                     
                        var gr = jQuery("#lista").jqGrid('getGridParam','selrow');

                        if (es_stakeholder == 1) {
                            $.ajax({
                                url: '../../../programas/persona/persona/apersona.php?op_persona=asignar_sh&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
                                beforeSend: function() {
                                    $("#opcion_persona_" + idpersona + "_" + idmodulo).html('<img src="../../../img/add_user.png" /> ');
                                },
                                success: function(datos) {
                                    $("#opcion_persona_" + idpersona + "_" + idmodulo).html("<a title=\"Desactivar\" href=\"javascript:eliminar_sh_rc(" + idpersona + " ," + idmodulo + "," + es_stakeholder +"," + idfila+"," + idpersona_tipo+ ")\"><img src=\"../../../img/delete.png\" /></a> ");
                                    
                                    var rowData = jQuery("#lista").jqGrid('getRowData',gr);
                                    rowData.paterno="<a  href=\"javascript:cargar_stakeholder('"+idpersona+"---"+idmodulo+"---"+idpersona_tipo+"')\">"+rowData.paterno+"</a>";
                                    rowData.materno="<a  href=\"javascript:cargar_stakeholder('"+idpersona+"---"+idmodulo+"---"+idpersona_tipo+"')\">"+rowData.materno+"</a>";
                                    rowData.nombre="<a  href=\"javascript:cargar_stakeholder('"+idpersona+"---"+idmodulo+"---"+idpersona_tipo+"')\">"+rowData.nombre+"</a>";
                                    var result=jQuery("#lista").jqGrid('setRowData',gr,rowData);
                                    
                                }
                            });
                        } else {
                            $.ajax({
                                url: '../../../programas/persona/persona/apersona.php?op_persona=asignar_rc&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
                                beforeSend: function() {
                                    $("#opcion_persona_" + idpersona + "_" + idmodulo).html('<img src="../../../img/add_user.png" /> ');
                                },
                                success: function(datos) {
                                    $("#opcion_persona_" + idpersona + "_" + idmodulo).html("<a title=\"Desactivar\" href=\"javascript:eliminar_sh_rc(" + idpersona + " ," + idmodulo + "," + es_stakeholder +"," + idfila+"," + idpersona_tipo+ ")\"><img src=\"../../../img/delete.png\" alt=\"Desactivar\"/></a> ");
                                    
                                    var rowData = jQuery("#lista").jqGrid('getRowData',gr);
                                    rowData.paterno="<a href='../stakeholder/stakeholder/astakeholder.php?idpersona="+idpersona+"&idmodulo="+idmodulo+"&nombre="+rowData.nombre+"'>"+rowData.paterno+"</a>";
                                    rowData.materno="<a href='../stakeholder/stakeholder/astakeholder.php?idpersona="+idpersona+"&idmodulo="+idmodulo+"&nombre="+rowData.nombre+"'>"+rowData.materno+"</a>";
                                    rowData.nombre="<a href='../stakeholder/stakeholder/astakeholder.php?idpersona="+idpersona+"&idmodulo="+idmodulo+"&nombre="+rowData.nombre+"'>"+rowData.nombre+"</a>";
                                    var result=jQuery("#lista").jqGrid('setRowData',gr,rowData);
                                    
                                    
                                }
                            });
                        }
                    }
                
function extraer_cadena(cadena){

    var pos = cadena.search('>');

    return cadena.slice(pos+1, cadena.length - 4);

}
            
function exportar_excel_persona(id){
   var ifrm = document.getElementById(id);
    ifrm.src = "../../../programas/persona/persona/apersona.php?op_persona=exportar_persona&"+$("#form_buscar_persona").serialize();
    //ifrm.src = "";        
}

function exportar_excel_persona_red(id){
   var ifrm = document.getElementById(id);
    ifrm.src = "../../../programas/persona/persona/apersona.php?op_persona=exportar_persona_red&"+$("#form_buscar_persona").serialize();
    //ifrm.src = "";        
}

function exportar_pdf_persona(id){
   var ifrm = document.getElementById(id);
    ifrm.src = "../../../programas/persona/persona/apersona.php?op_persona=exportar_pdf_persona&"+$("#form_buscar_persona").serialize();
    //ifrm.src = "";        
}

function exportar_pdf_organizacion(id){
   var ifrm = document.getElementById(id);
    ifrm.src = "../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=exportar_pdf_organizacion&"+$("#form_persona").serialize();
    //ifrm.src = "";        
}

//////persona
function ver_buscar_persona(es_stakeholder, idpersona_tipo) {
    $.ajax({
        url: '../../../programas/persona/persona/apersona.php?op_persona=ver_buscar_persona&es_stakeholder=' + es_stakeholder + '&idpersona_tipo=' + idpersona_tipo,        
        beforeSend: function() {
            $("#idhtml_tab_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
            $("#idhtml_cabecera_stakeholder").html("");
        },
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);


        }
    });
}

//////persona
function ver_buscar_persona_prioridad(es_stakeholder, idpersona_tipo) {
    $.ajax({
        url: '../../../programas/persona/persona/apersona.php?op_persona=ver_buscar_persona_prioridad&es_stakeholder=' + es_stakeholder + '&idpersona_tipo=' + idpersona_tipo,        
        beforeSend: function() {
            $("#idhtml_tab_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
            $("#idhtml_cabecera_stakeholder").html("");
        },
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);


        }
    });
}

function ver_buscar_red() {
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_buscar_red',
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);


        }
    });
}

function buscar_red() {

    datastring = $("#form_buscar_red").serialize();
    $.ajax({
        type: "POST",
        url: '../../../programas/persona/persona/apersona.php?op_persona=buscar_persona_red',
        dataType: "json",
        beforeSend: function() {
            $("#resultado_red").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        data: datastring,
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        success: function(datos) {

            //$("#resultado_persona").html(datos);
            $("#resultado_red").html("<br/><table id='lista'></table><div id='pager'></div>");
            jQuery("#lista").jqGrid({ 
                datatype: "local",
                data: datos,
                height: "100%", 
                width: "700", 
                colNames:['Ap. Paterno','Ap. Materno','Nombre', 'Red'], 
                colModel:[  
                            {name:'paterno',index:'paterno', width:190, sorttype:"text"},
                            {name:'materno',index:'materno', width:190, sorttype:"text"},
                            {name:'nombre',index:'nombre', width:190, sorttype:"text"},
                            {name:'red',index:'red', width:100, sortable:false}
                        ],
                 rowNum:20,
                 rowList:[10,20,30],
                 pager: '#pager',
                 rownumbers: true, 
                 rownumWidth: 30,
                 sortname: 'red',
                 sortorder: 'desc',
                 viewrecords: true,
                 gridview:true,
                 loadonce: true,
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
                                  exportar_excel_persona_red('frame4')
                                }, 
                                position:"last"
                            });
                       
             /*
             jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"PDF",
                                title:"Exportar",
                                buttonicon:"ui-icon-disk", 
                                onClickButton: function(){ 
                                  exportar_pdf_persona('frame2')
                                }, 
                                position:"last"
                            });
              */
            
        }
    });

}

function validar_nombre(tipo){
             
    $("#op_persona").val("validar_nombre");
    datastring = $("#form_persona").serialize();
    
    $.ajax({
        type: "POST",
        url: '../../../programas/persona/persona/apersona.php?tipo='+tipo,
        beforeSend: function() {
            $("#pantalla_aux_principal").dialog({
                            title: "Validar Nombre ",
                            autoOpen: false,
                            height: "auto",
                            width: "auto",
                            modal: true
                            
                        });
            $("#pantalla_aux_principal").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();

        },
        data: datastring,
        dataType: "json",
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        success: function(datos) {
                if(datos.rows>0){
                        $("#pantalla_aux_principal").html(datos.html);                        
                        $("#pantalla_aux_principal").center();
                       
                }else{
                    validar_nombre_aceptar();
                }
            
            
        }
    });
    
}

function validar_nombre_aceptar(){
    if($("#idpersona").val()!=""){
        $("#op_persona").val("editar");
    }else{
        $("#op_persona").val("guardar");
    }
    
    $("#pantalla_aux_principal").dialog("close");
    $("#form_persona").submit();
}

function validar_nombre_cancelar(){
    $("#pantalla_aux_principal").dialog("close");
}

function ver_crear_rol() {
    $.ajax({
        url: '../../../programas/persona/persona/apersona.php?op_persona=ver_crear_rol',
        beforeSend: function() {
            $("#idhtml_tab_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
            $("#idhtml_cabecera_stakeholder").html("");
        },
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);
            buscar_rol();

        }
    });
}

function ver_editar_rol(idrol, rol) {
    $.ajax({
        url: '../../../programas/persona/persona/apersona.php?op_persona=ver_editar_rol&idrol='+idrol+'&rol='+rol,
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);
            buscar_rol(idrol);

        }
    });
}

function buscar_rol(idrol) {
    

    
    $.ajax({
        url: '../../../programas/persona/persona/apersona.php?op_persona=buscar_rol&idrol='+idrol,
        type: "POST",
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        beforeSend: function() {
            $("#resultado_rol").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {

            $("#resultado_rol").html(data);
        }
    });

}

function guardar_rol() {
    //cargar div edit via ajax
    if( $("#form_guardar_rol").valid() ){
        datastring = $("#form_guardar_rol").serialize();
        $.ajax({
            url: '../../../programas/persona/persona/apersona.php',
            data: datastring,
            dataType: "json",
            type: "POST",
            beforeSend: function() {

                $("#guardar_rol").html('<img src="../../../img/bar-ajax-loader.gif" />');

            },
            success: function(data) {
                        
                if (data.success) {
                    $.jGrowl(data.mensaje, {theme: 'verde'});
                } else {
                    $.jGrowl(data.mensaje, {theme: 'rojo'});
                }
                 ver_crear_rol();

            }
        });
    }

}


function actualiza_estado_permiso(nombre_celda) {
    
    var n, valor_nombre_celda;
    //alert('id' + nombre_celda);
    valor_nombre_celda = document.getElementById('id' + nombre_celda).value;
    
    var aux=0;
    
    if (valor_nombre_celda.indexOf('***') != -1) {
        n = valor_nombre_celda.split('***');
        if (n[1] == 0) {
            n[1] = 1;
            document.getElementById('td_' + nombre_celda).className = "permiso";
            aux=1;
        } else {
            n[1] = 0;
            document.getElementById('td_' + nombre_celda).className = "celdaSimple";
            aux=-1;
        }
        valor_nombre_celda = n[0] + "***" + n[1] ;
    } else {
        if (valor_nombre_celda.indexOf('###') == -1) {

            valor_nombre_celda = valor_nombre_celda + "###0";
            
            document.getElementById('td_' + nombre_celda).className = "permiso";
            aux=-1;
        } else {
            n = valor_nombre_celda.split('###');
            valor_nombre_celda = n[0];
            aux=1;
            document.getElementById('td_' + nombre_celda).className = "celdaSimple";

        }

    }
    document.getElementById('id' + nombre_celda).value = valor_nombre_celda;
    
    
}

/*function ver_organizacion_stakeholder(idpersona,idmodulo,idpersona_tipo){
    
    //
    $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_bloque_interaccion&idpersona='+idpersona+'&idmodulo='+idmodulo+'&presenta=2&persona=0&modo=2&idpersona_tipo='+idpersona_tipo+'&inicio=50',
            dataType: 'json',
            beforeSend: function() {
                $("#idhtml_tab_stakeholder").html('');
                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

            },
            success: function(datos) {
                
                $("#idhtml_cabecera_stakeholder").html(datos.html);
                $('<div id=\"grid_sh\" style=\" z-index: 1000; position: absolute; right:280px; top:135px; \"><form id="form_sh"><table id="list2"></table><div id="ptreegrid2"></div></form></div>').appendTo('#idhtml_cabecera_stakeholder');
                
                $( "#grid_sh" ).draggable();

                var grid2 = jQuery("#list2");
                grid2.jqGrid({
                    datastr: datos.sh,
                    datatype: "jsonstring",
                    height: "auto",
                    //loadui: "disable",
                    gridview: true,
                    colNames: ["id"," ","SH"],
                    colModel: [
                        {name: "id",index:'id',width:1, hidden:true, key:true},                        
                        {name: "check",index:'check', width:30, resizable: false, sorttype:'text', align: "center"},
                        {name: "sh",index:'sh', width:250, resizable: false, sorttype:'text'}
                    ],
                    treeGrid: true,
                    treeGridModel: "adjacency",
                    treedatatype:"local",
                    ExpandColumn: "sh",
                    width: 320,
                    rowNum: 10000,
                    sortname: 'sh',
                    sortorder: 'desc',
                    pager : "#ptreegrid2",
                    caption:'Ver Organizaciones',
                    hiddengrid: false,
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
*/
function ver_organizacion_stakeholder(idpersona,idmodulo,idpersona_tipo){
    
    //
    $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_bloque_interaccion&idpersona='+idpersona+'&idmodulo='+idmodulo+'&presenta=2&persona=0&modo=2&idpersona_tipo='+idpersona_tipo+'&inicio=50',
            dataType: 'json',
            beforeSend: function() {
                $("#idhtml_tab_stakeholder").html('');
                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

            },
            success: function(datos) {
                
                $("#idhtml_cabecera_stakeholder").html(datos.html);
                $('<div id=\"grid_sh\" style=\" z-index: 1000; position: absolute; right:280px; top:135px; \"><form id="form_sh" name="form_sh"><table id="list2"></table><div id="ptreegrid2"></div></form></div>').appendTo('#idhtml_tab_stakeholder');
                
                
                
                $( "#grid_sh" ).draggable();

                var grid2 = jQuery("#list2");
                grid2.jqGrid({
                    datastr: datos.sh,
                    datatype: "jsonstring",
                    height: "auto",
                    //loadui: "disable",
                    gridview: true,
                    colNames: ["id"," ","SH"],
                    colModel: [
                        {name: "id",index:'id',width:1, hidden:true, key:true},                        
                        {name: "check",index:'check', width:30, resizable: false, sorttype:'text', align: "center"},
                        {name: "sh",index:'sh', width:250, resizable: false, sorttype:'text'}
                    ],
                    treeGrid: true,
                    treeGridModel: "adjacency",
                    treedatatype:"local",
                    ExpandColumn: "sh",
                    width: 320,
                    rowNum: 10000,
                    sortname: 'id',                    
                    pager : "#ptreegrid2",
                    caption:'Ver Organizaciones',
                    hiddengrid: false,
                    
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
                
                jQuery("#list2").jqGrid('navGrid', '#ptreegrid2',{position: 'center',view:false, del:false, add:false, edit:false, refresh:false, search:false});
            
                jQuery("#list2").jqGrid('navButtonAdd','#ptreegrid2',{
                                    caption:"Aplicar Filtro",
                                    title:"Aplicar Filtro",
                                    buttonicon:"ui-icon-search", 
                                    onClickButton: function(){ 
                                      aplicar_filtro_sh(idpersona,idmodulo,idpersona_tipo);
                                    }, 
                                    position:"last"
                                });

            }
        });
    
}

function ver_hogar_stakeholder(idpersona,idmodulo,idpersona_tipo){
    
    //
    $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_bloque_interaccion&idpersona='+idpersona+'&idmodulo='+idmodulo+'&presenta=2&persona=0&modo=3&idpersona_tipo='+idpersona_tipo+'&inicio=50',
            dataType: 'json',
            beforeSend: function() {
                $("#idhtml_tab_stakeholder").html('');
                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

            },
            success: function(datos) {
                
                $("#idhtml_cabecera_stakeholder").html(datos.html);
                $('<div id=\"grid_sh\" style=\" z-index: 1000; position: absolute; right:280px; top:135px; \"><form id="form_sh" name="form_sh"><table id="list2"></table><div id="ptreegrid2"></div></form></div>').appendTo('#idhtml_tab_stakeholder');
                
                
                
                $( "#grid_sh" ).draggable();

                var grid2 = jQuery("#list2");
                grid2.jqGrid({
                    datastr: datos.sh,
                    datatype: "jsonstring",
                    height: "auto",
                    //loadui: "disable",
                    gridview: true,
                    colNames: ["id"," ","SH"],
                    colModel: [
                        {name: "id",index:'id',width:1, hidden:true, key:true},                        
                        {name: "check",index:'check', width:30, resizable: false, sorttype:'text', align: "center"},
                        {name: "sh",index:'sh', width:250, resizable: false, sorttype:'text'}
                    ],
                    treeGrid: true,
                    treeGridModel: "adjacency",
                    treedatatype:"local",
                    ExpandColumn: "sh",
                    width: 320,
                    rowNum: 10000,
                    sortname: 'id',                    
                    pager : "#ptreegrid2",
                    caption:'Ver interacciones hogar',
                    hiddengrid: false,
                    
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
                
                jQuery("#list2").jqGrid('navGrid', '#ptreegrid2',{position: 'center',view:false, del:false, add:false, edit:false, refresh:false, search:false});
            
                jQuery("#list2").jqGrid('navButtonAdd','#ptreegrid2',{
                                    caption:"Aplicar Filtro",
                                    title:"Aplicar Filtro",
                                    buttonicon:"ui-icon-search", 
                                    onClickButton: function(){ 
                                      aplicar_filtro_sh(idpersona,idmodulo,idpersona_tipo);
                                    }, 
                                    position:"last"
                                });

            }
        });
    
}

function aplicar_filtro_sh(idpersona,idmodulo,idpersona_tipo){
    
    var datastr = $("#form_sh").serialize();
    
    //
    $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_bloque_interaccion&idpersona='+idpersona+'&idmodulo='+idmodulo+'&presenta=2&persona=0&modo=2&idpersona_tipo='+idpersona_tipo+'&inicio=50',
            data: datastr,
            dataType: 'json',
            beforeSend: function() {
                
                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

            },
            success: function(datos) {
                
                $("#idhtml_cabecera_stakeholder").html(datos.html);

            }
        });
    
}


function actualiza_estado_sh(nombre_celda) {
    
    var n, valor_nombre_celda, clase_celda;
    //alert('id' + nombre_celda);
        
    var checkboxes = new Array(); 
    checkboxes = document['form_sh'].getElementsByTagName('input');
    
    n = nombre_celda.split('-');
    clase_celda =  n[0]+'-'+n[1];
    
    valor_nombre_celda = document.getElementById('id' + nombre_celda).value;
 
    for (var i=0; i<checkboxes.length; i++)  {
        //console.log(checkboxes[i].className+' '+clase_celda);
        if (checkboxes[i].type == 'checkbox' && checkboxes[i].className == clase_celda)   {
            //console.log(checkboxes[i]);
            if (valor_nombre_celda.indexOf('-') != -1) {       
                checkboxes[i].checked = false;
                document.getElementById('id' + checkboxes[i].id).value = "";        
            }else{

                checkboxes[i].checked = true;
                document.getElementById('id' + checkboxes[i].id).value = clase_celda;        
            }
            
            
        }
    }
    /*
    if (valor_nombre_celda.indexOf('-') != -1) {       
        valor_nombre_celda = "";
        document.getElementById('id' + nombre_celda).value = valor_nombre_celda;        
    }else{
       
        valor_nombre_celda =  clase_celda;
        document.getElementById('id' + nombre_celda).value = valor_nombre_celda;        
    }
    */
    //reporte_tag_stakeholder_interaccion();
    
    
}


function checkAll(formname, checktoggle)
{
  var checkboxes = new Array(); 
  checkboxes = document[formname].getElementsByTagName('input');
 
  for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].type == 'checkbox')   {
      checkboxes[i].checked = checktoggle;
      var n, valor_nombre_celda;
    //alert('id' + nombre_celda);
      valor_nombre_celda = document.getElementById('id' + checkboxes[i].id).value;
      if (checktoggle){ 
          
            if( valor_nombre_celda.indexOf('###') == -1 && valor_nombre_celda.indexOf('***') == -1) {

                valor_nombre_celda = valor_nombre_celda + "###0";

                document.getElementById('td_' + checkboxes[i].id).className = "permiso";

                document.getElementById('id' + checkboxes[i].id).value = valor_nombre_celda;
            }
        
            if(valor_nombre_celda.indexOf('***') > -1){

                n = valor_nombre_celda.split('***');
                
                n[1] = 1;
                
                valor_nombre_celda = n[0] + '***' + n[1];

                document.getElementById('td_' + checkboxes[i].id).className = "permiso";

                document.getElementById('id' + checkboxes[i].id).value = valor_nombre_celda;
            
            }
        
       }else {
           
           if(valor_nombre_celda.indexOf('###') > -1){

                n = valor_nombre_celda.split('###');
                
                valor_nombre_celda = n[0];

                document.getElementById('td_' + checkboxes[i].id).className = "celdaSimple";

                document.getElementById('id' + checkboxes[i].id).value = valor_nombre_celda;
            
            }
        
            if(valor_nombre_celda.indexOf('***') > -1){

                n = valor_nombre_celda.split('***');
                
                n[1]=0;
                
                valor_nombre_celda = n[0] + '***' + n[1];

                document.getElementById('td_' + checkboxes[i].id).className = "celdaSimple";

                document.getElementById('id' + checkboxes[i].id).value = valor_nombre_celda;
            
            }
            
       }
    }
  }
}




function borrar_prioridad_tag() {
    $("#buscar_prioridad_tag").val("");
}



function busqueda_rapida_prioridad_tag(idtag_entidad) {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();


    $("#buscar_prioridad_tag").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                    $("#img_buscar_prioridad").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    $("#img_buscar_prioridad").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#buscar_prioridad_tag").val("");
            if(b.item.value!='nuevo_tag')
                agrega_celda('prioridad_tag', b.item, 'idprioridad_complejo_tag', 'nume_celda_prioridad_tag', 'nume_fila_prioridad_tag');
            return false;
        }
    });
}


function modal_tag_persona() {
    
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();

   
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_editar_tag_stakeholder&idpersona='+idpersona+'&idmodulo='+idmodulo,
        error: function(objeto, quepaso, otro) {
            alert(otro);
        },
        beforeSend: function() {

            $("#pantalla_aux_principal").dialog({
                title: $("<label>Tag - Stakeholder</label>").html(),
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
                title: $("<label>Tag - Stakeholder</label>").html(),
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

function exportar_pdf_sh(idframe,idpersona,idmodulo){
   var ifrm = document.getElementById(idframe);

  
   ifrm.src = "../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=exportar_pdf_sh&idpersona="+idpersona+"&idmodulo="+idmodulo;



    //ifrm.src = "";
}
