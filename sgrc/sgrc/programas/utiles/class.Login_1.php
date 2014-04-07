<?php

class Login {

	var $sql;
	
	function Login(){
		$this->sql = new DmpSql();
	}

	function valida($usuario, $pass){
		
		$pass=strip_tags(trim($pass));
		$usuario=strip_tags(trim($usuario));		
		
		$sql="SELECT
			idusuario
		FROM
		  usuario
		  where 
		usuario.`usuario` ='$usuario' and usuario.clave=MD5('$pass')";

		$res = $this->sql->consultar($sql,"sigh");
		$datos = mysql_fetch_array($res);

		if(sizeof($datos[idusuario])>0){
				if($this->creaSesion($datos[idusuario])){
					return true;	
				}else{
					session_destroy();
					return false;
				}
			}else{
				return false;
		}
        
	}

	function creaSesion($usuario){

	$sql="SELECT
		  persona.nombres,
		  persona.apellido_p,
		  persona.apellido_m,
		  persona.fecha_nacimiento,
		  usuario.idmodulo_sistema,
		  usuario.usuario,
		  usuario.idusuario as id_usu,
		  usuario.idseguridad_rol,
		  persona.idpersona
		FROM
		  usuario
		  INNER JOIN persona ON (usuario.idusuario = persona.idpersona)
		WHERE
		  usuario.idusuario='$usuario'";

		$res = $this->sql->consultar($sql,"sigh");
		$datos = mysql_fetch_array($res);
		// destruyo la session antes de crearla para no tener problemas
		if(session_is_registered("usuario")){
			session_start();
			session_destroy();
		}			
		session_start();
		$_SESSION["id_usu"]=$datos['id_usu'];
		$_SESSION["usuario"] = $datos['usuario'];
		$_SESSION["nombres"] = strtoupper($datos['nombres']);
		$_SESSION["apellido_p"] = strtoupper($datos['apellido_p']);
		$_SESSION["apellido_m"] = strtoupper($datos['apellido_m']);
		$_SESSION["fecha_nacimiento"] = $datos['fecha_nacimiento'];
        $_SESSION["idmodulo_sistema"] = $datos['idmodulo_sistema'];
		$_SESSION["idseguridad_rol"] = $datos['idseguridad_rol']; //pone la sesion
		$_SESSION["idpersona"] = $datos['idpersona'];
		$_SESSION["id_session"] =  session_id();
		//si no es modulo de paciente, es un trabajador o un tercero
		//(farmacia, logistica,convenio,admision)
		$flag_sesion=1;
        //lugar_admision lo manejo en gadmision_servicio para guardar els ervicio
		//la session ya ta creada
		switch ($datos['idmodulo_sistema']) {
            case 13:
 				$sql="SELECT
					  lugar.idlugar,
					  lugar.nombre
					FROM
					  lugar
					  INNER JOIN tipo_lugar ON (lugar.idtipo_lugar = tipo_lugar.idtipo_lugar)
					  INNER JOIN personal_lugar ON (personal_lugar.idlugar = lugar.idlugar)
					WHERE
					  personal_lugar.idpersonal = '$usuario' AND  lugar.idlugar='88'";
                $res = $this->sql->consultar($sql,"sigh");
				$fila = mysql_fetch_array($res);
				if(empty($fila[idlugar])){
					$flag_sesion=0;
				}else{
					$_SESSION["nombre_lugar"] = $fila[nombre];
					$_SESSION["lugar_archivo"] =  $fila[idlugar];
                   // $_SESSION["idcp_origen"]=1;
				}
                break;
			case 5:
				//farmacia tipo de lugar 4
				//da como resultado un lugar
				$sql="SELECT
					  lugar.idlugar,
					  lugar.nombre
					FROM
					  lugar
					  INNER JOIN tipo_lugar ON (lugar.idtipo_lugar = tipo_lugar.idtipo_lugar)
					  INNER JOIN personal_lugar ON (personal_lugar.idlugar = lugar.idlugar)
					WHERE
					  tipo_lugar.idtipo_lugar = 4 and
					  personal_lugar.idpersonal = '$usuario'";

				$res = $this->sql->consultar($sql,"sigh");
				$fila = mysql_fetch_array($res);
				if(empty($fila[idlugar])){
					$flag_sesion=0;
				}else{
					$_SESSION["nombre_farmacia"] = $fila[nombre];
					$_SESSION["lugar_farmacia"] =  $fila[idlugar];
                    $_SESSION["idcp_origen"]=1;
				}
			break;
			case 10:
				//logistica
				//da como resultado dos lugares, pero el que interesa es farmacia
				// 4 es el id para farmacia
				$sql="SELECT 
					  lugar.idlugar
					FROM
					  lugar
					  INNER JOIN tipo_lugar ON (lugar.idtipo_lugar = tipo_lugar.idtipo_lugar)
					  INNER JOIN personal_lugar ON (personal_lugar.idlugar = lugar.idlugar)
					  INNER JOIN personal ON (personal.idpersonal = personal_lugar.idpersonal)
					WHERE
					  personal.idpersonal = '$usuario' AND 
					  tipo_lugar.idtipo_lugar=4";
				
				$res = $this->sql->consultar($sql,"sigh");
				$fila = mysql_fetch_array($res);
				$_SESSION["lugar_farmacia"] =  $fila[idlugar];
				
			break;
			case 7:
				//convenio
				// 4 es de farmacia y 12 de admision
				$sql="SELECT 
					  lugar.idlugar
					  tipo_lugar.idtipo_lugar
					FROM
					  lugar
					  INNER JOIN tipo_lugar ON (lugar.idtipo_lugar = tipo_lugar.idtipo_lugar)
					  INNER JOIN personal_lugar ON (personal_lugar.idlugar = lugar.idlugar)
					  INNER JOIN personal ON (personal.idpersonal = personal_lugar.idpersonal)
					WHERE
					  personal.idpersonal = '$usuario' AND 
					  tipo_lugar.idtipo_lugar=4 or tipo_lugar.idtipo_lugar=12";
				
				$res = $this->sql->consultar($sql,"sigh");
				while($fila = mysql_fetch_array($res)){
					if($fila[idtipo_lugar]==4){
						$_SESSION["lugar_farmacia"] =  $fila[idlugar];
					}else{
						$_SESSION["lugar_admision"] =  $fila[idlugar];
					}		
				}	
			break;
			case 1:
				//admision
				$sql="SELECT 
					  lugar.idlugar,
                      lugar.nombre
					FROM
					  lugar
					  INNER JOIN tipo_lugar ON (lugar.idtipo_lugar = tipo_lugar.idtipo_lugar)
					  INNER JOIN personal_lugar ON (personal_lugar.idlugar = lugar.idlugar)
				
					WHERE
                      tipo_lugar.idtipo_lugar = 12 and
					  personal_lugar.idpersonal = '$usuario'";
				
				$res = $this->sql->consultar($sql,"sigh");
				$fila = mysql_fetch_array($res);
                if(empty($fila[idlugar])){
					$flag_sesion=0;
				}else{
                    $_SESSION["nombre_lugar"] = $fila[nombre];
                    $_SESSION["lugar_admision"] =  $fila[idlugar];
                    $_SESSION["idcp_origen"]=2;
                }
			break;
			case 2:
				//facturacion, he puesto la session de lugar en donde genero los comprobantes de facturacion
                //el tipo de lugar me ayuda a que tengan dos lugares..pensar'
				$sql="SELECT
					  lugar.idlugar,
                      lugar.nombre
					FROM
					  lugar
					  INNER JOIN tipo_lugar ON (lugar.idtipo_lugar = tipo_lugar.idtipo_lugar)
					  INNER JOIN personal_lugar ON (personal_lugar.idlugar = lugar.idlugar)

					WHERE
                      tipo_lugar.idtipo_lugar = 1 and
					  personal_lugar.idpersonal = '$usuario'";

				$res = $this->sql->consultar($sql,"sigh");
				$fila = mysql_fetch_array($res);
                if(empty($fila[idlugar])){
					$flag_sesion=0;
				}else{
                    $_SESSION["nombre_lugar"] = $fila[nombre];
                    $_SESSION["lugar_facturacion"] =  $fila[idlugar];
                    //condicional para ver que lugar poner
                    if($_SESSION[idmodulo_sistema]==1){//
                        $_SESSION["lugar_admision"] = 2 ;
                    }elseif($_SESSION[idmodulo_sistema]==2){
                        $_SESSION["lugar_admision"] = 55 ;
                    }
                }
                $_SESSION["idcp_origen"]=3;
			break;
			/*case 4:
				//medico
                el medico no tiene lugar
			break;*/                            
		}
		
		if($flag_sesion==1){	
			return true;
		}else{
			return false;
		}
		//para la inscripcion

	}
	
	function destruyeSesion(){
		
		session_start();
		session_unset();
		session_destroy();
	}
	
}

?>
