// JavaScript Document

//
function agrega_celda_hogar(tabla, datos, adatos, nume_celda, nume_fila, contador) {

    var TABLE = document.getElementById(tabla);
    //if(TABLE==null)alert(tabla);
    var nume_celda_element = document.getElementById(nume_celda);
    //if(nume_celda_element==null)alert(nume_celda);
    var nume_fila_element = document.getElementById(nume_fila);
    //if(nume_fila_element==null)alert(nume_fila);
    
    copyCeldaHogar(tabla, 1, datos, adatos, nume_celda_element, nume_fila_element,contador);
    
    if( typeof contador != "undefined" ){
    //do something since x is defined.
        var cant = parseInt(document.getElementById(contador).value);
        cant= cant + 1;
        document.getElementById(contador).value=cant;
    }

}
function agrega_celda(tabla, datos, adatos, nume_celda, nume_fila, contador) {

    var TABLE = document.getElementById(tabla);
    //if(TABLE==null)alert(tabla);
    var nume_celda_element = document.getElementById(nume_celda);
    //if(nume_celda_element==null)alert(nume_celda);
    var nume_fila_element = document.getElementById(nume_fila);
    //if(nume_fila_element==null)alert(nume_fila);
    
    copyCelda(tabla, 5, datos, adatos, nume_celda_element, nume_fila_element,contador);
    
    if( typeof contador != "undefined" ){
    //do something since x is defined.
        var cant = parseInt(document.getElementById(contador).value);
        cant= cant + 1;
        document.getElementById(contador).value=cant;
    }

}

function agrega_celda_tag(tabla, datos, adatos, nume_celda, nume_fila, contador) {

    var TABLE = document.getElementById(tabla);
    //if(TABLE==null)alert(tabla);
    var nume_celda_element = document.getElementById(nume_celda);
    //if(nume_celda_element==null)alert(nume_celda);
    var nume_fila_element = document.getElementById(nume_fila);
    //if(nume_fila_element==null)alert(nume_fila);
    copyCeldaTag(tabla, 5, datos, adatos, nume_celda_element, nume_fila_element,contador);
    
    if( typeof contador != "undefined" ){
    //do something since x is defined.
        var cant = parseInt(document.getElementById(contador).value);
        cant= cant + 1;
        document.getElementById(contador).value=cant;
    }

}

function agrega_celda_rc(tabla, datos, adatos, nume_celda, nume_fila, contador) {

    var TABLE = document.getElementById(tabla);
    //if(TABLE==null)alert(tabla);
    var nume_celda_element = document.getElementById(nume_celda);
    //if(nume_celda_element==null)alert(nume_celda);
    var nume_fila_element = document.getElementById(nume_fila);
    //if(nume_fila_element==null)alert(nume_fila);
    copyCeldaRC(tabla, 1, datos, adatos, nume_celda_element, nume_fila_element,contador);
    
    if( typeof contador != "undefined" ){
    //do something since x is defined.
        var cant = parseInt(document.getElementById(contador).value);
        cant= cant + 1;
        document.getElementById(contador).value=cant;
    }

}


function disminuye_celda(nombre_celda, contador) {
    var n, valor_nombre_celda;
    //alert('id' + nombre_celda);
    valor_nombre_celda = document.getElementById('id' + nombre_celda).value;
    //alert(nombre_celda);
    var aux=0;
    
    if (valor_nombre_celda.indexOf('***') != -1) {
        n = valor_nombre_celda.split('***');
        if (n[2] == 0) {
            n[2] = 1;
            document.getElementById(nombre_celda).className = "";
            aux=1;
        } else {
            n[2] = 0;
            document.getElementById(nombre_celda).className = "tachado";
            aux=-1;
        }
        valor_nombre_celda = n[0] + "***" + n[1] + "***" + n[2];
    } else {
        if (valor_nombre_celda.indexOf('###') == -1) {

            valor_nombre_celda = valor_nombre_celda + "###0";
            
            document.getElementById(nombre_celda).className = "tachado";
            aux=-1;
        } else {
            n = valor_nombre_celda.split('###');
            valor_nombre_celda = n[0];
            aux=1;
            document.getElementById(nombre_celda).className = "";

        }

    }
    document.getElementById('id' + nombre_celda).value = valor_nombre_celda;
    
    //document.getElementById('e'+nombre_celda).innerHTML="&nbsp;";
    if( typeof contador != "undefined" ){
    //do something since x is defined.
        
        var elem = document.getElementById(contador);
        if(typeof elem !== 'undefined' && elem !== null) {
          var cant = parseInt(document.getElementById(contador).value);
            cant= cant + aux;
            document.getElementById(contador).value=cant;
        }
    }
}

function appendCellCelda(Trow, txt, nombre_celda, opcion,length) {

    var newCell = Trow.insertCell(Trow.cells.length)

    //newCell.className="celdaSimple";

    newCell.innerHTML = txt

    newCell.id = nombre_celda;

    newCell.name = nombre_celda;
    
    newCell.width = length+"%";
    
    newCell.align=opcion;
    
}

