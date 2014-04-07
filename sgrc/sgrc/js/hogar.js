
function borrar_hogar_buscar() {
    $("#hogar_sh_buscar").val("");
}

function busquedarapida_hogar_sh_buscar() {

    $("#hogar_sh_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                    $("#img_buscar_hogar_sh").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                
                    $("#img_buscar_hogar_sh").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#hogar_sh_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                agrega_celda_hogar('hogar_sh', b.item, 'idhogar_complejo_sh', 'nume_celda_hogar_sh', 'nume_fila_hogar_sh','cant_hogar')
                return false;

            }

            return false;
        }
    });
}

    function ver_nuevo_hogar(idpersona, idmodulo) {
        $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_nuevo_hogar&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
            beforeSend: function() {
                $("#hogar").html('<table width="100%"><tr><td align="center"><img src="../../../img/bar-ajax-loader.gif"></td></tr></table>');
            },
            error: function(objeto, quepaso, otro) {
                alert(quepaso);
            },
            success: function(datos) {
                    //console.log(datos);
                $("#hogar").html(datos);
            }
        });
    }
    
    function eliminar_hogar(idsh_hogar, idmodulo_sh_hogar) {
  
    $("#pantalla_aux_principal").dialog({
                            title: "Eliminar el hogar ",
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
                                          url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=eliminar_hogar&idsh_hogar=' + idsh_hogar + '&idmodulo_sh_hogar=' + idmodulo_sh_hogar + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
                                          dataType: 'json',
                                          beforeSend: function() {

                                              $("#hogar").html('<table width="100%"><tr><td align="center"><img src="../../../img/bar-ajax-loader.gif"></td></tr></table>');
                                         },
                                          error: function(objeto, quepaso, otro) {
                                              alert(quepaso);
                                          },
                                          success: function(obj) {
                                              //console.log(data);
                                              //var obj = jQuery.parseJSON(data);
                                              $("#pantalla_aux_principal").dialog("close");
                                              if (obj.success) {
                                                  $.jGrowl(obj.mensaje, {theme: 'verde'});
                                                  $.ajax({
                                                  type: 'get',
                                                  url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_nuevo_editar_hogar&idpersona=' + obj.idpersona + '&idmodulo=' + obj.idmodulo,
                                                  success: function(data) {
                                                      $("#hogar").html(data);
                                                  }
                                                  });
                                              } else {
                                                  $.jGrowl(obj.mensaje, {theme: 'rojo'});
                                              }

                                              }
                                      });
                                    
                                },
                                "Cancel": function() {
                                    $(this).dialog("close");
                                }

                            }
                        });
    $("#pantalla_aux_principal").html("Est&aacute; seguro que desea eliminar el hogar?");
    $("#pantalla_aux_principal").dialog("open");
    $("#pantalla_aux_principal").center();



}
    
    
   /* function eliminar_hogar(idsh_hogar, idmodulo_sh_hogar){
        $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=eliminar_hogar&idsh_hogar=' + idsh_hogar + '&idmodulo_sh_hogar=' + idmodulo_sh_hogar + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
            dataType: 'json',
            beforeSend: function() {

                $("#hogar").html('<table width="100%"><tr><td align="center"><img src="../../../img/bar-ajax-loader.gif"></td></tr></table>');
           },
            error: function(objeto, quepaso, otro) {
                alert(quepaso);
            },
            success: function(obj) {
                //console.log(data);
                //var obj = jQuery.parseJSON(data);
                if (obj.success) {
                    $.jGrowl(obj.mensaje, {theme: 'verde'});
                    $.ajax({
                    type: 'get',
                    url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_nuevo_editar_hogar&idpersona=' + obj.idpersona + '&idmodulo=' + obj.idmodulo,
                    success: function(data) {
                        $("#hogar").html(data);
                    }
                    });
                } else {
                    $.jGrowl(obj.mensaje, {theme: 'rojo'});
                }

                }
        });
   }
   */
   function ver_hogar(idpersona,idmodulo){
        $.ajax({
           type: 'get',
           beforeSend: function() {

                $("#boton_hogar_cancelar").html('<table width="100%"><tr><td align="center"><img src="../../../img/bar-ajax-loader.gif"></td></tr></table>');
           },
           url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_nuevo_editar_hogar&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
           success: function(data) {
               $("#hogar").html(data);
           }
         })     
       
   }
   function ver_editar_hogar(idsh_hogar, idmodulo_sh_hogar){
       idpersona= $("#idpersona").val();
       idmodulo=$("#idmodulo").val();
   
         $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_editar_hogar&idsh_hogar=' + idsh_hogar + '&idmodulo_sh_hogar=' + idmodulo_sh_hogar+'&idpersona='+idpersona+'&idmodulo='+idmodulo,
            beforeSend: function() {

                $("#hogar").html('<table width="100%"><tr><td align="center"><img src="../../../img/bar-ajax-loader.gif"></td></tr></table>');
           },
            error: function(objeto, quepaso, otro) {
                alert(quepaso);
            },
            success: function(data) {

             $("#hogar").html(data);
           },      

        });      
   }