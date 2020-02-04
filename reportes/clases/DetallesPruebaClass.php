<?php

require_once("../../../framework/clases/ControlerClass.php");
final class DetallesPrueba extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesPruebaLayoutClass.php");
    require_once("DetallesPruebaModelClass.php");
		
	$Layout                 = new DetallesPruebaLayout();
    $Model                  = new DetallesPruebaModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cargo				= $_REQUEST['si_cargo'];
	$cargo_id				= $_REQUEST['cargo_id'];	
    $si_convocado			= $_REQUEST['si_convocado'];
	$convocado_id			= $_REQUEST['convocado_id'];	

	
    $Layout -> setIncludes();
	
	if($si_convocado=='ALL' && $si_cargo=='ALL')
		$Layout -> setReporteMC1($Model -> getReporteMC1($desde,$hasta,$this -> getConex()));
		
	else if	($si_convocado== 1 && $si_cargo=='ALL')
		$Layout -> setReporteMC2($Model -> getReporteMC2($convocado_id,$desde,$hasta,$this -> getConex()));

	else if	($si_convocado== 'ALL' && $si_cargo==1)
		$Layout -> setReporteMC3($Model -> getReporteMC3($cargo_id,$desde,$hasta,$this -> getConex()));
		
	else if	($si_convocado== 1 && $si_cargo==1)
		$Layout -> setReporteMC4($Model -> getReporteMC4($convocado_id,$cargo_id,$desde,$hasta,$this -> getConex()));		
		
	$Layout -> RenderMain();    
  }
}

$DetallesPrueba = new DetallesPrueba();

?>