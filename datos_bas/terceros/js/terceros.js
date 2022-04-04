// JavaScript Document

function setDataFormWithResponse(){
	auto();
RequiredRemove();

FindRow([{campos:"tercero_id",valores:$('#tercero_id').val()}],document.forms[0],'TercerosClass.php',null,function(resp){
  
  var data = $.parseJSON(resp);
  
  ocultaFilaNombresRazon(data[0]['tipo_persona_id']);
  
  
});

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
      url        : "TercerosClass.php?rand="+Math.random(),
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

function TerceroOnSaveOnUpdateonDelete(formulario,resp){

	if((parseInt(resp)>0) || (resp=='Se ingreso correctamente un nuevo tercero.') || (resp=='Se actualizo correctamente el tercero.')){
		Reset(formulario);
		clearFind();
		$("#refresh_QUERYGRID_terceros").click();
		$("#estado").val("B");
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	   alertJquery(resp,"Validacion Terceros");
	}else{
	   alertJquery(resp,"Validacion Terceros");
	}
   
}
function tercerosOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
	$("#estado").val("B");
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function auto(){

  $("#autoret_proveedor").change(function(){
    
	if(document.getElementById("autoret_proveedor").value=='S'){
		document.getElementById("regimen_id").options[3].disabled = false;	
		document.getElementById("regimen_id").options[4].disabled = false;	
		//document.getElementById('regimen_id').disabled=true;  
	}
	else if(document.getElementById("autoret_proveedor").value=='N'){
		document.getElementById("regimen_id").options[3].disabled = true;	
		document.getElementById("regimen_id").options[4].disabled = true;	
	}    
  });

}

$(document).ready(function(){
	auto();					   
  $("#tipo_identificacion_id").change(function(){
    calculaDigitoTercero();
  });
  
  $("#numero_identificacion").blur(function(){

     var tercero_id            = $("#tercero_id").val();
     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});
	 
	 if(!tercero_id.length > 0){
	 
       validaRegistro(this,params,"TercerosClass.php",null,function(resp){    
																  																  
         if(parseInt(resp) != 0 ){
           var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
           var formulario = document.forms[0];
           var url        = 'TercerosClass.php';

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
         Send(formulario,'onclickSave',null,TerceroOnSaveOnUpdateonDelete)
		}else{
            Send(formulario,'onclickUpdate',null,TerceroOnSaveOnUpdateonDelete)
		  }
	  }
	  	  
  });
  
  $("#tipo_persona_id").change(function(){
    
    ocultaFilaNombresRazon(this.value);
    
  });

});
	
