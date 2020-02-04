$(document).ready(function(){
	$("#graficos,#generar").css("display", "none");
	setTipo();
	$("#si_tipo").trigger("change");
	
	// Indicadores
	
	// Cierra Indicadores
		

			   
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

	$("#opciones_destino").click(function(){
     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
     var objSelect = document.getElementById('destino_id'); 
	 var numOp     = objSelect.options.length -1;
	   
     if(this.value == 'T'){
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 
		   
	   }
		 		 
	 }else{
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 
		   
	     } 		 
		 
	  }

  });
						   
});

function setTipo(){
		
	  $("#si_tipo").change(function(){
								 
	      if(this.value == 1){
			 $("#titulo_contrato,#campos_contrato").css("display",""); 
			 $("#titulo_contrato,#campos_contrato").addClass("obligatorio");
			 $("#titulo_arrendatario,#campos_arrendatario").css("display","none"); 
			 $("#titulo_arrendatario,#campos_arrendatario,#tercero_id").removeClass("obligatorio");
			 $('#tercero_id').val('');		
			 $('#tercero_id').val('');		 
		  }else if(this.value == 2){
			  $("#titulo_contrato,#campos_contrato").css("display","none"); 
			  $("#titulo_arrendatario,#campos_arrendatario").addClass("obligatorio"); 
			  $("#titulo_arrendatario,#campos_arrendatario").css("display",""); 
			  $("#titulo_contrato,#campos_contrato,#contrato_id").removeClass("obligatorio");; 	
			  $('#contrato_id').val('');
			  $('#contrato').val('');	 		  
			}else{
	            $("#titulo_contrato,#campos_contrato,#titulo_arrendatario,#campos_arrendatario").css("display","none");	
	          }							 
								 
	  });	
		
	}

function setIndicadores(){
		
	  $("#indicadores").change(function(){
								 
	      if(this.value == 'S'){
			 $("#graficos").css("display",""); 
			 $("#generar").css("display","none"); 	 
		  } else if (this.value == 'N') {
			  $("#graficos").css("display", "none");
			  $("#generar").css("display", ""); 
		  }else{
			  $("#graficos,#generar").css("display", "none");
	     }							 
								 
	  });	
		
	}

function descargarexcel(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "ReporteHojaVidaClass.php?ACTIONCONTROLER=generateFile&download=true&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		
	}
}

function viewDocument(encabezado_registro_id){
  var QueryString = "../../../contabilidad/clases/MovimientosContablesClass.php?ACTIONCONTROLER=onclickPrint&encabezado_registro_id="+encabezado_registro_id;
  var title       = "Visualizacion Documento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}

function viewDoc(encabezado_registro_id){
  var QueryString = "../../../contabilidad/clases/MovimientosContablesClass.php?ACTIONCONTROLER=onclickPrint&encabezado_registro_id="+encabezado_registro_id;
  var title       = "Visualizacion Documento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}

function viewDocFact(encabezado_registro_id){
  var QueryString = "../../../contabilidad/clases/MovimientosContablesClass.php?ACTIONCONTROLER=onclickPrint&encabezado_registro_id="+encabezado_registro_id;
  var title       = "Visualizacion Documento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}

function viewDocumentos(factura_id){
  var QueryString = "../../../facturacion/factura/clases/FacturaClass.php?ACTIONCONTROLER=onclickPrint&factura_id="+factura_id;
  var title       = "Visualizacion Documento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
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

function all_estados(){
	if(document.getElementById('all_estado').checked==true){
		$('#all_estado').val('SI');
		
		var objSelect = document.getElementById('estado_id'); 
		var numOp     = objSelect.options.length -1;	   

	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_estado').val('NO');
		var objSelect = document.getElementById('estado_id'); 
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

function all_clases(){
	if(document.getElementById('all_clase').checked==true){
		$('#all_clase').val('SI');
		
		var objSelect = document.getElementById('clase_id'); 
		var numOp     = objSelect.options.length -1;	   

	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_clase').val('NO');
		var objSelect = document.getElementById('clase_id'); 
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

function all_tipos(){
	if(document.getElementById('all_tipo').checked==true){
		$('#all_tipo').val('SI');
		
		var objSelect = document.getElementById('tipo'); 
		var numOp     = objSelect.options.length -1;	   

	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_tipo').val('NO');
		var objSelect = document.getElementById('tipo'); 
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
		 var QueryString = "ReporteHojaVidaClass.php?ACTIONCONTROLER=generateFile&download=false&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});
	}
	
}

function OnclickGenerarExcel(formulario){

	 if(ValidaRequeridos(formulario)){
		 var QueryString = "ReporteHojaVidaClass.php?ACTIONCONTROLER=generateFile&download=true&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		// $("#frameReporte").load(function(response){});
	}
	removeDivLoading();
}
function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "ReporteHojaVidaClass.php?ACTIONCONTROLER=generateFile&download=false&"+FormSerialize(formulario);
	 popPup(QueryString,'Impresion Reporte',800,600);
	   
   }
}

function mostrarGraficos(formulario) {

	var formulario = this.form;

	if (ValidaRequeridos(formulario)) {

		var si_tipo = $("#si_tipo").val();
		var indicadores = $("#indicadores").val();
		var contrato_id = $("#contrato_id").val();
		var contrato = $("#contrato").val();
		var tercero_id = $("#tercero_id").val();
		var tercero = $("#tercero").val();
		
		var QueryString = "DetallesindicadoresClass.php?grafico=SI&indicadores=" + indicadores + "&contrato_id=" + contrato_id + "&contrato=" + contrato + "&si_tipo=" + si_tipo +

			"&tercero_id=" + tercero_id + "&tercero=" + tercero + "&rand=" + Math.random();

		$("#frameReporte").attr("src", QueryString);
	}

}	