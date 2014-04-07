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
class ipropuesta {
    //put your code here
    public $sql;
	
    function ipropuesta(){
            $this->sql = new DmpSql();
    }  
    
    
    function get_propuesta($idpropuesta,$idmodulo_propuesta){
        
        $consulta="SELECT 
                      `propuesta`.`propuesta`,
                      `propuesta`.`comentario_realizado`,
                      `propuesta`.`se_cumple`,
                      DATE_FORMAT(propuesta.fecha,'%d/%m/%Y') AS fecha,
                      evaluacion.idreclamo,
                      evaluacion.idmodulo_reclamo
                    FROM
                      `propuesta`
                    LEFT JOIN evaluacion
                    ON propuesta.idevaluacion = evaluacion.idevaluacion
                    AND propuesta.idmodulo_evaluacion = evaluacion.idmodulo_evaluacion
                    WHERE
                    `propuesta`.`idpropuesta`=$idpropuesta
                     AND `propuesta`.`idmodulo_propuesta`=$idmodulo_propuesta
                     ";
        //echo $consulta;
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
   function lista_archivo($idpropuesta,$idmodulo){
        
        $consulta="SELECT 
                      `propuesta_archivo`.`idpropuesta_archivo`,  
                      `propuesta_archivo`.`idmodulo_propuesta_archivo`,  
                      `propuesta_archivo`.`archivo`,
                      `propuesta_archivo`.`fecha`,
                      `propuesta_archivo`.`activo`
                      
                    FROM
                      `propuesta_archivo`
                      
                    WHERE
                    `propuesta_archivo`.`idpropuesta` = $idpropuesta AND
                    `propuesta_archivo`.`idmodulo_propuesta` = $idmodulo AND
                    `propuesta_archivo`.`activo` = 1 ";
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
   
}

?>
