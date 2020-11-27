// JavaScript Document

function LlenarFormEmpresas(){

var NumeroId = document.getElementById('busqueda').value.split("-");

$('#numero_identificacion').val(NumeroId[0]);

RequiredRemove();

FindRow([{campos:"numero_identificacion",valores:NumeroId[0],botones:"guardar,actualizar,borrar,restaurar"}],document.forms[0],"EmpresasClass.php","../../../framework/media/images/forms/load.gif");

if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function ValidarTercero(){
if($('#guardar'))    $('#guardar').attr("disabled","");
if($('#actualizar')) $('#actualizar').attr("disabled","true");
if($('#borrar'))     $('#borrar').attr("disabled","true");
if($('#limpiar'))    $('#limpiar').attr("disabled","true");
}

function EmpresaOnSaveUpdate(){

    $("#refresh_QUERYGRID_terceros").click();

    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","true");
	
}

function EmpresaOnDelete(){

  Reset();
  $("#refresh_QUERYGRID_terceros").click();
   
}

function CargaLogoEmpresa(){


}