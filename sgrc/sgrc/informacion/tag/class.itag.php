<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of itag
 *
 * @author dmontjoy
 */
class itag {

    public $sql;

    function itag() {
        $this->sql = new DmpSql();
    }

    function lista() {

        $consulta = "SELECT
                  `tag`.`idtag`,
                  `tag`.`idmodulo`,
                  `tag`.`tag`
                FROM
                  `tag`
                 WHERE
                   `tag`.`activo`=1 ";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    function total(){
        
         $consulta = "SELECT count(*) AS cantidad
                FROM
                  `tag`
                 WHERE
                   `tag`.`activo`=1 ";

        $result = $this->sql->consultar($consulta, "sgrc");
        $fila=  mysql_fetch_array($result);
        $cantidad=  $fila['cantidad'];
        return $cantidad;       
        
    }
    function get_idtag($idtag, $idmodulo_tag) {

        $consulta = "SELECT
                  `tag`.`idtag`,
                  `tag`.`idmodulo_tag`,
                  `tag`.`tag`,
                   tag.idtag_padre,
                   tag.idmodulo_tag_padre,
                  DATE_FORMAT(`tag`.`fecha_a`,'%d/%m/%Y') as 'fecha_a'
                FROM
                  `tag`
                 WHERE
                   `tag`.`idtag` = '$idtag' AND
                   `tag`.`idmodulo_tag`=$idmodulo_tag ";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
        //return $consulta;
    }

