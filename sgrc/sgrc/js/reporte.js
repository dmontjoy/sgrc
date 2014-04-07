function consultar_reporte_estadistico(){
    var datastring = $("#form_consulta_reporte_estadistico").serialize();
  
     $.ajax({
        type:"POST",
        data: datastring,
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_reporte_estadistico&vista_reporte=0',
        beforeSend: function(xhr) {
            $("#bloque_izq").html('<img src="../../../img/loading.gif" />');
            $("#bloque_der").html('');
        },
        success: function(data) {
            $("#bloque_izq").html(data);

        }
    });
}


function consultar_reporte_estadistico_avanzado(){
    $('#rango_reporte').prop("selectedIndex",0);
   
    var datastring = $("#form_consulta_reporte_estadistico").serialize();
     $.ajax({
        type:"POST",
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_reporte_estadistico&vista_reporte=0',
        data: datastring,
        beforeSend: function(xhr) {
            $("#bloque_izq").html('<img src="../../../img/bar-ajax-loader.gif" />');
            $("#bloque_der").html('');
        },
        error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);
            },
        success: function(datos) {
            $("#bloque_izq").html(datos);
            $("#bloque_der").html('');

        }
    });
}   

function reporte_ver_mas_stakeholder(fecha_del,fecha_al){
    var datastring = $("#form_consulta_reporte_estadistico").serialize();
     $.ajax({
        type:"POST",
        data: datastring,
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_mas_stakeholder',
        beforeSend: function(xhr) {
            $("#bloque_der").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
        error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);
            },
        success: function(data) {
            $("#bloque_der").html(data);

        }
    });
}
function reporte_ver_mas_interaccion(fecha_del,fecha_al){
    var datastring = $("#form_consulta_reporte_estadistico").serialize();
     $.ajax({
        type:"POST",
        data: datastring,
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_mas_interaccion',
        beforeSend: function(xhr) {
            $("#bloque_der").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);
            },
        success: function(data) {
            $("#bloque_der").html(data);

        }
    });
}


function reporte_ver_mas_rc(fecha_del,fecha_al){
    var datastring = $("#form_consulta_reporte_estadistico").serialize();
     $.ajax({
        type:"POST",
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_mas_usuario',
        data: datastring,
         error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);
            },
         beforeSend: function(xhr) {
            $("#bloque_der").html('<img src="../../../img/bar-ajax-loader.gif" />');

        },
        success: function(data) {
            $("#bloque_der").html(data);

        }
    });
}
function reporte_ver_mas_tag(fecha_del, tabla, fecha_al){
    var datastring = $("#form_consulta_reporte_estadistico").serialize();
     $.ajax({
        type:"POST",
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_mas_tag&tabla='+tabla,
        dataType: 'json',
        data: datastring,
        error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);
            },
        beforeSend: function(xhr) {
            $("#bloque_der").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {
            $("#bloque_der").html('<table id="list"></table><div id="pager"></div>');
            
            var flag=false;
            
            if(tabla=='Interaccion-Tag-SH'){
                flag=true;
            }
            
            jQuery("#list").jqGrid({ 
                datastr: data.datos,
                datatype: "jsonstring",
                height: "auto",
                //loadui: "disable",
                gridview: true,               
                autowidth: true,
                colNames:['id','Tag','Cantidad','Porcentaje'], 
                colModel:[  
                            {name: "id",index:'id',width:1, hidden:true, key:true},
                            {name:'tag',index:'tag',width:40, sorttype:'text'},
                            {name:'cantidad',index:'cantidad',width:20,align:'center',hidden:flag, sorttype:'number'},
                            {name:'porcentaje',index:'porcentaje',width:40, sorttype:'text'},
                        ],
                treeGrid: true,
                treeGridModel: "adjacency",
                treedatatype:"local",
                ExpandColumn: "tag",                
                rowNum: 10000,
                 pager: '#pager',
                
                 caption: data.titulo,
                 treeIcons: {leaf:'ui-icon-document-b'},
                jsonReader: {
                    repeatitems: false,
                    root: function (obj) { return obj; },
                    page: function (obj) { return 1; },
                    total: function (obj) { return 1; },
                    records: function (obj) { return obj.length; }
                },
                loadComplete: function() {
                    var i=0, indexes = this.p._index, localdata = this.p.data,
                        rows=this.rows, rowsCount = rows.length, row, rowid, rowData, className;

                    for(;i<rowsCount;i++) {
                        row = rows[i];
                        className = row.className;
                        //if ($(row).hasClass('jqgrow')) { // test for standard row
                        if (className.indexOf('jqgrow') !== -1) {
                            rowid = row.id;
                            rowData = localdata[indexes[rowid]];
                            if (rowData.level % 3 == 1) {
                                // if (!$(row).hasClass('ui-state-disabled')) {
                                /*
                                if (className.indexOf('level-1') === -1) {
                                    row.className = className + ' level-1 ';
                                }*/
                                $("#"+rowid).css("background", "#ffbf87");
                                //$(row).addClass('ui-state-disabled');
                            }else if(rowData.level % 3 == 2){
                            
                                $("#"+rowid).css("background", "#dbedfc");
                            
                            }else{
                            
                            }
                        }
                    }
                }
            }); 
        
        if(!flag){
            jQuery("#list").jqGrid('setGroupHeaders', {
                useColSpanStyle: true, 
                groupHeaders:[
                      {startColumnName: 'tag', numberOfColumns: 3, titleText: data.resumen}
                ]	
              });
        }
    
        }
    });
}


