var controlprecionado = 0;
var altprecionado = 0;
function desactivarCrlAlt(teclaactual){

   var desactivar = false;
   //Ctrl +
   if (controlprecionado==17){
      //if (teclaactual==78 || teclaactual==85 ){
        //alert("Ctrl+N y Ctrl+U deshabilitado");
        //desactivar=true;
      //}
      if (teclaactual==82){
        //alert("Ctrl+R deshabilitado");
        desactivar=true;
      }
      if (teclaactual==116){
        //alert("Ctrl+F5 deshabilitado");
        desactivar=true;
      }
      if (teclaactual==114){
        //alert("Ctrl+F3 deshabilitado");
        desactivar=true;
      }
   }
   //Alt +
   if (altprecionado==18){
      if (teclaactual==37){
        //alert("Alt+ [<-] deshabilitado");
        desactivar=true;
      }
      if (teclaactual==39){
        //alert("Alt+ [->] deshabilitado");
        desactivar=true;
      }
   }
   if (teclaactual==17)controlprecionado=teclaactual;
   if (teclaactual==18)altprecionado=teclaactual;
   return desactivar;
}

document.onkeyup = function(ev){
   var keystroke;
    ev = ev || event;
    keystroke = ev.keyCode;
   if (keystroke==17){
 controlprecionado = 0;
   }
   if (keystroke==18){
 altprecionado = 0;
   }
}

document.onkeydown = function(ev){
   //116->f5
   //122->f11
   //117->f6
   //114->f3
   //13 enter
   var keystroke;
    ev = ev || event;
    keystroke = ev.keyCode;

    //which = String.fromCharCode(keystroke).toLowerCase();
    //alert (which);  // delete after testing

   //var code =(window.event)? event.keyCode : e.which;
   if (desactivarCrlAlt(keystroke)){
     return false;
   }
   /*
   if (
       keystroke == 116 ||
       keystroke==13){
       if(window.event){window.event.keyCode=505 };
     
      return false;
   }
   */
   if (keystroke == 505){
    return false;
 }
   if (keystroke == 8){
 valor = document.activeElement.value;
 if (valor==undefined) {
    //Evita Back en página.
    //alert("lo siento!, no hay back :P");
    return false;
 }
 else{
    if (document.activeElement.getAttribute('type')
          =='select-one')
       { return false; } //Evita Back en select.
    if (document.activeElement.getAttribute('type')
          =='button')
       { return false; } //Evita Back en button.
    if (document.activeElement.getAttribute('type')
          =='radio')
       { return false; } //Evita Back en radio.
    if (document.activeElement.getAttribute('type')
          =='checkbox')
       { return false; } //Evita Back en checkbox.
    if (document.activeElement.getAttribute('type')
          =='file')
       { return false; } //Evita Back en file.
    if (document.activeElement.getAttribute('type')
          =='reset')
       { return false; } //Evita Back en reset.
    if (document.activeElement.getAttribute('type')
          =='submit')
       { return false; } //Evita Back en submit.
    else //Text, textarea o password
 {
 if (document.activeElement.value.length==0){
    //No realiza el backspace(largo igual a 0).
    return false;
 }
 else{
       //Realiza el backspace.
       document.activeElement.value.keyCode = 8;
       return true;
    }
     }
   }
 }
}


