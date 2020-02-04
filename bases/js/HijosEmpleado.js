// JavaScript Document
$(document).ready(function(){
	linkDetalles();
	autocompletePuc();
	autocompleteUbicacion();
	/*$( ".dtp" ).datepicker({ dateFormat: 'yy-mm-dd' });*/
	
	$("input[name=fecha_nacimiento]").blur(function (){

		var fecha_nacimiento = (this.value);
		var edad 			 = 0; 
		var Fila             = this.parentNode.parentNode;
		
		if (fecha_nacimiento != ''){

		var fechaNace = new Date(fecha_nacimiento);

	    var fechaActual = new Date()
	 
	    var mes = fechaActual.getMonth();

	    var dia = fechaActual.getDate();

	    var año = fechaActual.getFullYear();

	    fechaActual.setDate(dia);

	    fechaActual.setMonth(mes);

	    fechaActual.setFullYear(año);

		edad = Math.floor(((fechaActual - fechaNace) / (1000 * 60 * 60 * 24) / 365));

		} 
		
		$(Fila).find("input[name=edad]").val(edad);
		
	});
});



function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                            = obj.parentNode;
	  var Fila                             = Celda.parentNode;
	  var Tabla                            = Fila.parentNode;
	  var empleado_id                = $("#empleado_id").val();
	  var hijos_id = $(Fila).find("input[name=hijos_id]").val();

	  var tipo_identificacion_id       = $(Fila).find("select[name=tipo_identificacion_id]").val();
	  var numero_identificacion        = $(Fila).find("input[name=numero_identificacion]").val();
	  var primer_nombre                = $(Fila).find("input[name=primer_nombre]").val();
	  var segundo_nombre               = $(Fila).find("input[name=segundo_nombre]").val();
	  var primer_apellido              = $(Fila).find("input[name=primer_apellido]").val();
	  var segundo_apellido             = $(Fila).find("input[name=segundo_apellido ]").val();
	  var fecha_nacimiento             = $(Fila).find("input[name=fecha_nacimiento]").val();
	  var estado 				       = $(Fila).find("select[name=estado]").val();
	  var  ubicacion_id                  = $(Fila).find("input[name=ubicacion_id]").val();

	  var checkProcesar                    = $(Fila).find("input[name=procesar]");
	
	  if(!parseInt(hijos_id)>0){
	    
		if( $('#guardar',parent.document).length > 0 ){
					  
			  var QueryString = "ACTIONCONTROLER=onclickSave&empleado_id="+empleado_id+"&tipo_identificacion_id="+tipo_identificacion_id+"&numero_identificacion="
			  +numero_identificacion+"&primer_nombre="+primer_nombre+"&segundo_nombre="+segundo_nombre+"&primer_apellido="+primer_apellido+"&segundo_apellido="+segundo_apellido+
			  "&fecha_nacimiento="+fecha_nacimiento+"&estado="+estado+"&ubicacion_id="+ubicacion_id;
			 
						  
			  $.ajax({
				  url        : "HijosEmpleadoClass.php",
				  data       : QueryString,
				  beforeSend : function(){
					//setMessageWaiting();
				  },
				  success    : function(response){
				  
					  if(!isNaN(response)){
					
						  $(Fila).find("input[name=hijos_id]").val(response);				      
						  checkProcesar.attr("checked","");
						  $(Celda).removeClass("focusSaveRow");
						  insertaFilaAbajoClon(Tabla);
						  autocompletePuc()
						  checkRow();
						  linkDetalles();
						  updateGrid();
						  autocompleteUbicacion();

						  $("input[type=text],textarea").keyup(function() {
						   this.value = this.value.toUpperCase();
						  });

						  alertJquery('Se guardo exitosamente.','HijosEmpleado');
				  
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
		  
			var QueryString = "ACTIONCONTROLER=onclickUpdate&empleado_id="+empleado_id+"&hijos_id="+hijos_id+"&tipo_identificacion_id="+tipo_identificacion_id+
			"&numero_identificacion="+numero_identificacion+"&primer_nombre="+primer_nombre+"&segundo_nombre="+segundo_nombre+"&primer_apellido="+primer_apellido+
			"&segundo_apellido="+segundo_apellido+"&fecha_nacimiento="+fecha_nacimiento+"&estado="+estado+"&ubicacion_id="+ubicacion_id; 
	
			$.ajax({
				url        : "HijosEmpleadoClass.php",
				data       : QueryString,
				beforeSend : function(){
				 // setMessageWaiting();
				},
				success    : function(response){
				  
					if( $.trim(response) == 'true'){
						
					  checkProcesar.attr("checked","");
					  $(Celda).removeClass("focusSaveRow");
					  updateGrid();
  				      autocompleteUbicacion();
					  alertJquery('Se actualizo exitosamente.','HijosEmpleado');				    
					}else{
						alertJquery(response);
					}
				   
				   
				   }
			});
			
		}//find el permiso de actalizar
	
    }//fin detalle_ss_id.length
     
  }//fin de validaRequeridosDetalle	
  
}

/***************************************************************
	  lista inteligente para la ubicacion con jquery
**************************************************************/
function autocompleteUbicacion(){
	
	$("input[name=ubicacion]").autocomplete("/application/framework/clases/ListaInteligente.php?consulta=ciudad", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=ubicacion]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
                $(this).parent().next().find("input").focus();
	});
	
}




function deleteDetalleSolicitud(obj){
	
	var Celda               = obj.parentNode;
	var Fila                = obj.parentNode.parentNode;
	var empleado_id                = $("#empleado_id").val();
	var hijos_id = $(Fila).find("input[name=hijos_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&empleado_id="+empleado_id+"&hijos_id="+hijos_id;
	
	if(hijos_id!=0){
		if( $('#borrar',parent.document).length > 0 ){
			$.ajax({
				   
				url        : "HijosEmpleadoClass.php",
				data       : QueryString,
				beforeSend : function(){
				  //setMessageWaiting();
				},
				success    : function(response){
				  				  
					if( $.trim(response) == 'true'){
						
						$(Fila).remove();
						updateGrid();
					  alertJquery('Se borro exitosamente.','HijosEmpleado');				    						
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
	
	$("#refresh_QUERYGRID_hijos").click();
	
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


/***************************************************************
	  lista inteligente para la los codigos puc
**************************************************************/
function autocompletePuc(){
	
	$("input[name=puc]").autocomplete("/application/framework/clases/ListaInteligente.php?consulta=cuentas_movimiento_activas", {
		width: 355,
		selectFirst: true
	});
	
	$("input[name=puc]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
                $(this).parent().next().find("input").focus();
	});
	
}