// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var causal_novedadId = $('#causal_novedad_id').val();
    RequiredRemove();

    var causal_novedad  = new Array({campos:"causal_novedad_id",valores:$('#causal_novedad_id').val()});
	var forma       = document.forms[0];
	var controlador = 'NovedadClass.php';

	FindRow(causal_novedad,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function NovedadOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_causal_novedad").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Causas evaluación de desempeño");
}
function NovedadOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('NovedadForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,NovedadOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,NovedadOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});
	
