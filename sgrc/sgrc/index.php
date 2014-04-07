<?php

/*
  if ($_SERVER['REMOTE_ADDR']=='190.41.177.202'){
  header("Location: http://192.168.1.7/sigh");
  } */

//echo phpinfo();
session_start();

$password = $_REQUEST[txtcontra];

$usuario = $_REQUEST[usuario];
$accion_login = $_REQUEST[accion_login];
$mensaje = $_REQUEST[mensaje];
if(isset($_REQUEST[idproyecto])){
	$_SESSION['idproyecto'] = $_REQUEST[idproyecto];
}

include_once("./programas/include_utiles.php");

switch ($accion_login) {
    case "validar": validar();
        break;
    case "salir": salir();
        break;
    default:presenta_pantalla();
        break;
}

function presenta_pantalla() {
    global $mensaje;
    echo "<br/><div id='cargando' style='width: 100px; margin:0 auto;'><img src='img/bar-ajax-loader.gif'></div><br/>";
    flush();
    $plantilla = new DmpTemplate("./plantillas/login.html");
    if ($mensaje != "") {
        $plantilla->iniciaBloque("mensaje");
        $plantilla->reemplazaEnBloque("mensaje", $mensaje, "mensaje");
    }
    $plantilla->presentaPlantilla();
    //header("Location: ./programas/persona/persona/apersona.php");
}


function validar() {
    global $password;
    global $usuario;
    //aqui se validará los usuarios
    // se vera que modulos tienen permiso y se enviara a su cuerpo respectivo habrá tantos cuerpos como modulos por tipo_usuario
    $login = new Login();
    //echo "<br>".$usuario;
    //echo "<br>".$password;
    $acceso = $login->valida($usuario, $password);
    if ($acceso) {
        //echo "entra";
        if($_SESSION['proyecto']=='bhp0203'){
            header("Location: ./programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_mapa");
        }else{
            header("Location: ./programas/stakeholder/stakeholder/astakeholder.php");
        }
        
    } else {
        $mensaje = "Usuario o clave incorrecta, intente de nuevo.";
        header("Location: ./index.php?mensaje=$mensaje");
    }
    //
}

function salir() {

    $login = new Login();
    $idproyecto = $_SESSION[idproyecto];
    $login->destruyeSesion();
    $mensaje = utf8_encode("Se cerro su cuenta con éxito");
    header("Location: ./index.php?mensaje=$mensaje&idproyecto=$idproyecto");
}

?>