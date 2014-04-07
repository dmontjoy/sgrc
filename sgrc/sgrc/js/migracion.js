function cargar_plantilla_sincronizacion(){
     $.ajax({
        url: '../../../programas/migracion/migracion/amigracion.php',
        success: function(datos) {
            $("#pantalla_aux_principal").html(datos);
            $("#pantalla_aux_principal").dialog({
                            title: "Sincronizar ",
                            autoOpen: false,
                            height: "auto",
                            width: "auto",
                            modal: true,
                              close: function(event, ui) {
                                $("#pantalla_aux_principal").html("");
                                $("#pantalla_aux_principal").dialog("destroy");
                            },
                            buttons:[ {
                                id:"button-ok",
                                text:"Iniciar",
                                click: function() {
                                    $("#button-ok").button("disable");
                                    $("#barra").show();
                                    var ipserver = $("#ipserver").val();
                                     $.ajax({
                                        url: '../../../programas/migracion/migracion/amigracion.php?op_migracion=generar_archivo_cliente&ipserver='+ipserver,
                                        dataType: "json",
                                        success: function(datos) {
                                            
                                            
                                            
                                            if(datos.success){
                                                
                                                $("#check_paso1").attr("checked","checked");
                                                
                                                $.ajax({
                                                    url: '../../../programas/migracion/migracion/amigracion.php?op_migracion=enviar_archivo_cliente',
                                                    success: function(datos) {
                                                        $("#check_paso2").attr("checked","checked");
                                                        
                                                        
                                                        
                                                        $.ajax({
                                                            url: '../../../programas/migracion/migracion/amigracion.php?op_migracion=solicitar_archivo_servidor',
                                                            success: function(datos) {
                                                                $("#check_paso3").attr("checked","checked");
                                                                $("#barra").hide();    
                                                                $("#button-end").button("enable");
                                                            }
                                                        }); 
                                                        
                                                        
                                                        
                                                    }
                                                });   
                                                
                                                
                                            }else{
                                                $("#barra").html(datos.message);
                                                $("#button-end").button("enable");
                                            }
                                         
                                        
                                        }
                                    });
                                    //$("#pantalla_aux_principal").dialog("close");
                                }
                            },{
                                id:"button-end",
                                text:"Terminar",
                                click: function() {
                                    $(this).dialog("close");
                                    actualiza();
                                }

                            }]
                        });
            
            $("#pantalla_aux_principal").dialog("open");
            $("#pantalla_aux_principal").center();
            $("#button-end").button("disable");


        }
    });
}