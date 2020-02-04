// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
	
    RequiredRemove();
	var abono_nomina_id = $('#abono_nomina_id').val();
    var parametros  = new Array({campos:"abono_nomina_id",valores:$('#abono_nomina_id').val()});
	var forma       = document.forms[0];
	var controlador = 'PagoClass.php';

	var url = "DetallesClass.php?abono_nomina_id="+abono_nomina_id+"&rand="+Math.random();
	$("#detalles").attr("src",url);						  	
	getTotalDebitoCredito(abono_nomina_id);
	FindRow(parametros,forma,controlador,null,function(resp){
	  if($('#empleados').val()=='T')	{
			if($('#empleado'))    $('#empleado').attr("disabled","true");			
			if($('#empleado'))    $('#empleado').val("");			
			if($('#empleado_id')) $('#empleado_id').val("");
			if($('#empleado_id')) $('#empleado_id').removeClass("obligatorio");			
			if($('#empleado_nit'))$('#empleado_nit').attr("disabled","true");			
			if($('#empleado_nit'))    $('#empleado_nit').val("");			
		  
	  }else if($('#empleados').val()=='U'){
			if($('#empleado'))     $('#empleado').attr("disabled","");
			if($('#empleado_id'))  $('#empleado_id').addClass("obligatorio");
			if($('#empleado_nit')) $('#empleado_nit').attr("disabled","");
	  }
      if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#estado_abono_nomina').val()=='A'){
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");		  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
		  if($('#reversar')) 		$('#reversar').attr("disabled","true");  
	   	  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:inherit");
	  }else if($('#estado_abono_nomina').val()=='C'){
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");		  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
	   	  if($('#reversar')) 		$('#reversar').attr("disabled",""); 
	   	  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:inherit");
		  
	  }else{
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			  
		  if($('#anular')) 			$('#anular').attr("disabled","true");  
		  if($('#reversar')) 		$('#reversar').attr("disabled","true");
		  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:none");		  
	  }
	  if($('#imprimir'))    	$('#imprimir').attr("disabled","");	
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });
}


