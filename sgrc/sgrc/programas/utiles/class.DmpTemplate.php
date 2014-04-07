<?php


class DmpTemplate {

	var $plantilla = "";
	var $plantillaFinal = Array();

	var $bloquesDinamicosSimples = Array();
	var $bloquesDinamicosSimplesTemporales = Array();
	var $bloquesDinamicosSimplesAux = Array();

	var $bloquesDinamicosCompuestos = Array();
	var $bloquesDinamicosCompuestosTemporales = Array();
	var $bloquesDinamicosCompuestosAux = Array();

	var $bloquesNormales = Array();

	var $posicion = Array();

	var $numTotalBloques = 0;

	function DmpTemplate($archivo=""){
		if($archivo!=""){
			$archivoTemporal = file($archivo);
			for($i=0; $i<sizeOf($archivoTemporal); $i++){
				$this->plantilla .=$archivoTemporal[$i];
			}
		}
		$this->preparaPlantilla();

	}

	function setPlantilla($plantilla){
		$this->plantilla = $plantilla;
		$this->preparaPlantilla();
	}

	function preparaPlantilla(){

		$longitudInicioBloque=21;

		$indiceInicioCabezaBloque = strpos($this->plantilla,"<!-- INICIO BLOQUE : "); //obtengo el inicio de la cabeza del bloque dinamico

		if($indiceInicioCabezaBloque){

			$bloqueNormal = substr($this->plantilla,0,$indiceInicioCabezaBloque); //obtengo bloque normal, está antes de emepzar el bloque dinamico
			$this->plantilla = substr($this->plantilla,$indiceInicioCabezaBloque+$longitudInicioBloque); //obtengo el resto de la plantilla
			$indiceFinNombreBloque = strpos($this->plantilla," ");//obtengo donde acaba el nombre del bloque
			$nombreBloque = substr($this->plantilla,0,$indiceFinNombreBloque); //obtengo nombre del bloque
			
			$indiceInicioPiesBloque = strpos($this->plantilla,"<!-- FIN BLOQUE : ".$nombreBloque." -->");//obtengo posición del inicio de los pies del bloque dinamico
			$bloqueDinamico = substr($this->plantilla,$indiceFinNombreBloque+4,$indiceInicioPiesBloque-4-strlen($nombreBloque));//obtengo el bloque dinamico

			$this->plantilla = substr($this->plantilla,$indiceInicioPiesBloque+strlen("<!-- FIN BLOQUE : ".$nombreBloque." -->"));

			$this->numTotalBloques+=2;

			$this->preparaPlantilla();

			if(strpos($bloqueDinamico,"<!-- INICIO BLOQUE : ")){
				$this->bloquesDinamicosCompuestos[$nombreBloque] = $bloqueDinamico;
				$this->bloquesDinamicosCompuestosAux[$nombreBloque] = new DmpTemplate();
				$this->posicion[--$this->numTotalBloques] = $nombreBloque;
				$this->bloquesDinamicosCompuestosTemporales[$nombreBloque] = Array();
			}else{
				$this->bloquesDinamicosSimples[$nombreBloque] = $bloqueDinamico;
				$this->posicion[--$this->numTotalBloques] = $nombreBloque;
				$this->bloquesDinamicosTemporales[$nombreBloque] = Array();
			}

			$this->posicion[--$this->numTotalBloques] = sizeOf($this->bloquesNormales);
			$this->bloquesNormales[]= $bloqueNormal;

		}else{

			$this->posicion[$this->numTotalBloques] = sizeOf($this->bloquesNormales);
			$this->bloquesNormales[]= $this->plantilla;
			$this->plantilla="";

		}

	}


	function reemplaza($antiguo, $nuevo){

		for($i=0; $i<sizeOf($this->bloquesNormales); $i++){
			$this->bloquesNormales[$i] = str_replace("{".$antiguo."}",$nuevo,$this->bloquesNormales[$i]);
		}
	}

	function reemplazaExacto($antiguo, $nuevo){
		for($i=0; $i<sizeOf($this->bloquesNormales); $i++){
			$this->bloquesNormales[$i] = str_replace($antiguo,$nuevo,$this->bloquesNormales[$i]);
		}
	}

