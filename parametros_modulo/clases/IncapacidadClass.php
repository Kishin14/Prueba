<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Incapacidad extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("IncapacidadLayoutClass.php");
	require_once("IncapacidadModelClass.php");
	
	$Layout   = new IncapacidadLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new IncapacidadModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	

	//// GRID ////
	$Attributes = array(
	  id		=>'tipo_incapacidad',
	  title		=>'Listado de Tipos de Incapacidades',
	  sortname	=>'tipo_incapacidad_id',
	  width		=>'auto',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'tipo_incapacidad_id',	index=>'tipo_incapacidad_id',	sorttype=>'text',	width=>'50',	align=>'center'),
		array(name=>'nombre',				index=>'nombre',				sorttype=>'text',	width=>'300',	align=>'left'),
		array(name=>'tipo',					index=>'tipo',					sorttype=>'text',	width=>'100',	align=>'left'),	
		array(name=>'diagnostico',			index=>'diagnostico',			sorttype=>'text',	width=>'100',	align=>'left'),	
		array(name=>'descuento',			index=>'descuento',				sorttype=>'text',	width=>'100',	align=>'left'),	
		array(name=>'dia',					index=>'dia',					sorttype=>'text',	width=>'100',	align=>'left'),	
		array(name=>'porcentaje',			index=>'porcentaje',			sorttype=>'text',	width=>'100',	align=>'left'),	
	  	array(name=>'estado',				index=>'estado',				sorttype=>'text',	width=>'50',	align=>'center')
	);
	  
    $Titles = array('CODIGO',
    				'NOMBRE',
    				'TIPO',	
					'DIAGNOSTICO',	
					'PAGO PARCIAL',	
					'DIA',	
					'PORCENTAJE',	
    				'ESTADO'
	);
	
	$Layout -> SetGridIncapacidad($Attributes,$Titles,$Cols,$Model -> GetQueryIncapacidadGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("IncapacidadModelClass.php");
    $Model = new IncapacidadModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("IncapacidadModelClass.php");
    $Model = new IncapacidadModel();
	
	$porcentaje = str_replace(',','.',$_REQUEST['porcentaje']);
	
	if($_REQUEST['tipo']=='I' && $_REQUEST['descuento']=='S' && (!is_numeric($_REQUEST['dia']) || !is_numeric($porcentaje))){
		exit('Para Incapacidades con Pago Parcial debe indicar D&iacute;as y Porcentaje!!');
	}
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo Tipo de Incapacidad');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("IncapacidadModelClass.php");
    $Model = new IncapacidadModel();

	$porcentaje = str_replace(',','.',$_REQUEST['porcentaje']);
	if($_REQUEST['tipo']=='I' && $_REQUEST['descuento']=='S' && (!is_numeric($_REQUEST['dia']) || !is_numeric($porcentaje))){
		exit('Para Incapacidades con Pago Parcial debe indicar D&iacute;as y Porcentaje!!');
	}

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Tipo de Incapacidad');
	  }
	
  }

  protected function onclickDelete(){

	require_once("IncapacidadModelClass.php");
	$Model = new IncapacidadModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el tipo de incapacidad');
	}else{
		exit('Se borro exitosamente el tipo de incapacidad');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
	require_once("IncapacidadModelClass.php");
    $Model = new IncapacidadModel();
	
    $Data          		= array();
	$tipo_incapacidad_id 	= $_REQUEST['tipo_incapacidad_id'];
	 
	if(is_numeric($tipo_incapacidad_id)){
	  
	  $Data  = $Model -> selectDatosIncapacidadId($tipo_incapacidad_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Incapacidad
	********************/
	
	$this -> Campos[tipo_incapacidad_id] = array(
		name	=>'tipo_incapacidad_id',
		id		=>'tipo_incapacidad_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tipo_incapacidad'),
			type	=>array('primary_key'))
	);

	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		required=>'yes',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('tipo_incapacidad'),
			type	=>array('column'))
	);

	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'L',text=>'LICENCIA',selected=>'L'),array(value=>'I',text=>'INCAPACIDAD')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_incapacidad'),
			type	=>array('column'))
	);
	
	$this -> Campos[diagnostico] = array(
		name	=>'diagnostico',
		id		=>'diagnostico',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'S',text=>'SI',selected=>'N'),array(value=>'N',text=>'NO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_incapacidad'),
			type	=>array('column'))
	);

	$this -> Campos[descuento] = array(
		name	=>'descuento',
		id		=>'descuento',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'S',text=>'SI',selected=>'N'),array(value=>'N',text=>'NO',selected=>'N')),
		required=>'yes',
		selected=>'N',
		disabled=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_incapacidad'),
			type	=>array('column'))
	);

	$this -> Campos[dia] = array(
		name	=>'dia',
		id		=>'dia',
		type	=>'text',
		Boostrap =>'si',
		//required=>'yes',
		disabled=>'yes',		
	 	datatype=>array(
			type	=>'integer',
			length	=>'3'),
		transaction=>array(
			table	=>array('tipo_incapacidad'),
			type	=>array('column'))
	);

	$this -> Campos[porcentaje] = array(
		name	=>'porcentaje',
		id		=>'porcentaje',
		type	=>'text',
		Boostrap =>'si',
		//required=>'yes',
		disabled=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'4',
			presicion=>3),
		transaction=>array(
			table	=>array('tipo_incapacidad'),
			type	=>array('column'))
	);

	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_incapacidad'),
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
			onsuccess=>'IncapacidadOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'IncapacidadOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		placeholder =>'Por favor digite el nombre',
		suggest=>array(
			name	=>'tipo_incapacidad',
			setId	=>'tipo_incapacidad_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tipo_incapacidad_id = new Incapacidad();

?>