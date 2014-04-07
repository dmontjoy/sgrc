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
class iinteraccion {
    //put your code here
    public $sql;
	
    function iinteraccion(){
            $this->sql = new DmpSql();
    }  
    
    
    function  get_interaccion($idinteraccion,$idmodulo){
     /*
                  interaccion.idpredio,
                  interaccion.idmodulo_predio,
                  predio.nombre,
                  predio.direccion
      *       */
      $consulta="SELECT 
                  DATE_FORMAT(interaccion.fecha,'%d/%m/%Y') AS fecha,
                  `interaccion`.`interaccion`,
                  `interaccion`.`activo`,
                  `interaccion`.`idinteraccion`,
                  `interaccion`.`idmodulo_interaccion`,
                  `interaccion`.`idinteraccion_estado`,
                  `interaccion`.`idinteraccion_tipo`,
                  `interaccion`.`idusu_c`,
                  `interaccion`.`fecha_c`,
                  `interaccion`.`idinteraccion_prioridad`,
                  `interaccion`.`comentario`,
                  `interaccion_tipo`.`interaccion_tipo`,
                  `interaccion_estado`.`interaccion_estado`,
                  interaccion.duracion_minutos
                FROM
                  `interaccion`                
                LEFT JOIN `interaccion_tipo`
                ON  `interaccion`.`idinteraccion_tipo`=`interaccion_tipo`.`idinteraccion_tipo`
                LEFT JOIN `interaccion_estado`
                ON  `interaccion`.`idinteraccion_estado`=`interaccion_estado`.`idinteraccion_estado` 
                WHERE
                   `interaccion`.`idinteraccion`= $idinteraccion AND
                   `interaccion`.`idmodulo_interaccion` =  $idmodulo ";
        //echo $consulta;
      /*
                LEFT OUTER JOIN `predio` ON (`interaccion`.`idpredio` = `predio`.`idpredio`)
                AND (`interaccion`.`idmodulo_predio` = `predio`.`idmodulo_predio`)
       *        */
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;   
        
        
    }


