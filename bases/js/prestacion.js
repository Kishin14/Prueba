// JavaScript Document
function setDataFormWithResponse(){
	RequiredRemove();
	var parametros  = new Array({campos:"tercero_id",valores:$('#tercero_id').val()});
	var forma       = document.forms[0];
	var controlador = 'EmpPrestacionClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}

function EmpPrestacionOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_empresa_prestaciones").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	$('#tipo_identificacion_id').val('2');
	$('#tipo_persona_id').val('2');	
	if($('#tipo_identificacion_id'))     $('#tipo_identificacion_id').attr("disabled","true");	
	if($('#tipo_persona_id'))     $('#tipo_persona_id').attr("disabled","true");	
	alertJquery(resp,"Empresas");
}

function EmpPrestacionOnReset(formulario){
	 Reset(formulario);
    clearFind();  
    setFocusFirstFieldForm(formulario); 
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	$('#tipo_identificacion_id').val('2');
	$('#tipo_persona_id').val('2');	
	if($('#tipo_identificacion_id'))     $('#tipo_identificacion_id').attr("disabled","true");	
	if($('#tipo_persona_id'))     $('#tipo_persona_id').attr("disabled","true");		
}

$(document).ready(function(){
	$('#tipo_identificacion_id').val('2');
	$('#tipo_persona_id').val('2');	
	if($('#tipo_identificacion_id'))     $('#tipo_identificacion_id').attr("disabled","true");	
	if($('#tipo_persona_id'))     $('#tipo_persona_id').attr("disabled","true");		

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('EmpPrestacionForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,EmpPrestacionOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,EmpPrestacionOnSaveOnUpdateonDelete)
			}
		}
	});

	$("#numero_identificacion").blur(function(){
	
		 var tercero_id            = $("#tercero_id").val();
		 var numero_identificacion = this.value;
		 var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});
		 
		 if(!tercero_id.length > 0){
		 
		   validaRegistro(this,params,"EmpPrestacionClass.php",null,function(resp){    
																																	  
			 if(parseInt(resp) != 0 ){
			   var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
			   var formulario = document.forms[0];
			   var url        = 'EmpPrestacionClass.php';
		
			   FindRow(params,formulario,url,null,function(resp){
														   
			   var data = $.parseJSON(resp);
			   //ocultaFilaNombresRazon(data[0]['tipo_persona_id']);	     
														   
														 
			   clearFind();		 
			 
			   $('#guardar').attr("disabled","true");
			   $('#actualizar').attr("disabled","");
			   $('#borrar').attr("disabled","");
			   $('#limpiar').attr("disabled","");	
														 
			   });
			 
			}else{	   		  
				calculaDigitoTercero();				  
				$('#guardar').attr("disabled","");
				$('#actualizar').attr("disabled","true");
				$('#borrar').attr("disabled","true");
				$('#limpiar').attr("disabled","");
			   }
		   });
		 
		 }
		
	});

});