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
class istakeholder {

    //put your code here
    public $sql;

    function istakeholder() {
        $this->sql = new DmpSql();
    }

    function total(){  
        $consulta ="SELECT count(*) AS cantidad FROM sh WHERE sh.activo=1";
        $result = $this->sql->consultar($consulta, "sgrc");
        $fila=  mysql_fetch_array($result);
        $cantidad=  $fila['cantidad'];
        return $cantidad;         
    }
    
    function lista_stakeholder_compromiso($idpersona, $idmodulo) {
        $consulta = "SELECT
            `interaccion_sh`.`principal`,
            `interaccion_sh`.`activo`,
            `compromiso`.`idinteraccion`,
            `compromiso`.`idmodulo_interaccion`,
            `compromiso`.`idcompromiso_prioridad`,
            `compromiso`.`idcompromiso_estado`,
            `compromiso`.`compromiso`,
            `compromiso`.`fecha`,
            `compromiso`.`activo`,
            `compromiso`.`idcompromiso`,
            `compromiso`.`idmodulo_compromiso`,
            `compromiso`.`idusu`,
            `compromiso`.`fecha_c`
            FROM
            `interaccion_sh`
            INNER JOIN `compromiso` ON (`interaccion_sh`.`idinteraccion` = `compromiso`.`idinteraccion`)
            AND (`interaccion_sh`.`idmodulo_interaccion` = `compromiso`.`idmodulo_interaccion`)
            WHERE
                 `persona`.`activo`=1 AND
                 `sh`.`activo`=1 AND
                 persona.idpersona=$idpersona AND
                 interaccion_sh.activo=1 AND
                 persona.idmodulo=$idmodulo
            ORDER BY
                `interaccion`.`idinteraccion` DESC";
    }
 
            
    function lista_stakeholder_interaccion($id, $idmodulo, $inicio = 0, $persona = 0, $idsh_compuesto=array(),$idpredio="",$idmodulo_predio="") {
        if(!is_array($idsh_compuesto) || count($idsh_compuesto)==0){
            $cant=0;
        }else{
            $cant=1;
        }
        
        //echo "predio".$idpredio." - ".$idmodulo_predio;
        //echo "cant ".$cant;
        if(!empty($idpredio)){
            /*con coma*/
            //echo "entra predio";
            $campo_idpredio=" predio.`idpredio`, ";
            $campo_idmodulo_predio=" `predio`.`idmodulo_predio`, ";
            $tabla_predio="  LEFT OUTER JOIN `predio` ON (`interaccion`.`idpredio` = `predio`.`idpredio`) AND (`interaccion`.`idmodulo_predio` = `predio`.`idmodulo_predio`) ";
            $where_predio=" AND predio.`idpredio` = '$idpredio' AND predio.idmodulo_predio='$idmodulo_predio' ";
            
        }else{
            // no venga de predio no muestre resultados de predio 
           $where_predio=" AND isnull(interaccion.`idpredio`)AND isnull(interaccion.idmodulo_predio) "; 
        }
                        
        if($cant>0){
            $cidsh_compuesto=" AND CONCAT(`interaccion`.`idinteraccion`,'-', `interaccion`.`idmodulo_interaccion`)
                IN ( SELECT CONCAT(`interaccion_sh`.`idinteraccion`,'-', `interaccion_sh`.`idmodulo_interaccion`)
                from interaccion_sh
                WHERE 
                CONCAT(interaccion_sh.idsh,'-',interaccion_sh.idmodulo)
                            IN ( ";
            foreach ($idsh_compuesto as $valor){
               
                    $cidsh_compuesto.= "'".$valor."',";                    
                
            }
            $cidsh_compuesto = substr($cidsh_compuesto, 0, -1);
            
            $cidsh_compuesto.= " ) ) "; 
                       
        }else{
            $cidsh_compuesto="";
        }
        
        //echo "$id, $idmodulo, $inicio , $persona ";
        //persona 1, item 0
        //lista stakeholder, pues puede ser una stakeholder como un rc
        // `sh`.`activo`= 1, lo que quitado pero podria ir
        $limite = "";
        //tipo de persona
        if ($persona == 0) {
            //rc
            //$condicion = " persona1.idpersona= $id AND persona1.idmodulo= $idmodulo AND  interaccion_rc.principal = 1 AND ";
            $condicion = "";
            
        }elseif ($persona == 1) {
            //sh
            //$condicion = " persona.idpersona= $id AND persona.idmodulo= $idmodulo AND interaccion_sh.`principal`=1 AND";
            $condicion = " CONCAT(`interaccion`.`idinteraccion`, '-', `interaccion`.`idmodulo_interaccion`) 
                          IN(SELECT 
                             CONCAT(`idinteraccion`,'-' ,`idmodulo_interaccion`) AS `FIELD_1`
                             FROM
                            `interaccion_sh`
                          WHERE idsh=$id AND idmodulo=$idmodulo AND activo=1) AND ";
            
        } elseif ($persona == 2) {
            //rc
            //$condicion = " persona1.idpersona= $id AND persona1.idmodulo= $idmodulo AND  interaccion_rc.principal = 1 AND ";
            $condicion = " persona1.idpersona= $id AND persona1.idmodulo= $idmodulo AND  ";
        } else {
            $condicion = " interaccion.idinteraccion= $id AND interaccion.idmodulo_interaccion= $idmodulo AND  ";
        }

        if ($inicio != 0) {

            $limite = "LIMIT 0,$inicio ";
        }
        
        $consulta = "SELECT count(distinct `interaccion`.idinteraccion, `interaccion`.idmodulo_interaccion) as total
                FROM
                  `interaccion`
                  LEFT OUTER JOIN `interaccion_sh` ON (`interaccion_sh`.`idinteraccion` = `interaccion`.`idinteraccion`)
                  AND (`interaccion_sh`.`idmodulo_interaccion` = `interaccion`.`idmodulo_interaccion`)
                  LEFT OUTER JOIN `sh` ON (`sh`.`idsh` = `interaccion_sh`.`idsh`)
                  AND (`sh`.`idmodulo` = `interaccion_sh`.`idmodulo`)
                  LEFT OUTER JOIN `persona` ON (`persona`.`idpersona` = `sh`.`idsh`)
                  AND (`persona`.`idmodulo` = `sh`.`idmodulo`)
                  LEFT OUTER JOIN `compromiso` ON (`interaccion_sh`.`idinteraccion` = `compromiso`.`idinteraccion`)
                  AND (`interaccion_sh`.`idmodulo_interaccion` = `compromiso`.`idmodulo_interaccion`)
                  LEFT OUTER JOIN `interaccion_rc` ON (`interaccion`.`idinteraccion` = `interaccion_rc`.`idinteraccion`)
                  AND (`interaccion`.`idmodulo_interaccion` = `interaccion_rc`.`idmodulo_interaccion`)
                  LEFT OUTER JOIN `rc` ON (`interaccion_rc`.`idrc` = `rc`.`idrc`)
                  AND (`interaccion_rc`.`idmodulo` = `rc`.`idmodulo`)
                  LEFT OUTER JOIN `persona` `persona1` ON (`rc`.`idrc` = `persona1`.`idpersona`)
                  AND (`rc`.`idmodulo` = `persona1`.`idmodulo`)
                  $tabla_predio
               WHERE
                `persona`.`activo`= 1
                 AND $condicion 
                 interaccion.activo= 1 AND
                 interaccion_sh.activo= 1 AND
                 interaccion_rc.activo= 1 $cidsh_compuesto 
              ";

        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");
        
        $fila = mysql_fetch_array($result);
        
        $ainteraccion['total'] = $fila[total];
        
        //lista las interaccions con un stakeholder
        $consulta = "SELECT distinct
                 DATE_FORMAT(interaccion.fecha,'%d/%m/%Y') AS fecha,
                   $campo_idpredio
                   $campo_idmodulo_predio
                  `interaccion`.`interaccion`,
                  `interaccion`.`idusu_c`,
                  `interaccion`.`idmodulo_c`,
                  `interaccion`.`activo`,
                  `sh`.`activo`,
                  `persona`.`activo`,
                  `persona`.`imagen`,
                  `interaccion`.`idinteraccion`,
                  interaccion_sh.`principal`,
                  interaccion_sh.activo,
                 `interaccion`.`idmodulo_interaccion`,
                 `interaccion_archivo`.idinteraccion_archivo,
                 `interaccion_archivo`.idmodulo_interaccion_archivo,
                 `interaccion_archivo`.archivo,
                 `interaccion_archivo`.activo as archivo_activo,
                `compromiso`.`idcompromiso_prioridad`,
                `compromiso`.`idcompromiso_estado`,
                `compromiso`.`compromiso`,
                DATE_FORMAT(compromiso.fecha,'%d/%m/%Y') AS fecha_compromiso,
                `compromiso`.`activo` as compromiso_activo,
                `compromiso`.`idcompromiso`,
                `compromiso`.`idmodulo_compromiso`,
                `compromiso`.`idusu_c` as compromiso_idusu_c,
                `compromiso`.`idmodulo_c` as compromiso_idmodulo_c,
                `compromiso`.`fecha_c`,
                `persona1`.`apellido_p` as rc_apellido_p,
              `persona1`.`apellido_m` as rc_apellido_m,
              `persona1`.`nombre` as rc_nombre,
              `persona`.`apellido_p` as sh_apellido_p,
              `persona`.`apellido_m` as sh_apellido_m,
              `persona`.`nombre` as sh_nombre,
              `persona`.`idpersona_tipo` as sh_idpersona_tipo,
             `persona1`.`idpersona` as rc_idpersona,
              `persona`.`idmodulo` as sh_idmodulo,
              `persona`.`idpersona` as sh_idpersona,
              `persona1`.`idmodulo` as rc_idmodulo,
              interaccion_rc.principal
                FROM
                  `interaccion`
                  LEFT OUTER JOIN `interaccion_sh` ON (`interaccion_sh`.`idinteraccion` = `interaccion`.`idinteraccion`)
                  AND (`interaccion_sh`.`idmodulo_interaccion` = `interaccion`.`idmodulo_interaccion`)
                  LEFT OUTER JOIN `interaccion_archivo` ON (`interaccion_archivo`.`idinteraccion` = `interaccion`.`idinteraccion`)
                  AND (`interaccion_archivo`.`idmodulo_interaccion` = `interaccion`.`idmodulo_interaccion`)
                  LEFT OUTER JOIN `sh` ON (`sh`.`idsh` = `interaccion_sh`.`idsh`)
                  AND (`sh`.`idmodulo` = `interaccion_sh`.`idmodulo`)
                  LEFT OUTER JOIN `persona` ON (`persona`.`idpersona` = `sh`.`idsh`)
                  AND (`persona`.`idmodulo` = `sh`.`idmodulo`)
                  LEFT OUTER JOIN `compromiso` ON (`interaccion_sh`.`idinteraccion` = `compromiso`.`idinteraccion`)
                  AND (`interaccion_sh`.`idmodulo_interaccion` = `compromiso`.`idmodulo_interaccion`)
                  LEFT OUTER JOIN `interaccion_rc` ON (`interaccion`.`idinteraccion` = `interaccion_rc`.`idinteraccion`)
                  AND (`interaccion`.`idmodulo_interaccion` = `interaccion_rc`.`idmodulo_interaccion`)
                  LEFT OUTER JOIN `rc` ON (`interaccion_rc`.`idrc` = `rc`.`idrc`)
                  AND (`interaccion_rc`.`idmodulo` = `rc`.`idmodulo`)
                  LEFT OUTER JOIN `persona` `persona1` ON (`rc`.`idrc` = `persona1`.`idpersona`)
                  AND (`rc`.`idmodulo` = `persona1`.`idmodulo`)
                  $tabla_predio
               WHERE
                (`persona`.`activo`= 1 or isnull(`persona`.`activo`))
                 AND $condicion
                 interaccion.activo= 1 AND
                 (interaccion_sh.activo= 1 or isnull(interaccion_sh.activo))AND
                 (interaccion_rc.activo= 1 OR isnull(interaccion_rc.activo)) 
                $cidsh_compuesto $where_predio
               ORDER BY
                 interaccion.fecha DESC,
                `interaccion`.`idinteraccion` DESC,
                `interaccion`.`idmodulo_interaccion` DESC,
                compromiso.fecha DESC,
                `compromiso`.`idcompromiso` DESC,
                `compromiso`.`idmodulo_compromiso` DESC
                $limite";

        //echo "<br>".$consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {

            $ainteraccion['idmodulo_interaccion'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]] = $fila[idmodulo_interaccion];

            $ainteraccion['idinteraccion'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]] = $fila[idinteraccion];
            
            $ainteraccion['idusu_c'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]] = $fila[idusu_c];
            
