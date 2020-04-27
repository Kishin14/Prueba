$(document).ready(function(){
	
	 $('#fecha_inicio').change(function(){

    var fechah = $('#fecha_final').val();
    var fechad = $('#fecha_inicio').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
     alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
     return this.value = $('#fecha_final').val();
	};

	
 });

	var fechah = $('#fecha_final').val();
	var fechad = $('#fecha_inicio').val();
	var fecha_i = fechah.substr(0, 4);
	var fecha_f = fechad.substr(0, 4);

		if (fecha_i!=fecha_f) {
			alertJquery('Las fechas deben ser entre el mismo periodo.');
			$('#fecha_inicio').val('');
			$('#fecha_final').val('');
		}

 $('#fecha_final').change(function(){

    var fechah = $('#fecha_final').val();
    var fechad = $('#fecha_inicio').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
     alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
     return this.value = $('#fecha_inicio').val();
	};

	var fecha_i = fechah.substr(0, 4);
	var fecha_f = fechad.substr(0, 4);
	if (fecha_i!=fecha_f) {
		alertJquery('Las fechas deben ser entre el mismo periodo.');
    	return this.value = $('#fecha_inicio').val();
	}
 });


 $('#si_contrato').change(function(){

    if ($('#si_contrato').val()=='ALL') {
		$('#contrato').attr("disabled","true");
		$('#contrato_hidden').attr("disabled","true");
	}else{
		$('#contrato').attr("disabled","");
		$('#contrato_hidden').attr("disabled","");
		$('#contrato').addClass('obligatorio');
		$('#contrato').addClass('requerido');
	}
 });


});


function renovar(contrato_id){
	
	parent.renovarcontrato(contrato_id);
}


function setDataFinal(){
	
  var fecha_inicio = $("#fecha_inicio_renovacion").val();
 // var numero_meses = document.getElementById('numero_meses').value;
  var QueryString = "ACTIONCONTROLER=setDataFinal&fecha_inicio="+fecha_inicio;
  //alert($("#fecha_inicio_renovacion")+'fecha');
  
  $.ajax({
    url        : "LiqRetencionClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray       = $.parseJSON(response); 
		var fecha_final_renovacion  = responseArray[0]['fecha_final_renovacion'];
		
		$("#fecha_final_renovacion").val(fecha_final_renovacion);
	
      }catch(e){
	  	alertJquery(e);
      }
      
    }
    
  });
}

function setDataActualiza(){
	
  var fecha_inicio = $("#fecha_inicio_actualiza").val();
  var numero_meses = document.getElementById('numero_meses_actualiza').value;
  var QueryString = "ACTIONCONTROLER=setDataActualiza&fecha_inicio="+fecha_inicio+"&numero_meses="+numero_meses;
  
  $.ajax({
    url        : "LiqRetencionClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray       = $.parseJSON(response); 
		var fecha_final_actualiza  = responseArray[0]['fecha_final_actualiza'];
		
		$("#fecha_final_actualiza").val(fecha_final_actualiza);
	
      }catch(e){
	  	alertJquery(e);
      }
      
    }
    
  });
}

function generateReporte(form){
	var contrato_id    			= $("#contrato_hidden").val();
	var si_contrato    			= $("#si_contrato").val();
	var fecha_inicio    		= $("#fecha_inicio").val();
	var fecha_final				= $("#fecha_final").val();
	var QueryString = "LiqRetencionClass.php?ACTIONCONTROLER=generateReporte&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&contrato_id="+contrato_id+"&si_contrato="+si_contrato;
	$("#frameRetencion").attr("src",QueryString);

}

function generateReporteExcel(form){
	var QueryString = "LiqRetencionClass.php?ACTIONCONTROLER=generateReporte&download=SI";
	 document.location.href = QueryString;
}

