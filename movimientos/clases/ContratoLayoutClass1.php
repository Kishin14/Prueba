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

		$this	->	TplInclude	->	IncludeCss("/application/framework/css/ajax-dynamic-list.css");
		$this	->	TplInclude	->	IncludeCss("/application/framework/css/reset.css");
		$this	->	TplInclude	->	IncludeCss("/application/framework/css/general.css");
		$this	->	TplInclude	->	IncludeCss("/application/framework/css/jquery.alerts.css");

		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jquery.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jqcalendar/jquery.ui.datepicker.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/ajaxupload.3.6.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jqueryform.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/funciones.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/general.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/ajax-list.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/ajax-dynamic-list.js");
		$this	->	TplInclude	->	IncludeJs("/application/nomina/movimientos/js/contrato.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jquery.alerts.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jquery.filestyle.js");

		$this	->	assign("FORM1",						$Form1	->	FormBegin());
		$this	->	assign("FORM1END",					$Form1	->	FormEnd());
		$this	->	assign("CSSSYSTEM",					$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",				$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("BUSQUEDA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this	->	assign("CONTRATO_ID",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrato_id]));
		$this	->	assign("NUMERO_CONTRATO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[numero_contrato]));
		$this	->	assign("FECHA_INICIO",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_inicio]));
		$this	->	assign("FECHA_TERMINACION",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_terminacion]));
		$this	->	assign("FECHA_TERMINACION_REAL",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_terminacion_real]));
		$this	->	assign("EMPLEADO_ID",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empleado_id]));
		$this	->	assign("EMPLEADO",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empleado]));
		$this	->	assign("CARGO_ID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cargo_id]));
		$this	->	assign("CARGO",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cargo]));
		$this	->	assign("SUELDO_BASE",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sueldo_base]));
		$this	->	assign("SUBSIDIO_TRANSPORTE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[subsidio_transporte]));
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
		$this	->	assign("INSTMED",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[insti_medico]));			
		$this	->	assign("ESCMED",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[escaner_medico]));			

		$this	->	assign("HORINI",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horario_ini]));			
		$this	->	assign("HORFIN",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horario_fin]));			

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