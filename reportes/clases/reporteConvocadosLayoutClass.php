<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class reporteConvocadosLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   } 
   
	public function SetLimpiar($Permiso){
			$this -> Limpiar = $Permiso;
	}
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("reporteConvocadosClass.php","reporteConvocadosForm","reporteConvocadosForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
     $this -> TplInclude -> IncludeCss("../css/reportes.css");
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/reporteConvocados.js"); 
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
	 
     $this -> assign("CSSSYSTEM",	     $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	     $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		     $Form1 -> FormBegin());
     $this -> assign("FORM1END",	     $Form1 -> FormEnd()); 
	 $this -> assign("DESDE",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));		 	 
	 $this -> assign("HASTA",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));
	 $this -> assign("CONVOCADO",       	 $this -> objectsHtml -> GetobjectHtml($this -> fields[convocado]));	            // 25/06/2013
     $this -> assign("CONVOCADOID",     	 $this -> objectsHtml -> GetobjectHtml($this -> fields[convocado_id]));	        // 25/06/2013	 
	 $this -> assign("CONVOCATORIA",		     $this -> objectsHtml -> GetobjectHtml($this -> fields[convocatoria]));	
	 $this -> assign("CONVOCATORIAID",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[convocatoria_id]));
 	
	 
	 $this -> assign("GENERAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
	   
	 if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

//LISTA MENU

/*   public function setOficinas($oficinas){
	 $this -> fields[oficina_id]['options'] = $oficinas;
     $this -> assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));      
   }*/
   


    public function SetSi_Pro($Si_pro){
	  $this -> fields[si_convocatoria]['options'] = $Si_pro;
      $this -> assign("SI_CONVOCATORIA",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_convocatoria]));
    }
	public function SetSi_Pro2($Si_pro2){
	  $this -> fields[si_convocado]['options'] = $Si_pro2;
      $this -> assign("SI_CONVOCADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_convocado]));
    }
   public function RenderMain(){   
     $this -> RenderLayout('reporteConvocados.tpl');	 
   }
}

?>