function ver_datos_stakeholder(idpersona_compuesto){
    $("#idhtml_tab_stakeholder").html("");
    if($("#pantalla_aux_principal").hasClass('ui-dialog-content') && $("#pantalla_aux_principal").dialog('isOpen')){
        $("#pantalla_aux_principal").dialog("close");
    }
    if($("#modal_interaccion").hasClass('ui-dialog-content') &&  $("#modal_interaccion").dialog('isOpen')){
        $("#modal_interaccion").dialog("close");
    }
    ver_cabecera_stakeholder(idpersona_compuesto);
    ver_tab_stakeholder(idpersona_compuesto);
}



function modal_reporte_tag_stakeholder_interaccion() {
    
    
    $("#idhtml_tab_stakeholder").html(''); 
    $("#idhtml_cabecera_stakeholder").html('');
    $("#idhtml_cabecera_stakeholder").append("<div id=\"X\" style=\" z-index: 1000; position: absolute; left:50px; top:165px; \"><form id=\"form_tag_sh\" ><table id=\"list2\"></table></form><div   id=\"ptreegrid2\"></div></div><div id=\"Y\" style=\" z-index: 1000; position: absolute; right:50px; top:165px; \"><form id=\"form_tag\" name=\"form_tag\" ><table id=\"list1\"></table></form><div   id=\"ptreegrid1\"></div></div><table align=\"center\"><tbody><tr><td><label for=\"from\">Del</label><input type=\"text\" id=\"hfecha1\" name=\"fecha_del\" value=\"\"></td><td><label for=\"to\">Al</label><input type=\"text\" id=\"hfecha2\" name=\"fecha_al\" value=\"\" ></td><td colspan=\"2\" align=\"center\"><button id=\"boton_filtro\" type=\"button\" onclick=\"reporte_tag_stakeholder_interaccion()\">Aplicar Filtro</button></td></tr></tbody></table><div id=\"container\" style=\"border-spacing: 2px; border-color: gray; min-width: 800px;   margin: 0 auto\"></div>");
    
    $( "#X" ).draggable();
    $( "#Y" ).draggable();
    
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
    
    $("#hfecha1").datepicker("option", "maxDate", $("#hfecha2").val());
    $("#hfecha2").datepicker("option", "minDate", $("#hfecha1").val());
    
    var fecha_del = $("#hfecha1").val();
    
    var fecha_al = $("#hfecha2").val();

    $("#boton_filtro").button({
            icons: {
            secondary: "ui-icon-search"
            }
        });
    
    $("#boton_tag").button({
            icons: {
            secondary: "ui-icon-gear"
            }
        });
    
    $.ajax({
        url: '../../../programas/tag/tag/atag.php?op_tag=ver_arbol_tags_check',
        dataType: "json",        
        beforeSend: function() {

            $("#container").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {
            
            //$("#resultado_tag").html(data.html);
            
            
           

            //$('<table id="list2"></table>').appendTo('#resultado_tag');

            var grid2 = jQuery("#list2");
            grid2.jqGrid({
                datastr: data.tags_sh,
                datatype: "jsonstring",
                height: "auto",
                //loadui: "disable",
                gridview: true,
                colNames: ["id"," ", " ","Tag","Ruta"],
                colModel: [
                    {name: "id",index:'id',width:1, hidden:true, key:true},
                    {name:'num',index:'num', width:1,hidden:true, align:'center', sorttype:'number'},
                    {name:'check',index:'check', width:20, align:'center', sorttype:'text'},
                    {name: "tag",index:'tag', width:250, resizable: false, sorttype:'text'},
                    {name: "ruta",index:'ruta', width:250, resizable: false, sorttype:'text'}
                ],
                treeGrid: true,
                treeGridModel: "adjacency",
                treedatatype:"local",
                ExpandColumn: "tag",
                width: 520,
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
                       
   
   
    var grid1 = jQuery("#list1");
            grid1.jqGrid({
                datastr: data.tags,
                datatype: "jsonstring",
                height: "auto",
                //loadui: "disable",
                gridview: true,
                colNames: ["id"," ", " ","Tag","Ruta"],
                colModel: [
                    {name: "id",index:'id',width:1, hidden:true, key:true},
                    {name:'num',index:'num', width:1,hidden:true, align:'center', sorttype:'number'},
                    {name:'check',index:'check', width:20, align:'center', sorttype:'text'},
                    {name: "tag",index:'tag', width:250, resizable: false, sorttype:'text'},
                    {name: "ruta",index:'ruta', width:250, resizable: false, sorttype:'text'}
                ],
                treeGrid: true,
                treeGridModel: "adjacency",
                treedatatype:"local",
                ExpandColumn: "tag",
                width: 520,
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
                       
        }
    });
                       
     reporte_tag_stakeholder_interaccion();


}

function checkAllTags(formname,checktoggle)
{
  var checkboxes = new Array(); 
  checkboxes = document[formname].getElementsByTagName('input');
 
  for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].type == 'checkbox' && checkboxes[i].checked != checktoggle )   {
      //cambiar_serie(checkboxes[i].class);
      
      //alert(checkboxes[i].getAttribute('onclick'));
      eval(checkboxes[i].getAttribute('onclick'));
      console.log(checkboxes[i]);
    }
  }
      
  }
                
       
                
                
function reporte_tag_stakeholder_interaccion() {
    
    
        
    var fecha_del = $("#hfecha1").val();
    
    var fecha_al = $("#hfecha2").val();
    var datastring = $("#form_tag_sh").serialize();

                       
                        $.ajax({
                            url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_reporte_tag_stakeholder_interaccion&rango_reporte=2&vista_reporte=1&fecha_del='+fecha_del+'&fecha_al='+fecha_al,         
                            beforeSend: function(xhr){
                                //$("#bloque_tag").html('');
                                $("#container").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                                    
                            },
                            dataType: "json",
                            data: datastring,
                            success: function(data) {
                                //var data = jQuery.parseJSON(datos); 
                                
                                
                                
                                $("#bloque_tag").html(data.html);
                                $("#container").html(''); 
                                $("#container").height( (data.ticks.length*30)+150 );
                                                                                                                                                                                                                                                               
                                
                                
                                  $('#container').highcharts({
                                            chart: {
                                                type: 'bar',
                                                events: {
                                                    load: function(event) {
                                                        checkAllTags('form_tag',true);  
                                                    }
                                                }   
                                            },
                                            title: {
                                                text: $('<label>Tag - Stakeholder / Interacci&oacute;n</label>').html()
                                            },
                                        
                                            credits: {
                                            enabled: false,
                                            href: 'http://www.highcharts.com',
                                            position: null,
                                            style: null,
                                            },
                                            xAxis: {
                                                categories: data.ticks
                                            },
                                            yAxis: {
                                                min: 0,
                                                title: {
                                                    text: 'Tag Interacciones'
                                                }
                                            },
                                            legend: {
                                                backgroundColor: '#FFFFFF',
                                                reversed: true
                                            },
                                            tooltip: {
                                                useHtml:true,
                                                formatter: function() {
                                                    	
                                                    return '<span style="font-weight:bold;color:'+this.series.color+';">'+ this.series.name +'</span>: se '+$('<label>trat&oacute;</label>').html()+' <b>'+this.y+'</b> veces ('+ Highcharts.numberFormat(this.percentage, 2) +'%) de un total de <b>'+this.total+'</b> temas en <b>'+this.point.options.interacciones+'</b> interacciones.';
                                                }

                                            },
                                            plotOptions: {
                                                series: {
                                                    stacking: 'normal'
                                                },
                                                bar: {
                                                    dataLabels: {
                                                        enabled: true,
                                                        color:'#FFFFFF',
                                                        formatter: function() {
                                                            var chart = $('#container').highcharts();
                                                            
                                                            if(chart.series[this.point.options.m].data[this.point.options.n].shapeArgs.height>180){
                                                                return +this.y+' ('+ Highcharts.numberFormat(this.percentage, 0) +'%) '+this.total+' temas '+this.point.options.interacciones+' int.';
                                                            }else if(chart.series[this.point.options.m].data[this.point.options.n].shapeArgs.height>150){
                                                                return +this.y+' ('+ Highcharts.numberFormat(this.percentage, 0) +'%) '+this.total+' temas ';
                                                            }else if(chart.series[this.point.options.m].data[this.point.options.n].shapeArgs.height>100){
                                                                return +this.y+' ('+ Highcharts.numberFormat(this.percentage, 0) +'%) ';
                                                            }else if(chart.series[this.point.options.m].data[this.point.options.n].shapeArgs.height>40){
                                                                return +this.y;
                                                            }else{

                                                                return '';
                                                            }
                                                            
                                                            
                                                        
                                                        }
                                                    }
                                                 }
                                            },
                                                series: data.datos,
                                               
                                                    exporting: {
                                                        sourceWidth: 1200,
                                                        sourceHeight: 600,
                                                        // scale: 2 (default)
                                                        chartOptions: {
                                                            subtitle: null
                                                        }
                                                    }
                                        });
                                    var chart = $('#container').highcharts();
                                    console.log(chart);
                                    
                                     
                                                                        
                                
                            }
                        });
                    
                   ;


                    }
                

function actualiza_estado_tag(nombre_celda,tag) {
    
    var n, valor_nombre_celda;
    //alert('id' + nombre_celda);
    valor_nombre_celda = document.getElementById('id' + nombre_celda).value;
    
    var aux=0;
    
    if (valor_nombre_celda.indexOf('-') != -1) {       
        valor_nombre_celda = "";
        document.getElementById('id' + nombre_celda).value = valor_nombre_celda;
        cambiar_categoria(tag);
    }else{
        valor_nombre_celda = nombre_celda;
        document.getElementById('id' + nombre_celda).value = valor_nombre_celda;
        reporte_tag_stakeholder_interaccion();
    }
    
    
    
}

                
                
function cambiar_categoria(categoria){
    
    var chart = $('#container').highcharts();
    var i,j,pos,cant;
    var categorias;
    categorias = Array();
    i=0;
    j=0;
    pos=-1;
    
    while(i<chart.xAxis[0].categories.length){
        
        if(chart.xAxis[0].categories[i]==categoria){           
            pos=i;            
        }else{
            categorias[j]=chart.xAxis[0].categories[i];
            j++;
        }        
        i++;
    }

    cant=j;

    if(pos>=0){
    
        chart.xAxis[0].setCategories(categorias,false);

        for(i=0;i<chart.series.length;i++){
            var datos = Array();
            var k;
            k=0;
            //console.log(chart.series[i].data[pos]);
            //console.log("\n");
            /*
            if(chart.series[i].data[pos].graphic.visibility=="hidden")
                chart.series[i].data[pos].graphic.show();
            else
                chart.series[i].data[pos].graphic.hide();
            */
            for(j=0;j<chart.series[i].data.length;j++){

                   if(j!=pos){
                       datos[k]={m:0,n:0,y:0,interacciones:0};
                       datos[k].y=chart.series[i].data[j].y;
                       datos[k].m=i;
                       datos[k].n=k;
                       datos[k].interacciones=chart.series[i].data[j].interacciones;
                       k++;
                   }        

             }
            chart.series[i].setData(datos, false);
        }
        
        //console.log(chart);
        chart.setSize(chart.chartWidth, chart.chartHeight- ((chart.chartHeight-150)/cant));

        //chart.redraw();
        
    }
}                         


function cambiar_serie(serie){
    
    var chart = $('#container').highcharts();
    var j;
    
    for(j=0;j<chart.series.length;j++){
           //console.log(chart.series[j]);
           if(chart.series[j].name==serie){
              
                if(chart.series[j].visible){
                    chart.series[j].hide();
                }else{
                    chart.series[j].show();
                }    
           }        

     }
}

function modal_reporte_estadistico_busca_rapida(tag) {
                       
    $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_reporte_estadistico&rango_reporte=2&vista_reporte=1&idestadistico_complejo_tag='+tag,
        beforeSend: function(xhr){
            $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
            $("#idhtml_tab_stakeholder").html('');  

        },
        success: function(datos) {
 
            $("#idhtml_cabecera_stakeholder").html(datos);
        }
    });
             
} 
             
