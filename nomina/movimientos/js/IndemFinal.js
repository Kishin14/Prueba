// JavaScript Document
$(document).ready(function(){
	linkDetallesSolicitud();	
});



function saveDetalleSolicitud(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var  Celda                    		= obj.parentNode;
	  var  Fila                     		= Celda.parentNode;
	  var  Tabla                    		= Fila.parentNode;

	  var  detalle_liquidacion_novedad_id	= $(Fila).find("input[name=detalle_liquidacion_novedad_id]").val();
	  
	  var  observacion                = $(Fila).find("input[name=observacion]").val();	  
	  var checkProcesar            = $(Fila).find("input[name=procesar]");
	
       
	if( $('#actualizar',parent.document).length > 0 ){
	  
		var QueryString = "ACTIONCONTROLER=onclickUpdate&detalle_liquidacion_novedad_id="+detalle_liquidacion_novedad_id+"&observacion="+observacion;
		
		$.ajax({
			url        : "IndemFinalClass.php",
			data       : QueryString,
			beforeSend : function(){
			  setMessageWaiting();
			},
			success    : function(response){
			  
			    if( $.trim(response) == 'true'){
				    
			      checkProcesar.attr("checked","");
			      $(Celda).removeClass("focusSaveRow");
			      updateGrid();
			      setMessage('Se Actualizo exitosamente.');				    
			    }else{
				    alert(response);
			    }
			   
		       
		       }
		});
		
	}//find el permiso de actalizar
	
     
  }//fin de validaRequeridosDetalle	
  
}




function saveDetallesSoliServi(){
	
	$("input[name=procesar]:checked").each(function(){
	
		saveDetalleSolicitud(this);
	
	});

}

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesSolicitud(){

	$("a[name=saveDetalleSoliServi]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleSoliServi]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleSoliServi]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleSoliServi]").click(function(){
		saveDetalleSolicitud(this);
    });
	
}