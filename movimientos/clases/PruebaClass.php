<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class Prueba extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){
			$this -> noCache();
			require_once("PruebaLayoutClass.php");
			require_once("PruebaModelClass.php");

			$Layout   = new PruebaLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new PruebaModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

			$Layout -> SetCampos($this -> Campos);

			//LISTA MENU
			/*$Layout -> SetTip($Model -> GetTip($this -> getConex()));
			$Layout -> SetUbi($Model -> GetUbi($this -> getConex()));*/


			//// GRID ////
			$Attributes = array(
				id		=>'prueba',
				title	=>'Listado de Pruebas',
				sortname=>'prueba_id',
				width	=>'auto',
				height	=>'250'
			);

			$Cols = array(
				array(name=>'prueba_id',			index=>'prueba_id',			sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'nombre',				index=>'nombre',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'observacion',			index=>'observacion',		sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'resultado',			index=>'resultado',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'aprobado',			    index=>'aprobado',			sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'base',					index=>'base',				sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'convocado_id',		    index=>'convocado_id',	    sorttype=>'text',	width=>'300',	align=>'center'),
				array(name=>'fecha',				index=>'fecha',				sorttype=>'text',	width=>'150',	align=>'center')
			);

			$Titles = array(
				'CONVOCADO',
				'NOMBRE',
				'OBSERVACION',
				'RESULTADO',
				'APROBADO',
				'BASE',
				'NOMBRE CONVOCADO',
				'FECHA'
			);

			$Layout -> SetGridPrueba($Attributes,$Titles,$Cols,$Model -> GetQueryPruebaGrid());
			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("PruebaModelClass.php");
			$Model = new PruebaModel();
			echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
		}


		protected function onclickSave(){

			require_once("PruebaModelClass.php");
			$Model = new PruebaModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente el convocado');
			}
		}

		protected function onclickUpdate(){

			require_once("PruebaModelClass.php");
			$Model = new PruebaModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente el convocado');
			}
		}


		protected function onclickDelete(){

			require_once("PruebaModelClass.php");
			$Model = new PruebaModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar el convocado');
			}else{
				exit('Se borro exitosamente el convocado');
			}
		}


		//BUSQUEDA
		protected function onclickFind(){
			require_once("PruebaModelClass.php");
			$Model = new PruebaModel();
			$Data  = array();
			$prueba_id   = $_REQUEST['prueba_id'];
			if(is_numeric($prueba_id)){
				$Data  = $Model -> selectDatosPruebaId($prueba_id,$this -> getConex());
			}
			echo json_encode($Data);
		}


		protected function SetCampos(){

			/********************
			Campos Tarifas Proveedor
			********************/

			$this -> Campos[prueba_id] = array(
				name	=>'prueba_id',
				id		=>'prueba_id',
				type	=>'hidden',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('prueba'),
					type	=>array('primary_key'))
			);


			$this -> Campos[nombre] = array(
				name	=>'nombre',
				id		=>'nombre',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'60'),
				transaction=>array(
					table	=>array('prueba'),
					type	=>array('column'))
			);

			$this -> Campos[observacion] = array(
				name	=>'observacion',
				id		=>'observacion',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'45'),
				transaction=>array(
					table	=>array('prueba'),
					type	=>array('column'))
			);

			$this -> Campos[resultado] = array(
				name	=>'resultado',
				id		=>'resultado',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'45'),
				transaction=>array(
					table	=>array('prueba'),
					type	=>array('column'))
			);

			$this -> Campos[base] = array(
				name	=>'base',
				id		=>'base',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'45'),
				transaction=>array(
					table	=>array('prueba'),
					type	=>array('column'))
			);

	

			  $this -> Campos[convocado_id] = array(
			   name =>'convocado_id',
			   id =>'convocado_hidden',
				 type =>'hidden',
				   required=>'yes',
				   datatype=>array(type=>'integer'),
				   transaction=>array(
				table =>array('prueba'),
				type =>array('column'))
				  );

			   $this -> Campos[convocado] = array(
			   name =>'convocado',
			   id =>'convocado',
				   type =>'text',
				   Boostrap =>'si',
					 size    =>'30',
				   suggest => array(
					name =>'convocado',
					setId =>'convocado_hidden',
					onclick => 'setDataConvocado')
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
					table	=>array('prueba'),
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
				table	=>array('prueba'),
				type	=>array('column')),
			namefile=>array(
				field	=>'yes',
				namefield=>'convocado_id',
				text	=>'_prueba'.date('Y-m-d h:m:s'))
		);

			$this -> Campos[aprobado] = array(
				name	=>'aprobado',
				id		=>'aprobado',
				type	=>'select',
				Boostrap =>'si',
				options	=> array(array(value=>1,text=>'SI'),array(value=>0,text=>'NO')),
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'2'),
				transaction=>array(
					table	=>array('prueba'),
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
					onsuccess=>'PruebaOnSaveOnUpdateonDelete')
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22', 
				onclick	=>'PruebaOnReset(this.form)'
			);

			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				Boostrap =>'si',
				// tabindex=>'1',
				suggest=>array(
					name	=>'prueba',
					setId	=>'prueba_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$prueba_id = new Prueba();
?>