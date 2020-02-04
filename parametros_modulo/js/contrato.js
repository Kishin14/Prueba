// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var tipo_contratoId = $('#tipo_contrato_id').val();
    RequiredRemove();

    var tipo_contrato  = new Array({campos:"tipo_contrato_id",valores:$('#tipo_contrato_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ContratoClass.php';

	FindRow(tipo_contrato,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function ContratoOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_tipo_contrato").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Contratos");
}

function ContratoOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('ContratoForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,ContratoOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,ContratoOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

  $('#tipo').change(function(){
    if($('#tipo').val() == 'I'){
      $('#tiempo_contrato').attr('disabled',true);
    }
    if ($('#tipo').val() == 'F') {
      $('#tiempo_contrato').attr('disabled', false);
    }
  });

  

});
	
