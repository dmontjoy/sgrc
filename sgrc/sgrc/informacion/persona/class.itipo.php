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
class itipo {
    //put your code here
    public $sql;
	
    function itipo(){
            $this->sql = new DmpSql();
    }   
    function lista_persona_tipo(){
        
            $consulta="SELECT 
                      `persona_tipo`.`idpersona_tipo`,
                      `persona_tipo`.`tipo`,
                      `persona_tipo`.`activo`
                    FROM
                      `persona_tipo`
                 WHERE 
                   `persona_tipo`.`activo`=1 ";
            
               $result = $this->sql->consultar( $consulta, "sgrc" );
               
               return $result;
    }

   
}

?>
