<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleCargo extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    $this -> noCache();

    

    require_once("DetalleCargoLayoutClass.php");
    require_once("DetalleCargoModelClass.php");
    $Layout = new DetalleCargoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleCargoModel();
    // $Model -> updateCargoId($this -> getConex());
    $Layout -> setIncludes();
    $Layout -> setOficinas($Model -> getOficinas($this -> getConex()));	
    $Layout -> setDetallesCargo($Model -> getDetallesCargo($this -> getConex()));
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleCargoModelClass.php");
	
    $Model = new DetalleCargoModel();
	
    $return = $Model -> Save($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        if(is_numeric($return)){
		  exit("$return");
		}else{
		    exit('false');
		  }
	  }

  }

  protected function onclickUpdate(){
  
    require_once("DetalleCargoModelClass.php");
	
    $Model = new DetalleCargoModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleCargoModelClass.php");
	
    $Model = new DetalleCargoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
//CAMPOS
  protected function setCampos(){

	
	$this -> Campos[categoria_cargo_id] = array(
		name	=>'categoria_cargo_id',
		id      =>'categoria_cargo_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('categoria_cargo'),
			type	=>array('primary_key'))
	);

	$this -> Campos[cargo_id] = array(
		name	=>'cargo_id',
		id      =>'cargo_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('categoria_cargo'),
			type	=>array('column'))
	);


	$this -> Campos[estado] = array(
		name	=>'estado',
		id      =>'estado',
		type	=>'select',
		options	=> array(array(value=>'A',text=>'ACTIVO',selected=>'0'),array(value=>'I',text=>'INACTIVO')),
		datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('categoria_cargo'),
			type	=>array('column'))
	);	
	
	$this -> Campos[categoria_id] = array(
		name	=>'categoria_id',
		id      =>'categoria_id',
		type	=>'integer',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('categoria_cargo'),
			type	=>array('column'))
	);	
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetalleCargo = new DetalleCargo();

?>