	function iniciaBloque($nombreBloque){

		if(isset($this->bloquesDinamicosSimples[$nombreBloque])){
			$this->bloquesDinamicosSimplesTemporales[$nombreBloque][] = $this->bloquesDinamicosSimplesAux[$nombreBloque];
			$this->bloquesDinamicosSimplesAux[$nombreBloque] = $this->bloquesDinamicosSimples[$nombreBloque];
		}

			foreach($this->bloquesDinamicosCompuestos as $nombre => $valor){
				if($nombre == $nombreBloque){
					$tmp = $this->bloquesDinamicosCompuestosAux[$nombreBloque]->getPlantillaArray();
					for($i=0; $i<sizeOf($tmp); $i++){
						$this->bloquesDinamicosCompuestosTemporales[$nombreBloque][] = $tmp[$i];
					}
					$this->bloquesDinamicosCompuestosAux[$nombreBloque] = new DmpTemplate();
					$this->bloquesDinamicosCompuestosAux[$nombreBloque]->setPlantilla($this->bloquesDinamicosCompuestos[$nombreBloque]);
				}else{
					$this->bloquesDinamicosCompuestosAux[$nombre]->iniciaBloque($nombreBloque);
				}
			}
	}

	function reemplazaEnBloque($antiguo, $nuevo, $nombreBloque){

		if(isset($this->bloquesDinamicosSimples[$nombreBloque])){
			$this->bloquesDinamicosSimplesAux[$nombreBloque] = str_replace("{".$antiguo."}", $nuevo, $this->bloquesDinamicosSimplesAux[$nombreBloque]);
		}

			foreach($this->bloquesDinamicosCompuestos as $nombre => $valor){
				if($nombre == $nombreBloque){
					$this->bloquesDinamicosCompuestosAux[$nombreBloque]->reemplaza($antiguo,$nuevo);
				}else{
					$this->bloquesDinamicosCompuestosAux[$nombre]->reemplazaEnBloque($antiguo,$nuevo, $nombreBloque);
				}
			}


	}

	function reemplazaExactoEnBloque($antiguo, $nuevo, $nombreBloque){

		if(isset($this->bloquesDinamicosSimples[$nombreBloque])){
			$this->bloquesDinamicosSimplesAux[$nombreBloque] = str_replace($antiguo, $nuevo, $this->bloquesDinamicosSimplesAux[$nombreBloque]);
		}

			foreach($this->bloquesDinamicosCompuestos as $nombre => $valor){
				if($nombre == $nombreBloque){
					$this->bloquesDinamicosCompuestosAux[$nombreBloque]->reemplazaExacto($antiguo,$nuevo);
				}else{
					$this->bloquesDinamicosCompuestosAux[$nombre]->reemplazaExactoEnBloque($antiguo,$nuevo, $nombreBloque);
				}
			}

	}

	function preparaPlantillaFinal(){

		for($i=0; $i<sizeOf($this->posicion); $i++){

			if(isset($this->bloquesNormales[$this->posicion[$i]])){
				$this->plantillaFinal[] = ereg_replace('{([-_A-Za-z0-9]*)}',"",$this->bloquesNormales[$this->posicion[$i]]);

			}

			if(isset($this->bloquesDinamicosSimples[$this->posicion[$i]])){
				for($j=0; $j<sizeOf($this->bloquesDinamicosSimplesTemporales[$this->posicion[$i]]); $j++){
					$this->plantillaFinal[] = ereg_replace('{([-_A-Za-z0-9]*)}',"",$this->bloquesDinamicosSimplesTemporales[$this->posicion[$i]][$j]);

				}
				$this->plantillaFinal[] = ereg_replace('{([-_A-Za-z0-9]*)}',"",$this->bloquesDinamicosSimplesAux[$this->posicion[$i]]);
			}

			if(isset($this->bloquesDinamicosCompuestos[$this->posicion[$i]])){
				for($j=0; $j<sizeOf($this->bloquesDinamicosCompuestosTemporales[$this->posicion[$i]]); $j++){
					$this->plantillaFinal[] = ereg_replace('{([-_A-Za-z0-9]*)}',"",$this->bloquesDinamicosCompuestosTemporales[$this->posicion[$i]][$j]);

				}
				$tmp = $this->bloquesDinamicosCompuestosAux[$this->posicion[$i]]->getPlantillaArray();
				for($j=0; $j<sizeOf($tmp); $j++){
					$this->plantillaFinal[] = ereg_replace('{([-_A-Za-z0-9]*)}',"",$tmp[$j]);
				}
			}
		}
	}

	function getPlantillaArray(){
		$this->preparaPlantillaFinal();
		return $this->plantillaFinal;
	}

	function getPlantillaCadena(){
		$this->preparaPlantillaFinal();
		$cadenaAux = "";
		for($i=0 ; $i<sizeOf($this->plantillaFinal); $i++){
			$cadenaAux .= $this->plantillaFinal[$i];
		}
		return $cadenaAux;
	}

	function presentaPlantilla(){
		$this->preparaPlantillaFinal();
		for($i=0; $i<sizeOf($this->plantillaFinal); $i++){
			echo $this->plantillaFinal[$i];
		}
	}

}

?>
