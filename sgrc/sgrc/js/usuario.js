function modal_registrar_usuario(idpersona,idmodulo){
   $.ajax({
                            url: '../../../programas/usuario/usuario/ausuario.php?op_usuario=ver_nuevo_usuario&idpersona='+idpersona+'&idmodulo='+idmodulo,
                            beforeSend: function(xhr){
                                    
                                    $("#pantalla_aux_principal").dialog({
                                        title: "Registrar usuario",
                                        autoOpen: false,
                                        height: "auto" ,
                                        width: "auto",
                                        modal: true,
                                  
                                        create: function(event, ui) {

                                        },
                                        open: function(event, ui) {
                                        },
                                        close: function(event, ui) {
                                            $("#pantalla_aux_principal").html("");
                                            $("#pantalla_aux_principal").dialog("destroy");
                                        },
                                    });
                                    $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');
                                    $("  #pantalla_aux_principal").dialog("open");
                                    $("  #pantalla_aux_principal").center();
                                    
                            },
                            success: function(datos) {
                                $("  #pantalla_aux_principal").dialog("close");
                                
                                $("#pantalla_aux_principal").html(datos);
                                $("#pantalla_aux_principal").dialog({
                                        title: "Registrar usuario",
                                        autoOpen: false,
                                        height: "auto" ,
                                        width: "auto",
                                        modal: true,
                                  
                                        create: function(event, ui) {

                                        },
                                        open: function(event, ui) {
                                        },
                                        close: function(event, ui) {
                                            $("#pantalla_aux_principal").html("");
                                            $("#pantalla_aux_principal").dialog("destroy");
                                        },
                                    });
                                    $("  #pantalla_aux_principal").dialog("open");
                                    $("  #pantalla_aux_principal").center();
                                
                                //$(window).scrollTop($(document).height()-$(window).height());
                            }
                        });

}

function modal_ver_usuario(idpersona,idmodulo){
   $.ajax({
                            url: '../../../programas/usuario/usuario/ausuario.php?op_usuario=ver_usuario&idpersona='+idpersona+'&idmodulo='+idmodulo,
                            beforeSend: function(xhr){
                                    $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');
                                    $("#pantalla_aux_principal").dialog({
                                        title: "Lista de Usuarios",
                                        autoOpen: false,
                                        height: "auto" ,
                                        width: "auto",
                                        modal: true,
                                  
                                        create: function(event, ui) {

                                        },
                                        open: function(event, ui) {
                                        },
                                        close: function(event, ui) {
                                            
                                            $("#pantalla_aux_principal").dialog("destroy");
                                            $("#pantalla_aux_principal").html("");
                                        },
                                    });
                                    $("  #pantalla_aux_principal").dialog("open");
                                    $("  #pantalla_aux_principal").center();
                                    
                            },
                            success: function(datos) {
                                $("  #pantalla_aux_principal").dialog("close");
                                
                                $("#pantalla_aux_principal").html(datos);
                                $("#pantalla_aux_principal").dialog({
                                        title: "Lista de Usuarios",
                                        autoOpen: false,
                                        height: "auto" ,
                                        width: "auto",
                                        modal: true,
                                  
                                        create: function(event, ui) {

                                        },
                                        open: function(event, ui) {
                                        },
                                        close: function(event, ui) {
                                            
                                            $("#pantalla_aux_principal").dialog("destroy");
                                            $("#pantalla_aux_principal").html("");
                                        },
                                    });
                                    $("  #pantalla_aux_principal").dialog("open");
                                    $("  #pantalla_aux_principal").center();
                                    
                                
                                //$(window).scrollTop($(document).height()-$(window).height());
                            }
                        });

}

function modal_editar_usuario(idusuario,idmodulo){
   $.ajax({
                            url: '../../../programas/usuario/usuario/ausuario.php?op_usuario=ver_editar_usuario&idusuario='+idusuario+'&idmodulo='+idmodulo,
                            beforeSend: function(xhr){
                                    $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');
                                    $("#pantalla_aux_principal").dialog({
                                        title: "Editar usuario",
                                        autoOpen: false,
                                        height: "auto" ,
                                        width: "auto",
                                        modal: true,
                                  
                                        create: function(event, ui) {

                                        },
                                        open: function(event, ui) {
                                        },
                                        close: function(event, ui) {
                                            
                                            $("#pantalla_aux_principal").dialog("destroy");
                                            $("#pantalla_aux_principal").html("");
                                        },
                                    });
                                    $("  #pantalla_aux_principal").dialog("open");
                                    $("  #pantalla_aux_principal").center();
                                    
                            },
                            success: function(datos) {
                                $("  #pantalla_aux_principal").dialog("close");
                                
                                $("#pantalla_aux_principal").html(datos);
                                $("#pantalla_aux_principal").dialog({
                                        title: "Editar usuario",
                                        autoOpen: false,
                                        height: "auto" ,
                                        width: "auto",
                                        modal: true,
                                  
                                        create: function(event, ui) {

                                        },
                                        open: function(event, ui) {
                                        },
                                        close: function(event, ui) {
                                            
                                            $("#pantalla_aux_principal").dialog("destroy");
                                            $("#pantalla_aux_principal").html("");
                                        },
                                    });
                                    $("  #pantalla_aux_principal").dialog("open");
                                    $("  #pantalla_aux_principal").center();
                                    
                                
                                //$(window).scrollTop($(document).height()-$(window).height());
                            }
                        });

}

