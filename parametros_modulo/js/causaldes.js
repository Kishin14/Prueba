// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var causal_despidoId = $('#causal_despido_id').val();
    RequiredRemove();

    var causal_despido  = new Array({campos:"causal_despido_id",valores:$('#causal_despido_id').val()});
	var forma       = document.forms[0];
	var controlador = 'CausalDesClass.php';

	FindRow(causal_despido,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function CausalDesOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_causal_despido").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Causales Despidos");
}
function CausalDesOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('CausalDesForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,CausalDesOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,CausalDesOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});
	