function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "LiqRetencionClass.php?ACTIONCONTROLER=generateReporte&printers=si";  
	   popPup(QueryString,'Impresi&oacute;n Pendientes',800,600);
   }else{
	 alertJquery("Por favor ingrese los datos requeridos","Validaci&oacute;n");
   }
}
function closeDialog(){
	$("#Renovarmarco").dialog('close');
}

function renovarcontrato(contrato_id){
	
   if(parseInt(contrato_id)>0){
	   
	   $("#contrato_id").val(contrato_id);
	   
		$("#Renovarmarco").dialog({
		  title: 'Liquidar Retenciones',
		  width: 750,
		  height: 640,
		  closeOnEscape:true
		 });
	   
   }else{
	 alertJquery("Por favor seleccione un contrato!","Validaci&oacute;n");
	   
   }
   setDataContrato(contrato_id);
}

function finalizarcontrato(contrato_id){
	
   if(parseInt(contrato_id)>0){
	   
	   $("#contrato_id").val(contrato_id);
	   
		$("#Finalizarmarco").dialog({
			title: 'Finalizar Contrato',
			width: 620,
			height: 640,
			closeOnEscape:true
		 });
	   
   }else{
	 alertJquery("Por favor seleccione un contrato!","Validaci&oacute;n");
	   
   }
   setDataFinaliza(contrato_id);
}

function actualizarcontrato(contrato_id){
	
   if(parseInt(contrato_id)>0){
	   
	   $("#contrato_id").val(contrato_id);
	   
		$("#Actualizarmarco").dialog({
		  title: 'Actualizar Contrato',
		  width: 750,
			height: 640,
		  closeOnEscape:true
		 });
	   
   }else{
	 alertJquery("Por favor seleccione un contrato!","Validaci&oacute;n");
	   
   }
   setDataActualizar(contrato_id);
}

function setDataActualizar(contrato_id){
		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataActualizar&contrato_id="+contrato_id;
	
   $.ajax({
	 url        : "LiqRetencionClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
		 showDivLoading();
	 },
	 success    : function(resp){
	 		 
		 try{
			 
			 var dataResp = $.parseJSON(resp);	 

			 $("#contrato_id").val(dataResp[0]['contrato_id']);				 
			 $("#consecutivo_actualiza").val(dataResp[0]['numero_contrato']);		 			 
			 $("#fecha_inicio_2_actualiza").val(dataResp[0]['fecha_inicio']);				 				 
			 $("#fecha_final_2_actualiza").val(dataResp[0]['fecha_final']);
			 $("#fecha_inicio_actualiza").val(dataResp[0]['fecha_inicio_actualiza']);				 				 
			 $("#fecha_final_actualiza").val(dataResp[0]['fecha_final_actualiza']);
			 $("#canon_actualiza").val(dataResp[0]['empleado_id']);
			 $("#numero_meses_actualiza").val(dataResp[0]['subsidio_transporte']);
			 $("#canon_antiguo_actualiza").val(dataResp[0]['sueldo_base']);
			 $("#administracion_actualiza").val(dataResp[0]['estado']);			 				 				 			 				 				 	

		 
		 }catch(e){
			   alertJquery(resp,"Error :"+e);
			}
		 
		 removeDivLoading();
	 }
	
   });

	
}

