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
class ireclamo {
    //put your code here
    public $sql;
	
    function ireclamo(){
            $this->sql = new DmpSql();
    }  
    
    



    function get_reclamo($idreclamo,$idmodulo_reclamo){
        
        $consulta="SELECT 
                      `reclamo`.`reclamo`,
                      `reclamo`.`comentario`,
                      `reclamo`.`idreclamo_estado`,
                      `reclamo`.`idreclamo_previo`,
                      `reclamo`.`idmodulo_reclamo_previo`,
                      DATE_FORMAT(reclamo.fecha,'%d/%m/%Y') AS fecha,
                      `reclamo`.`idfase`,
                      `reclamo_tipo`.`tipo`,
                      `reclamo_tipo`.`idreclamo_tipo`,
                      `reclamo_estado`.`tipo` as tipo_estado,
                      `reclamo_estado`.`estado`,
                      `reclamo_estado`.`nombre_tipo`
                    FROM
                      `reclamo`
                      LEFT JOIN `reclamo_tipo`
                      ON `reclamo`.idreclamo_tipo = `reclamo_tipo`.idreclamo_tipo
                      LEFT JOIN `reclamo_estado`
                      ON `reclamo`.idreclamo_estado = `reclamo_estado`.idreclamo_estado
                    WHERE
                    `reclamo`.`idreclamo`=$idreclamo
                     AND `reclamo`.`idmodulo_reclamo`=$idmodulo_reclamo
                     ";
        
        //echo $consulta;
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
     function get_evaluacion($idevaluacion,$idmodulo_evaluacion){
        
        $consulta="SELECT 
                      `evaluacion`.`idreclamo`,
                      `evaluacion`.`idmodulo_reclamo`,
                      evaluacion.evaluacion
                    FROM
                      `evaluacion`
                     
                    WHERE
                    `evaluacion`.`idevaluacion`=$idevaluacion
                     AND `evaluacion`.`idmodulo_evaluacion`=$idmodulo_evaluacion
                     ";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista_tag_reclamo($idreclamo,$idmodulo_reclamo){
        $consulta="SELECT 
                    `tag`.`tag`,
                    `reclamo_tag`.`activo`,
                    `tag`.`activo`,
                    `reclamo_tag`.`idtag`,
                    `reclamo_tag`.`idmodulo_tag`,
                    `reclamo_tag`.`idreclamo`,
                    `reclamo_tag`.`idmodulo_reclamo`,
                    reclamo_tag.idreclamo_tag,
                    `reclamo_tag`.`idmodulo_reclamo_tag`
                    FROM
                    `reclamo_tag`
                    INNER JOIN `tag` ON (`reclamo_tag`.`idtag` = `tag`.`idtag`)
                    AND (`reclamo_tag`.`idmodulo_tag` = `tag`.`idmodulo_tag`)
                    INNER JOIN `reclamo` ON (`reclamo_tag`.`idmodulo_reclamo` = `reclamo`.`idmodulo_reclamo`)
                    AND (`reclamo_tag`.`idreclamo` = `reclamo`.`idreclamo`)
                    WHERE
                    `reclamo`.`activo`= 1 AND
                    `reclamo_tag`.`activo`=1 AND
                    `reclamo_tag`.`idreclamo` = $idreclamo AND
                    `reclamo_tag`.`idmodulo_reclamo` = $idmodulo_reclamo";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
        
    }
    
    function lista_reclamo_sh($idreclamo,$idmodulo){
        //lista los sh de una reclamo
        $consulta="SELECT 
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      `persona`.`nombre`,
                      `persona`.`activo`,
                      `sh`.`activo`,
                      `sh`.`idsh`,
                      `reclamo_sh`.`idreclamo_sh`,
                      `reclamo_sh`.`idmodulo_reclamo_sh`
                    FROM
                      `reclamo`
                      INNER JOIN `reclamo_sh` ON (`reclamo`.`idreclamo` = `reclamo_sh`.`idreclamo`)
                      AND (`reclamo`.`idmodulo_reclamo` = `reclamo_sh`.`idmodulo_reclamo`)
                      INNER JOIN `sh` ON (`reclamo_sh`.`idsh` = `sh`.`idsh`)
                      AND (`reclamo_sh`.`idmodulo` = `sh`.`idmodulo`)
                      INNER JOIN `persona` ON (`sh`.`idsh` = `persona`.`idpersona`)
                      AND (`sh`.`idmodulo` = `persona`.`idmodulo`)
                    WHERE
                    `reclamo`.`activo`= 1 AND 
                    `reclamo_sh`.`activo`= 1 AND
                    `sh`.`activo`= 1 AND 
                    `persona`.`activo`= 1 AND 
                    `reclamo`.`idreclamo` = $idreclamo AND
                    `reclamo`.`idmodulo_reclamo` = $idmodulo";
        
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }

      function lista_reclamo_rc($idreclamo,$idmodulo){
        
        $consulta="SELECT distinct
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      `persona`.`nombre`,
                      `persona`.`activo`,
                      `reclamo_rc`.`activo`,
                      `reclamo_rc`.`idrol`,
                      DATE_FORMAT(reclamo_rc.fecha,'%d/%m/%Y') AS fecha,
                      `reclamo`.`idreclamo`,
                      `reclamo`.`idmodulo_reclamo`,
                      `reclamo`.`idusu_c`,
                      `reclamo`.`idmodulo_c`,
                      `reclamo_rc`.`idmodulo_reclamo_rc`,
                      `reclamo_rc`.`idreclamo_rc`
                    FROM
                      `reclamo`
                      INNER JOIN `reclamo_rc` ON (`reclamo`.`idreclamo` = `reclamo_rc`.`idreclamo`)
                      AND (`reclamo`.`idmodulo_reclamo` = `reclamo_rc`.`idmodulo_reclamo`)
                     INNER JOIN `rc` ON (`reclamo_rc`.`idrc` = `rc`.`idrc`)
                      AND (`reclamo_rc`.`idmodulo` = `rc`.`idmodulo`)
                      INNER JOIN `persona` ON (`reclamo_rc`.`idrc` = `persona`.`idpersona`)
                      AND (`reclamo_rc`.`idmodulo` = `persona`.`idmodulo`)
                    WHERE
                    `reclamo`.`activo`= 1 AND 
                    `reclamo_rc`.`activo`= 1 AND
                    `rc`.`activo`= 1 AND
                    `persona`.`activo`= 1 AND 
                    `reclamo`.`idreclamo` = $idreclamo AND
                    `reclamo`.`idmodulo_reclamo` = $idmodulo";
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
     function   lista_stakeholder_reclamo($id, $idmodulo, $inicio = 0, $persona = 0, $orden=0) {
        //persona 1, item 0
        //lista stakeholder, pues puede ser una stakeholder como un rc
        // `sh`.`activo`= 1, lo que quitado pero podria ir
        $limite = "";

        if($persona==0){
            $condicion = "";
        }elseif ($persona == 1) {
            //sh
            //$condicion = " persona.idpersona= $id AND persona.idmodulo= $idmodulo AND reclamo_sh.`principal`=1 AND";
            $condicion = " CONCAT(`reclamo`.`idreclamo`, '-', `reclamo`.`idmodulo_reclamo`) 
                          IN(SELECT 
                             CONCAT(`idreclamo`,'-' ,`idmodulo_reclamo`) AS `FIELD_1`
                             FROM
                            `reclamo_sh`
                          WHERE idsh=$id AND idmodulo=$idmodulo AND activo=1) AND ";
            
        } elseif ($persona == 2) {
            //rc
            //$condicion = " persona1.idpersona= $id AND persona1.idmodulo= $idmodulo AND  reclamo_rc.principal = 1 AND ";
            $condicion = " persona1.idpersona= $id AND persona1.idmodulo= $idmodulo AND  ";
        } else {
            $condicion = " reclamo.idreclamo= $id AND reclamo.idmodulo_reclamo= $idmodulo AND  ";
        }

        if ($inicio != 0) {

            $cinicio = "AND DATEDIFF(now(),reclamo.fecha) < $inicio ";
        }
        
        if ($orden != 0) {

            $orden_evaluacion="`evaluacion`.`fecha_c` ASC";
        }else{
            $orden_evaluacion="`evaluacion`.`idevaluacion` DESC,
                               `evaluacion`.`idmodulo_evaluacion` DESC";
        }
        //lista los reclamos con un stakeholder
        $consulta = "SELECT distinct
                 DATE_FORMAT(reclamo.fecha,'%d/%m/%Y') AS fecha,
                  `reclamo`.`reclamo`,
                  `reclamo`.`activo`,
                  `sh`.`activo`,                  
                  `persona`.`activo`,
                  `persona`.`imagen`,
                  `reclamo`.`idreclamo`,
                  `reclamo`.`idmodulo_reclamo`,
                  `reclamo`.`idreclamo_previo`,
                  `reclamo`.`idmodulo_reclamo_previo`,
                  `reclamo_estado`.`estado`,
                  `reclamo_estado`.`nombre_tipo`,
                  `reclamo_tipo`.`tipo`,
                  reclamo_sh.activo,
                  `reclamo_rc`.`idrol`,
                  `reclamo_rc`.`activo` as reclamo_rc_activo,                 
                 `evaluacion`.`evaluacion`,
                `evaluacion`.`activo` as evaluacion_activo,
                `evaluacion`.`idevaluacion`,
                `evaluacion`.`idmodulo_evaluacion`,
                `evaluacion`.`idusu_c` as idusu_c_evaluacion,
                `evaluacion`.`idmodulo_c` as idmodulo_c_evaluacion,
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
              `propuesta`.`activo` as propuesta_activo,
              `propuesta`.`idpropuesta`,
              `propuesta`.`idmodulo_propuesta`,
              `propuesta`.`propuesta`,
              `propuesta`.`comentario_realizado`,
              `propuesta`.`idusu_c` as idusu_c_propuesta,
              `propuesta`.`idmodulo_c` as idmodulo_c_propuesta,
              DATE_FORMAT(propuesta.fecha,'%d/%m/%Y') as propuesta_fecha,
              `apelacion`.`activo` as apelacion_activo,
              `apelacion`.`idapelacion`,
              `apelacion`.`idmodulo_apelacion`,
              `apelacion`.`apelacion`,
              `apelacion`.`idusu_c` as idusu_c_apelacion,
              `apelacion`.`idmodulo_c` as idmodulo_c_apelacion,
              DATE_FORMAT(apelacion.fecha,'%d/%m/%Y') as apelacion_fecha
              
                FROM
                  `reclamo`
                  LEFT OUTER JOIN `reclamo_tipo` ON `reclamo`.idreclamo_tipo = `reclamo_tipo`.idreclamo_tipo
                  LEFT OUTER JOIN `reclamo_estado` ON (`reclamo_estado`.`idreclamo_estado` = `reclamo`.`idreclamo_estado`)
                  LEFT OUTER JOIN `reclamo_sh` ON (`reclamo_sh`.`idreclamo` = `reclamo`.`idreclamo`)
                  AND (`reclamo_sh`.`idmodulo_reclamo` = `reclamo`.`idmodulo_reclamo`)
                  LEFT OUTER JOIN `sh` ON (`sh`.`idsh` = `reclamo_sh`.`idsh`)
                  AND (`sh`.`idmodulo` = `reclamo_sh`.`idmodulo`)
                  LEFT OUTER JOIN `persona` ON (`persona`.`idpersona` = `sh`.`idsh`)
                  AND (`persona`.`idmodulo` = `sh`.`idmodulo`)
                  LEFT OUTER JOIN `evaluacion` ON (`reclamo`.`idreclamo` = `evaluacion`.`idreclamo`)
                  AND (`reclamo`.`idmodulo_reclamo` = `evaluacion`.`idmodulo_reclamo`)
                  LEFT OUTER JOIN `reclamo_rc` ON (`reclamo`.`idreclamo` = `reclamo_rc`.`idreclamo`)
                  AND (`reclamo`.`idmodulo_reclamo` = `reclamo_rc`.`idmodulo_reclamo`)
                  LEFT OUTER JOIN `rc` ON (`reclamo_rc`.`idrc` = `rc`.`idrc`)
                  AND (`reclamo_rc`.`idmodulo` = `rc`.`idmodulo`)
                  LEFT OUTER JOIN `persona` `persona1` ON (`rc`.`idrc` = `persona1`.`idpersona`)
                  AND (`rc`.`idmodulo` = `persona1`.`idmodulo`)
                  LEFT OUTER JOIN `propuesta` ON (`evaluacion`.`idevaluacion` = `propuesta`.`idevaluacion`)
                  AND (`evaluacion`.`idmodulo_evaluacion` = `propuesta`.`idmodulo_evaluacion`)
                  LEFT OUTER JOIN `apelacion` ON (`evaluacion`.`idevaluacion` = `apelacion`.`idevaluacion`)
                  AND (`evaluacion`.`idmodulo_evaluacion` = `apelacion`.`idmodulo_evaluacion`)
               WHERE
                `persona`.`activo`= 1
                 AND $condicion
                 reclamo.activo= 1 AND
                 reclamo_sh.activo= 1
                 $cinicio
               ORDER BY
                 reclamo.fecha DESC,
                `reclamo`.`idreclamo` DESC,
                `reclamo`.`idmodulo_reclamo` DESC,
                $orden_evaluacion";

       //echo "<br/>$consulta";exit;
        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {

            $areclamo['idmodulo_reclamo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idmodulo_reclamo];

            $areclamo['idreclamo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idreclamo];
            
            $areclamo['idmodulo_c'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idmodulo_c];

            $areclamo['idusu_c'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idusu_c];
            
            $areclamo['idmodulo_reclamo_previo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idmodulo_reclamo_previo];

            $areclamo['idreclamo_previo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idreclamo_previo];

            $areclamo['reclamo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[reclamo];
            
            $areclamo['estado'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[estado]." ( $fila[nombre_tipo] ) ";
            
            $areclamo['tipo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[tipo];

            $areclamo['fecha'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[fecha];
            
            if($fila[reclamo_rc_activo]==1)
                $areclamo['rc'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[rc_idpersona] . "-" . $fila[rc_idmodulo] ."-" .$fila[idrol]] = $fila[rc_apellido_p] . " " . $fila[rc_apellido_m] . " " . $fila[rc_nombre]. "---".$fila[idrol];

            $areclamo['sh'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[sh_idpersona] . "-" . $fila[sh_idmodulo]] = $fila[sh_idpersona].'---'.$fila[sh_idmodulo].'---'.$fila[sh_apellido_p] . " " . $fila[sh_apellido_m] . " " . $fila[sh_nombre].'---'.$fila[sh_idpersona_tipo].'---'.$fila[imagen];
            
            //echo "sh_idpersona_tipo: $fila[sh_idpersona_tipo]";

            if ($fila[idevaluacion] != "" && $fila[evaluacion_activo] != 0 ) {
                $areclamo['idevaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = $fila[idevaluacion];
                $areclamo['idmodulo_evaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = $fila[idmodulo_evaluacion];
                $areclamo['idusu_c_evaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = $fila[idusu_c_evaluacion];
                $areclamo['idmodulo_c_evaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = $fila[idmodulo_c_evaluacion];
                $areclamo['evaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = $fila[evaluacion];
                $areclamo['fecha_evaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = "";
            }
            
            if ($fila[idpropuesta] != "" && $fila[propuesta_activo] != 0 ) {
                $areclamo['idpropuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[idpropuesta];
                $areclamo['idmodulo_propuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[idmodulo_propuesta];
                $areclamo['propuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[propuesta];
                $areclamo['comentario_realizado'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[comentario_realizado];
                $areclamo['fecha_propuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[propuesta_fecha];
                $areclamo['idusu_c_propuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[idusu_c_propuesta];
                $areclamo['idmodulo_c_propuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[idmodulo_c_propuesta];
            }
            
             if ($fila[idapelacion] != "" && $fila[apelacion_activo] != 0 ) {
                $areclamo['idapelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[idapelacion];
                $areclamo['idmodulo_apelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[idmodulo_apelacion];
                $areclamo['apelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[apelacion];
                $areclamo['fecha_apelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[apelacion_fecha];
                $areclamo['idusu_c_apelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[idusu_c_apelacion];
                $areclamo['idmodulo_c_apelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[idmodulo_c_apelacion];
            }
        }
        //print_r($areclamo);
        return $areclamo;
    }
    
    function   lista_relacionista_reclamo($id, $idmodulo, $inicio = 0) {
        //persona 1, item 0
        //lista stakeholder, pues puede ser una stakeholder como un rc
        // `sh`.`activo`= 1, lo que quitado pero podria ir
        $limite = "";

       
            //rc
            //$condicion = " persona1.idpersona= $id AND persona1.idmodulo= $idmodulo AND  reclamo_rc.principal = 1 AND ";
            $condicion = " persona1.idpersona= $id AND persona1.idmodulo= $idmodulo AND `reclamo_rc`.`idrol`=2 AND";
       

        if ($inicio != 0) {

            $limite = "LIMIT 0,$inicio ";
        }
        
       
        //lista los reclamos con un stakeholder
        $consulta = "SELECT distinct
                 DATE_FORMAT(reclamo.fecha,'%d/%m/%Y') AS fecha,
                  `reclamo`.`reclamo`,                                                          
                  `reclamo`.`idreclamo`,
                  `reclamo`.`idmodulo_reclamo`,
                  `reclamo`.`idusu_c`,
                  `reclamo`.`idmodulo_c`, 
                  `reclamo_estado`.`estado`,
                  `reclamo_tipo`.`tipo`,                 
                  `reclamo_rc`.`idrol`                                                             
                FROM
                  `reclamo`
                  LEFT OUTER JOIN `reclamo_tipo` ON `reclamo`.idreclamo_tipo = `reclamo_tipo`.idreclamo_tipo
                  LEFT OUTER JOIN `reclamo_estado` ON (`reclamo_estado`.`idreclamo_estado` = `reclamo`.`idreclamo_estado`)                 
                  LEFT OUTER JOIN `reclamo_rc` ON (`reclamo`.`idreclamo` = `reclamo_rc`.`idreclamo`)
                  AND (`reclamo`.`idmodulo_reclamo` = `reclamo_rc`.`idmodulo_reclamo`)
                  LEFT OUTER JOIN `rc` ON (`reclamo_rc`.`idrc` = `rc`.`idrc`)
                  AND (`reclamo_rc`.`idmodulo` = `rc`.`idmodulo`)
                  LEFT OUTER JOIN `persona` `persona1` ON (`rc`.`idrc` = `persona1`.`idpersona`)
                  AND (`rc`.`idmodulo` = `persona1`.`idmodulo`)                  
               WHERE
                `persona1`.`activo`= 1 AND 
                $condicion
                 reclamo.activo= 1 AND
                 `reclamo_rc`.`activo` =1
               ORDER BY
                 reclamo.fecha DESC,
                `reclamo`.`idreclamo` DESC,
                `reclamo`.`idmodulo_reclamo` DESC
                $limite";

        //echo "<br/>$consulta";
        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {

            $areclamo['idmodulo_reclamo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idmodulo_reclamo];

            $areclamo['idreclamo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idreclamo];
            
            $areclamo['idmodulo_c'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idmodulo_c];

            $areclamo['idusu_c'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idusu_c];
                        
            $areclamo['reclamo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[reclamo];
            
            $areclamo['estado'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[estado];
            
            $areclamo['tipo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[tipo];

            $areclamo['fecha'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[fecha];
            
            if($fila[reclamo_rc_activo]==1)
                $areclamo['rc'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[rc_idpersona] . "-" . $fila[rc_idmodulo] ."-" .$fila[idrol]] = $fila[rc_apellido_p] . " " . $fila[rc_apellido_m] . " " . $fila[rc_nombre]. "---".$fila[idrol];
            
        }
        return $areclamo;
    }
    
    function lista_archivo($idreclamo,$idmodulo){
        
        $consulta="SELECT 
                      `reclamo_archivo`.`idreclamo_archivo`,  
                      `reclamo_archivo`.`idmodulo_reclamo_archivo`,  
                      `reclamo_archivo`.`archivo`,
                      `reclamo_archivo`.`fecha`,
                      `reclamo_archivo`.`activo`
                      
                    FROM
                      `reclamo_archivo`
                      
                    WHERE
                    `reclamo_archivo`.`idreclamo` = $idreclamo AND
                    `reclamo_archivo`.`idmodulo_reclamo` = $idmodulo AND
                    `reclamo_archivo`.`activo` = 1 ";
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista_evaluacion($idreclamo,$idmodulo){
        
        $consulta="SELECT 
                      `evaluacion`.`idevaluacion`,  
                      `evaluacion`.`idmodulo_evaluacion`,  
                      `evaluacion`.`evaluacion`
                      
                    FROM
                      `evaluacion`
                      
                    WHERE
                    `evaluacion`.`idreclamo` = $idreclamo AND
                    `evaluacion`.`idmodulo_reclamo` = $idmodulo AND
                    `evaluacion`.`activo` = 1 ";
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function get_fase($idreclamo,$idmodulo){
        
        $consulta="SELECT 
                      `fase`.`idfase`,  
                      `fase`.`fase`,
                      `fase`.`dias_max`,
                      ( select count(*) from fase where activo=1) as total,
                      reclamo.fecha_fase
                    FROM
                      `fase`
                    LEFT JOIN reclamo
                    ON reclamo.idfase=fase.idfase
                    WHERE
                    `reclamo`.`idreclamo` = $idreclamo     AND
                    `reclamo`.`idmodulo_reclamo` = $idmodulo 
                   ";
        //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista_fase(){
        
        $consulta="SELECT 
                      `fase`.`idfase`,  
                      `fase`.`fase`,
                      `fase`.`dias_max`
                    FROM
                      fase                    
                    WHERE                    
                    `fase`.`activo` = 1
                    ORDER BY
                    `fase`.`idfase` ASC
                    ";
        
        //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista_tipo(){
        
        $consulta="SELECT                       
                      `reclamo_tipo`.`idreclamo_tipo`,
                      `reclamo_tipo`.`tipo`
                    FROM
                      reclamo_tipo            
                    WHERE                    
                    `reclamo_tipo`.`activo` = 1                    
                    ";
        
        //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
     function lista_estado(){
        
        $consulta="SELECT                       
                      `reclamo_estado`.`idreclamo_estado`,
                      `reclamo_estado`.`estado`
                    FROM
                      reclamo_estado            
                                    
                    ";
        
        //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista($busca = "", $con_limit = "") {

        $limit = "";
        if ($con_limit != "") {
            $con_limit = max_br_m;
            $limit = " LIMIT 0,$con_limit";
        }
        $consulta = "SELECT
                    
                      concat(`reclamo`.`idreclamo`,'-',`reclamo`.`idmodulo_reclamo`) AS idreclamo_compuesto
                    FROM
                      `reclamo`
                      WHERE
                   `reclamo`.`activo`=1 
                   having idreclamo_compuesto like '%$busca%' $limit";

        //echo $consulta . "<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }
    
    function lista_reporte($identidad,$idmodulo_entidad,$entidad,$idreclamo_fase,$idreclamo_tipo,$idreclamo_estado,$fecha_del , $fecha_al, $idreclamo_complejo_tag , $idreclamo_complejo_sh, $idreclamo_rc,$idreclamo_complejo_rc,$plazo) {
        
        if( $identidad!="" || $idmodulo_entidad!="" ){
            $cidentidad =" CONCAT(`$entidad`.`id$entidad`,'-',`$entidad`.`idmodulo_$entidad`) like '%$identidad%-$idmodulo_entidad%' AND ";            
        }else{
            $cidentidad="";
        }
        
        $cant = count($idreclamo_fase);
                        
        if($cant>0){
            $cidreclamo_fase=" AND `reclamo`.`idfase` 
                            IN ( ";
            foreach ($idreclamo_fase as $valor){
               
                    $cidreclamo_fase.= "'".$valor."',";                    
                
            }
            $cidreclamo_fase = substr($cidreclamo_fase, 0, -1);
            
            $cidreclamo_fase.= " ) "; 
                       
        }else{
            $cidreclamo_fase="";
        }
        
        $cant = count($idreclamo_tipo);
                        
        if($cant>0){
            $cidreclamo_tipo=" AND `reclamo_tipo`.`idreclamo_tipo` 
                            IN ( ";
            foreach ($idreclamo_tipo as $valor){
               
                    $cidreclamo_tipo.= "'".$valor."',";                    
                
            }
            $cidreclamo_tipo = substr($cidreclamo_tipo, 0, -1);
            
            $cidreclamo_tipo.= " ) "; 
                       
        }else{
            $cidreclamo_tipo="";
        }
        
        $cant = count($idreclamo_estado);
        
        if($cant>0){
            $cidreclamo_estado=" AND `reclamo_estado`.`idreclamo_estado` 
                            IN ( ";
            foreach ($idreclamo_estado as $valor){
               
                    $cidreclamo_estado.= "'".$valor."',";                    
                
            }
            $cidreclamo_estado = substr($cidreclamo_estado, 0, -1);
            
            $cidreclamo_estado.= " ) "; 
                       
        }else{
            $cidreclamo_estado="";
        }
        
        if($fecha_del!="" && $fecha_al!=""){
            $ayudante = new Ayudante();
            $fecha_del = $ayudante->FechaRevezMysql($fecha_del,"/");
            $fecha_al = $ayudante->FechaRevezMysql($fecha_al,"/");
            $cfecha=" AND `$entidad`.`fecha`>='$fecha_del' AND `$entidad`.`fecha`<='$fecha_al'";
        }else{
            $cfecha="";
        }
        
        $tags = count($idreclamo_complejo_tag);
                        
        if($tags>0){
            $creclamo_tag=" ,
					(
                    SELECT COUNT(*)
                    FROM `reclamo_tag` 
                    WHERE (`reclamo`.`idreclamo` = `reclamo_tag`.`idreclamo`)
                    AND (`reclamo`.`idmodulo_reclamo` = `reclamo_tag`.`idmodulo_reclamo`)
                    AND CONCAT(`reclamo_tag`.`idtag`,'---',`reclamo_tag`.`idmodulo_tag`) 
		    IN ( ";
            foreach ($idreclamo_complejo_tag as $valor){
                if(strpos($valor, "###")){
                    $tags--;
                }else{
                    $creclamo_tag.= "'".$valor."',";                    
                }
            }
            $creclamo_tag = substr($creclamo_tag, 0, -1);
            
            $creclamo_tag.= " ) AND `reclamo_tag`.`activo`=1) as 'tags' ";
                            
            if($tags==0){
                $creclamo_tag="";
            }
            
        }else{
            $creclamo_tag="";
        }
        
        $shs = count($idreclamo_complejo_sh);
                        
        if($shs>0){
            $creclamo_sh=" ,
                    (
                    SELECT COUNT(*)
                    FROM `reclamo_sh` 
                    WHERE (`reclamo`.`idreclamo` = `reclamo_sh`.`idreclamo`)
                    AND (`reclamo`.`idmodulo_reclamo` = `reclamo_sh`.`idmodulo_reclamo`)
                    AND CONCAT(`reclamo_sh`.`idsh`,'---',`reclamo_sh`.`idmodulo`) 
                    IN (  ";
            foreach ($idreclamo_complejo_sh as $valor){
                if(strpos($valor, "###")){
                    $shs--;
                }else{
                    $aux_valor = explode("---", $valor);
                    $creclamo_sh.= "'$aux_valor[0]---$aux_valor[1]',";  
                    
                }
            }
            $creclamo_sh = substr($creclamo_sh, 0, -1);
            
            $creclamo_sh.= " ) AND `reclamo_sh`.`activo`=1  ) as 'shs'";
                            
            if($shs==0){
                $creclamo_sh="";
            }
            
        }else{
            $creclamo_sh="";
        }
        
        
                        
        if(isset($idreclamo_rc)){
            $rc1=1;
            $creclamo_rc1=" ,
                    (
                    SELECT COUNT(*)
                    FROM `reclamo_rc` 
                    WHERE (`reclamo`.`idreclamo` = `reclamo_rc`.`idreclamo`)
                    AND (`reclamo`.`idmodulo_reclamo` = `reclamo_rc`.`idmodulo_reclamo`)
                    AND CONCAT(`reclamo_rc`.`idrc`,'---',`reclamo_rc`.`idmodulo`) 
                    IN (  ";
            
                
                    $aux_valor = explode("---", $idreclamo_rc);
                    $creclamo_rc1.= "'$aux_valor[0]---$aux_valor[1]',";  
                    
                
            
            $creclamo_rc1 = substr($creclamo_rc1, 0, -1);
            
            $creclamo_rc1.= " ) AND `reclamo_rc`.`activo`=1 AND `reclamo_rc`.`idrol`=1 ) as 'rc1'";
                                       
            
        }else{
            $rc1=0;
            $creclamo_rc1="";
        }
        
        $rc2 = count($idreclamo_complejo_rc);
                        
        if($rc2>0){
            $creclamo_rc2=" ,
                    (
                    SELECT COUNT(*)
                    FROM `reclamo_rc` 
                    WHERE (`reclamo`.`idreclamo` = `reclamo_rc`.`idreclamo`)
                    AND (`reclamo`.`idmodulo_reclamo` = `reclamo_rc`.`idmodulo_reclamo`)
                    AND CONCAT(`reclamo_rc`.`idrc`,'---',`reclamo_rc`.`idmodulo`) 
                    IN (  ";
            foreach ($idreclamo_complejo_rc as $valor){
                if(strpos($valor, "###")){
                    $rc2--;
                }else{
                    $aux_valor = explode("---", $valor);
                    $creclamo_rc2.= "'$aux_valor[0]---$aux_valor[1]',";  
                    
                }
            }
            $creclamo_rc2 = substr($creclamo_rc2, 0, -1);
            
            $creclamo_rc2.= " ) AND `reclamo_rc`.`activo`=1 AND `reclamo_rc`.`idrol`=2 ) as 'rc2'";
                            
            if($rc2==0){
                $creclamo_rc2="";
            }
            
        }else{
            $creclamo_rc2="";
        }
                                       
        $total=$tags+$rc1+$rc2+$shs+$plazo;
        
        if($total>0 || isset($plazo)){
            
            $cid  = "  HAVING 1=1 ";
            if($tags>0)$cid.=" AND tags>=$tags "; 
            if($rc1>0) $cid.=" AND rc1>=$rc1 "; 
            if($rc2>0) $cid.=" AND rc2>=$rc2 ";
            if($shs>0) $cid.=" AND shs>=$shs "; 
            if( $plazo!="") $cid.=" AND plazo=$plazo ";
            
        }

        
         $consulta = "SELECT distinct
                 DATE_FORMAT(reclamo.fecha,'%d/%m/%Y') AS fecha,
                  `reclamo`.`reclamo`,
                  `reclamo`.`activo`,
                  `sh`.`activo`,                  
                  `persona`.`activo`,
                  `persona`.`imagen`,
                  `reclamo`.`idreclamo`,
                  `reclamo`.`idmodulo_reclamo`,
                  `reclamo`.`idusu_c`,
                  `reclamo`.`idmodulo_c`,
                  `reclamo`.`idreclamo_previo`,
                  `reclamo`.`idmodulo_reclamo_previo`,
                  `reclamo`.`idreclamo_estado`,
                  `reclamo`.`idfase`,
                  `reclamo`.`fecha_fase`,
                  `reclamo_estado`.`estado`,
                  `reclamo_estado`.`tipo` as tipo_estado,
                  `reclamo_tipo`.`tipo`,
                      (select count(*) from reclamo_archivo
                       where reclamo_archivo.activo=1
                       AND reclamo_archivo.idreclamo=reclamo.idreclamo
                       AND reclamo_archivo.idmodulo_reclamo=reclamo.idmodulo_reclamo
                      ) as archivos,
                                                
                      (select count(distinct reclamo_sh2.idreclamo, reclamo_sh2.idmodulo_reclamo) 
                       from predio_gis_item as predio_gis_item2
                       left join predio_sh as predio_sh2 
                       on predio_gis_item2.idpredio=predio_sh2.idpredio
                       left join reclamo_sh as reclamo_sh2
                       on predio_sh2.idsh=reclamo_sh2.idsh
                       and predio_sh2.idmodulo=reclamo_sh2.idmodulo
                       where predio_gis_item.idgis_item=predio_gis_item2.idgis_item
                       
                      ) as reclamos, 
                  `fase`.`dias_max`,
                  reclamo_sh.activo,
                  `reclamo_rc`.`idrol`,
                  `reclamo_rc`.`activo` as reclamo_rc_activo,                 
                 `evaluacion`.`evaluacion`,
                `evaluacion`.`activo` as evaluacion_activo,
                `evaluacion`.`idevaluacion`,
                `evaluacion`.`idmodulo_evaluacion`,
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
              `propuesta`.`activo` as propuesta_activo,
              `propuesta`.`idpropuesta`,
              `propuesta`.`idmodulo_propuesta`,
              `propuesta`.`propuesta`,
              `propuesta`.`comentario_realizado`,
              DATE_FORMAT(propuesta.fecha,'%d/%m/%Y') as propuesta_fecha,
              `apelacion`.`activo` as apelacion_activo,
              `apelacion`.`idapelacion`,
              `apelacion`.`idmodulo_apelacion`,
              `apelacion`.`apelacion`,
              DATE_FORMAT(apelacion.fecha,'%d/%m/%Y') as apelacion_fecha,
              ( dias_max - DATEDIFF(now(),fecha_fase) ) as plazo,
              `predio_gis_item`.`idgis_item`
              $creclamo_tag
              $creclamo_sh
              $creclamo_rc1
              $creclamo_rc2
              $cplazo
                FROM
                  `reclamo`
                  LEFT OUTER JOIN `reclamo_tipo` ON `reclamo`.idreclamo_tipo = `reclamo_tipo`.idreclamo_tipo
                  LEFT OUTER JOIN `reclamo_estado` ON (`reclamo_estado`.`idreclamo_estado` = `reclamo`.`idreclamo_estado`)
                  LEFT OUTER JOIN `fase` ON (`fase`.`idfase` = `reclamo`.`idfase`)
                  LEFT OUTER JOIN `reclamo_sh` ON (`reclamo_sh`.`idreclamo` = `reclamo`.`idreclamo`)
                  AND (`reclamo_sh`.`idmodulo_reclamo` = `reclamo`.`idmodulo_reclamo`)
                  LEFT OUTER JOIN `sh` ON (`sh`.`idsh` = `reclamo_sh`.`idsh`)
                  AND (`sh`.`idmodulo` = `reclamo_sh`.`idmodulo`)
                  LEFT OUTER JOIN `persona` ON (`persona`.`idpersona` = `sh`.`idsh`)
                  AND (`persona`.`idmodulo` = `sh`.`idmodulo`)
                  LEFT OUTER JOIN `evaluacion` ON (`reclamo`.`idreclamo` = `evaluacion`.`idreclamo`)
                  AND (`reclamo`.`idmodulo_reclamo` = `evaluacion`.`idmodulo_reclamo`)
                  LEFT OUTER JOIN `reclamo_rc` ON (`reclamo`.`idreclamo` = `reclamo_rc`.`idreclamo`)
                  AND (`reclamo`.`idmodulo_reclamo` = `reclamo_rc`.`idmodulo_reclamo`)
                  LEFT OUTER JOIN `rc` ON (`reclamo_rc`.`idrc` = `rc`.`idrc`)
                  AND (`reclamo_rc`.`idmodulo` = `rc`.`idmodulo`)
                  LEFT OUTER JOIN `persona` `persona1` ON (`rc`.`idrc` = `persona1`.`idpersona`)
                  AND (`rc`.`idmodulo` = `persona1`.`idmodulo`)
                  LEFT OUTER JOIN `propuesta` ON (`evaluacion`.`idevaluacion` = `propuesta`.`idevaluacion`)
                  AND (`evaluacion`.`idmodulo_evaluacion` = `propuesta`.`idmodulo_evaluacion`)
                  LEFT OUTER JOIN `apelacion` ON (`evaluacion`.`idevaluacion` = `apelacion`.`idevaluacion`)
                  AND (`evaluacion`.`idmodulo_evaluacion` = `apelacion`.`idmodulo_evaluacion`)
                  LEFT OUTER JOIN `predio_sh` ON (`reclamo_sh`.`idsh` = `predio_sh`.`idsh`)
                  AND (`reclamo_sh`.`idmodulo` = `predio_sh`.`idmodulo`)
                  LEFT OUTER JOIN `predio_gis_item` ON (`predio_sh`.`idpredio` = `predio_gis_item`.`idpredio`)
               WHERE
                `persona`.`activo`= 1 AND
                 $cidentidad
                 reclamo.activo= 1 AND
                 reclamo_sh.activo= 1 
                 $cidreclamo_tipo
                 $cidreclamo_fase
                 $cidreclamo_estado
                 $cfecha
                 $cid
                 
               ORDER BY
                 reclamo.fecha DESC,
                `reclamo`.`idreclamo` DESC,
                `reclamo`.`idmodulo_reclamo` DESC,
                `evaluacion`.`fecha_c` ASC
                ";

        //echo "<br/>$consulta";
        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {

            $areclamo['idmodulo_reclamo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idmodulo_reclamo];

            $areclamo['idreclamo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idreclamo];
            
            $areclamo['idmodulo_c'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idmodulo_c];

            $areclamo['idusu_c'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idusu_c];
            
            $areclamo['idmodulo_reclamo_previo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idmodulo_reclamo_previo];

            $areclamo['idreclamo_previo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idreclamo_previo];

            $areclamo['reclamo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[reclamo];
            
            $areclamo['archivos'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[archivos];
            
            $areclamo['estado'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[estado];
            
            $areclamo['idfase'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[idfase];
            
            $areclamo['fecha_fase'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[fecha_fase];
            
            $areclamo['dias_max'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[dias_max];
            
            $areclamo['plazo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[plazo];
            
            $areclamo['tipo'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[tipo];
            
            $areclamo['tipo_estado'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[tipo_estado];

            $areclamo['fecha'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]] = $fila[fecha];
            
            if($fila[reclamo_rc_activo]==1)
                $areclamo['rc'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[rc_idpersona] . "-" . $fila[rc_idmodulo] ."-" .$fila[idrol]] = $fila[rc_apellido_p] . " " . $fila[rc_apellido_m] . " " . $fila[rc_nombre]. "---".$fila[idrol];

            $areclamo['sh'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[sh_idpersona] . "-" . $fila[sh_idmodulo]] = $fila[sh_idpersona].'---'.$fila[sh_idmodulo].'---'.$fila[sh_apellido_p] . " " . $fila[sh_apellido_m] . " " . $fila[sh_nombre].'---'.$fila[sh_idpersona_tipo].'---'.$fila[imagen];
            
            //echo "sh_idpersona_tipo: $fila[sh_idpersona_tipo]";

            if ($fila[idevaluacion] != "" && $fila[evaluacion_activo] != 0 ) {
                $areclamo['idevaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = $fila[idevaluacion];
                $areclamo['idmodulo_evaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = $fila[idmodulo_evaluacion];
                $areclamo['evaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = $fila[evaluacion];
                $areclamo['fecha_evaluacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]] = "";
            }
            
            if ($fila[idpropuesta] != "" && $fila[propuesta_activo] != 0 ) {
                $areclamo['idpropuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[idpropuesta];
                $areclamo['idmodulo_propuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[idmodulo_propuesta];
                $areclamo['propuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[propuesta];
                $areclamo['comentario_realizado'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[comentario_realizado];
                $areclamo['fecha_propuesta'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idpropuesta] . "-" . $fila[idmodulo_propuesta]] = $fila[propuesta_fecha];
            }
            
             if ($fila[idapelacion] != "" && $fila[apelacion_activo] != 0 ) {
                $areclamo['idapelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[idapelacion];
                $areclamo['idmodulo_apelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[idmodulo_apelacion];
                $areclamo['apelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[apelacion];
                $areclamo['fecha_apelacion'][$fila[idreclamo] . "-" . $fila[idmodulo_reclamo]][$fila[idevaluacion] . "-" . $fila[idmodulo_evaluacion]][$fila[idapelacion] . "-" . $fila[idmodulo_apelacion]] = $fila[apelacion_fecha];
            }
            
            if(isset($fila[idgis_item])){
                $areclamo['idgis_item'][$fila[idgis_item]]=$fila[reclamos];
            }
        }
        return $areclamo;
    }
   
}

?>
