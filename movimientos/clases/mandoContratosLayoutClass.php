<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class mandoContratosLayout extends View{

 
   private $fields;

     public function setIncludes(){
 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../facturacion/Contratos/css/mandoContratos.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/sweetalert2/dist/sweetalert2.min.css");
     

     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	   $this -> TplInclude -> IncludeJs("../../../nomina/movimientos/js/mandoContratos.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/sweetalert2/dist/sweetalert2.min.js");
      	

	 
     $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> getCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> getJsInclude());


   }



//// GRID ////  

   public function SetGridMandoContratos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	   $TableGrid = new JqGrid();
 	   $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDmandoContratos",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());

   }


   public function RenderMain(){

        $this -> RenderLayout('mandoContratos.tpl');

   }


}



?>