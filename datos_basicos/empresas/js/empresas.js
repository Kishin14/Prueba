// JavaScript Document

function LlenarFormEmpresas(){

    var terceroId = $('#tercero_id').val();

    RequiredRemove();

    var parametros  = new Array({campos:"tercero_id",valores:$('#tercero_id').val()});
	var forma       = document.forms[0];
	var controlador = 'EmpresasClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
	  
	  var data = $.parseJSON(resp);
	  ocultaFilaNombresRazon(data[0]['tipo_persona_id']);
	  
          if($('#guardar'))    $('#guardar').attr("disabled","true");
          if($('#actualizar')) $('#actualizar').attr("disabled","");
          if($('#borrar'))     $('#borrar').attr("disabled","");
          if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function showTable(){
  
	var frame_grid =  document.getElementById('frame_grid');
	
	  //Se valida que el iFrame no exista
	  if(frame_grid == null ){
  
	  var QueryString   = 'ACTIONCONTROLER=showGrid';
  
	  $.ajax({
		url        : "EmpresasClass.php?rand="+Math.random(),
		data       : QueryString,
		 async     : false,
		beforeSend : function(){
		showDivLoading();
		},
		success    : function(resp){
		  console.log(resp);
		  try{
			
			var iframe           = document.createElement('iframe');
			iframe.id            ='frame_grid';
			iframe.style.cssText = "border:0; height: 400px; background-color:transparent";
			//iframe.scrolling   = 'no';
			
			document.body.appendChild(iframe); 
			iframe.contentWindow.document.open();
			iframe.contentWindow.document.write(resp);
			iframe.contentWindow.document.close();
			
			$('#mostrar_grid').removeClass('btn btn-warning btn-sm');
			$('#mostrar_grid').addClass('btn btn-secondary btn-sm');
			$('#mostrar_grid').html('Ocultar tabla');
			
		  }catch(e){
			
			console.log(e);
			
		  }
		  removeDivLoading();
		} 
	  });
	  
	}else{
	  
		$('#frame_grid').remove();
		$('#mostrar_grid').removeClass('btn btn-secondary btn-sm');
		$('#mostrar_grid').addClass('btn btn-warning btn-sm');
		$('#mostrar_grid').html('Mostrar tabla');
	  
	}
	
  }

function EmpresaOnSaveOnUpdateOnDelete(formulario,response){
	
	if((parseInt(response)>0) || (response=='Se ingreso correctamente una nueva empresa.') || (response=='Se actualizo correctamente la empresa.')){
		Reset(formulario);
		clearFind();	  
		$("#refresh_QUERYGRID_terceros").click();
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
		alertJquery(response,"Validacion Empresas");
	}else{
		alertJquery(response,"Validacion Empresas");
	}
	
}

function empresaOnReset(){
	
	Reset(document.forms[0]);
    clearFind();	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	
}

function calculador(){
	var rangoFin  = $("#fin_resolucion").val();
	var disponible= $("#inicio_disponible_res").val();
	
	var saldo     = parseInt(rangoFin) - parseInt(disponible) + parseInt(1);
	
	$("#saldo_res").val( saldo );
}

function size(){

    $("#logo").blur(function(){
						 
  	var input = document.getElementById('logo');

	var file = input.files[0];

	if(file.size>4000000 ){
		alertJquery("El Archivo de Imagen Supera los 4MB.<br> Por Favor Baje la Resoluci&oacute;n de la Imagen o el Peso del Archivo.");
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
	}else{
		if($('#empresa_id').val()>0){
			if($('#guardar'))    $('#guardar').attr("disabled","true");
			if($('#actualizar')) $('#actualizar').attr("disabled","");
		}else{
			if($('#guardar'))    $('#guardar').attr("disabled","");
			if($('#actualizar')) $('#actualizar').attr("disabled","true");
		}
	
	}
	
	
	
  });
	
	
}

$(document).ready(function(){
	size();						   
  $("#tipo_identificacion_id").change(function(){
    calculaDigitoTercero();
  });
  
  $("#numero_identificacion").blur(function(){

     var empresa_id            = $("#empresa_id").val();
     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});
	 
	 if(!empresa_id.length > 0){
		 
          validaRegistro(this,params,"EmpresasClass.php",null,function(resp){    
																  																  
          if(parseInt(resp) != 0 ){
            var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
            var formulario = document.forms[0];
            var url        = 'EmpresasClass.php';

            FindRow(params,formulario,url,null,function(resp){

  	    var data = $.parseJSON(resp);

   	    ocultaFilaNombresRazon(data[0]['tipo_persona_id']);

            clearFind();
		 
	    $('#guardar').attr("disabled","true");
            $('#actualizar').attr("disabled","");
            $('#borrar').attr("disabled","");
            $('#limpiar').attr("disabled","");	


            });

	  }else{	   		  
             calculaDigitoTercero();				  
	     $('#guardar').attr("disabled","");
             $('#actualizar').attr("disabled","true");
             $('#borrar').attr("disabled","true");
             $('#limpiar').attr("disabled","");
	    }
		  
       });
	   
	 }
 
  
  });
  
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('TercerosForm');
	  
	  if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,EmpresaOnSaveOnUpdateOnDelete);
		}else{
            Send(formulario,'onclickUpdate',null,EmpresaOnSaveOnUpdateOnDelete);
		  }
	  }
	  	  
  });
  
  	
  $("#tipo_persona_id").change(function(){
    
    ocultaFilaNombresRazon(this.value);
    
  });
	

});