<?php

require_once("../../../framework/clases/ControlerClass.php");

final class HijosEmpleado extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    $this -> noCache();
    require_once("HijosEmpleadoLayoutClass.php");
    require_once("HijosEmpleadoModelClass.php");
    $Layout = new HijosEmpleadoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new HijosEmpleadoModel();
    $Layout -> setIncludes();
    $Layout -> setHijos($Model -> getHijos($this -> getConex()));	
    $Layout -> setHijosEmpleado($Model -> getHijosEmpleado($this -> getConex()));
    $Layout -> setTip($Model -> getTip($this -> getConex()));
    $Layout -> RenderMain();
  }
  

  protected function onclickSave(){
  
    require_once("HijosEmpleadoModelClass.php");
	
    $Model = new HijosEmpleadoModel();
	
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
  
    require_once("HijosEmpleadoModelClass.php");
	
    $Model = new HijosEmpleadoModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("HijosEmpleadoModelClass.php");
	
    $Model = new HijosEmpleadoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
//CAMPOS
  protected function setCampos(){

	
	$this -> Campos[hijos_id] = array(
		name	=>'hijos_id',
		id      =>'hijos_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('primary_key'))
	);

	$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id		=>'tipo_identificacion_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
		datatype=>array(
			type	=>'alphanum',
			length	=>'11'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);

	$this -> Campos[numero_identificacion] = array(
		name	=>'numero_identificacion',
		id      =>'numero_identificacion',
		type	=>'text',
		required=>'no',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);


	$this -> Campos[primer_nombre] = array(
		name	=>'primer_nombre',
		id      =>'primer_nombre',
		type	=>'text',
		datatype=>array(
			type	=>'text',
			length	=>'11'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);		
	
	$this -> Campos[segundo_nombre] = array(
		name	=>'segundo_nombre',
		id      =>'segundo_nombre',
		type	=>'text',
		datatype=>array(
			type	=>'text',
			length	=>'11'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);

	$this -> Campos[primer_apellido] = array(
		name	=>'primer_apellido',
		id      =>'primer_apellido',
		type	=>'text',
		datatype=>array(
			type	=>'text',
			length	=>'11'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);

	$this -> Campos[segundo_apellido] = array(
		name	=>'segundo_apellido',
		id      =>'segundo_apellido',
		type	=>'text',
		datatype=>array(
			type	=>'text',
			length	=>'11'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_nacimiento] = array(
		name	=>'fecha_nacimiento',
		id		=>'fecha_nacimiento',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'date',
			length	=>'11'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);

	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options	=> array(array(value=>'A',text=>'ACTIVO',selected=>'0'),array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'2'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);

	$this -> Campos[empleado_id] = array(
		name	=>'empleado_id',
		id      =>'empleado_id',
		type	=>'text',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		type	=>'text'
	);
	
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('hijos'),
			type	=>array('column'))
	);

		
	$this -> SetVarsValidate($this -> Campos);
  }
	
}

$HijosEmpleado = new HijosEmpleado();

?>