<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Perfil extends Controler{

	public function __construct(){
		parent::__construct(3);
	}

	public function Main(){

		$this -> noCache();

		require_once("PerfilLayoutClass.php");
		require_once("PerfilModelClass.php");

		$Layout   = new PerfilLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new PerfilModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
		$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
		$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
		$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

		$Layout -> SetCampos($this -> Campos);

		//LISTA MENU
		
		$Layout -> SetEscolaridad($Model -> GetEscolaridad($this -> getConex()));
		$Layout -> SetEscala($Model -> GetEscala($this -> getConex()));
		$Layout -> SetCivil($Model -> GetCivil($this -> getConex()));
		$Layout -> SetARL($Model -> GetARL($this -> getConex()));

		//// GRID ////
		$Attributes = array(
			id		=>'perfil',
			title	=>'Listado de Perfiles',
			sortname=>'experiencia',
			width	=>'auto',
			height	=>'250'
		);

		$Cols = array(
			array(name=>'perfil_id',			index=>'perfil_id',			sorttype=>'text',	width=>'70',	align=>'center'),
			array(name=>'cargo_id',				index=>'cargo_id',			sorttype=>'text',	width=>'200',	align=>'left'),
			array(name=>'arl',					index=>'arl',				sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'nivel_escolaridad_id',	index=>'nivel_escolaridad_id',sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'experiencia',			index=>'experiencia',		sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'escala_salarial_id',	index=>'escala_salarial_id',sorttype=>'text',	width=>'130',	align=>'center'),
			array(name=>'sexo',					index=>'sexo',				sorttype=>'text',	width=>'50',	align=>'center'),
			array(name=>'minimo_edad',			index=>'minimo_edad',		sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'maximo_edad',			index=>'maximo_edad',		sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'rango_sal_minimo',		index=>'rango_sal_minimo',	sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'rango_sal_maximo',		index=>'rango_sal_maximo',	sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'estado_civil_id',		index=>'estado_civil_id',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'ocupacion_dane',		index=>'ocupacion_dane',	sorttype=>'text',	width=>'100',	align=>'left')			

		);

		$Titles = array(
			'CODIGO',
			'CARGO',
			'CAT ARL',
			'NIVEL ESCOLARIDAD',
			'EXPERIENCIA',
			'ESCALA SALARIAL',
			'SEXO',
			'EDAD MIN',
			'EDAD MAX',
			'RANGO SALARIO MIN',
			'RANGO SALARIO MAX',
			'ESTADO CIVIL',
			'OCUPACION DANE'
		);

		$Layout -> SetGridPerfil($Attributes,$Titles,$Cols,$Model -> GetQueryPerfilGrid());
		$Layout -> RenderMain();
	}

	protected function onclickValidateRow(){
		require_once("PerfilModelClass.php");
		$Model = new PerfilModel();
		echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
	}


	protected function onclickSave(){

		require_once("PerfilModelClass.php");
		$Model = new PerfilModel();
		$Model -> Save($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
		}else{
		exit('Se ingreso correctamente el perfil');
		}
	}

	protected function onclickUpdate(){

		require_once("PerfilModelClass.php");
		$Model = new PerfilModel();
		$Model -> Update($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente el perfil');
		}
	}


	protected function onclickDelete(){

		require_once("PerfilModelClass.php");
		$Model = new PerfilModel();
		$Model -> Delete($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('No se puede borrar el perfil');
		}else{
			exit('Se borro exitosamente el perfil');
		}
	}


	//BUSQUEDA
	protected function onclickFind(){

		require_once("PerfilModelClass.php");
		$Model = new PerfilModel();
		$Data                  = array();
		$perfil_id   = $_REQUEST['perfil_id'];
		if(is_numeric($perfil_id)){
			$Data  = $Model -> selectDatosPerfilId($perfil_id,$this -> getConex());
		}
		echo json_encode($Data);
	}


	protected function SetCampos(){

		/********************
		Campos Tarifas Proveedor
		********************/

		$this -> Campos[perfil_id] = array(
			name	=>'perfil_id',
			id		=>'perfil_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('primary_key'))
		);

	
		$this -> Campos[cargo_id] = array(
			name	=>'cargo_id',
			id		=>'cargo_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement'),
			transaction=>array(
				table	=>array('cargo','perfil'),
				type	=>array('primary_key','column'))
		);

		$this -> Campos[base] = array(
			name	=>'base',
			id		=>'base',
			type	=>'text',
			Boostrap =>'si',
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
			Boostrap =>'si',
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
			Boostrap =>'si',
			options	=>null,
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('cargo'),
				type	=>array('column'))
		);

		$this -> Campos[experiencia] = array(
			name	=>'experiencia',
			id		=>'experiencia',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'11'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('column'))
		);

		$this -> Campos[sexo] = array(
			name	=>'sexo',
			id		=>'sexo',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'M',text=>'MASCULINO',selected=>'0'),array(value=>'F',text=>'FEMENINO'),array(value=>'C',text=>'CUALQUIERA')),
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'1'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('column'))
		);

		$this -> Campos[minimo_edad] = array(
			name	=>'minimo_edad',
			id		=>'minimo_edad',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'11'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('column'))
		);

		$this -> Campos[maximo_edad] = array(
			name	=>'maximo_edad',
			id		=>'maximo_edad',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'11'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('column'))
		);

		$this -> Campos[rango_sal_minimo] = array(
			name	=>'rango_sal_minimo',
			id		=>'rango_sal_minimo',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			datatype=>array(
				type	=>'numeric',
				length	=>'11'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('column'))
		);

		$this -> Campos[rango_sal_maximo] = array(
			name	=>'rango_sal_maximo',
			id		=>'rango_sal_maximo',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			datatype=>array(
				type	=>'numeric',
				length	=>'11'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('column'))
		);


		$this -> Campos[nivel_escolaridad_id] = array(
			name	=>'nivel_escolaridad_id',
			id		=>'nivel_escolaridad_id',
			type	=>'select',
			Boostrap =>'si',
			options	=>null,
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('column'))
		);

		$this -> Campos[escala_salarial_id] = array(
			name	=>'escala_salarial_id',
			id		=>'escala_salarial_id',
			type	=>'select',
			Boostrap =>'si',
			options	=>null,
			//required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('column'))
		);

		$this -> Campos[estado_civil_id] = array(
			name	=>'estado_civil_id',
			id		=>'estado_civil_id',
			type	=>'select',
			Boostrap =>'si',
			options	=>null,
			//required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('perfil'),
				type	=>array('column'))
		);

			$this -> Campos[area_laboral] = array(
				name	=>'area_laboral',
				id		=>'area_laboral',
				type	=>'select',
				Boostrap =>'si',
				options	=> array(array(value=>'A',text=>'ADMINISTRATIVO',selected=>'A'),array(value=>'O',text=>'OPERATIVO'),array(value=>'C',text=>'COMERCIAL')),
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'2'),
				transaction=>array(
					table	=>array('perfil'),
					type	=>array('column'))
			);

			$this -> Campos[ocupacion] = array(
				name	=>'ocupacion',
				id		=>'ocupacion',
				type	=>'text',
				Boostrap =>'si',
				size	=>'40',
				// tabindex=>'1',
				suggest=>array(
					name	=>'ocupacion',
					setId	=>'ocupacion_id')
			);

			$this -> Campos[ocupacion_id] = array(
				name	=>'ocupacion_id',
				id		=>'ocupacion_id',
				type	=>'hidden',
				datatype=>array(
					type	=>'integer'),
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
				onsuccess=>'PerfilOnSaveOnUpdateonDelete')
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			// tabindex=>'22',
			onclick	=>'PerfilOnReset()'
		);

		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			size	=>'85',
			placeholder =>'Por favor digite el nombre del cargo',
			Boostrap =>'si',
			// tabindex=>'1',
			suggest=>array(
				name	=>'perfil',
				setId	=>'perfil_id',
				onclick	=>'setDataFormWithResponse')
		);
		$this -> SetVarsValidate($this -> Campos);
	}
}
$perfil = new Perfil();
?>