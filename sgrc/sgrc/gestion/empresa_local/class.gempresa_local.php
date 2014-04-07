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
class gempresa_local {
    //put your code here
   public $sql;


function gempresa_local() {
    $this->sql = new DmpSql();
}
function editar_movimiento( $idpersona,$idmodulo,$idperiodo,$idperiodo_sub) {

    $this->sql->consultar("START TRANSACTION", "sgrc");
    $error = 0;


    $fecha_c = date('Y-m-d H:i:s');

    $ayudante = new Ayudante();
    $consulta1="UPDATE movimiento SET activo=0 WHERE idperiodo=$idperiodo AND idsh='$idpersona' AND idmodulo='$idmodulo'";
        if (!$this->sql->consultar($consulta1, "sgrc")) {
            $error++;
        }

        $consulta_sincronizacion= $ayudante->migracion_update($consulta1);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
    $tama_idperiodo_sub = sizeof($idperiodo_sub);

    if ($tama_idperiodo_sub > 0) {
        $cabecera_consulta_insert= "INSERT INTO
        `movimiento`(
          `monto`,
          `idperiodo`,
          `idsh`,
          `idmodulo`,
          `activo`,
          `idperiodo_sub`,
          idmodulo_movimiento)
        VALUES";
        foreach ($idperiodo_sub as $id => $monto) {
            $consulta2.="($monto,$idperiodo,$idpersona,$idmodulo,1,$id,$_SESSION[idmodulo]),";

                                       // echo $consulta2="INSERT INTO movimiento SET monto=$monto, idperiodo=$idperiodo, idsh=$idpersona,idmodulo=$idmodulo, activo=1, idperiodo_sub=$id, idmodulo_movimiento=$_SESSION[idmodulo]";
        }


        $cabecera_consulta_insert.=$consulta2;
        $cabecera_consulta_insert = substr($cabecera_consulta_insert, 0, -1);
        //echo $cabecera_consulta_insert;
        if (!$this->sql->consultar($cabecera_consulta_insert, "sgrc")) {
            $error++;
                                    //echo $consulta;
        }
    }
    $idmovimiento=$this->sql->idtabla();

    $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idmovimiento",$idmovimiento,$cabecera_consulta_insert);

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
}