function cargardiv(){
	var empleado_id  = $('#empleado_id').val();
	var empleados  = $('#empleados').val();
	
	if(parseInt(empleado_id)>0 && empleados=='U'){
		
		$("#iframeSolicitud").attr("src","SolicFacturasClass.php?empleado_id="+empleado_id+"&empleados="+empleados+"&rand="+Math.random());
		$("#divSolicitudFacturas").dialog({
			title: 'Nomina Pendiente de Pago',
			width: 880,
			height: 395,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
	
	}else if(empleados=='T'){

		$("#iframeSolicitud").attr("src","SolicFacturasClass.php?empleados="+empleados+"&rand="+Math.random());
		$("#divSolicitudFacturas").dialog({
			title: 'Nomina Pendiente de Pago',
			width: 880,
			height: 395,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
		
	}else{
		alertJquery("Por Favor Seleccione un Empleado","Pago Nomina");			   
	}
}

function closeDialog(){
	$("#divSolicitudFacturas").dialog('close');
}

function cargardatos(){
	var detalle_concepto='';
	var causaciones_abono_nomina  	= $('#causaciones_abono_nomina').val();
	var liquidacion_novedad_id		= causaciones_abono_nomina.split(",");

	/*
	for( var i in liquidacion_novedad_id){
		if(liquidacion_novedad_id[i]!=''){
		
			var QueryString = "ACTIONCONTROLER=setSolicitud&factura_proveedor_id="+factura_proveedor_id[i]+"&rand="+Math.random();
			$.ajax({
				url     : "PagoClass.php",
				data    : QueryString,
				success : function(resp){
					
					var resp 			= $.parseJSON(resp);
					var consecutivo_id  = resp[0]['consecutivo_id'];
					var tipo			= resp[0]['tipo'];	
					var orden_no		= resp[0]['orden_no'];	
					var codfactura_prov	= resp[0]['codfactura_proveedor'];	
					var manifiesto		= resp[0]['manifiesto'];	
					if(parseInt(orden_no)>0){ 
						var factura= " "+orden_no+", Factura: "+codfactura_prov; 
						detalle_concepto += tipo+": "+factura+" / ";
					}else if(manifiesto!='' && manifiesto!= null){ 
						var factura=manifiesto;
						detalle_concepto += tipo+": "+factura+" / ";
					}else{ 
						var factura='';
						detalle_concepto += tipo+" / ";
					}
					
					$("#concepto_abono_nomina").val(detalle_concepto);
				}
			});
		}
	}*/
	$("#concepto_abono_nomina").val('ABONO NOMINA');
}

function PagoOnSave(formulario,resp){
	
   if(isInteger(resp)){

		var abono_nomina_id = resp;
		var url = "DetallesClass.php?abono_nomina_id="+abono_nomina_id+"&rand="+Math.random();
		$("#abono_nomina_id").val(abono_nomina_id);						
		$("#detalles").attr("src",url);						  	
 	    $("#refresh_QUERYGRID_pago").click();
	   
		if($('#guardar'))    	$('#guardar').attr("disabled","true");
		if($('#actualizar')) 	$('#actualizar').attr("disabled","");
		if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");				
		if($('#anular')) 		$('#anular').attr("disabled","");	
		if($('#imprimir'))    	$('#imprimir').attr("disabled","");	
		if($('#limpiar'))    	$('#limpiar').attr("disabled","");	
		getTotalDebitoCredito(abono_nomina_id);
		alertJquery("Guardado Exitosamente","Pago Nomina");
   }else{
	       alertJquery(resp,"Pago");
		   if($('#guardar'))    	$('#guardar').attr("disabled",""); //habbilita si es errado
	}
	
   
}

function PagoOnUpdate(formulario,resp){
   if(resp){
		var abono_nomina_id = $("#abono_nomina_id").val();
		var url = "DetallesClass.php?abono_nomina_id="+abono_nomina_id+"&rand="+Math.random();
		$("#detalles").attr("src",url);						  	
   }
   $("#refresh_QUERYGRID_pago").click();
   
    if($('#guardar'))    	$('#guardar').attr("disabled","true");
	if($("#estado_abono_nomina").val()=='A'){
		if($('#actualizar')) 		$('#actualizar').attr("disabled","");
		if($('#contabilizar')) 		$('#contabilizar').attr("disabled","");						
		if($('#anular')) 			$('#anular').attr("disabled","");	
		if($('#reversar')) 			$('#reversar').attr("disabled","true");  
   	    if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:inherit");	
  	}else if($('#estado_abono_nomina').val()=='C'){
	  	if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
	  	if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");		  
	  	if($('#anular')) 			$('#anular').attr("disabled","");  
	  	if($('#reversar')) 			$('#reversar').attr("disabled","");  
	  	if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:inherit");
	}else{
		if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");						
		if($('#anular')) 			$('#anular').attr("disabled","true");
		if($('#reversar')) 			$('#reversar').attr("disabled","true"); 
  		if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:none");			
		
	}
	if($('#imprimir'))    	$('#imprimir').attr("disabled","");	
    if($('#limpiar'))    	$('#limpiar').attr("disabled","");	
	getTotalDebitoCredito(abono_nomina_id);
	
   alertJquery(resp,"Pago");
   
}

function PagoOnReset(formulario){
	$("#detalles").attr("src","../../../framework/tpl/blank.html");
    if($('#guardar'))    		$('#guardar').attr("disabled","");
    if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
	if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");						
    if($('#anular')) 			$('#anular').attr("disabled","true");	
    if($('#reversar')) 			$('#reversar').attr("disabled","true");	
    if($('#limpiar'))    		$('#limpiar').attr("disabled","");	
	if($('#imprimir'))    	    $('#imprimir').attr("disabled","true");	
	if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:inherit");
    $("#totalDebito").html("0.00");
    $("#totalCredito").html("0.00");	  
    clearFind();

	document.getElementById('usuario_id').value=document.getElementById('anul_usuario_id').value;
	document.getElementById('ingreso_abono_nomina').value=document.getElementById('anul_abono_nomina').value;
	document.getElementById('oficina_id').value=document.getElementById('oficina_anul').value;
	document.getElementById('estado_abono_nomina').value='A';

}


$(document).ready(function(){

	$("#empleados").change(function(){

		if(this.value=='U'){									
			if($('#empleado'))     $('#empleado').attr("disabled","");
			if($('#empleado_id'))  $('#empleado_id').addClass("obligatorio");
			if($('#empleado_nit')) $('#empleado_nit').attr("disabled","");
		}else{
			if($('#empleado'))    $('#empleado').attr("disabled","true");			
			if($('#empleado'))    $('#empleado').val("");			
			if($('#empleado_id')) $('#empleado_id').val("");
			if($('#empleado_id')) $('#empleado_id').removeClass("obligatorio");			
			if($('#empleado_nit'))$('#empleado_nit').attr("disabled","true");			
			if($('#empleado_nit'))    $('#empleado_nit').val("");			
			
		}
	});

  $("#saveDetallepuc").click(function(){										
    window.frames[0].saveDetalles();

  });  
  $("#Buscar").click(function(){										
    cargardiv();

  });  


  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('PagoForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
		 if($('#guardar')) $('#guardar').attr("disabled","true");	//inhabbilita mientras		
         Send(formulario,'onclickSave',null,PagoOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,PagoOnUpdate)
		  }
	  }
	  	  
  });

});

function setDataEmpleado(empleado_id){

	var QueryString = "ACTIONCONTROLER=setDataEmpleado&empleado_id="+empleado_id;
	$.ajax({
    	url        : "PagoClass.php?rand="+Math.random(),
    	data       : QueryString,
    	beforeSend : function(){
    	},
    	success    : function(response){
      
			try{
		
				var responseArray         = $.parseJSON(response); 
				var empleado_nit         = responseArray[0]['empleado_nit'];
				$("#empleado_nit").val(empleado_nit);
			}catch(e){
				alertJquery(e);
			}
    	}
  	});
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){

	   var causal_anulacion_id 		= $("#causal_anulacion_id").val();
	   var desc_anul_abono_nomina  = $("#desc_anul_abono_nomina").val();
	   var anul_abono_nomina   	= $("#anul_abono_nomina").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&abono_nomina_id="+$("#abono_nomina_id").val();
		
	     $.ajax({
           url  : "PagoClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Pago Anulado','Anulado Exitosamente');
				 $("#refresh_QUERYGRID_pago").click();
				 setDataFormWithResponse();
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	   
	     });
	   
	   }
	
    }else{
		
	 var abono_nomina_id = $("#abono_nomina_id").val();
	 var estado_abono_nomina   	= $("#estado_abono_nomina").val();
	 
	 if(parseInt(abono_nomina_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&abono_nomina_id="+abono_nomina_id;
	 
	 $.ajax({
       url        : "PagoClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'A' || $.trim(estado) == 'C'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Pago',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite anular Pagos en estado : <b>ACTIVO/CONTABILIZADO</b>','Anulacion');			   
		   }  
			 
	     removeDivLoading();			 
	     }
		 
	 });
	 
		
	 }else{
		alertJquery('Debe Seleccionar primero un Registro','Anulacion Nomina');
	  }		
		
	}  
}



