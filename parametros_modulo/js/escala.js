// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var escalaId = $('#escala_salarial_id').val();
    RequiredRemove();

    var escala  = new Array({campos:"escala_salarial_id",valores:$('#escala_salarial_id').val()});
	var forma       = document.forms[0];
	var controlador = 'EscalaClass.php';

	FindRow(escala,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function EscalaOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_escala_salarial").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Escala");
}
function EscalaOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('EscalaForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,EscalaOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,EscalaOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });
  
  $("#periodo_contable_id").change(function(){
		uvt();		
	});

  $("#minimo").blur(function(){
		uvt();		
	});
  $("#maximo").blur(function(){
		uvt();		
	});

});

function uvt(){

		var periodo_contable_id     =  $("#periodo_contable_id").val();
		var minimo   				=  $("#minimo").val();
		var maximo   				=  $("#maximo").val();
		var pesos_minimo   			=  $("#pesos_minimo").val();
		var pesos_maximo   			=  $("#pesos_maximo").val();
		
	if(parseInt(periodo_contable_id)>0){
    	  var QueryString   = "ACTIONCONTROLER=getuvt&periodo_contable_id="+periodo_contable_id;
	      
				      
	      $.ajax({
		      url        : "EscalaClass.php",
		      data       : QueryString,
		      beforeSend : function(){

		      },
		      success    : function(response){
				var uvt_nominal = response;
				if(parseFloat(uvt_nominal) > 0){
					if(parseFloat(minimo)>0){
	                  var pesos_minimo = (uvt_nominal * minimo);
					  $("#pesos_minimo").val(setFormatCurrency(pesos_minimo));
						
					}

					if(parseFloat(maximo)>0){
					  var pesos_maximo = (uvt_nominal * maximo);
					  $("#pesos_maximo").val(setFormatCurrency(pesos_maximo));	
					}

				
				
				}else{
					alertJquery('No se ha parametrizado el UVT para el periodo contable.');			
				}
			 }
		      
	      });
		
		
	}else{
		alertJquery('No ha seleccionado periodo contable, por favor seleccione primero un periodo contable');
	}
}
	
