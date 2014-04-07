// JavaScript Document

var TABLE;
var TROW;
//caja del buscar, lo utilizo para el enfoque y volve el valor en blanco
var nume_fila;

function carga_identificacion(tabla, fila, nume_fila_inicial, adatos) {

    TABLE = document.getElementById(tabla);
    TROW = document.getElementById(fila);
    nume_fila = document.getElementById(nume_fila_inicial);
    adatos = adatos;

    // debugger;
}


function agregafila_identificacion(tabla, fila, nume_fila_inicial, adatos) {

    carga_identificacion(tabla, fila, nume_fila_inicial, adatos);
    var content = TROW.getElementsByTagName("td");
    var newRow = TABLE.insertRow(-1);
    copyRow_identificacion(tabla, newRow, adatos);

}

function disminuye_celda_documento_identificacion_editar(idtabla, nombre_celda) {
    //idcampo, campo que almacena el id del campo a actualizar
    var n, valor_campo;

    valor_campo = document.getElementById('id' + nombre_celda).value;

    if (valor_campo.indexOf('***') != -1) {
        //viejos
        n = valor_campo.split('***');//3***1**1->los dos primeros llaves, el último si esta activo
        if (n[2] == 0) {
            n[1] = 1;
        } else {
            n[2] = 0;
        }
        valor_campo = n[0] + "***" + n[1] + "***" + n[2];
    } else {
        //nuevos, valor 0 - 1
        valor_campo = 0;
    }
    document.getElementById('id' + nombre_celda).value = valor_campo;
    var TABLE = document.getElementById(idtabla);

    var nume = TABLE.getElementsByTagName('tr');

    for (i = 0; i < nume.length; i++) {

        if (nume[i].id == 'tr' + nombre_celda) {

            num = i;

            break;
        }

    }

    TABLE.deleteRow(i);


    // document.getElementById('id' + nombre_celda).value = valor_campo;
    //document.getElementById('td' + nombre_celda).className = "tachado";
    // document.getElementById('etd' + nombre_celda).innerHTML = "&nbsp;";
}

function disminuyefila_identificacion(obj, idtabla) {

    var TABLE = document.getElementById(idtabla);
    var nume = TABLE.getElementsByTagName('tr');
    for (i = 0; i < nume.length; i++) {
        //alert(nume[i].id);
        //alert(obj);
        if (nume[i].id == obj) {
            num = i;
            break;
        }
    }
    TABLE.deleteRow(i);

}
function appendCell_identificacion(Trow, txt, tipo) {

    var newCell = Trow.insertCell(Trow.cells.length)
    if (tipo == 1) {
        newCell.className = "celdaSimple";
    }
    if (tipo == 2) {
        newCell.className = "celda_titulo";
    }
    newCell.innerHTML = txt
}


function copyRow_identificacion(tabla, Trow, adatos) {

    var contenido;
    var filas = nume_fila.value
    // alert("filas " + filas);
    if (filas == "" || filas == "NaN") {
        filas = 0;
    }
    filas = nume_fila.value;
//nombre y id de las filas
    Trow.name = "tr" + tabla + filas;
    Trow.id = "tr" + tabla + filas;

    contenido = "";

    contenido = "Doct. identificaci&oacute;n<input id='idpersona_documento_identificacion" + filas + "' type='hidden' size='25' value='1' name='idpersona_documento_identificacion[" + filas + " ]'>";
    appendCell_identificacion(Trow, contenido, 2);

    contenido = "";
    contenido_tipo = document.getElementById("select_documento_identificacion[0]").innerHTML;//copia el combo de los tipos de identificacion
    contenido = "<select name='select_documento_identificacion[" + filas + "]' id='select_documento_identificacion" + filas + "'>" + contenido_tipo + "</select>";
    appendCell_identificacion(Trow, contenido, 1);

    contenido = "";
    contenido = "N&uacute;mero documento";
    appendCell_identificacion(Trow, contenido, 2);

    contenido = "";
    contenido = "<input name='" + adatos + "[" + filas + "]' id='" + adatos + filas + "' type='text' value='' size='25' />";
    appendCell_identificacion(Trow, contenido, 1);
    contenido = "<img src=\"../../../img/trash.png\" alt=\"Eliminar\" id='tr" + filas + "' name='tr" + filas + "' width=\"16\" height=\"16\" border=\"0\" class=\"icono\" onclick=\"disminuyefila_identificacion('tr" + tabla + filas + "', '" + TABLE.id + "')\">";

    filas++;
    nume_fila.value = filas;
    appendCell_identificacion(Trow, contenido, 1);


}