// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
      // var estudiosId = $('#nivel_educativo_id').val();
    RequiredRemove();

    var nivel_escolaridad  = new Array({campos:"nivel_escolaridad_id",valores:$('#nivel_escolaridad_id').val()});
	var forma       = document.forms[0];
	var controlador = 'EstudiosClass.php';

	FindRow(nivel_escolaridad,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function EstudiosOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_nivel_escolaridad").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Estudios");
}
function EstudiosOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('EstudiosForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){	
				 formSubmitted = true;	
				 Send(formulario,'onclickSave',null,EstudiosOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,EstudiosOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});
	
