// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var liquidacion_nomina_id = $('#liquidacion_nomina_id').val();
    RequiredRemove();

    var novedad  = new Array({campos:"liquidacion_nomina_id",valores:$('#liquidacion_nomina_id').val()});
	var forma       = document.forms[0];
	var controlador = 'LiquidacionNominaClass.php';

	FindRow(novedad,forma,controlador,null,function(resp){

	  var data    = $.parseJSON(resp); 				
	  var estado  = data[0]['estado'];
	  document.getElementById('detalles').src = 'DetallesLiqNomClass.php?liquidacion_nomina_id='+liquidacion_nomina_id+"&rand="+Math.random();
													
      if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if(estado=='E'){  
	  	if($('#actualizar')) $('#actualizar').attr("disabled","");  
	  }else{
		if($('#actualizar')) $('#actualizar').attr("disabled","true");    
	  }
      if(estado!='A'){  
	  	if($('#anular'))     $('#anular').attr("disabled",""); 
	  }else{
		if($('#anular'))     $('#anular').attr("disabled","true");   
	  }
	  if(estado=='E'){
	  	if($('#contabilizar')) $('#contabilizar').attr("disabled","");
	  }else{
		if($('#contabilizar')) $('#contabilizar').attr("disabled","true");  
	  }
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function LiquidacionNominaOnSave(formulario,resp){
   
   if(isInteger(resp)){
	   document.getElementById('detalles').src = 'DetallesLiqNomClass.php?liquidacion_nomina_id='+resp+"&rand="+Math.random();
	
	   $("#refresh_QUERYGRID_liquidacion_nomina").click();
	   if($('#guardar'))    $('#guardar').attr("disabled","true");
	   if($('#actualizar')) $('#actualizar').attr("disabled","");
	   if($('#anular'))     $('#anular').attr("disabled","");
	   if($('#contabilizar'))$('#contabilizar').attr("disabled","");
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	   alertJquery("Guardado Exitosamente","Liquidacion Nomina"); 
   }else{
	   alertJquery(resp,"Liquidacion Nomina");   
   }
   
}

function LiquidacionNominaOnUpdate(formulario,resp){
   clearFind();
   $("#refresh_QUERYGRID_liquidacion_nomina").click();
   document.getElementById('detalles').src = 'DetallesLiqNomClass.php?liquidacion_nomina_id='+resp+"&rand="+Math.random();
   if($('#guardar'))    $('#guardar').attr("disabled","true");
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#anular'))     $('#anular').attr("disabled","");
   if($('#contabilizar'))$('#contabilizar').attr("disabled","");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Liquidacion Nomina");
}

function LiquidacionNominaOnDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_liquidacion_nomina").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#anular'))     $('#anular').attr("disabled","true");
   if($('#contabilizar'))$('#contabilizar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Liquidacion Nomina");
}

function LiquidacionNominaOnReset(formulario){
	Reset(formulario);
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#anular'))     $('#anular').attr("disabled","true");
	if($('#contabilizar'))$('#contabilizar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	$("#estado").val('E');
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){

	   var causal_anulacion_id 			= $("#causal_anulacion_id").val();
	   var desc_anul_liquidacion  			= $("#desc_anul_liquidacion").val();
	   var anul_liquidacion   				= $("#anul_liquidacion").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&liquidacion_nomina_id="+$("#liquidacion_nomina_id").val();
		
	     $.ajax({
           url  : "LiquidacionNominaClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 
				 $("#refresh_QUERYGRID_liquidacion_nomina").click();
 				 setDataFormWithResponse();
 				 alertJquery('Liquidacion Anulada','Anulado Exitosamente');
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	   
	     });
	   
	   }
	
    }else{
		
	 var liquidacion_nomina_id 		= $("#liquidacion_nomina_id").val();
	 var estado   = $("#estado").val();
	 
	 if(parseInt(liquidacion_nomina_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&liquidacion_nomina_id="+liquidacion_nomina_id;
	 
	 $.ajax({
       url        : "LiquidacionNominaClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'E' || $.trim(estado) == 'C'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Liquidacion',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite anular Liquidacions en estado : <b>EDICION/CONTABILIZADO</b>','Anulacion');			   
		   }  
			 
	     removeDivLoading();			 
	     }
		 
	 });
	 
		
	 }else{
		alertJquery('Debe Seleccionar primero una Liquidacion','Anulacion');
	  }		
		
	}  
}

function OnclickContabilizar(){
	var liquidacion_nomina_id= $("#liquidacion_nomina_id").val();
	var fecha_inicial		 = $("#fecha_inicial").val();	
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_nomina_id="+liquidacion_nomina_id;	
	if($('#contabilizar'))	$('#contabilizar').attr("disabled","true");
	
	if(parseInt(liquidacion_nomina_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "LiquidacionNominaClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 $("#totalDebito").html(totalDebito);
					 $("#totalCredito").html(totalCredito);	
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito)  && parseFloat(totalCredito)>0){
						var QueryString = "ACTIONCONTROLER=getContabilizar&liquidacion_nomina_id="+liquidacion_nomina_id+"&fecha_inicial="+fecha_inicial;	
	
						$.ajax({
							url     : "LiquidacionNominaClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										 alertJquery('Liquidacion Contabilizada','Contabilizacion Exitosa');
										 $("#refresh_QUERYGRID_liquidacion_nomina").click();
										 setDataFormWithResponse();
										 formSubmitted = false;	
									 }else{
										   alertJquery(response,'Inconsistencia Contabilizando');
 				   						   if($('#contabilizar'))	$('#contabilizar').attr("disabled","");
									 }
									
		
								}catch(e){
								  
								}
							}
						});
					 }else{
						alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
						if($('#contabilizar'))	$('#contabilizar').attr("disabled","");
					 }
				  }catch(e){
					  
				  }
			  }
			  
			}); 
			
		}
	}else{
		alertJquery('Debe Seleccionar primero una Liquidacion','Contabilizacion'); 
	}
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('LiquidacionNominaForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,LiquidacionNominaOnSave);
			}
		}else{
			Send(formulario,'onclickUpdate',null,LiquidacionNominaOnUpdate);
		}	
	
	formSubmitted = false;
  
  });
  

});