function usuarioOnReset(formulario){

	

		$("#frameReporte").attr("src","/application/framework/tpl/blank.html");	

	

	}

function Cliente_si(){

	if($('#si_cliente').val()==1){

		

		  if($('#cliente'))    $('#cliente').attr("disabled","");

	

	}else if($('#si_cliente').val()=='ALL'){

		

		  if($('#cliente'))    $('#cliente').attr("disabled","true");

		  $('#cliente').val('');

		  $('#cliente_id').val('');

	}

}

function all_oficce(){

	if(document.getElementById('all_oficina').checked==true){

		$('#all_oficina').val('SI');

		var objSelect = document.getElementById('oficina_id'); 

		var numOp     = objSelect.options.length -1;

	   

	   

	   for(var i = numOp; i > 0; i-- ){

		   

		  if(objSelect.options[i].value != 'NULL'){

			 objSelect.options[i].selected = true;

		  }else{

			   objSelect.options[i].selected = false;

			} 

		   

	   }

		 		 



	}else{

		$('#all_oficina').val('NO');

		var objSelect = document.getElementById('oficina_id'); 

		var numOp     = objSelect.options.length -1;

		 

	     for(var i = numOp; i > 0; i-- ){

		   

		   if(objSelect.options[i].value != 'NULL'){

			 objSelect.options[i].selected = false;

		   }else{

			   objSelect.options[i].selected = true;

			 } 

		   

	     } 		 

	}

	

}

function OnclickGenerar(formulario){

	

	if(ValidaRequeridos(formulario)){

		 var QueryString = "DetallesClass.php?"+FormSerialize(formulario);

		 $("#frameReporte").attr("src",QueryString);

		 showDivLoading();	 	   

		 $("#frameReporte").load(function(response){removeDivLoading();});

	}

}

$(document).ready(function(){

						   

   	///INICIO VALIDACION FECHAS DE REPORTE

	

  	$('#desde').change(function(){

	  	var fechah = $('#hasta').val();

	  	var fechad = $('#desde').val();

	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {

	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');

	  		return this.value = $('#hasta').val();

	  	};

	});

	$('#hasta').change(function(){

	  	var fechah = $('#hasta').val();

	  	var fechad = $('#desde').val();

	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {

	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');

	  		return this.value = $('#desde').val();

	  	};

	});

	

	///FIN VALIDACION FECHAS DE REPORTE						   

	$("#generar_excel").click(function(){

	

	 var formulario = this.form;

	

	 if(ValidaRequeridos(formulario)){

	 

	   var desde = $("#desde").val();

	   var hasta = $("#hasta").val();

	   var tipo = $("#tipo").val();

	   var oficina_id = $("#oficina_id").val();

	   var all_ofice = $("#all_ofice").val();

	   var si_cliente = $("#si_cliente").val();	 

	   var cliente_id = $("#cliente_id").val();	 	

	   var saldos = $("#saldos").val();	 	

	   

	   var QueryString = "ReportesClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&tipo="+tipo+"&oficina_id="+oficina_id+

						 "&cliente_id="+cliente_id+"&all_ofice="+all_ofice+"&si_cliente="+si_cliente+"&saldos="+saldos+"&rand="+Math.random();

						 

	   document.location.href = QueryString;						 

	

	 }								

	});	

						   

});

function descargarexcel(formulario){

	

	if(ValidaRequeridos(formulario)){

		 var QueryString = "DetallesClass.php?download=true&"+FormSerialize(formulario);

		 $("#frameReporte").attr("src",QueryString);

		

	}

}

function beforePrint(formulario){

 

   if(ValidaRequeridos(formulario)){

	   if($("#tipo").val()=='EC'){

		   if (confirm("Imprimir carta para cliente?") == true) {

			

				$("#imp_carta_cliente").val('SI');

				return true;

			 

			} else {

				$("#imp_carta_cliente").val('NO');

				return true;

			}		

			

	   }else

	   {

		   var QueryString = "DetallesClass.php?"+FormSerialize(formulario);

 	 		popPup(QueryString,'Impresion Reporte',800,600);

	   }

    

   }
}




	function mostrarGraficos(formulario){

	 var formulario = this.form;

	 if(ValidaRequeridos(formulario)){

	   var desde = $("#desde").val();
	   var hasta = $("#hasta").val();
	   var tipo = $("#tipo").val();
	   var oficina_id = $("#oficina_id").val();
	   //var all_ofice = $("#all_ofice").val();
	   var si_cliente = $("#si_cliente").val();	 
	   var cliente_id = $("#cliente_id").val();	 	
	   var saldos = $("#saldos").val();	  
	   var QueryString = "DetallesClass.php?grafico=SI&desde="+desde+"&hasta="+hasta+"&tipo="+tipo+"&oficina_id="+oficina_id+

						 "&cliente_id="+cliente_id+"&si_cliente="+si_cliente+"&saldos="+saldos+"&rand="+Math.random();
	   		 				 
		$("#frameReporte").attr("src",QueryString);
	 }								

	}	