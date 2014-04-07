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
class iestado_civil {

    //put your code here
    public $sql;

    function iestado_civil() {
        $this->sql = new DmpSql();
    }

    function lista_estado_civil() {

        $consulta = "SELECT
                      `persona_estado_civil`.`idpersona_estado_civil`,
                      `persona_estado_civil`.`descripcion`,
                      `persona_estado_civil`.`activo`
                    FROM
                      `persona_estado_civil`
                 WHERE
                   `persona_estado_civil`.`activo`=1";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

}

?>
