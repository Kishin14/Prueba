<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleVacaciones extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetalleVacacionesLayoutClass.php");
    require_once("DetalleVacacionesModelClass.php");
		
	  $Layout         = new DetalleVacacionesLayout();
    $Model          = new DetalleVacacionesModel();	
    $liquidacion_vacaciones_id 				= $_REQUEST['liquidacion_vacaciones_id'];
	
	  $empresa_id		= $this -> getEmpresaId();
	  $oficina_id		= $this -> getOficinaId();	

    $Layout -> setIncludes();
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($liquidacion_vacaciones_id,$empresa_id,$oficina_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    print json_encode($Data -> GetData());
  }


	  

}

$DetalleVacaciones = new DetalleVacaciones();

?>