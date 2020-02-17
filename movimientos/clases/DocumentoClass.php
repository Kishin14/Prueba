<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class Documento extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){
			$this -> noCache();
			require_once("DocumentoLayoutClass.php");
			require_once("DocumentoModelClass.php");

			$Layout   = new DocumentoLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new DocumentoModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
			$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

			$Layout -> SetCampos($this -> Campos);

			//LISTA MENU
		/*	$Layout -> SetCosto($Model -> GetCosto($this -> getConex()));*/
			$Layout -> SetDoc($Model -> GetDoc($this -> getConex()));




			//// GRID ////
			$Attributes = array(
				id		=>'contrato',
				title	=>'Lista de Documentos',
				sortname=>'numero_contrato',
				width	=>'auto',
				height	=>'250'
			);

			$Cols = array(
				array(name=>'numero_contrato',			index=>'numero_contrato',			sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'documento_laboral_id',	    index=>'documento_laboral_id',		sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'fecha',	    			index=>'fecha',						sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'tipo_documento_laboral_id',index=>'tipo_documento_laboral_id',	sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'empleado_id',				index=>'empleado_id',				sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'tipo_contrato_id',			index=>'tipo_contrato_id',			sorttype=>'text',	width=>'150',	align=>'center')
				
			);

			$Titles = array(
				'NO. CONTRATO',
				'NO DOCUMENTO',
				'FECHA DOCUMENTO',
				'NOMBRE DOCUMENTO',
				'EMPLEADO',
				'TIPO CONTRATO'
				
			);

			$Layout -> SetGridContrato($Attributes,$Titles,$Cols,$Model -> GetQueryContratoGrid());
			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("DocumentoModelClass.php");
			$Model = new DocumentoModel();
			echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
		}


		protected function onclickSave(){

			require_once("DocumentoModelClass.php");
			$Model = new DocumentoModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente el contrato');
			}
		}
		
		protected function onclickPrint(){
	
			require_once("Imp_DocumentoClass.php");
			$print = new Imp_Documento($this -> getEmpresaId(),$this -> getConex());
			$print -> printOut();
	  
		}

		protected function onclickUpdate(){

			require_once("DocumentoModelClass.php");
			$Model = new DocumentoModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente el documento');
			}
		}


		protected function onclickDelete(){

			require_once("DocumentoModelClass.php");
			$Model = new DocumentoModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar el contrato');
			}else{
				exit('Se borro exitosamente el documento');
			}
		}


		//BUSQUEDA
		protected function onclickFind(){
			require_once("DocumentoModelClass.php");
			$Model = new DocumentoModel();
			$Data                  = array();
			$documento_laboral_id   		= $_REQUEST['documento_laboral_id']; 
			$Data  = $Model -> selectDatosDocumentoId($documento_laboral_id,$this -> getConex());
			echo json_encode($Data);
		}


		protected function SetCampos(){

			/********************
			Campos Tarifas Proveedor
			********************/

			 $this -> Campos[documento_laboral_id] = array(
			  name =>'documento_laboral_id',
			  id  =>'documento_laboral_id',
			  type =>'text',
			  Boostrap =>'si',
			  required=>'no',
			  readonly=>'readonly',
			  size =>'10',
			  datatype=>array(
			   type =>'integer',
			   length =>'11'),
			  transaction=>array(
			   table =>array('documento_laboral'),
			   type =>array('primary_key'))
			 );

			$this -> Campos[fecha] = array(
				name	=>'fecha',
				id		=>'fecha',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'45'),
				transaction=>array(
					table	=>array('documento_laboral'),
					type	=>array('column'))
			);
			
			
			$this -> Campos[tipo_documento_laboral_id] = array(
			   	name =>'tipo_documento_laboral_id',
			   	id =>'tipo_documento_laboral_id',
				type	=>'select',
				Boostrap =>'si',
				required=>'yes',
			   	datatype=>array(type=>'integer'),
			   	transaction=>array(
				table =>array('documento_laboral'),
				type =>array('column'))
			  );
			
			$this -> Campos[contrato_id] = array(
				name =>'contrato_id',
				id =>'contrato_id',
				type =>'hidden',
				required=>'yes',
				datatype=>array(
				type=>'integer'),
				transaction=>array(
				table =>array('documento_laboral'),
				type =>array('column'))
			);
				
			$this -> Campos[contrato] = array(
				name =>'contrato',
				id =>'contrato',
				type =>'text',
				Boostrap =>'si',
				size    =>'30',
				suggest => array(
				name =>'contrato',
				setId =>'contrato_id')
				//onclick => 'setDataContrato')
			);
			


			/**********************************
			Botones
			**********************************/

			$this -> Campos[guardar] = array(
				name	=>'guardar',
				id		=>'guardar',
				type	=>'button',
				value	=>'Guardar'
				// tabindex=>'19'
			);

			$this -> Campos[actualizar] = array(
				name	=>'actualizar',
				id		=>'actualizar',
				type	=>'button',
				value	=>'Actualizar',
				disabled=>'disabled'
				// tabindex=>'20'
			);
			
			$this -> Campos[imprimir] = array(
			name	   =>'imprimir',
			id	   =>'imprimir',
			type	   =>'print',
			value	   =>'Imprimir',
				displayoptions => array(
					  beforeprint => 'beforePrint',
					  form        => 0,
			  title       => 'Impresion Contrato',
			  width       => '700',
			  height      => '600'
			)
	
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
					onsuccess=>'DocumentoOnSaveOnUpdateonDelete')
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'DocumentoOnReset(this.form)'
			);

			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				Boostrap =>'si',
				size	=>'85',
				placeholder =>'Por favor digite el nombre del documento o el numero de contrato',
				// tabindex=>'1',
				suggest=>array(
					name	=>'contratoDP',
					setId	=>'documento_laboral_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$documento_laboral_id  = new Documento();
?>