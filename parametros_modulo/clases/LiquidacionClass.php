<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class Liquidacion extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){
			$this -> noCache();

			require_once("LiquidacionLayoutClass.php");
			require_once("LiquidacionModelClass.php");

			$Layout   = new LiquidacionLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new LiquidacionModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

			$Layout -> SetCampos($this -> Campos);

			//LISTA MENU
			//$Layout -> SetPuc($Model -> GetPuc($this -> getConex()));
			$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));


			//// GRID ////

			$Attributes = array(
				id		=>'parametro_liquidacion',
				title	=>'Listado de liquidaciones',
				sortname=>'parametro_liquidacion_id',
				width	=>'825',
				height	=>'250'
			);

			$Cols = array(
				array(name=>'parametro_liquidacion_id',			index=>'parametro_liquidacion_id',			sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'nombre_concepto',			index=>'nombre_concepto',			sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'tipo',	index=>'tipo',	sorttype=>'text',	width=>'150',	align=>'left'),
			);

			$Titles = array(
				'CODIGO',
				'PUC',
				'TIPO CONCEPTO',
			);

			$Layout -> SetGridLiquidacion($Attributes,$Titles,$Cols,$Model -> GetQueryLiquidacionGrid());
			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("LiquidacionModelClass.php");
			$Model = new LiquidacionModel();
			echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
		}


		protected function onclickSave(){

			require_once("LiquidacionModelClass.php");
			$Model = new LiquidacionModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente la Liquidación');
			}
		}

		protected function onclickUpdate(){

			require_once("LiquidacionModelClass.php");
			$Model = new LiquidacionModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente la Liquidación');
			}
		}


		protected function onclickDelete(){

			require_once("LiquidacionModelClass.php");
			$Model = new LiquidacionModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar la Liquidacion');
			}else{
				exit('Se borro exitosamente la Liquidacion');
			}
		}

		//BUSQUEDA
		protected function onclickFind(){
			require_once("LiquidacionModelClass.php");
			$Model = new LiquidacionModel();
			$Data                  = array();
			$id_liquidacion  = $_REQUEST['parametro_liquidacion_id'];

			if(is_numeric($id_liquidacion)){
				$Data  = $Model -> selectDatosLiquidacionId($id_liquidacion,$this -> getConex());
			}
			echo json_encode($Data);
		}

		protected function SetCampos(){

			/********************
			Campos Tarifas Proveedor
			********************/

			$this -> Campos[parametro_liquidacion_id] = array(
				name	=>'parametro_liquidacion_id',
				id		=>'parametro_liquidacion_id',
				type	=>'hidden',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('parametro_liquidacion'),
					type	=>array('primary_key'))
			);

			/*$this -> Campos[contrapartida_puc_id] = array(
				name	=>'contrapartida_puc_id',
				id		=>'contrapartida_puc_id',
				type	=>'select',
				options	=>null,
				required=>'yes',
				datatype=>array(
					type	=>'alphanum',
					length	=>'11'),
				transaction=>array(
					table	=>array('parametro_liquidacion'),
					type	=>array('column'))
			);*/

  	
				$this -> Campos[contrapartida] = array(
					name	=>'contrapartida',
					id		=>'contrapartida',
					type	=>'text',
					datatype=>array(type=>'text'),
					suggest=>array(
						name	=>'cuentas_movimiento',
						setId	=>'contrapartida_puc_id_hidden')
				);	  
		
				$this -> Campos[contrapartida_puc_id] = array(
					name	=>'contrapartida_puc_id',
					id	    =>'contrapartida_puc_id_hidden',
					type	=>'hidden',
					required=>'yes',
					datatype=>array(type=>'text'),
					transaction=>array(
						table	=>array('parametro_liquidacion'),
						type	=>array('column'))
				);	
		
				$this -> Campos[tipo_concepto_laboral_id] = array(
				name	=>'tipo_concepto_laboral_id',
				id		=>'tipo_concepto_laboral_id',
				type	=>'select',
				options	=>null,
				required=>'yes',
				datatype=>array(
					type	=>'alphanum',
					length	=>'11'),
				transaction=>array(
					table	=>array('parametro_liquidacion'),
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
					onsuccess=>'LiquidacionOnSaveOnUpdateonDelete')
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'LiquidacionOnReset()'
			);

		   	$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				suggest=>array(
					name	=>'parametro_liquidacion_id',
					setId	=>'parametro_liquidacion_id',
					onclick	=>'setDataFormWithResponse')
			);

			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$id_liquidacion = new Liquidacion();
?>