<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class Desempeno extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){
			$this -> noCache();
			require_once("DesempenoLayoutClass.php");
			require_once("DesempenoModelClass.php");

			$Layout   = new DesempenoLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new DesempenoModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

			$Layout -> SetCampos($this -> Campos);

			//LISTA MENU
			/*$Layout -> SetTip($Model -> GetTip($this -> getConex()));*/
			$Layout -> SetCausal($Model -> GetCausal($this -> getConex()));


			//// GRID ////
			$Attributes = array(
				id		=>'desempeno',
				title	=>'Listado calificacion desempeño',
				sortname=>'causal_desempeno_empleado_id',
				width	=>'auto',
				height	=>'250'
			);

			$Cols = array(
				array(name=>'causal_desempeno_empleado_id',	index=>'causal_desempeno_empleado_id',	sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'empleado_id',					index=>'empleado_id',					sorttype=>'text',	width=>'200',	align=>'center'),
				array(name=>'causal_desempeno_id',			index=>'causal_desempeno_id',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'resultado',					index=>'resultado',						sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'fecha',						index=>'fecha',							sorttype=>'text',	width=>'150',	align=>'center')
				
			);

			$Titles = array(
				'NO.',
				'EMPLEADO',
				'CAUSAL DESEMPEÑO',
				'RESULTADO',
				'FECHA'
		
			);

			$Layout -> SetGridDesempeno($Attributes,$Titles,$Cols,$Model -> GetQueryDesempenoGrid());
			$Layout -> RenderMain();
		}

	  protected function onclickValidateRow(){
	
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($this -> getConex(),"causal_desempeno_empleado",$this ->Campos);
		$this -> getArrayJSON($Data  -> GetData());
	  }


		protected function onclickSave(){

			require_once("DesempenoModelClass.php");
			$Model = new DesempenoModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente el convocado');
			}
		}

		protected function onclickUpdate(){

			require_once("DesempenoModelClass.php");
			$Model = new DesempenoModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente el convocado');
			}
		}


		protected function onclickDelete(){

			require_once("DesempenoModelClass.php");
			$Model = new DesempenoModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar el convocado');
			}else{
				exit('Se borro exitosamente el convocado');
			}
		}


		//BUSQUEDA
		protected function onclickFind(){
			require_once("DesempenoModelClass.php");
			$Model = new DesempenoModel();
			$Data                  = array();
			$causal_desempeno_empleado_id   = $_REQUEST['causal_desempeno_empleado_id'];
			if(is_numeric($causal_desempeno_empleado_id)){
				$Data  = $Model -> selectDatosDesempenoId($causal_desempeno_empleado_id,$this -> getConex());
			}
			echo json_encode($Data);
		}


		protected function SetCampos(){

			/********************
			Campos Tarifas Proveedor
			********************/

			$this -> Campos[causal_desempeno_empleado_id] = array(
				name	=>'causal_desempeno_empleado_id',
				id		=>'causal_desempeno_empleado_id',
				type	=>'hidden',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('causal_desempeno_empleado'),
					type	=>array('primary_key'))
			);

	

			$this -> Campos[empleado_id] = array(
				name	=>'empleado_id',
				id		=>'empleado_hidden',
				type	=>'hidden',
					required=>'yes',
					datatype=>array(
					type=>'integer'),
					transaction=>array(
				table	=>array('causal_desempeno_empleado'),
				type	=>array('column'))
			);
			
				  $this -> Campos[empleado] = array(
			   name =>'empleado',
			   id =>'empleado',
				 type =>'text',
				  size    =>'30',
				    suggest => array(
				  name =>'empleado',
				   setId =>'empleado_hidden',
				onclick => 'setDataEmpleado')
			);


			$this -> Campos[causal_desempeno_id] = array(
				name	=>'causal_desempeno_id',
				id		=>'causal_desempeno_id',
				type	=>'select',
				options =>array(),
				required=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'45'),
				transaction=>array(
					table	=>array('causal_desempeno_empleado'),
					type	=>array('column'))
			);

	
			
			$this -> Campos[resultado] = array(
				name =>'resultado',
				id  =>'resultado',
				type =>'select',
				options => array(array(value=>'A',text=>'APROBADO',selected=>'A'),array(value=>'N',text=>'NO APROBADO')),
				required=>'yes',
				datatype=>array(
				 type =>'text',
				 length =>'2'),
				transaction=>array(
				 table =>array('causal_desempeno_empleado'),
				 type =>array('column'))
			   );


			$this -> Campos[fecha] = array(
				name	=>'fecha',
				id		=>'fecha',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'11'),
				transaction=>array(
					table	=>array('causal_desempeno_empleado'),
					type	=>array('column'))
			);

			$this -> Campos[prueba] = array(
			name	=>'prueba',
			id		=>'prueba',
			type	=>'file',
			value	=>'',
			path	=>'/application/imagenes/nomina/prueba/',
			size	=>'70',	
			required=>'yes',	
			datatype=>array(
				type	=>'file'),
			transaction=>array(
				table	=>array('causal_desempeno_empleado'),
				type	=>array('column')),
			namefile=>array(
				field	=>'yes',
				namefield=>'evidencia',
				text	=>'_prueba'.date('Y-m-d h:m:s'))
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
					onsuccess=>'DesempenoOnSaveOnUpdateonDelete')
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'DesempenoOnReset(this.form)'
			);

			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				// tabindex=>'1',
				suggest=>array(
					name	=>'desempeno',
					setId	=>'causal_desempeno_empleado_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$causal_desempeno_empleado_id = new Desempeno();
?>