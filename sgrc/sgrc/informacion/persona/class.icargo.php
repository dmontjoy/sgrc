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
class icargo {
    //put your code here
    public $sql;
	
    function icargo(){
            $this->sql = new DmpSql();
    }   
    function lista_cargo(){
        
            $consulta="SELECT 
                  `persona_cargo`.`idpersona_cargo`,
                  `persona_cargo`.`cargo`,
                  `persona_cargo`.`activo`
                FROM
                  `persona_cargo`
                                 WHERE 
                                   `persona_cargo`.`activo`=1 ";
            
               $result = $this->sql->consultar( $consulta, "sgrc" );
               
               return $result;
    }

   
}

?>
