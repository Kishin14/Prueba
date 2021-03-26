// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#contrato_id').val();
	var parametros  = new Array({campos:"contrato_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'ContratoClass.php';
	var tipo = '';

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
			$("#horario_ini,#horario_fin,#empresa_eps,#empresa_pension,#empresa_arl,#empresa_caja,#empresa_cesan,#empresa_eps_id,#empresa_pension_id,#empresa_arl_id,#empresa_caja_id,#empresa_cesan_id,#empresa_pension,#empresa_pension_id").addClass("obligatorio");	
			$('#horario_ini,#horario_fin,#empresa_eps,#empresa_pension,#empresa_arl,#empresa_caja,#empresa_cesan,#empresa_pension,#empresa_pension_id').attr("disabled","");  
		  }else{
			$("#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan,#empresa_caja_id,#empresa_cesan_id,#empresa_pension,#empresa_pension_id,#fecha_inicio_pension,#fecha_inicio_compensacion,#fecha_inicio_cesantias").removeClass("obligatorio");	
			$("#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan,#empresa_pension,#empresa_pension_id,#fecha_inicio_pension,#fecha_inicio_compensacion,#fecha_inicio_cesantias").removeClass("requerido");
			$('#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan,#empresa_pension,#empresa_pension_id,#fecha_inicio_pension,#fecha_inicio_compensacion,#fecha_inicio_cesantias').attr("disabled","true");  
			
			$('#empresa_caja_id,#empresa_cesan_id,#empresa_pension,#empresa_pension_id').val("");  					
			$('#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan').val("");  
		  }

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
	});
}

function showTable(){
  
	var frame_grid =  document.getElementById('frame_grid');
	
	  //Se valida que el iFrame no exista
	  if(frame_grid == null ){
  
	  var QueryString   = 'ACTIONCONTROLER=showGrid';
  
	  $.ajax({
		url        : "ContratoClass.php?rand="+Math.random(),
		data       : QueryString,
		 async     : false,
		beforeSend : function(){
		showDivLoading();
		},
		success    : function(resp){
		  console.log(resp);
		  try{
			
			var iframe           = document.createElement('iframe');
			iframe.id            ='frame_grid';
			iframe.style.cssText = "border:0; height: 400px; background-color:transparent";
			//iframe.scrolling   = 'no';
			
			document.body.appendChild(iframe); 
			iframe.contentWindow.document.open();
			iframe.contentWindow.document.write(resp);
			iframe.contentWindow.document.close();
			
			$('#mostrar_grid').removeClass('btn btn-warning btn-sm');
			$('#mostrar_grid').addClass('btn btn-secondary btn-sm');
			$('#mostrar_grid').html('Ocultar tabla');
			
		  }catch(e){
			
			console.log(e);
			
		  }
		  removeDivLoading();
		} 
	  });
	  
	}else{
	  
		$('#frame_grid').remove();
		$('#mostrar_grid').removeClass('btn btn-secondary btn-sm');
		$('#mostrar_grid').addClass('btn btn-warning btn-sm');
		$('#mostrar_grid').html('Mostrar tabla');
	  
	}
	
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
	ContratoOnReset(formulario);
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

	 $("#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real").removeClass("obligatorio");		 
	 $("#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real").removeClass("requerido");		 		 
	 $('#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real,#fecha_terminacion').attr("disabled","true"); 
	 $('#fecha_terminacion').val('');
	 
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

	
	$("#empresa_eps").keypress(function(){

		$("#fecha_inicio_eps").val('');
		$("#fecha_inicio_eps").addClass("obligatorio");	
		$("#fecha_inicio_eps").addClass("requerido");	

	});


	$("#empresa_pension").keypress(function(){

		$("#fecha_inicio_pension").val('');
		$("#fecha_inicio_pension").addClass("obligatorio");	
		$("#fecha_inicio_pension").addClass("requerido");	
	});

	$("#empresa_arl").keypress(function(){

		$("#fecha_inicio_arl").val('');
		$("#fecha_inicio_arl").addClass("obligatorio");	
		$("#fecha_inicio_arl").addClass("requerido");	
	});

	$("#empresa_caja").keypress(function(){

		$("#fecha_inicio_compensacion").val('');
		$("#fecha_inicio_compensacion").addClass("obligatorio");	
		$("#fecha_inicio_compensacion").addClass("requerido");	
	});

	$("#empresa_cesan").keypress(function(){

		$("#fecha_inicio_cesantias").val('');
		$("#fecha_inicio_cesantias").addClass("obligatorio");	
		$("#fecha_inicio_cesantias").addClass("requerido");	
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
				  tipo             	  = responseArray['tipo'];
				  var tiempo_contrato  	  = responseArray['tiempo_contrato'];
				  var prestaciones_sociales= responseArray['prestaciones_sociales'];
				  $('#tiempo_contrato').val(tiempo_contrato);
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
					$("#horario_ini,#horario_fin,#empresa_eps,#empresa_pension,#empresa_arl,#empresa_caja,#empresa_cesan,#empresa_eps_id,#empresa_pension_id,#empresa_arl_id,#empresa_caja_id,#empresa_cesan_id,#empresa_pension,#empresa_pension_id").addClass("obligatorio");	
					$('#horario_ini,#horario_fin,#empresa_eps,#empresa_pension,#empresa_arl,#empresa_caja,#empresa_cesan,#empresa_pension,#empresa_pension_id').attr("disabled","");  
				  }else{
					  $("#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan,#empresa_caja_id,#empresa_cesan_id,#empresa_pension,#empresa_pension_id,#fecha_inicio_pension,#fecha_inicio_compensacion,#fecha_inicio_cesantias").removeClass("obligatorio");	
					  $("#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan,#empresa_pension,#empresa_pension_id,#fecha_inicio_pension,#fecha_inicio_compensacion,#fecha_inicio_cesantias").removeClass("requerido");
					  $('#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan,#empresa_pension,#empresa_pension_id,#fecha_inicio_pension,#fecha_inicio_compensacion,#fecha_inicio_cesantias').attr("disabled","true");  
					
					$('#empresa_caja_id,#empresa_cesan_id,#empresa_pension,#empresa_pension_id').val("");  					
					$('#horario_ini,#horario_fin,#empresa_caja,#empresa_cesan').val("");  
				  }
				  
				  if(!isNaN(tiempo_contrato)){ 
					calculaFechaFin(tiempo_contrato,tipo);
				  }

			  }catch(e){
				 //alertJquery(e);
			  }
			  
			}
			
		  });
	 }
  });
  
  $('#fecha_inicio').change(function(){	  
	  var tiempo_contrato = $('#tiempo_contrato').val();
	  calculaFechaFin(tiempo_contrato,tipo);
	});
