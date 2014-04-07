<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class
 *
 * @author dmontjoy
 */
class ipredio {
//put your code here
        //put your code here
    public $sql;

    function ipredio() {
        $this->sql = new DmpSql();
    }
   
   function lista_predio_gis($idpredio, $idmodulo_predio, $idmapa) {
        
        if(isset($idmapa)){
            $cmapa=" gis_mapa.idgis_mapa = $idmapa ";
        }else{
            $cmapa=" gis_mapa.idgis_mapa = ( select idgis_mapa from gis_mapa where activo =1 and predeterminado=1 limit 1)";
        }

        $consulta = "SELECT DISTINCT 
                        `predio`.`idpredio`,
                        `predio`.`nombre`,
                        `predio_gis_item`.`idgis_item`
                      FROM
                        `predio`
                        LEFT OUTER JOIN `predio_gis_item` ON (`predio`.`idpredio` = `predio_gis_item`.`idpredio`)
                        AND (`predio`.`idmodulo_predio` = `predio_gis_item`.`idmodulo_predio`)
                        LEFT OUTER JOIN `gis_item` ON (`predio_gis_item`.`idgis_item` = `gis_item`.`idgis_item`)
                        LEFT OUTER JOIN `gis_capa` ON (`gis_item`.`idgis_capa` = `gis_capa`.`idgis_capa`)
                        LEFT OUTER JOIN `gis_mapa` ON (`gis_capa`.`idgis_mapa` = `gis_mapa`.`idgis_mapa`)
              WHERE
              $cmapa AND
             `predio`.`idpredio`=$idpredio AND
             `predio`.`idmodulo_predio`= $idmodulo_predio
               ";

        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");
        
        $apredio = array();
        
        while($fila=  mysql_fetch_array($result)){
            $apredio['idpredio'][$fila[idpredio]]=$fila[nombre];

            if(isset($fila[idgis_item])){
                $apredio['idgis_item_predio'][$fila[idpredio]][$fila[idgis_item]]=$fila[idgis_item];
                $apredio['idgis_item'][$fila[idgis_item]]=$fila[idgis_item];
            }
           
        }
        //print_r($apredio);
        return $apredio;
    }

