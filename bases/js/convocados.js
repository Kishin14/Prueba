// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#convocado_id').val();
	var parametros  = new Array({campos:"convocado_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'ConvocadosClass.php';

	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
	  var data              = $.parseJSON(resp);
      var convocados_id = data[0]['convocados_id'];

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}


function setDataUbicacion(ubicacion_id){
    
  var QueryString = "ACTIONCONTROLER=setDataUbicacion&ubicacion_id="+ubicacion_id;
  
  $.ajax({
    url        : "ConvocadoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
  var responseArray         = $.parseJSON(response); 
  var ubicacion               =responseArray[0]['ubicacion'];
  var ubicacion_id            =responseArray[0]['ubicacion_id'];  
  $("#ubicacion").val(ubicacion);
  $("#ubicacion_id").val(ubicacion_id);
 
      }catch(e){
     //alertJquery(e);
       }
      
    }
    
  });
  
}

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
      url        : "ConvocadosClass.php?rand="+Math.random(),
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

function ConvocadosOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_convocado_id").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function ConvocadosOnReset(formulario){
	Reset(formulario);
    clearFind();  
	 $("#estado").val('A');
	$('#convocado_id').attr("disabled","");
	$('#convocados').attr("disabled","");
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

$(document).ready(function(){

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('ConvocadosForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,ConvocadosOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,ConvocadosOnSaveOnUpdateonDelete)
			}
		}
				
	});
	
$("#numero_identificacion").blur(function(){

     var convocado_id            = $("#convocado_id").val();
     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});
  
  if(!convocado_id.length > 0){
  
       validaRegistro(this,params,"ConvocadosClass.php",null,function(resp){    
                                    
         if(parseInt(resp) != 0 ){
           var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
           var formulario = document.forms[0];
           var url        = 'ConvocadosClass.php';

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
      $('#guardar').attr("disabled","");
            $('#actualizar').attr("disabled","true");
            $('#borrar').attr("disabled","true");
            $('#limpiar').attr("disabled","");
     }
       });
  
  }
  
  });	
});