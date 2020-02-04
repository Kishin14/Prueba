// JavaScript Document

$(document).ready(function(){

	linkDetalles();

	autocompletePuc();

});







function saveDetalle(obj){

	

	var row = obj.parentNode.parentNode;

	

	if(validaRequeridosDetalle(obj,row)){

	  

	  var Celda                            = obj.parentNode;

	  var Fila                             = Celda.parentNode;

	  var Tabla                            = Fila.parentNode;

	  var cargo_id                = $("#cargo_id").val();

	  if (cargo_id == "-1")

	  {

	  	cargo_id = varjs;

	  }

	  var categoria_cargo_id = $(Fila).find("input[name=categoria_cargo_id]").val();	  	  

	  var categoria_id                       = $(Fila).find("select[name=categoria_id] option:selected").val();

	  var estado                      = $(Fila).find("select[name=estado]").val();

	  var checkProcesar                    = $(Fila).find("input[name=procesar]");

	

	  if(!categoria_cargo_id.length > 0){

	    

	    if( $('#guardar',parent.document).length > 0 ){

	      	      

	      var QueryString = "ACTIONCONTROLER=onclickSave&categoria_cargo_id="+categoria_cargo_id+"&cargo_id="+

		  cargo_id+"&categoria_id="+categoria_id+"&estado="+estado;

	      

				      

	      $.ajax({

		      url        : "DetalleCargoClass.php",

		      data       : QueryString,

		      beforeSend : function(){

			    setMessageWaiting();

		      },

		      success    : function(response){

		      

			      if(!isNaN(response)){

				

				      $(Fila).find("input[name=categoria_cargo_id]").val(response);				      

				      checkProcesar.attr("checked","");

				      $(Celda).removeClass("focusSaveRow");

				      

				      insertaFilaAbajoClon(Tabla);

					  autocompletePuc()

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

	  

	      var QueryString = "ACTIONCONTROLER=onclickUpdate&categoria_cargo_id="+categoria_cargo_id+"&cargo_id="+

		  cargo_id+"&categoria_id="+categoria_id+"&estado="+estado;

		

		$.ajax({

			url        : "DetalleCargoClass.php",

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

	var cargo_id   = $("#cargo_id").val();

	if (cargo_id == "-1")

	  {

	  	cargo_id = varjs;

	  }

	var categoria_cargo_id = $(Fila).find("input[name=categoria_cargo_id]").val();

		

	var QueryString   = "ACTIONCONTROLER=onclickDelete&cargo_id="+cargo_id+"&categoria_cargo_id="+categoria_cargo_id;

	

	if(categoria_cargo_id.length > 0){

		if( $('#borrar',parent.document).length > 0 ){

			$.ajax({

				   

				url        : "DetalleCargoClass.php",

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

	

	parent.document.getElementById("refresh_QUERYGRID_cargo").click();

	

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

	

	$("input[name=puc]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=cuentas_movimiento_activas", {

		width: 355,

		selectFirst: true

	});

	

	$("input[name=puc]").result(function(event, data, formatted) {

		if (data) $(this).next().val(data[1]);

                $(this).parent().next().find("input").focus();

	});

	

}