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

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
     
      url        : "ProfesionesClass.php?rand="+Math.random(),
      data       : QueryString,
      async      :false,
      beforeSend : function(){
      showDivLoading();
      },
      success    : function(resp){
        console.log(resp);
        try{
          
          var iframe           = document.createElement('iframe');
          iframe.id            ='frame_grid';
          iframe.style.cssText = "border:0; height: 400px; background-color:transparent";
          //iframe.scrolling   = 'no';
          
          document.body.appendChild(iframe); 
          iframe.contentWindow.document.open();
          iframe.contentWindow.document.write(resp);
          iframe.contentWindow.document.close();
          
          $('#mostrar_grid').removeClass('btn btn-warning btn-sm');
          $('#mostrar_grid').addClass('btn btn-secondary btn-sm');
          $('#mostrar_grid').html('Ocultar tabla');
          
        }catch(e){
          
          console.log(e);
          
        }
        removeDivLoading();
      } 
    });
    
  }else{
    
      $('#frame_grid').remove();
      $('#mostrar_grid').removeClass('btn btn-secondary btn-sm');
      $('#mostrar_grid').addClass('btn btn-warning btn-sm');
      $('#mostrar_grid').html('Mostrar tabla');
    
  }
  
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

	

