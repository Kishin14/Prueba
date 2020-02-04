// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#parametros_liquidacion_id').val();
	var parametros  = new Array({campos:"parametros_liquidacion_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'ParametrosLiquidacionClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
		console.log(resp);

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}

function ParametrosLiquidacionOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_ParametrosLiquidacion_Salariales").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function ParametrosLiquidacionOnReset(formulario){
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
		var formulario = document.getElementById('ParametrosLiquidacionForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,ParametrosLiquidacionOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,ParametrosLiquidacionOnSaveOnUpdateonDelete)
			}
		}
	});
});


function setOficinasCliente(empresa_id,oficina_id){
	
	var QueryString = "ACTIONCONTROLER=setOficinasCliente&empresa_id="+empresa_id+"&oficina_id="+oficina_id;
	
	$.ajax({
		url     : "ParametrosLiquidacionClass.php?rand="+Math.random(),
		data    : QueryString,
		success : function(response){
			$("#oficina_id").parent().html(response);
		}
	});
}