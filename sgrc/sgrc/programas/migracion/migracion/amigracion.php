<?php
session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$op_migracion=$_REQUEST["op_migracion"];
$nombre_archivo=$_REQUEST["nombre_archivo"];
$idmigracion=$_REQUEST["idmigracion"];
$idmodulo=$_REQUEST["idmodulo"];
$ipserver=$_REQUEST["ipserver"];
$usuario=$_REQUEST["usuario"];
$password=$_REQUEST["password"];
$proyecto=$_REQUEST["proyecto"];




include_once '../../include_utiles.php';
include_once '../../../informacion/migracion/class.imigracion.php';
include_once '../../../informacion/usuario/class.iusuario.php';
include_once '../../../gestion/usuario/class.gusuario.php';
include_once '../../../gestion/migracion/class.gmigracion.php';

switch ($op_migracion) {
    case "generar_archivo_cliente" :generar_archivo_cliente($ipserver);break;
    case "enviar_archivo_cliente" :enviar_archivo_cliente();break;
    case "recibir_archivo_cliente" :recibir_archivo_cliente($nombre_archivo,$idmigracion,$idmodulo,$proyecto);break;
    case "solicitar_archivo_servidor":solicitar_archivo_servidor();break;
    case "enviar_archivo_servidor" :enviar_archivo_servidor($idmigracion,$idmodulo,$proyecto);break;
    case "recibir_archivo_servidor" :recibir_archivo_servidor($idmigracion,$idmodulo,$nombre_archivo);break;
    case "ejecutar_archivo_cliente":ejecutar_archivo_cliente($idmigracion, $idmodulo, $nombre_archivo,$proyecto);break;
    case "ejecutar_archivo_servidor":ejecutar_archivo_servidor($idmigracion, $idmodulo, $nombre_archivo);break;
    case "notificar_cliente_servidor":notificar_cliente_servidor($idmigracion, $idmodulo, $nombre_archivo);break;
    case "validar_usuario":validar_usuario($usuario,$password, $proyecto);break;

    default : ver_cuerpo_inicial();break;


}

// 1
function generar_archivo_cliente($ipserver){
    //echo "Cliente:";
    //print_r($_SESSION);
    $message ="";
    $imigracion = new imigracion();
    $gmigracion = new gmigracion();

    $_SESSION['ip_servidor']=$ipserver;

    $result = $imigracion->lista_migracion();

    if (filter_var($_SESSION['ip_servidor'], FILTER_VALIDATE_IP)) {
        if($fila = mysql_fetch_array($result)){
            $message.="<div class='fondoRojo'>Cliente: Hay una migracion en curso</div>";
            $data["success"]=false;
        }else{
            $url = "http://".$_SESSION['ip_servidor']."/".$_SESSION['ruta_servidor'];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            //echo "$url $retcode";
            if (200==$retcode) {
                // All's well

                $idmigracion=$gmigracion->generar_migracion();
                $result = $imigracion->lista_detalle_migracion($idmigracion,$_SESSION[idmodulo]);
                $cantidad= mysql_num_rows($result);
                if($cantidad>0){

                    $nombre_archivo = 'cliente_'.$_SESSION[idmodulo].'_'.$idmigracion.'.txt';

                    if ( !$gestor = fopen($nombre_archivo, 'w')) {
                     $message.= "<br/>Cliente: No se puede abrir el archivo (".$nombre_archivo.") para escritura";

                 }else{

                    while($fila= mysql_fetch_array($result)){

                        $contenido = $fila['consulta'].";\n";

                        if (fwrite($gestor, $contenido) === FALSE) {
                           $message.= "<br/>Cliente: No se puede escribir en el archivo ($nombre_archivo)";

                       }
                   }
                   fclose($gestor);
                   $zip = new ZipArchive;
                   if ($zip->open($nombre_archivo.".zip", ZIPARCHIVE::CREATE)!==TRUE) {
                    $message.= "<br/>No se puede abrir ".$nombre_archivo.".zip";

                }
                $zip->addFile($nombre_archivo);
                $zip->close();
                $gmigracion->actualiza_archivo_cliente($idmigracion,$_SESSION[idmodulo],$nombre_archivo.".zip");
                $message.= "<br/>Cliente: archivo $nombre_archivo";
                if(file_exists($nombre_archivo)){
                    rename($nombre_archivo,dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$nombre_archivo);
                    rename($nombre_archivo.".zip",dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$nombre_archivo.".zip");
                    $message.= "<br/>Cliente: renombrando $nombre_archivo\n";
                }else{
                    $message.= "<br/>Cliente: No existe $nombre_archivo\n";
                }

            }


        }else{

         $message.= "<div class='fondoRojo'>Cliente: No hay registros para migrar al servidor</div>";

     }
     $data["success"]=true;
 }else{
    $message.= "<div class='fondoRojo'>Cliente: El servidor no est&aacute; disponible</div>";
    $data["success"]=false;
}
}
}else{
    $message.="<div class='fondoRojo'>Cliente: IP no v&aacute;lida</div>";
    $data["success"]=false;
}

$data['message'] = $message;

echo json_encode($data);

}

