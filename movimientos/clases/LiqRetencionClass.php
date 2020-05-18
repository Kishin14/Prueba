<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class LiqRetencion extends Controler{

		public function __construct(){
			parent::__construct(2);	
		}

		public function Main(){

			$this -> noCache();

			require_once("LiqRetencionLayoutClass.php");
			require_once("LiqRetencionModelClass.php");

			$Layout	=	new	LiqRetencionLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model	=	new	LiqRetencionModel();

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

		 	require_once("LiqRetencionModelClass.php");
		 	$Model = new LiqRetencionModel();

		 	$Model -> OnFinalizar($this->getUsuarioId(),$this -> getConex());
			
		 	if(strlen($Model -> GetError()) > 0){
				
			  exit('false');
			}else{
				exit('Contrato finalizado exitosamente!');
			}
		 }
		 
		  protected function onclickLiquidar(){

		 	require_once("LiqRetencionModelClass.php");
		 	$Model = new LiqRetencionModel();
		 	$Model -> Liquidar($this->getUsuarioId(),$this -> getConex());
			
		 	if(strlen($Model -> GetError()) > 0){
				
			  exit('false');
			}else{
				exit('Liquidacion generada exitosamente!');
			}
		 }
		 
		  protected function onclickContabilizar(){

		 	require_once("LiqRetencionModelClass.php");
		 	$Model = new LiqRetencionModel();

		 	$Model -> Contabilizar($this->getUsuarioId(),$this -> getConex());
			
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

			require_once("LiqRetencionModelClass.php");
			require_once("LiqRetencionLayoutClass.php");
			$Model	= new LiqRetencionModel();
			$Layout	= new LiqRetencionLayout();

			$contrato_id = $_REQUEST['contrato_id'];
			$si_contrato = $_REQUEST['si_contrato'];
			$fecha_inicio = $_REQUEST['fecha_inicio'];
			$fecha_final = $_REQUEST['fecha_final'];

			$Layout -> setCssInclude("../../../framework/css/reset.css");
			$Layout -> setCssInclude("../../../framework/css/general.css");
			$Layout -> setCssInclude("../../../framework/css/bootstrap.css");
			$Layout -> setCssInclude("../../../framework/css/generalDetalle.css");
			$Layout	-> setJsInclude("../../../framework/js/jquery.js");
			$Layout	-> setJsInclude("../js/LiqRetencion.js");
			$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
			$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());

			if ($si_contrato == '1') {
				$consulta_contrato = " AND s.contrato_id = $contrato_id ";
			}else {
				$consulta_contrato = "";
			}
			
			$data = $Model -> generateReporte($this -> getEmpresaId(),$fecha_inicio,$fecha_final,$consulta_contrato,$this -> getConex());

			$Layout -> setVar("DATA",$data);
			$Layout -> setVar("total",$data[0]['total']);
			$Layout -> setVar("PRINTERS",$_REQUEST['printers']);
			
			if($_REQUEST['download']=='SI'){
				$ruta  = $this -> arrayToExcel("Liquidacion Retencion","Liquidaciones Retenciones",$data,null);
				$this -> ForceDownload($ruta);	
			}else{
				$Layout	-> RenderLayout('DetallesLiqRetencion.tpl');
			}
		}
		
		 protected function setDataFinal(){

			require_once("LiqRetencionModelClass.php");
			$Model = new LiqRetencionModel();    
			//$solicitud_id = $_REQUEST['solicitud_id'];
			$fecha_inicio = $_REQUEST['fecha_inicio'];
			$data = $Model -> getDataFinal($fecha_inicio,$this -> getConex());
			print json_encode($data);

 		}
		
		protected function setDataActualiza(){

			require_once("LiqRetencionModelClass.php");
			$Model = new LiqRetencionModel();    
			$solicitud_id = $_REQUEST['solicitud_id'];
			$fecha_inicio = $_REQUEST['fecha_inicio_actualiza'];
			$data = $Model -> getDataActualiza($solicitud_id,$fecha_inicio,$this -> getConex());
			print json_encode($data);

 		}

		 
		 protected function getDataContrato(){
              
			 require_once("LiqRetencionModelClass.php");
		 	 $Model = new LiqRetencionModel();
			 $contrato_id = $_REQUEST['contrato_id'];
			 $fecha_inicio = $_REQUEST['fecha_inicio'];
			 $fecha_final = $_REQUEST['fecha_final'];
			 $data  = $Model -> selectDataContrato($contrato_id,$fecha_inicio,$fecha_final,$this -> getConex());
			
			 if(is_array($data)){
			  $this -> getArrayJSON($data);
			 }else{
				print 'false';
			  }    
		  
		  }
		  
		  protected function getDataActualizar(){
              
			 require_once("LiqRetencionModelClass.php");
		 	 $Model = new LiqRetencionModel();
			 $contrato_id = $_REQUEST['contrato_id'];
			 $data  = $Model -> selectDataActualizar($contrato_id,$this -> getConex());
			
			 if(is_array($data)){
			  $this -> getArrayJSON($data);
			 }else{
				print 'false';
			  }    
		  
		  }
		  
		   protected function getDataFinaliza(){
              
			 require_once("LiqRetencionModelClass.php");
		 	 $Model = new LiqRetencionModel();
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
			require_once("LiqRetencionModelClass.php");
			$Model = new LiqRetencionModel();

			$activo_id = $this -> requestDataForQuery("activo_id");
			$Data  = $Model -> selectDatos($activo_id,$this -> getConex());
			$this -> getArrayJSON($Data);
		}

		protected function setCampos(){

			//campos formulario
			
			// INICIO CAMPOS DETALLE

			$this -> Campos[si_contrato] = array(
				name	=>'si_contrato',
				id		=>'si_contrato',
				options	 =>array(array(value => 'ALL',text => 'TODOS',selected=>'0'),array(value => '1', text => 'UNO')),
				type	=>'select',
				Boostrap =>'si',
			);
			
			$this -> Campos[contrato] = array(
				name	=>'contrato',
				id		=>'contrato',
				type	=>'text',
				Boostrap =>'si',
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
			
			$this -> Campos[contrato_liq_id] = array(
				name	=>'contrato_liq_id',
				id		=>'contrato_liq_id',
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
						
			$this -> Campos[fecha_inicio] = array(
				name	=>'fecha_inicio',
				id		=>'fecha_inicio',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'10')
			);
			
			$this -> Campos[fecha_final] = array(
				name	=>'fecha_final',
				id		=>'fecha_final',
				type	=>'text',
				required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'10')
			);
			
			// INICIO CAMPOS LIQUIDAR RETENCION
			
			$this -> Campos[aportes_pension] = array(
				name	=>'aportes_pension',
				id		=>'aportes_pension',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			
			$this -> Campos[aportes_salud] = array(
				name	=>'aportes_salud',
				id		=>'aportes_salud',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[aportes_fondop] = array(
				name	=>'aportes_fondop',
				id		=>'aportes_fondop',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[pago_vivienda] = array(
				name	=>'pago_vivienda',
				id		=>'pago_vivienda',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[deduccion_dependiente] = array(
				name	=>'deduccion_dependiente',
				id		=>'deduccion_dependiente',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[salud_prepagada] = array(
				name	=>'salud_prepagada',
				id		=>'salud_prepagada',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[otras_rentas] = array(
				name	=>'otras_rentas',
				id		=>'otras_rentas',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);

			$this -> Campos[aportes_vol_empl] = array(
				name	=>'aportes_vol_empl',
				id		=>'aportes_vol_empl',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[aportes_afc] = array(
				name	=>'aportes_afc',
				id		=>'aportes_afc',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[st_icr] = array(
				name	=>'st_icr',
				id		=>'st_icr',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);

			$this -> Campos[st_d] = array(
				name	=>'st_d',
				id		=>'st_d',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);

			$this -> Campos[st_re] = array(
				name	=>'st_re',
				id		=>'st_re',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[total_suma] = array(
				name	=>'total_suma',
				id		=>'total_suma',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[sub1] = array(
				name	=>'sub1',
				id		=>'sub1',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[sub2] = array(
				name	=>'sub2',
				id		=>'sub2',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[sub3] = array(
				name	=>'sub3',
				id		=>'sub3',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[sub4] = array(
				name	=>'sub4',
				id		=>'sub4',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[rte] = array(
				name	=>'rte',
				id		=>'rte',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[cifra_control] = array(
				name	=>'cifra_control',
				id		=>'cifra_control',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[total_deduccion] = array(
				name	=>'total_deduccion',
				id		=>'total_deduccion',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[validau] = array(
				name	=>'validau',
				id		=>'validau',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[ingreso_mensual] = array(
				name	=>'ingreso_mensual',
				id		=>'ingreso_mensual',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);
			
			$this -> Campos[ingreso_gravado] = array(
				name	=>'ingreso_gravado',
				id		=>'ingreso_gravado',
				type	=>'text',
				Boostrap =>'si',
				// disabled=>'yes',
				// size	=>'6',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('solicitud'),
					type	=>array('column'))
			);

			$this -> Campos[uvt] = array(
				name	=>'uvt',
				id		=>'uvt',
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
			
			//FIN CAMPOS LIQUIDAR RETENCION 			
			// INICIO CAMPOS DIV LIQUIDAR MOSTRAR
			
			$this -> Campos[consecutivo_renueva] = array(
				name	=>'consecutivo_renueva',
				id		=>'consecutivo_renueva',
				type	=>'text',
				Boostrap =>'si',
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
					
			$this -> Campos[numero_meses] = array(
				name	=>'numero_meses',
				id		=>'numero_meses',
				type	=>'text',
				Boostrap =>'si',
				disabled=>'yes',
				size	=>'30'
			); 
			
			// FIN CAMPOS DIV LIQUIDAR MOSTRAR
	
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
				value	=>'Liquidar',
				//disabled=>'disabled',
				onclick =>'onclickLiquidar(this.form)'
			);
			
			$this -> Campos[actualizar] = array(
				name	=>'actualizar',
				id		=>'actualizar',
				type	=>'button',
				value	=>'Contabilizar',
				//disabled=>'disabled',
				onclick =>'onclickContabilizar(this.form)'
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
				Boostrap =>'si',
				suggest=>array(
					name	=>'activo',
					setId	=>'activo_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$LiqRetencion = new LiqRetencion();
?>