function modal_reporte_estadistico() {
                       
    $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_reporte_estadistico&rango_reporte=2&vista_reporte=1',
        beforeSend: function(xhr){
            $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
            $("#idhtml_tab_stakeholder").html('');  

        },
        success: function(datos) {
 
            $("#idhtml_cabecera_stakeholder").html(datos);
        }
    });
             
}   
                    
                    
function modal_reporte_tag_interaccion_relevancia() {
                       
                        $.ajax({
                            url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_reporte_tag_interaccion',
                            dataType: 'json',
                            beforeSend: function(xhr){
                                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                                $("#idhtml_tab_stakeholder").html('');  
                                    
                            },
                            success: function(datos) {
                                                        
                                $("#idhtml_cabecera_stakeholder").html("<div id=\"resultado_tag_interaccion\"></div>");
                                $("#resultado_tag_interaccion").html("<br/><table id='lista'></table><div id='pager'></div>");
                                jQuery("#lista").jqGrid({ 
                                    datatype: "local",
                                    data: datos.data,
                                    height: "100%", 
                                    width: "850", 
                                    shrinkToFit:false,
                                    colNames:['Tag',' 1&ordm; ','Porcentaje 1&ordm;',' 2&ordm; ','Porcentaje 2&ordm;',' 3&ordm; ','Porcentaje 3&ordm;',' >3&ordm; ','Porcentaje >3&ordm;',' 0&ordm; ','Porcentaje 0&ordm;'], 
                                    colModel:[  
                                                {name:'tag',index:'tag', width:200, sorttype:"text"},
                                                {name:'primero',index:'primero', width:50, sorttype:"number",align:"right"},
                                                {name:'porcentaje1',index:'porcentaje1', width:150, sorttype:"text"},
                                                {name:'segundo',index:'segundo', width:50, sorttype:"number",align:"right"},
                                                {name:'porcentaje2',index:'porcentaje2', width:150, sorttype:"text"},
                                                {name:'tercero',index:'tercero', width:50, sorttype:"number",align:"right"},
                                                {name:'porcentaje3',index:'porcentaje3', width:150, sorttype:"text"},
                                                {name:'cuarto',index:'cuarto', width:50, sorttype:"number",align:"right"},
                                                {name:'porcentaje4',index:'porcentaje4', width:150, sorttype:"text"},
                                                 {name:'cero',index:'cero', width:50, sorttype:"number",align:"right"},
                                                {name:'porcentaje0',index:'porcentaje0', width:150, sorttype:"text"}
                                                
                                            ],
                                     rowNum:20,
                                     rowList:[10,20,30],
                                     pager: '#pager', 
                                     rownumWidth: 30,
                                     sortname: 'primero',
                                     sortorder: 'desc',
                                     viewrecords: true,
                                     gridview:true,
                                     loadonce: true,
                                     caption: 'Tags por relevancia',
                                    
                                    footerrow: true
                                }); 

                                jQuery("#lista").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,defaultSearch : "cn"});
                                jQuery("#lista").jqGrid('footerData','set', {tag: 'Total:', primero: datos.primero, segundo: datos.segundo, tercero: datos.tercero, cuarto: datos.cuarto, cero: datos.cero});
            
                                
                            }
                        });
                    
                   ;


                    }   



 function modal_reporte_posicion_importancia() {
     
     
     
     
     
     
     
     
     
                        $.ajax({
                            url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=posicion_importancia',
                            beforeSend: function() {
                                
                                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                                $("#idhtml_tab_stakeholder").html('');

                            },
                            success: function(datos) {
                               
                                $("#idhtml_cabecera_stakeholder").html(datos);
                              
                            }
                        });


                    }
                
                
 function modal_reporte_posicion_tiempo() {
                        $.ajax({
                            url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_posicion_tiempo',
                            beforeSend: function() {
                                
                                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                                $("#idhtml_tab_stakeholder").html('');
                                
                            },
                            success: function(datos) {
                               
                                $("#idhtml_cabecera_stakeholder").html(datos);
                               
                            }
                        });


                    }
                
                
