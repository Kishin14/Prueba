// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
	
    var liquidacion_int_cesantias_id = $('#liquidacion_int_cesantias_id').val();
    RequiredRemove();

    var liquidacion  = new Array({campos:"liquidacion_int_cesantias_id",valores:$('#liquidacion_int_cesantias_id').val()});
	var forma       = document.forms[0];
	var controlador = 'IntCesantiasClass.php';

	FindRow(liquidacion,forma,controlador,null,function(resp){
														
		 var data   = $.parseJSON(resp);													   
		 var empleado_id = data[0]['empleado_id'];
		 
		  var estado = data[0]['estado'];
		 		 
		 if(estado == 'I' || estado == 'C'){
			 
		   $(forma).find("input,select,textarea").each(function(){
               this.disabled = true;																
           });
		   
		 }else{
			 
		     $(forma).find("input,select,textarea").each(function(){
               this.disabled = false;																
             });	
			 $('#estado').attr("disabled","true");
			 
		  }
     	 var url    = "DetalleIntCesantiasClass.php?liquidacion_int_cesantias_id="+liquidacion_int_cesantias_id+"&rand="+Math.random();
	 
	 $("#detalleIntCesantias").attr("src",url);
	 $("#detalleIntCesantias").load(function(){
  	    getTotalDebitoCredito(liquidacion_int_cesantias_id);
     });
      if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#previsual'))  $('#previsual').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
	  if($('#estado').val()=='A'){ 
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");		
		  if($('#imprimir')) 		$('#imprimir').attr("disabled","true");		
		  if($('#anular')) 			$('#anular').attr("disabled","");  
	  }else if($('#estado').val()=='C'  ){
		  
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			
  		  if($('#imprimir')) 		$('#imprimir').attr("disabled","");		
		  if($('#anular')) 			$('#anular').attr("disabled","");  

	  }else if( $('#estado').val()=='I' ){
		  
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			
  		  if($('#imprimir')) 		$('#imprimir').attr("disabled","");		
		  if($('#anular')) 			$('#anular').attr("disabled","true");  
		  

	  }	  
    });


}


function Empleado_si(){
	if($('#si_empleado').val()==1){
		
		  $('#empleado').attr("disabled","");	
		  $("#empleado").addClass("obligatorio");
		  $('#fecha_ultimo_corte').attr("disabled","true");		  

		  $('#num_identificacion,#cargo,#salario,#fecha_inicio_contrato,#valor_liquidacion,#valor_liquidacion1,#valor_consolidado,#valor_diferencia,#dias_no_remu,#dias_liquidados').val('');
 		  $("#num_identificacion,#cargo,#salario,#fecha_inicio_contrato,#valor_liquidacion,#valor_liquidacion1,#valor_consolidado,#valor_diferencia,#dias_no_remu,#dias_liquidados").addClass("obligatorio");
		  $('#num_identificacion,#cargo,#salario,#fecha_inicio_contrato,#valor_liquidacion,#valor_liquidacion1,#valor_consolidado,#valor_diferencia,#dias_no_remu,#dias_liquidados').attr("disabled","");

	}else if($('#si_empleado').val()=='ALL'){
		
		  $('#empleado').attr("disabled","true");
		  $('#empleado').val('');
		  $('#empleado_id').val('');
 		  $("#empleado").removeClass("obligatorio");
		  $('#fecha_ultimo_corte').attr("disabled","");
		  $('#num_identificacion,#cargo,#salario,#fecha_inicio_contrato,#valor_liquidacion,#valor_liquidacion1,#valor_consolidado,#valor_diferencia,#dias_no_remu,#dias_liquidados').val('');
 		  $("#num_identificacion,#cargo,#salario,#fecha_inicio_contrato,#valor_liquidacion,#valor_liquidacion1,#valor_consolidado,#valor_diferencia,#dias_no_remu,#dias_liquidados").removeClass("obligatorio");
		  $('#num_identificacion,#cargo,#salario,#fecha_inicio_contrato,#valor_liquidacion,#valor_liquidacion1,#valor_consolidado,#valor_diferencia,#dias_no_remu,#dias_liquidados').attr("disabled","true");
	}

}

