<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Estudios extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("EstudiosLayoutClass.php");
	require_once("EstudiosModelClass.php");
	
	$Layout   = new EstudiosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new EstudiosModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("EstudiosModelClass.php");
    $Model = new EstudiosModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  
  
  protected function showGrid(){
	  
	require_once("EstudiosLayoutClass.php");
	require_once("EstudiosModelClass.php");
	
	$Layout   = new EstudiosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new EstudiosModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'nivel_escolaridad',
		title		=>'Listado de Estudios',
		sortname	=>'nombre',
		width		=>'1000',
		height	=>'200'
	  );
  
	  $Cols = array(
		array(name=>'nivel_escolaridad_id',	index=>'nivel_escolaridad_id',	sorttype=>'text',	width=>'50',	align=>'center'),
		array(name=>'nombre',					index=>'nombre',				sorttype=>'text',	width=>'250',	align=>'left'),
		array(name=>'descripcion',			index=>'descripcion',			sorttype=>'text',	width=>'350',	align=>'left'),
		array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'150',	align=>'left')
	  );
		
	  $Titles = array('CODIGO', 'NOMBRE','DESCRIPCION','ESTADO');
	  
	  $html = $Layout -> SetGridEstudios($Attributes,$Titles,$Cols,$Model -> GetQueryEstudiosGrid());
	 
	 print $html;
	  
  }
  

  protected function onclickSave(){

  	require_once("EstudiosModelClass.php");
    $Model = new EstudiosModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo Nivel de Escolaridad');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("EstudiosModelClass.php");
    $Model = new EstudiosModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Nivel de Escolaridad');
	  }
	
  }

   protected function onclickDelete(){

			require_once("EstudiosModelClass.php");
			$Model = new EstudiosModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar el Nivel de Escolaridad');
			}else{
				exit('Se borro exitosamente el Nivel de Escolaridad');
			}
		}


//BUSQUEDA
  protected function onclickFind(){
	require_once("EstudiosModelClass.php");
    $Model = new EstudiosModel();
	
    $Data          		= array();
	$nivel_escolaridad_id	= $_REQUEST['nivel_escolaridad_id'];
	 
	if(is_numeric($nivel_escolaridad_id)){
	  
	  $Data  = $Model -> selectDatosEstudiosId($nivel_escolaridad_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Contrato
	********************/
	
	$this -> Campos[nivel_escolaridad_id] = array(
		name	=>'nivel_escolaridad_id',
		id		=>'nivel_escolaridad_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('nivel_escolaridad'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'45'),
		transaction=>array(
			table	=>array('nivel_escolaridad'),
			type	=>array('column'))
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
			table	=>array('nivel_escolaridad'),
			type	=>array('column'))
	);

	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		options	 =>array(array(value => '1',text => 'ACTIVO'),array(value => '0', text => 'INACTIVO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'45'),
		transaction=>array(
			table	=>array('nivel_escolaridad'),
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
			onsuccess=>'EstudiosOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'EstudiosOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		placeholder =>'Por favor digite el nombre',
		suggest=>array(
			name	=>'nivel_escolaridad',
			setId	=>'nivel_escolaridad_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$nivel_escolaridad_id = new Estudios();

?>