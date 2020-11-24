<?php

require_once("../../../framework/clases/ViewClass.php");

final class VacacionLayout extends View{

   private $fields;
   
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   } 
   
   public function SetAnular($Permiso){
      $this -> Anular = $Permiso;
   }

   public function SetImprimir($Permiso){
      $this -> Imprimir = $Permiso;
    }

    public function setLiq_VacacionFrame($liquidacion_vacaciones_id){

	 $this -> fields[liquidacion_vacaciones_id]['value'] = $liquidacion_vacaciones_id;

     $this -> assign("CONSECUTIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_vacaciones_id]));	  	   

   }
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("VacacionClass.php","VacacionForm","VacacionForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap.css");
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/Vacacion.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
	 
	 $this -> assign("EMPLEADO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[empleado]));
	 $this -> assign("EMPLEADOID",   		$this -> objectsHtml -> GetobjectHtml($this -> fields[empleado_id]));
	 $this -> assign("FECHALIQ",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_liquidacion]));
	 $this -> assign("CONSECUTIVO",   		$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_vacaciones_id]));
	 $this -> assign("IDENTIFICACION",   	$this -> objectsHtml -> GetobjectHtml($this -> fields[num_identificacion]));
	 $this -> assign("CARGO",		   		$this -> objectsHtml -> GetobjectHtml($this -> fields[cargo]));
	 $this -> assign("SALARIO",		   		$this -> objectsHtml -> GetobjectHtml($this -> fields[salario]));
	 $this -> assign("CONCEPTO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto]));		 
	 $this -> assign("CONCEPTOITEM",		$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_item]));	
   $this -> assign("DIASDESCONTAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[dias]));
   $this -> assign("DIASDISFRUTAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[dias_disfrutar]));
   $this -> assign("DIASDISFRUTAREAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[dias_disfrutar_real]));	
   $this -> assign("VALORLIQUIDACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[valor]));	
   $this -> assign("DIASPAGAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[dias_pagados]));	
   $this -> assign("VALORLIQUIDACIONPAGAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_pagos]));
   $this -> assign("VALORTOTAL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_total]));
	 $this -> assign("FECHAINI",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_dis_inicio]));
     $this -> assign("FECHAFIN",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_dis_final]));
	 $this -> assign("FECHAINICONT",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio_contrato]));
     $this -> assign("FECHAREINTEGRO",  	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_reintegro]));
     $this -> assign("OBSERVACION",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));
	 
	 $this -> assign("SIEMPLEADO",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[si_empleado]));
     
	 $this -> assign("ESTADO",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	 
    $this -> assign("TIPOIMPRE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_impresion]));
    
   $this -> assign("USUARIOID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
	 $this -> assign("FECHAREGISTRO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));
	//anulacion
	 $this -> assign("USUARIOANUL_ID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_anulo_id]));
	 $this -> assign("FECHAANUL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_anulacion]));	  
	 $this -> assign("OBS_ANULACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));
	 $this -> assign("CAUSALANUL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));

     
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   $this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));
	 }
	 if($this -> Imprimir){
        $this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
		$this -> assign("PRINTOUT",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[print_out]));		
		$this -> assign("PRINTCANCEL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[print_cancel]));	
   }
   
   if($this -> Anular)
	   $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));

	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
 	public function SetTipoConcepto($TiposConcepto){
      $this -> fields[concepto_area_id]['options'] = $TiposConcepto;
      $this -> assign("CONCEPTOAREA",$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_area_id]));
    }

  public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALANUL",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }  
	
    public function SetGridVacacion($Attributes,$Titles,$Cols,$Query){
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
      $this ->RenderLayout('Vacacion.tpl');
    }
}

?>