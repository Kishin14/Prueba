<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesindicadoresEnfermedadesLayout extends View{

   private $fields;

     

   public function setReporte($detalles){

     $this -> assign("DETALLES",$detalles);	  

   }   

 

   public function setIncludes(){

	 

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

   	 $this -> TplInclude -> IncludeJs("../js/detindicadoresEnfermedades.js");
    //  $this -> TplInclude -> IncludeJs("../js/detalles.js");
	  	  

     $this -> assign("CSSSYSTEM",	          $this -> TplInclude -> GetCssInclude());

     $this -> assign("JAVASCRIPT",	          $this -> TplInclude -> GetJsInclude());

     //$this -> assign("si_tipo",  				  $_REQUEST['si_tipo']);	 

   }

   public function RenderMain(){

   

        $this -> RenderLayout('detindicadoresEnfermedades.tpl');

	 

   }



}



?>