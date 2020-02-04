<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetallePatronales extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("DetallePatronalesLayoutClass.php");
    require_once("DetallePatronalesModelClass.php");
	
    $Layout = new DetallePatronalesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetallePatronalesModel();
	
    $Layout -> setIncludes();
	$Layout -> setDetallesRegistrar($Model -> getDetallesRegistrar($this -> getConex()));
    $Layout -> RenderMain();
    
  }
  


  protected function onclickUpdate(){
  
    require_once("DetallePatronalesModelClass.php");
	
    $Model = new DetallePatronalesModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  

  //CAMPOS
  protected function setCampos(){

	
	$this -> Campos[detalle_liquidacion_patronal_id] = array(
		name	=>'detalle_liquidacion_patronal_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('primary_key'))
	);

	$this -> Campos[liquidacion_patronal_id] = array(
		name	=>'liquidacion_patronal_id',
		id		=>'liquidacion_patronal_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[formula] = array(
		name	=>'formula',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);
	
	$this -> Campos[base] = array(
		name	=>'base',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	

	$this -> Campos[porcentaje] = array(
		name	=>'porcentaje',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	

	$this -> Campos[debito] = array(
		name	=>'debito',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	

	$this -> Campos[credito] = array(
		name	=>'credito',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	
	
	$this -> Campos[fecha_inicial] = array(
		name	=>'fecha_inicial',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	
	
	$this -> Campos[fecha_final] = array(
		name	=>'fecha_final',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);		

	$this -> Campos[dias] = array(
		name	=>'dias',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);		

	$this -> Campos[observacion] = array(
		name	=>'observacion',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);		


	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetallePatronales = new DetallePatronales();

?>