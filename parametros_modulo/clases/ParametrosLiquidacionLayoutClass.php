<?php
require_once("../../../framework/clases/ViewClass.php");

final class ParametrosLiquidacionLayout extends View{

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
		$Form1      = new Form("ParametrosLiquidacionClass.php","ParametrosLiquidacionForm","ParametrosLiquidacionForm");
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
		$this	->	TplInclude	->	IncludeJs("../js/ParametrosLiquidacion.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

		$this	->	assign("FORM1",			$Form1	->	FormBegin());
		$this	->	assign("FORM1END",		$Form1	->	FormEnd());
		$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this   -> assign("OFICINAID",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	
		$this	->	assign("PARAMETROLIQUIDACIONID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[parametros_liquidacion_id]));
		
		$this	->	assign("PUCVACCONSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_vac_cons_id]));
		$this	->	assign("PUCVACCONS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_vac_cons]));
		//$this	->	assign("PUCVACPROVID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_vac_prov_id]));
		//$this	->	assign("PUCVACPROV",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_vac_prov]));
		$this	->	assign("PUCVACCONTRAID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_vac_contra_id]));
		$this	->	assign("PUCVACCONTRA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_vac_contra]));
		
		$this	->	assign("PUCADMONVACID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_vac_id]));
		$this	->	assign("PUCADMONVAC",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_vac]));
		$this	->	assign("PUCVENTASVACID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_vac_id]));
		$this	->	assign("PUCVENTASVAC",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_vac]));
		$this	->	assign("PUCPRODUCCVACID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_vac_id]));
		$this	->	assign("PUCPRODUCCVAC",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_vac]));
		
		$this	->	assign("PUCSALUDVACID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_salud_vac_id]));
		$this	->	assign("PUCSALUDVAC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_salud_vac]));

		$this	->	assign("PUCPENSIONVACID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_pension_vac_id]));
		$this	->	assign("PUCPENSIONVAC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_pension_vac]));
		
		$this	->	assign("PUCREINTEVACID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_reintegro_vac_id]));
		$this	->	assign("PUCREINTEVAC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_reintegro_vac]));
		
		//para primas
		
		$this	->	assign("PUCPRIMACONSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_prima_cons_id]));
		$this	->	assign("PUCPRIMACONS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_prima_cons]));
		//$this	->	assign("PUCPRIMAPROVID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_prima_prov_id]));
		//$this	->	assign("PUCPRIMAPROV",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_prima_prov]));
		$this	->	assign("PUCPRIMACONTRAID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_prima_contra_id]));
		$this	->	assign("PUCPRIMACONTRA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_prima_contra]));
		
		$this	->	assign("PUCADMONPRIMAID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_prima_id]));
		$this	->	assign("PUCADMONPRIMA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_prima]));
		$this	->	assign("PUCVENTASPRIMAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_prima_id]));
		$this	->	assign("PUCVENTASPRIMA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_prima]));
		$this	->	assign("PUCPRODUCCPRIMAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_prima_id]));
		$this	->	assign("PUCPRODUCCPRIMA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_prima]));
		
		$this	->	assign("PUCREINTEPRIMAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_reintegro_prima_id]));
		$this	->	assign("PUCREINTEPRIMA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_reintegro_prima]));
		
		
			//para cesantias
		
		$this	->	assign("PUCCESANTIASCONSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_cesantias_cons_id]));
		$this	->	assign("PUCCESANTIASCONS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_cesantias_cons]));
		//$this	->	assign("PUCCESANTIASPROVID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_cesantias_prov_id]));
		//$this	->	assign("PUCCESANTIASPROV",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_cesantias_prov]));
		$this	->	assign("PUCCESANTIASCONTRAID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_cesantias_contra_id]));
		$this	->	assign("PUCCESANTIASCONTRA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_cesantias_contra]));
		
		$this	->	assign("PUCADMONCESANTIASID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_cesantias_id]));
		$this	->	assign("PUCADMONCESANTIAS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_cesantias]));
		$this	->	assign("PUCVENTASCESANTIASID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_cesantias_id]));
		$this	->	assign("PUCVENTASCESANTIAS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_cesantias]));
		$this	->	assign("PUCPRODUCCCESANTIASID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_cesantias_id]));
		$this	->	assign("PUCPRODUCCCESANTIAS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_cesantias]));
		
		$this	->	assign("PUCREINTECESANTIASID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_reintegro_cesantias_id]));
		$this	->	assign("PUCREINTECESANTIAS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_reintegro_cesantias]));
		
			//para intereses cesantias
		
		$this	->	assign("PUCINTCESANTIASCONSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_int_cesantias_cons_id]));
		$this	->	assign("PUCINTCESANTIASCONS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_int_cesantias_cons]));
		//$this	->	assign("PUCINTCESANTIASPROVID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_int_cesantias_prov_id]));
		//$this	->	assign("PUCINTCESANTIASPROV",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_int_cesantias_prov]));
		$this	->	assign("PUCINTCESANTIASCONTRAID",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_int_cesantias_contra_id]));
		$this	->	assign("PUCINTCESANTIASCONTRA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_int_cesantias_contra]));
		
		$this	->	assign("PUCADMONINTCESANTIASID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_int_cesantias_id]));
		$this	->	assign("PUCADMONINTCESANTIAS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_int_cesantias]));
		$this	->	assign("PUCVENTASINTCESANTIASID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_int_cesantias_id]));
		$this	->	assign("PUCVENTASINTCESANTIAS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_int_cesantias]));
		$this	->	assign("PUCPRODUCCINTCESANTIASID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_int_cesantias_id]));
		$this	->	assign("PUCPRODUCCINTCESANTIAS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_int_cesantias]));
		
		$this	->	assign("PUCREINTEINTCESANTIASID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_reintegro_int_cesantias_id]));
		$this	->	assign("PUCREINTEINTCESANTIAS",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_reintegro_int_cesantias]));
		
	

		

		if($this -> Guardar)
			$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

		if($this -> Actualizar)
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

		if($this -> Borrar)
			$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

		if($this -> Limpiar)
			$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	}

	/*public function SetPeriodoContable($periodo_contable_id){
		$this -> fields[periodo_contable_id]['options'] = $periodo_contable_id;
		$this -> assign("PERIODOCONTABLE",$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo_contable_id]));
	}*/
	
	 public function setEmpresas($Empresas){
   
     $this -> fields[empresa_id]['options'] = $Empresas;
	 $this -> assign("EMPRESAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	

   }	 
   
   public function SetTiposDocumentoContable($DocumentosContables){
	 $this -> fields[tipo_documento_id]['options'] = $DocumentosContables;
	 $this -> assign("DOCUMENTOCONTABLE",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));	 
   }
   


	public function SetGridParametrosLiquidacion($Attributes,$Titles,$Cols,$Query){
		require_once("../../../framework/clases/grid/JqGridClass.php");
		$TableGrid = new JqGrid();
		$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
		$this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
		$this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
		$this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
	}

	public function RenderMain(){
		$this ->RenderLayout('ParametrosLiquidacion.tpl');
	}
}
?>