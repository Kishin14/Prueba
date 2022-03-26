<?php
include("../../../framework/clases/ControlerClass.php");

final class Detallesindicadores extends Controler{

  public function __construct(){
	parent::__construct(3);
  }





  public function Main(){
 
    $this -> noCache();

	require_once("DetallesindicadoresLayoutClass.php");
    require_once("DetallesindicadoresModelClass.php");

	$Layout                 = new DetallesindicadoresLayout();
    $Model                  = new DetallesindicadoresModel();	
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
 

 	/* for ($i=0; $i < count($data) ; $i++) { 
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
 	} */

	 $download = $this -> requestData('download');

	

	if($download == 'true'){

	    $Layout -> exportToExcel('detalles.tpl'); 		

	}else{	
		  $Layout -> setVar("DETALLES",$data);
		  $Layout -> RenderMain();

	  }

    

  }


  
}
$Detallesindicadores = new Detallesindicadores();

?>