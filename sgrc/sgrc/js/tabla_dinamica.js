// JavaScript Document


function agregafila(tabla, fila, datos, adatos, nume_fila) {

    var TABLE = document.getElementById(tabla);

    var TROW = document.getElementById(fila);

    var content = TROW.getElementsByTagName("td");

    var nume_fila_element = document.getElementById(nume_fila);

    var newRow = TABLE.insertRow(-1);

    copyRow(tabla, content, newRow, datos, adatos, nume_fila_element);

}

function disminuyefila_editar(tr, idtabla, idcampo) {

    var TABLE = document.getElementById(idtabla);

    var nume = TABLE.getElementsByTagName('tr');

    for (i = 0; i < nume.length; i++) {

        if (nume[i].id == tr) {

            num = i;

            break;
        }

    }

    valor_campo = document.getElementById(idcampo).value
    n = valor_campo.split('***');//3***1**1->los dos primeros llaves, el último si esta activo
    if (n[2] == 0) {
        n[1] = 1;
    } else {
        n[2] = 0;
    }
    valor_campo = n[0] + "***" + n[1] + "***" + n[2];
    document.getElementById(idcampo).value = valor_campo
    TABLE.deleteRow(i);

}

function disminuyefila(tr, idtabla) {

    var TABLE = document.getElementById(idtabla);

    var nume = TABLE.getElementsByTagName('tr');

    for (i = 0; i < nume.length; i++) {

        if (nume[i].id == tr) {

            num = i;

            break;
        }

    }
    TABLE.deleteRow(i);

}
function appendCell(Trow, txt) {

    var newCell = Trow.insertCell(Trow.cells.length)

    newCell.className = "celdaSimple";

    newCell.innerHTML = txt
}


function copyRow(tabla, content, Trow, datos, adatos, nume_fila) {

    var cnt = 0;
    var contenido;
    var array_datos = new Array();
    var datos;
    var filas = nume_fila.value;

    if (filas == "") {
        filas = 0;
    }
    var id;
    var TABLE = document.getElementById(tabla);
    //nombre y id de las filas
    Trow.name = "tr" + adatos + filas;
    Trow.id = "tr" + adatos + filas;

    //datos, contiene los datos a mostrar; la tabla construida tiene exactamente la misma cantidad
    while (datos.indexOf("@@") > -1) {
        //los @@ se convertiran en un " para que los reconozca
        datos = datos.replace("@@", "\"");
    }
    //     alert(datos);
    array_datos = datos.split("**")

    contenido = "";
    //content numero de td
    for (; cnt <= content.length - 1; cnt++) {
        if (cnt != 1) {
            while (array_datos[cnt].indexOf("##") > -1) {
                // los ## sirve para asignarle la posicion del array de la tabla dinamica
                array_datos[cnt] = array_datos[cnt].replace("##", filas);

            }
            contenido = array_datos[cnt];

            appendCell(Trow, contenido);

        } else {
            id = array_datos[cnt];
        }

    }

    contenido = "<input type='hidden' id='id" + adatos + "[" + filas + "]' name='id" + adatos + "[" + filas + "]' value='" + id + "'><img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" onclick=\"disminuyefila('tr" + adatos + filas + "', '" + TABLE.id + "')\">";
    ;
    filas++;

    nume_fila.value = filas;

    appendCell(Trow, contenido);

}

