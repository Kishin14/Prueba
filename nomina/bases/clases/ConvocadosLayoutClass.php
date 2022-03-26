<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class ConvocadosLayout extends View{

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
			$Form1      = new Form("ConvocadosClass.php","ConvocadosForm","ConvocadosForm");
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
			$this	->	TplInclude	->	IncludeJs("../js/convocados.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

			$this	->	assign("FORM1",						$Form1	->	FormBegin());
			$this	->	assign("FORM1END",					$Form1	->	FormEnd());
			$this	->	assign("CSSSYSTEM",					$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",				$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("BUSQUEDA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
			$this	->	assign("CONVOCADO_ID",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[convocado_id]));
			$this	->	assign("NUMERO_IDENTIFICACION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[numero_identificacion]));
			$this	->	assign("PRIMER_NOMBRE",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[primer_nombre]));
			$this	->	assign("SEGUNDO_NOMBRE",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[segundo_nombre]));
			$this	->	assign("PRIMER_APELLIDO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[primer_apellido]));
			$this	->	assign("SEGUNDO_APELLIDO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[segundo_apellido]));
			$this	->	assign("DIRECCION",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[direccion]));
			$this	->	assign("TELEFONO",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[telefono]));
			$this	->	assign("MOVIL",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[movil]));
			$this	->	assign("UBICACION_ID",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[ubicacion_id]));
			$this	->	assign("UBICACION",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[ubicacion]));
			$this	->	assign("ESTADO",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));			

			if($this -> Guardar)
				$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

			if($this -> Actualizar)
				$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

			if($this -> Borrar)
				$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}

		public function SetTip($tipo_identificacion_id){
			$this -> fields[tipo_identificacion_id]['options'] = $tipo_identificacion_id;
			$this -> assign("TIPO_IDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_id]));
		}

		/*public function SetUbi($ubicacion_id){
			$this -> fields[ubicacion_id]['options'] = $ubicacion_id;
			$this -> assign("UBICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_id]));
		}*/

		public function SetGridConvocados($Attributes,$Titles,$Cols,$Query){
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
			$this ->RenderLayout('convocados.tpl');
		}
	}
?>