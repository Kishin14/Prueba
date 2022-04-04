// JavaScript Document

function setDataFormWithResponse(){
	
var NumeroId = $('#busqueda').val().split("-");

$('#numero_identificacion').val(NumeroId[0]);

RequiredRemove();

FindRow([{campos:"numero_identificacion",valores:NumeroId[0],botones:"guardar,actualizar,borrar,restaurar"}],document.forms[0],"TercerosClass.php","../../../framework/media/images/forms/load.gif");

if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function ValidarTercero(){
if($('#guardar'))    $('#guardar').attr("disabled","");
if($('#actualizar')) $('#actualizar').attr("disabled","true");
if($('#borrar'))     $('#borrar').attr("disabled","true");
if($('#limpiar'))    $('#limpiar').attr("disabled","true");
}

function TerceroOnSaveUpdate(resp){

    $("#refresh_QUERYGRID_terceros").click();

    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","true");
	
}

function TerceroOnDelete(resp){

   Reset(document.getElementById('TercerosForm'));
   $("#refresh_QUERYGRID_terceros").click();
   
}

function ValidaOtrosTercero(Forma){
	
  var Pnombre     = Forma.primer_nombre;
  var Snombre     = Forma.segundo_nombre;
  var Papellido   = Forma.primer_apellido;
  var Sapellido   = Forma.segundo_apellido;
  var Sigla       = Forma.sigla;
  var RazonSocial = Forma.razon_social;
  
  if(vacio(Pnombre.value) && vacio(Snombre.value) && vacio(Papellido.value) && vacio(Sapellido.value) && vacio(Sigla.value) 
  && vacio(RazonSocial.value)){
	   
    alert("Debe ingresar los datos descriptivos para el tercero\n\nPor ejemplo : Primer Nombre o  Razon Social");
	return false;
	  
  }else if(!vacio(RazonSocial.value)){
	  
	  if(vacio(Sigla.value)){
		  alert('Debe diligenciar el campo [ Sigla ]');
		  return false;
	   }else{
          Pnombre.value   = '';
		  Snombre.value   = '';
		  Papellido.value = '';
		  Sapellido.value = '';
		}
		
	}else if(!vacio(Sigla.value)){
		
	   if(vacio(RazonSocial.value)){
		  alert('Debe diligenciar el campo [ RAZON SOCIAL ]');
		  return false;
	   }else{
          Pnombre.value   = '';
		  Snombre.value   = '';
		  Papellido.value = '';
		  Sapellido.value = '';
		}
		
	  }else if(!vacio(Pnombre.value)){
		  
		  if(vacio(Papellido.value)){
		   alert('Debe diligenciar el campo [ PRIMER APELLIDO ]');
		   return false;
	      }else{
              Sigla.value       = '';
	    	  RazonSocial.value = '';
		    }
		
		}else if(!vacio(Papellido.value)){
		  
		   if(vacio(Pnombre.value)){
		    alert('Debe diligenciar el campo [ PRIMER NOMBRE ]');
		    return false;
	       }else{
              Sigla.value       = '';
	    	  RazonSocial.value = '';
		    }
		  
		 }
		 
  return true;
}

function ValidaTercero(response){
	
	if(response == '0'){
      if($('#guardar'))    $('#guardar').attr("disabled","");
      if($('#actualizar')) $('#actualizar').attr("disabled","true");
      if($('#borrar'))     $('#borrar').attr("disabled","true");
      if($('#limpiar'))    $('#limpiar').attr("disabled","true");
    }
	
}