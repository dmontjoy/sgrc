<?php
include_once("include_utiles.php");

if(!$seguridad->verificaSesion()){
	$mensaje="Ingrese su usuario y contraseña";
	header("Location: ../../index.php?mensaje=$mensaje");
}

function cabecera(){

	$obj_ayudante=new Ayudante();
	$p_cabecera= new DmpTemplate(ruta_plantillas."cabecera.html");
	$p_cabecera->reemplaza(fecha,$obj_ayudante->formateaFecha(date("Y-m-d")));

	if(date("G")>=4 && date("G")<=11){
		$tiempo="Buenos d&iacute;as ";		
	}
	if(date("G")>11 && date("G")<= 19){
		$tiempo="Buenas tardes ";
	}
	if(date("G")> 19 && date("G")<= 0){
		$tiempo="Buenas noches ";	
	}
	
	$p_cabecera->reemplaza("quien",$tiempo.$_SESSION[nombre]);
	$p_cabecera->reemplaza("ruta_sigh",ruta_sigh);
    if($_SESSION["idmodulo_sistema"]==5){
        $p_cabecera->reemplaza("titulo",'Farmacia ('.$_SESSION["nombre_farmacia"].')');
    }
    if($_SESSION["idmodulo_sistema"]==1){
        $p_cabecera->reemplaza("titulo",'Admisi&oacute;n ('.$_SESSION["nombre_lugar"].')');
    }
     if($_SESSION["idmodulo_sistema"]==2){
        $p_cabecera->reemplaza("titulo",'Facturaci&oacute;n ('.$_SESSION["nombre_lugar"].')');
    }
    if($_SESSION["idmodulo_sistema"]==13){
      $p_cabecera->reemplaza("titulo",'('.$_SESSION["nombre_lugar"].')');
    }
    if($_SESSION["idmodulo_sistema"]==3){
      $p_cabecera->reemplaza("titulo",'(Modular)');
    }
    if($_SESSION["idmodulo_sistema"]==10){
      $p_cabecera->reemplaza("titulo",'Log&iacute;stica');
    }	return $p_cabecera->getPlantillaCadena();
}
?>