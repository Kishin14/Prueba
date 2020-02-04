<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetLiqFinInmLayout extends View{

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
   
   public function setDetallesSolicitudServicios($detallesSolicitudServicio){
   
     $this -> assign("DETALLES",$detallesSolicitudServicio);
   
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/generalDetalle.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");
	 	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/application/nomina/movimientos/js/DetLiqFinInm.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/colResizable-1.3.min.js");
	  	  
     $this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude());
     $this -> assign("SOLICITUDID",$_REQUEST['solicitud_id']);	 

   }

   public function setTipoIdentificacion($tipos_identificacion){
   
      $this -> assign("TIPOSID",$tipos_identificacion);          
   
   }
   
   public function setUnidades($unidades){

      $this -> assign("UNIDADES",$unidades);     

   }

   public function setUnidadesVolumen($unidades){

      $this -> assign("UNIDADESVOLUMEN",$unidades);     

   }

   public function RenderMain(){

        //$this -> enableDebugging();
   
        $this -> RenderLayout('DetLiqFinInm.tpl');
	 
   }


}


?>