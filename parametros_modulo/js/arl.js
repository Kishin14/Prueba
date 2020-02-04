// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    // var categoria_arlId = $('#categoria_arl_id').val();
    RequiredRemove();

    var categoria_arl  = new Array({campos:"categoria_arl_id",valores:$('#categoria_arl_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ARLClass.php';

	FindRow(categoria_arl,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function ARLOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_categoria_arl").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Categoria ARL");
}
function ARLOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
    document.getElementById('estado').value = 'A';
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('ARLForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,ARLOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,ARLOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});
	
