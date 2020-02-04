$(document).ready(function(){
	
	 $('#fecha_inicio').change(function(){

    var fechah = $('#fecha_final').val();
    var fechad = $('#fecha_inicio').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
     alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
     return this.value = $('#fecha_final').val();
    };
 });

 $('#fecha_final').change(function(){

    var fechah = $('#fecha_final').val();
    var fechad = $('#fecha_inicio').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
     alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
     return this.value = $('#fecha_inicio').val();
    };
 });
	

});

function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "AumentoClass.php?ACTIONCONTROLER=generateReporte&printers=si";  
	   popPup(QueryString,'Impresion Pendientes',800,600);
   }else{
	 alertJquery("Por favor ingrese los datos requeridos","Validacion");
   }
}

function renovar(solicitud_id){
	
	parent.renovarcontrato(solicitud_id);
}

function finalizar(solicitud_id){
	
	 
	parent.finalizarcontrato(solicitud_id); 
	
}

function actualizar(solicitud_id){
	
	 
	parent.actualizarcontrato(solicitud_id); 
	
}

function setDataFormWithResponse(){
	var activo_id	=	document.getElementById("activo_id").value;
	var cantidad	=	document.getElementById("cantidad").value;
	var formulario	=	document.forms[0];
	var QueryString = "ACTIONCONTROLER=onclickFind&activo_id="+activo_id;
	$.ajax({
		url        : "AumentoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){
			try{
				var data	= $.parseJSON(resp);
				if(isNaN(parseInt(data[0]['activo_id']))){ 
					return false;
				}
				$("#activo_id").val(data[0]['activo_id']);
				$("#activo").val(data[0]['activo']);
				$("#concepto").val(data[0]['concepto']);
				$("#tercero").val(data[0]['tercero']);
				$("#tercero_id").val(data[0]['tercero_id']);
				$("#tabla_depreciacion_id").val(data[0]['tabla_depreciacion_id']);
				$("#valor").val(data[0]['valor']);
				
				//setFormWithJSON(formulario,data);
				$("#cantidad").val(cantidad);
				// if($('#guardar'))		$('#guardar').attr("disabled","true");
				// if($('#actualizar'))	$('#actualizar').attr("disabled","");
				// if($('#borrar'))		$('#borrar').attr("disabled","");
				// if($('#limpiar'))		$('#limpiar').attr("disabled","");
			}catch(e){
				alertJquery(resp,"Error :"+e);
			}
			removeDivLoading();
		}
	});
}

function ResetForm(formulario){
	var f=new Date();
	var anio= f.getFullYear();
	Reset(formulario);
	$("#busqueda").val('');
	$("#frameDepreciados").attr("src",'');
	Ninguno();
	
	var objSelect = document.getElementById('periodo_contable_id'); 
	var numOp     = objSelect.options.length ;
	objSelect.options[0].selected=false;		
   
   for(var i = 0; i < numOp; i++ ){
	 objSelect.options[i].selected = true;
   }
	
}