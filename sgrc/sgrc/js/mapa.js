


function ver_buscar_mapa(){
    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_buscar_mapa&presenta=1',
        beforeSend: function() {
                $("#idhtml_cabecera_stakeholder").html("");
                $("#idhtml_tab_stakeholder").html('<br/><div><img src="../../../img/bar-ajax-loader.gif" /></div>');


                },
        success: function(datos) {
            $("#idhtml_cabecera_stakeholder").html("");
            $.ajax({
                url: '../../../programas/tag/tag/atag.php?op_tag=ver_arbol_tags_check&tipo_check=1',
                dataType: "json",
                beforeSend: function() {

                    $("#container").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

                },
                success: function(data) {

                    $("#idhtml_tab_stakeholder").html("<form id=\"form_tag_sh\" name=\"form_tag_sh\" ><div id=\"X\" style=\" z-index: 1000; position: absolute; left:50px; top:100px; \"><table id=\"list2\"></table><div   id=\"ptreegrid2\"></div></div><div id=\"Y\" style=\" z-index: 1000; position: absolute; right:50px; top:100px; \"><table id=\"list1\"></table><div   id=\"ptreegrid1\"></div></div><div style=\"position: absolute; left: 50%;top:100px;\"><div id=\"Z\" style=\" z-index: 1000; position: relative; left: -50%;\"><table id=\"list3\"></table><div   id=\"ptreegrid3\"></div></div></form>");
                    $("#idhtml_tab_stakeholder").append("<div><br/><br/><br/><br/></div>"+datos);
                    $( "#X" ).draggable();
                    $( "#Y" ).draggable();
                    $( "#Z" ).draggable();

                    var grid2 = jQuery("#list2");
                    grid2.jqGrid({
                        datastr: data.tags_sh,
                        datatype: "jsonstring",
                        height: "auto",
                        //loadui: "disable",
                        gridview: true,
                        shrinkToFit:false,
                        colNames: ["id"," ", " ","Tag","Ruta"],
                        colModel: [
                            {name: "id",index:'id',width:1, hidden:true, key:true},
                            {name:'num',index:'num', width:1,hidden:true, align:'center', sorttype:'number'},
                            {name:'check',index:'check', width:20, align:'center', sorttype:'text'},
                            {name: "tag",index:'tag', width:250, resizable: false, sorttype:'text'},
                            {name: "ruta",index:'ruta', width:250, resizable: false, sorttype:'text'}
                        ],
                        treeGrid: true,
                        toppager: true,
                        treeGridModel: "adjacency",
                        treedatatype:"local",
                        ExpandColumn: "tag",
                        width: 300,
                        rowNum: 10000,
                        sortname: 'num',
                        sortorder: 'asc',
                        pager : "#ptreegrid2",
                        caption:'Tags Stakeholder - Y',
                        hiddengrid: true,
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

                $('#list2_toppager_center').hide();
                $('#list2_toppager_right').hide();


            grid2.jqGrid('navGrid', '#ptreegrid2',
                {add: false, edit: false, del: false, search: false, refresh: false, cloneToTop:true });

            $('#ptreegrid2_center').hide();
            $('#ptreegrid2_right').hide();

            grid2.jqGrid('navButtonAdd','#ptreegrid2',{
                                caption:"Seleccionar",
                                title:"Seleccionar",
                                buttonicon:"ui-icon-check",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', true, 'tags_sh');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

            grid2.jqGrid('navButtonAdd','#list2_toppager_left',{
                                caption:"Seleccionar",
                                title:"Seleccionar",
                                buttonicon:"ui-icon-check",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', true, 'tags_sh');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

             grid2.jqGrid('navButtonAdd','#ptreegrid2',{
                                caption:"Deseleccionar",
                                title:"Deseleccionar",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', false, 'tags_sh');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

            grid2.jqGrid('navButtonAdd','#list2_toppager_left',{
                                caption:"Deseleccionar",
                                title:"Deseleccionar",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', false, 'tags_sh');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });





                var grid1 = jQuery("#list1");
                        grid1.jqGrid({
                            datastr: data.tags,
                            datatype: "jsonstring",
                            height: "auto",
                            //loadui: "disable",
                            gridview: true,
                            shrinkToFit:false,
                            colNames: ["id"," ", " ","Tag","Ruta"],
                            colModel: [
                                {name: "id",index:'id',width:1, hidden:true, key:true},
                                {name:'num',index:'num', width:1,hidden:true, align:'center', sorttype:'number'},
                                {name:'check',index:'check', width:20, align:'center', sorttype:'text'},
                                {name: "tag",index:'tag', width:250, resizable: false, sorttype:'text'},
                                {name: "ruta",index:'ruta', width:250, resizable: false, sorttype:'text'}
                            ],
                            treeGrid: true,
                            toppager: true,
                            treeGridModel: "adjacency",
                            treedatatype:"local",
                            ExpandColumn: "tag",
                            width: 300,
                            rowNum: 10000,
                            sortname: 'num',
                            sortorder: 'asc',
                            pager : "#ptreegrid1",
                            caption:'Tags Interaccion - X',
                            hiddengrid: true,
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

            $('#list1_toppager_center').hide();
            $('#list1_toppager_right').hide();


            grid1.jqGrid('navGrid', '#ptreegrid1',
                {add: false, edit: false, del: false, search: false, refresh: false, cloneToTop:true });

            $('#ptreegrid1_center').hide();
            $('#ptreegrid1_right').hide();

            grid1.jqGrid('navButtonAdd','#ptreegrid1',{
                                caption:"Seleccionar",
                                title:"Seleccionar",
                                buttonicon:"ui-icon-check",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', true, 'tags');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

            grid1.jqGrid('navButtonAdd','#list1_toppager_left',{
                                caption:"Seleccionar",
                                title:"Seleccionar",
                                buttonicon:"ui-icon-check",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', true, 'tags');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

             grid1.jqGrid('navButtonAdd','#ptreegrid1',{
                                caption:"Deseleccionar",
                                title:"Deseleccionar",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', false, 'tags');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

            grid1.jqGrid('navButtonAdd','#list1_toppager_left',{
                                caption:"Deseleccionar",
                                title:"Deseleccionar",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', false, 'tags');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

            var grid3 = jQuery("#list3");
                        grid3.jqGrid({
                            datastr: data.tags_predio,
                            datatype: "jsonstring",
                            height: "auto",
                            //loadui: "disable",
                            gridview: true,
                            shrinkToFit:false,
                            colNames: ["id"," ", " ","Tag","Ruta"],
                            colModel: [
                                {name: "id",index:'id',width:1, hidden:true, key:true},
                                {name:'num',index:'num', width:1,hidden:true, align:'center', sorttype:'number'},
                                {name:'check',index:'check', width:20, align:'center', sorttype:'text'},
                                {name: "tag",index:'tag', width:250, resizable: false, sorttype:'text'},
                                {name: "ruta",index:'ruta', width:250, resizable: false, sorttype:'text'}
                            ],
                            treeGrid: true,
                            toppager: true,
                            treeGridModel: "adjacency",
                            treedatatype:"local",
                            ExpandColumn: "tag",
                            width: 300,
                            rowNum: 10000,
                            sortname: 'num',
                            sortorder: 'asc',
                            pager : "#ptreegrid3",
                            caption:'Tags Predio - Z',
                            hiddengrid: true,
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

              $('#list3_toppager_center').hide();
              $('#list3_toppager_right').hide();


            grid3.jqGrid('navGrid', '#ptreegrid3',
                {add: false, edit: false, del: false, search: false, refresh: false, cloneToTop:true });

            $('#ptreegrid3_center').hide();
            $('#ptreegrid3_right').hide();

            grid3.jqGrid('navButtonAdd','#ptreegrid3',{
                                caption:"Seleccionar",
                                title:"Seleccionar",
                                buttonicon:"ui-icon-check",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', true, 'tags_predio');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

            grid3.jqGrid('navButtonAdd','#list3_toppager_left',{
                                caption:"Seleccionar",
                                title:"Seleccionar",
                                buttonicon:"ui-icon-check",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', true, 'tags_predio');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

             grid3.jqGrid('navButtonAdd','#ptreegrid3',{
                                caption:"Deseleccionar",
                                title:"Deseleccionar",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', false, 'tags_predio');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

            grid3.jqGrid('navButtonAdd','#list3_toppager_left',{
                                caption:"Deseleccionar",
                                title:"Deseleccionar",
                                onClickButton: function(){
                                  checkAllClass('form_tag_sh', false, 'tags_predio');
                                  actualiza_identificador_geografico();
                                },
                                position:"last"
                            });

        }
    });

        }
    });

}


function borrar_predio_stakeholder() {

    $("#busqueda_rapida_predio_stakeholder").val("");
}


function busqueda_rapida_predio_stakeholder() {
    $("#busqueda_rapida_predio_stakeholder").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 1,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida_predio_stakeholder: request.term
                },
                url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=busqueda_rapida_predio_stakeholder',
                beforeSend: function(){
                    $("#img_complejo_buscar_predio").attr("src","../../../img/ajax-loader.png");
                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));

                    $("#img_complejo_buscar_predio").attr("src","../../../img/serach.png");

                }
            });
        }, focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        }, select: function(a, b) {
            $("#busqueda_rapida_predio_stakeholder").val("Buscar predio");

            if (b.item.value == 'nuevo_stake_holder') {

            } else {
                guardar_predio_stakeholder(b.item.value);

            }

            return false;
        }
    });
}

function guardar_predio_stakeholder(idpredio) {

        idpersona = $("#idpersona").val();
        idmodulo = $("#idmodulo").val();

        $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=guardar_predio_stakeholder&idpredio=' + idpredio + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
            dataType: "json",
            beforeSend: function() {
                $("#predio_stakeholder").html('<img src="../../../img/loading.gif" />');

            },
            success: function(datos) {

                if (datos.success) {
                    $.jGrowl(datos.mensaje, {theme: 'verde'});
                } else {
                    $.jGrowl(datos.mensaje, {theme: 'rojo'});
                }
                //console.log(datos);


                $.ajax({
                    url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_editar_predio_stakeholder' + '&idpersona=' + idpersona + '&idmodulo=' + idmodulo,
                    success: function(datos) {
                        $("#predio_stakeholder").html(datos);


                    }
                });

            }
        });
        $("#busqueda_rapida_predio_stakeholder").focus();


    }

function actualiza_identificador_geografico(){

    datastring = $("#form_tag_sh").serialize();
    //alert(datastring);
    $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=consultar_indentificadores_geograficos',
            data: datastring,
            dataType: "json",
            beforeSend: function() {
                document.getElementById("output").innerHTML = '<img src="../../../img/bar-ajax-loader.gif" style="width:auto; height:auto;vertical-align: middle;">';

            },
            success: function(datos) {

                document.getElementById("output").innerHTML = '';
                $("#fid_string_query").val(datos.fid_string);
                //alert(datos.fid_string);
                 updateFilter();
            }
        });



}

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};


function modal_ver_predio_stakeholders(idgis_item) {

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_predio_persona&idgis_item=' + idgis_item,
        beforeSend: function() {

            $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');

            $("#pantalla_aux_principal").dialog({
                title: "Stakholders Predio "+idgis_item,
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
                title: "Stakholders Predio "+idgis_item,
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


function ver_predio_stakeholders(idgis_item) {

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_predio_persona&idgis_item=' + idgis_item,
        beforeSend: function() {

            $("#nodelist").html('<img src="../../../img/bar-ajax-loader.gif" />');




        },
        success: function(data) {

            $("#nodelist").html(data);


        }
    });
}


function modal_ver_predio_entidad(entidad,identidad,idmodulo) {

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_reporte_predio_entidad&entidad='+entidad+'&identidad='+identidad+'&idmodulo='+idmodulo,
        beforeSend: function() {

            $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');

            $("#pantalla_aux_principal").dialog({
                title: "Stakholders Predio "+entidad+" "+identidad+"-"+idmodulo,
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
                title: "Stakholders Predio "+entidad+" "+identidad+"-"+idmodulo,
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

function ver_predio_entidad(entidad) {
    var intensidad=0;
    var fid_string = $("#fid_string").val();

    if(entidad=='Interaccion' || entidad=='Compromiso' || entidad=='Reclamo'){
        intensidad=1;
    }

    //alert('intensidad : '+intensidad);

    $.ajax({
        url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_predio_entidad&fid_string='+fid_string+'&intensidad='+intensidad,
        beforeSend: function() {

            $("#pantalla_aux_principal").html('<img src="../../../img/bar-ajax-loader.gif" />');

            $("#pantalla_aux_principal").dialog({
                title: "Stakholders Predio "+entidad,
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
                title: "Stakholders Predio "+entidad,
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


function vista_avanzada_predio(idpredio,idmodulo_predio,nombre) {

        $.ajax({
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_predio_stakolder_complejo&idpredio=' + idpredio+'&idmodulo_predio='+idmodulo_predio,
            beforeSend: function() {
                $("#pantalla_aux_principal").dialog({
                    title: $("<label>Predio - "+nombre+" </label>").html(),
                    autoOpen: false,
                    height: "auto",
                    width: "auto",
                    modal: true,
                    position: ['center', 'center'],
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
                $("#pantalla_aux_principal").dialog("open");
                $("#pantalla_aux_principal").center();

            },
            success: function(datos) {
                $("#pantalla_aux_principal").dialog("close");
                $("#pantalla_aux_principal").dialog({
                    title: $("<label>Predio - "+nombre+"</label>").html(),
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
                $("#pantalla_aux_principal").dialog("open");
                $("#pantalla_aux_principal").center();

            }
        });



}


function borrar_predio_sh_tag() {
    $("#buscar_predio_tag").val("");
}



function busqueda_rapida_sh_predio_tag(idtag_entidad) {
    var idpersona = $("#idpersona").val();
    var idmodulo = $("#idmodulo").val();


    $("#buscar_predio_tag").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
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
                    $("#img_buscar_predio").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    $("#img_buscar_predio").attr("src","../../../img/serach.png");

                }
            });
        },
        focus: function(event, ui) {
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#buscar_predio_tag").val("");
            if(b.item.value!='nuevo_tag')
                agrega_celda_tag('predio_tag', b.item, 'idpredio_complejo_tag', 'nume_celda_predio_tag', 'nume_fila_predio_tag');
            return false;
        }
    });
}


function recargar_mapa(){
    var idmapa= $("#idmapa").val();
    var fid_string=$("#fid_string_query").val();
    var intensidad=0;

    //predio
    var idpredio = $("#predio").val();
    var idmodulo_predio = $("#idmodulo_predio").val();

    if($("#intensidad").length ){
        intensidad=1;
    }

    if ( $("#form_tag_sh").length){
        //you can now reuse  $myDiv here, without having to select it again.
        checkAllClass('form_tag_sh', false, 'tags_sh');
        checkAllClass('form_tag_sh', false, 'tags');
        checkAllClass('form_tag_sh', false, 'tags_predio');
    }
    if(typeof(idpredio) != "undefined"){
         $.ajax({
            type: "POST",
            url: '../../../programas/prediop/predio/apredio.php?op_predio=ver_editar_predio_map&fid_string='+fid_string+'&presenta=1&idmapa='+idmapa+'&idpredio='+idpredio+'&idmodulo_predio='+idmodulo_predio,
            beforeSend: function() {
                $("#ui-tabs-4").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

            },
            error: function(objeto, quepaso, otro) {
                //alert(objeto.responseText);
                alert(otro);
            },
            success: function(datos) {

                //$("#resultado_persona").html(datos);
                $("#ui-tabs-4").html(datos);




            }
        });

    }else{
    if($('#ui-tabs-4').is(':visible')){
        var idpersona = $("#idpersona").val();
        var idmodulo = $("#idmodulo").val();

        $.ajax({
            type: "POST",
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_editar_predio_stakeholder&fid_string='+fid_string+'&presenta=1&idmapa='+idmapa+'&idpersona='+idpersona+'&idmodulo='+idmodulo,
            beforeSend: function() {
                $("#ui-tabs-4").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

            },
            error: function(objeto, quepaso, otro) {
                //alert(objeto.responseText);
                alert(otro);
            },
            success: function(datos) {

                //$("#resultado_persona").html(datos);
                $("#ui-tabs-4").html(datos);




            }
        });

    }else{

        $.ajax({
            type: "POST",
            url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_buscar_mapa&fid_string='+fid_string+'&presenta=1&idmapa='+idmapa+'&intensidad='+intensidad,
            beforeSend: function() {
                $("#ver_buscar_mapa").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

            },
            error: function(objeto, quepaso, otro) {
                //alert(objeto.responseText);
                alert(otro);
            },
            success: function(datos) {

                //$("#resultado_persona").html(datos);
                $("#ver_buscar_mapa").html(datos);




            }
        });

    }
}
}

function checkAllClass(formname, checktoggle, clase)
{
  var checkboxes = new Array();
  checkboxes = document[formname].getElementsByTagName('input');

  for (var i=0; i<checkboxes.length; i++)  {
    //console.log(checkboxes[i].className + ' == ' +clase);
    if (checkboxes[i].type == 'checkbox'  && checkboxes[i].className == clase)   {

      checkboxes[i].checked = checktoggle;


       }
    }
  }

  function recargar_intensidad(){
      var flag=false;
      if($("#intensidad").length && $("#intensidad").is(':checked')){
          flag=true;
      }
      aplicar_intensidad(flag);
  }
