function copiar_celda(txt, nombre_celda) {
    document.getElementById(nombre_celda).innerHTML = txt;

}

function copyCelda(tabla, max_nume_celda, datos, adatos, nume_celda, nume_fila,contador) {
    //son dos tds, uno para el texto a mostrar otro para el id


    var newRow;
    var cnt;
    var filas = nume_fila.value;
    var celdas = nume_celda.value;
    var nombre_celda = "";
    var nombre_celda_eliminar = "";
    var length1;
    var length2;
    var id;
    var TABLE = document.getElementById(tabla);

    if (filas == "") {
        filas = 0;
    }
    if (celdas == "") {
        celdas = 0;
    }
    
    if(tabla=='hogar_sh'){
      
        length1='90';
        length2='10';
       direccion1='left';
        direccion2='left'
    }else{
        length1='10';
        length2='10'
        direccion1='right';
        direccion2='left'
    }
    //alert(max_nume_celda +' + ' +celdas);
    if (max_nume_celda <= celdas || celdas == 0) {
       
        nume_fila.value = parseInt(filas) + 1;
        filas = nume_fila.value;
        trow = TABLE.insertRow(-1);
        celdas = 0;
        trow.name = "tr" + tabla + filas;
        trow.id = "tr" + tabla + filas;
        for (cnt = celdas; cnt < (max_nume_celda - celdas); cnt++) {


            nombre_celda = tabla + filas + cnt;
            nombre_celda_eliminar = 'e' + tabla + filas + cnt;
    
            appendCellCelda(trow, "&nbsp;", nombre_celda,direccion1,length1);    
            appendCellCelda(trow, "&nbsp;", nombre_celda_eliminar,direccion1,length2);


        }


    }
    nombre_celda = tabla + filas + celdas;

    nombre_celda_eliminar = 'e' + tabla + filas + celdas;
        

    copiar_celda(datos.label, nombre_celda);
    idnombre_celda_valor = 'id' + tabla + filas + celdas;
    

    contenido = "<input type='hidden' id='" + idnombre_celda_valor + "' name='" + adatos + "[]' value='" + datos.value + "'><img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" onclick=\"disminuye_celda('" + nombre_celda + "','"+contador+"')\">";
    //alert(contenido);
    copiar_celda(contenido, nombre_celda_eliminar);
    nume_celda.value = parseInt(celdas) + 1;
    
    

}
function copyCeldaHogar(tabla, max_nume_celda, datos, adatos, nume_celda, nume_fila,contador) {
    //son dos tds, uno para el texto a mostrar otro para el id


    var newRow;
    var cnt;
    var filas = nume_fila.value;
    var celdas = nume_celda.value;
    var idcombo = document.getElementById('idpersona_parentesco[0]');
  
    var nombre_celda = "";
    var nombre_celda_eliminar = "";
    var length1;
    var length2;
    var id;
    var TABLE = document.getElementById(tabla);

    if (filas == "") {
        filas = 0;
    }
    if (celdas == "") {
        celdas = 0;
    }
    
    if(tabla=='hogar_sh'){
      
        length1='50';
        length2='10';
       direccion1='left';
        direccion2='left'
    }else{
        length1='10';
        length2='10'
        direccion1='right';
        direccion2='left'
    }
    //alert(max_nume_celda +' + ' +celdas);

    if (max_nume_celda <= celdas || celdas == 0) {
       
        nume_fila.value = parseInt(filas) + 1;
        filas = nume_fila.value;
        trow = TABLE.insertRow(-1);
        celdas = 0;
        trow.name = "tr" + tabla + filas;
        trow.id = "tr" + tabla + filas;
       var comboParentesco="<select name='idpersona_parentesco[]' id='idpersona_parentesco["+filas+"]'>"+idcombo.innerHTML+"</select>";

        for (cnt = celdas; cnt < (max_nume_celda - celdas); cnt++) {

            
            nombre_celda = tabla + filas + cnt;
            nombre_celda_eliminar = 'e' + tabla + filas + cnt;
            nombre_celda_combo='p'+tabla+filas+cnt;
            appendCellCelda(trow, "&nbsp;", nombre_celda,direccion1,length1);   
            
            appendCellCelda(trow,comboParentesco,nombre_celda_combo,'left',40);
            appendCellCelda(trow, "&nbsp;", nombre_celda_eliminar,direccion1,length2);


        }


    }
    nombre_celda = tabla + filas + celdas;

    nombre_celda_eliminar = 'e' + tabla + filas + celdas;
        

    copiar_celda(datos.label, nombre_celda);
    idnombre_celda_valor = 'id' + tabla + filas + celdas;
    

    contenido = "<input type='hidden' id='" + idnombre_celda_valor + "' name='" + adatos + "[]' value='" + datos.value + "'><img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" onclick=\"disminuye_celda('" + nombre_celda + "','"+contador+"')\">";
    //alert(contenido);
    copiar_celda(contenido, nombre_celda_eliminar);
    nume_celda.value = parseInt(celdas) + 1;
    
    

}
function copyCeldaTag(tabla, max_nume_celda, datos, adatos, nume_celda, nume_fila,contador) {
    //son dos tds, uno para el texto a mostrar otro para el id


    var newRow;
    var cnt;
    var filas = nume_fila.value;
    var celdas = nume_celda.value;
    var nombre_celda = "";
    var nombre_celda_eliminar = "";
    var nombre_celda_spinner = "";
    var id;
    var TABLE = document.getElementById(tabla);

    if (filas == "") {
        filas = 0;
    }
    if (celdas == "") {
        celdas = 0;
    }

    if (max_nume_celda <= celdas || celdas == 0) {
        nume_fila.value = parseInt(filas) + 1;
        filas = nume_fila.value;
        trow = TABLE.insertRow(-1);
        celdas = 0;
        trow.name = "tr" + tabla + filas;
        trow.id = "tr" + tabla + filas;
        for (cnt = celdas; cnt < (max_nume_celda - celdas); cnt++) {


            nombre_celda = tabla + filas + cnt;
            nombre_celda_eliminar = 'e' + tabla + filas + cnt;
            nombre_celda_spinner = 's' + tabla + filas + cnt;
            appendCellCelda(trow, "&nbsp;", nombre_celda,"right",10);
            appendCellCelda(trow, "&nbsp;", nombre_celda_spinner,"left",10);
            appendCellCelda(trow, "&nbsp;", nombre_celda_eliminar,"left",10);


        }


    }
    nombre_celda = tabla + filas + celdas;

    nombre_celda_eliminar = 'e' + tabla + filas + celdas;
    
    nombre_celda_spinner = 's' + tabla + filas + celdas;

    copiar_celda(datos.label, nombre_celda);
    idnombre_celda_valor = 'id' + tabla + filas + celdas;
    

    contenido = "<input type='hidden' id='" + idnombre_celda_valor + "' name='" + adatos + "[]' value='" + datos.value + "'><img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" onclick=\"disminuye_celda('" + nombre_celda + "','"+contador+"')\">";
    //alert(contenido);
    copiar_celda(contenido, nombre_celda_eliminar);
    nume_celda.value = parseInt(celdas) + 1;
    
    contenido = "<input id=\"spinner_"+idnombre_celda_valor+"\" name=\"orden_complejo_tag[]\" style=\"width:20px;\"/>";
    //alert(contenido);
    copiar_celda(contenido, nombre_celda_spinner);
    $( "#spinner_"+idnombre_celda_valor ).spinner({
        spin: function( event, ui ) {
        if ( ui.value < 0 ) {
          $( this ).spinner( "value", 0 );
          return false;
        } 
      }
    });
    $( "#spinner_"+idnombre_celda_valor ).spinner( "value", 0 );
      
    contenido = "";

}


