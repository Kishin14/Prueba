// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#fondo_pensional_id').val();
	var parametros  = new Array({campos:"fondo_pensional_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'PensionalClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}
function PensionalOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_fondo_pensional").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}
function PensionalOnReset(formulario){
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
		var formulario = document.getElementById('PensionalForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,PensionalOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,PensionalOnSaveOnUpdateonDelete)
			}
		}
	});
});