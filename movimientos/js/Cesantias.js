// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
	
    var liquidacion_cesantias_id = $('#liquidacion_cesantias_id').val();
    RequiredRemove();

    var liquidacion  = new Array({campos:"liquidacion_cesantias_id",valores:$('#liquidacion_cesantias_id').val()});
	var forma       = document.forms[0];
	var controlador = 'CesantiasClass.php';

	FindRow(liquidacion,forma,controlador,null,function(resp){
														
		 var data   = $.parseJSON(resp);													   
		 var empleado_id = data[0]['empleado_id'];
		 
		  var estado = data[0]['estado'];
		 		 
		 if(estado == 'I'){
			 
		   $(forma).find("input,select,textarea").each(function(){
               this.disabled = true;																
           });
		   
		 }else{
			 
		     $(forma).find("input,select,textarea").each(function(){
               this.disabled = false;																
             });			 
			 
		  }
     	 var url    = "DetalleCesantiasClass.php?liquidacion_cesantias_id="+liquidacion_cesantias_id+"&rand="+Math.random();
	 
	 $("#detalleCesantias").attr("src",url);
	 $("#detalleCesantias").load(function(){
  	    getTotalDebitoCredito(liquidacion_cesantias_id);
     });
    if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#estado').val()=='A'){
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");		  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
	   	  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:inherit");
	  }else if($('#estado').val()=='C' ){
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
		  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:none");		  
		  
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

function getTotalDebitoCredito(liquidacion_cesantias_id){
		
	var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_cesantias_id="+liquidacion_cesantias_id;
	
	$.ajax({
      url     : "CesantiasClass.php",
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
    url        : "CesantiasClass.php?rand="+Math.random(),
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
		  var fecha_ultimo_corte   	  =responseArray[0]['fecha_ultimo_corte']; 
		  
		  
		  $("#fecha_ultimo_corte").val(fecha_ultimo_corte);
  		  $("#fecha_ultimo_corte1").val(fecha_ultimo_corte);
		  $("#num_identificacion").val(numero_identificacion);
		  $("#cargo").val(cargo);
 		  $("#salario").val(setFormatCurrency(sueldo_base));
		  $("#empleado").val(empleado);
		  $("#fecha_inicio_contrato").val(fecha_inicio);
		  
		  //var valor_provision   	  =responseArray[0]['valor_provision']; 
		  //var valor_consolidado   	  =responseArray[0]['valor_consolidado']; 
		  //$("#valor_provision").val(setFormatCurrency(valor_provision));
		  //$("#valor_consolidado").val(setFormatCurrency(valor_consolidado));

 
      }catch(e){
        alertJquery(e,'Inconsistencia');
		$("#empleado").val();
		$("#empleado_id").val();
       }
      
    }
    
  });
  
}

function CesantiasOnSaveOnUpdate(formulario,resp){
  
	$("#refresh_QUERYGRID_cesantias").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	if (parseInt(resp)>0){
		alertJquery("Se guardo la liquidacion No "+resp,"Cesantiass");
		$('#liquidacion_cesantias_id').val(resp);
		var liquidacion_cesantias_id = $('#liquidacion_cesantias_id').val();

     	 var url    = "DetalleCesantiasClass.php?liquidacion_cesantias_id="+liquidacion_cesantias_id+"&rand="+Math.random();

		
		$("#detalleCesantias").attr("src",url);
		$("#detalleCesantias").load(function(){
			getTotalDebitoCredito(liquidacion_cesantias_id);
		});
	}else{
		alertJquery(resp,"Cesantias Validacion");
	}
    

}

function OnclickContabilizar(){
	
	var liquidacion_cesantias_id 			 = $("#liquidacion_cesantias_id").val();
	var fecha_liquidacion 			 = $("#fecha_liquidacion").val();
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_cesantias_id="+liquidacion_cesantias_id;	

	if(parseInt(liquidacion_cesantias_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "CesantiasClass.php",
			  data    : QueryString,
			  success : function(response){

				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 $("#totalDebito").html(totalDebito);
					 $("#totalCredito").html(totalCredito);	
											  					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) ){
						var QueryString = "ACTIONCONTROLER=getContabilizar&liquidacion_cesantias_id="+liquidacion_cesantias_id+"&fecha_liquidacion="+fecha_liquidacion;	

						$.ajax({
							url     : "CesantiasClass.php",
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


function CesantiasOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	 $("#detalleCesantias").attr("src","../../../framework/tpl/blank.html");	

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
		url        : "CesantiasClass.php?rand="+Math.random(),
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
			  var diferencia = parseInt((parseInt(valor_consolidado)))-parseInt(valor_liquidacion);
			 
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
		url        : "CesantiasClass.php?rand="+Math.random(),
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

$(document).ready(function(){


	var liquidacion_cesantias_id = $("#liquidacion_cesantias_id").val();

	if (liquidacion_cesantias_id.length > 0) {
		setDataFormWithResponse();
	}
						   
  	var formulario = document.getElementById('CesantiasForm');
  	$("#divSolicitudFacturas").css("display","none");


  	$("#detalleCesantias").attr("src","../../../framework/tpl/blank.html");	


	 $("#fecha_corte,#fecha_ultimo_corte").change(function(){
												   
		if(this.id=='fecha_ultimo_corte' && $("#fecha_ultimo_corte").val()!=$("#fecha_ultimo_corte1").val() && $('#si_empleado').val()==1 ){
			alertJquery('Para la Liquidacion Individual No se puede Cambiar la fecha de Ultimo Corte','Validacion Cesantias');
			 $("#fecha_ultimo_corte").val($("#fecha_ultimo_corte1").val());
		}else{
			calculaValor();								
			
		}
	});


	
	$("#tipo_liquidacion").change(function(){										
		if($("#si_empleado").val()=='ALL' && $("#tipo_liquidacion").val()=='P'){
				alertJquery("No es posible hacer una liquidacion parcial para todos los empleados!!","Validacion Liquidacion Cesantias");
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
				alertJquery("No es posible hacer una liquidacion parcial para todos los empleados!!","Validacion Liquidacion Cesantias");
				$("#tipo_liquidacion").val('T');
		}
	
	});
	
  	$("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,CesantiasOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,CesantiasOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});

/*

function cargardiv(){
	var empleado_id  					= $('#empleado_id').val();
	
	if(parseInt(empleado_id)>0){
		$("#iframeSolicitud").attr("src","SolicPeriodosClass.php?empleado_id="+empleado_id+"&rand="+Math.random());
		$("#divSolicitudFacturas").dialog({
			title: 'Remesas y Ordenes de Servicios Pendientes',
			width: 950,
			height: 395,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
	}else{
		alertJquery("Por Favor Seleccione un Empleado","Cesantiass");		
	}
}

	$("#Buscar").click(function(){										
		cargardiv();
	 });

*/


