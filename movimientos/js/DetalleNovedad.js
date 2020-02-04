// JavaScript Document
$(document).ready(function(){
	linkDetalles();
});



function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                            = obj.parentNode;
	  var Fila                             = Celda.parentNode;
	  var Tabla                            = Fila.parentNode;
	  var tipo_documento_id                = $("#tipo_documento_id").val();
	  var consecutivo_documento_oficina_id = $(Fila).find("input[name=consecutivo_documento_oficina_id]").val();	  	  
	  var oficina_id                       = $(Fila).find("select[name=oficina_id] option:selected").val();
	  var consecutivo                      = $(Fila).find("input[name=consecutivo]").val();
	  var checkProcesar                    = $(Fila).find("input[name=procesar]");
	
	  if(!consecutivo_documento_oficina_id.length > 0){
	    
	    if( $('#guardar',parent.document).length > 0 ){
	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&consecutivo_documento_oficina_id="+consecutivo_documento_oficina_id+"&tipo_documento_id="+
		  tipo_documento_id+"&oficina_id="+oficina_id+"&consecutivo="+consecutivo;
	      
				      
	      $.ajax({
		      url        : "DetalleNovedadClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=consecutivo_documento_oficina_id]").val(response);				      
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
				      checkRow();
				      linkDetalles();
				      updateGrid();
				      setMessage('Se guardo exitosamente.');
		      
			      }else{
					  alert(response)
				      setMessage(response);
			      }
			      
			      
		      }
		      
	      });
	      
	}//fin del permiso de guardar
	
     }else{
       
	if( $('#actualizar',parent.document).length > 0 ){
	  
	      var QueryString = "ACTIONCONTROLER=onclickUpdate&consecutivo_documento_oficina_id="+consecutivo_documento_oficina_id+"&tipo_documento_id="+
		  tipo_documento_id+"&oficina_id="+oficina_id+"&consecutivo="+consecutivo;
		
		$.ajax({
			url        : "DetalleNovedadClass.php",
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
				    alertJquery(response);
			    }
			   
		       
		       }
		});
		
	}//find el permiso de actalizar
	
     }//fin detalle_ss_id.length
     
  }//fin de validaRequeridosDetalle	
  
}


function deleteDetalleSolicitud(obj){
	
	var Celda               = obj.parentNode;
	var Fila                = obj.parentNode.parentNode;
	var tipo_documento_id   = $("#tipo_documento_id").val();
	var consecutivo_documento_oficina_id = $(Fila).find("input[name=consecutivo_documento_oficina_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&tipo_documento_id="+tipo_documento_id+"&consecutivo_documento_oficina_id="+consecutivo_documento_oficina_id;
	
	if(consecutivo_documento_oficina_id.length > 0){
		if( $('#borrar',parent.document).length > 0 ){
			$.ajax({
				   
				url        : "DetalleNovedadClass.php",
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
						alertJquery(response);
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
	
		saveDetalle(this);
	
	});

}

function deleteDetallesSoliServi(){
  
	$("input[name=procesar]:checked").each(function(){
	
		deleteDetalleSolicitud(this);
	
	});

}	
    
	
function updateGrid(){
	
	parent.document.getElementById("refresh_QUERYGRID_tipo_de_documento").click();
	
}

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetalles(){

	$("a[name=saveDetalle]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalle]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle]").click(function(){
		saveDetalle(this);
    });
	
}