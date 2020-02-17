// JavaScript Document
$(document).ready(function(){


	var licencia_id = $("#licencia_id").val();

	if (licencia_id.length > 0) {
		setDataFormWithResponse();
	}


	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('LicenciaForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,LicenciaOnSave)
			}else{
				Send(formulario,'onclickUpdate',null,LicenciaOnUpdate)
			}
		}
	});

	$('#fecha_inicial,#fecha_final').change(function(){
	
		var fecha_inicial = $('#fecha_inicial').val();
		var fecha_final = $('#fecha_final').val();

		if((Date.parse(fecha_final) < Date.parse(fecha_inicial)) ) {
		 alertJquery('La fecha final no puede ser menor a la Inicial.');
		  $('#fecha_final').val('');
		}else{
			if(fecha_inicial!='' && fecha_final!=''){
				var dias1 = restaFechas(fecha_inicial,fecha_final);
				$('#dias').val(dias1);
			}
		}
	});
	
	$('#tipo_incapacidad_id').change(function(){
	
		var tipo_incapacidad_id = $('#tipo_incapacidad_id').val();
		
		var QueryString = "ACTIONCONTROLER=setDiagnostico&tipo_incapacidad_id="+tipo_incapacidad_id;
	
		$.ajax({
		  url     : "LicenciaClass.php",
		  data    : QueryString,
		  success : function(response){
					  
			  try{
				 var data = $.parseJSON(response); 

				 var aplica_diagnostico = data[0]['diagnostico'];
				 var tipo = data[0]['tipo'];

				if(aplica_diagnostico=='S'){
						$('#diagnostico').attr("disabled","");	
		  				$("#diagnostico").addClass("obligatorio");
				}else{
						$('#diagnostico').attr("disabled","true");	
		  				$("#diagnostico").removeClass("obligatorio");
				}

				if(tipo == 'I'){
					$('#descripcion').attr("disabled", "");
				}else if(tipo == 'L'){
					$('#descripcion').attr("disabled", "true");
				}


			  }catch(e){
				  console.log(e);
				}
		  }
		  
		});    
		
	});

 
  
});


function restaFechas(f1,f2){
	var aFecha1 = f1.split('-'); 
	var aFecha2 = f2.split('-'); 
	var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]); 
	var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
	var dif = fFecha2 - fFecha1;
	var dias = Math.floor(dif / (1000 * 60 * 60 * 24))
	dias= (dias+1); 
	return dias;
}
function LicenciaOnSave(formulario,resp){

	if(resp=='Se ingreso correctamente La Licencia.'){
		Reset(formulario);
		clearFind();
	}
 
	$("#refresh_QUERYGRID_licencia").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#imprimir'))   $('#imprimir').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Licencia");

}

function LicenciaOnUpdate(formulario,resp){

	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_licencia").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#imprimir'))   $('#imprimir').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Licencia");
}
function LicenciaOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function setDataFormWithResponse(){
	var parametrosId = $('#licencia_id').val();
	var parametros  = new Array({campos:"licencia_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'LicenciaClass.php';

	
	FindRow(parametros,forma,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#imprimir'))   $('#imprimir').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}

function beforePrint(){
	
   var licencia_id = parseInt(document.getElementById("licencia_id").value);
      
   if(isNaN(licencia_id)){
     alertJquery("Debe Seleccionar una Licencia!!","Impresion Licencia"); 
     return false;
   }else{
      return true;
    }
  
  
}