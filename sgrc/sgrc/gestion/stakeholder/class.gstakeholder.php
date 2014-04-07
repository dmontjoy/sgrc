<?php

class gstakeholder {

    //put your code here
    function gstakeholder() {           
        $this->sql = new DmpSql();
    }

    function asignar($idpersona, $idmodulo) {
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $ayudante = new Ayudante();
        $error = 0;
        //la persona ya esta creada
        $c_validar = "SELECT
                        `sh`.`idsh`,
                        `sh`.`idmodulo`
                      FROM
                        `sh` WHERE idsh=$idpersona AND idmodulo=$idmodulo";
        $result = $this->sql->consultar($c_validar, "sgrc");

        if (mysql_num_rows($result) == 0) {
            $consulta = "INSERT INTO
                            `sh`(
                            `activo`,
                            `idsh`,
                            `idmodulo`,
                            `importancia`,
                            `idusu`,
                            `idmodulo_a`)
                          VALUES(
                            1,
                            $idpersona,
                            $idmodulo,
                            0,
                            '$_SESSION[idusu]',
                            '$_SESSION[idmodulo_a]'
                          )";
            //echo $consulta;

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
            
            
        } else {
             $fecha_a= date('Y-m-d H:i:s');

            $consulta = "UPDATE `sh` SET `fecha_a`='$fecha_a',activo=1 WHERE idsh=$idpersona AND idmodulo=$idmodulo";

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
        }
        
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

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

    function eliminar($idpersona, $idmodulo) {
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        $ayudante = new Ayudante();
         $fecha_a= date('Y-m-d H:i:s');
        
        $update = "UPDATE sh SET `fecha_a`='$fecha_a',activo=0 WHERE idsh=$idpersona AND idmodulo=$idmodulo";

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
    
    function eliminar_persona($idpersona, $idmodulo) {
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        $ayudante = new Ayudante();
        
        $interaccion_rc = 0;
        
       $consulta = "SELECT COUNT(*) AS 'cantidad' 
                    FROM interaccion_rc
                    WHERE activo=1
                    AND idrc=$idpersona
                    AND idmodulo=$idmodulo";
        
       $result=$this->sql->consultar($consulta, "sgrc"); 
       
       if( $fila=  mysql_fetch_array($result) ){
           $interaccion_rc = $fila[cantidad];
       }
       
       $interaccion_sh = 0;
       
       $consulta = "SELECT COUNT(*) AS 'cantidad' 
                    FROM interaccion_sh
                    WHERE activo=1
                    AND idsh=$idpersona
                    AND idmodulo=$idmodulo";
        
       $result=$this->sql->consultar($consulta, "sgrc"); 
       
       if( $fila=  mysql_fetch_array($result) ){
           $interaccion_sh = $fila[cantidad];
       }
       
       $persona_tag = 0;
       
       $consulta = "SELECT COUNT(*) AS 'cantidad' 
                    FROM persona_tag
                    WHERE activo=1
                    AND idpersona=$idpersona
                    AND idmodulo=$idmodulo";
        
       $result=$this->sql->consultar($consulta, "sgrc"); 
       
       if( $fila=  mysql_fetch_array($result) ){
           $persona_tag = $fila[cantidad];
       }
       
       $error = $interaccion_rc + $interaccion_sh + $persona_tag;
        
        $fecha_a= date('Y-m-d H:i:s');

        $update = "UPDATE persona SET `fecha_a`='$fecha_a',activo=0 WHERE idpersona=$idpersona AND idmodulo=$idmodulo";
        
        //echo "update : ".$update;

        if (!$this->sql->consultar($update, "sgrc")) {

            $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($update);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
         $fecha_a= date('Y-m-d H:i:s');
        $update = "UPDATE rc SET `fecha_a`='$fecha_a',activo=0 WHERE idrc=$idpersona AND idmodulo=$idmodulo";

        if (!$this->sql->consultar($update, "sgrc")) {

            $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($update);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
         $fecha_a= date('Y-m-d H:i:s');
        $update = "UPDATE sh SET `fecha_a`='$fecha_a',activo=0 WHERE idsh=$idpersona AND idmodulo=$idmodulo";

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


    function eliminar_compromiso($idcompromiso, $idmodulo_compromiso) {
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $ayudante = new Ayudante();
        $error = 0;
         $fecha_a= date('Y-m-d H:i:s');
        $consulta = "UPDATE compromiso
                    SET `fecha_a`='$fecha_a',activo=0
                    WHERE idcompromiso=$idcompromiso
                    AND idmodulo_compromiso=$idmodulo_compromiso
                    AND activo=1";
        if (!$this->sql->consultar($consulta, "sgrc")) {

            $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        // echo $idcompromiso."---".$idmodulo_compromiso."---".$error;exit;
        return $error;
    }

    function actualizar_compromiso($idcompromiso, $idmodulo_compromiso, $fecha_compromiso, $hora_compromiso,$minuto_compromiso,$fecha_fin_compromiso,$hora_fin_compromiso,$minuto_fin_compromiso,$compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $idcompromiso_rc, $idcompromiso_sh, $idcompromiso_archivo, $comentario_compromiso) {

        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $ayudante = new Ayudante();
        $fecha_compromiso = $ayudante->FechaRevezMysql($fecha_compromiso, "/");
        $fecha_compromiso.=" ".$hora_compromiso.":".$minuto_compromiso.":00";
        
        $fecha_fin_compromiso = $ayudante->FechaRevezMysql($fecha_fin_compromiso, "/");
        $fecha_fin_compromiso.=" ".$hora_fin_compromiso.":".$minuto_fin_compromiso.":00";
        
        $interaccion = $ayudante->caracter($interaccion);
        ///compromiso
         $fecha_a= date('Y-m-d H:i:s');
        $consulta_compromiso = "UPDATE compromiso SET
                            `fecha_a`='$fecha_a',
                            compromiso='$compromiso',
                            fecha='$fecha_compromiso',
                            fecha_fin='$fecha_fin_compromiso',
                            idcompromiso_estado='$idcompromiso_estado',
                            idcompromiso_prioridad='$idcompromiso_prioridad',
                            comentario='$comentario_compromiso'
                                WHERE
                            idcompromiso='$idcompromiso' AND
                            idmodulo_compromiso='$idmodulo_compromiso'";
        //echo $consulta_compromiso;exit;
        if (!$this->sql->consultar($consulta_compromiso, "sgrc")) {

            $error++;
        }
         $consulta_sincronizacion= $ayudante->migracion_update($consulta_compromiso);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        ///echo $consulta_interaccion."<br>";
        /////TAG
        ///LOGICA, SI VIENE CON ***, NECESITO ACTUALIZAR 1 - 0, ESTADOS DE ACTIVO
        //SI VIENE CON --- ES PARA AGREGAR SALVO SI TIENE numeral
        /////RC

        $tama_rc_compromiso = sizeof($idcompromiso_rc);
        $consulta_insert_rc = "";
        if ($tama_rc_compromiso > 0) {

            for ($i = 0; $i < $tama_rc_compromiso; $i++) {
                // echo "veamos ".$idcompromiso_rc[$i];
                if (strpos($idcompromiso_rc[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag

                    $aux_rc = explode("***", $idcompromiso_rc[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_rc = "UPDATE compromiso_rc SET `fecha_a`='$fecha_a',activo=$aux_rc[2] WHERE idcompromiso_rc=$aux_rc[0] AND idmodulo_compromiso_rc=$aux_rc[1] AND activo!=$aux_rc[2]";
                    //echo "<br>".$consulta_update_rc;exit;
                    if (!$this->sql->consultar($consulta_update_rc, "sgrc")) {

                        $error++;
                    }
                     $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_rc);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idcompromiso_rc[$i], "###")) {
                    $aux_rc_compromiso = explode("---", $idcompromiso_rc[$i]);
                    $consulta_insert_rc.="($_SESSION[idmodulo],1,$idcompromiso,$idmodulo_compromiso,$aux_rc_compromiso[0],$aux_rc_compromiso[1],1),";
                }
            }
            //echo $consulta_insert_rc;exit;
            if (strlen($consulta_insert_rc) > 0) {
                $cabecera_consulta_insert_rc = "INSERT INTO
                                  `compromiso_rc`(
                                  `idmodulo_compromiso_rc`,
                                  `activo`,
                                  `idcompromiso`,
                                  `idmodulo_compromiso`,
                                  `idrc`,
                                  `idmodulo`,
                                  principal)
                                VALUES";

                $cabecera_consulta_insert_rc.=$consulta_insert_rc;
                $cabecera_consulta_insert_rc = substr($cabecera_consulta_insert_rc, 0, -1);
                //  echo $cabecera_consulta_insert_rc."<br>";
                if (!$this->sql->consultar($cabecera_consulta_insert_rc, "sgrc")) {
                    //echo $cabecera_consulta_insert_rc."<br>";
                    $error++;
                }
                $idcompromiso_rc = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idcompromiso_rc",$idcompromiso_rc,$cabecera_consulta_insert_rc);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }
        ////SH

        $tama_sh_compromiso = sizeof($idcompromiso_sh);
        $consulta_insert_sh = "";
        if ($tama_sh_compromiso > 0) {


            for ($i = 0; $i < $tama_sh_compromiso; $i++) {

                if (strpos($idcompromiso_sh[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag
                    //echo "bien ".$idcompromiso_sh[$i];


                    $aux_sh = explode("***", $idcompromiso_sh[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_sh = "UPDATE compromiso_sh SET `fecha_a`='$fecha_a',activo=$aux_sh[2] WHERE idcompromiso_sh=$aux_sh[0] AND idmodulo_compromiso_sh=$aux_sh[1] AND activo!=$aux_sh[2]";
                    
                    //echo "consulta_update_sh : ".$consulta_update_sh;
                    
                    if (!$this->sql->consultar($consulta_update_sh, "sgrc")) {

                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_sh);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idcompromiso_sh[$i], "###")) {
                    $aux_sh_compromiso = explode("---", $idcompromiso_sh[$i]);
                    $consulta_insert_sh.="($_SESSION[idmodulo],1,$idcompromiso,$idmodulo_compromiso,$aux_sh_compromiso[0],$aux_sh_compromiso[1],0),";
                }
            }

            if (strlen($consulta_insert_sh) > 0) {
                $cabecera_consulta_insert_sh = "INSERT INTO
                                  `compromiso_sh`(
                                  `idmodulo_compromiso_sh`,
                                  `activo`,
                                  `idcompromiso`,
                                  `idmodulo_compromiso`,
                                  `idsh`,
                                  `idmodulo`,
                                  principal)
                                VALUES";

                $cabecera_consulta_insert_sh.=$consulta_insert_sh;
                $cabecera_consulta_insert_sh = substr($cabecera_consulta_insert_sh, 0, -1);

                if (!$this->sql->consultar($cabecera_consulta_insert_sh, "sgrc")) {
                    $error++;
                }
                 $idcompromiso_sh = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idcompromiso_sh",$idcompromiso_sh,$cabecera_consulta_insert_sh);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }


       ////DOCUMENTO
        
        $tama_compromiso_archivo = sizeof($idcompromiso_archivo);
        
        if ($tama_compromiso_archivo > 0) {


            for ($i = 0; $i < $tama_compromiso_archivo; $i++) {

                if (strpos($idcompromiso_archivo[$i], "***")) {
                  

                    $aux_archivo = explode("***", $idcompromiso_archivo[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_archivo = "UPDATE compromiso_archivo SET `fecha_a`='$fecha_a',activo=$aux_archivo[2] WHERE idcompromiso_archivo=$aux_archivo[0] AND  idmodulo_compromiso_archivo=$aux_archivo[1] AND activo!=$aux_archivo[2]";

                    if (!$this->sql->consultar($consulta_update_archivo, "sgrc")) {

                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_archivo);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } 
            }

        }

        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        // echo $idcompromiso."---".$idmodulo_compromiso."---".$error;exit;
        return $idcompromiso . "---" . $idmodulo_compromiso . "---" . $error;
    }

    function agregar_compromiso($idinteraccion, $idmodulo_interaccion, $fecha_compromiso, $hora_compromiso,$minuto_compromiso,$fecha_fin_compromiso,$hora_fin_compromiso,$minuto_fin_compromiso,$compromiso, $idcompromiso_estado, $idcompromiso_prioridad, $idcompromiso_rc, $idcompromiso_sh, $comentario_compromiso) {

        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $ayudante = new Ayudante();
        $fecha_compromiso = $ayudante->FechaRevezMysql($fecha_compromiso, "/");
        $fecha_compromiso.=" ".$hora_compromiso.":".$minuto_compromiso.":00";
        if( isset($fecha_fin_compromiso) ){
            $fecha_fin_compromiso = $ayudante->FechaRevezMysql($fecha_fin_compromiso, "/");
            $fecha_fin_compromiso.=" ".$hora_fin_compromiso.":".$minuto_fin_compromiso.":00";
        }
        
        $interaccion = $ayudante->caracter($interaccion);

        $consulta_compromiso = "INSERT INTO
          `compromiso`(
          `idmodulo_compromiso`,
          `compromiso`,
          `fecha`,
          `fecha_fin`,
          `activo`,
          `idusu_c`,
          `fecha_c`,
          `idinteraccion`,
          `idmodulo_interaccion`,
          `idcompromiso_prioridad`,
          `idcompromiso_estado`,
           comentario)
        VALUES(
          $_SESSION[idmodulo],
          '$compromiso',
          '$fecha_compromiso',
          '$fecha_fin_compromiso',
          1,
          NULL,
          NULL,
          $idinteraccion,
          $idmodulo_interaccion,
          $idcompromiso_prioridad,
          $idcompromiso_estado,
          '$comentario_compromiso')";


        //echo $consulta_compromiso;exit;
        if (!$this->sql->consultar($consulta_compromiso, "sgrc")) {
            $error++;
        }
        $idcompromiso = $this->sql->idtabla(); //obtener id de la tabla
        $consulta_sincronizacion= $ayudante->migracion_insert("idcompromiso",$idcompromiso,$consulta_compromiso);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }

        
        // echo $idcompromiso_rc;exit;
        if (!is_array($idcompromiso_rc)) {
            $aux_idcompromiso_rc = $idcompromiso_rc;
            $$aux_idcompromiso_rc = null;
            $idcompromiso_rc = array($aux_idcompromiso_rc);

            $tama_idcompromiso_rc = 1;
        } else {

            $tama_idcompromiso_rc = sizeof($idcompromiso_rc);
        }
        //echo $tama_idcompromiso_rc;exit;

        if ($tama_idcompromiso_rc > 0) {

            $consulta_rc = "INSERT INTO
                                  `compromiso_rc`(
                                  `idmodulo_compromiso_rc`,
                                  `activo`,
                                  `idcompromiso`,
                                  `idmodulo_compromiso`,
                                  `idrc`,
                                  `idmodulo`,
                                  principal)
                                VALUES";

            for ($i = 0; $i < $tama_idcompromiso_rc; $i++) {
                $principal = 0;
                if ($tama_idcompromiso_rc == 1) {
                    $principal = 1;
                }



                if (!strpos($idcompromiso_rc[$i], "###")) {
                    $aux_idcompromiso_rc = explode("---", $idcompromiso_rc[$i]); //compuesto
                    if ($idpersona == $aux_idcompromiso_rc[0]) {
                        $principal = 1;
                    }
                    $consulta_rc.="($_SESSION[idmodulo],1,$idcompromiso,$_SESSION[idmodulo],$aux_idcompromiso_rc[0],$aux_idcompromiso_rc[1],$principal),";
                }
            }
            $consulta_rc = substr($consulta_rc, 0, -1);

            //echo "qqq ".$consulta_rc."<br>";exit;
            if (!$this->sql->consultar($consulta_rc, "sgrc")) {
                $error++;
            }
            $idcompromiso_rc = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idcompromiso_rc",$idcompromiso_rc,$consulta_rc);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }  

        //echo $consulta_rc; echo $error;exit;
        //sh
        //principal el de la session, sino el unico

        if (!is_array($idcompromiso_sh)) {
            $aux_idcompromiso_sh = $idcompromiso_sh;
            $tama_idcompromiso_sh = null;
            $idcompromiso_sh = array($aux_idcompromiso_sh);

            $tama_idcompromiso_sh = 1;
        } else {

            $tama_idcompromiso_sh = sizeof($idcompromiso_sh);
        }
        //echo "verrr".$tama_idinteraccion_sh;
        if ($tama_idcompromiso_sh > 0) {

            $consulta_sh = "INSERT INTO
                                  `compromiso_sh`(
                                  `idmodulo_compromiso_sh`,
                                  `activo`,
                                  `idcompromiso`,
                                  `idmodulo_compromiso`,
                                  `idsh`,
                                  `idmodulo`,
                                  principal)
                                VALUES";

            for ($i = 0; $i < $tama_idcompromiso_sh; $i++) {
                $principal = 0;
                if ($tama_idcompromiso_sh == 1) {
                    $principal = 1;
                }
                //vienen varios
                if (!strpos($idcompromiso_sh[$i], "###")) {
                    if ($idpersona == $aux_idcompromiso_sh[0]) {
                        $principal = 1;
                    }
                    $aux_idcompromiso_sh = explode("---", $idcompromiso_sh[$i]);
                    $consulta_sh.="($_SESSION[idmodulo],1,$idcompromiso,$_SESSION[idmodulo],$aux_idcompromiso_sh[0],$aux_idcompromiso_sh[1],$principal),";
                }
            }
            $consulta_sh = substr($consulta_sh, 0, -1);

            if (!$this->sql->consultar($consulta_sh, "sgrc")) {
                $error++;
            }
            $idcompromiso_sh = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idcompromiso_sh",$idcompromiso_sh,$consulta_sh);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            //echo $consulta_sh;
        }
        // echo "errrorr ".$error;exit;
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $idcompromiso . "---" . $_SESSION[idmodulo] . "---" . $error;
    }

    function actualizar_interaccion($idinteraccion, $idmodulo_interaccion, $idinteraccion_complejo_tag, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $idinteraccion_archivo, $comentario_interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $idinteraccion_prioridad, $interaccion, $orden_complejo_tag,$minuto_dura_interaccion) {
        
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $ayudante = new Ayudante();
        $fecha_interaccion = $ayudante->FechaRevezMysql($fecha_interaccion, "/");
        $interaccion = $ayudante->caracter($interaccion);
        
         $fecha_a= date('Y-m-d H:i:s');
        ///INTERACCION
        $consulta_interaccion = "UPDATE interaccion SET
                            `fecha_a`='$fecha_a',                            
                            interaccion='$interaccion',
                            idusu_a=$_SESSION[idusu_a],
                            idmodulo_a=$_SESSION[idmodulo_a],
                            fecha='$fecha_interaccion',
                            idinteraccion_estado='$idinteraccion_estado',
                            idinteraccion_tipo='$idinteraccion_tipo',
                            idinteraccion_prioridad='$idinteraccion_prioridad',
                            comentario='$comentario_interaccion',
                            duracion_minutos='$minuto_dura_interaccion'
                                WHERE
                            idinteraccion='$idinteraccion'
                            AND idmodulo_interaccion='$idmodulo_interaccion' ";

        if (!$this->sql->consultar($consulta_interaccion, "sgrc")) {
           // echo "consulta_interaccion: ".$consulta_interaccion;
            $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($consulta_interaccion);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        ///echo $consulta_interaccion."<br>";
        /////TAG
        ///LOGICA, SI VIENE CON ***, NECESITO ACTUALIZAR 1 - 0, ESTADOS DE ACTIVO
        //SI VIENE CON --- ES PARA AGREGAR SALVO SI TIENE numeral
        //print_r($idinteraccion_complejo_tag);

        $tama_tag_interaccion = sizeof($idinteraccion_complejo_tag);
        $consulta_insert_tag = "";
        if ($tama_tag_interaccion > 0) {

            for ($i = 0; $i < $tama_tag_interaccion; $i++) {
                if (strpos($idinteraccion_complejo_tag[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag
                    $aux_tag = explode("***", $idinteraccion_complejo_tag[$i]);
                    
                    $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_tag = "UPDATE interaccion_tag SET `fecha_a`='$fecha_a', prioridad=$orden_complejo_tag[$i] , activo=$aux_tag[2] WHERE idinteraccion_tag=$aux_tag[0] AND idmodulo_interaccion_tag=$aux_tag[1] ";

                    if (!$this->sql->consultar($consulta_update_tag, "sgrc")) {
                        //echo "consulta_update_tag: ".$consulta_update_tag;
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_tag);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idinteraccion_complejo_tag[$i], "###")) {
                    $aux_tag_interaccion = explode("---", $idinteraccion_complejo_tag[$i]);
                    $consulta_insert_tag.="($_SESSION[idmodulo],1,$idinteraccion,$idmodulo_interaccion,$aux_tag_interaccion[0],$aux_tag_interaccion[1],$orden_complejo_tag[$i]),";
                }
            }

            if (strlen($consulta_insert_tag) > 0) {
                $cabecera_consulta_insert_tag = "INSERT INTO
                              `interaccion_tag`(
                              `idmodulo_interaccion_tag`,
                              `activo`,
                              `idinteraccion`,
                              `idmodulo_interaccion`,
                              `idtag`,
                              `idmodulo_tag`,
                              prioridad)
                            VALUES";

                $cabecera_consulta_insert_tag.=$consulta_insert_tag;
                $cabecera_consulta_insert_tag = substr($cabecera_consulta_insert_tag, 0, -1);

                if (!$this->sql->consultar($cabecera_consulta_insert_tag, "sgrc")) {
                    //echo "cabecera_consulta_insert_tag: ".$cabecera_consulta_insert_tag;
                    $error++;
                }
                $idinteraccion_tag = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idinteraccion_tag",$idinteraccion_tag,$cabecera_consulta_insert_tag);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }

        /////RC

        $tama_rc_interaccion = sizeof($idinteraccion_complejo_rc);
        $consulta_insert_rc = "";
        if ($tama_rc_interaccion > 0) {

            for ($i = 0; $i < $tama_rc_interaccion; $i++) {
                // echo "veamos ".$idinteraccion_complejo_rc[$i];
                if (strpos($idinteraccion_complejo_rc[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag

                    $aux_rc = explode("***", $idinteraccion_complejo_rc[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_rc = "UPDATE interaccion_rc SET `fecha_a`='$fecha_a',activo=$aux_rc[2] WHERE idinteraccion_rc=$aux_rc[0] AND idmodulo_interaccion_rc=$aux_rc[1] AND activo!=$aux_rc[2]";
                    //echo "<br>".$consulta_update_rc;
                    if (!$this->sql->consultar($consulta_update_rc, "sgrc")) {
                        //echo "<br>".$consulta_update_rc;
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_rc);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idinteraccion_complejo_rc[$i], "###")) {
                    $aux_rc_interaccion = explode("---", $idinteraccion_complejo_rc[$i]);
                    $consulta_insert_rc.="($_SESSION[idmodulo],1,$idinteraccion,$idmodulo_interaccion,$aux_rc_interaccion[0],$aux_rc_interaccion[1],1),";
                }
            }
            //echo $consulta_insert_rc;
            if (strlen($consulta_insert_rc) > 0) {
                $cabecera_consulta_insert_rc = "INSERT INTO
                                  `interaccion_rc`(
                                  `idmodulo_interaccion_rc`,
                                  `activo`,
                                  `idinteraccion`,
                                  `idmodulo_interaccion`,
                                  `idrc`,
                                  `idmodulo`,
                                  principal)
                                VALUES";

                $cabecera_consulta_insert_rc.=$consulta_insert_rc;
                $cabecera_consulta_insert_rc = substr($cabecera_consulta_insert_rc, 0, -1);
                //  echo $cabecera_consulta_insert_rc."<br>";
                if (!$this->sql->consultar($cabecera_consulta_insert_rc, "sgrc")) {
                    //echo $cabecera_consulta_insert_rc."<br>";
                    $error++;
                }
                $idinteraccion_rc = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idinteraccion_rc",$idinteraccion_rc,$cabecera_consulta_insert_rc);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }
        ////SH

        $tama_sh_interaccion = sizeof($idinteraccion_complejo_sh);
        $consulta_insert_sh = "";
        if ($tama_sh_interaccion > 0) {


            for ($i = 0; $i < $tama_sh_interaccion; $i++) {

                if (strpos($idinteraccion_complejo_sh[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag
                    //echo "bien ".$idinteraccion_complejo_sh[$i];


                    $aux_sh = explode("***", $idinteraccion_complejo_sh[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_sh = "UPDATE interaccion_sh SET activo=$aux_sh[2] WHERE idinteraccion_sh=$aux_sh[0] AND  idmodulo_interaccion_sh=$aux_sh[1] AND activo!=$aux_sh[2]";
                    
                    if (!$this->sql->consultar($consulta_update_sh, "sgrc")) {

                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_sh);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idinteraccion_complejo_sh[$i], "###")) {
                    $aux_sh_interaccion = explode("---", $idinteraccion_complejo_sh[$i]);
                    $consulta_insert_sh.="($_SESSION[idmodulo],1,$idinteraccion,$idmodulo_interaccion,$aux_sh_interaccion[0],$aux_sh_interaccion[1],0),";
                }
            }

            if (strlen($consulta_insert_sh) > 0) {
                $cabecera_consulta_insert_sh = "INSERT INTO
                                  `interaccion_sh`(
                                  `idmodulo_interaccion_sh`,
                                  `activo`,
                                  `idinteraccion`,
                                  `idmodulo_interaccion`,
                                  `idsh`,
                                  `idmodulo`,
                                  principal)
                                VALUES";

                $cabecera_consulta_insert_sh.=$consulta_insert_sh;
                $cabecera_consulta_insert_sh = substr($cabecera_consulta_insert_sh, 0, -1);
                
                //echo "cabecera_consulta_insert_sh: ".$cabecera_consulta_insert_sh;

                if (!$this->sql->consultar($cabecera_consulta_insert_sh, "sgrc")) {
                    //echo "cabecera_consulta_insert_sh: ".$cabecera_consulta_insert_sh;
                    $error++;
                }
                $idinteraccion_sh = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idinteraccion_sh",$idinteraccion_sh,$cabecera_consulta_insert_sh);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }


        ////DOCUMENTO
        
        $tama_interaccion_archivo = sizeof($idinteraccion_archivo);
        
        if ($tama_interaccion_archivo > 0) {


            for ($i = 0; $i < $tama_interaccion_archivo; $i++) {

                if (strpos($idinteraccion_archivo[$i], "***")) {
                  

                    $aux_archivo = explode("***", $idinteraccion_archivo[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_archivo = "UPDATE interaccion_archivo SET `fecha_a`='$fecha_a',activo=$aux_archivo[2] WHERE idinteraccion_archivo=$aux_archivo[0] AND  idmodulo_interaccion_archivo=$aux_archivo[1] AND activo!=$aux_archivo[2]";
                    //echo $consulta_update_archivo;
                    if (!$this->sql->consultar($consulta_update_archivo, "sgrc")) {

                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_archivo);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } 
            }

        }


        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $idinteraccion . "---" . $idmodulo_interaccion ."---". $error;
    }

    function eliminar_interaccion($idinteraccion, $idmodulo_interaccion) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $consulta = "SELECT *
                   FROM compromiso
                   WHERE
                   idinteraccion=$idinteraccion
                   AND
                   idmodulo_interaccion=$idmodulo_interaccion
                   AND
                   activo=1";

        $result = $this->sql->consultar($consulta, "sgrc");

        $cantidad = mysql_num_rows($result);

        if ($cantidad == 0) {
            
             $fecha_a= date('Y-m-d H:i:s');

            $consulta = "UPDATE interaccion
                       SET activo=0
                       WHERE
                       idinteraccion=$idinteraccion
                       AND
                       idmodulo_interaccion=$idmodulo_interaccion
                       AND
                       activo=1";
            //echo "consulta_interaccion: ".$consulta;

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
            
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
             $fecha_a= date('Y-m-d H:i:s');
            
            $consulta = "UPDATE interaccion_rc
                       SET `fecha_a`='$fecha_a',activo=0
                       WHERE
                       idinteraccion=$idinteraccion
                       AND
                       idmodulo_interaccion=$idmodulo_interaccion
                       AND
                       activo=1";
            //echo "consulta_interaccion: ".$consulta;

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
            
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
            $fecha_a= date('Y-m-d H:i:s');
            
            $consulta = "UPDATE interaccion_sh
                       SET `fecha_a`='$fecha_a',activo=0
                       WHERE
                       idinteraccion=$idinteraccion
                       AND
                       idmodulo_interaccion=$idmodulo_interaccion
                       AND
                       activo=1";
            //echo "consulta_interaccion: ".$consulta;

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
            
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
            $fecha_a= date('Y-m-d H:i:s');
            
            $consulta = "UPDATE interaccion_tag
                       SET `fecha_a`='$fecha_a',activo=0
                       WHERE
                       idinteraccion=$idinteraccion
                       AND
                       idmodulo_interaccion=$idmodulo_interaccion
                       AND
                       activo=1";
            //echo "consulta_interaccion: ".$consulta;

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
            
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }

            if ($error == 0) {
                $this->sql->consultar("COMMIT", "sgrc");
            } else {
                $this->sql->consultar("ROLLBACK", "sgrc");
            }
        }

        $respuesta = array();
        $respuesta[] = $error;
        $respuesta[] = $cantidad;

        return $respuesta;
    }

    function agregar_interaccion($idpersona, $idmodulo, $interaccion, $fecha_interaccion, $idinteraccion_estado, $idinteraccion_tipo, $atag_interaccion, $idinteraccion_prioridad, $idinteraccion_complejo_rc, $idinteraccion_complejo_sh, $comentario_interaccion,$orden_complejo_tag,$idpredio,$idmodulo_predio,$minuto_dura_interaccion) {
        
        //echo "comentario_interaccion: ".$comentario_interaccion;
        // echo $idinteraccion_sh."<br>";
        //  echo $idinteraccion_rc;exit();
        //$idinteraccion="",$idmodulo_interaccion=""
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        if ($idinteraccion_estado == "") {
            $idinteraccion_estado = 1;
        }
        if ($idinteraccion_tipo == "") {

            $idinteraccion_tipo = 1;
        }

        $ayudante = new Ayudante();
        $fecha_interaccion = $ayudante->FechaRevezMysql($fecha_interaccion, "/");
        $interaccion = $ayudante->caracter($interaccion);
        //echo $interaccion;
        if($idpredio==""){
            $idpredio='NULL';
            $idmodulo_predio='NULL';
        }
        $fecha_c = date('Y-m-d');
        
        $consulta_interaccion = "INSERT INTO
              `interaccion`(
              `idmodulo_interaccion`,
              `interaccion`,
              `fecha`,
              `idinteraccion_estado`,
              `idinteraccion_tipo`,
              `activo`,
              `idusu_c`,
              `idmodulo_c`,
              `fecha_c`,
               interaccion.idinteraccion_prioridad,
               comentario,
               idpredio,
               idmodulo_predio,
               duracion_minutos)
            VALUES(
              $_SESSION[idmodulo],
              '$interaccion',
              '$fecha_interaccion',
              $idinteraccion_estado,
              $idinteraccion_tipo,
              1,
              $_SESSION[idusu_c],
              $_SESSION[idmodulo_c],
              '$fecha_c',
              $idinteraccion_prioridad,
              '$comentario_interaccion',$idpredio,$idmodulo_predio,
               '$minuto_dura_interaccion')";

      // echo "consulta_interaccion: " . $consulta_interaccion;

        if (!$this->sql->consultar($consulta_interaccion, "sgrc")) {
            $error++;
            echo $consulta_interaccion;
            echo $error;
        }
        
        $idinteraccion = $this->sql->idtabla(); //obtener id de la tabla
        $consulta_sincronizacion= $ayudante->migracion_insert("idinteraccion",$idinteraccion,$consulta_interaccion);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        //tag_interaccion
        $tama_tag_interaccion = sizeof($atag_interaccion);
        if ($tama_tag_interaccion > 0) {

            $consulta_tag_interaccion = "INSERT INTO
                                  `interaccion_tag`(
                                  `idmodulo_interaccion_tag`,
                                  `activo`,
                                  `idinteraccion`,
                                  `idmodulo_interaccion`,
                                  `idtag`,
                                  `idmodulo_tag`,
                                  prioridad)
                                VALUES";

            for ($i = 0; $i < $tama_tag_interaccion; $i++) {
                if (!strpos($tama_tag_interaccion[$i], "###")) {

                    $aux_tag_interaccion = explode("---", $atag_interaccion[$i]);

                    $consulta_tag_interaccion.="($_SESSION[idmodulo],1,$idinteraccion,$_SESSION[idmodulo],$aux_tag_interaccion[0],$aux_tag_interaccion[1],$orden_complejo_tag[$i]),";
                }
            }
            $consulta_tag_interaccion = substr($consulta_tag_interaccion, 0, -1);
            


            if (!$this->sql->consultar($consulta_tag_interaccion, "sgrc")) {
                $error++;
                //echo "consulta_tag_interaccion: " . $consulta_tag_interaccion;
            }
            
            $idinteraccion_tag = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idinteraccion_tag",$idinteraccion_tag,$consulta_tag_interaccion);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            //echo $consulta_tag_interaccion;exit;
        }

        //echo $consulta_tag_interaccion;echo $error;exit;
        //rc
        //print_r($idinteraccion_complejo_rc);exit;
        if (!is_array($idinteraccion_complejo_rc)) {
            $aux_idinteraccion_rc = $idinteraccion_complejo_rc;
            $idinteraccion_complejo_rc = null;
            $idinteraccion_complejo_rc = array($aux_idinteraccion_rc);

            $tama_idinteraccion_rc = 1;
        } else {

            $tama_idinteraccion_rc = sizeof($idinteraccion_complejo_rc);
        }

        if ($tama_idinteraccion_rc > 0) {

            #########################
            #########################

            $consulta_rc = "INSERT INTO
                                  `interaccion_rc`(
                                    `idmodulo_interaccion_rc`,
                                  `activo`,
                                  `idinteraccion`,
                                  `idmodulo_interaccion`,
                                  `idrc`,
                                  `idmodulo`,
                                  principal)
                                VALUES";



            for ($i = 0; $i < $tama_idinteraccion_rc; $i++) {
                $principal = 0;
                if ($tama_idinteraccion_rc == 1) {
                    $principal = 1;
                }

                if (!strpos($idinteraccion_complejo_rc[$i], "###")) {
                    $aux_idinteraccion_rc = explode("---", $idinteraccion_complejo_rc[$i]); //compuesto
                    if ($idpersona == $aux_idinteraccion_rc[0]) {
                        $principal = 1;
                    }
                    $consulta_rc.="($_SESSION[idmodulo],1,$idinteraccion,$_SESSION[idmodulo],$aux_idinteraccion_rc[0],$aux_idinteraccion_rc[1],$principal),";
                }
            }
            $consulta_rc = substr($consulta_rc, 0, -1);
            
            //echo "consulta_rc: " . $consulta_rc;


            if (!$this->sql->consultar($consulta_rc, "sgrc")) {
                //echo "consulta_rc: " . $consulta_rc;
                $error++;
            }
            
            $idinteraccion_rc = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idinteraccion_rc",$idinteraccion_rc,$consulta_rc);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }

        //echo $consulta_rc; 
        //echo $error;exit;
        //sh
        //principal el de la session, sino el unico
        if ( isset($idinteraccion_complejo_sh) && !is_array($idinteraccion_complejo_sh)) {
            
            $aux_idinteraccion_sh = $idinteraccion_complejo_sh;
            $tama_idinteraccion_sh = null;
            $idinteraccion_complejo_sh = array($aux_idinteraccion_sh);

            $tama_idinteraccion_sh = 1;
             
            
        } else {

            $tama_idinteraccion_sh = sizeof($idinteraccion_complejo_sh);
        }
        //echo "verrr".$tama_idinteraccion_sh;
        if ($tama_idinteraccion_sh > 0) {

            $consulta_sh = "INSERT INTO
                                  `interaccion_sh`(
                                   `idmodulo_interaccion_sh`,
                                  `activo`,
                                  `idinteraccion`,
                                  `idmodulo_interaccion`,
                                  `idsh`,
                                  `idmodulo`,
                                  principal)
                                VALUES";

            for ($i = 0; $i < $tama_idinteraccion_sh; $i++) {
                $principal = 0;
                /*
                if ($tama_idinteraccion_sh == 1) {
                    $principal = 1;
                }
                 * 
                 */
                 if ($i == 0) {
                    $principal = 1;
                 }
                //vienen varios
                if (!strpos($idinteraccion_complejo_sh[$i], "###")) {
                    $aux_idinteraccion_sh = explode("---", $idinteraccion_complejo_sh[$i]);
                    if ($idpersona == $aux_idinteraccion_sh[0]) {
                        $principal = 1;
                    }
                    $consulta_sh.="($_SESSION[idmodulo],1,$idinteraccion,$_SESSION[idmodulo],$aux_idinteraccion_sh[0],$aux_idinteraccion_sh[1],$principal),";
                }
            }
            $consulta_sh = substr($consulta_sh, 0, -1);

            if (!$this->sql->consultar($consulta_sh, "sgrc")) {
                //echo "consulta_sh: " . $consulta_sh;
                $error++;
            }
            
            $idinteraccion_sh = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idinteraccion_sh",$idinteraccion_sh,$consulta_sh);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }
        //   exit;
    //echo $error;
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
          
        return $idinteraccion . "---" .$_SESSION[idmodulo]."---" . $error;
    }
    
    function agregar_archivo_interaccion( $idinteraccion, $idmodulo_interaccion, $archivos ) {
       
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        
        $fecha_c = date('Y-m-d H:i:s');

        $ayudante = new Ayudante();
     
        
        if( isset($archivos) && is_array($archivos) && count($archivos)>0 ){
            
            $consulta_archivo = "INSERT INTO interaccion_archivo(
                                idmodulo_interaccion_archivo,archivo,comentario,
                                idinteraccion,idmodulo_interaccion,
                                activo, idusu, idmodulo,
                                fecha_c) 
                                VALUES ";
            
            foreach ( $archivos as $archivo ){
                $consulta_archivo .= "(
                                $_SESSION[idmodulo],'$archivo','',
                                $idinteraccion,$idmodulo_interaccion,
                                1,$_SESSION[idusuario],$_SESSION[idmodulo_a],
                                '$fecha_c') ,";
            
            }
            
            
            $consulta_archivo = substr($consulta_archivo, 0, -1);

            if (!$this->sql->consultar($consulta_archivo, "sgrc")) {
                    //echo "consulta_archivo: " . $consulta_archivo;
                    $error++;
            }else{
                $idinteraccion_archivo = $this->sql->idtabla(); //obtener id de la tabla
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idinteraccion_archivo",$idinteraccion_archivo,$consulta_archivo);

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

        return $error;
    }
    
     function agregar_archivo_compromiso( $idcompromiso,$idmodulo_compromiso, $archivos ) {
       
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
       
        $fecha_c = date('Y-m-d H:i:s');

        $ayudante = new Ayudante();
     
        
        if( isset($archivos) && is_array($archivos) && count($archivos)>0 ){
            
            $consulta_archivo = "INSERT INTO compromiso_archivo(
                                idmodulo_compromiso_archivo,archivo,comentario,
                                idcompromiso,idmodulo_compromiso,
                                activo, idusu, idmodulo_a,
                                fecha_c) 
                                VALUES ";
            
            foreach ( $archivos as $archivo ){
                $consulta_archivo .= "(
                                $_SESSION[idmodulo],'$archivo','',
                                $idcompromiso,$idmodulo_compromiso,
                                1,$_SESSION[idusuario],$_SESSION[idmodulo_a],
                                '$fecha_c') ,";
            
            }
            
            
            $consulta_archivo = substr($consulta_archivo, 0, -1);

            if (!$this->sql->consultar($consulta_archivo, "sgrc")) {
                    echo "consulta_archivo: " . $consulta_archivo;
                    $error++;
            }else{
                $idcompromiso_archivo = $this->sql->idtabla(); //obtener id de la tabla
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idcompromiso_archivo",$idcompromiso_archivo,$consulta_archivo);

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

        return $error;
    }
    
    function agregar_archivo_predio( $idpredio, $archivos ) {
       
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        
        $fecha_c = date('Y-m-d H:i:s');

        $ayudante = new Ayudante();
     
        
        if( isset($archivos) && is_array($archivos) && count($archivos)>0 ){
            
            $consulta_archivo = "INSERT INTO predio_archivo(
                                idmodulo_predio_archivo,archivo,
                                idpredio,
                                activo) 
                                VALUES ";
            
            foreach ( $archivos as $archivo ){
                $consulta_archivo .= "(
                                $_SESSION[idmodulo],'$archivo',
                                $idpredio,
                                1) ,";
            
            }
            
            
            $consulta_archivo = substr($consulta_archivo, 0, -1);

            if (!$this->sql->consultar($consulta_archivo, "sgrc")) {
                    //echo "consulta_archivo: " . $consulta_archivo;
                    $error++;
            }else{
                $idpredio_archivo = $this->sql->idtabla(); //obtener id de la tabla
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpredio_archivo",$idpredio_archivo,$consulta_archivo);

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

        return $error;
    }

    function eliminar_red($idpersona_red_stakeholder, $idmodulo_persona_red) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        //$consulta="DELETE FROM persona_red WHERE idred=$idpersona_red_stakeholder";
        
         $fecha_a= date('Y-m-d H:i:s');
         
        $consulta = "UPDATE persona_red
                    SET `fecha_a`='$fecha_a', activo='0'
                    WHERE
                    idred=$idpersona_red_stakeholder
                    AND
                    idmodulo_persona_red=$idmodulo_persona_red";


        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
        }
        
         $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }

        $consulta = "SELECT
                        idpersona,
                        idmodulo,
                        idpersona_red,
                        idmodulo_red
                    FROM
                        persona_red
                    WHERE
                        idred=$idpersona_red_stakeholder
                    AND
                        idmodulo_persona_red=$idmodulo_persona_red";

        //echo $consulta;

        $result = $this->sql->consultar($consulta, "sgrc");

        if ($fila = mysql_fetch_array($result)) {
            $idpersona = $fila[idpersona];
            $idmodulo = $fila[idmodulo];
            $idpersona_red = $fila[idpersona_red];
            $idmodulo_red = $fila[idmodulo_red];
            
            $fecha_a= date('Y-m-d H:i:s');

            $consulta = "UPDATE persona_red
                    SET `fecha_a`='$fecha_a',activo='0'
                    WHERE
                        idmodulo_persona_red=$idmodulo_persona_red
                    AND
                        idpersona=$idpersona_red
                    AND
                        idmodulo=$idmodulo_red
                    AND
                        idpersona_red=$idpersona
                    AND
                        idmodulo_red=$idmodulo
                    AND
                        activo=1";

            //echo $consulta;
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

    function agregar_red($idpersona, $idmodulo, $idpersona_red, $idmodulo_red, $idmodulo_a) {
        
        $ayudante = new Ayudante();
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;

        $consulta = "SELECT COUNT(*) as 'cantidad'
                    FROM persona_red
                    WHERE
                    idpersona=$idpersona
                    AND
                       idmodulo=$idmodulo
                    AND
                    idpersona_red=$idpersona_red
                    AND
                    idmodulo_red=$idmodulo_red
                    AND
                    idmodulo_a=$idmodulo_a
                    AND
                    activo=1";

        $result = $this->sql->consultar($consulta, "sgrc");

        if ($fila = mysql_fetch_array($result)) {
            $error = $fila[cantidad];
        }

        if ($error == 0) {

            $consulta = "INSERT INTO
              `persona_red`(
              `idpersona`,
              `idmodulo_persona_red`,
              `idmodulo`,
              `idpersona_red`,
              `idmodulo_red`,
              `activo`,
              `idmodulo_a`)
            VALUES(
              $idpersona,
              $_SESSION[idmodulo],
              $idmodulo,
              $idpersona_red,
              $idmodulo_red,
              1,
              $idmodulo_a)";


            if (!$this->sql->consultar($consulta, "sgrc")) {
                $error++;
                echo $consulta;
            }
            
            $idred = $this->sql->idtabla();
      
            $consulta_sincronizacion= $ayudante->migracion_insert("idred",$idred,$consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }

            $consulta = "INSERT INTO
              `persona_red`(
              `idpersona`,
              `idmodulo_persona_red`,
              `idmodulo`,
              `idpersona_red`,
              `idmodulo_red`,
              `activo`,
              `idmodulo_a`)
            VALUES(
              $idpersona_red,
              $_SESSION[idmodulo],
              $idmodulo_red,
              $idpersona,
              $idmodulo,
              1,
              $idmodulo_a)";


            if (!$this->sql->consultar($consulta, "sgrc")) {
                $error++;
                echo $consulta;
            }
            
            $idred = $this->sql->idtabla();
      
            $consulta_sincronizacion= $ayudante->migracion_insert("idred",$idred,$consulta);

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
    
    function agregar_predio($idpersona, $idmodulo, $idpredio,$idmodulo_predio, $idmodulo_predio_sh) {
        //la estoy utilizando
        $ayudante = new Ayudante();
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        /*                    AND
                    idmodulo_predio_sh=$idmodulo_predio_sh*/
        $consulta = "SELECT COUNT(*) as 'cantidad'
                    FROM predio_sh
                    WHERE
                    idsh=$idpersona
                    AND
                    idmodulo=$idmodulo
                    AND
                    idpredio=$idpredio  
                    AND                  
                    idmodulo_predio=$idmodulo_predio
                    AND
                    activo=1";

        $result = $this->sql->consultar($consulta, "sgrc");

        if ($fila = mysql_fetch_array($result)) {
            $error = $fila[cantidad];
        }

        if ($error == 0) {
            
            $consulta = "INSERT INTO
              `predio_sh`(
              `idsh`,
              `idmodulo_predio_sh`,
              `idmodulo`,
              `idpredio`,
              idmodulo_predio,
              `activo`)
            VALUES(
              $idpersona,
              $idmodulo_predio_sh,
              $idmodulo,
              $idpredio,
              $idmodulo_predio,
              1)";
           

            if (!$this->sql->consultar($consulta, "sgrc")) {
                $error++;
                
            }
            
            $idpredio = $this->sql->idtabla();
      
            $consulta_sincronizacion= $ayudante->migracion_insert("idpredio",$idpredio,$consulta);

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


    function agregar_tag($idtag, $idmodulo_tag, $idpersona, $idmodulo) {
        $ayudante = new Ayudante();
        //$email=array_filter($email);
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $consulta = "SELECT COUNT(*) as 'cantidad'
                   FROM persona_tag
                   WHERE
                   idtag=$idtag
                   AND
                   idmodulo_tag=$idmodulo_tag
                   AND
                   idpersona=$idpersona
                   AND
                   idmodulo=$idmodulo
                   AND activo=1";
        //   echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");

        if ($fila = mysql_fetch_array($result)) {
            //echo "cantidad" . $fila[cantidad];
            if ($fila[cantidad] == 0) {
                $consulta = "INSERT INTO
                      `persona_tag`(
                      `idmodulo_persona_tag`,
                      `activo`,
                      `idpersona`,
                      `idmodulo`,
                      `idtag`,
                      `idmodulo_tag`,
                      `idmodulo_a`)
                    VALUES(
                      $_SESSION[idmodulo],
                      '1',
                      $idpersona,
                      $idmodulo,
                      $idtag,
                      $idmodulo_tag,
                      $_SESSION[idmodulo_a])";
                // echo $consulta;
                if (!$this->sql->consultar($consulta, "sgrc")) {
                    $error++;
                }
                $idpersona_tag = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert("idpersona_tag",$idpersona_tag,$consulta);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            } else {
                $error++;
            }
        } else {
            $error++;
        }



        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $error;
        //return $consulta;
    }
    
     function agregar_tag_complejo($idstakeholder_complejo_tag, $orden_complejo_tag, $idpersona, $idmodulo) {
        $ayudante = new Ayudante();
        //$email=array_filter($email);
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        $tama_tag_stakeholder = sizeof($idstakeholder_complejo_tag);
        $consulta_insert_tag = "";
        if ($tama_tag_stakeholder > 0) {

            for ($i = 0; $i < $tama_tag_stakeholder; $i++) {
                if (strpos($idstakeholder_complejo_tag[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag
                    $aux_tag = explode("***", $idstakeholder_complejo_tag[$i]);
                    
                    $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_tag = "UPDATE persona_tag SET `fecha_a`='$fecha_a', prioridad=$orden_complejo_tag[$i] , activo=$aux_tag[2] WHERE idpersona_tag=$aux_tag[0] AND idmodulo_persona_tag=$aux_tag[1] ";

                    if (!$this->sql->consultar($consulta_update_tag, "sgrc")) {
                        //echo "consulta_update_tag: ".$consulta_update_tag;
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_tag);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idstakeholder_complejo_tag[$i], "###")) {
                    $aux_tag_stakeholder = explode("---", $idstakeholder_complejo_tag[$i]);
                    $consulta_insert_tag.="($_SESSION[idmodulo],1,$idpersona,$idmodulo,$aux_tag_stakeholder[0],$aux_tag_stakeholder[1],$orden_complejo_tag[$i]),";
                }
            }

            if (strlen($consulta_insert_tag) > 0) {
                $cabecera_consulta_insert_tag = "INSERT INTO
                              `persona_tag`(
                              `idmodulo_persona_tag`,
                              `activo`,
                              `idpersona`,
                              `idmodulo`,
                              `idtag`,
                              `idmodulo_tag`,
                              prioridad)
                            VALUES";

                $cabecera_consulta_insert_tag.=$consulta_insert_tag;
                $cabecera_consulta_insert_tag = substr($cabecera_consulta_insert_tag, 0, -1);

                if (!$this->sql->consultar($cabecera_consulta_insert_tag, "sgrc")) {
                    //echo "cabecera_consulta_insert_tag: ".$cabecera_consulta_insert_tag;
                    $error++;
                }
                $idpersona_tag = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpersona_tag",$idpersona_tag,$cabecera_consulta_insert_tag);

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

        return $error;
        //return $consulta;
    }

    function eliminar_tag($idtag_persona, $idmodulo_persona_tag) {
        ///////////////////////////////////////////////////
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $fecha_a= date('Y-m-d H:i:s');
        $consulta = "UPDATE persona_tag
        SET `fecha_a`='$fecha_a',activo=0
        WHERE idpersona_tag=$idtag_persona
        AND idmodulo_persona_tag=$idmodulo_persona_tag";

        //echo $consulta;
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

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
    
    function actualizar_predio($idpredio,$idmodulo_predio ,$comentario_predio,$idpredio_archivo,$idpredio_complejo_tag, $orden_complejo_tag){
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $ayudante = new Ayudante();
        
        
         $fecha_a= date('Y-m-d H:i:s');
        ///predio
        $consulta = "UPDATE predio SET
                            
                            comentario='$comentario_predio'
                                WHERE
                            idpredio='$idpredio' ANd idmodulo_predio='$idmodulo_predio'
                             ";
        //echo "consulta_interaccion: ".$consulta;
        if (!$this->sql->consultar($consulta, "sgrc")) {
            
            $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
        
        ////DOCUMENTO
        
        $tama_predio_archivo = sizeof($idpredio_archivo);
        
        if ($tama_predio_archivo > 0) {


            for ($i = 0; $i < $tama_predio_archivo; $i++) {

                if (strpos($idpredio_archivo[$i], "***")) {
                  

                    $aux_archivo = explode("***", $idpredio_archivo[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_archivo = "UPDATE predio_archivo SET activo=$aux_archivo[2] WHERE idpredio_archivo=$aux_archivo[0] AND  idmodulo_predio_archivo=$aux_archivo[1] AND activo!=$aux_archivo[2]";

                    if (!$this->sql->consultar($consulta_update_archivo, "sgrc")) {
                        echo $consulta_update_archivo;
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_archivo);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } 
            }

        }
        
        
        $tama_tag_predio = sizeof($idpredio_complejo_tag);
        $consulta_insert_tag = "";
        if ($tama_tag_predio > 0) {

            for ($i = 0; $i < $tama_tag_predio; $i++) {
                if (strpos($idpredio_complejo_tag[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag
                    $aux_tag = explode("***", $idpredio_complejo_tag[$i]);
                    
                    $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_tag = "UPDATE predio_tag SET `fecha_a`='$fecha_a', prioridad=$orden_complejo_tag[$i] , activo=$aux_tag[2] WHERE idpredio_tag=$aux_tag[0] AND idmodulo_predio_tag=$aux_tag[1] ";

                    if (!$this->sql->consultar($consulta_update_tag, "sgrc")) {
                        //echo "consulta_update_tag: ".$consulta_update_tag;
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_tag);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idpredio_complejo_tag[$i], "###")) {
                    $aux_tag_predio = explode("---", $idpredio_complejo_tag[$i]);
                    $consulta_insert_tag.="($_SESSION[idmodulo],1,$idpredio,$idmodulo_predio,$aux_tag_predio[0],$aux_tag_predio[1],$orden_complejo_tag[$i]),";
                }
            }

            if (strlen($consulta_insert_tag) > 0) {
                $cabecera_consulta_insert_tag = "INSERT INTO
                              `predio_tag`(
                              `idmodulo_predio_tag`,
                              `activo`,
                              `idpredio`, 
                              idmodulo_predio,
                              `idtag`,
                              `idmodulo_tag`,
                              prioridad)
                            VALUES";

                $cabecera_consulta_insert_tag.=$consulta_insert_tag;
                $cabecera_consulta_insert_tag = substr($cabecera_consulta_insert_tag, 0, -1);

                if (!$this->sql->consultar($cabecera_consulta_insert_tag, "sgrc")) {
                    echo "cabecera_consulta_insert_tag: ".$cabecera_consulta_insert_tag;
                    $error++;
                }
                $idpredio_tag = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpredio_tag",$idpredio_tag,$cabecera_consulta_insert_tag);

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

        return $idpredio . "---" . $error;
    }
    

}

?>