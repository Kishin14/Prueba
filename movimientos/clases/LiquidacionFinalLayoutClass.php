<?php

require_once("../../../framework/clases/ViewClass.php");

final class LiquidacionFinalLayout extends View{

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

   public function setAnular($Permiso){
   	 $this -> Anular = $Permiso;
   }     
   
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("LiquidacionFinalClass.php","LiquidacionFinalForm","LiquidacionFinalForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
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
     $this -> TplInclude -> IncludeJs("../js/LiquidacionFinal.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("LIQDEFINITIVAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_definitiva_id]));	 
     $this -> assign("CONTRATOID",   		$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato_id]));
     $this -> assign("CONTRATO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato]));
	 $this -> assign("FECHAINI",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio]));
     $this -> assign("FECHAFIN",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));
	 $this -> assign("ESTADO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));

	 $this -> assign("BASE_LIQ",	     	$this -> objectsHtml -> GetobjectHtml($this -> fields[base_liquidacion]));
	 $this -> assign("JUSTIFICADO",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[justificado]));
	 $this -> assign("DIAS",	     		$this -> objectsHtml -> GetobjectHtml($this -> fields[dias]));
 	 $this -> assign("ENCABEZADOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));


	 $this -> assign("USUARIOID",	     		$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
	 $this -> assign("FECHAREG",	     		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));

	//anulacion
	 $this -> assign("USUARIOANUL_ID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_anulo_id]));
	 $this -> assign("FECHAANUL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_anulacion]));	  
	 $this -> assign("OBS_ANULACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));
	 $this -> assign("CAUSALANUL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));
	 
	 $this -> assign("TIPOIMPRE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_impresion]));


    
	
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

	//LISTA MENU

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALANUL",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }   


 	public function SetMotivoTer($TiposMotivoTerm){
      $this -> fields[motivo_terminacion_id]['options'] = $TiposMotivoTerm;
      $this -> assign("MOTIVO_TERMID",$this -> objectsHtml -> GetobjectHtml($this -> fields[motivo_terminacion_id]));
    }

 	public function SetCausalDes($TiposMotivoTerm){
      $this -> fields[causal_despido_id]['options'] = $TiposMotivoTerm;
      $this -> assign("CAUSALDESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_despido_id]));
    }

    public function SetGridLiquidacionFinal($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('LiquidacionFinal.tpl');
    }
}

?>