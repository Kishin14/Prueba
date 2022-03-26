<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Detalles extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesLayoutClass.php");
    require_once("DetallesModelClass.php");
		
	$Layout                 	= new DetallesLayout();
    $Model                  	= new DetallesModel();	
    $abono_nomina_id 			= $_REQUEST['abono_nomina_id'];
	$empresa_id 				= $this -> getEmpresaId();
	$oficina_id 				= $this -> getOficinaId();	
	
    $Layout -> setIncludes();
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($abono_nomina_id,$empresa_id,$oficina_id,$this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    print json_encode($Data -> GetData());
  }
 
  protected function onclickSave(){
  
    require_once("DetallesModelClass.php");
	
    $Model = new DetallesModel();
	
    $Model -> Save($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	
  
  }


  protected function onclickUpdate(){

    require_once("DetallesModelClass.php");
	
    $Model = new DetallesModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	

  }
	  
  protected function getRequieresCuenta(){

    require_once("DetallesModelClass.php");
	
    $Model                  	= new DetallesModel();
    $puc_id                 	= $_REQUEST['puc_id'];
    $abono_factura_proveedor_id = $_REQUEST['abono_factura_proveedor_id'];
	
	$data = $Model -> selectCuentaPuc($puc_id,$abono_factura_proveedor_id,$this -> getConex());
	
	print json_encode($data);
		  
  }
  
  protected function getvalorCalculadoBase(){
	  
    require_once("DetallesModelClass.php");
	
    $Model = new DetallesModel();
	
    $puc_id                 	= $_REQUEST['puc_id'];
    $abono_factura_proveedor_id = $_REQUEST['abono_factura_proveedor_id'];
    $base_abono_factura			= $_REQUEST['base_abono_factura'];
	
	$data = $Model -> selectImpuesto($puc_id,$base_abono_factura,$abono_factura_proveedor_id,$this -> getConex());
	
	print json_encode($data);
	  
  }

}

$Detalles = new Detalles();

?>