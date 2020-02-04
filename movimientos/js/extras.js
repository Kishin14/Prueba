// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#hora_extra_id').val();
	var parametros  = new Array({campos:"hora_extra_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'ExtrasClass.php';

	
	
	
	FindRow(parametros,forma,controlador,null,function(resp){
		var sueldo_base = $('#sueldo_base').val();
		var fecha_inicial = $('#fecha_inicial').val();
		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#imprimir'))   $('#imprimir').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
		//alert(sueldo_base+fecha_inicial);
		$("#personas").val('U');
		if ($("#estado").val()=='E') {
			$("#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#estado,").attr("disabled", "");
			if ($('#procesar')) $('#procesar').attr("disabled", "");
			if ($('#procesar_todos')) $('#procesar_todos').attr("disabled", "");
		}else{
			$("#fecha_inicial,#fecha_final,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#estado,").attr("disabled", "true");
			if ($('#procesar')) $('#procesar').attr("disabled", "true");
			if ($('#procesar_todos')) $('#procesar_todos').attr("disabled", "true");
			if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
		}
		$("#contrato,#contrato_hidden,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#state,#Uno").css('display', '');
		$("#personas,#contrato,#sueldo_base,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#archivo").attr("disabled", "true");
		$("#contrato,#contrato_hidden,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado,#archivo,#personas").removeClass('obligatorio');
		$("#contrato,#contrato_hidden,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado,#archivo,#personas").removeClass('requerido');
		$("#procest").css('display', 'none');
		$("#proces").css('display', 'none');

			if ($("#personas").val() == 'U') {
				$("#proces").css('display', '');
				$("#procest").css('display', 'none');
			} else if ($("#personas").val() == 'NULL') {
				$("#proces").css('display', 'none');
				$("#procest").css('display', 'none');
			} else {
				$("#proces").css('display', 'none');
				$("#procest").css('display', '');
			}

		ExtrasAuto(sueldo_base, fecha_inicial);
		total();
	});

	

	/*$("#ajax_listOfOptions").click(function () {
	});*/

}

function ExtrasOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_Extras").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#imprimir'))   $('#imprimir').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	if ($('#procesar')) $('#procesar').attr("disabled", "");
	if ($('#procesar_todos')) $('#procesar_todos').attr("disabled", "");
	alertJquery(resp,"Horas Extras");
}

function onclickCancellation(formulario) {

	var contrato_id = $("#contrato_hidden").val();

	if ($("#divAnulacion").is(":visible")) {

		var formulario = document.getElementById('ExtrasForm');
		var causal_anulacion_id = $("#causal_anulacion_id").val();
		var observacion_anulacion = $("#observacion_anulacion").val();

		if (ValidaRequeridos(formulario)) {


				var QueryString = "ACTIONCONTROLER=onclickCancellation&contrato_id=" + contrato_id + "&observacion_anulacion=" + observacion_anulacion + "&causal_anulacion_id=" + causal_anulacion_id;

				$.ajax({
					url: "ExtrasClass.php?rand=" + Math.random(),
					data: QueryString,
					beforeSend: function () {
						showDivLoading();
						formSubmitted = true;
					},
					success: function (response) {

						Reset(formulario);
						ExtrasOnReset(formulario);
						removeDivLoading();
						$("#divAnulacion").dialog('close');

						formSubmitted = false;
						if ($.trim(response) == 'true') {

							alertJquery('Horas Extras Anuladas', 'Anulado Exitosamente');
							$("#refresh_QUERYGRID_Extras").click();



						} else {
							alertJquery(response, 'Inconsistencia Anulando');
						}


					}

				});

		}

	} else {

		var estado = document.getElementById("estado").value;

		if (parseInt(contrato_id) > 0) {

			$("input[name=anular]").each(function () { this.disabled = false; });

			$("#divAnulacion").dialog({
				title: 'Anulacion Horas Extras',
				width: 450,
				height: 280,
				closeOnEscape: true
			});

		} else {
			alertJquery('Debe Seleccionar primero unas horas extras', 'Anulacion');
		}

	}


}

function ExtrasOnReset(formulario){
	Reset(formulario);
    clearFind();  
	setFocusFirstFieldForm(formulario); 
	enabledInputsFormRemesa(formulario);
	$('#hora_extra_id').attr("disabled","");
	$('#Todos,#Uno').css("display","none");
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#imprimir'))   $('#imprimir').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	if ($('#procesar')) $('#procesar').attr("disabled", "");
	if ($('#procesar_todos')) $('#procesar_todos').attr("disabled", "");

}

