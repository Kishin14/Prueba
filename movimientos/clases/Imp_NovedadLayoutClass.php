<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_NovedadLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/nomina/movimientos/css/Imp_Contratos.css");
	 
	 $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("/application/nomina/movimientos/css/Imp_Contratos.css","print");	 
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
   
   public function setNovedad($documento){
     $this -> assign("DATOS",$documento[0]);
   }
  
  
  public function setDetallesNovedad($DetallesNovedad){   
     $this -> assign("DETALLES",$DetallesNovedad);   
   }
  
   public function RenderMain(){

      $this -> RenderLayout('Imp_Novedad.tpl');

   }


}

?>