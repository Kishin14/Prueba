// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var liquidacion_definitiva_id = $('#liquidacion_definitiva_id').val();
    RequiredRemove();

    var novedad  = new Array({campos:"liquidacion_definitiva_id",valores:$('#liquidacion_definitiva_id').val()});
	var forma       = document.forms[0];
	var controlador = 'LiquidacionFinalClass.php';

	FindRow(novedad,forma,controlador,null,function(resp){
	  var estado = $('#estado').val();			
	  var blur = true;									
	  document.getElementById('prestacion').src = 'LiquidacionFinalClass.php?ACTIONCONTROLER=onclickSave&liquidacion_definitiva_id='+liquidacion_definitiva_id+'&blur='+blur;
													
      if($('#guardar'))    $('#guardar').attr("disabled","true");
     

	  if(estado=='A'){
	      $('#anular').attr("disabled","true");
		  $('#contabilizar').attr("disabled","true");
		   if($('#actualizar')) $('#actualizar').attr("disabled","true");		  		  
	  }else if(estado=='C'){
		  $('#anular').attr("disabled","");
		  $('#contabilizar').attr("disabled","true");			   
		   if($('#actualizar')) $('#actualizar').attr("disabled","true");		  
	  }else if(estado=='E'){
		  $('#anular').attr("disabled","");
		  $('#contabilizar').attr("disabled","");	
		   if($('#actualizar')) $('#actualizar').attr("disabled","");
		  
	  }
	  if($('#imprimir')) $('#imprimir').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function setDataContrato(contrato_id){
    
  var QueryString = "ACTIONCONTROLER=setDataContrato&contrato_id="+contrato_id;
  
  $.ajax({
    url        : "LiquidacionFinalClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
		  var responseArray         = $.parseJSON(response); 
		  var fecha_inicio          =responseArray[0]['fecha_inicio'];
		  var fecha_terminacion     =responseArray[0]['fecha_terminacion'];  
 		  var sueldo_base     		=responseArray[0]['sueldo_base'];  
		  var subsidio_transporte   =responseArray[0]['subsidio_transporte'];  	
		  var base_liquidacion		= parseFloat(sueldo_base)+parseFloat(subsidio_transporte);
		  var estado   =responseArray[0]['estado'];  	
		  
		  if(estado=='A'){
			  $("#fecha_inicio").val(fecha_inicio);
			  $("#fecha_final").val(fecha_terminacion);
			  $("#base_liquidacion").val(setFormatCurrency(base_liquidacion,2));
			  
			  if(fecha_terminacion!=''){
					var fecha_inicial = $('#fecha_inicio').val();
					var fecha_final = $('#fecha_final').val();
			
					if((Date.parse(fecha_final) < Date.parse(fecha_inicial)) ) {
					 alertJquery('La fecha final no puede ser menor a la Inicial.');
					  $('#fecha_final').val('');
					}else{
						if(fecha_inicial!='' && fecha_final!=''){
							var dias1 = restaFechas(fecha_inicial,fecha_final);
							$('#dias').val(dias1);
						}
					}
				  
			  }
		  }else{
			  alertJquery('El contrato seleccionado No esta Activo, no se puede Liquidar','Validacion');
		  }
      }catch(e){
     	//alertJquery(e);
      }
      
    }
    
  });
  
}

function LiquidacionFinalOnSave(formulario,resp){

   if(isInteger(resp)){
	   $('#liquidacion_definitiva_id').val(liquidacion_definitiva_id);
	   document.getElementById('prestacion').src = 'LiquidacionFinalClass.php?ACTIONCONTROLER=onclickSave&liquidacion_definitiva_id='+resp+"&rand="+Math.random();
	   
	
	   $("#refresh_QUERYGRID_liquidacion_definitiva").click();
	   if($('#guardar'))    $('#guardar').attr("disabled","true");
	   if($('#actualizar')) $('#actualizar').attr("disabled","");
	   if($('#anular'))     $('#anular').attr("disabled","");
	   if($('#contabilizar')) $('#contabilizar').attr("disabled","");	   
	   if($('#imprimir')) $('#imprimir').attr("disabled","");	   	   
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");

   }else{
	   alertJquery(resp,"Liquidacion Nomina");   
   }
   
}

function LiquidacionFinalOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_liquidacion_definitiva").click();
   if($('#guardar'))    $('#guardar').attr("disabled","true");
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#anular'))     $('#anular').attr("disabled","");
   if($('#contabilizar')) $('#contabilizar').attr("disabled","");	   
   if($('#imprimir')) $('#imprimir').attr("disabled","");	   	   
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Liquidacion Nomina");
}


function LiquidacionFinalOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#anular'))     $('#anular').attr("disabled","true");
	if($('#contabilizar')) $('#contabilizar').attr("disabled","true");	   
	if($('#imprimir')) $('#imprimir').attr("disabled","true");	   	   
	
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	$('#estado').val("E");	
}

function restaFechas(f1,f2){
	var aFecha1 = f1.split('-'); 
	var aFecha2 = f2.split('-'); 
	var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]); 
	var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
	var dif = fFecha2 - fFecha1;
	var dias = Math.floor(dif / (1000 * 60 * 60 * 24))
	dias= (dias+1); 
	var meses=parseInt(dias/30);
	var meses_res= ((dias/30)-meses);
	
	var date = new Date();
	var ultimoDia = new Date(aFecha1[0], aFecha1[1], 0);
	var ultimoDiaFin = new Date(aFecha2[0], aFecha2[1], 0);

	if(aFecha1[0]==aFecha2[0] && aFecha1[1]==aFecha2[1] && aFecha1[2]=='01' &&  aFecha2[2]==ultimoDia.getDate() ){
		dias=30;
	}else if(meses==1 && ultimoDiaFin.getDate()==31 && aFecha2[2]==31){
		
		 fFecha1 = Date.UTC(aFecha1[0],aFecha2[1]-1,aFecha1[2]); 
		 fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
		 dif = fFecha2 - fFecha1;
		 dias = Math.floor(dif / (1000 * 60 * 60 * 24))
		 dias= (dias+30); 
		
	}else if(meses==1){
		 if(aFecha1[2]<=aFecha2[2]){		
			 fFecha1 = Date.UTC(aFecha1[0],aFecha2[1]-1,aFecha1[2]); 
			 fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
			 dif = fFecha2 - fFecha1;
			 dias = Math.floor(dif / (1000 * 60 * 60 * 24))
			 dias= (dias+31); 
		 }else{
			fFecha1 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha1[2]); 
			fFecha2 = Date.UTC(aFecha2[0],aFecha2[1],aFecha2[2]); 
			dif = fFecha2 - fFecha1;
			dias = Math.floor(dif / (1000 * 60 * 60 * 24));
			dias= (dias+30); 
			 
		 }
	}else if(meses>1){
		 var cont_mes=0;
		 if(aFecha1[0]==aFecha2[0]){
			 if(aFecha1[2]<=aFecha2[2]){
				var dia_ult = aFecha2[2]!=31 ? aFecha2[2] : 30; 
				fFecha1 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha1[2]); 
				fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,dia_ult); 
				dif = fFecha2 - fFecha1;
		 		var dias_dif = Math.floor(dif / (1000 * 60 * 60 * 24))				 
				
				cont_mes=parseInt(aFecha2[1])-parseInt(aFecha1[1]);
				dias=((cont_mes*30)+dias_dif+1);
			 }else{
				fFecha1 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha1[2]); 
				fFecha2 = Date.UTC(aFecha2[0],aFecha2[1],aFecha2[2]); 
				dif = fFecha2 - fFecha1;
				var dias_dif = Math.floor(dif / (1000 * 60 * 60 * 24))				 
				 
				cont_mes=parseInt(aFecha2[1])-parseInt(aFecha1[1]);
				dias=(((cont_mes-1)*30)+dias_dif);
				 
			 }
		 }else{
			 //FALTA CUANDO ES MAS DE UN ANIO A OTRO
			 if(aFecha1[1]<=aFecha2[1]){
				//ok
				fFecha1 = Date.UTC(aFecha2[0],aFecha2[1],aFecha1[2]); 
				fFecha2 = Date.UTC(aFecha2[0],aFecha2[1],aFecha2[2]); 
				dif = fFecha2 - fFecha1;
		 		var dias_dif = Math.floor(dif / (1000 * 60 * 60 * 24))				 

				var meses_dif_dias=((aFecha2[1]-aFecha1[1])*30); 
				
				var dif_year_dias= ((aFecha2[0]-aFecha1[0])*360);
				dias = parseInt(dias_dif+meses_dif_dias+dif_year_dias);
				 
				   
			 }else{
				//ok
				fFecha1 = Date.UTC(aFecha2[0],aFecha2[1],aFecha1[2]); 
				fFecha2 = Date.UTC(aFecha2[0],aFecha2[1],aFecha2[2]); 
				dif = fFecha2 - fFecha1;
		 		var dias_dif = Math.floor(dif / (1000 * 60 * 60 * 24))				 

				
				var meses_dif_dias=(((12-(aFecha1[1]-aFecha2[1])))*30); 

				var dif_year_dias= (((aFecha2[0]-1)-aFecha1[0])*360);

				dias = parseInt(dias_dif+meses_dif_dias+dif_year_dias+1);

			 }
		 }
		 
	}

	return dias;
}


