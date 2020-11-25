<?php
require_once("../../../framework/clases/ViewClass.php");

final class ConvocatoriaLayout extends View{

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
		$Form1      = new Form("ConvocatoriaClass.php","ConvocatoriaForm","ConvocatoriaForm");
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
		$this	->	TplInclude	->	IncludeJs("../js/Convocatoria.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

		$this	->	assign("FORM1",			$Form1	->	FormBegin());
		$this	->	assign("FORM1END",		$Form1	->	FormEnd());
		$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this	->	assign("CONVID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[convocatoria_id]));
		$this	->	assign("FAPERTURA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_apertura]));
		$this	->	assign("FCIERRE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_cierre]));
		$this	->	assign("ESTADO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));
		
		

		if($this -> Guardar)
			$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

		if($this -> Actualizar)
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

		if($this -> Borrar)
			$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

		if($this -> Limpiar)
			$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	}

	
	public function Setcargo($cargo_id){
		$this -> fields[cargo_id]['options'] = $cargo_id;
		$this -> assign("CARGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[cargo_id]));
	}

	public function SetGridConvocatoria($Attributes,$Titles,$Cols,$Query){
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
		$this ->RenderLayout('Convocatoria.tpl');
	}
}
?>