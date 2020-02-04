// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    // var tipo_contratoId = $('#tipo_contrato_id').val();
    RequiredRemove();

    var tipo_vehiculo_nomina  = new Array({campos:"vehiculo_nomina_id",valores:$('#vehiculo_nomina_id').val()});
	var forma       = document.forms[0];
	var controlador = 'TipoVehiculoClass.php';

	FindRow(tipo_vehiculo_nomina,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function TipoVehiculoOnSaveOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_tipo_vehiculo_nomina").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"TipoVehiculos");
}
function TipoVehiculoOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  var formulario = document.getElementById('TipoVehiculoForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){
				 formSubmitted = true;
				 Send(formulario,'onclickSave',null,TipoVehiculoOnSaveOnUpdate);
			}
		}else{
			Send(formulario,'onclickUpdate',null,TipoVehiculoOnSaveOnUpdate);
		}	
	
	formSubmitted = false;
  
  });

});
	
