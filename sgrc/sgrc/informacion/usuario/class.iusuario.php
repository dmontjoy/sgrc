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
class iusuario {

    //put your code here
    public $sql;

    function iusuario() {
        $this->sql = new DmpSql();
    }

    function lista_host() {

        $consulta = "SELECT
                      idmodulo,
                      host
                    FROM
                    modulo
                    ";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function lista_rol() {

        $consulta = "SELECT
                      idseguridad_rol,
                      nombre
                    FROM
                    seguridad_rol
                    ";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function lista_usuario($idpersona,$idmodulo){
        $consulta="
            SELECT `usuario`.`idusuario`,
            `usuario`.`idmodulo_usuario`,
            `usuario`.`idusu_c`,
            `usuario`.`idmodulo_c`,
            `usuario`.`usuario` FROM `usuario`
            JOIN `usuario_persona`
            ON `usuario`.`idusuario`=`usuario_persona`.`idusuario`
            AND usuario.`idmodulo_usuario` = `usuario_persona`.`idmodulo_usuario`
            WHERE `usuario_persona`.`idpersona` = $idpersona
            AND   `usuario_persona`.`idmodulo` = $idmodulo
            AND `usuario`.`activo` = 1";

        $result = $this->sql->consultar($consulta, "sgrc");

        return $result;
    }

    function lista($idusuario, $idmodulo){
       $consulta="SELECT
                    `usuario`.`usuario`,
                    `usuario_modulo`.`idmodulo`,
                    `usuario`.`idseguridad_rol`,
                    `usuario_modulo`.`activo`
                    FROM `usuario`
                    LEFT OUTER JOIN  `usuario_modulo`
                    ON `usuario`.`idusuario`=`usuario_modulo`.`idusuario`
                    AND `usuario`.`idmodulo_usuario`=`usuario_modulo`.`idmodulo_usuario`
                    WHERE
                    `usuario`.`idusuario`=$idusuario
                    AND `usuario`.`idmodulo_usuario`=$idmodulo";
       $result = $this->sql->consultar($consulta, "sgrc");

       //echo $consulta;

        return $result;
    }

    function lista_usuario_modulo($usuario, $password){

       $consulta="SELECT
                    `modulo`.`idmodulo`,
                    `modulo`.`configurado`,
                    usuario_persona.idpersona,
                    usuario_persona.idmodulo as idmodulo_persona,
                    persona.apellido_m,
                    persona.apellido_p,
                    persona.nombre
                    FROM `usuario`
                    LEFT JOIN  `usuario_modulo`
                    ON `usuario`.`idusuario`=`usuario_modulo`.`idusuario`
                    AND `usuario`.`idmodulo_usuario`=`usuario_modulo`.`idmodulo_usuario`
                    LEFT JOIN  `usuario_persona`
                    ON `usuario`.`idusuario`=`usuario_persona`.`idusuario`
                    AND `usuario`.`idmodulo_usuario`=`usuario_persona`.`idmodulo_usuario`
                    left join persona
                    ON `persona`.`idpersona`=`usuario_persona`.`idpersona`
                    AND `persona`.`idmodulo`=`usuario_persona`.`idmodulo`
                    LEFT JOIN  `modulo`
                    ON `usuario_modulo`.`idmodulo`=`modulo`.`idmodulo`
                    WHERE
                    `usuario`.`activo` = 1
                    AND `usuario_modulo`.`activo` = 1
                    AND `usuario`.`usuario` LIKE '$usuario'
                    AND `usuario`.`clave` LIKE MD5('$password')";

       $result = $this->sql->consultar($consulta, "sgrc");

       // echo $consulta;

        return $result;
    }

}

?>
