// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var tipo_documento_laboral_id = $('#tipo_documento_laboral_id').val();
    RequiredRemove();

    var tipo_documento_laboral  = new Array({campos:"tipo_documento_laboral_id",valores:$('#tipo_documento_laboral_id').val()});
	var forma       = document.forms[0];
	var controlador = 'Parametros_documentoClass.php';


	FindRow(tipo_documento_laboral,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  	  $("#variables").addClass("obligatorio");	
			$("#variables").addClass("requerido");	
			$('#variables').attr("disabled",""); 
      var data              = $.parseJSON(resp);
	  var cuerpo_mensaje = data[0]['cuerpo_mensaje'];
	  $('#cuerpo_mensaje').html(cuerpo_mensaje);
	  tinyMCE.activeEditor.setContent(''+cuerpo_mensaje+'');
	 	
	  
    });
	


}

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
      url        : "Parametros_documentoClass.php?rand="+Math.random(),
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

function CausalEvalOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_tipo_documento_laboral_id").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   	  	  $("#variables").addClass("obligatorio");	
			$("#variables").addClass("requerido");	
			$('#variables').attr("disabled","");
   alertJquery(resp,"Parametros Tipo Documento");
  CausalEvalOnReset(formulario);	
}
function CausalEvalOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
		  	  $("#variables").addClass("obligatorio");	
			$("#variables").addClass("requerido");	
			$('#variables').attr("disabled","");
	tinyMCE.activeEditor.setContent('');	
}

function tipo(){
var tipo_contrato_id=$("#tipo_contrato_id").val();
var QueryString = "ACTIONCONTROLER=onclickTipo&tipo_contrato_id="+tipo_contrato_id;

 $.ajax({
        url        : "Parametros_documentoClass.php?rand="+Math.random(),
        data       : QueryString,
        beforeSend : function(){
       showDivLoading();
        },
        success    : function(resp){
            
      try{ /*var data = resp;
	  if (data == 'true'){
		 alertJquery('no se puede seleccionar por que  ya existe un tipo ducumento con este tipo contrato',"Error : "); 		  
		 $("#tipo_contrato_id").val('');
		  }		  */
		  
		  
 }catch(e){
       alertJquery(resp,"Error : "+e);
       return false;
     }} 
       
       }); 
 removeDivLoading();
	}
	

$(document).ready(function(){
  tinymce.init({
    selector: '#cuerpo_mensaje'
	
  });
  
  	$("#variables").change(function(){
    
tinymce.activeEditor.execCommand('mceInsertContent', false, this.value);
    
  }); 
	
	 	$("#tipo_contrato_id").change(function(){    
		tipo();    
  }); 
						   
  var formulario = document.getElementById('Parametros_documentoForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				tinyMCE.triggerSave ();
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,CausalEvalOnSaveOnUpdate);
			}
		}else{
			tinyMCE.triggerSave ();
			Send(formulario,'onclickUpdate',null,CausalEvalOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});
	
