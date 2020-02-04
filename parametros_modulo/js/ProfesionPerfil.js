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

	  var perfil_id                = $("#perfil_id").val();

	  if (perfil_id == "-1")

	  {

	  	perfil_id = varjs;

	  }

	  var profesion_perfil_id = $(Fila).find("input[name=profesion_perfil_id]").val();	  	  

	  var profesion_id                       = $(Fila).find("select[name=profesion_id] option:selected").val();

	  var checkProcesar                    = $(Fila).find("input[name=procesar]");

	

	  if(!profesion_perfil_id.length > 0){

	    

	    if( $('#guardar',parent.document).length > 0 ){

	      	      

	      var QueryString = "ACTIONCONTROLER=onclickSave&profesion_perfil_id="+profesion_perfil_id+"&perfil_id="+

		  perfil_id+"&profesion_id="+profesion_id;

	      

				      

	      $.ajax({

		      url        : "ProfesionPerfilClass.php",

		      data       : QueryString,

		      beforeSend : function(){

			    setMessageWaiting();

		      },

		      success    : function(response){

		      

			      if(!isNaN(response)){

				

				      $(Fila).find("input[name=profesion_perfil_id]").val(response);				      

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

	  

	      var QueryString = "ACTIONCONTROLER=onclickUpdate&profesion_perfil_id="+profesion_perfil_id+"&perfil_id="+

		  perfil_id+"&profesion_id="+profesion_id;

		

		$.ajax({

			url        : "ProfesionPerfilClass.php",

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

	var perfil_id   = $("#perfil_id").val();

	if (perfil_id == "-1")

    {

  	  perfil_id = varjs;

    }

	var profesion_perfil_id = $(Fila).find("input[name=profesion_perfil_id]").val();

		

	var QueryString   = "ACTIONCONTROLER=onclickDelete&perfil_id="+perfil_id+"&profesion_perfil_id="+profesion_perfil_id;

	

	if(profesion_perfil_id.length > 0){

		if( $('#borrar',parent.document).length > 0 ){

			$.ajax({

				   

				url        : "ProfesionPerfilClass.php",

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





function saveDetallesSoliServi2(){

	

	$("input[name=procesar]:checked").each(function(){

	

		saveDetalle(this);

	

	});



}



function deleteDetallesSoliServi2(){

  

	$("input[name=procesar]:checked").each(function(){

		deleteDetalleSolicitud(this);

	

	});



}	

    

	

function updateGrid(){

	

	parent.document.getElementById("refresh_QUERYGRID_perfil").click();

	

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