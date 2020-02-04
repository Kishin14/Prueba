// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#prueba_id').val();
	var parametros  = new Array({campos:"prueba_id",valores:parametrosId});
	var formulario       = document.forms[0];
	var controlador = 'PruebaClass.php';

	
	FindRow(parametros,formulario,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}

function PruebaOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_prueba").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function setDataConvocado(convocado_id){
    
  var QueryString = "ACTIONCONTROLER=setDataConvocado&convocado_id="+convocado_id;
  
  $.ajax({
    url        : "PruebaClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
 
  var responseArray         = $.parseJSON(response); 
  var convocado               =responseArray[0]['convocado'];
  var convocado_id            =responseArray[0]['convocado_id'];  
  $("#convocado").val(convocado);
  $("#convocado_id").val(convocado_id);
 
      }catch(e){
     //alertJquery(e);
       }
      
    }
    
  });
  
}



function PruebaOnReset(formulario){
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
		var formulario = document.getElementById('PruebaForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,PruebaOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,PruebaOnSaveOnUpdateonDelete)
			}
		}
	});
});