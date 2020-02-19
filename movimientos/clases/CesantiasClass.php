<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Cesantias extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("CesantiasLayoutClass.php");
	require_once("CesantiasModelClass.php");
	
	$Layout   = new CesantiasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CesantiasModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
	//// LISTAS MENU ////
	$liquidacion_cesantias_id = $_REQUEST['liquidacion_cesantias_id'];

		if($liquidacion_cesantias_id>0){

			$Layout -> setLiq_CesantiasFrame($liquidacion_cesantias_id);

		}

	//// GRID ////
	$Attributes = array(
	  id		=>'cesantias',
	  title		=>'Listado de Tipos de Cesantias',
	  sortname	=>'liquidacion_cesantias_id',
	  width		=>'auto',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'liquidacion_cesantias_id',	index=>'liquidacion_cesantias_id',	sorttype=>'text',	width=>'50',	align=>'center'),
		array(name=>'empleado',				index=>'empleado',		sorttype=>'text',	width=>'200',	align=>'left'),
		array(name=>'numero_identificacion',index=>'numero_identificacion',		sorttype=>'text',	width=>'200',	align=>'center'),
		array(name=>'observaciones',		index=>'observaciones',	sorttype=>'text',	width=>'200',	align=>'left'),
	  	array(name=>'fecha_liquidacion',	index=>'fecha_liquidacion',		sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'dias',			index=>'dias',		sorttype=>'text',	width=>'100',	align=>'center'),
	    array(name=>'valor',				index=>'valor',				sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'estado',				index=>'estado',			sorttype=>'text',	width=>'120',	align=>'center')
	);
	  
    $Titles = array('No',
					'EMPELADO',
					'NUMERO ID',
    				'OBSERVACION',
    				'FECHA LIQUIDACION',
    				'DIAS',
					'VALOR',
					'ESTADO'
	);
	
	$Layout -> SetGridCesantias($Attributes,$Titles,$Cols,$Model -> GetQueryCesantiasGrid());

	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("CesantiasModelClass.php");
    $Model = new CesantiasModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  
  protected function restaFechasContables(){
	$fecha_corte = $_REQUEST['fecha_corte'];
	$fecha_ultimo_corte = $_REQUEST['fecha_ultimo_corte'];
	$dias_corte = $this -> restaFechasCont($_REQUEST['fecha_ultimo_corte'],$_REQUEST['fecha_corte'],1);
	echo  $dias_corte;	  
  }

  protected function onclickSave(){

  	require_once("CesantiasModelClass.php");
    $Model = new CesantiasModel();
	$beneficiario = $_REQUEST['beneficiario'];
	$si_empleado = $_REQUEST['si_empleado'];
	$contrato_id = $_REQUEST['contrato_id'];	
	$fecha_liquidacion = $_REQUEST['fecha_liquidacion'];	
	$fecha_corte = $_REQUEST['fecha_corte'];
	$fecha_ultimo_corte = $_REQUEST['fecha_ultimo_corte'];
	$tipo_liquidacion = $_REQUEST['tipo_liquidacion'];	
	$observaciones = $_REQUEST['observaciones'];	
	$previsual          =	$_REQUEST['previsual'];
	
	$dias_corte = $this -> restaFechasCont($_REQUEST['fecha_ultimo_corte'],$_REQUEST['fecha_corte'],1);

	
	if($si_empleado==1){
		$contrato_id	  = $this -> requestDataForQuery('contrato_id','integer');
		$comprobar_nomina = $Model -> comprobar_liquidaciones($contrato_id,$fecha_corte,$this -> getConex());
		$comprobar_provision = $Model -> comprobar_liquidaciones_pro($contrato_id,$fecha_corte,$this -> getConex());
		
		//if($comprobar_nomina['validacion']!='SI') exit('No se ha liquidado las Nominas del Contrato a la fecha de Corte de cesantias'); 
		//if($comprobar_provision['validacion']!='SI') exit('No se ha liquidado las Provisiones del Contrato a la fecha de Corte de cesantias'); 
		
		
		$return = $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getConex());

		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit($return);
		}

	}else{

		$contratos_activos = $Model -> contratos_activos($fecha_corte,$this -> getConex());
		
		$no_liquidados='';
		$total_contratos = count($contratos_activos);
		$total_contratos_liq = 0;		
		for($i=0;$i<count($contratos_activos);$i++){ 
			$contrato_id = $contratos_activos[$i]['contrato_id'];
			$empleado_id = $contratos_activos[$i]['empleado_id'];	
			$tercero_id = $contratos_activos[$i]['tercero_id'];	
			$numero_identificacion = $contratos_activos[$i]['numero_identificacion'];	
			$tercero_id_cesan	 = $beneficiario=1 ?  $contratos_activos[$i]['tercero_id_cesan'] : $contratos_activos[$i]['tercero_id'];
			$numero_identificacion_cesan = $beneficiario=1 ? $contratos_activos[$i]['numero_identificacion_cesan'] :  $contratos_activos[$i]['numero_identificacion'];

			$area_laboral = $contratos_activos[$i]['area_laboral'];	
			$centro_de_costo_id = $contratos_activos[$i]['centro_de_costo_id'];	
			$salario = $contratos_activos[$i]['base_liquidacion'];	
			$fecha_inicio = $contratos_activos[$i]['fecha_inicio'];				
			$nombre = $contratos_activos[$i]['primer_nombre'].' '.$contratos_activos[$i]['primer_apellido'];									
			$comprobar_nomina = $Model -> comprobar_liquidaciones($contrato_id,$fecha_corte,$this -> getConex());
			$comprobar_provision = $Model -> comprobar_liquidaciones_pro($contrato_id,$fecha_corte,$this -> getConex());
			$comprobar_cesantias = $Model -> comprobar_liquidaciones_cesan($contrato_id,$fecha_corte,$this -> getConex());			
	
			//if($comprobar_nomina['validacion']!='SI') exit('No se ha liquidado las Nominas del Contrato de '. $contratos_activos[$i]['primer_nombre'].' '.$contratos_activos[$i]['primer_apellido'].' a la fecha de Corte de cesantias'); 
			//if($comprobar_provision['validacion']!='SI') exit('No se ha liquidado las Provisiones del Contrato de '. $contratos_activos[$i]['primer_nombre'].' '.$contratos_activos[$i]['primer_apellido'].' a la fecha de Corte de cesantias'); 
			
			if($comprobar_cesantias[0]['validacion_posterior']=='NO' || $comprobar_cesantias[0]['validacion_posterior']==''){
				if($fecha_inicio<$fecha_ultimo_corte){
					$fecha_ultimo_corte1 = $comprobar_cesantias[0]['fecha_corte']!='' ? $comprobar_cesantias[0]['fecha_corte'] : $fecha_ultimo_corte;
					$dias_corte = $this -> restaFechasCont($fecha_ultimo_corte1,$_REQUEST['fecha_corte'],1);
						
				}else{
					$fecha_ultimo_corte1 = $fecha_inicio;
					$dias_corte = $this -> restaFechasCont($fecha_ultimo_corte1,$_REQUEST['fecha_corte'],0);
			
				}
				$Data = $Model -> getValor($empleado_id,$fecha_ultimo_corte1,$fecha_corte,$dias_corte,$this -> getOficinaId(),$this -> getConex());
				$valor_diferencia = intval($Data[0]['valor_liquidacion']-$Data[0]['valor_consolidado']);
				
				if($Data[0]['validacion_posterior']=='SI'){
					$no_liquidados.='El Empleado '.$numero_identificacion.' -  '.$nombre.' no se Liquido, ya tiene una liquidaci&oacute;n Reciente!!<br>';
				}else{
					$return = $Model -> saveTodos($si_empleado,$area_laboral,$centro_de_costo_id,$tercero_id,$numero_identificacion,$tercero_id_cesan,$numero_identificacion_cesan,$fecha_liquidacion,$fecha_corte,$fecha_ultimo_corte1,$beneficiario,$contrato_id,$empleado_id,$salario,$dias_corte,$Data[0]['valor_liquidacion'],$Data[0]['dias_no_remu'],$Data[0]['dias_liquidacion'],$Data[0]['valor_consolidado'],$valor_diferencia,$fecha_inicio,$tipo_liquidacion,$observaciones,$this -> getOficinaId(),$this -> getConex());
					if(!$Model -> GetNumError() > 0){
						$total_contratos_liq++;
					}
				}
			}
		}
		echo $no_liquidados.'<br>Total Contratos Activos: '.$total_contratos.'<br>Total Contratos Liquidados:'.$total_contratos_liq;
		
	}
	
	
  }
	
	 protected function getTotalDebitoCredito(){
	  
    require_once("CesantiasModelClass.php");
    $Model = new CesantiasModel();
	
	$liquidacion_cesantias_id = $_REQUEST['liquidacion_cesantias_id'];
	
	$data = $Model -> getTotalDebitoCredito($liquidacion_cesantias_id,$this -> getConex());
	
	$this -> getArrayJSON($data);  
	  
  }
  protected function onclickUpdate(){
 
  	require_once("CesantiasModelClass.php");
    $Model = new CesantiasModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Tipo de Cesantias');
	  }
	
  }
  protected function getContabilizar(){
	
  	require_once("CesantiasModelClass.php");
    $Model = new CesantiasModel();
	$liquidacion_cesantias_id 	 = $_REQUEST['liquidacion_cesantias_id'];
	$fecha_inicial = $_REQUEST['fecha_inicial'];
	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
	
	
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha_inicial,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	$estado=$Model -> comprobar_estado($liquidacion_cesantias_id,$this -> getConex());

	if($estado[0]['estado']=='C'){
		 exit('No se puede Contabilizar. <br> La Liquidaci&oacute;n estaba previamente Contabilizada.');
	}else if(is_numeric($estado[0]['encabezado_registro_id'])){
		 exit('No se puede Contabilizar. <br> La Liquidaci&oacute;n estaba previamente Relacionada con un Registro contable.');
		 
	}
	 
    if($mesContable && $periodoContable){
		if($estado[0]['si_empleado']=='1'){
			$return=$Model -> getContabilizarReg($liquidacion_cesantias_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());//aca
		}elseif($estado[0]['si_empleado']=='ALL'){
			$return=$Model -> getContabilizarRegT($liquidacion_cesantias_id,$estado[0]['fecha_liquidacion'],$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());	
		}
		if($return==true){
			exit("true");
		}else{
			exit("Error : ".$Model -> GetError());
		}	
		
	}else{
			 
		if(!$mesContable && !$periodoContable){
			exit("No se permite Contabilizar en el periodo y mes seleccionado");
		}elseif(!$mesContable){
 		    exit("No se permite Contabilizar en el mes seleccionado");				 
		}else if(!$periodoContable){
		    exit("No se permite Contabilizar en el periodo seleccionado");				   
		}
	}
	  
  }
  
  protected function setDataEmpleado(){
	 require_once("CesantiasModelClass.php");
	$Model = new CesantiasModel();
	$empleado_id 	= $_REQUEST['empleado_id'];
	
	$Data = $Model -> getDataEmpleado($empleado_id,$this -> getOficinaId(),$this -> getConex());
	
	echo json_encode($Data);
	 
  }
  
  protected function calculaValor(){
	 require_once("CesantiasModelClass.php");
	$Model = new CesantiasModel();
	$empleado_id 	= $_REQUEST['empleado_id'];
	$fecha_corte 	= $_REQUEST['fecha_corte'];
	$fecha_ultimo_corte = $_REQUEST['fecha_ultimo_corte'];

	$dias_corte = $this -> restaFechasCont($fecha_ultimo_corte,$fecha_corte,1);

	$Data = $Model -> getValor($empleado_id,$fecha_ultimo_corte,$fecha_corte,$dias_corte,$this -> getOficinaId(),$this -> getConex());
	
	echo json_encode($Data);
	 
  }
  

  //BUSQUEDA
  protected function onclickFind(){
	require_once("CesantiasModelClass.php");
    $Model = new CesantiasModel();
	
    $Data          		= array();
	$liquidacion_cesantias_id 	= $_REQUEST['liquidacion_cesantias_id'];
	 
	if(is_numeric($liquidacion_cesantias_id)){
	  
	  $Data  = $Model -> selectDatosLiquidacionId($liquidacion_cesantias_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos concepto
	********************/
	
	$this -> Campos[fecha_liquidacion] = array(
		name 	=>'fecha_liquidacion',
		id  	=>'fecha_liquidacion',
		type 	=>'text',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('liquidacion_cesantias'),
			type =>array('column'))
	);
	
	
	$this -> Campos[liquidacion_cesantias_id] = array(
		name	=>'liquidacion_cesantias_id',
		id		=>'liquidacion_cesantias_id',
		type	=>'text',
		Boostrap =>'si',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
	);
	
	$this -> Campos[empleado_id] = array(
		name	=>'empleado_id',
		id		=>'empleado_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
	);
	$this -> Campos[contrato_id] = array(
		name	=>'contrato_id',
		id		=>'contrato_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
	);
	
	$this -> Campos[empleado] = array(
		name =>'empleado',
		id =>'empleado',
		type =>'text',
		Boostrap =>'si',
		required=>'yes',
		size    =>'45',
		suggest => array(
		name =>'empleado',
		setId =>'empleado_id',
		onclick => 'setDataEmpleado')
	  );

	$this -> Campos[cargo] = array(
		name	=>'cargo',
		id		=>'cargo',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250')
	);

	$this -> Campos[num_identificacion] = array(
		name	=>'num_identificacion',
		id		=>'num_identificacion',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250')
		
	);
	$this -> Campos[salario] = array(
		name	=>'salario',
		id		=>'salario',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[valor_liquidacion] = array(
		name	=>'valor_liquidacion',
		id		=>'valor_liquidacion',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[valor_liquidacion1] = array(
		name	=>'valor_liquidacion1',
		id		=>'valor_liquidacion1',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'250')
		
	);
	

		
	
	$this -> Campos[fecha_inicio_contrato] = array(
		name 	=>'fecha_inicio_contrato',
		id  	=>'fecha_inicio_contrato',
		type 	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
		
	);	
	
	$this -> Campos[fecha_ultimo_corte] = array(
		name	=>'fecha_ultimo_corte',
		id		=>'fecha_ultimo_corte',
		type	=>'text',
		required=>'yes',
		disabled=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
	);

	$this -> Campos[fecha_ultimo_corte1] = array(
		name	=>'fecha_ultimo_corte1',
		id		=>'fecha_ultimo_corte1',
		type	=>'hidden',
		//required=>'yes',
		//disabled=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'10')
		
	);

	/*$this -> Campos[valor_provision] = array(
		name	=>'valor_provision',
		id		=>'valor_provision',
		type	=>'text',
		required=>'yes',
		//readonly=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
		
	);*/
	
	$this -> Campos[valor_consolidado] = array(
		name	=>'valor_consolidado',
		id		=>'valor_consolidado',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		//readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[valor_diferencia] = array(
		name	=>'valor_diferencia',
		id		=>'valor_diferencia',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		//readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
	);
	
	

	$this -> Campos[observaciones] = array(
		name	=>'observaciones',
		id		=>'observaciones',
		type	=>'text',
		Boostrap =>'si',
		size	=>61,
		
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'450'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[dias_liquidados] = array(
		name	=>'dias_liquidados',
		id		=>'dias_liquidados',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'450'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[dias_periodo] = array(
		name	=>'dias_periodo',
		id		=>'dias_periodo',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'450'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[dias_no_remu] = array(
		name	=>'dias_no_remu',
		id		=>'dias_no_remu',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'450'),
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
			type	=>array('column'))
		
	);
	
	
	$this -> Campos[fecha_corte] = array(
		name 	=>'fecha_corte',
		id  	=>'fecha_corte',
		type 	=>'text',
		required=>'yes',
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('liquidacion_cesantias'),
			type =>array('column'))
	);
			
	$this -> Campos[estado] = array(
		name =>'estado',
		id  =>'estado',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO',selected=>'A'),array(value => 'C', text => 'CONTABILIZADA')),
		required=>'yes',
		disabled=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('liquidacion_cesantias'),
		 	type =>array('column'))
   );
	
	$this -> Campos[tipo_liquidacion] = array(
		name =>'tipo_liquidacion',
		id  =>'tipo_liquidacion',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>'T',text=>'TOTAL',selected=>'T'),array(value=>'P',text=>'PARCIAL',selected=>'T')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('liquidacion_cesantias'),
		 	type =>array('column'))
   );
	
	$this -> Campos[si_empleado] = array(
		name	=>'si_empleado',
		id		=>'si_empleado',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(array(value=>'1',text=>'UNO',selected=>'1'),array(value=>'ALL',text=>'TODOS',selected=>'1')),
		required=>'yes',
		onchange=>'Empleado_si()',
			transaction=>array(
		 	table =>array('liquidacion_cesantias'),
		 	type =>array('column'))
	
	);
	
	$this -> Campos[beneficiario] = array(
		name	=>'beneficiario',
		id		=>'beneficiario',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(array(value=>'1',text=>'FONDO',selected=>'1'),array(value=>'2',text=>'EMPLEADO',selected=>'1')),
		required=>'yes',
		transaction=>array(
			table	=>array('liquidacion_cesantias'),
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
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
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
			onsuccess=>'CesantiasOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'button',
		value	=>'Limpiar',
		onclick	=>'CesantiasOnReset(this.form)'
	);
		$this -> Campos[contabilizar] = array(
		name	=>'contabilizar',
		id		=>'contabilizar',
		type	=>'button',
		value	=>'Contabilizar',
		tabindex=>'16',
		onclick =>'OnclickContabilizar()'
	);	

   	$this -> Campos[previsual] = array(
		name	    =>'previsual',
		id	    	=>'previsual',
		type	    =>'button',
		value	    =>'Previsual',
		onclick     =>'Previsual(this.form)'
	);

   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap =>'si',
		size	=>'85',
		placeholder =>'Por favor digite el numero de identificación o el nombre',
		suggest=>array(
			name	=>'liquidacion_cesantias',
			setId	=>'liquidacion_cesantias_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$Cesantias = new Cesantias();

?>