function disabledInputsFormRemesa(forma) {

	$(forma).find("input,select,textarea").each(function () {

		if (this.type != 'button') {
			this.disabled = true;
		}
	});
}

function enabledInputsFormRemesa(forma) {

	$(forma).find("input,select,textarea").each(function () {

		if (this.type != 'button') {
			this.disabled = false;
		}
	});
}


function cambio_mensaje(boton,obj) {
mensaje_alert(boton,obj);

}



function setDataContrato(contrato_id){
	
  var QueryString = "ACTIONCONTROLER=setDataContrato&contrato_id="+contrato_id;
  
  $.ajax({
    url        : "ExtrasClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
	
      
		try{
	
			var responseArray         = $.parseJSON(response); 

			if (responseArray == 'false') {
				alertJquery('Este empleado ya tiene unas horas extras creadas, por favor digite en el campo de busqueda el nombre o identificacion del empleado.');
			} else {
			
			var contrato               =responseArray[0]['contrato'];
			var contrato_id            =responseArray[0]['contrato_id']; 
			var sueldo_base   			= responseArray[0]['sueldo_base'];

			$("#contrato").val(contrato);
			$("#contrato_id").val(contrato_id);
			$("#sueldo_base").val(sueldo_base);  
			var fecha_inicial = '';
			ExtrasAuto(sueldo_base,fecha_inicial);
			}	
			
		}catch(e){
		//alertJquery(e);
		}

	}
    
  });
  
}