function getTotalDebitoCredito(liquidacion_int_cesantias_id){
		
	var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_int_cesantias_id="+liquidacion_int_cesantias_id;
	

	$.ajax({
      url     : "IntCesantiasClass.php",
	  data    : QueryString,
	  success : function(response){
		  		  
		  try{
			 var totalDebitoCredito = $.parseJSON(response); 
             var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
			 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
             var totalDiferencia    = Math.abs(totalDebito - totalCredito);
			 
			 $("#totalDebito").html(totalDebito);
			 $("#totalCredito").html(totalCredito);
			 $("#totalDiferencia").html(totalDiferencia);
		  }catch(e){
			  
		  }
      }
	  
    });    


}

function setDataEmpleado(empleado_id){
    
  var QueryString = "ACTIONCONTROLER=setDataEmpleado&empleado_id="+empleado_id;
  
  $.ajax({
    url        : "IntCesantiasClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 			
		  var responseArray        	  = $.parseJSON(response); 
		  var contrato_id             =responseArray[0]['contrato_id'];
		  var sueldo_base      	      =responseArray[0]['sueldo_base']; 
		  var cargo      	      	  =responseArray[0]['cargo']; 
		  var empleado     	      	  =responseArray[0]['empleado']; 
		  var numero_identificacion   =responseArray[0]['numero_identificacion']; 
		  var fecha_inicio   		  =responseArray[0]['fecha_inicio']; 
		  var fecha_ultimo_corte   	  =responseArray[0]['fecha_ultimo_corte']!=null ?  responseArray[0]['fecha_ultimo_corte'] : responseArray[0]['fecha_inicio']; 
		  
		  $("#fecha_ultimo_corte").val(fecha_ultimo_corte);
  		  $("#fecha_ultimo_corte1").val(fecha_ultimo_corte);
		  $("#num_identificacion").val(numero_identificacion);
		  $("#cargo").val(cargo);
 		  $("#salario").val(setFormatCurrency(sueldo_base));
		  $("#empleado").val(empleado);
		  $("#fecha_inicio_contrato").val(fecha_inicio);
 
      }catch(e){
        alertJquery(e,'Inconsistencia');
		$("#empleado").val();
		$("#empleado_id").val();
       }
      
    }
    
  });
  
}

function IntCesantiasOnSaveOnUpdate(formulario,resp){
  
	$("#refresh_QUERYGRID_cesantias").click();
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
	
	if (resp>0){
		if($('#guardar'))    	$('#guardar').attr("disabled","true");
		if($('#previsual'))    	$('#previsual').attr("disabled","true");
		if($('#imprimir'))  $('#imprimir').attr("disabled","true");		
		if($('#contabilizar'))  $('#contabilizar').attr("disabled","");
		
		alertJquery("Se guardo la liquidacion No "+resp,"Liquidacion Individual IntCesantias ");
		$('#liquidacion_int_cesantias_id').val(resp);
		var liquidacion_int_cesantias_id = $('#liquidacion_int_cesantias_id').val();
     	var url    = "DetalleIntCesantiasClass.php?liquidacion_int_cesantias_id="+liquidacion_int_cesantias_id+"&rand="+Math.random();

		
		$("#detalleIntCesantias").attr("src",url);
		$("#detalleIntCesantias").load(function(){
			getTotalDebitoCredito(liquidacion_int_cesantias_id);
		});
		
	}else{
		var respu=resp.split("===");
		
		if(parseInt(respu[0])>0){
			alertJquery("Se guardo las liquidaciones  "+respu[1],"Liquidacion Total IntCesantias ");
			if($('#guardar'))    	$('#guardar').attr("disabled","true");
			if($('#previsual'))    	$('#previsual').attr("disabled","true");
			if($('#imprimir'))  $('#imprimir').attr("disabled","true");		
			if($('#contabilizar'))  $('#contabilizar').attr("disabled","");

			$('#liquidacion_int_cesantias_id').val(respu[0]);
			var liquidacion_int_cesantias_id = $('#liquidacion_int_cesantias_id').val();
			setDataFormWithResponse();

		
		}else{
			alertJquery(resp,"IntCesantias Validacion");
			if($('#guardar'))    	$('#guardar').attr("disabled","");
			if($('#previsual'))    	$('#previsual').attr("disabled","");
			if($('#imprimir'))  $('#imprimir').attr("disabled","true");
			if($('#contabilizar'))  $('#contabilizar').attr("disabled","true");
		}

	}
    

}

