<?php

final class Imp_Extras{

  private $Conex;
  private $empresa_id;

  public function __construct($empresa_id,$Conex){
    $this -> Conex = $Conex; 
	$this -> getEmpresaId = $empresa_id; 
  }

  public function printOut(){
  	
      require_once("Imp_ExtrasLayoutClass.php");
      require_once("Imp_ExtrasModelClass.php");
		
      $Layout = new Imp_ExtrasLayout();
      $Model  = new Imp_ExtrasModel();		
	
      $Layout -> setIncludes();
	  $hora_extra_id = $_REQUEST['hora_extra_id'];	  
	
      $Layout -> setextras($Model -> getextras($this -> getEmpresaId,$this -> Conex));
	  $Layout -> setTotal($Model -> getTotal($hora_extra_id,$this -> Conex));	
	  
      $Layout -> RenderMain();	  
    
  }   
  
	
}

new Imp_Extras();

?>