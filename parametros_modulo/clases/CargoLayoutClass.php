<?php
require_once("../../../framework/clases/ViewClass.php");

final class CargoLayout extends View{

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
		$Form1      = new Form("CargoClass.php","CargoForm","CargoForm");
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
		$this	->	TplInclude	->	IncludeJs("../js/cargo.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

		$this	->	assign("FORM1",			$Form1	->	FormBegin());
		$this	->	assign("FORM1END",		$Form1	->	FormEnd());
		$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this	->	assign("CARGOID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cargo_id]));
		$this	->	assign("NOMBRE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[nombre_cargo]));
		$this	->	assign("BASE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[base]));

		if($this -> Guardar)
			$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

		if($this -> Actualizar)
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

		if($this -> Borrar)
			$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

		if($this -> Limpiar)
			$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	}

	public function SetARL($categoria_arl_id){
		$this -> fields[categoria_arl_id]['options'] = $categoria_arl_id;
		$this -> assign("ARLID",$this -> objectsHtml -> GetobjectHtml($this -> fields[categoria_arl_id]));
	}

	public function SetGridCargo($Attributes,$Titles,$Cols,$Query){
		require_once("../../../framework/clases/grid/JqGridClass.php");
		$TableGrid = new JqGrid();
		$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
		$this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
		$this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
		$this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
	}

	public function RenderMain(){
		$this ->RenderLayout('cargo.tpl');
	}
}
?>