<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ConyugeEmpleado extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
    $this -> noCache();
    require_once("ConyugeEmpleadoLayoutClass.php");
    require_once("ConyugeEmpleadoModelClass.php");
    $Layout = new ConyugeEmpleadoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new ConyugeEmpleadoModel();
    $Layout -> setIncludes();
    $Layout -> setConyuge($Model -> getConyuge($this -> getConex()));	
    $Layout -> setConyugeEmpleado($Model -> getConyugeEmpleado($this -> getConex()));
    $Layout -> setTip($Model -> getTip($this -> getConex()));
    $Layout -> RenderMain();
  }
  

  protected function onclickSave(){
  
    require_once("ConyugeEmpleadoModelClass.php");
	
    $Model = new ConyugeEmpleadoModel();
	
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
  
    require_once("ConyugeEmpleadoModelClass.php");
	
    $Model = new ConyugeEmpleadoModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("ConyugeEmpleadoModelClass.php");
	
    $Model = new ConyugeEmpleadoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
//CAMPOS
  protected function setCampos(){

	
	$this -> Campos[conyuge_id] = array(
		name	=>'conyuge_id',
		id      =>'conyuge_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('conyuge'),
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
			table	=>array('conyuge'),
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
			table	=>array('conyuge'),
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
			table	=>array('conyuge'),
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
			table	=>array('conyuge'),
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
			table	=>array('conyuge'),
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
			table	=>array('conyuge'),
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
			table	=>array('conyuge'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_inicio] = array(
		name	=>'fecha_inicio',
		id		=>'fecha_inicio',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'date',
			length	=>'11'),
		transaction=>array(
			table	=>array('conyuge'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_final] = array(
		name	=>'fecha_final',
		id		=>'fecha_final',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'date',
			length	=>'11'),
		transaction=>array(
			table	=>array('conyuge'),
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
			table	=>array('conyuge'),
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
			table	=>array('conyuge'),
			type	=>array('column'))
	);
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
}

$ConyugeEmpleado = new ConyugeEmpleado();

?>