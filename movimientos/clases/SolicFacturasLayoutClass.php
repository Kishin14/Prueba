<?php

require_once("../../../framework/clases/ViewClass.php");

final class SolicFacturasLayout extends View{

   private $fields;
   
   public function setIncludes(){
	   
	   
     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/application/nomina/movimientos/css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/application/nomina/movimientos/js/SolicFacturas.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.hotkeys.js");	 
	   
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());

   }
   
   public function SetCampos($campos){
	   
     require_once("../../../framework/clases/FormClass.php");
	   
  	 $this -> fields = $campos;
	 
	 $this -> assign("ADICIONAR", $this -> GetobjectHtml($this -> fields[adicionar]));	 
 
   }


 	public function SetSolicFacturas($detalles){
   
     $this -> assign("DETALLES",$detalles);	
	 $this -> assign("empleado_id",$_REQUEST['empleado_id']);	
	 $this -> assign("empleados",  $_REQUEST['empleados']);		 
   
   }


   public function RenderMain(){
   
        $this -> RenderLayout('SolicFacturas.tpl');
	 
   }

}

?>