//2
function enviar_archivo_cliente(){
    $message ="";
    $data["success"]=true;
    $imigracion = new imigracion();
    $gmigracion = new gmigracion();
    $result=$imigracion->lista_migracion();

    if($fila =  mysql_fetch_array($result)){
     $idmigracion=$fila[idmigracion];
     $idmodulo=$fila[idmodulo_migracion];
     $nombre_archivo=$fila[archivo_cliente];
     $message.= "<br/>Cliente: Enviando archivo al servidor";

         //Copiar archivo cliente al servidor
         // URL on which we have to post data
     $url = "http://".$_SESSION['ip_servidor']."/".$_SESSION['ruta_servidor']."/programas/migracion/migracion/amigracion.php?op_migracion=recibir_archivo_cliente&nombre_archivo=$nombre_archivo&idmodulo=".$idmodulo."&idmigracion=".$idmigracion."&proyecto=".$_SESSION['proyecto'];
     $message.= "<br/>Cliente: Empleando URL ".$url;

        // Initialize cURL
     $ch = curl_init();
        // Set URL on which you want to post the Form and/or data
     curl_setopt($ch, CURLOPT_URL, $url);
        // Data+Files to be posted
         // File you want to upload/post
     if($nombre_archivo!=""){
        $file = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$nombre_archivo;
        $post_data['file'] = "@$file";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
        // Pass TRUE or 1 if you want to wait for and catch the response against the request made
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // For Debug mode; shows up any error encountered during the operation
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
        // Execute the request
    $response = curl_exec($ch);

    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);



    if (200==$retcode) {
                // All's well

                // Just for debug: to see response
        $message.= $response;

        $message.= "<br/>Cliente: Culminando envio";


                //print_r($_SESSION);
    }else{

       $data["success"]=false;

       $message.= "<br/>Cliente: Error de envio";

               // Restaurar tabla migracion detalle...

       $gmigracion-> restaurar_migracion($idmigracion,$idmodulo);
   }



}else{
    $message.="<br/>Cliente: No hay proceso de migracion pendiente al servidor";
}

$data["message"]=$message;

echo json_encode($data);

}

