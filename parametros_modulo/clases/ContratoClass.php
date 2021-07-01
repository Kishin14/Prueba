<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Contrato extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ContratoLayoutClass.php");
	require_once("ContratoModelClass.php");
	
	$Layout   = new ContratoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ContratoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);

	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("ContratoLayoutClass.php");
	require_once("ContratoModelClass.php");
	
	$Layout   = new ContratoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ContratoModel();
	  
	//// GRID ////
	$Attributes = array(
		id		=>'tipo_contrato',
		title		=>'Listado de Tipos de Contratos',
		sortname	=>'descripcion',
		width		=>'1000',
		height	=>'200'
	  );
  
	  $Cols = array(
		  array(name=>'tipo_contrato_id',		index=>'tipo_contrato_id',		sorttype=>'text',	width=>'80',	align=>'center'),
		  array(name=>'nombre',				index=>'nombre',				sorttype=>'text',	width=>'100',	align=>'left'),
		  array(name=>'prefijo',				index=>'prefijo',				sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'descripcion',			index=>'descripcion',			sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'periodo_prueba',		index=>'periodo_prueba',		sorttype=>'text',	width=>'120',	align=>'center'),
			array(name=>'indemnizacion',		index=>'indemnizacion',			sorttype=>'text',	width=>'120',	align=>'center'),
			array(name=>'liquidacion',			index=>'liquidacion',			sorttype=>'text',	width=>'120',	align=>'center'),
			array(name=>'prestaciones_sociales',index=>'prestaciones_sociales',	sorttype=>'text',	width=>'150',	align=>'center'), 
			array(name=>'salud',				index=>'salud',					sorttype=>'text',	width=>'80',	align=>'left'), 
			array(name=>'arl',					index=>'arl',					sorttype=>'text',	width=>'80',	align=>'left'), 
			array(name=>'tipo',					index=>'tipo',					sorttype=>'text',	width=>'100',	align=>'left')
	  );
		
	  $Titles = array('CODIGO',
					  'NOMBRE',
					  'PREFIJO',
					  'DESCRIPCION',
					  'PERIODO PRUEBA',
					  'INDEMNIZACION',
					  'LIQUIDACION',
					  'PRESTACIONES SOCIALES',
					  'SALUD',
					  'ARL',
					  'TIPO'
	  );
	  
	 $html = $Layout -> SetGridContrato($Attributes,$Titles,$Cols,$Model -> GetQueryContratoGrid());
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){
	require_once("ContratoModelClass.php");
    $Model = new ContratoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("ContratoModelClass.php");
    $Model = new ContratoModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo Tipo de Contrato');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("ContratoModelClass.php");
    $Model = new ContratoModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Tipo de Contrato');
	  }
	
  }

  protected function onclickDelete(){

	require_once("ContratoModelClass.php");
	$Model = new ContratoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el Contrato');
	}else{
		exit('Se borro exitosamente el Contrato');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
	require_once("ContratoModelClass.php");
    $Model = new ContratoModel();
	
    $Data          		= array();
	$tipo_contrato_id 	= $_REQUEST['tipo_contrato_id'];
	 
	if(is_numeric($tipo_contrato_id)){
	  
	  $Data  = $Model -> selectDatosContratoId($tipo_contrato_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Contrato
	********************/
	
	$this -> Campos[tipo_contrato_id] = array(
		name	=>'tipo_contrato_id',
		id		=>'tipo_contrato_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tipo_contrato'),
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
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);
	
	$this -> Campos[prefijo] = array(
		name	=>'prefijo',
		id		=>'prefijo',
		type	=>'text',
		Boostrap =>'si',
		required=>'no', 
	 	datatype=>array(
			type	=>'text',
			length	=>'9'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);
	
	$this -> Campos[tiempo_contrato] = array(
		name	=>'tiempo_contrato',
		id		=>'tiempo_contrato',
		type	=>'text',
		Boostrap =>'si',
		required=>'no',
	 	datatype=>array(
			type	=>'text',
			length	=>'3'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);
	
	$this -> Campos[prefijo] = array(
		name	=>'prefijo',
		id		=>'prefijo',
		type	=>'text',
		Boostrap =>'si',
		required=>'no', 
	 	datatype=>array(
			type	=>'text',
			length	=>'9'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);
	
	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'textarea',
		
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);

	$this -> Campos[periodo_prueba] = array(
		name	=>'periodo_prueba',
		id		=>'periodo_prueba',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);

	$this -> Campos[indemnizacion] = array(
		name	=>'indemnizacion',
		id		=>'indemnizacion',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);

	$this -> Campos[liquidacion] = array(
		name	=>'liquidacion',
		id		=>'liquidacion',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);

	$this -> Campos[prestaciones_sociales] = array(
		name	=>'prestaciones_sociales',
		id		=>'prestaciones_sociales',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
		required=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);


	$this -> Campos[salud] = array(
		name	=>'salud',
		id		=>'salud',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
		required=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);

	$this -> Campos[pension] = array(
		name	=>'pension',
		id		=>'pension',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
		required=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);

	$this -> Campos[arl] = array(
		name	=>'arl',
		id		=>'arl',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
		required=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_contrato'),
			type	=>array('column'))
	);

	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'F',text=>'FIJO',selected=>'F'),array(value=>'I',text=>'INDEFINIDO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('tipo_contrato'),
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
			onsuccess=>'ContratoOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ContratoOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		placeholder =>'Por favor digite el nombre',
		Boostrap =>'si',
		suggest=>array(
			name	=>'tipo_contrato',
			setId	=>'tipo_contrato_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tipo_contrato_id = new Contrato();

?>