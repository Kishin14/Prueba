<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CausalDes extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("CausalDesLayoutClass.php");
	require_once("CausalDesModelClass.php");
	
	$Layout   = new CausalDesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CausalDesModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));   
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("CausalDesLayoutClass.php");
	require_once("CausalDesModelClass.php");
	
	$Layout   = new CausalDesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CausalDesModel();
	  
	//// GRID ////
	$Attributes = array(
		id		=>'causal_despido',
		title		=>'Listado de Causas de Despido',
		sortname	=>'nombre',
		width		=>'600',
		height	=>'200'
	  );
  
	  $Cols = array(
		  array(name=>'causal_despido_id',	index=>'causal_despido_id',	sorttype=>'text',	width=>'50',	align=>'center'),
		  array(name=>'nombre',				index=>'nombre',			sorttype=>'text',	width=>'300',	align=>'left'),
			array(name=>'tipo_causal',			index=>'tipo_causal',		sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'estado',				index=>'estado',			sorttype=>'text',	width=>'100',	align=>'center')
	  );
		
	  $Titles = array('CODIGO',
					  'NOMBRE',
					  'TIPO CAUSAL',					
					  'ESTADO'
	  );
	  
	  $html =  $Layout -> SetGridCausalDes($Attributes,$Titles,$Cols,$Model -> GetQueryCausalDesGrid());
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){
	require_once("CausalDesModelClass.php");
    $Model = new CausalDesModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("CausalDesModelClass.php");
    $Model = new CausalDesModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo causal de despido');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("CausalDesModelClass.php");
    $Model = new CausalDesModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el causal de despido');
	  }
	
  }

  protected function onclickDelete(){

	require_once("CausalDesModelClass.php");
	$Model = new CausalDesModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el causal de despido');
	}else{
		exit('Se borro exitosamente el causal de despido');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
	require_once("CausalDesModelClass.php");
    $Model = new CausalDesModel();
	
    $Data          		= array();
	$causal_despido_id 	= $_REQUEST['causal_despido_id'];
	 
	if(is_numeric($causal_despido_id)){
	  
	  $Data  = $Model -> selectDatosCausalDesId($causal_despido_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Incapacidad
	********************/
	
	$this -> Campos[causal_despido_id] = array(
		name	=>'causal_despido_id',
		id		=>'causal_despido_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('causal_despido'),
			type	=>array('primary_key'))
	);

	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('causal_despido'),
			type	=>array('column'))
	);

	$this -> Campos[tipo_causal] = array(
		name	=>'tipo_causal',
		id		=>'tipo_causal',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'J',text=>'JUSTIFICADA',selected=>'0'),array(value=>'I',text=>'INJUSTIFICADA')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('causal_despido'),
			type	=>array('column'))
	);

	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'A',text=>'ACTIVO',selected=>'0'),array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('causal_despido'),
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
			onsuccess=>'CausalDesOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CausalDesOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap =>'si',
		placeholder =>'Por favor digite el nombre',
		size	=>'85',
		suggest=>array(
			name	=>'causal_despido',
			setId	=>'causal_despido_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$causal_despido_id = new CausalDes();

?>