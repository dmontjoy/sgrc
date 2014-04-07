<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tag_anterior="montjoy";
$patron="/".".*\/".$tag_anterior."\/"."/"; //todas a la izquierda
echo $patron;
echo "<br>";
$cadena="/daniel/montjoy/pita";
$sustituir="/geray/";
$nueva_ruta=preg_replace($patron, $sustituir, $cadena);
echo $cadena;
echo "<br>";
echo $nueva_ruta;
echo "<br>";
echo $nuevo_nivel=substr_count($nueva_ruta,'/');

?>
