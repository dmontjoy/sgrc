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
class iinteraccion_estado {
    //put your code here
    public $sql;
	
    function iinteraccion_estado(){
            $this->sql = new DmpSql();
    }  
    
   

    function lista_interaccion_estado(){
        
        $consulta="SELECT 
                      `interaccion_estado`.`idinteraccion_estado`,
                      `interaccion_estado`.`interaccion_estado`,
                      `interaccion_estado`.`activo`
                    FROM
                      `interaccion_estado` ORDER BY `interaccion_estado`.`interaccion_estado`
                      ";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    

    
    
    
   
}

?>
