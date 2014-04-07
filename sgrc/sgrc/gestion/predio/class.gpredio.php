<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gpredio
 *
 * @author dmontjoy
 */
class gpredio {
    //put your code here
   public $sql;


    function gpredio() {           
        $this->sql = new DmpSql();
    }
    function agregar_archivo( $idpredio,$idmodulo_predio ,$archivos) {
       
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        
        $fecha_c = date('Y-m-d H:i:s');

        $ayudante = new Ayudante();
     
        
        if( isset($archivos) && is_array($archivos) && count($archivos)>0 ){
            
            $consulta_archivo = "INSERT INTO predio_archivo(
                                idmodulo_predio_archivo,archivo,
                                idpredio,
                                idmodulo_predio,
                                activo) 
                                VALUES ";
            
            foreach ( $archivos as $archivo ){
                $consulta_archivo .= "(
                                $_SESSION[idmodulo],'$archivo',
                                $idpredio,
                                $idmodulo_predio,
                                1) ,";
            
            }
            //echo "seee".$consulta_archivo;
            
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
    
   function agregar_tag_complejo($idpredio_complejo_tag, $orden_complejo_tag, $idpredio, $idmodulo_predio) {
        $ayudante = new Ayudante();
        //$email=array_filter($email);
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
     
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
                    //echo "consulta_update_tag: ".$consulta_update_tag;
                    if (!$this->sql->consultar($consulta_update_tag, "sgrc")) {
                        
                        $error++;
                    }
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta_update_tag);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (!strpos($idpredio_complejo_tag[$i], "###")) {
                    $aux_predio_tag = explode("---", $idpredio_complejo_tag[$i]);
                    $consulta_insert_tag.="($_SESSION[idmodulo],1,$idpredio,$idmodulo_predio,$aux_predio_tag[0],$aux_predio_tag[1],$orden_complejo_tag[$i]),";
                }
            }

            if (strlen($consulta_insert_tag) > 0) {
                $cabecera_consulta_insert_tag = "INSERT INTO
                              `predio_tag`(
                              `idmodulo_predio_tag`,
                              `activo`,
                              `idpredio`,
                              `idmodulo_predio`,
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
    function actualizar_predio_datum($idpredio,$idmodulo_predio,$predio_datum,$idpredio_archivo, $predio_comentario="",$predio_direccion="" ){
       
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $ayudante = new Ayudante();
        $fecha_a= date('Y-m-d H:i:s');
        ///predio
        $consulta = "UPDATE predio SET
                            direccion='$predio_direccion',
                            comentario='$predio_comentario'
                                WHERE
                            idpredio='$idpredio' AND idmodulo_predio='$idmodulo_predio'";

        if (!$this->sql->consultar($consulta, "sgrc")) {
            echo "consulta: ".$consulta;
        //    $error++;
        }
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        } 
        
        //DATUM
        //
        $tama_predio_datum = sizeof($predio_datum);
        if ($tama_predio_datum > 0) {
            foreach ($predio_datum as $idpredio_datum => $valor_predio_datum) {
                //echo "valor ".$idpredio_datum." ".$valor_predio_datum;
                $apredio_datum=explode("***",$idpredio_datum);
                  
                $consulta="UPDATE predio_datum_valor SET activo='0' WHERE 
                        idpredio_datum_valor='$apredio_datum[1]' AND idmodulo_predio_datum_valor='$apredio_datum[2]'";
                
                if(!$this->sql->consultar($consulta,"sgrc")){
                   $error++;
                }
                
                $consulta_sincronizacion= $ayudante->migracion_update($consulta);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                } 
                /*
idmodulo_predio_datum_valor='$apredio_datum[1]',
                 *                  */
               $insert="INSERT predio_datum_valor SET valor='$valor_predio_datum',idpredio='$idpredio', idmodulo_predio='$idmodulo_predio', idmodulo_predio_datum_valor='$_SESSION[idmodulo]',idpredio_datum='$apredio_datum[0]' ";
               //echo $insert; 
               if(!$this->sql->consultar($insert,"sgrc")){
                   $error++;
                }                
                //echo $consulta;
                $consulta_sincronizacion= $ayudante->migracion_update($insert);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                } 
            }
        }
        //$consulta_sincronizacion= $ayudante->migracion_update($consulta);

        //if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
        //    $error++;
        //} 
        ////DOCUMENTO
        
        $tama_predio_archivo = sizeof($idpredio_archivo);

        if ($tama_predio_archivo > 0) {


            for ($i = 0; $i < $tama_predio_archivo; $i++) {

                if (strpos($idpredio_archivo[$i], "***")) {
                  
                    $aux_archivo = explode("***", $idpredio_archivo[$i]);
                    
                     $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update_archivo = "UPDATE predio_archivo SET activo=$aux_archivo[2] WHERE idpredio_archivo=$aux_archivo[0] AND  idmodulo_predio_archivo=$aux_archivo[1] AND activo!=$aux_archivo[2]";
                    //echo $consulta_update_archivo;
                    if (!$this->sql->consultar($consulta_update_archivo, "sgrc")) {
                        //
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

        return $idpredio . "---" . $error;
    
    }
    
   function eliminar_predio_sh($idpredio_sh, $idmodulo_predio_sh) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        //$consulta="DELETE FROM persona_red WHERE idred=$idpersona_red_stakeholder";
        
         $fecha_a= date('Y-m-d H:i:s');
         
        $consulta = "UPDATE predio_sh
                    SET `fecha_a`='$fecha_a', activo='0'
                    WHERE
                    idpredio_sh=$idpredio_sh
                    AND
                    idmodulo_predio_sh=$idmodulo_predio_sh";
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
    
function agregar_sh($idpersona, $idmodulo, $idpredio, $idmodulo_predio_sh) {

    $ayudante = new Ayudante();
    ///////////////////////////////////////////////////
    $this->sql->consultar("START TRANSACTION", "sgrc");
    $error = 0;

    $consulta = "SELECT COUNT(*) as 'cantidad'
                FROM predio_sh
                WHERE
                idsh=$idpersona
                AND
                idmodulo=$idmodulo
                AND
                idpredio=$idpredio                    
                AND
                idmodulo_predio_sh=$idmodulo_predio_sh
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
          `activo`)
        VALUES(
          $idpersona,
          $idmodulo_predio_sh,
          $idmodulo,
          $idpredio,
          1)";


        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
            //echo $consulta;
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
function editar_predio_tipo_tenencia($idpredio_sh,$idmodulo_predio_sh,$idpredio_tipo_tenencia){
    $ayudante = new Ayudante();
    ///////////////////////////////////////////////////
    $this->sql->consultar("START TRANSACTION", "sgrc");
    $error = 0;   
    $update="UPDATE predio_sh SET idpredio_tipo_tenencia=$idpredio_tipo_tenencia WHERE idpredio_sh=$idpredio_sh AND idmodulo_predio_sh=$idmodulo_predio_sh AND activo=1";
    
    if(!$this->sql->consultar($update,"sgrc")){
        $error++;
    }

    if ($error == 0) {
        $this->sql->consultar("COMMIT", "sgrc");
    } else {
        $this->sql->consultar("ROLLBACK", "sgrc");
    }  
    //$idpredio ."***". $idmodulo_predio."***" . 
    return $error;   
    
    
}
function editar_proceso_pasos($idpredio_sh,$idmodulo_predio_sh,$idpredio_proceso_pasos,$idpredio,$idmodulo_predio) {
    $ayudante = new Ayudante();
    ///////////////////////////////////////////////////
    $this->sql->consultar("START TRANSACTION", "sgrc");
    $error = 0;   
    $update="UPDATE predio_proceso_pasos_predio SET activo=0 WHERE idpredio_sh=$idpredio_sh AND idmodulo_predio_sh=$idmodulo_predio_sh";
    //echo $update;
    if(!$this->sql->consultar($update,"sgrc")){
        $error++;
    }
    $insert="INSERT INTO predio_proceso_pasos_predio SET activo=1,idpredio_sh=$idpredio_sh,idmodulo_predio_sh=$idmodulo_predio_sh,idpredio_proceso_pasos=$idpredio_proceso_pasos,idmodulo_predio_proceso_pasos_predio=$_SESSION[idmodulo]";
    //echo $insert;
    //$id = $this->sql->idtabla();
    //exit;
    //$consulta_sincronizacion= $ayudante->migracion_insert("idpredio",$idpredio,$consulta);

    if(!$this->sql->consultar($insert,"sgrc")){
        $error++;
    }
    if ($error == 0) {
        $this->sql->consultar("COMMIT", "sgrc");
    } else {
        $this->sql->consultar("ROLLBACK", "sgrc");
    }  
    //$idpredio ."***". $idmodulo_predio."***" . 
    return $error;
}
}
