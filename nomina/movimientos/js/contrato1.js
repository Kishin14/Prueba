// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#contrato_id').val();
	var parametros  = new Array({campos:"contrato_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'ContratoClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
										   
	    var data              = $.parseJSON(resp);
	    var estado = data[0]['estado'];
		var tipo = data[0]['tipo'];
		var prestaciones_sociales = data[0]['prestaciones_sociales'];		
		 

		if(estado=='A'){
			if($('#actualizar')) $('#actualizar').attr("disabled","");
			if($('#anular'))     $('#anular').attr("disabled","");

		}else if(estado=='AN' || estado=='F' || estado=='L' || estado=='R'){
			if($('#actualizar')) $('#actualizar').attr("disabled","true");
			if($('#anular'))     $('#anular').attr("disabled","true");
		}

		if(tipo=='F'){
			$("#fecha_terminacion").addClass("obligatorio");	
			$("#fecha_terminacion").addClass("requerido");	
			$('#fecha_terminacion').attr("disabled","");  
		}else{
			$("#fecha_terminacion").removeClass("obligatorio");	
			$("#fecha_terminacion").removeClass("requerido");
			$('#fecha_terminacion').attr("disabled","true");  
		}
		
		if(prestaciones_sociales=='1'){
			$("#horario_ini,#horario_fin,#empresa_eps,#empresa_pension,#empresa_arl,#empresa_caja,#empresa_cesan,#empresa_eps_id,#empresa_pension_id,#empresa_arl_id,#empresa_caja_id,#empresa_cesan_id").addClass("obligatorio");	
			$('#horario_ini,#horario_fin,#empresa_eps,#empresa_pension,#empresa_arl,#empresa_caja,#empresa_cesan').attr("disabled","");  
		}else{
			$("#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan,#empresa_caja_id,#empresa_cesan_id").removeClass("obligatorio");	
			$("#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan").removeClass("requerido");
			$('#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan').attr("disabled","true");  
			$('#empresa_caja_id,#empresa_cesan_id').val("");  					
			$('#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan').val("");  
		}

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
	});
}


function setDataEmpleado(empleado_id){
    
  var QueryString = "ACTIONCONTROLER=setDataEmpleado&empleado_id="+empleado_id;
  
  $.ajax({
    url        : "ContratoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
		  var responseArray        	  = $.parseJSON(response); 
		  var empleado             	  =responseArray[0]['empleado'];
		  var empleado_id      	      =responseArray[0]['empleado_id'];  
		  $("#empleado").val(empleado);
		  $("#empleado_id").val(empleado_id);
 
      }catch(e){
     	//alertJquery(e);
      }
      
    }
    
  });
  
}
  
function setDataCargo(cargo_id){
    
  var QueryString = "ACTIONCONTROLER=setDataCargo&cargo_id="+cargo_id;
  
  $.ajax({
    url        : "ContratoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
		  var responseArray        	  = $.parseJSON(response); 
		  var cargo             	  =responseArray[0]['cargo'];
		  var cargo_id      	      =responseArray[0]['cargo_id'];  
		  $("#cargo").val(cargo);
		  $("#cargo_id").val(cargo_id);
 
      }catch(e){
	     //alertJquery(e);
       }
      
    }
    
  });
  
}
  

function ContratoOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_contrato").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#anular'))     $('#anular').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Contrato");
}

function ContratoOnReset(formulario){
	Reset(formulario);
    clearFind();  
	$("#estado").val('A');
	$('#contrato_id').attr("disabled","");
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#anular'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

$(document).ready(function(){
						   
  $("#estado").change(function(){

      if(this.value == 'F'){
		
		$("#causal_despido_id").addClass("obligatorio");	
		$("#causal_despido_id").addClass("requerido");	

	  }else{		  
	   				  
		 
 		 $("#causal_despido_id").removeClass("obligatorio");		 
 		 $("#causal_despido_id").removeClass("requerido");		 		 
		 
	    }
	});

  $("#tipo_contrato_id").change(function(){
	 var tipo_contrato_id = $('#tipo_contrato_id').val();
	 if(parseInt(tipo_contrato_id)>0){
		  var QueryString = "ACTIONCONTROLER=setTipoContra&tipo_contrato_id="+tipo_contrato_id;
		  
		  $.ajax({
			url        : "ContratoClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			  
			},
			success    : function(response){
			  
			  try{
		 
				  var responseArray       = $.parseJSON(response); 
				  var tipo             	  = responseArray['tipo'];
  				  var prestaciones_sociales= responseArray['prestaciones_sociales'];
				  if(tipo=='F'){
					$("#fecha_terminacion").addClass("obligatorio");	
					$("#fecha_terminacion").addClass("requerido");	
					$('#fecha_terminacion').attr("disabled","");  
				  }else{
					$("#fecha_terminacion").removeClass("obligatorio");	
					$("#fecha_terminacion").removeClass("requerido");
					$('#fecha_terminacion').attr("disabled","true");  
				  }

				  if(prestaciones_sociales=='1'){
					$("#horario_ini,#horario_fin,#empresa_eps,#empresa_pension,#empresa_arl,#empresa_caja,#empresa_cesan,#empresa_eps_id,#empresa_pension_id,#empresa_arl_id,#empresa_caja_id,#empresa_cesan_id").addClass("obligatorio");	
					$('#horario_ini,#horario_fin,#empresa_eps,#empresa_pension,#empresa_arl,#empresa_caja,#empresa_cesan').attr("disabled","");  
				  }else{
					$("#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan,#empresa_caja_id,#empresa_cesan_id").removeClass("obligatorio");	
					$("#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan").removeClass("requerido");
					$('#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan').attr("disabled","true");  
					
					$('#empresa_caja_id,#empresa_cesan_id').val("");  					
					$('#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan').val("");  
				  }

			  }catch(e){
				 //alertJquery(e);
			  }
			  
			}
			
		  });
	 }
	});

///INICIO VALIDACION FECHAS DE REPORTE
 
 $('#fecha_terminacion').change(function(){

    var fechat = $('#fecha_terminacion').val();
    var fechai = $('#fecha_inicio').val();
	var today = new Date();

    if ((Date.parse(fechat) < Date.parse(fechai)) || (Date.parse(fechat)>today)) {
     alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
     return this.value = $('#fecha_inicio').val();
    };
 });
 
  $('#fecha_terminacion_real').change(function(){

    var fechat = $('#fecha_terminacion_real').val();
    var fechai = $('#fecha_inicio').val();
	var today = new Date();

    if ((Date.parse(fechat) < Date.parse(fechai)) || (Date.parse(fechat)>today)) {
     alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
     return this.value = $('#fecha_inicio').val();
    };
 });
 
 ///FIN VALIDACION FECHAS DE REPORTE

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('ContratoForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,ContratoOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,ContratoOnSaveOnUpdateonDelete)
			}
		}
   });
});



function beforePrint(){
	
   var contrato_id = parseInt(document.getElementById("contrato_id").value);
      
   if(isNaN(contrato_id)){
     alertJquery("Debe Seleccionar un Contrato !!","Impresion Contrato"); 
     return false;
   }else{
      return true;
    }
  
  
}