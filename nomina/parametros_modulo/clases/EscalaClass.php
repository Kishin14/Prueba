<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Escala extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("EscalaLayoutClass.php");
	require_once("EscalaModelClass.php");
	
	$Layout   = new EscalaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new EscalaModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetPeriodo   		($Model -> GetPeriodo($this -> getConex()));

	

	//// GRID ////
	$Attributes = array(
	  id		=>'escala_salarial',
	  title		=>'Listado de Escalas',
	  sortname	=>'minimo',
	  width		=>'1000',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'escala_salarial_id',		index=>'escala_salarial_id',		sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'minimo',					index=>'minimo',					sorttype=>'text',	width=>'200',	align=>'left'),
	  	array(name=>'maximo',					index=>'maximo',					sorttype=>'text',	width=>'200',	align=>'left'),
		array(name=>'pesos_minimo',				index=>'pesos_minimo',				sorttype=>'text',	width=>'200',	align=>'left'),
	  	array(name=>'pesos_maximo',				index=>'pesos_maximo',				sorttype=>'text',	width=>'200',	align=>'left')

	);
	  
    $Titles = array('CODIGO',
    				'MINIMO',
    				'MAXIMO',
    				'MINIMO EN PESOS',
    				'MAXIMO EN PESOS'
					
					
	);
	
	$Layout -> SetGridEscala($Attributes,$Titles,$Cols,$Model -> GetQueryEscalaGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("EscalaModelClass.php");
    $Model = new EscalaModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("EscalaModelClass.php");
    $Model = new EscalaModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente una nueva escala salarial');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("EscalaModelClass.php");
    $Model = new EscalaModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la escala salarial');
	  }
	
  }

  protected function onclickDelete(){

			require_once("EscalaModelClass.php");
			$Model = new EscalaModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar la escala salarial');
			}else{
				exit('Se borro exitosamente la escala salarial');
			}
		}

  protected function getuvt(){

			require_once("EscalaModelClass.php");
			$Model = new EscalaModel();
			$uvt_nominal = $Model -> getuvt($this -> getConex());
				exit("$uvt_nominal");
  }


//BUSQUEDA
  protected function onclickFind(){
	require_once("EscalaModelClass.php");
    $Model = new EscalaModel();
	
    $Data          		= array();
	$escala_salarial_id 	= $_REQUEST['escala_salarial_id'];
	 
	if(is_numeric($escala_salarial_id)){
	  
	  $Data  = $Model -> selectDatosEscalaId($escala_salarial_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Escala salarial
	********************/
	
	$this -> Campos[escala_salarial_id] = array(
		name	=>'escala_salarial_id',
		id		=>'escala_salarial_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('escala_salarial'),
			type	=>array('primary_key'))
	);

	$this -> Campos[minimo] = array(
		name	=>'minimo',
		id		=>'minimo',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('escala_salarial'),
			type	=>array('column'))
	);
	
	$this -> Campos[maximo] = array(
		name	=>'maximo',
		id		=>'maximo',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('escala_salarial'),
			type	=>array('column'))
	);
	
	$this -> Campos[pesos_minimo] = array(
		name	=>'pesos_minimo',
		id		=>'pesos_minimo',
		type	=>'text',
		disabled=>'yes',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('escala_salarial'),
			type	=>array('column'))
	);
	 
	 $this -> Campos[pesos_maximo] = array(
		name	=>'pesos_maximo',
		id		=>'pesos_maximo',
		type	=>'text',
		disabled=>'yes',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('escala_salarial'),
			type	=>array('column'))
	);


	$this -> Campos[periodo_contable_id] = array(
		name	=>'periodo_contable_id',
		id		=>'periodo_contable_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('escala_salarial'),
			type	=>array('column'))
	);
	
		$this -> Campos[uvt_nominal] = array(
		name	=>'uvt_nominal',
		id		=>'uvt_nominal',
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric')
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
			onsuccess=>'EscalaOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'EscalaOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'escala_salarial',
			setId	=>'escala_salarial_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$escala_salarial_id = new Escala();

?>