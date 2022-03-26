// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#empleado_id').val();
	RequiredRemove();
	var parametros  = new Array({campos:"empleado_id",valores:$('#empleado_id').val()});
	var forma       = document.forms[0];
	var controlador = 'EmpleadoClass.php';

	
	FindRow(parametros,forma,controlador,null,function(resp){

	  var data              = $.parseJSON(resp);
      var empleado_id = data[0]['empleado_id']; 

	  document.getElementById('HijosEmpleado').src = 'HijosEmpleadoClass.php?empleado_id='+empleado_id;
	  document.getElementById('ConyugeEmpleado').src = 'ConyugeEmpleadoClass.php?empleado_id='+empleado_id;
	  document.getElementById('EstudiosEmpleado').src = 'EstudiosEmpleadoClass.php?empleado_id='+empleado_id;
     // $('#tercero_id').attr("disabled","true");
      //$('#tercero').attr("disabled","true");	  

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
		url        : "EmpleadoClass.php?rand="+Math.random(),
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

function setcargaDatos(convocado_id){
	
    
  var QueryString = "ACTIONCONTROLER=setcargaDatos&convocado_id="+convocado_id;
  
  $.ajax({
    url        : "EmpleadoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray       = $.parseJSON(response); 
		var covocado_id         = responseArray[0]['convocado_id'];
		var primer_nombre       = responseArray[0]['primer_nombre'];
		var segundo_nombre      = responseArray[0]['segundo_nombre'];
		var primer_apellido     = responseArray[0]['primer_apellido'];		
		var segundo_apellido    = responseArray[0]['segundo_apellido'];		
		var numero_identificacion    = responseArray[0]['numero_identificacion'];		

		
		$("#convocado_id").val(convocado_id);
		$("#primer_nombre").val(primer_nombre);
		$("#segundo_nombre").val(segundo_nombre);		
		$("#primer_apellido").val(primer_apellido);	
		$("#segundo_apellido").val(segundo_apellido);			
		$("#numero_identificacion").val(numero_identificacion);
		closeDialog();
	
      }catch(e){
	  alertJquery(e);
       }
      
    }
    
  }); 

	
}
	
function closeDialog(){ 
	$("#divSolicitudConvocado").dialog('close');
}

function EmpleadoOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_empleado").click();
	resetDetalle('HijosEmpleado');
	resetDetalle('ConyugeEmpleado');
	resetDetalle('EstudiosEmpleado');
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Empleado");
}


function setDataProfesion(profesion_id){
    
  var QueryString = "ACTIONCONTROLER=setDataProfesion&profesion_id="+profesion_id;
  
  $.ajax({
    url        : "EmpleadoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray         = $.parseJSON(response); 
		var profesion               =responseArray[0]['profesion'];
		var profesion_id            =responseArray[0]['profesion_id'];		
		$("#profesion").val(profesion);
		$("#profesion_id").val(profesion_id);
	
      }catch(e){
	  		//alertJquery(e);
       }
      
    }
    
  });
  
}


