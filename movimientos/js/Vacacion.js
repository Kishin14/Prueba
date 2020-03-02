// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
	
    var liquidacion_vacaciones_id = $('#liquidacion_vacaciones_id').val();
    RequiredRemove();

    var liquidacion  = new Array({campos:"liquidacion_vacaciones_id",valores:$('#liquidacion_vacaciones_id').val()});
	var forma       = document.forms[0];
	var controlador = 'VacacionClass.php';

	FindRow(liquidacion,forma,controlador,null,function(resp){
														
		 var data   = $.parseJSON(resp);													   
		 var empleado_id = data[0]['empleado_id'];
		 var valor = data[0]['valor'];
		 var valor_total = data[0]['valor_total'];
		 var valor_pagos = data[0]['valor_pagos'];
		 
		 if(valor_pagos>0){
			 $("#valor_pagos").val(setFormatCurrency(valor_pagos));
		 }
		 
		$("#si_empleado").val(1);
		$("#valor").val(setFormatCurrency(valor));
		$("#valor_total").val(setFormatCurrency(valor_total));
		
		

		 setDataEmpleado(empleado_id);
		 
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
     	 var url    = "DetalleVacacionesClass.php?liquidacion_vacaciones_id="+liquidacion_vacaciones_id+"&rand="+Math.random();
	 
	 $("#detalleVacacion").attr("src",url);
	 $("#detalleVacacion").load(function(){
  	    getTotalDebitoCredito(liquidacion_vacaciones_id);
     });
    if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#estado').val()=='A'){
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");		  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
	   	  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:inherit");
	  }else if($('#estado').val()=='C' ){
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
		  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:none");		  
		  
	  } else if ($('#estado').val() == 'I') {

		  if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
		  if ($('#imprimir')) $('#imprimir').attr("disabled", "");
		  if ($('#anular')) $('#anular').attr("disabled", "true"); 
		} 
    });


}

function Empleado_si(){
	if($('#si_empleado').val()==1){
		
		  if($('#empleado'))   
		  $('#empleado').attr("disabled","");	

		  $("#empleado").addClass("obligatorio");
		  $("#num_identificacion").addClass("obligatorio");
		  $("#cargo").addClass("obligatorio");
		  $("#concepto").addClass("obligatorio");
		  $("#fecha_inicio_contrato").addClass("obligatorio");
		  $('#dias_pagados').addClass("obligatorio");
		  $('#valor_pagos').addClass("obligatorio");
		  

		  $('#dias_disfrutar').attr("readonly", "readonly");
		  $('#dias').attr("readonly", "readonly");

		 
		  
	}else if($('#si_empleado').val()=='ALL'){

		alertJquery("La opcion <strong>'TODOS'</strong> solo se aplicará para todos los empleados que tenga un contrato con vigencia mayor o igual a un año, Para liquidar un contrato con vigencia menor a un año puede seleccionar la opcion <strong>'UNO'</strong>", "Atención");
		
		  if($('#empleado'))
		  $('#empleado').attr("disabled","true");

		  $('#empleado').val('');
		  $('#empleado_id').val('');
		  $("#empleado").removeClass("obligatorio");
		  $("#num_identificacion").removeClass("obligatorio");
		  $("#cargo").removeClass("obligatorio");
		  $("#concepto").removeClass("obligatorio");
		  $("#fecha_inicio_contrato").removeClass("obligatorio");
		  $('#dias_pagados').removeClass("obligatorio");
		  $('#valor_pagos').removeClass("obligatorio");

		  $('#dias_disfrutar').attr("readonly", "");
		  $('#dias').attr("readonly", "");


		var QueryString = "ACTIONCONTROLER=CalcularLiqTodos";
		$.ajax({
			url: "VacacionClass.php",
			data: QueryString,
			success: function (resp) {
				var data = $.parseJSON(resp);
				var salario_total = data[0]['sueldos'];
				$("#salario").val(setFormatCurrency(salario_total));
			}
		});
		  
		  
	}

}

