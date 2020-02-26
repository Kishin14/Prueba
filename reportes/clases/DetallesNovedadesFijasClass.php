<?php

require_once("../../../framework/clases/ControlerClass.php");
final class DetallesNovedadesFijas extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	   
    $this -> noCache();
    	
	require_once("DetallesNovedadesFijasLayoutClass.php");
    require_once("DetallesNovedadesFijasModelClass.php");
	$Layout                 = new DetallesNovedadesFijasLayout();
    $Model                  = new DetallesNovedadesFijasModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_empleado			= $_REQUEST['si_empleado'];
	$empleado_id			= $_REQUEST['empleado_id'];	

	
    $Layout -> setIncludes();
	
	if($si_empleado=='ALL')
		$Layout -> setReporteMC1($Model -> getReporteMC1($desde,$hasta,$this -> getConex()));
		
	else if($si_empleado==1 )
		$Layout -> setReporteMC2($Model -> getReporteMC2($empleado_id,$desde,$hasta,$this -> getConex()));
				
	
	$Layout -> RenderMain();    
  }
}

$DetallesHorasExtras = new DetallesNovedadesFijas();

?>