//3
function recibir_archivo_cliente($nombre_archivo,$idmigracion,$idmodulo,$proyecto){
    $message="";
    $xml = new XMLReader();
    $xml->open("../../../config.xml");
    $xml->setParserProperty(2,true); // This seems a little unclear to me - but it worked :)

while ($xml->read()) {
    switch ($xml->name) {
        case "idmodulo":
        $xml->read();
        $_SESSION['idmodulo'] = $xml->value;
        $xml->read();
        break;
        case "ip_servidor":
        $xml->read();
        $_SESSION['ip_servidor'] = $xml->value;
        $xml->read();
        break;

        case "ruta_servidor":
        $xml->read();
        $_SESSION['ruta_servidor'] = $xml->value;
        $xml->read();
        break;
    }

}

    //print_r($_SESSION);

    //print_r($_FILES);

$xml->close();

$data["success"] = true;
$imigracion = new imigracion();
$imigracion->sql->setDB($proyecto);
$gmigracion = new gmigracion();
$gmigracion->sql->setDB($proyecto);
$result = $imigracion->lista_migracion();


if($fila = mysql_fetch_array($result)){

    $fecha_ini = $fila[fecha_ini];
        //validar diferencia de hora de migracion...

    $interval = time()-strtotime($fecha_ini);
        $diff = round(abs($interval) / 60); //minutes

        if($diff<2){
            $data["success"] = false;
            $message.= "<br/>Server: migracion en curso";
        }else{
            $gmigracion-> restaurar_migracion($idmigracion,$idmodulo);
        }

    }

    if($data["success"]){

        $message.= "<br/>Server: registrando migracion $idmigracion-$idmodulo";

        $gmigracion->registra_migracion($idmigracion,$idmodulo);

        $gmigracion->registrar_modulo_migracion($idmigracion,$idmodulo,$idmodulo);
        $message.= "<br/> nombre_archivo: $nombre_archivo";
        if(strlen($nombre_archivo)>5){

        // validar nombre archivo longitud > 5

            $file = $nombre_archivo;
            //$mobile = $nombre_archivo;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
                $message.= "<br/>Server: El archivo es valido y fue cargado exitosamente.\n";

                $file = substr($file, 0, strlen($file)-4 );
                $mobile = substr($mobile, 0, strlen($mobile)-4 );
                $message.= "<br/>Server: archivo $file";


                $zip = new ZipArchive;
                $zip->open($nombre_archivo);
                $zip->extractTo(".".DIRECTORY_SEPARATOR);
                $zip->close();
                /*
                if(file_exists($mobile)){
                        rename($mobile,$file);
                        $message.= "<br/>Server: renombrando $mobile\n";
                }else{
                        $message.= "<br/>Server: No existe $mobile\n";
                }
                 *
                 */

                if(file_exists($nombre_archivo)){
                    rename($file,dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$proyecto.DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$file);
                    rename($nombre_archivo,dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$proyecto.DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$nombre_archivo);
                    $message.= "<br/>Server: renombrando $nombre_archivo\n";
                }else{
                    $message.= "<br/>Server: No existe $nombre_archivo\n";
                }

            } else {
                $message.= "<br/>Server: No se pudo cargar el archivo\n";

                $gmigracion->restaurar_migracion($idmigracion,$idmodulo);
            }

        }else{
            $message.= "<br/>Server: Se recibio el mensaje\n";
            $gmigracion->finaliza_migracion($idmigracion,$idmodulo);
        }



    }



    $data["message"]=$message;

    echo json_encode($data);
}




//4
function solicitar_archivo_servidor(){
   $imigracion = new imigracion();
   $result=$imigracion->lista_migracion();

   if($fila =  mysql_fetch_array($result)){
    $idmigracion=$fila[idmigracion];
    $idmodulo=$fila[idmodulo_migracion];
    $nombre_archivo=$fila[archivo_cliente];
    echo "Cliente: Solicitando actualizaciones URL http://".$_SESSION['ip_servidor']."/".$_SESSION['ruta_servidor']."/programas/migracion/migracion/amigracion.php?op_migracion=enviar_archivo_servidor&idmodulo=".$_SESSION['idmodulo']."&idmigracion=".$idmigracion."&proyecto=".$_SESSION['proyecto'];
    flush();
    $json = file_get_contents("http://".$_SESSION['ip_servidor']."/".$_SESSION['ruta_servidor']."/programas/migracion/migracion/amigracion.php?op_migracion=enviar_archivo_servidor&idmodulo=".$_SESSION['idmodulo']."&idmigracion=".$idmigracion."&proyecto=".$_SESSION['proyecto']);
    $data = json_decode($json, true);
    print_r($data);
    foreach ($data["archivos"] as $archivo){
        recibir_archivo_servidor($idmigracion, $idmodulo, $archivo);
    }
    flush();
        //recorrer array y recibir archivo servidor

    echo notificar_cliente_servidor($idmigracion, $idmodulo, $nombre_archivo);
    flush();


}else{
    echo "Cliente: No hay migracion en curso";
    flush();
}
}

