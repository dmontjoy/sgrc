<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class iperiodo {

    //put your code here
    public $sql;

    function iperiodo() {
        $this->sql = new DmpSql();
    }

    function get_periodo_total($idempresa, $idmodulo) {
        $consulta = "SELECT
                    `periodo`.`idperiodo`,
                    `periodo`.`descripcion`,
                   round( sum(movimiento.monto),2) as total
                  FROM
                    `periodo`
                    INNER JOIN `movimiento` ON (`periodo`.`idperiodo` = `movimiento`.`idperiodo`)
                  WHERE
                    movimiento.idsh=$idempresa AND
                    movimiento.idmodulo=$idmodulo AND
                    periodo.`activo` = 1 AND
                    movimiento.activo =1
                  group  by
                    periodo.idperiodo
                 ";
        // echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");
        return $result;
    }

    function get_periodo() {
        $consulta = "SELECT idperiodo,descripcion,activo FROM periodo WHERE activo=1 ";
        $result = $this->sql->consultar($consulta, "sgrc");
        return $result;
    }

}

?>