            $ainteraccion['idmodulo_c'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]] = $fila[idmodulo_c];

            $ainteraccion['interaccion'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]] = utf8_encode($fila[interaccion]);

            $ainteraccion['fecha'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]] = $fila[fecha];

            $ainteraccion['rc'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[rc_idpersona] . "-" . $fila[rc_idmodulo]] = utf8_encode($fila[rc_apellido_p] . " " . $fila[rc_apellido_m] . " " . $fila[rc_nombre]);

            $ainteraccion['sh'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[sh_idpersona] . "-" . $fila[sh_idmodulo]] = utf8_encode($fila[sh_idpersona].'---'.$fila[sh_idmodulo].'---'. $fila[sh_nombre]. " ".$fila[sh_apellido_p] . " " . $fila[sh_apellido_m] .'---'.$fila[sh_idpersona_tipo].'---'.$fila[imagen]);
            if($fila[sh_idpersona_tipo]>1){
                $ainteraccion['sh'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[sh_idpersona] . "-" . $fila[sh_idmodulo]] = utf8_encode($fila[sh_idpersona].'---'.$fila[sh_idmodulo].'---'.$fila[sh_apellido_p].'---'.$fila[sh_idpersona_tipo].'---'.$fila[imagen]);
            }        
            
            //echo "sh_idpersona_tipo: $fila[sh_idpersona_tipo]";

            if ($fila[idcompromiso] != "" && $fila[compromiso_activo] != 0 ) {
                //echo "entra";
                $ainteraccion['idcompromiso'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso];
                $ainteraccion['idmodulo_compromiso'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idmodulo_compromiso];
                $ainteraccion['compromiso_idusu_c'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[compromiso_idusu_c];
                $ainteraccion['compromiso_idmodulo_c'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[compromiso_idmodulo_c];
                $ainteraccion['compromiso'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = utf8_encode($fila[compromiso]);
                $ainteraccion['fecha_compromiso'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[fecha_compromiso];
            }
            
            if ($fila[archivo] != "" && $fila[archivo_activo] != 0 ) {
                $ainteraccion['archivo'][$fila[idinteraccion] . "-" . $fila[idmodulo_interaccion]][$fila[idinteraccion_archivo] . "-" . $fila[idmodulo_interaccion_archivo]] = $fila[archivo];                
            }
            
            //print_r($ainteraccion['archivo']);
        }
        //print_r($ainteraccion);
        return $ainteraccion;
    }
    
    
    function   lista_stakeholder_predio_tag($idtag_compuesto,$tags,$tags_predio) {
        
        $cant = count($idtag_compuesto);
        
        $count=0;
        
        $consulta="";
                        
        if($cant>0){
            $count++;
            $cidtag_compuesto=" AND CONCAT(`persona_tag`.`idtag`,'-',  `persona_tag`.`idmodulo_tag`)                
                            IN ( ";
            foreach ($idtag_compuesto as $valor){
               
                    $cidtag_compuesto.= "'".$valor."',";                    
                
            }
            $cidtag_compuesto = substr($cidtag_compuesto, 0, -1);
            
            $cidtag_compuesto.= " )  "; 
            
            $consulta = "SELECT DISTINCT
            `predio_gis_item`.`idgis_item`
          FROM
            `persona_tag`
            LEFT OUTER JOIN `predio_sh` ON (`persona_tag`.`idpersona` = `predio_sh`.`idsh`)
            AND (`persona_tag`.`idmodulo` = `predio_sh`.`idmodulo`)
            LEFT OUTER JOIN `predio_gis_item` ON (`predio_sh`.`idpredio` = `predio_gis_item`.`idpredio`)
          WHERE
            `predio_gis_item`.`idgis_item` IS NOT NULL $cidtag_compuesto"; 
                       
        }
        
        
        $cant = count($tags);                
                        
        if($cant>0){
            $count++;
            $cidtags=" AND CONCAT(`interaccion_tag`.`idtag`,'-',  `interaccion_tag`.`idmodulo_tag`)                
                            IN ( ";
            foreach ($tags as $valor){
               
                    $cidtags.= "'".$valor."',";                    
                
            }
            $cidtags = substr($cidtags, 0, -1);
            
            $cidtags.= " )  "; 
            
             if($consulta!=""){
                 
                 $consulta .= " UNION ALL ";
             }
             
            
            $consulta .= "SELECT DISTINCT
            `predio_gis_item`.`idgis_item`
          FROM
            `interaccion_tag`
             LEFT OUTER JOIN `interaccion_sh` ON (`interaccion_sh`.`idinteraccion` = `interaccion_tag`.`idinteraccion`)
            AND (`interaccion_sh`.`idmodulo_interaccion` = `interaccion_tag`.`idmodulo_interaccion`)
            LEFT OUTER JOIN `predio_sh` ON (`interaccion_sh`.`idsh` = `predio_sh`.`idsh`)
            AND (`interaccion_sh`.`idmodulo` = `predio_sh`.`idmodulo`)
            LEFT OUTER JOIN `predio_gis_item` ON (`predio_sh`.`idpredio` = `predio_gis_item`.`idpredio`)
          WHERE
            `predio_gis_item`.`idgis_item` IS NOT NULL $cidtags"; 
                       
        }
        
        $cant = count($tags_predio);                
                        
        if($cant>0){
            $count++;
            $cidtags_predio=" AND CONCAT(`predio_tag`.`idtag`,'-',  `predio_tag`.`idmodulo_tag`)                
                            IN ( ";
            foreach ($tags_predio as $valor){
               
                    $cidtags_predio.= "'".$valor."',";                    
                
            }
            $cidtags_predio = substr($cidtags_predio, 0, -1);
            
            $cidtags_predio.= " )  "; 
            
             if($consulta!=""){
                 
                 $consulta .= " UNION ALL ";
             }
             
            
            $consulta .= "SELECT DISTINCT
            `predio_gis_item`.`idgis_item`
          FROM
            `predio_tag`             
            LEFT OUTER JOIN `predio_gis_item` ON (`predio_tag`.`idpredio` = `predio_gis_item`.`idpredio`)
          WHERE
            `predio_gis_item`.`idgis_item` IS NOT NULL $cidtags_predio"; 
                       
        }
                                              
        if($consulta!=""){
            
            $consulta = "SELECT resultado.idgis_item from ( $consulta ) as resultado GROUP BY idgis_item HAVING count(*) >= $count; ";
            
            //echo $consulta;
            
            $result = $this->sql->consultar($consulta, "sgrc");
        }
        
        return $result;
    }

    function lista_stakeholder_red($idpersona, $idmodulo) {

        $consulta = "SELECT
              `persona`.`idpersona_tipo`,
              `persona`.`apellido_p`,
              `persona`.`apellido_m`,
              `persona`.`nombre`,
              `persona`.`imagen`,
              `persona_red`.`idpersona`,
              `persona_red`.`idmodulo`,
              `persona_red`.`idpersona_red`,
              `persona_red`.`idmodulo_red`,
              `persona_red`.`idred`,
              `persona_red`.`idmodulo_persona_red`
            FROM
              `persona_red`
              INNER JOIN `persona` ON (`persona_red`.`idpersona_red` = `persona`.`idpersona`)
              AND (`persona_red`.`idmodulo_red` = `persona`.`idmodulo`)
              WHERE
              persona_red.activo=1 AND
             `persona_red`.`idpersona`=$idpersona AND
              `persona_red`.`idmodulo`= $idmodulo ";

        ///echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_stakeholder_predio($idpersona, $idmodulo, $idmapa) {
        //revisada
        if(isset($idmapa)){
            $cmapa=" gis_mapa.idgis_mapa = $idmapa ";
        }else{
            $cmapa=" gis_mapa.idgis_mapa = ( select idgis_mapa from gis_mapa where activo =1 and predeterminado=1 limit 1)";
        }

        $consulta = "SELECT distinct
              `predio`.`idpredio`,
              predio.idmodulo_predio,
              predio.direccion,
              `predio`.`nombre`,
               predio_archivo.idpredio_archivo,
               predio_archivo.idmodulo_predio_archivo,
               predio_archivo.archivo,
               predio_archivo.activo as archivo_activo,
               `predio_gis_item`.`idgis_item`,
               `predio_tag`.`activo` as tag_activo,
               tag.tag
            FROM
  `predio`
  LEFT OUTER JOIN `predio_sh` ON (`predio`.`idpredio` = `predio_sh`.`idpredio`)
  AND (`predio_sh`.`idmodulo_predio` = `predio`.`idmodulo_predio`)
  LEFT OUTER JOIN `predio_archivo` ON (`predio`.`idpredio` = `predio_archivo`.`idpredio`)
  AND (`predio`.`idmodulo_predio` = `predio_archivo`.`idmodulo_predio`)
  LEFT OUTER JOIN `predio_gis_item` ON (`predio`.`idpredio` = `predio_gis_item`.`idpredio`)
  AND (`predio`.`idmodulo_predio` = `predio_gis_item`.`idmodulo_predio`)
  LEFT OUTER JOIN `predio_tag` ON (`predio`.`idpredio` = `predio_tag`.`idpredio`)
  AND (`predio`.`idmodulo_predio` = `predio_tag`.`idmodulo_predio`)
  LEFT OUTER JOIN `tag` ON (`tag`.`idtag` = `predio_tag`.`idtag`)
  AND (`tag`.`idmodulo_tag` = `predio_tag`.`idmodulo_tag`)
  LEFT OUTER JOIN `gis_item` ON (`predio_gis_item`.`idgis_item` = `gis_item`.`idgis_item`)
  LEFT OUTER JOIN `gis_capa` ON (`gis_item`.`idgis_capa` = `gis_capa`.`idgis_capa`)
  LEFT OUTER JOIN `gis_mapa` ON (`gis_capa`.`idgis_mapa` = `gis_mapa`.`idgis_mapa`)
              WHERE
              $cmapa AND
              predio_sh.activo=1 AND
             `predio_sh`.`idsh`=$idpersona AND
             `predio_sh`.`idmodulo`= $idmodulo
               ";

      //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");
        
        $apredio = array();
        
        while($fila=  mysql_fetch_array($result)){
          
            $apredio['idpredio'][$fila[idpredio]."***".$fila[idmodulo_predio]]=$fila[nombre];
            $apredio['direccion'][$fila[idpredio]."***".$fila[idmodulo_predio]]=$fila[direccion];
            if ($fila[archivo] != "" && $fila[archivo_activo] != 0 ) {
                $apredio['archivo'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idpredio_archivo] . "-" . $fila[idmodulo_predio_archivo]] = $fila[archivo];                
            }
            if(isset($fila[idgis_item])){
                $apredio['idgis_item_predio'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[idgis_item]]=$fila[idgis_item];
                $apredio['idgis_item'][$fila[idgis_item]."***".$fila[idmodulo_predio]]=$fila[idgis_item];
            }
            
            if(isset($fila[tag])&& $fila[tag_activo] != 0){
                $apredio['tag'][$fila[idpredio]."***".$fila[idmodulo_predio]][$fila[tag]]=$fila[tag];
            }
        }
        //print_r($apredio);
        return $apredio;
    }
    
    function lista_predio_entidad($entidad, $identidad, $idmodulo){
        
        $consulta="SELECT DISTINCT
            `predio_gis_item`.`idgis_item`
          FROM
            `$entidad"."`
             LEFT OUTER JOIN `$entidad"."_sh` ON (`$entidad"."_sh`.`id$entidad"."` = `$entidad"."`.`id$entidad"."`)
            AND (`$entidad"."_sh`.`idmodulo_$entidad"."` = `$entidad"."`.`idmodulo_$entidad"."`)
            LEFT OUTER JOIN `predio_sh` ON (`$entidad"."_sh`.`idsh` = `predio_sh`.`idsh`)
            AND (`$entidad"."_sh`.`idmodulo` = `predio_sh`.`idmodulo`)
            LEFT OUTER JOIN `predio_gis_item` ON (`predio_sh`.`idpredio` = `predio_gis_item`.`idpredio`)
          WHERE
            `predio_gis_item`.`idgis_item` IS NOT NULL
            and $entidad".".id$entidad"."=$identidad
            and $entidad".".idmodulo_$entidad"."=$idmodulo";
        
        $result = $this->sql->consultar($consulta, "sgrc");
        
        $apredio = array();
        
        while($fila=  mysql_fetch_array($result)){
            
            $apredio['idgis_item'][$fila[idgis_item]]=$fila[idgis_item];
            
        }
        //print_r($apredio);
        return $apredio;
        
    }
    
    function lista_archivo_predio($idpredio) {

        $consulta = "SELECT distinct
               predio_archivo.idpredio_archivo,
               predio_archivo.idmodulo_predio_archivo,
               predio_archivo.archivo,
               predio_archivo.activo 
            FROM
              predio_archivo              
              WHERE
              predio_archivo.activo=1 AND
             `predio_archivo`.`idpredio`=$idpredio ";

        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");
        
        
        //print_r($apredio);
        return $result;
    }

    function lista_stakeholder_tag($busca = "", $con_limit = ""){
  
                $limit = "";
        if ($con_limit != "") {
            $con_limit = max_br_m;
            $limit = " LIMIT 0,$con_limit";
        }
        $consultaa = "(SELECT
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      concat(`persona`.`idpersona`,'---',`persona`.`idmodulo`,'---',persona.idpersona_tipo) AS idpersona_compuesto,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      IF( persona.idpersona_tipo > 1 ,`persona`.`apellido_p`,concat(persona.nombre,' ',`persona`.`apellido_p`,' ',`persona`.`apellido_m`)) as nombre_completo,  
                      
                       persona.nombre,
                       persona.idpersona_tipo
                    FROM
                      `persona`
                      INNER JOIN sh ON (persona.idpersona = sh.idsh)
                      AND (persona.idmodulo = sh.idmodulo)
                      WHERE
                   `persona`.`activo`=1 AND sh.activo=1 AND (persona.apellido_p like '$busca%' OR persona.nombre like '$busca%'))";
        
        $consultab="(SELECT
                     tag.idtag AS id,
                     tag.idmodulo_tag AS idmodulo,
                     concat(tag.idtag,'---',tag.idmodulo_tag,'---','tag.') as idcompuesto,
                     tag.tag,
                     tag.tag,
                     tag.tag,
                     tag.tag,
                     tag.tag
                     FROM 
                     tag
                     WHERE 
                     tag.activo=1 AND tag like '%$busca%')";
                    
         $consulta=$consultaa.' UNION ALL '.$consultab ." $limit";           
        //echo $consulta."<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
        
    }
    
    function lista($busca = "", $con_limit = "") {

        $limit = "";
        if ($con_limit != "") {
            $con_limit = max_br_m;
            $limit = " LIMIT 0,$con_limit";
        }
        $consulta = "SELECT
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      concat(`persona`.`idpersona`,'---',`persona`.`idmodulo`,'---',persona.idpersona_tipo) AS idpersona_compuesto,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      IF( persona.idpersona_tipo > 1 ,`persona`.`apellido_p`,concat(persona.nombre,' ',`persona`.`apellido_p`,' ',`persona`.`apellido_m`)) as nombre_completo,  
                      
                       persona.nombre,
                       persona.idpersona_tipo
                    FROM
                      `persona`
                      INNER JOIN sh ON (persona.idpersona = sh.idsh)
                      AND (persona.idmodulo = sh.idmodulo)
                      WHERE
                   `persona`.`activo`=1 AND sh.activo=1 AND (persona.apellido_p like '$busca%' OR persona.nombre like '$busca%') $limit";

        //echo $consulta."<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    
    function lista_predio($busca) {
        
        if($busca=='*'){
            $busca='';
        }

       
        $consulta = "SELECT
                       predio.`idpredio`,
                       predio.nombre
                    FROM
                      `predio`
                      
                      WHERE
                   `predio`.`activo`=1 AND (predio.nombre like '$busca%') ";

        //echo $consulta."<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function get_predio($idpredio,$idmodulo_predio) {
        
        
        $consulta = "SELECT
                       predio.`idpredio`,
                       predio.nombre,
                       predio.comentario
                    FROM
                      `predio`
                      
                      WHERE
                   predio.idpredio=$idpredio AND predio.idmodulo_predio=$idmodulo_predio";

        //echo $consulta."<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function listar_predio_persona($idgis_item) {
       //revisada                
        $consulta = "SELECT DISTINCT 
                        persona.idpersona,
                        persona.idmodulo,
                        persona.apellido_p,
                        persona.`apellido_m`,
                        persona.nombre,
                        persona.`idpersona_tipo`
                      FROM
                        `persona`
                        LEFT OUTER JOIN `sh` ON (`persona`.`idpersona` = `sh`.`idsh`)
                        AND (`persona`.`idmodulo` = `sh`.`idmodulo`)
                        left outer join `predio_sh`
                        on `predio_sh`.`idsh`=sh.idsh and predio_sh.`idmodulo`=sh.`idmodulo`
                        LEFT OUTER JOIN `predio_gis_item` ON (`predio_sh`.`idpredio` = `predio_gis_item`.`idpredio`)
                        AND (`predio_sh`.`idmodulo_predio` = `predio_gis_item`.`idmodulo_predio`)
                        AND  predio_sh.`activo`=1
                      WHERE
                        `predio_gis_item`.`idgis_item` ='$idgis_item'
                                  
                ";
        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
     function lista_tag_predio($idpredio,$idmodulo_predio){
        
        $consulta="SELECT 
                        `tag`.`tag`,
                        `predio_tag`.`activo`,
                        `tag`.`activo`,
                        `predio_tag`.`idtag`,
                        `predio_tag`.`idmodulo_tag`,
                        `predio_tag`.`idpredio`,
                        `predio_tag`.`idpredio_tag`,
                        `predio_tag`.`idmodulo_predio_tag`,
                        `predio_tag`.`prioridad`
                      FROM
                        `predio_tag`
                        INNER JOIN `tag` ON (`predio_tag`.`idtag` = `tag`.`idtag`)
                        AND (`predio_tag`.`idmodulo_tag` = `tag`.`idmodulo_tag`)
                        INNER JOIN `predio` ON (`predio_tag`.`idpredio` = `predio`.`idpredio`)
                        AND (`predio_tag`.`idmodulo_predio` = `predio`.`idmodulo_predio`)
                    WHERE
                    `predio`.`activo`= 1 AND
                    `predio_tag`.`activo`=1 AND
                    `predio_tag`.`idpredio` = $idpredio 
                    order by prioridad desc";
        //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }

}

?>
