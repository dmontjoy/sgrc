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
class ihogar {

    //put your code here
    public $sql;

    function ihogar() {
        $this->sql = new DmpSql();
    }
    function get_hogar($idsh_hogar,$idmodulo_sh_hogar){
        $consulta = "SELECT 
                `sh_hogar`.`idsh_hogar`,
                `sh_hogar`.`idmodulo_sh_hogar`,
                DATE_FORMAT(`sh_hogar`.`fecha`,'%d/%m/%Y') AS fecha_hogar,
                `sh_hogar`.`comentario`,
                `sh_hogar`.`activo`,
                `sh_hogar`.`idusu_c`,
                `sh_hogar`.`idmodulo_c`,
                `sh_hogar`.`idusu_a`,
                `sh_hogar`.`idmodulo_a`,
                `sh_hogar`.`fecha_a`,
                `sh_hogar`.`idsh` AS idsh_principal,
                `sh_hogar`.`idmodulo` AS idsh_modulo_principal,
                `sh_hogar`.`fecha_c`,
                `sh_hogar_sh`.`idsh_hogar_sh`,
                `sh_hogar_sh`.`idmodulo_sh_hogar_sh`,
                `sh_hogar_sh`.`idsh`,
                `sh_hogar_sh`.`idmodulo`,
                `sh_hogar_sh`.`activo`,
                `sh_hogar_sh`.`fecha_c`,
                `sh_hogar_sh`.`idusu_c`,
                `sh_hogar_sh`.`idmodulo_c`,
                `sh_hogar_sh`.`fecha_a`,
                `sh_hogar_sh`.`idusu_a`,
                `sh_hogar_sh`.`idmodulo_a`,
                `sh_hogar_sh`.`idsh_hogar`,
                `sh_hogar_sh`.`idmodulo_sh_hogar`,
                `persona`.`apellido_p`,
                `persona`.`apellido_m`,
                `persona`.`nombre`,
                `sh_hogar_sh`.`idpersona_parentesco`,
                `persona_parentesco`.`descripcion` AS parentesco,
                `persona_parentesco`.`activo`
              FROM
                `sh_hogar`
                INNER JOIN `sh_hogar_sh` ON (`sh_hogar`.`idsh_hogar` = `sh_hogar_sh`.`idsh_hogar`)
                AND (`sh_hogar`.`idmodulo_sh_hogar` = `sh_hogar_sh`.`idmodulo_sh_hogar`)
                INNER JOIN `sh` ON (`sh_hogar_sh`.`idsh` = `sh`.`idsh`)
                AND (`sh_hogar_sh`.`idmodulo` = `sh`.`idmodulo`)
                INNER JOIN `persona` ON (`sh`.`idsh` = `persona`.`idpersona`)
                AND (`sh`.`idmodulo` = `persona`.`idmodulo`)
                LEFT OUTER JOIN `persona_parentesco` ON (`sh_hogar_sh`.`idpersona_parentesco` = `persona_parentesco`.`idpersona_parentesco`)
              WHERE
                `sh_hogar`.`idsh_hogar`=$idsh_hogar AND
                `sh_hogar`.`idmodulo_sh_hogar`= $idmodulo_sh_hogar AND
                `sh_hogar`.`activo`=1 AND
                `sh_hogar_sh`.`activo`=1 AND
                 persona.activo=1 AND
                 sh.activo=1 AND
                 `persona_parentesco`.`activo`=1
                ";
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");
        
        while($fila=mysql_fetch_array($result)){
            $hogar[idsh]=$fila[idsh_principal];
            $hogar[idmodulo]=$fila[idsh_modulo_principal];
            $hogar[fecha_hogar][$fila[idsh_hogar].'---'.$fila[idmodulo_sh_hogar]]=$fila[fecha_hogar];
            $hogar[sh][$fila[idsh_hogar].'---'.$fila[idmodulo_sh_hogar]][$fila[idsh]."---".$fila[idmodulo]]=$fila[nombre]." ".$fila[apellido_p]." ".$fila[apellido_m];
            $hogar['parentesco'][$fila[idsh_hogar].'---'.$fila[idmodulo_sh_hogar]][$fila[idsh]."---".$fila[idmodulo]]=$fila[parentesco];
            $hogar['idpersona_parentesco'][$fila[idsh_hogar].'---'.$fila[idmodulo_sh_hogar]][$fila[idsh]."---".$fila[idmodulo]]=$fila[idpersona_parentesco];
            
        }
        
        return $hogar;       
        
        
    }
    function get_hogar_sh($idpersona,$idmodulo) {
        $subconsulta="SELECT 
                concat(`sh_hogar`.`idsh_hogar`,'---',`sh_hogar`.`idmodulo_sh_hogar`)
              FROM
                `sh_hogar`
                INNER JOIN `sh_hogar_sh` ON (`sh_hogar`.`idsh_hogar` = `sh_hogar_sh`.`idsh_hogar`)
                AND (`sh_hogar`.`idmodulo_sh_hogar` = `sh_hogar_sh`.`idmodulo_sh_hogar`)
                INNER JOIN `sh` ON (`sh_hogar_sh`.`idsh` = `sh`.`idsh`)
                AND (`sh_hogar_sh`.`idmodulo` = `sh`.`idmodulo`)
                INNER JOIN `persona` ON (`sh`.`idsh` = `persona`.`idpersona`)
                AND (`sh`.`idmodulo` = `persona`.`idmodulo`)
                LEFT OUTER JOIN `persona_parentesco` ON (`sh_hogar_sh`.`idpersona_parentesco` = `persona_parentesco`.`idpersona_parentesco`)
              WHERE
                `sh_hogar_sh`.`idsh`=$idpersona AND
                `sh_hogar_sh`.`idmodulo`= $idmodulo AND
                `sh_hogar`.`activo`=1 AND
                `sh_hogar_sh`.`activo`=1 AND
                 persona.activo=1 AND
                 sh.activo=1";
        
        //$result = $this->sql->consultar($consulta, "sgrc");
        
        //$fila_ini=mysql_fetch_array($result);
        
        $consulta = "SELECT 
                `sh_hogar`.`idsh_hogar`,
                `sh_hogar`.`idmodulo_sh_hogar`,
                DATE_FORMAT(`sh_hogar`.`fecha`,'%d/%m/%Y') AS fecha_hogar,
                `sh_hogar`.`comentario`,
                `sh_hogar`.`activo`,
                `sh_hogar`.`idusu_c`,
                `sh_hogar`.`idmodulo_c`,
                `sh_hogar`.`idusu_a`,
                `sh_hogar`.`idmodulo_a`,
                `sh_hogar`.`fecha_a`,
                `sh_hogar`.`idsh`,
                `sh_hogar`.`idmodulo`,
                `sh_hogar`.`fecha_c`,
                `sh_hogar_sh`.`idsh_hogar_sh`,
                `sh_hogar_sh`.`idmodulo_sh_hogar_sh`,
                `sh_hogar_sh`.`idsh`,
                `sh_hogar_sh`.`idmodulo`,
                `sh_hogar_sh`.`activo`,
                `sh_hogar_sh`.`fecha_c`,
                `sh_hogar_sh`.`idusu_c`,
                `sh_hogar_sh`.`idmodulo_c`,
                `sh_hogar_sh`.`fecha_a`,
                `sh_hogar_sh`.`idusu_a`,
                `sh_hogar_sh`.`idmodulo_a`,
                `sh_hogar_sh`.`idsh_hogar`,
                `sh_hogar_sh`.`idmodulo_sh_hogar`,
                `persona`.`apellido_p`,
                `persona`.`apellido_m`,
                `persona`.`nombre`,
                `sh_hogar_sh`.`idpersona_parentesco`,
                `persona_parentesco`.`descripcion` AS parentesco,
                `persona_parentesco`.`activo`
              FROM
                `sh_hogar`
                INNER JOIN `sh_hogar_sh` ON (`sh_hogar`.`idsh_hogar` = `sh_hogar_sh`.`idsh_hogar`)
                AND (`sh_hogar`.`idmodulo_sh_hogar` = `sh_hogar_sh`.`idmodulo_sh_hogar`)
                INNER JOIN `sh` ON (`sh_hogar_sh`.`idsh` = `sh`.`idsh`)
                AND (`sh_hogar_sh`.`idmodulo` = `sh`.`idmodulo`)
                INNER JOIN `persona` ON (`sh`.`idsh` = `persona`.`idpersona`)
                AND (`sh`.`idmodulo` = `persona`.`idmodulo`)
                LEFT OUTER JOIN `persona_parentesco` ON (`sh_hogar_sh`.`idpersona_parentesco` = `persona_parentesco`.`idpersona_parentesco`)
              WHERE
                concat(`sh_hogar`.`idsh_hogar`,'---',`sh_hogar`.`idmodulo_sh_hogar`) IN ($subconsulta) AND
                `sh_hogar`.`activo`=1 AND
                `sh_hogar_sh`.`activo`=1 AND
                 persona.activo=1 AND
                 sh.activo=1 
               ORDER BY
                  fecha_hogar DESC, sh_hogar.idsh_hogar DESC";
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");
        
        while($fila=mysql_fetch_array($result)){
       
            $hogar[fecha_hogar][$fila[idsh_hogar].'---'.$fila[idmodulo_sh_hogar]]=$fila[fecha_hogar];
            $hogar[sh][$fila[idsh_hogar].'---'.$fila[idmodulo_sh_hogar]][$fila[idsh]."---".$fila[idmodulo]]=$fila[nombre]." ".$fila[apellido_p]." ".$fila[apellido_m];
            $hogar['parentesco'][$fila[idsh_hogar].'---'.$fila[idmodulo_sh_hogar]][$fila[idsh]."---".$fila[idmodulo]]=$fila[parentesco];
            $hogar['idpersona_parentesco'][$fila[idsh_hogar].'---'.$fila[idmodulo_sh_hogar]][$fila[idsh]."---".$fila[idmodulo]]=$fila[idpersona_parentesco];
        }
        
        return $hogar;
    }

}

?>
