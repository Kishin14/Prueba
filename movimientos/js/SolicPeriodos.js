// JavaScript Document
detalle_lq = '';
	dias_totales=0;
$(document).ready(function(){
	
	$("#adicionar").click(function(){
		setSolicitud();
		
	});
	compara_cantidad();
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
	
	$(document).find("input[type=checkbox]:checked").each(function(){
																   
		fecha_ini= $($(this).parent().parent()).find("input[name=fecha_inicio_hidden]").val();
		fecha_fin= $($(this).parent().parent()).find("input[name=fecha_final_hidden]").val();
		fecha_inicial= $($(this).parent().parent()).find("input[name=fecha_inicio]").val();
		fecha_final= $($(this).parent().parent()).find("input[name=fecha_final]").val();
		dias_ganados =$($(this).parent().parent()).find("input[name=dias_hidden]").val();
		dias_asignados =$($(this).parent().parent()).find("input[name=dias_asignar]").val();
		
		
		detalle_lq += fecha_ini+"-"+fecha_fin+"-"+dias_ganados+"-"+dias_asignados+",";
		texto_lq   += "Periodo desde :"+fecha_inicial+" Hasta :"+fecha_final+" Dias asignados :"+dias_asignados+" / ";
		 
		dias_totales+= parseInt(dias_asignados);
		
	});
	
	salario = removeFormatCurrency(parent.document.forms[0]['salario'].value);
	alertJquery(parent.document.forms[0]['salario'].value);
	valor = Math.floor((salario/30)*dias_totales);
	parent.document.forms[0]['concepto_item'].value = detalle_lq;
	parent.document.forms[0]['concepto'].value = texto_lq;
	parent.document.forms[0]['dias'].value = dias_totales;
	parent.document.forms[0]['valor'].value =setFormatCurrency(valor);
	parent.closeDialog();
}