function OnclickContabilizar(){
	
	var liquidacion_int_cesantias_id 	 = $("#liquidacion_int_cesantias_id").val();
	var fecha_liquidacion 			 = $("#fecha_liquidacion").val();
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_int_cesantias_id="+liquidacion_int_cesantias_id;	

	if(parseInt(liquidacion_int_cesantias_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "IntCesantiasClass.php",
			  data    : QueryString,
			  success : function(response){

				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 $("#totalDebito").html(totalDebito);
					 $("#totalCredito").html(totalCredito);	
											  					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) ){
						var QueryString = "ACTIONCONTROLER=getContabilizar&liquidacion_int_cesantias_id="+liquidacion_int_cesantias_id+"&fecha_liquidacion="+fecha_liquidacion;	

						$.ajax({
							url     : "IntCesantiasClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										 alertJquery('Liquidacion Contabilizada','Contabilizacion Exitosa');
										 $("#refresh_QUERYGRID_cesantias").click();
										 setDataFormWithResponse();
										 formSubmitted = false;	
									 }else{
										   alertJquery(response,'Inconsistencia Contabilizando');
										   formSubmitted = false;	
									 }
									
		
								}catch(e){
								  formSubmitted = false;	
								}
							}
						});
					 }else{
						alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
					 }
				  }catch(e){
					formSubmitted = false;	  
				  }
			  }
			  
			}); 
			
		}
	}else{
		alertJquery('Debe Seleccionar primero una Liquidacion','Contabilizacion'); 
	}
}


function IntCesantiasOnReset(formulario){
	
    clearFind();	
	Reset(formulario);
    if($('#guardar'))    	$('#guardar').attr("disabled","");
	if($('#previsual'))    	$('#previsual').attr("disabled","");
    if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");
	if($('#imprimir'))  	$('#imprimir').attr("disabled","true");
	if($('#anular'))  		$('#anular').attr("disabled","true");
    if($('#limpiar'))    	$('#limpiar').attr("disabled","");	
	$("#estado").val('A');
	$(formulario).find("input,select,textarea").each(function(){
															  
	   this.disabled = false;																
	});
	 $('#estado').attr("disabled","true");
	
	$("#detalleIntCesantias").attr("src","../../../framework/tpl/blank.html");	


}


function closeDialog(){
	$("#divSolicitudFacturas").dialog('close');
}