$(document).ready(function(){

	var hora_extra_id = $("#hora_extra_id").val();
    
	if (hora_extra_id.length > 0) {
        setDataFormWithResponse();
    }
	$("#Todos,#Uno,#divAnulacion").css('display', 'none');

	$("#personas").change(function () {
		validaExcel();
	});	

	$("#procest").css('display', 'none');
	$("#proces").css('display', 'none');
	$("#personas").change(function () {

		if ($("#personas").val() == 'U') {
			$("#proces").css('display', '');
			$("#procest").css('display', 'none');
		} else if ($("#personas").val() == 'NULL'){
			$("#proces").css('display', 'none');
			$("#procest").css('display', 'none');
		}else{
			$("#proces").css('display', 'none');
			$("#procest").css('display', '');
		}
	});	
	
	

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('ExtrasForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				if ($("#personas").val() == 'U') {
					Send(formulario,'onclickSave',null,ExtrasOnSaveOnUpdateonDelete)
				}else{
					Send(formulario, 'onclickSaveExcel', null, ExtrasOnSaveOnUpdateonDelete)
				}
			}else{
				Send(formulario,'onclickUpdate',null,ExtrasOnSaveOnUpdateonDelete)
			}
		}
	});

	$("#procesar,#procesar_todos").click(function(){
		var contrato_id = $("#contrato_hidden").val();
		var fecha_inicial = $("#fecha_inicial").val();
		var fecha_final = $("#fecha_final").val();
		if (fecha_inicial != '' && fecha_final!='') {
			
			if (this.id == 'procesar') {
				
				var QueryString = "ACTIONCONTROLER=setProcesar&contrato_id=" + contrato_id + "&fecha_inicial=" + fecha_inicial + "&fecha_final=" + fecha_final;
			}else{

				var QueryString = "ACTIONCONTROLER=setProcesar&fecha_inicial=" + fecha_inicial + "&fecha_final=" + fecha_final;
			} 

			$.ajax({
				url: "ExtrasClass.php?rand=" + Math.random(),
				data: QueryString,
				beforeSend: function () {

				},
				success: function (response) {


					try {
						$("#refresh_QUERYGRID_Extras").click();
						if ($('#guardar')) $('#guardar').attr("disabled", "true");
						if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
						if ($('#borrar')) $('#borrar').attr("disabled", "true");
						if ($('#imprimir')) $('#imprimir').attr("disabled", "");
						if ($('#limpiar')) $('#limpiar').attr("disabled", "");
						if ($('#procesar')) $('#procesar').attr("disabled", "true");
						if ($('#procesar_todos')) $('#procesar_todos').attr("disabled", "true");
						alertJquery(response, "Horas Extras");

						setDataFormWithResponse();
						

					} catch (e) {
						alertJquery(e);
						if ($('#procesar')) $('#procesar').attr("disabled", "");
						if ($('#procesar_todos')) $('#procesar_todos').attr("disabled", "");
					}

				}

			});
		}else{
			alertJquery('Debe digitar las fechas para procesar las horas extras en ese rango de fechas.');
		}
	});
	
	
	$("#horas_diurnas").blur(function(){

		var sueldo_base 	= removeFormatCurrency($("#sueldo_base").val());
		var fecha_inicial 	= $('#fecha_inicial').val();
		var horas_diurnas 	= $('#horas_diurnas').val();					  
		var vr_horas_extra_diurna = removeFormatCurrency($("#vr_horas_extra_diurna").val());

		var QueryString = "ACTIONCONTROLER=setExtras&sueldo_base=" + sueldo_base + "&fecha_inicial=" + fecha_inicial + "&horas_diurnas=" + horas_diurnas + "&vr_horas_extra_diurna=" + vr_horas_extra_diurna;
		
		$.ajax({
			url        : "ExtrasClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			
			},
			success    : function(response){
			
			try{
			
				var vr_horas_diurnas    =response;
				$("#vr_horas_diurnas").val(setFormatCurrency(vr_horas_diurnas));  
				total();
				
				}catch(e){
				//alertJquery(e);
				}
			
			}
		
		});
	});



	
	$("#horas_nocturnas").blur(function(){

		
		var sueldo_base 	= removeFormatCurrency($("#sueldo_base").val());
		var fecha_inicial 	= $('#fecha_inicial').val();
		var horas_nocturnas = $('#horas_nocturnas').val();					  
		var vr_horas_extra_nocturna = removeFormatCurrency($("#vr_horas_extra_nocturna").val());	

		var QueryString = "ACTIONCONTROLER=setExtras&sueldo_base=" + sueldo_base + "&fecha_inicial=" + fecha_inicial + "&horas_nocturnas=" + horas_nocturnas + "&vr_horas_extra_nocturna=" + vr_horas_extra_nocturna; 
		
		$.ajax({
			url        : "ExtrasClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			
			},
			success    : function(response){
			
			try{
			
				var vr_horas_nocturnas    =response;
				$("#vr_horas_nocturnas").val(setFormatCurrency(vr_horas_nocturnas));  
				total();
				
				}catch(e){
				//alertJquery(e);
				}
			
			}
		
		});
	});	
	
	$("#horas_diurnas_fes").blur(function(){

		
		var sueldo_base 	= removeFormatCurrency($("#sueldo_base").val());
		var fecha_inicial 	= $('#fecha_inicial').val();
		var horas_diurnas_fes = $('#horas_diurnas_fes').val();					  
		var vr_horas_diurna_fest = removeFormatCurrency($("#vr_horas_diurna_fest").val());

		var QueryString = "ACTIONCONTROLER=setExtras&sueldo_base=" + sueldo_base + "&fecha_inicial=" + fecha_inicial + "&horas_diurnas_fes=" + horas_diurnas_fes + "&vr_horas_diurna_fest=" + vr_horas_diurna_fest;
		
		$.ajax({
			url        : "ExtrasClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			
			},
			success    : function(response){
			
			try{
			
				var vr_horas_diurnas_fes    =response;
				$("#vr_horas_diurnas_fes").val(setFormatCurrency(vr_horas_diurnas_fes));  
				total();
				
				}catch(e){
				//alertJquery(e);
				}
			
			}
		
		});
	});	
	
	$("#horas_nocturnas_fes").blur(function(){

		
		var sueldo_base 	= removeFormatCurrency($("#sueldo_base").val());
		var fecha_inicial 	= $('#fecha_inicial').val();
		var horas_nocturnas_fes = $('#horas_nocturnas_fes').val();					  
		var vr_horas_recargo_festivo = removeFormatCurrency($("#vr_horas_recargo_festivo").val());	

		var QueryString = "ACTIONCONTROLER=setExtras&sueldo_base=" + sueldo_base + "&fecha_inicial=" + fecha_inicial + "&horas_nocturnas_fes=" + horas_nocturnas_fes + "&vr_horas_recargo_festivo=" + vr_horas_recargo_festivo;
		
		$.ajax({
			url        : "ExtrasClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			
			},
			success    : function(response){
			
			try{
			
				var vr_horas_nocturnas_fes    =response;
				$("#vr_horas_nocturnas_fes").val(setFormatCurrency(vr_horas_nocturnas_fes));  
				total();
				
				}catch(e){
				//alertJquery(e);
				}
			
			}
		
		});
	});		

	$("#horas_recargo_noc").blur(function(){

		
		var sueldo_base 	= removeFormatCurrency($("#sueldo_base").val());
		var fecha_inicial 	= $('#fecha_inicial').val();
		var horas_recargo_noc = $('#horas_recargo_noc').val();					  
		var vr_horas_nocturno = removeFormatCurrency($("#vr_horas_nocturno").val());				  
		var QueryString = "ACTIONCONTROLER=setExtras&sueldo_base=" + sueldo_base + "&fecha_inicial=" + fecha_inicial + "&horas_recargo_noc=" + horas_recargo_noc + "&vr_horas_nocturno=" + vr_horas_nocturno;
		
		$.ajax({
			url        : "ExtrasClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			
			},
			success    : function(response){
			
			try{
			
				var vr_horas_recargo_noc    =response;
				$("#vr_horas_recargo_noc").val(setFormatCurrency(vr_horas_recargo_noc));  
				total();
				
				}catch(e){
				//alertJquery(e);
				}
			
			}
		
		});
	});	
	
	
	$("#horas_recargo_doc").blur(function(){

		
		var sueldo_base 	= removeFormatCurrency($("#sueldo_base").val());
		var fecha_inicial 	= $('#fecha_inicial').val();
		var horas_recargo_doc = $('#horas_recargo_doc').val();	
		var vr_horas_festivo = removeFormatCurrency($("#vr_horas_festivo").val());	
						  
		var QueryString = "ACTIONCONTROLER=setExtras&sueldo_base=" + sueldo_base + "&fecha_inicial=" + fecha_inicial + "&horas_recargo_doc=" + horas_recargo_doc + "&vr_horas_festivo=" + vr_horas_festivo;
		
		$.ajax({
			url        : "ExtrasClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			
			},
			success    : function(response){
			
			try{
			
				var vr_horas_recargo_doc    =response;
				$("#vr_horas_recargo_doc").val(setFormatCurrency(vr_horas_recargo_doc));  
				total();
				
				}catch(e){
				//alertJquery(e);
				}
			
			}
		
		});
	});	

	$("#fecha_final,#fecha_inicial").change(function(){

		
		var sueldo_base 	= removeFormatCurrency($("#sueldo_base").val());
		var fecha_inicial 	= $('#fecha_inicial').val();
		if (fecha_inicial !='') {
			ExtrasAuto(sueldo_base, fecha_inicial);
		}else{
			alertJquery('Debe digitar la fecha inicial para poder continuar con el proceso! ');
		}
	});	 	

	
}
	
);

