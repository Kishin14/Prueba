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
	 
       var desde		 = $("#desde").val();
	   var hasta		 = $("#hasta").val();
	   var si_cargo 	 = $("#si_cargo").val();	 
	   var cargo_id 	 = $("#cargo_id").val();
	   var si_convocado   = $("#si_convocado").val();	 
	   var convocado_id   = $("#convocado_id").val();		   
	   
       var QueryString = "reportePruebaClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+
	                     "&si_cargo="+si_cargo+"&cargo_id="+cargo_id+
						 "&si_convocado="+si_convocado+"&convocado_id="+convocado_id+"&rand="+Math.random();
						 
	   document.location.href = QueryString;	
	 }								
   });
  
   	$("#si_convocado").change(function(){

      if(this.value == 1){
		
		$("#convocado").addClass("obligatorio");	
		$("#convocado").addClass("requerido");	
		
	  }else{		  
	   				  
		 
 		 $("#convocado").removeClass("obligatorio");		 
 		 $("#convocado").removeClass("requerido");		 		 
		 
	    }
});
	
	 	$("#si_cargo").change(function(){

      if(this.value == 1){
		
		$("#cargo").addClass("obligatorio");	
		$("#cargo").addClass("requerido");	
		
	  }else{		  
	   				  
		 
 		 $("#cargo").removeClass("obligatorio");		 
 		 $("#cargo").removeClass("requerido");		 		 
		 
	    }
});

});


function convocado_si(){
	if($('#si_convocado').val()==1){
		
		  if($('#convocado'))    $('#convocado').attr("disabled","");
	
	}else if($('#si_convocado').val()=='ALL'){
		
		  if($('#convocado'))    $('#convocado').attr("disabled","true");
		  $('#convocado').val('');
		  $('#convocado_id').val('');
	}
}

	function cargo_si(){
		if($('#si_cargo').val()==1){
			
		  if($('#cargo'))    $('#cargo').attr("disabled","");
	
	}else if($('#si_cargo').val()=='ALL'){
		
		  if($('#cargo'))    $('#cargo').attr("disabled","true");
		  $('#cargo').val('');
		  $('#cargo_id').val('');
	}
}



function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesPruebaClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});		
	}
	
	
}

function ConvocadoOnReset(formulario){
	$("#frameReporte").attr("src","../../../framework/tpl/blank.html");	
	Reset(formulario);
    clearFind();  
	$("#estado").val('A');
	$('#convocatoria_id').attr("disabled","");
	$('#convocatoria').attr("disabled","");
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "DetallesPruebaClass.php?"+FormSerialize(formulario);
	 popPup(QueryString,'Impresion Reporte',800,600);
	   
   }
}