function onclickCancellation(formulario) {


	var liquidacion_vacaciones_id = $("#liquidacion_vacaciones_id").val();

	if ($("#divAnulacion").is(":visible")) {

		var formularioPrincipal = document.getElementById('RegistrarForm');
		var causal_anulacion_id = $("#causal_anulacion_id").val();
		var observacion_anulacion = $("#observacion_anulacion").val();

		if (ValidaRequeridos(formulario)) {


			if (!formSubmitted) {

				var QueryString = "ACTIONCONTROLER=onclickCancellation&liquidacion_vacaciones_id=" + liquidacion_vacaciones_id + "&causal_anulacion_id=" + causal_anulacion_id + "&observacion_anulacion=" + observacion_anulacion;

				$.ajax({
					url: "VacacionClass.php?rand=" + Math.random(),
					data: QueryString,
					beforeSend: function () {
						showDivLoading();
						formSubmitted = true;
					},
					success: function (response) {

						removeDivLoading();
						$("#divAnulacion").dialog('close');
						formSubmitted = false;

						if ($.trim(response) == 'true') {
							setDataFormWithResponse();
							alertJquery('Liquidacion Anulada', 'Anulado Exitosamente');

						} else {
							alertJquery(response, 'Inconsistencia Anulando');
						}


					}

				});

			}

		}

	} else {

		var liquidacion_vacaciones_id = $("#liquidacion_vacaciones_id").val();
		var estado = document.getElementById("estado").value;
		var si_empleado = document.getElementById("si_empleado").value;

		if (parseInt(liquidacion_vacaciones_id) > 0 && (si_empleado == '1' || si_empleado == 'ALL')) {

			$("input[name=anular]").each(function () { this.disabled = false; });

			$("#divAnulacion").dialog({
				title: 'Anulacion Liquidacion',
				width: 550,
				height: 280,
				closeOnEscape: true
			});

		} else if (!parseInt(liquidacion_vacaciones_id) > 0) {
			alertJquery('Debe Seleccionar primero una Liquidacion', 'Validacion Anulacion');


		} else {
			alertJquery('Por favor verifique que este correcto', 'Validacion Anulacion');
		}

	}
}

