<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class reporteHojaVidaLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   } 
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("reporteHojaVidaClass.php","reporteHojaVidaForm","reporteHojaVidaForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeCss("/application/nomina/reportes/css/reportes.css");
	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.js");	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/application/nomina/reportes/js/ReporteHojaVida.js"); 
    //  $this -> TplInclude -> IncludeJs("/application/nomina/reportes/js/IndicadoresHojaVida.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.alerts.js");		 
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqeffects/jquery.magnifier.js");
	 $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.filestyle.js");
	 
     $this -> assign("CSSSYSTEM",	     $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	     $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		     $Form1 -> FormBegin());
     $this -> assign("FORM1END",	     $Form1 -> FormEnd());
	 $this -> assign("CONTRATO",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[contrato]));	
	 $this -> assign("CONTRATOID",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[contrato_id]));
   	 $this -> assign("ARRENDATARIO",     $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero]));  
   	 $this -> assign("ARRENDATARIOID",   $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));	 
	 
   $this -> assign("GENERAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	
    $this -> assign("GRAFICOS",        $this -> objectsHtml -> GetobjectHtml($this -> fields[graficos]));
	 $this -> assign("GENERAREXCEL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[generar_excel]));	

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
   }

//LISTA MENU
   
    /*public function SetOficina($oficina){
	  $this -> fields[oficina_id]['options'] = $oficina;
      $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }
    public function SetEstado($estado){
	  $this -> fields[estado_id]['options'] = $estado;
      $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_id]));
    }
    public function SetClase($clase){
	  $this -> fields[clase_id]['options'] = $clase;
      $this -> assign("CLASE",$this -> objectsHtml -> GetobjectHtml($this -> fields[clase_id]));
    }	
    public function SetSi_Des($Si_des){
    $this -> fields[destino_id]['options'] = $Si_des;
      $this -> assign("SI_DES",$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));
    }*/ 
    
    public function SetSi_Pro($Si_pro){
    $this -> fields[si_tipo]['options'] = $Si_pro;
      $this -> assign("SI_TIP",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_tipo]));
    }

    public function SetIndicadores($indicadores){
    $this -> fields[indicadores]['options'] = $indicadores;
      $this -> assign("INDICADORES",$this -> objectsHtml -> GetobjectHtml($this -> fields[indicadores]));
    }
    
   public function RenderMain(){   
     $this -> RenderLayout('ReporteHojaVida.tpl');	 
   }
}

?>