//5
function enviar_archivo_servidor($idmigracion,$idmodulo, $proyecto){
    $xml = new XMLReader();
    $xml->open("../../../config.xml");
    $xml->setParserProperty(2,true); // This seems a little unclear to me - but it worked :)

while ($xml->read()) {
    switch ($xml->name) {
        case "idmodulo":
        $xml->read();
        $_SESSION['idmodulo'] = $xml->value;
        $xml->read();
        break;
        case "ip_servidor":
        $xml->read();
        $_SESSION['ip_servidor'] = $xml->value;
        $xml->read();
        break;

        case "ruta_servidor":
        $xml->read();
        $_SESSION['ruta_servidor'] = $xml->value;
        $xml->read();
        break;
    }

}

$xml->close();

$datos= array();
$archivos = array();

$imigracion = new imigracion();
$imigracion->sql->setDB($proyecto);
$gmigracion = new gmigracion();
$gmigracion->sql->setDB($proyecto);

$result = $imigracion->lista_detalle_migracion($idmigracion,$idmodulo);
$cantidad= mysql_num_rows($result);

$message="";
if($cantidad>0){
    $message.= "<br/>Server: generando archivo servidor";


    $nombre_archivo = 'server_'.$idmodulo.'_'.$idmigracion.'.txt';
    $file = $nombre_archivo;

    if (!$gestor = fopen($nombre_archivo, 'w')) {
     $message.= "<br/>Server: No se puede abrir el archivo (".$nombre_archivo.")";


 }else{


    while($fila= mysql_fetch_array($result)){

        $contenido = $fila['consulta'].";\n";

        if (fwrite($gestor, $contenido) === FALSE) {
           $message.= "<br/>Server:No se puede escribir en el archivo ($nombre_archivo)";

       }
   }
   fclose($gestor);
   $zip = new ZipArchive;
   if ($zip->open($nombre_archivo.".zip", ZIPARCHIVE::CREATE)!==TRUE) {
    $message.= ("<br/>No se puede abrir ".ruta_archivo.DIRECTORY_SEPARATOR.$nombre_archivo.".zip");

}
$zip->addFile($nombre_archivo);
$zip->close();
$nombre_archivo.=".zip";

if(file_exists($nombre_archivo)){
    rename($file,dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$proyecto.DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$file);
    rename($nombre_archivo,dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$proyecto.DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$nombre_archivo);
    $message.= "<br/>Server: renombrando $nombre_archivo\n";
    $gmigracion->actualiza_archivo_servidor($idmigracion,$idmodulo,$nombre_archivo);
    $message.= "<br/>Server: migrando $nombre_archivo";
    $archivos[]=$nombre_archivo;
}else{
    $message.= "<br/>Server: No existe $nombre_archivo\n";
}



}

}else{

    $message.=  "<br/>Servidor: No hay registros nuevos para migrar al cliente";

}


$result = $imigracion->lista_migracion_modulo($idmodulo);


while($fila=  mysql_fetch_array($result)){
    $nombre_archivo = $fila[archivo_cliente];

    if(isset($nombre_archivo)){
        $archivos[]= $nombre_archivo;
    }
    $nombre_archivo = $fila[archivo_servidor];
    if(isset($nombre_archivo)){
        $archivos[]= $nombre_archivo;
    }
    $gmigracion->registrar_modulo_migracion($fila[idmigracion],$fila[idmodulo_migracion],$idmodulo);

}


$datos["message"]=$message;
$datos["archivos"]=$archivos;

echo json_encode($datos);
}

