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
	
	 public function SetImprimir($Permiso){
		 $this -> Imprimir = $Permiso;
	} 

	public function SetAnular($Permiso){
		$this -> Anular = $Permiso;
	}

	public function SetLimpiar($Permiso){
		$this -> Limpiar = $Permiso;
	}

	public function SetCampos($campos){

		require_once("../../../framework/clases/FormClass.php");
		$Form1      = new Form("ContratoClass.php","ContratoForm","ContratoForm");
		$this	->	fields	=	$campos;

		$this	->	TplInclude	->	IncludeCss("../../../framework/css/ajax-dynamic-list.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/reset.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/general.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/jquery.alerts.css");

		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajaxupload.3.6.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqueryform.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/funciones.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/general.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-list.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-dynamic-list.js");
		$this	->	TplInclude	->	IncludeJs("../js/contrato.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

		$this	->	assign("FORM1",						$Form1	->	FormBegin());
		$this	->	assign("FORM1END",					$Form1	->	FormEnd());
		$this	->	assign("CSSSYSTEM",					$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",				$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("BUSQUEDA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this	->	assign("CONTRATO_ID",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrato_id]));
		$this	->	assign("NUMERO_CONTRATO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[numero_contrato]));
		$this	->	assign("PREFIJO",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[prefijo]));
		$this	->	assign("FECHA_INICIO",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_inicio]));
		$this	->	assign("FECHA_TERMINACION",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_terminacion]));
		$this	->	assign("FECHA_TERMINACION_REAL",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_terminacion_real]));
		$this	->	assign("EMPLEADO_ID",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empleado_id]));
		$this	->	assign("EMPLEADO",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empleado]));
		$this	->	assign("CARGO_ID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cargo_id]));
		$this	->	assign("CARGO",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cargo]));
		$this	->	assign("SUELDO_BASE",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sueldo_base]));
		$this	->	assign("SUBSIDIO_TRANSPORTE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[subsidio_transporte]));
		$this	->	assign("INGRESO_NOSALARIAL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[ingreso_nosalarial]));

		$this	->	assign("FECHA_ULTCES",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_ult_cesantias]));	
		$this	->	assign("FECHA_ULTINTCES",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_ult_intcesan]));	
		$this	->	assign("FECHA_ULTPRIMA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_ult_prima]));	
		$this	->	assign("FECHA_ULTVACA",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_ult_vaca]));			

		$this	->	assign("VALOR_ULTCES",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[valor_cesantias]));	
		$this	->	assign("VALOR_ULTINTCES",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[valor_intcesantias]));	
		$this	->	assign("VALOR_ULTPRIMA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[valor_prima]));	
		$this	->	assign("VALOR_ULTVACA",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[valor_vacaciones]));			

		$this	->	assign("PERIOCIDAD",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[periodicidad]));	
		$this	->	assign("ESTADO",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));			
		$this	->	assign("AREA",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[area_laboral]));			

		$this	->	assign("EMPEPSID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_eps_id]));			
		$this	->	assign("EMPEPS",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_eps]));			
		$this	->	assign("EMPPENID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_pension_id]));			
		$this	->	assign("EMPPEN",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_pension]));			
		$this	->	assign("EMPARLID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_arl_id]));			
		$this	->	assign("EMPARL",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_arl]));			
		$this	->	assign("EMPCAJID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_caja_id]));			
		$this	->	assign("EMPCAJ",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_caja]));			
		$this	->	assign("EMPCESID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_cesan_id]));			
		$this	->	assign("EMPCES",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_cesan]));			
		$this	->	assign("ESCEPS",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[escaner_eps]));			
		$this	->	assign("ESCPEN",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[escaner_pension]));			
		$this	->	assign("ESCARL",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[escaner_arl]));			
		$this	->	assign("ESCCAJA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[escaner_caja]));			
		$this	->	assign("ESCCESAN",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[escaner_cesan]));			
		$this	->	assign("NUMCUENTA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[numcuenta_proveedor]));			
		$this	->	assign("BANCO",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[banco]));			
		$this	->	assign("BANCOID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[banco_id]));			
		$this	->	assign("CERTBANC",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[escaner_bancario]));			
		
		$this	->	assign("EXAMENMEDICO",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[examen_medico]));
		$this	->	assign("EXAMENEGRESO",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[examen_egreso]));
		$this	->	assign("EXAMENPERIODICO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[examen_periodico]));
		$this	->	assign("SALUDOCU",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[salud_ocupacional]));			
		$this	->	assign("CARTASCYC",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cartas_cyc]));			
		$this	->	assign("ENTRDOTACION",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[entrega_dotacion]));			
		$this	->	assign("CONTRATOFIRMADO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrato_firmado]));			
		$this	->	assign("FOTO",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[foto]));			
		
		$this	->	assign("HORINI",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horario_ini]));			
		$this	->	assign("HORFIN",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horario_fin]));
		$this	->	assign("CARNE",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[carne]));	
		$this	->	assign("DOTACION",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[dotacion]));	
		$this	->	assign("INCAPACIDADES",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[incapacidades]));	
		$this	->	assign("PAZYSALVO",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[paz_salvo]));	
		$this	->	assign("CERTI_PROCURADURIA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[certi_procu]));	
		$this	->	assign("CERTI_ANTECEDENTES",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[certi_antece]));	
		$this	->	assign("CERTI_CONTRALORIA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[certi_contralo]));	
		$this	->	assign("CERTI_LIQUIDACION",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[certi_liquidacion]));	
		$this	->	assign("FECINIEPS",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_inicio_eps]));	
		$this	->	assign("FECINIPEN",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_inicio_pension]));	
		$this	->	assign("FECINIARL",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_inicio_arl]));	
		$this	->	assign("FECINICOM",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_inicio_compensacion]));	
		$this	->	assign("FECINICES",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_inicio_cesantias]));	
		
		
		$this	->	assign("LUGAREXP",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[lugar_expedicion_doc]));	
		$this	->	assign("LUGARTRAB",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[lugar_trabajo]));	

		if($this -> Guardar)
			$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

		if($this -> Actualizar)
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
			
		if($this -> Imprimir)
			$this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));

		if($this -> Anular)
			$this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));

		if($this -> Limpiar)
			$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	}
	
	public function SetARL($categoria_arl_id){
		$this -> fields[categoria_arl_id]['options'] = $categoria_arl_id;
		$this -> assign("ARLID",$this -> objectsHtml -> GetobjectHtml($this -> fields[categoria_arl_id]));
	}
	
	public function SetTiposCuenta($TiposCuenta){
		  $this -> fields[tipo_cta_id]['options'] = $TiposCuenta;
		  $this -> assign("TIPOCUENTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_cta_id]));
    }


	public function SetCosto($centro_de_costo_id){
		$this -> fields[centro_de_costo_id]['options'] = $centro_de_costo_id;
		$this -> assign("CENTRO_DE_COSTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[centro_de_costo_id]));
	}

	public function SetCausal($causal_despido_id){
		$this -> fields[causal_despido_id]['options'] = $causal_despido_id;
		$this -> assign("CAUSAL_DESPIDO",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_despido_id]));
	}
	
	public function SetTip($tipo_contrato_id){
		$this -> fields[tipo_contrato_id]['options'] = $tipo_contrato_id;
		$this -> assign("TIPO_CONTRATO_ID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_contrato_id]));
	}
	
	public function SetMot($motivo_terminacion_id){
		$this -> fields[motivo_terminacion_id]['options'] = $motivo_terminacion_id;
		$this -> assign("MOTIVO_TERMINACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[motivo_terminacion_id]));
	}

	public function SetGridContrato($Attributes,$Titles,$Cols,$Query){
		require_once("../../../framework/clases/grid/JqGridClass.php");
		$TableGrid = new JqGrid();
		$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
		$this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
		$this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
		$this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
	}

	public function RenderMain(){
		$this ->RenderLayout('contrato.tpl');
	}
}
?>