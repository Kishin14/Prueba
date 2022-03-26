<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesPruebaLayout extends View{

   private $fields;
     
   public function setReporteMC1($DetallesPrueba){
     $this -> assign("DetallesPrueba",$DetallesPrueba);	  
	    
   }

 public function setReporteMC2($DetallesPrueba){
     $this -> assign("DetallesPrueba",$DetallesPrueba);	  
	    
   }
   
   public function setReporteMC3($DetallesPrueba){
     $this -> assign("DetallesPrueba",$DetallesPrueba);	  
	    
   }
   
    
   public function setReporteMC4($DetallesPrueba){
     $this -> assign("DetallesPrueba",$DetallesPrueba);	  
	    
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
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 		 	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 	 		   	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.hotkeys.js");	 
   	 $this -> TplInclude -> IncludeJs("../js/detalles.js");
	  	  
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude()); 
	 $this -> assign("desde",  		   $_REQUEST['desde']);	 
	 $this -> assign("hasta",  		   $_REQUEST['hasta']);	
	 $this -> assign("convocado",  	   $_REQUEST['convocado']);	 
	 $this -> assign("cargo",  		   $_REQUEST['cargo']);
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesPrueba.tpl');
	 
   }

}

?>