function calendario(parametro, botonParametro) {
    Calendar.setup({
        inputField     :    parametro,     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    botonParametro,  // trigger for the calendar (button ID)
        align          :    "TR",           // alignment (defaults to "Bl")
        singleClick    :    true,
		weekNumbers    :    false,
		electric       :    false
    });
}
function calendario2(parametro, botonParametro) {
    Calendar.setup({
        inputField     :    parametro,     // id of the input field
        ifFormat       :    "%d/%m/%Y",      // format of the input field
        button         :    botonParametro,  // trigger for the calendar (button ID)
        align          :    "TR",           // alignment (defaults to "Bl")
        singleClick    :    true,
		weekNumbers    :    false,
		electric       :    false
    });
}
function abrir(direccion, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
	var opciones = "fullscreen=" + pantallacompleta +
				   ",toolbar=" + herramientas +
				   ",location=" + direcciones +
				   ",status=" + estado +
				   ",menubar=" + barramenu +
				   ",scrollbars=" + barrascroll +
				   ",resizable=" + cambiatamano +
				   ",width=" + ancho +
				   ",height=" + alto +
				   ",left=" + izquierda +
				   ",top=" + arriba;
	 var ventana = window.open(direccion,"venta",opciones,sustituir);
}

var hijo = null;
var hijo2=null;

function abrePopUp(pag,nombre) {
    pos =0;
    //h = 500;
    //w = 800;
	w=window.screen.availWidth;
	h=window.screen.availHeight*0.9;
    if(nombre=="ventana1"){
        nombre_pag="hijo";
    }
    if(nombre=="ventana2"){
        nombre_pag="hijo2";
    }
    if(hijo){
        hijo.close();
    }
    if(hijo2){
        hijo2.close();
    }
    hijo=window.open(pag,nombre_pag,"pageX="+pos+",pageY"+pos+",left="+pos+",top="+pos+",menubar=no,toolbar=no,scrollbars=yes,width="+w+",height="+h+",resizable=yes")


}

function procesando(){

	document.getElementById('preloader').style.visibility='visible';
	document.getElementById('preloader').style.display='block';

	return true;
}

function limpiar(id,foco){
	document.getElementById(id).value='';
    if(foco){
        document.getElementById(foco).focus();
    }    
}
function eliminar(){
	return confirm("¿Está seguro de eliminar?");
}
function eliminar2(texto){
	return confirm("¿Está seguro de eliminar "+texto+"?");
}
function anular(texto){
	return confirm("¿Está seguro de anular "+texto+" ?");
}

function cerrar(direccion) {
	window.opener.document.location.href = direccion;
	window.close();
}

function actualiza(){
	window.location.reload()
}

function error_numero_general2(numero){
	var error=0;	

	if(isNaN(numero)){
		error=1;
	}else{
		if((numero)<0){
		error=1;
		}	 
	}
    var numString = numero.toString();
	if(numString.lastIndexOf(".")>0){
		var cutoff = numString.lastIndexOf(".") + 3;
		numString=numString.substring(cutoff);
		numero=Number(numString);
		
		if(numero>0){
			error=1;
		}
	}
	return error;
}
function cantidad_caracteres(elemento){
	var var_elemento = document.getElementById(elemento);
	var elemento_sinespacios=var_elemento.value;
	elemento_sinespacios=elemento_sinespacios.replace(/^\s*|\s*$/g,"");
	if(elemento_sinespacios.lenght<=0){
		var_elemento.focus();
		return false;
	}
}
function error_numero_general(numero){
	var error=0;
    var num;
	if(numero==""){
		error=1;
	}
	if(isNaN(numero)){
		error=1;
	}else{
		if((numero)<0){
		error=1;
		}
	}
	if(numero>999999){
		error=1;
	}
    //trabajo con cadenas por los errores de rendondero 18.31*100, 4.395
    var numString = numero.toString();
	if(numString.lastIndexOf(".")>0){
		var cutoff = numString.lastIndexOf(".") + 3;
		numString=numString.substring(cutoff);
		numero=Number(numString);
		
		if(numero>0){
			error=1;
		}
	}
	return error;
}
function error_numero_general3(numero){
	//sin decimales pero puedo ser negativo
	var error=0;
    var num;
	if(numero==""){
		error=1;
	}
	if(isNaN(numero)){
		error=1;
	}
	if(numero>999999){
		error=1;
	}
    //trabajo con cadenas por los errores de rendondero 18.31*100, 4.395
    var numString = numero.toString();
    var cutoff = numString.lastIndexOf(".");
        if(cutoff>-1){
            //numero
            numString=numString.substring(cutoff);
            numero=Number(numString);
            if(numero>0){
                error=1;
            }
    }
	return error;
}


