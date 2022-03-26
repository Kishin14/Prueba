// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#documento_laboral_id').val();
	var parametros  = new Array({campos:"documento_laboral_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'DocumentoClass.php';

	
	FindRow(parametros,forma,controlador,null,function(resp){
										   
	  var data              = $.parseJSON(resp);
	  var documento_laboral_id = data[0]['documento_laboral_id'];

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
      url        : "DocumentoClass.php?rand="+Math.random(),
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

function setDataEmpleado(empleado_id){
    
  var QueryString = "ACTIONCONTROLER=setDataEmpleado&empleado_id="+empleado_id;
  
  $.ajax({
    url        : "DocumentoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
  var responseArray        	  = $.parseJSON(response); 
  var empleado             	  =responseArray[0]['empleado'];
  var empleado_id      	      =responseArray[0]['empleado_id'];  
  $("#empleado").val(empleado);
  $("#empleado_id").val(empleado_id);
 
      }catch(e){
     //alertJquery(e);
       }
      
    }
    
  });
  
}
  
function setDataCargo(cargo_id){
    
  var QueryString = "ACTIONCONTROLER=setDataCargo&cargo_id="+cargo_id;
  
  $.ajax({
    url        : "DocumentoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
  var responseArray        	  = $.parseJSON(response); 
  var cargo             	  =responseArray[0]['cargo'];
  var cargo_id      	      =responseArray[0]['cargo_id'];  
  $("#cargo").val(cargo);
  $("#cargo_id").val(cargo_id);
 
      }catch(e){
     //alertJquery(e);
       }
      
    }
    
  });
  
}
  

function DocumentoOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_documento").click();	
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"documento_laboral");
}

function DocumentoOnReset(formulario){
	Reset(formulario);
    clearFind(); 
	$("#estado").val('A');
	$('#documento_laboral_id').attr("disabled","");
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function setDataContrato(contrato_id){
    
  var QueryString = "ACTIONCONTROLER=setDataContrato&contrato_id="+contrato_id;
  
  $.ajax({
    url        : "DocumentoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
  var responseArray         = $.parseJSON(response); 
  var contrato               =responseArray[0]['contrato'];
  var contrato_id            =responseArray[0]['contrato_id'];  
  $("#contrato").val(contrato);
  $("#contrato_id").val(contrato_id);
 
      }catch(e){
     //alertJquery(e);
       }
      
    }
    
  });
  
}

$(document).ready(function(){
						   
  $("#estado").change(function(){

      if(this.value == 'F'){
		
		$("#causal_despido_id").addClass("obligatorio");	
		$("#causal_despido_id").addClass("requerido");	
		
	  }else{		  
	   				  
		 
 		 $("#causal_despido_id").removeClass("obligatorio");		 
 		 $("#causal_despido_id").removeClass("requerido");		 		 
		 
	    }
});
						   
///INICIO VALIDACION FECHAS DE REPORTE
 
 $('#fecha_terminacion').change(function(){

    var fechat = $('#fecha_terminacion').val();
    var fechai = $('#fecha_inicio').val();
	var today = new Date();

    if ((Date.parse(fechat) < Date.parse(fechai)) || (Date.parse(fechat)>today)) {
     alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
     return this.value = $('#fecha_inicio').val();
    };
 });
 
  $('#fecha_terminacion_real').change(function(){

    var fechat = $('#fecha_terminacion_real').val();
    var fechai = $('#fecha_inicio').val();
	var today = new Date();

    if ((Date.parse(fechat) < Date.parse(fechai)) || (Date.parse(fechat)>today)) {
     alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
     return this.value = $('#fecha_inicio').val();
    };
 });
 
 ///FIN VALIDACION FECHAS DE REPORTE

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('DocumentoForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,DocumentoOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,DocumentoOnSaveOnUpdateonDelete)
			}
		}
		
		
	});
});

function beforePrint(){
	
   var documento_laboral_id = parseInt(document.getElementById("documento_laboral_id").value);
      
   if(isNaN(documento_laboral_id)){
     alertJquery("Debe Seleccionar un Contrato !!","Impresion Contrato"); 
     return false;
   }else{
      return true;
    }
  
  
}