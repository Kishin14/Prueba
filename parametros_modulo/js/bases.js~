// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#id_datos').val();
	var parametros  = new Array({campos:"id_datos",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'BasesClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}

function BasesOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_Bases_Salariales").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function BasesOnReset(formulario){
	return true;
	//  Reset(formulario);
 //    clearFind();  
 //    setFocusFirstFieldForm(formulario); 
	// if($('#guardar'))    $('#guardar').attr("disabled","");
	// if($('#actualizar')) $('#actualizar').attr("disabled","true");
	// if($('#borrar'))     $('#borrar').attr("disabled","true");
	// if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

$(document).ready(function(){

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('BasesForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,BasesOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,BasesOnSaveOnUpdateonDelete)
			}
		}
	});
});