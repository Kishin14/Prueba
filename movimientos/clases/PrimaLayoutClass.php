<?php

require_once("../../../framework/clases/ViewClass.php");

final class PrimaLayout extends View{

   private $fields;
   
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }   
    public function SetImprimir($Permiso){
	 $this -> Imprimir = $Permiso;
   } 

   public function setLiq_PrimaFrame($liquidacion_prima_id){

	 $this -> fields[liquidacion_prima_id]['value'] = $liquidacion_prima_id;

     $this -> assign("LIQUIDACIONPRIMAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_prima_id]));	  	   

   }

   public function SetBorrar($Permiso){
      $this -> Borrar = $Permiso;
    }
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("PrimaClass.php","PrimaForm","PrimaForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/Prima.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 //busqueda por fechas
	 $this -> assign("BUSQUEDA1",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda_fecha]));
	 
	 
	 $this -> assign("CONSECUTIVO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo]));
	 $this -> assign("EMPLEADO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[empleado]));
	 $this -> assign("EMPLEADOID",   		$this -> objectsHtml -> GetobjectHtml($this -> fields[empleado_id]));
	 $this -> assign("FECHALIQ",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_liquidacion]));
	 $this -> assign("LIQUIDACIONPRIMAID",   		$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_prima_id]));
	 $this -> assign("IDENTIFICACION",   	$this -> objectsHtml -> GetobjectHtml($this -> fields[num_identificacion]));
	 $this -> assign("CARGO",		   		$this -> objectsHtml -> GetobjectHtml($this -> fields[cargo]));
	 $this -> assign("SALARIO",		   		$this -> objectsHtml -> GetobjectHtml($this -> fields[salario]));
	 $this -> assign("TIPOLIQUIDACION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_liquidacion]));		 
    $this -> assign("VALORLIQUIDACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[total]));	
    $this -> assign("VALORACUMULADO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[acumulado]));	
    $this -> assign("VALORDIFERENCIA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[diferencia]));	
	  $this -> assign("FECHAINICONT",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio_contrato]));
     
     $this -> assign("OBSERVACION",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));
	 
	  $this -> assign("PERIODO",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo]));
	 
	  $this -> assign("SIEMPLEADO",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[si_empleado]));
     
   $this -> assign("ESTADO",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
   
   $this -> assign("FECHALOG",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_abono_nomina]));	   
	 $this -> assign("OBSERVACIONES",$this -> objectsHtml -> GetobjectHtml($this -> fields[desc_anul_abono_nomina]));
     
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar){
     $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
     $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));
	   $this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));
	 }
	 if($this -> Imprimir){
		$this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
		$this -> assign("PRINTOUT",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[print_out]));		
		$this -> assign("PRINTCANCEL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[print_cancel]));				
		$this -> assign("TIPOIMPRE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_impresion]));
	 	$this -> assign("DESPRENDIBLES",	$this -> objectsHtml -> GetobjectHtml($this -> fields[desprendibles]));
	 
	}
	 
	 if($this -> Borrar)
        $this -> assign("BORRAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	
	 
 	public function SetTipoConcepto($TiposConcepto){
      $this -> fields[concepto_area_id]['options'] = $TiposConcepto;
      $this -> assign("CONCEPTOAREA",$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_area_id]));
    }

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }


   public function setUsuarioId($usuario,$oficina){	  
	  
	   $this -> fields[anul_usuario_id]['value'] = $usuario;
     $this -> assign("ANULUSUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_usuario_id]));	  
	 
   }   
	
    public function SetGridPrima($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('Prima.tpl');
    }
}

?>