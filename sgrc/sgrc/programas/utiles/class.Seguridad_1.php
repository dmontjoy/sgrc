<?php

class Seguridad {
	
	function Seguridad(){
		
	}

	function verificaSesion(){

		session_start();
		if(session_is_registered("usuario")){
			return true;
		}else{
			return false;
		}

	}
}

?>
