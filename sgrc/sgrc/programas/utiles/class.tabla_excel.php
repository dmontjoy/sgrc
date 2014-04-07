<?php
class tabla_excel{
    private $tabla="";
    private $array_filas= array();
    private $cont=0;

    function tabla_excel($formato=''){
        $this->tabla.="<table ".$formato.">";
    }

    function armar_celda($dato,$formato=''){
       return "<td ".$formato.">".$dato."</td>";
    }

    function armar_fila($array,$posicion=-1,$formato=''){
        $aux;
       
        $this->array_filas[$this->cont]="<tr ".$formato.">";
        for($i=0;$i<SizeOf($array["valor"]);$i++){
            $this->array_filas[$this->cont].= $this->armar_celda($array["valor"][$i],$array["formato"][$i]);
        }
        $this->array_filas[$this->cont].="</tr>";
        if($posicion>-1){
            $aux=$this->array_filas[$this->cont];
            if(SizeOf($array["valor"])>0){
                for($j=$this->cont;$j>=$posicion;$j--){
                    //echo $j." ".$posicion."<br>";
                    $this->array_filas[$j]=$this->array_filas[$j-1];
               }
               $this->array_filas[$posicion]=$aux;
            }
            //$this->array_filas[$posicion]=$this->array_filas[$this->cont];
        }
        $this->cont++;
    }

    function final_tabla(){
        $this->tabla.="</table>";
    }

    function get_tabla(){
        for($i=0;$i<SizeOf($this->array_filas);$i++){
            $this->tabla.=$this->array_filas[$i];
        }
        $this->tabla.=$this->final_tabla();
        return $this->tabla;
    }

    function genera_excel($nombre_archivo='prueba'){
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=$nombre_archivo.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}
?>