// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    RequiredRemove();

    var novedad  = new Array({campos:"contrato_id",valores:$('#contrato_id').val()});
	var forma       = document.forms[0];
	var controlador = 'FinalizarContratosClass.php';

	FindRow(novedad,forma,controlador,null,function(resp){											
		   
	if ($("#actualizar")) $("#actualizar").attr("disabled", "");	 
	  
    });

}

function setDataContrato(contrato_id){
    
  var QueryString = "ACTIONCONTROLER=setDataContrato&contrato_id="+contrato_id;
  
  $.ajax({
    url        : "FinalizarContratosClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
		  var responseArray          = $.parseJSON(response); 
		  var fecha_inicio           = responseArray[0]['fecha_inicio'];
		  var fecha_terminacion      = responseArray[0]['fecha_terminacion'];  		
		  var estado     			 = responseArray[0]['estado'];  		
		  var motivo_terminacion_id  = responseArray[0]["motivo_terminacion_id"];  		
		  var causal_despido_id      = responseArray[0]["causal_despido_id"];  		
		  var fecha_terminacion_real = responseArray[0]["fecha_terminacion_real"];  		
		  
		  $("#fecha_inicio").val(fecha_inicio);
		  $("#fecha_terminacion").val(fecha_terminacion);
		  $("#estado").val(estado);
		  $("#fecha_terminacion_real").val(fecha_terminacion_real);
		  $("#motivo_terminacion_id").val(motivo_terminacion_id);
		  $("#causal_despido_id").val(causal_despido_id);

		 if ($("#actualizar")) $("#actualizar").attr("disabled", "");
			  
      }catch(e){
     	console.log("Error : "+e);
      }
      
    }
    
  });
  
}

function FinalizarContratosOnUpdate(formulario,resp){

	if(resp == 'true'){
		alertJquery("Se actualizo correctamente el contrato !!");
		Reset(formulario);
		clearFind();
		$("#refresh_QUERYGRID_contrato").click();

		if ($("#actualizar")) $("#actualizar").attr("disabled", "");
		if ($("#limpiar")) $("#limpiar").attr("disabled", "");
	}else{

		alertJquery(resp,"Error");
	}
  
}


function FinalizarContratosOnReset(formulario){
	
    clearFind();	
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
	
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	$('#estado').val("A");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('FinalizarContratosForm');
						   
  $("#actualizar").click(function(){
	
	Send(formulario,'onclickUpdate',null,FinalizarContratosOnUpdate);
			
	formSubmitted = false;
  
  });


});