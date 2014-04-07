<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class
 *
 * @author dmontjoy
 */
class ipredio_tipo_tenencia {
//put your code here
        //put your code here
    public $sql;

    function ipredio_tipo_tenencia() {
        $this->sql = new DmpSql();
    }
    

     function lista() {          
           $sql="SELECT 
                    `predio_tipo_tenencia`.`idpredio_tipo_tenencia`,
                    `predio_tipo_tenencia`.`descripcion`,
                    `predio_tipo_tenencia`.`activo`
                  FROM
                     `predio_tipo_tenencia` 
                   WHERE
                      (predio_tipo_tenencia.activo=1 OR isnull(predio_tipo_tenencia.activo))
                   ORDER BY
                   predio_tipo_tenencia.orden ASC";

        //echo $sql;
        $result = $this->sql->consultar($sql, "sgrc");
     
        return $result;
    }

}
