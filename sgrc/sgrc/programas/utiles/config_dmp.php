<?php

session_start();


$proyectos = array(
    md5('test') => 'test',
    md5('odebrecht') => 'odebrecht',
    md5('hud700') => 'hud700',
    md5('marcobre') => 'marcobre',
    md5('mayaniquel') => 'mayaniquel'
);

if (session_is_registered("idproyecto")) {
  
   $_SESSION['proyecto'] = $proyectos[$_SESSION['idproyecto']];
    $DmpSqlBd["sgrc"] = 'hud700';
     //echo $DmpSqlBd["sgrc"];
            //'hud700';
    //$_SESSION['proyecto'];
} else {
 	$DmpSqlBd["sgrc"] = "";
}

$DmpSqlServidor["sgrc"] = "localhost";
$DmpSqlUsuario["sgrc"] = "root";
$DmpSqlPass["sgrc"] = "sgrc2013";

?>