     function lista_predio($idpredio="",$idmodulo_predio="",$codigo_predio="",$idpredio_complejo_tag="",$idpredio_sh_complejo="",$idpredio_tipo_tenencia="",$idpredio_proceso_pasos="") {
        /*
         *               WHERE
              $cmapa AND
              predio_sh.activo=1 AND
             `predio_sh`.`idsh`=$idpersona AND
             `predio_sh`.`idmodulo`= $idmodulo
        if(isset($idmapa)){
            $cmapa=" gis_mapa.idgis_mapa = $idmapa ";
        }else{
            $cmapa=" gis_mapa.idgis_mapa = ( select idgis_mapa from gis_mapa where activo =1 and predeterminado=1 limit 1)";
        }
        
        */
         $cpredio_tipo_tenencia="";
         if(!empty($idpredio_tipo_tenencia)){
             //echo "nuevo ".$idpredio_tipo_tenencia;
             $cpredio_tipo_tenencia=" AND predio_tipo_tenencia.idpredio_tipo_tenencia = $idpredio_tipo_tenencia ";
         }
         
         $cpredio_proceso_pasos="";
         if(!empty($idpredio_proceso_pasos)){
             
             $cpredio_proceso_pasos=" AND predio_proceso_pasos_predio.idpredio_proceso_pasos IN ( ";
             
             foreach ($idpredio_proceso_pasos as $valor){

                      $cpredio_proceso_pasos.= "'".$valor."',";                    
                  
              }            
              $cpredio_proceso_pasos = substr($cpredio_proceso_pasos, 0, -1);
              
              $cpredio_proceso_pasos.= " ) ";
         }
         
         $condicion="";
           if(!empty($idpredio)){
              $condicion.=" AND `predio`.`idpredio`='$idpredio' AND `predio`.`idmodulo_predio`='$idmodulo_predio' ";
           }
           if(!empty($codigo_predio)){
               $condicion.=" AND `predio`.`nombre` like '$codigo_predio%'";
           }
           //print_r(count($idpredio_complejo_tag));
           if(!is_array($idpredio_complejo_tag) || count($idpredio_complejo_tag)==0){
               $tags=0;
           }else{
               $tags=count($idpredio_complejo_tag);
           }
           
           if(!is_array($idpredio_sh_complejo) || count($idpredio_sh_complejo)==0){
               $shs=0;
           }else{
               $shs= count($idpredio_sh_complejo);
           }           
        if($tags>0){
              /*$tabla_predio_tag="  LEFT OUTER JOIN `interaccion` ON (`predio`.`idpredio` = `interaccion`.`idpredio`)
                            AND (`predio`.`idmodulo_predio` = `interaccion`.`idmodulo_predio`)
                            LEFT OUTER JOIN `interaccion_tag` ON (`interaccion`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
                            AND (`interaccion`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`) ";
              */
              $cpredio_tag=" AND CONCAT(`tag`.`idtag`,'---',`tag`.`idmodulo_tag`) 
                              IN ( ";
              foreach ($idpredio_complejo_tag as $valor){
                  if(strpos($valor, "###")){
                      $tags--;
                  }else{
                      $cpredio_tag.= "'".$valor."',";                    
                  }
              }
              $cpredio_tag = substr($cpredio_tag, 0, -1);
              
              $cpredio_tag.= " ) ";
              /*
              $cpredio_tag.= " ) AND predio_tag.activo=1
                               GROUP BY
                              `predio`.`idpredio`,  `predio`.`idmodulo_predio`
                              HAVING count(*)=$tags"; */
              $cpredio_tag.="AND (`predio_tag`.`activo`=1 or isnull(`predio_tag`.`activo`))"  ;
              if($tags==0){
                  $cpredio_tag="";
              }
             
          }else{
              $cpredio_tag="";
          }
        
          //print_r($idpredio_sh_complejo);
          //echo "shs ".$shs;
          if($shs>0){
              
              /*$tabla_predio_tag="  LEFT OUTER JOIN `interaccion` ON (`predio`.`idpredio` = `interaccion`.`idpredio`)
                            AND (`predio`.`idmodulo_predio` = `interaccion`.`idmodulo_predio`)
                            LEFT OUTER JOIN `interaccion_tag` ON (`interaccion`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
                            AND (`interaccion`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`) ";
              */
              $cpredio_sh=" AND ( CONCAT(`persona`.`idpersona`,'---',`persona`.`idmodulo`) 
                              IN ( ";
              foreach ($idpredio_sh_complejo as $valor){
                  if(strpos($valor, "###")){
                      $shs--;
                  }else{
                      if(strpos($valor, "---")){
                        $aux_predio_sh=explode("---", $valor);
                        $cpredio_sh.= "'".$aux_predio_sh[0]."---".$aux_predio_sh[1]."',";                    
                      }                   
                  }

              }
              $cpredio_sh = substr($cpredio_sh, 0, -1);
             
              $cpredio_sh.= " ) ) AND (predio_sh.activo=1 OR isnull(predio_sh.activo)) ";
               
              /*
              $cpredio_tag.= " ) AND predio_tag.activo=1
                               GROUP BY
                              `predio`.`idpredio`,  `predio`.`idmodulo_predio`
                              HAVING count(*)=$tags"; */
          }else{
              $cpredio_sh="";
          }
          
            $sql="SELECT DISTINCT 
                    `predio`.`idpredio`,
                    `predio`.`nombre` AS `nombre_predio`,
                    `predio`.`direccion`,
                    `predio_tag`.`activo` AS `tag_activo`,
                    predio_tag.prioridad,
                    `tag`.`tag`,
                     predio_archivo.idpredio_archivo,
                     predio_archivo.idmodulo_predio_archivo,
                    `predio_archivo`.`archivo`,
                    `predio_archivo`.`activo` AS `archivo_activo`,
                    `predio_archivo`.`comentario` AS archivo_comentario,
                    predio.comentario AS predio_comentario,
                    `persona`.`apellido_p`,
                    `persona`.`apellido_m`,
                    `persona`.`nombre`,
                    `predio_sh`.`idpredio_sh`,
                    `predio_sh`.`idmodulo_predio_sh`,                    
                    `predio_sh`.`activo` AS predio_sh_activo,
                    `persona`.`idpersona`,
                    `persona`.`idmodulo`,
                    `tag`.`idtag`,
                    `tag`.`idmodulo_tag`,
                    `predio`.`idmodulo_predio`,
                     predio_datum_valor.idpredio_datum,
                    `predio_datum`.`descripcion` AS `predio_datum`,
                    `predio_datum_valor`.`idpredio_datum_valor`,
                    `predio_datum_valor`.`idmodulo_predio_datum_valor`,
                    `predio_datum_valor`.`valor` AS `predio_datum_valor`,
                    `unidades`.`simbolo`,
                    `predio_proceso`.`descripcion` as proceso,
                    `predio_proceso`.`activo`,
                    `predio_proceso_pasos`.`activo`,
                    `predio_proceso_pasos`.`descripcion` as proceso_pasos,
                    `predio_proceso_pasos`.`idpredio_proceso_pasos`,
                    `predio_sh`.`idpredio_tipo_tenencia`,
                    `predio_tipo_tenencia`.`descripcion` AS `predio_tipo_tenencia`,
                    `predio_proceso_pasos_predio`.`activo`,
                    `predio_proceso_pasos_predio`.`idpredio_proceso_pasos_predio`,
                    `predio_proceso_pasos_predio`.`idmodulo_predio_proceso_pasos_predio`
                  FROM
                    `predio`
                    LEFT OUTER JOIN `predio_tag` ON (`predio`.`idpredio` = `predio_tag`.`idpredio`)
                    AND (`predio`.`idmodulo_predio` = `predio_tag`.`idmodulo_predio`)
                    LEFT OUTER JOIN `tag` ON (`tag`.`idtag` = `predio_tag`.`idtag`)
                    AND (`tag`.`idmodulo_tag` = `predio_tag`.`idmodulo_tag`)
                    LEFT OUTER JOIN `predio_archivo` ON (`predio`.`idpredio` = `predio_archivo`.`idpredio`)
                    AND (`predio`.`idmodulo_predio` = `predio_archivo`.`idmodulo_predio`)
                    LEFT OUTER JOIN `predio_sh` ON (`predio`.`idpredio` = `predio_sh`.`idpredio`)
                    AND (`predio`.`idmodulo_predio` = `predio_sh`.`idmodulo_predio`)
                    LEFT OUTER JOIN `sh` ON (`predio_sh`.`idsh` = `sh`.`idsh`)
                    AND (`predio_sh`.`idmodulo` = `sh`.`idmodulo`)
                    LEFT OUTER JOIN `persona` ON (`sh`.`idsh` = `persona`.`idpersona`)
                    AND (`sh`.`idmodulo` = `persona`.`idmodulo`)
                    LEFT OUTER JOIN `predio_tipo_tenencia` ON (`predio_sh`.`idpredio_tipo_tenencia` = `predio_tipo_tenencia`.`idpredio_tipo_tenencia`)
                    LEFT OUTER JOIN `predio_datum_valor` ON (`predio`.`idpredio` = `predio_datum_valor`.`idpredio`)
                    AND (`predio`.`idmodulo_predio` = `predio_datum_valor`.`idmodulo_predio`)
                    LEFT OUTER JOIN `predio_datum` ON (`predio_datum_valor`.`idpredio_datum` = `predio_datum`.`idpredio_datum`)
                    LEFT OUTER JOIN `unidades` ON (`predio_datum`.`idunidades` = `unidades`.`idunidades`)
                    LEFT OUTER JOIN `predio_proceso_pasos_predio` ON (`predio_sh`.`idpredio_sh` = `predio_proceso_pasos_predio`.`idpredio_sh`)
                    AND (`predio_sh`.`idmodulo_predio_sh` = `predio_proceso_pasos_predio`.`idmodulo_predio_sh`)
                    LEFT OUTER JOIN `predio_proceso_pasos` ON (`predio_proceso_pasos`.`idpredio_proceso_pasos` = `predio_proceso_pasos_predio`.`idpredio_proceso_pasos`)
                    LEFT OUTER JOIN `predio_proceso` ON (`predio_proceso_pasos`.`idpredio_proceso` = `predio_proceso`.`idpredio_proceso`)
                   WHERE
                      (`predio_datum_valor`.`activo`=1 or isnull(`predio_datum_valor`.`activo`)) AND
                      (predio_proceso_pasos.activo=1 or isnull(predio_proceso_pasos.activo)) AND
                      (predio_proceso.activo=1 or isnull(predio_proceso.activo)) AND
                      (predio_tipo_tenencia.activo=1 or isnull(predio_tipo_tenencia.activo)) AND
                     ( `predio_proceso_pasos_predio`.`activo`=1 or isnull(`predio_proceso_pasos_predio`.`activo`)) 
                     $condicion $cpredio_tag $cpredio_sh $cpredio_tipo_tenencia $cpredio_proceso_pasos";
            
         //(`predio_archivo`.`activo`=1 OR isnull(`predio_archivo`.activo)) AND
         //(`predio_tag`.`activo`=1 or isnull(`predio_tag`.`activo`)) AND
         //AND (predio_sh.activo=1 OR isnull(predio_sh.activo))
        //echo $cpredio_tag;
        $result = $this->sql->consultar($sql, "sgrc");
        
        $apredio = array();
        
        while($fila=  mysql_fetch_array($result)){
            $apredio['nombre_predio'][$fila[idpredio]."***".$fila[idmodulo_predio]]=$fila[nombre_predio];
            $apredio['direccion'][$fila[idpredio]."***".$fila[idmodulo_predio]]=$fila[direccion];
            $apredio['predio_comentario'][$fila[idpredio]."***".$fila[idmodulo_predio]]=$fila[predio_comentario];
                     
            /*if(isset($fila[idgis_item])){
                $apredio['idgis_item_predio'][$fila[idpredio]][$fila[idgis_item]]=$fila[idgis_item];
                $apredio['idgis_item'][$fila[idgis_item]]=$fila[idgis_item];
            }*/
           if ($fila[archivo_activo] != "" && $fila[archivo_activo] != 0 ) {
            $apredio['archivo'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpredio_archivo] . "-" . $fila[idmodulo_predio_archivo]] = $fila[archivo];                
           }
            if(isset($fila[idpredio_datum_valor])){
             
                $apredio['predio_datum_valor'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpredio_datum_valor]."***".$fila[idmodulo_predio_datum_valor]]=$fila[predio_datum_valor];
                $apredio['predio_datum'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpredio_datum_valor]."***".$fila[idmodulo_predio_datum_valor]]=$fila[predio_datum];
                $apredio['simbolo'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpredio_datum_valor]."***".$fila[idmodulo_predio_datum_valor]]=$fila[simbolo];
                $apredio['idpredio_datum'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpredio_datum_valor]."***".$fila[idmodulo_predio_datum_valor]]=$fila[idpredio_datum];
            }
            
            if($fila[tag_activo] != "" && $fila[tag_activo] != 0 ) {
            //        if(isset($fila[idtag])){
                       //$apredio['tag'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idtag]."***".$fila[idmodulo_tag]]=$fila[tag];
                       $apredio['tag'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idtag]."***".$fila[idmodulo_tag]]=$fila[tag];
                       $apredio['prioridad'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idtag]."***".$fila[idmodulo_tag]]=$fila[tag];
             //       }
             }
             /***sh*****/
            if($fila[predio_sh_activo] != "" && $fila[predio_sh_activo] != 0 ) {
            //if(!empty($fila[idpersona])){
                //echo $fila[idpersona]."***".$fila[idmodulo].' '.$fila[idpredio]."***".$fila[idmodulo_predio];
                //sizeof($apredio['sh'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]);
                $apredio['sh'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]=$fila[apellido_p]." ".$fila[apellido_m]." ".$fila[nombre];
                $apredio['idpredio_sh'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]=$fila[idpredio_sh];
                $apredio['idmodulo_predio_sh'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]=$fila[idmodulo_predio_sh];
                
              
                $apredio['tipo_tenencia'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]=$fila[predio_tipo_tenencia];
                $apredio['idpredio_tipo_tenencia'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]=$fila[idpredio_tipo_tenencia];
                $apredio['idpredio_proceso_pasos'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]=$fila[idpredio_proceso_pasos];

                $apredio['predio_proceso_pasos'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpersona]."***".$fila[idmodulo]]=$fila[proceso_pasos];
            //}
            }
            
        }
        //print_r($apredio);
        return $apredio;
    }
   function lista_tag($idpredio,$idmodulo_predio){
        
        $consulta="SELECT 
                    `tag`.`tag`,
                    `predio_tag`.`activo`,
                    `tag`.`activo`,
                    `predio_tag`.`idtag`,
                    `predio_tag`.`idmodulo_tag`,
                    `predio_tag`.`idpredio`,
                    predio_tag.idpredio_tag,
                    `predio_tag`.`idmodulo_predio_tag`,
                    `predio_tag`.`prioridad`
                    FROM
                    `predio_tag`
                    INNER JOIN `tag` ON (`predio_tag`.`idtag` = `tag`.`idtag`)
                    AND (`predio_tag`.`idmodulo_tag` = `tag`.`idmodulo_tag`)
                    INNER JOIN `predio` ON (`predio_tag`.`idpredio` = `predio`.`idpredio`)
                    WHERE
                    `predio`.`activo`= 1 AND
                    `predio_tag`.`activo`=1 AND
                    `predio_tag`.`idpredio` = $idpredio AND
                    predio_tag.idmodulo_predio = $idmodulo_predio
                    order by prioridad desc";
        //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    function lista_predio_proceso_pasos(){
        
        $sql="SELECT 
                `predio_proceso_pasos`.`descripcion` AS predio_proceso_pasos,
                `predio_proceso_pasos`.`activo`,
                `predio_proceso`.`activo`,
                `predio_proceso_pasos`.`idpredio_proceso_pasos`,
                `predio_proceso`.`idpredio_proceso`,
                predio_proceso_pasos.orden
              FROM
                `predio_proceso`
                INNER JOIN `predio_proceso_pasos` ON (`predio_proceso`.`idpredio_proceso` = `predio_proceso_pasos`.`idpredio_proceso`)
             WHERE
               `predio_proceso`.`activo`=1 AND
               `predio_proceso_pasos`.`activo`=1
             ORDER BY
                predio_proceso_pasos.orden ASC";
        
        $result = $this->sql->consultar($sql, "sgrc");
        
        return $result;
        
    }
}
