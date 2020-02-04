<?php

require_once("../../../framework/clases/ViewClass.php");

final class SolicServToConvocadoLayout extends View{

   private $fields;
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");
	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/application/nomina/bases/js/SolicServToConvocado.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());

   }
   
   public function setCampos($campos){
	   
     require_once("../../../framework/clases/FormClass.php");
	   
  	 $this -> fields = $campos;
	 
	 $this -> assign("CONVOCADO", $this -> getObjectHtml($this -> fields[convocado]));	 
 
   }


//// GRID ////
  		public function SetGridSolicServToConvocados($Attributes,$Titles,$Cols,$Query){
			require_once("../../../framework/clases/grid/JqGridClass.php");
			$TableGrid = new JqGrid();
			$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
			$this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
			$this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
			$this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
		}

   public function RenderMain(){
   
        $this -> RenderLayout('SolicServToConvocado.tpl');
	 
   }

}

?>