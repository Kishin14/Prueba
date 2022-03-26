<?php

require_once("../../../framework/clases/ControlerClass.php");
final class DetallesConvocados extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesConvocadosLayoutClass.php");
    require_once("DetallesConvocadosModelClass.php");
		
	$Layout                 = new DetallesConvocadosLayout();
    $Model                  = new DetallesConvocadosModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_convocatoria		= $_REQUEST['si_convocatoria'];
	$convocatoria_id		= $_REQUEST['convocatoria_id'];	
    $si_convocado			= $_REQUEST['si_convocado'];
	$convocado_id			= $_REQUEST['convocado_id'];	

	
    $Layout -> setIncludes();
	
	if($si_convocado=='ALL' && $si_convocatoria=='ALL')
		$Layout -> setReporteMC1($Model -> getReporteMC1($desde,$hasta,$this -> getConex()));
		
	else if($si_convocado==1 && $si_convocatoria=='ALL')
		$Layout -> setReporteMC2($Model -> getReporteMC2($convocado_id,$desde,$hasta,$this -> getConex()));	
		
	else if($si_convocado==1 && $si_convocatoria==1)
		$Layout -> setReporteMC3($Model -> getReporteMC3($convocado_id,$convocatoria_id,$desde,$hasta,$this -> getConex()));		

	else if($si_convocado=='ALL' && $si_convocatoria==1)
		$Layout -> setReporteMC4($Model -> getReporteMC4($convocatoria_id,$desde,$hasta,$this -> getConex()));		

	$Layout -> RenderMain();    
  }
}

$DetallesConvocados = new DetallesConvocados();

?>