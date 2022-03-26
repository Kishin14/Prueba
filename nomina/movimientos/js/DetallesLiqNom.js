// JavaScript Document
$(document).ready(function(){
	linkDetallesSolicitud();
});

function saveDetalleSolicitud(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                    = obj.parentNode;
	  var Fila                     = Celda.parentNode;
	  var Tabla                    = Fila.parentNode;
	  var liquidacion_nomina_id    = $("#liquidacion_nomina_id").val();
	  var detalle_liquidacion_nomina_id	= $(Fila).find("input[name=detalle_liquidacion_nomina_id]").val();	  
	  var  debito           	= $(Fila).find("input[name=debito]").val();
	  var  credito              = $(Fila).find("input[name=credito]").val();
	  var checkProcesar            = $(Fila).find("input[name=procesar]");
	
	  if(detalle_liquidacion_nomina_id.length > 0){
       
	  if( $('#actualizar',parent.document).length > 0 ){
	  
		var QueryString = "ACTIONCONTROLER=onclickUpdate&detalle_liquidacion_nomina_id="+detalle_liquidacion_nomina_id+"&debito="+debito+"&credito="+credito;
		
		$.ajax({
			url        : "DetallesLiqNomClass.php",
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
	
     }//fin detalle_ss_id.length
  }//fin de validaRequeridosDetalle	
  
}


function deleteDetalleSolicitud(obj){
	
	var Celda         = obj.parentNode;
	var Fila          = obj.parentNode.parentNode;
	var liquidacion_nomina_id  = $("#liquidacion_nomina_id").val();
	var detalle_liquidacion_nomina_id = $(Fila).find("input[name=detalle_liquidacion_nomina_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&liquidacion_nomina_id="+liquidacion_nomina_id+"&detalle_liquidacion_nomina_id="+detalle_liquidacion_nomina_id;
	
	if(detalle_liquidacion_nomina_id.length > 0){
		if( $('#borrar',parent.document).length > 0 ){
			$.ajax({
				   
				url        : "DetallesLiqNomClass.php",
				data       : QueryString,
				beforeSend : function(){
				  setMessageWaiting();
				},
				success    : function(response){
				  				  
					if( $.trim(response) == 'true'){
						
						$(Fila).remove();
						updateGrid();
						setMessage('Se borro exitosamente.'); 
						
					}else{
						alert(response);
					}
					
				    
				}
			});
		}
	}else{
		setMessage('No puede eliminar elementos que no han sido guardados');
		$(Fila).find("input[name=procesar]").attr("checked","");
	}
}


function saveDetallesSoliServi(){
	
	$("input[name=procesar]:checked").each(function(){
		saveDetalleSolicitud(this);
	});

}

function deleteDetallesSoliServi(){
  
	$("input[name=procesar]:checked").each(function(){
		deleteDetalleSolicitud(this);
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