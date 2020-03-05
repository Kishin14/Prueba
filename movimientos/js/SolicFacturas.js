// JavaScript Document
var detalle_ss_id='';
var detalle_concepto='';
$(document).ready(function(){
	
	$("#adicionar").click(function(){
		setSolicitud();
		
	});
	compara_cantidad();
});


function compara_cantidad(){
	
	$("input[name=pagar]").keyup(function() {
		var Fila        = $(this).parent().parent();
		var pagar 		= $(Fila).find("input[name=pagar]").val();	
		var saldo 		= $(Fila).find("input[name=saldo]").val();
		var abonos_nc	= $(Fila).find("input[name=abonos_nc]").val();
		
		var pagar1		= removeFormatCurrency(pagar);
		var saldo1		= removeFormatCurrency(saldo);	
		var abonos_nc1	= parseFloat(abonos_nc)>0 ? parseFloat(abonos_nc):0;
		if(parseFloat(abonos_nc1)>0)
			mensajeabo	= "<br>Por favor tenga en cuenta que los abonos por $"+setFormatCurrency(abonos_nc)+" No contabilizados se toman en cuenta";
		else
			mensajeabo	= "_";
		

		if((parseFloat(saldo1)-parseFloat(abonos_nc1)) < parseFloat(pagar1)){

			$(Fila).find("input[name=pagar]").val(setFormatCurrency(parseFloat(saldo1)-parseFloat(abonos_nc1)));
			alertJquery("Valor ingresado mayor al saldo"+mensajeabo,"Pago");
			
		}

	});	


}

function checkRow(obj){
	if(obj){
		if(obj.checked == true ){
			$(obj).attr("checked","true");
			var Fila        =  obj.parentNode.parentNode;
			var abonos_nc 	= $(Fila).find("input[name=abonos_nc]").val();	
			var saldo 		= $(Fila).find("input[name=saldo]").val();
			var pagar 		= $(Fila).find("input[name=pagar]").val();	
			var pagar1		= removeFormatCurrency(pagar);
			var saldo1		= removeFormatCurrency(saldo);

			if(parseFloat(abonos_nc)>0){
				alertJquery("Existen abonos sin Contabilizar para esta Nomina por valor de $"+setFormatCurrency(abonos_nc)+"<br> Por favor Contabilice los pagos si desea que se tomen en cuenta en los abonos.<br>De lo contrario por favor anule esos pagos para que no vuelva a aparecer este mensaje","Pago");
				var real = parseFloat(pagar1)-parseFloat(abonos_nc);
		
				if((parseFloat(saldo1)-parseFloat(abonos_nc)) < parseFloat(pagar1)){			
					$(Fila).find("input[name=pagar]").val(setFormatCurrency(real));	
				}
			}
		}
	}
 }




