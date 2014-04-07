<?php
include_once '../../include_utiles.php';


$this->sql = new DmpSql();


$consulta   ="SELECT apellido_p from persona1";

$this->sql->consultar( $consulta, "sgrc" );

$consulta_1 ="SELECT apellido_p from persona1";
// palabra de entrada mal escrita

$result_1 = $this->sql->consultar( $consulta_1, "sgrc" );


while($fila=mysql_fetch_array($result)){

    while($fila_1=  mysql_affected_array($result_1)){
        $porc   =100;
        $lev    =levenshtein($fila[apellido_p], $fila_1[apellido_m]);
        $tama   =strlen($fila[apellido_p]);
        $tama_1 =strlen($fila_1[apellido_p]);
        if($lev>0){
                if($tama>$tama_1){$tamanio=$tama;}else{$tamanio=$tama_1;}
                $porc=(1-$tama)*100;
         }
        if($porc>80){
            echo $fila[apellido_p]."....".$fila_1[apellido_m]."....".$porc;

        }

    }

}
?>