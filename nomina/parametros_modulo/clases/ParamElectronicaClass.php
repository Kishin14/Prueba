<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ParamElectronica extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ParamElectronicaLayoutClass.php");
	require_once("ParamElectronicaModelClass.php");
	
	$Layout   = new ParamElectronicaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParamElectronicaModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU
	$Layout -> SetEstado     	  ($Model -> GetEstado($this -> getConex()));
	$Layout -> SetAmbiente     	  ($Model -> GetAmbiente($this -> getConex()));
	/* $Layout -> SetTipofactura     ($Model -> GetTipofactura($this -> getConex()));
	$Layout -> SetTipodocumento   ($Model -> GetTipodocumento($this -> getConex()));
	$Layout -> SetTipooficina     ($Model -> GetTipooficina($this -> getConex())); */
	
	$Layout -> RenderMain();
  
  }
  
  
  protected function showGrid(){
	  
	require_once("ParamElectronicaLayoutClass.php");
	require_once("ParamElectronicaModelClass.php");
	
	$Layout   = new ParamElectronicaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParamElectronicaModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'parametros',
		title		=>'Listado de Parametros Facturacion Electronica',
		sortname	=>'param_nom_electronica_id',
		width		=>'auto',
		height	=>'250'
	  );
  
	  $Cols = array(
	  
		array(name=>'param_nom_electronica_id',	index=>'param_nom_electronica_id',	sorttype=>'text',	width=>'80',	align=>'center'),
		array(name=>'wsdl',						index=>'wsdl',						sorttype=>'text',	width=>'130',	align=>'left'),
		array(name=>'wsanexo',					index=>'wsanexo',					sorttype=>'text',	width=>'120',	align=>'left'),	  
		array(name=>'wsdl_prueba',				index=>'wsdl_prueba',				sorttype=>'text',	width=>'140',	align=>'left'),	  	  
		array(name=>'wsanexo_prueba',			index=>'wsanexo_prueba',			sorttype=>'text',	width=>'220',	align=>'left'),
		array(name=>'tokenenterprise',			index=>'tokenenterprise',			sorttype=>'text',	width=>'140',	align=>'left'),	  
		array(name=>'tokenautorizacion',		index=>'tokenautorizacion',			sorttype=>'text',	width=>'150',	align=>'left'),
		array(name=>'correo',					index=>'correo',					sorttype=>'int',	width=>'210',	align=>'left')
	  );
		
	  $Titles = array('No.',
					  'URL o WSDL',
					  'URL Anexo o WSDL Anexo',
					  'URL Prueba o WSDL Prueba',
					  'URL Prueba Anexo o WSDL Prueba Anexo',
					  'Token Empresa',
					  'Token Autorizacion',
					  'Correo'
	  );
	  
	  $html = $Layout -> SetGridParamElectronica($Attributes,$Titles,$Cols,$Model -> GetQueryParamElectronicaGrid());
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){
	require_once("ParamElectronicaModelClass.php");
    $Model = new ParamElectronicaModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("ParamElectronicaModelClass.php");
    $Model = new ParamElectronicaModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('¡Se ingreso correctamente!');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("ParamElectronicaModelClass.php");
    $Model = new ParamElectronicaModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('¡Se actualizo correctamente!');
	  }
	
  }


  protected function onclickDelete(){

  	require_once("ParamElectronicaModelClass.php");
    $Model = new ParamElectronicaModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar');
	}else{
	    exit('¡Se borro exitosamente!');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("ParamElectronicaModelClass.php");
    $Model = new ParamElectronicaModel();
	
    $Data                  = array();
	$param_nom_electronica_id   = $_REQUEST['param_nom_electronica_id'];
	 
	if(is_numeric($param_nom_electronica_id)){

	  
	  $Data  = $Model -> selectDatosParamElectronicaId($param_nom_electronica_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[param_nom_electronica_id] = array(
		name	=>'param_nom_electronica_id',
		id		=>'param_nom_electronica_id',
		type	=>'text',
		Boostrap =>'si',
		disabled=>'yes',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[wsdl] = array(
		name	=>'wsdl',
		id		=>'wsdl',
		type	=>'text_lower',
		Boostrap =>'si',
		// required=>'yes',
	 	datatype=>array(
			type	=>'text_lower'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);
	$this -> Campos[wsanexo] = array(
		name	=>'wsanexo',
		id		=>'wsanexo',
		type	=>'text_lower',
		Boostrap =>'si',
		// required=>'yes',
	 	datatype=>array(
			type	=>'text_lower'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);
	$this -> Campos[wsdl_prueba] = array(
		name	=>'wsdl_prueba',
		id		=>'wsdl_prueba',
		type	=>'text_lower',
		Boostrap =>'si',
		// required=>'yes',
	 	datatype=>array(
			type	=>'text_lower'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);

	$this -> Campos[prefijo] = array(
		name	=>'prefijo',
		id		=>'prefijo',
		type	=>'text_lower',
		Boostrap =>'si',
		// required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);

	$this -> Campos[rango_comienza] = array(
		name	=>'rango_comienza',
		id		=>'rango_comienza',
		type	=>'text',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'integer',
			length	=>'5'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);
	$this -> Campos[rango_final] = array(
		name	=>'rango_final',
		id		=>'rango_final',
		type	=>'text',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'integer',
			length	=>'5'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);
	$this -> Campos[rango_inicial] = array(
		name	=>'rango_inicial',
		id		=>'rango_inicial',
		type	=>'text',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'integer',
			length	=>'5'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);

	$this -> Campos[wsanexo_prueba] = array(
		name	=>'wsanexo_prueba',
		id		=>'wsanexo_prueba',
		type	=>'text_lower',
		Boostrap =>'si',
		// required=>'yes',
	 	datatype=>array(
			type	=>'text_lower'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);
	$this -> Campos[tokenenterprise] = array(
		name	=>'tokenenterprise',
		id		=>'tokenenterprise',
		type	=>'text_lower',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text_lower'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);
	$this -> Campos[tokenautorizacion] = array(
		name	=>'tokenautorizacion',
		id		=>'tokenautorizacion',
		type	=>'text_lower',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text_lower'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);
	$this -> Campos[correo] = array(
		name	=>'correo',
		id		=>'correo',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'email'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
			type	=>array('column'))
	);

	$this -> Campos[ambiente] = array(
		name	=>'ambiente',
		id		=>'ambiente',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('param_nomina_electronica'),
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
		//tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		//tabindex=>'20'
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
  		disabled=>'disabled',
		//tabindex=>'21',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ParamElectronicaOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'ParamElectronicaOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap =>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'param_nomina_electronica',
			setId	=>'param_nom_electronica_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$ParamElectronica_factura_id = new ParamElectronica();

?>