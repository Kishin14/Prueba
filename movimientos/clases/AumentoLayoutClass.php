<?php
require_once("../../../framework/clases/ViewClass.php");

final class AumentoLayout extends View{

	private $fields;
	private $Guardar;
	private $Actualizar;
	private $Limpiar;

	public function setGuardar($Permiso){
		$this	->	Guardar = $Permiso;
	}

	public function setActualizar($Permiso){
		$this	->	Actualizar = $Permiso;
	}

   public function setImprimir($Imprimir){
	 $this -> Imprimir = $Imprimir;
   }

	public function setLimpiar($Permiso){
		$this	->	Limpiar = $Permiso;
	}

	public function setCampos($campos){
		require_once("../../../framework/clases/FormClass.php");

		$Form1	=	new Form("AumentoClass.php","AumentoForm","AumentoForm");
		$this	->	fields		=	$campos;
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/jquery.alerts.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/ajax-dynamic-list.css");
		$this	->	TplInclude	->	IncludeCss("../css/Aumento.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/reset.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/general.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/bootstrap.css");
		
		

		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.js");
		$this 	-> 	TplInclude	-> 	IncludeJs("../../../framework/js/jqcalendar/jquery-ui-1.8.1.custom.min.js");	
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqueryform.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/funciones.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-list.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-dynamic-list.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
		$this	->	TplInclude	->	IncludeJs("../js/Aumento.js");
		$this	->	TplInclude	->	IncludeJs("../js/DetallesAumento.js");

		$this	->	assign("CSSSYSTEM",				$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",			$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("FORM1",					$Form1	->	FormBegin());
		$this	->	assign("FORM1END",				$Form1	->	FormEnd());
		$this	->	assign("BUSQUEDA",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this	->	assign("SOLICITUDID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[solicitud_id]));
		$this	->	assign("CONSECUTIVO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[consecutivo]));
		$this	->	assign("CONSECUTIVO2",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[consecutivo2]));
		$this	->	assign("CONSECUTIVORENUEVA",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[consecutivo_renueva]));
		$this	->	assign("OBSERVACIONRENUEVA",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[observacion_renovacion]));
		$this 	->  assign("CONTRATO",				$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[contrato]));
		$this 	-> 	assign("CONTRATOID",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->	fields[contrato_id]));
		$this 	->  assign("DESDE",					$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_inicio]));		 	 
		$this	->  assign("HASTA",					$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_final]));
		$this	->	assign("OBSERVACION",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[observacion_retiro]));
		$this	->	assign("CLIENTE",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cliente]));
		$this	->	assign("CLIENTEFINALIZA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cliente_finaliza]));
		//$this	->	assign("CLIENTERENUEVA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cliente_renueva]));
		$this	->	assign("CANON",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[canon]));
		$this	->	assign("ESTADO",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));
		$this 	->  assign("FECHAINICIO2",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_inicio2]));		 	 
		$this	->  assign("FECHAFINAL2",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_final2]));
		$this 	->  assign("FECHAINIRENOVACION",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_inicio_renovacion]));		 	 
		$this	->  assign("FECHAFINRENOVACION",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_final_renovacion]));
		$this	->	assign("CANONRENUEVA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[canon_renovacion]));
		$this	->	assign("CANONVIEJO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[canon_viejo]));
		$this	->	assign("CANONANTIGUOACTUALIZA",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[canon_antiguo_actualiza]));
		$this 	->  assign("FECHARETIRO",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_retiro]));
		$this 	->  assign("FECHAENTREGA",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_entrega]));
		$this 	->  assign("FECHACONTRATO",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_solicitud]));
		$this 	->  assign("FECHACONTRATORENUEVA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_solicitud_renueva]));
		$this 	->  assign("PROPIETARIO",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[propietario_id]));
		$this 	->  assign("ARRENDATARIO",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[arrendatario_id]));
		$this 	->  assign("ADMINISTRACION",		$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[administracion]));
		$this 	->  assign("PROPIETARIORENUEVA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[propietario_renueva]));
		$this 	->  assign("ARRENDATARIORENUEVA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[arrendatario_renueva]));
		$this	->	assign("OBSERVACIONACTUALIZA",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[observacion_actualiza]));
		$this 	->  assign("CONSECUTIVOACTUALIZA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[consecutivo_actualiza]));		 	 
		$this	->  assign("FECHASOLICACTUALIZA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_solicitud_actualiza]));
		$this	->	assign("FECHAINI2ACTUALIZA",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha_inicio_2_actualiza]));
		$this 	->  assign("FECHAFIN2ACTUALIZA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_final_2_actualiza]));
		$this 	->  assign("CLIENTEACTUALIZA",		$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[cliente_actualiza]));
		$this 	->  assign("PROPIETARIOACTUALIZA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[propietario_actualiza]));
		$this 	->  assign("ARRENDATARIOACTUALIZA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[arrendatario_actualiza]));
		$this 	->  assign("CANONACTUALIZA",		$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[canon_actualiza]));
		$this 	->  assign("ADMINISTRACIONACTUALIZA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[administracion_actualiza]));
		$this 	->  assign("FECHAINICIOACTUALIZA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_inicio_actualiza]));
		$this 	->  assign("FECHAFINALACTUALIZA",	$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_final_actualiza]));
		$this 	-> 	assign("FECHARENOVACION",		$this 	-> 	objectsHtml -> 	GetobjectHtml($this -> 	fields[fecha_renovacion]));
		$this 	-> 	assign("NUMESES",				$this 	->	objectsHtml -> 	GetobjectHtml($this ->	fields[numero_meses]));
		$this 	-> 	assign("NUMESESACTUALIZA",		$this 	->	objectsHtml -> 	GetobjectHtml($this ->	fields[numero_meses_actualiza]));

		if($this ->	Guardar)
		$this	->	assign("GUARDAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[guardar]));
		$this	->	assign("GENERAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[generar]));
		$this	->	assign("GENERAREXCEL",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[generar_excel]));

		if($this ->	Actualizar){
			$this	->	assign("RENOVAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[renovar]));
			$this	->	assign("FINALIZAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[finalizar]));
			$this	->	assign("ACTUALIZAR",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[actualizar]));
		}

		 if($this -> Imprimir)
		   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 

		if($this ->	Limpiar)
		$this	->	assign("LIMPIAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[limpiar]));
		}

	/*public function setTipoDepreciacion($Depreciacion){
		$this	->	fields[tabla_depreciacion_id]['options'] = $Depreciacion;
		$this	->	assign("TABLADEPRECIACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tabla_depreciacion_id]));
	}

	public function setGrupoActivo($GrupoActivo){
		$this	->	fields[grupo_activo_id]['options'] = $GrupoActivo;
		$this	->	assign("GRUPOACTIVOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[grupo_activo_id]));
	}*/




	public function RenderMain(){
		$this	->	RenderLayout('Aumento.tpl');
	}
}
?>