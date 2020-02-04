// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#perfil_id').val();
	RequiredRemove();
	var parametros  = new Array({campos:"perfil_id",valores:$('#perfil_id').val()});
	var forma       = document.forms[0];
	var controlador = 'PerfilClass.php';

	
	FindRow(parametros,forma,controlador,null,function(resp){

  var data              = $.parseJSON(resp);
  var perfil_id = data[0]['perfil_id']; 

  document.getElementById('VehiculoPerfil').src = 'VehiculoPerfilClass.php?perfil_id='+perfil_id;
  document.getElementById('ProfesionPerfil').src = 'ProfesionPerfilClass.php?perfil_id='+perfil_id;


		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}

function PerfilOnSaveOnUpdateonDelete(formulario,resp){
	// Reset(formulario);
	// clearFind();
	$("#refresh_QUERYGRID_perfil").click();
 //  resetDetalle('VehiculoPerfil');
 //  resetDetalle('ProfesionPerfil');
	// if($('#guardar'))    $('#guardar').attr("disabled","");
	// if($('#actualizar')) $('#actualizar').attr("disabled","true");
	// if($('#borrar'))     $('#borrar').attr("disabled","true");
	// if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function PerfilOnReset(formulario){
	 // Reset(formulario);
    clearFind();  
    // setFocusFirstFieldForm(formulario); 
    document.getElementById('VehiculoPerfil').src = '../../../framework/tpl/blank.html'; 
    document.getElementById('ProfesionPerfil').src = '../../../framework/tpl/blank.html'; 
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

$(document).ready(function(){

  $("#saveDetalles").click(function(){
    window.frames[0].saveDetallesSoliServi();
  });
    
  $("#deleteDetalles").click(function(){
    window.frames[0].deleteDetallesSoliServi();
  });  

  $("#saveDetalles2").click(function(){
    window.frames[1].saveDetallesSoliServi2();
  });
    
  $("#deleteDetalles2").click(function(){
    window.frames[1].deleteDetallesSoliServi2();
  });  

  resetDetalle('VehiculoPerfil');
  resetDetalle('ProfesionPerfil');
	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('PerfilForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,PerfilOnSaveOnUpdateonDelete);
				document.getElementById('VehiculoPerfil').src = 'VehiculoPerfilClass.php?perfil_id=-1';
				document.getElementById('ProfesionPerfil').src = 'ProfesionPerfilClass.php?perfil_id=-1';
			}else{
				Send(formulario,'onclickUpdate',null,PerfilOnSaveOnUpdateonDelete);
				Reset(formulario);
				resetDetalle('VehiculoPerfil');
				resetDetalle('ProfesionPerfil');
				if($('#guardar'))    $('#guardar').attr("disabled","");
				if($('#actualizar')) $('#actualizar').attr("disabled","true");
				if($('#borrar'))     $('#borrar').attr("disabled","true");
				if($('#limpiar'))    $('#limpiar').attr("disabled","");
				document.getElementById('VehiculoPerfil').src = '../../../framework/tpl/blank.html';
				document.getElementById('ProfesionPerfil').src = '../../../framework/tpl/blank.html';
			}
		}
	});
  resetDetalle('VehiculoPerfil');
  resetDetalle('ProfesionPerfil');
});