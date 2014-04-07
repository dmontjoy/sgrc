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
class gmigracion {
    //put your code here
    public $sql;

    function gmigracion(){
        $this->sql = new DmpSql();
    }


    function generar_migracion(){
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;
        $idmigracion=0;
        $fecha_ini=date("Y-m-d H:i:s");

            $consulta="INSERT INTO
              migracion(
              idmodulo_migracion,
              fecha_ini
              )
            VALUES(".
              $_SESSION[idmodulo].",
                  '$fecha_ini')";

        //echo $consulta;


            if(!$this->sql->consultar($consulta,"sgrc")){
                $error++;
            }


            $idmigracion=$this->sql->idtabla();

            $consulta="UPDATE
                            migracion_detalle
                            SET idmigracion=$idmigracion
                        WHERE
                            idmigracion IS NULL
                        AND
                            idmodulo_migracion=".$_SESSION[idmodulo];

        //echo $consulta;


            if(!$this->sql->consultar($consulta,"sgrc")){
                $error++;
            }

        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
        }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }

        return $idmigracion;
    }

    function registra_migracion($idmigracion,$idmodulo){
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;
        $fecha_ini=date("Y-m-d H:i:s");

            $consulta="INSERT INTO
              migracion(
              idmigracion,
              idmodulo_migracion,
              fecha_ini
              )
            VALUES(
              $idmigracion,
              $idmodulo,
              '$fecha_ini');";




            if(!$this->sql->consultar($consulta,"sgrc")){
                $error++;
                //echo $consulta;
            }


            $consulta="UPDATE
                            migracion_detalle
                            SET idmigracion=$idmigracion,
                            idmodulo_migracion=$idmodulo
                        WHERE
                            idmigracion IS NULL ";

        //echo $consulta;


            if(!$this->sql->consultar($consulta,"sgrc")){
                $error++;
            }

        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
        }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }

    }


     function actualiza_archivo_cliente($idmigracion,$idmodulo,$archivo_cliente){
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;
        $cantidad=0;



        $consulta=" UPDATE migracion
                    SET archivo_cliente='$archivo_cliente'
                    WHERE idmigracion=$idmigracion
                    AND idmodulo_migracion=".$idmodulo;

        //echo $consulta;


        if(!$this->sql->consultar($consulta,"sgrc")){
            $error++;
        }



        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
        }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }


    }

    function actualiza_archivo_servidor($idmigracion,$idmodulo,$archivo_servidor){
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;
        $cantidad=0;



        $consulta=" UPDATE migracion
                    SET archivo_servidor='$archivo_servidor'
                    WHERE idmigracion=$idmigracion
                    AND idmodulo_migracion=".$idmodulo;

        //echo $consulta;


        if(!$this->sql->consultar($consulta,"sgrc")){
            $error++;
        }



        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
        }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }


    }

    function registrar_modulo_migracion($idmigracion,$idmodulo_migracion,$idmodulo){
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;

        $consulta="INSERT INTO
          modulo_migracion(
          idmigracion,
          idmodulo_migracion,
          idmodulo
          )
        VALUES(
          $idmigracion,
          $idmodulo_migracion,
          $idmodulo)";

        //echo $consulta;

        if(!$this->sql->consultar($consulta,"sgrc")){
            $error++;
        }

        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
                }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }

        return $error;
    }

     function finaliza_migracion($idmigracion,$idmodulo){
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;
        $cantidad=0;

        $fecha_fin=date("Y-m-d H:i:s");

        $consulta=" UPDATE migracion
                    SET migrando=0,
                    resultado = 1,
                    fecha_fin='$fecha_fin'
                    WHERE idmigracion=$idmigracion
                    AND idmodulo_migracion=".$idmodulo;

        //echo $consulta;


        if(!$this->sql->consultar($consulta,"sgrc")){
            $error++;
        }



        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
        }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }


    }


        function restaurar_migracion($idmigracion,$idmodulo){
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;

        $fecha_fin=date("Y-m-d H:i:s");

            $consulta="UPDATE
                            migracion_detalle
                            SET idmigracion=NULL
                        WHERE
                            idmigracion=$idmigracion
                            AND idmodulo_migracion=$idmodulo ";

        //echo $consulta;


            if(!$this->sql->consultar($consulta,"sgrc")){
                $error++;
            }


        $consulta=" UPDATE migracion
                    SET migrando=0,
                    resultado = 0,
                    fecha_fin = '$fecha_fin'
                    WHERE idmigracion=$idmigracion
                    AND idmodulo_migracion=".$idmodulo;

        //echo $consulta;


        if(!$this->sql->consultar($consulta,"sgrc")){
            $error++;
        }

        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
        }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }

    }

    function registra_migracion_archivo($idmigracion,$idmodulo,$nombre_archivo){
         ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;

        $consulta="INSERT INTO
          migracion_archivo(
          idmigracion,
          idmodulo_migracion,
          nombre_archivo
          )
        VALUES(
          $idmigracion,
          $idmodulo,
          '$nombre_archivo')";

        //echo $consulta;

        if(!$this->sql->consultar($consulta,"sgrc")){
            $error++;
        }

        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
                }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }

        return $error;
    }

     function actualiza_migracion_archivo($idmigracion_archivo,$idmigracion,$idmodulo_migracion){
        ///////////////////////////////////////////////////
        $this->sql->consultar("START TRANSACTION","sgrc");
        $error=0;
        $cantidad=0;



        $consulta=" UPDATE migracion_archivo
                    SET migrado=1
                    WHERE idmigracion_archivo=$idmigracion_archivo
                    AND idmigracion=$idmigracion
                    AND idmodulo_migracion=".$idmodulo_migracion;

        //echo $consulta;


        if(!$this->sql->consultar($consulta,"sgrc")){
            $error++;
        }



        if($error==0){
            $this->sql->consultar("COMMIT","sgrc");
        }else{
            $this->sql->consultar("ROLLBACK","sgrc");
        }


    }



}

?>
