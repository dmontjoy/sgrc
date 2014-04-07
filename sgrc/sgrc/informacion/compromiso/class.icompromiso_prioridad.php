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
class icompromiso_prioridad {
    //put your code here
    public $sql;
	
    function icompromiso_prioridad(){
            $this->sql = new DmpSql();
    }  
    
   

    function lista_compromiso_prioridad(){
        
        $consulta="SELECT 
                      `compromiso_prioridad`.`idcompromiso_prioridad`,
                      `compromiso_prioridad`.`compromiso_prioridad`,
                      `compromiso_prioridad`.`activo`
                    FROM
                      `compromiso_prioridad` 
                    WHERE
                        compromiso_prioridad.activo= 1
                    ORDER BY `compromiso_prioridad`.`orden`
                      ";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    

    
    
    
   
}

?>
