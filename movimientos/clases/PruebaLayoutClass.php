	<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class PruebaLayout extends View{

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
			$Form1      = new Form("PruebaClass.php","PruebaForm","PruebaForm");
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
			$this	->	TplInclude	->	IncludeJs("../js/Prueba.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

			$this	->	assign("FORM1",			$Form1	->	FormBegin());
			$this	->	assign("FORM1END",		$Form1	->	FormEnd());
			$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
			$this	->	assign("PRUEBA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[prueba_id]));
			$this	->	assign("NOMBRE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[nombre]));
			$this	->	assign("OBSERVACIONES",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[observacion]));
			$this	->	assign("RESULTADO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[resultado]));
			$this	->	assign("BASE",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[base]));
			$this	->	assign("CONVOCADOID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[convocado_id]));
			$this	->	assign("CONVOCADO",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[convocado]));
			$this	->	assign("FECHA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha]));
			$this	->	assign("EVIPRUEBA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[prueba]));
			$this	->	assign("APROBADO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[aprobado]));

			if($this -> Guardar)
				$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

			if($this -> Actualizar)
				$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

			if($this -> Borrar)
				$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}

	
		public function SetGridPrueba($Attributes,$Titles,$Cols,$Query){
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
			$this ->RenderLayout('Prueba.tpl');
		}
	}
?>