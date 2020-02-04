<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Concepto extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ConceptoLayoutClass.php");
	require_once("ConceptoModelClass.php");
	
	$Layout   = new ConceptoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ConceptoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);

	//// GRID ////
	$Attributes = array(
	  id		=>'tipo_concepto',
	  title		=>'Listado de Tipos de Conceptos',
	  sortname	=>'concepto',
	  width		=>'600',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'tipo_concepto_laboral_id',		index=>'tipo_concepto_laboral_id',		sorttype=>'text',	width=>'50',	align=>'center'),
		array(name=>'concepto',		index=>'concepto',		sorttype=>'text',	width=>'180',	align=>'left'),
	  	array(name=>'base_salarial',		index=>'base_salarial',		sorttype=>'text',	width=>'50',	align=>'left'),
	  	array(name=>'fija',		index=>'fija',		sorttype=>'text',	width=>'50',	align=>'center'),
	  	array(name=>'porc_empresa',				index=>'porc_empresa',			sorttype=>'text',	width=>'80',	align=>'center'),
	  	array(name=>'porc_trabajador',	index=>'porc_trabajador',	sorttype=>'text',	width=>'120',	align=>'center')
	);
	  
    $Titles = array('CODIGO',
    				'CONCEPTO',
    				'BASE SALARIAL',
    				'FIJA',
    				'PORC EMPRESA',
					'PORC TRABAJADOR'
	);
	
	$Layout -> SetGridConcepto($Attributes,$Titles,$Cols,$Model -> GetQueryConceptoGrid());

	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("ConceptoModelClass.php");
    $Model = new ConceptoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("ConceptoModelClass.php");
    $Model = new ConceptoModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo Tipo de Concepto');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("ConceptoModelClass.php");
    $Model = new ConceptoModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Tipo de Concepto');
	  }
	
  }

  protected function onclickDelete(){

	require_once("ConceptoModelClass.php");
	$Model = new ConceptoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el Concepto');
	}else{
		exit('Se borro exitosamente el Concepto');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
	require_once("ConceptoModelClass.php");
    $Model = new ConceptoModel();
	
    $Data          		= array();
	$tipo_concepto_laboral_id 	= $_REQUEST['tipo_concepto_laboral_id'];
	 
	if(is_numeric($tipo_concepto_laboral_id)){
	  
	  $Data  = $Model -> selectDatosConceptoId($tipo_concepto_laboral_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos concepto
	********************/
	
	$this -> Campos[tipo_concepto_laboral_id] = array(
		name	=>'tipo_concepto_laboral_id',
		id		=>'tipo_concepto_laboral_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tipo_concepto'),
			type	=>array('primary_key'))
	);

	$this -> Campos[concepto] = array(
		name	=>'concepto',
		id		=>'concepto',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('tipo_concepto'),
			type	=>array('column'))
	);
	
	$this -> Campos[base_salarial] = array(
		name	=>'base_salarial',
		id		=>'base_salarial',
		type	=>'select',
		options	=> array(array(value=>'NO',text=>'NO',selected=>'0'),array(value=>'SI',text=>'SI')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'2'),
		transaction=>array(
			table	=>array('tipo_concepto'),
			type	=>array('column'))
	);

	$this -> Campos[fija] = array(
		name	=>'fija',
		id		=>'fija',
		type	=>'select',
		options	=> array(array(value=>'NO',text=>'NO',selected=>'0'),array(value=>'SI',text=>'SI')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'2'),
		transaction=>array(
			table	=>array('tipo_concepto'),
			type	=>array('column'))
	);

	$this -> Campos[porc_empresa] = array(
		name	=>'porc_empresa',
		id		=>'porc_empresa',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('tipo_concepto'),
			type	=>array('column'))
	);

	$this -> Campos[porc_trabajador] = array(
		name	=>'porc_trabajador',
		id		=>'porc_trabajador',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('tipo_concepto'),
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
			onsuccess=>'ConceptoOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ConceptoOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'tipo_concepto',
			setId	=>'tipo_concepto_laboral_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tipo_concepto_laboral_id = new Concepto();

?>