function modal_reporte_interaccion_tiempo() {
                        $.ajax({
                            url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_interaccion_tiempo',
                            beforeSend: function() {
                                
                                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                                $("#idhtml_tab_stakeholder").html('');
                                
                            },
                            success: function(datos) {
                               
                                $("#idhtml_cabecera_stakeholder").html(datos);
                               
                            }
                        });


                    }                
      
                
                
                    function modal_reporte_interes_poder() {

                        $.ajax({
                            url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=interes_poder',
                            beforeSend: function() {
                                
                                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                                $("#idhtml_tab_stakeholder").html('');
                                

                            }, success: function(datos) {
                               
                                $("#idhtml_cabecera_stakeholder").html(datos);
                               
                            }
                        });
                    }


function cargar_stakeholder_posicion_importancia(x1, y1, x2, y2) {
    var datastring = $("#form_modal_importancia").serialize();

    $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=listar_sh_importancia&x1=' + x1 + '&x2=' + x2 + '&y1=' + y1 + '&y2=' + y2,
        data: datastring,
        dataType: "json",
        beforeSend: function() {
            $("#listado").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {
            
            $("#listado").html("<br/><table id='lista_sh_importancia'></table><div id='pager'></div>");
            jQuery("#lista_sh_importancia").jqGrid({ 
                datatype: "local",
                data: data,
                height: "100%", 
                width: "700", 
                colNames:['Ap. Paterno','Ap. Materno','Nombre','Importancia','Posici&oacute;n'], 
                colModel:[  
                            {name:'paterno',index:'paterno', width:100, sorttype:"text"},
                            {name:'materno',index:'materno', width:100, sorttype:"text"},
                            {name:'nombre',index:'nombre', width:100, sorttype:"text"},
                            {name:'importancia',index:'importancia', width:50, sorttype:"int"},
                            {name:'posicion',index:'posicion', width:50, sorttype:"int"}
                        ],
                 rowNum:20,
                 rowList:[10,20,30],
                 pager: '#pager',
                 rownumbers: true, 
                 rownumWidth: 30,
                 sortname: 'importancia',
                 sortorder: 'desc',
                 viewrecords: true,
                 gridview:true
            }); 
            
            jQuery("#lista_sh_importancia").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,defaultSearch : "cn"});
            
        }
    });

}

 function cargar_stakeholders(x1, y1, z1, x2, y2, z2) {
      var datastring = $("#form_modal_poder").serialize();

    $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=listar_sh_cuadrante&x1=' + x1 + '&x2=' + x2 + '&y1=' + y1 + '&y2=' + y2 + '&z1=' + z1 + '&z2=' + z2,
        data: datastring,
        dataType: "json",
        beforeSend: function() {
            $("#listado").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {
            $("#listado").html("<br/><table id='lista_sh'></table><div id='pager'></div>");
            jQuery("#lista_sh").jqGrid({ 
                datatype: "local",
                data: data,
                height: "100%", 
                width: "700", 
                colNames:['Ap. Paterno','Ap. Materno','Nombre','Importancia','Poder','Inter&eacute;s'], 
                colModel:[  
                            {name:'paterno',index:'paterno', width:100, sorttype:"text"},
                            {name:'materno',index:'materno', width:100, sorttype:"text"},
                            {name:'nombre',index:'nombre', width:100, sorttype:"text"},
                            {name:'importancia',index:'importancia', width:50, sorttype:"int"},
                            {name:'poder',index:'poder', width:50, sorttype:"int"},
                            {name:'interes',index:'interes', width:50, sorttype:"int"}
                        ],
                 rowNum:20,
                 rowList:[10,20,30],
                 pager: '#pager',
                 rownumbers: true, 
                 rownumWidth: 30,
                 sortname: 'importancia',
                 sortorder: 'desc',
                 viewrecords: true,
                 gridview:true
            }); 
            
            jQuery("#lista_sh").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,defaultSearch : "cn"});
            
        }
    });

}

