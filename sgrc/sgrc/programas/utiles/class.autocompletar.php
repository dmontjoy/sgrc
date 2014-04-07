<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of autocompletar
 *
 * @author dmontjoy
 */
class autocompletar {
    //put your code here
   var $value;
   var $label;
   
   //constructor que recibe los datos para inicializar los elementos
   function __construct($label, $value){
      $this->label = $label;
      $this->value = $value;
   }
}

?>
