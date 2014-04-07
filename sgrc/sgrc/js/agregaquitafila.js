// JavaScript Document

function agregafila(){
	var TABLE = document.getElementById("base");
	var TROW = document.getElementById("example");
	var content = TROW.getElementsByTagName("td");
	var newRow = TABLE.insertRow(-1);
	var newRow2 = TABLE.insertRow(-1);
	copyRow(content,newRow2);
}

function disminuyefila() {
	var TABLE = document.getElementById("base");
	    if(TABLE.rows.length > 2) {
	        TABLE.deleteRow(TABLE.rows.length-1);
	        TABLE.deleteRow(TABLE.rows.length-1);
	    }
}

function appendCell(Trow, txt) {
    var newCell = Trow.insertCell(Trow.cells.length)
    newCell.innerHTML = txt
}
function copyRow(content,Trow) {
var cnt = 0;
    for (; cnt < content.length; cnt++) {
    appendCell(Trow, content[cnt].innerHTML);
    }
}