function setDataContrato(contrato_id){

	

		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataContrato&contrato_id="+contrato_id;
	
   $.ajax({
	 url        : "LiqRetencionClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
		 showDivLoading();
	 },
	 success    : function(resp){
	 		 
		 try{
			 var dataResp = $.parseJSON(resp);	 

			 $("#contrato_id").val(dataResp[0]['contrato_id']);				 
			 $("#consecutivo_renueva").val(dataResp[0]['numero_contrato']);		 			 
			 $("#fecha_inicio2").val(dataResp[0]['fecha_inicio']);				 				 
			 $("#fecha_final2").val(dataResp[0]['fecha_terminacion']);
			 $("#fecha_inicio_renovacion").val(dataResp[0]['fecha_inicio_renovacion']);				 				 
			 $("#fecha_final_renovacion").val(dataResp[0]['fecha_final_renovacion']);
			 $("#numero_meses").val(dataResp[0]['empleado_id']);
			 $("#administracion").val(dataResp[0]['subsidio_transporte']);
			 $("#canon_renovacion").val(dataResp[0]['sueldo_base']);
			 $("#propietario_renueva").val(dataResp[0]['estado']);			 				 				 			 				 				 	

			 var today = new Date();
			var fecha_inicio_renovacion = document.getElementById("fecha_inicio_renovacion").value;
	  		if (Date.parse(fecha_inicio_renovacion) > today) {
     				alertJquery('La fecha de inicio no puede ser mayor a la fecha actual.');
     				$('#renovar').attr("disabled","true");
    			}else{
    				$('#renovar').attr("disabled","");
    			}
		 
		 }catch(e){
			   alertJquery(resp,"Error :"+e);
			}
		 
		 removeDivLoading();
	 }
	
   });



   
}

function setDataFinaliza(contrato_id){
		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataFinaliza&contrato_id="+contrato_id;
	
   $.ajax({
	 url        : "LiqRetencionClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
		 showDivLoading();
	 },
	 success    : function(resp){
	 		 
		 try{
			 var dt = new Date();
			 var month = dt.getMonth()+1;
			 var day = dt.getDate();
			 var year = dt.getFullYear();
			 var dataResp = $.parseJSON(resp);	 

			 $("#contrato_id").val(dataResp[0]['contrato_id']);				 
			 $("#consecutivo2").val(dataResp[0]['numero_contrato']);
			 $("#fecha_solicitud").val(dataResp[0]['fecha_inicio']);
			 $("#cliente_finaliza").val(dataResp[0]['empleado_id']);
			 $("#propietario_id").val(dataResp[0]['subsidio_transporte']);
			 $("#arrendatario_id").val(dataResp[0]['sueldo_base']);

		 
		 }catch(e){
			   alertJquery(resp,"Error :"+e);
			}
		 
		 removeDivLoading();
	 }
	
   });

	
}


function onclickFinalizar(formulario){

	if(ValidaRequeridos(formulario)){
		
			var contrato_id			=	$("#contrato_id").val();
			var fecha_retiro			=	$("#fecha_retiro").val();
			var fecha_entrega			=	$("#fecha_entrega").val();
			var observacion_retiro		=	$("#observacion_retiro").val();
			
			if(parseInt(contrato_id)>0){
				var QueryString = "ACTIONCONTROLER=onclickFinalizar&contrato_id="+contrato_id+"&fecha_retiro="+fecha_retiro+
				"&observacion_retiro="+observacion_retiro+"&fecha_entrega="+fecha_entrega;
				$.ajax({
					url        : "LiqRetencionClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
						showDivLoading();
					},
					success    : function(resp){
						try{
							
							alertJquery(resp,"Finalizar Contrato");
							$("#Finalizarmarco").dialog('close');
							ResetForm(formulario);
							
						}catch(e){
							alertJquery(resp,"Error :"+e);
							ResetForm(formulario);
						}
						removeDivLoading();
						//ResetForm(formulario);
					}
				});
			}else{
				alertJquery("Por favor seleccione un contrato.","Validacion");
			}
	}
}

