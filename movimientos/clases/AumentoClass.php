<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class Aumento extends Controler{

		public function __construct(){
			parent::__construct(2);	
		}

		public function Main(){

			$this -> noCache();

			require_once("AumentoLayoutClass.php");
			require_once("AumentoModelClass.php");

			$Layout	=	new	AumentoLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model	=	new	AumentoModel();

			$Model	->	SetUsuarioId($this	->	getUsuarioId(),$this	->	getOficinaId());

			$Layout -> setGuardar   	($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
			$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
			$Layout -> setImprimir		($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
			$Layout -> setLimpiar   	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

			$Layout -> setCampos($this -> Campos);

			//$Layout	-> setGrupoActivo		($Model	->	selectGrupoActivo		($this	->	getConex()));
			//$Layout	-> setTipoDepreciacion	($Model	->	selectTipoDepreciacion	($this	->	getConex()));
			
			$Layout -> RenderMain();
		}

		
		 protected function onclickFinalizar(){

		 	require_once("AumentoModelClass.php");
		 	$Model = new AumentoModel();

		 	$Model -> OnFinalizar($this->getUsuarioId(),$this -> getConex());
			
		 	if(strlen($Model -> GetError()) > 0){
				
			  exit('false');
			}else{
				exit('Contrato finalizado exitosamente!');
			}
		 }
		 
		  protected function onclickRenovar(){

		 	require_once("AumentoModelClass.php");
		 	$Model = new AumentoModel();
		 	$Model -> OnRenovar($this->getUsuarioId(),$this -> getConex());
			
		 	if(strlen($Model -> GetError()) > 0){
				
			  exit('false');
			}else{
				exit('Contrato renovado exitosamente!');
			}
		 }
		 
		  protected function onclickActualizar(){

		 	require_once("AumentoModelClass.php");
		 	$Model = new AumentoModel();

		 	$Model -> Actualizar($this->getUsuarioId(),$this -> getConex());
			
		 	if(strlen($Model -> GetError()) > 0){
				
			  exit('false');
			}else{
				exit('Contrato Actualizado exitosamente!');
			}
		 }
		
		protected function onclickPrint(){
			require_once("Imp_DocumentoClass.php");
			$print = new Imp_Documento($this -> getConex());
			$print -> printOut();
		 }



		protected function generateReporte(){

			require_once("AumentoModelClass.php");
			require_once("AumentoLayoutClass.php");
			$Model	= new AumentoModel();
			$Layout	= new AumentoLayout();

			$contrato_id = $_REQUEST['contrato_id'];
			$fecha_inicio = $_REQUEST['fecha_inicio'];
			$fecha_final = $_REQUEST['fecha_final'];

			$Layout -> setCssInclude("/application/framework/css/reset.css");
			$Layout -> setCssInclude("/application/framework/css/general.css");
			$Layout -> setCssInclude("/application/framework/css/bootstrap.css");
			$Layout -> setCssInclude("/application/framework/css/generalDetalle.css");
			$Layout	-> setJsInclude("/application/framework/js/jquery.js");
			$Layout	-> setJsInclude("/application/nomina/movimientos/js/DetallesAumento.js");
			$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
			$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());

			$data = $Model -> generateReporte($this -> getEmpresaId(),$fecha_inicio,$fecha_final,$contrato_id,$this -> getConex());

			$Layout -> setVar("DATA",$data);
			$Layout -> setVar("PRINTERS",$_REQUEST['printers']);
			
			if($_REQUEST['download']=='SI'){
				$ruta  = $this -> arrayToExcel("Depreciaciones","Depreciaciones Pendientes",$data,null);
				$this -> ForceDownload($ruta);	
			}else{
				$Layout	-> RenderLayout('DetallesAumento.tpl');
			}
		}
		
		 protected function setDataFinal(){

			require_once("AumentoModelClass.php");
			$Model = new AumentoModel();    
			//$solicitud_id = $_REQUEST['solicitud_id'];
			$fecha_inicio = $_REQUEST['fecha_inicio'];
			$data = $Model -> getDataFinal($fecha_inicio,$this -> getConex());
			print json_encode($data);

 		}
		
		protected function setDataActualiza(){

			require_once("AumentoModelClass.php");
			$Model = new AumentoModel();    
			$solicitud_id = $_REQUEST['solicitud_id'];
			$fecha_inicio = $_REQUEST['fecha_inicio_actualiza'];
			$data = $Model -> getDataActualiza($solicitud_id,$fecha_inicio,$this -> getConex());
			print json_encode($data);

 		}

		 
		 protected function getDataContrato(){
              
			 require_once("AumentoModelClass.php");
		 	 $Model = new AumentoModel();
			 $contrato_id = $_REQUEST['contrato_id'];
			 $data  = $Model -> selectDataContrato($contrato_id,$this -> getConex());
			
			 if(is_array($data)){
			  $this -> getArrayJSON($data);
			 }else{
				print 'false';
			  }    
		  
		  }
		  
		  protected function getDataActualizar(){
              
			 require_once("AumentoModelClass.php");
		 	 $Model = new AumentoModel();
			 $contrato_id = $_REQUEST['contrato_id'];
			 $data  = $Model -> selectDataActualizar($contrato_id,$this -> getConex());
			
			 if(is_array($data)){
			  $this -> getArrayJSON($data);
			 }else{
				print 'false';
			  }    
		  
		  }
		  
		   protected function getDataFinaliza(){
              
			 require_once("AumentoModelClass.php");
		 	 $Model = new AumentoModel();
			 $contrato_id = $_REQUEST['contrato_id'];
			 $data  = $Model -> selectDataFinaliza($contrato_id,$this -> getConex());
			
			 if(is_array($data)){
			  $this -> getArrayJSON($data);
			 }else{
				print 'false';
			  }    
		  
		  }

		//BUSQUEDA
		protected function onclickFind(){
			require_once("AumentoModelClass.php");
			$Model = new AumentoModel();

			$activo_id = $this -> requestDataForQuery("activo_id");
			$Data  = $Model -> selectDatos($activo_id,$this -> getConex());
			$this -> getArrayJSON($Data);
		}

		protected function setCampos(){

			//campos formulario
			
			
			$this -> Campos[solicitud_id] = array(
				name	=>'solicitud_id',
				id	    =>'solicitud_id',
				type	=>'hidden',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('primary_key'))
			);
			
			// INICIO CAMPOS DETALLE


			$this -> Campos[consecutivo] = array(
				name	=>'consecutivo',
				id		=>'consecutivo',
				type	=>'text',
				readonly=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[contrato] = array(
				name	=>'contrato',
				id		=>'contrato',
				type	=>'text',
				//tabindex=>'7',
				suggest=>array(
					name	=>'contrato_activo',
					setId	=>'contrato_hidden')
			);
			
			$this -> Campos[contrato_id] = array(
				name	=>'contrato_id',
				id		=>'contrato_hidden',
				type	=>'hidden',
				value	=>'',
				//required=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'20'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[cliente] = array(
				name	=>'cliente',
				id		=>'cliente',
				type	=>'text',
				readonly=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			

			$this -> Campos[canon] = array(
				name	=>'canon',
				id		=>'canon',
				type	=>'text',
				readonly=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			
			$this -> Campos[estado] = array(
				name   	 =>'estado',
				id     	 =>'estado',
				type   	 =>'select',
				disabled => 'yes',
				options  =>	array(array(value => 'A', text => 'APROBADO', selected => 'E'),array(value => 'D', text => 'DESISTIDO', selected => 'E'), 
							array(value => 'N', text => 'NO APROBADA' , selected => 'E'),array(value => 'F', text => 'FINALIZADO' , selected => 'E'),array(value=>'E',text=>'EN ESTUDIO',selected=>'E')),
				datatype=>	array(type=>'text'),
				transaction=>array(
						table=>array('solicitud'),
						type=>array('column'))
			);	

			
			$this -> Campos[fecha_inicio] = array(
				name	=>'fecha_inicio',
				id		=>'fecha_inicio',
				type	=>'text',
				//required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'10')
			);
			
			$this -> Campos[fecha_final] = array(
				name	=>'fecha_final',
				id		=>'fecha_final',
				type	=>'text',
				//required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'10')
			);
			
			// INICIO CAMPOS DIV FINALIZAR
			
			$this -> Campos[consecutivo2] = array(
				name	=>'consecutivo2',
				id		=>'consecutivo2',
				type	=>'text',
				disabled=>'yes',
				size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[fecha_solicitud] = array(
				name	=>'fecha_solicitud',
				id		=>'fecha_solicitud',
				type	=>'text',
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			$this -> Campos[cliente_finaliza] = array(
				name	=>'cliente_finaliza',
				id		=>'cliente_finaliza',
				type	=>'text',
				disabled=>'yes',
				size	=>'52',
				datatype=>array(
					type	=>'text',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[propietario_id] = array(
				name	=>'propietario_id',
				id		=>'propietario_id',
				type	=>'text',
				size	=>'52',
				disabled=>'yes',
			 	datatype=>array(
					type	=>'text',
					length	=>'20'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[arrendatario_id] = array(
				name	=>'arrendatario_id',
				id		=>'arrendatario_id',
				type	=>'text',
				size	=>'52',
				disabled=>'yes',
			 	datatype=>array(
					type	=>'text',
					length	=>'20'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[fecha_retiro] = array(
				name	=>'fecha_retiro',
				id		=>'fecha_retiro',
				type	=>'text',
				//value =>date(Y-m-d),
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			$this -> Campos[fecha_entrega] = array(
				name	=>'fecha_entrega',
				id		=>'fecha_entrega',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'10')
			);
			
			$this -> Campos[observacion_retiro] = array(
				name	=>'observacion_retiro',
				id		=>'observacion_retiro',
				type	=>'textarea',
			 	datatype=>array(
					type	=>'text',
					length	=>'10'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			// FIN CAMPOS FINALIZA
			
			// INICIO CAMPOS DIV RENOVACION
			
			$this -> Campos[consecutivo_renueva] = array(
				name	=>'consecutivo_renueva',
				id		=>'consecutivo_renueva',
				type	=>'text',
				disabled=>'yes',
				size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[fecha_solicitud_renueva] = array(
				name	=>'fecha_solicitud_renueva',
				id		=>'fecha_solicitud_renueva',
				type	=>'text',
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			$this -> Campos[fecha_inicio2] = array(
				name	=>'fecha_inicio2',
				id		=>'fecha_inicio2',
				type	=>'text',
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'7')
			);
			
			$this -> Campos[fecha_final2] = array(
				name	=>'fecha_final2',
				id		=>'fecha_final2',
				type	=>'text',
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			/* $this -> Campos[cliente_renueva] = array(
				name	=>'cliente_renueva',
				id		=>'cliente_renueva',
				type	=>'text',
				disabled=>'yes',
				size	=>'5',
				datatype=>array(
					type	=>'text',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			); */
			
			$this -> Campos[propietario_renueva] = array(
				name	=>'propietario_renueva',
				id		=>'propietario_renueva',
				type	=>'text',
				size	=>'52',
				disabled=>'yes',
			 	datatype=>array(
					type	=>'text',
					length	=>'7'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[arrendatario_renueva] = array(
				name	=>'arrendatario_renueva',
				id		=>'arrendatario_renueva',
				type	=>'text',
				size	=>'52',
				disabled=>'yes',
			 	datatype=>array(
					type	=>'text',
					length	=>'20'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[canon_renovacion] = array(
				name	=>'canon_renovacion',
				id		=>'canon_renovacion',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'12',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[canon_viejo] = array(
				name	=>'canon_viejo',
				id		=>'canon_viejo',
				type	=>'hidden',
				required=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[administracion] = array(
				name	=>'administracion',
				id		=>'administracion',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'12',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[fecha_inicio_renovacion] = array(
				name	=>'fecha_inicio_renovacion',
				id		=>'fecha_inicio_renovacion',
				type	=>'text',
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			$this -> Campos[fecha_renovacion] = array(
				name	=>'fecha_renovacion',
				id		=>'fecha_renovacion',
				type	=>'hidden',
				//required=>'yes',
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[fecha_final_renovacion] = array(
				name	=>'fecha_final_renovacion',
				id		=>'fecha_final_renovacion',
				type	=>'text',
				disabled=>'yes',
				//required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			$this -> Campos[observacion_renovacion] = array(
				name	=>'observacion_renovacion',
				id		=>'observacion_renovacion',
				type	=>'textarea',
			 	datatype=>array(
					type	=>'text',
					length	=>'10'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[numero_meses] = array(
				name	=>'numero_meses',
				id		=>'numero_meses',
				type	=>'text',
				disabled=>'yes',
				size	=>'30'
			); 
			
			// FIN CAMPOS RENOVACION
			
			// INICIO CAMPOS DIV ACTUALIZAR
			
			$this -> Campos[consecutivo_actualiza] = array(
				name	=>'consecutivo_actualiza',
				id		=>'consecutivo_actualiza',
				type	=>'text',
				disabled=>'yes',
				size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[fecha_solicitud_actualiza] = array(
				name	=>'fecha_solicitud_actualiza',
				id		=>'fecha_solicitud_actualiza',
				type	=>'text',
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			$this -> Campos[fecha_inicio_2_actualiza] = array(
				name	=>'fecha_inicio_2_actualiza',
				id		=>'fecha_inicio_2_actualiza',
				type	=>'text',
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			$this -> Campos[fecha_final_2_actualiza] = array(
				name	=>'fecha_final_2_actualiza',
				id		=>'fecha_final_2_actualiza',
				type	=>'text',
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			$this -> Campos[cliente_actualiza] = array(
				name	=>'cliente_actualiza',
				id		=>'cliente_actualiza',
				type	=>'text',
				disabled=>'yes',
				size	=>'52',
				datatype=>array(
					type	=>'text',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[propietario_actualiza] = array(
				name	=>'propietario_actualiza',
				id		=>'propietario_actualiza',
				type	=>'text',
				size	=>'52',
				disabled=>'yes',
			 	datatype=>array(
					type	=>'text',
					length	=>'20'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[arrendatario_actualiza] = array(
				name	=>'arrendatario_actualiza',
				id		=>'arrendatario_actualiza',
				type	=>'text',
				size	=>'52',
				disabled=>'yes',
			 	datatype=>array(
					type	=>'text',
					length	=>'20'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[canon_actualiza] = array(
				name	=>'canon_actualiza',
				id		=>'canon_actualiza',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[administracion_actualiza] = array(
				name	=>'administracion_actualiza',
				id		=>'administracion_actualiza',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[fecha_inicio_actualiza] = array(
				name	=>'fecha_inicio_actualiza',
				id		=>'fecha_inicio_actualiza',
				type	=>'text',
				disabled=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			$this -> Campos[fecha_final_actualiza] = array(
				name	=>'fecha_final_actualiza',
				id		=>'fecha_final_actualiza',
				type	=>'text',
				disabled=>'yes',
				//required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'10')
			);
			
			$this -> Campos[observacion_actualiza] = array(
				name	=>'observacion_actualiza',
				id		=>'observacion_actualiza',
				type	=>'textarea',
			 	datatype=>array(
					type	=>'text',
					length	=>'10'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[numero_meses_actualiza] = array(
				name	=>'numero_meses_actualiza',
				id		=>'numero_meses_actualiza',
				type	=>'text',
				disabled=>'yes',
				size	=>'10'
			); 
			
			$this -> Campos[canon_antiguo_actualiza] = array(
				name	=>'canon_antiguo_actualiza',
				id		=>'canon_antiguo_actualiza',
				type	=>'hidden',
				//required=>'yes',
				datatype=>array(
					type	=>'numeric',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			//FIN CAMPOS DIV ACTUALIZA
	
			//botones
			$this -> Campos[guardar] = array(
				name	=>'guardar',
				id		=>'guardar',
				type	=>'button',
				value	=>'Guardar',
				onclick =>'OnSave(this.form)'
			);

			$this -> Campos[generar] = array(
				name	=>'generar',
				id		=>'generar',
				type	=>'button',
				value	=>'Consultar Pendientes',
				onclick =>'generateReporte(this.form)'
			);

			$this -> Campos[generar_excel] = array(
				name	=>'generar_excel',
				id		=>'generar_excel',
				type	=>'button',
				value	=>'Pendientes Excel',
				onclick =>'generateReporteExcel(this.form)'
			);


			$this -> Campos[renovar] = array(
				name	=>'renovar',
				id		=>'renovar',
				type	=>'button',
				value	=>'Renovar',
				//disabled=>'disabled',
				onclick =>'onclickRenovar(this.form)'
			);
			
			$this -> Campos[actualizar] = array(
				name	=>'actualizar',
				id		=>'actualizar',
				type	=>'button',
				value	=>'Actualizar',
				//disabled=>'disabled',
				onclick =>'onclickActualizar(this.form)'
			);

			$this -> Campos[imprimir] = array(
			  name    =>'imprimir',
			  id      =>'imprimir',
			  type    =>'button',
			  value   =>'Imprimir',
			  onclick =>'beforePrint(this.form)'

			);	


			$this -> Campos[finalizar] = array(
				name	=>'finalizar',
				id		=>'finalizar',
				type	=>'button',
				value	=>'Finalizar',
				//disabled=>'disabled',
				onclick =>'onclickFinalizar(this.form)'
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				onclick =>'ResetForm(this.form)'
			);

			//busqueda
			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				suggest=>array(
					name	=>'activo',
					setId	=>'activo_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$Aumento = new Aumento();
?>