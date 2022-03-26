<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleCesantias extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetalleCesantiasLayoutClass.php");
    require_once("DetalleCesantiasModelClass.php");
		
	$Layout         = new DetalleCesantiasLayout();
    $Model          = new DetalleCesantiasModel();	
    $liquidacion_cesantias_id 				= $_REQUEST['liquidacion_cesantias_id'];
	
	$empresa_id		= $this -> getEmpresaId();
	$oficina_id		= $this -> getOficinaId();	

    $Layout -> setIncludes();
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($liquidacion_cesantias_id,$empresa_id,$oficina_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    print json_encode($Data -> GetData());
  }


	  

}

$DetalleCesantias = new DetalleCesantias();

?>