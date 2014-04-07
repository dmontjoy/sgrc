function cuerpo_ver_mas_compromiso(limite) {

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_cuerpo_compromiso&limite='+limite,
        beforeSend: function() {
            $("#cuerpo_compromiso").html('<img src="../../../img/bar-ajax-loader.gif">');
        },
        success: function(data) {           
            $("#cuerpo_compromiso").html(data);            
        }
    });


}

function ver_buscar_compromiso() {
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_buscar_compromiso',
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);


        }
    });
}

function buscar_compromiso() {

    datastring = $("#form_buscar_compromiso").serialize();
    $.ajax({
        type: "POST",
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=buscar_compromiso',
        dataType: "json",
        beforeSend: function() {
            $("#resultado_compromiso").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

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
    
           $("#fid_string").val(datos.fid_string);

            //$("#resultado_persona").html(datos);
            $("#resultado_compromiso").html("<br/><table id='lista'></table><div id='pager'></div>");
            jQuery("#lista").jqGrid({ 
                datatype: "local",
                data: datos.data,
                height: "100%", 
                width: "700", 
                colNames:['Compromiso','Estado','Prioridad','Fecha','Accion'], 
                colModel:[  
                            {name:'compromiso',index:'compromiso', width:400, sorttype:"text"},                            
                            {name:'estado',index:'estado', width:75, sorttype:"text"},
                            {name:'prioridad',index:'prioridad', width:75, sorttype:"text"},
                            {name:'fecha',index:'fecha', width:75, sorttype:"date"},
                            {name:'accion',index:'accion', width:75, sorteable:false}
                        ],
                 rowNum:20,
                 rowList:[10,20,30],
                 pager: '#pager',
                 rownumbers: true, 
                 rownumWidth: 30,
                 sortname: 'compromiso',
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
                                  exportar_excel_compromiso('frame4')
                                }, 
                                position:"last"
                            });
                        
            jQuery("#lista").jqGrid('navButtonAdd','#pager',{
                                caption:"GIS",
                                title:"GIS",
                                buttonicon:"ui-icon-search", 
                                onClickButton: function(){ 
                                  ver_predio_entidad('Compromiso')
                                }, 
                                position:"last"
                            });
                            
           
            
        }
    });

}

function borrar_compromiso_rc_buscar() {

    $("#compromiso_rc_buscar").val("");
}


function busquedarapida_compromiso_rc_buscar() {

    $("#compromiso_rc_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                    $("#img_buscar_rc").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    $("#img_buscar_rc").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#compromiso_rc_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda('compromiso_rc', b.item, 'idcompromiso_rc', 'nume_celda_compromiso_rc', 'nume_fila_compromiso_rc','cant_rc')
                return false;

            }

            return false;
        }
    });
}


                    function borrar_compromiso_sh_buscar() {

                        $("#compromiso_sh_buscar").val("");
                    }

                    function busquedarapida_compromiso_sh_buscar() {

                        $("#compromiso_sh_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                                        $("#img_buscar_compromiso_sh").attr("src","../../../img/ajax-loader.png");

                                    },
                                    success: function(datos) {
                                        //$("#mensaje").val(datos);
                                        response($.map(datos, function(item) {
                                            return{
                                                label: item.label,
                                                value: item.value
                                            }
                                        }));
                                    
                                    $("#img_buscar_compromiso_sh").attr("src","../../../img/serach.png");

                                    }
                                });
                            },
                            focus: function(event, ui) {
                                event.preventDefault();
                                return false;
                            },
                            select: function(a, b) {
                                $("#compromiso_sh_buscar").val("");

                                if (b.item.value == 'nuevo_stake_holder') {
                                    //alert("entra");
                                } else {
                                    agrega_celda('compromiso_sh', b.item, 'idcompromiso_sh', 'nume_celda_compromiso_sh', 'nume_fila_compromiso_sh','cant_sh')
                                    return false;

                                }

                                return false;
                            }
                        });
                    }

function exportar_excel_compromiso(id){
   var ifrm = document.getElementById(id);
    ifrm.src = "../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=exportar_compromiso&"+$("#form_buscar_compromiso").serialize();
    //ifrm.src = "";
    
    
}


function modal_nuevo_compromiso(idinteraccion, idmodulo_interaccion) {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_compromiso_stakeholder&idinteraccion=' + idinteraccion + '&idmodulo_interaccion=' + idmodulo_interaccion + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
        beforeSend: function() {
             $("#pantalla_aux_principal").dialog({
                title: "Compromiso",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                create: function(event, ui) {



                },
                open: function(event, ui) {
                    $("#fecha_compromiso").blur();
                    $("#pantalla_aux_principal").center();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');
            $("#pantalla_aux_principal").dialog("open");

        },
        success: function(datos) {
            $("#pantalla_aux_principal").dialog("close");
            $("#pantalla_aux_principal").dialog({
                title: "Compromiso",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                create: function(event, ui) {



                },
                open: function(event, ui) {
                    $("#fecha_compromiso").blur();
                    $("#fecha_compromiso").datepicker({changeYear: true, changeMonth: true});
                    $("#fecha_fin_compromiso").datepicker({changeYear: true, changeMonth: true});
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html(datos);
            $("#fecha_compromiso").blur();
            $("#fecha_compromiso").datepicker({changeYear: true, changeMonth: true});
            $("#fecha_fin_compromiso").datepicker({changeYear: true, changeMonth: true});
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();
        }
    });
}



function modal_editar_compromiso(idcompromiso, idmodulo_compromiso) {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_editar_compromiso_stakeholder&idcompromiso=' + idcompromiso + '&idmodulo_compromiso=' + idmodulo_compromiso + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
        beforeSend: function() {
            $("#pantalla_aux_principal").dialog({
                title: "Compromiso",
                autoOpen: false,
                height: "auto",
                width: "auto",
                modal: true,
                create: function(event, ui) {


                },
                open: function(event, ui) {
                    $("#fecha_compromiso").blur();
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
                title: "Compromiso",
                autoOpen: false,
                height: "auto",
                width: "800",
                modal: true,
                create: function(event, ui) {


                },
                open: function(event, ui) {
                    $("#fecha_compromiso").blur();
                    //$("#comp_interaccion").focus();
                },
                close: function(event, ui) {
                    $("#pantalla_aux_principal").html("");
                    $("#pantalla_aux_principal").dialog("destroy");
                },
            });
            $("#pantalla_aux_principal").html(datos);
            $("#fecha_compromiso").blur();
            $("#fecha_compromiso").datepicker({changeYear: true, changeMonth: true});
            $("#fecha_fin_compromiso").datepicker({changeYear: true, changeMonth: true});

            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();




        }
    });
}

function exportar_pdf_compromiso(idframe,idcompromiso,idmodulo_compromiso){
   var ifrm = document.getElementById(idframe);
    ifrm.src = "../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=exportar_pdf_compromiso&idcompromiso="+idcompromiso+"&idmodulo_compromiso="+idmodulo_compromiso;
    //ifrm.src = "";        
}