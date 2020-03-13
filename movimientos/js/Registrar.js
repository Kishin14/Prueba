// JavaScript Document
//eventos asignados a los objetos
var	formSubmitted = false;
var fecha_oculta = '';			
$(document).ready(function(){

	

	$("#fecha_inicial").change(function () {

		var periodo_liquida = $('#periodo').val();

		if(periodo_liquida > 0){

			var fecha_inicial = $(this).val();
			var ano = moment(fecha_inicial).format('YYYY');
			var mes = moment(fecha_inicial).format('MM');

        if(periodo_liquida == 1){

			var fecha_inicio = new Date($(this).val());
			var dias = 07;
			var fecha_fin = fecha_inicio.setDate(fecha_inicio.getDate() + dias);
			var fecha_final = moment(fecha_fin).format('YYYY-MM-DD');
	

			$('#fecha_final').val(fecha_final);
			$('#periodicidad').val('S');
			fecha_oculta = fecha_final;
			

		}else if(periodo_liquida == 2){

			var dia = '01';
			var dia_fin = '15';
			
			fecha_ini_sin_formato = '' + ano + '-' + mes + '-' + dia + '';
			fecha_fin_sin_formato = '' + ano + '-' + mes + '-' + dia_fin + '';

			fecha_inicio = moment(fecha_ini_sin_formato).format('YYYY-MM-DD');
			fecha_fin    = moment(fecha_fin_sin_formato).format('YYYY-MM-DD');

				$(this).val(fecha_inicio);
				$('#fecha_final').val(fecha_fin);
				$('#periodicidad').val('Q');
			    fecha_oculta = fecha_fin;

			}else if(periodo_liquida == 3){

				var dia = '16';
				var dia_fin = new Date(ano, mes, 0).getDate();

				fecha_ini_sin_formato = '' + ano + '-' + mes + '-' + dia + '';
				fecha_fin_sin_formato = '' + ano + '-' + mes + '-' + dia_fin + '';

				fecha_inicio = moment(fecha_ini_sin_formato).format('YYYY-MM-DD');
				fecha_fin = moment(fecha_fin_sin_formato).format('YYYY-MM-DD');
				$(this).val(fecha_inicio);
				$('#fecha_final').val(fecha_fin);
				$('#periodicidad').val('Q');
			    fecha_oculta = fecha_fin;

			}else if(periodo_liquida == 4){

				var dia = '01';
				var dia_fin = new Date(ano, mes, 0).getDate();

				fecha_ini_sin_formato = '' + ano + '-' + mes + '-' + dia + '';
				fecha_fin_sin_formato = '' + ano + '-' + mes + '-' + dia_fin + '';

				fecha_inicio = moment(fecha_ini_sin_formato).format('YYYY-MM-DD');
				fecha_fin = moment(fecha_fin_sin_formato).format('YYYY-MM-DD');
				$(this).val(fecha_inicio);
				$('#fecha_final').val(fecha_fin);
				$('#periodicidad').val('M');
			    fecha_oculta = fecha_fin;

			}else{
			    $('#periodicidad').val('T');
			}

		}else{
			alertJquery("¡Por favor primero seleccione un periodo a liquidar!","Atención");
			$(this).val('');
		}
		
	});

	$("#periodo").change(function () {

		var periodo_liquida = $(this).val();
		var fecha_inicial = $('#fecha_inicial').val();

		if (periodo_liquida == 5) {
			$('#fecha_final').attr("disabled", "");
		}else{
			$('#fecha_final').attr("disabled", "disabled");
		}

		if(fecha_inicial != '') {

			var ano = moment(fecha_inicial).format('YYYY');
			var mes = moment(fecha_inicial).format('MM');

			if (periodo_liquida == 1) {

				var fecha_inicio = new Date(fecha_inicial);
				var dias = 07;
				var fecha_fin = fecha_inicio.setDate(fecha_inicio.getDate() + dias);
				var fecha_final = moment(fecha_fin).format('YYYY-MM-DD');


				$('#fecha_final').val(fecha_final);
				$('#periodicidad').val('S');
				fecha_oculta = fecha_final;


			} else if (periodo_liquida == 2) {

				var dia = '01';
				var dia_fin = '15';

				fecha_ini_sin_formato = '' + ano + '-' + mes + '-' + dia + '';
				fecha_fin_sin_formato = '' + ano + '-' + mes + '-' + dia_fin + '';

				fecha_inicio = moment(fecha_ini_sin_formato).format('YYYY-MM-DD');
				fecha_fin = moment(fecha_fin_sin_formato).format('YYYY-MM-DD');

				$('#fecha_inicial').val(fecha_inicio);
				$('#fecha_final').val(fecha_fin);
				$('#periodicidad').val('Q');
				fecha_oculta = fecha_fin;

			} else if (periodo_liquida == 3) {

				var dia = '16';
				var dia_fin = new Date(ano, mes, 0).getDate();

				fecha_ini_sin_formato = '' + ano + '-' + mes + '-' + dia + '';
				fecha_fin_sin_formato = '' + ano + '-' + mes + '-' + dia_fin + '';

				fecha_inicio = moment(fecha_ini_sin_formato).format('YYYY-MM-DD');
				fecha_fin = moment(fecha_fin_sin_formato).format('YYYY-MM-DD');
				$('#fecha_inicial').val(fecha_inicio);
				$('#fecha_final').val(fecha_fin);
				$('#periodicidad').val('Q');
				fecha_oculta = fecha_fin;

			} else if (periodo_liquida == 4) {

				var dia = '01';
				var dia_fin = new Date(ano, mes, 0).getDate();

				fecha_ini_sin_formato = '' + ano + '-' + mes + '-' + dia + '';
				fecha_fin_sin_formato = '' + ano + '-' + mes + '-' + dia_fin + '';

				fecha_inicio = moment(fecha_ini_sin_formato).format('YYYY-MM-DD');
				fecha_fin = moment(fecha_fin_sin_formato).format('YYYY-MM-DD');
				$('#fecha_inicial').val(fecha_inicio);
				$('#fecha_final').val(fecha_fin);
				$('#periodicidad').val('M');
				fecha_oculta = fecha_fin;

			} else {
				$('#periodicidad').val('T');
			}

		}



	});


	$("#fecha_final").change(function () {

		var fecha_final= $(this).val();

		var periodo = $('#periodo').val();

		if(periodo != 5){

			if(fecha_final != fecha_oculta){
				$('#fecha_final').val(fecha_oculta);
			}

		}
	});



  	$("#tipo_impresion").change(function(){
									
		if(this.value=='DP'){									
			$('#desprendibles').attr("disabled","");
			document.getElementById('desprendibles').value=1;
			
		}else{
			$('#desprendibles').attr("disabled","true");
			document.getElementById('desprendibles').value='NULL';
		}
    });
	
    $("#saveDetallesSoliServi").click(function(){
      window.frames[0].saveDetallesSoliServi();
    });
    

    $("#empleados").change(function(){
									
		if(this.value=='U'){									
			if($('#contrato'))    $('#contrato').attr("disabled","");
			if($('#contrato_id')) $('#contrato_id').addClass("obligatorio");
			
			if($('#periodicidad')) $('#periodicidad').val("T");			
			if($('#periodicidad')) $('#periodicidad').attr("disabled","true");			
			if($('#periodicidad')) $('#periodicidad').removeClass("obligatorio");
			
			if($('#area_laboral')) $('#area_laboral').val("T");			
			if($('#area_laboral'))    $('#area_laboral').attr("disabled","true");			
			if($('#area_laboral')) $('#area_laboral').removeClass("obligatorio");				

			if($('#centro_de_costo_id')) $('#centro_de_costo_id').val("NULL");			
			if($('#centro_de_costo_id')) $('#centro_de_costo_id').attr("disabled","true");			
			if($('#centro_de_costo_id')) $('#centro_de_costo_id').removeClass("obligatorio");				

		}else{
			if($('#contrato'))    $('#contrato').attr("disabled","true");			
			if($('#contrato'))    $('#contrato').val("");			
			if($('#contrato_id')) $('#contrato_id').val("");
			if($('#contrato_id')) $('#contrato_id').removeClass("obligatorio");
			
			if($('#periodicidad')) $('#periodicidad').attr("disabled","");
			if($('#periodicidad')) $('#periodicidad').addClass("obligatorio");
			if($('#area_laboral')) $('#area_laboral').attr("disabled","");
			if($('#area_laboral')) $('#area_laboral').addClass("obligatorio");
			if($('#centro_de_costo_id')) $('#centro_de_costo_id').attr("disabled","");

		}
    });
	
	$("#print_out").click(function(){
       printOut();								   
    });
	
    $("#print_cancel").click(function(){
       printCancel();									  
    });	
});



 function Previsual(formulario){

	if(ValidaRequeridos(formulario)){

	var empleados          = document.getElementById("empleados").value;
	var fecha_inicial      = $("#fecha_inicial").val();
	var fecha_final        = $("#fecha_final").val();
	var periodicidad       = $("#periodicidad").val();
	var area_laboral       = $("#area_laboral").val();
	var centro_de_costo_id = $("#centro_de_costo_id").val();	
	var contrato_id        = $("#contrato_id").val();
	
	var QueryString = "ACTIONCONTROLER=validaPeriodo&empleados="+empleados+"&periodicidad="+periodicidad+"&contrato_id=" + contrato_id;

		$.ajax({
			type: "POST",
			url: "RegistrarClass.php?rand=" + Math.random(),
			data: QueryString,

			success: function (resp) {	

				var data = $.parseJSON(resp);
                
				if(data != null){
					
					if(data.length > 1){
						var mensaje = '';
						for(var i = 0; i < data.length; i++){

							var numero_contrato = data[i]['numero_contrato'];
							var empleado = data[i]['empleado'];
							var periodicidad1 = data[i]['periodicidad'];

							mensaje = mensaje + "\n <b>Contrato " + numero_contrato + "--" + empleado+"--"+periodicidad1+"</b>\n";
						}

						if(periodicidad == 'S'){
							periodicidad2 =' SEMANAL';
						}else if(periodicidad == 'Q'){
							periodicidad2 = 'QUINCENAL';
						}else if(periodicidad == 'M'){
							periodicidad2 = 'MENSUAL';
						}else if(periodicidad =='T'){
							periodicidad2 = 'TODAS';
						}
						


						jConfirm("Estos contratos no se liquidar&aacuten. Excepto si la periodicidad de esta liquidaci&oacuten es <b>'TODOS'</b>: <br>"+mensaje+"<br>Por favor tenga en cuenta que la liquidacion que se esta haciendo tiene periodicidad: <b style='color:red'>"+periodicidad2+"</b><br><br>¿Esta seguro que desea continuar?", "Validacion",

							function (r) {
								if (r) {
									//Codigo si se le da ACEPTAR al Jconfirm.
									var QueryString = "ACTIONCONTROLER=onclickSave&previsual=true&empleados=" + empleados + "&fecha_inicial=" + fecha_inicial + "&fecha_final=" + fecha_final + "&periodicidad=" + periodicidad + "&area_laboral=" + area_laboral + "&centro_de_costo_id=" + centro_de_costo_id + "&contrato_id=" + contrato_id;

									$.ajax({
										type: "POST",
										url: "RegistrarClass.php?rand=" + Math.random(),
										data: QueryString,

										success: function (resp) {

											try {
												if (resp > 0) {

													alertJquery("Existe una liquidaci&oacuten Previa  para las fechas seleccionadas. <br>Por favor verifique Liquidaci&oacute;n No " + resp);

												} else {

													if (resp.indexOf('<html>') != -1) {
														document.location.href = "RegistrarClass.php?" + QueryString;
													} else {
														alertJquery(resp, "atencion");
													}

												}
											} catch (e) {
												alertJquery("se presento un inconveniente: " + e, "Atencion");
											}
										}
									});


								} else {
									alertJquery("La nomina no se liquidar&aacute","Atencion");
								}
							}); 
						}else{

							var numero_contrato = data[0]['numero_contrato'];
							var empleado = data[0]['empleado'];
							var periodicidad1 = data[0]['periodicidad'];

							mensaje = "\n <b>Contrato " + numero_contrato + "--" + empleado + "-- Periodicidad: " + periodicidad1 + "</b>\n";
						

								if (periodicidad == 'S') {
									periodicidad2 = ' SEMANAL';
								} else if (periodicidad == 'Q') {
									periodicidad2 = 'QUINCENAL';
								} else if (periodicidad == 'M') {
									periodicidad2 = 'MENSUAL';
								} else {
									periodicidad2 = 'TODAS';
								}

						alertJquery("¡Este contrato no se liquidar&aacute!. Si desea puede actualizar la periodicidad en el contrato: <br>" + mensaje + "<br>Por favor tenga en cuenta que la liquidaci&oacuten que se esta haciendo tiene periodicidad: <b style='color:red'>"+periodicidad2);

						}
				}else{
					var QueryString = "ACTIONCONTROLER=onclickSave&previsual=true&empleados=" + empleados + "&fecha_inicial=" + fecha_inicial + "&fecha_final=" + fecha_final + "&periodicidad=" + periodicidad + "&area_laboral=" + area_laboral + "&centro_de_costo_id=" + centro_de_costo_id + "&contrato_id=" + contrato_id;

					$.ajax({
						type: "POST",
						url: "RegistrarClass.php?rand=" + Math.random(),
						data: QueryString,

						success: function (resp) {

							try {
								if (resp > 0) {

									alertJquery("Existe una liquidaci&oacute;n Previa  para las fechas seleccionadas. <br>Por favor verifique Liquidaci&oacute;n No " + resp);

								} else {

									if (resp.indexOf('<html>') != -1) {
										document.location.href = "RegistrarClass.php?" + QueryString;
									} else {
										alertJquery(resp, "atencion");
									}

								}
							} catch (e) {
								alertJquery("se presento un inconveniente: " + e, "Atencion");
							}
						}
					});
				}
			
		
			}

		});

  }

}