function EmpleadoOnReset(formulario){
	 Reset(formulario);
    clearFind();  
    setFocusFirstFieldForm(formulario); 
    resetDetalle('HijosEmpleado');
    resetDetalle('ConyugeEmpleado');
    resetDetalle('EstudiosEmpleado');
	   $('#tercero_id').attr("disabled","");
      $('#tercero').attr("disabled","");
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

$(document).ready(function(){

  $("#saveDetalles").click(function(){
    window.frames[1].saveDetallesSoliServi();
  });
    
  $("#deleteDetalles").click(function(){
    window.frames[1].deleteDetallesSoliServi();
  });  

  $("#saveDetalles2").click(function(){
    window.frames[2].saveDetallesSoliServi2();
  });
    
  $("#deleteDetalles2").click(function(){   
    window.frames[2].deleteDetallesSoliServi2();
  }); 

  $("#saveDetalles3").click(function(){
    window.frames[3].saveDetallesSoliServi3();
  });
    
  $("#deleteDetalles3").click(function(){
    window.frames[3].deleteDetallesSoliServi3();
	
  });
  
     $('#tercero_id').attr("disabled","");
      $('#tercero').attr("disabled","");

  resetDetalle('HijosEmpleado');
  resetDetalle('ConyugeEmpleado');
  resetDetalle('EstudiosEmpleado');
	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('EmpleadoForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,EmpleadoOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,EmpleadoOnSaveOnUpdateonDelete)
			}
		}
	});
  resetDetalle('HijosEmpleado');
  resetDetalle('ConyugeEmpleado');
  resetDetalle('EstudiosEmpleado');


  $("#impConv").click(function(){
		
	    // var formulario = document.getElementById('RemesasForm');		
	    // Reset(formulario);
	    // RemesasOnReset();	

										
	    $("#divImpConv").dialog({
		    title: 'Importar Convocado',
		    width: 950,
		    height: 395,
		    closeOnEscape:true,
		    show: 'scale',
		    hide: 'scale'
	    });
	    
	    //$("#divImpConv").parent().fadeIn();					
	});


 $("#convocado_id").val("");


 $(".selConv").click(function(){
 	numero_identificacion=$(this).find(".numero_identificacion").html();
 	primer_nombre=$(this).find(".primer_nombre").html();
 	segundo_nombre=$(this).find(".segundo_nombre").html();
 	primer_apellido=$(this).find(".primer_apellido").html();
 	segundo_apellido=$(this).find(".segundo_apellido").html();
 	direccion=$(this).find(".direccion").html();
 	telefono=$(this).find(".telefono").html();
 	movil=$(this).find(".movil").html();
 	convocado_id=$(this).find(".convocado_id").html();

 	$("#divImpConv").parent().fadeOut(1500);	

 	$("#convocado_id").val(convocado_id);
 	$("#nombrecomp").val(primer_nombre+" "+segundo_nombre+" "+primer_apellido+" "+segundo_apellido);
 	$("#trnombrecomp").fadeIn(1000);
 });
 
  /**
    * cargamos el grid con las solicitudes de servicio
    */
    $("#iframeSolicitudConvocado").attr("src","SolicServConvocadoClass.php");	
    
    $("#importConvocado").click(function(){
		
        var formulario = document.getElementById('EmpleadoForm');		
        Reset(formulario);	
        //RemesasOnReset();						
										
	    $("#divSolicitudConvocado").dialog({
		    title: 'Convocados a Importar',
		    width: 950,
		    height: 395,
		    closeOnEscape:true,
		    show: 'scale',
		    hide: 'scale'
	    });
    });
 

						   
  $("#tipo_identificacion_id").change(function(){
    calculaDigitoTercero();
  });
  
  $("#numero_identificacion").blur(function(){

     var tercero_id            = $("#tercero_id").val();
     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});
	 
	 if(!tercero_id.length > 0){
	 
       validaRegistro(this,params,"EmpleadoClass.php",null,function(resp){    
																  																  
         if(parseInt(resp) != 0 ){
           var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
           var formulario = document.forms[0];
           var url        = 'EmpleadoClass.php';

           FindRow(params,formulario,url,null,function(resp){
													   
		   var data = $.parseJSON(resp);
		   //ocultaFilaNombresRazon(data[0]['tipo_persona_id']);	     
													   
													 
           clearFind();		 
		 
	  	   $('#guardar').attr("disabled","true");
           $('#actualizar').attr("disabled","");
           $('#borrar').attr("disabled","");
           $('#limpiar').attr("disabled","");	
													 
           });
		 
	    }else{	   		  
            //calculaDigitoTercero();				  
		    $('#guardar').attr("disabled","");
            $('#actualizar').attr("disabled","true");
            $('#borrar').attr("disabled","true");
            $('#limpiar').attr("disabled","");
		   }
       });
	 
	 }
  
  });
  
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('EmpleadoForm');
	  
	  if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,EmpleadoOnSaveOnUpdateonDelete)
		}else{
            Send(formulario,'onclickUpdate',null,EmpleadoOnSaveOnUpdateonDelete)
		  }
	  }
	  	  
  });
  $("#tipo_persona_id").change(function(){
    //ocultaFilaNombresRazon(this.value);
    
  });
  



});



