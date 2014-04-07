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
class greclamo {

    //put your code here
    function greclamo() {           
        $this->sql = new DmpSql();
    }
           
    function agregar($idpersona, $idmodulo, $reclamo, $fecha_reclamo, $idreclamo_tipo, $atag_reclamo, $idreclamo_rc,  $idreclamo_complejo_sh,  $idreclamo_complejo_rc,$fecha_complejo, $comentario_reclamo, $evaluacion, $radio_evaluacion, $idreclamo_previo) {
        
        //echo "comentario_reclamo: ".$comentario_reclamo;
        // echo $idreclamo_sh."<br>";
        //  echo $idreclamo_rc;exit();
        //$idreclamo="",$idmodulo_reclamo=""
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        if ($idreclamo_tipo == "") {

            $idreclamo_tipo = 1;
        }
        
        if(isset($idreclamo_previo)){
            $aux = split("-", $idreclamo_previo);
            $idreclamo_previo=$aux[0];
            $idmodulo_reclamo_previo=$aux[1];
        }else{
            $idreclamo_previo=0;
            $idmodulo_reclamo_previo=0;                        
        }

        $ayudante = new Ayudante();
        $fecha_reclamo= $ayudante->FechaRevezMysql($fecha_reclamo, "/");
        $reclamo= $ayudante->caracter($reclamo);
        
        $consulta_reclamo = "INSERT INTO
              `reclamo`(
              `idmodulo_reclamo`,
              `reclamo`,
              `fecha`,              
              `idreclamo_tipo`,
              `activo`,
              `idusu_c`,              
              `idmodulo_c`,
               comentario,
               idreclamo_estado,
               idreclamo_previo,
               idmodulo_reclamo_previo,
               idfase,
               fecha_fase)
            VALUES(
              $_SESSION[idmodulo],
              '$reclamo',
              '$fecha_reclamo',              
              $idreclamo_tipo,
              1,
              $_SESSION[idusu_c],            
              $_SESSION[idmodulo_c],            
              '$comentario_reclamo',
                  1,
              $idreclamo_previo,
              $idmodulo_reclamo_previo,
                  1,
              '$fecha_reclamo')";

        

        if (!$this->sql->consultar($consulta_reclamo, "sgrc")) {
            $error++;
            //echo "consulta_reclamo: " . $consulta_reclamo;
        }
        
        $idreclamo = $this->sql->idtabla(); //obtener id de la tabla
        $consulta_sincronizacion= $ayudante->migracion_insert("idreclamo",$idreclamo,$consulta_reclamo);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        //tag_reclamo
        $tama_tag_reclamo = sizeof($atag_reclamo);
        if ($tama_tag_reclamo > 0) {

            $consulta_tag_reclamo = "INSERT INTO
                                  `reclamo_tag`(
                                  `idmodulo_reclamo_tag`,
                                  `activo`,
                                  `idreclamo`,
                                  `idmodulo_reclamo`,
                                  `idtag`,
                                  `idmodulo_tag`)
                                VALUES";

            for ($i = 0; $i < $tama_tag_reclamo; $i++) {
                if (!strpos($tama_tag_recalamo[$i], "###")) {

                    $aux_tag_reclamo = explode("---", $atag_reclamo[$i]);

                    $consulta_tag_reclamo.="($_SESSION[idmodulo],1,$idreclamo,$_SESSION[idmodulo],$aux_tag_reclamo[0],$aux_tag_reclamo[1]),";
                }
            }
            $consulta_tag_reclamo = substr($consulta_tag_reclamo, 0, -1);
            


            if (!$this->sql->consultar($consulta_tag_reclamo, "sgrc")) {
                $error++;
                //echo "consulta_tag_reclamo: " . $consulta_tag_reclamo;
            }
            
            $idreclamo_tag = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idreclamo_tag",$idreclamo_tag,$consulta_tag_reclamo);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            //echo $consulta_tag_reclamo;exit;
        }

        

        //echo $consulta_rc; 
        //echo $error;exit;
        //sh
        //principal el de la session, sino el unico
        if ( isset($idreclamo_complejo_sh) && !is_array($idreclamo_complejo_sh)) {
            
            $aux_idreclamo_sh = $idreclamo_complejo_sh;
            $tama_idreclamo_sh = null;
            $idreclamo_complejo_sh = array($aux_idreclamo_sh);

            $tama_idreclamo_sh = 1;
             
            
        } else {

            $tama_idreclamo_sh = sizeof($idreclamo_complejo_sh);
        }
        //echo "verrr".$tama_idreclamo_sh;
        if ($tama_idreclamo_sh > 0) {

            $consulta_sh = "INSERT INTO
                                  `reclamo_sh`(
                                   `idmodulo_reclamo_sh`,
                                  `activo`,
                                  `idreclamo`,
                                  `idmodulo_reclamo`,
                                  `idsh`,
                                  `idmodulo`)
                                VALUES";

            for ($i = 0; $i < $tama_idreclamo_sh; $i++) {
                
                //vienen varios
                if (!strpos($idreclamo_complejo_sh[$i], "###")) {
                    $aux_idreclamo_sh = explode("---", $idreclamo_complejo_sh[$i]);
                   
                    $consulta_sh.="($_SESSION[idmodulo],1,$idreclamo,$_SESSION[idmodulo],$aux_idreclamo_sh[0],$aux_idreclamo_sh[1]),";
                }
            }
            $consulta_sh = substr($consulta_sh, 0, -1);

            if (!$this->sql->consultar($consulta_sh, "sgrc")) {
                //echo "consulta_sh: " . $consulta_sh;
                $error++;
            }
            
            $idreclamo_sh = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idreclamo_sh",$idreclamo_sh,$consulta_sh);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }
        //   exit;
        
        
        if ( isset($idreclamo_rc) && !is_array($idreclamo_rc)   ) {
            
            $aux_idreclamo_rc = $idreclamo_rc;
            $tama_idreclamo_rc = null;
            $idreclamo_rc = array($aux_idreclamo_rc);

            $tama_idreclamo_rc = 1;
             
            
        } else {

            $tama_idreclamo_rc = sizeof($idreclamo_rc);
        }
        //echo "verrr".$tama_idreclamo_sh;
        if ($tama_idreclamo_rc > 0) {

            $consulta_rc = "INSERT INTO
                                  `reclamo_rc`(
                                   `idmodulo_reclamo_rc`,
                                  `activo`,
                                  `idreclamo`,
                                  `idmodulo_reclamo`,
                                  `idrc`,
                                  `idmodulo`,
                                  `idrol`)
                                VALUES";

            for ($i = 0; $i < $tama_idreclamo_rc; $i++) {
                
                //vienen varios
                if (!strpos($idreclamo_rc[$i], "###")) {
                    $aux_idreclamo_rc = explode("---", $idreclamo_rc[$i]);
                   
                    $consulta_rc.="($_SESSION[idmodulo],1,$idreclamo,$_SESSION[idmodulo],$aux_idreclamo_rc[0],$aux_idreclamo_rc[1],1),";
                }
            }
            $consulta_rc = substr($consulta_rc, 0, -1);

            if (!$this->sql->consultar($consulta_rc, "sgrc")) {
                //echo "consulta_rc1: " . $consulta_rc;
                $error++;
            }
            
            $idreclamo_rc = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idreclamo_rc",$idreclamo_rc,$consulta_rc);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }
        
        if (isset($idreclamo_complejo_rc) && !is_array($idreclamo_complejo_rc)) {
            $aux_idreclamo_rc = $idreclamo_complejo_rc;
            $idreclamo_complejo_rc = null;
            $idreclamo_complejo_rc = array($aux_idreclamo_rc);

            $tama_idreclamo_rc = 1;
        } else {

            $tama_idreclamo_rc = sizeof($idreclamo_complejo_rc);
        }

        if ($tama_idreclamo_rc > 0) {

            #########################
            #########################

            $consulta_rc = "INSERT INTO
                                  `reclamo_rc`(
                                    `idmodulo_reclamo_rc`,
                                  `activo`,
                                  `idreclamo`,
                                  `idmodulo_reclamo`,
                                  `idrc`,
                                  `idmodulo`,
                                  fecha,
                                  idrol)
                                VALUES";



            for ($i = 0; $i < $tama_idreclamo_rc; $i++) {
                

                if (!strpos($idreclamo_complejo_rc[$i], "###")) {
                    $aux_idreclamo_rc = explode("---", $idreclamo_complejo_rc[$i]); //compuesto
                    $fecha='';
                    if(array_key_exists($i, $fecha_complejo)){
                        $fecha = $fecha_complejo[$i];
                        $fecha = $ayudante->FechaRevezMysql($fecha, "/");
                    }
                   
                    $consulta_rc.="($_SESSION[idmodulo],1,$idreclamo,$_SESSION[idmodulo],$aux_idreclamo_rc[0],$aux_idreclamo_rc[1],'$fecha',2),";
                }
            }
            $consulta_rc = substr($consulta_rc, 0, -1);
            
            //echo "consulta_rc: " . $consulta_rc;


            if (!$this->sql->consultar($consulta_rc, "sgrc")) {
                //echo "consulta_rc2: " . $consulta_rc;
                $error++;
            }
            
            $idreclamo_rc = $this->sql->idtabla();
                        
            $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idreclamo_rc",$idreclamo_rc,$consulta_rc);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }
        
        $fecha_c= date('Y-m-d H:i:s');
        
        $idevaluacion="";
        
        if( strlen(trim($evaluacion)) > 0 ){
            $consulta_evaluacion = "INSERT INTO
                                  `evaluacion`(
                                    `idmodulo_evaluacion`,
                                  `activo`,
                                  `evaluacion`,
                                  `idreclamo`,
                                  `idmodulo_reclamo`, 
                                  estado,
                                  fecha_c,
                                  idusu_c,
                                  idmodulo_c
                                  )
                                VALUES(
                                $_SESSION[idmodulo],
                                1,
                                '$evaluacion',              
                                $idreclamo,
                                $_SESSION[idmodulo],
                                $radio_evaluacion,
                                '$fecha_c',
                                 $_SESSION[idusu_c],
                                 $_SESSION[idmodulo_c])";
            
            if (!$this->sql->consultar($consulta_evaluacion, "sgrc")) {
                $error++;
                //echo "consulta_reclamo: " . $consulta_reclamo;
            }

            $idevaluacion = $this->sql->idtabla(); //obtener id de la tabla
            $consulta_sincronizacion= $ayudante->migracion_insert("idevaluacion",$idevaluacion,$consulta_evaluacion);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
             $consulta_reclamo = "UPDATE reclamo SET                            
                            idreclamo_estado=2
                            WHERE
                            idreclamo=$idreclamo
                            AND idmodulo_reclamo=$_SESSION[idmodulo]";

            if (!$this->sql->consultar($consulta_reclamo, "sgrc")) {
                //echo "consulta_reclamo: ".$consulta_reclamo;
                $error++;
            }
            $consulta_sincronizacion= $ayudante->migracion_update($consulta_reclamo);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
            
        }              
                
         
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $idreclamo . "---" .$_SESSION[idmodulo]."---" . $error."---".$idevaluacion. "---" .$_SESSION[idmodulo];
    }
    
    function agregar_propuesta($idevaluacion, $idmodulo_evaluacion, $propuesta, $fecha_propuesta, $radio_estado, $comentario_realizado) {
        
        //echo "comentario_reclamo: ".$comentario_reclamo;
        // echo $idreclamo_sh."<br>";
        //  echo $idreclamo_rc;exit();
        //$idreclamo="",$idmodulo_reclamo=""
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        if(!isset($radio_estado)){
            $radio_estado=4;
        }

        $ayudante = new Ayudante();
        //$fecha_reclamo= $ayudante->FechaRevezMysql($fecha_reclamo, "/");
        $propuesta= $ayudante->caracter($propuesta);
        $fecha_propuesta= $ayudante->FechaRevezMysql($fecha_propuesta, "/");
        $fecha_c= date('Y-m-d H:i:s');
        
        $consulta_propuesta = "INSERT INTO
              `propuesta`(
              `idmodulo_propuesta`,
              `idevaluacion`,
              `idmodulo_evaluacion`,
              `propuesta`,
              fecha,
              activo,
              fecha_c,
              se_cumple,
              comentario_realizado,
              idusu_c,
              idmodulo_c
              )
            VALUES(
              $_SESSION[idmodulo],
              $idevaluacion,
              $idmodulo_evaluacion,              
              '$propuesta',
              '$fecha_propuesta',
                  1,
              '$fecha_c',
              $radio_estado,
              '$comentario_realizado',
              $_SESSION[idusu_c],
              $_SESSION[idmodulo_c])";

        

        if (!$this->sql->consultar($consulta_propuesta, "sgrc")) {
            $error++;
            //echo "consulta_reclamo: " . $consulta_reclamo;
        }
        
        $idpropuesta = $this->sql->idtabla(); //obtener id de la tabla
        $consulta_sincronizacion= $ayudante->migracion_insert("idpropuesta",$idpropuesta,$consulta_propuesta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
       
       
        $consulta_reclamo = "UPDATE reclamo
                             LEFT JOIN evaluacion
                             ON reclamo.idreclamo=evaluacion.idreclamo
                             AND reclamo.idmodulo_reclamo=evaluacion.idmodulo_reclamo
                             SET idreclamo_estado=$radio_estado
                             WHERE
                             evaluacion.idevaluacion=$idevaluacion
                             AND evaluacion.idmodulo_evaluacion=$idmodulo_evaluacion";

        if (!$this->sql->consultar($consulta_reclamo, "sgrc")) {
            //echo "consulta_reclamo: ".$consulta_reclamo;
            $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($consulta_reclamo);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
         
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $idpropuesta . "---" .$_SESSION[idmodulo]."---" . $error;
    }
    
    function agregar_apelacion($idevaluacion, $idmodulo_evaluacion, $apelacion,$fecha_apelacion) {
        
        //echo "comentario_reclamo: ".$comentario_reclamo;
        // echo $idreclamo_sh."<br>";
        //  echo $idreclamo_rc;exit();
        //$idreclamo="",$idmodulo_reclamo=""
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
                
        $ayudante = new Ayudante();
        //$fecha_reclamo= $ayudante->FechaRevezMysql($fecha_reclamo, "/");
        $apelacion= $ayudante->caracter($apelacion);
        $fecha_apelacion= $ayudante->FechaRevezMysql($fecha_apelacion, "/");
        $fecha_c= date('Y-m-d H:i:s');
        $consulta_apelacion = "INSERT INTO
              `apelacion`(
              `idmodulo_apelacion`,
              `idevaluacion`,
              `idmodulo_evaluacion`,
              `apelacion`,
              fecha,
              activo,
              fecha_c,
              idusu_c,
              idmodulo_c)
            VALUES(
              $_SESSION[idmodulo],
              $idevaluacion,
              $idmodulo_evaluacion,              
              '$apelacion',
              '$fecha_apelacion',
                  1,
              '$fecha_c',
              $_SESSION[idusu_c],
              $_SESSION[idmodulo_c])";

        

        if (!$this->sql->consultar($consulta_apelacion, "sgrc")) {
            $error++;
            //echo "consulta_reclamo: " . $consulta_reclamo;
        }
        
        $idapelacion = $this->sql->idtabla(); //obtener id de la tabla
        $consulta_sincronizacion= $ayudante->migracion_insert("idapelacion",$idapelacion,$consulta_apelacion);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
        $consulta_fase = "select idreclamo, idmodulo_reclamo from evaluacion where idevaluacion=$idevaluacion and idmodulo_evaluacion=$idmodulo_evaluacion";
        
        $result = $this->sql->consultar($consulta_fase, "sgrc");
        
        if($fila_reclamo=  mysql_fetch_array($result)){
            
            $consulta_reclamo = "UPDATE reclamo SET                            
                                idreclamo_estado=3,
                                idfase = (idfase+1),
                                fecha_fase='$fecha_apelacion'
                                WHERE
                                idreclamo=$fila_reclamo[idreclamo]
                                AND idmodulo_reclamo=$fila_reclamo[idmodulo_reclamo]";

                if (!$this->sql->consultar($consulta_reclamo, "sgrc")) {
                    //echo "consulta_reclamo: ".$consulta_reclamo;
                    $error++;
                }
                $consulta_sincronizacion= $ayudante->migracion_update($consulta_reclamo);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            
                   
        }
        
            
                        
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $idapelacion . "---" .$_SESSION[idmodulo]."---" . $error;
    }
    
    function actualizar_reclamo($idreclamo, $idmodulo_reclamo, $idreclamo_complejo_tag, $idreclamo_rc, $idreclamo_complejo_rc,$fecha_complejo, $idreclamo_complejo_sh, $idreclamo_archivo, $comentario_reclamo, $fecha_reclamo, $idreclamo_tipo, $reclamo, $evaluacion,$idreclamo_previo,$idreclamo_estado,$fecha_cierre) {
        //echo "fecha_complejo: ";
        //print_r($fecha_complejo);
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $ayudante = new Ayudante();
        $fecha_reclamo = $ayudante->FechaRevezMysql($fecha_reclamo, "/");
        $reclamo= $ayudante->caracter($reclamo);
        
        if(isset($idreclamo_previo)){
            $aux = preg_split("/[-]+/", $idreclamo_previo);
            $idreclamo_previo = $aux[0];
            $idmodulo_reclamo_previo = $aux[1];
        }else{
            $idreclamo_previo = 0;
            $idmodulo_reclamo_previo = 0;
        }
        
        $consulta_cierre="";
        
        if(isset($idreclamo_estado) && $idreclamo_estado > 0){
            
            $consulta_cierre =" idreclamo_estado=$idreclamo_estado, " ; 
            
            if(isset($fecha_cierre)){
                $fecha_cierre = $ayudante->FechaRevezMysql($fecha_cierre, "/");
                $consulta_cierre.=" fecha_cierre='$fecha_cierre', ";
            }
                
            
            
        }
        
         $fecha_a= date('Y-m-d H:i:s');
        ///INTERACCION
        $consulta_reclamo = "UPDATE reclamo SET
                            `fecha_a`='$fecha_a',                            
                            `fecha`='$fecha_reclamo',
                            `idreclamo_tipo`=$idreclamo_tipo,
                            `idreclamo_previo`=$idreclamo_previo,
                            `idusu_a`=$_SESSION[idusu_a],
                            `idmodulo_a`=$_SESSION[idmodulo_a],
                             $consulta_cierre
                            `idmodulo_reclamo_previo`=$idmodulo_reclamo_previo,
                            `comentario`='$comentario_reclamo',
                            reclamo='$reclamo'
                            WHERE
                            idreclamo='$idreclamo'
                            AND idmodulo_reclamo='$idmodulo_reclamo' ";

        if (!$this->sql->consultar($consulta_reclamo, "sgrc")) {
            //echo "consulta_reclamo: ".$consulta_reclamo;
            $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($consulta_reclamo);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        ///echo $consulta_reclamo."<br>";
        /////TAG
        ///LOGICA, SI VIENE CON ***, NECESITO ACTUALIZAR 1 - 0, ESTADOS DE ACTIVO
        //SI VIENE CON --- ES PARA AGREGAR SALVO SI TIENE numeral
        //print_r($idreclamo_complejo_tag);
        
        

        $tama_tag_reclamo = sizeof($idreclamo_complejo_tag);
        $consulta_insert_tag = "";
        if ($tama_tag_reclamo > 0) {

            for ($i = 0; $i < $tama_tag_reclamo; $i++) {
                if (strpos($idreclamo_complejo_tag[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag
                    $aux_tag = explode("***", $idreclamo_complejo_tag[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_tag = "UPDATE reclamo_tag SET `fecha_a`='$fecha_a',activo=$aux_tag[2] WHERE idreclamo_tag=$aux_tag[0] AND idmodulo_reclamo_tag=$aux_tag[1] AND activo!=$aux_tag[2]";

                    if (!$this->sql->consultar($consulta_update_tag, "sgrc")) {
                        //echo "consulta_update_tag: ".$consulta_update_tag;
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_tag);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idreclamo_complejo_tag[$i], "###")) {
                    $aux_tag_reclamo = explode("---", $idreclamo_complejo_tag[$i]);
                    $consulta_insert_tag.="($_SESSION[idmodulo],1,$idreclamo,$idmodulo_reclamo,$aux_tag_reclamo[0],$aux_tag_reclamo[1]),";
                }
            }

            if (strlen($consulta_insert_tag) > 0) {
                $cabecera_consulta_insert_tag = "INSERT INTO
                              `reclamo_tag`(
                              `idmodulo_reclamo_tag`,
                              `activo`,
                              `idreclamo`,
                              `idmodulo_reclamo`,
                              `idtag`,
                              `idmodulo_tag`)
                            VALUES";

                $cabecera_consulta_insert_tag.=$consulta_insert_tag;
                $cabecera_consulta_insert_tag = substr($cabecera_consulta_insert_tag, 0, -1);

                if (!$this->sql->consultar($cabecera_consulta_insert_tag, "sgrc")) {
                    //echo "cabecera_consulta_insert_tag: ".$cabecera_consulta_insert_tag;
                    $error++;
                }
                $idreclamo_tag = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idreclamo_tag",$idreclamo_tag,$cabecera_consulta_insert_tag);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }
         
         
        
        if( isset($idreclamo_rc)){
            if (strpos($idreclamo_rc, "---")) {
                $aux_rc = explode("---", $idreclamo_rc);
                if($aux_rc[2]>0){
                    $consulta_update_rc = "UPDATE reclamo_rc SET activo=0 WHERE idrol=1 AND idreclamo=$idreclamo AND idmodulo_reclamo=$idmodulo_reclamo ";
                    //echo "<br>".$consulta_update_rc;
                    if (!$this->sql->consultar($consulta_update_rc, "sgrc")) {
                        echo "consulta_update_rc1: ".$consulta_update_rc."<br>";
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_rc);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                    
                    $cabecera_consulta_insert_rc = "INSERT INTO
                                  `reclamo_rc`(
                                  `idmodulo_reclamo_rc`,
                                  `activo`,
                                  `idreclamo`,
                                  `idmodulo_reclamo`,
                                  `idrc`,
                                  `idmodulo`,
                                   idrol)
                                VALUES(
                                $_SESSION[idmodulo],
                                1,
                                $idreclamo,
                                $idmodulo_reclamo,
                                $aux_rc[0],
                                $aux_rc[1],
                                1)";
                    
                    if (!$this->sql->consultar($cabecera_consulta_insert_rc, "sgrc")) {
                        echo "cabecera_consulta_insert_rc1 : ".$cabecera_consulta_insert_rc."<br>";
                        $error++;
                    }
                    $idreclamo_rc = $this->sql->idtabla();

                    $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idreclamo_rc",$idreclamo_rc,$cabecera_consulta_insert_rc);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                    
                }
                
            }
            
            
        }else{
            
            $consulta_update_rc = "UPDATE reclamo_rc SET activo=0 WHERE idrol=1 AND idreclamo=$idreclamo AND idmodulo_reclamo=$idmodulo_reclamo ";
            //echo "<br>".$consulta_update_rc;
            if (!$this->sql->consultar($consulta_update_rc, "sgrc")) {
                //echo "<br>".$consulta_update_rc;
                $error++;
            }
            $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_rc);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
        }
        
        
        

        /////RC

        $tama_rc_reclamo = sizeof($idreclamo_complejo_rc);
        $consulta_insert_rc = "";
        if ($tama_rc_reclamo > 0) {

            for ($i = 0; $i < $tama_rc_reclamo; $i++) {
                $fecha_complejo[$i] = $ayudante->FechaRevezMysql($fecha_complejo[$i], "/");
                // echo "veamos ".$idreclamo_complejo_rc[$i];
                if (strpos($idreclamo_complejo_rc[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag

                    $aux_rc = explode("***", $idreclamo_complejo_rc[$i]);
                    
                   $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_rc = "UPDATE reclamo_rc SET `fecha`='$fecha_complejo[$i]',`fecha_a`='$fecha_a',activo=$aux_rc[2] WHERE idreclamo_rc=$aux_rc[0] AND idmodulo_reclamo_rc=$aux_rc[1] ";
                    //echo "<br>".$consulta_update_rc;
                    if (!$this->sql->consultar($consulta_update_rc, "sgrc")) {
                        //echo "<br>".$consulta_update_rc;
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_rc);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idreclamo_complejo_rc[$i], "###")) {
                    $aux_rc_reclamo = explode("---", $idreclamo_complejo_rc[$i]);
                    $consulta_insert_rc.="($_SESSION[idmodulo],1,$idreclamo,$idmodulo_reclamo,$aux_rc_reclamo[0],$aux_rc_reclamo[1],2,'$fecha_complejo[$i]'),";
                }
            }
            //echo $consulta_insert_rc;
            if (strlen($consulta_insert_rc) > 0) {
                $cabecera_consulta_insert_rc = "INSERT INTO
                                  `reclamo_rc`(
                                  `idmodulo_reclamo_rc`,
                                  `activo`,
                                  `idreclamo`,
                                  `idmodulo_reclamo`,
                                  `idrc`,
                                  `idmodulo`,
                                   idrol,
                                   fecha)
                                VALUES";

                $cabecera_consulta_insert_rc.=$consulta_insert_rc;
                $cabecera_consulta_insert_rc = substr($cabecera_consulta_insert_rc, 0, -1);
                //  echo $cabecera_consulta_insert_rc."<br>";
                if (!$this->sql->consultar($cabecera_consulta_insert_rc, "sgrc")) {
                    //echo $cabecera_consulta_insert_rc."<br>";
                    $error++;
                }
                $idreclamo_rc = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idreclamo_rc",$idreclamo_rc,$cabecera_consulta_insert_rc);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }
         
         
        ////SH

        $tama_sh_reclamo = sizeof($idreclamo_complejo_sh);
        $consulta_insert_sh = "";
        if ($tama_sh_reclamo > 0) {


            for ($i = 0; $i < $tama_sh_reclamo; $i++) {

                if (strpos($idreclamo_complejo_sh[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag
                    //echo "bien ".$idreclamo_complejo_sh[$i];


                    $aux_sh = explode("***", $idreclamo_complejo_sh[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_sh = "UPDATE reclamo_sh SET activo=$aux_sh[2] WHERE idreclamo_sh=$aux_sh[0] AND  idmodulo_reclamo_sh=$aux_sh[1] AND activo!=$aux_sh[2]";

                    if (!$this->sql->consultar($consulta_update_sh, "sgrc")) {

                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_sh);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idreclamo_complejo_sh[$i], "###")) {
                    $aux_sh_reclamo = explode("---", $idreclamo_complejo_sh[$i]);
                    $consulta_insert_sh.="($_SESSION[idmodulo],1,$idreclamo,$idmodulo_reclamo,$aux_sh_reclamo[0],$aux_sh_reclamo[1]),";
                }
            }

            if (strlen($consulta_insert_sh) > 0) {
                $cabecera_consulta_insert_sh = "INSERT INTO
                                  `reclamo_sh`(
                                  `idmodulo_reclamo_sh`,
                                  `activo`,
                                  `idreclamo`,
                                  `idmodulo_reclamo`,
                                  `idsh`,
                                  `idmodulo`)
                                VALUES";

                $cabecera_consulta_insert_sh.=$consulta_insert_sh;
                $cabecera_consulta_insert_sh = substr($cabecera_consulta_insert_sh, 0, -1);
                
                //echo "cabecera_consulta_insert_sh: ".$cabecera_consulta_insert_sh;

                if (!$this->sql->consultar($cabecera_consulta_insert_sh, "sgrc")) {
                    //echo "cabecera_consulta_insert_sh: ".$cabecera_consulta_insert_sh;
                    $error++;
                }
                $idreclamo_sh = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idreclamo_sh",$idreclamo_sh,$cabecera_consulta_insert_sh);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }

        
        ////DOCUMENTO
        
        $tama_reclamo_archivo = sizeof($idreclamo_archivo);
        
        if ($tama_reclamo_archivo > 0) {


            for ($i = 0; $i < $tama_reclamo_archivo; $i++) {

                if (strpos($idreclamo_archivo[$i], "***")) {
                  

                    $aux_archivo = explode("***", $idreclamo_archivo[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_archivo = "UPDATE reclamo_archivo SET `fecha_a`='$fecha_a',activo=$aux_archivo[2] WHERE idreclamo_archivo=$aux_archivo[0] AND  idmodulo_reclamo_archivo=$aux_archivo[1] AND activo!=$aux_archivo[2]";

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
        
        if( isset($evaluacion) && strlen(trim($evaluacion)) > 0 ){
            $estado=0;
            if(isset($radio_evaluacion)){
                $estado=$radio_evaluacion;
            }
            $consulta_evaluacion = "INSERT INTO
                                  `evaluacion`(
                                    `idmodulo_evaluacion`,
                                  `activo`,
                                  `evaluacion`,
                                  `idreclamo`,
                                  `idmodulo_reclamo`, 
                                  estado,
                                  fecha_c
                                  )
                                VALUES(
                                $_SESSION[idmodulo],
                                1,
                                '$evaluacion',              
                                $idreclamo,
                                $idmodulo_reclamo,
                                $estado,
                                '$fecha_a')";
            
            if (!$this->sql->consultar($consulta_evaluacion, "sgrc")) {
                $error++;
                //echo "consulta_evaluacion: " . $consulta_evaluacion;
            }

            $idevaluacion = $this->sql->idtabla(); //obtener id de la tabla
            $idmodulo_evaluacion=$_SESSION[idmodulo];
            $consulta_sincronizacion= $ayudante->migracion_insert("idevaluacion",$idevaluacion,$consulta_evaluacion);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
             $consulta_reclamo = "UPDATE reclamo SET                            
                            idreclamo_estado=2
                            WHERE
                            idreclamo=$idreclamo
                            AND idmodulo_reclamo=$idmodulo_reclamo";

            if (!$this->sql->consultar($consulta_reclamo, "sgrc")) {
                //echo "consulta_reclamo: ".$consulta_reclamo;
                $error++;
            }
            $consulta_sincronizacion= $ayudante->migracion_update($consulta_reclamo);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
            
        }else{
            
            $idevaluacion="";
            $idmodulo_evaluacion="";
            
            $consulta = "select idevaluacion, idmodulo_evaluacion, fecha_c
                        from evaluacion
                        where 
                        idreclamo=$idreclamo and
                        idmodulo_reclamo=$idmodulo_reclamo and
                        activo=1
                        order by fecha_c desc limit 1";
            
            $result = $this->sql->consultar($consulta, "sgrc");
            
            $fila = mysql_fetch_array($result);
            
            $idevaluacion = $fila[idevaluacion];
            $idmodulo_evaluacion = $fila[idmodulo_evaluacion];
                                                
        }
        

        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $idreclamo . "---" . $idmodulo_reclamo ."---". $error."---".$idevaluacion."---".$idmodulo_evaluacion;
    }
    
    
     function actualizar_evaluacion($idevaluacion, $idmodulo_evaluacion, $evaluacion) {

        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $ayudante = new Ayudante();
        $evaluacion = $ayudante->caracter($evaluacion);
        ///compromiso
        $fecha_a= date('Y-m-d H:i:s');
        $consulta_evaluacion = "UPDATE evaluacion SET
                            `fecha_a`='$fecha_a',
                            evaluacion='$evaluacion',
                            idusu_a=$_SESSION[idusu_a],
                            idmodulo_a=$_SESSION[idmodulo_a]
                                WHERE
                            idevaluacion='$idevaluacion' AND
                            idmodulo_evaluacion='$idmodulo_evaluacion'";
        //echo $consulta_compromiso;exit;
        if (!$this->sql->consultar($consulta_evaluacion, "sgrc")) {

            $error++;
        }
         $consulta_sincronizacion= $ayudante->migracion_update($consulta_evaluacion);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        

        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        // echo $idcompromiso."---".$idmodulo_compromiso."---".$error;exit;
        return $idevaluacion. "---" . $idmodulo_evaluacion . "---" . $error;
    }
    
    function actualizar_propuesta($idpropuesta, $idmodulo_propuesta, $propuesta, $fecha_propuesta, $idpropuesta_archivo,$radio_estado,$comentario_realizado) {

        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $ayudante = new Ayudante();
        $propuesta = $ayudante->caracter($propuesta);        
        $fecha_propuesta = $ayudante->FechaRevezMysql($fecha_propuesta, "/");
        ///compromiso
        $fecha_a= date('Y-m-d H:i:s');
        
        $consulta_estado="";
        if(isset($radio_estado)){
             $consulta_estado.=", se_cumple=$radio_estado, comentario_realizado='$comentario_realizado'";
            
             $consulta_propuesta = "UPDATE reclamo 
                            LEFT JOIN evaluacion
                            ON reclamo.idreclamo = evaluacion.idreclamo
                            AND reclamo.idmodulo_reclamo = evaluacion.idmodulo_reclamo
                            LEFT JOIN propuesta
                            ON propuesta.idevaluacion = evaluacion.idevaluacion
                            AND propuesta.idmodulo_evaluacion = evaluacion.idmodulo_evaluacion
                            SET
                            reclamo.`idreclamo_estado`=$radio_estado
                            WHERE
                            propuesta.idpropuesta=$idpropuesta AND
                            propuesta.idmodulo_propuesta=$idmodulo_propuesta";
            
            if (!$this->sql->consultar($consulta_propuesta, "sgrc")) {
                echo $consulta_propuesta;
                $error++;
            }
             $consulta_sincronizacion= $ayudante->migracion_update($consulta_propuesta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }
        
        $consulta_propuesta = "UPDATE propuesta SET
                            `fecha_a`='$fecha_a',
                            `fecha`='$fecha_propuesta',
                            `idusu_a`=$_SESSION[idusu_a],
                            `idmodulo_a`=$_SESSION[idmodulo_a],
                            propuesta='$propuesta'
                            $consulta_estado
                            WHERE
                            idpropuesta=$idpropuesta AND
                            idmodulo_propuesta=$idmodulo_propuesta";
        //echo $consulta_propuesta;
        if (!$this->sql->consultar($consulta_propuesta, "sgrc")) {

            $error++;
        }
         $consulta_sincronizacion= $ayudante->migracion_update($consulta_propuesta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
         ////DOCUMENTO
        
        $tama_propuesta_archivo = sizeof($idpropuesta_archivo);
        
        if ($tama_propuesta_archivo > 0) {


            for ($i = 0; $i < $tama_propuesta_archivo; $i++) {

                if (strpos($idpropuesta_archivo[$i], "***")) {
                  

                    $aux_archivo = explode("***", $idpropuesta_archivo[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_archivo = "UPDATE propuesta_archivo SET `fecha_a`='$fecha_a',activo=$aux_archivo[2] WHERE idpropuesta_archivo=$aux_archivo[0] AND  idmodulo_propuesta_archivo=$aux_archivo[1] AND activo!=$aux_archivo[2]";

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
        return $idpropuesta. "---" . $idmodulo_propuesta . "---" . $error;
    }
    
    function actualizar_apelacion($idapelacion, $idmodulo_apelacion, $apelacion, $fecha_apelacion, $idapelacion_archivo) {

        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $ayudante = new Ayudante();
        $apelacion = $ayudante->caracter($apelacion);        
        $fecha_apelacion = $ayudante->FechaRevezMysql($fecha_apelacion, "/");
        ///compromiso
        $fecha_a= date('Y-m-d H:i:s');
        $consulta_apelacion = "UPDATE apelacion SET
                            `fecha_a`='$fecha_a',
                            `fecha`='$fecha_apelacion',
                            apelacion='$apelacion',
                            idusu_a=$_SESSION[idusu_a],
                            idmodulo_a=$_SESSION[idmodulo_a]
                                WHERE
                            idapelacion='$idapelacion' AND
                            idmodulo_apelacion='$idmodulo_apelacion'";
        //echo $consulta_apelacion;
        if (!$this->sql->consultar($consulta_apelacion, "sgrc")) {

            $error++;
        }
         $consulta_sincronizacion= $ayudante->migracion_update($consulta_apelacion);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
         ////DOCUMENTO
        
        $tama_apelacion_archivo = sizeof($idapelacion_archivo);
        
        if ($tama_apelacion_archivo > 0) {


            for ($i = 0; $i < $tama_apelacion_archivo; $i++) {

                if (strpos($idapelacion_archivo[$i], "***")) {
                  

                    $aux_archivo = explode("***", $idapelacion_archivo[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_archivo = "UPDATE apelacion_archivo SET `fecha_a`='$fecha_a',activo=$aux_archivo[2] WHERE idapelacion_archivo=$aux_archivo[0] AND  idmodulo_apelacion_archivo=$aux_archivo[1] AND activo!=$aux_archivo[2]";

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
        return $idapelacion. "---" . $idmodulo_apelacion . "---" . $error;
    }
    
     function eliminar_reclamo($idreclamo, $idmodulo_reclamo) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $consulta = "SELECT *
                   FROM evaluacion
                   WHERE
                   idreclamo=$idreclamo
                   AND
                   idmodulo_reclamo=$idmodulo_reclamo
                   AND
                   activo=1";

        $result = $this->sql->consultar($consulta, "sgrc");

        $cantidad = mysql_num_rows($result);

        if ($cantidad == 0) {
            
             $fecha_a= date('Y-m-d H:i:s');

            $consulta = "UPDATE reclamo
                       SET activo=0
                       WHERE
                       idreclamo=$idreclamo
                       AND
                       idmodulo_reclamo=$idmodulo_reclamo
                       AND
                       activo=1";
            //echo "consulta_reclamo: ".$consulta;

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
            
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
             $fecha_a= date('Y-m-d H:i:s');
            
            $consulta = "UPDATE reclamo_rc
                       SET `fecha_a`='$fecha_a',activo=0
                       WHERE
                       idreclamo=$idreclamo
                       AND
                       idmodulo_reclamo=$idmodulo_reclamo
                       AND
                       activo=1";
            //echo "consulta_reclamo: ".$consulta;

            if (!$this->sql->consultar($consulta, "sgrc")) {

                $error++;
            }
            
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
             $fecha_a= date('Y-m-d H:i:s');
            
            $consulta = "UPDATE reclamo_sh
                       SET `fecha_a`='$fecha_a',activo=0
                       WHERE
                       idreclamo=$idreclamo
                       AND
                       idmodulo_reclamo=$idmodulo_reclamo
                       AND
                       activo=1";
            //echo "consulta_reclamo: ".$consulta;

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
    
     function eliminar_propuesta($idpropuesta, $idmodulo_propuesta,$idreclamo,$idmodulo_reclamo) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        $consulta ="SELECT (
                            SELECT COUNT(*) 
                            from evaluacion
                            where 
                            evaluacion.idreclamo=$idreclamo
                            and evaluacion.idmodulo_reclamo=$idmodulo_reclamo
                            and evaluacion.fecha_c>propuesta.fecha_c)
                            as cantidad
                            from propuesta
                            where
                            propuesta.idpropuesta=$idpropuesta
                            and propuesta.idmodulo_propuesta=$idmodulo_propuesta";
        
        //echo $consulta;
        
        $result = $this->sql->consultar($consulta, "sgrc");

        $fila = mysql_fetch_array($result);

        if ($fila[cantidad] == 0) {

            $consulta = "UPDATE propuesta
                       SET activo=0
                       WHERE
                       idpropuesta=$idpropuesta
                       AND
                       idmodulo_propuesta=$idmodulo_propuesta
                       AND
                       activo=1";
            //echo "consulta_propuesta: ".$consulta;

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
        }else{
            $error++;
        }

     
        $respuesta = $error;

        return $respuesta;
    }
    
    function eliminar_apelacion($idapelacion, $idmodulo_apelacion) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        $error++;
        
        //Falta validar que no tenga hijos
        

        $fecha_a= date('Y-m-d H:i:s');

        $consulta = "UPDATE apelacion
                   SET activo=0
                   WHERE
                   idapelacion=$idapelacion
                   AND
                   idmodulo_apelacion=$idmodulo_apelacion
                   AND
                   activo=1";
        //echo "consulta_apelacion: ".$consulta;

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
        

     
        $respuesta = $error;

        return $respuesta;
    }
    
     function eliminar_evaluacion($idevaluacion, $idmodulo_evaluacion) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        $error++;
        
        //Falta validar que no tenga hijos
        

        $fecha_a= date('Y-m-d H:i:s');

        $consulta = "UPDATE evaluacion
                   SET activo=0
                   WHERE
                   idevaluacion=$idevaluacion
                   AND
                   idmodulo_evaluacion=$idmodulo_evaluacion
                   AND
                   activo=1";
        //echo "consulta_apelacion: ".$consulta;

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
        

     
        $respuesta = $error;

        return $respuesta;
    }
    
    
     function agregar_archivo_reclamo( $idreclamo, $idmodulo_reclamo, $archivos ) {
       
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        
        $fecha_c = date('Y-m-d H:i:s');

        $ayudante = new Ayudante();
     
        
        if( isset($archivos) && is_array($archivos) && count($archivos)>0 ){
            
            $consulta_archivo = "INSERT INTO reclamo_archivo(
                                idmodulo_reclamo_archivo,archivo,
                                idreclamo,idmodulo_reclamo,
                                activo, idusu, idmodulo_a,
                                fecha) 
                                VALUES ";
            
            foreach ( $archivos as $archivo ){
                $consulta_archivo .= "(
                                $_SESSION[idmodulo],'$archivo',
                                $idreclamo,$idmodulo_reclamo,
                                1,$_SESSION[idusuario],$_SESSION[idmodulo_a],
                                '$fecha_c') ,";
            
            }
            
            
            $consulta_archivo = substr($consulta_archivo, 0, -1);

            if (!$this->sql->consultar($consulta_archivo, "sgrc")) {
                    //echo "consulta_archivo: " . $consulta_archivo;
                    $error++;
            }else{
                $idreclamo_archivo = $this->sql->idtabla(); //obtener id de la tabla
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idreclamo_archivo",$idreclamo_archivo,$consulta_archivo);

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
    
    
      function agregar_archivo_propuesta( $idpropuesta, $idmodulo_propuesta, $archivos ) {
       
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        
        $fecha_c = date('Y-m-d H:i:s');

        $ayudante = new Ayudante();
     
        
        if( isset($archivos) && is_array($archivos) && count($archivos)>0 ){
            
            $consulta_archivo = "INSERT INTO propuesta_archivo(
                                idmodulo_propuesta_archivo,archivo,
                                idpropuesta,idmodulo_propuesta,
                                activo, idusu_c, idmodulo_c,
                                fecha) 
                                VALUES ";
            
            foreach ( $archivos as $archivo ){
                $consulta_archivo .= "(
                                $_SESSION[idmodulo],'$archivo',
                                $idpropuesta,$idmodulo_propuesta,
                                1,$_SESSION[idusu_c],$_SESSION[idmodulo_c],
                                '$fecha_c') ,";
            
            }
            
            
            $consulta_archivo = substr($consulta_archivo, 0, -1);

            if (!$this->sql->consultar($consulta_archivo, "sgrc")) {
                    //echo "consulta_archivo: " . $consulta_archivo;
                    $error++;
            }else{
                $idpropuesta_archivo = $this->sql->idtabla(); //obtener id de la tabla
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idpropuesta_archivo",$idpropuesta_archivo,$consulta_archivo);

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
    
     function agregar_archivo_apelacion( $idapelacion, $idmodulo_apelacion, $archivos ) {
       
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        
        $fecha_c = date('Y-m-d H:i:s');

        $ayudante = new Ayudante();
     
        
        if( isset($archivos) && is_array($archivos) && count($archivos)>0 ){
            
            $consulta_archivo = "INSERT INTO apelacion_archivo(
                                idmodulo_apelacion_archivo,archivo,
                                idapelacion,idmodulo_apelacion,
                                activo, idusu, idmodulo_a,
                                fecha) 
                                VALUES ";
            
            foreach ( $archivos as $archivo ){
                $consulta_archivo .= "(
                                $_SESSION[idmodulo],'$archivo',
                                $idapelacion,$idmodulo_apelacion,
                                1,$_SESSION[idusuario],$_SESSION[idmodulo_a],
                                '$fecha_c') ,";
            
            }
            
            
            $consulta_archivo = substr($consulta_archivo, 0, -1);

            if (!$this->sql->consultar($consulta_archivo, "sgrc")) {
                    //echo "consulta_archivo: " . $consulta_archivo;
                    $error++;
            }else{
                $idapelacion_archivo = $this->sql->idtabla(); //obtener id de la tabla
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idapelacion_archivo",$idapelacion_archivo,$consulta_archivo);

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


    
}

?>