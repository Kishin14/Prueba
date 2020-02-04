<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DeduccionFinalLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   public function setBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setDetallesRegistrar($detallesRegistrar){
   
     $this -> assign("DETALLES",$detallesRegistrar);
	 $this -> assign("RANGO",$_REQUEST['rango']);
   
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/generalDetalle.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.autocomplete.css");
	 $this -> TplInclude -> IncludeCss("/application/nomina/movimientos/css/detalle_registrar.css");	
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");
	 	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/application/nomina/movimientos/js/DeduccionFinal.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/colResizable-1.3.min.js");
	  	  
     $this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude());
     $this -> assign("LIQUIDACIONNOVID",$_REQUEST['liquidacion_novedad_id']);	 

   }

   
   
   public function RenderMain(){

        //$this -> enableDebugging();
   
        $this -> RenderLayout('DeduccionFinal.tpl');
	 
   }


}


?>