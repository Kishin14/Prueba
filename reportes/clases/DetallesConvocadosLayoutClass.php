<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesConvocadosLayout extends View{

   private $fields;
     
   public function setReporteMC1($DetallesConvocados){
     $this -> assign("DetallesConvocados",$DetallesConvocados);	  
   } 
   
    public function setReporteMC2($DetallesConvocados){
     $this -> assign("DetallesConvocados",$DetallesConvocados);	  
   } 
   
 public function setReporteMC3($DetallesConvocados){
     $this -> assign("DetallesConvocados",$DetallesConvocados);	  
   } 

 public function setReporteMC4($DetallesConvocados){
     $this -> assign("DetallesConvocados",$DetallesConvocados);	  
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
	 $this -> assign("convocatoria",   $_REQUEST['convocatoria']);
   }

   public function RenderMain(){
   
        $this -> RenderLayout('detallesConvocados.tpl');
	 
   }

}

?>