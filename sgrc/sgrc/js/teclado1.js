function sup(){
	if(document.formulario.opcion[0].checked){
		
			document.formulario.txtcontra.value="";
			

	}
	if(document.formulario.opcion[1].checked){
	
			document.formulario.contrasenia.value="";
			

	}
	if(document.formulario.opcion[2].checked){
	
			document.formulario.contrasenia_confirma.value="";
	

	}
    	
}
function val(es){

	if(document.formulario.opcion[0].checked){
		if (document.formulario.txtcontra.value.length<4){
			document.formulario.txtcontra.value=document.formulario.txtcontra.value+es;
		}	

	}
	if(document.formulario.opcion[1].checked){
		if (document.formulario.contrasenia.value.length<4){
			document.formulario.contrasenia.value=document.formulario.contrasenia.value+es;
		}	

	}
	if(document.formulario.opcion[2].checked){
		if (document.formulario.contrasenia_confirma.value.length<4){
			document.formulario.contrasenia_confirma.value=document.formulario.contrasenia_confirma.value+es;
		}	

	}
	
}
var n= new Array(9)
	var ban
	var p
	var x
	for (j = 0; j <= 9; j++)
	{ban="no";
		do {
			p=Math.random();
			ban="no"
			x=(Math.round(p*9));
			for (i = 0; i <= j-1; i++)
			{
				if (n[i]==x)
					{
					ban="si";
				}
				}
			}while (ban=="si")
			n[j]=x
			}
		
		 
var cuadro;
cuadro='<TABLE id="Table1" cellSpacing="1" cellPadding="3" style="background: #E1FFE1;"><TR align="center"><TD style="cursor:pointer;border:1px solid #cccccc;"  onMouseOut="mOut(this);" onMouseOver="mOvr(this);" width="15" onclick="val('+ n[0] +')"><img src=../../../img/'+n[0]+'.gif border=0></TD>';
cuadro=cuadro + '<TD style="cursor:pointer;border:1px solid #cccccc;" width="15" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" onclick="val(' + n[1] + ')"><img src=../../../img/'+n[1]+'.gif border=0></TD>';
cuadro=cuadro + '<TD style="cursor:pointer;border:1px solid #cccccc;" width="15" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" onclick="val(' + n[2] + ')"><img src=../../../img/'+n[2]+'.gif border=0></TD></tr>';
cuadro=cuadro + '<tr align="center"><TD style="cursor:pointer;border:1px solid #cccccc;" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" onclick="val(' + n[3] + ')"><img src=../../../img/'+n[3]+'.gif border=0></TD>';
cuadro=cuadro + '<TD style="cursor:pointer;border:1px solid #cccccc;" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" onclick="val(' + n[4] + ')"><img src=../../../img/'+n[4]+'.gif border=0></TD>';
cuadro=cuadro + '<TD style="cursor:pointer;border:1px solid #cccccc;" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" onclick="val(' + n[5] + ')"><img src=../../../img/'+n[5]+'.gif border=0></TD></tr>';
cuadro=cuadro + '<tr class="tec" align="center" ><TD style="cursor:pointer;border:1px solid #cccccc;" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" onclick="val(' + n[6] + ')"><img src=../../../img/'+n[6]+'.gif border=0></TD>';
cuadro=cuadro + '<TD style="cursor:pointer;border:1px solid #cccccc;" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" onclick="val(' + n[7] + ')"><img src=../../../img/'+n[7]+'.gif border=0></TD>';
cuadro=cuadro + '<TD style="cursor:pointer;border:1px solid #cccccc;" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" onclick="val(' + n[8] + ')"><img src="../../../img/'+n[8]+'.gif" border=0></TD></tr>';
cuadro=cuadro + '<tr class="tec" align="center"><TD style="cursor:pointer;border:1px solid #cccccc;" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" onclick="val(' + n[9] + ')"><img src=../../../img/'+n[9]+'.gif border=0></TD>';
cuadro=cuadro + '<TD style="cursor:pointer;border:1px solid #cccccc;" onMouseOut="mOut(this);" onMouseOver="mOvr(this);" colspan=2 onclick="sup()"><img src="../../../img/borrar.gif"></TD></tr></table>';
document.write(cuadro);

