<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Convocatoria extends Controler{

	public function __construct(){
		parent::__construct(3);
	}

	public function Main(){
		$this -> noCache();
		require_once("ConvocatoriaLayoutClass.php");
		require_once("ConvocatoriaModelClass.php");

		$Layout   = new ConvocatoriaLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new ConvocatoriaModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
		$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
		$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
		$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

		$Layout -> SetCampos($this -> Campos);

		//LISTA MENU
		$Layout -> Setcargo($Model -> Getcargo($this -> getConex()));
		


		//// GRID ////
		$Attributes = array(
			id		=>'convocatoria',
			title	=>'Listado de convocados',
			sortname=>'fecha_apertura',
			width	=>'1325',
			height	=>'250'
		);

		$Cols = array(
			
			array(name=>'fecha_apertura', index=>'fecha_apertura',	sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'fecha_cierre', index=>'fecha_cierre',	sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'cargo', index=>'cargo', sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'estado', index=>'estado',	sorttype=>'text',	width=>'150',	align=>'center')

		);

		$Titles = array(
			'FECHA APERTURA',
			'FECHA CIERRE',
			'CARGO',
			'ESTADO'
		);

		$Layout -> SetGridConvocatoria($Attributes,$Titles,$Cols,$Model -> GetQueryConvocatoriaGrid());
		$Layout -> RenderMain();
	}

	protected function onclickValidateRow(){
		require_once("ConvocatoriaModelClass.php");
		$Model = new ConvocatoriaModel();
		echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
	}


	protected function onclickSave(){

		require_once("ConvocatoriaModelClass.php");
		$Model = new ConvocatoriaModel();
		$Model -> Save($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
		}else{
		exit('Se ingreso correctamente la convocatoria');
		}
	}

	protected function onclickUpdate(){

		require_once("ConvocatoriaModelClass.php");
		$Model = new ConvocatoriaModel();
		$Model -> Update($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente la convocatoria ');
		}
	}


	protected function onclickDelete(){

		require_once("ConvocatoriaModelClass.php");
		$Model = new ConvocatoriaModel();
		$Model -> Delete($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('No se puede borrar la convocatoria');
		}else{
			exit('Se borro exitosamente la convocatoria');
		}
	}


	//BUSQUEDA
	protected function onclickFind(){
		require_once("ConvocatoriaModelClass.php");
		$Model = new ConvocatoriaModel();
		$Data  = array();
		$convocatoria_id   = $_REQUEST['convocatoria_id'];
		if(is_numeric($convocatoria_id)){
			$Data  = $Model -> selectDatosConvocatoriaId($convocatoria_id,$this -> getConex());
		}
		echo json_encode($Data);
	}


	protected function SetCampos(){

		/**************************
		Campos Tarifas Convocatoria
		***************************/

		$this -> Campos[convocatoria_id] = array(
			name	=>'convocatoria_id',
			id		=>'convocatoria_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement'),
			transaction=>array(
				table	=>array('convocatoria'),
				type	=>array('primary_key'))
		);

		$this -> Campos[fecha_apertura] = array(
			name	=>'fecha_apertura',
			id		=>'fecha_apertura',
			type	=>'text',
			required=>'yes',
			datatype=>array(
				type	=>'date',
				length	=>'45'),
			transaction=>array(
				table	=>array('convocatoria'),
				type	=>array('column'))
		);

		$this -> Campos[fecha_cierre] = array(
			name	=>'fecha_cierre',
			id		=>'fecha_cierre',
			type	=>'text',
			required=>'yes',
			datatype=>array(
				type	=>'date',
				length	=>'45'),
			transaction=>array(
				table	=>array('convocatoria'),
				type	=>array('column'))
		);

		$this -> Campos[estado] = array(
			name	=>'estado',
			id		=>'estado',
			type	=>'select',
			options	=> array(array(value=>'1',text=>'ACTIVO',selected=>'1'),array(value=>'0',text=>'INACTIVO')),
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'45'),
			transaction=>array(
				table	=>array('convocatoria'),
				type	=>array('column'))
		);
		$this -> Campos[cargo_id] = array(
			name	=>'cargo_id',
			id		=>'cargo_id',
			type	=>'select',
			
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'10'),
			transaction=>array(
				table	=>array('convocatoria'),
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
				onsuccess=>'ConvocatoriaOnSaveOnUpdateonDelete')
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			// tabindex=>'22',
			onclick	=>'ConvocatoriaOnReset(this.form)'
		);

		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			size	=>'85',
			// tabindex=>'1',
			suggest=>array(
				name	=>'convocatoria',
				setId	=>'convocatoria_id',
				onclick	=>'setDataFormWithResponse')
		);
		$this -> SetVarsValidate($this -> Campos);
	}
}
$convocatoria_id = new Convocatoria();
?>