<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

connect("sgrc");

$query1 = "select idcompromiso, idmodulo_compromiso 
    from compromiso 
    where idusu_c is NULL or idmodulo_c is NULL";

$result1 = executeQuery( $query1 );

while($compromiso = mysql_fetch_array($result1)){
    
    $query2 = "select idrc, idmodulo 
        from compromiso_rc 
        where idcompromiso=$compromiso[idcompromiso] 
            and idmodulo_compromiso=$compromiso[idmodulo_compromiso] 
                and activo=1
                order by idcompromiso_rc asc limit 1";
    $result2 = executeQuery( $query2 );
    
    if($compromiso_rc = mysql_fetch_array($result2)){
        
        $query3 = "update compromiso
            set idusu_c=$compromiso_rc[idrc],
                idmodulo_c=$compromiso_rc[idmodulo]
        where idcompromiso=$compromiso[idcompromiso] 
            and idmodulo_compromiso=$compromiso[idmodulo_compromiso]"; 
        
        $result3 = executeQuery( $query3 );
        
    }
}

mysql_close(); 

function connect( $dbName ) 
  { 
    mysql_connect("localhost", "root", "" ); 
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
