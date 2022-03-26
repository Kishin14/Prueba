// JavaScript Document

function setDataFormWithResponse(){

	var parametrosId = $('#cargo_id').val();

	RequiredRemove();

	var parametros  = new Array({campos:"cargo_id",valores:$('#cargo_id').val()});

	var forma       = document.forms[0];

	var controlador = 'CargoClass.php';



	

	FindRow(parametros,forma,controlador,null,function(resp){



  var data              = $.parseJSON(resp);

  var cargo_id = data[0]['cargo_id']; 

 // alert(cargo_id);

  document.getElementById('detalleCargo').src = 'DetalleCargoClass.php?cargo_id='+cargo_id;





		if($('#guardar'))    $('#guardar').attr("disabled","true");

		if($('#actualizar')) $('#actualizar').attr("disabled","");

		if($('#borrar'))     $('#borrar').attr("disabled","");

		if($('#limpiar'))    $('#limpiar').attr("disabled","");

	});

}



function CargoOnSaveOnUpdateonDelete(formulario,resp){

	// alert($(this).attr("id"));

	// if(this.id != 'guardar')

	// {

	// 	Reset(formulario);

	// 	resetDetalle('detalleCargo');

	// 	if($('#guardar'))    $('#guardar').attr("disabled","");

	// 	if($('#actualizar')) $('#actualizar').attr("disabled","true");

	// 	if($('#borrar'))     $('#borrar').attr("disabled","true");

	// 	if($('#limpiar'))    $('#limpiar').attr("disabled","");

	// }

	// clearFind();

	$("#refresh_QUERYGRID_cargo").click();

	alertJquery(resp,"Depreciacion");

}



function CargoOnReset(formulario){

	 // Reset(formulario);

  //   clearFind();  

  //   setFocusFirstFieldForm(formulario);

    document.getElementById('detalleCargo').src = '../../../framework/tpl/blank.html'; 

    // resetDetalle('detalleCargo'); 

    // $("#detalleCargo").html("");

    // $("#detalleCargo").attr("src","../../../framework/tpl/blank.html");

	if($('#guardar'))    $('#guardar').attr("disabled","");

	if($('#actualizar')) $('#actualizar').attr("disabled","true");

	if($('#borrar'))     $('#borrar').attr("disabled","true");

	if($('#limpiar'))    $('#limpiar').attr("disabled","");

}



$(document).ready(function(){



  $("#saveDetalles").click(function(){

    window.frames[0].saveDetallesSoliServi();

  });

    

  $("#deleteDetalles").click(function(){

    window.frames[0].deleteDetallesSoliServi();

  });  



  resetDetalle('detalleCargo');

	$("#guardar,#actualizar").click(function(){

		var formulario = document.getElementById('CargoForm');

		if(ValidaRequeridos(formulario)){

			if(this.id == 'guardar'){

				Send(formulario,'onclickSave',null,CargoOnSaveOnUpdateonDelete);

  				document.getElementById('detalleCargo').src = 'DetalleCargoClass.php?cargo_id=-1';

			}else{

				Send(formulario,'onclickUpdate',null,CargoOnSaveOnUpdateonDelete);

				Reset(formulario);

				resetDetalle('detalleCargo');

				if($('#guardar'))    $('#guardar').attr("disabled","");

				if($('#actualizar')) $('#actualizar').attr("disabled","true");

				if($('#borrar'))     $('#borrar').attr("disabled","true");

				if($('#limpiar'))    $('#limpiar').attr("disabled","");

				document.getElementById('detalleCargo').src = '../../../framework/tpl/blank.html';

			}

		}

	});

  resetDetalle('detalleCargo');

});