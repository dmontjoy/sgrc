<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../../include_utiles.php';
include_once '../../../informacion/usuario/class.iusuario.php';
include_once '../../../gestion/usuario/class.gusuario.php';
include_once '../../../programas/mensajes.php';
include_once '../../../informacion/persona/class.itipo.php';

$idpersona=$_REQUEST['idpersona'];
$idmodulo=$_REQUEST['idmodulo'];
$usuario=$_REQUEST['usuario'];
$idmodulo_usuario=$_REQUEST['idmodulo_usuario'];
$idusuario=$_REQUEST['idusuario'];
$clave=$_REQUEST['clave'];
$clave_actual=$_REQUEST['clave_actual'];
$idseguridad_rol=$_REQUEST['idseguridad_rol'];
$host=$_REQUEST['host'];

if (!$seguridad->verificaSesion()) {
    $mensaje = "Ingrese su usuario y contraseña";
    header("Location: ../../../index.php?mensaje=$mensaje");
}

switch ($_REQUEST["op_usuario"]) {
    default :ver_nuevo_usuario($idpersona,$idmodulo);
        break;       
    case "ver_editar_usuario" :ver_editar_usuario($idusuario,$idmodulo);
        break; 
    case "ver_actualizar_clave" :ver_actualizar_clave($idusuario,$idmodulo);
        break; 
    case "guardar":guardar($idpersona,$idmodulo,$usuario,$clave,$idseguridad_rol,$host);
        break;
    case "editar":editar($idusuario,$idmodulo,$usuario,$clave,$idseguridad_rol,$host);
        break;
    case "actualizar_clave":actualizar_clave($idusuario,$idmodulo,$clave,$clave_actual);
        break;
    case "eliminar":eliminar($idusuario,$idmodulo_usuario);
        break;
   case "ver_usuario":ver_usuario($idpersona,$idmodulo);
        break;
}

function ver_nuevo_usuario($idpersona,$idmodulo) {

    $plantilla = new DmpTemplate("../../../plantillas/usuario/usuario/registrar_usuario.html");
    $iusuario=new iusuario();
    $plantilla->reemplaza("op_usuario","guardar");  
    $plantilla->reemplaza("idpersona","$idpersona"); 
    $plantilla->reemplaza("idmodulo","$idmodulo"); 
    
    $result=$iusuario->lista_rol();
    
    while($fila=mysql_fetch_array( $result  )){
         $plantilla->iniciaBloque("tipo");
         $plantilla->reemplazaEnBloque("value",$fila[idseguridad_rol], "tipo");
         $plantilla->reemplazaEnBloque("tipo", $fila[nombre], "tipo");
         
     }
     $result=$iusuario->lista_host();
     while($fila=mysql_fetch_array( $result  )){
        $plantilla->iniciaBloque("host");
        $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "host");
        $plantilla->reemplazaEnBloque("host", $fila[host], "host");
     }    
     
    $plantilla->presentaPlantilla();
}

function ver_editar_usuario($idusuario,$idmodulo) {

    $plantilla = new DmpTemplate("../../../plantillas/usuario/usuario/registrar_usuario.html");
    $iusuario=new iusuario();
    $plantilla->reemplaza("op_usuario","editar");  
    $plantilla->reemplaza("idusuario","$idusuario"); 
    $plantilla->reemplaza("idmodulo","$idmodulo"); 
    $plantilla->iniciaBloque("clave");
    $plantilla->reemplaza("estilo","display:none;"); 
    $result=$iusuario->lista($idusuario,$idmodulo);
    $username="";
    $idseguridad_rol=1;
    $hosts = array();
    $activos = array();
    if($fila=mysql_fetch_array( $result  )){
        $username=$fila['usuario'];
        $idseguridad_rol=$fila['idseguridad_rol'];
        $hosts[]=$fila['idmodulo'];
        $activos[$fila['idmodulo']]= $fila['activo'];
        //print_r($fila);
       
     }
    
    $result=$iusuario->lista_rol();
    
    while($fila=mysql_fetch_array( $result  )){
         $plantilla->iniciaBloque("tipo");
         $plantilla->reemplazaEnBloque("value",$fila[idseguridad_rol], "tipo");
         $plantilla->reemplazaEnBloque("tipo", $fila[nombre], "tipo");
         if( $idseguridad_rol == $fila[idseguridad_rol]){
             $plantilla->reemplazaEnBloque("selected", "selected", "tipo");
         }
     }
     $result=$iusuario->lista_host();
     while($fila=mysql_fetch_array( $result  )){
        $plantilla->iniciaBloque("host");
        
        
        if(in_array($fila[idmodulo], $hosts) ){
            if( $activos[$fila[idmodulo]]==1){
               if($idseguridad_rol==2 && $_SESSION[idmodulo]==$fila[idmodulo]){
                   $plantilla->reemplazaEnBloque("estilo", "display:none;", "host");   
               }
               $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo], "host");
               $plantilla->reemplazaEnBloque("checked", "checked", "host");
               
            }else{
                $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo]."***", "host");
            }
        }else{
            $plantilla->reemplazaEnBloque("idmodulo", $fila[idmodulo]."---", "host");
        }
        $plantilla->reemplazaEnBloque("host", $fila[host], "host");
     }  
    // echo $username;
    $plantilla->reemplaza("username","$username"); 
    $plantilla->presentaPlantilla();
}

