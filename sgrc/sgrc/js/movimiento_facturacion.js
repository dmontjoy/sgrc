


function ver_editar_periodo(idperiodo) {

 idpersona= $("#idpersona").val();
 idmodulo=$("#idmodulo").val();

 $.ajax({
  url: '../../../programas/empresa_local/movimiento_facturacion/amovimiento_facturacion.php?op_empresa_local=ver_editar_periodo&idpersona=' + idpersona + '&idmodulo=' + idmodulo +'&idperiodo=' + idperiodo,
  beforeSend: function() {
    $("#cdetalle_movimiento_facturacion").html('<table width="100%"><tr><td align="center"><img src="../../../img/bar-ajax-loader.gif"></td></tr></table>');
  },
  error: function(objeto, quepaso, otro) {
    alert(quepaso);
  },
  success: function(datos) {

                    //console.log(datos);
                    $("#cdetalle_movimiento_facturacion").html(datos);
                  }
                });

}




function ver_editar_hogar(idsh_hogar, idmodulo_sh_hogar){
 idpersona= $("#idpersona").val();
 idmodulo=$("#idmodulo").val();

 $.ajax({
  url: '../../../programas/stakeholder/stakeholder/astakeholder.php?op_stakeholder=ver_editar_hogar&idsh_hogar=' + idsh_hogar + '&idmodulo_sh_hogar=' + idmodulo_sh_hogar+'&idpersona='+idpersona+'&idmodulo='+idmodulo,
  beforeSend: function() {

    $("#hogar").html('<table width="100%"><tr><td align="center"><img src="../../../img/bar-ajax-loader.gif"></td></tr></table>');
  },
  error: function(objeto, quepaso, otro) {
    alert(quepaso);
  },
  success: function(data) {

   $("#hogar").html(data);
 },

});
}