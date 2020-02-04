$(document).ready(function(){   
						   
	$("#si_empleado").change(function(){

      if(this.value == 1){
		
		$("#empleado").addClass("obligatorio");	
		$("#empleado").addClass("requerido");	
		
	  }else{		  
	   				  
		 
 		 $("#empleado").removeClass("obligatorio");		 
 		 $("#empleado").removeClass("requerido");		 		 
		 
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
	
	 $("#generar_excel").click(function(){

     var formulario = this.form;

     if(ValidaRequeridos(formulario)){
	 
       var desde		 = $("#desde").val();
	   var hasta		 = $("#hasta").val();
	   var si_cargo 	 = $("#si_cargo").val();	 
	   var cargo_id 	 = $("#cargo_id").val();
	   var si_empleado   = $("#si_empleado").val();	 
	   var empleado_id   = $("#empleado_id").val();		   
	   
       var QueryString = "reportesContratosClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+
	                     "&si_cargo="+si_cargo+"&cargo_id="+cargo_id+
						 "&si_empleado="+si_empleado+"&empleado_id="+empleado_id+"&rand="+Math.random();
						 
	   document.location.href = QueryString;	
	 }								
   });	


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

});


function empleado_si(){
	if($('#si_empleado').val()==1){
		
		  if($('#empleado'))    $('#empleado').attr("disabled","");
	
	}else if($('#si_empleado').val()=='ALL'){
		
		  if($('#empleado'))    $('#empleado').attr("disabled","true");
		  $('#empleado').val('');
		  $('#empleado_id').val('');
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
		 var QueryString = "DetallesContratosClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});		
	}
	

}

function ContratoOnReset(formulario){
	$("#frameReporte").attr("src","../../../framework/tpl/blank.html");	
	Reset(formulario);
    clearFind();  
	$("#estado").val('A');
	$('#contrato_id').attr("disabled","");
	$('#contratos').attr("disabled","");
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "DetallesContratosClass.php?"+FormSerialize(formulario);
	 popPup(QueryString,'Impresion Reporte',800,600);
	   
   }
}