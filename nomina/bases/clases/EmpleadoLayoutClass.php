<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class EmpleadoLayout extends View{

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
			$Form1      = new Form("EmpleadoClass.php","EmpleadoForm","EmpleadoForm");
			$this	->	fields	=	$campos;

			$this	->	TplInclude	->	IncludeCss("../../../framework/css/ajax-dynamic-list.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/reset.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/general.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 
			$this	->	TplInclude	->	IncludeCss("../css/Empleado.css");

			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajaxupload.3.6.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqueryform.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/funciones.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/general.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-list.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-dynamic-list.js");
			$this	->	TplInclude	->	IncludeJs("../js/empleado.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

			$this	->	assign("FORM1",			$Form1	->	FormBegin());
			$this	->	assign("FORM1END",		$Form1	->	FormEnd());
			$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
			$this	->	assign("EMPLEADOID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[empleado_id]));
			$this	->	assign("SEXO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sexo]));
			$this	->	assign("FECHN",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_nacimiento]));
			$this	->	assign("VIVIENDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tipo_vivienda]));
			$this	->	assign("NHIJOS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[num_hijos]));
			$this	->	assign("ESTADO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));
			$this	->	assign("CONVOCADOID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[convocado_id]));
			$this	->	assign("TERCEROID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tercero_id]));
     		$this	->	assign("PROFESIONID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[profesion_id]));
			$this	->	assign("PROFESION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[profesion]));
			$this   -> assign("NUMEROIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion]));
			$this   -> assign("PRIMERAPELLIDO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[primer_apellido]));
		    $this   -> assign("SEGUNDOAPELLIDO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[segundo_apellido]));
		    $this   -> assign("PRIMERNOMBRE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[primer_nombre]));
		    $this   -> assign("OTROSNOMBRES",		$this -> objectsHtml -> GetobjectHtml($this -> fields[segundo_nombre]));
			$this   -> assign("TIPOPERSONA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_persona_id]));
			$this   -> assign("IMPORTARCONVOCADO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[importConvocado]));
			$this   -> assign("DIRECCION",  $this -> objectsHtml -> GetobjectHtml($this -> fields[direccion]));
			$this   -> assign("TELEFONO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[telefono]));
			$this   -> assign("MOVIL",  $this -> objectsHtml -> GetobjectHtml($this -> fields[movil]));
     		$this -> assign("FOTO",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[foto]));
			$this -> assign("CERTIFICADO",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[certificados]));
			$this -> assign("DOCUMENTO",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[documentos]));
     		


			if($this -> Guardar)
				$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

			if($this -> Actualizar)
				$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

			if($this -> Borrar)
				$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}
		
		public function SetTiposId($TiposId){
      $this -> fields[tipo_identificacion_id]['options'] = $TiposId;
      $this -> assign("TIPOIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_id]));
    }
   
    public function SetTiposPersona($TiposPersona){
	  $this -> fields[tipo_persona_id]['options'] = $TiposPersona;
      $this -> assign("TIPOPERSONA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_persona_id]));
    }

		public function SetEstadoCiv($estado_civil_id){
			$this -> fields[estado_civil_id]['options'] = $estado_civil_id;
			$this -> assign("ESTADOCIV",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_civil_id]));
		}


		// public function SetCivil($estado_civil_id){
		// 	$this -> fields[estado_civil_id]['options'] = $estado_civil_id;
		// 	$this -> assign("CIVILID",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_civil_id]));
		// }

		public function setConvocados($convocados){
		      $this -> assign("CONV",$convocados);     
		}

		public function SetGridEmpleado($Attributes,$Titles,$Cols,$Query){
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
			$this ->RenderLayout('empleado.tpl');
		}
	}
?>