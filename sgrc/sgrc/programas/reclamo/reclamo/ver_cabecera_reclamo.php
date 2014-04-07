<?php


function ver_cabecera_reclamo($idreclamo,$idmodulo_reclamo){
    
        $ayudante = new Ayudante();
       
        $plantilla_reclamo = new DmpTemplate("../../../plantillas/reclamo/reclamo/reclamo_cabecera.html");
        $plantilla_reclamo->iniciaBloque("codigo_reclamo");
        $plantilla_reclamo->reemplazaEnBloque("idreclamo", $idreclamo, "codigo_reclamo");
        $plantilla_reclamo->reemplazaEnBloque("idmodulo_reclamo", $idmodulo_reclamo, "codigo_reclamo");
        
        $ireclamo = new ireclamo();
        
        $result_reclamo = $ireclamo->get_reclamo($idreclamo,$idmodulo_reclamo);
        
        $fila_reclamo = mysql_fetch_array($result_reclamo);
        
        $plantilla_reclamo->reemplazaEnBloque("fecha_reclamo", $fila_reclamo[fecha], "codigo_reclamo");
        $plantilla_reclamo->reemplazaEnBloque("tipo", $fila_reclamo[tipo], "codigo_reclamo");
        
        $result_fase = $ireclamo->get_fase($idreclamo,$idmodulo_reclamo);
        
        $fila_fase= mysql_fetch_array($result_fase);
        
        $plantilla_reclamo->reemplazaEnBloque("fase", $fila_fase[fase], "codigo_reclamo");
        
        $plantilla_reclamo->reemplaza("reclamo", $fila_reclamo[reclamo], "codigo_reclamo");
        
        if(isset($fila_reclamo[idreclamo_previo]) && $fila_reclamo[idreclamo_previo]>0){                
                $plantilla_reclamo->reemplaza("idreclamo_previo", $fila_reclamo[idreclamo_previo]);
                $plantilla_reclamo->reemplaza("idmodulo_reclamo_previo", $fila_reclamo[idmodulo_reclamo_previo]);
        }
        
        
        $result=$ireclamo->lista_tag_reclamo($idreclamo, $idmodulo_reclamo );
        while($fila=  mysql_fetch_array($result)){
            $tags.= $fila[tag]. " , ";
        }
        $tags= substr($tags, 0, -3);
        
        $plantilla_reclamo->reemplaza("tag", $tags);
         
        $result=$ireclamo->lista_reclamo_sh($idreclamo, $idmodulo_reclamo );
        while($fila=  mysql_fetch_array($result)){
            $shs.= $fila[apellido_p]." ".$fila[apellido_m]." ".$fila[nombre]. " , ";
        }
        
        $shs= substr($shs, 0, -3);
                
        $plantilla_reclamo->reemplaza("sh", $shs);
        
        $result=$ireclamo->lista_reclamo_rc($idreclamo, $idmodulo_reclamo );
        while($fila=  mysql_fetch_array($result)){
            if($fila[idrol]==1){
                $rc1.= $fila[apellido_p]." ".$fila[apellido_m]." ".$fila[nombre]. " , ";
            }else{
                $rc2.= $fila[apellido_p]." ".$fila[apellido_m]." ".$fila[nombre]. " , ";
            }
        }
        
        $rc1= substr($rc1, 0, -3);
        $rc2= substr($rc2, 0, -3);
                
        $plantilla_reclamo->reemplaza("rc1", $rc1);
        $plantilla_reclamo->reemplaza("rc2", $rc2);
        
        return $plantilla_reclamo->getPlantillaCadena();
}


?>


