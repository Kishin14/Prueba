// JavaScript Document
$(document).ready(function(){
	linkDetalles();
	autocompletePuc();

	$( ".dtp" ).datepicker({ dateFormat: 'yy-mm-dd' });
});



function saveDetalle2(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                            = obj.parentNode;
	  var Fila                             = Celda.parentNode;
	  var Tabla                            = Fila.parentNode;
	  var empleado_id                = $("#empleado_id").val();
	  var conyuge_id = $(Fila).find("input[name=conyuge_id]").val();

	  var tipo_identificacion_id         = $(Fila).find("select[name=tipo_identificacion_id]").val();
	  var numero_identificacion         = $(Fila).find("input[name=numero_identificacion]").val();
	  var primer_nombre                = $(Fila).find("input[name=primer_nombre]").val();
	  var segundo_nombre                = $(Fila).find("input[name=segundo_nombre]").val();
	  var primer_apellido                = $(Fila).find("input[name=primer_apellido]").val();
	  var segundo_apellido                = $(Fila).find("input[name=segundo_apellido ]").val();
	  var fecha_nacimiento                = $(Fila).find("input[name=fecha_nacimiento]").val();
	  var fecha_inicio                = $(Fila).find("input[name=fecha_inicio]").val();
	  var fecha_final                = $(Fila).find("input[name=fecha_final]").val();
	  var estado 						  = $(Fila).find("select[name=estado]").val();

	  var checkProcesar                    = $(Fila).find("input[name=procesar]");
	
	  if(!parseInt(conyuge_id)>0){
	    
	    if( $('#guardar',parent.document).length > 0 ){
	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&empleado_id="+empleado_id+"&tipo_identificacion_id="+tipo_identificacion_id+"&numero_identificacion="+numero_identificacion+"&primer_nombre="+primer_nombre+"&segundo_nombre="+segundo_nombre+"&primer_apellido="+primer_apellido+"&segundo_apellido="+segundo_apellido+"&fecha_nacimiento="+fecha_nacimiento+"&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&estado="+estado;
	      
				      
	      $.ajax({
		      url        : "ConyugeEmpleadoClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    //setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=conyuge_id]").val(response);				      
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
					  autocompletePuc()
				      checkRow();
				      linkDetalles();
				      updateGrid();
			       alertJquery('Se guardo exitosamente.','ConyugeEmpleado');				  		      
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
	  
	    var QueryString = "ACTIONCONTROLER=onclickUpdate&empleado_id="+empleado_id+"&conyuge_id="+conyuge_id+"&tipo_identificacion_id="+tipo_identificacion_id+"&numero_identificacion="+numero_identificacion+"&primer_nombre="+primer_nombre+"&segundo_nombre="+segundo_nombre+"&primer_apellido="+primer_apellido+"&segundo_apellido="+segundo_apellido+"&fecha_nacimiento="+fecha_nacimiento+"&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&estado="+estado;

		$.ajax({
			url        : "ConyugeEmpleadoClass.php",
			data       : QueryString,
			beforeSend : function(){
			  //setMessageWaiting();
			},
			success    : function(response){
			  
			    if( $.trim(response) == 'true'){
				    
			      checkProcesar.attr("checked","");
			      $(Celda).removeClass("focusSaveRow");
			      updateGrid();
			      alertJquery('Se actualizo exitosamente.','ConyugeEmpleado');				    
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
	var conyuge_id = $(Fila).find("input[name=conyuge_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&empleado_id="+empleado_id+"&conyuge_id="+conyuge_id;
	
	if(conyuge_id!=0){
		if( $('#borrar',parent.document).length > 0 ){
			$.ajax({
				   
				url        : "ConyugeEmpleadoClass.php",
				data       : QueryString,
				beforeSend : function(){
				  //setMessageWaiting();
				},
				success    : function(response){
				  				  
					if( $.trim(response) == 'true'){
						
						$(Fila).remove();
						updateGrid();
						alertJquery('Se borro exitosamente.','ConyugeEmpleado'); 
						
					}else{
						alertJquery(response);
					}
					
				    
				}
			});
		}
	}else{
		alertJquery('No puede eliminar elementos que no han sido guardados','ConyugeEmpleado');
		$(Fila).find("input[name=procesar]").attr("checked","");
	}
}


function saveDetallesSoliServi2(){
	
	$("input[name=procesar]:checked").each(function(){
	
		saveDetalle2(this);
	
	});

}

function deleteDetallesSoliServi2(){

	$("input[name=procesar]:checked").each(function(){
	
		deleteDetalleSolicitud(this);
	
	});

}	
    
	
function updateGrid(){
	
	$("#refresh_QUERYGRID_conyuge").click();
	
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
		saveDetalle2(this);
    });
	
}


/***************************************************************
	  lista inteligente para la los codigos puc
**************************************************************/
function autocompletePuc(){
	
	$("input[name=puc]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=cuentas_movimiento_activas", {
		width: 355,
		selectFirst: true
	});
	
	$("input[name=puc]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
                $(this).parent().next().find("input").focus();
	});
	
}