<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class Extras extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){
			$this -> noCache();

			require_once("ExtrasLayoutClass.php");
			require_once("ExtrasModelClass.php");

			$Layout   = new ExtrasLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new ExtrasModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetAnular    ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));
			$Layout -> SetImprimir  ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

			$Layout -> SetCampos($this -> Campos);

			$Layout	->	setCausalesAnulacion	($Model -> getCausalesAnulacion	($this -> getConex()));
			 $hora_extra_id = $_REQUEST['hora_extra_id'];

			if($hora_extra_id>0){

				$Layout -> setHoraExtraFrame($hora_extra_id);

			}


			//// GRID ////
			$Attributes = array(
				id		=>'Extras',
				title	=>'Listado de Horas Extras',
				sortname=>'hora_extra_id',
				sortorder=>'desc',
				width	=>'auto',
				height	=>'250'
			);

			$Cols = array(
				array(name=>'hora_extra_id',			index=>'hora_extra_id',				sorttype=>'text',	width=>'50',	align=>'center'),
				array(name=>'contrato',					index=>'contrato',					sorttype=>'text',	width=>'300',	align=>'left'),
				array(name=>'fecha_inicial',			index=>'fecha_inicial',				sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'fecha_final',				index=>'fecha_final',				sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'horas_diurnas',			index=>'horas_diurnas',				sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'vr_horas_diurnas',			index=>'vr_horas_diurnas',			sorttype=>'text',	width=>'100',	align=>'center',	format=>'currency'),				
				array(name=>'horas_nocturnas',			index=>'horas_nocturnas',			sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'vr_horas_nocturnas',		index=>'vr_horas_nocturnas',		sorttype=>'text',	width=>'100',	align=>'center',	format=>'currency'),								
				array(name=>'horas_diurnas_fes',		index=>'horas_diurnas_fes',			sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'vr_horas_diurnas_fes',		index=>'vr_horas_diurnas_fes',		sorttype=>'text',	width=>'100',	align=>'center',	format=>'currency'),												
				array(name=>'horas_nocturnas_fes',		index=>'horas_nocturnas_fes',		sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'vr_horas_nocturnas_fes',	index=>'vr_horas_nocturnas_fes',	sorttype=>'text',	width=>'100',	align=>'center',	format=>'currency'),												
				array(name=>'horas_recargo_noc',		index=>'horas_recargo_noc',			sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'vr_horas_recargo_noc',		index=>'vr_horas_recargo_noc',		sorttype=>'text',	width=>'100',	align=>'center',	format=>'currency'),												
				array(name=>'estado',					index=>'estado',					sorttype=>'text',	width=>'100',	align=>'center')				

			);

			$Titles = array(
				'NO.',
				'CONTRATO',
				'FECHA INICIAL',
				'FECHA FINAL',
				'HRS DIURNAS',
				'VR HRS DIURNAS',				
				'HRS NOCTURNAS',
				'VR HRS NOCTURNAS',				
				'HRS DIURNAS FESTIVAS',
				'VR HRS DIURNAS FESTIVAS',				
				'HRS NOCTURNAS FESTIVAS',
				'VR HRS NOCTURNAS FESTIVAS',				
				'HRS RECARGO NOCTURNO',
				'VR HRS RECARGO NOCTURNO',				
				'ESTADO',				
			);

			$Layout -> SetGridExtras($Attributes,$Titles,$Cols,$Model -> GetQueryExtrasGrid());
			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("ExtrasModelClass.php");
			$Model = new ExtrasModel();
			echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
		}


		protected function onclickSave(){

			require_once("ExtrasModelClass.php");
			$Model = new ExtrasModel();
			   
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente el Extras');
			}
		}
		
		protected function onclickSaveExcel(){

			require_once("ExtrasModelClass.php");
			$Model = new ExtrasModel();
			
			$fecha_inicial = $_REQUEST['fecha_inicial'];
			$fecha_final = $_REQUEST['fecha_final'];

			if ($fecha_inicial !='' || ($fecha_inicial!='' && $fecha_final!='')) {

				$this -> upload_max_filesize("2048M");
				$archivoPOST     = $_FILES['archivo'];
				$rutaAlmacenar   = "../../../archivos/nomina/horas_extras/";
				$dir_file        = $this -> moveUploadedFile($archivoPOST,$rutaAlmacenar,"archivohoraextra");   
				$camposArchivo   = $this -> excelToArray($dir_file,'ALL');	
				   
				$Model -> SaveExcel($fecha_inicial,$fecha_final,$camposArchivo,$this -> getConex());
				if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
				}else{
				exit('Se ingresaron correctamente las Horas Extras');
				}
			}else{
				Exit('Por favor seleccione la fecha inicial y fecha final.');
			}

		}
		
	protected function setDataContrato(){
		require_once("ExtrasModelClass.php");
		$Model = new ExtrasModel();    
		$contrato_id = $_REQUEST['contrato_id'];
		$data = $Model -> getDataContrato($contrato_id,$this -> getConex());
		$this -> getArrayJSON($data);
	}

	protected function setExtras(){
		require_once("ExtrasModelClass.php");
		$Model = new ExtrasModel();
		
		$sueldo_base = $_REQUEST['sueldo_base'];
		$horas_diurnas = $_REQUEST['horas_diurnas'];
		$horas_nocturnas = $_REQUEST['horas_nocturnas'];
		$horas_diurnas_fes = $_REQUEST['horas_diurnas_fes'];
		$horas_nocturnas_fes = $_REQUEST['horas_nocturnas_fes'];
		$horas_recargo_noc = $_REQUEST['horas_recargo_noc'];		
		$horas_recargo_doc = $_REQUEST['horas_recargo_doc'];		
		
		$vr_horas_extra_diurna = $_REQUEST['vr_horas_extra_diurna'];		
		$vr_horas_extra_nocturna = $_REQUEST['vr_horas_extra_nocturna'];		
		$vr_horas_diurna_fest = $_REQUEST['vr_horas_diurna_fest'];		
		$vr_horas_recargo_festivo = $_REQUEST['vr_horas_recargo_festivo'];		
		$vr_horas_nocturno = $_REQUEST['vr_horas_nocturno'];		
		$vr_horas_festivo = $_REQUEST['vr_horas_festivo'];		
		
		$fecha_inicial = $_REQUEST['fecha_inicial'];
		
		$data = $Model -> getExtras($fecha_inicial,$this -> getConex());
		$valor = 0;

		
		if($horas_diurnas>0){

			
			$valor = (str_replace(' ','',$vr_horas_extra_diurna)*$horas_diurnas);
			
		}elseif($horas_nocturnas>0){

			$valor = str_replace(' ','',$vr_horas_extra_nocturna)*$horas_nocturnas;
	
		}elseif($horas_diurnas_fes>0){

			$valor =  str_replace(' ','',$vr_horas_diurna_fest)*$horas_diurnas_fes;
			
		
		}elseif($horas_nocturnas_fes>0){

			$valor =  str_replace(' ','',$vr_horas_recargo_festivo)*$horas_nocturnas_fes;
			
	
		}elseif($horas_recargo_noc>0){

			$valor =  str_replace(' ','',$vr_horas_nocturno)*$horas_recargo_noc;
			

		}elseif($horas_recargo_doc>0){

			$valor =  str_replace(' ','',$vr_horas_festivo)*$horas_recargo_doc;
			
		}
		$residuo= ($valor-intval($valor));
		if($residuo>0) $valor = intval($valor+1);
		exit("$valor");
	}


	protected function setExtrasAuto(){
		require_once("ExtrasModelClass.php");
		$Model = new ExtrasModel();
		
		$sueldo_base = $_REQUEST['sueldo_base'];
	
		
		
		$fecha_inicial = $_REQUEST['fecha_inicial'];
		
		$data = $Model -> getExtrasAuto($fecha_inicial,$this -> getConex());
		$valor_festivo = 0;
		$valor_recargo_noct = 0;
		$valor_noct_fest = 0;
		$valor_diur_fest = 0;
		$valor_nocturnas = 0;
		$valor_diurnas = 0;
		
		$horas_dia=$data[0]['horas_dia'];

		$val_recargo_dominical=$data[0]['val_recargo_dominical'];
		$val_recargo_nocturna=$data[0]['val_recargo_nocturna'];
		$val_hr_ext_festiva_nocturna=$data[0]['val_hr_ext_festiva_nocturna'];
		$val_hr_ext_festiva_diurna=$data[0]['val_hr_ext_festiva_diurna'];
		$val_hr_ext_nocturna=$data[0]['val_hr_ext_nocturna'];
		$val_hr_ext_diurna=$data[0]['val_hr_ext_diurna'];
		
		$dias_lab_mes=$data[0]['dias_lab_mes'];
		
		$val_hr_corriente=$data[0]['val_hr_corriente'];

		$salario = ($sueldo_base/240);


		
		if($fecha_inicial!=''){

			$valor_festivo = number_format((($salario*$val_recargo_dominical)/100)+$salario, 0, ',', ' ');
			$valor_recargo_noct = number_format((($salario*$val_recargo_nocturna)/100)+$salario, 0, ',', ' ');
			$valor_noct_fest = number_format((($salario*$val_hr_ext_festiva_nocturna)/100)+$salario, 0, ',', ' ');
			$valor_diur_fest = number_format((($salario*$val_hr_ext_festiva_diurna)/100)+$salario, 0, ',', ' ');
			$valor_nocturnas = number_format((($salario*$val_hr_ext_nocturna)/100)+$salario, 0, ',', ' ');
			$valor_diurnas = number_format((($salario*$val_hr_ext_diurna)/100)+$salario, 0, ',', ' ');

			
		}else{
			exit('Debe digitar la fecha antes de seleccionar un contrato.');
		}
	
		$arrayResponse = array();
	   	$arrayResponse = array(valor_festivo => $valor_festivo, valor_diurnas => $valor_diurnas, valor_nocturnas => $valor_nocturnas, valor_diur_fest => $valor_diur_fest, valor_noct_fest => $valor_noct_fest, valor_recargo_noct => $valor_recargo_noct);

		$this -> getArrayJSON($arrayResponse);
	}
		
		protected function onclickPrint(){

		require_once("Imp_ExtrasClass.php");
		$print = new Imp_Extras($this -> getEmpresaId(),$this -> getConex());
		$print -> printOut();
	  
	}

		protected function onclickUpdate(){

			require_once("ExtrasModelClass.php");
			$Model = new ExtrasModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente las Horas Extras');
			}
		}

		protected function setProcesar(){

			require_once("ExtrasModelClass.php");
			$Model = new ExtrasModel();

			$contrato_id = $_REQUEST['contrato_id'];
			$fecha_final = $_REQUEST['fecha_final'];
			$fecha_inicial = $_REQUEST['fecha_inicial'];
			$Model -> Procesar($this -> Campos,$contrato_id,$fecha_inicial,$fecha_final,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente las Horas Extras');
			}
		}


		protected function onclickDelete(){

			require_once("ExtrasModelClass.php");
			$Model = new ExtrasModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se pueden borrar las Horas Extras');
			}else{
				exit('Se borro exitosamente las Horas Extras');
			}
		}

		protected function onclickCancellation(){
  
			require_once("ExtrasModelClass.php");
			$Model                 = new ExtrasModel(); 

			$contrato_id         = $this -> requestDataForQuery('contrato_id','integer');
			$causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
			$observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
			$usuario_anulo_id      = $this -> getUsuarioId();
			
			$Model -> cancellation($contrato_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
			
			if(strlen($Model -> GetError()) > 0){
			exit('false');
			}else{
				exit('true');
			}
			
		}  


		//BUSQUEDA
		protected function onclickFind(){
			require_once("ExtrasModelClass.php");
			$Model = new ExtrasModel();
			$Data                  = array();
			$hora_extra_id   = $_REQUEST['hora_extra_id'];
			if(is_numeric($hora_extra_id)){
				$Data  = $Model -> selectExtrasId($hora_extra_id,$this -> getConex());
			}

			echo json_encode($Data);
		}


		protected function SetCampos(){

			/********************
			Campos Tarifas Proveedor
			********************/

			$this -> Campos[hora_extra_id] = array(
				name	=>'hora_extra_id',
				id		=>'hora_extra_id',
				type	=>'text',
				Boostrap =>'si',				
				disabled=>'yes',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('primary_key'))
			);

		  $this -> Campos[contrato_id] = array(
			   name =>'contrato_id',
			   id =>'contrato_hidden',
			   type =>'hidden',
			   required=>'yes',
			   datatype=>array(type=>'integer'),
			   transaction=>array(
					table =>array('hora_extra'),
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
					setId =>'contrato_hidden',
					onclick => 'setDataContrato')
		  );
		   
			$this -> Campos[sueldo_base] = array(
				name	=>'sueldo_base',
				id		=>'sueldo_base',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'30')/*,
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))*/
				
			);		   
		   
		   $this -> Campos[fecha_inicial] = array(
				name 	=>'fecha_inicial',
				id  	=>'fecha_inicial',
				type 	=>'text',
				required=>'yes',
				datatype=>array(
					type =>'date',
					length =>'11'),
				transaction=>array(
					table =>array('hora_extra'),
					type =>array('column'))
			);
		   
			$this -> Campos[fecha_final] = array(
				name 	=>'fecha_final',
				id  	=>'fecha_final',
				type 	=>'text',
				required=>'yes',
				datatype=>array(
					type =>'date',
					length =>'11'),
				transaction=>array(
					table =>array('hora_extra'),
					type =>array('column'))
		   );
		   
			$this -> Campos[horas_diurnas] = array(
				name	=>'horas_diurnas',
				id		=>'horas_diurnas',
				type	=>'text',
				required=>'yes',
				Boostrap =>'si',
				size	=>'10',				
				datatype=>array(
					type	=>'integer',
					length	=>'5'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);
			
			$this -> Campos[vr_horas_diurnas] = array(
				name	=>'vr_horas_diurnas',
				id		=>'vr_horas_diurnas',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);		   			

			$this -> Campos[horas_nocturnas] = array(
				name	=>'horas_nocturnas',
				id		=>'horas_nocturnas',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				size	=>'10',				
				datatype=>array(
					type	=>'integer',
					length	=>'5'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);
			
			$this -> Campos[vr_horas_nocturnas] = array(
				name	=>'vr_horas_nocturnas',
				id		=>'vr_horas_nocturnas',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);		   			
			
			$this -> Campos[horas_diurnas_fes] = array(
				name	=>'horas_diurnas_fes',
				id		=>'horas_diurnas_fes',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				size	=>'10',				
				datatype=>array(
					type	=>'integer',
					length	=>'5'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);

			$this -> Campos[vr_horas_diurnas_fes] = array(
				name	=>'vr_horas_diurnas_fes',
				id		=>'vr_horas_diurnas_fes',
				type	=>'text',
				required=>'yes',
				Boostrap =>'si',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);		   			

			$this -> Campos[horas_nocturnas_fes] = array(
				name	=>'horas_nocturnas_fes',
				id		=>'horas_nocturnas_fes',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'integer',
					length	=>'5'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);

			$this -> Campos[vr_horas_nocturnas_fes] = array(
				name	=>'vr_horas_nocturnas_fes',
				id		=>'vr_horas_nocturnas_fes',
				type	=>'text',
				required=>'yes',
				Boostrap =>'si',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);		   			

			$this -> Campos[horas_recargo_noc] = array(
				name	=>'horas_recargo_noc',
				id		=>'horas_recargo_noc',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'integer',
					length	=>'5'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);
			
			$this -> Campos[vr_horas_recargo_noc] = array(
				name	=>'vr_horas_recargo_noc',
				id		=>'vr_horas_recargo_noc',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);
			
			
			$this -> Campos[horas_recargo_doc] = array(
				name	=>'horas_recargo_doc',
				id		=>'horas_recargo_doc',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'integer',
					length	=>'5'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);
			
			$this -> Campos[vr_horas_recargo_doc] = array(
				name	=>'vr_horas_recargo_doc',
				id		=>'vr_horas_recargo_doc',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20'),
				transaction=>array(
					table	=>array('hora_extra'),
					type	=>array('column'))
				
			);
					   						
			$this -> Campos[vr_horas_festivo] = array(
				name	=>'vr_horas_festivo',
				id		=>'vr_horas_festivo',
				type	=>'text',
				Boostrap =>'si',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20')
				
			);	
			
			$this -> Campos[total] = array(
				name	=>'total',
				id		=>'total',
				type	=>'text',
				Boostrap =>'si',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20')
				
			);	

			$this -> Campos[vr_horas_nocturno] = array(
				name	=>'vr_horas_nocturno',
				id		=>'vr_horas_nocturno',
				type	=>'text',
				Boostrap =>'si',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20')
				
			);	  

			$this -> Campos[vr_horas_recargo_festivo] = array(
				name	=>'vr_horas_recargo_festivo',
				id		=>'vr_horas_recargo_festivo',
				type	=>'text',
				Boostrap =>'si',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20')
				
			);

			$this -> Campos[vr_horas_diurna_fest] = array(
				name	=>'vr_horas_diurna_fest',
				id		=>'vr_horas_diurna_fest',
				type	=>'text',
				Boostrap =>'si',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20')
				
			);

			$this -> Campos[vr_horas_extra_nocturna] = array(
				name	=>'vr_horas_extra_nocturna',
				id		=>'vr_horas_extra_nocturna',
				type	=>'text',
				Boostrap =>'si',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20')
				
			);	

			$this -> Campos[vr_horas_extra_diurna] = array(
				name	=>'vr_horas_extra_diurna',
				id		=>'vr_horas_extra_diurna',
				type	=>'text',
				Boostrap =>'si',
				readonly=>'yes',
				disabled=>'yes',
				size	=>'10',
				datatype=>array(
					type	=>'numeric',
					length	=>'20')
				
			);	  
			
			$this -> Campos[archivo]  = array(
				name	=>'archivo',
				id		=>'archivo',
				type	=>'file',
				// required=>'yes',
				title     =>'Carga de Archivos Clientes'
				
			);

			$this -> Campos[personas] = array(
				name	=>'personas',
				id		=>'personas',
				type	 =>'select',
				Boostrap =>'si',
				required =>'yes',
				options	 =>array(array(value => 'U',text => 'Uno',selected=>'0'),array(value => 'A', text => 'Todos')),
				//disabled=>'yes',		
				datatype=>array(
					type	=>'alphanum',
					length	=>'200')
			);	

			$this -> Campos[estado] = array(
				name =>'estado',
				id  =>'estado',
				type =>'select',
				Boostrap =>'si',
				options => array(array(value=>'E',text=>'EDICION',selected=>'0'),array(value=>'A',text=>'ANULADO'),array(value=>'L',text=>'LIQUIDADO'),array(value=>'P',text=>'PROCESADO')),
				// required=>'yes',
				datatype=>array(
					type =>'text',
					length =>'2'),
				transaction=>array(
					table =>array('hora_extra'),
					type =>array('column'))
		   );

		   	//ANULACION
	
			$this -> Campos[causal_anulacion_id] = array(
				name	=>'causal_anulacion_id',
				id		=>'causal_anulacion_id',
				type	=>'select',
				required=>'yes',
				options	=>array(),
				datatype=>array(
					type	=>'integer')
			);		
			
			
			$this -> Campos[observacion_anulacion] = array(
				name	=>'observacion_anulacion',
				id		=>'observacion_anulacion',
				type	=>'textarea',
				value	=>'',
				required=>'yes',
				datatype=>array(
					type	=>'text')
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
			
			$this -> Campos[procesar] = array(
				name	=>'procesar',
				id		=>'procesar',
				type	=>'button',
				value	=>'Procesar'
			);
			
			$this -> Campos[procesar_todos] = array(
				name	=>'procesar_todos',
				id		=>'procesar_todos',
				type	=>'button',
				value	=>'Procesar Todos'
			);

			$this -> Campos[actualizar] = array(
				name	=>'actualizar',
				id		=>'actualizar',
				type	=>'button',
				value	=>'Actualizar',
				disabled=>'disabled',
				// tabindex=>'20'
			);

			$this -> Campos[anular] = array(
			name	=>'anular',
			id		=>'anular',
			type	=>'button',
			value	=>'Anular',
			onclick =>'onclickCancellation(this.form)'
		);

			
		$this -> Campos[imprimir] = array(
			name	   =>'imprimir',
			id	   =>'imprimir',
			type	   =>'print',
			value	   =>'Imprimir',
				displayoptions => array(
					  beforeprint => 'beforePrint',
					  form        => 0,
			  title       => 'Impresion Horas Extras',
			  width       => '700',
			  height      => '600'
			)
	
		);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'ExtrasOnReset(this.form)'
			);

			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				Boostrap =>'si',
				size	=>'85',
				placeholder =>'Por favor digite el numero de identificacion o el nombre',
				// tabindex=>'1',
				suggest=>array(
					name	=>'horas_extras',
					setId	=>'hora_extra_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$hora_extra_id = new Extras();
?>