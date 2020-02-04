<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class ConyugeEmpleadoLayout extends View{

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
   
   public function setConyugeEmpleado($ConyugeEmpleado){   
     $this -> assign("CONYUGEEM",$ConyugeEmpleado);   
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/generalDetalle.css");
     $this -> TplInclude -> IncludeCss("https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeJs("https://code.jquery.com/jquery-2.2.0.min.js");
     
     $this ->  TplInclude  ->  IncludeJs("https://code.jquery.com/ui/1.11.4/jquery-ui.js");
     
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funcionesDetalle.js");
	 
	   $this -> TplInclude -> IncludeJs("/application/framework/js/funcionesDetalle.js");
 
     $this -> TplInclude -> IncludeJs("/application/nomina/bases/js/ConyugeEmpleado.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/colResizable-1.3.min.js");
	  	  
     $this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude());
     $this -> assign("CONYID",$this -> requestData('empleado_id'));
   }
   public function setConyuge($Conyuge){
      $this -> assign("CONYUGES",$Conyuge);     
   }
   public function setTip($tipos){
      $this -> assign("TIP",$tipos);     
   }

   public function RenderMain(){

        //$this -> enableDebugging();
   
        $this -> RenderLayout('ConyugeEmpleado.tpl');
	 
   }


}


?>