function setDataFormWithResponse(){
	
    var parametros 	= new Array ({campos:"liquidacion_novedad_id", valores:$('#liquidacion_novedad_id').val()});
    var forma 	= document.forms[0];
    var controlador = 'RegistrarClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var liquidacion_novedad_id = $('#liquidacion_novedad_id').val();
	  var estado = $('#estado').val();
      var url 	    = "DetalleRegistrarClass.php?liquidacion_novedad_id="+liquidacion_novedad_id;
      
      $("#detalleRegistrarNovedad").attr("src",url);
      $('#contrato').attr("disabled","true");
	  $('#empleados').attr("disabled","true");
	  $('#fecha_inicial').attr("disabled","true");
	  $('#fecha_final').attr("disabled","true");
	  $('#periodo').attr("disabled", "true");	

	  $('#centro_de_costo_id').attr("disabled","true");
	  
      $('#guardar').attr("disabled","true");
	  $("#previsual").attr("disabled", "true");
	  
	  if(estado=='A'){
	      $('#anular').attr("disabled","true");
		  $('#contabilizar').attr("disabled","true");
	  }else if(estado=='C'){
		  $('#anular').attr("disabled","");
		  $('#contabilizar').attr("disabled","true");			   
	  }else if(estado=='E'){
		  $('#anular').attr("disabled","");
		  $('#contabilizar').attr("disabled","");			   
		  
	  }
      $('#limpiar').attr("disabled","");
      	    
    });
}

