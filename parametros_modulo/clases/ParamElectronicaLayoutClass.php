<?php

require_once("../../../framework/clases/ViewClass.php");

final class ParamElectronicaLayout extends View{

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
	 
     $Form1      = new Form("ParamElectronicaClass.php","ParamElectronicaForm","ParamElectronicaForm");
	 
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
     $this -> TplInclude -> IncludeJs("../js/ParamElectronica.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("PARAMEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[param_nom_electronica_id]));
     $this -> assign("URL",			$this -> objectsHtml -> GetobjectHtml($this -> fields[wsdl]));	 
     $this -> assign("URLANEXO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[wsanexo]));
	   $this -> assign("URLPRUEBA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[wsdl_prueba]));	 
     $this -> assign("URLPRUEBAANEXO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[wsanexo_prueba]));
     $this -> assign("TOKENEMPRESA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tokenenterprise]));
	   $this -> assign("TOKENAUTORIZACION",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[tokenautorizacion]));
	   $this -> assign("CORREO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[correo]));
	   $this -> assign("PREFIJO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[prefijo]));
	   $this -> assign("RANGO_COMIENZA",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[rango_comienza]));
	   $this -> assign("RANGO_FINAL",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[rango_final]));
	   $this -> assign("RANGO_INICIAL",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[rango_inicial]));
	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
    public function SetEstado($Estado){
      $this -> fields[estado]['options'] = $Estado;
      $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
    }

    public function SetAmbiente($Ambiente){
      $this -> fields[ambiente]['options'] = $Ambiente;
      $this -> assign("AMBIENTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[ambiente]));
    }

   
    public function SetGridParamElectronica($Attributes,$Titles,$Cols,$Query){
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
      $this ->RenderLayout('ParamElectronica.tpl');
    }

}

?>