<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesindicadoresLayout extends View{

   private $fields;

     

   public function setReporte($detalles){

     $this -> assign("DETALLES",$detalles);	  

   }   

  /*  public function setReporteRF1($detalles){

     $this -> assign("DETALLES",$detalles);	  

   }   

   public function setReporteEC1($detalles){

     $this -> assign("DETALLES",$detalles);	  

   }   

   public function setReportePE1($detalles){

     $this -> assign("DETALLES",$detalles);	  

   }   

   public function setReporteFP_ALL($detalles){

     $this -> assign("DETALLES",$detalles);	  

   }   

   public function setReporteRF_ALL($detalles){

     $this -> assign("DETALLES",$detalles);	  

   }   

   public function setReporteEC_ALL($detalles){

     $this -> assign("DETALLES",$detalles); 	  

   }   

   public function setReportePE_ALL($detalles){

     $this -> assign("DETALLES",$detalles);	  

   } 

  public function setReporteGR_ALL($tipo,$detalles){
    print_r($detalles);
      $this -> assign("tipo",$tipo);   
     $this -> assign("DETALLES",$detalles);   

   }   

  public function setReporteGR_BAR($tipo,$detalles){
      $this -> assign("tipo",$tipo);   
     $this -> assign("DETALLES",$detalles);   
   }   */
  

   public function setIncludes(){

	 

     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");

     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css");

     $this -> TplInclude -> IncludeCss("/application/nomina/reportes/css/detalles.css");	 

     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.autocomplete.css");	 	 

     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");		 	 

	 

     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.js");

     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.autocomplete.js");	

     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");

     $this -> TplInclude -> IncludeJs("/application/framework/js/funcionesDetalle.js");

     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.alerts.js");	 		   	 

     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.hotkeys.js");	 

   	 $this -> TplInclude -> IncludeJs("/application/nomina/reportes/js/detindicadores.js");
    //  $this -> TplInclude -> IncludeJs("/application/nomina/reportes/js/detalles.js");
	  	  

     $this -> assign("CSSSYSTEM",	          $this -> TplInclude -> GetCssInclude());

     $this -> assign("JAVASCRIPT",	          $this -> TplInclude -> GetJsInclude());

     $this -> assign("si_tipo",  				  $_REQUEST['si_tipo']);	 

   }

   public function RenderMain(){

   

        $this -> RenderLayout('detindicadores.tpl');

	 

   }



}



?>