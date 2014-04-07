<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gpersona
 *
 * @author dmontjoy
 */
class grelacionista_comunitario {

    //put your code here
    function grelacionista_comunitario() {
        $this->sql = new DmpSql();
    }

    function eliminar($idpersona, $idmodulo) {
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $ayudante = new Ayudante();
        $error = 0;
         $fecha_a= date('Y-m-d H:i:s');

        $update = "UPDATE rc SET `fecha_a`='$fecha_a',activo=0 WHERE idrc=$idpersona AND idmodulo=$idmodulo";

        //echo $update;
        // exit;
        if (!$this->sql->consultar($update, "sgrc")) {

            $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($update);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        return $error;
    }

    function asignar($idpersona, $idmodulo) {
        $ayudante = new Ayudante();
        $error = 0;
        //la persona ya esta creada
        $c_validar = "SELECT
                        `rc`.`idrc`,
                        `rc`.`idmodulo`
                      FROM
                        `rc` WHERE idrc=$idpersona AND idmodulo=$idmodulo";
        //echo $c_validar;
        $result = $this->sql->consultar($c_validar, "sgrc");

        if (mysql_num_rows($result) == 0) {
            $consulta = "INSERT INTO
                            `rc`(
                            `activo`,
                            `idrc`,
                            `idmodulo`,
                            `idusu`,
                            `idmodulo_a`)
                          VALUES(
                            1,
                            $idpersona,
                            $idmodulo,
                            '$_SESSION[idusu]',
                            '$_SESSION[idmodulo_a]'
                          )";
            // exit;

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
             
        } else {
             $fecha_a= date('Y-m-d H:i:s');
            $consulta = "UPDATE `rc` SET `fecha_a`='$fecha_a',activo=1 WHERE idrc=$idpersona AND idmodulo=$idmodulo";

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
             $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        return $error;
    }

}

?>