///INICIO VALIDACION FECHAS DE REPORTE
 
 $('#fecha_terminacion').change(function(){

    var fechat = $('#fecha_terminacion').val();
    var fechai = $('#fecha_inicio').val();
	var today = new Date();

	if($('#fecha_terminacion').is(':disabled')){
		$('#fecha_terminacion').val('');
	}else{
		if ((Date.parse(fechat) < Date.parse(fechai)) ) {
		 alertJquery('Esta fecha no puede ser menor a la fecha de inicio .');
		  $('#fecha_terminacion').val('');
		}else{
			if(Date.parse(fechat)<today){
				$("#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real").addClass("obligatorio");	
				$("#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real").addClass("requerido");	
				$('#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real').attr("disabled","");  
				$('#estado').val('F');
	
			}else{
				 $("#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real").removeClass("obligatorio");		 
				 $("#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real").removeClass("requerido");		 		 
				 $('#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real').attr("disabled","true"); 
				$('#causal_despido_id,#motivo_terminacion_id,#fecha_terminacion_real').val("");  				 
				 $('#estado').val('A');
	
			}
		}
	
	}
 });
 
  $('#fecha_terminacion_real').change(function(){

    var fechat = $('#fecha_terminacion_real').val();
    var fechai = $('#fecha_inicio').val();
	var today = new Date();

	if($('#fecha_terminacion_real').is(':disabled')){
		$('#fecha_terminacion_real').val('');
	}else{
		if((Date.parse(fechat) < Date.parse(fechai)) || (Date.parse(fechat)>today)) {
		 alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
		  $('#fecha_terminacion_real').val('');
		}
	}
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


function calculaFechaFin(tiempo_contrato,tipo_contrato = 'F'){

	var fechai = $('#fecha_inicio').val();

	if(fechai != ''){
	
		var QueryString = "ACTIONCONTROLER=calculaFechaFin&fechai="+fechai+"&tiempo_contrato="+tiempo_contrato;
		  
		  $.ajax({
			url        : "ContratoClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			  
			},
			success    : function(response){
			  
			  try{
				  var responseArray       = $.parseJSON(response); 
				  var fecha_fin        	  = responseArray['fechafin'];
				  
				  //Valida Contrato Indefinido
				  
				  var fecha_fin = tipo_contrato == 'I' ? '' : fecha_fin;
				  
				  $('#fecha_terminacion').val(fecha_fin);
				 
			  }catch(e){
				 alertJquery(e);
			  }
			  
			}
			
		  });
		}else{
			alertJquery("¡Por favor ingrese la fecha inicio y seleccione nuevamente el TIPO DE CONTRATO!");
		}
}

function beforePrint(){
	
   var contrato_id = parseInt(document.getElementById("contrato_id").value);
      
   if(isNaN(contrato_id)){
     alertJquery("Debe Seleccionar un Contrato !!","Impresion Contrato"); 
     return false;
   }else{
      return true;
    }
  
  
}