function setSolicitud(){
	
	console.log('test');
	
	detalle_ss_id_nomina         = '';
	detalle_ss_id_primas         = '';
	detalle_ss_id_cesantias      = '';
	detalle_ss_id_int_cesantias  = '';
	detalle_ss_id_vacaciones     = '';
	
	detalle_valores_nomina         = '';
	detalle_valores_primas         = '';
	detalle_valores_cesantias      = '';
	detalle_valores_int_cesantias  = '';
	detalle_valores_vacaciones     = '';
	
	pago_saldo_nomina         = 0;
	pago_saldo_primas         = 0;
	pago_saldo_cesantias      = 0;
	pago_saldo_int_cesantias  = 0;
	pago_saldo_vacaciones     = 0;
	
	var retorno               = ''; 
	
	$(document).find("input[name=nomina]:checked").each(function(){

		detalle_ss_id_nomina  += $(this).val()+",";	
		detalle_valores_nomina+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
		valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
		pago_saldo_nomina = parseFloat(pago_saldo_nomina) + parseFloat(valor_ind);
	});
	
	
	$(document).find("input[name=primas]:checked").each(function(){

		detalle_ss_id_primas  += $(this).val()+",";	
		detalle_valores_primas+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
		valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
		pago_saldo_primas = parseFloat(pago_saldo_primas) + parseFloat(valor_ind);
	});
	
	
	$(document).find("input[name=cesantias]:checked").each(function(){

		detalle_ss_id_cesantias  += $(this).val()+",";	
		detalle_valores_cesantias+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
		valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
		pago_saldo_cesantias = parseFloat(pago_saldo_cesantias) + parseFloat(valor_ind);
	});
	
	$(document).find("input[name=int_cesantias]:checked").each(function(){

		detalle_ss_id_int_cesantias  += $(this).val()+",";	
		detalle_valores_int_cesantias+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
		valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
		pago_saldo_int_cesantias = parseFloat(pago_saldo_int_cesantias) + parseFloat(valor_ind);
	});
	
	
	$(document).find("input[name=vacaciones]:checked").each(function(){

		detalle_ss_id_vacaciones  += $(this).val()+",";	
		detalle_valores_vacaciones+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
		valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
		pago_saldo_vacaciones = parseFloat(pago_saldo_vacaciones) + parseFloat(valor_ind);
	});

	
	if(pago_saldo_nomina>0 && $("#tableNomina tr").length > 2){
		
		parent.document.forms[0]['causaciones_abono_nomina'].value = detalle_ss_id_nomina;
		parent.document.forms[0]['valores_abono_nomina'].value     = detalle_valores_nomina;
		parent.document.forms[0]['valor_abono_nomina'].value       = setFormatCurrency(pago_saldo_nomina);
		
	}else if($("#tableNomina tr").length ==  2){
		
		parent.document.forms[0]['causaciones_abono_nomina'].value = '';
		parent.document.forms[0]['valores_abono_nomina'].value     = '';
		parent.document.forms[0]['valor_abono_nomina'].value       = 0;
		
	}else{
		
		retorno += "No ha escogido una de las Nominas Pendientes. Por favor Seleccione una de las Nominas !! .<br><br>";
	}
	
	
	
	
	if(pago_saldo_primas>0 && $("#tablePrimas tr").length > 2){
		
		parent.document.forms[0]['causaciones_abono_primas'].value = detalle_ss_id_primas;
		parent.document.forms[0]['valores_abono_primas'].value     = detalle_valores_primas;
		parent.document.forms[0]['valor_abono_primas'].value       = setFormatCurrency(pago_saldo_primas);
		
	}else if($("#tablePrimas tr").length ==  2){
		
		parent.document.forms[0]['causaciones_abono_primas'].value = '';
		parent.document.forms[0]['valores_abono_primas'].value     = '';
		parent.document.forms[0]['valor_abono_primas'].value       = 0;
		
	}else{
		
		retorno += "No ha escogido una de las Primas Pendientes. Por favor Seleccione una de las Primas !! .<br><br>";
	}
	
	
	
	
	if(pago_saldo_cesantias>0 && $("#tableCesantias tr").length > 2){
		
		parent.document.forms[0]['causaciones_abono_cesantias'].value = detalle_ss_id_cesantias;
		parent.document.forms[0]['valores_abono_cesantias'].value     = detalle_valores_cesantias;
		parent.document.forms[0]['valor_abono_cesantias'].value       = setFormatCurrency(pago_saldo_cesantias);
		
		
	}else if($("#tableCesantias tr").length ==  2){
		
		parent.document.forms[0]['causaciones_abono_cesantias'].value = '';
		parent.document.forms[0]['valores_abono_cesantias'].value     = '';
		parent.document.forms[0]['valor_abono_cesantias'].value       = 0;
		
	}else{
		
		retorno += "No ha escogido una de las Cesantias Pendientes. Por favor Seleccione una de las Cesantias !! .<br><br>";
	}
	
	
	
	
	if(pago_saldo_int_cesantias>0 && $("#tableIntCesantias tr").length > 2){
		
		parent.document.forms[0]['causaciones_abono_int_cesantias'].value = detalle_ss_id_int_cesantias;
		parent.document.forms[0]['valores_abono_int_cesantias'].value     = detalle_valores_int_cesantias;
		parent.document.forms[0]['valor_abono_int_cesantias'].value       = setFormatCurrency(pago_saldo_int_cesantias);
		
		
	}else if($("#tableIntCesantias tr").length ==  2){
		
		parent.document.forms[0]['causaciones_abono_int_cesantias'].value = '';
		parent.document.forms[0]['valores_abono_int_cesantias'].value     = '';
		parent.document.forms[0]['valor_abono_int_cesantias'].value       = 0;
		
	}else{
		
		retorno += "No ha escogido una de los Intereses de Cesantias Pendientes. Por favor Seleccione una de los Intereses de Cesantias !! .<br><br>";

	}
	
	
	
	if(pago_saldo_vacaciones>0 && $("#tableVacaciones tr").length > 2){
		
		parent.document.forms[0]['causaciones_abono_vacaciones'].value = detalle_ss_id_vacaciones;
		parent.document.forms[0]['valores_abono_vacaciones'].value     = detalle_valores_vacaciones;
		parent.document.forms[0]['valor_abono_vacaciones'].value       = setFormatCurrency(pago_saldo_vacaciones);
		
	}else if($("#tableVacaciones tr").length ==  2){
		
		parent.document.forms[0]['causaciones_abono_vacaciones'].value = '';
		parent.document.forms[0]['valores_abono_vacaciones'].value     = '';
		parent.document.forms[0]['valor_abono_vacaciones'].value       = 0;
		
	}else{
		
		retorno += "No ha escogido una de las Vacaciones Pendientes. Por favor Seleccione una de las Vacaciones !!.";

	}
	
	if(retorno.length == 0) parent.cargardatos();
	
	return retorno;
}

