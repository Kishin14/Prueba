<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CausalEval extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("CausalEvalLayoutClass.php");
	require_once("CausalEvalModelClass.php");
	
	$Layout   = new CausalEvalLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CausalEvalModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	

	//// GRID ////
	$Attributes = array(
	  id		=>'causal_desempeno',
	  title		=>'Listado de causas de desempeño',
	  sortname	=>'nombre',
	  width		=>'600',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'causal_desempeno_id',		index=>'causal_desempeno_id',		sorttype=>'text',	width=>'50',	align=>'center'),
		array(name=>'nombre',		index=>'nombre',		sorttype=>'text',	width=>'300',	align=>'left'),
		array(name=>'nota',		    index=>'nota',		    sorttype=>'text',	width=>'200',	align=>'left'),
	  	array(name=>'estado',		index=>'estado',		sorttype=>'text',	width=>'200',	align=>'center')
	);
	  
    $Titles = array('CODIGO',
					'NOMBRE',
					'ESTADO',
    				'NOTA MINIMA',
	);
	
	$Layout -> SetGridCausalEval($Attributes,$Titles,$Cols,$Model -> GetQueryCausalEvalGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("CausalEvalModelClass.php");
    $Model = new CausalEvalModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("CausalEvalModelClass.php");
    $Model = new CausalEvalModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo causal de desempeño');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("CausalEvalModelClass.php");
    $Model = new CausalEvalModel();
    $causal_desempeno_id = $_REQUEST['causal_desempeno_id'];
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el causal de desempeño');
	  }
	
  }

  protected function onclickDelete(){

	require_once("CausalEvalModelClass.php");
	$Model = new CausalEvalModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el causal de desempeño');
	}else{
		exit('Se borro exitosamente el causal de desempeño');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
	require_once("CausalEvalModelClass.php");
    $Model = new CausalEvalModel();
	
    $Data          		= array();
	$causal_desempeno_id 	= $_REQUEST['causal_desempeno_id'];
	 
	if(is_numeric($causal_desempeno_id)){
	  
	  $Data  = $Model -> selectDatosCausalEvalId($causal_desempeno_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Incapacidad
	********************/
	
	$this -> Campos[causal_desempeno_id] = array(
		name	=>'causal_desempeno_id',
		id		=>'causal_desempeno_id',
		type	=>'text',
		readonly =>'yes',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('causal_desempeno'),
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
			table	=>array('causal_desempeno'),
			type	=>array('column'))
	);

	$this -> Campos[nota] = array(
		name	=>'nota',
		id		=>'nota',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('causal_desempeno'),
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
			table	=>array('causal_desempeno'),
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
			onsuccess=>'CausalEvalOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CausalEvalOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'causal_desempeno',
			setId	=>'causal_desempeno_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$causal_desempeno_id = new CausalEval();

?>