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
class ipersona {

    //put your code here
    public $sql;

    function ipersona() {
        $this->sql = new DmpSql();
    }

    function get_persona($idpersona, $idmodulo) {
        $consulta = "
                  SELECT
                  `persona`.`idpersona`,
                  `persona`.`idmodulo`,
                  `persona`.`apellido_p`,
                  `persona`.`apellido_m`,
                  `persona`.`nombre`,
                  `persona`.`imagen`,
                  `persona`.`activo`,
                  `persona`.`idusu_c`,
                  `persona`.`idmodulo_c`,
                  DATE_FORMAT(persona.fecha_nacimiento,'%d/%m/%Y') AS fecha_nacimiento,
                  `persona`.`idpersona_tipo`,
                  `persona`.`idestado_civil`,
                  `persona`.`sexo`,
                  `persona`.`background`,
                  `persona`.`comentario`
                    FROM
                      `persona`
                    WHERE
                      `persona`.`idpersona` = $idpersona AND
                      `persona`.`idmodulo` = $idmodulo";
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function get_persona_documento_identificacion($idpersona, $idmodulo) {
        $consulta = "SELECT
                        `persona_documento_identificacion`.`idpersona_documento_identificacion`,
                        `persona_documento_identificacion`.`documento_identificacion`,
                        `persona_documento_identificacion`.`iddocumento_identificacion`,
                        `persona_documento_identificacion`.`idmodulo_persona_documento_identificacion`,
                        `documento_identificacion`.`documento_identificacion` AS tipo_documento_identificacion
                    FROM
                      `persona`
                        INNER JOIN `persona_documento_identificacion` ON (`persona`.`idpersona` = `persona_documento_identificacion`.`idpersona`)
                        AND (`persona`.`idmodulo` = `persona_documento_identificacion`.`idmodulo`)
                        LEFT OUTER JOIN `documento_identificacion` ON (`persona_documento_identificacion`.`iddocumento_identificacion` = `documento_identificacion`.`iddocumento_identificacion`)
                       WHERE
                          `persona`.`idpersona` = $idpersona AND
                          `persona`.`idmodulo` = $idmodulo AND
                          persona_documento_identificacion.activo=1
                     ORDER BY persona_documento_identificacion.idpersona_documento_identificacion";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function get_persona_direccion($idpersona, $idmodulo) {

        $consulta = " SELECT
                                persona_direccion.idpersona_direccion,
                                persona_direccion.idmodulo_persona_direccion,
                                `persona_direccion`.`direccion`
                            FROM
                              `persona`
                              INNER JOIN `persona_direccion` ON (`persona`.`idpersona` = `persona_direccion`.`idpersona`)
                              AND (`persona`.`idmodulo` = `persona_direccion`.`idmodulo`)
                         WHERE
                          `persona`.`idpersona` = $idpersona AND
                          `persona`.`idmodulo` = $idmodulo AND
                          persona_direccion.activo=1
                          ORDER BY persona_direccion.idpersona_direccion";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function get_persona_telefono($idpersona, $idmodulo) {

        $consulta = " SELECT
                        persona_telefono.idpersona_telefono,
                        persona_telefono.idmodulo_persona_telefono,
                       `persona_telefono`.`telefono`
                    FROM
                      `persona`
                      INNER JOIN `persona_telefono` ON (`persona`.`idpersona` = `persona_telefono`.`idpersona`)
                      AND (`persona`.`idmodulo` = `persona_telefono`.`idmodulo`)
                    WHERE
                          `persona`.`idpersona` = $idpersona AND
                          `persona`.`idmodulo` = $idmodulo AND
                          persona_telefono.activo=1
                    ORDER BY persona_telefono.idpersona_telefono";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function get_persona_email($idpersona, $idmodulo) {

        $consulta = " SELECT
                        persona_mail.idpersona_mail,
                        persona_mail.idmodulo_persona_mail,
                        `persona_mail`.`mail`
                    FROM
                      `persona`
                      INNER JOIN `persona_mail` ON (`persona`.`idpersona` = `persona_mail`.`idpersona`)
                      AND (`persona`.`idmodulo` = `persona_mail`.`idmodulo`)
                     WHERE
                          `persona`.`idpersona` = $idpersona AND
                          `persona`.`idmodulo` = $idmodulo AND
                          persona_mail.activo=1
                     ORDER BY persona_mail.idpersona_mail";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function get_persona_organizacion($idpersona, $idmodulo) {
        //no hago filtro de tipo de persona,creo q es mejor asi xq la persona no esta inactiva para no mostrarla
        $consulta = "  SELECT
                       `persona_organizacion`.`idorganizacion`,
                       `persona_organizacion`.`idmodulo_organizacion`,
                      `persona_organizacion`.`idpersona_cargo`,
                      `persona_organizacion`.`idpersona_organizacion`,
                      persona_organizacion.idmodulo_persona_organizacion,
                      `persona1`.`apellido_p`,
                      `persona1`.`apellido_m`,
                      `persona1`.`idpersona_tipo`,
                       `persona_cargo`.`cargo`
                    FROM
                      `persona`
                      INNER JOIN `persona_organizacion` ON (`persona`.`idpersona` = `persona_organizacion`.`idpersona`)
                      AND (`persona`.`idmodulo` = `persona_organizacion`.`idmodulo`)
                      INNER JOIN `persona` `persona1` ON (`persona_organizacion`.`idorganizacion` = `persona1`.`idpersona`)
                      AND (`persona_organizacion`.`idmodulo_organizacion` = `persona1`.`idmodulo`)
                      INNER JOIN `persona_cargo` ON (`persona_organizacion`.`idpersona_cargo` = `persona_cargo`.`idpersona_cargo`)
                   WHERE
                          `persona`.`idpersona` = $idpersona AND
                          `persona`.`idmodulo` = $idmodulo AND
                          persona_organizacion.activo = 1
                    ORDER BY persona_organizacion.idpersona_organizacion";
        // echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function get_persona_tag($idpersona, $idmodulo) {

        $consulta = "SELECT
                  `persona_tag`.`idmodulo_persona_tag`,
                  `persona_tag`.`idpersona_tag`,
                  `persona_tag`.`idtag`,
                  `persona_tag`.`idmodulo_tag`,
                  `persona_tag`.`prioridad`,
                  `tag`.`idusu_c`,
                  `tag`.`idmodulo_c`,
                  `tag`.`tag`
                FROM
                  `persona`
                  INNER JOIN `persona_tag` ON (`persona`.`idpersona` = `persona_tag`.`idpersona`)
                  AND (`persona`.`idmodulo` = `persona_tag`.`idmodulo`)
                  INNER JOIN `tag` ON (`persona_tag`.`idtag` = `tag`.`idtag`)
                  AND (`persona_tag`.`idmodulo_tag` = `tag`.`idmodulo_tag`)
                WHERE
                          `persona`.`idpersona` = $idpersona AND
                          `persona`.`idmodulo` = $idmodulo AND
                          persona_tag.activo = 1
                    ORDER BY persona_tag.idtag";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function lista_sh($apellido_p = "", $apellido_m = "", $nombre = "", $idpersona_tipo = "", $join = "" ,$todos = "1",$idinteraccion_complejo_tag=array(),$criterio="",$dimensiones=array(),$operadores=array(),$puntajes=array(),$atag=array()) {
        if ($todos == 1) {
            $ctodos = " AND `persona`.`activo`=1 ";
        } elseif ($todos == 0) {
            $ctodos = " AND `persona`.`activo`=1 AND `sh`.`activo`=1";
        } else {
            $ctodos = " AND `persona`.`activo`=0";
        }

        if ($apellido_p != "") {
            $capellido_p = " AND persona.apellido_p like '$apellido_p%' ";
        }

        if ($apellido_m != "") {
            $capellido_m = " AND persona.apellido_m like '$apellido_m%'";
        }

        if ($nombre != "") {
            $cnombre = " AND persona.nombre like '$nombre%'";
        }

        if ($idpersona_tipo != "" && $idpersona_tipo > 0) {
            $cpersona_tipo = " AND persona.idpersona_tipo=$idpersona_tipo ";
        }
        
        $tags = count($idinteraccion_complejo_tag);
                        
        if($tags>0){
            $cpersona_tag=" AND CONCAT(`persona_tag`.`idtag`,'---',`persona_tag`.`idmodulo_tag`) 
                            IN ( ";
            foreach ($idinteraccion_complejo_tag as $valor){
                if(strpos($valor, "###")){
                    $tags--;
                }else{
                    $cpersona_tag.= "'".$valor."',";                    
                }
            }
            $cpersona_tag = substr($cpersona_tag, 0, -1);
            
            $cpersona_tag.= " ) AND persona_tag.activo=1
                             GROUP BY
                            `persona`.`idpersona`,  `persona`.`idmodulo`
                            HAVING count(*)=$tags"; 
            if($tags==0){
                $cpersona_tag="";
            }
            
        }else{
            $cpersona_tag="";
        }
        
        $cant = count($dimensiones);
        
        //echo "CANT: $cant ";
        
       
        if($cant>1 && $criterio!=""){
            $cpersona_importancia="";
            if($tags>0){
                $cpersona_dimension="";
            }else{
                $cpersona_dimension=" HAVING 1=1 ";
            }
            for ($i=1;$i<$cant;$i++){
                if($dimensiones[$i]==0){
                   $cpersona_importancia.=" $criterio sh.importancia ".$operadores[$i]." ".$puntajes[$i];
                }elseif($dimensiones[$i]==1){
                   $cpersona_dimension.=" $criterio posicion ".$operadores[$i]." ".$puntajes[$i]; 
                }elseif($dimensiones[$i]==2){
                   $cpersona_dimension.=" $criterio poder ".$operadores[$i]." ".$puntajes[$i]; 
                }else{
                   $cpersona_dimension.=" $criterio interes ".$operadores[$i]." ".$puntajes[$i]; 
                }
            }              
           
        }else{
            $cpersona_dimension="";
            $cpersona_importacia="";
        }

        $consulta = "SELECT DISTINCT
                    `persona`.`idpersona`,
                    `persona`.`idmodulo`,
                    `persona`.`idpersona_tipo`,
                    `persona`.`apellido_p`,
                    `persona`.`apellido_m`,
                    `persona`.`nombre`,
                    `persona`.`activo`, ";
        
        foreach ($atag as $key_tag => $tag) {
            $consulta.=" ( select avg(prioridad) from persona_tag 
                            where 
                            persona_tag.activo=1 
                            and persona_tag.idpersona=persona.idpersona
                            and persona_tag.idmodulo=persona.idmodulo
                            and CONCAT(`persona_tag`.`idtag`,'-', `persona_tag`.`idmodulo_tag`) = '$key_tag' 
                          ) as '$key_tag',";
        }
        
        $consulta .="
                    `sh`.`activo` AS sh_rc_activo,
                    (
                    select  `dimension_matriz_sh_valor`.`puntaje`
                    from  `dimension_matriz_sh_valor`
                    left join  `sh_dimension_matriz_sh`
                    on  `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`= `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`
                    left join `sh_dimension`
                    on `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
                    and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
                    where 
                    `sh_dimension`.`ultimo`=1
                    and 
                    `sh_dimension`.`idsh`=`sh`.`idsh`
                    and
                    `sh_dimension`.`idmodulo`=`sh`.`idmodulo`
                    and
                    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=1 limit 1
                    
                    ) as 'posicion',
                    (
                    select  `dimension_matriz_sh_valor`.`puntaje`
                    from  `dimension_matriz_sh_valor`
                    left join  `sh_dimension_matriz_sh`
                    on  `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`= `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`
                    left join `sh_dimension`
                    on `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
                    and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
                    where 
                    `sh_dimension`.`ultimo`=1
                    and 
                    `sh_dimension`.`idsh`=`sh`.`idsh`
                    and
                    `sh_dimension`.`idmodulo`=`sh`.`idmodulo`
                    and
                    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=2 limit 1
                    
                    ) as 'poder',
                    (
                    select  `dimension_matriz_sh_valor`.`puntaje`
                    from  `dimension_matriz_sh_valor`
                    left join  `sh_dimension_matriz_sh`
                    on  `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`= `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`
                    left join `sh_dimension`
                    on `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
                    and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
                    where 
                    `sh_dimension`.`ultimo`=1
                    and 
                    `sh_dimension`.`idsh`=`sh`.`idsh`
                    and
                    `sh_dimension`.`idmodulo`=`sh`.`idmodulo`
                    and
                    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=3 limit 1
                    
                    ) as 'interes',
                      `predio_gis_item`.`idgis_item`
                  FROM
                    `persona`
                    $join JOIN `sh` ON (`persona`.`idpersona` = `sh`.`idsh`)
                    AND (`persona`.`idmodulo` = `sh`.`idmodulo`)
                    LEFT JOIN `persona_tag` ON (`persona`.`idpersona` = `persona_tag`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_tag`.`idmodulo`)
                    LEFT OUTER JOIN `predio_sh` ON (`sh`.`idsh` = `predio_sh`.`idsh`)
                    AND (`sh`.`idmodulo` = `predio_sh`.`idmodulo`)
                    LEFT OUTER JOIN `predio_gis_item` ON (`predio_sh`.`idpredio` = `predio_gis_item`.`idpredio`)
                    WHERE
                    1=1
                   $ctodos $capellido_p $capellido_m $cnombre $cpersona_tipo $cpersona_importancia $cpersona_tag  $cpersona_dimension                    
                   ORDER BY `persona`.`apellido_p` ";
        //echo $consulta;
        // exit;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_sh_excel($apellido_p = "", $apellido_m = "", $nombre = "", $idpersona_tipo = "", $join = "" ,$todos = "1",$idinteraccion_complejo_tag=array(),$criterio="",$dimensiones=array(),$operadores=array(),$puntajes=array()) {
        if ($todos == 1) {
            $ctodos = " AND `persona`.`activo`=1 ";
        } elseif ($todos == 0) {
            $ctodos = " AND `persona`.`activo`=1 AND `sh`.`activo`=1";
        } else {
            $ctodos = " AND `persona`.`activo`=0";
        }

        if ($apellido_p != "") {
            $capellido_p = " AND persona.apellido_p like '$apellido_p%' ";
        }

        if ($apellido_m != "") {
            $capellido_m = " AND persona.apellido_m like '$apellido_m%'";
        }

        if ($nombre != "") {
            $cnombre = " AND persona.nombre like '$nombre%'";
        }

        if ($idpersona_tipo != "" && $idpersona_tipo > 0) {
            $cpersona_tipo = " AND persona.idpersona_tipo=$idpersona_tipo ";
        }
        
        $tags = count($idinteraccion_complejo_tag);
                        
        if($tags>0){
            $cpersona_tag=" AND CONCAT(`persona_tag`.`idtag`,'---',`persona_tag`.`idmodulo_tag`) 
                            IN ( ";
            foreach ($idinteraccion_complejo_tag as $valor){
                if(strpos($valor, "###")){
                    $tags--;
                }else{
                    $cpersona_tag.= "'".$valor."',";                    
                }
            }
            $cpersona_tag = substr($cpersona_tag, 0, -1);
            
            $cpersona_tag.= " ) 
                             GROUP BY
                            `persona`.`idpersona`,  `persona`.`idmodulo`
                            HAVING count(*)=$tags"; 
            if($tags==0){
                $cpersona_tag="";
            }
            
        }else{
            $cpersona_tag="";
        }
        
        $cant = count($dimensiones);
        
        //echo "CANT: $cant ";
        
       
        if($cant>1 && $criterio!=""){
            $cpersona_importancia="";
            if($tags>0){
                $cpersona_dimension="";
            }else{
                $cpersona_dimension=" HAVING 1=1 ";
            }
            for ($i=1;$i<$cant;$i++){
                if($dimensiones[$i]==0){
                   $cpersona_importancia.=" $criterio sh.importancia ".$operadores[$i]." ".$puntajes[$i];
                }elseif($dimensiones[$i]==1){
                   $cpersona_dimension.=" $criterio posicion ".$operadores[$i]." ".$puntajes[$i]; 
                }elseif($dimensiones[$i]==2){
                   $cpersona_dimension.=" $criterio poder ".$operadores[$i]." ".$puntajes[$i]; 
                }else{
                   $cpersona_dimension.=" $criterio interes ".$operadores[$i]." ".$puntajes[$i]; 
                }
            }              
           
        }else{
            $cpersona_dimension="";
            $cpersona_importacia="";
        }

        $consulta = "SELECT DISTINCT
                    `persona`.`idpersona`,
                    `persona`.`idmodulo`,
                    `persona`.`idpersona_tipo`,
                    `persona`.`apellido_p`,
                    `persona`.`apellido_m`,
                    `persona`.`nombre`,
                    `persona`.`activo`, 
                    `persona`.`background`,
                    `persona`.`comentario`,
                    IF(persona.fecha_nacimiento>'0000-00-00',DATE_FORMAT(persona.fecha_nacimiento,'%d/%m/%Y'),'') AS fecha,
                    IF(persona.sexo>0,'M','F') AS sexo,
                    tag.idtag,
                    tag.idmodulo_tag,
                    tag.tag,
                    persona_tipo.tipo,
                    documento_identificacion.documento_identificacion as documento,
                    persona_documento_identificacion.documento_identificacion as numero,
                    `persona_direccion`.idpersona_direccion,
                    `persona_direccion`.idmodulo_persona_direccion,
                    `persona_direccion`.direccion,
                    `persona_telefono`.idpersona_telefono,
                    `persona_telefono`.idmodulo_persona_telefono,
                    `persona_telefono`.telefono,
                    `persona_mail`.idpersona_mail,
                    `persona_mail`.idmodulo_persona_mail,
                    `persona_mail`.mail,
                     persona_organizacion.idpersona_organizacion,
                     persona_organizacion.idmodulo_persona_organizacion,
                     organizacion.apellido_p as organizacion,
                    `sh`.`activo` AS sh_rc_activo,
                    (
                    select  `dimension_matriz_sh_valor`.`puntaje`
                    from  `dimension_matriz_sh_valor`
                    left join  `sh_dimension_matriz_sh`
                    on  `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`= `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`
                    left join `sh_dimension`
                    on `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
                    and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
                    where 
                    `sh_dimension`.`ultimo`=1
                    and 
                    `sh_dimension`.`idsh`=`sh`.`idsh`
                    and
                    `sh_dimension`.`idmodulo`=`sh`.`idmodulo`
                    and
                    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=1 limit 1
                    
                    ) as 'posicion',
                    (
                    select  `dimension_matriz_sh_valor`.`puntaje`
                    from  `dimension_matriz_sh_valor`
                    left join  `sh_dimension_matriz_sh`
                    on  `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`= `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`
                    left join `sh_dimension`
                    on `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
                    and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
                    where 
                    `sh_dimension`.`ultimo`=1
                    and 
                    `sh_dimension`.`idsh`=`sh`.`idsh`
                    and
                    `sh_dimension`.`idmodulo`=`sh`.`idmodulo`
                    and
                    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=2 limit 1
                    
                    ) as 'poder',
                    (
                    select  `dimension_matriz_sh_valor`.`puntaje`
                    from  `dimension_matriz_sh_valor`
                    left join  `sh_dimension_matriz_sh`
                    on  `sh_dimension_matriz_sh`.`idsh_dimension_matriz_sh_valor`= `dimension_matriz_sh_valor`.`iddimension_matriz_sh_valor`
                    left join `sh_dimension`
                    on `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
                    and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`
                    where 
                    `sh_dimension`.`ultimo`=1
                    and 
                    `sh_dimension`.`idsh`=`sh`.`idsh`
                    and
                    `sh_dimension`.`idmodulo`=`sh`.`idmodulo`
                    and
                    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=3 limit 1
                    
                    ) as 'interes'
                  FROM
                    `persona`
                    $join JOIN `sh` ON (`persona`.`idpersona` = `sh`.`idsh`)
                    AND (`persona`.`idmodulo` = `sh`.`idmodulo`)
                    LEFT JOIN (select * from persona_tag where activo=1) as `persona_tag` 
                    ON (`persona`.`idpersona` = `persona_tag`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_tag`.`idmodulo`)
                    LEFT JOIN `tag` 
                    ON (`tag`.`idtag` = `persona_tag`.`idtag`)
                    AND (`tag`.`idmodulo_tag` = `persona_tag`.`idmodulo_tag`)
                    LEFT JOIN persona_tipo
                    ON persona.idpersona_tipo=persona_tipo.idpersona_tipo
                    LEFT JOIN (select * from persona_documento_identificacion where activo=1) AS persona_documento_identificacion
                    ON (`persona`.`idpersona` = `persona_documento_identificacion`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_documento_identificacion`.`idmodulo`)
                    LEFT JOIN documento_identificacion
                    ON persona_documento_identificacion.iddocumento_identificacion=documento_identificacion.iddocumento_identificacion
                    LEFT JOIN (select * from persona_direccion where activo=1) as persona_direccion
                    ON (`persona`.`idpersona` = `persona_direccion`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_direccion`.`idmodulo`)
                    LEFT JOIN (select * from persona_telefono where activo=1) as persona_telefono
                    ON (`persona`.`idpersona` = `persona_telefono`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_telefono`.`idmodulo`)
                    LEFT JOIN (select * from persona_mail where activo=1) as persona_mail
                    ON (`persona`.`idpersona` = `persona_mail`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_mail`.`idmodulo`)
                    LEFT JOIN (select * from persona_organizacion where activo=1) as persona_organizacion
                    ON (`persona`.`idpersona` = `persona_organizacion`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_organizacion`.`idmodulo`)
                    LEFT JOIN (select * from persona where activo=1) as organizacion
                    ON (`persona_organizacion`.`idorganizacion` = `organizacion`.`idpersona`)
                    AND (`persona_organizacion`.`idmodulo_organizacion` = `organizacion`.`idmodulo`)
                    WHERE
                    1=1
                   $ctodos $capellido_p $capellido_m $cnombre $cpersona_tipo $cpersona_importancia $cpersona_tag  $cpersona_dimension                    
                   ORDER BY `persona`.`apellido_p` ";
        //echo $consulta;       exit;
        $result = $this->sql->consultar($consulta, "sgrc");
        
        while($fila=  mysql_fetch_array($result)){
            $aresult['nombre'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[nombre];
            $aresult['apellido_p'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[apellido_p];
            $aresult['apellido_m'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[apellido_m];
            $aresult['background'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[background];
            $aresult['fecha'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[fecha];
            $aresult['sexo'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[sexo];
            $aresult['tag'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idtag]."-".$fila[idmodulo_tag]]=$fila[tag];
            $aresult['tipo'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[tipo];
            $aresult['documento'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[documento];
            $aresult['numero'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[numero];
            $aresult['direccion'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idpersona_direccion]."-".$fila[idmodulo_persona_direccion]]=$fila[direccion];
            $aresult['telefono'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idpersona_telefono]."-".$fila[idmodulo_persona_telefono]]=$fila[telefono];
            $aresult['mail'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idpersona_mail]."-".$fila[idmodulo_persona_mail]]=$fila[mail];
            $aresult['organizacion'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idpersona_organizacion]."-".$fila[idmodulo_persona_organizacion]]=$fila[organizacion];
            $aresult['comentario'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[comentario];
        }

        return $aresult;
    }
    
    function lista_sh_red($idinteraccion_complejo_sh=array()) {
        
        $shs = count($idinteraccion_complejo_sh);
                        
        if($shs>0){
            $csh_red=" ,
                    (
                    SELECT COUNT(*)
                    FROM `persona_red` 
                    WHERE (`persona`.`idpersona` = `persona_red`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_red`.`idmodulo`)
                    AND CONCAT(`persona_red`.`idpersona_red`,'---',`persona_red`.`idmodulo_red`) 
                    IN (  ";
            foreach ($idinteraccion_complejo_sh as $valor){
                if(strpos($valor, "###")){
                    $shs--;
                }else{
                    $aux_valor = explode("---", $valor);
                    $csh_red.= "'$aux_valor[0]---$aux_valor[1]',";  
                    
                }
            }
            $csh_red = substr($csh_red, 0, -1);
            
            $csh_red.= " ) AND `persona_red`.`activo`=1  ) as 'shs'";
                            
            if($shs==0){
                $csh_red="";
            }
            
        }else{
            $csh_red="";
        }
        
        $ctodos = " AND `persona`.`activo`=1 AND `sh`.`activo`=1";
                
        $consulta = "SELECT 
                    `persona`.`idpersona`,
                    `persona`.`idmodulo`,
                    `persona`.`idpersona_tipo`,
                    `persona`.`apellido_p`,
                    `persona`.`apellido_m`,
                    `persona`.`nombre`,
                    (SELECT COUNT(*)
                    FROM persona_red
                    WHERE persona.idpersona=persona_red.idpersona_red
                    AND persona.idmodulo=persona_red.idmodulo_red
                    ) as cantidad
                    $csh_red
                  FROM
                    `persona`
                    LEFT JOIN `sh` ON (`persona`.`idpersona` = `sh`.`idsh`)
                    AND (`persona`.`idmodulo` = `sh`.`idmodulo`)
                    
                    WHERE
                    1=1
                   $ctodos  ";
        
        $total=$shs;
        if($total>0){
            
            $consulta.= "  HAVING 1=1 ";
            if($shs>0) $consulta.=" AND shs>=$shs "; 
        }
        
        $consulta.= "  ORDER BY cantidad DESC ";
        
        //echo $consulta;
        // exit;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function lista_rc($apellido_p = "", $apellido_m = "", $nombre = "", $idpersona_tipo = "", $join = "", $todos = "1",$idinteraccion_complejo_tag=array()) {

        if ($todos == 1) {
            $ctodos = "  AND `persona`.`activo`=1 ";
        } elseif ($todos == 0) {
            $ctodos = " AND `persona`.`activo`=1 AND `rc`.`activo`=1";
        } else {
            $ctodos = " AND `persona`.`activo`=0 ";
        }

        if ($apellido_p != "") {
            $capellido_p = " AND persona.apellido_p like '$apellido_p%' ";
        }


        if ($apellido_m != "") {
            $capellido_m = " AND persona.apellido_m like '$apellido_m%' ";
        }


        if ($nombre != "") {
            $cnombre = " AND persona.nombre like '$nombre%'";
        }

        if ($idpersona_tipo != "" && $idpersona_tipo > 0) {
            $cpersona_tipo = " AND persona.idpersona_tipo=$idpersona_tipo ";
        }
        
         

        $consulta = "SELECT DISTINCT
                    `persona`.`idpersona`,
                    `persona`.`idmodulo`,
                    `persona`.`idpersona_tipo`,
                    `persona`.`apellido_p`,
                    `persona`.`apellido_m`,
                    `persona`.`nombre`,
                    `persona`.`activo`,
                    `persona`.`idusu_c`,
                    `persona`.`idmodulo_c`,
                    `rc`.`activo` AS sh_rc_activo
                    
                  FROM
                    `persona`
                    $join JOIN `rc` ON (`persona`.`idpersona` = `rc`.`idrc`)
                    AND (`persona`.`idmodulo` = `rc`.`idmodulo`)
                      WHERE
                      1=1
                   $ctodos $capellido_p $capellido_m  $cnombre $cpersona_tipo 
                   ORDER BY `persona`.`apellido_p` ";
         //echo $consulta;
 
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
     function lista_rc_excel($apellido_p = "", $apellido_m = "", $nombre = "", $idpersona_tipo = "", $join = "", $todos = "1",$idinteraccion_complejo_tag=array()) {

        if ($todos == 1) {
            $ctodos = "  AND `persona`.`activo`=1 ";
        } elseif ($todos == 0) {
            $ctodos = " AND `persona`.`activo`=1 AND `rc`.`activo`=1";
        } else {
            $ctodos = " AND `persona`.`activo`=0 ";
        }

        if ($apellido_p != "") {
            $capellido_p = " AND persona.apellido_p like '$apellido_p%' ";
        }


        if ($apellido_m != "") {
            $capellido_m = " AND persona.apellido_m like '$apellido_m%' ";
        }


        if ($nombre != "") {
            $cnombre = " AND persona.nombre like '$nombre%'";
        }

        if ($idpersona_tipo != "" && $idpersona_tipo > 0) {
            $cpersona_tipo = " AND persona.idpersona_tipo=$idpersona_tipo ";
        }
        
         

        $consulta = "SELECT DISTINCT
                    `persona`.`idpersona`,
                    `persona`.`idmodulo`,
                    `persona`.`idpersona_tipo`,
                    `persona`.`apellido_p`,
                    `persona`.`apellido_m`,
                    `persona`.`nombre`,
                    `persona`.`activo`,
                    `persona`.`idusu_c`,
                    `persona`.`idmodulo_c`,
                    `persona`.`background`,
                    `persona`.`comentario`,
                    IF(persona.fecha_nacimiento>'0000-00-00',DATE_FORMAT(persona.fecha_nacimiento,'%d/%m/%Y'),'') AS fecha,
                    IF(persona.sexo>0,'M','F') AS sexo,
                    tag.idtag,
                    tag.idmodulo_tag,
                    tag.tag,
                    persona_tipo.tipo,
                    documento_identificacion.documento_identificacion as documento,
                    persona_documento_identificacion.documento_identificacion as numero,
                    `persona_direccion`.idpersona_direccion,
                    `persona_direccion`.idmodulo_persona_direccion,
                    `persona_direccion`.direccion,
                    `persona_telefono`.idpersona_telefono,
                    `persona_telefono`.idmodulo_persona_telefono,
                    `persona_telefono`.telefono,
                    `persona_mail`.idpersona_mail,
                    `persona_mail`.idmodulo_persona_mail,
                    `persona_mail`.mail,
                    persona_organizacion.idpersona_organizacion,
                    persona_organizacion.idmodulo_persona_organizacion,
                    organizacion.apellido_p as organizacion,
                    `rc`.`activo` AS sh_rc_activo
                    
                  FROM
                    `persona`
                    $join JOIN `rc` ON (`persona`.`idpersona` = `rc`.`idrc`)                    
                    AND (`persona`.`idmodulo` = `rc`.`idmodulo`)
                    LEFT JOIN (select * from persona_tag where activo=1) as `persona_tag` 
                    ON (`persona`.`idpersona` = `persona_tag`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_tag`.`idmodulo`)
                    LEFT JOIN `tag` 
                    ON (`tag`.`idtag` = `persona_tag`.`idtag`)
                    AND (`tag`.`idmodulo_tag` = `persona_tag`.`idmodulo_tag`)
                    LEFT JOIN persona_tipo
                    ON persona.idpersona_tipo=persona_tipo.idpersona_tipo
                    LEFT JOIN (select * from persona_documento_identificacion where activo=1) AS persona_documento_identificacion
                    ON (`persona`.`idpersona` = `persona_documento_identificacion`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_documento_identificacion`.`idmodulo`)
                    LEFT JOIN documento_identificacion
                    ON persona_documento_identificacion.iddocumento_identificacion=documento_identificacion.iddocumento_identificacion
                    LEFT JOIN (select * from persona_direccion where activo=1) as persona_direccion
                    ON (`persona`.`idpersona` = `persona_direccion`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_direccion`.`idmodulo`)
                    LEFT JOIN (select * from persona_telefono where activo=1) as persona_telefono
                    ON (`persona`.`idpersona` = `persona_telefono`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_telefono`.`idmodulo`)
                    LEFT JOIN (select * from persona_mail where activo=1) as persona_mail
                    ON (`persona`.`idpersona` = `persona_mail`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_mail`.`idmodulo`)
                    LEFT JOIN (select * from persona_organizacion where activo=1) as persona_organizacion
                    ON (`persona`.`idpersona` = `persona_organizacion`.`idpersona`)
                    AND (`persona`.`idmodulo` = `persona_organizacion`.`idmodulo`)
                    LEFT JOIN (select * from persona where activo=1) as organizacion
                    ON (`persona_organizacion`.`idorganizacion` = `organizacion`.`idpersona`)
                    AND (`persona_organizacion`.`idmodulo_organizacion` = `organizacion`.`idmodulo`)
                      WHERE
                      1=1
                   $ctodos $capellido_p $capellido_m  $cnombre $cpersona_tipo 
                   ORDER BY `persona`.`apellido_p` ";
         //echo $consulta;
 
        $result = $this->sql->consultar($consulta, "sgrc");

        while($fila=  mysql_fetch_array($result)){
            $aresult['nombre'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[nombre];
            $aresult['apellido_p'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[apellido_p];
            $aresult['apellido_m'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[apellido_m];
            $aresult['background'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[background];
            $aresult['fecha'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[fecha];
            $aresult['sexo'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[sexo];
            $aresult['tag'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idtag]."-".$fila[idmodulo_tag]]=$fila[tag];
            $aresult['tipo'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[tipo];
            $aresult['documento'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[documento];
            $aresult['numero'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[numero];
            $aresult['direccion'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idpersona_direccion]."-".$fila[idmodulo_persona_direccion]]=$fila[direccion];
            $aresult['telefono'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idpersona_telefono]."-".$fila[idmodulo_persona_telefono]]=$fila[telefono];
            $aresult['mail'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idpersona_mail]."-".$fila[idmodulo_persona_mail]]=$fila[mail];
            $aresult['organizacion'][$fila[idpersona]."-".$fila[idmodulo]][$fila[idpersona_organizacion]."-".$fila[idmodulo_persona_organizacion]]=$fila[organizacion];
            $aresult['comentario'][$fila[idpersona]."-".$fila[idmodulo]]=$fila[comentario];
        }

        return $aresult;
    }

    function lista_persona($apellido_p = "", $apellido_m = "", $nombre = "", $todos = "0") {

        if ($todos == 1) {
            $ctodos = "";
        } elseif ($todos == "0") {
            $ctodos = " AND `persona`.`activo`=1";
        } else {
            $ctodos = " AND `persona`.`activo`=0";
        }

        if ($apellido_m != "") {
            $capellido_m = "AND persona.apellido_m like '$apellido_m%'";
        }

        if ($apellido_p != "") {
            $capellido_p = "OR persona.apellido_p like '$apellido_p%' ";
        }

        if ($nombre != "") {
            $cnombre = "OR persona.nombre like '$nombre%'";
        }
        $consulta = "SELECT
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                       persona.nombre,
                       persona.activo
                    FROM
                      `persona`
                      WHERE
                      1=1

                  $ctodos $capellido_m $capellido_p $cnombre";

        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function valida_persona($apellido_p = "", $apellido_m = "", $nombre = "", $idpersona, $idmodulo, $idpersona_tipo) {

        
        $consulta = "call `levenshtein`('$nombre $apellido_p $apellido_m', $idpersona, $idmodulo, $idpersona_tipo)";

        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }


    function lista_organizacion_nombre($busca = "", $con_limit = "") {
        if ($con_limit != null) {
            $con_limit = " LIMIT 0,30";
        }
        $consulta = "SELECT
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`
                    FROM
                      `persona`
                      left join sh
                      on sh.idsh=persona.idpersona 
                      and sh.idmodulo=persona.idmodulo
                      WHERE
                   `persona`.`activo`=1 
                   and sh.activo=1
                   AND (persona.idpersona_tipo=2 OR persona.idpersona_tipo=3)
                   AND (persona.apellido_p like '$busca%' OR persona.apellido_m like '$busca%') $con_limit";

        // echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_persona_organizacion($idpersona, $idmodulo) {
        
        $consulta = "SELECT
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      `persona`.`nombre`,
                      `persona_cargo`.`cargo`
                    FROM
                      `persona`
                    LEFT JOIN persona_organizacion
                    ON persona_organizacion.idpersona = persona.idpersona
                    AND persona_organizacion.idmodulo = persona.idmodulo
                    LEFT JOIN persona_cargo
                    ON persona_organizacion.idpersona_cargo = persona_cargo.idpersona_cargo                    
                      WHERE
                   `persona`.`activo`=1 
                   AND idorganizacion = $idpersona
                   AND idmodulo_organizacion = $idmodulo
                   ";

        // echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_organizacion($idpersona, $idmodulo) {
        
        $consulta = "SELECT
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      `persona`.`nombre`
                    FROM
                      `persona`                   
                      WHERE
                   `persona`.`activo`=1 
                   AND idpersona = $idpersona
                   AND idmodulo = $idmodulo
                   ";

        // echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_organizacion_sh($idpersona, $idmodulo){
        
        $consulta="select persona.idpersona,
                `persona`.idmodulo,
                persona.apellido_p,
                persona.apellido_m,
                persona.`nombre`,
                persona.idpersona_tipo,
                persona_organizacion1.idorganizacion,
                persona_organizacion1.idmodulo_organizacion,
                IF( persona_organizacion1.idorganizacion is NULL,CONCAT(persona.idpersona,'-',persona.idmodulo),CONCAT(persona_organizacion1.idorganizacion,'-',persona_organizacion1.idmodulo_organizacion)) as campo,
                IF( idpersona_tipo > 1,0,1) as nivel,
                (select count(*) from persona_organizacion
                where 
                activo=1 and 
                idpersona=$idpersona and idmodulo=$idmodulo                
                and ( ( persona_organizacion1.`idorganizacion`=`persona_organizacion`.`idorganizacion`
                        and `persona_organizacion1`.`idmodulo_organizacion`=persona_organizacion.idmodulo_organizacion)
                    or (persona.`idpersona`=persona_organizacion.idorganizacion
                    and `persona`.`idmodulo`=persona_organizacion.idmodulo_persona_organizacion) ) ) as cantidad
                

                from persona
                left outer join (select * from persona_organizacion where activo=1) as persona_organizacion1
                on persona.idpersona = persona_organizacion1.idpersona
                and persona.idmodulo = persona_organizacion1.idmodulo
                where persona.activo=1
                having (idpersona=$idpersona and idmodulo=$idmodulo ) or cantidad > 0
                order by campo,nivel";
        
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
        
    }


    function get_analisis_red_semana($idpersona, $idmodulo) {
        $consulta = "SELECT
                      MAX(`sh_dimension`.`idsh_dimension`) AS `FIELD_1`,
                      `sh_dimension`.`idsh`,
                      `sh_dimension`.`idmodulo`,
                      `sh_dimension`.`comentario`,
                      DATE_FORMAT(`sh_dimension`.`fecha`, '%x%v')  AS `periodo`,
                    persona.nombre,
                    persona.apellido_p,
                    persona.apellido_m,
                      dimension_matriz_sh_valor.puntaje,
                      dimension_matriz_sh_valor.iddimension_matriz_sh,
                      dimension_matriz_sh_valor.valor,
                      dimension_matriz_sh.dimension
                    FROM

                    persona
                    INNER JOIN `sh_dimension` ON (`persona`.`idpersona` = `sh_dimension`.`idsh`)
                      AND (`persona`.`idmodulo` = `sh_dimension`.`idmodulo`)

                    LEFT JOIN
                    sh_dimension_matriz_sh
                    ON
                    sh_dimension_matriz_sh.idsh_dimension=sh_dimension.idsh_dimension
                    AND
                    sh_dimension_matriz_sh.idmodulo_sh_dimension=sh_dimension.idmodulo_sh_dimension
                    LEFT JOIN
                    dimension_matriz_sh_valor
                    ON
                    dimension_matriz_sh_valor.iddimension_matriz_sh_valor=sh_dimension_matriz_sh.idsh_dimension_matriz_sh_valor
                    LEFT JOIN
                    dimension_matriz_sh
                    ON
                    dimension_matriz_sh.iddimension_matriz_sh=dimension_matriz_sh_valor.iddimension_matriz_sh
                    WHERE
                    `persona`.`idpersona`=$idpersona AND
                    `persona`.`idmodulo`=$idmodulo AND
                    sh_dimension_matriz_sh.activo=1
                    GROUP BY
                    periodo,
                      `sh_dimension`.`idsh`,
                      `sh_dimension`.`idmodulo`,
                      `dimension_matriz_sh`.`iddimension_matriz_sh`
                    ORDER BY
                    `sh_dimension`.idsh_dimension
                    DESC";
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function get_analisis_red_mes($idpersona, $idmodulo) {
        $consulta = "SELECT
                      MAX(`sh_dimension`.`idsh_dimension`) AS `FIELD_1`,
                      `sh_dimension`.`idsh`,
                      `sh_dimension`.`idmodulo`,
                      `sh_dimension`.`comentario`,
                      DATE_FORMAT(`sh_dimension`.`fecha`, '%Y%m')  AS `periodo`,
                    persona.nombre,
                    persona.apellido_p,
                    persona.apellido_m,
                      dimension_matriz_sh_valor.puntaje,
                      dimension_matriz_sh_valor.iddimension_matriz_sh,
                      dimension_matriz_sh_valor.valor,
                      dimension_matriz_sh.dimension
                    FROM

                    persona
                    INNER JOIN `sh_dimension` ON (`persona`.`idpersona` = `sh_dimension`.`idsh`)
                      AND (`persona`.`idmodulo` = `sh_dimension`.`idmodulo`)

                    LEFT JOIN
                    sh_dimension_matriz_sh
                    ON
                    sh_dimension_matriz_sh.idsh_dimension=sh_dimension.idsh_dimension
                    AND
                    sh_dimension_matriz_sh.idmodulo_sh_dimension=sh_dimension.idmodulo_sh_dimension
                    LEFT JOIN
                    dimension_matriz_sh_valor
                    ON
                    dimension_matriz_sh_valor.iddimension_matriz_sh_valor=sh_dimension_matriz_sh.idsh_dimension_matriz_sh_valor
                    LEFT JOIN
                    dimension_matriz_sh
                    ON
                    dimension_matriz_sh.iddimension_matriz_sh=dimension_matriz_sh_valor.iddimension_matriz_sh
                    WHERE
                    `persona`.`idpersona`=$idpersona AND
                    `persona`.`idmodulo`=$idmodulo AND
                    sh_dimension_matriz_sh.activo=1
                    GROUP BY
                    periodo,
                      `sh_dimension`.`idsh`,
                      `sh_dimension`.`idmodulo`,
                      `dimension_matriz_sh`.`iddimension_matriz_sh`
                    ORDER BY
                    periodo
                    DESC";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function lista_persona_red($idpersona, $idmodulo) {

        $consulta = "SELECT
                      persona_red.idred,
                      persona.apellido_p,
                      persona.apellido_m,
                      persona.nombre,
                      persona.idpersona_tipo,
                      persona_red.idpersona,
                      persona_red.idmodulo,
                      sh.importancia
                    FROM
                    persona_red
                    LEFT JOIN
                    `persona`
                    ON
                    `persona_red`.`idpersona`=persona.`idpersona`
                    AND
                    `persona_red`.`idmodulo`=persona.`idmodulo`
                    LEFT JOIN
                    sh
                    ON
                    sh.idsh=persona_red.idpersona
                    AND
                    sh.idmodulo=persona_red.idmodulo
                    WHERE
                    persona_red.idpersona_red=$idpersona
                    AND
                    persona_red.idmodulo_red=$idmodulo
                    AND
                    persona_red.activo=1
                    ORDER BY
                    importancia
                    DESC";
        //echo $consulta;
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
                      concat(`persona`.`apellido_p`,' ',`persona`.`apellido_m`,', ',persona.nombre) AS nombre_completo,
                       persona.nombre,
                       persona.idpersona_tipo
                    FROM
                      `persona`
                      
                      WHERE
                   `persona`.`activo`=1 AND (persona.apellido_p like '$busca%' OR persona.nombre like '$busca%') $limit";

        //echo $consulta . "<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function listar_rol() {

       
        $consulta = "SELECT
                      `seguridad_rol`.`idseguridad_rol` as idrol, 
                      `seguridad_rol`.nombre as rol 
                    FROM
                      `seguridad_rol`                       
                     ";

        //echo $consulta . "<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
     function listar_usuario_rol($idrol) {

       
        $consulta = "SELECT
                      usuario.usuario,
                      persona.nombre,
                      persona.apellido_p,
                      persona.apellido_m
                    FROM
                      usuario
                    LEFT JOIN usuario_persona
                    ON usuario.idusuario = usuario_persona.idusuario
                    and usuario.idmodulo_usuario=usuario_persona.idmodulo_usuario
                    LEFT JOIN persona
                    ON persona.idpersona = usuario_persona.idpersona
                    and persona.idmodulo = usuario_persona.idmodulo
                    where
                    usuario.idseguridad_rol=$idrol
                    and usuario.activo=1
                    and persona.nombre is not NULL
                     ";

        //echo $consulta . "<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function listar_permiso() {

       
        $consulta = "SELECT
                      `seguridad_permiso`.`idseguridad_permiso` , 
                      `seguridad_permiso`.accion,
                      `seguridad_permiso`.objeto,
                      `seguridad_permiso`.nombre,
                      `seguridad_permiso`.es_server
                    FROM
                      `seguridad_permiso`
                      WHERE
                      seguridad_permiso.activo=1
                      order by objeto, accion asc
                     ";

        //echo $consulta . "<br>";
        $result = $this->sql->consultar($consulta, "sgrc");
        
        while (!!$fila = mysql_fetch_array($result)) {

            $apermiso[$fila[nombre] ][$fila[es_server]] = $fila[idseguridad_permiso];
        }

        return $apermiso;
    }
    
    function listar_permiso_rol($idrol){
        
        $consulta="select seguridad_permiso.idseguridad_permiso,
                seguridad_permiso.accion,
                seguridad_permiso.objeto,
                seguridad_permiso.nombre,
                `seguridad_permiso`.es_server,
                `tabla2`.idseguridad_rol       
                from seguridad_permiso
                left outer join  (select idseguridad_permiso,idseguridad_rol from `seguridad_permiso_grupo`
                where `seguridad_permiso_grupo`.idseguridad_rol=$idrol and `seguridad_permiso_grupo`.activo=1)
                as tabla2 on `tabla2`.`idseguridad_permiso`=`seguridad_permiso`.`idseguridad_permiso`
                WHERE
                seguridad_permiso.activo=1
                order by seguridad_permiso.objeto,seguridad_permiso.accion asc  ";
        
        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {

            $apermiso[idseguridad_permiso][$fila[nombre] ][$fila[es_server]] = $fila[idseguridad_permiso];
            $apermiso[idseguridad_rol][$fila[nombre] ][$fila[es_server]] = $fila[idseguridad_rol];
        }

        return $apermiso;
    }

}

?>