//6
function recibir_archivo_servidor($idmigracion,$idmodulo,$nombre_archivo){
    $gmigracion = new gmigracion();

    $url="http://".$_SESSION['ip_servidor']."/".$_SESSION['ruta_servidor']."/archivo/".$_SESSION['proyecto']."/".ruta_archivo."/".$nombre_archivo;

    if (!$rfile = fopen($url, 'r')) {
     echo "<br/>Cliente:No se puede abrir el archivo $url";
     flush();

 }else{
    define('BUFSIZ', 4095);
    $lfile = fopen($nombre_archivo, 'w');
    while(!feof($rfile))
        fwrite($lfile, fread($rfile, BUFSIZ), BUFSIZ);
    fclose($lfile);
    fclose($rfile);
    echo  "<br/>Cliente:lectura exitosa";
    flush();
    $file = $nombre_archivo;
    $file = substr($file, 0, strlen($file)-4 );
		//$mobile = dirname( __FILE__ ).DIRECTORY_SEPARATOR.$nombre_archivo;
		//$mobile = substr($mobile, 0, strlen($mobile)-4 );
    echo "<br/>Cliente: archivo $file";
    flush();
    $zip = new ZipArchive;
    $zip->open($nombre_archivo);
    $zip->extractTo(".".DIRECTORY_SEPARATOR);
    $zip->close();

    if(file_exists($nombre_archivo)){
        rename($nombre_archivo,dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$nombre_archivo);
        rename($file,dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$file);
        $message.= "<br/>Cliente: renombrando $nombre_archivo\n";
    }else{
        $message.= "<br/>Cliente: No existe $nombre_archivo\n";
    }

        /*
        if(file_exists($mobile)){
                rename($mobile,$file);
                echo "<br/>Cliente: renombrando $mobile\n";
        }else{
                echo "<br/>Cliente: No existe $mobile\n";
        }
         *
         */

        $gmigracion->registra_migracion_archivo($idmigracion,$idmodulo,$nombre_archivo);
        //Concatenar

    }

}

//7
function ejecutar_archivo_cliente($idmigracion, $idmodulo, $nombre_archivo,$proyecto){


    $gmigracion = new gmigracion();
    $gmigracion->sql->setDB($proyecto);

    if(strlen($nombre_archivo)>5){
        // validar nombre archivo longitud > 5

        $file = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$proyecto.DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$nombre_archivo;
        $file = trim(substr($file, 0, strlen($file)-4 ));

        $message.= "<br/>Server: archivo $file";

        global $DmpSqlBd;
        global $DmpSqlUsuario;
        global $DmpSqlPass;
        global $DmpSqlServidor;

        $mysqli = new mysqli($DmpSqlServidor['sgrc'], $DmpSqlUsuario['sgrc'], $DmpSqlPass['sgrc'], $proyecto);

        if (mysqli_connect_error()) {
            echo "mal";
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }
        $sql = file_get_contents($file);
        if (!$sql){
            die ('Error opening file');
        }
        mysqli_multi_query($mysqli,$sql);
        $mysqli->close();
        //$ejecutar=trim("mysql -u".trim($DmpSqlUsuario['sgrc'])." -p".trim($DmpSqlPass['sgrc'])." ".trim($proyecto)."< $file");
        //$ejecutar=trim("mysql -u".trim($DmpSqlUsuario['sgrc'])." -p".trim($DmpSqlPass['sgrc']));
        //$contenido_consulta=file_get_contents($file);
        //$sql = new DmpSql();
        //$result = $sql->consulta_multi($contenido_consulta,"sgrc");
        //if(!$result){
         //   echo "error";
        //}

        //echo "mysql --user=".$DmpSqlUsuario['sgrc']." --password=".$DmpSqlPass['sgrc']." --database=". $proyecto."< $file";
        //exec('"'.$ejecutar.'"',$out ,$retval);

        //echo ($retval);
        $gmigracion->actualiza_archivo_cliente($idmigracion,$idmodulo,$nombre_archivo);

        $gmigracion->finaliza_migracion($idmigracion,$idmodulo);



    }else{
        $message.= "<br/>Server: Se recibio el mensaje\n";
        $gmigracion->finaliza_migracion($idmigracion,$idmodulo);
    }

    $data["message"]=$message;

    echo json_encode($data);
}

function ver_cuerpo_inicial(){
     //phpinfo();
    $plantilla=new DmpTemplate("../../../plantillas/migracion/migracion/cuerpo.html");
    $plantilla->reemplaza("ipserver",$_SESSION[ip_servidor]);
    $plantilla->presentaPlantilla();
}


