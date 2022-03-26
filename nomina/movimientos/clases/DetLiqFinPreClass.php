<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetLiqFinPre extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("DetLiqFinPreLayoutClass.php");
    require_once("DetLiqFinPreModelClass.php");
	
    $Layout = new DetLiqFinPreLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetLiqFinPreModel();
	
    $Layout -> setIncludes();
    $Layout -> setTipoIdentificacion($Model -> getTipoIdentificacion($this -> getConex()));	
    $Layout -> setUnidades($Model -> getUnidades($this -> getConex()));
    $Layout -> setUnidadesVolumen($Model -> getUnidadesVolumen($this -> getConex()));
	
    $Layout -> setDetallesSolicitudServicios($Model -> getDetallesSolicitudServicios($this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetLiqFinPreModelClass.php");
	
    $Model = new DetLiqFinPreModel();
	
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
  
    require_once("DetLiqFinPreModelClass.php");
	
    $Model = new DetLiqFinPreModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetLiqFinPreModelClass.php");
	
    $Model = new DetLiqFinPreModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
  
  protected function getDataRemitenteDestinatario(){
  
    require_once("DetLiqFinPreModelClass.php");
	
	$remitente_destinatario_id = $_REQUEST['remitente_destinatario_id'];
    $Model = new DetLiqFinPreModel();
	$data  = $Model -> selectDataRemitenteDestinatario($remitente_destinatario_id,$this -> getConex());
	
	if(is_array($data)){
	  $this -> getArrayJSON($data);
	}else{
	    print 'false';
	  }
  
  
  }


//CAMPOS
  protected function setCampos(){

	
	$this -> Campos[detalle_ss_id] = array(
		name	=>'detalle_ss_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('primary_key'))
	);

	$this -> Campos[solicitud_id] = array(
		name	=>'solicitud_id',
		id		=>'solicitud_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[orden_despacho] = array(
		name	=>'orden_despacho',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);	
	
	
	$this -> Campos[origen] = array(
		name	=>'origen',
		type	=>'text'
	);
	
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[remitente] = array(
		name	=>'remitente',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[doc_remitente] = array(
		name	=>'doc_remitente',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'12'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[direccion_remitente] = array(
		name	=>'direccion_remitente',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[telefono_remitente] = array(
		name	=>'telefono_remitente',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[destino] = array(
		name	=>'destino',
		type	=>'text'
	);
	
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[destinatario] = array(
		name	=>'destinatario',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[doc_destinatario] = array(
		name	=>'doc_destinatario',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'12'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[direccion_destinatario] = array(
		name	=>'direccion_destinatario',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[telefono_destinatario] = array(
		name	=>'telefono_destinatario',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[referencia_producto] = array(
		name	=>'referencia_producto',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);	
	
	$this -> Campos[descripcion_producto] = array(
		name	=>'descripcion_producto',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[unidad_peso_id] = array(
		name	=>'unidad_peso_id',
		type	=>'text',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
  			type	=>array('column'))
	);
	
	$this -> Campos[unidad_volumen_id] = array(
		name	=>'unidad_volumen_id',
		type	=>'text',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
  			type	=>array('column'))
	);	
	
	$this -> Campos[cantidad] = array(
		name	=>'cantidad',
		type	=>'text',
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso] = array(
		name	=>'peso',
		type	=>'text',
		datatype=>array(type => 'integer'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso_volumen] = array(
		name	=>'peso_volumen',
		type	=>'text',
		datatype=>array( type=>'numeric',length	=>'15', size => '3'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);	
	
	$this -> Campos[valor_unidad] = array(
		name	=>'valor_unidad',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'15', 
			presicion => '2'),
		transaction=>array(
			table	=>array('detalle_solicitud_servicio'),
			type	=>array('column'))
	);	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetLiqFinPre = new DetLiqFinPre();

?>