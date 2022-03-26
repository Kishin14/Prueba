<?php

require_once("../../../framework/clases/ControlerClass.php");
final class DetallesContratos extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesContratosLayoutClass.php");
    require_once("DetallesContratosModelClass.php");
		
	$Layout                 = new DetallesContratosLayout();
    $Model                  = new DetallesContratosModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cargo				= $_REQUEST['si_cargo'];
	$cargo_id				= $_REQUEST['cargo_id'];	
    $si_empleado			= $_REQUEST['si_empleado'];
	$empleado_id			= $_REQUEST['empleado_id'];	

	
    $Layout -> setIncludes();
	
	if($si_empleado=='ALL' && $si_cargo=='ALL')
		$Layout -> setReporteMC1($Model -> getReporteMC1($desde,$hasta,$this -> getConex()));
		
	else if($si_empleado==1 && $si_cargo=='ALL')
		$Layout -> setReporteMC2($Model -> getReporteMC2($empleado_id,$desde,$hasta,$this -> getConex()));
				
	else if($si_empleado=='ALL' && $si_cargo==1)
		$Layout -> setReporteMC3($Model -> getReporteMC3($cargo_id,$desde,$hasta,$this -> getConex()));		
		
	else if($si_empleado==1 && $si_cargo==1)
		$Layout -> setReporteMC4($Model -> getReporteMC4($empleado_id,$cargo_id,$desde,$hasta,$this -> getConex()));	
				
	$Layout -> RenderMain();    
  }
}

$DetallesContratos = new DetallesContratos();

?>