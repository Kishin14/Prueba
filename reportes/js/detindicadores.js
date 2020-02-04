function viewDocument(encabezado_registro_id){
	
  var QueryString = "../../../contabilidad/clases/LibrosAuxiliaresClass.php?ACTIONCONTROLER=viewDocument&encabezado_registro_id="+encabezado_registro_id;
  var title       = "Visualizacion DOcumento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}
function viewDocumentfact(factura_id){
	
  var QueryString = "../../factura/clases/FacturaClass.php?ACTIONCONTROLER=onclickPrint&factura_id="+factura_id;
  var title       = "Visualizacion DOcumento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}