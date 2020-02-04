<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Profesiones extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ProfesionesLayoutClass.php");
	require_once("ProfesionesModelClass.php");
	
	$Layout   = new ProfesionesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ProfesionesModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	

	//// GRID ////
	$Attributes = array(
	  id		=>'profesion',
	  title		=>'Listado de Profesiones',
	  sortname	=>'nombre',
	  width		=>'1000',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'profesion_id',		index=>'profesion_id',		sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'id_dane_profesion',index=>'id_dane_profesion',	sorttype=>'text',	width=>'150',	align=>'left'),
	  	array(name=>'nombre',			index=>'nombre',			sorttype=>'text',	width=>'450',	align=>'left'),  
	);
	  
    $Titles = array('CODIGO',
    				'DANE',
    				'NOMBRE',
	);
	
	$Layout -> SetGridProfesiones($Attributes,$Titles,$Cols,$Model -> GetQueryProfesionesGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("ProfesionesModelClass.php");
    $Model = new ProfesionesModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("ProfesionesModelClass.php");
    $Model = new ProfesionesModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nueva profesión');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("ProfesionesModelClass.php");
    $Model = new ProfesionesModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la profesión');
	  }
	
  }

   protected function onclickDelete(){

			require_once("ProfesionesModelClass.php");
			$Model = new ProfesionesModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar la profesión');
			}else{
				exit('Se borro exitosamente la profesión');
			}
		}


//BUSQUEDA
  protected function onclickFind(){
	require_once("ProfesionesModelClass.php");
    $Model = new ProfesionesModel();
	
    $Data          		= array();
	$profesion_id 	= $_REQUEST['profesion_id'];
	 
	if(is_numeric($profesion_id)){
	  
	  $Data  = $Model -> selectDatosProfesionesId($profesion_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Profesion
	********************/
	
	$this -> Campos[profesion_id] = array(
		name	=>'profesion_id',
		id		=>'profesion_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('profesion'),
			type	=>array('primary_key'))
	);

	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('profesion'),
			type	=>array('column'))
	);
	
	$this -> Campos[nombre_dane] = array(
		name	=>'nombre_dane',
		id		=>'nombre_dane',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('profesion'),
			type	=>array('column'))
	);
	
	$this -> Campos[id_dane_profesion] = array(
		name	=>'id_dane_profesion',
		id		=>'id_dane_profesion',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'20'),
		transaction=>array(
			table	=>array('profesion'),
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
			onsuccess=>'ProfesionesOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ProfesionesOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'profesion',
			setId	=>'profesion_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$profesion_id = new Profesiones();

?>