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
class iinteraccion_tipo {
    //put your code here
    public $sql;
	
    function iinteraccion_tipo(){
            $this->sql = new DmpSql();
    }  
    
    



    function lista_interaccion_tipo(){
        
        $consulta="SELECT 
                      `interaccion_tipo`.`idinteraccion_tipo`,
                      `interaccion_tipo`.`interaccion_tipo`,
                      `interaccion_tipo`.`activo`
                    FROM
                      `interaccion_tipo`
                     ORDER BY
                     `interaccion_tipo`.`interaccion_tipo`";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    

    
    
    
   
}

?>
