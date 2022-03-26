<?php

require_once("../../../framework/clases/ControlerClass.php");
final class reporteIncapacidadesResult extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  	
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("reporteIncapacidadesResultLayoutClass.php");
    require_once("reporteIncapacidadesResultModelClass.php");
		
	$Layout                 = new reporteIncapacidadesResultLayout();
    $Model                  = new reporteIncapacidadesResultModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];	
    $si_empleado			= $_REQUEST['si_empleado'];
    $empleado_id			= $_REQUEST['empleado_id'];	
    $tipo				    = $_REQUEST['tipo'];
    $cie_enfermedades_id    = $_REQUEST['cie_enfermedades_id'];
    

	
    $Layout -> setIncludes();
	
    if($si_empleado=='ALL' &&  $tipo == 'I' && $cie_enfermedades_id == 'NULL'){
		$Layout -> setReporteMC1($Model -> getReporteMC1($desde,$hasta,$tipo,$this -> getConex()));
		
    }else if($si_empleado=='ALL' && $tipo == 'L' && $cie_enfermedades_id == 'NULL'){
		$Layout -> setReporteMC2($Model -> getReporteMC2($desde,$hasta,$tipo,$this -> getConex()));	
		
    }else if($si_empleado==1 && $tipo == 'I' && $cie_enfermedades_id == 'NULL'){
		$Layout -> setReporteMC3($Model -> getReporteMC3($empleado_id,$desde,$hasta,$tipo,$this -> getConex()));		

    }else if($si_empleado==1 && $tipo == 'L' && $cie_enfermedades_id == 'NULL'){
        $Layout -> setReporteMC4($Model -> getReporteMC4($empleado_id,$desde,$hasta,$tipo,$this -> getConex()));
    
    }else if($si_empleado=='ALL' && $tipo == 'I' && $cie_enfermedades_id>0){
		$Layout -> setReporteMC5($Model -> getReporteMC5($desde,$hasta,$tipo,$cie_enfermedades_id,$this -> getConex()));		
    }
	$Layout -> RenderMain();    
  }
}

$reporteIncapacidadesResult = new reporteIncapacidadesResult();

?>