function error_numero_general_sin_decimal(numero){
    //la utiliza farmacia
	var error=0;
    var num;
	if(numero==""){
		error=1;
	}
	if(isNaN(numero)){
		error=1;
	}else{
		if((numero)<0){
		error=1;
		}
	}
	if(numero>999999){
		error=1;
	}
    //trabajo con cadenas por los errores de rendondero 18.31*100, 4.395
    var numString = numero.toString();
    var cutoff = numString.lastIndexOf(".");
        if(cutoff>-1){
            //numero
            numString=numString.substring(cutoff);
            numero=Number(numString);
            if(numero>0){
                error=1;
            }
    }
	return error;
}
function valida_array(celda){

	monto=celda.value;
   
	error=error_numero_general(monto);
	if(error==1){
		alert("Cantidad indecuada");
		celda.focus();
		celda.value=0;
	}

}
function valida_array3(celda){

	monto=celda.value;
   
	error=error_numero_general3(monto);
	if(error==1){
		alert("Cantidad indecuada");
		celda.focus();
		
	}

}
function valida_array_sin_decimal(celda){

	monto=celda.value;

	error=error_numero_general_sin_decimal(monto);
	if(error==1){
		alert("Cantidad indecuada");
		celda.focus();
		celda.value=0;
	}

}
function redondeo2decimales(numero)
{
	var original=parseFloat(numero);
	var result=Math.round(original*100)/100;
	return result;
}
function redondeo4decimales(numero)
{
	var original=parseFloat(numero);
	var result=Math.round(original*10000)/10000;
	return result;
}
function redondeo1decimal(numero)
{
	var original=parseFloat(numero);
	var result=Math.round(original*10)/10;
	return result;
}

function valida_cantidad_filas(tabla){

	var obj_tabla = document.getElementById(tabla);
	var tabla_cant= obj_tabla.getElementsByTagName('tr');
	//valido nombre de la farmacia
	//valido responsables de la farmacia
	if (tabla_cant.length<=1){
	   return 0;
	} else{
		return 1;
	}

}

function valida_array2(celda){
	monto=celda.value;
	error=error_numero_general2(monto);
	if(error==1){
        
		alert("Cantidad indecuada");       
		celda.value="";
		celda.focus();
		//return false;
	}	
}
function ignoreSpaces(string) {
	var temp = "";
	string = '' + string;
	splitstring = string.split(" ");
	for(i = 0; i < splitstring.length; i++){
		temp += splitstring[i];
	}			
	return temp;
}
function cambia_css(id,css,css_anterior){
   
    var elemento=document.getElementById(id);
    if(elemento.className==css_anterior){
        elemento.className=css;
    }else{
        elemento.className=css_anterior;
    }
    


}

function mostrar_ventana(ventana){

	document.getElementById(ventana).style.visibility = "visible";
	document.getElementById(ventana).style.display = "block";

}   
function ocultar_ventana(ventana){
	document.getElementById(ventana).style.visibility = "hidden";
	document.getElementById(ventana).style.display = "none";
	//document.getElementById(ventana).innerHTML="";
}   

function cambia_color_rojo(nombre_objeto){//nueva
    objeto=document.getElementById(nombre_objeto);
    objeto.style.backgroundColor="#FCB4C0";
}

function perder_enfoque_caja(){
	var input = $("input:text").css("font-size","11px");
		if($(this).val()==""){
			if($(this).attr("id")=='busca_apepat'){
			$(this).val("Ap.paterno o DNI")
		}
	}
}

function enfoque_caja(){
	if($(this).val()=="Ap.paterno o DNI"){
		if($(this).attr("id")=='busca_apepat'){
			$(this).val("");
		}
	}
	$(this).css("font-size","18px");
}

