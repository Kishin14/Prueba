// JavaScript Document
$(document).ready(function(){
	autocompleteUbicacion();
	linkDetallesSolicitud();
	autocompleteRemitente();
	autocompleteDestinatario();
	
});



function saveDetalleSolicitud(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                    = obj.parentNode;
	  var Fila                     = Celda.parentNode;
	  var Tabla                    = Fila.parentNode;
	  var solicitud_id             = $("#solicitud_id").val();
	  var detalle_ss_id	           = $(Fila).find("input[name=detalle_ss_id]").val();	  
	  
	  var  detalle_ss_id           = $(Fila).find("input[name=detalle_ss_id]").val();
	  var  origen_id               = $(Fila).find("input[name=origen_id]").val();
	  var  unidad_peso_id          = $(Fila).find("select[name=unidad_peso_id]").val();
	  var  unidad_volumen_id       = $(Fila).find("select[name=unidad_volumen_id]").val();
	  var  destino_id              = $(Fila).find("input[name=destino_id]").val();
	  var  orden_despacho          = $(Fila).find("input[name=orden_despacho]").val();
	  var  shipment                = $(Fila).find("input[name=shipment]").val();	  
	  var  valor_unidad            = $(Fila).find("input[name=valor_unidad]").val();	  	
	  var checkProcesar            = $(Fila).find("input[name=procesar]");
	
	  if(!detalle_ss_id.length > 0){
	    
	    if( $('#guardar',parent.document).length > 0 ){
	      
	      detalle_ss_id   = 'NULL';
	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&detalle_ss_id="+detalle_ss_id+"&origen_id="+origen_id+"&unidad_peso_id="+unidad_peso_id+"&unidad_volumen_id="+unidad_volumen_id+"&solicitud_id="+solicitud_id+"&destino_id="+destino_id+"&orden_despacho="+orden_despacho+"&shipment="+shipment+"&remitente="+remitente+"&remitente_id="+remitente_id+"&tipo_identificacion_remitente_id="+tipo_identificacion_remitente_id+"&doc_remitente="+doc_remitente+"&direccion_remitente="+direccion_remitente+"&telefono_remitente="+telefono_remitente+"&destinatario="+destinatario+"&destinatario_id="+destinatario_id+"&tipo_identificacion_destinatario_id="+tipo_identificacion_destinatario_id+"&doc_destinatario="+doc_destinatario+"&direccion_destinatario="+direccion_destinatario+"&telefono_destinatario="+telefono_destinatario+"&referencia_producto="+referencia_producto+"&descripcion_producto="+descripcion_producto+"&cantidad="+cantidad+"&peso="+peso+"&peso_volumen="+peso_volumen+"&valor_unidad="+valor_unidad;
	      
				      
	      $.ajax({
		      url        : "DetLiqFinDedClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=detalle_ss_id]").val(response);				      
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
				      checkRow();
				      autocompleteUbicacion();
				      autocompleteRemitente();
				      autocompleteDestinatario();					  
				      linkDetallesSolicitud();
				      updateGrid();
				      setMessage('Se guardo exitosamente.');
		      
			      }else{
				      alert(response);
			      }
			      
			      
		      }
		      
	      });
	      
	}//fin del permiso de guardar
	
     }else{
       
	if( $('#actualizar',parent.document).length > 0 ){
	  
		var QueryString = "ACTIONCONTROLER=onclickUpdate&detalle_ss_id="+detalle_ss_id+"&origen_id="+origen_id+"&unidad_peso_id="+unidad_peso_id+"&unidad_volumen_id="+unidad_volumen_id+"&solicitud_id="+solicitud_id+"&destino_id="+destino_id+"&orden_despacho="+orden_despacho+"&shipment="+shipment+"&remitente="+remitente+"&remitente_id="+remitente_id+"&tipo_identificacion_remitente_id="+tipo_identificacion_remitente_id+"&doc_remitente="+doc_remitente+"&direccion_remitente="+direccion_remitente+"&telefono_remitente="+telefono_remitente+"&destinatario="+destinatario+"&destinatario_id="+destinatario_id+"&tipo_identificacion_destinatario_id="+tipo_identificacion_destinatario_id+	"&doc_destinatario="+doc_destinatario+"&direccion_destinatario="+direccion_destinatario+"&telefono_destinatario="+telefono_destinatario+"&referencia_producto="+referencia_producto+"&descripcion_producto="+descripcion_producto+"&cantidad="+cantidad+"&peso="+peso+"&peso_volumen="+peso_volumen+"&valor_unidad="+valor_unidad;
		
		$.ajax({
			url        : "DetLiqFinDedClass.php",
			data       : QueryString,
			beforeSend : function(){
			  setMessageWaiting();
			},
			success    : function(response){
			  
			    if( $.trim(response) == 'true'){
				    
			      checkProcesar.attr("checked","");
			      $(Celda).removeClass("focusSaveRow");
			      updateGrid();
			      setMessage('Se guardo exitosamente.');				    
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
	var solicitud_id  = $("#solicitud_id").val();
	var detalle_ss_id = $(Fila).find("input[name=detalle_ss_id]").val();
	var detalle_ss    = $(Fila).find("input[name=detalle_ss]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&solicitud_id="+solicitud_id+"&detalle_ss_id="+detalle_ss_id;
	
	if(detalle_ss_id.length > 0){
		if( $('#borrar',parent.document).length > 0 ){
			$.ajax({
				   
				url        : "DetLiqFinDedClass.php",
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
	  lista inteligente para la ubicacion con jquery
**************************************************************/
function autocompleteUbicacion(){
	
	$("input[name=origen],input[name=destino]").autocomplete("/application/framework/clases/ListaInteligente.php?consulta=ciudad", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=origen],input[name=destino]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
                $(this).parent().next().find("input").focus();
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