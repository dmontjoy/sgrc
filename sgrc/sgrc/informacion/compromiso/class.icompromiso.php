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
class icompromiso {

    //put your code here
    public $sql;

    function icompromiso() {
        $this->sql = new DmpSql();
    }

    function get_compromiso($idcompromiso, $idmodulo_compromiso) {

        $consulta_compromiso = "SELECT
                              `compromiso`.`compromiso`,
                              DATE_FORMAT(`compromiso`.`fecha`,'%d/%m/%Y') AS fecha,
                              DATE_FORMAT(`compromiso`.`fecha`,'%H') AS hora,
                              DATE_FORMAT(`compromiso`.`fecha`,'%i') AS minuto,
                              DATE_FORMAT(`compromiso`.`fecha_fin`,'%d/%m/%Y') AS fecha_fin,
                              DATE_FORMAT(`compromiso`.`fecha_fin`,'%H') AS hora_fin,
                              DATE_FORMAT(`compromiso`.`fecha_fin`,'%i') AS minuto_fin,
                              `compromiso`.`activo`,
                              `persona1`.`idpersona`,
                              `persona1`.`idmodulo`,
                              `persona1`.`apellido_p` as sh_apellido_p,
                              `persona1`.`apellido_m` as sh_apellido_m,
                              `persona1`.`nombre` as sh_nombre,
                              `persona`.`idpersona`,
                              `persona`.`idmodulo`,
                              `persona`.`apellido_p` as rc_apellido_p,
                              `persona`.`apellido_m` as rc_apellido_m,
                              `persona`.`nombre` as rc_nombre,
                              `persona`.`activo`,
                              `persona1`.`activo`,
                              `compromiso`.`idcompromiso`,
                              `compromiso`.`idmodulo_compromiso`,
                              `compromiso`.`idinteraccion`,
                              `compromiso`.`idmodulo_interaccion`,
                              `compromiso_rc`.`idrc`,                              
                              `compromiso_rc`.`idmodulo` AS rc_idmodulo,
                              `compromiso_sh`.`idmodulo` AS sh_idmodulo,
                              `compromiso_sh`.`idsh`,                              
                              `compromiso`.`idcompromiso_prioridad`,
                              `compromiso`.`idcompromiso_estado`,
                              `compromiso`.`comentario`,
                               compromiso_rc.idcompromiso_rc,
                               `compromiso_rc`.`idmodulo_compromiso_rc`,
                               `compromiso_sh`.idcompromiso_sh,
                               `compromiso_sh`.`idmodulo_compromiso_sh`,
                               interaccion.interaccion,
                               interaccion.fecha as 'fecha_interaccion',
                               `compromiso_prioridad`.`compromiso_prioridad` as prioridad,
                               `compromiso_estado`.`compromiso_estado` as estado
                            FROM
                              `compromiso`
                              INNER JOIN `compromiso_prioridad` ON (`compromiso`.`idcompromiso_prioridad` = `compromiso_prioridad`.`idcompromiso_prioridad`)
                              INNER JOIN  `compromiso_estado`    ON  `compromiso`.`idcompromiso_estado`= `compromiso_estado`.`idcompromiso_estado`
                              INNER JOIN `compromiso_rc` ON (`compromiso`.`idmodulo_compromiso` = `compromiso_rc`.`idmodulo_compromiso`)
                              AND (`compromiso`.`idcompromiso` = `compromiso_rc`.`idcompromiso`)
                              INNER JOIN `compromiso_sh` ON (`compromiso`.`idcompromiso` = `compromiso_sh`.`idcompromiso`)
                              AND (`compromiso`.`idmodulo_compromiso` = `compromiso_sh`.`idmodulo_compromiso`)
                              INNER JOIN `persona` ON (`compromiso_rc`.`idrc` = `persona`.`idpersona`)
                              AND (`compromiso_rc`.`idmodulo` = `persona`.`idmodulo`)
                              INNER JOIN `persona` `persona1` ON (`compromiso_sh`.`idsh` = `persona1`.`idpersona`)
                              AND (`compromiso_sh`.`idmodulo` = `persona1`.`idmodulo`)
                              INNER JOIN `interaccion` ON (`compromiso`.`idinteraccion` = `interaccion`.`idinteraccion`)
                              AND (`compromiso`.`idmodulo_interaccion` = `interaccion`.`idmodulo_interaccion`)
                             WHERE
                              `compromiso`.`idcompromiso`= $idcompromiso AND
                              `compromiso`.`idmodulo_compromiso` = $idmodulo_compromiso  AND 
                              `compromiso_rc`.`activo`=1 AND 
                              `compromiso_sh`.`activo`=1";

        //echo $consulta_compromiso;
        $result = $this->sql->consultar($consulta_compromiso, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {

            $acompromiso['idmodulo_compromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idmodulo_compromiso];

            $acompromiso['idinteraccion'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idinteraccion];
            
            $acompromiso['idmodulo_interaccion'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idmodulo_interaccion];

            $acompromiso['idcompromiso_prioridad'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso_prioridad];
            
            $acompromiso['prioridad'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[prioridad];
            
            $acompromiso['estado'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[estado];

            $acompromiso['idcompromiso_estado'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso_estado];

            $acompromiso['compromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = utf8_encode($fila[compromiso]);

            $acompromiso['fecha'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[fecha];
            
            $acompromiso['hora'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[hora];
            
            $acompromiso['minuto'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[minuto];
            
            $acompromiso['fecha_fin'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[fecha_fin];
            
            $acompromiso['hora_fin'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[hora_fin];
            
            $acompromiso['minuto_fin'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[minuto_fin];

            $acompromiso['comentario'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = utf8_encode($fila[comentario]);

            $acompromiso['rc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[rc_apellido_p] . " " . $fila[rc_apellido_m] . " " . $fila[rc_nombre];

            $acompromiso['idrc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[idrc];

            $acompromiso['rc_idmodulo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[rc_idmodulo];

            $acompromiso['sh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = utf8_encode($fila[sh_apellido_p] . " " . $fila[sh_apellido_m] . " " . $fila[sh_nombre]);

            $acompromiso['idsh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[idsh];

            $acompromiso['sh_idmodulo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[rc_idmodulo]] = $fila[sh_idmodulo];

            $acompromiso['idcompromiso_rc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[idcompromiso_rc];

            $acompromiso['idcompromiso_sh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[idcompromiso_sh];
            
            $acompromiso['idmodulo_compromiso_rc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[idmodulo_compromiso_rc];

            $acompromiso['idmodulo_compromiso_sh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[idmodulo_compromiso_sh];
            
            $acompromiso['interaccion'] = utf8_encode($fila[interaccion]);
            
            $acompromiso['fecha_interaccion'] = $fila[fecha_interaccion];
        }
        return $acompromiso;
    }

    function lista_item_compromiso($idcompromiso, $idmodulo_compromiso) {
         
        if($todos == 1){
            $c_todos = "";
        }else{
            $c_todos = "   AND compromiso.idcompromiso = $idcompromiso  AND compromiso.idmodulo_compromiso = $idmodulo_compromiso ";
        }
               
        if ($limite != "") {
            //$limite = "";
            $limite = " LIMIT $limite ";
        }

        $consulta_compromiso = "SELECT
                      `compromiso`.`compromiso`,
                      DATE_FORMAT(`compromiso`.`fecha`,'%d/%m/%Y') AS fecha,
                      DATE_FORMAT(`compromiso`.`fecha`,'%d/%m/%Y') AS fecha_fin,
                      `compromiso`.`activo`,
                      `persona1`.`idpersona`,
                      `persona1`.`idmodulo`,
                      `persona1`.`apellido_p` as sh_apellido_p,
                      `persona1`.`apellido_m` as sh_apellido_m,
                      `persona1`.`nombre` as sh_nombre,
                      `persona1`.`idpersona_tipo` as sh_idpersona_tipo,
                      `persona1`.`imagen` as sh_imagen,
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p` as rc_apellido_p,
                      `persona`.`apellido_m` as rc_apellido_m,
                      `persona`.`nombre` as rc_nombre,
                      `persona`.`activo`,
                      `persona1`.`activo`,
                      `compromiso`.`idcompromiso`,
                      `compromiso`.`idmodulo_compromiso`,
                      `compromiso`.`idusu_c`,
                      `compromiso`.`idmodulo_c`,
                      `compromiso_rc`.`idrc`,
                      `compromiso_rc`.`idmodulo` AS rc_idmodulo,
                      `compromiso_sh`.`idmodulo` AS sh_idmodulo,
                      `compromiso_sh`.`idsh`,
                      `compromiso`.`idcompromiso_prioridad`,
                      `compromiso`.`idcompromiso_estado`,
                      `compromiso`.`comentario`,
                       compromiso_rc.idcompromiso_rc,
                       compromiso_sh.idcompromiso_sh,
                       `compromiso_archivo`.idcompromiso_archivo,
                        `compromiso_archivo`.idmodulo_compromiso_archivo,
                        `compromiso_archivo`.archivo,
                        `compromiso_archivo`.activo as archivo_activo
                    FROM
                      `compromiso`
                      INNER JOIN `compromiso_rc` ON (`compromiso`.`idmodulo_compromiso` = `compromiso_rc`.`idmodulo_compromiso`)
                      AND (`compromiso`.`idcompromiso` = `compromiso_rc`.`idcompromiso`)
                      INNER JOIN `compromiso_sh` ON (`compromiso`.`idcompromiso` = `compromiso_sh`.`idcompromiso`)
                      AND (`compromiso`.`idmodulo_compromiso` = `compromiso_sh`.`idmodulo_compromiso`)
                      INNER JOIN `persona` ON (`compromiso_rc`.`idrc` = `persona`.`idpersona`)
                      AND (`compromiso_rc`.`idmodulo` = `persona`.`idmodulo`)
                      INNER JOIN `persona` `persona1` ON (`compromiso_sh`.`idsh` = `persona1`.`idpersona`)
                      AND (`compromiso_sh`.`idmodulo` = `persona1`.`idmodulo`)
                      LEFT OUTER JOIN `compromiso_archivo` ON (`compromiso_archivo`.`idcompromiso` = `compromiso`.`idcompromiso`)
                      AND (`compromiso_archivo`.`idmodulo_compromiso` = `compromiso`.`idmodulo_compromiso`)
                    WHERE
                        `compromiso`.`activo`= 1 AND `compromiso`.`idcompromiso_estado`= 1 $c_todos 
                    ORDER BY
                        compromiso.fecha DESC $limite";
        
        //echo $consulta_compromiso;

        $result = $this->sql->consultar($consulta_compromiso, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {
            $acompromiso['idcompromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso];

            $acompromiso['idmodulo_compromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idmodulo_compromiso];
            
            $acompromiso['idusu_c'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idusu_c];

            $acompromiso['idmodulo_c'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idmodulo_c];

            $acompromiso['idinteraccion'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idinteraccion];

            $acompromiso['idcompromiso_prioridad'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso_prioridad];

            $acompromiso['idcompromiso_estado'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso_estado];

            $acompromiso['compromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[compromiso];

            $acompromiso['fecha'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[fecha];
            
            $acompromiso['fecha_fin'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[fecha_fin];

            $acompromiso['comentario'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[comentario];

            $acompromiso['rc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[rc_apellido_p] . " " . $fila[rc_apellido_m] . " " . $fila[rc_nombre];

            $acompromiso['idrc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[idrc];

            $acompromiso['rc_idmodulo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[rc_idmodulo];

            $acompromiso['sh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[sh_apellido_p] . " " . $fila[sh_apellido_m] . " " . $fila[sh_nombre];

            $acompromiso['idsh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[idsh];

            $acompromiso['sh_idmodulo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[sh_idmodulo];
            
            $acompromiso['sh_idpersona_tipo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[sh_idpersona_tipo];
            
            $acompromiso['sh_imagen'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[sh_imagen];

            $acompromiso['idcompromiso_rc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[idcompromiso_rc];

            $acompromiso['idcompromiso_sh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[idcompromiso_sh];
            
            if ($fila[archivo] != "" && $fila[archivo_activo] != 0 ) {
                $acompromiso['archivo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idcompromiso_archivo] . "-" . $fila[idmodulo_compromiso_archivo]] = $fila[archivo];                
            }
            
        }
        return $acompromiso;
    }

    function lista_compromiso($idpersona,$idmodulo, $limite = "", $todos) {
        //lista todos los compromisos por estado, devuelve un array
        
        if($todos == 1){
            $c_todos = "";
        }else{
            $c_todos = "   AND compromiso_rc.idrc = $idpersona  AND compromiso_rc.idmodulo = $idmodulo ";
        }
               
        if ($limite != "") {
            //$limite = "";
            $limite = " LIMIT $limite ";
        }

        $consulta_compromiso = "SELECT
                      count(distinct `compromiso`.idcompromiso, `compromiso`.idmodulo_compromiso) as total
                    FROM
                      `compromiso`
                      INNER JOIN `compromiso_rc` ON (`compromiso`.`idmodulo_compromiso` = `compromiso_rc`.`idmodulo_compromiso`)
                      AND (`compromiso`.`idcompromiso` = `compromiso_rc`.`idcompromiso`)
                      INNER JOIN `compromiso_sh` ON (`compromiso`.`idcompromiso` = `compromiso_sh`.`idcompromiso`)
                      AND (`compromiso`.`idmodulo_compromiso` = `compromiso_sh`.`idmodulo_compromiso`)
                      INNER JOIN `persona` ON (`compromiso_rc`.`idrc` = `persona`.`idpersona`)
                      AND (`compromiso_rc`.`idmodulo` = `persona`.`idmodulo`)
                      INNER JOIN `persona` `persona1` ON (`compromiso_sh`.`idsh` = `persona1`.`idpersona`)
                      AND (`compromiso_sh`.`idmodulo` = `persona1`.`idmodulo`)
                      LEFT OUTER JOIN `compromiso_archivo` ON (`compromiso_archivo`.`idcompromiso` = `compromiso`.`idcompromiso`)
                      AND (`compromiso_archivo`.`idmodulo_compromiso` = `compromiso`.`idmodulo_compromiso`)
                    WHERE
                        `compromiso`.`activo`= 1 AND `compromiso`.`idcompromiso_estado`= 1 $c_todos";
        
        //echo $consulta_compromiso;

        $result = $this->sql->consultar($consulta_compromiso, "sgrc");
        
        $fila = mysql_fetch_array($result);
        
        $acompromiso['total'] = $fila[total];
        
        
        $consulta_compromiso = "SELECT
                      `compromiso`.`compromiso`,
                      DATE_FORMAT(`compromiso`.`fecha`,'%d/%m/%Y') AS fecha,
                      DATE_FORMAT(`compromiso`.`fecha`,'%d/%m/%Y') AS fecha_fin,
                      `compromiso`.`activo`,
                      `persona1`.`idpersona`,
                      `persona1`.`idmodulo`,
                      `persona1`.`apellido_p` as sh_apellido_p,
                      `persona1`.`apellido_m` as sh_apellido_m,
                      `persona1`.`nombre` as sh_nombre,
                      `persona1`.`idpersona_tipo` as sh_idpersona_tipo,
                      `persona1`.`imagen` as sh_imagen,
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p` as rc_apellido_p,
                      `persona`.`apellido_m` as rc_apellido_m,
                      `persona`.`nombre` as rc_nombre,
                      `persona`.`activo`,
                      `persona1`.`activo`,
                      `compromiso`.`idcompromiso`,
                      `compromiso`.`idmodulo_compromiso`,
                      `compromiso`.`idusu_c`,
                      `compromiso`.`idmodulo_c`,
                      `compromiso_rc`.`idrc`,
                      `compromiso_rc`.`idmodulo` AS rc_idmodulo,
                      `compromiso_sh`.`idmodulo` AS sh_idmodulo,
                      `compromiso_sh`.`idsh`,
                      `compromiso`.`idcompromiso_prioridad`,
                      `compromiso`.`idcompromiso_estado`,
                      `compromiso`.`comentario`,
                       compromiso_rc.idcompromiso_rc,
                       compromiso_sh.idcompromiso_sh,
                       `compromiso_archivo`.idcompromiso_archivo,
                        `compromiso_archivo`.idmodulo_compromiso_archivo,
                        `compromiso_archivo`.archivo,
                        `compromiso_archivo`.activo as archivo_activo
                    FROM
                      `compromiso`
                      INNER JOIN `compromiso_rc` ON (`compromiso`.`idmodulo_compromiso` = `compromiso_rc`.`idmodulo_compromiso`)
                      AND (`compromiso`.`idcompromiso` = `compromiso_rc`.`idcompromiso`)
                      INNER JOIN `compromiso_sh` ON (`compromiso`.`idcompromiso` = `compromiso_sh`.`idcompromiso`)
                      AND (`compromiso`.`idmodulo_compromiso` = `compromiso_sh`.`idmodulo_compromiso`)
                      INNER JOIN `persona` ON (`compromiso_rc`.`idrc` = `persona`.`idpersona`)
                      AND (`compromiso_rc`.`idmodulo` = `persona`.`idmodulo`)
                      INNER JOIN `persona` `persona1` ON (`compromiso_sh`.`idsh` = `persona1`.`idpersona`)
                      AND (`compromiso_sh`.`idmodulo` = `persona1`.`idmodulo`)
                      LEFT OUTER JOIN `compromiso_archivo` ON (`compromiso_archivo`.`idcompromiso` = `compromiso`.`idcompromiso`)
                      AND (`compromiso_archivo`.`idmodulo_compromiso` = `compromiso`.`idmodulo_compromiso`)
                    WHERE
                        `compromiso`.`activo`= 1 AND `compromiso`.`idcompromiso_estado`= 1 $c_todos 
                    ORDER BY
                        compromiso.fecha DESC $limite";
        
        //echo $consulta_compromiso;

        $result = $this->sql->consultar($consulta_compromiso, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {
            $acompromiso['idcompromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso];

            $acompromiso['idmodulo_compromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idmodulo_compromiso];
            
            $acompromiso['idusu_c'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idusu_c];

            $acompromiso['idmodulo_c'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idmodulo_c];

            $acompromiso['idinteraccion'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idinteraccion];

            $acompromiso['idcompromiso_prioridad'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso_prioridad];

            $acompromiso['idcompromiso_estado'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso_estado];

            $acompromiso['compromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = utf8_encode($fila[compromiso]);

            $acompromiso['fecha'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[fecha];
            
            $acompromiso['fecha_fin'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[fecha_fin];

            $acompromiso['comentario'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[comentario];

            $acompromiso['rc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = utf8_encode($fila[rc_apellido_p] . " " . $fila[rc_apellido_m] . " " . $fila[rc_nombre]);

            $acompromiso['idrc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[idrc];

            $acompromiso['rc_idmodulo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[rc_idmodulo];

            $acompromiso['sh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = utf8_encode($fila[sh_apellido_p] . " " . $fila[sh_apellido_m] . " " . $fila[sh_nombre]);

            $acompromiso['idsh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[idsh];

            $acompromiso['sh_idmodulo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[sh_idmodulo];
            
            $acompromiso['sh_idpersona_tipo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[sh_idpersona_tipo];
            
            $acompromiso['sh_imagen'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[sh_imagen];

            $acompromiso['idcompromiso_rc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idrc] . "-" . $fila[rc_idmodulo]] = $fila[idcompromiso_rc];

            $acompromiso['idcompromiso_sh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idsh] . "-" . $fila[sh_idmodulo]] = $fila[idcompromiso_sh];
            
            if ($fila[archivo] != "" && $fila[archivo_activo] != 0 ) {
                $acompromiso['archivo'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[idcompromiso_archivo] . "-" . $fila[idmodulo_compromiso_archivo]] = $fila[archivo];                
            }
            
        }
        return $acompromiso;
    }
    
     function lista_archivo($idcompromiso,$idmodulo){
        
        $consulta="SELECT 
                      `compromiso_archivo`.`idcompromiso_archivo`,  
                      `compromiso_archivo`.`idmodulo_compromiso_archivo`,  
                      `compromiso_archivo`.`archivo`,
                      `compromiso_archivo`.`fecha_c`,
                      `compromiso_archivo`.`activo`
                      
                    FROM
                      `compromiso_archivo`
                      
                    WHERE
                    `compromiso_archivo`.`idcompromiso` = $idcompromiso AND
                    `compromiso_archivo`.`idmodulo_compromiso` = $idmodulo AND
                    `compromiso_archivo`.`activo` = 1 ";
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
     function lista($idcompromiso,$idmodulo_compromiso,$idcompromiso_estado,$idcompromiso_prioridad,$fecha_del,$fecha_al,$idinteraccion_complejo_rc,$idinteraccion_complejo_sh,$compromiso) {
         
        /*
        if( $idcompromiso!="" && $idmodulo_compromiso!="" ){
            $cidcompromiso ="AND `compromiso`.`idcompromiso`=$idcompromiso
                             AND `compromiso`.`idmodulo_compromiso`=$idmodulo_compromiso";
            
        }else{
            $cidcompromiso="";
        }
        */
         
        if( $idcompromiso!="" || $idmodulo_compromiso!="" ){
            $cidcompromiso ="AND CONCAT(`compromiso`.`idcompromiso`,'-',`compromiso`.`idmodulo_compromiso`) like '%$idcompromiso%-$idmodulo_compromiso%' ";            
        }else{
            $cidcompromiso="";
        }
         
        $cant = count($idcompromiso_estado);
                        
        if($cant>0){
            $cidcompromiso_estado=" AND `compromiso_estado`.`idcompromiso_estado` 
                            IN ( ";
            foreach ($idcompromiso_estado as $valor){
               
                    $cidcompromiso_estado.= "'".$valor."',";                    
                
            }
            $cidcompromiso_estado = substr($cidcompromiso_estado, 0, -1);
            
            $cidcompromiso_estado.= " ) "; 
                       
        }else{
            $cidcompromiso_estado="";
        }
        
        $cant = count($idcompromiso_prioridad);
                        
        if($cant>0){
            $cidcompromiso_prioridad=" AND `compromiso_prioridad`.`idcompromiso_prioridad` 
                            IN ( ";
            foreach ($idcompromiso_prioridad as $valor){
               
                    $cidcompromiso_prioridad.= "'".$valor."',";                    
                
            }
            $cidcompromiso_prioridad = substr($cidcompromiso_prioridad, 0, -1);
            
            $cidcompromiso_prioridad.= " ) "; 
                       
        }else{
            $cidcompromiso_prioridad="";
        }
        
        if($fecha_del!="" && $fecha_al!=""){
            $ayudante = new Ayudante();
            $fecha_del = $ayudante->FechaRevezMysql($fecha_del,"/");
            $fecha_al = $ayudante->FechaRevezMysql($fecha_al,"/");
            $cfecha=" AND `compromiso`.`fecha`>='$fecha_del' AND DATE_FORMAT(`compromiso`.`fecha`,'%Y-%m-%d')<='$fecha_al'";
        }else{
            $cfecha="";
        }
        
        $rcs = count($idinteraccion_complejo_rc);
        
        if($rcs>0){
            $ccompromiso_rc=" ,
                    (
                    SELECT COUNT(*)
                    FROM `compromiso_rc` 
                    WHERE (`compromiso`.`idcompromiso` = `compromiso_rc`.`idcompromiso`)
                    AND (`compromiso`.`idmodulo_compromiso` = `compromiso_rc`.`idmodulo_compromiso`)
                    AND CONCAT(`compromiso_rc`.`idrc`,'---',`compromiso_rc`.`idmodulo`) 
                    IN (  ";
            foreach ($idinteraccion_complejo_rc as $valor){
                if(strpos($valor, "###")){
                    $rcs--;
                }else{
                    $aux_valor = explode("---", $valor);
                    $ccompromiso_rc.= "'$aux_valor[0]---$aux_valor[1]',";  
                    
                }
            }
            $ccompromiso_rc = substr($ccompromiso_rc, 0, -1);
            
            $ccompromiso_rc.= " ) AND `compromiso_rc`.`activo`=1  ) as 'rcs'";
                            
            if($rcs==0){
                $ccompromiso_rc="";
            }
            
        }else{
            $ccompromiso_rc="";
        }
        
        $shs = count($idinteraccion_complejo_sh);
                        
        if($shs>0){
            $ccompromiso_sh=" ,
                    (
                    SELECT COUNT(*)
                    FROM `compromiso_sh` 
                    WHERE (`compromiso`.`idcompromiso` = `compromiso_sh`.`idcompromiso`)
                    AND (`compromiso`.`idmodulo_compromiso` = `compromiso_sh`.`idmodulo_compromiso`)
                    AND CONCAT(`compromiso_sh`.`idsh`,'---',`compromiso_sh`.`idmodulo`) 
                    IN (  ";
            foreach ($idinteraccion_complejo_sh as $valor){
                if(strpos($valor, "###")){
                    $shs--;
                }else{
                    $aux_valor = explode("---", $valor);
                    $ccompromiso_sh.= "'$aux_valor[0]---$aux_valor[1]',";  
                    
                }
            }
            $ccompromiso_sh = substr($ccompromiso_sh, 0, -1);
            
            $ccompromiso_sh.= " ) AND `compromiso_sh`.`activo`=1  ) as 'shs'";
                            
            if($shs==0){
                $ccompromiso_sh="";
            }
            
        }else{
            $ccompromiso_sh="";
        }
        
        if($compromiso!=""){
            $ccompromiso=" AND `compromiso`.`compromiso` LIKE '%$compromiso%' ";
        }
        
        
        $consulta_compromiso = "SELECT
                      `compromiso`.`compromiso`,
                      DATE_FORMAT(`compromiso`.`fecha`,'%d/%m/%Y') AS fecha,
                      `compromiso`.`activo`,                      
                      `compromiso`.`idcompromiso`,
                      `compromiso`.`idmodulo_compromiso`,
                      `compromiso`.`idusu_c`,
                      `compromiso`.`idmodulo_c`,
                      `compromiso_estado`.`compromiso_estado`,
                      `compromiso_prioridad`.`compromiso_prioridad`,
                      (select count(*) from compromiso_archivo
                       where compromiso_archivo.activo=1
                       AND compromiso_archivo.idcompromiso=compromiso.idcompromiso
                       AND compromiso_archivo.idmodulo_compromiso=compromiso.idmodulo_compromiso
                      ) as archivos,                             
                      (select count(distinct compromiso_sh2.idcompromiso, compromiso_sh2.idmodulo_compromiso) 
                       from predio_gis_item as predio_gis_item2
                       left join predio_sh as predio_sh2 
                       on predio_gis_item2.idpredio=predio_sh2.idpredio
                       left join compromiso_sh as compromiso_sh2
                       on predio_sh2.idsh=compromiso_sh2.idsh
                       and predio_sh2.idmodulo=compromiso_sh2.idmodulo
                       where predio_gis_item.idgis_item=predio_gis_item2.idgis_item
                       
                      ) as compromisos, 
                      `predio_gis_item`.`idgis_item`
                       $ccompromiso_rc
                       $ccompromiso_sh
                      FROM
                      `compromiso`
                      LEFT JOIN  `compromiso_estado`
                      ON  `compromiso`.`idcompromiso_estado`= `compromiso_estado`.`idcompromiso_estado`
                      LEFT JOIN  `compromiso_prioridad`
                      ON  `compromiso`.`idcompromiso_prioridad`= `compromiso_prioridad`.`idcompromiso_prioridad`
                      LEFT OUTER JOIN `compromiso_sh` ON (`compromiso_sh`.`idcompromiso` = `compromiso`.`idcompromiso`)
                    AND (`compromiso_sh`.`idmodulo_compromiso` = `compromiso`.`idmodulo_compromiso`)
                    LEFT OUTER JOIN `predio_sh` ON (`compromiso_sh`.`idsh` = `predio_sh`.`idsh`)
                    AND (`compromiso_sh`.`idmodulo` = `predio_sh`.`idmodulo`)
                    LEFT OUTER JOIN `predio_gis_item` ON (`predio_sh`.`idpredio` = `predio_gis_item`.`idpredio`)
                      
                    WHERE
                        `compromiso`.`activo`= 1 
                        $cidcompromiso $cidcompromiso_estado $cidcompromiso_prioridad $cfecha $ccompromiso
                    ";
        
        $total=$rcs+$shs;
        if($total>0){
            
            $consulta_compromiso.= "  HAVING 1=1 ";
            
            if($rcs>0) $consulta_compromiso.=" AND rcs>=$rcs "; 
            if($shs>0) $consulta_compromiso.=" AND shs>=$shs "; 
        }
        
        $consulta_compromiso.="ORDER BY
                        compromiso.fecha DESC ";
        
        //echo $consulta_compromiso;

        $result = $this->sql->consultar($consulta_compromiso, "sgrc");

       
        return $result;
    }
    
    function lista_compromiso_rc($idcompromiso,$idmodulo){
        
        $consulta="SELECT distinct
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      `persona`.`nombre`,
                      `persona`.`activo`,
                      `compromiso_rc`.`activo`,
                      `compromiso_rc`.`idmodulo_compromiso_rc`,
                      `compromiso_rc`.`idcompromiso_rc`
                    FROM
                      `compromiso_rc` 
                      INNER JOIN `rc` ON (`compromiso_rc`.`idrc`=`rc`.`idrc`)
                      AND (`compromiso_rc`.`idmodulo`=`rc`.`idmodulo`)
                      INNER JOIN `persona` ON (`compromiso_rc`.`idrc` = `persona`.`idpersona`)
                      AND (`compromiso_rc`.`idmodulo` = `persona`.`idmodulo`)
                    WHERE                    
                    `compromiso_rc`.`activo`= 1 AND
                    `rc`.`activo`= 1 AND
                    `persona`.`activo`= 1 AND 
                    `compromiso_rc`.`idcompromiso` = $idcompromiso AND
                    `compromiso_rc`.`idmodulo_compromiso` = $idmodulo";
       //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista_compromiso_sh($idcompromiso,$idmodulo){
        
        $consulta="SELECT distinct
                      `persona`.`idpersona`,
                      `persona`.`idmodulo`,
                      `persona`.`apellido_p`,
                      `persona`.`apellido_m`,
                      `persona`.`nombre`,
                      `persona`.`activo`,
                      `compromiso_sh`.`activo`,
                      `compromiso_sh`.`idmodulo_compromiso_sh`,
                      `compromiso_sh`.`idcompromiso_sh`
                    FROM
                      `compromiso_sh`
                      INNER JOIN `sh` ON (`compromiso_sh`.`idsh`=`sh`.`idsh`)
                      AND (`compromiso_sh`.`idmodulo`=`sh`.`idmodulo`)
                      INNER JOIN `persona` ON (`compromiso_sh`.`idsh` = `persona`.`idpersona`)
                      AND (`compromiso_sh`.`idmodulo` = `persona`.`idmodulo`)
                    WHERE                    
                    `compromiso_sh`.`activo`= 1 AND
                    `sh`.`activo`= 1 AND
                    `persona`.`activo`= 1 AND 
                    `compromiso_sh`.`idcompromiso` = $idcompromiso AND
                    `compromiso_sh`.`idmodulo_compromiso` = $idmodulo";
       //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    
    function   lista_interaccion_compromiso($idinteraccion, $idmodulo_interaccion) {
        //persona 1, item 0
        //lista stakeholder, pues puede ser una stakeholder como un rc
        // `sh`.`activo`= 1, lo que quitado pero podria ir
       
        //lista las interaccions con un stakeholder
        $consulta = "SELECT distinct
                  `compromiso`.`compromiso`,
                  `compromiso`.`activo`,
                  `sh`.`activo`,
                  `persona`.`activo`,
                  `persona`.`imagen`,                                  
                  compromiso_sh.activo,                 
                `compromiso`.`idcompromiso_prioridad`,
                `compromiso`.`idcompromiso_estado`,
                DATE_FORMAT(compromiso.fecha,'%d/%m/%Y') AS fecha_compromiso,
                DATE_FORMAT(compromiso.fecha_fin,'%d/%m/%Y') AS fecha_fin,
                `compromiso`.`activo` as compromiso_activo,
                `compromiso`.`idcompromiso`,
                `compromiso`.`idmodulo_compromiso`,
                `compromiso`.`idusu_c`,
                `compromiso`.`fecha_c`,
                compromiso_estado.compromiso_estado,
                compromiso_prioridad.compromiso_prioridad,
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
              `persona1`.`idmodulo` as rc_idmodulo
                FROM
                  `compromiso`
                  LEFT OUTER JOIN `compromiso_estado` ON (`compromiso_estado`.`idcompromiso_estado` = `compromiso`.`idcompromiso_estado`)
                  LEFT OUTER JOIN `compromiso_prioridad` ON (`compromiso_prioridad`.`idcompromiso_prioridad` = `compromiso`.`idcompromiso_prioridad`)
                  LEFT OUTER JOIN `compromiso_sh` ON (`compromiso_sh`.`idcompromiso` = `compromiso`.`idcompromiso`)
                  AND (`compromiso_sh`.`idmodulo_compromiso` = `compromiso`.`idmodulo_compromiso`)
                  LEFT OUTER JOIN `sh` ON (`sh`.`idsh` = `compromiso_sh`.`idsh`)
                  AND (`sh`.`idmodulo` = `compromiso_sh`.`idmodulo`)
                  LEFT OUTER JOIN `persona` ON (`persona`.`idpersona` = `sh`.`idsh`)
                  AND (`persona`.`idmodulo` = `sh`.`idmodulo`)                  
                  LEFT OUTER JOIN `compromiso_rc` ON (`compromiso`.`idcompromiso` = `compromiso_rc`.`idcompromiso`)
                  AND (`compromiso`.`idmodulo_compromiso` = `compromiso_rc`.`idmodulo_compromiso`)
                  LEFT OUTER JOIN `rc` ON (`compromiso_rc`.`idrc` = `rc`.`idrc`)
                  AND (`compromiso_rc`.`idmodulo` = `rc`.`idmodulo`)
                  LEFT OUTER JOIN `persona` `persona1` ON (`rc`.`idrc` = `persona1`.`idpersona`)
                  AND (`rc`.`idmodulo` = `persona1`.`idmodulo`)
               WHERE
                `persona`.`activo`= 1
                 AND compromiso.idinteraccion=$idinteraccion
                 AND compromiso.idmodulo_interaccion=$idmodulo_interaccion
                 AND compromiso.activo= 1
                 AND compromiso_sh.activo= 1 
                 AND compromiso_rc.activo= 1 
               ORDER BY
                 compromiso.fecha DESC";

        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        while (!!$fila = mysql_fetch_array($result)) {            

            $acompromiso['rc'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[rc_idpersona] . "-" . $fila[rc_idmodulo]] = $fila[rc_apellido_p] . " " . $fila[rc_apellido_m] . " " . $fila[rc_nombre];

            $acompromiso['sh'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]][$fila[sh_idpersona] . "-" . $fila[sh_idmodulo]] = $fila[sh_apellido_p] . " " . $fila[sh_apellido_m] . " " . $fila[sh_nombre];
            
            //echo "sh_idpersona_tipo: $fila[sh_idpersona_tipo]";
            
            $acompromiso['idcompromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idcompromiso];
            $acompromiso['idmodulo_compromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[idmodulo_compromiso];
            $acompromiso['compromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[compromiso];
            $acompromiso['fecha_compromiso'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[fecha_compromiso];
            $acompromiso['fecha_fin'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[fecha_fin];
            $acompromiso['compromiso_estado'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[compromiso_estado];
            $acompromiso['compromiso_prioridad'][$fila[idcompromiso] . "-" . $fila[idmodulo_compromiso]] = $fila[compromiso_prioridad];
            
        }
        return $acompromiso;
    }
    
    

}

?>
