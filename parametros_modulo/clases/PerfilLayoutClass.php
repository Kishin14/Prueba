<?php
require_once("../../../framework/clases/ViewClass.php");

final class PerfilLayout extends View{

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
		$Form1      = new Form("PerfilClass.php","PerfilForm","PerfilForm");
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
		$this	->	TplInclude	->	IncludeJs("/application/nomina/parametros_modulo/js/perfil.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jquery.alerts.js");
		$this	->	TplInclude	->	IncludeJs("/application/framework/js/jquery.filestyle.js");

		$this	->	assign("FORM1",			$Form1	->	FormBegin());
		$this	->	assign("FORM1END",		$Form1	->	FormEnd());
		$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this	->	assign("PERFILID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[perfil_id]));
		$this	->	assign("EXPERIENCIA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[experiencia]));
		$this	->	assign("SEXO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sexo]));
		$this	->	assign("MINIMOEDAD",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[minimo_edad]));
		$this	->	assign("MAXIMOEDAD",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[maximo_edad]));
		$this	->	assign("RANGOSALMIN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[rango_sal_minimo]));
		$this	->	assign("RANGOSALMAX",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[rango_sal_maximo]));
		
		$this	->	assign("CARGOID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cargo_id]));
		$this	->	assign("BASE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[base]));
		$this	->	assign("NOMBRE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[nombre_cargo]));
		$this	->	assign("AREALAB",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[area_laboral]));

		$this	->	assign("OCUPACION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[ocupacion]));
		$this	->	assign("OCUPACIONID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[ocupacion_id]));

		if($this -> Guardar)
			$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

		if($this -> Actualizar)
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

		if($this -> Borrar)
			$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

		if($this -> Limpiar)
			$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	}


	public function SetEscolaridad($nivel_escolaridad_id){
		$this -> fields[nivel_escolaridad_id]['options'] = $nivel_escolaridad_id;
		$this -> assign("ESCOLARIDADID",$this -> objectsHtml -> GetobjectHtml($this -> fields[nivel_escolaridad_id]));
	}

	public function SetEscala($escala_salarial_id){
		$this -> fields[escala_salarial_id]['options'] = $escala_salarial_id;
		$this -> assign("ESCALAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[escala_salarial_id]));
	}

	public function SetARL($categoria_arl_id){
		$this -> fields[categoria_arl_id]['options'] = $categoria_arl_id;
		$this -> assign("ARLID",$this -> objectsHtml -> GetobjectHtml($this -> fields[categoria_arl_id]));
	}

	public function SetCivil($estado_civil_id){
		$this -> fields[estado_civil_id]['options'] = $estado_civil_id;
		$this -> assign("CIVILID",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_civil_id]));
	}

	public function SetGridPerfil($Attributes,$Titles,$Cols,$Query){
		require_once("../../../framework/clases/grid/JqGridClass.php");
		$TableGrid = new JqGrid();
		$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
		$this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
		$this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
		$this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
	}

	public function RenderMain(){
		$this ->RenderLayout('perfil.tpl');
	}
}
?>