function setDataFormWithResponse1(){
	
    var parametros 	= new Array ({campos:"liquidacion_novedad_id1", valores:$('#liquidacion_novedad_id').val()});
    var forma 	= document.forms[0];
    var controlador = 'RegistrarClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var fecha_inicial = $('#fecha_inicial').val();
	  var fecha_final = $('#fecha_final').val();
	  var estado = $('#estado').val();
      var url 	    = "DetalleRegistrarClass.php?fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final+"&rango=T";
      
      $("#detalleRegistrarNovedad").attr("src",url);
	  $('#periodo').attr("disabled", "true");
	  $('#contrato').attr("disabled","true");
	  $('#empleados').attr("disabled","true");
	  $('#fecha_inicial').attr("disabled","true");
	  $('#fecha_final').attr("disabled","true");	  
	  
	  $('#area_laboral').attr("disabled","true");
	  $('#periodicidad').attr("disabled","true");
	  $('#centro_de_costo_id').attr("disabled","true");
	  
	  
	  $('#guardar').attr("disabled","true");
	  $("#previsual").attr("disabled", "true");
	  if(estado=='A'){
	      $('#anular').attr("disabled","true");
		  $('#contabilizar').attr("disabled","true");
	  }else if(estado=='C'){
		  $('#anular').attr("disabled","");
		  $('#contabilizar').attr("disabled","true");			   
	  }else if(estado=='E'){
		  $('#anular').attr("disabled","");
		  $('#contabilizar').attr("disabled","");			   
	  }
      $('#limpiar').attr("disabled","");
      	    
    });
}

