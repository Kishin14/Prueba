<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ARL extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ARLLayoutClass.php");
	require_once("ARLModelClass.php");
	
	$Layout   = new ARLLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ARLModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	

	//// GRID ////
	$Attributes = array(
	  id		=>'categoria_arl',
	  title		=>'Listado de categorias ARL',
	  sortname	=>'clase_riesgo',
	  width		=>'auto',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'categoria_arl_id',	index=>'categoria_arl_id',	sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'clase_riesgo',		index=>'clase_riesgo',		sorttype=>'text',	width=>'250',	align=>'center'),
		array(name=>'descripcion',		index=>'descripcion',		sorttype=>'text',	width=>'300',	align=>'center'),
	  	array(name=>'porcentaje',		index=>'porcentaje',		sorttype=>'text',	width=>'150',	align=>'center'),
	  	array(name=>'estado',			index=>'estado',			sorttype=>'text',	width=>'150',	align=>'center')
	);
	  
    $Titles = array('CODIGO',
    				'CLASE DE RIESGO',
    				'DESCRIPCION',
    				'PORCENTAJE',
    				'ESTADO',
	);
	
	$Layout -> SetGridARL($Attributes,$Titles,$Cols,$Model -> GetQueryARLGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("ARLModelClass.php");
    $Model = new ARLModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("ARLModelClass.php");
    $Model = new ARLModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente una nueva categoría de ARL');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("ARLModelClass.php");
    $Model = new ARLModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la categoría de ARL');
	  }
	
  }

  protected function onclickDelete(){

	require_once("ARLModelClass.php");
	$Model = new ARLModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar la categoría de ARL');
	}else{
		exit('Se borro exitosamente la categoría de ARL');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
	require_once("ARLModelClass.php");
    $Model = new ARLModel();
	
    $Data          		= array();
	$categoria_arl_id 	= $_REQUEST['categoria_arl_id'];
	 
	if(is_numeric($categoria_arl_id)){
	  
	  $Data  = $Model -> selectDatosARLId($categoria_arl_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos ARL
	********************/
	
	$this -> Campos[categoria_arl_id] = array(
		name	=>'categoria_arl_id',
		id		=>'categoria_arl_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('categoria_arl'),
			type	=>array('primary_key'))
	);

	$this -> Campos[clase_riesgo] = array(
		name	=>'clase_riesgo',
		id		=>'clase_riesgo',
		type	=>'text',
		required=>'yes',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'5'),
		transaction=>array(
			table	=>array('categoria_arl'),
			type	=>array('column'))
	);
	
	$this -> Campos[porcentaje] = array(
		name	=>'porcentaje',
		id		=>'porcentaje',
		type	=>'text',
		required=>'yes',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'15',
			presicion =>4),
		transaction=>array(
			table	=>array('categoria_arl'),
			type	=>array('column'))
	);

	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'textarea',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'5'),
		transaction=>array(
			table	=>array('categoria_arl'),
			type	=>array('column'))
	);

	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'A',text=>'ACTIVO',selected=>'0'),array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
		selected => 'A',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('categoria_arl'),
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
			onsuccess=>'ARLOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ARLOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		placeholder =>'Por favor digite la clase de riesgo',
		Boostrap =>'si',
		suggest=>array(
			name	=>'categoria_arl',
			setId	=>'categoria_arl_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$categoria_arl_id = new ARL();

?>