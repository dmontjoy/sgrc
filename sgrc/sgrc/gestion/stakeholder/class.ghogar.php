<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author daniel.montjoy
 */
class ghogar {
    /* var $fecha_hogar;
      var $comentario_hogar;
      var $idpersona;
      var $idmodulo;
      var $idhogar_complejo_sh = array(); */

//put your code here
    function ghogar() {
        $this->sql = new DmpSql();
    }

    function eliminar($idsh_hogar, $idmodulo_sh_hogar) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $consulta = "UPDATE sh_hogar SET activo =0 WHERE idsh_hogar=$idsh_hogar AND idmodulo_sh_hogar=$idmodulo_sh_hogar";
        //echo $consulta;
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
        }

        $consulta_sincronizacion = $ayudante->migracion_update($consulta);

        if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
            $error++;
        }
        $consulta_1 = "UPDATE sh_hogar set activo=0 WHERE idsh_hogar=$idsh_hogar AND idmodulo_sh_hogar=$idmodulo_sh_hogar";
        //echo $consulta_1;
        if (!$this->sql->consultar($consulta_1, "sgrc")) {
            $error++;
        }

        $consulta_sincronizacion = $ayudante->migracion_update($consulta_1);

        if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
            $error++;
        }

        //echo "error :".$error;
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        //exit;
        //return $error;       
    }

    function editar($idsh_hogar, $idmodulo_sh_hogar, $fecha_hogar, $comentario_hogar, $idpersona, $idmodulo, $idhogar_complejo_sh,$idpersona_parentesco) {
        $ayudante = new Ayudante();
        $fecha_hogar = $ayudante->FechaRevezMysql($fecha_hogar, "/");
        $fecha_a = date('Y-m-d');
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $consulta_hogar = "UPDATE
              `sh_hogar` SET
              `fecha`='$fecha_hogar',
              `idusu_a`=$_SESSION[idusu_c],
              `idmodulo_a`=$_SESSION[idmodulo_c],
              `fecha_a` = '$fecha_a',
               comentario = '$comentario_hogar' 
               WHERE
                idsh_hogar=$idsh_hogar AND idmodulo_sh_hogar=$idmodulo_sh_hogar
               ";

        if (!$this->sql->consultar($consulta_hogar, "sgrc")) {
            $error++;
            echo $consulta_hogar;
            //echo $error;
        }
        $consulta_sincronizacion = $ayudante->migracion_update($consulta_hogar);

        if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
            $error++;
        }
 
        /****elimando todos los anteriores****/
          $consulta_hogar = "UPDATE
              `sh_hogar_sh` 
              SET
                activo=0
               WHERE
                idsh_hogar=$idsh_hogar AND idmodulo_sh_hogar=$idmodulo_sh_hogar
               ";
        // echo $consulta_hogar;
        if (!$this->sql->consultar($consulta_hogar, "sgrc")) {
            $error++;
            echo $consulta_hogar;
            //echo $error;
        }
        $consulta_sincronizacion = $ayudante->migracion_update($consulta_hogar);

        if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
            $error++;
        }
        
        
        /*****insertando nuevos****/
        $tama_idhogar_complejo = sizeof($idhogar_complejo_sh);


        if ($tama_idhogar_complejo > 0) {
            /*
              fecha_c,
              idusu_c,
              idmodulo_c,
             *              */
            $consulta_sh = "INSERT INTO
                                  `sh_hogar_sh`(
                                   `idmodulo_sh_hogar_sh`,
                                   idsh,
                                   idmodulo,
                                  `activo`,
                                  idsh_hogar,
                                  idmodulo_sh_hogar,
                                  idpersona_parentesco)
                                VALUES";

            for ($i = 0; $i < $tama_idhogar_complejo; $i++) {


                //vienen varios
                if (!strpos($idhogar_complejo_sh[$i], "###")) {
                    $aux_idhogar_sh = explode("---", $idhogar_complejo_sh[$i]);

                    $consulta_sh.="($_SESSION[idmodulo],$aux_idhogar_sh[0],$aux_idhogar_sh[1],1,$idsh_hogar, $idmodulo_sh_hogar,$idpersona_parentesco[$i]),";
                }
            }
            //echo $consulta_sh;
            $consulta_sh = substr($consulta_sh, 0, -1);

            if (!$this->sql->consultar($consulta_sh, "sgrc")) {
                echo "consulta_sh: " . $consulta_sh;
                $error++;
            }

     
            $consulta_sincronizacion = $ayudante->migracion_insert_multiple("idsh_hogar_sh", $idsh_hogar, $consulta_sh);

            if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
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

    function agregar($fecha_hogar, $comentario_hogar, $idpersona, $idmodulo, $idhogar_complejo_sh,$idpersona_parentesco) {

        $ayudante = new Ayudante();
        $fecha_hogar = $ayudante->FechaRevezMysql($fecha_hogar, "/");
        $fecha_c = date('Y-m-d');
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $consulta_hogar = "INSERT INTO
              `sh_hogar`(
              `idmodulo_sh_hogar`,
              `fecha`,
              `activo`,
              `idusu_c`,
              `idmodulo_c`,
              `fecha_c`,
               comentario,
               idsh,
               idmodulo
               )
            VALUES(
              $_SESSION[idmodulo],
              '$fecha_hogar',
              1,
              $_SESSION[idusu_c],
              $_SESSION[idmodulo_c],
              '$fecha_c',
              '$comentario_hogar',
              $idpersona,
              $idmodulo)";

        if (!$this->sql->consultar($consulta_hogar, "sgrc")) {
            $error++;
            echo $consulta_hogar;
            //echo $error;
        }
        $idhogar = $this->sql->idtabla(); //obtener id de la tabla
        $consulta_sincronizacion = $ayudante->migracion_insert("idinteraccion", $idhogar, $consulta_hogar);
        if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
            $error++;
        }

        $tama_idhogar_complejo = sizeof($idhogar_complejo_sh);


        if ($tama_idhogar_complejo > 0) {
            /*
              fecha_c,
              idusu_c,
              idmodulo_c,
             *              */
            $consulta_sh = "INSERT INTO
                                  `sh_hogar_sh`(
                                   `idmodulo_sh_hogar_sh`,
                                   idsh,
                                   idmodulo,
                                  `activo`,
                                  idsh_hogar,
                                  idmodulo_sh_hogar,
                                  idpersona_parentesco)
                                VALUES";

            for ($i = 0; $i < $tama_idhogar_complejo; $i++) {


                //vienen varios
                if (!strpos($idhogar_complejo_sh[$i], "###")) {
                    $aux_idhogar_sh = explode("---", $idhogar_complejo_sh[$i]);

                    $consulta_sh.="($_SESSION[idmodulo],$aux_idhogar_sh[0],$aux_idhogar_sh[1],1,$idhogar,$_SESSION[idmodulo],$idpersona_parentesco[$i]),";
                }
            }
            $consulta_sh = substr($consulta_sh, 0, -1);

            if (!$this->sql->consultar($consulta_sh, "sgrc")) {
                echo "consulta_sh: " . $consulta_sh;
                $error++;
            }

            $idhogar_sh = $this->sql->idtabla();

            $consulta_sincronizacion = $ayudante->migracion_insert_multiple("idsh_hogar_sh", $idhogar_sh, $consulta_sh);

            if (!$this->sql->consultar($consulta_sincronizacion, "sgrc")) {
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
