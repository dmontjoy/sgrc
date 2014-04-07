<?php

class Seguridad {
    
    

    function Seguridad() {
         
    }

    function verificaSesion() {

        session_start();
        if (session_is_registered("idusu")) {
            return true;
        } else {
            return false;
        }
    }
    
    function verifica_permiso($accion,$objeto, $idusu_c, $idmodulo_c){
        /*
        if($objeto=="Stakeholder-Interes-Poder"){
            echo "$accion,$objeto, $_SESSION[idusu_c]==$idusu_c && $_SESSION[idmodulo_c]==$idmodulo_c";
            print_r($_SESSION[permiso]);
        }
         * 
         */
        if(isset($_SESSION[permiso][$accion][$objeto][$_SESSION[es_server]])){
            return true;
        }else{
            if( $_SESSION["idusu_c"]==$idusu_c && $_SESSION["idmodulo_c"]==$idmodulo_c)
                return true;
            else
                return false;
            
        }
        
    }
    
    
}

?>
