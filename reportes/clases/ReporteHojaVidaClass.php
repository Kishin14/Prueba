<?php
require_once("../../../framework/clases/ControlerClass.php");

final class reporteHojaVida extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
    require_once("ReporteHojaVidaLayoutClass.php");
    require_once("ReporteHojaVidaModelClass.php");
    $Layout   = new reporteHojaVidaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new reporteHojaVidaModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
	$Layout -> SetSi_Pro ($Model -> GetSi_Pro ($this -> getConex()));
	$Layout -> SetIndicadores ($Model -> GetIndicadores ($this -> getConex()));
	$Layout -> RenderMain();    

  }  

  protected function generateFile(){
    require_once("ReporteHojaVidaModelClass.php");
	require_once("ReporteHojaVidaLayoutClass.php");
    $Layout   = new reporteHojaVidaLayout();
    $Model     = new reporteHojaVidaModel();	

	$si_tipo				= $_REQUEST['si_tipo'];
	$indicadores			= $_REQUEST['indicadores'];
	$contrato_id			= $_REQUEST['contrato_id'];
	$contrato				= $_REQUEST['contrato'];
	$tercero_id				= $_REQUEST['tercero_id'];
	$tercero				= $_REQUEST['tercero'];	


	if($si_tipo==1){
	 $consulta_cliente=" s.contrato_id =".$contrato_id;
	 $data  = $Model -> getReporte($consulta_cliente,$this -> getConex());

	}else{
	 $consulta_cliente=" (s.contrato_id IN (SELECT c.contrato_id FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id AND e.tercero_id=".$tercero_id."))";
	 $data  = $Model -> getReporte($consulta_cliente,$this -> getConex());
	}
 

 	for ($i=0; $i < count($data) ; $i++) { 
 		$data_eps  = $Model -> getempresa_eps($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['empresa_eps'] = $data_eps;
	 }
	//   exit(print_r($data));

 	for ($i=0; $i < count($data) ; $i++) { 
 		$data_pension  = $Model -> getempresa_pension($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['empresa_pension'] = $data_pension;
 	}

	for ($i=0; $i < count($data) ; $i++) { 
 		$data_cesantias  = $Model -> getempresa_cesantias($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['empresa_cesantias'] = $data_cesantias;
 	}

  	for ($i=0; $i < count($data) ; $i++) { 
 		$data_arl  = $Model -> getempresa_arl($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['empresa_arl'] = $data_arl;
 	}

 	for ($i=0; $i < count($data) ; $i++) { 
 		$data_caja  = $Model -> getempresa_caja($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['empresa_caja'] = $data_caja;
 	}

 		for ($i=0; $i < count($data) ; $i++) { 
 		$data_licencia  = $Model -> get_licencia($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['licencia'] = $data_licencia;
 	}

 	for ($i=0; $i < count($data) ; $i++) { 
 		$data_novedad  = $Model -> get_novedad($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['novedad'] = $data_novedad;
 	}

 	for ($i=0; $i < count($data) ; $i++) { 
		 $data_extras  = $Model -> get_extras($data[$i]['contrato_id'],$this -> getConex());
		 $hora_extra_id = $data_extras[0]['hora_extra_id'];
		 if ($hora_extra_id > 0) {
			 $data[$i]['extras'] = $data_extras;
		 }else {
			 $data[$i]['extras'] = '';
		 }
 	}
 	
	 	for ($i=0; $i < count($data) ; $i++) { 
 		$data_liq_cesantias  = $Model -> getliquida_cesantias($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['liq_cesantias'] = $data_liq_cesantias;
 	}

 	for ($i=0; $i < count($data) ; $i++) { 
 		$data_liq_primas  = $Model -> getliquida_primas($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['liq_primas'] = $data_liq_primas;
	}
	 
 	for ($i=0; $i < count($data) ; $i++) { 
 		$data_liq_vacacion  = $Model -> getliquida_vacacion($data[$i]['contrato_id'],$this -> getConex());
 		$data[$i]['liq_vacacion'] = $data_liq_vacacion;
 	}
 	

    if($_REQUEST['download'] == 'true'){
      $Layout -> setVar("REMESAS",$data);
      $Layout -> exportToExcel('ReporteHojaVidaResultExcel.tpl');	
	}else{
		
			$Layout -> setJsInclude("../../../framework/js/funciones.js");
			$Layout -> setJsInclude("../js/ReporteHojaVida.js");
			$Layout -> setCssInclude("../../../framework/css/bootstrap.css");
			$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
			$Layout -> setVar("REMESAS",$data);
	
			$Layout	-> RenderLayout('ReporteHojaVidaResult.tpl');		

	  }  
  }

  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){    


	$this -> Campos[si_tipo] = array(
		name	=>'si_tipo',
		id		=>'si_tipo',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'setTipo();'
	);

	$this -> Campos[indicadores] = array(
		name	=>'indicadores',
		id		=>'indicadores',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		selected=>'A',
		required=>'yes',
		onchange=>'setIndicadores();'
	);


	$this -> Campos[contrato_id] = array(
		name	=>'contrato_id',
		id		=>'contrato_id',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);	

	$this -> Campos[contrato] = array(
		name	=>'contrato',
		id		=>'contrato',
		type	=>'text',
		placeholder=>'Por favor digite un numero de contrato.',
		Boostrap=>'si',
		//required=>'yes',
		suggest=>array(
			name	=>'contrato_activo',
			setId	=>'contrato_id')
	);	

	$this -> Campos[tercero] = array(
		name	=>'tercero',
		id		=>'tercero',
		type	=>'text',
		placeholder=>'Por favor digite el nombre o identificacion del empleado.',
		Boostrap=>'si',
		//required=>'yes',
		suggest=>array(
			name	=>'tercero',
			setId	=>'tercero_id')
	);



	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	

/////// BOTONES 

	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);	
	
	$this -> Campos[graficos] = array(
    name   =>'graficos',
    id   =>'graficos',
    type   =>'button',
    value   =>'Generar',
	onclick =>'mostrarGraficos(this.form)'
    ); 

	
	$this -> Campos[generar_excel] = array(
    name   =>'generar_excel',
    id   =>'generar_excel',
    type   =>'button',
    value   =>'Descargar Excel Formato',
	onclick =>'OnclickGenerarExcel(this.form)'
    );

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Imprimir',
	onclick =>'beforePrint(this.form)'
    );
	 
	$this -> SetVarsValidate($this -> Campos);
	
   }  
 }

$reporteHojaVida = new reporteHojaVida();

?>