function ver_actualizar_clave($idusuario,$idmodulo) {

    $plantilla = new DmpTemplate("../../../plantillas/usuario/usuario/actualizar_clave.html");
    $plantilla->reemplaza("op_usuario","actualizar_clave");  
    $plantilla->reemplaza("idusuario","$idusuario"); 
    $plantilla->reemplaza("idmodulo","$idmodulo");    
    // echo $username;
    $plantilla->reemplaza("username","$_SESSION[usuario]"); 
    $plantilla->presentaPlantilla();
}


function ver_usuario($idpersona,$idmodulo) {
    $seguridad = new Seguridad();
    $plantilla = new DmpTemplate("../../../plantillas/usuario/usuario/ver_usuario.html");
    $iusuario=new iusuario();
    $result=$iusuario->lista_usuario($idpersona,$idmodulo);
    $i=0;
     while($fila=mysql_fetch_array( $result  )){
        $i++;
        $plantilla->iniciaBloque("resultado_usuario");
        $plantilla->reemplazaEnBloque("i", $i, "resultado_usuario");
        $plantilla->reemplazaEnBloque("usuario", $fila[usuario], "resultado_usuario");
        if($seguridad->verifica_permiso("Editar", "Usuario", $fila[idusu_c], $fila[idmodulo_c]) ){
            $plantilla->iniciaBloque("editar_usuario");
            $plantilla->reemplazaEnBloque("idusuario", $fila[idusuario], "editar_usuario");
            $plantilla->reemplazaEnBloque("idmodulo_usuario", $fila[idmodulo_usuario], "editar_usuario");
        }
        
        if($seguridad->verifica_permiso("Eliminar", "Usuario", $fila[idusu_c], $fila[idmodulo_c]) ){
            $plantilla->iniciaBloque("eliminar_usuario");
            $plantilla->reemplazaEnBloque("idusuario", $fila[idusuario], "eliminar_usuario");
            $plantilla->reemplazaEnBloque("idmodulo_usuario", $fila[idmodulo_usuario], "eliminar_usuario");
        }
        
     }    
     
    $plantilla->presentaPlantilla();
}

function guardar($idpersona,$idmodulo,$usuario,$clave,$idseguridad_rol,$host){
    $gusuario = new gusuario();
    $error=$gusuario->guardar($idpersona,$idmodulo,$usuario,$clave,$idseguridad_rol,$host);
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("guarda_ok", " del usuario ");
        
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("guarda_error", " del usuario ");
    }
    
    echo json_encode($data);
}

function editar($idusuario,$idmodulo,$usuario,$clave,$idseguridad_rol,$host){
    $gusuario = new gusuario();
    $error=0;
    //print_r($host);
    $error=$gusuario->editar($idusuario,$idmodulo,$usuario,$clave,$idseguridad_rol,$host);
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " del usuario ");
        
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " del usuario ");
    }
    
    echo json_encode($data);
}

function actualizar_clave($idusuario,$idmodulo,$clave,$clave_actual){
    $gusuario = new gusuario();
    $error=0;
    //print_r($host);
    $error=$gusuario->actualizar_clave($idusuario,$idmodulo,$clave,$clave_actual);
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("actualiza_ok", " del usuario ");
        
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("actualiza_error", " del usuario ");
    }
    
    echo json_encode($data);
}

function eliminar($idpersona,$idmodulo){
    $gusuario = new gusuario();
    $error=$gusuario->eliminar($idpersona,$idmodulo);
    if ($error == 0) {
        $data['success'] = true;
        $data['mensaje'] = coloca_mensaje("elimina_ok", " del usuario ");
        
    } else {
        $data['success'] = false;
        $data['mensaje'] = coloca_mensaje("elimina_error", " del usuario ");
    }
    
    echo json_encode($data);
}

?>
