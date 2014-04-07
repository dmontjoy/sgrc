
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
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_tags',
        success: function(data) {
            $("#resultado_tag").html(data);
        }
    });
}

function ver_stakeholders(idtag, idmodulo_tag, tag) {

    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_tags_persona&idtag=' + idtag + '&idmodulo_tag=' + idmodulo_tag,
        success: function(data) {
            $("#stakeholder").html(data);
            $('html,body').animate({
                scrollTop: $("#stakeholder").offset().top
            }, 2000);

        }
    });
}

function modal_mostrar_editar_tag(idtag, idmodulo, tag) {
    //cargar div edit via ajax

    $.ajax({
        url: '../../../plantillas/stakeholder/tag/edit_tag.html',
        success: function(data) {
            $("#edit-form").html(data);

            $("#edit-form").dialog({
                autoOpen: false,
                height: 150,
                width: 200,
                modal: true,
                close: function(event, ui) {
                    $("this").dialog("destroy");
                },
                create: function(event, ui) {
                    ;
                    $("#actualiza_tag").val(tag);


                },
                open: function(event, ui) {

                    $("#actualiza_tag").val(tag);


                },
                buttons: {
                    "Guardar": function() {
                        var tag = $("#actualiza_tag").val();

                        $.ajax({
                            url: '../../../programas/tag/tag/atag.php?op_tag=editar_tag&idtag=' + idtag + '&idmodulo_tag=' + idmodulo + '&tag=' + tag,
                            dataType: "json",
                            success: function(data) {
                                if (data.success) {
                                    $.jGrowl(data.mensaje, {theme: 'verde'});
                                    $("#columna_" + idtag + '_' + idmodulo).html('<a href="javascript:ver_stakeholders( ' + idtag + ',' + idmodulo + ',\'' + tag + '\'  )">' + tag + '</a>');
                                    $("#enlace_" + idtag + '_' + idmodulo).html('<a href="javascript:modal_mostrar_editar_tag( ' + idtag + ',' + idmodulo + ',\'' + tag + '\'  )"><img src="../../../img/edit.png" alt="Editar"/></a>' + ' <a href="javascript:mostrar_eliminar_tag( ' + idtag + ',' + idmodulo + ' )">	<img src="../../../img/trash.png" alt="Eliminar"/></a>');
                                } else {
                                    $.jGrowl(data.mensaje, {theme: 'rojo'});
                                }
                                $("#edit-form").dialog("close");
                            }
                        });
                    },
                    "Cancel": function() {
                        $("#edit-form").dialog("close");
                    }

                }
            });

            $("#edit-form").dialog("open");

        }
    });



}

function ver_buscar_tag() {
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_buscar_tag',
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $("#idhtml_tab_stakeholder").html(datos);


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

function buscar_tag(tag) {
    if (tag == '***') {
        tag = $("#tag").val();
    }

    //datastring = $("#form_buscar_tag").serialize();
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=buscar_tag&tag=' + tag,
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
    datastring = $("#form_guardar_tag").serialize();
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=crear_tag',
        data: datastring,
        dataType: "json",
        type: "POST",
        success: function(data) {
            $("#tag").val("");
            if (data.success) {
                $.jGrowl(data.mensaje, {theme: 'verde'});
            } else {
                $.jGrowl(data.mensaje, {theme: 'rojo'});
            }

        }
    });

}


function mostrar_eliminar_tag(idtag, idmodulo) {

    $.ajax({
        url: '../../../plantillas/stakeholder/tag/delete_tag.html',
        success: function(data) {
            $("#delete-form").html(data);

            $("#delete-form").dialog({
                autoOpen: false,
                height: 150,
                width: 200,
                modal: true,
                close: function(event, ui) {
                    $("this").dialog("destroy");
                },
                buttons: {
                    "Aceptar": function() {


                        //alert('../../../programas/tag/tag/atag.php?op_tag=eliminar_tag&idtag='+idtag+'&idmodulo_tag='+idmodulo);
                        $.ajax({
                            url: '../../../programas/tag/tag/atag.php?op_tag=eliminar_tag&idtag=' + idtag + '&idmodulo_tag=' + idmodulo,
                            dataType: "json",
                            success: function(data) {
                                if (data.success) {
                                    $.jGrowl(data.mensaje, {theme: 'verde'});
                                    $("#fila_" + idtag + '_' + idmodulo).hide();

                                } else {
                                    $.jGrowl(data.mensaje, {theme: 'rojo'});
                                }
                                $("#delete-form").dialog("close");

                                //location.reload(true);

                            }
                        });

                    },
                    "Cancel": function() {
                        $("#delete-form").dialog("close");
                    }

                }
            });

            $("#delete-form").dialog("open");

        }
    });


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
function busqueda_rapida_tag() {

    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();

    $("#tag_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_tag: request.term
                },
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_tag',
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
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#tag_buscar").val("");
            //alert(b.item.value);
            guardar_tag_stakeholder(b.item.value);
            return false;
        }
    });

}

function eliminar_tag_stakeholder(idpersona_tag, idmodulo_persona_tag) {
    idpersona = $("#idpersona").val();
    idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=eliminar_tag_stakeholder&idpersona_tag=' + idpersona_tag + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&idmodulo_persona_tag=' + idmodulo_persona_tag,
        dataType: 'json',
        success: function(datos) {
            //$("#subbloque_editar_tag").html(datos);
            if (datos.success) {
                $.jGrowl(datos.mensaje, {theme: 'verde'});
            } else {
                $.jGrowl(datos.mensaje, {theme: 'rojo'});
            }
            $.ajax({
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_tag_stakeholder&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
                success: function(datos) {
                    $("#subbloque_editar_tag").html(datos);


                }
            });

        }
    });
    $("#tag_buscar").focus();
}