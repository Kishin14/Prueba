<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class ExtrasLayout extends View{

		private $fields;

		public function SetGuardar($Permiso){
			$this -> Guardar = $Permiso;
		}

		public function SetActualizar($Permiso){
			$this -> Actualizar = $Permiso;
		}

		public function SetAnular($Permiso){
		$this -> Anular = $Permiso;
		}

		public function setHoraExtraFrame($hora_extra_id){

			$this -> fields[hora_extra_id]['value'] = $hora_extra_id;

			$this -> assign("HORAEXTRAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_extra_id]));	  	   

		}
		
		public function SetImprimir($Permiso){
			$this -> Imprimir = $Permiso;
		}

		public function SetLimpiar($Permiso){
			$this -> Limpiar = $Permiso;
		}

		public function SetCampos($campos){

			require_once("../../../framework/clases/FormClass.php");
			$Form1      = new Form("ExtrasClass.php","ExtrasForm","ExtrasForm");
			$this	->	fields	=	$campos;

			$this	->	TplInclude	->	IncludeCss("/application/framework/css/ajax-dynamic-list.css");
			$this	->	TplInclude	->	IncludeCss("/application/framework/css/reset.css");
			$this	->	TplInclude	->	IncludeCss("/application/framework/css/bootstrap.css");
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
			$this	->	TplInclude	->	IncludeJs("/application/nomina/movimientos/js/extras.js");
			$this	->	TplInclude	->	IncludeJs("/application/framework/js/jqeffects/jquery.magnifier.js");
			$this	->	TplInclude	->	IncludeJs("/application/framework/js/jquery.alerts.js");
			$this	->	TplInclude	->	IncludeJs("/application/framework/js/jquery.filestyle.js");

			$this	->	assign("FORM1",			$Form1	->	FormBegin());
			$this	->	assign("FORM1END",		$Form1	->	FormEnd());
			$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
			$this	->	assign("HORAEXTRAID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[hora_extra_id]));
			$this	->	assign("CONTRATOID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrato_id]));
			$this	->	assign("CONTRATO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrato]));
			$this	->	assign("SUELDO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sueldo_base]));												
			$this	->	assign("FECHAINI",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_inicial]));
			$this	->	assign("FECHAFIN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_final]));
			$this	->	assign("HRSEXTDIUR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horas_diurnas]));
			$this	->	assign("VREXTDIUR",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_diurnas]));
			$this	->	assign("HRSEXTNOCT",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horas_nocturnas]));			
			$this	->	assign("VREXTNOCT",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_nocturnas]));
			$this	->	assign("HRSEXTDIURFEST",$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horas_diurnas_fes]));
			$this	->	assign("VREXTDIURFEST",$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_diurnas_fes]));			
			$this	->	assign("HRSEXTNOCTFEST",$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horas_nocturnas_fes]));
			$this	->	assign("VREXTNOCTFEST",$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_nocturnas_fes]));
			$this	->	assign("HRSRECNOCT",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horas_recargo_noc]));
			$this	->	assign("VRRECNOCT",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_recargo_noc]));			
			$this	->	assign("HRSRECDOCT",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horas_recargo_doc]));
			$this	->	assign("VRRECDOCT",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_recargo_doc]));			
			$this	->	assign("VRRECINICIAL",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_festivo]));			
			$this	->	assign("VRHRNOCTURNO",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_nocturno]));			
			$this	->	assign("VRRECFESTIVO",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_recargo_festivo]));			
			$this	->	assign("VRHRDIURNO",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_diurna_fest]));			
			$this	->	assign("VRHREXTRNOC",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_extra_nocturna]));			
			$this	->	assign("VRHREXTRDIUR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_extra_diurna]));			
			$this	->	assign("VRHREXTRDIUR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_horas_extra_diurna]));			
			$this	->	assign("TOTAL",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[total]));			
			$this	->	assign("ESTADO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));	
			$this -> assign("ARCHIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[archivo]));								
			$this -> assign("PERSONAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[personas]));								
			 $this -> assign("OBSERVANULACION",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));								
			$this -> assign("PERSONAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[personas]));	
			
			

			if($this -> Guardar)
				$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
				$this -> assign("PROCESAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[procesar]));
				$this -> assign("PROCESARTODOS",	$this -> objectsHtml -> GetobjectHtml($this -> fields[procesar_todos]));

			if($this -> Actualizar)
				$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

			if($this -> Anular)
			$this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));
				
			if($this -> Imprimir)
				$this -> assign("IMPRIMIR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
	

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}

		public function setCausalesAnulacion($causales){
				$this -> fields[causal_anulacion_id]['options'] = $causales;
				$this -> assign("CAUSALANULACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
			}

		public function SetGridExtras($Attributes,$Titles,$Cols,$Query){
			require_once("../../../framework/clases/grid/JqGridClass.php");
			$TableGrid = new JqGrid();
			$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
			$this -> assign("GRIDEXTRAS",$TableGrid -> RenderJqGrid());
			$this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
			$this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
		}

		public function RenderMain(){
			$this ->RenderLayout('extras.tpl');
		}
	}
?>