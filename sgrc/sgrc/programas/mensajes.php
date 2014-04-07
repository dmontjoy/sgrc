<?php
function coloca_mensaje($valor,$texto){
//estas variables las recibe del bloque donde se va a mostrar y este a su vez las recibe del guardar, editar o eliminar
	$msj=new DmpTemplate("../../../plantillas/mensajes.tpl");
	$msj->iniciaBloque($valor);
	$msj->reemplazaEnBloque("texto",$texto,$valor);
	$msj->reemplazaEnBloque("ruta_img",ruta_images,$valor);
	return $msj->getPlantillaCadena();
}
	
?>