<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class UVT extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){
			$this -> noCache();

			require_once("UVTLayoutClass.php");
			require_once("UVTModelClass.php");

			$Layout   = new UVTLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new UVTModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

			$Layout -> SetCampos($this -> Campos);

			//LISTA MENU
			$Layout -> SetPeriodo($Model -> GetPeriodo($this -> getConex()));
			$Layout -> SetImpuesto($Model -> GetImpuesto($this -> getConex()));


			//// GRID ////
			$Attributes = array(
				id		=>'uvt',
				title	=>'Listado de uvt',
				sortname=>'periodo_contable_id',
				width	=>'825',
				height	=>'250'
			);

			$Cols = array(
				array(name=>'id_uvt',				index=>'id_uvt',				sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'periodo_contable_id',	index=>'periodo_contable_id',	sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'uvt_nominal',			index=>'uvt_nominal',			sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'utv_minimo',			index=>'utv_minimo',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'impuesto_id',			index=>'impuesto_id',			sorttype=>'text',	width=>'150',	align=>'center'),
			);

			$Titles = array(
				'CODIGO',
				'PERIODO CONTABLE',
				'UVT NOMINAL',
				'UVT MINIMO',
				'IMPUESTO'
			);

			$Layout -> SetGridUVT($Attributes,$Titles,$Cols,$Model -> GetQueryUVTGrid());
			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("UVTModelClass.php");
			$Model = new UVTModel();
			echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
		}


		protected function onclickSave(){

			require_once("UVTModelClass.php");
			$Model = new UVTModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente el UVT');
			}
		}

		protected function onclickUpdate(){

			require_once("UVTModelClass.php");
			$Model = new UVTModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente el UVT');
			}
		}


		protected function onclickDelete(){

			require_once("UVTModelClass.php");
			$Model = new UVTModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar el UVT');
			}else{
				exit('Se borro exitosamente el UVT');
			}
		}


		//BUSQUEDA
		protected function onclickFind(){
			require_once("UVTModelClass.php");
			$Model = new UVTModel();
			$Data                  = array();
			$id_uvt   = $_REQUEST['id_uvt'];
			if(is_numeric($id_uvt)){
				$Data  = $Model -> selectDatosUVTId($id_uvt,$this -> getConex());
			}
			echo json_encode($Data);
		}


		protected function SetCampos(){

			/********************
			Campos Tarifas Proveedor
			********************/

			$this -> Campos[id_uvt] = array(
				name	=>'id_uvt',
				id		=>'id_uvt',
				type	=>'hidden',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('uvt'),
					type	=>array('primary_key'))
			);

			$this -> Campos[periodo_contable_id] = array(
				name	=>'periodo_contable_id',
				id		=>'periodo_contable_id',
				type	=>'select',
				options	=>null,
				required=>'yes',
				datatype=>array(
					type	=>'alphanum',
					length	=>'11'),
				transaction=>array(
					table	=>array('uvt'),
					type	=>array('column'))
			);

			$this -> Campos[uvt_nominal] = array(
				name	=>'uvt_nominal',
				id		=>'uvt_nominal',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'250'),
				transaction=>array(
					table	=>array('uvt'),
					type	=>array('column'))
			);

			$this -> Campos[utv_minimo] = array(
				name	=>'utv_minimo',
				id		=>'utv_minimo',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'250'),
				transaction=>array(
					table	=>array('uvt'),
					type	=>array('column'))
			);


			$this -> Campos[impuesto_id] = array(
				name	=>'impuesto_id',
				id		=>'impuesto_id',
				type	=>'select',
				options	=>null,
				required=>'yes',
				datatype=>array(
					type	=>'alphanum',
					length	=>'11'),
				transaction=>array(
					table	=>array('uvt'),
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
					onsuccess=>'UVTOnSaveOnUpdateonDelete')
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'UVTOnReset(this.form)'
			);

			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				// tabindex=>'1',
				suggest=>array(
					name	=>'uvt',
					setId	=>'id_uvt',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$id_uvt = new UVT();
?>