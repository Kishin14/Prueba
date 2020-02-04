<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesNovedadesFijasLayout extends View{

   private $fields;
     
   public function setReporteMC1($DetallesNovedadesFijas){
     $this -> assign("DetallesNovedadesFijas",$DetallesNovedadesFijas);	  
   } 

   public function setReporteMC2($DetallesNovedadesFijas){
     $this -> assign("DetallesNovedadesFijas",$DetallesNovedadesFijas);	  
   } 


	public function setReporteMC3($DetallesNovedadesFijas){
     $this -> assign("DetallesNovedadesFijas",$DetallesNovedadesFijas);	  
   } 

	public function setReporteMC4($DetallesNovedadesFijas){
     $this -> assign("DetallesNovedadesFijas",$DetallesNovedadesFijas);	  
   } 



   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("/application/nomina/reportes/css/reportes.css");	
	 $this -> TplInclude -> IncludeCss("/application/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");   	
	 $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/application/nomina/reportes/css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.hotkeys.js");	 
   	 $this -> TplInclude -> IncludeJs("/application/nomina/reportes/js/detalles.js");
	  	  
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude()); 
	 $this -> assign("desde",  		   $_REQUEST['desde']);	 
	 $this -> assign("hasta",  		   $_REQUEST['hasta']);	
	 
	 
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesNovedadesFijas.tpl');
	 
   }

}

?>