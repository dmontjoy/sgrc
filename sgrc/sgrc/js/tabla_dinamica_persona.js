// JavaScript Document

//tabla: es la tabla donde se crean
//datos nombre de la variable
//nume_fila
function agrega_celda_persona(tabla, datos, nume_fila) {

    var TABLE = document.getElementById(tabla);
    var nume_fila_element = document.getElementById(nume_fila);
    copyCelda_persona(tabla, datos, nume_fila_element);

}

function disminuye_celda_persona(idtabla, nombre_celda) {
    //cuando agrega no necesita el editar pues no esta guardo y lo anterior ya esta deshabilitado
    var TABLE = document.getElementById(idtabla);

    var nume = TABLE.getElementsByTagName('tr');

    for (i = 0; i < nume.length; i++) {
        // alert(nume[i].id + " <-> " + nombre_celda);
        if (nume[i].id == 'tr' + nombre_celda) {

            num = i;

            break;
        }
    }
    TABLE.deleteRow(i);

}

function disminuye_celda_persona_editar(idtabla, nombre_celda) {
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


function appendCellCelda_persona(Trow, txt, nombre_celda) {
    //crean celda
    var newCell = Trow.insertCell(Trow.cells.length);

    //newCell.className="celdaSimple";

    newCell.innerHTML = txt;

    newCell.id = nombre_celda;

    newCell.name = nombre_celda;

    newCell.width = "10%";
}

function copiar_celda_persona(txt, nombre_celda) {
    document.getElementById(nombre_celda).innerHTML = txt;

}

function copyCelda_persona(tabla, datos, nume_fila) {
    //son dos tds, uno para el texto a mostrar otro para el id
    var filas = nume_fila.value;
    var nombre_celda = "";
    var nombre_celda_eliminar = "";

    var TABLE = document.getElementById(tabla);

    if (filas == "") {
        filas = 0;
    }



    trow = TABLE.insertRow(-1);

    trow.name = "tr" + tabla + filas;

    trow.id = "tr" + tabla + filas;

    nombre_celda = 'td' + tabla + filas;

    appendCellCelda_persona(trow, "&nbsp;", nombre_celda);
    //
    //" + filas + "
    contenido = "<input type='text' name='" + datos + "[" + filas + "]' id='" + datos + filas + "' size='60'  /><input type='hidden' name=id" + datos + "[" + filas + "] id=id" + datos + filas + " value=1 />";

    copiar_celda_persona(contenido, nombre_celda);

    nombre_celda_eliminar = 'etd' + tabla + filas;
    //alert(tabla);
    contenido = "<img src=\"../../../img/trash.png\" title=\"Eliminar\" width=\"16\" height=\"16\" border=\"0\" class=\"icono\" onclick=\"disminuye_celda_persona('" + tabla + "','" + tabla + filas + "')\">";

    appendCellCelda_persona(trow, "&nbsp;", nombre_celda_eliminar);

    copiar_celda_persona(contenido, nombre_celda_eliminar);

    nume_fila.value = parseInt(filas) + 1;

}

