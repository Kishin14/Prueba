<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ProfesionPerfil extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    $this -> noCache();
    require_once("ProfesionPerfilLayoutClass.php");
    require_once("ProfesionPerfilModelClass.php");
    $Layout = new ProfesionPerfilLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new ProfesionPerfilModel();
    $Layout -> setIncludes();
    $Layout -> setProfesiones($Model -> getProfesiones($this -> getConex()));	
    $Layout -> setProfesionPerfil($Model -> getProfesionPerfil($this -> getConex()));
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("ProfesionPerfilModelClass.php");
	
    $Model = new ProfesionPerfilModel();
	
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
  
    require_once("ProfesionPerfilModelClass.php");
	
    $Model = new ProfesionPerfilModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("ProfesionPerfilModelClass.php");
	
    $Model = new ProfesionPerfilModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
//CAMPOS
  protected function setCampos(){

	
	$this -> Campos[profesion_perfil_id] = array(
		name	=>'profesion_perfil_id',
		id      =>'profesion_perfil_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('profesion_perfil'),
			type	=>array('primary_key'))
	);

	$this -> Campos[profesion_id] = array(
		name	=>'profesion_id',
		id      =>'profesion_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('profesion_perfil'),
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
			table	=>array('profesion_perfil'),
			type	=>array('column'))
	);		
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$ProfesionPerfil = new ProfesionPerfil();

?>