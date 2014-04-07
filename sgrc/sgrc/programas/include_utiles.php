<?php

//$ruta=$_SERVER['DOCUMENT_ROOT'];

if($_SERVER[DOCUMENT_ROOT]=="/srv/www/htdocs/sgrc"){

	define("ruta","/srv/www/htdocs");
}else{
	define("ruta",$_SERVER[DOCUMENT_ROOT]);
}

date_default_timezone_set('America/Lima');

ini_set('include_path', ini_get('include_path').';'.ruta.'/sgrc/programas/utiles/Classes/');




include_once(ruta."/sgrc/programas/utiles/config_dmp.php");
include_once(ruta."/sgrc/programas/utiles/class.DmpTemplate.php");
include_once(ruta."/sgrc/programas/utiles/class.DmpSql.php");
include_once(ruta."/sgrc/programas/utiles/class.Ayudante.php");
include_once(ruta."/sgrc/programas/utiles/class.Login.php");
include_once(ruta."/sgrc/programas/utiles/class.Seguridad.php");
include_once(ruta."/sgrc/programas/utiles/class.zipfile.php");
include_once(ruta."/sgrc/programas/utiles/class.thumb.php");
include_once(ruta."/sgrc/programas/utiles/class.tabla_excel.php");
include_once(ruta."/sgrc/programas/utiles/class.autocompletar.php");
include_once(ruta."/sgrc/programas/utiles/Classes/PHPExcel.php");
include_once(ruta."/sgrc/programas/utiles/Classes/PHPExcel/Writer/Excel2007.php");
include_once(ruta."/sgrc/programas/utiles/tcpdf/config/lang/spa.php");
include_once(ruta."/sgrc/programas/utiles/fpdf/fpdf.php");
include_once(ruta."/sgrc/programas/utiles/class.PDF.php");

define("ruta_img",ruta."/sgrc/img/");
define("ruta_images","../../../img/");
define("ruta_css",ruta."/sgrc/css/");
define("ruta_js",ruta."/sgrc/js/");
define("max_br_m",30);
bcscale (4);

define("ruta_archivo","data");
define("version","1.8.1");

$seguridad = new Seguridad();

// Textos a traducir
$dicc['text'] = array (
    'welcome' => 'Bienvenidos',
    'stakeholders' => 'stakeholders',
    'Stakeholder'  => 'Stakeholder',
    'Stakeholders' => 'Stakeholders'
);





?>