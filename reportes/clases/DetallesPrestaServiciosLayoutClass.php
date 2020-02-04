<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesPrestaServiciosLayout extends View{

   private $fields;
     
   public function setReporteMC1($DetallesPrestaServicios){
     $this -> assign("DetallesPrestaServicios",$DetallesPrestaServicios);	  
   } 

   public function setReporteMC2($DetallesPrestaServicios){
     $this -> assign("DetallesPrestaServicios",$DetallesPrestaServicios);	  
   } 


	public function setReporteMC3($DetallesPrestaServicios){
     $this -> assign("DetallesPrestaServicios",$$DetallesPrestaServicios);	  
   } 

	public function setReporteMC4($DetallesPrestaServicios){
     $this -> assign("DetallesPrestaServicios",$DetallesPrestaServicios);	  
   } 



   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../css/reportes.css");	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");   	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.hotkeys.js");	 
   	 $this -> TplInclude -> IncludeJs("../js/detalles.js");
	  	  
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude()); 
	 $this -> assign("desde",  		   $_REQUEST['desde']);	 
	 $this -> assign("hasta",  		   $_REQUEST['hasta']);	
	 $this -> assign("empleado",  	   $_REQUEST['empleado']);	 
	 $this -> assign("cargo",  		   $_REQUEST['cargo']);
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesPrestaServicios.tpl');
	 
   }

}

?>