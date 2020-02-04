<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetallePrimas extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallePrimasLayoutClass.php");
    require_once("DetallePrimasModelClass.php");
		
	$Layout         = new DetallePrimasLayout();
    $Model          = new DetallePrimasModel();	
    $liquidacion_prima_id 				= $_REQUEST['liquidacion_prima_id'];
	$rango 				= $_REQUEST['rango'];
	
	$empresa_id		= $this -> getEmpresaId();
	$oficina_id		= $this -> getOficinaId();	

    $Layout -> setIncludes();
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($liquidacion_prima_id,$rango,$empresa_id,$oficina_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    print json_encode($Data -> GetData());
  }


	  

}

$DetallePrimas = new DetallePrimas();

?>