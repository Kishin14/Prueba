// JavaScript Document
detalle_lq = '';
	dias_totales=0;
$(document).ready(function(){
	
	$("#adicionar").click(function(){
		setSolicitud();
		
	});
	compara_cantidad();

	$("input[name=dias_asignar]").blur(function () {
		var Fila = $(this).parent().parent();
		var dias_asignados = $(this).val();
		var dias_ganados = $(Fila).find("input[name=dias_hidden]").val();
		if(dias_asignados == dias_ganados){
			$(Fila).find("input[name = dias_pagar]").attr('readonly', 'readonly');
			$(Fila).find("input[name = dias_pagar]").val(0);
		}else{
			$(Fila).find("input[name = dias_pagar]").attr('readonly', '');
		}

		if(dias_asignados > 15){
			alertJquery("¡No puede disfrutar mas de los dias ganados!","Atención");
			$(this).val('');
		}

		if (dias_asignados < 6) {
			alertJquery("¡No puede disfrutar menos de 6 dias ganados! El artículo 190 del código laboral expone que:<br><br> El trabajador gozara anualmente, por lo menos de seis (6) días hábiles continuos de vacaciones, los que no son acumulables.", "Atención");
			$(this).val('');
		}


	});

	$("input[name=dias_pagar]").blur(function () {
		var Fila = $(this).parent().parent();
		var dias_pagados = $(this).val();
		if(dias_pagados > 9){
			alertJquery("¡No puede pagar mas de 9 dias! El artículo 190 del código laboral expone que:<br><br> El trabajador gozara anualmente, por lo menos de seis (6) días hábiles continuos de vacaciones, los que no son acumulables.", "Atención")
			$(this).val('');
		}

		
		var dias_asignados = $(Fila).find("input[name = dias_asignar]").val();
		var dias_ganados = $(Fila).find("input[name = dias_hidden]").val();

		var numero = dias_ganados - dias_asignados;
		
		if(dias_pagados > numero) {
			alertJquery("los dias a pagar son como maximo " + numero);
			$(this).val('');
		}


	});
});


function compara_cantidad(){
	
	$("input[name=dias_asignar]").blur(function() {
		var Fila        	= $(this).parent().parent();
		var dias_asignados  =  $(this).val();
		var dias_ganados	= $(Fila).find("input[name=dias_hidden]").val();
		var dias_otorgados	= $(Fila).find("input[name=diaso_hidden]").val();
		 
		dias_permitidos 	= dias_ganados-dias_otorgados;
		
		
		//if (dias_permitidos<dias_asignados || dias_asignados>dias_permitidos){
//			$(this).val('');
//			alertJquery("No puede ingresar mas de los dias ganados!!","Liquidacion Vacaciones");
//		}
		

	});	


}

function checkRow(obj){
	if(obj){
		if($(obj).attr("checked")){
			$(obj).attr("checked","true");
		}else{
			$(obj).attr("checked","");
		}
		
	}
 }


function setSolicitud(){
	
	detalle_lq = '';
	texto_lq = '';
	dias_totales=0;
	dias_totales_pago = 0;
	
	$(document).find("input[type=checkbox]:checked").each(function(){
																   
		fecha_ini= $($(this).parent().parent()).find("input[name=fecha_inicio_hidden]").val();
		fecha_fin= $($(this).parent().parent()).find("input[name=fecha_final_hidden]").val();
		fecha_inicial= $($(this).parent().parent()).find("input[name=fecha_inicio]").val();
		fecha_final= $($(this).parent().parent()).find("input[name=fecha_final]").val();
		dias_ganados =$($(this).parent().parent()).find("input[name=dias_hidden]").val();
		dias_asignados =$($(this).parent().parent()).find("input[name=dias_asignar]").val();
		dias_pagados = $($(this).parent().parent()).find("input[name=dias_pagar]").val();
		
		
		detalle_lq += fecha_ini+"-"+fecha_fin+"-"+dias_ganados+"-"+dias_asignados+",";
		texto_lq   += "Periodo desde :"+fecha_inicial+" Hasta :"+fecha_final+" Dias asignados :"+dias_asignados+" Dias pagados: "+dias_pagados+" / ";
		 
		dias_totales = dias_totales + parseInt(dias_asignados) + parseInt(dias_pagados);

		
		if(dias_pagados>=0){
		  dias_totales_pago = dias_totales_pago + parseInt(dias_pagados);
		}
	});
	
	salario = removeFormatCurrency(parent.document.forms[0]['salario'].value);
	alertJquery(parent.document.forms[0]['salario'].value);
	
	//valor = Math.floor((salario / 30) * (dias_totales + dias_totales_pago));
	valor_dias_pagados = Math.floor((salario / 30) * dias_totales_pago);
	//valor_total = parseInt(valor)+parseInt(valor_dias_pagados);
	
	parent.document.forms[0]['concepto_item'].value = detalle_lq;
	parent.document.forms[0]['concepto'].value = texto_lq;
	parent.document.forms[0]['dias'].value = dias_totales;
	parent.document.forms[0]['dias_pagados'].value = dias_totales_pago;
	//parent.document.forms[0]['valor'].value =setFormatCurrency(valor);
	parent.document.forms[0]['valor_pagos'].value = setFormatCurrency(valor_dias_pagados);
	//parent.document.forms[0]['valor_total'].value = setFormatCurrency(valor_total);
	parent.closeDialog();
}

