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
class imigracion {

    //put your code here
    public $sql;

    function imigracion() {
        $this->sql = new DmpSql();
    }

    function lista_migracion_pendiente(){
        $consulta = "
                  SELECT

                  *
                    FROM
                      `migracion_detalle`
                    WHERE
                      idmigracion is NULL";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }


    function lista_detalle_migracion($idmigracion,$idmodulo){
        $consulta = "
                  SELECT

                  *
                    FROM
                      `migracion_detalle`
                    WHERE
                      idmigracion=$idmigracion
                    AND idmodulo_migracion=$idmodulo";
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function lista_migracion_modulo($idmodulo){
        $consulta = "
                  SELECT
                    migracion.idmigracion, migracion.idmodulo_migracion,
                    migracion.archivo_cliente, migracion.archivo_servidor,
                    (SELECT COUNT(*) from modulo_migracion
                    WHERE `modulo_migracion`.`idmigracion`=`migracion`.`idmigracion`
                    AND  `modulo_migracion`.`idmodulo_migracion`=`migracion`.`idmodulo_migracion`
                    AND  `modulo_migracion`.`idmodulo`=$idmodulo
                    ) as cantidad
                    from migracion
                    WHERE  resultado = 1
                    HAVING cantidad=0";

        $result = $this->sql->consultar($consulta, "sgrc");

          return $result;

    }

    function verifica_migracion(){
       $consulta = "
                  SELECT
                  *
                    FROM
                      `modulo`
                    WHERE
                      running>0
                      AND idmodulo = ".$_SESSION[idmodulo];

       $result = $this->sql->consultar($consulta, "sgrc");

       return $result;

    }

    function lista_migracion(){
        $consulta = "SELECT * from migracion WHERE migrando=1";
        $result = $this->sql->consultar($consulta, "sgrc");

       return $result;
    }

    function lista_migracion_archivo($idmigracion,$idmodulo){
        $consulta = "
                  SELECT

                  *
                    FROM
                      `migracion_archivo`
                    WHERE
                      idmigracion=$idmigracion
                    AND idmodulo_migracion=$idmodulo";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }


}

?>
