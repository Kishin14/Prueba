<?php

require_once("../../../framework/clases/ViewClass.php");

final class SolicPeriodosLayout extends View{

   private $fields;
   
   public function setIncludes(){
	   
	   
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/detalles.css");
     $this -> TplInclude -> IncludeCss("../css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../js/SolicPeriodos.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.hotkeys.js");	 
	   
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());

   }
   
   public function SetCampos($campos){
	   
     require_once("../../../framework/clases/FormClass.php");
	   
  	 $this -> fields = $campos;
	 
	 $this -> assign("ADICIONAR", $this -> GetobjectHtml($this -> fields[adicionar]));	 
 
   }


 	public function SetSolicPeriodos($detalles){
   
     $this -> assign("DETALLES",$detalles);	  
   
   }
   
   public function RenderMain(){
   
        $this -> RenderLayout('SolicPeriodos.tpl');
	 
   }

}

?>