<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Cargo extends Controler{

	public function __construct(){
		parent::__construct(3);
	}

	public function Main(){

		$this -> noCache();

		require_once("CargoLayoutClass.php");
		require_once("CargoModelClass.php");

		$Layout   = new CargoLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new CargoModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
		$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
		$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
		$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

		$Layout -> SetCampos($this -> Campos);

		//LISTA MENU
		$Layout -> SetARL($Model -> GetARL($this -> getConex()));


		//// GRID ////
		$Attributes = array(
			id		=>'cargo',
			title	=>'Listado de cargos',
			sortname=>'nombre_cargo',
			width	=>'auto',
			height	=>'250'
		);

		$Cols = array(
			array(name=>'cargo_id',			index=>'cargo_id',			sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'nombre_cargo',			index=>'nombre_cargo',			sorttype=>'text',	width=>'250',	align=>'left'),
			array(name=>'base',	index=>'base',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'categoria_arl_id',			index=>'categoria_arl_id',			sorttype=>'text',	width=>'150',	align=>'center'),
		);

		$Titles = array(
			'CODIGO',
			'NOMBRE',
			'BASE',
			'CATEGORIA ARL'
		);

		$Layout -> SetGridCargo($Attributes,$Titles,$Cols,$Model -> GetQueryCargoGrid());
		$Layout -> RenderMain();
	}

	protected function onclickValidateRow(){
		require_once("CargoModelClass.php");
		$Model = new CargoModel();
		echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
	}


	protected function onclickSave(){

		require_once("CargoModelClass.php");
		$Model = new CargoModel();
		$Model -> Save($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
		}else{
		exit('Se ingreso correctamente el Cargo');
		}
	}

	protected function onclickUpdate(){

		require_once("CargoModelClass.php");
		$Model = new CargoModel();
		$Model -> Update($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente el Cargo');
		}
	}


	protected function onclickDelete(){

		require_once("CargoModelClass.php");
		$Model = new CargoModel();
		$Model -> Delete($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('No se puede borrar el Cargo');
		}else{
			exit('Se borro exitosamente el Cargo');
		}
	}


	//BUSQUEDA
	protected function onclickFind(){

		require_once("CargoModelClass.php");
		$Model = new CargoModel();
		$Data                  = array();
		$cargo_id   = $_REQUEST['cargo_id'];
		if(is_numeric($cargo_id)){
			$Data  = $Model -> selectDatosCargoId($cargo_id,$this -> getConex());
		}
		echo json_encode($Data);
	}


	protected function SetCampos(){

		/********************
		Campos Tarifas Proveedor
		********************/

		$this -> Campos[cargo_id] = array(
			name	=>'cargo_id',
			id		=>'cargo_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement'),
			transaction=>array(
				table	=>array('cargo'),
				type	=>array('primary_key'))
		);

		$this -> Campos[base] = array(
			name	=>'base',
			id		=>'base',
			type	=>'text',
			required=>'yes',
			datatype=>array(
				type	=>'numeric',
				length	=>'15'),
			transaction=>array(
				table	=>array('cargo'),
				type	=>array('column'))
		);

		$this -> Campos[nombre_cargo] = array(
			name	=>'nombre_cargo',
			id		=>'nombre_cargo',
			type	=>'text',
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('cargo'),
				type	=>array('column'))
		);



		$this -> Campos[categoria_arl_id] = array(
			name	=>'categoria_arl_id',
			id		=>'categoria_arl_id',
			type	=>'select',
			options	=>null,
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('cargo'),
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
			// tabindex=>'19'
		);

		$this -> Campos[actualizar] = array(
			name	=>'actualizar',
			id		=>'actualizar',
			type	=>'button',
			value	=>'Actualizar',
			disabled=>'disabled',
			// tabindex=>'20'
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
				onsuccess=>'CargoOnSaveOnUpdateonDelete')
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			// tabindex=>'22',
			onclick	=>'CargoOnReset()'
		);

		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			size	=>'85',
			// tabindex=>'1',
			suggest=>array(
				name	=>'cargo',
				setId	=>'cargo_id',
				onclick	=>'setDataFormWithResponse')
		);
		$this -> SetVarsValidate($this -> Campos);
	}
}
$cargo = new Cargo();
?>