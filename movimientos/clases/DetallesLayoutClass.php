<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesLayout extends View{

   private $fields;
     
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   public function SetBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setImputacionesContables($detalles){
   
     $this -> assign("DETALLES",$detalles);	  
   
   }   
   
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
     $this -> TplInclude -> IncludeJs("/application/nomina/movimientos/js/detalles.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.hotkeys.js");	 
	  	  
     $this -> assign("CSSSYSTEM",	          		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	          		$this -> TplInclude -> GetJsInclude());
     $this -> assign("abono_nomina_id",  $_REQUEST['abono_nomina_id']);	 

   }

   public function RenderMain(){
   
        $this -> RenderLayout('detalles.tpl');
	 
   }


}


?>