<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of itag
 *
 * @author dmontjoy
 */
class gtag {

    public $sql;

    function gtag() {
        $this->sql = new DmpSql();
    }

    function crear_tag($tag,$idtag_padre_compuesto,$idtag_entidad) {
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $idtag = 0;
        $fecha_c= date('Y-m-d');
        
        $fecha_a= date('Y-m-d');
        
        $consulta="SELECT COUNT(*) as cantidad from tag where tag like '$tag' and activo=1";       
        
        $result = $this->sql->consultar($consulta, "sgrc");
        
        if (!$result) {
            $error++;
            //echo $consulta;
            
        }else{
            $fila = mysql_fetch_array($result);
            if($fila[cantidad]>0){
                $error++;
            }
        }
                              
        if(strpos($idtag_padre_compuesto, "_") > 0){
            $aux=preg_split("/[_]+/", $idtag_padre_compuesto);
            $idtag_padre=$aux[0];
            $idmodulo_tag_padre=$aux[1];
            
            $consulta ="select nivel,ruta,tag, cantidad_hijos from tag 
                    where activo=1 
                    and idtag=$idtag_padre
                    and idmodulo_tag=$idmodulo_tag_padre";
        
            $result=$this->sql->consultar($consulta, "sgrc");
            
            $fila = mysql_fetch_array($result);
            
            //print_r($fila);exit;
            
            $nivel = $fila['nivel']+1;
            $ruta  = $fila['ruta'].$fila['tag'].'/';
            
            $consulta= "SELECT cantidad_hijos from tag 
                    where activo=1 
                    and idtag=$idtag_padre
                    and idmodulo_tag=$idmodulo_tag_padre FOR UPDATE";
        
            if (!$this->sql->consultar($consulta, "sgrc")) {
                $error++;
                //echo $consulta; 
            }


            $consulta= "UPDATE tag SET cantidad_hijos = cantidad_hijos + 1 where activo=1 
                    and idtag=$idtag_padre
                    and idmodulo_tag=$idmodulo_tag_padre";

            if (!$this->sql->consultar($consulta, "sgrc")) {
                $error++;
                //echo $consulta; 
            }
        
        }else{
            $nivel=0; 
            $ruta='/';
            $idtag_padre="NULL";
            $idmodulo_tag_padre="NULL";
            
        }   
        
        $cantidad_hijos=0;
        
        $consulta = "INSERT INTO
                  tag(idmodulo_tag,tag,activo,idusu_c,idmodulo_c,fecha_c,fecha_a,idtag_padre,idmodulo_tag_padre,nivel,cantidad_hijos,ruta)
                VALUES($_SESSION[idmodulo],'$tag',1,$_SESSION[idusu_c],$_SESSION[idmodulo_c],'$fecha_c','$fecha_a',$idtag_padre,$idmodulo_tag_padre,$nivel,$cantidad_hijos,'$ruta')";

        
        
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
            //echo $consulta; 
        }
                              
           
        $idtag = $this->sql->idtabla();
      
        $consulta_sincronizacion= $ayudante->migracion_insert("idtag",$idtag,$consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
        $tama_idtag_entidad= sizeof($idtag_entidad);
        
        $consulta_insert="";
        
        if($tama_idtag_entidad>0){
            for ($i = 0; $i < $tama_idtag_entidad; $i++) {
                $consulta_insert.="($_SESSION[idmodulo],$idtag_entidad[$i],$idtag,$_SESSION[idmodulo],1),";
            }
            
        }
        
         if (strlen($consulta_insert) > 0) {
                $cabecera_consulta_insert = "INSERT INTO
                                  `tag_entidad_tag`(
                                  `idmodulo_tag_entidad_tag`,
                                  `idtag_entidad`,
                                  `idtag`,
                                  `idmodulo_tag`,
                                  activo)
                                VALUES";

                $cabecera_consulta_insert.=$consulta_insert;
                $cabecera_consulta_insert = substr($cabecera_consulta_insert, 0, -1);
                //  echo $cabecera_consulta_insert_rc."<br>";
                if (!$this->sql->consultar($cabecera_consulta_insert, "sgrc")) {
                    //echo $cabecera_consulta_insert."<br>";
                    $error++;
                }
                $idtag_entidad_tag = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idtag_entidad_tag",$idtag_entidad_tag,$cabecera_consulta_insert);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }


        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }

        return $error . "***" . $idtag;
    }

