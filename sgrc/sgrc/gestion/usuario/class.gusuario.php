<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gusuario
 *
 * @author dmontjoy
 */
class gusuario {

    public $sql;

    function gusuario() {
        $this->sql = new DmpSql();
    }

    function guardar($idpersona,$idmodulo,$usuario,$clave,$idseguridad_rol,$host) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        $fecha_a = date('Y-m-d H:i:s');
        $clave=md5($clave);
        $consulta = "INSERT INTO
                  usuario(idmodulo_usuario,activo,
                  usuario,clave,
                  fecha_a,idmodulo_c,
                  idusu_c,idseguridad_rol)
                VALUES($_SESSION[idmodulo],1,
                '$usuario','$clave',
                '$fecha_a',$_SESSION[idmodulo_c],
                $_SESSION[idusu_c],$idseguridad_rol)";

        //echo $consulta;
        $idusuario=0;
        
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
        }else{
            $idusuario = $this->sql->idtabla();
            $consulta_sincronizacion= $ayudante->migracion_insert("idusuario",$idusuario,$consulta);
                
            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
                
        }
                                
        if(!empty($host)){
            $consulta="INSERT INTO 
                usuario_modulo(
                idmodulo_usuario_modulo,idusuario,
                idmodulo_usuario,idmodulo,
                activo,idusu,
                idmodulo_a,fecha_a)
                VALUES";
            
            foreach($host as $modulo){
              $consulta.= "(
                $_SESSION[idmodulo],$idusuario,
                $_SESSION[idmodulo],$modulo,
                1,$_SESSION[idusu],
                $_SESSION[idmodulo_a],'$fecha_a'    ),"; 
            }
            $consulta = substr($consulta, 0, strlen($consulta) - 1);
            
            if(!$this->sql->consultar($consulta,"sgrc")){
                $error++;
            }
                     
            $idusuario_modulo = $this->sql->idtabla();
            $consulta_sincronizacion= $ayudante->migracion_insert("idusuario_modulo",$idusuario_modulo,$consulta);
            
            //echo $consulta;
            if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
                $error++;
            }
                
            
           
        }
        
        $consulta="INSERT INTO 
            usuario_persona(
            idmodulo_usuario_persona,idusuario,
            idmodulo_usuario,idpersona,
            idmodulo,idusu,
            idmodulo_a,fecha_a)
            VALUES(
            $_SESSION[idmodulo],$idusuario,
            $_SESSION[idmodulo],$idpersona,
            $idmodulo,$_SESSION[idusu],
            $_SESSION[idmodulo_a], '$fecha_a'   )";
        
        //echo $consulta;
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
        }
        $idusuario_persona = $this->sql->idtabla();
        $consulta_sincronizacion= $ayudante->migracion_insert("idusuario_persona",$idusuario_persona,$consulta);

        //echo $consulta;
        if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
            $error++;
        }
        
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        
        return $error;
    }
    
    function editar($idusuario,$idmodulo,$usuario,$clave,$idseguridad_rol,$host) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        
        $fecha_a = date('Y-m-d H:i:s');
        
        
        $consulta = "UPDATE
                  usuario 
                  SET `fecha_a`='$fecha_a',usuario='$usuario',
                  idseguridad_rol=$idseguridad_rol ";
        
        if($clave!=''){
            $clave=md5($clave);
            $consulta.=", clave='$clave'";
        }
        
        $consulta.= " WHERE idusuario=$idusuario
                    AND idmodulo_usuario=$idmodulo ";

        //echo $consulta;
  
        
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
        }else{
        
        
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
                
        }
                              
        if(!empty($host)){
            $fecha_a= date('Y-m-d H:i:s');
           $consulta="UPDATE usuario_modulo
                       SET `fecha_a`='$fecha_a',activo=0
                       WHERE idusuario=$idusuario
                       AND idmodulo_usuario=$idmodulo
                       AND idmodulo NOT IN ( ";
            
            foreach($host as $modulo){
              $pos=strpos($modulo,"***");
                if($pos!==false){
                    //update 1
                    $tokens = preg_split("/[*]+/", $modulo);
                    //print_r($tokens);
                    $modulo=$tokens[0];
                }
              $pos=strpos($modulo,"---");
                if($pos!==false){
                    //insert 1
                    $tokens = preg_split("/[-]+/", $modulo);
                    //print_r($tokens);
                    $modulo=$tokens[0];
                }
              $consulta.= "$modulo,"; 
            }
            $consulta = substr($consulta, 0, strlen($consulta) - 1);
            $consulta.=")";
            
            
            if(!$this->sql->consultar($consulta,"sgrc")){
                $error++;
                //echo $consulta;
            }
            
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
            foreach ($host as $modulo){
                $pos=strpos($modulo,"***");
                if($pos!==false){
                    //update 1
                    $tokens = preg_split("/[*]+/", $modulo);
                    //print_r($tokens);
                    $modulo=$tokens[0];
                    $fecha_a= date('Y-m-d H:i:s');
                    $consulta="UPDATE usuario_modulo
                       SET `fecha_a`='$fecha_a',activo=1
                       WHERE idusuario=$idusuario
                       AND idmodulo_usuario=$idmodulo
                       AND idmodulo=$modulo";
                    
                     if(!$this->sql->consultar($consulta,"sgrc")){
                        $error++;
                        //echo $consulta;
                     }
                     
                     $consulta_sincronizacion= $ayudante->migracion_update($consulta);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                }
                
                $pos=strpos($modulo,"---");
                if($pos!==false){
                    //insert 1
                    $tokens = preg_split("/[-]+/", $modulo);
                    //print_r($tokens);
                    $modulo=$tokens[0];
                    $consulta="INSERT INTO 
                        usuario_modulo(
                        idmodulo_usuario_modulo,idusuario,
                        idmodulo_usuario,idmodulo,
                        activo,idusu,
                        idmodulo_a,fecha_a)
                        VALUES(
                        $_SESSION[idmodulo],$idusuario,
                        $idmodulo,$modulo,
                        1,$_SESSION[idusu],
                        $_SESSION[idmodulo_a],'$fecha_a' ) "; 
                    
                   

                    if(!$this->sql->consultar($consulta,"sgrc")){
                        $error++;
                    }
                    
                    $idusuario_modulo = $this->sql->idtabla();
                    $consulta_sincronizacion= $ayudante->migracion_insert("idusuario_modulo",$idusuario_modulo,$consulta);

                    //echo $consulta;
                    if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
                        $error++;
                    }
                }
            }
            
           
        }else{
            $fecha_a= date('Y-m-d H:i:s');
            $consulta="UPDATE usuario_modulo
                       SET `fecha_a`='$fecha_a',activo=0
                       WHERE idusuario=$idusuario
                       AND idmodulo_usuario=$idmodulo";
            
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
    
     function actualizar_clave($idusuario,$idmodulo,$clave,$clave_actual) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        //echo "$idusuario,$idmodulo,$clave,$clave_actual";
        $fecha_a = date('Y-m-d H:i:s');
        
        if($clave!=''){
            
            $clave=md5($clave);
            $clave_actual=md5($clave_actual);  
            $fecha_a= date('Y-m-d H:i:s');
            
            $consulta = "UPDATE
                      usuario 
                      SET `fecha_a`='$fecha_a',clave='$clave'
                      WHERE idusuario=$idusuario
                      AND idmodulo_usuario=$idmodulo 
                      AND clave='$clave_actual'";
            
            $result=$this->sql->consultar($consulta, "sgrc");
            
            //echo $consulta;
                    
            if (!$result) {
                $error++;
                
            }else{
                if(mysql_affected_rows()==0){
                    $error++;
                }else{
                    $consulta_sincronizacion= $ayudante->migracion_update($consulta);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                }

                


            }

        }else{
            $error++;
        }
                               
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        
        return $error;
    }
    
    function actualizar_modulo($idmodulo) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;    
            
        $consulta = "UPDATE
                  modulo
                  SET configurado=1
                  WHERE idmodulo=$idmodulo";

        $result=$this->sql->consultar($consulta, "sgrc");
                    
        if (!$result) {
            $error++;
        }
                               
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        
        return $error;
    }


    function eliminar($idusuario,$idmodulo_usuario) {
        $ayudante = new Ayudante();
        //consultar si ha sido utilizado por persona o interaccion
        $error = 0;
        $fecha_a= date('Y-m-d H:i:s');

        $consulta = "UPDATE
                  usuario
                SET
                  `fecha_a`='$fecha_a',activo=0
                WHERE
                  idusuario=$idusuario
                AND
                  idmodulo_usuario=$idmodulo_usuario";

        //echo $consulta;
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
        }
        
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
        //echo "error " . $error;
        return $error;
    }

}

?>
