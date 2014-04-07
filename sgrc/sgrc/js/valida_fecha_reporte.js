
        function valida_envia(){
            var fechai=document.getElementById("fechai");
	    var fechaf=document.getElementById("fechaf");
            var idresponsable=document.getElementById("idresponsable");
            var idempresa_responsable=document.getElementById("idempresa_responsable");
            var es_responsable=document.getElementById("es_responsable");
	    	//tiene q estar en formato mm/dd/yyyy pa compararse
	    	fecha_ini=fechai.value;
	    	fecha_fin=fechaf.value;
	    	array_fechai=fecha_ini.split("/");
	    	array_fechaf=fecha_fin.split("/");
	    	//cambiamos
	    	fechai=new Date(array_fechai[2],array_fechai[1],array_fechai[0]);
	    	fechaf=new Date(array_fechaf[2],array_fechaf[1],array_fechaf[0]);
	    	//comparamos
	    	if(fechaf<fechai){
	           alert("Fecha Final No Valida...")
	           fechaf.focus()
	           return 0;
	        }else{
	            if(es_responsable.value==1){
                    //el formulario se envia
                    document.getElementById("form1").submit();
	            }else{
	               if(idresponsable.value=="" && idempresa_responsable.value==""){
                        alert("Debe seleccionar responsable o empresa responsable...")
                        idresponsable.focus()
                        return 0;
                    }else{
                        if(idresponsable.value!="" && idempresa_responsable.value!=""){
                            alert("Si selecciona responsables no debe seleccionar empresas responsables...")
                            idempresa_responsable.focus()
                            return 0;
                        }else{
                            //el formulario se envia
                            document.getElementById("form1").submit();
                        }
                    }
	        }
	    }
        }
 