function validaExcel() {
	if ($("#personas").val() == 'U') {

		$("#Todos").css('display', 'none');
		$("#Uno").css('display', '');
		$("#archivo").css('display', 'none');
		$('#contrato').attr("disabled", "");
		$('#sueldo_base').attr("disabled", "true");
		$('#horas_diurnas').attr("disabled", "");
		$('#horas_nocturnas').attr("disabled", "");
		$('#horas_diurnas_fes').attr("disabled", "");
		$('#horas_nocturnas_fes').attr("disabled", "");
		$('#horas_recargo_noc').attr("disabled", "");
		$('#horas_recargo_doc').attr("disabled", "");
		$('#vr_horas_diurnas').attr("disabled", "true");
		$('#vr_horas_nocturnas').attr("disabled", "true");
		$('#vr_horas_diurnas_fes').attr("disabled", "true");
		$('#vr_horas_nocturnas_fes').attr("disabled", "true");
		$('#vr_horas_recargo_noc').attr("disabled", "true");
		$('#vr_horas_recargo_doc').attr("disabled", "true");
		$('#estado').attr("disabled", "");
		$('#state').attr("disabled", "");
		$("#contrato,#contrato_hidden,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado,#state").css('display', '');
		$("#contrato,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado").addClass('obligatorio');
		$("#contrato,#contrato_hidden,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado").addClass('requerido');
		$("#archivo").removeClass('requerido');


	} else if ($("#personas").val() == 'NULL'){
		$("#contrato,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado,#archivo").attr("disabled", "true");
		$("#contrato,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado,#state,#archivo,#Todos,#Uno").css('display', 'none');
		$("#contrato,#contrato_hidden,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado,#archivo").removeClass('obligatorio');
		$("#contrato,#contrato_hidden,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado,#archivo").removeClass('requerido');
	} else {

		$("#Uno").css('display', 'none');
		$("#Todos").css('display', '');
		$("#archivo").css('display', '');
		$("#archivo").addClass('requerido');
		$('#archivo').attr("disabled", "");
		$("#contrato,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado").attr("disabled", "true");
		$("#contrato,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado,#state").css('display', 'none');
		$("#contrato,#contrato_hidden,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado").removeClass('obligatorio');
		$("#contrato,#contrato_hidden,#sueldo_base,#horas_diurnas,#horas_nocturnas,#horas_diurnas_fes,#horas_nocturnas_fes,#horas_recargo_noc,#horas_recargo_doc,#vr_horas_diurnas,#vr_horas_nocturnas,#vr_horas_diurnas_fes,#vr_horas_nocturnas_fes,#vr_horas_recargo_noc,#vr_horas_recargo_doc,#estado").removeClass('requerido');

	}
}