function calculaValor(){
    
	var fecha_corte = $("#fecha_corte").val();
	var fecha_ultimo_corte = $("#fecha_ultimo_corte").val();
	var si_empleado = $("#si_empleado").val();
	var empleado_id = $("#empleado_id").val();
	
  	
	if(si_empleado=='1' && fecha_corte!=''){
		var QueryString = "ACTIONCONTROLER=calculaValor&empleado_id="+empleado_id+"&fecha_corte="+fecha_corte+"&fecha_ultimo_corte="+fecha_ultimo_corte;
		
		$.ajax({
		url        : "IntCesantiasClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  
		},
		success    : function(response){
		  
		  try{
		
			  var responseArray         = $.parseJSON(response); 
			  var valor_liquidacion     = responseArray[0]['valor_liquidacion'];
			  var dias_periodo          = responseArray[0]['dias_periodo'];  
			  var dias_no_remu          = responseArray[0]['dias_no_remu'];  
			  var dias_liquidados       = responseArray[0]['dias_liquidacion'];  
			  var valor_consolidado     = responseArray[0]['valor_consolidado'];  			  

			  //var valor_provision	 = removeFormatCurrency($("#valor_provision").val());
			  //var diferencia = parseInt((parseInt(valor_consolidado)+parseInt(valor_provision)))-parseInt(valor_liquidacion);
			  var diferencia = parseInt(valor_liquidacion)-parseInt(valor_consolidado);
			 
			  $("#dias_periodo").val(dias_periodo);
			  $("#dias_no_remu").val(dias_no_remu);
			  $("#dias_liquidados").val(dias_liquidados);
			  $("#valor_liquidacion").val(setFormatCurrency(valor_liquidacion));
			  $("#valor_liquidacion1").val(setFormatCurrency(valor_liquidacion));
			  $("#valor_diferencia").val(setFormatCurrency(diferencia)); 
			  $("#valor_consolidado").val(setFormatCurrency(valor_consolidado)); 
		  }catch(e){
		  	//alertJquery(e);
		  }
		  
		}
		
		});
	}else if(si_empleado=='ALL' && fecha_ultimo_corte!='' && fecha_corte!=''){		
		var QueryString = "ACTIONCONTROLER=restaFechasContables&fecha_ultimo_corte="+fecha_ultimo_corte+"&fecha_corte="+fecha_corte;
		
		$.ajax({
		url        : "IntCesantiasClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  
		},
		success    : function(response){
		  
		  try{
			  $("#dias_periodo").val(response);
		  }catch(e){
		  	//alertJquery(e);
		  }
		  
		}
		
		});
	
	}
  
}

function Previsual(formulario){

	if(ValidaRequeridos(formulario)){
	
		var beneficiario       = $("#beneficiario").val();
		var si_empleado        = $("#si_empleado").val();
		var empleado_id        = $("#empleado_id").val();		
		var contrato_id        = $("#contrato_id").val();		
		var fecha_liquidacion  = $("#fecha_liquidacion").val();
		var fecha_corte        = $("#fecha_corte").val();
		var fecha_ultimo_corte = $("#fecha_ultimo_corte").val();	
		var tipo_liquidacion   = $("#tipo_liquidacion").val();
		var observaciones 	   = $("#observaciones").val();	
	
		var QueryString = "ACTIONCONTROLER=onclickSave&previsual=true&empleados="+empleados+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final+"&periodicidad="+periodicidad+"&area_laboral="+area_laboral+"&centro_de_costo_id="+centro_de_costo_id+"&contrato_id="+contrato_id;
	
		$.ajax({
		type: "POST",
		url: "IntCesantiasClass.php?rand=" + Math.random(),
		data: QueryString,
		success: function(resp) {
		  try {
			  if (isInteger(resp)){
	
				  alertJquery("Existe una liquidaci&oacute;n Previa  para las fechas seleccionadas. <br>Por favor verifique Liquidaci&oacute;n No "+resp);
				  
				}else{
					
					document.location.href = "IntCesantiasClass.php?" + QueryString;
	
			  } 
		  } catch (e) {
			alertJquery("Se presento un error :" + e, "Alerta !!");
		  }
		}
	  });
	
	}

}

function beforePrint(formulario,url,title,width,height){
	
   var encabezado_registro_id = parseInt(document.getElementById("encabezado_registro_id").value);
      
   if(isNaN(encabezado_registro_id)){
     alertJquery("Debe Seleccionar una Liquidacion  Contabilizada!!!","Impresion Liquidacion"); 
     return false;
   }else{
	  
      return true;
    }
  
  
}