function copyCeldaRC(tabla, max_nume_celda, datos, adatos, nume_celda, nume_fila,contador) {
    //son dos tds, uno para el texto a mostrar otro para el id


    var newRow;
    var cnt;
    var filas = nume_fila.value;
    var celdas = nume_celda.value;
    var nombre_celda = "";
    var nombre_celda_eliminar = "";
    var id;
    var TABLE = document.getElementById(tabla);

    if (filas == "") {
        filas = 0;
    }
    if (celdas == "") {
        celdas = 0;
    }

    if (max_nume_celda <= celdas || celdas == 0) {
        nume_fila.value = parseInt(filas) + 1;
        filas = nume_fila.value;
        trow = TABLE.insertRow(-1);
        celdas = 0;
        trow.name = "tr" + tabla + filas;
        trow.id = "tr" + tabla + filas;
        for (cnt = celdas; cnt < (max_nume_celda - celdas); cnt++) {


            nombre_celda = tabla + filas + cnt;
            nombre_celda_eliminar = 'e' + tabla + filas + cnt;
            appendCellCelda(trow, "&nbsp;", nombre_celda,"right",10);
            appendCellCelda(trow, "&nbsp;", nombre_celda_eliminar,"left",10);


        }


    }
    nombre_celda = tabla + filas + celdas;

    nombre_celda_eliminar = 'e' + tabla + filas + celdas;

    copiar_celda(datos.label, nombre_celda);
    idnombre_celda_valor = 'id' + tabla + filas + celdas;
    idnombre_celda_fecha = 'id' + 'fecha' + filas + celdas;
    fdatos = 'fecha_complejo';
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = dd+'/'+mm+'/'+yyyy;
    

    contenido = "<input type='hidden' id='" + idnombre_celda_valor + "' name='" + adatos + "[]' value='" + datos.value + "'><input type='text' size='10' value='"+today+"' id='"+idnombre_celda_fecha+"' name='" + fdatos + "[]' > <img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" onclick=\"disminuye_celda('" + nombre_celda + "','"+contador+"')\">";
    //alert(contenido);
    copiar_celda(contenido, nombre_celda_eliminar);
    nume_celda.value = parseInt(celdas) + 1;

    $("#"+idnombre_celda_fecha).datepicker({changeYear: true, changeMonth: true});

    contenido = "";

}