function ExtrasAuto(sueldo_base,fecha_inicial) {

	if (sueldo_base>0 && fecha_inicial !='') {
		
		showDivLoading();
		
		var sueldo_base = sueldo_base;
		var fecha_inicial = fecha_inicial;
		removeDivLoading();
		
	}else{
		

		 showDivLoading();
		 var sueldo_base = removeFormatCurrency($("#sueldo_base").val());
		 var fecha_inicial = $('#fecha_inicial').val();
		 removeDivLoading();
		if (fecha_inicial=='') {
			alertJquery('Debe digitar la fecha inicial para poder continuar con el proceso! ');
		 }
	}

		var QueryString = "ACTIONCONTROLER=setExtrasAuto&sueldo_base=" + sueldo_base + "&fecha_inicial=" + fecha_inicial;

		$.ajax({
			url: "ExtrasClass.php?rand=" + Math.random(),
			data: QueryString,
			beforeSend: function () {

			},
			success: function (response) {

				try {

					var responseArray = JSON.parse(response);


					var vr_horas_festivo = responseArray.valor_festivo;
					var vr_horas_nocturno = responseArray.valor_recargo_noct;
					var vr_horas_recargo_festivo = responseArray.valor_noct_fest;
					var vr_horas_diurna_fest = responseArray.valor_diur_fest;
					var vr_horas_extra_nocturna = responseArray.valor_nocturnas;
					var vr_horas_extra_diurna = responseArray.valor_diurnas;
					
	
					$("#vr_horas_festivo").val(setFormatCurrency(vr_horas_festivo));
					$("#vr_horas_nocturno").val(setFormatCurrency(vr_horas_nocturno));
					$("#vr_horas_recargo_festivo").val(setFormatCurrency(vr_horas_recargo_festivo));
					$("#vr_horas_diurna_fest").val(setFormatCurrency(vr_horas_diurna_fest));
					$("#vr_horas_extra_nocturna").val(setFormatCurrency(vr_horas_extra_nocturna));
					$("#vr_horas_extra_diurna").val(setFormatCurrency(vr_horas_extra_diurna));


				} catch (e) {
					//alertJquery(e);
				}

			}

		});

}
function total() {
	var vr_horas_diurnas       = removeFormatCurrency($("#vr_horas_diurnas").val());
	var vr_horas_nocturnas     = removeFormatCurrency($("#vr_horas_nocturnas").val());
	var vr_horas_diurnas_fes   = removeFormatCurrency($("#vr_horas_diurnas_fes").val());
	var vr_horas_nocturnas_fes = removeFormatCurrency($("#vr_horas_nocturnas_fes").val());
	var vr_horas_recargo_noc   = removeFormatCurrency($("#vr_horas_recargo_noc").val());
	var vr_horas_recargo_doc   = removeFormatCurrency($("#vr_horas_recargo_doc").val());

	if (vr_horas_diurnas == null || vr_horas_diurnas == '') vr_horas_diurnas = 0;
	if (vr_horas_nocturnas == null || vr_horas_nocturnas == '') vr_horas_nocturnas = 0;
	if (vr_horas_diurnas_fes == null || vr_horas_diurnas_fes == '') vr_horas_diurnas_fes = 0;
	if (vr_horas_nocturnas_fes == null || vr_horas_nocturnas_fes == '') vr_horas_nocturnas_fes = 0;
	if (vr_horas_recargo_noc == null || vr_horas_recargo_noc == '') vr_horas_recargo_noc = 0;
	if (vr_horas_recargo_doc == null || vr_horas_recargo_doc == '') vr_horas_recargo_doc = 0;

	
	var total = (parseInt(vr_horas_diurnas) + parseInt(vr_horas_nocturnas) + parseInt(vr_horas_diurnas_fes) + parseInt(vr_horas_nocturnas_fes) + parseInt(vr_horas_recargo_noc) + parseInt(vr_horas_recargo_doc));

	$("#total").val(setFormatCurrency(total));
}

function beforePrint(){
	
   var hora_extra_id = parseInt(document.getElementById("hora_extra_id").value);
      
   if(isNaN(hora_extra_id)){
     alertJquery("Debe Seleccionar una hora extra !!","Impresion Hora Extra"); 
     return false;
   }else{
      return true;
    }
 }