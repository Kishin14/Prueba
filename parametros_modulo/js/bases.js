// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#id_datos').val();
	var parametros  = new Array({campos:"id_datos",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'BasesClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}

function BasesOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_Bases_Salariales").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function onclickDuplicar(){
	
	if($("#divAnulacion").is(":visible")){

	   var formulario 				= document.forms[0];
	   var sub_nuevo 				= $("#sub_nuevo").val();
	   var salario_nuevo  			= $("#salario_nuevo").val();
	   var periodo_contable_nuevo   = $("#periodo_contable_nuevo").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickDuplicar&"+FormSerialize(formulario)+"&sub_nuevo="+sub_nuevo+"&salario_nuevo="+salario_nuevo+"&periodo_contable_nuevo="+periodo_contable_nuevo;
		
	     $.ajax({
           url  : "BasesClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Duplicación de Ley Exitosa!','Parametros Ley');
				 $("#refresh_QUERYGRID_Bases_Salariales").click();
				 Reset(formulario);
				 clearFind();	
			 }else{
				   alertJquery(response,'Inconsistencia Duplicando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	   
	     });
	   
	   }
	
    }else{
		
		var id_datos 		= $("#id_datos").val();
		if(parseInt(id_datos) > 0){	
			
	
	 /* var estado   = $("#estado").val();
	 

	 var QueryString = "ACTIONCONTROLER=onclickDuplicar&factura_id="+factura_id;
	 
	 $.ajax({
       url        : "BasesClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'A' || $.trim(estado) == 'C'){ */
			   
		    $("#divAnulacion").dialog({
			  title: 'Duplicar Parametros',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
			
		  /*  }else{
		      alertJquery('Solo se permite anular Facturas en estado : <b>ACTIVO/CONTABILIZADO</b>','Anulacion');			   
		   }   */
			 
	     removeDivLoading();			 
	    //  }
		 
	//  });
	 
		
		}else{
		alertJquery('Debe Seleccionar primero un Parametro','Duplicar');
	  	}	
		
	}  
}

function BasesOnReset(formulario){
	return true;
	//  Reset(formulario);
 //    clearFind();  
 //    setFocusFirstFieldForm(formulario); 
	// if($('#guardar'))    $('#guardar').attr("disabled","");
	// if($('#actualizar')) $('#actualizar').attr("disabled","true");
	// if($('#borrar'))     $('#borrar').attr("disabled","true");
	// if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

$(document).ready(function(){

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('BasesForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,BasesOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,BasesOnSaveOnUpdateonDelete)
			}
		}
	});
});