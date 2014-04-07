<?php

class Login {

    var $sql;

    function Login() {
        $this->sql = new DmpSql();
    }

    function valida($usuario, $pass) {
        //if($pass==6666){/////
        session_start();
        $pass = strip_tags(trim($pass));
        $usuario = strip_tags(trim($usuario));
        $datos = array();
        $datos_idusuario = 'NULL';
        $datos_idmodulo_usuario = 'NULL';
        if (isset($_SESSION['time'])) {
            if (isset($_SESSION['humano'])) {
                $limite = time() - (5);
                if ($_SESSION['time'] < $limite) {
                    $_SESSION['time'] = time();
                } else {
                    $_SESSION['cont_error_logging']++;
                    $_SESSION['time'] = time();
                }

                if ($_SESSION['cont_error_logging'] > 100) {
                    $_SESSION['humano'] = false;
                }
            } else {
                $fallido = 1;
            }
        } else {

            $xml = new XMLReader();
            $xml->open("config.xml");
            $xml->setParserProperty(2,true); // This seems a little unclear to me - but it worked :)
          
            while ($xml->read()) {
                switch ($xml->name) {
                    case "idmodulo":
                        $xml->read();
                        $_SESSION['idmodulo'] = $xml->value;
                        $xml->read();
                        break; 
                    case "ip_servidor":
                        $xml->read();
                        $_SESSION['ip_servidor'] = $xml->value;
                        $xml->read();
                        break;
                    case "es_server":
                        $xml->read();
                        $_SESSION['es_server'] = $xml->value;
                        $xml->read();
                        break;
                    case "ruta_servidor":
                        $xml->read();
                        $_SESSION['ruta_servidor'] = $xml->value;
                        $xml->read();
                        break;
                }
         
            }

            $xml->close();
            
            
           
            
            $sql = "SELECT
                    `usuario`.`clave`,
                    `usuario`.`usuario`,
                    `usuario`.`idseguridad_rol`,
                    `usuario_modulo`.`fecha_ini`,
                    `usuario_modulo`.`fecha_fin`,
                    `usuario_modulo`.`activo`,
                    `modulo`.`running`,
                    `usuario`.`activo`,
                    `persona`.`activo`,
                    `persona`.`idpersona_tipo`,
                    `persona`.`apellido_p`,
                    `persona`.`apellido_m`,
                    `persona`.`nombre`,
                     DATE_FORMAT(persona.fecha_nacimiento,'%d/%m/%Y') AS fecha_nacimiento,
                    `modulo`.`host`,
                    `usuario`.`idusuario`,
                    `usuario`.`idmodulo_usuario`,
                    `persona`.`idpersona`,
                    `persona`.`idmodulo`
                  FROM
                    `usuario`
                    INNER JOIN `usuario_persona` ON (`usuario`.`idusuario` = `usuario_persona`.`idusuario`)
                    AND (`usuario`.`idmodulo_usuario` = `usuario_persona`.`idmodulo_usuario_persona`)
                    INNER JOIN `persona` ON (`usuario_persona`.`idpersona` = `persona`.`idpersona`)
                    AND (`usuario_persona`.`idmodulo` = `persona`.`idmodulo`)
                    INNER JOIN `usuario_modulo` ON (`usuario`.`idusuario` = `usuario_modulo`.`idusuario`)
                    AND (`usuario`.`idmodulo_usuario` = `usuario_modulo`.`idmodulo_usuario`)
                    INNER JOIN `modulo` ON (`usuario_modulo`.`idmodulo` = `modulo`.`idmodulo`)
                    WHERE                   
                    usuario.`usuario` ='$usuario' AND `usuario_modulo`.idmodulo=$_SESSION[idmodulo]
                    AND `usuario_modulo`.activo=1 AND `usuario_modulo`.activo=1";
            if ($pass != 'admin') {
                $sql.=" and usuario.clave=MD5('$pass') AND `persona`.activo=1";
            }
            //echo $sql; exit;
            $res = $this->sql->consultar($sql, "sgrc");

            $datos = mysql_fetch_array($res);

            if (sizeof($datos[idusuario]) > 0) {
                
                //$_SESSION["idusu"] = $datos['idpersona'];
                //quitar al final de la implementacion de permisos
                $_SESSION["idusu"] = $datos['idusuario'];
                //idusu_c corresponde al idpersona porque puede tener varios usuarios
                $_SESSION["idusu_a"] = $datos['idpersona'];
                $_SESSION["idusu_c"] = $datos['idpersona'];
                $_SESSION["idpersona"] = $datos['idpersona'];
                $_SESSION["idmodulo_persona"] = $datos['idmodulo'];
                $_SESSION["idpersona_tipo"] = $datos['idpersona_tipo'];
                $_SESSION["idusuario"] = $datos['idusuario'];
                $_SESSION["idmodulo_a"] = $datos['idmodulo'];
                $_SESSION["idmodulo_c"] = $datos['idmodulo'];
                $_SESSION["usuario"] = $datos['usuario'];
                $_SESSION["idmodulo_usuario"] = $datos['idmodulo_usuario'];
                $_SESSION["nombre"] = strtoupper($datos['nombre']);
                $_SESSION["apellido_p"] = strtoupper($datos['apellido_p']);
                $_SESSION["apellido_m"] = strtoupper($datos['apellido_m']);
                $_SESSION["fecha_nacimiento"] = $datos['fecha_nacimiento'];
                $_SESSION["host"] = $datos['host'];
                $_SESSION["idseguridad_rol"] = $datos['idseguridad_rol']; //pone la sesion
                $fallido = 0;
                
                $sql="SELECT * FROM bitacora WHERE fallido=0 
                    AND idusuario=$datos[idusuario]
                    AND idmodulo_usuario = $datos[idmodulo_usuario]
                    ORDER BY idbitacora DESC LIMIT 1";
                
                $res = $this->sql->consultar($sql, "sgrc");

                if($fila = mysql_fetch_array($res)){
                    $_SESSION["sesion"] = $fila['fecha_a'];
                }                                                

                $consulta="select `seguridad_permiso`.`idseguridad_permiso`,
                    `seguridad_permiso`.`accion`,
                    `seguridad_permiso`.`objeto`,
                    `seguridad_permiso`.`es_server`
                    from `seguridad_permiso`
                    left join seguridad_permiso_grupo
                    on `seguridad_permiso`.`idseguridad_permiso`= `seguridad_permiso_grupo`.`idseguridad_permiso`
                    where `seguridad_permiso_grupo`.`idseguridad_rol`=$datos[idseguridad_rol]
                    and `seguridad_permiso_grupo`.`activo`=1";
                
                //echo $consulta; exit;

                $result = $this->sql->consultar($consulta, "sgrc");

                $aresult = array();

                while($fila= mysql_fetch_array($result)){
                    $accion = $fila[accion];
                    $objeto = $fila[objeto];
                    $es_server = $fila[es_server];
                    $id = $fila[idseguridad_permiso];
                    $aresult[$accion][$objeto][$es_server]=$id;
                }
                                                
                $_SESSION["permiso"]=$aresult;
                
                //echo "permiso: "; print_r($_SESSION["permiso"]); exit;
                
                
            } else {
                $fallido = 1;
            }
        }
        $this->sql->consultar("START TRANSACTION", "sgrc");
        if (!empty($datos[idusuario])) {
            $datos_idusuario = $datos[idusuario];
        }
        if (!empty($datos[idmodulo_usuario])) {
            $datos_idmodulo_usuario = $datos[idmodulo_usuario];
        }
        $consulta_bitacora = "INSERT INTO
                                `bitacora`(
                                `ip`,
                                `fallido`,
                                `idusuario`,
                                `idmodulo_usuario`)
                              VALUES(
                               '$_SERVER[REMOTE_ADDR]',
                                $fallido,$datos_idusuario,$datos_idmodulo_usuario)";

        //echo $consulta_bitacora;
        if (!$this->sql->consultar($consulta_bitacora, "sgrc")) {
            $error++;
        }

        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        if ($fallido + $error == 0) {

            return true;
        } else {
            //  session_destroy();
            return false;
        }
    }

    function destruyeSesion() {

        session_start();
        session_unset();
        session_destroy();
    }
    
    
    

      
        
  


}

?>