function beforePrint(formulario,url,title,width,height){
	
   var liquidacion_vacaciones_id = parseInt(document.getElementById("liquidacion_vacaciones_id").value);
      
   if(isNaN(liquidacion_vacaciones_id)){
     alertJquery("Debe Seleccionar una Liquidacion!!!","Impresion Liquidacion"); 
     return false;
   }else{
	  
	  
	  $("#rangoImp").dialog({
		  title: 'Impresion Liquidacion Vacaciones',
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
	var liquidacion_vacaciones_id = document.getElementById("liquidacion_vacaciones_id").value;
	var url = "VacacionClass.php?ACTIONCONTROLER=onclickPrint&tipo_impresion="+tipo_impresion+"&liquidacion_vacaciones_id="+liquidacion_vacaciones_id+"&random="+Math.random();
	console.log(url);
	printCancel();
    onclickPrint(null,url,"Impresion Liquidacion Vacaciones","950","600");	
	
}


function printCancel(){
	$("#rangoImp").dialog('close');	
	removeDivLoading();
}



function getTotalDebitoCredito(liquidacion_vacaciones_id){
		
	var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_vacaciones_id="+liquidacion_vacaciones_id;
	
	$.ajax({
      url     : "VacacionClass.php",
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
    url        : "VacacionClass.php?rand="+Math.random(),
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
function setDataContrato(contrato_id){
    
  var QueryString = "ACTIONCONTROLER=setDataContrato&contrato_id="+contrato_id;
  
  $.ajax({
    url        : "VacacionClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
  var responseArray         = $.parseJSON(response); 
  var contrato               =responseArray[0]['contrato'];
  var contrato_id            =responseArray[0]['contrato_id'];  
  $("#contrato").val(contrato);
  $("#contrato_id").val(contrato_id);
 
      }catch(e){
     //alertJquery(e);
       }
      
    }
    
  });
  
}

function VacacionOnSaveOnUpdate(formulario,resp){
  
   $("#refresh_QUERYGRID_novedad").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   if (parseInt(resp)>0){
   alertJquery("Se guardo la liquidacion No "+resp,"Vacaciones");
    $('#liquidacion_vacaciones_id').val(resp);
	var liquidacion_vacaciones_id = $('#liquidacion_vacaciones_id').val();
	
    var url    = "DetalleVacacionesClass.php?liquidacion_vacaciones_id="+liquidacion_vacaciones_id+"&rand="+Math.random();
	 
	 $("#detalleVacacion").attr("src",url);
	 $("#detalleVacacion").load(function(){
		 getTotalDebitoCredito(liquidacion_vacaciones_id);
     });
   }else
   {
	  alertJquery(resp,"Vacaciones");
   }
    

}

function OnclickContabilizar(){
	
	var liquidacion_vacaciones_id 			 = $("#liquidacion_vacaciones_id").val();
	var fecha 				 = $("#fecha_liquidacion").val();	
	var valor 				 = removeFormatCurrency($("#valor_total").val());
	var si_empleado          = $("#si_empleado").val();		
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_vacaciones_id="+liquidacion_vacaciones_id;	

	if(parseInt(liquidacion_vacaciones_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "VacacionClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 $("#totalDebito").html(totalDebito);
					 $("#totalCredito").html(totalCredito);	
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito)  && parseFloat(valor)>0){
						var QueryString = "ACTIONCONTROLER=getContabilizar&liquidacion_vacaciones_id="+liquidacion_vacaciones_id+"&fecha_liquidacion="+fecha+"&si_empleado="+si_empleado+"&valor="+valor;	
	
						$.ajax({
							url     : "VacacionClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										 alertJquery('Liquidacion Contabilizada','Contabilizacion Exitosa');
										 $("#refresh_QUERYGRID_factura").click();
										 setDataFormWithResponse();
										 formSubmitted = false;	
									 }else{
										   alertJquery(response,'Inconsistencia Contabilizando');
									 }
									
		
								}catch(e){
								  
								}
							}
						});
					 }else{
						alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
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


function VacacionOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	 $("#detalleVacacion").attr("src","../../../framework/tpl/blank.html");	

}

function cargardiv(){
	var empleado_id  					= $('#empleado_id').val();
	
	if(parseInt(empleado_id)>0){
		$("#iframeSolicitud").attr("src","SolicPeriodosClass.php?empleado_id="+empleado_id+"&rand="+Math.random());
		$("#divSolicitudFacturas").dialog({
			title: 'Periodos de Vacaciones Pendientes',
			width: 950,
			height: 395,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
	}else{
		alertJquery("Por Favor Seleccione un Empleado","Vacaciones");		
	}
}

function closeDialog(){
	$("#divSolicitudFacturas").dialog('close');
}

$(document).ready(function(){

	var liquidacion_vacaciones_id = $("#liquidacion_vacaciones_id").val();

	if (liquidacion_vacaciones_id.length > 0) {
		setDataFormWithResponse();
	}
						   
  var formulario = document.getElementById('VacacionForm');
  
  $("#divSolicitudFacturas").css("display","none");

						   

  $("#detalleVacacion").attr("src","../../../framework/tpl/blank.html");
	
	/* $('#dias').blur(function (){

		var si_empleado = $('#si_empleado').val();
		var dias = $('#dias').val();
		var dias_disfrutar = $('#dias_disfrutar').val();

		if(si_empleado == 'ALL'){

			salario = removeFormatCurrency($("#salario").val());
			valor = Math.floor((salario / 30) * (dias_disfrutar));
			$("#valor").val(setFormatCurrency(valor));
			$("#valor_total").val(setFormatCurrency(valor));
			
		}
	}); */
	


	 $("#fecha_dis_inicio").change(function(){
						
		
						var fecha       =	$("#fecha_dis_inicio").val();			  
						var dias 		=	$("#dias").val();
						var si_empleado =   $("#si_empleado").val();

						if(si_empleado == 1){

							if(isNaN(dias) || dias== ''){
								
								alertJquery("Debe ingresar los dias a disfrutar!");
								$("#fecha_dis_inicio").val('');
								//("#vencimiento").val(resp);
							}else{
								var QueryString = "ACTIONCONTROLER=setVencimiento&fecha="+fecha+"&dias="+dias;
								$.ajax({
									url     : "VacacionClass.php",
									data    : QueryString,
									success : function(resp){
										var data       = $.parseJSON(resp);
										var dia_fin = data[0]['dia_fin'];
		   								var dia_reintegro    = data[0]['dia_reintegro'];
										
										$("#fecha_dis_final").val(dia_fin);	
										$("#fecha_reintegro").val(dia_reintegro);

										var fecha_inicio = moment(fecha);	
										var fecha_fin = moment($("#fecha_dis_final").val());
									
										var dias_disfrutar = fecha_fin.diff(fecha_inicio,'days');
										$("#dias_disfrutar").val(dias_disfrutar);

										salario = removeFormatCurrency($("#salario").val());
										valor = Math.floor((salario / 30) * (dias_disfrutar));
										$("#valor").val(setFormatCurrency(valor));

										var valor_pagos = removeFormatCurrency($("#valor_pagos").val());
										valor_total = parseInt(valor) + parseInt(valor_pagos);
										$("#valor_total").val(setFormatCurrency(valor_total));
									}
								});
						}
					}
							
					
										
	});

	$("#fecha_dis_final").change(function () {

		var fecha_inicio = $("#fecha_dis_inicio").val();
		var fecha_final = $('#fecha_dis_final').val();
		var dias = $("#dias").val();
		var dias_disfrutar = $('#dias_disfrutar').val();
		var si_empleado = $('#si_empleado').val();

		var dias_dif = moment(fecha_final).diff(moment(fecha_inicio), 'days');
	    var porcentaje = ((dias*20)/(100));
		var dias_max = parseInt(dias)+parseInt(porcentaje);

        var fecha_reintegro = moment(fecha_final).add(1, 'days').format("YYYY-MM-DD");
		$("#fecha_reintegro").val(fecha_reintegro);
		
        var dias_disfrutar = moment(fecha_final).diff(moment(fecha_inicio), 'days');
		$("#dias_disfrutar").val(dias_disfrutar);

		if (si_empleado == 1) {

				salario = removeFormatCurrency($("#salario").val());
				valor = Math.floor((salario / 30) * (dias_disfrutar));
				$("#valor").val(setFormatCurrency(valor));

				var valor_pagos = removeFormatCurrency($("#valor_pagos").val());
				valor_total = parseInt(valor) + parseInt(valor_pagos);
				$("#valor_total").val(setFormatCurrency(valor_total));

		} else if (si_empleado == 'ALL') {
			
			salario = removeFormatCurrency($("#salario").val());
			valor = Math.floor((salario / 30) * (dias_disfrutar));
			$("#valor").val(setFormatCurrency(valor));
			$("#valor_total").val(setFormatCurrency(valor));

			

		}


		if(dias_dif > dias_max){ 
			   
			jConfirm("¡Puede que se este excediendo en la fecha final de las vacaciones! <br><br> ¿Esta seguro que desea dejar esta fecha?", "Validacion",

				function (r) {
					if (r) {
						//Codigo si se le da ACEPTAR al Jconfirm.	
					} else {
						$('#fecha_dis_final').val('');
						$('#fecha_reintegro').val('');
						//return false;
					}
				}); 
		}

		
	 
	});

	$("#fecha_reintegro").change(function () {

		var fecha_inicio = $("#fecha_dis_inicio").val();
		var fecha_reintegro = $('#fecha_reintegro').val();
		var dias = $("#dias").val();

		var dias_dif = moment(fecha_reintegro).diff(moment(fecha_inicio), 'days');
		var porcentaje = ((dias * 30) / (100));

		var dias_max = parseInt(dias) + parseInt(porcentaje);

		if (dias_dif > dias_max) {
			jConfirm("¡Puede que se este excediendo en la fecha de reintegro de las vacaciones! <br><br> ¿Esta seguro que desea dejar esta fecha?", "Validacion",

				function (r) {
					if (r) {
						//Codigo si se le da ACEPTAR al Jconfirm.	
					} else {
						
						$('#fecha_reintegro').val('');
						//return false;
					}
				}); 
		}

	});
	 
	$("#Buscar").click(function(){										
		cargardiv();
	
	  });
	
	$("#print_out").click(function(){
       printOut();								   
    });
	
    $("#print_cancel").click(function(){
       printCancel();									  
    });	
	
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,VacacionOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,VacacionOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});