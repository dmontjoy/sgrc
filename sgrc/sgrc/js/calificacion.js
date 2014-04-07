function mostrar_registrar_voto(idpersona, idmodulo) {


    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_dimension_matriz',
        success: function(data) {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var yyyy = today.getFullYear();
            $("#frm_registrar_voto").html(data);
            $("#fecha_voto").datepicker({changeYear: true, changeMonth: true});
            $("#fecha_voto").val(dd + "/" + mm + "/" + yyyy);
            $("#idpersona_voto").val(idpersona);
            $("#idmodulo_voto").val(idmodulo);


            //alert('Load was performed.');
            $("#frm_registrar_voto").dialog("open");
            $("#button-save").button("enable");
            
            $("#frm_registrar_voto").center();


        }
    });


}


function seleccionar_puntaje(idvalor, iddimension) {
    var ultimo_valor = $("#dimension_" + iddimension).val();
    var border = $("#imagen_" + idvalor).attr("border");

    if (border > 0) {
        $("#imagen_" + idvalor).attr("border", "0")
        $("#dimension_" + iddimension).val(0)
    } else {
        $("#imagen_" + idvalor).attr("border", "2")
        $("#dimension_" + iddimension).val(idvalor)
    }

    if (ultimo_valor != idvalor) {
        $("#imagen_" + ultimo_valor).attr("border", "0")
    }



}



function mostrar_historico(idpersona, idmodulo) {

    $.ajax({
        url: '../../../plantillas/stakeholder/calificacion/ver_historico.html',
        success: function(data) {
            $("#mostrar_historico").html(data);
            $("#idpersona_historico").val(idpersona);
            $("#idmodulo_historico").val(idmodulo);

            $("#hfecha1").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function(selectedDate) {
                    $("#hfecha2").datepicker("option", "minDate", selectedDate);
                }
            });
            $("#hfecha2").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function(selectedDate) {
                    $("#hfecha1").datepicker("option", "maxDate", selectedDate);
                }
            });

            var date = new Date();
            

            $("#hfecha1").val(customFormat("01/#MM#/#YYYY#" ,date));

            $("#hfecha2").val(customFormat("#DD#/#MM#/#YYYY#" ,date));
            //alert('Load was performed.');
            
            $("#hfecha1").datepicker("disable");
            
            $("#hfecha2").datepicker("disable");
                        
              
            $("#mostrar_historico").dialog("open");
            
            
            $("#mostrar_historico").center();
            
            
            $("#hfecha1").datepicker("enable");
            
            $("#hfecha2").datepicker("enable");
            
        }
    });




}


function eliminar_calificacion(idsh_dimension,idmodulo_sh_dimension) {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();
    var gr = jQuery("#lista_historico").jqGrid('getGridParam','selrow');
    var url= '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=eliminar_calificacion_stakeholder&idsh_dimension='+idsh_dimension+'&idmodulo_sh_dimension='+idmodulo_sh_dimension+'&idpersona='+idpersona+'&idmodulo='+idmodulo;
    //alert('url: '+url);
    
    
    jQuery("#lista_historico").jqGrid('delGridRow',gr,{
                                               reloadAfterSubmit:false,
                                               url: url,
                                               afterShowForm: function(idform){ 
                                                   $("#delhdlista_historico").center();
                                                   return [true, "", ""]; 
                                               },
                                               afterSubmit: function(response){ 
                                                   var obj = JSON.parse(response.responseText);
                                                   
                                                   if (obj.success) {
                                                        $.jGrowl(obj.mensaje, {theme: 'verde'});
                                                        buscar_calificacion();
                                                        ver_cabecera_stakeholder(idpersona+'---'+idmodulo);
                                                        
                                                    } else {
                                                        $.jGrowl(obj.mensaje, {theme: 'rojo'});
                                                       
                                                    }
                                                   
                                                   return [true, "", ""]; 
                                               }
                                       });
        

}

