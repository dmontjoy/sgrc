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
class irc {

    //put your code here
    public $sql;

    function irc() {
        $this->sql = new DmpSql();
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
                      INNER JOIN rc ON (persona.idpersona = rc.idrc)
                      AND (persona.idmodulo = rc.idmodulo)
                      WHERE
                   `persona`.`activo`=1 AND rc.activo=1 AND (persona.apellido_p like '$busca%' OR persona.nombre like '$busca%') $limit";

        //echo $consulta . "<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

}

?>
