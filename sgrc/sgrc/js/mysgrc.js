function mostrar_registrar_voto(idpersona, idmodulo) {


    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_dimension_matriz',
        beforeSend: function() {

            $("#frm_registrar_voto").html('<img src="../../../img/loading.gif" />');

        },
        success: function(data) {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var yyyy = today.getFullYear();
            $("#frm_registrar_voto").html(data);
            $("#fecha_voto").datepicker();
            $("#fecha_voto").val(dd + "/" + mm + "/" + yyyy);
            $("#idpersona_voto").val(idpersona);
            $("#idmodulo_voto").val(idmodulo);


            //alert('Load was performed.');
            $("#frm_registrar_voto").dialog("open");


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
        beforeSend: function() {

            $("#mostrar_historico").html('<img src="../../../img/loading.gif" />');

        },
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

            var d = new Date();
            var YYYY = d.getFullYear();
            var mm = d.getMonth() + 1;
            var dd = d.getDate();

            $("#hfecha1").val("01" + "/" + mm + "/" + YYYY);

            $("#hfecha2").val(dd + "/" + mm + "/" + YYYY);
            //alert('Load was performed.');
            $("#mostrar_historico").dialog("open");
            $('#table_id').dataTable({
                "sDom": '<"top">rti<"bottom"p><"clear">',
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "../../../informacion/calificacion/server_processing.php?idpersona=" + idpersona + "&idmodulo=" + idmodulo,
                "oLanguage": {
                    "sUrl": "../../../plantillas/stakeholder/calificacion/es_PE.txt"
                }
            });
        }
    });




}


function aplicar_filtro() {
    var fecha1 = $("#hfecha1").val();
    var fecha2 = $("#hfecha2").val();
    var tokens1 = fecha1.split("/");
    var tokens2 = fecha2.split("/");

    fecha1 = tokens1[2] + "-" + tokens1[1] + "-" + tokens1[0];
    fecha2 = tokens2[2] + "-" + tokens2[1] + "-" + tokens2[0];

    //alert("fecha 1: "+fecha1);



    $.ajax({
        url: '../../../plantillas/stakeholder/calificacion/tabla_historico.html',
        beforeSend: function() {

            $("#tabla_historico").html('<img src="../../../img/loading.gif" />');

        },
        success: function(data) {
            $("#tabla_historico").html(data);

            //alert('Load was performed.');
            var idpersona = $("#idpersona_historico").val();
            var idmodulo = $("#idmodulo_historico").val();

            $('#table_id').dataTable({
                "sDom": '<"top">rti<"bottom"p><"clear">',
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "../../../informacion/calificacion/server_processing.php?sStart=" + fecha1 + "&sEnd=" + fecha2 + "&idpersona=" + idpersona + "&idmodulo=" + idmodulo,
                "oLanguage": {
                    "sUrl": "../../../plantillas/stakeholder/calificacion/es_PE.txt"
                }
            });
        }
    });


}



function actualizar_calificacion(idsh_dimension_matriz_sh) {

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=actualizar_calificacion_stakeholder&idsh_dimension_matriz_sh=' + idsh_dimension_matriz_sh,
        success: function(data) {

            $.ajax({
                url: '../../../plantillas/stakeholder/calificacion/tabla_historico.html',
                beforeSend: function() {

                    $("#tabla_historico").html('<img src="../../../img/loading.gif" />');

                },
                success: function(data) {
                    $("#tabla_historico").html(data);

                    var idpersona = $("#idpersona_historico").val();
                    var idmodulo = $("#idmodulo_historico").val();

                    $('#table_id').dataTable({
                        "sDom": '<"top">rti<"bottom"p><"clear">',
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "../../../informacion/calificacion/server_processing.php?idpersona=" + idpersona + "&idmodulo=" + idmodulo,
                        "oLanguage": {
                            "sUrl": "../../../plantillas/stakeholder/calificacion/es_PE.txt"
                        }
                    });
                }
            });

        }
    });


}

function mostrar_editar(idtag, idmodulo, tag) {
    $("#actualiza_tag").val(tag);
    $("#id_tag").val(idtag);
    $("#id_modulo").val(idmodulo);
    $("#edit-form").dialog("open");

}

function refrescar_tag_stakeholder(idpersona_tag) {
    idpersona = $("#idpersona").val();
    idmodulo = $("#idmodulo").val();
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=refrescar_tag_stakeholder&idpersona_tag=' + idpersona_tag + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
        beforeSend: function() {

            $("#subbloque_editar_tag").html('<img src="../../../img/loading.gif" />');

        },
        success: function(datos) {
            $("#subbloque_editar_tag").html(datos);

        }
    });
    $("#tag_buscar").focus();
}


function mostrar_crear() {

    $("#create-form").dialog("open");

}


function cargar_analisis_red() {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();
    var rango_fecha = $("#rango_fecha").val();

    if (rango_fecha > 1) {


        $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=actualizar_analisis_red&idpersona=' + idpersona + '&idmodulo=' + idmodulo + '&rango_fecha=' + rango_fecha,
            beforeSend: function() {

                $("#analisis_red").html('<img src="../../../img/loading.gif" />');

            },
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
    //llamada ajax json reload tab
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=eliminar_compromiso_stakeholder&idcompromiso=' + idcompromiso + '&idmodulo_compromiso=' + idmodulo_compromiso,
        dataType: "json",
        success: function(data) {
            if (data.success) {
                $('#tabs').tabs('load', 0);
                $.jGrowl(data.mensaje, {theme: 'verde'});

            } else {
                $.jGrowl(data.mensaje, {theme: 'rojo'});
            }


        }
    });


}