function buscar_reporte_poder(){
    var datastring = $("#form_modal_poder").serialize();
        $.ajax({
            url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=interes_poder&tipo=1',
            data: datastring,
            beforeSend: function() {
                
                $("#reporte_poder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                


            }, success: function(datos) {
                
                $("#reporte_poder").html(datos);
               
            }
        });
    

    
}

function buscar_reporte_importancia(){
    var datastring = $("#form_modal_importancia").serialize();
        $.ajax({
            url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=posicion_importancia&tipo=1',
            data: datastring,
            beforeSend: function() {
                
                $("#reporte_importancia").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                


            }, success: function(datos) {
                
                $("#reporte_importancia").html(datos);
               
            }
        });
    

    
}

function cambiar_rango_posicion_tiempo(){    
    var rango_posicion_tiempo = $("#rango_posicion_tiempo").val();
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1; //Months are zero based
    var year = date.getFullYear()-rango_posicion_tiempo;
    
     $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=obtener_posicion_tiempo&rango_posicion_tiempo='+rango_posicion_tiempo,
        dataType: "json",
        beforeSend: function() {
            $("#placeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(datos) {
                              
             var plot = $.plot($("#placeholder"),
           [ { data: datos.data, label: "Promedio"} ], {
               series: {
                   lines: { show: true },
                   points: { show: true }
               },
               grid: { hoverable: true, clickable: false,show:true,backgroundColor: { colors: ["#EDF5FF", "#ffffff"] }},
               
                xaxis: { mode:"time",timeformat:"%m/%Y",tickSize: [3, "month"] ,min: (new Date(year+"/"+month+"/"+day)).getTime(),max: date.getTime()  },
                yaxis: { min: 1, max: 5, tickDecimals: 0 }
             });
         
        // $(".x1Axis").append("<div style=\"position:absolute;text-align:center;left:640px;top:286px;width:116px\" class=\"tickLabel\">"+customFormat("#MM#/#YYYY#",date)+"</div>");
         
         function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css( {
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 5,
                border: '1px solid #fdd',
                padding: '2px',
                'background-color': '#fee',
                opacity: 0.80
            }).appendTo("body").fadeIn(200);
        }

            var previousPoint = null;
            $("#placeholder").bind("plothover", function (event, pos, item) {


                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);
                            ;
                        var date = new Date();

                        date.setTime(x);

                        showTooltip(item.pageX, item.pageY,
                                    //item.series.label + " " + y + " al " + customFormat("#DD#/#MM#/#YYYY#",date));
                                    "<div><strong>Fecha:</strong> " + customFormat("#DD#/#MM#/#YYYY#",date) + "</div>" +
                                    "<div><strong>Posici&oacute;n:</strong> " + y + "</div>" +
                                    "<div><strong>Ratio:</strong> " + datos.ratio[item.dataIndex] + "</div>"  );
                    }
                }
                else {
                    $("#tooltip").remove();
                    previousPoint = null;            
                }

            });

           
        }
    });

      
}


