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
	$empleados 	= $_REQUEST['empleados'];
	
    $Layout -> setIncludes();
	if($empleado_id>0){ $consul_emp=" AND l.contrato_id IN (SELECT contrato_id FROM contrato WHERE empleado_id=$empleado_id) "; }else{ $consul_emp="";  } 
    $Layout -> SetSolicFacturas($Model -> getSolicFacturas($consul_emp,$empleados,$this -> getConex()));

	$Layout -> SetCampos($this -> Campos);
    $Layout -> RenderMain();
    
  }
  

  protected function SetCampos(){
		
	//botones
	$this -> Campos[adicionar] = array(
		name	=>'adicionar',
		id		=>'adicionar',
		type	=>'button',
		value=>'ADICIONAR'
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$SolicFacturas = new SolicFacturas();

?>