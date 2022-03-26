// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var tipo_concepto_laboral_id = $('#tipo_concepto_laboral_id').val();
    RequiredRemove();

    var tipo_concepto  = new Array({campos:"tipo_concepto_laboral_id",valores:$('#tipo_concepto_laboral_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ConceptoClass.php';

	FindRow(tipo_concepto,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function ConceptoOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_tipo_concepto").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Conceptos");
}

function ConceptoOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('ConceptoForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,ConceptoOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,ConceptoOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});
	
