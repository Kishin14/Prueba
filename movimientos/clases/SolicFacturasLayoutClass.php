<?php

require_once("../../../framework/clases/ViewClass.php");

final class SolicFacturasLayout extends View{

   private $fields;
   
   public function setIncludes(){
	   
	   
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
     $this -> TplInclude -> IncludeJs("../js/SolicFacturas.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 	 		   	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.hotkeys.js");	 
	   
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());

   }
   
   public function SetCampos($campos){
	   
     require_once("../../../framework/clases/FormClass.php");
 
   }


 	public function SetSolicFacturas($detalles){
   
   $this -> assign("DETALLESFACTURAS",$detalles);	
	 $this -> assign("empleado_id",$_REQUEST['empleado_id']);	
	 $this -> assign("empleados",  $_REQUEST['empleados']); 	 
   
   }
   
 	public function SetSolicVacaciones($detalles){
   
   $this -> assign("DETALLESVACACIONES",$detalles);		 
   
   }
   
 	public function SetSolicPrimas($detalles){
   
   $this -> assign("DETALLESPRIMAS",$detalles);		 
   
   }
   
 	public function SetSolicCesantias($detalles){
   
   $this -> assign("DETALLESCESANTIAS",$detalles);		 
   
   }
   
 	public function SetSolicIntCesantias($detalles){
   
   $this -> assign("DETALLESINTCESANTIAS",$detalles);		 
   
   }


   public function RenderMain(){
   
        $this -> RenderLayout('SolicFacturas.tpl');
	 
   }

}

?>