    function actualizar($idtag, $idmodulo_tag, $tag, $idtag_entidad,$idtag_padre_compuesto) {
        
        $ayudante = new Ayudante();
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $fecha_a= date('Y-m-d H:i:s');
        //revisar el nombre
        $consulta="SELECT COUNT(*) as cantidad from tag where tag like '$tag' 
            and (idtag<>$idtag or idmodulo_tag<>$idmodulo_tag) AND activo=1";       
        //echo $consulta;
        $result = $this->sql->consultar($consulta, "sgrc");
        
        if (!$result) {
            $error++;
            
        }else{
            $fila = mysql_fetch_array($result);
            //verifica que no haya otro nombre igual
            if($fila[cantidad]>0){
                $error++;
            }
        }
        
        //echo $error;
        
        $consulta ="SELECT 
                      tag,idtag_padre, idmodulo_tag_padre,ruta
                    FROM 
                      tag 
                    WHERE
                     idtag=$idtag AND idmodulo_tag=$idmodulo_tag";
        
        $result=$this->sql->consultar($consulta, "sgrc");

        $fila = mysql_fetch_array($result);

        $idtag_padre_anterior = $fila['idtag_padre'];

        $idmodulo_tag_padre_anterior = $fila['idmodulo_tag_padre'];

        $tag_anterior=$fila['tag'];
        
        /**editar tag**/
        //if(strpos($idtag_padre_compuesto, "_") > 0){
        $aux=preg_split("/[_]+/", $idtag_padre_compuesto);
       
        $idtag_padre=$aux[0];
        
        $idmodulo_tag_padre=$aux[1];
      
        //echo "uno ".$idtag_padre_anterior;
        //echo "dos ".$idtag_padre;
        if($idtag_padre_anterior!=$idtag_padre || $idmodulo_tag_padre_anterior!=$idmodulo_tag_padre){
            
            if($idtag_padre_anterior!='' || $idmodulo_tag_padre_anterior!=''){
                 
                ///padre antiguo                 
                $consulta= "SELECT cantidad_hijos from tag 
                        where activo=1 
                        and idtag=$idtag_padre_anterior
                        and idmodulo_tag=$idmodulo_tag_padre_anterior FOR UPDATE";

                if (!$this->sql->consultar($consulta, "sgrc")) {
                    $error++;
                    //echo $consulta; 
                }

                //RESTA HIJOS
                ///PADRE nuevo, solo debemos actualizar la cantidad de hijos
                $consulta= "UPDATE tag SET cantidad_hijos = cantidad_hijos - 1 where 
                        idtag=$idtag_padre_anterior
                        and idmodulo_tag=$idmodulo_tag_padre_anterior";
                //echo $error;
                //echo $consulta;
                //echo $consulta;
                if (!$this->sql->consultar($consulta, "sgrc")) {
                    $error++;

                }              
            }
            
            if($idtag_padre!='' || $idmodulo_tag_padre!=''){
          
                $consulta ="SELECT nivel,ruta,tag, cantidad_hijos from tag 
                        where 
                        idtag=$idtag_padre
                        and idmodulo_tag=$idmodulo_tag_padre";

                $result=$this->sql->consultar($consulta, "sgrc");

                $fila = mysql_fetch_array($result);

                $nivel = $fila['nivel']+1;
                $ruta  = $fila['ruta'].$fila['tag'].'/';
            }else{
                $idtag_padre='NULL';
                $idmodulo_tag_padre='NULL';
                $nivel=0;
                $ruta='/';
            }
            //rutas que cambian
            $chijos_cambiar_ruta="SELECT idtag,idmodulo_tag,ruta FROM tag WHERE ruta LIKE '%/$tag_anterior/%'"; //sus hijos
            //echo $chijos_cambiar_ruta;
            //echo  $error;
            //echo "<br>".$chijos_cambiar_ruta;
            $result=$this->sql->consultar($chijos_cambiar_ruta, "sgrc");
            while($fila=mysql_fetch_array($result)){
               $patron="/".".*\/".$tag_anterior."\/"."/"; //todas a la izquierda
               $cadena=$fila['ruta'];
               //el que se mueve no esta cambiando la ruta a sus hijos
               $sustituir=$ruta."$tag_anterior/";//nueva ruta
               /*echo "<br>"."patron ".$patron;
               echo "<br>"."sustituir ".$sustituir;
               echo "<br>"."cadena ".$cadena;
               echo "<br>";*/
               $nueva_ruta=preg_replace($patron, $sustituir, $cadena);
               $nuevo_nivel=substr_count($nueva_ruta,'/');
               $nuevo_nivel=$nuevo_nivel-1;
               $cupdate="UPDATE tag SET ruta='$nueva_ruta',nivel=$nuevo_nivel  WHERE idtag=$fila[idtag] AND idmodulo_tag=$fila[idmodulo_tag]";
               //echo $cupdate."<br>";
              if (!$this->sql->consultar($cupdate, "sgrc")) {
                  $error++;
              } 
              //echo $error;
              $consulta_sincronizacion= $ayudante->migracion_update($consulta);

              if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                  $error++;
              }
            }
            //echo $error;
            //fin rutas que cambian
            
            //valido que el nuevo padre no sea la raiz así no se le tienen de sumar hijos
            if($idtag_padre!='' || $idmodulo_tag_padre!=''){
                $consulta= "SELECT cantidad_hijos from tag 
                        where 
                        idtag=$idtag_padre
                        and idmodulo_tag=$idmodulo_tag_padre FOR UPDATE";
                //echo $consulta;
                if (!$this->sql->consultar($consulta, "sgrc")) {
                    $error++;
                    //echo $consulta; 
                }

                $consulta= "UPDATE tag SET cantidad_hijos = cantidad_hijos + 1 where idtag=$idtag_padre
                        and idmodulo_tag=$idmodulo_tag_padre";

                if (!$this->sql->consultar($consulta, "sgrc")) {
                    $error++;          
                }

            }else{
                $idtag_padre=NULL;
                $idmodulo_tag_padre=NULL;
                $nivel=0;
            }
            //echo $error;
            $update="UPDATE tag SET tag='$tag',idusu_a=$_SESSION[idusu_a],idmodulo_a=$_SESSION[idmodulo_a],fecha_a='$fecha_a',idtag_padre=$idtag_padre,idmodulo_tag_padre=$idmodulo_tag_padre,nivel=$nivel,ruta='$ruta' WHERE idtag=$idtag AND idmodulo_tag=$idmodulo_tag";
            //echo $update;
        }else{
            $update="UPDATE tag SET tag='$tag',idusu_a=$_SESSION[idusu_a],idmodulo_a=$_SESSION[idmodulo_a],fecha_a='$fecha_a',idtag_padre=$idtag_padre,idmodulo_tag_padre=$idmodulo_tag_padre WHERE idtag=$idtag AND idmodulo_tag=$idmodulo_tag ";
           //echo $update;
        }
        //$cantidad_hijos=0;
        /*****update inicial***/
        