function onclickCancellation(formulario){


	var liquidacion_int_cesantias_id     = $("#liquidacion_int_cesantias_id").val();

	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.getElementById('RegistrarForm');
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observacion_anulacion       = $("#observacion_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
		   
		   
		 if(!formSubmitted){  
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&liquidacion_int_cesantias_id="+liquidacion_int_cesantias_id+"&causal_anulacion_id="+causal_anulacion_id+"&observacion_anulacion="+observacion_anulacion;
		
	     $.ajax({
           url  : "IntCesantiasClass.php?rand="+Math.random(),
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
			   formSubmitted = true;
	       },
	       success : function(response){
			 
			 removeDivLoading();
             $("#divAnulacion").dialog('close');			 
			 formSubmitted = false;
						  
		     if($.trim(response) == 'true'){
				 setDataFormWithResponse();			 
			    alertJquery('Liquidacion Anulada','Anulado Exitosamente');
			 
			 }else{
			    alertJquery(response,'Inconsistencia Anulando');
			 }
			   
			 
	       }
	   
	     });
		 
	    }
	   
	   }
	
    }else{
		
	 var liquidacion_int_cesantias_id = $("#liquidacion_int_cesantias_id").val();
	 var estado    = document.getElementById("estado").value;
	 var si_empleado = document.getElementById("si_empleado").value;
	 
	 if(parseInt(liquidacion_int_cesantias_id) > 0 && (si_empleado=='1' || si_empleado=='ALL' )){		

	    $("input[name=anular]").each(function(){ this.disabled = false; });
		
		$("#divAnulacion").dialog({
		  title: 'Anulacion Liquidacion',
		  width: 550,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else if(!parseInt(liquidacion_int_cesantias_id) > 0){
		alertJquery('Debe Seleccionar primero una Liquidacion','Validacion Anulacion');
	 
		
	 }else{
		alertJquery('Por favor verifique que este correcto','Validacion Anulacion'); 
	 }
		
	}
}

$(document).ready(function(){


	var liquidacion_int_cesantias_id = $("#liquidacion_int_cesantias_id").val();

	if (liquidacion_int_cesantias_id.length > 0) {
		setDataFormWithResponse();
	}
						   
  	var formulario = document.getElementById('IntCesantiasForm');
  	$("#divSolicitudFacturas").css("display","none");


  	$("#detalleIntCesantias").attr("src","../../../framework/tpl/blank.html");	


	 $("#fecha_corte,#fecha_ultimo_corte").change(function(){
												   
		if(this.id=='fecha_ultimo_corte' && $("#fecha_ultimo_corte").val()!=$("#fecha_ultimo_corte1").val() && $('#si_empleado').val()==1 ){
			alertJquery('Para la Liquidacion Individual No se puede Cambiar la fecha de Ultimo Corte','Validacion IntCesantias');
			 $("#fecha_ultimo_corte").val($("#fecha_ultimo_corte1").val());
		}else{
			calculaValor();								
			
		}
	});


	
	$("#tipo_liquidacion").change(function(){										
		if($("#si_empleado").val()=='ALL' && $("#tipo_liquidacion").val()=='P'){
				alertJquery("No es posible hacer una liquidacion parcial para todos los empleados!!","Validacion Liquidacion IntCesantias");
				$("#tipo_liquidacion").val('T');
		}
		
		if($("#si_empleado").val()=='1' && $("#tipo_liquidacion").val()=='T'){
			salario = removeFormatCurrency($("#salario").val());
			cesantias = salario/2;
			$("#valor").val(setFormatCurrency(cesantias));
		}
		if($("#si_empleado").val()=='1' && $("#tipo_liquidacion").val()=='P'){
			
			$("#valor").val('');
		}
	
  	});
	
	$("#si_empleado").change(function(){										
		if($("#si_empleado").val()=='ALL' && $("#tipo_liquidacion").val()=='P'){
				alertJquery("No es posible hacer una liquidacion parcial para todos los empleados!!","Validacion Liquidacion IntCesantias");
				$("#tipo_liquidacion").val('T');
		}
	
	});
	
  	$("#guardar,#actualizar").click(function(){
		if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,IntCesantiasOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,IntCesantiasOnSaveOnUpdate);
		}	
	
		formSubmitted = false;
  
  	});

});