function RegistrarOnSave(formulario,resp){
  	
  	try{
		
		if (isInteger(resp)){
					
			$("#liquidacion_novedad_id").val(resp);
			
			var liquidacion_novedad_id = $('#liquidacion_novedad_id').val();
			var url 		           = "DetalleRegistrarClass.php?liquidacion_novedad_id="+liquidacion_novedad_id;
			
			$("#detalleRegistrarNovedad").attr("src",url);
			$('#contrato').attr("disabled","true");
			$('#empleados').attr("disabled","true");
		    $('#fecha_inicial').attr("disabled","true");
		    $('#fecha_final').attr("disabled","true");	  
			$('#centro_de_costo_id').attr("disabled","true");
			$('#guardar').attr("disabled","true");
			$('#anular').attr("disabled","");
			$('#contabilizar').attr("disabled","");			
			$('#limpiar').attr("disabled","");
			$("#previsual").attr("disabled", "true");
			
			updateGrid();
		
		}else{
			alertJquery("Ocurrio una inconsistencia : "+resp);
		}
	
    }catch(e){
		 alertJquery(e);
		 console.log(resp);
    }
}



function RegistrarOnReset(){
  
    var oficina    = $("#oficina_hidden").val();
    var oficina_id = $("#oficina_id_hidden").val();
    
    clearFind();
	$("#detalleRegistrarNovedad").attr("src","");
    $('#contrato').attr("disabled","");
	$('#empleados').attr("disabled","");
	$('#guardar').attr("disabled","");
	$("#previsual").attr("disabled", "");
    $('#anular').attr("disabled","true");
	$('#contabilizar').attr("disabled","true");
    $('#limpiar').attr("disabled","");
    
    $("#oficina").val(oficina);
    $("#oficina_id").val(oficina_id);	
    $("#fecha_ss").val($("#fecha_ss_static").val());		
	$("#busqueda").val('');
	$("#busqueda1").val('');
    $('#fecha_inicial').attr("disabled","");
	$('#fecha_final').attr("disabled","");	
	$('#periodo').attr("disabled", "");
	
	if($('#periodicidad')) $('#periodicidad').val("T");			
	if($('#periodicidad'))    $('#periodicidad').attr("disabled","true");			
	if($('#periodicidad')) $('#periodicidad').removeClass("obligatorio");
	
	if($('#area_laboral')) $('#area_laboral').val("T");			
	if($('#area_laboral'))    $('#area_laboral').attr("disabled","true");			
	if($('#area_laboral')) $('#area_laboral').removeClass("obligatorio");  

	if($('#centro_de_costo_id')) $('#centro_de_costo_id').val("NULL");			
	if($('#centro_de_costo_id'))    $('#centro_de_costo_id').attr("disabled","true");			
	if($('#centro_de_costo_id')) $('#centro_de_costo_id').removeClass("obligatorio");  


    document.getElementById('estado').value = 'E';
    document.getElementById('estado').disabled=true;
    document.getElementById('empleados').value = 'U';	
	
}


