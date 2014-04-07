<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of apredio_mapa
 *
 * @author dmontjoy
 */
function ver_buscar_mapa($fid_string=" ",$presenta=0,$idmapa=0,$intensidad){
    
    $plantilla = new DmpTemplate("../../../plantillas/stakeholder/mapa/ver_mapa.html");
    
    //echo "intensidad : $intensidad";
    
    if($intensidad>0){
        $plantilla->iniciaBloque("intensidad");
    }
     
    $imapa = new imapa();
    
    $result1 = $imapa->get_mapa();
    
    $nombres = array();
    
    $count=0;
    
    $modo=0;
    
    $color=array("#B19CD9","#FF6961","#77DD77","#CFCFC4","#FDFD96");
    
    $stroke=array("#966FD6","#C23B22","#03C03C","#836953","#FFB347");
    
    while($mapa=  mysql_fetch_array($result1)){
        $count++;
        
        $plantilla->iniciaBloque("mapa");
        $plantilla->reemplazaEnBloque("idmapa", $mapa[idgis_mapa],"mapa");
        $plantilla->reemplazaEnBloque("nombre", $mapa[nombre],"mapa");
        
        if( $mapa[idgis_mapa]==$idmapa || ( $mapa[predeterminado]>0 && $idmapa==0 )  ){
            
            $plantilla->reemplazaEnBloque("selected", "selected","mapa");
            
            $plantilla->reemplaza("frontera", $mapa[frontera]);
            $plantilla->reemplaza("enfoque", $mapa[enfoque]);
            $plantilla->reemplaza("resolucion", $mapa[resolucion]);
            $plantilla->reemplaza("proyeccion", $mapa[proyeccion]);
            $plantilla->reemplaza("unidad", $mapa[unidad]);

            $i=0;
            $nombre="";
            $result2 = $imapa->get_capa_mapa($mapa[idgis_mapa]);
            while($capa=  mysql_fetch_array($result2)){
                $nombre=$capa[nombre];
                $nombres[$nombre]=$nombre;
                if($modo>0){
                    $plantilla->iniciaBloque("capa");
                    $plantilla->reemplazaEnBloque("i", $i, "capa");

                    $plantilla->reemplazaEnBloque("nombre", $nombre, "capa");


                    $plantilla->reemplazaEnBloque("proyeccion", $capa[proyeccion], "capa");
                    if($capa[base]>0){
                        $plantilla->reemplazaEnBloque("base", "true", "capa");
                    }else{
                        
                        $plantilla->reemplazaEnBloque("base", "false", "capa");
                    }
                }else{
                    $plantilla->iniciaBloque("gml");                    
                    $plantilla->reemplazaEnBloque("i", $i, "gml");
                    $plantilla->reemplazaEnBloque("nombre", $nombre, "gml");
                    $plantilla->reemplazaEnBloque("color", $color[($i%5)], "gml");
                    $plantilla->reemplazaEnBloque("stroke", $stroke[($i%5)], "gml");
                    if($capa[base]>0){
                        $plantilla->reemplazaEnBloque("base", "true", "gml");
                    }else{                        
                        $plantilla->reemplazaEnBloque("base", "false", "gml");
                    }
                } 
                $i++;
            }
            $capas=" ";

            foreach ($nombres as $nombre){
                $capas .= $nombre.",";
            }


            $capas = substr($capas, 0, -1);


            $plantilla->reemplaza("i", $i);
            $plantilla->reemplaza("nombre", $nombre);
            $plantilla->reemplaza("capas", $capas);
            $plantilla->reemplaza("fid_string", $fid_string);
        
        }
        
        
    }
    
    if($count==0){
        $plantilla = new DmpTemplate("../../../plantillas/stakeholder/mapa/no_mapa.html");
    }
    
    if($presenta>0){
        $plantilla->presentaPlantilla();
    }else{
        return $plantilla->getPlantillaCadena();
    }
    
}
?>