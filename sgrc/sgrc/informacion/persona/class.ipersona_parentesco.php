<?php


class ipersona_parentesco {

//put your code here
    public $sql;

    function ipersona_parentesco() {
        $this->sql = new DmpSql();
    }
    
    function get_persona_parentesco(){
        
        $consulta="SELECT  idpersona_parentesco, descripcion,activo FROM persona_parentesco WHERE activo=1";
        
        $result = $this->sql->consultar($consulta, "sgrc");
        
        return $result;
        
    }

}

?>