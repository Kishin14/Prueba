// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var tipo_incapacidadId = $('#tipo_incapacidad_id').val();
    RequiredRemove(); 

    var tipo_incapacidad  = new Array({campos:"tipo_incapacidad_id",valores:$('#tipo_incapacidad_id').val()});
	var forma       = document.forms[0];
	var controlador = 'IncapacidadClass.php';

	FindRow(tipo_incapacidad,forma,controlador,null,function(resp){
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");	
		var tipo = $('#tipo').val();
		var descuento = $('#descuento').val();
		if(tipo == 'L'){
			$('#descuento').attr("disabled","true");
			$('#dia').attr("disabled","true");
			$('#porcentaje').attr("disabled","true");		  
			$('#descuento').val("N");
			$('#dia').val("");	
			$('#porcentaje').val("");				
		}else{
			$('#descuento').attr("disabled","");
		}	


		if(descuento == 'S'){
			$('#dia').attr("disabled","");
			$('#porcentaje').attr("disabled","");		  
			
		}else{
			$('#dia').attr("disabled","true");
			$('#porcentaje').attr("disabled","true");		  
			$('#dia').val("");	
			$('#porcentaje').val("");				
			
		}	


    });


}

function IncapacidadOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_tipo_incapacidad").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Incapacidades");
}
function IncapacidadOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('IncapacidadForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,IncapacidadOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,IncapacidadOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });


  $("#tipo").change(function(){
	if(this.value == 'L'){
		$('#descuento').attr("disabled","true");
		$('#dia').attr("disabled","true");
		$('#porcentaje').attr("disabled","true");		  
		$('#descuento').val("N");
		$('#dia').val("");	
		$('#porcentaje').val("");				
	}else{
		$('#descuento').attr("disabled","");
	}	
	
  
  });

  $("#descuento").change(function(){
	if(this.value == 'S'){
		$('#dia').attr("disabled","");
		$('#porcentaje').attr("disabled","");		  
		
	}else{
		$('#dia').attr("disabled","true");
		$('#porcentaje').attr("disabled","true");		  
		$('#dia').val("");	
		$('#porcentaje').val("");				
		
	}	
	
  
  });

});
	