function cambiar_rango_interaccion_tiempo(){    
    var rango_interaccion_tiempo = $("#rango_interaccion_tiempo").val();
    var idpersona_compuesto = $("#idpersona_compuesto").val();
    
   
    
     $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=obtener_interaccion_tiempo&rango_interaccion_tiempo='+rango_interaccion_tiempo+'&idpersona_compuesto='+idpersona_compuesto,
        dataType: "json",
        beforeSend: function() {
            $("#placeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(datos) {
    
            $('#placeholder').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: datos.x,
                title: {
                    text: 'Fecha',
                    align: 'high',
                    rotation: 0,
                    textAlign: 'right',
                    x: -10,
                    y: -10
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Interacciones',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' interacciones'
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Total',
                data: datos.y
            }]
        });
          
           
        }
    });


    
    
   
      
}

function cambiar_rango_interaccion_tiempo_tag(){    
    var rango_interaccion_tiempo = $("#rango_interaccion_tiempo").val();
    var idpersona_compuesto = $("#idpersona_compuesto").val();
    
   
    
     $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=obtener_interaccion_tiempo_tag&rango_interaccion_tiempo='+rango_interaccion_tiempo+'&idpersona_compuesto='+idpersona_compuesto,
        dataType: "json",
        beforeSend: function() {
            $("#placeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(datos) {
    
            $('#placeholder').highcharts({
            chart: {
                type: 'column'
            },title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: datos.categorias,
                title: {
                    text: 'Fecha',
                    align: 'high',
                    rotation: 0,
                    textAlign: 'right',
                    x: -10,
                    y: -10
                }
            },
            yAxis: {
                min: 1,
                title: {
                    text: 'Interacciones'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                        formatter: function() {
                           if(this.y>0)
                                return this.y;
                           else
                               return '';
                        
                       }   
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: datos.series
        });
          
           
        }
    });


    
    
   
      
}


