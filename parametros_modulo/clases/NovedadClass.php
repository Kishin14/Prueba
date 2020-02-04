<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Novedad extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("NovedadLayoutClass.php");
	require_once("NovedadModelClass.php");
	
	$Layout   = new NovedadLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new NovedadModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	

	//// GRID ////
	$Attributes = array(
	  id		=>'causal_novedad',
	  title		=>'Listado de causas de desempeño',
	  sortname	=>'nombre',
	  width		=>'600',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'causal_novedad_id',		index=>'causal_novedad_id',		sorttype=>'text',	width=>'50',	align=>'center'),
		array(name=>'nombre',		index=>'nombre',		sorttype=>'text',	width=>'300',	align=>'left'),
	  	array(name=>'estado',		index=>'estado',		sorttype=>'text',	width=>'50',	align=>'center')
	);
	  
    $Titles = array('CODIGO',
    				'NOMBRE',
    				'ESTADO',
	);
	
	$Layout -> SetGridNovedad($Attributes,$Titles,$Cols,$Model -> GetQueryNovedadGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("NovedadModelClass.php");
    $Model = new NovedadModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("NovedadModelClass.php");
    $Model = new NovedadModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente una nueva novedad');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("NovedadModelClass.php");
    $Model = new NovedadModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la novedad');
	  }
	
  }

  protected function onclickDelete(){

	require_once("NovedadModelClass.php");
	$Model = new NovedadModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar la novedad');
	}else{
		exit('Se borro exitosamente la novedad');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
	require_once("NovedadModelClass.php");
    $Model = new NovedadModel();
	
    $Data          		= array();
	$causal_novedad_id 	= $_REQUEST['causal_novedad_id'];
	 
	if(is_numeric($causal_novedad_id)){
	  
	  $Data  = $Model -> selectDatosNovedadId($causal_novedad_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Incapacidad
	********************/
	
	$this -> Campos[causal_novedad_id] = array(
		name	=>'causal_novedad_id',
		id		=>'causal_novedad_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('causal_novedad'),
			type	=>array('primary_key'))
	);

	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('causal_novedad'),
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
			length	=>'1'),
		transaction=>array(
			table	=>array('causal_novedad'),
			type	=>array('column'))
	);

	 
	 	  
	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
	);

	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		// tabindex=>'21',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'NovedadOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'NovedadOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'causal_novedad',
			setId	=>'causal_novedad_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$causal_novedad_id = new Novedad();

?>