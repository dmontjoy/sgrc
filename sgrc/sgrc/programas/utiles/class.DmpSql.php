<?php

class DmpSql {
	public $enlace;
	public $db;

	function DmpSql(){
		$this->db=null;
	}

	function setDB($database){
		$this->db=$database;
	}


	function consulta_multi($consulta,$clave){
		$this->conectarCompuesto_i($clave);
		try{
			$resultado = mysqli_multi_query($consulta,$this->enlace);
			if(!$resultado){
				throw new Exception('transaccion');
			}
		}catch (Exception $e){
			$resultado = mysqli_multi_query($consulta,$this->enlace);
            //$this->consultar($consulta,$clave);
		}

		$error=mysql_error();

		//if($error==""){
		if($resultado){
			return $resultado;
		}else{
            mysql_close($this->enlace); //añadido
            return false;
        }
    }

    function consultar($consulta,$clave="",$cerrar="0"){

    	if($clave==""){
    		$this->enlace=$this->conectarSimple();
    	}
    	else{
    		$this->conectarCompuesto($clave);
    	}

        /*
        $res=mysql_query($consulta,$this->enlace);

        if($res){
            return $res;
        }else{
            echo('Invalid query: ' . mysql_error(). ' '. $consulta );
            mysql_close($this->enlace); //añadido
            return false;
        }
        */

        try{
        	$resultado = mysql_query($consulta,$this->enlace);
        	if(!$resultado){
        		throw new Exception('transaccion');
        	}
        }catch (Exception $e){
        	$resultado = mysql_query($consulta,$this->enlace);
            //$this->consultar($consulta,$clave);
        }catch (Exception $e){
        	$resultado = mysql_query($consulta,$this->enlace);
            //$this->consultar($consulta,$clave);
        }catch (Exception $e){
        	$resultado = mysql_query($consulta,$this->enlace);
            //$this->consultar($consulta,$clave);
        }
        $error=mysql_error();
        if($cerrar!=0){
        	mysql_close($this->enlace);
        }
		//if($error==""){
        if($resultado){
        	return $resultado;
        }else{
            mysql_close($this->enlace); //añadido
            return false;
        }



    }


    function conectarSimple(){

    	global $DmpSqlServidor;
    	global $DmpSqlUsuario;
    	global $DmpSqlPass;
    	global $DmpSqlBd;
    	$enlace=mysql_connect($DmpSqlServidor,$DmpSqlUsuario,$DmpSqlPass);
    	mysql_select_db($DmpSqlBd);
    	return $enlace;

    }

    function idtabla(){
    	return mysql_insert_id($this->enlace);
    }

    function conectarCompuesto_i($clave){
		//if($_SERVER['REMOTE_ADDR']=="127.0.0.1"){
		//echo "clave ".$DmpSqlServidor[$clave];

    	global $DmpSqlServidor;
    	global $DmpSqlUsuario;
    	global $DmpSqlPass;
    	global $DmpSqlBd;

    	if(empty($this->enlace) ){
    		if(isset($this->db)){
    			$this->enlace=mysqli_connect($DmpSqlServidor[$clave],$DmpSqlUsuario[$clave],$DmpSqlPass[$clave],$this->db);

    			//echo mysqli_connect_errno();

    		}else{
    			$this->enlace=mysqli_connect($DmpSqlServidor[$clave],$DmpSqlUsuario[$clave],$DmpSqlPass[$clave],$DmpSqlBd[$clave])or die("Error " . mysqli_error($this->enlace));;
    			echo $DmpSqlServidor[$clave]." ".$DmpSqlUsuario[$clave]." ".$DmpSqlBd[$clave]." ".$DmpSqlPass[$clave];
    			printf("Connect failed: %s\n", mysqli_connect_error());
    		}
    	}
			//return $enlace;
		//}

    }


    function conectarCompuesto($clave){
		//if($_SERVER['REMOTE_ADDR']=="127.0.0.1"){
		//echo "clave ".$DmpSqlServidor[$clave];

    	global $DmpSqlServidor;
    	global $DmpSqlUsuario;
    	global $DmpSqlPass;
    	global $DmpSqlBd;

    	if(empty($this->enlace) ){
    		if(isset($this->db)){
    			$this->enlace=mysql_connect($DmpSqlServidor[$clave],$DmpSqlUsuario[$clave],$DmpSqlPass[$clave]);

    			echo mysql_error();

    			mysql_select_db($this->db);
    			echo mysql_error();
    		}else{
    			$this->enlace=mysql_connect($DmpSqlServidor[$clave],$DmpSqlUsuario[$clave],$DmpSqlPass[$clave]);

    			echo mysql_error();

    			mysql_select_db($DmpSqlBd[$clave]);
    			echo mysql_error();
    		}
    	}
			//return $enlace;
		//}

    }

    function __destruct(){
    	@mysql_close();
    }

}


?>