        //echo $update;
        if (!$this->sql->consultar($update, "sgrc")) {
            $error++;
            //echo $consulta;
        }

       $consulta_sincronizacion= $ayudante->migracion_update($update);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
            //echo $consulta_sincronizacion;
        }    
               
        /**editar tag**/
       
        $tama_tag_entidad = sizeof($idtag_entidad);
        $consulta_insert = "";
        if ($tama_tag_entidad > 0) {

            for ($i = 0; $i < $tama_tag_entidad; $i++) {
                // echo "veamos ".$idcompromiso_rc[$i];
                if (strpos($idtag_entidad[$i], "***")) {
                    //actualiza siempre que haya cambio en el estado
                    // es el array $aaux_tag

                    $aux = explode("***", $idtag_entidad[$i]);
                    
                    $fecha_a= date('Y-m-d H:i:s');

                    $consulta_update = "UPDATE tag_entidad_tag SET activo=$aux[1] WHERE idtag_entidad=$aux[0] AND activo!=$aux[1] AND idtag=$idtag AND idmodulo_tag=$idmodulo_tag";
                    //echo "<br>".$consulta_update_rc;exit;
                    if (!$this->sql->consultar($consulta_update, "sgrc")) {

                        $error++;
                    }
                     $consulta_sincronizacion= $ayudante->migracion_update($consulta_update);

                    if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                        $error++;
                    }
                } elseif (strpos($idtag_entidad[$i], "###")) {
                    $aux = explode("###", $idtag_entidad[$i]);
                    if($aux[1]>0)
                        $consulta_insert.="($_SESSION[idmodulo],1,$idtag,$idmodulo_tag,$aux[0]),";
                }
            }
            //echo $consulta_insert_rc;exit;
            if (strlen($consulta_insert) > 0) {
                $cabecera_consulta_insert = "INSERT INTO
                                  `tag_entidad_tag`(
                                  `idmodulo_tag_entidad_tag`,
                                  `activo`,
                                  `idtag`,
                                  `idmodulo_tag`,
                                  `idtag_entidad`)
                                VALUES";

                $cabecera_consulta_insert.=$consulta_insert;
                $cabecera_consulta_insert = substr($cabecera_consulta_insert, 0, -1);
                //  echo $cabecera_consulta_insert_rc."<br>";
                if (!$this->sql->consultar($cabecera_consulta_insert, "sgrc")) {
                    //echo $cabecera_consulta_insert_rc."<br>";
                    $error++;
                }
                $idtag_entidad_tag = $this->sql->idtabla();
                        
                $consulta_sincronizacion= $ayudante->migracion_insert_multiple("idtag_entidad_tag ",$idtag_entidad_tag ,$cabecera_consulta_insert);

                if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                    $error++;
                }
            }
        }
        
       if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        } 

        return $error;
    }

    function eliminar($idtag, $idmodulo_tag) {
        $ayudante = new Ayudante();
        
        //consultar si ha sido utilizado por persona o interaccion
        $this->sql->consultar("START TRANSACTION", "sgrc");
        $error = 0;
        $consulta="UPDATE persona_tag SET activo=2 WHERE idtag='$idtag' AND idmodulo_tag='$idmodulo_tag' AND activo=1";
        
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
            //echo $consulta;
        }
        //echo $error;
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }        
        /*
        $consulta = "SELECT count(*) AS nume_persona FROM persona_tag WHERE idtag='$idtag' AND idmodulo_tag='$idmodulo_tag' AND activo=1";
        //echo $consulta . "<br>";
        $result = $this->sql->consultar($consulta, "sgrc");

        $fila = mysql_fetch_array($result);
        $nume_persona = $fila['nume_persona'];
        */
        
        $consulta="UPDATE interaccion_tag SET activo=2 WHERE idtag='$idtag' AND idmodulo_tag='$idmodulo_tag' AND activo=1";
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
            //echo $consulta;
        }
        
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }      
        /*
        $consulta = "SELECT count(*) AS nume_interaccion FROM interaccion_tag
            left join interaccion
            on interaccion_tag.idinteraccion = interaccion.idinteraccion
            and interaccion_tag.idmodulo_interaccion=interaccion.idmodulo_interaccion
            WHERE interaccion_tag.idtag='$idtag' AND interaccion_tag.idmodulo_tag='$idmodulo_tag' AND interaccion.activo=1";

        //echo $consulta . "<br>";

        $result = $this->sql->consultar($consulta, "sgrc");
        $fila = mysql_fetch_array($result);
        $nume_interaccion = $fila['nume_interaccion'];
        */
        
        $consulta = "SELECT cantidad_hijos AS nume_hijos FROM tag WHERE idtag='$idtag' AND idmodulo_tag='$idmodulo_tag' AND activo=1";

        //echo $consulta . "<br>";

        $result = $this->sql->consultar($consulta, "sgrc");
        $fila = mysql_fetch_array($result);
        $nume_hijos = $fila['nume_hijos'];

        $nume_total = $nume_interaccion + $nume_persona + $nume_hijos;
        $nume_total = $nume_hijos;

        //bloquedar
        
        $consulta ="SELECT 
                      tag,idtag_padre, idmodulo_tag_padre,ruta
                    FROM 
                      tag 
                    WHERE
                     idtag=$idtag AND idmodulo_tag=$idmodulo_tag";
        $result=$this->sql->consultar($consulta, "sgrc");
   
        if($fila=mysql_fetch_array($result)){
            $idtag_padre=$fila['idtag_padre'];
            $idmodulo_tag_padre=$fila['idmodulo_tag_padre'];
        }
        if($idtag_padre!=''|| $idmodulo_tag_padre!=''){
          
            $consulta="SELECT cantidad_hijos from tag 
                        where activo=1 
                        and idtag=$idtag_padre
                        and idmodulo_tag=$idmodulo_tag_padre FOR UPDATE";          
            if (!$this->sql->consultar($consulta, "sgrc")) {
                $error++;
                //echo $consulta;
            } 
            
            $consulta = "UPDATE
                    tag
                  SET
                    cantidad_hijos=cantidad_hijos-1
                  WHERE
                    idtag=$idtag_padre
                  AND
                    idmodulo_tag=$idmodulo_tag_padre";

        
            if (!$this->sql->consultar($consulta, "sgrc")) {
                $error++;
                //echo $consulta;
            }

            $consulta_sincronizacion= $ayudante->migracion_update($consulta);

            if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
                $error++;
            }          
            
        }

        
        $fecha_a= date('Y-m-d H:i:s');
            
        $consulta = "UPDATE
                  tag
                SET
                  `fecha_a`='$fecha_a',activo=0, cantidad_hijos=cantidad_hijos-1
                WHERE
                  idtag=$idtag
                AND
                  idmodulo_tag=$idmodulo_tag";

        
        if (!$this->sql->consultar($consulta, "sgrc")) {
            $error++;
            //echo $consulta;
        }
        
        $consulta_sincronizacion= $ayudante->migracion_update($consulta);

        if(!$this->sql->consultar($consulta_sincronizacion,"sgrc")){
            $error++;
        }
        
        $error = $nume_total + $error;
        
        if ($error == 0) {
            $this->sql->consultar("COMMIT", "sgrc");
        } else {
            $this->sql->consultar("ROLLBACK", "sgrc");
        }
        //echo "error " . $error;
        return $error;
    }

}

?>
