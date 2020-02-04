// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#parametro_liquidacion_id').val();
	var parametros  = new Array({campos:"parametro_liquidacion_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'LiquidacionClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}

function LiquidacionOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_parametro_liquidacion").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function LiquidacionOnReset(formulario){
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
		var formulario = document.getElementById('LiquidacionForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,LiquidacionOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,LiquidacionOnSaveOnUpdateonDelete)
			}
		}
	});
});