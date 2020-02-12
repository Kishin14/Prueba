<?php

require_once("../../../framework/clases/ControlerClass.php");

final class TipoVehiculo extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("TipoVehiculoLayoutClass.php");
	require_once("TipoVehiculoModelClass.php");
	
	$Layout   = new TipoVehiculoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TipoVehiculoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	

	//// GRID ////
	$Attributes = array(
	  id		=>'tipo_vehiculo_nomina',
	  title		=>'Listado de Tipos de Vehículos',
	  sortname	=>'nombre',
	  width		=>'auto',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'nombre',		index=>'nombre',		sorttype=>'text',	width=>'300',	align=>'left'),
	  	array(name=>'codigo',		index=>'codigo',		sorttype=>'text',	width=>'100',	align=>'left'), 
		array(name=>'servicio',		index=>'servicio',		sorttype=>'text',	width=>'100',	align=>'left'),
		array(name=>'tipo',			index=>'tipo',			sorttype=>'text',	width=>'150',	align=>'center'),
	);
	  
    $Titles = array('NOMBRE',
    				'CODIGO',
					'SERVICIO',
					'TIPO'
	);
	
	$Layout -> SetGridTipoVehiculo($Attributes,$Titles,$Cols,$Model -> GetQueryTipoVehiculoGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("TipoVehiculoModelClass.php");
    $Model = new TipoVehiculoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("TipoVehiculoModelClass.php");
    $Model = new TipoVehiculoModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo Tipo de Vehículo');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("TipoVehiculoModelClass.php");
    $Model = new TipoVehiculoModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Tipo de Vehículo');
	  }
	
  }

  protected function onclickDelete(){

	require_once("TipoVehiculoModelClass.php");
	$Model = new TipoVehiculoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el tipo de vehículo');
	}else{
		exit('Se borro exitosamente el tipo de vehículo');
	}
  }



//BUSQUEDA
  protected function onclickFind(){
	require_once("TipoVehiculoModelClass.php");
    $Model = new TipoVehiculoModel();
	
    $Data          		= array();
	$vehiculo_nomina_id 	= $_REQUEST['vehiculo_nomina_id'];
	 
	if(is_numeric($vehiculo_nomina_id)){
	  
	  $Data  = $Model -> selectDatosTipoVehiculoId($vehiculo_nomina_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos TipoVehiculo
	********************/
	
	$this -> Campos[vehiculo_nomina_id] = array(
		name	=>'vehiculo_nomina_id',
		id		=>'vehiculo_nomina_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tipo_vehiculo_nomina'),
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
			length	=>'45'),
		transaction=>array(
			table	=>array('tipo_vehiculo_nomina'),
			type	=>array('column'))
	);
	
	$this -> Campos[codigo] = array(
		name	=>'codigo',
		id		=>'codigo',
		type	=>'text',
		required=>'yes',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'15'),
		transaction=>array(
			table	=>array('tipo_vehiculo_nomina'),
			type	=>array('column'))
	);
	
		$this -> Campos[servicio] = array(
		name	=>'servicio',
		id		=>'servicio',
		type	=>'select',
		Boostrap =>'si',
		options	 =>array(array(value => '1',text => 'PARTICULAR'),array(value => '0', text => 'PUBLICO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'45'),
		transaction=>array(
			table	=>array('tipo_vehiculo_nomina'),
			type	=>array('column'))
	);
	
			$this -> Campos[tipo] = array(
			name	=>'tipo',
			id		=>'tipo',
			type	=>'select',
			Boostrap =>'si',
			options	=>array(array(value => 'C',text => 'CARGA'),array(value => 'P', text => 'PASAJERO'),array(value => 'R', text => 'PROPIO')),
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('tipo_vehiculo_nomina'),
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
			onsuccess=>'TipoVehiculoOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'TipoVehiculoOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		placeholder =>'Por favor digite el nombre',
		suggest=>array(
			name	=>'tipo_vehiculo_nomina',
			setId	=>'vehiculo_nomina_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$vehiculo_nomina_id = new TipoVehiculo();

?>