function modal_actualizar_clave(idusuario,idmodulo){
   $.ajax({
                            url: '../../../programas/usuario/usuario/ausuario.php?op_usuario=ver_actualizar_clave&idusuario='+idusuario+'&idmodulo='+idmodulo,
                            beforeSend: function(xhr){
                                    $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');
                                    $("#pantalla_aux_principal").dialog({
                                        title: "Actualizar Clave",
                                        autoOpen: false,
                                        height: "auto" ,
                                        width: "auto",
                                        modal: true,
                                  
                                        create: function(event, ui) {

                                        },
                                        open: function(event, ui) {
                                        },
                                        close: function(event, ui) {
                                            
                                            $("#pantalla_aux_principal").dialog("destroy");
                                            $("#pantalla_aux_principal").html("");
                                        },
                                    });
                                    $("  #pantalla_aux_principal").dialog("open");
                                    
                            },
                            success: function(datos) {
                                $("  #pantalla_aux_principal").dialog("close");
                                
                                $("#pantalla_aux_principal").html(datos);
                                $("#pantalla_aux_principal").dialog({
                                        title: "Actualizar Clave",
                                        autoOpen: false,
                                        height: "auto" ,
                                        width: "auto",
                                        modal: true,
                                  
                                        create: function(event, ui) {

                                        },
                                        open: function(event, ui) {
                                        },
                                        close: function(event, ui) {
                                            
                                            $("#pantalla_aux_principal").dialog("destroy");
                                            $("#pantalla_aux_principal").html("");
                                        },
                                    });
                                    $("  #pantalla_aux_principal").dialog("open");
                                    
                                
                                //$(window).scrollTop($(document).height()-$(window).height());
                            }
                        });

}



function guardar_usuario(){
    if( $("#clave").val() != $("#password").val()){
        $("#usuario_mensaje").html("Las contrase&ntilde;as no coinciden");
    }else{
        $("#usuario_mensaje").html("");
        datastring = $("#form_usuario").serialize();
        $.ajax({
            type: "POST",
            url: '../../../programas/usuario/usuario/ausuario.php',
            data: datastring,
            dataType: "json",
            beforeSend: function() {
                
            },
            error: function (request, status, error) {
                alert(request.responseText);
            },
            success: function(datos) {
                //console.log(datos);
                $("  #pantalla_aux_principal").dialog("close");
                if (datos.success) {
                    
                    $.jGrowl(datos.mensaje, {theme: 'verde'});
                } else {
                    $.jGrowl(datos.mensaje, {theme: 'rojo'});
                }
                

            }
        });
    }
   
}

function eliminar_usuario(idusuario,idmodulo_usuario){
    $("  #pantalla_aux_principal").dialog("close");
                                
    $("#pantalla_aux_principal").html("Est&aacute; seguro que desea eliminar los datos del usuario?");
    $("#pantalla_aux_principal").dialog({
            title: "Eliminar usuario",
            autoOpen: false,
            height: "auto" ,
            width: "auto",
            modal: true,

            create: function(event, ui) {

            },
            open: function(event, ui) {
            },
            close: function(event, ui) {

                $("#pantalla_aux_principal").dialog("destroy");
            },
             buttons: {
                    "Aceptar": function() {
                        $.ajax({
                            type: "POST",
                            url: '../../../programas/usuario/usuario/ausuario.php?op_usuario=eliminar&idusuario='+idusuario+'&idmodulo_usuario='+idmodulo_usuario,                           
                            dataType: "json",
                            beforeSend: function() {
                                    $("#pantalla_aux_principal").append('<div><img src="../../../img/add_user.png" /></div>');
                            },
                            error: function (request, status, error) {
                                alert(request.responseText);
                            },
                            success: function(datos) {
                                //console.log(datos);
                                $("  #pantalla_aux_principal").dialog("close");
                                if (datos.success) {

                                    $.jGrowl(datos.mensaje, {theme: 'verde'});
                                } else {
                                    $.jGrowl(datos.mensaje, {theme: 'rojo'});
                                }


                            }
                        });
                        
                    },
                    "Cancelar": function() {
                        $("#pantalla_aux_principal").dialog("close");
                    }

                }
        });
    $("  #pantalla_aux_principal").dialog("open");
    
}

function habilitar_campo_password(){
    if($('#fila_clave_1').is(':visible')){
        $('#fila_clave_1').hide();
        $('#fila_clave_2').hide();
    }else{
        $('#fila_clave_1').show();
        $('#fila_clave_2').show();
    }
}