    function lista_tag_interaccion($idinteraccion,$idmodulo){
        
        $consulta="SELECT 
                    `tag`.`tag`,
                    `interaccion_tag`.`activo`,
                    `tag`.`activo`,
                    `interaccion_tag`.`idtag`,
                    `interaccion_tag`.`idmodulo_tag`,
                    `interaccion_tag`.`idinteraccion`,
                    `interaccion_tag`.`idmodulo_interaccion`,
                    interaccion_tag.idinteraccion_tag,
                    `interaccion_tag`.`idmodulo_interaccion_tag`,
                    `interaccion_tag`.`prioridad`
                    FROM
                    `interaccion_tag`
                    INNER JOIN `tag` ON (`interaccion_tag`.`idtag` = `tag`.`idtag`)
                    AND (`interaccion_tag`.`idmodulo_tag` = `tag`.`idmodulo_tag`)
                    INNER JOIN `interaccion` ON (`interaccion_tag`.`idmodulo_interaccion` = `interaccion`.`idmodulo_interaccion`)
                    AND (`interaccion_tag`.`idinteraccion` = `interaccion`.`idinteraccion`)
                    WHERE
                    `interaccion`.`activo`= 1 AND
                    `interaccion_tag`.`activo`=1 AND
                    `interaccion_tag`.`idinteraccion` = $idinteraccion AND
                    `interaccion_tag`.`idmodulo_interaccion` = $idmodulo
                    order by prioridad desc";
        //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista_interaccion_sh($idinteraccion,$idmodulo){
        //lista los sh de una interaccion
        $consulta="SELECT 
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      `persona`.`nombre`,
                      `persona`.`activo`,
                      `persona`.`idpersona_tipo`,
                      `sh`.`activo`,
                      `sh`.`idsh`,
                      `interaccion_sh`.`idinteraccion_sh`,
                      `interaccion_sh`.`idmodulo_interaccion_sh`,
                      (
                    SELECT  `dimension_matriz_sh_valor`.`puntaje`
                    FROM  `dimension_matriz_sh_valor`
                    LEFT JOIN  `sh_dimension_matriz_sh`
                    ON  `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`= `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`
                    LEFT JOIN `sh_dimension`
                    ON `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
                    AND `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
                    WHERE 
                    `sh_dimension`.`ultimo`=1
                    AND 
                    `sh_dimension`.`idsh`=`sh`.`idsh`
                    AND
                    `sh_dimension`.`idmodulo`=`sh`.`idmodulo`
                    AND
                    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=1 limit 1
                    
                    ) AS 'posicion'
                    FROM
                      `interaccion`
                      INNER JOIN `interaccion_sh` ON (`interaccion`.`idinteraccion` = `interaccion_sh`.`idinteraccion`)
                      AND (`interaccion`.`idmodulo_interaccion` = `interaccion_sh`.`idmodulo_interaccion`)
                      INNER JOIN `sh` ON (`interaccion_sh`.`idsh` = `sh`.`idsh`)
                      AND (`interaccion_sh`.`idmodulo` = `sh`.`idmodulo`)
                      INNER JOIN `persona` ON (`sh`.`idsh` = `persona`.`idpersona`)
                      AND (`sh`.`idmodulo` = `persona`.`idmodulo`)
                    WHERE
                    `interaccion`.`activo`= 1 AND 
                    `interaccion_sh`.`activo`= 1 AND
                    `sh`.`activo`= 1 AND 
                    `persona`.`activo`= 1 AND 
                    `interaccion`.`idinteraccion` = $idinteraccion AND
                    `interaccion`.`idmodulo_interaccion` = $idmodulo";
        
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
  
        function lista_interaccion_rc($idinteraccion,$idmodulo){
        
        $consulta="SELECT distinct
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      `persona`.`nombre`,
                      `persona`.`activo`,
                      `interaccion_rc`.`activo`,
                      `interaccion`.`idinteraccion`,
                      `interaccion`.`idmodulo_interaccion`,
                      `interaccion_rc`.`idmodulo_interaccion_rc`,
                      `interaccion_rc`.`idinteraccion_rc`
                    FROM
                      `interaccion`
                      INNER JOIN `interaccion_rc` ON (`interaccion`.`idinteraccion` = `interaccion_rc`.`idinteraccion`)
                      AND (`interaccion`.`idmodulo_interaccion` = `interaccion_rc`.`idmodulo_interaccion`)
                     INNER JOIN `rc` ON (`interaccion_rc`.`idrc` = `rc`.`idrc`)
                      AND (`interaccion_rc`.`idmodulo` = `rc`.`idmodulo`)
                      INNER JOIN `persona` ON (`interaccion_rc`.`idrc` = `persona`.`idpersona`)
                      AND (`interaccion_rc`.`idmodulo` = `persona`.`idmodulo`)
                    WHERE
                    `interaccion`.`activo`= 1 AND 
                    `interaccion_rc`.`activo`= 1 AND
                    `rc`.`activo`= 1 AND
                    `persona`.`activo`= 1 AND 
                    `interaccion`.`idinteraccion` = $idinteraccion AND
                    `interaccion`.`idmodulo_interaccion` = $idmodulo";
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
     function lista_archivo($idinteraccion,$idmodulo){
        
        $consulta="SELECT 
                      `interaccion_archivo`.`idinteraccion_archivo`,  
                      `interaccion_archivo`.`idmodulo_interaccion_archivo`,  
                      `interaccion_archivo`.`archivo`,
                      `interaccion_archivo`.`fecha_c`,
                      `interaccion_archivo`.`activo`
                      
                    FROM
                      `interaccion_archivo`
                      
                    WHERE
                    `interaccion_archivo`.`idinteraccion` = $idinteraccion AND
                    `interaccion_archivo`.`idmodulo_interaccion` = $idmodulo AND
                    `interaccion_archivo`.`activo` = 1 ";
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista($idinteraccion="",$idmodulo_interaccion="",$idinteraccion_estado,$prioridades=array(),$tipos=array(),$fecha_del="",$fecha_al="",$idinteraccion_complejo_tag=array(),$idinteraccion_complejo_rc=array(),$idinteraccion_complejo_sh=array(),$interaccion=""){
        
        /*
        if( $idinteraccion!="" && $idmodulo_interaccion!="" ){
            $cidinteraccion="AND `interaccion`.`idinteraccion`=$idinteraccion
                             AND `interaccion`.`idmodulo_interaccion`=$idmodulo_interaccion";
            
        }else{
            $cidinteraccion="";
        }
        */
        
        if( $idinteraccion!="" || $idmodulo_interaccion!="" ){
            $cidinteraccion ="AND CONCAT(`interaccion`.`idinteraccion`,'-',`interaccion`.`idmodulo_interaccion`) like '%$idinteraccion%-$idmodulo_interaccion%' ";            
        }else{
            $cidinteraccion="";
        }
        
        $cant = count($idinteraccion_estado);
                        
        if($cant>0){
            $cidinteraccion_estado=" AND `interaccion`.`idinteraccion_estado` 
                            IN ( ";
            foreach ($idinteraccion_estado as $valor){
               
                    $cidinteraccion_estado.= "'".$valor."',";                    
                
            }
            $cidinteraccion_estado = substr($cidinteraccion_estado, 0, -1);
            
            $cidinteraccion_estado.= " ) "; 
                       
        }else{
            $cidinteraccion_estado="";
        }
                       
        $cant = count($prioridades);
                        
        if($cant>0){
            $cidinteraccion_prioridad=" AND `interaccion`.`idinteraccion_prioridad` 
                            IN ( ";
            foreach ($prioridades as $valor){
               
                    $cidinteraccion_prioridad.= "'".$valor."',";                    
                
            }
            $cidinteraccion_prioridad = substr($cidinteraccion_prioridad, 0, -1);
            
            $cidinteraccion_prioridad.= " ) "; 
                       
        }else{
            $cidinteraccion_prioridad="";
        }
        
        $cant = count($tipos);
                        
        if($cant>0){
            $cidinteraccion_tipo= " AND `interaccion`.`idinteraccion_tipo` 
                            IN ( ";
            foreach ($tipos as $valor){
                    
                    $cidinteraccion_tipo.= "$valor,";                    
                
            }
            $cidinteraccion_tipo = substr($cidinteraccion_tipo, 0, -1);
            
            $cidinteraccion_tipo.= " ) "; 
                       
        }else{
            $cidinteraccion_tipo="";
        }
        
        if($fecha_del!="" && $fecha_al!=""){
            $ayudante = new Ayudante();
            $fecha_del = $ayudante->FechaRevezMysql($fecha_del,"/");
            $fecha_al = $ayudante->FechaRevezMysql($fecha_al,"/");
            $cfecha=" AND `interaccion`.`fecha`>='$fecha_del' AND `interaccion`.`fecha`<='$fecha_al'";
        }else{
            $cfecha="";
        }
        
        $tags = count($idinteraccion_complejo_tag);
                        
        if($tags>0){
            $cinteraccion_tag=" ,
					(
                    SELECT COUNT(*)
                    FROM `interaccion_tag` 
                    WHERE (`interaccion`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
                    AND (`interaccion`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`)
                    AND CONCAT(`interaccion_tag`.`idtag`,'---',`interaccion_tag`.`idmodulo_tag`) 
		    IN ( ";
            foreach ($idinteraccion_complejo_tag as $valor){
                if(strpos($valor, "###")){
                    $tags--;
                }else{
                    $cinteraccion_tag.= "'".$valor."',";                    
                }
            }
            $cinteraccion_tag = substr($cinteraccion_tag, 0, -1);
            
            $cinteraccion_tag.= " ) AND `interaccion_tag`.`activo`=1) as 'tags' ";
                            
            if($tags==0){
                $cinteraccion_tag="";
            }
            
        }else{
            $cinteraccion_tag="";
        }
        
        $rcs = count($idinteraccion_complejo_rc);
                        
        if($rcs>0){
            $cinteraccion_rc=" ,
                    (
                    SELECT COUNT(*)
                    FROM `interaccion_rc` 
                    WHERE (`interaccion`.`idinteraccion` = `interaccion_rc`.`idinteraccion`)
                    AND (`interaccion`.`idmodulo_interaccion` = `interaccion_rc`.`idmodulo_interaccion`)
                    AND CONCAT(`interaccion_rc`.`idrc`,'---',`interaccion_rc`.`idmodulo`) 
                    IN (  ";
            foreach ($idinteraccion_complejo_rc as $valor){
                if(strpos($valor, "###")){
                    $rcs--;
                }else{
                    $aux_valor = explode("---", $valor);
                    $cinteraccion_rc.= "'$aux_valor[0]---$aux_valor[1]',";  
                    
                }
            }
            $cinteraccion_rc = substr($cinteraccion_rc, 0, -1);
            
            $cinteraccion_rc.= " ) AND `interaccion_rc`.`activo`=1  ) as 'rcs'";
                            
            if($rcs==0){
                $cinteraccion_rc="";
            }
            
        }else{
            $cinteraccion_rc="";
        }
        
        $shs = count($idinteraccion_complejo_sh);
                        
        if($shs>0){
            $cinteraccion_sh=" ,
                    (
                    SELECT COUNT(*)
                    FROM `interaccion_sh` 
                    WHERE (`interaccion`.`idinteraccion` = `interaccion_sh`.`idinteraccion`)
                    AND (`interaccion`.`idmodulo_interaccion` = `interaccion_sh`.`idmodulo_interaccion`)
                    AND CONCAT(`interaccion_sh`.`idsh`,'---',`interaccion_sh`.`idmodulo`) 
                    IN (  ";
            foreach ($idinteraccion_complejo_sh as $valor){
                if(strpos($valor, "###")){
                    $shs--;
                }else{
                    $aux_valor = explode("---", $valor);
                    $cinteraccion_sh.= "'$aux_valor[0]---$aux_valor[1]',";  
                    
                }
            }
            $cinteraccion_sh = substr($cinteraccion_sh, 0, -1);
            
            $cinteraccion_sh.= " ) AND `interaccion_sh`.`activo`=1  ) as 'shs'";
                            
            if($shs==0){
                $cinteraccion_sh="";
            }
            
        }else{
            $cinteraccion_sh="";
        }
        
        if($interaccion!=""){
            $cinteraccion=" AND `interaccion`.`interaccion` LIKE '%$interaccion%' ";
        }
                                
        $consulta="SELECT                                             
                      `interaccion`.`idinteraccion`,
                      `interaccion`.`idmodulo_interaccion`,
                      `interaccion`.`idusu_c`,
                      `interaccion`.`idmodulo_c`,
                      `interaccion`.`interaccion`,
                      `interaccion`.`idinteraccion_prioridad`,
                      `interaccion_tipo`.`interaccion_tipo`,
                      `interaccion_estado`.`interaccion_estado`,
                      `interaccion`.`fecha`,
                      (select count(*) from interaccion_archivo
                       where interaccion_archivo.activo=1
                       AND interaccion_archivo.idinteraccion=interaccion.idinteraccion
                       AND interaccion_archivo.idmodulo_interaccion=interaccion.idmodulo_interaccion
                      ) as archivos,                      
                      (select count(distinct interaccion_sh2.idinteraccion, interaccion_sh2.idmodulo_interaccion) 
                       from predio_gis_item as predio_gis_item2
                       left join predio_sh as predio_sh2 
                       on predio_gis_item2.idpredio=predio_sh2.idpredio
                       left join interaccion_sh as interaccion_sh2
                       on predio_sh2.idsh=interaccion_sh2.idsh
                       and predio_sh2.idmodulo=interaccion_sh2.idmodulo
                       where predio_gis_item.idgis_item=predio_gis_item2.idgis_item
                       
                      ) as interacciones,                                                                  
                      `predio_gis_item`.`idgis_item`
                       $cinteraccion_tag
                       $cinteraccion_rc
                       $cinteraccion_sh
                    FROM    `interaccion` 
                    LEFT JOIN   `interaccion_tipo`
                    ON   `interaccion`.`idinteraccion_tipo`= `interaccion_tipo`.`idinteraccion_tipo`
                    LEFT JOIN   `interaccion_estado`
                    ON   `interaccion`.`idinteraccion_estado`= `interaccion_estado`.`idinteraccion_estado`
                    LEFT OUTER JOIN `interaccion_sh` ON (`interaccion_sh`.`idinteraccion` = `interaccion`.`idinteraccion`)
                    AND (`interaccion_sh`.`idmodulo_interaccion` = `interaccion`.`idmodulo_interaccion`)
                    LEFT OUTER JOIN `predio_sh` ON (`interaccion_sh`.`idsh` = `predio_sh`.`idsh`)
                    AND (`interaccion_sh`.`idmodulo` = `predio_sh`.`idmodulo`)
                    LEFT OUTER JOIN `predio_gis_item` ON (`predio_sh`.`idpredio` = `predio_gis_item`.`idpredio`)
                    WHERE
                    `interaccion`.`activo`= 1 
                    $cidinteraccion $cidinteraccion_estado $cidinteraccion_prioridad $cidinteraccion_tipo $cfecha $cinteraccion";
        
        
        $total=$tags+$rcs+$shs;
        if($total>0){
            
            $consulta.= "  HAVING 1=1 ";
            if($tags>0)$consulta.=" AND tags>=$tags "; 
            if($rcs>0) $consulta.=" AND rcs>=$rcs "; 
            if($shs>0) $consulta.=" AND shs>=$shs "; 
        }
        //modifico el order by para recorrerlo en forma secuencial por el id de interaccion / modulo interaccion
        $consulta .= " ORDER BY interaccion.idinteraccion, interaccion.idmodulo_interaccion, fecha ASC";
        
        //echo $consulta;
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    
   
}

function lista_interaccion_predio(){
    
    
}

?>
