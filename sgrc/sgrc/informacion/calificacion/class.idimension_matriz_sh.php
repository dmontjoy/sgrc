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
class idimension_matriz_sh {
    //put your code here
    public $sql;
	
    function idimension_matriz_sh(){
            $this->sql = new DmpSql();
    }  
    
   

    function lista_dimension_matriz_sh($idpersona,$idmodulo){
        
        $consulta="SELECT 
                      sh_dimension_matriz_sh.idsh_dimension_matriz_sh,
                      sh_dimension_matriz_sh.idsh_dimension,
                      sh_dimension.idsh,
                      sh_dimension.`idmodulo`,
                      sh_dimension.`comentario`,
                      dimension_matriz_sh_valor.valor,
                      dimension_matriz_sh_valor.iddimension_matriz_sh,
                      `dimension_matriz_sh`.`dimension`                                       
                    FROM
                      `sh_dimension` LEFT JOIN  sh_dimension_matriz_sh                    
                    ON
                    `sh_dimension_matriz_sh`.`idsh_dimension`=`sh_dimension`.`idsh_dimension`
                    and `sh_dimension_matriz_sh`.`idmodulo_sh_dimension`=`sh_dimension`.`idmodulo_sh_dimension`                    
                    LEFT JOIN 
                      dimension_matriz_sh_valor
                    ON
                    sh_dimension_matriz_sh.idsh_dimension_matriz_sh_valor=dimension_matriz_sh_valor.iddimension_matriz_sh_valor
                    LEFT JOIN
                    `dimension_matriz_sh`
                    ON
                    `dimension_matriz_sh_valor`.`iddimension_matriz_sh`=`dimension_matriz_sh`.`iddimension_matriz_sh`                    
                    WHERE                     
                      sh_dimension.activo=1
                    AND
                      sh_dimension.idsh=$idpersona
                    AND
                      sh_dimension.idmodulo=$idmodulo
                    AND sh_dimension.ultimo=1";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista_dimension(){
        
        $consulta="SELECT 
                      dimension_matriz_sh.iddimension_matriz_sh,
                      dimension_matriz_sh.dimension
                      
                    FROM
                      dimension_matriz_sh
                    ORDER BY
                      dimension_matriz_sh.iddimension_matriz_sh
                    ASC";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }

     function lista_dimension_valor($iddimension){
        
        $consulta="SELECT 
                      dimension_matriz_sh_valor.iddimension_matriz_sh_valor,
                      dimension_matriz_sh_valor.valor,
                      dimension_matriz_sh_valor.puntaje
                      
                    FROM
                      dimension_matriz_sh_valor
                    WHERE
                      dimension_matriz_sh_valor.iddimension_matriz_sh=$iddimension

                    ";
        //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }

    function lista_dimension_puntaje($iddimension){
        
        $consulta="SELECT 
                      dimension_matriz_sh_valor.iddimension_matriz_sh_valor,
                      dimension_matriz_sh_valor.valor,
                      dimension_matriz_sh_valor.puntaje,
                      dimension_matriz_sh_valor.comentario
                      
                    FROM
                      dimension_matriz_sh_valor
                    WHERE
                      dimension_matriz_sh_valor.iddimension_matriz_sh=$iddimension
                    AND
                      dimension_matriz_sh_valor.puntaje IS NOT NULL


                    ";
        //echo $consulta;
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }
    
    function lista_dimension_matriz_sh_valor(){
        
        $consulta="SELECT 
                      
                      dimension_matriz_sh_valor.puntaje
                      
                    FROM
                      dimension_matriz_sh_valor";
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }


     function lista_calificacion($idpersona,$idmodulo,$fecha_del,$fecha_al){
         if($fecha_del!=""){
             $cfecha_del="AND sh_dimension.fecha>='$fecha_del'";
         }
         
         if($fecha_al!=""){
             $cfecha_al="AND sh_dimension.fecha<='$fecha_al'";
         }
        
        $consulta="SELECT                      
                    `sh_dimension`.`idsh_dimension`,
                    `sh_dimension`.`idmodulo_sh_dimension`,
                    sh_dimension.fecha,
                     (
                        SELECT  `dimension_matriz_sh_valor`.`puntaje` 
                        from  sh_dimension_matriz_sh                        
                        left join `dimension_matriz_sh_valor`
                        on sh_dimension_matriz_sh.idsh_dimension_matriz_sh_valor=dimension_matriz_sh_valor.iddimension_matriz_sh_valor
                        left join dimension_matriz_sh
                        on dimension_matriz_sh.iddimension_matriz_sh=dimension_matriz_sh_valor.iddimension_matriz_sh
                        where
                        sh_dimension.idsh_dimension=sh_dimension_matriz_sh.idsh_dimension
                        and 
                        sh_dimension.idmodulo_sh_dimension=sh_dimension_matriz_sh.idmodulo_sh_dimension
                        and dimension_matriz_sh.iddimension_matriz_sh=1
                        limit 1
                        
                    ) as posicion,
                    (
                        SELECT  `dimension_matriz_sh_valor`.`puntaje` 
                        from  sh_dimension_matriz_sh                        
                        left join `dimension_matriz_sh_valor`
                        on sh_dimension_matriz_sh.idsh_dimension_matriz_sh_valor=dimension_matriz_sh_valor.iddimension_matriz_sh_valor
                        left join dimension_matriz_sh
                        on dimension_matriz_sh.iddimension_matriz_sh=dimension_matriz_sh_valor.iddimension_matriz_sh
                        where
                        sh_dimension.idsh_dimension=sh_dimension_matriz_sh.idsh_dimension
                        and 
                        sh_dimension.idmodulo_sh_dimension=sh_dimension_matriz_sh.idmodulo_sh_dimension
                        and dimension_matriz_sh.iddimension_matriz_sh=2
                        limit 1
                        
                    ) as poder,
                    (
                        SELECT  `dimension_matriz_sh_valor`.`puntaje` 
                        from  sh_dimension_matriz_sh                        
                        left join `dimension_matriz_sh_valor`
                        on sh_dimension_matriz_sh.idsh_dimension_matriz_sh_valor=dimension_matriz_sh_valor.iddimension_matriz_sh_valor
                        left join dimension_matriz_sh
                        on dimension_matriz_sh.iddimension_matriz_sh=dimension_matriz_sh_valor.iddimension_matriz_sh
                        where
                        sh_dimension.idsh_dimension=sh_dimension_matriz_sh.idsh_dimension
                        and 
                        sh_dimension.idmodulo_sh_dimension=sh_dimension_matriz_sh.idmodulo_sh_dimension
                        and dimension_matriz_sh.iddimension_matriz_sh=3
                        limit 1
                        
                    ) as interes
                    FROM
                      `sh_dimension` 
                    WHERE sh_dimension.activo=1 
                    $cfecha_del
                    $cfecha_al
                    AND sh_dimension.idsh=$idpersona 
                    AND sh_dimension.idmodulo=$idmodulo
                    ";
        
        //echo $consulta;
        
        $result = $this->sql->consultar( $consulta, "sgrc" );
               
        return $result;
    }

    
    
    
   
}

?>
