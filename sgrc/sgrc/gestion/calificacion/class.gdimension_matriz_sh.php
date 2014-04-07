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
class gdimension_matriz_sh {
    //put your code here
     function gdimension_matriz_sh(){
        $this->sql = new DmpSql();
    }

    function agregar_calificacion($idpersona,$idmodulo,$idmodulo_a,$fecha,$dimension, $comentario){
        $ayudante = new Ayudante();
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;
        
        $fecha_a= date('Y-m-d H:i:s');

        $consulta="INSERT INTO
              sh_dimension(
              idmodulo_sh_dimension,  
              fecha,
              fecha_a,
              idsh,
              idmodulo,
              idmodulo_a,
              comentario
              )
            VALUES(
              $_SESSION[idmodulo],
              '$fecha',
              '$fecha_a',
              $idpersona,
              $idmodulo,
              $idmodulo_a,
              '$comentario')";
        
        //echo $consulta;

        
        if(!$this->sql->consultar($consulta,"sgrc")){
            $error++;
        }
        

       $idsh_dimension = $this->sql->idtabla();
                        
       $consulta_sincronizacion= $ayudante->migracion_insert("idsh_dimension",$idsh_dimension,$consulta);
       
        //echo $consulta;

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
        
        $i=0;

        foreach ($dimension as $valor ) {
          $i++;

          $consulta="INSERT INTO
              sh_dimension_matriz_sh(
              idmodulo_sh_dimension,
              idsh_dimension_matriz_sh_valor,              
              activo,
              idsh_dimension                            
              )
            VALUES
            (
              $_SESSION[idmodulo],
              $valor,                                
              1,
              $idsh_dimension
              )";
          
          //echo $consulta."<br>";
          
            if(!$this->sql->consultar($consulta,"sgrc")){
                $error++;
            }
            
            $idsh_dimension_matriz_sh = $this->sql->idtabla();
                        
           $consulta_sincronizacion= $ayudante->migracion_insert("idsh_dimension_matriz_sh",$idsh_dimension_matriz_sh,$consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
        }
      
        //actualizar último, bloquear tablas a actualizar
        $consulta="SELECT * FROM sh WHERE sh.idsh=$idpersona AND sh.idmodulo=$idmodulo FOR UPDATE";
        //echo $consulta;
        $this->sql->consultar($consulta,"sgrc");
        
        $consulta = "SELECT 
                 `sh_dimension`.`idsh_dimension`, `sh_dimension`.`idmodulo_sh_dimension`
             FROM 
                 `sh_dimension`
             WHERE
                 `sh_dimension`.`idsh`=$idpersona and `sh_dimension`.`idmodulo`=$idmodulo
                 AND `sh_dimension`.`activo` = 1 
             ORDER BY fecha desc, fecha_a desc
             limit 1 FOR UPDATE";
        
        //echo $consulta;
        $result = $this->sql->consultar($consulta,"sgrc");
        
        if($fila = mysql_fetch_array($result)){
            
            $idsh_dimension = $fila['idsh_dimension'];
            $idmodulo_sh_dimension = $fila['idmodulo_sh_dimension'];
            
            $fecha_a= date('Y-m-d H:i:s');
            
            $consulta       ="UPDATE `sh_dimension`
                              SET `fecha_a`='$fecha_a',`sh_dimension`.`ultimo`=0
                              WHERE `sh_dimension`.`idsh`=$idpersona and `sh_dimension`.`idmodulo`=$idmodulo 
                              AND `sh_dimension`.`ultimo`=1";
            
            //echo $consulta;
            
            if(!$this->sql->consultar($consulta,"sgrc")){
                    $error++;
            }     
             
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
            $fecha_a= date('Y-m-d H:i:s', strtotime("+1 second ") );
            
            
            
            $consulta       ="update `sh_dimension`
                              set `fecha_a`='$fecha_a',`sh_dimension`.`ultimo`=1
                              where `sh_dimension`.`idsh_dimension`=$idsh_dimension
                              and `sh_dimension`.`idmodulo_sh_dimension`=$idmodulo_sh_dimension";
            
            if(!$this->sql->consultar($consulta,"sgrc")){
                    $error++;
            }     
        
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
            
            
            $consulta = "SELECT sum(IF(ISNULL(`dimension_matriz_sh_valor`.`puntaje`),0,`dimension_matriz_sh_valor`.`puntaje`)) AS 'importancia'
                         FROM 
                            sh_dimension_matriz_sh 
                            INNER JOIN  dimension_matriz_sh_valor
                            ON sh_dimension_matriz_sh.idsh_dimension_matriz_sh_valor = dimension_matriz_sh_valor.iddimension_matriz_sh_valor
                         WHERE
                            sh_dimension_matriz_sh.idsh_dimension=$idsh_dimension
                            AND sh_dimension_matriz_sh.idmodulo_sh_dimension=$idmodulo_sh_dimension
                            AND dimension_matriz_sh_valor.iddimension_matriz_sh > 1 ";
            
           
            
            $result = $this->sql->consultar($consulta,"sgrc");
            
            $importancia=0;
            
            if($fila = mysql_fetch_array($result)){
                if(isset($fila['importancia'])){
                    $importancia = $fila['importancia'];
                }
            }    
                                    
            
           //actualizar importancia
            
            $fecha_a= date('Y-m-d H:i:s');
            
            $consulta="UPDATE sh SET `fecha_a`='$fecha_a',importancia=$importancia 
                  WHERE  idsh=$idpersona
                  AND idmodulo=$idmodulo";

            //echo $consulta;
          
            if(!$this->sql->consultar($consulta,"sgrc")){
                        $error++;
            }     

            $consulta_sincronizacion= $ayudante->migracion_update($consulta);
            // echo "Error ".$error;
            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }
            
            
              
            
        }
        
         //echo "Error ".$error;
       
        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
                }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }          

       
        return $error;
        
    }

    function eliminar_calificacion($idpersona,$idmodulo,$idsh_dimension,$idmodulo_sh_dimension){
        $ayudante = new Ayudante();
        
        $this->sql->consultar("START TRANSACTION","sgrc");

        $error=0;
        
        $fecha_a= date('Y-m-d H:i:s');

        
        $consulta="UPDATE
                      sh_dimension
                   SET
                      `fecha_a`='$fecha_a',activo=0, ultimo=0
                   WHERE
                     idsh_dimension=$idsh_dimension
                     and idmodulo_sh_dimension=$idmodulo_sh_dimension";
                
        //echo $consulta;
        
        if(!$this->sql->consultar($consulta,"sgrc")){
            $error++;
            //echo $consulta;
        }
        
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }

       //actualizar último
        
        $consulta = "select `sh_dimension`.`idsh_dimension`, `sh_dimension`.`idmodulo_sh_dimension`
                    from `sh_dimension`
                    where `sh_dimension`.`idsh`=$idpersona and `sh_dimension`.`idmodulo`=$idmodulo
                    and `sh_dimension`.`activo` = 1
                    order by fecha desc, fecha_a desc
                    limit 1";
        
        $result = $this->sql->consultar($consulta,"sgrc");
        
        if($fila = mysql_fetch_array($result)){
            
            $idsh_dimension = $fila['idsh_dimension'];
            $idmodulo_sh_dimension = $fila['idmodulo_sh_dimension'];
            
            $fecha_a= date('Y-m-d H:i:s');
            
            $consulta       ="update `sh_dimension`
                              set `fecha_a`='$fecha_a',`sh_dimension`.`ultimo`=1
                              where `sh_dimension`.`idsh_dimension`=$idsh_dimension
                              and `sh_dimension`.`idmodulo_sh_dimension`=$idmodulo_sh_dimension";
            
            if(!$this->sql->consultar($consulta,"sgrc")){
                    $error++;
                    //echo $consulta;
            }     
        
            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
                
            }
                             
            $consulta = "select sum(dimension_matriz_sh_valor.puntaje) as 'importancia'
                         from sh_dimension_matriz_sh join  dimension_matriz_sh_valor
                         on sh_dimension_matriz_sh.idsh_dimension_matriz_sh_valor = dimension_matriz_sh_valor.iddimension_matriz_sh_valor
                         where sh_dimension_matriz_sh.idsh_dimension=$idsh_dimension
                         and sh_dimension_matriz_sh.idmodulo_sh_dimension=$idmodulo_sh_dimension
                         and dimension_matriz_sh_valor.iddimension_matriz_sh > 1 ";
            
            $result = $this->sql->consultar($consulta,"sgrc");
            
            $fila = mysql_fetch_array($result);
            
            $importancia = $fila['importancia'];
                                                                       
        }else{
            $importancia=0;
        }
        
        //actualizar importancia
        
            $fecha_a= date('Y-m-d H:i:s');
            
            $consulta="UPDATE sh SET `fecha_a`='$fecha_a',importancia=$importancia 
                  WHERE  idsh=$idpersona
                  AND idmodulo=$idmodulo";

            //echo $consulta;
            if(!$this->sql->consultar($consulta,"sgrc")){
                        $error++;
                        //echo $consulta;
            }     

            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }

        
        
        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
                }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }          

        return $error;
    }

}

?>