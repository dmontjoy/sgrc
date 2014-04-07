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
class gpersona {

    //put your code here
    function gpersona() {
        $this->sql = new DmpSql();
    }
    
    function editar_rol($idrol,$rol,$idseguridad_permiso) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        
        $consulta="SELECT COUNT(*) as cantidad from seguridad_rol where nombre like '$rol' AND idseguridad_rol<>$idrol";       
        
        $result = $this->sql->consultar($consulta, "sgrc");
        
        if (!$result) {
            $error++;
            //echo $consulta;
            
        }else{
            $fila = mysql_fetch_array($result);
            if($fila[cantidad]>0){
                $error++;
            }
        }

        $consulta = "UPDATE
                  seguridad_rol set nombre='$rol'
                  WHERE
                  idseguridad_rol=$idrol";

         
        
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
            //echo $consulta;
        }                   
      
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
        $tama_idseguridad_permiso = sizeof($idseguridad_permiso);
        
        //echo $tama_idcompromiso_rc;exit;
        
        $count=0;

        if ($tama_idseguridad_permiso > 0) {

            $consulta = "INSERT INTO
                                  `seguridad_permiso_grupo`(
                                  `idseguridad_permiso`,
                                  `idseguridad_rol`,
                                  `activo`)
                                VALUES";

            for ($i = 0; $i < $tama_idseguridad_permiso; $i++) {              

                if (strpos($idseguridad_permiso[$i], "###")) {
                    $count++;
                    
                    $aux_idseguridad_permiso = explode("###", $idseguridad_permiso[$i]);
                    
                    $consulta.="($aux_idseguridad_permiso[0],$idrol,1),";
                }
                
                if (strpos($idseguridad_permiso[$i], "***") > 0) {
                    $aux_idseguridad_permiso = explode("***", $idseguridad_permiso[$i]);

                    if ($aux_idseguridad_permiso[1] == '0') {
                        $fecha_a= date('Y-m-d H:i:s');
                        $update = "UPDATE seguridad_permiso_grupo SET activo=0 WHERE idseguridad_rol=$idrol AND idseguridad_permiso=$aux_idseguridad_permiso[0]";
                        //echo $update_dir . "<br>";
                        if (!$this->sql->consultar($update, "sgrc")) {
                            $error++;
                            //echo $update;
                        }

                         $consulta_sincronizacion= $ayudante->migracion_update($update);

                        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                            $error++;
                        }
                    } 

                    
                }
            }
            
            if($count>0){
            
                $consulta = substr($consulta, 0, -1);

                if (!$this->sql->consultar($consulta, "sgrc")) {
                    $error++;
                    //echo "consulta : ".$consulta;
                }            

                $consulta_sincronizacion= $ayudante->migracion_update($consulta);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }


        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $error . "***" . $idrol;
    }
    
    function crear_rol($rol,$idseguridad_permiso) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $idrol = 0;
        
        $consulta="SELECT COUNT(*) as cantidad from seguridad_rol where nombre like '$rol'";       
        
        $result = $this->sql->consultar($consulta, "sgrc");
        
        if (!$result) {
            $error++;
            
        }else{
            $fila = mysql_fetch_array($result);
            if($fila[cantidad]>0){
                $error++;
            }
        }

        $consulta = "INSERT INTO
                  seguridad_rol(nombre)
                VALUES('$rol')";

        //echo $consulta; 
        
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
            
        }
           
        $idrol = $this->sql->idtabla();
      
        $consulta_sincronizacion= $ayudante->migracion_insert("idrol",$idrol,$consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
        $tama_idseguridad_permiso = sizeof($idseguridad_permiso);
        
        //echo $tama_idcompromiso_rc;exit;

        if ($tama_idseguridad_permiso > 0) {

            $consulta = "INSERT INTO
                                  `seguridad_permiso_grupo`(
                                  `idseguridad_permiso`,
                                  `idseguridad_rol`,
                                  `activo`)
                                VALUES";

            for ($i = 0; $i < $tama_idseguridad_permiso; $i++) {              

                if (strpos($idseguridad_permiso[$i], "###")) {
                    
                    $aux_idseguridad_permiso = explode("###", $idseguridad_permiso[$i]);
                    
                    $consulta.="($aux_idseguridad_permiso[0],$idrol,1),";
                }
            }
            
            $consulta = substr($consulta, 0, -1);

            //echo "consulta : ".$consulta."<br>";
            
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

        return $error . "***" . $idrol;
    }

    function agregar($idmodulo, $nombre, $apaterno, $amaterno,$archivo, $idpersona_tipo, $comentario, $fecha_nacimiento, $sexo, $background, $persona_direccion, $idpersona_direccion, $persona_telefono, $idpersona_telefono, $persona_mail, $idpersona_mail, $idpersona_organizacion, $idpersona_cargo, $idpersona_documento_identificacion, $select_documento_identificacion, $numero_documento, $es_stakeholder, $idestado_civil) {
        $ayudante = new Ayudante();
        //$email=array_filter($email);
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        $fecha_a= date('Y-m-d H:i:s');
                
        $fecha_nacimiento = $ayudante->FechaRevezMysql($fecha_nacimiento, "/");
        $consulta = "INSERT INTO
                      `persona`(
                      `idmodulo`,
                      `apellido_p`,
                      `apellido_m`,
                      `nombre`,
                       imagen,
                      `activo`,
                      `idusu_c`,
                      `idmodulo_c`,
                      `fecha_nacimiento`,
                      `idpersona_tipo`,
                      `idestado_civil`,
                      `sexo`,
                       comentario,
                       background,
                       fecha_a)
                    VALUES(
                      $_SESSION[idmodulo],
                      '$apaterno',
                      '$amaterno',
                      '$nombre',
                      '$archivo',
                      1,
                      $_SESSION[idusu_c],
                      $_SESSION[idmodulo_c],
                      '$fecha_nacimiento',
                      $idpersona_tipo,
                      '$idestado_civil',
                      '$sexo',
                      '$comentario',
                      '$background',
                      '$fecha_a')";

        //echo $consulta;
        //exit;
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
        }
        $idpersona = $this->sql->idtabla();
                        
        $consulta_sincronizacion= $ayudante->migracion_insert("idpersona",$idpersona,$consulta);
                
        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
       

       /*         * ****************mail************** */

        $entro_email = 0;
        $sql_ins = "INSERT INTO persona_mail(mail,idpersona,idmodulo,activo,idmodulo_persona_mail) VALUES ";
        //print_r($persona_mail);
        if (count($idpersona_mail) > 0) {
            foreach ($idpersona_mail as $key => $value_idpersona_mail) {
                //$key = $ayudante->caracter($key);
                if (strpos("$value_idpersona_mail", "***") > 0) {
                    $apersona_mail = explode("***", $value_idpersona_mail);

                    if ($apersona_mail[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_mail SET `fecha_a`='$fecha_a',activo=0 WHERE idpersona_mail=$apersona_mail[0] AND idmodulo_persona_mail=$apersona_mail[1]";
                    } else {
                         $fecha_a= date('Y-m-d H:i:s');
                        //cuando esta activo
                        $update_dir = "UPDATE persona_mail SET `fecha_a`='$fecha_a',mail='$persona_mail[$key]',activo=1 WHERE idpersona_mail=$apersona_mail[0] AND idmodulo_persona_mail=$apersona_mail[1] AND mail!='$persona_mail[$key]'";
                    }

                    //echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                    
                    $consulta_sincronizacion= $ayudante->migracion_update($update_dir);
                
                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                    
                } else {
                    //$persona_mail[$i] != null &&
                    if ($idpersona_mail[$key] != 0 && $persona_mail[$key]!='') {
                        $entro_email = 1;
                        $sql_ins.="('" . $persona_mail[$key] . "'," . $idpersona . "," . $_SESSION[idmodulo] . ",1, $_SESSION[idmodulo] ),";
                    }
                }
            }

            if ($entro_email == 1) {
                $sql_ins = substr($sql_ins, 0, -1);
                
                //echo $sql_ins;
                if (!$this->sql->consultar($sql_ins, "sgrc")) {
                    $error++;
                }
                $idpersona_mail = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_mail",$idpersona_mail,$sql_ins);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }
        /*         * ****************telefono******** */
        $entro_telefono = 0;
        $sql_ins = "INSERT INTO persona_telefono(telefono,idpersona,idmodulo,activo,idmodulo_persona_telefono) VALUES ";
        //print_r($persona_telefono);
        if (count($idpersona_telefono) > 0) {
            foreach ($idpersona_telefono as $key => $value_idpersona_telefono) {
                //$key = $ayudante->caracter($key);
                if (strpos("$value_idpersona_telefono", "***") > 0) {
                    $apersona_telefono = explode("***", $value_idpersona_telefono);

                    if ($apersona_telefono[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_telefono SET `fecha_a`='$fecha_a',activo=0 WHERE idpersona_telefono=$apersona_telefono[0] AND idmodulo_persona_telefono=$apersona_telefono[1]";
                    } else {
                         $fecha_a= date('Y-m-d H:i:s');
                        //cuando esta activo
                        $update_dir = "UPDATE persona_telefono SET `fecha_a`='$fecha_a',telefono='$persona_telefono[$key]',activo=1 WHERE idpersona_telefono=$apersona_telefono[0] AND idmodulo_persona_telefono=$apersona_telefono[1] AND telefono!='$persona_telefono[$key]'";
                    }

                    //echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($update_dir);
                
                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } else {
                    if ($value_idpersona_telefono != 0 && $persona_telefono[$key] !='') {
                        $entro_telefono = 1;
                        $sql_ins.="('" . $persona_telefono[$key] . "'," . $idpersona . "," . $_SESSION[idmodulo] . ",1,$_SESSION[idmodulo]),";
                    }
                }
            }

            if ($entro_telefono == 1) {
                $sql_ins = substr($sql_ins, 0, -1);
                
                // echo $sql_ins . "<br>";
                if (!$this->sql->consultar($sql_ins, "sgrc")) {
                    $error++;
                }
                $idpersona_telefono = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_telefono",$idpersona_telefono,$sql_ins);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }

        /*         * **********direccion*********** */
        //actualizar
        $entro_direccion = 0;
        $sql_ins = "INSERT INTO persona_direccion(direccion,idpersona,idmodulo,activo,idmodulo_persona_direccion) VALUES ";

        if (count($idpersona_direccion) > 0) {
            foreach ($idpersona_direccion as $key => $value_idpersona_direccion) {
                
                $persona_direccion[$key]=$ayudante->caracter($persona_direccion[$key]);
                //$key = $ayudante->caracter($key); 
                if (strpos("$value_idpersona_direccion", "***") > 0) {
                    $apersona_direccion = explode("***", $value_idpersona_direccion);

                    if ($apersona_direccion[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_direccion SET `fecha_a`='$fecha_a',activo=0 WHERE idpersona_direccion=$apersona_direccion[0] AND idmodulo_persona_direccion=$apersona_direccion[1]";
                    } else {
                         $fecha_a= date('Y-m-d H:i:s');
                        //cuando esta activo
                        $update_dir = "UPDATE persona_direccion SET `fecha_a`='$fecha_a',direccion='$persona_direccion[$key]',activo=1 WHERE idpersona_direccion=$apersona_direccion[0] AND idmodulo_persona_direccion=$apersona_direccion[1] AND direccion!='$persona_direccion[$key]'";
                    }

                    //echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($update_dir);
                
                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } else {
                    //echo "persona_direccion" . $persona_direccion[$i] . "<br>";
                    //echo "idpersona direccion " . $idpersona_direccion[$i];
                    //$persona_direccion[$i] != null &&
                    if ($value_idpersona_direccion != 0 && $persona_direccion[$key]!='') {
                        $entro_direccion = 1;
                        //$direccion[$key] = $ayudante->caracter($direccion[$key]);
                       
                            $sql_ins.="('" . $persona_direccion[$key] . "'," . $idpersona . "," . $_SESSION[idmodulo] . ",1,$_SESSION[idmodulo]),";
                        
                    }
                }
            }
        }
        /* for ($i = 0; $i < count($idpersona_direccion); $i++) {
          if (strpos("$idpersona_direccion[$i]", "***") > 0) {
          $apersona_direccion = explode("***", $idpersona_direccion[$i]);

          if ($apersona_direccion[2] == '0') {
          $update_dir = "UPDATE persona_direccion SET activo=0 WHERE idpersona_direccion=$apersona_direccion[0] AND idmodulo_persona_direccion=$apersona_direccion[1]";
          } else {
          //cuando esta activo
          $update_dir = "UPDATE persona_direccion SET direccion='$persona_direccion[$i]',activo=1 WHERE idpersona_direccion=$apersona_direccion[0] AND idmodulo_persona_direccion=$apersona_direccion[1] AND direccion!='$persona_direccion[$i]'";
          }

          //echo $update_dir . "<br>";
          if (!$this->sql->consultar($update_dir, "sgrc")) {
          $error++;
          }
          } else {
          //echo "persona_direccion" . $persona_direccion[$i] . "<br>";
          //echo "idpersona direccion " . $idpersona_direccion[$i];
          //$persona_direccion[$i] != null &&
          if ($idpersona_direccion[$i] != 0) {
          $entro_direccion = 1;
          $direccion[$i] = $ayudante->caracter($direccion[$i]);
          $sql_ins.="('" . $persona_direccion[$i] . "'," . $idpersona . "," . $idmodulo . ",1,$_SESSION[idmodulo_a]),";
          }
          }
          } */
        if ($entro_direccion == 1) {
            $sql_ins = substr($sql_ins, 0, -1);
            
            //echo "<br>" . $sql_ins;
            if (!$this->sql->consultar($sql_ins, "sgrc")) {
                $error++;
            }
            $idpersona_direccion = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_direccion",$idpersona_direccion,$sql_ins);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }


        /*         * *****documento identificacion****** */
//$idpersona_documento_identificacion,$select_documento_identificacion, $numero_documento
        $entro_documento_identificacion = 0;
        $sql_ins = "INSERT INTO persona_documento_identificacion(documento_identificacion,iddocumento_identificacion,idpersona,idmodulo,activo,idmodulo_persona_documento_identificacion) VALUES ";
        //print_r($idpersona_documento_identificacion);
        //print_r($numero_documento);
        //print_r($select_documento_identificacion);

        if (count($idpersona_documento_identificacion) > 0) {
            foreach ($idpersona_documento_identificacion as $key => $value_idpersona_documento_identificacion) {
                $key = $ayudante->caracter($key);
                if (strpos("$value_idpersona_documento_identificacion", "***") > 0) {
                    $apersona_documento_identificacion = explode("***", $value_idpersona_documento_identificacion);

                    if ($apersona_documento_identificacion[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_documento_identificacion SET `fecha_a`='$fecha_a',activo=0 WHERE idpersona_documento_identificacion=$apersona_documento_identificacion[0] AND idmodulo_persona_documento_identificacion=$apersona_documento_identificacion[1]";
                    } else {
                        //cuando esta activo
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_documento_identificacion SET `fecha_a`='$fecha_a',documento_identificacion='$numero_documento[$key]',iddocumento_identificacion='$select_documento_identificacion[$key]',activo=1 WHERE idpersona_documento_identificacion=$apersona_documento_identificacion[0] AND idmodulo_persona_documento_identificacion=$apersona_documento_identificacion[1] AND (documento_identificacion!='$numero_documento[$key]' OR iddocumento_identificacion!='$select_documento_identificacion[$key]')";
                    }

                    // echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($update_dir);
                
                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                    
                } else {

                    //echo "nume" . $numero_documento[trim($key)] . "<\br>";
                    // print_r($numero_documento);
                    if ($numero_documento[$key] != null && $numero_documento[$key] !='') {
                        $entro_documento_identificacion = 1;
                        $sql_ins.="('" . $numero_documento[$key] . "', '" . $select_documento_identificacion[$key] . "', '" . $idpersona . "', '" . $_SESSION[idmodulo] . "', 1, $_SESSION[idmodulo]),";
                    }
                }
            }

            if ($entro_documento_identificacion == 1) {
                $sql_ins = substr($sql_ins, 0, -1);
                
                //echo $sql_ins . "<br>";
                //exit;

                if (!$this->sql->consultar($sql_ins, "sgrc")) {
                    $error++;
                }
                $idpersona_documento_identificacion = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_documento_identificacion",$idpersona_documento_identificacion,$sql_ins);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }
        //echo "error " . $error;
        //exit;
        /*         * *******persona organizacion******* */
        //echo print_r($idpersona_organizacion);

        if (count($idpersona_organizacion) > 0) {

            $sql_ins = "INSERT INTO persona_organizacion(idorganizacion, idmodulo_organizacion, idpersona_cargo, idpersona, idmodulo, activo, idmodulo_persona_organizacion) VALUES ";
            foreach ($idpersona_organizacion as $key => $value_idpersona_organizacion) {
                //$key = $ayudante->caracter($key);
                if (strpos("$value_idpersona_organizacion", "***") > 0) {
                    $apersona_organizacion = explode("***", $value_idpersona_organizacion);

                    if ($apersona_organizacion[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_organizacion SET `fecha_a`='$fecha_a',activo = 0 WHERE idpersona_organizacion = $apersona_organizacion[0] AND idmodulo_persona_organizacion = $apersona_organizacion[1]";
                    } else {
                         $fecha_a= date('Y-m-d H:i:s');
                        //cuando esta activo
                        $update_dir = "UPDATE persona_organizacion SET `fecha_a`='$fecha_a',idpersona_cargo = $idpersona_cargo[$key], activo = 1 WHERE idpersona_organizacion = $apersona_organizacion[0] AND idmodulo_persona_organizacion = $apersona_organizacion[1] AND idpersona_cargo!='$idpersona_cargo[$key]'";
                    }

                    //echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($update_dir);
                
                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                    
                } else {

                    //if ($idpersona_organizacion[$i] != null && !strpos($idpersona_organizacion[$i], "###")) {
                    $entro_organizacion = 1;
                    $lista_idorganizacion = split("---", $value_idpersona_organizacion);
                    $sql_ins.="('" . $lista_idorganizacion[0] . "','" . $lista_idorganizacion[1] . "'," . $idpersona_cargo[$key] . "," . $idpersona . "," . $_SESSION[idmodulo]. ",1,$_SESSION[idmodulo]),";
                    // }
                }
            }
            if ($entro_organizacion == 1) {
                $sql_ins = substr($sql_ins, 0, -1);
                
                //echo $sql_ins;
                //exit;

                if (!$this->sql->consultar($sql_ins, "sgrc")) {
                    $error++;
                }
                 
                $idpersona_organizacion = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_organizacion",$idpersona_organizacion,$sql_ins);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }


        //si tipo de persona 1, es stakeholder
        if ($es_stakeholder == 1) {
            $sql_insert = "INSERT INTO
                            `sh`(
                            `activo`,
                            `idsh`,
                            `idmodulo`,
                            `importancia`)
                          VALUES(
                            1,
                            $idpersona,
                            $_SESSION[idmodulo],
                            0)";
            if (!$this->sql->consultar($sql_insert, "sgrc")) {
                $error++;
            }
            $consulta_sincronizacion= $ayudante->migracion_update($sql_insert);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
            
        }elseif($es_stakeholder == 2){
            $sql_insert = "INSERT INTO
                            `rc`(
                            `activo`,
                            `idrc`,
                            `idmodulo`
                            )
                          VALUES(
                            1,
                            $idpersona,
                            $_SESSION[idmodulo]
                            )";
            if (!$this->sql->consultar($sql_insert, "sgrc")) {
                $error++;
            }
            $consulta_sincronizacion= $ayudante->migracion_update($sql_insert);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
        }else{
            
        }
        
        
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $idpersona . "***" . $_SESSION[idmodulo] . "***" . $error;
    }

    function editar($idpersona, $idmodulo, $nombre, $apaterno, $amaterno, $archivo, $idpersona_tipo, $comentario, $fecha_nacimiento, $sexo, $background, $persona_direccion, $idpersona_direccion, $persona_telefono, $idpersona_telefono, $persona_mail, $idpersona_mail, $idpersona_organizacion, $idpersona_cargo, $idpersona_documento_identificacion, $select_documento_identificacion, $numero_documento, $idestado_civil) {

        $ayudante = new Ayudante();
        //$email=array_filter($email);
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $fecha_creacion = date('Y-m-d');
        $fecha_nacimiento = $ayudante->FechaRevezMysql($fecha_nacimiento, "/");
        
        $fecha_a= date('Y-m-d H:i:s');

        $consulta = "UPDATE persona SET
                      `fecha_a` = '$fecha_a',
                      `idusu_a` = $_SESSION[idusu_a],
                      `idmodulo_a` = $_SESSION[idmodulo_a],
                      `apellido_p` = '$apaterno',
                      `apellido_m` = '$amaterno',
                      `nombre` = '$nombre', ";
        
        if($archivo!=""){
            $consulta.="
                      `imagen` = '$archivo',";
        }
        
            $consulta.="
                      `fecha_nacimiento` = '$fecha_nacimiento',
                      `idpersona_tipo` = '$idpersona_tipo',
                      `idestado_civil` = '$idestado_civil',
                      `sexo` = '$sexo',
                       comentario = '$comentario',
                       background = '$background'
                      WHERE
                       idpersona ='$idpersona' AND
                       idmodulo='$idmodulo'";


        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
        }
        
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }

        /*         * ****************mail************** */

        $entro_email = 0;
        $sql_ins = "INSERT INTO persona_mail(mail,idpersona,idmodulo,activo,idmodulo_persona_mail) VALUES ";
        //print_r($persona_mail);
        if (count($idpersona_mail) > 0) {
            foreach ($idpersona_mail as $key => $value_idpersona_mail) {
                //$key = $ayudante->caracter($key);
                if (strpos("$value_idpersona_mail", "***") > 0) {
                    $apersona_mail = explode("***", $value_idpersona_mail);

                    if ($apersona_mail[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_mail SET `fecha_a`='$fecha_a',activo=0 WHERE idpersona_mail=$apersona_mail[0] AND idmodulo_persona_mail=$apersona_mail[1]";
                    } else {
                         $fecha_a= date('Y-m-d H:i:s');
                        //cuando esta activo
                        $update_dir = "UPDATE persona_mail SET `fecha_a`='$fecha_a',mail='$persona_mail[$key]',activo=1 WHERE idpersona_mail=$apersona_mail[0] AND idmodulo_persona_mail=$apersona_mail[1] AND mail!='$persona_mail[$key]'";
                    }

                    //echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                    
                     $consulta_sincronizacion= $ayudante->migracion_update($update_dir);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } else {
                    //$persona_mail[$i] != null &&
                    if ($idpersona_mail[$key] != 0 && $persona_mail[$key] !='') {
                        $entro_email = 1;
                        $sql_ins.="('" . $persona_mail[$key] . "'," . $idpersona . "," . $idmodulo . ",1, $_SESSION[idmodulo]),";
                    }
                }
            }

            if ($entro_email == 1) {
                $sql_ins = substr($sql_ins, 0, -1);
                
                //echo $sql_ins;
                if (!$this->sql->consultar($sql_ins, "sgrc")) {
                    $error++;
                }
                $idpersona_mail= $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_mail",$idpersona_mail,$sql_ins);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }
        /*         * ****************telefono******** */

        $entro_telefono = 0;
        $sql_ins = "INSERT INTO persona_telefono(telefono,idpersona,idmodulo,activo,idmodulo_persona_telefono) VALUES ";
        //print_r($persona_telefono);
        if (count($idpersona_telefono) > 0) {
            foreach ($idpersona_telefono as $key => $value_idpersona_telefono) {
                //$key = $ayudante->caracter($key);
                if (strpos("$value_idpersona_telefono", "***") > 0) {
                    $apersona_telefono = explode("***", $value_idpersona_telefono);

                    if ($apersona_telefono[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_telefono SET `fecha_a`='$fecha_a',activo=0 WHERE idpersona_telefono=$apersona_telefono[0] AND idmodulo_persona_telefono=$apersona_telefono[1]";
                    } else {
                         $fecha_a= date('Y-m-d H:i:s');
                        //cuando esta activo
                        $update_dir = "UPDATE persona_telefono SET `fecha_a`='$fecha_a',telefono='$persona_telefono[$key]',activo=1 WHERE idpersona_telefono=$apersona_telefono[0] AND idmodulo_persona_telefono=$apersona_telefono[1] AND telefono!='$persona_telefono[$key]'";
                    }

                    //echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                     $consulta_sincronizacion= $ayudante->migracion_update($update_dir);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } else {
                    if ($value_idpersona_telefono != 0 && $persona_telefono[$key] !='') {
                        $entro_telefono = 1;
                        $sql_ins.="('" . $persona_telefono[$key] . "'," . $idpersona . "," . $idmodulo . ",1,$_SESSION[idmodulo]),";
                    }
                }
            }

            if ($entro_telefono == 1) {
                $sql_ins = substr($sql_ins, 0, -1);
                
                // echo $sql_ins . "<br>";
                if (!$this->sql->consultar($sql_ins, "sgrc")) {
                    $error++;
                }
                $idpersona_telefono= $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_telefono",$idpersona_telefono,$sql_ins);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }

        /*         * **********direccion*********** */
        //actualizar
        $entro_direccion = 0;
        $sql_ins = "INSERT INTO persona_direccion(direccion,idpersona,idmodulo,activo,idmodulo_persona_direccion) VALUES ";

        if (count($idpersona_direccion) > 0) {
            foreach ($idpersona_direccion as $key => $value_idpersona_direccion) {
                $persona_direccion[$key]=$ayudante->caracter($persona_direccion[$key]);
                //$key = $ayudante->caracter($key);
                if (strpos("$value_idpersona_direccion", "***") > 0) {
                    $apersona_direccion = explode("***", $value_idpersona_direccion);

                    if ($apersona_direccion[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_direccion SET `fecha_a`='$fecha_a',activo=0 WHERE idpersona_direccion=$apersona_direccion[0] AND idmodulo_persona_direccion=$apersona_direccion[1]";
                    } else {
                         $fecha_a= date('Y-m-d H:i:s');
                        //cuando esta activo
                        $update_dir = "UPDATE persona_direccion SET `fecha_a`='$fecha_a',direccion='$persona_direccion[$key]',activo=1 WHERE idpersona_direccion=$apersona_direccion[0] AND idmodulo_persona_direccion=$apersona_direccion[1] AND direccion!='$persona_direccion[$key]'";
                    }

                    //echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                    
                    $consulta_sincronizacion= $ayudante->migracion_update($update_dir);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } else {
                    //echo "persona_direccion" . $persona_direccion[$i] . "<br>";
                    //echo "idpersona direccion " . $idpersona_direccion[$i];
                    //$persona_direccion[$i] != null &&
                    if ($value_idpersona_direccion != 0 && $persona_direccion[$key]!='') {
                        $entro_direccion = 1;
                        //$direccion[$key] = $ayudante->caracter($direccion[$key]);
                        $sql_ins.="('" . $persona_direccion[$key] . "'," . $idpersona . "," . $idmodulo . ",1,$_SESSION[idmodulo]),";
                    }
                }
            }
        }
        /* for ($i = 0; $i < count($idpersona_direccion); $i++) {
          if (strpos("$idpersona_direccion[$i]", "***") > 0) {
          $apersona_direccion = explode("***", $idpersona_direccion[$i]);

          if ($apersona_direccion[2] == '0') {
          $update_dir = "UPDATE persona_direccion SET activo=0 WHERE idpersona_direccion=$apersona_direccion[0] AND idmodulo_persona_direccion=$apersona_direccion[1]";
          } else {
          //cuando esta activo
          $update_dir = "UPDATE persona_direccion SET direccion='$persona_direccion[$i]',activo=1 WHERE idpersona_direccion=$apersona_direccion[0] AND idmodulo_persona_direccion=$apersona_direccion[1] AND direccion!='$persona_direccion[$i]'";
          }

          //echo $update_dir . "<br>";
          if (!$this->sql->consultar($update_dir, "sgrc")) {
          $error++;
          }
          } else {
          //echo "persona_direccion" . $persona_direccion[$i] . "<br>";
          //echo "idpersona direccion " . $idpersona_direccion[$i];
          //$persona_direccion[$i] != null &&
          if ($idpersona_direccion[$i] != 0) {
          $entro_direccion = 1;
          $direccion[$i] = $ayudante->caracter($direccion[$i]);
          $sql_ins.="('" . $persona_direccion[$i] . "'," . $idpersona . "," . $idmodulo . ",1,$_SESSION[idmodulo_a]),";
          }
          }
          } */
        if ($entro_direccion == 1) {
            $sql_ins = substr($sql_ins, 0, -1);
            
            //echo "<br>" . $sql_ins;
            if (!$this->sql->consultar($sql_ins, "sgrc")) {
                $error++;
            }
            $idpersona_direccion= $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_direccion",$idpersona_direccion,$sql_ins);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }


        /*         * *****documento identificacion****** */
//$idpersona_documento_identificacion,$select_documento_identificacion, $numero_documento
        $entro_documento_identificacion = 0;
        $sql_ins = "INSERT INTO persona_documento_identificacion(documento_identificacion,iddocumento_identificacion,idpersona,idmodulo,activo,idmodulo_persona_documento_identificacion) VALUES ";
        //print_r($idpersona_documento_identificacion);
        //print_r($numero_documento);
        //print_r($select_documento_identificacion);

        if (count($idpersona_documento_identificacion) > 0) {
            foreach ($idpersona_documento_identificacion as $key => $value_idpersona_documento_identificacion) {
                $key = $ayudante->caracter($key);
                if (strpos("$value_idpersona_documento_identificacion", "***") > 0) {
                    $apersona_documento_identificacion = explode("***", $value_idpersona_documento_identificacion);

                    if ($apersona_documento_identificacion[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_documento_identificacion SET `fecha_a`='$fecha_a',activo=0 WHERE idpersona_documento_identificacion=$apersona_documento_identificacion[0] AND idmodulo_persona_documento_identificacion=$apersona_documento_identificacion[1]";
                    } else {
                         $fecha_a= date('Y-m-d H:i:s');
                        //cuando esta activo
                        $update_dir = "UPDATE persona_documento_identificacion SET `fecha_a`='$fecha_a',documento_identificacion='$numero_documento[$key]',iddocumento_identificacion='$select_documento_identificacion[$key]',activo=1 WHERE idpersona_documento_identificacion=$apersona_documento_identificacion[0] AND idmodulo_persona_documento_identificacion=$apersona_documento_identificacion[1] AND (documento_identificacion!='$numero_documento[$key]' OR iddocumento_identificacion!='$select_documento_identificacion[$key]')";
                    }

                    // echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                    
                    $consulta_sincronizacion= $ayudante->migracion_update($update_dir);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } else {

                    //echo "nume" . $numero_documento[trim($key)] . "<\br>";
                    // print_r($numero_documento);
                    if ($numero_documento[$key] != null) {
                        $entro_documento_identificacion = 1;
                        $sql_ins.="('" . $numero_documento[$key] . "', '" . $select_documento_identificacion[$key] . "', '" . $idpersona . "', '" . $idmodulo . "', 1, $_SESSION[idmodulo]),";
                    }
                }
            }

            if ($entro_documento_identificacion == 1) {
                $sql_ins = substr($sql_ins, 0, -1);

                //echo $sql_ins . "<br>";
                //exit;

                if (!$this->sql->consultar($sql_ins, "sgrc")) {
                    $error++;
                }
                $idpersona_documento_identificacion= $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_documento_identificacion",$idpersona_documento_identificacion,$sql_ins);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }
        //echo "error " . $error;
        //exit;
        /*         * *******persona organizacion******* */
        //echo print_r($idpersona_organizacion);

        if (count($idpersona_organizacion) > 0) {

            $sql_ins = "INSERT INTO persona_organizacion(idorganizacion, idmodulo_organizacion, idpersona_cargo, idpersona, idmodulo, activo, idmodulo_persona_organizacion) VALUES ";
            foreach ($idpersona_organizacion as $key => $value_idpersona_organizacion) {
                //$key = $ayudante->caracter($key);
                if (strpos("$value_idpersona_organizacion", "***") > 0) {
                    $apersona_organizacion = explode("***", $value_idpersona_organizacion);

                    if ($apersona_organizacion[2] == '0') {
                         $fecha_a= date('Y-m-d H:i:s');
                        $update_dir = "UPDATE persona_organizacion SET `fecha_a`='$fecha_a',activo = 0 WHERE idpersona_organizacion = $apersona_organizacion[0] AND idmodulo_persona_organizacion = $apersona_organizacion[1]";
                    } else {
                         $fecha_a= date('Y-m-d H:i:s');
                        //cuando esta activo
                        $update_dir = "UPDATE persona_organizacion SET `fecha_a`='$fecha_a',idpersona_cargo = $idpersona_cargo[$key], activo = 1 WHERE idpersona_organizacion = $apersona_organizacion[0] AND idmodulo_persona_organizacion = $apersona_organizacion[1] AND idpersona_cargo!='$idpersona_cargo[$key]'";
                    }

                    //echo $update_dir . "<br>";
                    if (!$this->sql->consultar($update_dir, "sgrc")) {
                        $error++;
                    }
                    
                    $consulta_sincronizacion= $ayudante->migracion_update($update_dir);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } else {

                    //if ($idpersona_organizacion[$i] != null && !strpos($idpersona_organizacion[$i], "###")) {
                    $entro_organizacion = 1;
                    $lista_idorganizacion = split("---", $value_idpersona_organizacion);
                    $sql_ins.="('" . $lista_idorganizacion[0] . "','" . $lista_idorganizacion[1] . "'," . $idpersona_cargo[$key] . "," . $idpersona . "," . $idmodulo . ",1,$_SESSION[idmodulo]),";
                    // }
                }
            }
            if ($entro_organizacion == 1) {
                $sql_ins = substr($sql_ins, 0, -1);
                //echo $sql_ins;
                //exit;

                if (!$this->sql->consultar($sql_ins, "sgrc")) {
                    $error++;
                }
                $idpersona_organizacion = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_organizacion",$idpersona_organizacion,$sql_ins);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }

        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        // echo $consulta;
        
        return $idpersona . "***" . $idmodulo . "***" . $error;
    }

}

?>
