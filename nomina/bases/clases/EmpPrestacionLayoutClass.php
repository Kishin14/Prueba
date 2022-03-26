<?php
require_once("../../../framework/clases/ViewClass.php");
final class EmpPrestacionLayout extends View{
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
		$Form1      = new Form("EmpPrestacionClass.php","EmpPrestacionForm","EmpPrestacionForm");
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
		$this	->	TplInclude	->	IncludeJs("../js/prestacion.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");
		$this	->	assign("FORM1",			$Form1	->	FormBegin());
		$this	->	assign("FORM1END",		$Form1	->	FormEnd());
		$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this	->	assign("EMPID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empresa_id]));
		$this	->	assign("TERID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tercero_id]));
		$this	->	assign("CODIGO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[codigo]));
		$this	->	assign("SALUD",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[salud]));
		$this	->	assign("PENSION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[pension]));
		$this	->	assign("ARL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[arl]));
		$this	->	assign("CAJA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[caja_compensacion]));
		$this	->	assign("CESANTIAS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cesantias]));
		$this	->	assign("PARAFISCALES",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[parafiscales]));
		
		//tabla tercero
		$this	->	assign("NUMID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[numero_identificacion]));
		$this	->	assign("DIGITO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[digito_verificacion]));
		$this	->	assign("RAZON",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[razon_social]));
		$this	->	assign("SIGLA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sigla]));
		$this	->	assign("EMAIL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[email]));
		$this	->	assign("TELEFAX",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[telefax]));
		$this	->	assign("TELEFONO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[telefono]));
		$this	->	assign("DIRECCION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[direccion]));
		$this	->	assign("UBICACIONID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[ubicacion_id]));
		$this	->	assign("UBICACION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[ubicacion]));
		
		$this	->	assign("MOVIL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[movil]));
		$this	->	assign("ESTADO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));
		$this	->	assign("RETEI",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[retei_proveedor]));
		$this	->	assign("AUTORET",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[autoret_proveedor]));

		if($this -> Guardar)
			$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
		if($this -> Actualizar)
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
		if($this -> Borrar)
			$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
		if($this -> Limpiar)
			$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	}
	public function SetTipoPersonas($tipo_persona_id){
		$this -> fields[tipo_persona_id]['options'] = $tipo_persona_id;
		$this -> assign("PERSONAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_persona_id]));
	}
	public function SetIdentificacion($tipo_identificacion_id){
		$this -> fields[tipo_identificacion_id]['options'] = $tipo_identificacion_id;
		$this -> assign("IDENTIFICACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_id]));
	}
	public function SetRegimen($regimen_id){
		$this -> fields[regimen_id]['options'] = $regimen_id;
		$this -> assign("REGIMENID",$this -> objectsHtml -> GetobjectHtml($this -> fields[regimen_id]));
	}
	public function SetGridEmpPrestacion($Attributes,$Titles,$Cols,$Query){
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
		$this ->RenderLayout('prestacion.tpl');
	}
}
?>