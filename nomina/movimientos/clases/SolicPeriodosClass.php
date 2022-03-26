<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicPeriodos extends Controler{

  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
   	
	require_once("SolicPeriodosLayoutClass.php");
    require_once("SolicPeriodosModelClass.php");
	
	$Layout = new SolicPeriodosLayout();
    $Model  = new SolicPeriodosModel();
    $empleado_id 	= $_REQUEST['empleado_id'];
	
    $Layout -> setIncludes();
    $Layout -> SetSolicPeriodos($Model -> getSolicPeriodos($empleado_id,$this -> getConex()));
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

$SolicPeriodos = new SolicPeriodos();

?>