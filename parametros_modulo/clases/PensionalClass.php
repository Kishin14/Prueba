<?php
	require_once("../../../framework/clases/ControlerClass.php");
	final class Pensional extends Controler{
		public function __construct(){
			parent::__construct(3);
		}
		public function Main(){
			$this -> noCache();
			require_once("PensionalLayoutClass.php");
			require_once("PensionalModelClass.php");
			$Layout   = new PensionalLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new PensionalModel();
			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
			$Layout -> SetCampos($this -> Campos);
			//LISTA MENU
			$Layout -> SetPeriodo($Model -> GetPeriodo($this -> getConex()));

			
			$Layout -> RenderMain();
		}
		
		protected function showGrid(){
	  
			require_once("PensionalLayoutClass.php");
			require_once("PensionalModelClass.php");
			$Layout   = new PensionalLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new PensionalModel();
			  
			 //// GRID ////
			$Attributes = array(
				id		=>'fondo_pensional',
				title	=>'Listado de Pensional',
				sortname=>'porcentaje',
				width	=>'825',
				height	=>'250'
			);
			$Cols = array(
				array(name=>'fondo_pensional_id',		index=>'fondo_pensional_id',			sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'porcentaje',				index=>'porcentaje',					sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'rango_ini',				index=>'rango_ini',						sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'rango_fin',				index=>'rango_fin',						sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'periodo_contable_id',		index=>'periodo_contable_id',			sorttype=>'text',	width=>'150',	align=>'center'),
			);
			$Titles = array(
				'CODIGO',
				'PORCENTAJE',
				'RANGO INICIAL',
				'RANGO FINAL',
				'PERIODO CONTABLE'
			);
			
			$html = $Layout -> SetGridPensional($Attributes,$Titles,$Cols,$Model -> GetQueryPensionalGrid());
			 
			 print $html;
			  
		  }
		
		protected function onclickValidateRow(){
			require_once("PensionalModelClass.php");
			$Model = new PensionalModel();
			echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
		}

		protected function onclickSave(){
			require_once("PensionalModelClass.php");
			$Model = new PensionalModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente la Retención');
			}
		}
		protected function onclickUpdate(){
			require_once("PensionalModelClass.php");
			$Model = new PensionalModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente la Retención');
			}
		}

		protected function onclickDelete(){
			require_once("PensionalModelClass.php");
			$Model = new PensionalModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar el Retención');
			}else{
				exit('Se borro exitosamente el Retención');
			}
		}

		//BUSQUEDA
		protected function onclickFind(){
			require_once("PensionalModelClass.php");
			$Model = new PensionalModel();
			$Data                  = array();
			$fondo_pensional_id   = $_REQUEST['fondo_pensional_id'];
			if(is_numeric($fondo_pensional_id)){
				$Data  = $Model -> selectDatosPensionalId($fondo_pensional_id,$this -> getConex());
			}
			echo json_encode($Data);
		}

		protected function SetCampos(){
			/********************
			Campos Tarifas Proveedor
			********************/
			$this -> Campos[fondo_pensional_id] = array(
				name	=>'fondo_pensional_id',
				id		=>'fondo_pensional_id',
				type	=>'hidden',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('fondo_pensional'),
					type	=>array('primary_key'))
			);
			$this -> Campos[porcentaje] = array(
				name	=>'porcentaje',
				id		=>'porcentaje',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'10',
					presicion=>3),
				transaction=>array(
					table	=>array('fondo_pensional'),
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
					table	=>array('fondo_pensional'),
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
					table	=>array('fondo_pensional'),
					type	=>array('column'))
			);
			$this -> Campos[periodo_contable_id] = array(
				name	=>'periodo_contable_id',
				id		=>'periodo_contable_id',
				type	=>'select',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'alphanum',
					length	=>'11'),
				transaction=>array(
					table	=>array('fondo_pensional'),
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
					onsuccess=>'PensionalOnSaveOnUpdateonDelete')
			);
			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'PensionalOnReset()'
			);
			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				Boostrap =>'si',
				// tabindex=>'1',
				suggest=>array(
					name	=>'fondo_pensional',
					setId	=>'fondo_pensional_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$fondo_pensional_id = new Pensional();
?>