function beforePrint(formulario,url,title,width,height){
	
   var liquidacion_definitiva_id = parseInt(document.getElementById("liquidacion_definitiva_id").value);
      
   if(isNaN(liquidacion_definitiva_id)){
     alertJquery("Debe Seleccionar una Liquidacion!!!","Impresion Liquidacion"); 
     return false;
   }else{
	  
	  
	  $("#rangoImp").dialog({
		  title: 'Impresion Liquidacion Final',
		  width: 700,
		  height: 220,
			  closeOnEscape:true,
			  show: 'scale',
			  hide: 'scale'
	  });

      return false;
    }
  
  
}

function printOut(){	
	
	var tipo_impresion = document.getElementById("tipo_impresion").value;
	var liquidacion_definitiva_id = document.getElementById("liquidacion_definitiva_id").value;
	var url = "LiquidacionFinalClass.php?ACTIONCONTROLER=onclickPrint&tipo_impresion="+tipo_impresion+"&liquidacion_definitiva_id="+liquidacion_definitiva_id+"&random="+Math.random();
	
	printCancel();
    onclickPrint(null,url,"Impresion Liquidacion Final","950","600");	
	
}


function printCancel(){
	$("#rangoImp").dialog('close');	
	removeDivLoading();
}

function onclickCancellation(formulario){


	var liquidacion_definitiva_id     = $("#liquidacion_definitiva_id").val();

	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.getElementById('LiquidacionFinalForm');
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observacion_anulacion       = $("#observacion_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
		   
		   
		 if(!formSubmitted){  
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&liquidacion_definitiva_id="+liquidacion_definitiva_id+"&causal_anulacion_id="+causal_anulacion_id+"&observacion_anulacion="+observacion_anulacion;
		
	     $.ajax({
           url  : "LiquidacionFinalClass.php?rand="+Math.random(),
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
			   formSubmitted = true;
	       },
	       success : function(response){
			 
             Reset(formularioPrincipal);	
             LiquidacionFinalOnReset();		
			 removeDivLoading();
             $("#divAnulacion").dialog('close');			 
			 
			 formSubmitted = false;
						  
		     if($.trim(response) == 'true'){
				 
			    alertJquery('Liquidacion Final Anulada','Anulado Exitosamente');
			 
			 }else{
			    alertJquery(response,'Inconsistencia Anulando');
			 }
			   
			 
	       }
	   
	     });
		 
	    }
	   
	   }
	
    }else{
		
	 var liquidacion_definitiva_id = $("#liquidacion_definitiva_id").val();
	 var estado    = document.getElementById("estado").value;
	 var contrato    = document.getElementById("contrato").value;
	 
	 if(parseInt(liquidacion_definitiva_id) > 0) {		

	    $("input[name=anular]").each(function(){ this.disabled = false; });
		
		$("#divAnulacion").dialog({
		  title: 'Anulacion Liquidacion',
		  width: 550,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else if(!parseInt(liquidacion_definitiva_id) > 0){
		alertJquery('Debe Seleccionar primero una Liquidacion','Validacion Anulacion');
	 
		
	 }else{
		alertJquery('Por favor verifique que este correcto','Validacion Anulacion'); 
	 }
		
	}
}


function OnclickContabilizar(){
	var liquidacion_definitiva_id  = $("#liquidacion_definitiva_id").val();
	var fecha_final 			= $("#fecha_final").val();	
	$('#contabilizar').attr("disabled","true");
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_definitiva_id="+liquidacion_definitiva_id;	

	if(parseInt(liquidacion_definitiva_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "LiquidacionFinalClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)>0 ){
						var QueryString = "ACTIONCONTROLER=getContabilizar&liquidacion_definitiva_id="+liquidacion_definitiva_id+"&fecha_final="+fecha_final;	
	
						$.ajax({
							url     : "LiquidacionFinalClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										$('#guardar').attr("disabled","true");
										$('#anular').attr("disabled","");
										$('#contabilizar').attr("disabled","true");
										$('#limpiar').attr("disabled","");
										document.getElementById('estado').value = 'C';
										 alertJquery('Registro Contabilizado','Contabilizacion Exitosa');
										 $("#refresh_QUERYGRID_liquidacion_definitiva").click();

									     formSubmitted = false;	
									 }else{
										   alertJquery(response,'Inconsistencia Contabilizando');
										   $('#contabilizar').attr("disabled",""); 
									 }
									
		
								}catch(e){
									$('#contabilizar').attr("disabled","true");  
								}
							}
						});
					 }else if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)==0){
						alertJquery('Los valores no Pueden estar En Ceros :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
						$('#contabilizar').attr("disabled","");
					 }else{
						alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b><br />Debito: $'+setFormatCurrency(totalDebito)+' Credito: $'+setFormatCurrency(totalCredito),'Contabilizacion'); 
						$('#contabilizar').attr("disabled","");
					 }
				  }catch(e){
					  
				  }
			  }
			  
			});  
		}
	}else{
		alertJquery('Debe Seleccionar primero un Registro','Contabilizacion'); 
		$('#contabilizar').attr("disabled","");
	}
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('LiquidacionFinalForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 console.log(formulario);
				 $('#blur').val('false');
				 Send(formulario,'onclickSave',null,LiquidacionFinalOnSave);
			}
		}else{
			Send(formulario,'onclickUpdate',null,LiquidacionFinalOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

   $("#fecha_inicio,#fecha_final,#justificado").blur(function(){

		var fecha_inicio =	$("#fecha_inicio").val();	
		var fecha_final = $("#fecha_final").val();	
		var contrato_id = $("#contrato_id").val();
		var justificado = $("#justificado").val();
		var liquidacion_definitiva_id = $("#liquidacion_definitiva_id").val();	
		
		if(parseInt(contrato_id)>0 && fecha_inicio!='' && fecha_final!='' && justificado!='NULL'){
			blur = true;
			document.getElementById('prestacion').src = 'LiquidacionFinalClass.php?ACTIONCONTROLER=onclickSave&contrato_id='+contrato_id+"&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&justificado="+justificado+"&blur="+blur+"&liquidacion_definitiva_id="+liquidacion_definitiva_id+"&rand="+Math.random();
			blur = false;
		}
  
  });
  

	$('#fecha_final').change(function(){
	
		var fecha_inicial = $('#fecha_inicio').val();
		var fecha_final = $('#fecha_final').val();

		if((Date.parse(fecha_final) < Date.parse(fecha_inicial)) ) {
		 alertJquery('La fecha final no puede ser menor a la Inicial.');
		  $('#fecha_final').val('');
		}else{
			if(fecha_inicial!='' && fecha_final!=''){
				var dias1 = restaFechas(fecha_inicial,fecha_final);
				$('#dias').val(dias1);
			}
		}
	});

	$("#print_out").click(function(){
       printOut();								   
    });
	
    $("#print_cancel").click(function(){
       printCancel();									  
    });	

});