function refrescar_tag_stakeholder() {
    idpersona = $("#idpersona").val();
    idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=refrescar_tag_stakeholder&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
        dataType:"json",
        success: function(datos) {
            //alert(datos.editar_tag);
            $("#subbloque_editar_tag").html(datos.editar_tag);
            $("#tabla_persona_tag").html(datos.ver_tag);
        }
    });
    $("#tag_buscar").focus();
}




function cargar_analisis_red() {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();
    var rango_fecha = $("#rango_fecha").val();

    //alert('fecha_rango : '+rango_fecha);

    /*

     Si rango fecha es mayor que uno ajax
     sino reload tab
     */
    if (rango_fecha > 1) {


        $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=actualizar_analisis_red&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&rango_fecha=' + rango_fecha,
            success: function(data) {
                $("#analisis_red").html(data);




            }
        });
    } else {
        $('#tabs').tabs('load', 3);
    }
}

function mostrar_legend(idlegend) {
    $("#legend_" + idlegend).show();

}

function cerrar_legend(idlegend) {
    $("#legend_" + idlegend).hide();

}

function cargar_stakeholder(idpersona_compuesto) {
    ver_cabecera_stakeholder(idpersona_compuesto);
    ver_tab_stakeholder(idpersona_compuesto);
}




function eliminar_compromiso(idcompromiso, idmodulo_compromiso) {
    $("#pantalla_aux_principal").html("Esta seguro que desea eliminar el compromiso?");
    $("#pantalla_aux_principal").dialog({
                            title: "Eliminar compromiso ",
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
                                        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=eliminar_compromiso_stakeholder&idcompromiso=' + idcompromiso + '&idmodulo_compromiso=' + idmodulo_compromiso,
                                        dataType: "json",
                                        success: function(data) {
                                            if (data.success) {
                                                $('.compromiso_'+idcompromiso+'_'+idmodulo_compromiso).hide();
                                                $.jGrowl(data.mensaje, {theme: 'verde'});

                                            } else {
                                                $.jGrowl(data.mensaje, {theme: 'rojo'});
                                            }
                                            $("#pantalla_aux_principal").dialog("close");

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

}

function buscar_calificacion() {
    var idpersona=$("#idpersona").val();
    var idmodulo=$("#idmodulo").val();
    datastring = $("#form_historico").serialize();
    $.ajax({
        type: "POST",
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=obtener_calificacion_stakeholder&idpersona='+idpersona+"&idmodulo="+idmodulo,
        dataType: "json",
        beforeSend: function() {
            $("#tabla_historico").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        data: datastring,
        error: function(objeto, quepaso, otro) {
            //alert(objeto.responseText);
            alert(otro);
        },
        success: function(datos) {

            //$("#resultado_persona").html(datos);
            $("#tabla_historico").html("<br/><table id='lista_historico'></table><div id='pager'></div>");
            
              
                jQuery("#lista_historico").jqGrid({ 
                datatype: "local",
                data: datos,
                height: "100%", 
                width: "540", 
                colNames:['Fecha','Posicion','Poder','Interes','Accion'], 
                colModel:[  
                            {name:'fecha',index:'fecha', width:80,align:'center', sorttype:"date"},
                            {name:'posicion',index:'posicion', width:40,align:'center', sorttype:"int"},
                            {name:'poder',index:'poder', width:40,align:'center', sorttype:"int"},
                            {name:'interes',index:'interes', width:40,align:'center', sorttype:"int"},
                            {name:'accion',index:'accion', width:40,align:'center', sorttype:"text"}
                        ],
                 rowNum:20,
                 rowList:[10,20,30],
                 pager: '#pager',
                 rownumbers: true, 
                 rownumWidth: 30,
                 sortname: 'fecha',
                 sortorder: 'asc',
                 viewrecords: true,
                 gridview:true
            }); 
            
            jQuery("#lista_historico").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,defaultSearch : "cn"});
            
            /*
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
            */
                        
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