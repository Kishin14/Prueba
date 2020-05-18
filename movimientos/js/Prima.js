// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
	
    var liquidacion_prima_id = $('#liquidacion_prima_id').val();
    RequiredRemove();

    var liquidacion  = new Array({campos:"liquidacion_prima_id",valores:$('#liquidacion_prima_id').val()});
	var forma       = document.forms[0];
	var controlador = 'PrimaClass.php';

	FindRow(liquidacion,forma,controlador,null,function(resp){
														
		 var data   = $.parseJSON(resp);													   
		 var empleado_id = data[0]['empleado_id'];
		 setDataEmpleado(empleado_id);
		 
		  var estado = data[0]['estado'];
		  var consecutivo = data[0]['consecutivo'];
		  
		  $('#consecutivo').val(consecutivo);			 
		 		 
		$('#si_empleado').val('1');			 
		 if(estado == 'I'){
			 
		   $(forma).find("input,select,textarea").each(function(){
               this.disabled = true;																
           });
		   
		 }else{
			 
		     $(forma).find("input,select,textarea").each(function(){
               this.disabled = false;																
             });			 
			 
		  }
     	 var url    = "DetallePrimasClass.php?liquidacion_prima_id="+liquidacion_prima_id+"&rand="+Math.random();
	 
	 $("#detallePrima").attr("src",url);
	 $("#detallePrima").load(function(){
  	    getTotalDebitoCredito(liquidacion_prima_id,'1');
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
		  
	  }	  
    });


}

