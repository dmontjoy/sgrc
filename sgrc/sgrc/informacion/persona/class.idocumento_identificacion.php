<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of idocumento_identificacion
 *
 * @author dmontjoy
 */
class idocumento_identificacion {
    //put your code here
    public $sql;
	
    function idocumento_identificacion(){
            $this->sql = new DmpSql();
    }   
    function lista_documento_identificacion(){
        
            $consulta="SELECT 
                  `documento_identificacion`.`iddocumento_identificacion`,
                  `documento_identificacion`.`documento_identificacion`,
                  `documento_identificacion`.`activo`
                FROM
                  `documento_identificacion`
                 WHERE 
                   `documento_identificacion`.`activo`=1 ";
            
               $result = $this->sql->consultar( $consulta, "sgrc" );
               
               return $result;
    }

   
}

?>