//8
function ejecutar_archivo_servidor($idmigracion,$idmodulo){

    global $DmpSqlBd;
    global $DmpSqlUsuario;
    global $DmpSqlPass;

    $imigracion = new imigracion();
    $gmigracion = new gmigracion();

    $result = $imigracion->lista_migracion_archivo($idmigracion,$idmodulo);
    while($fila= mysql_fetch_array($result)){

        $idmigracion_archivo = $fila[idmigracion_archivo];
        $nombre_archivo = $fila[nombre_archivo];

        $file = dirname(dirname(dirname( dirname(__FILE__) ) ) ).DIRECTORY_SEPARATOR.'archivo'.DIRECTORY_SEPARATOR.$_SESSION['proyecto'].DIRECTORY_SEPARATOR.ruta_archivo.DIRECTORY_SEPARATOR.$nombre_archivo;
        $file = substr($file, 0, strlen($file)-4 );

        exec("mysql --user=".$DmpSqlUsuario['sgrc']." --password=".$DmpSqlPass['sgrc']." --database=". $DmpSqlBd['sgrc']." < $file ");

        $gmigracion->actualiza_migracion_archivo($idmigracion_archivo,$idmigracion,$idmodulo);
        //Concatenar
    }

    $gmigracion->finaliza_migracion($idmigracion,$idmodulo);

}

function notificar_cliente_servidor($idmigracion, $idmodulo, $nombre_archivo){
     //Copiar archivo cliente al servidor
         // URL on which we have to post data
    $url = "http://".$_SESSION['ip_servidor']."/".$_SESSION['ruta_servidor']."/programas/migracion/migracion/amigracion.php?op_migracion=ejecutar_archivo_cliente&nombre_archivo=$nombre_archivo&idmodulo=".$idmodulo."&idmigracion=".$idmigracion."&proyecto=".$_SESSION['proyecto'];
    $message.= "<br/>Cliente: Empleando URL ".$url;

        // Initialize cURL
    $ch = curl_init();
        // Set URL on which you want to post the Form and/or data
    curl_setopt($ch, CURLOPT_URL, $url);

        // Pass TRUE or 1 if you want to wait for and catch the response against the request made
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // For Debug mode; shows up any error encountered during the operation
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
        // Execute the request
    $response = curl_exec($ch);

    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);



    if (200==$retcode) {
            // All's well

            // Just for debug: to see response
            //$message.= $response;
       $message.="<br/>".$response;

       $message.= "<br/>Cliente: Culminando notificacion";



       ejecutar_archivo_servidor($idmigracion, $idmodulo);


            //print_r($_SESSION);
   }else{

       $data["success"]=false;

       $message.= "<br/>Cliente: Error de notificacion";

           // Restaurar tabla migracion detalle...

       $gmigracion-> restaurar_migracion($idmigracion,$idmodulo);
   }

   return $message;
}

function validar_usuario($usuario,$password, $proyecto){
    $data= array();

    //17-03-14 $data["idmodulo"] = 0;
    $data["idmodulo"] = 0;

    $iusuario = new iusuario();
    $iusuario->sql->setDB($proyecto);

    $result_1 = $iusuario->lista_usuario_modulo($usuario, $password);

            //       $data["idmodulo"] = 2;
            // $data["idpersona"] = 186;
            // $data["idmodulo_persona"] = 1;
            // $data["apellido_p"] ="Pucee";
            // $data["apellido_m"] = "Lopez";
            // $data["nombre"] = "Ange";
    if($fila = mysql_fetch_array($result_1)){

        //echo "Configurando... 1";
        //if($fila[configurado]==0){
            // //echo "Configurando... 2";
            //         $data["idmodulo"] = 2;
            // $data["idpersona"] = 186;
            // $data["idmodulo_persona"] = 1;
            // $data["apellido_p"] ="Pucee";
            // $data["apellido_m"] = "Lopez";
            // $data["nombre"] = "Ange";

        $data["idmodulo"] = $fila[idmodulo];
        $data["idpersona"] = $fila[idpersona];
        $data["idmodulo_persona"] = $fila[idmodulo_persona];
        $data["apellido_p"] = $fila[apellido_p];
        $data["apellido_m"] = $fila[apellido_m];
        $data["nombre"] = $fila[nombre];

            //$gusuario = new gusuario();
            //$gusuario->actualizar_modulo($fila[idmodulo]);
        //}
    }


    //print_r($data);
    echo json_encode($data);

}

?>