function setDataFormWithResponse1(){
	
    var liquidacion_prima_id = $('#liquidacion_prima_id').val();
    RequiredRemove();

    var liquidacion  = new Array({campos:"liquidacion_prima_id",valores:$('#liquidacion_prima_id').val()});
	var forma       = document.forms[0];
	var controlador = 'PrimaClass.php';

	FindRow(liquidacion,forma,controlador,null,function(resp){
														
		 var data   = $.parseJSON(resp);													   
		
		  var estado = data[0]['estado'];
		  var consecutivo = data[0]['consecutivo'];
			
		
		  
		 if(estado == 'I'){
			 
		   $(forma).find("input,select,textarea").each(function(){
               this.disabled = true;																
           });
		   
		 }else{
			 
		     $(forma).find("input,select,textarea").each(function(){
               this.disabled = false;																
             });			 
			 
		  }
		  
		  $('#si_empleado').val('ALL');	
			
		  $('#empleado').attr("disabled","true");
		  $('#empleado').val('');
		  $('#empleado_id').val('');
 		  $("#empleado").removeClass("obligatorio");
		  
		  $('#num_identificacion').val('');
 		  $("#num_identificacion").removeClass("obligatorio");
		  $('#num_identificacion').attr("disabled","true");
		  
		  $('#cargo').val('');
 		  $("#cargo").removeClass("obligatorio");
		  $('#cargo').attr("disabled","true");
		  
		  $('#salario').val('');
 		  $("#salario").removeClass("obligatorio");
		  $('#salario').attr("disabled","true");
		  
		  $('#fecha_inicio_contrato').val('');
 		  $("#fecha_inicio_contrato").removeClass("obligatorio");
		  $('#fecha_inicio_contrato').attr("disabled","true");
		  
		   $('#valor').val('');
 		  $("#valor").removeClass("obligatorio");
		  $('#valor').attr("disabled","true");
     	 var url    = "DetallePrimasClass.php?liquidacion_prima_id="+liquidacion_prima_id+"&rango=T&rand="+Math.random();
	 
	 $("#detallePrima").attr("src",url);
	 
	 $("#detallePrima").load(function(){
  	    getTotalDebitoCredito(liquidacion_prima_id,'T');
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
		  
	  }	  
    });


}


function Empleado_si(){
	if($('#si_empleado').val()==1){
		
		  $('#empleado').attr("disabled","");	
		  $("#empleado").addClass("obligatorio");
		  $('#num_identificacion').attr("disabled","");	
		  $("#num_identificacion").addClass("obligatorio");
		  $('#cargo').attr("disabled","");	
		  $("#cargo").addClass("obligatorio");
		  $('#salario').attr("disabled","");	
		  $("#salario").addClass("obligatorio");
		  $('#fecha_inicio_contrato').attr("disabled","");	
		  $("#fecha_inicio_contrato").addClass("obligatorio");
		   $('#valor').attr("disabled","");	
		  $("#valor").addClass("obligatorio");
		  
	}else if($('#si_empleado').val()=='ALL'){
		
		  $('#empleado').attr("disabled","true");
		  $('#empleado').val('');
		  $('#empleado_id').val('');
 		  $("#empleado").removeClass("obligatorio");
		  
		  $('#num_identificacion').val('');
 		  $("#num_identificacion").removeClass("obligatorio");
		  $('#num_identificacion').attr("disabled","true");
		  
		  $('#cargo').val('');
 		  $("#cargo").removeClass("obligatorio");
		  $('#cargo').attr("disabled","true");
		  
		  $('#salario').val('');
 		  $("#salario").removeClass("obligatorio");
		  $('#salario').attr("disabled","true");
		  
		  $('#fecha_inicio_contrato').val('');
 		  $("#fecha_inicio_contrato").removeClass("obligatorio");
		  $('#fecha_inicio_contrato').attr("disabled","true");
		  
		   $('#valor').val('');
 		  $("#valor").removeClass("obligatorio");
		  $('#valor').attr("disabled","true");
		  
		  
		  
	}

}

function getTotalDebitoCredito(liquidacion_prima_id,rango){
		
	var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&rango="+rango+"&liquidacion_prima_id="+liquidacion_prima_id;
	
	$.ajax({
      url     : "PrimaClass.php",
	  data    : QueryString,
	  success : function(response){
		  		  
		  try{
			 var totalDebitoCredito = $.parseJSON(response); 
             var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
			 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
             var totalDiferencia    = Math.abs(totalDebito - totalCredito);
			 
			 $("#totalDebito").html(setFormatCurrency(totalDebito));
			 $("#totalCredito").html(setFormatCurrency(totalCredito));
			 $("#totalDiferencia").html(setFormatCurrency(totalDiferencia));
		  }catch(e){
			  
			}
      }
	  
    });    


}

function setDataEmpleado(empleado_id){
    
  var fecha_liquidacion = 	$("#fecha_liquidacion").val();	
  var QueryString = "ACTIONCONTROLER=setDataEmpleado&empleado_id="+empleado_id+"&fecha_liquidacion="+fecha_liquidacion;
  
  $.ajax({
    url        : "PrimaClass.php?rand="+Math.random(),
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
		  var dias_laborados   		  =responseArray[0]['dias_laborados']; 
		  	
		 
		  $("#num_identificacion").val(numero_identificacion);
		  $("#cargo").val(cargo);
 		  $("#salario").val(setFormatCurrency(sueldo_base));
		  $("#empleado").val(empleado);
		  $("#fecha_inicio_contrato").val(fecha_inicio);
		  
		  if($("#tipo_liquidacion").val()=='T'){
			  if(dias_laborados>180){dias_laborados=180}			  
			  /* salario = removeFormatCurrency($("#salario").val());
			  prima = (dias_laborados*(salario/2))/180;
			  $("#valor").val(setFormatCurrency(prima)); */
			  Liq_AnteriorTotal();
			  
		  }
 
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
    url        : "PrimaClass.php?rand="+Math.random(),
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

function beforePrint(formulario,url,title,width,height){
	
   var liquidacion_prima_id = parseInt(document.getElementById("liquidacion_prima_id").value);
      
   if(isNaN(liquidacion_prima_id)){
     alertJquery("Debe Seleccionar una Liquidacion!!!","Impresion Liquidacion"); 
     return false;
   }else{
	  if(document.getElementById("si_empleado").value=='1'){

	  	document.getElementById('tipo_impresion').value = 'DP';
    	document.getElementById('tipo_impresion').disabled=true;
		document.getElementById('desprendibles').disabled=false;
		
	  }else if(document.getElementById("si_empleado").value=='ALL' && document.getElementById("empleado_id").value!=''){

		document.getElementById("tipo_impresion").options[3].disabled = false;
	  	document.getElementById('tipo_impresion').value = 'DP';
    	document.getElementById('tipo_impresion').disabled=false;
		document.getElementById('desprendibles').disabled=false;

	  }else if(document.getElementById("si_empleado").value=='ALL' && document.getElementById("empleado_id").value==''){

		
		document.getElementById("tipo_impresion").options[3].disabled = true;
	  	document.getElementById('tipo_impresion').value = 'C';
    	document.getElementById('tipo_impresion').disabled=false;
		document.getElementById('desprendibles').disabled=true;
		document.getElementById('desprendibles').value='NULL';
		  
	  }
	  
	  if(document.getElementById("estado").value=='C'){
		  document.getElementById("tipo_impresion").options[4].disabled = false;
	  }else{
  		  document.getElementById("tipo_impresion").options[4].disabled = true;
	  }
	  
	  $("#rangoImp").dialog({
		  title: 'Impresion Liquidacion Prima',
		  width: 700,
		  height: 220,
			  closeOnEscape:true,
			  show: 'scale',
			  hide: 'scale'
	  });

      return false;
    }
  
  
}

function PrimaOnSaveOnUpdate(formulario,resp){
  
   $("#refresh_QUERYGRID_novedad").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   if (parseInt(resp)>0){
   alertJquery("Se guardo correctamente la liquidacion","Primas");
    $('#liquidacion_prima_id').val(resp);
    var liquidacion_prima_id = $('#liquidacion_prima_id').val();
	if($('#si_empleado').val=='1'){
		var url    = "DetallePrimasClass.php?liquidacion_prima_id="+liquidacion_prima_id+"&rand="+Math.random();
	}else{
    	var url    = "DetallePrimasClass.php?liquidacion_prima_id="+liquidacion_prima_id+"&rango=T&rand="+Math.random();
	}
	 
	 $("#detallePrima").attr("src",url);
	 $("#detallePrima").load(function(){
  	    getTotalDebitoCredito(encabezado_registro_id);
     });
   }else
   {
	  alertJquery(resp,"Primas");
   }
    

}

function OnclickContabilizar(){
	
	var liquidacion_prima_id 			 = $("#liquidacion_prima_id").val();
	var fecha 				 = $("#fecha_liquidacion").val();
	var si_empleado 		 = $("#si_empleado").val();	
	var valor 				 = removeFormatCurrency($("#valor").val());		
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_prima_id="+liquidacion_prima_id+"&rango="+si_empleado;	

	if(parseInt(liquidacion_prima_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "PrimaClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 $("#totalDebito").html(totalDebito);
					 $("#totalCredito").html(totalCredito);	
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) ){
						var QueryString = "ACTIONCONTROLER=getContabilizar&liquidacion_prima_id="+liquidacion_prima_id+"&fecha_liquidacion="+fecha+"&si_empleado="+si_empleado;	
	
						$.ajax({
							url     : "PrimaClass.php",
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
						console.log("deb : "+totalDebito+" cre:"+totalCredito); 
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

function printOut(){	
	
	var tipo_impresion = document.getElementById("tipo_impresion").value;
	var desprendibles = document.getElementById("desprendibles").value;
	var liquidacion_prima_id = document.getElementById("liquidacion_prima_id").value;
	var url = "PrimaClass.php?ACTIONCONTROLER=onclickPrint&tipo_impresion="+tipo_impresion+"&desprendibles="+desprendibles+"&liquidacion_prima_id="+liquidacion_prima_id+"&random="+Math.random();
	
	printCancel();
    onclickPrint(null,url,"Impresion Liquidacion Prima","950","600");	
	
}


function printCancel(){
	$("#rangoImp").dialog('close');	
	removeDivLoading();
}


function PrimaOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	 $("#detallePrima").attr("src","../../../framework/tpl/blank.html");	
	 
	 $("#tipo_liquidacion").val('T');
	 $("#si_empleado").val('1');
	 $("#periodo").val('1');
	 $("#estado").val('A');
	 $('#valor').attr("disabled","yes");
	 $('#valor').attr("readonly","yes");

}

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
		alertJquery("Por Favor Seleccione un Empleado","Primas");		
	}
}

function closeDialog(){
	$("#divSolicitudFacturas").dialog('close');
}


function Liq_AnteriorTotal(){
	if($('#guardar'))    $('#guardar').attr("disabled","");
	$('#valor').attr("disabled","true");
	$('#valor').attr("readonly","true");
	var empleado_id = $("#empleado_id").val();
	var periodo = $("#periodo").val();
	var fecha_liquidacion = $("#fecha_liquidacion").val();

	var QueryString = "ACTIONCONTROLER=Liq_Anterior&empleado_id="+empleado_id+"&periodo="+periodo+"&fecha_liquidacion="+fecha_liquidacion;
		$.ajax({
			url     : "PrimaClass.php",
			data    : QueryString,
			success : function(resp){
				var data       = $.parseJSON(resp);

				console.log(data);

				var fecha_anterior = data[0]['fecha_liquidacion'].substr(0, 4);
				var fecha_liquidacion = $("#fecha_liquidacion").val().substr(0, 4);
				var periodo_anterior    = data[0]['periodo'];
				var total    = data[0]['total'];
				var valor_guardado    = parseFloat(data[0]['valor_guardado']) > 0 ? data[0]['valor_guardado'] : 0;
				if (fecha_anterior ==fecha_liquidacion && periodo_anterior==periodo) {
					salario = removeFormatCurrency($("#salario").val());
					prima = ((salario/2)-total);
					var diferencia = parseFloat((prima - valor_guardado)) > 0 ? (prima - valor_guardado) : 0;				
					if (prima == 0) {
						alertJquery('Este empleado ya cuenta con una liquidación realizada por el valor completo para este semestre');
						if($('#guardar'))    $('#guardar').attr("disabled","true");
					}
					$("#diferencia").val(diferencia);
					$("#acumulado").val(valor_guardado);
					$("#valor").val(prima);
				}else if (fecha_anterior ==fecha_liquidacion && periodo_anterior!=periodo) {
					console.log('entra');
					salario = removeFormatCurrency($("#salario").val());
					prima = ((salario/2));
					var diferencia = parseFloat((prima - valor_guardado)) > 0 ? (prima - valor_guardado) : 0;
					if (prima == 0) {
						alertJquery('Este empleado ya cuenta con una liquidación realizada por el valor completo para este semestre');
						if($('#guardar'))    $('#guardar').attr("disabled","true");
					}
					$("#diferencia").val(diferencia);
					$("#acumulado").val(valor_guardado);
					$("#valor").val(prima);
				}
				// var tipo_liquidacion    = data[0]['tipo_liquidacion'];
				
	}});
}


function Liq_AnteriorParcial(){

	if($('#guardar'))    $('#guardar').attr("disabled","");
	var empleado_id = $("#empleado_id").val();
	var periodo = $("#periodo").val();
	var fecha_liquidacion = $("#fecha_liquidacion").val();

	var QueryString = "ACTIONCONTROLER=Liq_Anterior&empleado_id="+empleado_id+"&periodo="+periodo+"&fecha_liquidacion="+fecha_liquidacion;
		$.ajax({
			url     : "PrimaClass.php",
			data    : QueryString,
			success : function(resp){
				var data       = $.parseJSON(resp);

				console.log(data);

				var fecha_anterior = data[0]['fecha_liquidacion'].substr(0, 4);
				var fecha_liquidacion = $("#fecha_liquidacion").val().substr(0, 4);
				var periodo_anterior    = data[0]['periodo'];
				var total    = data[0]['total'];
				var valor_guardado    = parseFloat(data[0]['valor_guardado']) > 0 ? data[0]['valor_guardado'] : 0;
				if (fecha_anterior ==fecha_liquidacion && periodo_anterior==periodo) {
					salario = removeFormatCurrency($("#salario").val());
					prima = ((salario/2)-total);
					var diferencia = parseFloat((prima - valor_guardado)) > 0 ? (prima - valor_guardado) : 0;	
					if (prima == 0) {
						alertJquery('Este empleado ya cuenta con una liquidación realizada por el valor completo para este semestre');
						if($('#guardar'))    $('#guardar').attr("disabled","true");
					}
					$("#valor_parcial").val(prima);
					$("#diferencia").val(diferencia);
					$("#acumulado").val(valor_guardado);
					$('#valor').attr("disabled","");
					$('#valor').attr("readonly","");
					$("#valor").val('');
				}else if (fecha_anterior ==fecha_liquidacion && periodo_anterior!=periodo) {
					salario = removeFormatCurrency($("#salario").val());
					prima = ((salario/2));
					var diferencia = parseFloat((prima - valor_guardado)) > 0 ? (prima - valor_guardado) : 0;
					if (prima == 0) {
						alertJquery('Este empleado ya cuenta con una liquidación realizada por el valor completo para este semestre');
						if($('#guardar'))    $('#guardar').attr("disabled","true");
					}
					$("#valor_parcial").val(prima);
					$("#diferencia").val(diferencia);
					$("#acumulado").val(valor_guardado);
					$('#valor').attr("disabled","");
					$('#valor').attr("readonly","");
					$("#valor").val('');
				}
	}});
}

$(document).ready(function(){

	Empleado_si();
	$("#si_empleado").change(function(){										
		if($("#si_empleado").val()=='ALL'){
				$("#divConta").css("display","none");
		}else{
				$("#divConta").css("display","");

		}
	
	});


	var liquidacion_prima_id = $("#liquidacion_prima_id").val();

	if (liquidacion_prima_id.length > 0) {
		setDataFormWithResponse();
	}
						   
  var formulario = document.getElementById('PrimaForm');
  
  $("#divSolicitudFacturas").css("display","none");

						   

  $("#detallePrima").attr("src","../../../framework/tpl/blank.html");	


	 $("#fecha_dis_inicio").change(function(){
										  
						var fecha       =	$("#fecha_dis_inicio").val();			  
						var dias 		=	$("#dias").val();
						
						if(isNaN(dias) || dias== ''){
							
							alertJquery("Debe ingresar los dias a disfrutar!");
							$("#fecha_dis_inicio").val('');
							//("#vencimiento").val(resp);
						}else{
								var QueryString = "ACTIONCONTROLER=setVencimiento&fecha="+fecha+"&dias="+dias;
								$.ajax({
									url     : "PrimaClass.php",
									data    : QueryString,
									success : function(resp){
										var data       = $.parseJSON(resp);
										var dia_fin = data[0]['dia_fin'];
		   								var dia_reintegro    = data[0]['dia_reintegro'];
										
										$("#fecha_dis_final").val(dia_fin);	
										$("#fecha_reintegro").val(dia_reintegro);	
									}});
						}
										
	});
	 
	$("#Buscar").click(function(){										
		cargardiv();
	
	  });
	
	  /* $("#fecha_liquidacion,#periodo").change(function(){										
		cargardiv();
	
	  }); */
	
	$("#tipo_liquidacion,#fecha_liquidacion,#periodo").change(function(){										
		if($("#si_empleado").val()=='ALL' && $("#tipo_liquidacion").val()=='P'){
				alertJquery("No es posible hacer una liquidacion parcial para todos los empleados!!","Validacion Liquidacion Prima");
				$("#tipo_liquidacion").val('T');
		}
		
		if($("#si_empleado").val()=='1' && $("#tipo_liquidacion").val()=='T'){
			Liq_AnteriorTotal();
		}
		if($("#si_empleado").val()=='1' && $("#tipo_liquidacion").val()=='P'){
			Liq_AnteriorParcial();
		}
	
	});
	
	$("#si_empleado").change(function(){										
		if($("#si_empleado").val()=='ALL' && $("#tipo_liquidacion").val()=='P'){
				alertJquery("No es posible hacer una liquidacion parcial para todos los empleados!!","Validacion Liquidacion Prima");
				$("#tipo_liquidacion").val('T');
		}
	
	});
	$("#valor").blur(function() {							
		if (parseInt($("#valor").val()) > parseInt($("#valor_parcial").val())) {
			alert(parseInt($("#valor").val())+' Valor '+parseInt($("#valor_parcial").val())+' Valor parcial');
			alertJquery('El valor de la liquidación  $'+setFormatCurrency($("#valor").val())+' no debe ser mayor al valor máximo  $'+setFormatCurrency($("#valor_parcial").val())+' a liquidar a este empleado.');
			$("#valor").val('');
		}
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
				 Send(formulario,'onclickSave',null,PrimaOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,PrimaOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});