<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class Retencion extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){
			$this -> noCache();

			require_once("RetencionLayoutClass.php");
			require_once("RetencionModelClass.php");

			$Layout   = new RetencionLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new RetencionModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

			$Layout -> SetCampos($this -> Campos);

			//LISTA MENU
			$Layout -> SetPeriodo($Model -> GetPeriodo($this -> getConex()));


			//// GRID ////
			$Attributes = array(
				id		=>'retencion_salarial',
				title	=>'Listado de Retencion',
				sortname=>'porcentaje',
				width	=>'825',
				height	=>'250'
			);

			$Cols = array(
				array(name=>'retencion_salarial_id',			index=>'retencion_salarial_id',			sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'porcentaje',			index=>'porcentaje',			sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'rango_ini',	index=>'rango_ini',	sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'rango_fin',			index=>'rango_fin',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'periodo_contable_id',			index=>'periodo_contable_id',			sorttype=>'text',	width=>'150',	align=>'center'),
			);

			$Titles = array(
				'CODIGO',
				'PORCENTAJE',
				'RANGO INICIAL',
				'RANGO FINAL',
				'PERIODO CONTABLE'
			);

			$Layout -> SetGridRetencion($Attributes,$Titles,$Cols,$Model -> GetQueryRetencionGrid());
			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("RetencionModelClass.php");
			$Model = new RetencionModel();
			echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
		}


		protected function onclickSave(){

			require_once("RetencionModelClass.php");
			$Model = new RetencionModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente la Retención');
			}
		}

		protected function onclickUpdate(){

			require_once("RetencionModelClass.php");
			$Model = new RetencionModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente la Retención');
			}
		}


		protected function onclickDelete(){

			require_once("RetencionModelClass.php");
			$Model = new RetencionModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar el Retención');
			}else{
				exit('Se borro exitosamente el Retención');
			}
		}

		protected function calculauvt(){
			require_once("RetencionModelClass.php");
			$Model = new RetencionModel();
			//$Data                  = array();
			$periodo_contable_id   = $_REQUEST['periodo_contable_id'];
			if(is_numeric($periodo_contable_id)){
				$Data  = $Model -> calculauvt($periodo_contable_id,$this -> getConex());
			}
			echo json_encode($Data);
		}


		//BUSQUEDA
		protected function onclickFind(){
			require_once("RetencionModelClass.php");
			$Model = new RetencionModel();
			$Data                  = array();
			$retencion_salarial_id   = $_REQUEST['retencion_salarial_id'];
			if(is_numeric($retencion_salarial_id)){
				$Data  = $Model -> selectDatosRetencionId($retencion_salarial_id,$this -> getConex());
			}
			echo json_encode($Data);
		}


		protected function SetCampos(){

			/********************
			Campos Tarifas Proveedor
			********************/

			$this -> Campos[retencion_salarial_id] = array(
				name	=>'retencion_salarial_id',
				id		=>'retencion_salarial_id',
				type	=>'hidden',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('retencion_salarial'),
					type	=>array('primary_key'))
			);

			$this -> Campos[porcentaje] = array(
				name	=>'porcentaje',
				id		=>'porcentaje',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				size=>'5',
				datatype=>array(
					type	=>'numeric',
					length	=>'10',
					presicion=>3),
				transaction=>array(
					table	=>array('retencion_salarial'),
					type	=>array('column'))
			);

			$this -> Campos[rango_ini] = array(
				name	=>'rango_ini',
				id		=>'rango_ini',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'10',
					presicion=>3),
				transaction=>array(
					table	=>array('retencion_salarial'),
					type	=>array('column'))
			);

			$this -> Campos[rango_fin] = array(
				name	=>'rango_fin',
				id		=>'rango_fin',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'10',
					presicion=>3),
				transaction=>array(
					table	=>array('retencion_salarial'),
					type	=>array('column'))
			);

			$this -> Campos[rango_ini_pesos] = array(
				name	=>'rango_ini_pesos',
				id		=>'rango_ini_pesos',
				type	=>'text',
				Boostrap =>'si',
				disabled=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'10',
					presicion=>3),
				transaction=>array(
					table	=>array('retencion_salarial'),
					type	=>array('column'))
			);

			$this -> Campos[rango_fin_pesos] = array(
				name	=>'rango_fin_pesos',
				id		=>'rango_fin_pesos',
				type	=>'text',
				Boostrap =>'si',
				disabled=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'10',
					presicion=>3),
				transaction=>array(
					table	=>array('retencion_salarial'),
					type	=>array('column'))
			);

			$this -> Campos[periodo_contable_id] = array(
				name	=>'periodo_contable_id',
				id		=>'periodo_contable_id',
				type	=>'select',
				Boostrap =>'si',
				options	=>null,
				required=>'yes',
				datatype=>array(
					type	=>'alphanum',
					length	=>'11'),
				transaction=>array(
					table	=>array('retencion_salarial'),
					type	=>array('column'))
			);
			
			$this -> Campos[concepto] = array(
				name	=>'concepto',
				id		=>'concepto',
				type	=>'textarea',
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10',
					presicion=>3),
				transaction=>array(
					table	=>array('retencion_salarial'),
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
					onsuccess=>'RetencionOnSaveOnUpdateonDelete')
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'RetencionOnReset()'
			);

			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				Boostrap =>'si',
				placeholder =>'Por favor digite el porcentaje o periodo contable',
				// tabindex=>'1',
				suggest=>array(
					name	=>'retencion_salarial',
					setId	=>'retencion_salarial_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$retencion_salarial_id = new Retencion();
?>