    function get_tag($busca,$idtag_entidad="") {
        
        if($busca=='*'){
            $busca="";
        }
        
        if($idtag_entidad!=""){
            
            $tag_from_entidad=" left join tag_entidad_tag
                  ON tag_entidad_tag.idtag = tag.idtag
                  AND tag_entidad_tag.idmodulo_tag = tag.idmodulo_tag ";
            
            $tag_where_entidad=" AND tag_entidad_tag.idtag_entidad=$idtag_entidad  "
                    . "    AND tag_entidad_tag.activo=1 ";
        }
        
        $consulta = "SELECT 
                  `tag`.`idtag`,
                  `tag`.`idmodulo_tag`,
                  `tag`.`tag`,
                  concat(`tag`.`idtag`,'---',`tag`.`idmodulo_tag`) AS idtag_compuesto
                FROM
                  `tag` $tag_from_entidad
                 WHERE
                    tag.tag like '%$busca%' 
                    AND `tag`.`activo`=1
                    $tag_where_entidad
                   ORDER BY `tag`.`tag`";
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_tags_persona($idtag, $idmodulo_tag) {
        
        $consulta = "SELECT tag from tag where idtag=$idtag AND idmodulo_tag=$idmodulo_tag ";
        
        $result = $this->sql->consultar($consulta, "sgrc");
        
        $fila = mysql_fetch_array($result);
        
        $tag = $fila['tag'];
                
        $consulta = "SELECT distinct
                  persona.idpersona,
                  persona.idmodulo,
                  persona.nombre,
                  persona.apellido_p,
                  persona.apellido_m,
                  persona.`idpersona_tipo`
                FROM
                  (SELECT * from persona_tag where activo=1) as persona_tag
                LEFT JOIN
                  persona
                ON
                persona_tag.idpersona=persona.idpersona
                AND persona_tag.idmodulo= persona.idmodulo

                 WHERE
                 
                    CONCAT(persona_tag.idtag,'-',persona_tag.idmodulo_tag)
                    IN (SELECT CONCAT(idtag,'-',idmodulo_tag) from tag where ruta like '%/$tag/%' or tag='$tag')
                  
                                  
                ";
        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function listar_tag($tag = "", $ultimos = "0") {

        if ($ultimos == 0) {
            $order = " ORDER BY tag ";
        } else {
            $order = " ORDER BY
                fecha_c
                DESC
                LIMIT " . max_br_m;
        }

        $consulta = "SELECT
                  `tag`.`idtag`,
                  `tag`.`idmodulo_tag`,
                  `tag`.`idusu_c`,
                  `tag`.`idmodulo_c`,
                  `tag`.`tag`,
                  DATE_FORMAT(`tag`.`fecha_a`,'%d/%m/%Y') as 'fecha_a'
                FROM
                  tag
                 WHERE
                  tag.tag like '%$tag%'
                AND
                  tag.activo=1
                $order";
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
     function lista_tag_nivel() {        

        $consulta = "SELECT
                  `tag`.`idtag`,
                  `tag`.`idmodulo_tag`,
                  `tag`.`idusu_c`,
                  `tag`.`idmodulo_c`,
                  `tag`.`tag`,
                  DATE_FORMAT(`tag`.`fecha_a`,'%d/%m/%Y') as 'fecha_a',
                  `tag`.`nivel`,
                  `tag`.`cantidad_hijos` as hijos,
                  `tag`.`idtag_padre`,
                  `tag`.`idmodulo_tag_padre`,
                  CONCAT(ruta,tag,'/') as tag_ruta,
                  IF( cantidad_hijos > 0 OR nivel < 1,CONCAT(ruta,tag,'/'),ruta) as campo                  
                FROM
                  tag
                 WHERE                 
                  tag.activo=1
                  order by campo, nivel";
        
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_tag_nivel_entidad() {        

        $consulta = "SELECT
                  `tag`.`idtag`,
                  `tag`.`idmodulo_tag`,
                  `tag`.`idusu_c`,
                  `tag`.`idmodulo_c`,
                  `tag`.`tag`,
                  DATE_FORMAT(`tag`.`fecha_a`,'%d/%m/%Y') as 'fecha_a',
                  `tag`.`nivel`,
                  `tag`.`cantidad_hijos` as hijos,
                  `tag`.`idtag_padre`,
                  `tag`.`idmodulo_tag_padre`,
                  CONCAT(tag.ruta,tag.tag,'/') as tag_ruta,
                  IF( tag.cantidad_hijos > 0 OR tag.nivel < 1,CONCAT(tag.ruta,tag.tag,'/'),tag.ruta) as campo,
                  tag_entidad.idtag_entidad,
                  tag_entidad.entidad
                FROM
                  tag
                  left outer join (select * from tag_entidad_tag where activo=1) as tag_entidad_tag
                  on tag_entidad_tag.idtag=tag.idtag
                  and tag_entidad_tag.idmodulo_tag=tag.idmodulo_tag
                  left outer join (select * from tag_entidad where activo=1) as tag_entidad
                  on tag_entidad_tag.idtag_entidad=tag_entidad.idtag_entidad
                 WHERE                 
                  tag.activo=1
                  order by campo, nivel";
        
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");
        
        $aresult=array();
        
        while($fila=  mysql_fetch_array($result)){
            $aresult['idtag'][$fila['idtag'].'_'.$fila['idmodulo_tag']]=  $fila['idtag'];
            $aresult['idmodulo_tag'][$fila['idtag'].'_'.$fila['idmodulo_tag']]=  $fila['idmodulo_tag'];
            $aresult['tag'][$fila['idtag'].'_'.$fila['idmodulo_tag']]=  $fila['tag'];
            $aresult['nivel'][$fila['idtag'].'_'.$fila['idmodulo_tag']]=  $fila['nivel'];
            $aresult['hijos'][$fila['idtag'].'_'.$fila['idmodulo_tag']]=  $fila['hijos'];                       
            $aresult['tag_ruta'][$fila['idtag'].'_'.$fila['idmodulo_tag']]=  $fila['tag_ruta'];
            $aresult['idtag_padre'][$fila['idtag'].'_'.$fila['idmodulo_tag']]=  $fila['idtag_padre'];
            $aresult['idmodulo_tag_padre'][$fila['idtag'].'_'.$fila['idmodulo_tag']]=  $fila['idmodulo_tag_padre'];
            if(isset($fila['idtag_entidad'])){
                $aresult['entidad'][$fila['idtag'].'_'.$fila['idmodulo_tag']][$fila['idtag_entidad']]=  $fila['entidad'];
            }
                                    
        }

        return $aresult;
    }
    
     function lista_tag_entidad() {        

        $consulta = "SELECT
                  `tag_entidad`.`idtag_entidad`,
                  `tag_entidad`.`entidad`
                  
                FROM
                  tag_entidad
                  
                 WHERE                 
                  tag_entidad.activo=1
                  ";
        
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
       function lista_tag_entidad_tag($idtag, $idmodulo_tag) {        

        $consulta = "SELECT distinct
                  `tag_entidad`.`idtag_entidad`,
                  `tag_entidad`.`entidad`,
                  `tag_entidad_tag`.`activo`
                  
                FROM
                  tag_entidad
                  left join (select * from tag_entidad_tag where tag_entidad_tag.activo=1 and tag_entidad_tag.idtag=$idtag and tag_entidad_tag.idmodulo_tag=$idmodulo_tag) as `tag_entidad_tag`
                  on tag_entidad_tag.`idtag_entidad`=`tag_entidad`.`idtag_entidad`

                 WHERE                 
                  tag_entidad.activo=1
                  ";
        
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_tag_nivel_sh() {        

        $consulta = "SELECT
                  `tag`.`idtag`,
                  `tag`.`idmodulo_tag`,
                  `tag`.`idusu_c`,
                  `tag`.`idmodulo_c`,
                  `tag`.`tag`,
                  DATE_FORMAT(`tag`.`fecha_a`,'%d/%m/%Y') as 'fecha_a',
                  `tag`.`nivel`,
                  `tag`.`cantidad_hijos` as hijos,
                  `tag`.`idtag_padre`,
                  `tag`.`idmodulo_tag_padre`,
                  CONCAT(ruta,tag,'/') as tag_ruta,
                  IF( cantidad_hijos > 0 OR nivel < 1,CONCAT(ruta,tag,'/'),ruta) as campo,
                  (select count(*) from persona_tag
                    left join persona
                    on persona.idpersona = persona_tag.idpersona
                    and persona.idmodulo = persona_tag.idmodulo
                    where tag.idtag=persona_tag.idtag
                    and persona.activo=1 and persona_tag.activo=1
                    and tag.idmodulo_tag=persona_tag.idmodulo_tag) as sh
                FROM
                  tag
                 WHERE                 
                  tag.activo=1
                  having sh > 0
                  order by campo, nivel
                  ";
        
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_tag_nivel_interaccion() {        

        $consulta = "SELECT
                  `tag`.`idtag`,
                  `tag`.`idmodulo_tag`,
                  `tag`.`idusu_c`,
                  `tag`.`idmodulo_c`,
                  `tag`.`tag`,
                  DATE_FORMAT(`tag`.`fecha_a`,'%d/%m/%Y') as 'fecha_a',
                  `tag`.`nivel`,
                  `tag`.`cantidad_hijos` as hijos,
                  `tag`.`idtag_padre`,
                  `tag`.`idmodulo_tag_padre`,
                  CONCAT(ruta,tag,'/') as tag_ruta,
                  IF( cantidad_hijos > 0 OR nivel < 1,CONCAT(ruta,tag,'/'),ruta) as campo,
                  (select count(*) from interaccion_tag
                    left join interaccion
                    on interaccion.idinteraccion = interaccion_tag.idinteraccion
                    and interaccion.idmodulo_interaccion = interaccion_tag.idmodulo_interaccion
                    where tag.idtag=interaccion_tag.idtag
                    and interaccion.activo=1 and interaccion_tag.activo=1
                    and tag.idmodulo_tag=interaccion_tag.idmodulo_tag) as interaccion
                FROM
                  tag
                 WHERE                 
                  tag.activo=1
                  having interaccion > 0
                  order by campo, nivel
                  ";
        
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_tag_nivel_predio() {        

        $consulta = "SELECT
                  `tag`.`idtag`,
                  `tag`.`idmodulo_tag`,
                  `tag`.`idusu_c`,
                  `tag`.`idmodulo_c`,
                  `tag`.`tag`,
                  DATE_FORMAT(`tag`.`fecha_a`,'%d/%m/%Y') as 'fecha_a',
                  `tag`.`nivel`,
                  `tag`.`cantidad_hijos` as hijos,
                  `tag`.`idtag_padre`,
                  `tag`.`idmodulo_tag_padre`,
                  CONCAT(ruta,tag,'/') as tag_ruta,
                  IF( cantidad_hijos > 0 OR nivel < 1,CONCAT(ruta,tag,'/'),ruta) as campo,
                  (select count(*) from predio_tag
                    left join predio
                    on predio.idpredio = predio_tag.idpredio                    
                    where tag.idtag=predio_tag.idtag
                    and predio.activo=1 and predio_tag.activo=1
                    and tag.idmodulo_tag=predio_tag.idmodulo_tag) as predio
                FROM
                  tag
                 WHERE                 
                  tag.activo=1
                  having predio > 0
                  order by campo, nivel
                  ";
        
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function get_array_tag($idprioridad_complejo_tag){
        
        $cant = count($idprioridad_complejo_tag);
        
        $atag = array();
                        
        if($cant>0){
            
            $cidprioridad_complejo_tag="  CONCAT(`tag`.`idtag`,'---', `tag`.`idmodulo_tag`)
                IN ( ";
            foreach ($idprioridad_complejo_tag as $valor){
               
                    $cidprioridad_complejo_tag.= "'".$valor."',";                    
                
            }
            $cidprioridad_complejo_tag = substr($cidprioridad_complejo_tag, 0, -1);
            
            $cidprioridad_complejo_tag.= " )  "; 
            
            
        
            //lista las interaccions con un stakeholder
            $consulta = "SELECT distinct
                    tag.idtag,
                    tag.idmodulo_tag,
                    tag.tag
                    FROM
                      tag
                   WHERE
                    `tag`.`activo`= 1
                     AND $cidprioridad_complejo_tag
                   ";

            //echo $consulta;
            $result = $this->sql->consultar($consulta, "sgrc");

            while (!!$fila = mysql_fetch_array($result)) {

                $atag[$fila[idtag] . "-" . $fila[idmodulo_tag]] = $fila[tag];
                

                //print_r($ainteraccion['archivo']);
            }
                       
        }
        
        
       
        //print_r($ainteraccion);
        return $atag;
        
    }

}

?>
