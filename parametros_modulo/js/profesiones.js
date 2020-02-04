// JavaScript Document

var formSubmitted = false;

function setDataFormWithResponse(){

    var tipo_profesionId = $('#profesion_id').val();

    RequiredRemove();



    var profesion  = new Array({campos:"profesion_id",valores:$('#profesion_id').val()});

	var forma       = document.forms[0];

	var controlador = 'ProfesionesClass.php';



	FindRow(profesion,forma,controlador,null,function(resp){

	$('#nombre_dane').attr("disabled","true");
	$('#id_dane_profesion').attr("disabled","true");
	
      if($('#guardar'))    $('#guardar').attr("disabled","true");

      if($('#actualizar')) $('#actualizar').attr("disabled","");

      if($('#borrar'))     $('#borrar').attr("disabled","");

      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  

    });





}



function ProfesionesOnSaveOnUpdate(formulario,resp){

   Reset(formulario);

   clearFind();

   $("#refresh_QUERYGRID_profesion").click();
   
   $('#nombre_dane').attr("disabled","");
	$('#id_dane_profesion').attr("disabled","");

   if($('#guardar'))    $('#guardar').attr("disabled","");

   if($('#actualizar')) $('#actualizar').attr("disabled","true");

   if($('#borrar'))     $('#borrar').attr("disabled","true");

   if($('#limpiar'))    $('#limpiar').attr("disabled","");

   alertJquery(resp,"Profesiones");

}

function ProfesionesOnReset(formulario){

	

    clearFind();	
	
	 $('#nombre_dane').attr("disabled","");
	$('#id_dane_profesion').attr("disabled","");


    if($('#guardar'))    $('#guardar').attr("disabled","");

    if($('#actualizar')) $('#actualizar').attr("disabled","true");

    if($('#borrar'))     $('#borrar').attr("disabled","true");

    if($('#limpiar'))    $('#limpiar').attr("disabled","");	

}



$(document).ready(function(){

						   

  var formulario = document.getElementById('ProfesionesForm');

						   

  $("#guardar,#actualizar").click(function(){

	if(this.id == 'guardar'){

			if(!formSubmitted){

				 formSubmitted = true;

				 Send(formulario,'onclickSave',null,ProfesionesOnSaveOnUpdate);

			}

		}else{

			Send(formulario,'onclickUpdate',null,ProfesionesOnSaveOnUpdate);

		}	

	

	formSubmitted = false;

  

  });



});

	

