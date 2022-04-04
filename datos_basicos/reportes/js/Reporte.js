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

});

function Usuario_si(){
	if($('#si_usuario').val()==1){
		
		  if($('#usuario'))    $('#usuario').attr("disabled","");
	
	}else if($('#si_usuario').val()=='ALL'){
		
		  if($('#usuario'))    $('#usuario').attr("disabled","true");
		  $('#usuario').val('');
		  $('#usuario_id').val('');
	}

}

function usuarioOnReset(formulario){

	$("#frameReporte").attr("src","/envipack/framework/tpl/blank.html");	

}

function alltablas(){
	if(document.getElementById('all_tablas').checked==true){
		$('#all_tablas').val('SI');

		var objSelect = document.getElementById('tablas_id'); 
		var numOp     = objSelect.options.length -1;
		objSelect.options[0].selected=false;
	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 
		   
	   }
		 		 


	}else{
		$('#all_tablas').val('NO');
		var objSelect = document.getElementById('tablas_id'); 
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
		 if($("#imprimir")) $("#imprimir").attr("disabled","");
		
	}
	
}

function OnclickGenerarexcel(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesClass.php?download=true&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 if($("#imprimir")) $("#imprimir").attr("disabled","");
		 removeDivLoading();
		
	}
	
}

function imprimir_reporte(formulario){
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
		 popPup(QueryString,'Trafico','1250','700');
	}
}