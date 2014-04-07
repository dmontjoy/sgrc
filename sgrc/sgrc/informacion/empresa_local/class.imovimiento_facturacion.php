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
class imovimiento_facturacion {

    //put your code here
    public $sql;

    function imovimiento_facturacion() {
        $this->sql = new DmpSql();
    }
    function get_movimiento_facturacion($idempresa,$idmodulo,$idperiodo=""){
        $consulta = "SELECT
                        `movimiento`.`monto`,
                        `movimiento`.`idperiodo`,
                        `movimiento`.`idperiodo_sub`,
                        `movimiento`.`idsh`,
                        `movimiento`.`activo`,
                        `movimiento`.`idmodulo`,
                        `movimiento`.`idmodulo_movimiento`,
                        `movimiento`.`idmovimiento`,
                         `periodo`.`descripcion`,
                        `periodo_sub`.`descripcion` AS periodo_sub
                      FROM
                        `periodo`
                        LEFT OUTER JOIN `movimiento` ON (`periodo`.`idperiodo` = `movimiento`.`idperiodo`)
                        LEFT OUTER JOIN `periodo_sub` ON (`movimiento`.`idperiodo_sub` = `periodo_sub`.`idperiodo_sub`)
                      WHERE
                        movimiento.idsh=$idempresa AND
                        movimiento.idmodulo=$idmodulo AND
                        movimiento.activo=1 ";
        if($idperiodo!=""){
            $consulta.=" AND movimiento.idperiodo=$idperiodo";
        }
        $consulta.=" ORDER BY movimiento.idperiodo DESC, movimiento.idperiodo_sub ASC";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        while($fila=mysql_fetch_array($result)){

          #  $hogar[idcompuesto][$fila[idperiodo]][$fila[idperiodo_sub]]=$fila[idmovimiento].'---'.$fila[idmodulo_movimiento];
          #  $hogar[periodo_sub][$fila[idperiodo]][$fila[idperiodo_sub]][$fila[idmovimiento].'---'.$fila[idmodulo_movimiento]]=$fila[periodo_sub];

            $hogar[periodo][$fila[idperiodo]]=$fila[descripcion];
            $hogar[monto][$fila[idmovimiento].'---'.$fila[idmodulo_movimiento]]=$fila[monto];
            $hogar[idperiodo_sub][$fila[idmovimiento].'---'.$fila[idmodulo_movimiento]]=$fila[idperiodo_sub];
            $hogar[periodo_sub][$fila[idperiodo]][$fila[idmovimiento].'---'.$fila[idmodulo_movimiento]]=$fila[periodo_sub];


        }

        return $hogar;


    }

}

?>
