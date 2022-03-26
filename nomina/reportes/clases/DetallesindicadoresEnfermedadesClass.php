<?php
include("../../../framework/clases/ControlerClass.php");

final class DetallesindicadoresEnfermedades extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
 
    $this -> noCache();

	require_once("DetallesindicadoresEnfermedadesLayoutClass.php");
    require_once("DetallesindicadoresEnfermedadesModelClass.php");

	$Layout                 = new DetallesindicadoresEnfermedadesLayout();
    $Model                  = new DetallesindicadoresEnfermedadesModel();	

    $desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];	
    $si_empleado			= $_REQUEST['si_empleado'];
    $empleado_id			= $_REQUEST['empleado_id'];	
    $tipo				    = $_REQUEST['tipo'];
    $cie_enfermedades_id    = $_REQUEST['cie_enfermedades_id'];	
   

	if($si_empleado=='ALL' && $tipo == 'I' && $cie_enfermedades_id == ''){
       $data  = $Model -> getReporte($desde,$hasta,$tipo,$this -> getConex());

    }else if($si_empleado=='ALL' && $tipo == 'L' && $cie_enfermedades_id == ''){
		$data  = $Model -> getReporte1($desde,$hasta,$tipo,$this -> getConex());	
		
    }else if($si_empleado==1 && $tipo == 'I' && $cie_enfermedades_id == ''){
		$data  = $Model -> getReporte2($desde,$hasta,$tipo,$empleado_id,$this -> getConex());		

    }else if($si_empleado==1 && $tipo == 'L' && $cie_enfermedades_id == ''){
        $data  = $Model -> getReporte3($desde,$hasta,$tipo,$empleado_id,$this -> getConex());
    
    }else if($si_empleado=='ALL' && $tipo == 'I' && $cie_enfermedades_id>0){
		$data  = $Model -> getReporte4($desde,$hasta,$tipo,$cie_enfermedades_id,$this -> getConex());		
    }

/* 	for ($i=0; $i < count($data) ; $i++) { 
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
$DetallesindicadoresEnfermedades = new DetallesindicadoresEnfermedades();

?>