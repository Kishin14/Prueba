// JavaScript Document
/*function setDataFormWithResponse(){
	var parametrosId = $('#causal_desempeno_empleado_id').val();
	var parametros  = new Array({campos:"causal_desempeno_empleado_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'DesempenoClass.php';

	
	FindRow(parametros,forma,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}*/

function setDataFormWithResponse(){
    var causal_desempeno_empleado_id = $('#causal_desempeno_empleado_id').val();
    RequiredRemove();

    var causal  = new Array({campos:"causal_desempeno_empleado_id",valores:$('#causal_desempeno_empleado_id').val()});
 var forma       = document.forms[0];
 var controlador = 'DesempenoClass.php';

 FindRow(causal,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");   
    });


}

function DesempenoOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_desempeno").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function setDataEmpleado(empleado_id){
    
  var QueryString = "ACTIONCONTROLER=setDataEmpleado&empleado_id="+empleado_id; 
  
  $.ajax({
    url        : "DesempenoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
  var responseArray         = $.parseJSON(response); 
  var empleado               =responseArray[0]['empleado'];
  var empleado_id            =responseArray[0]['empleado_id'];  
  $("#empleado").val(empleado);
  $("#empleado_id").val(empleado_id);
 
      }catch(e){
     //alertJquery(e);
       }
      
    }
    
  });
  
}

function DesempenoOnReset(formulario){
	 Reset(formulario);
    clearFind();  
    setFocusFirstFieldForm(formulario); 
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

$(document).ready(function(){

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('DesempenoForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,DesempenoOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,DesempenoOnSaveOnUpdateonDelete)
			}
		}
	});
});