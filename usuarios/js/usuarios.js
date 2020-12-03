// JavaScript Document

function setDataFormWithResponse(){
	
RequiredRemove();

var params     = new Array({campos:"tercero_id",valores:$('#tercero_id').val()});
var formulario = document.forms[0];
var url        = 'UsuariosClass.php';

FindRow(params,formulario,url,null,null);

if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
      url        : "UsuariosClass.php?rand="+Math.random(),
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

function UsuarioOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();   
   
   $("#refresh_QUERYGRID_terceros").click();
   $("#tipo_persona_id").val(1);
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	   
   
   	alertJquery(resp,"Usuarios");
	
}

function usuarioOnReset(formulario){
	
	Reset(formulario);
	clearFind();
	
	$("#tipo_persona_id").val(1);
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function ValidaOtrosTercero(Forma){
	
  var Pnombre     = Forma.primer_nombre;
  var Snombre     = Forma.segundo_nombre;
  var Papellido   = Forma.primer_apellido;
  var Sapellido   = Forma.segundo_apellido;
  
  if(vacio(Pnombre.value) && vacio(Snombre.value) && vacio(Papellido.value) && vacio(Sapellido.value) ){
	   
    alertJquery("Debe ingresar los datos descriptivos para el tercero\n\nPor ejemplo : Primer Nombre");
	return false;
	  
  }else if(!vacio(Pnombre.value)){
		  
		  if(vacio(Papellido.value)){
		   alertJquery('Debe diligenciar el campo [ PRIMER APELLIDO ]');
		   return false;
	      }
		  
		}else if(!vacio(Papellido.value)){
		  
		   if(vacio(Pnombre.value)){
		    alertJquery('Debe diligenciar el campo [ PRIMER NOMBRE ]');
		    return false;
	       }
		  
		 }
		 
  return true;
}


$(document).ready(function(){
  
  $("#numero_identificacion").blur(function(){

     var tercero_id = $("#tercero_id").val();
     var params     = new Array({campos:"numero_identificacion",valores:$("#numero_identificacion").val()});
	 
	 if(!tercero_id.length > 0){
	 
     validaRegistro(this,params,"UsuariosClass.php",null,function(resp){    
															  																  
       if(parseInt(resp) != 0 ){

         var params     = new Array({campos:"numero_identificacion",valores:$('#numero_identificacion').val()});
         var formulario = document.forms[0];
         var url        = 'UsuariosClass.php';

         FindRow(params,formulario,url);
		 
		 $('#guardar').attr("disabled","true");
         $('#actualizar').attr("disabled","");
         $('#borrar').attr("disabled","");
         $('#limpiar').attr("disabled","");		 

	   }else{
		  $('#guardar').attr("disabled","");
          $('#actualizar').attr("disabled","true");
          $('#borrar').attr("disabled","true");
          $('#limpiar').attr("disabled","");
		  }
      });
	 
	 }else{
 		  //$('#guardar').attr("disabled","");
          //$('#actualizar').attr("disabled","true");
          //$('#borrar').attr("disabled","true");
          //$('#limpiar').attr("disabled","");
		}
  
  });
    
  
});
	
