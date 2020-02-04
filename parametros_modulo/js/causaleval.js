// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var causal_desempenoId = $('#causal_desempeno_id').val();
    RequiredRemove();

    var causal_desempeno  = new Array({campos:"causal_desempeno_id",valores:$('#causal_desempeno_id').val()});
	var forma       = document.forms[0];
	var controlador = 'CausalEvalClass.php';

	FindRow(causal_desempeno,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function CausalEvalOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_causal_desempeno").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Causas evaluación de desempeño");
}
function CausalEvalOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('CausalEvalForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,CausalEvalOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,CausalEvalOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});
	
