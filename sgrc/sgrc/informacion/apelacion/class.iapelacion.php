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
class iapelacion {
    //put your code here
    public $sql;
	
    function iapelacion(){
            $this->sql = new DmpSql();
    }  
    
    
    function get_apelacion($idapelacion,$idmodulo_apelacion){
        
        $consulta="SELECT 
                      `apelacion`.`apelacion`,
                      DATE_FORMAT(apelacion.fecha,'%d/%m/%Y') AS fecha,
                      evaluacion.idreclamo,
                      evaluacion.idmodulo_reclamo
                    FROM
                      `apelacion`
                    LEFT JOIN evaluacion
                    ON apelacion.idevaluacion = evaluacion.idevaluacion
                    AND apelacion.idmodulo_evaluacion = evaluacion.idmodulo_evaluacion
                    WHERE
                    `apelacion`.`idapelacion`=$idapelacion
                     AND `apelacion`.`idmodulo_apelacion`=$idmodulo_apelacion
                     ";
        //echo $consulta;
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
   function lista_archivo($idapelacion,$idmodulo){
        
        $consulta="SELECT 
                      `apelacion_archivo`.`idapelacion_archivo`,  
                      `apelacion_archivo`.`idmodulo_apelacion_archivo`,  
                      `apelacion_archivo`.`archivo`,
                      `apelacion_archivo`.`fecha`,
                      `apelacion_archivo`.`activo`
                      
                    FROM
                      `apelacion_archivo`
                      
                    WHERE
                    `apelacion_archivo`.`idapelacion` = $idapelacion AND
                    `apelacion_archivo`.`idmodulo_apelacion` = $idmodulo AND
                    `apelacion_archivo`.`activo` = 1 ";
      // echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
   
}

?>
