// JavaScript Document
$(document).ready(function(){

	var novedad_fija_id = $("#novedad_fija_id").val();

	if (novedad_fija_id.length > 0) {
		setDataFormWithResponse();
	}

  resetDetalle('detalleNovedad');
  $("#saveDetalles").click(function(){
    window.frames[0].saveDetallesSoliServi();
  });
    
  $("#deleteDetalles").click(function(){
    window.frames[0].deleteDetallesSoliServi();
  });  
  
  $("#valor").blur(function(){
    var cuotas = removeFormatCurrency($("#cuotas").val());
	var valor  = removeFormatCurrency($("#valor").val());
	if(cuotas>0 && valor>0){
		
		valor_cuota = (valor*1)/(cuotas*1);
		
		$("#valor_cuota").val(setFormatCurrency(valor_cuota));
		
	}
  });
  
  $("#cuotas").blur(function(){
    var cuotas = removeFormatCurrency($("#cuotas").val());
	var valor  = removeFormatCurrency($("#valor").val());
	if(cuotas>0 && valor>0){
		
		valor_cuota = (valor*1)/(cuotas*1);
		
		$("#valor_cuota").val(setFormatCurrency(valor_cuota,2));
		
	}
  });

   $("#estado").change(function(){ 

		var estado = $('#estado').val();
		if(estado == 'P'){
			$('#estado').val('A');
			alertJquery('No se puede cambiar a estado <strong>Procesado</strong> ya que este es automatico.','Atención')
		}
	});

  resetDetalle('detalleNovedad');

  /* Validar el cruce de novedades y contratos con las fechas */

  $("#fecha_inicial,#fecha_final,#concepto_area_id,#contrato").blur(function (){

	var fecha_inicial    = $("#fecha_inicial").val();
	var fecha_final      = $("#fecha_final").val();
	var concepto_area_id = $("#concepto_area_id").val();
	var novedad_fija_id  = $("#novedad_fija_id").val();
	var contrato         = $("#contrato_hidden").val();
	 
	if (fecha_inicial != "" && fecha_final != "" && concepto_area_id != 'NULL' && novedad_fija_id == '' && contrato != '') {

		var QueryString   = 'ACTIONCONTROLER=validarFechas&fecha_inicial='+fecha_inicial+'&fecha_final='
		+fecha_final+"&contrato="+contrato;

		$.ajax({
			url        : "NovedadClass.php?rand="+Math.random(),
			data       : QueryString,
			
			success    : function(resp){
				try{

				var data = $.parseJSON(resp);
				
				if(resp != 'null' && data.length > 0){

					var Novedades = '';

					for (var i = 0; i < data.length; i++) {

						Novedades = Novedades + '\n' + data[i]["descripcion"]+'.     (<b>Fecha Inc.  </b>'+data[i]["fecha_inicial"]+'  <b> - Fecha Fin.  </b> '+fecha_final+')';
						
					}

					jConfirm("Las siguientes novedades se encuentran en el rango de fechas "
					+fecha_inicial+" y "+fecha_final+" : \n" 
					+ Novedades ,"Alerta !!", 
					 
					function(r) {

					if(!r) {  

					$("#fecha_inicial").val('');
					$("#fecha_final").val('');
									
													
					} else { 
					return true;
					}	

					}); 

				}

				}catch(e){

				alertJquery("Se presento un error :"+e,"Try Catch");

				}
			} 
		});

  	}
	
  });
  
});


function showTable(){
  
	var frame_grid =  document.getElementById('frame_grid');
	
	  //Se valida que el iFrame no exista
	  if(frame_grid == null ){
  
	  var QueryString   = 'ACTIONCONTROLER=showGrid';
  
	  $.ajax({
		url        : "NovedadClass.php?rand="+Math.random(),
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



function Empleado_si(){
	if($('#si_empleado').val()==1){
		
		  if($('#contrato'))    $('#contrato').attr("disabled","");	
		  $("#contrato").addClass("obligatorio");
		  
	}else if($('#si_empleado').val()=='ALL'){
		
		  if($('#contrato'))    $('#contrato').attr("disabled","true");
		  $('#contrato').val('');
		  $('#contrato_hidden').val('');
 		  $("#contrato").removeClass("obligatorio");
		  $("#contrato_hidden").removeClass("obligatorio");
		  
	}

}

function NovedadOnSave(formulario,resp){

  	try{
		resp = $.parseJSON(resp);
		
		if($.isArray(resp)){
					
			$("#novedad_fija_id").val(resp[0]['novedad_fija_id']);
			$("#doc_contable").val(resp[0]['consecutivo']);
			
			var novedad_fija_id = $('#novedad_fija_id').val();
			var url 		= "DetalleNovedadClass.php?novedad_fija_id="+novedad_fija_id;
			
			$("#detalleNovedad").attr("src",url);
			
			if($('#guardar'))    $('#guardar').attr("disabled","true");
			if($('#actualizar')) $('#actualizar').attr("disabled","");
			if($('#limpiar'))    $('#limpiar').attr("disabled","");
			$("#refresh_QUERYGRID_novedad").click();			
			alertJquery("Se ingreso Exitosamente la Novedad","Registrar Novedad");
		
		}else{
			alertJquery("Ocurrio una inconsistencia : "+resp,"Registrar Novedad");
		}
	
    }catch(e){
		 alertJquery(e,"Inconsistencia Registrar Novedad");
    }
}

function NovedadOnUpdate(formulario,resp){

	try{
	resp = $.parseJSON(resp);
	
				
		$("#novedad_fija_id").val(resp[0]['novedad_fija_id']);
		
		var novedadId = $('#novedad_fija_id').val();
		var url 	  = "DetalleNovedadClass.php?novedad_fija_id="+novedadId;
		
		$("#detalleNovedad").attr("src",url);
		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		if($('#imprimir')) 	 $('#imprimir').attr("disabled",""); 		
			
		alertJquery("Ocurrio una inconsistencia : "+resp);
	
       }catch(e){
		parent.document.getElementById("detalleNovedad").contentWindow.location.reload(true);
	 	alertJquery(e);
	}
}
function NovedadOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
	$("#detalleNovedad").attr("src","../../../framework/tpl/blank.html");	
    /*setFocusFirstFieldForm(formulario);	
    resetDetalle('detalleNovedad');	*/
	
	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function setDataFormWithResponse(){
	
	var novedad_fija_id = $('#novedad_fija_id').val();
	
	var parametros  = new Array ({campos:"novedad_fija_id", valores:$('#novedad_fija_id').val()});	
    var forma 	    = document.forms[0];
    var controlador = 'NovedadClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var novedadId = novedad_fija_id;
      var url 	    = "DetalleNovedadClass.php?novedad_fija_id="+novedadId;
      
      $("#detalleNovedad").attr("src",url);
      
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
      	    
    });
}

function beforePrint(){
	
   var novedad_fija_id = parseInt(document.getElementById("novedad_fija_id").value);
      
   if(isNaN(novedad_fija_id)){
     alertJquery("Debe Seleccionar una Novedad!!","Impresion Novedad"); 
     return false;
   }else{
      return true;
    }
  
  
}