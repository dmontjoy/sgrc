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
class icompromiso_estado {
    //put your code here
    public $sql;
	
    function icompromiso_estado(){
            $this->sql = new DmpSql();
    }  
    
   

    function lista_compromiso_estado(){
        
        $consulta="SELECT 
                      `compromiso_estado`.`idcompromiso_estado`,
                      `compromiso_estado`.`compromiso_estado`,
                      `compromiso_estado`.`activo`
                    FROM
                      `compromiso_estado` 
                    WHERE
                        compromiso_estado.activo= 1
                    ORDER BY `compromiso_estado`.`orden`
                      ";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    

    
    
    
   
}

?>
