<?php
require_once("../../../framework/clases/ViewClass.php");

final class ContableLayout extends View{

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
	$Form1      = new Form("ContableClass.php","ContableForm","ContableForm");
	$this	->	fields	=	$campos;
	
	$this	->	TplInclude	->	IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	$this	->	TplInclude	->	IncludeCss("../../../framework/css/reset.css");
	$this	->	TplInclude	->	IncludeCss("../../../framework/css/general.css");
	$this	->	TplInclude	->	IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 
	
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajaxupload.3.6.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqueryform.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/funciones.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/general.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-list.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	$this	->	TplInclude	->	IncludeJs("../js/contable.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
	$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");
	
	$this	->	assign("FORM1",							$Form1	->	FormBegin());
	$this	->	assign("FORM1END",						$Form1	->	FormEnd());
	$this	->	assign("CSSSYSTEM",						$this	->	TplInclude	->	GetCssInclude());
	$this	->	assign("JAVASCRIPT",					$this	->	TplInclude	->	GetJsInclude());
	$this	->	assign("BUSQUEDA",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
	$this	->	assign("CONTABLEID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[concepto_area_id]));
	$this	->	assign("DESCRIPCION",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[descripcion]));
	$this	->	assign("NATURALEZA_CONTRA",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[naturaleza_contrapartida]));
	$this	->	assign("NATURALEZA_ADMON",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[naturaleza_admon]));
	$this	->	assign("NATURALEZA_VENTAS",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[naturaleza_ventas]));
	$this	->	assign("NATURALEZA_PROD",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[naturaleza_prod]));
	$this	->	assign("ESTADO",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));
	$this	->	assign("TCALCULO",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tipo_calculo]));
	$this	->	assign("PUC_ADMON",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon]));
	$this	->	assign("PUC_ADMON_ID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_id]));
	$this	->	assign("PUC_VENTAS",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas]));
	$this	->	assign("PUC_VENTAS_ID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_id]));
	$this	->	assign("PUC_PROD",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_prod]));
	$this	->	assign("PUC_PROD_ID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_prod_id]));
	$this	->	assign("CONTRAPARTIDA_PUC_ID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrapartida_puc_id]));
	$this 	-> 	assign("BASE",							$this 	-> 	objectsHtml -> 	GetobjectHtml($this -> 	fields[base_salarial]));
	$this	->	assign("CONTRAPARTIDA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrapartida]));
	$this	->	assign("CONTABILIZA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contabiliza]));

	$this	->	assign("PUCPARTIDA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_partida]));
	$this	->	assign("PUCPARTIDAID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_partida_id]));
	$this	->	assign("PUCCONTRA",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra]));
	$this	->	assign("PUCCONTRAID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_id]));

	$this	->	assign("NATPARTIDA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[naturaleza_partida]));
	$this	->	assign("NATCONTRA",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[naturaleza_contra]));
	
	$this	->	assign("TIPONOVEDAD",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tipo_novedad]));

	if($this -> Guardar)
		$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	
	if($this -> Actualizar)
		$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	
	if($this -> Borrar)
		$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	
	if($this -> Limpiar)
		$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	}
	
	
	
	public function SetGridContable($Attributes,$Titles,$Cols,$Query){
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
		$this ->RenderLayout('contable.tpl');
	}
}
?>