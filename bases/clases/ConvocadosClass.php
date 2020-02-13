<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class Convocados extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){
			$this -> noCache();
			require_once("ConvocadosLayoutClass.php");
			require_once("ConvocadosModelClass.php");

			$Layout   = new ConvocadosLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new ConvocadosModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

			$Layout -> SetCampos($this -> Campos);

			//LISTA MENU
			$Layout -> SetTip($Model -> GetTip($this -> getConex()));
			//$Layout -> SetUbi($Model -> GetUbi($this -> getConex()));


			//// GRID ////
			$Attributes = array(
				id		=>'convocado',
				title	=>'Lista de Convocados',
				sortname=>'numero_identificacion',
				width	=>'auto',
				height	=>'250'
			);

			$Cols = array(
				array(name=>'convocado_id',				index=>'convocado_id',				sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'tipo_identificacion_id',	index=>'tipo_identificacion_id',	sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'numero_identificacion',	index=>'numero_identificacion',		sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'primer_nombre',			index=>'primer_nombre',				sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'segundo_nombre',			index=>'segundo_nombre',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'primer_apellido',			index=>'primer_apellido',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'segundo_apellido',			index=>'segundo_apellido',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'direccion',				index=>'direccion',					sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'telefono',					index=>'telefono',					sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'movil',					index=>'movil',						sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'ubicacion_id',				index=>'ubicacion_id',				sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'estado',					index=>'estado',					sorttype=>'text',	width=>'150',	align=>'center')
			);

			$Titles = array(
				'CONVOCADOOO',
				'TIPO IDENTIFICACION',
				'IDENTIFICACION',
				'PRIMER NOMBRE',
				'SEGUNDO NOMBRE',
				'PRIMER APELLIDO',
				'SEGUNDO APELLIDO',
				'DIRECCION',
				'TELEFONO',
				'MOVIL',
				'UBICACION',
				'ESTADO'
			);

			$Layout -> SetGridConvocados($Attributes,$Titles,$Cols,$Model -> GetQueryConvocadosGrid());
			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("ConvocadosModelClass.php");
			$Model = new ConvocadosModel();
			echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
		}


		protected function onclickSave(){

			require_once("ConvocadosModelClass.php");
			$Model = new ConvocadosModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente el convocado');
			}
		}

		protected function onclickUpdate(){

			require_once("ConvocadosModelClass.php");
			$Model = new ConvocadosModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente el convocado');
			}
		}


		protected function onclickDelete(){

			require_once("ConvocadosModelClass.php");
			$Model = new ConvocadosModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar el convocado');
			}else{
				exit('Se borro exitosamente el convocado');
			}
		}


		//BUSQUEDA
		protected function onclickFind(){
			require_once("ConvocadosModelClass.php");
			$Model = new ConvocadosModel();
			$Data                  = array();
			$convocado_id   		= $_REQUEST['convocado_id'];
			$numero_identificacion  = $_REQUEST['numero_identificacion'];
			if(is_numeric($convocado_id)){
				$Data  = $Model -> selectDatosConvocadosId($convocado_id,$this -> getConex());
			}else if(is_numeric($numero_identificacion)){
				$Data  = $Model -> selectDatosConvocadosId1($numero_identificacion,$this -> getConex());
			}
			echo json_encode($Data);
		}


		protected function SetCampos(){

			/********************
			Campos Tarifas Proveedor
			********************/

			$this -> Campos[convocado_id] = array(
				name	=>'convocado_id',
				id		=>'convocado_id',
				type	=>'hidden',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('primary_key'))
			);

			$this -> Campos[tipo_identificacion_id] = array(
				name	=>'tipo_identificacion_id',
				id		=>'tipo_identificacion_id',
				type	=>'select',
				Boostrap =>'si',
				options	=>null,
				required=>'yes',
				datatype=>array(
					type	=>'alphanum',
					length	=>'11'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);

			$this -> Campos[numero_identificacion] = array(
				name	=>'numero_identificacion',
				id		=>'numero_identificacion',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'45'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);

			$this -> Campos[primer_nombre] = array(
				name	=>'primer_nombre',
				id		=>'primer_nombre',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'45'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);

			$this -> Campos[segundo_nombre] = array(
				name	=>'segundo_nombre',
				id		=>'segundo_nombre',
				type	=>'text',
				Boostrap =>'si',
				datatype=>array(
					type	=>'text',
					length	=>'45'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);

			$this -> Campos[primer_apellido] = array(
				name	=>'primer_apellido',
				id		=>'primer_apellido',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'45'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);

			$this -> Campos[segundo_apellido] = array(
				name	=>'segundo_apellido',
				id		=>'segundo_apellido',
				type	=>'text',
				Boostrap =>'si',
				datatype=>array(
					type	=>'text',
					length	=>'45'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);

			$this -> Campos[direccion] = array(
				name	=>'direccion',
				id		=>'direccion',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'45'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);

			$this -> Campos[telefono] = array(
				name	=>'telefono',
				id		=>'telefono',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'45'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);

			$this -> Campos[movil] = array(
				name	=>'movil',
				id		=>'movil',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'45'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);
			
			$this -> Campos[ubicacion_id] = array(
			   	name =>'ubicacion_id',
			   	id =>'ubicacion_hidden',
			   	type =>'hidden',
			   	required=>'yes',
			   	datatype=>array(type=>'integer'),
			   	transaction=>array(
				table =>array('convocado'),
				type =>array('column'))
			  );
			
			$this -> Campos[ubicacion] = array(
			   	name =>'ubicacion',
			   	id =>'ubicacion',
				   type =>'text',
				   Boostrap =>'si',
				size    =>'15',
			   	suggest => array(
				name =>'ciudad',
				setId =>'ubicacion_hidden',
				onclick => 'setDataUbicacion')
			  );

			/*$this -> Campos[ubicacion_id] = array(
				name	=>'ubicacion_id',
				id		=>'ubicacion_id',
				type	=>'select',
				options	=>null,
				required=>'yes',
				datatype=>array(
					type	=>'alphanum',
					length	=>'11'),
				transaction=>array(
					table	=>array('convocado'),
					type	=>array('column'))
			);*/


			$this -> Campos[estado] = array(
				name	=>'estado',
				id		=>'estado',
				type	=>'select',
				Boostrap =>'si',
				options	=> array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO')),
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'2'),
				transaction=>array(
					table	=>array('convocado'),
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
					onsuccess=>'ConvocadosOnSaveOnUpdateonDelete')
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'ConvocadosOnReset(this.form)'
			);

			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				Boostrap =>'si',
				size	=>'85',
				// tabindex=>'1',
				suggest=>array(
					name	=>'convocado',
					setId	=>'convocado_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$convocado_id = new Convocados();
?>