// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#concepto_area_id').val();
	var parametros  = new Array({campos:"concepto_area_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'ContableClass.php';

	
	FindRow(parametros,forma,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		var data           = $.parseJSON(resp);	
		
		if(data[0]['contabiliza']=='SI'){
	    	$("#puc_partida,#puc_partida_id,#puc_contra,#puc_contra_id,#naturaleza_partida,#naturaleza_contra").addClass("obligatorio");
	    	$("#puc_partida,#puc_contra,#naturaleza_partida,#naturaleza_contra").attr("disabled","");			
		}else{
			 $("#puc_partida,#puc_partida_id,#puc_contra,#puc_contra_id,#naturaleza_partida,#naturaleza_contra").removeClass("obligatorio");
			 $("#puc_partida,#puc_partida_id,#puc_contra,#puc_contra_id,#naturaleza_partida,#naturaleza_contra").val("");
 	    	 $("#puc_partida,#puc_contra,#naturaleza_partida,#naturaleza_contra").attr("disabled","true");
		}

	}); 
  
}

function showTable(){
  
	var frame_grid =  document.getElementById('frame_grid');
	
	  //Se valida que el iFrame no exista
	  if(frame_grid == null ){
  
	  var QueryString   = 'ACTIONCONTROLER=showGrid';
  
	  $.ajax({
		url        : "ContableClass.php?rand="+Math.random(),
		data       : QueryString,
		 async     :false,
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

function ContableOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_concepto_area").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function ContableOnReset(formulario){
	 Reset(formulario);
    clearFind();  
    setFocusFirstFieldForm(formulario); 
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");

	 $("#puc_partida,#puc_partida_id,#puc_contra,#puc_contra_id,#naturaleza_partida,#naturaleza_contra").removeClass("obligatorio");
	 $("#puc_partida,#puc_partida_id,#puc_contra,#puc_contra_id,#naturaleza_partida,#naturaleza_contra,#busqueda").val("");
	 $("#puc_partida,#puc_contra,#naturaleza_partida,#naturaleza_contra").attr("disabled","true");

}

$(document).ready(function(){

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('ContableForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,ContableOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,ContableOnSaveOnUpdateonDelete)
			}
		}
	});
	
	$("#contabiliza").change(function(){  
		if(this.value=='SI'){
	    	$("#puc_partida,#puc_partida_id,#puc_contra,#puc_contra_id,#naturaleza_partida,#naturaleza_contra").addClass("obligatorio");
	    	$("#puc_partida,#puc_contra,#naturaleza_partida,#naturaleza_contra").attr("disabled","");			
		}else{
			 $("#puc_partida,#puc_partida_id,#puc_contra,#puc_contra_id,#naturaleza_partida,#naturaleza_contra").removeClass("obligatorio");
			 $("#puc_partida,#puc_partida_id,#puc_contra,#puc_contra_id,#naturaleza_partida,#naturaleza_contra").val("");
 	    	 $("#puc_partida,#puc_contra,#naturaleza_partida,#naturaleza_contra").attr("disabled","true");
		}
										   
   });
	
});