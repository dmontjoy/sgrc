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
class ireclamo_tipo {
    //put your code here
    public $sql;
	
    function ireclamo_tipo(){
            $this->sql = new DmpSql();
    }  
    
    



    function lista_reclamo_tipo(){
        
        $consulta="SELECT 
                      `reclamo_tipo`.`idreclamo_tipo`,
                      `reclamo_tipo`.`tipo`,
                      `reclamo_tipo`.`activo`
                    FROM
                      `reclamo_tipo`
                    WHERE
                    activo=1
                     ORDER BY
                     `reclamo_tipo`.`tipo`";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    

    
    
    
   
}

?>
