<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
$proyecto = $_REQUEST['proyecto'];

connect($proyecto);
/*
$query1 = "select idtag, idmodulo_tag 
    from tag 
    where activo=1";

$result1 = executeQuery( $query1 );
*/

/*
while($tag = mysql_fetch_array($result1)){
    
        $query2 = "insert into tag_entidad_tag(
					idmodulo_tag_entidad_tag,
					activo,
					idtag,
					idmodulo_tag,
					idtag_entidad) 
					values
					(
					$tag[idmodulo_tag],
					1,
					$tag[idtag],
					$tag[idmodulo_tag],
					1),
					(
					$tag[idmodulo_tag],
					1,
					$tag[idtag],
					$tag[idmodulo_tag],
					2),
					(
					$tag[idmodulo_tag],
					1,
					$tag[idtag],
					$tag[idmodulo_tag],
					3)"; 
        
        $result2 = executeQuery( $query2 );
        
    
}
*/


for($i=2;$i<=68;$i++){
        /*
        $query2 = "insert into predio(
					idpredio,
					activo,
					nombre) 
					values
					(
					$i,
					1,
					'Predio Est - $i')"; 
        
        $result2 = executeQuery( $query2 );
        */
        /*
        $query2 = "insert into gis_item(
                                            idgis_item
                                            ) 
                                            values
                                            (                                            
                                            'Estancia.$i')"; 

        $result2 = executeQuery( $query2 );
         * 
         */
    
         $query2 = "insert into predio_gis_item(
                                            idpredio_gis_item,
                                            idpredio,
                                            idgis_item
                                            ) 
                                            values
                                            (
                                            $i,
                                            $i,
                                            'Estancia.$i')"; 

        $result2 = executeQuery( $query2 );
    
}

mysql_close(); 

function connect( $dbName ) 
  { 
    mysql_connect("localhost", "root", "sgrc2013" ); 
    mysql_select_db( $dbName ); 
  } 

  function executeQuery( $query ) 
  {       
      echo "Query : $query </br>";
      flush();
      $result= mysql_query( $query ); 
      $err   = mysql_error(); 
      if( $err != "" ) echo "error=$err  ";       
      return $result; 
  } 

?>
