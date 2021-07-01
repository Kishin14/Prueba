<?php
require_once("../../../framework/clases/ViewClass.php");
final class ContratoLayout extends View{

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
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("ContratoClass.php","contratoForm","ContratoForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/contrato.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("TIPOCONTRATOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_contrato_id]));	 
     $this -> assign("NOMBRE",     $this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));
	 $this -> assign("PREFIJO",     $this -> objectsHtml -> GetobjectHtml($this -> fields[prefijo]));
     $this -> assign("DESCRIPCION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));
     $this -> assign("PERIODO_PRUEBA",     $this -> objectsHtml -> GetobjectHtml($this -> fields[periodo_prueba]));
     $this -> assign("INDEMNIZACION",     $this -> objectsHtml -> GetobjectHtml($this -> fields[indemnizacion]));
     $this -> assign("LIQUIDACION",     $this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion]));
     $this -> assign("PRESTACIONES",     $this -> objectsHtml -> GetobjectHtml($this -> fields[prestaciones_sociales]));
	 $this -> assign("TIPO",     $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));
	 
	 $this -> assign("TIEMPOCONTRATO",     $this -> objectsHtml -> GetobjectHtml($this -> fields[tiempo_contrato]));

	 $this -> assign("SALUD",     $this -> objectsHtml -> GetobjectHtml($this -> fields[salud]));
	 $this -> assign("PENSION",     $this -> objectsHtml -> GetobjectHtml($this -> fields[pension]));
	 $this -> assign("ARL",     $this -> objectsHtml -> GetobjectHtml($this -> fields[arl]));

     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 if($this -> Borrar)
        $this -> assign("BORRAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
   
    public function SetGridContrato($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
     
	   $TableGrid = new JqGrid();
    
 	   $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
    
     $head = "'<head>".
	 
     $TableGrid -> GetJqGridJs()." ".
    
     $TableGrid -> GetJqGridCss()."
    
     </head>";
    
     $body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
    
     return "<html>".$head." ".$body."</html>";
    
    }
     
    public function RenderMain(){
      $this ->RenderLayout('contrato.tpl');
    }
}

?>