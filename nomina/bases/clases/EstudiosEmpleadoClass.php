<?php

require_once("../../../framework/clases/ControlerClass.php");

final class EstudiosEmpleado extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    $this -> noCache();
    require_once("EstudiosEmpleadoLayoutClass.php");
    require_once("EstudiosEmpleadoModelClass.php");
    $Layout = new EstudiosEmpleadoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new EstudiosEmpleadoModel();
    $Layout -> setIncludes();
    $Layout -> setEstudios($Model -> getEstudios($this -> getConex()));	
    $Layout -> setEstudiosEmpleado($Model -> getEstudiosEmpleado($this -> getConex()));
    $Layout -> setNiv($Model -> getNiv($this -> getConex()));
    $Layout -> RenderMain();
  }
  

  protected function onclickSave(){
  
    require_once("EstudiosEmpleadoModelClass.php");
	
    $Model = new EstudiosEmpleadoModel();

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
  
    require_once("EstudiosEmpleadoModelClass.php");
	
    $Model = new EstudiosEmpleadoModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("EstudiosEmpleadoModelClass.php");
	
    $Model = new EstudiosEmpleadoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
//CAMPOS
  protected function setCampos(){

	
	$this -> Campos[estudio_id] = array(
		name	=>'estudio_id',
		id      =>'estudio_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('estudio'),
			type	=>array('primary_key'))
	);

	$this -> Campos[empleado_id] = array(
		name	=>'empleado_id',
		id      =>'empleado_id',
		type	=>'text',
		required=>'no',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('estudio'),
			type	=>array('column'))
	);

	$this -> Campos[nivel_escolaridad_id] = array(
		name	=>'nivel_escolaridad_id',
		id      =>'nivel_escolaridad_id',
		type	=>'text',
		required=>'no',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('estudio'),
			type	=>array('column'))
	);


	$this -> Campos[titulo] = array(
		name	=>'titulo',
		id      =>'titulo',
		type	=>'text',
		datatype=>array(
			type	=>'text',
			length	=>'11'),
		transaction=>array(
			table	=>array('estudio'),
			type	=>array('column'))
	);		
	
	$this -> Campos[fecha_terminacion] = array(
		name	=>'fecha_terminacion',
		id      =>'fecha_terminacion',
		type	=>'text',
		datatype=>array(
			type	=>'date',
			length	=>'11'),
		transaction=>array(
			table	=>array('estudio'),
			type	=>array('column'))
	);
	
		$this -> Campos[institucion] = array(
		name	=>'institucion',
		id      =>'institucion',
		type	=>'text',
		datatype=>array(
			type	=>'text',
			length	=>'11'),
		transaction=>array(
			table	=>array('estudio'),
			type	=>array('column'))
	);		


		$this -> Campos[acta_de_grado] = array(
		name	=>'acta_de_grado',
		id      =>'acta_de_grado',
		type	=>'text',
		datatype=>array(
			type	=>'text',
			length	=>'11'),
		transaction=>array(
			table	=>array('estudio'),
			type	=>array('column'))
	);		


		
	$this -> SetVarsValidate($this -> Campos);
  }
	
}

$EstudiosEmpleado = new EstudiosEmpleado();

?>