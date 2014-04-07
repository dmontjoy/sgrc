<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of idocumento_identificacion
 *
 * @author dmontjoy
 */
class imapa {

    //put your code here
    public $sql;

    function imapa() {
        $this->sql = new DmpSql();
    }
                 
    function get_mapa(){
        $consulta = "SELECT 
                            `idgis_mapa` ,
                            `frontera`,
                            `enfoque` ,
                            `resolucion` ,
                            `proyeccion` ,
                            `unidad` ,  
                            `nombre` ,
                            predeterminado
                            from gis_mapa 
                            WHERE activo=1 
                            order by predeterminado desc";
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

       return $result; 
    }
    
   function get_capa_mapa($idgis_mapa){
        $consulta = "SELECT 
                            `idgis_capa` ,                            
                            `proyeccion` ,                            
                            `nombre` ,
                            base
                            from gis_capa 
                            WHERE activo=1 
                            AND idgis_mapa=$idgis_mapa
                            order by orden asc";
        $result = $this->sql->consultar($consulta, "sgrc");

       return $result; 
    }

    
}

?>
