// JavaScript Document
$(document).ready(function(){
	linkDetalles();

	$( ".dtp" ).datepicker({ dateFormat: 'yy-mm-dd' });
});



function saveDetalle3(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                     = obj.parentNode;
	  var Fila                      = Celda.parentNode;
	  var Tabla                     = Fila.parentNode;
	  var empleado_id               = $("#empleado_id").val();
	  var estudio_id 				= $(Fila).find("input[name=estudio_id]").val();

	  var nivel_escolaridad_id      = $(Fila).find("select[name=nivel_escolaridad_id]").val();
	  var titulo              		= $(Fila).find("input[name=titulo]").val();
	  var fecha_terminacion   		= $(Fila).find("input[name=fecha_terminacion]").val();
	  var institucion         		= $(Fila).find("input[name=institucion]").val();
	  var acta_de_grado       		= $(Fila).find("input[name=acta_de_grado]").val();
	  
	  var checkProcesar       		= $(Fila).find("input[name=procesar]");
	
	  if(!parseInt(estudio_id)>0){
	    
	    if( $('#guardar',parent.document).length > 0 ){
	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&empleado_id="+empleado_id+"&nivel_escolaridad_id="+nivel_escolaridad_id+"&titulo="+titulo+"&fecha_terminacion="+fecha_terminacion+"&institucion="+institucion+"&acta_de_grado="+acta_de_grado;
	      
				      
	      $.ajax({
		      url        : "EstudiosEmpleadoClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    //setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=estudio_id]").val(response);				      
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
				      checkRow();
				      linkDetalles();
				      updateGrid();
					   alertJquery('Se guardo exitosamente.','EstudiosEmpleado');
				      //setMessage('Se guardo exitosamente.');

			      }else{
					  /*alert(response)
				      setMessage(response);*/
					   alertJquery(response);
			      }
			      
			      
		      }
		      
	      });
	      
	}//fin del permiso de guardar
	
     }else{
       
	if( $('#actualizar',parent.document).length > 0 ){
	  
	    var QueryString = "ACTIONCONTROLER=onclickUpdate&empleado_id="+empleado_id+"&estudio_id="+estudio_id+"&nivel_escolaridad_id="+nivel_escolaridad_id+"&titulo="+titulo+"&fecha_terminacion="+fecha_terminacion+"&institucion="+institucion+"&acta_de_grado="+acta_de_grado;;

		$.ajax({
			url        : "EstudiosEmpleadoClass.php",
			data       : QueryString,
			beforeSend : function(){
			  //setMessageWaiting();
			},
			success    : function(response){
			  
			    if( $.trim(response) == 'true'){
				    
			      checkProcesar.attr("checked","");
			      $(Celda).removeClass("focusSaveRow");
			      updateGrid();
			  alertJquery('Se actualizo exitosamente.','EstudiosEmpleado');
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
	var empleado_id                = $("#empleado_id").val();
	var estudio_id = $(Fila).find("input[name=estudio_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&empleado_id="+empleado_id+"&estudio_id="+estudio_id;
	
	if(estudio_id!=0){
		if( $('#borrar',parent.document).length > 0 ){
			$.ajax({
				   
				url        : "EstudiosEmpleadoClass.php",
				data       : QueryString,
				beforeSend : function(){
				  //setMessageWaiting();
				},
				success    : function(response){
				  				  
					if( $.trim(response) == 'true'){
						
						$(Fila).remove();
						updateGrid();
						alertJquery('Se borro exitosamente.','EstudioEmpleado'); 
						
					}else{
						alertJquery(response);
					}
					
				    
				}
			});
		}
	}else{
		alertJquery('No puede eliminar elementos que no han sido guardados');
		$(Fila).find("input[name=procesar]").attr("checked","");
	}
}


function saveDetallesSoliServi3(){
	
	$("input[name=procesar]:checked").each(function(){
	
		saveDetalle3(this);
	
	});

}

function deleteDetallesSoliServi3(){
  
	$("input[name=procesar]:checked").each(function(){
	
		deleteDetalleSolicitud(this);
	
	});

}	
    
	
function updateGrid(){
	
	$("#refresh_QUERYGRID_estudio").click();
	
}

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetalles(){

	$("a[name=saveDetalle3]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalle3]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle3]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle3]").click(function(){
		saveDetalle3(this);
    });
	
}