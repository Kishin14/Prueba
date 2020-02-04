<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class LiquidacionLayout extends View{

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
			$Form1      = new Form("LiquidacionClass.php","LiquidacionForm","LiquidacionForm");
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
			$this	->	TplInclude	->	IncludeJs("/application/nomina/parametros_modulo/js/liquidacion.js");
			$this	->	TplInclude	->	IncludeJs("/application/framework/js/jqeffects/jquery.magnifier.js");
			$this	->	TplInclude	->	IncludeJs("/application/framework/js/jquery.alerts.js");
			$this	->	TplInclude	->	IncludeJs("/application/framework/js/jquery.filestyle.js");

			$this	->	assign("FORM1",							$Form1	->	FormBegin());
			$this	->	assign("FORM1END",						$Form1	->	FormEnd());
			$this	->	assign("CSSSYSTEM",						$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",					$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("BUSQUEDA",						$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
			$this	->	assign("LIQID",							$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[parametro_liquidacion_id]));
			$this	->	assign("CONTRAPARTIDA_PUC_ID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrapartida_puc_id]));
			$this	->	assign("CONTRAPARTIDA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrapartida]));

			if($this -> Guardar)
				$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

			if($this -> Actualizar)
				$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

			if($this -> Borrar)
				$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}


		public function SetTipo($tipo_concepto_laboral_id){
			$this -> fields[tipo_concepto_laboral_id]['options'] = $tipo_concepto_laboral_id;
			$this -> assign("NOMBRETIPO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_concepto_laboral_id]));
		}

		public function SetGridLiquidacion($Attributes,$Titles,$Cols,$Query){
			require_once("../../../framework/clases/grid/JqGridClass.php");
			$TableGrid = new JqGrid();
			$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
			$this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
			$this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
			$this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
		}

		public function RenderMain(){
			$this ->RenderLayout('liquidacion.tpl');
		}
	}
?>