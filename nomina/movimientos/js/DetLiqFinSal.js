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
	  var  remitente               = $(Fila).find("input[name=remitente]").val();
      var  remitente_id 	       = $(Fila).find("input[name=remitente_id]").val();
	  var  tipo_identificacion_remitente_id	 = $(Fila).find("select[name=tipo_identificacion_remitente_id] option:selected").val();
	  var  doc_remitente           = $(Fila).find("input[name=doc_remitente]").val();
	  var  direccion_remitente     = $(Fila).find("input[name=direccion_remitente]").val();
	  var  telefono_remitente      = $(Fila).find("input[name=telefono_remitente]").val();
	  var  destinatario            = $(Fila).find("input[name=destinatario]").val();
	  var  destinatario_id         = $(Fila).find("input[name=destinatario_id]").val();
	  var  tipo_identificacion_destinatario_id = $(Fila).find("select[name=tipo_identificacion_destinatario_id] option:selected").val();
	  var  doc_destinatario        = $(Fila).find("input[name=doc_destinatario]").val();
	  var  direccion_destinatario  = $(Fila).find("input[name=direccion_destinatario]").val();
	  var  telefono_destinatario   = $(Fila).find("input[name=telefono_destinatario]").val();
	  var  referencia_producto     = $(Fila).find("input[name=referencia_producto]").val();
	  var  descripcion_producto    = $(Fila).find("input[name=descripcion_producto]").val();
	  var  cantidad                = $(Fila).find("input[name=cantidad]").val();
	  var  peso                    = $(Fila).find("input[name=peso]").val();
	  var  peso_volumen            = $(Fila).find("input[name=peso_volumen]").val();
	  var  valor_unidad            = $(Fila).find("input[name=valor_unidad]").val();	  	
	  var checkProcesar            = $(Fila).find("input[name=procesar]");
	
	  if(!detalle_ss_id.length > 0){
	    
	    if( $('#guardar',parent.document).length > 0 ){
	      
	      detalle_ss_id   = 'NULL';
	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&detalle_ss_id="+detalle_ss_id+"&origen_id="+origen_id+"&unidad_peso_id="+unidad_peso_id+"&unidad_volumen_id="+unidad_volumen_id+"&solicitud_id="+solicitud_id+"&destino_id="+destino_id+"&orden_despacho="+orden_despacho+"&shipment="+shipment+"&remitente="+remitente+"&remitente_id="+remitente_id+"&tipo_identificacion_remitente_id="+tipo_identificacion_remitente_id+"&doc_remitente="+doc_remitente+"&direccion_remitente="+direccion_remitente+"&telefono_remitente="+telefono_remitente+"&destinatario="+destinatario+"&destinatario_id="+destinatario_id+"&tipo_identificacion_destinatario_id="+tipo_identificacion_destinatario_id+"&doc_destinatario="+doc_destinatario+"&direccion_destinatario="+direccion_destinatario+"&telefono_destinatario="+telefono_destinatario+"&referencia_producto="+referencia_producto+"&descripcion_producto="+descripcion_producto+"&cantidad="+cantidad+"&peso="+peso+"&peso_volumen="+peso_volumen+"&valor_unidad="+valor_unidad;
	      
				      
	      $.ajax({
		      url        : "DetLiqFinSalClass.php",
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
			url        : "DetLiqFinSalClass.php",
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
				   
				url        : "DetLiqFinSalClass.php",
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
	
	$("input[name=origen],input[name=destino]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=ciudad", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=origen],input[name=destino]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
                $(this).parent().next().find("input").focus();
	});
	
}

function autocompleteRemitente(){
	
	$("input[name=remitente]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=remitente", {
		width      : 260,
		selectFirst: true
	});
	
	$("input[name=remitente]").result(function(event, data, formatted) {

       var input = this;
	   
       if (data){
		   		   
			var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatario&remitente_destinatario_id="+data[1];
			
           $.ajax({
			 url        : "DetLiqFinSalClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				 showDivLoading();
			 },
			 success    : function(resp){
				 
				 try{
					 
					 var dataResp = $.parseJSON(resp);	 
					 var row      = input.parentNode.parentNode;
					 
					 $(row).find("input[name=remitente]").val(dataResp[0]['remitente_destinatario']);
					 $(row).find("input[name=remitente_id]").val(dataResp[0]['remitente_destinatario_id']);				 
					 $(row).find("input[name=doc_remitente]").val(dataResp[0]['numero_identificacion']);				 	
					 
					 //$(row).find("input[name=tipo_identificacion_remitente_id]").val(dataResp[0]['tipo_identificacion_id']);
					 
					 document.getElementById('tipo_identificacion_remitente_id').value = dataResp[0]['tipo_identificacion_id'];
					 
					 $(row).find("input[name=direccion_remitente]").val(dataResp[0]['direccion']);								 
					 $(row).find("input[name=origen]").val(dataResp[0]['ubicacion']);				 									 
					 $(row).find("input[name=origen_id]").val(dataResp[0]['ubicacion_id']);				 									 
					 $(row).find("input[name=telefono_remitente]").val(dataResp[0]['telefono']);				 				 				 	

				 
				 }catch(e){
					   alert(resp,"Error :"+e);
					}
				 
				 removeDivLoading();
			 }
			
		   });

	   }
	   
	});
	
}


function autocompleteDestinatario(){
	
	$("input[name=destinatario]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=destinatario", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=destinatario]").result(function(event, data, formatted) {

       var input = this;

       if (data){
		   		   
			var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatario&remitente_destinatario_id="+data[1];
			
           $.ajax({
			 url        : "DetLiqFinSalClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				 showDivLoading();
			 },
			 success    : function(resp){

				 try{
					 
					 var dataResp = $.parseJSON(resp);	 
					 var row      = input.parentNode.parentNode;
					 
					 $(row).find("input[name=destinatario]").val(dataResp[0]['remitente_destinatario']);
					 $(row).find("input[name=destinatario_id]").val(dataResp[0]['remitente_destinatario_id']);				 
					 $(row).find("input[name=doc_destinatario]").val(dataResp[0]['numero_identificacion']);				 		
					 
					 document.getElementById('tipo_identificacion_destinatario_id').value = dataResp[0]['tipo_identificacion_id'];					 
//					 $(row).find("input[name=tipo_identificacion_destinatario_id]").val(dataResp[0]['tipo_identificacion_id']);			
					 
					  $(row).find("input[name=destino]").val(dataResp[0]['ubicacion']);	
					  $(row).find("input[name=destino_id]").val(dataResp[0]['ubicacion_id']);	
					 
					 $(row).find("input[name=direccion_destinatario]").val(dataResp[0]['direccion']);				 				 				 
					 $(row).find("input[name=telefono_destinatario]").val(dataResp[0]['telefono']);				 				 				 	

				 
				 }catch(e){
					   alert(resp,"Error :"+e);
					}
				 
				 removeDivLoading();

			 }
			
		   });

	   }


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