function modal_reclamo_estadistico() {
                       
        $.ajax({
            url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_reclamo_estadistico&rango_reporte=2&vista_reporte=1',
            beforeSend: function(xhr){
                $("#idhtml_cabecera_stakeholder").html('<br/><div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');
                $("#idhtml_tab_stakeholder").html('');  

            },
            success: function(datos) {

                $("#idhtml_cabecera_stakeholder").html(datos);

            }
        });

   ;


}


function consultar_reclamo_estadistico(){
    var value=$("#rango_reporte").val();
     $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_reclamo_estadistico&rango_reporte='+value+'&vista_reporte=0',
        beforeSend: function(xhr) {
            $("#bloque_izq").html('<img src="../../../img/bar-ajax-loader.gif">');
            $("#bloque_der").html('');
        },
        success: function(data) {
            $("#bloque_izq").html(data);

        }
    });
}



function reporte_ver_mas_tag_reclamo(fecha){
     $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_mas_tag_reclamo&fecha_reporte='+fecha,
        beforeSend: function(xhr) {
            $("#bloque_der").html('<div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {
            $("#bloque_der").html(data);

        }
    });
}

function reporte_ver_estado_fase_reclamo(fecha,idfase){
     $.ajax({
        url: '../../../programas/reporte/stakeholder/areporte.php?op_reporte=ver_estado_fase_reclamo&idfase='+idfase+'&fecha_reporte='+fecha,
        beforeSend: function(xhr) {
            $("#bloque_der").html('<div style="margin:0px auto;text-align: center;"><img src="../../../img/bar-ajax-loader.gif"></div>');

        },
        success: function(data) {
            $("#bloque_der").html(data);

        }
    });
}