function onclickRenovar(formulario){

	if(ValidaRequeridos(formulario)){
		
			var contrato_id			=	$("#contrato_id").val();
			var fecha_inicio			=	$("#fecha_inicio_renovacion").val();
			var fecha_final				=	$("#fecha_final_renovacion").val();
			var administracion			=	$("#administracion").val();
			var canon_renovacion		=	$("#canon_renovacion").val();
			var canon_viejo				=	$("#canon_viejo").val();
			var observacion_renovacion	=	$("#observacion_renovacion").val();
			
			if(parseInt(contrato_id)>0){
				var QueryString = "ACTIONCONTROLER=onclickRenovar&contrato_id="+contrato_id+"&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&administracion="+administracion+"&canon_renovacion="+canon_renovacion+"&canon_viejo="+canon_viejo+"&observacion_renovacion="+observacion_renovacion;
				$.ajax({
					url        : "LiqRetencionClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
						showDivLoading();
					},
					success    : function(resp){
						try{
							
							alertJquery(resp,"Renovar Contrato");
							$("#Renovarmarco").dialog('close');
							ResetForm(formulario);
							
						}catch(e){
							alertJquery(resp,"Error :"+e);
							ResetForm(formulario);
						}
						removeDivLoading();
						//ResetForm(formulario);
					}
				});
			}else{
				alertJquery("Por favor seleccione un contrato.","Validacion");
			}
	}
}

function onclickActualizar(formulario){

	if(ValidaRequeridos(formulario)){
		
			var contrato_id			=	$("#contrato_id").val();
			var fecha_inicio			=	$("#fecha_inicio_actualiza").val();
			var fecha_final				=	$("#fecha_final_actualiza").val();
			var administracion			=	$("#administracion_actualiza").val();
			var canon					=	$("#canon_actualiza").val();
			var canon_antiguo_actualiza	=	$("#canon_antiguo_actualiza").val();
			var observacion_actualiza	=	$("#observacion_actualiza").val();
			
			if(parseInt(contrato_id)>0){
				var QueryString = "ACTIONCONTROLER=onclickActualizar&contrato_id="+contrato_id+"&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&administracion="+administracion+"&canon="+canon+"&canon_antiguo_actualiza="+canon_antiguo_actualiza+"&observacion_actualiza="+observacion_actualiza;
				$.ajax({
					url        : "LiqRetencionClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
						showDivLoading();
					},
					success    : function(resp){
						try{
							
							alertJquery(resp,"Actualizar Contrato");
							$("#Actualizarmarco").dialog('close');
							ResetForm(formulario);
							
						}catch(e){
							alertJquery(resp,"Error :"+e);
							ResetForm(formulario);
						}
						removeDivLoading();
						//ResetForm(formulario);
					}
				});
			}else{
				alertJquery("Por favor seleccione un contrato.","Validacion");
			}
	}
}

function setDataFormWithResponse(){
	var activo_id	=	document.getElementById("activo_id").value;
	var cantidad	=	document.getElementById("cantidad").value;
	var formulario	=	document.forms[0];
	var QueryString = "ACTIONCONTROLER=onclickFind&activo_id="+activo_id;
	$.ajax({
		url        : "LiqRetencionClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){
			try{
				var data	= $.parseJSON(resp);
				if(isNaN(parseInt(data[0]['activo_id']))){ 
					return false;
				}
				$("#activo_id").val(data[0]['activo_id']);
				$("#activo").val(data[0]['activo']);
				$("#concepto").val(data[0]['concepto']);
				$("#tercero").val(data[0]['tercero']);
				$("#tercero_id").val(data[0]['tercero_id']);
				$("#tabla_depreciacion_id").val(data[0]['tabla_depreciacion_id']);
				$("#valor").val(data[0]['valor']);
				
				//setFormWithJSON(formulario,data);
				$("#cantidad").val(cantidad);
				// if($('#guardar'))		$('#guardar').attr("disabled","true");
				// if($('#actualizar'))	$('#actualizar').attr("disabled","");
				// if($('#borrar'))		$('#borrar').attr("disabled","");
				// if($('#limpiar'))		$('#limpiar').attr("disabled","");
			}catch(e){
				alertJquery(resp,"Error :"+e);
			}
			removeDivLoading();
		}
	});
}

function ResetForm(formulario){

	Reset(formulario);
	$("#busqueda").val('');
	$("#contrato").val('');
	$("#contrato_id").val('');
	$("#fecha_inicio").val('');
	$("#fecha_final").val('');
	$("#frameRetencion").attr("src",'');

	
}