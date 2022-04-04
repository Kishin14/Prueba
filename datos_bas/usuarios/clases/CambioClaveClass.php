<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class CambioClave extends Controler{
	
  public function __construct(){
	  
	parent::__construct(3);

  }
  	
  public function Main(){

    $this -> noCache();

    require_once("CambioClaveLayoutClass.php");
    require_once("CambioClaveModelClass.php");	  
	
    $Layout   = new CambioClaveLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CambioClaveModel();
	
    $Layout -> setCampos($this -> Campos);
    $Layout -> setUsusarioId($Model -> getUsuarioId($this -> getConex()));	
    $Layout -> setUsusario($Model -> getUsuario($this -> getConex())); 
    $Layout -> setUsusarioNombres($Model -> getUsuarioNombres($this -> getConex()));		
	  
    $Layout -> RenderMain();
  
  }

  protected function onclickUpdate(){
	  
	require_once("CambioClaveModelClass.php");	  
	
    $Model = new CambioClaveModel();
	
	if($Model -> Update($this -> getConex())){
	 exit('Se actualizo correctamente el usuario');
    }else{
		exit('Ocurrio una inconsistencia');
      }
	  	
  }


  protected function setCampos(){
  
	$this -> Campos[usuario_id]  = array(type=>'hidden',name=>'usuario_id',id=>'usuario_id');
	  
	$this -> Campos[usuario] = array(type=>'text',datatype=>array(type=>'alphanum',length=>'100'),name=>'usuario',id=>'usuario',
	tabindex =>'1',readonly=>'readonly');
	
	$this -> Campos[clave] = array(type=>'password',datatype=>array(type=>'alphanum',length=>'100'),name=>'clave',id=>'clave',
	tabindex =>'2',required=>'yes');	
	 
 	$this -> Campos[actualizar] = array(type=>'button',name=>'actualizar',id=>'actualizar',tabindex => 
	 '3',property=>array(name=>'update_ajax',onsuccess=>'CambioClaveOnSaveUpdate'),value=>'Actualizar');
	 	 
	$this -> SetVarsValidate($this -> Campos);
   }


}

$CambioClave = new CambioClave();

?>