<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classtemplate
 *
 * @author daniel montjoy
 */
include_once(ruta."/SIGH/programas/utiles/smarty/Smarty.class.php");

class template extends Smarty {
    function template($ruta_template="") {
        $this->template_dir = ruta_plantillas ."$ruta_template";
        $this->compile_dir = ruta_sigh.'programas/utiles/smarty/templates_c';
        $this->config_dir = ruta_sigh.'programas/utiles/smarty/configs';
        $this->cache_dir = ruta_sigh.'programas/utiles/smarty/cache';
    }
}
?>
