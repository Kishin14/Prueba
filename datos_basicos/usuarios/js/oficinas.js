// JavaScript Document

function LlenarFormOficina(){

var OficinaId  = $("#oficina_id").val();
var params     = new Array({campos:"oficina_id",valores:OficinaId});
var formulario = document.forms[0];
var url        = "OficinasClass.php";

FindRow(params,formulario,url,null,function(){

getOptionsOficinaSelected();

});

if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");

}

function OficinaOnSaveUpdate(formulario,response){

    $("#refresh_QUERYGRID_oficina").click();

    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");

    Reset(formulario);
    OficinaOnClear();
	getOficinasTree();
    alertJquery(response,'Oficinas');		
	
}

function OficinaOnDelete(formulario,response){

  Reset(formulario);
  $("#refresh_QUERYGRID_terceros").click();
   
  if($('#guardar'))    $('#guardar').attr("disabled","");
  if($('#actualizar')) $('#actualizar').attr("disabled","true");
  if($('#borrar'))     $('#borrar').attr("disabled","true");
  if($('#limpiar'))    $('#limpiar').attr("disabled","true");   

  Reset(formulario);
  OficinaOnClear();
  getOficinasTree();
  alertJquery(response,'Oficinas');
   
}

function OficinaOnClear(){

	$("#cen_oficina_id option").each(function(){
      if(this.value != 'NULL') $(this).remove();  
    });
	
}

function getOptionsOficina(){

	var EmpresaId   = $("#empresa_id").val();
    var QueryString = "ACTIONCONTROLER=getOptionsOficina&empresa_id="+EmpresaId;

	if(EmpresaId != 'NULL'){
	
	  $.ajax({
	    url     : "OficinasClass.php",
	    data    : QueryString,
	    success : function(response){
		  $("#cen_oficina_id").parent().html(response);
        }
      });
	  
	}
	
}

function getOptionsOficinaSelected(){
	
	var EmpresaId   = $("#empresa_id").val();
	var OficinaId   = $("#oficina_id").val();
    var QueryString = "ACTIONCONTROLER=getOptionsOficinaSelected&empresa_id="+EmpresaId+"&oficina_id="+OficinaId;
	
	if(EmpresaId != 'NULL'){
	
	  $.ajax({
	    url     : "OficinasClass.php",
	    data    : QueryString,
	    success : function(response){
		  $("#cen_oficina_id").parent().html(response);
        }
      });
	  
	}	
	
}

function getOficinasTree(){
	
	$.ajax({
	  url        : "OficinasClass.php",
	  data       : "ACTIONCONTROLER=getOficinasTree",
	  beforeSend : function(){
		$("#oficinasTree").html("<img src='../../../framework/media/images/desktop/blue-loading.gif' />");
	  },
	  success    : function(response){
		$("#oficinasTree").html(response);
        $("#tree").treeTable();
      }
    });
	
}

$(document).ready(function(){

  $("#tree").treeTable(/*{ expandable: false} */);
  
  
  $("#empresa_id").change(function(){
     getOptionsOficina();
  });
  
});