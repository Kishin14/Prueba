$(document).ready(function(){

	$('#aportes_pension,#aportes_salud,#aportes_fondop,#st_icr,#pago_vivienda,#deduccion_dependiente,#salud_prepagada,#st_d,#st_re,#aportes_vol_empl,#aportes_afc,#otras_rentas,#sub1,#sub2,#sub3,#sub4,#rte,#cifra_control,#total_deduccion,#validau,#ingreso_mensual,#ingreso_gravado').val(0);

	$('#sub1,#sub2,#sub3,#sub4,#rte,#cifra_control,#total_deduccion,#validau,#ingreso_mensual,#ingreso_gravado').attr("disable","true");

	$('#aportes_pension,#aportes_salud,#aportes_fondop').change(function(){

		var aportes_pension = parseFloat($('#aportes_pension').val());
		var aportes_salud = parseFloat($('#aportes_salud').val());
		var aportes_fondop = parseFloat($('#aportes_fondop').val());
		var total_suma = parseFloat($('#total_suma').val());
		var uvt = parseFloat($('#uvt').val());

		var uvt_max = parseFloat((420)*(uvt));
		var total = parseFloat((aportes_pension)+(aportes_salud)+(aportes_fondop));
		var sub1 = parseFloat((total_suma)-(total));

		$('#st_icr').val(total);
		$('#sub1').val(sub1);
		$('#validau').val(uvt_max);
		
		var cifra_control =  Math.round(parseFloat((sub1)*(0.40)));
		$('#cifra_control').val(cifra_control);
		
	 });
	
	 $('#pago_vivienda,#deduccion_dependiente,#salud_prepagada').change(function(){

		var pago_vivienda = parseFloat($('#pago_vivienda').val());
		var deduccion_dependiente = parseFloat($('#deduccion_dependiente').val());
		var salud_prepagada = parseFloat($('#salud_prepagada').val());
		var sub1 = parseFloat($('#sub1').val());
		
		var total = parseFloat((pago_vivienda)+(deduccion_dependiente)+(salud_prepagada));
		var sub2 = parseFloat((sub1)-(total));

		$('#st_d').val(total);
		$('#sub2').val(sub2);
		
	 });
	 
	 $('#aportes_vol_empl,#aportes_afc,#otras_rentas').change(function(){

		var aportes_vol_empl = parseFloat($('#aportes_vol_empl').val());
		var aportes_afc = parseFloat($('#aportes_afc').val());
		var otras_rentas = parseFloat($('#otras_rentas').val());
		var sub2 = parseFloat($('#sub2').val());
		
		var total = parseFloat((aportes_vol_empl)+(aportes_afc)+(otras_rentas));
		var sub3 = parseFloat((sub2)-(total));

		$('#st_re').val(total);
		$('#sub3').val(sub3);

		var rte = parseFloat((sub3)*(0.25));
		var sub4 = parseFloat((sub3)-(rte));

		$('#rte').val(rte);
		$('#sub4').val(sub4);

		var st_d = parseFloat($('#st_d').val());
		var st_re = parseFloat($('#st_re').val());
		var total_deduccion = Math.round(parseFloat((st_d)+(st_re)+(rte)));

		$('#total_deduccion').val(total_deduccion);


		var cifra_control = parseFloat($('#cifra_control').val());
		var total_deduccion = parseFloat($('#total_deduccion').val());
		var sub1 = parseFloat($('#sub1').val());
		var sub4 = parseFloat($('#sub4').val());

		ingreso_mensual = (total_deduccion>cifra_control)?Math.round(parseFloat((sub1)-(cifra_control))):sub4;

		$('#ingreso_mensual').val(ingreso_mensual);
		
		var uvt = $('#uvt').val();
		var ingreso_gravado = Math.round(parseFloat((ingreso_mensual)/(uvt)));
		$('#ingreso_gravado').val(ingreso_gravado);

		
	 });


	
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


function renovar(contrato_id,total_suma,uvt){
	$('#aportes_pension,#aportes_salud,#aportes_fondop,#st_icr,#pago_vivienda,#deduccion_dependiente,#salud_prepagada,#st_d,#st_re,#aportes_vol_empl,#aportes_afc,#otras_rentas,#sub1,#sub2,#sub3,#sub4,#rte,#cifra_control,#total_deduccion,#validau,#ingreso_mensual,#ingreso_gravado').val(0);
	parent.renovarcontrato(contrato_id,total_suma,uvt);

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

function renovarcontrato(contrato_id,total_suma,uvt){
	
   if(parseInt(contrato_id)>0){
	   
	   var fecha_inicio2 = parent.$("#fecha_inicio").val();
	   var fecha_final2 = parent.$("#fecha_final").val();
	   $("#contrato_id").val(contrato_id);
	   $("#total_suma").val(total_suma);
	   $("#uvt").val(uvt);
	   
		$("#Renovarmarco").dialog({
		  title: 'Liquidar Retenciones',
		  width: 1000,
		  height: 700,
		  closeOnEscape:true
		 });
	   
   }else{
	 alertJquery("Por favor seleccione un contrato!","Validaci&oacute;n");
	   
   }
   setDataContrato(contrato_id,fecha_inicio2,fecha_final2);
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

function setDataContrato(contrato_id,fecha_inicio,fecha_final){

	

		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataContrato&contrato_id="+contrato_id+"&fecha_final="+fecha_final+"&fecha_inicio="+fecha_inicio;
	
   $.ajax({
	 url        : "LiqRetencionClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
		 showDivLoading();
	 },
	 success    : function(resp){
	 		 
		 try{
			var dataResp = $.parseJSON(resp);
			$("#contrato_liq_id").val(contrato_id);				 
			$("#consecutivo_renueva").val(dataResp[0]['numero_contrato']);		 			 
			$("#numero_meses").val(dataResp[0]['empleado_id']);	 				 				 			 				 				 	
			if (dataResp[0]['contabilizar']=='SI') {
				$("#total_suma").val(dataResp[0]['devengado']);
				$("#uvt").val(dataResp[0]['uvt']);

				$("#aportes_pension").val(dataResp[0]['aportes_pension']);
				$("#aportes_salud").val(dataResp[0]['aportes_salud']);
				$("#aportes_fondop").val(dataResp[0]['aportes_fondop']);
				$("#st_icr").val(dataResp[0]['st_icr']);
				$("#sub1").val(dataResp[0]['sub1']);

				$("#pago_vivienda").val(dataResp[0]['pago_vivienda']);
				$("#deduccion_dependiente").val(dataResp[0]['deduccion_dependiente']);
				$("#salud_prepagada").val(dataResp[0]['salud_prepagada']);
				$("#st_d").val(dataResp[0]['st_d']);
				$("#sub2").val(dataResp[0]['sub2']);
				
				$("#aportes_vol_empl").val(dataResp[0]['aportes_vol_empl']);
				$("#aportes_afc").val(dataResp[0]['aportes_afc']);
				$("#otras_rentas").val(dataResp[0]['otras_rentas']);
				$("#st_re").val(dataResp[0]['st_re']);
				$("#sub3").val(dataResp[0]['sub3']);
				
				$("#rte").val(dataResp[0]['rte']);
				$("#sub4").val(dataResp[0]['sub4']);

				$("#cifra_control").val(dataResp[0]['cifra_control']);
				$("#total_deduccion").val(dataResp[0]['total_deduccion']);
				$("#validau").val(dataResp[0]['validau']);

				$("#ingreso_gravado").val(dataResp[0]['ingreso_gravado']);
				$("#ingreso_mensual").val(dataResp[0]['ingreso_mensual']);
				$("#renovar").css("disabled","true");
				alertJquery("Ya existe una Liquidación para este empleado.");
			}else{
				$("#renovar").css("disabled","");	

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

function onclickLiquidar(formulario){

	if(ValidaRequeridos(formulario)){

			var contrato_id				=	$("#contrato_liq_id").val();
			var fecha_inicio			=	$("#fecha_inicio").val();
			var fecha_final				=	$("#fecha_final").val();
			
			var total_suma 				= parseFloat($('#total_suma').val());
			var uvt 					= parseFloat($('#uvt').val());

			var aportes_pension 		= parseFloat($('#aportes_pension').val());
			var aportes_salud 			= parseFloat($('#aportes_salud').val());
			var aportes_fondop 			= parseFloat($('#aportes_fondop').val());
			var st_icr 					= parseFloat($('#st_icr').val());
			var sub1 					= parseFloat($('#sub1').val());
			
			var pago_vivienda 			= parseFloat($('#pago_vivienda').val());
			var deduccion_dependiente 	= parseFloat($('#deduccion_dependiente').val());
			var salud_prepagada 		= parseFloat($('#salud_prepagada').val());
			var st_d 					= parseFloat($('#st_d').val());
			var sub2 					= parseFloat($('#sub2').val());
			
			var aportes_vol_empl 		= parseFloat($('#aportes_vol_empl').val());
			var aportes_afc 			= parseFloat($('#aportes_afc').val());
			var otras_rentas 			= parseFloat($('#otras_rentas').val());
			var st_re 					= parseFloat($('#st_re').val());
			var sub3 					= parseFloat($('#sub3').val());
			
			var rte 					= parseFloat($('#rte').val());
			var sub4 					= parseFloat($('#sub4').val());	

			var cifra_control 			= parseFloat($('#cifra_control').val());
			var total_deduccion 		= parseFloat($('#total_deduccion').val());
			var validau 				= parseFloat($('#validau').val());

			var ingreso_gravado 		= parseFloat($('#ingreso_gravado').val());	
			var ingreso_mensual 		= parseFloat($('#ingreso_mensual').val());	
			
			if(parseInt(contrato_id)>0){
				var QueryString = "ACTIONCONTROLER=onclickLiquidar&contrato_id="+contrato_id+"&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&total_suma="+total_suma+"&uvt="+uvt+"&aportes_pension="+aportes_pension+"&aportes_salud="+aportes_salud+"&aportes_fondop="+aportes_fondop+"&st_icr="+st_icr+"&sub1="+sub1+"&pago_vivienda="+pago_vivienda+"&deduccion_dependiente="+deduccion_dependiente+"&salud_prepagada="+salud_prepagada+"&st_d="+st_d+"&sub2="+sub2+"&aportes_vol_empl="+aportes_vol_empl+"&aportes_afc="+aportes_afc+"&otras_rentas="+otras_rentas+"&st_re="+st_re+"&sub3="+sub3+"&rte="+rte+"&sub4="+sub4+"&cifra_control="+cifra_control+"&total_deduccion="+total_deduccion+"&validau="+validau+"&ingreso_gravado="+ingreso_gravado+"&ingreso_mensual="+ingreso_mensual;
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

function onclickContabilizar(formulario){

	if(ValidaRequeridos(formulario)){
		
			var contrato_id			=	$("#contrato_id").val();
			var fecha_inicio			=	$("#fecha_inicio_actualiza").val();
			var fecha_final				=	$("#fecha_final_actualiza").val();
			var administracion			=	$("#administracion_actualiza").val();
			var canon					=	$("#canon_actualiza").val();
			var canon_antiguo_actualiza	=	$("#canon_antiguo_actualiza").val();
			var observacion_actualiza	=	$("#observacion_actualiza").val();
			
			if(parseInt(contrato_id)>0){
				var QueryString = "ACTIONCONTROLER=onclickContabilizar&contrato_id="+contrato_id+"&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&administracion="+administracion+"&canon="+canon+"&canon_antiguo_actualiza="+canon_antiguo_actualiza+"&observacion_actualiza="+observacion_actualiza;
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