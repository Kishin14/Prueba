<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleNovedad extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("DetalleNovedadLayoutClass.php");
    require_once("DetalleNovedadModelClass.php");
	
    $Layout = new DetalleNovedadLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleNovedadModel();
	
    $Layout -> setIncludes();

    $Layout -> setDetallesNovedad($Model -> getDetallesNovedad($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickFind(){
	      				
	require_once("DetalleNovedadModelClass.php");	    

    $Model             = new DetalleNovedadModel();	 
	$novedad_fija_id = $_REQUEST['novedad_fija_id'];
    $result            = $Model -> selectDetalles($novedad_fija_id,$this -> getConex());
	 		
	$this -> getArrayJSON($result);
	  
  }
  
//CAMPOS
  protected function setCampos(){


	$this -> Campos[novedad_fija_id] = array(
		name	=>'novedad_fija_id',
		id      =>'novedad_fija_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11')
	);

	$this -> Campos[cuota] = array(
		name	=>'cuota',
		id      =>'cuota',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11')
	);

	$this -> Campos[no_cuota] = array(
		name	=>'no_cuota',
		id      =>'no_cuota',
		required=>'no',
		datatype=>array(type=>'integer')
	);


	$this -> Campos[vr_cuota] = array(
		name	=>'vr_cuota',
		id      =>'vr_cuota',
		type	=>'select',
		datatype=>array(type=>'integer')
	);	
	
	$this -> Campos[saldo] = array(
		name	=>'saldo',
		id      =>'saldo',
		type	=>'text',
		datatype=>array(type=>'integer')
	);	
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetalleNovedad = new DetalleNovedad();

?>