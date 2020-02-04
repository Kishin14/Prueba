<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class reportesPrestaServiciosLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   } 
   
	public function SetLimpiar($Permiso){
			$this -> Limpiar = $Permiso;
	}
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("reportesPrestaServiciosClass.php","reportesPrestaServiciosForm","reportesPrestaServiciosForm");
	 
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
     $this -> TplInclude -> IncludeJs("../js/reportesPrestaServicios.js"); 
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
	 $this -> assign("EMPLEADO",       	 $this -> objectsHtml -> GetobjectHtml($this -> fields[empleado]));	            // 25/06/2013
     $this -> assign("EMPLEADOID",     	 $this -> objectsHtml -> GetobjectHtml($this -> fields[empleado_id]));	        // 25/06/2013	 
	 $this -> assign("CARGO",		     $this -> objectsHtml -> GetobjectHtml($this -> fields[cargo]));	
	 $this -> assign("CARGOID",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[cargo_id]));
 	
	 
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
	  $this -> fields[si_cargo]['options'] = $Si_pro;
      $this -> assign("SI_CAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_cargo]));
    }
	public function SetSi_Pro2($Si_pro2){
	  $this -> fields[si_empleado]['options'] = $Si_pro2;
      $this -> assign("SI_EM",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_empleado]));
    }
   public function RenderMain(){   
     $this -> RenderLayout('reportesPrestaServicios.tpl');	 
   }
}

?>