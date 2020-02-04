// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#convocatoria_id').val();
	var parametros  = new Array({campos:"convocatoria_id",valores:parametrosId});
	var formulario       = document.forms[0];
	var controlador = 'ConvocatoriaClass.php';

	
	FindRow(parametros,formulario,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}

function ConvocatoriaOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_convocatoria").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function ConvocatoriaOnReset(formulario){
	Reset(formulario);
    clearFind();  
    setFocusFirstFieldForm(formulario); 
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

$(document).ready(function(){

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('ConvocatoriaForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,ConvocatoriaOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,ConvocatoriaOnSaveOnUpdateonDelete)
			}
		}
	});
});