<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicFacturas extends Controler{

  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
   	
	  require_once("SolicFacturasLayoutClass.php");
    require_once("SolicFacturasModelClass.php");
	
	  $Layout = new SolicFacturasLayout();
    $Model  = new SolicFacturasModel();
    
    $empleado_id 	= $_REQUEST['empleado_id'];
	  $empleados 	  = $_REQUEST['empleados'];
	
    $Layout -> setIncludes();
	
    $consul_emp = $empleado_id>0 ? " AND l.contrato_id IN (SELECT contrato_id FROM contrato WHERE empleado_id=$empleado_id) " : "";
        
    if($empleados!=''){	
	
    $Layout -> SetSolicFacturas  ($Model -> getSolicFacturas($consul_emp,$empleados,$this -> getConex()));
    $Layout -> SetSolicVacaciones($Model -> getSolicVacaciones($consul_emp,$empleados,$this -> getConex()));
    $Layout -> SetSolicPrimas    ($Model -> getSolicPrimas($consul_emp,$empleados,$this -> getConex()));
    $Layout -> SetSolicCesantias ($Model -> getSolicCesantias($consul_emp,$empleados,$this -> getConex()));
    $Layout -> SetSolicIntCesantias ($Model -> getSolicIntCesantias($consul_emp,$empleados,$this -> getConex()));
    
    }else{
      
      $Layout -> SetSolicFacturas  (array());
      $Layout -> SetSolicVacaciones(array());
      $Layout -> SetSolicPrimas    (array());
      $Layout -> SetSolicCesantias (array());
      $Layout -> SetSolicIntCesantias (array());
      
    }

      $Layout -> SetCampos($this -> Campos);
      $Layout -> RenderMain();
    
  }
  

  protected function SetCampos(){
		
	//botones

  }

}

$SolicFacturas = new SolicFacturas();

?>