function getTotalDebitoCredito(abono_nomina_id){ 
		
	var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&abono_nomina_id="+abono_nomina_id;
	
	$.ajax({
      url     : "PagoClass.php",
	  data    : QueryString,
	  success : function(response){
		  		  
		  try{
			 var totalDebitoCredito = $.parseJSON(response); 
             var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
			 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
			 var valor_total		= parseFloat(totalDebito) > parseFloat(totalCredito) ? totalDebito : totalCredito;			 
			 
			 $("#totalDebito").html(setFormatCurrency(totalDebito));
			 $("#totalCredito").html(setFormatCurrency(totalCredito));	
			 
			 
		  }catch(e){
			  
			}
      }
	  
    });    


}

function OnclickContabilizar(){
	var abono_nomina_id	= $("#abono_nomina_id").val();	
	var ingreso_abono_nomina 		= $("#ingreso_abono_nomina").val();		
	var valor 				 		= $("#valor_abono_nomina").val();		
	var QueryString 		 		= "ACTIONCONTROLER=getTotalDebitoCredito&abono_nomina_id="+abono_nomina_id;	

	if(parseInt(abono_nomina_id)>0){
		if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");	//inhabilitar contabilizar
		if(!formSubmitted){	
			formSubmitted = true;			
		
			$.ajax({
			  url     : "PagoClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 $("#totalDebito").html(totalDebito);
					 $("#totalCredito").html(totalCredito);	
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) /*&& parseFloat(totalCredito)==parseFloat(removeFormatCurrency(valor))*/ && parseFloat(removeFormatCurrency(valor))>0){
						var QueryString = "ACTIONCONTROLER=getContabilizar&abono_nomina_id="+abono_nomina_id+"&ingreso_abono_nomina="+ingreso_abono_nomina;	
	
						$.ajax({
							url     : "PagoClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										 alertJquery('Registro Contabilizado','Contabilizacion Exitosa');
										 $("#refresh_QUERYGRID_pago").click();
										 setDataFormWithResponse();
										 formSubmitted = false;	
									 }else{
										   alertJquery(response,'Inconsistencia Contabilizando');
										   if($('#contabilizar')) 		$('#contabilizar').attr("disabled","");	//habilitar contabilizar
									 }
									
		
								}catch(e){
								  
								}
							}
						});
					 }else if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)!=parseFloat(removeFormatCurrency(valor))){
						alertJquery('El valor del registro no coincide con las sumas :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
					 }else{
						alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
					 }
				  }catch(e){
					  
				  }
			  }
			  
			});    
		}
	}else{
		alertJquery('Debe Seleccionar primero un Registro','Contabilizacion'); 
	}
}


function beforePrint(formulario,url,title,width,height){

	var encabezado_registro_id = parseInt($("#encabezado_registro_id").val());
	
	if(isNaN(encabezado_registro_id)){
	  
	  alertJquery('Debe seleccionar una Pago o Abono Contabilizado!!!','Impresion Pago o Abono');
	  return false;
	  
	}else{	  
	    return true;
	}
}
