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

function ALL_OFFICE(){
	if(document.getElementById('all_office').checked==true){
		$('#all_office').val('SI');

		var objSelect = document.getElementById('oficina_id'); 
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
		$('#all_office').val('NO');
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

function ALL_PERMISES(){
	if(document.getElementById('all_permiso').checked==true){
		$('#all_permiso').val('SI');

		var objSelect = document.getElementById('permiso_id'); 
		var numOp     = objSelect.options.length -1;
	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_permiso').val('NO');
		var objSelect = document.getElementById('permiso_id'); 
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

function ALL_TYPES(){
	if(document.getElementById('all_tipos').checked==true){
		$('#all_tipos').val('SI');

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
		$('#all_tipos').val('NO');
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
		 var QueryString = "DetallesUsuariosClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});
		 if($("#imprimir")) $("#imprimir").attr("disabled","");
		
	}
	
}

function descargarexcel(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesUsuariosClass.php?download=true&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		
	}
}

function beforePrint(formulario){
 
   if(ValidaRequeridos(formulario)){
     var QueryString = "DetallesUsuariosClass.php?"+FormSerialize(formulario);
  popPup(QueryString,'Impresion Reporte',800,600);
    
   }
}