function busqueda_rapida_persona_buscar() {

    $("#reclamo_rc1_buscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
        dataType: "json",
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                data: {
                    busca_rapida: request.term
                },
                url: '../../../programas/persona/persona/apersona.php?op_persona=busqueda_rapida',
                beforeSend: function() {
                    $("#img_buscar_reclamo_rc1").attr("src","../../../img/ajax-loader.png");

                },
                success: function(datos) {
                    //$("#mensaje").val(datos);
                    response($.map(datos, function(item) {
                        return{
                            label: item.label,
                            value: item.value
                        }
                    }));
                    
                    $("#img_buscar_reclamo_rc1").attr("src","../../../img/serach.png");
               
                }
            });
        },
        focus: function(event, ui) {
            //$("#stakeholder_buscar").val(ui.item.label);
            event.preventDefault();
            return false;
        },
        select: function(a, b) {
            $("#reclamo_rc1_buscar").val("");

            if (b.item.value == 'nuevo_stake_holder') {
                //alert("entra");
            } else {
                //alert (b.item.label+" "+b.item.value);
                $("#reclamo_receptor").html(b.item.label+"<img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" style=\"margin-left:10px;vertical-align: middle;\" onclick=\"borrar_receptor()\">" + 
                    "<input type=\"hidden\" name=\"idpersona_compuesto\" id=\"idpersona_compuesto\" value=\""+b.item.value+"\"/>");
                $("#count_receptor").val(1);
                
                eval($("#rango_interaccion_tiempo").attr("onChange"));
                
                return false;

            }

            return false;
        }
    });
}