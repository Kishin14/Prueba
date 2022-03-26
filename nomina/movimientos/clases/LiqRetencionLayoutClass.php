<?php
require_once("../../../framework/clases/ViewClass.php");

final class LiqRetencionLayout extends View{

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

		$Form1	=	new Form("LiqRetencionClass.php","LiqRetencionForm","LiqRetencionForm");
		$this	->	fields		=	$campos;
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/ajax-dynamic-list.css");
		$this	->	TplInclude	->	IncludeCss("../css/LiqRetencion.css");
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
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
		$this	->	TplInclude	->	IncludeJs("../js/LiqRetencion.js");
		$this	->	TplInclude	->	IncludeJs("../js/DetallesLiqRetencion.js");

		$this	->	assign("CSSSYSTEM",				$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",			$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("FORM1",					$Form1	->	FormBegin());
		$this	->	assign("FORM1END",				$Form1	->	FormEnd());
		$this	->	assign("BUSQUEDA",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));

		$this	->	assign("CONTRATOLIQ",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[consecutivo_renueva]));
		$this	->	assign("CONTRATOLIQID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrato_liq_id]));
		$this 	-> 	assign("EMPLEADOLIQ",				$this 	->	objectsHtml -> 	GetobjectHtml($this ->	fields[numero_meses]));
		$this 	->  assign("CONTRATO",				$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[contrato]));
		$this 	-> 	assign("CONTRATOID",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->	fields[contrato_id]));
		$this	->	assign("SI_CONTRATO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[si_contrato]));
		$this	->  assign("HASTA",					$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_final]));
		$this 	->  assign("DESDE",					$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_inicio]));		 	 
		// Campos Div liquidar Retencion
		$this	->	assign("AOP",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[aportes_pension]));
		$this	->	assign("AOS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[aportes_salud]));
		$this	->	assign("AVPO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[aportes_fondop]));
		$this	->	assign("PIV",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[pago_vivienda]));
		$this	->	assign("DPD",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[deduccion_dependiente]));
		$this	->	assign("PPS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[salud_prepagada]));
		$this	->	assign("ORE",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[otras_rentas]));
		$this	->	assign("AVEFP",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[aportes_vol_empl]));
		$this	->	assign("AFC",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[aportes_afc]));
		$this	->	assign("STICR",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[st_icr]));
		$this	->	assign("STD",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[st_d]));
		$this	->	assign("STRE",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[st_re]));
		$this	->	assign("TOTALSUMA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[total_suma]));
		$this	->	assign("UVT",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[uvt]));
		$this	->	assign("SUB1",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sub1]));
		$this	->	assign("SUB2",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sub2]));
		$this	->	assign("SUB3",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sub3]));
		$this	->	assign("SUB4",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sub4]));
		$this	->	assign("RTE",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[rte]));
		$this	->	assign("CCD",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cifra_control]));
		$this	->	assign("TDR",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[total_deduccion]));
		$this	->	assign("VALIDAU",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[validau]));
		$this	->	assign("IGM",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[ingreso_mensual]));
		$this	->	assign("ILG",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[ingreso_gravado]));
		// Campos Div liquidar Retencion

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
		$this	->	RenderLayout('LiqRetencion.tpl');
	}
}
?>