function updateGrid(){
	$("#refresh_QUERYGRID_Registrar").click();
}

function beforePrint(formulario,url,title,width,height){
	
   var liquidacion_novedad_id = parseInt(document.getElementById("liquidacion_novedad_id").value);
      
   if(isNaN(liquidacion_novedad_id)){
     alertJquery("Debe Seleccionar una Liquidacion!!!","Impresion Liquidacion"); 
     return false;
   }else{
	  /*if(document.getElementById("empleados").value=='U'){

	  	document.getElementById('tipo_impresion').value = 'DP';
    	document.getElementById('tipo_impresion').disabled=true;
		document.getElementById('desprendibles').disabled=false;
		
	  }else if(document.getElementById("empleados").value=='T' && document.getElementById("contrato").value!=''){

		document.getElementById("tipo_impresion").options[3].disabled = false;
	  	document.getElementById('tipo_impresion').value = 'DP';
    	document.getElementById('tipo_impresion').disabled=false;
		document.getElementById('desprendibles').disabled=false;

	  }else */if(document.getElementById("empleados").value=='T' && document.getElementById("contrato").value==''){

		
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
		  title: 'Impresion Liquidacion Nomina',
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
	var desprendibles = document.getElementById("desprendibles").value;
	var liquidacion_novedad_id = document.getElementById("liquidacion_novedad_id").value;
	if(tipo_impresion=='PE'){
		var download = 'true';
	}else{
		var download = 'false';
	}
	
	var url = "RegistrarClass.php?ACTIONCONTROLER=onclickPrint&download="+download+"&tipo_impresion="+tipo_impresion+"&desprendibles="+desprendibles+"&liquidacion_novedad_id="+liquidacion_novedad_id+"&random="+Math.random();
	
	printCancel();
    onclickPrint(null,url,"Impresion Liquidacion Nomina","950","600");	
	
}


function printCancel(){
	$("#rangoImp").dialog('close');	
	removeDivLoading();
}

function onclickCancellation(formulario){


	var liquidacion_novedad_id     = $("#liquidacion_novedad_id").val();

	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.getElementById('RegistrarForm');
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observacion_anulacion       = $("#observacion_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
		   
		   
		 if(!formSubmitted){  
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&liquidacion_novedad_id="+liquidacion_novedad_id+"&causal_anulacion_id="+causal_anulacion_id+"&observacion_anulacion="+observacion_anulacion;
		
	     $.ajax({
           url  : "RegistrarClass.php?rand="+Math.random(),
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
			   formSubmitted = true;
	       },
	       success : function(response){
			 
             Reset(formularioPrincipal);	
             RegistrarOnReset();		
			 removeDivLoading();
             $("#divAnulacion").dialog('close');			 
			 
			 formSubmitted = false;
						  
		     if($.trim(response) == 'true'){
				 
			    alertJquery('Liquidacion Anulada','Anulado Exitosamente');
			 
			 }else{
			    alertJquery(response,'Inconsistencia Anulando');
			 }
			   
			 
	       }
	   
	     });
		 
	    }
	   
	   }
	
    }else{
		
	 var liquidacion_novedad_id = $("#liquidacion_novedad_id").val();
	 var estado    = document.getElementById("estado").value;
	 var empleados = document.getElementById("empleados").value;
	 var contrato    = document.getElementById("contrato").value;
	 
	 if(parseInt(liquidacion_novedad_id) > 0 && (empleados=='U' || (empleados=='T' && contrato==''))){		

	    $("input[name=anular]").each(function(){ this.disabled = false; });
		
		$("#divAnulacion").dialog({
		  title: 'Anulacion Liquidacion',
		  width: 550,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else if(!parseInt(liquidacion_novedad_id) > 0){
		alertJquery('Debe Seleccionar primero una Liquidacion','Validacion Anulacion');
	 
	 }else if(empleados=='T' && contrato!=''){
		alertJquery('Esta liquidacion se Realizo Aplicando el proceso a Todos los empleados.<br />Por favor haga la busqueda por fechas y anule Toda la Planilla del Periodo.','Anulacion');
		
	 }else{
		alertJquery('Por favor verifique que este correcto','Validacion Anulacion'); 
	 }
		
	}
}


function OnclickContabilizar(){
	var liquidacion_novedad_id  = $("#liquidacion_novedad_id").val();
	var fecha_inicial 			= $("#fecha_inicial").val();	
	$('#contabilizar').attr("disabled","true");
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_novedad_id="+liquidacion_novedad_id;	

	if(parseInt(liquidacion_novedad_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "RegistrarClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)>0 ){
						var QueryString = "ACTIONCONTROLER=getContabilizar&liquidacion_novedad_id="+liquidacion_novedad_id+"&fecha_inicial="+fecha_inicial;	
	
						$.ajax({
							url     : "RegistrarClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										$('#guardar').attr("disabled","true");
										$('#anular').attr("disabled","");
										$('#contabilizar').attr("disabled","true");
										$("#previsual").attr("disabled", "true");
										$('#limpiar').attr("disabled","");
										document.getElementById('estado').value = 'C';
										 alertJquery('Registro Contabilizado','Contabilizacion Exitosa');
										 $("#refresh_QUERYGRID_Registrar").click();

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
						alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
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
