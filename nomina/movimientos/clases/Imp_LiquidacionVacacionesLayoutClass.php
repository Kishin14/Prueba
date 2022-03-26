<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_LiquidacionVacacionesLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../css/Imp_Extras.css");
	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("../css/Imp_Extras.css","print");	 
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   

  public function setLiquidacion1($liquidacion, $detalles){

	 $this -> assign("DETALLES",$liquidacion);
	 $this -> assign("DETALLESLIQ",$detalles);
	 $this -> assign("TIPOIMPRE",$_REQUEST['tipo_impresion']);
     $this -> assign("DESPREND",$_REQUEST['desprendibles']); 
	 $this -> assign("FECHA_INI",$liquidacion[0]['fecha_inicial']); 
	 $this -> assign("FECHA_FIN",$liquidacion[0]['fecha_final']); 	 

	 $this -> assign("LOGO",$liquidacion[0]['logo']); 	 
	 $this -> assign("NOMBREEMPRESA",$liquidacion[0]['nombre_empresa']); 	 
	 $this -> assign("NITEMPRESA",$liquidacion[0]['nit_empresa']); 	 

   
   }


   public function RenderMain(){

      $this -> RenderLayout('Imp_LiquidacionVacaciones.tpl');

   }


}

?>