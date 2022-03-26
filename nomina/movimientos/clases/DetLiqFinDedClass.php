<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetLiqFinDed extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("DetLiqFinDedLayoutClass.php");
    require_once("DetLiqFinDedModelClass.php");
	
    $Layout = new DetLiqFinDedLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetLiqFinDedModel();
	
    $Layout -> setIncludes();
    $Layout -> setConcepto($Model -> getConcepto($this -> getConex()));
	
    $Layout -> setDetallesLiqFinDed($Model -> getDetallesLiqFinDed($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetLiqFinDedModelClass.php");
	
    $Model = new DetLiqFinDedModel();
	
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
  
    require_once("DetLiqFinDedModelClass.php");
	
    $Model = new DetLiqFinDedModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetLiqFinDedModelClass.php");
	
    $Model = new DetLiqFinDedModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  

//CAMPOS
  protected function setCampos(){

	
	$this -> Campos[liq_def_deduccion_id] = array(
		name	=>'liq_def_deduccion_id',
		id	=>'liq_def_deduccion_id',		
		type	=>'integer',
		required=>'no',
		readonly=>'yes',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('liq_def_deduccion'),
			type	=>array('primary_key'))
	);

	$this -> Campos[concepto] = array(
		name	=>'concepto',
		id		=>'concepto',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('liq_def_deduccion'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[dias] = array(
		name	=>'dias',
		id		=>'dias',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'150'),
		transaction=>array(
			table	=>array('liq_def_deduccion'),
			type	=>array('column'))
	);


	$this -> Campos[valor] = array(
		name	=>'valor',
		id		=>'valor',		
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15', 
			presicion => '2'),
		transaction=>array(
			table	=>array('liq_def_deduccion'),
			type	=>array('column'))
	);		
	
	$this -> Campos[concepto_area_id] = array(
		name	=>'concepto_area_id',
		id		=>'concepto_area_id',		
		type	=>'text',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('liq_def_deduccion'),
  			type	=>array('column'))
	);
	
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',		
		type	=>'text',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('liq_def_deduccion'),
  			type	=>array('column'))
	);		
	
	$this -> Campos[debito] = array(
		name	=>'debito',
		id		=>'debito',		
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15', 
			presicion => '2'),
		transaction=>array(
			table	=>array('liq_def_deduccion'),
			type	=>array('column'))
	);	
	
	$this -> Campos[credito] = array(
		name	=>'credito',
		id		=>'credito',		
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15', 
			presicion => '2'),
		transaction=>array(
			table	=>array('liq_def_deduccion'),
			type	=>array('column'))
	);		
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetLiqFinDed = new DetLiqFinDed();

?>