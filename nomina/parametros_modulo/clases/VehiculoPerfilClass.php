<?php

require_once("../../../framework/clases/ControlerClass.php");

final class VehiculoPerfil extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    $this -> noCache();
    require_once("VehiculoPerfilLayoutClass.php");
    require_once("VehiculoPerfilModelClass.php");
    $Layout = new VehiculoPerfilLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new VehiculoPerfilModel();
    $Layout -> setIncludes();
    $Layout -> setVehiculos($Model -> getVehiculos($this -> getConex()));	
    $Layout -> setVehiculoPerfil($Model -> getVehiculoPerfil($this -> getConex()));
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("VehiculoPerfilModelClass.php");
	
    $Model = new VehiculoPerfilModel();
	
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
  
    require_once("VehiculoPerfilModelClass.php");
	
    $Model = new VehiculoPerfilModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("VehiculoPerfilModelClass.php");
	
    $Model = new VehiculoPerfilModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
//CAMPOS
  protected function setCampos(){

	
	$this -> Campos[vehiculo_perfil] = array(
		name	=>'vehiculo_perfil',
		id      =>'vehiculo_perfil',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('vehiculo_perfil'),
			type	=>array('primary_key'))
	);

	$this -> Campos[vehiculo_nomina_id] = array(
		name	=>'vehiculo_nomina_id',
		id      =>'vehiculo_nomina_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('vehiculo_perfil'),
			type	=>array('column'))
	);


	$this -> Campos[perfil_id] = array(
		name	=>'perfil_id',
		id      =>'perfil_id',
		type	=>'text',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('vehiculo_perfil'),
			type	=>array('column'))
	);		
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$VehiculoPerfil = new VehiculoPerfil();

?>