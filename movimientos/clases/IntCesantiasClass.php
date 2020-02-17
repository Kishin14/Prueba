<?php

require_once("../../../framework/clases/ControlerClass.php");

final class IntCesantias extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("IntCesantiasLayoutClass.php");
	require_once("IntCesantiasModelClass.php");
	
	$Layout   = new IntCesantiasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new IntCesantiasModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
	//// LISTAS MENU ////
	

	//// GRID ////
	$Attributes = array(
		id		    =>'novedad_fija_id',
		title		=>'Listado de Tipos de Cesantias',
		sortname	=>'liquidacion_int_cesantias_id',
		width		=>'auto',
		height	    =>'200'
	  );
  
	  $Cols = array(
		  array(name=>'liquidacion_int_cesantias_id',	index=>'liquidacion_int_cesantias_id',	sorttype=>'text',	width=>'50',	align=>'center'),
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
	
	$Layout -> SetGridIntCesantias($Attributes,$Titles,$Cols,$Model -> GetQueryIntCesantiasGrid());

	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("IntCesantiasModelClass.php");
    $Model = new IntCesantiasModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("IntCesantiasModelClass.php");
    $Model = new IntCesantiasModel();
	
	$return = $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit($return);
	}
	
  }
	
	 protected function getTotalDebitoCredito(){
	  
    require_once("IntCesantiasModelClass.php");
    $Model = new IntCesantiasModel();
	
	$liquidacion_int_cesantias_id = $_REQUEST['liquidacion_int_cesantias_id'];
	
	$data = $Model -> getTotalDebitoCredito($liquidacion_int_cesantias_id,$this -> getConex());
	
	$this -> getArrayJSON($data);  
	  
  }
  protected function onclickUpdate(){
 
  	require_once("IntCesantiasModelClass.php");
    $Model = new IntCesantiasModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Tipo de IntCesantias');
	  }
	
  }
  protected function getContabilizar(){
	
  	require_once("IntCesantiasModelClass.php");
    $Model = new IntCesantiasModel();
	$liquidacion_int_cesantias_id 	= $_REQUEST['liquidacion_int_cesantias_id'];
	$fecha 			= $_REQUEST['fecha_liquidacion'];
	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
	
	
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	
    if($mesContable && $periodoContable){
		$return=$Model -> getContabilizarReg($liquidacion_int_cesantias_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());
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
  protected function onclickDelete(){

	require_once("IntCesantiasModelClass.php");
	$Model = new IntCesantiasModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el IntCesantias');
	}else{
		exit('Se borro exitosamente el IntCesantias');
	}
  }
  
  protected function setDataEmpleado(){
	 require_once("IntCesantiasModelClass.php");
	$Model = new IntCesantiasModel();
	$empleado_id 	= $_REQUEST['empleado_id'];
	
	$Data = $Model -> getDataEmpleado($empleado_id,$this -> getOficinaId(),$this -> getConex());
	
	
	
	echo json_encode($Data);
	 
  }
  
  protected function calculaValor(){
	 require_once("IntCesantiasModelClass.php");
	$Model = new IntCesantiasModel();
	$empleado_id 	= $_REQUEST['empleado_id'];
	$fecha_corte 	= $_REQUEST['fecha_corte'];
	
	$Data = $Model -> getValor($empleado_id,$fecha_corte,$this -> getConex());
	
	
	
	echo json_encode($Data);
	 
  }
  
   protected function setVencimiento($Conex){
	  
  	$dias 	 = $_REQUEST['dias'];
	$fecha 	 = $_REQUEST['fecha'];
	$dias2	 = $dias+1;
	$dia_fin = date('Y-m-d', strtotime("$fecha + $dias day"));
	$dia_reintegro = date('Y-m-d', strtotime("$fecha + $dias2 day"));
	$Data[0]['dia_fin']= $dia_fin;
	$Data[0]['dia_reintegro']= $dia_reintegro;
	  $this -> getArrayJSON($Data);
   }


//BUSQUEDA
  protected function onclickFind(){
	require_once("IntCesantiasModelClass.php");
    $Model = new IntCesantiasModel();
	
    $Data          		= array();
	$liquidacion_int_cesantias_id 	= $_REQUEST['liquidacion_int_cesantias_id'];
	 
	if(is_numeric($liquidacion_int_cesantias_id)){
	  
	  $Data  = $Model -> selectDatosLiquidacionId($liquidacion_int_cesantias_id,$this -> getConex());
	  
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
			table =>array('liquidacion_int_cesantias'),
			type =>array('column'))
	);
	
	
	$this -> Campos[liquidacion_int_cesantias_id] = array(
		name	=>'liquidacion_int_cesantias_id',
		id		=>'liquidacion_int_cesantias_id',
		type	=>'text',
		Boostrap =>'si',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_int_cesantias'),
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
			table	=>array('liquidacion_int_cesantias'),
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
			table	=>array('liquidacion_int_cesantias'),
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
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_int_cesantias'),
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
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_int_cesantias'),
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
			type	=>'text',
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
			table	=>array('liquidacion_int_cesantias'),
			type	=>array('column'))
		
		
	);	
	
	$this -> Campos[fecha_ultimo_corte] = array(
		name	=>'fecha_ultimo_corte',
		id		=>'fecha_ultimo_corte',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		//readonly=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_int_cesantias'),
			type	=>array('column'))
		
	);
	
	
	$this -> Campos[valor_consolidado] = array(
		name	=>'valor_consolidado',
		id		=>'valor_consolidado',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		//readonly=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_int_cesantias'),
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
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_int_cesantias'),
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
			table	=>array('liquidacion_int_cesantias'),
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
			table	=>array('liquidacion_int_cesantias'),
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
			table	=>array('liquidacion_int_cesantias'),
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
			table	=>array('liquidacion_int_cesantias'),
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
			table =>array('liquidacion_int_cesantias'),
			type =>array('column'))
	);
			
	$this -> Campos[estado] = array(
		name =>'estado',
		id  =>'estado',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO',selected=>'A'),array(value => 'C', text => 'CONTABILIZADA')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('liquidacion_int_cesantias'),
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
		 	table =>array('liquidacion_int_cesantias'),
		 	type =>array('column'))
   );
	
	$this -> Campos[si_empleado] = array(
		name	=>'si_empleado',
		id		=>'si_empleado',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(array(value=>'1',text=>'UNO',selected=>'1'),array(value=>'ALL',text=>'TODOS',selected=>'1')),
		
		required=>'yes',
		onchange=>'Empleado_si()'
	);
	
	$this -> Campos[beneficiario] = array(
		name	=>'beneficiario',
		id		=>'beneficiario',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(array(value=>'1',text=>'FONDO',selected=>'1'),array(value=>'2',text=>'EMPLEADO',selected=>'1')),
		required=>'yes',
		transaction=>array(
			table	=>array('liquidacion_int_cesantias'),
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
			onsuccess=>'IntCesantiasOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'IntCesantiasOnReset()'
	);
		$this -> Campos[contabilizar] = array(
		name	=>'contabilizar',
		id		=>'contabilizar',
		type	=>'button',
		value	=>'Contabilizar',
		tabindex=>'16',
		onclick =>'OnclickContabilizar()'
	);	
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		suggest=>array(
			name	=>'liquidacion_int_cesantias',
			setId	=>'liquidacion_int_cesantias_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$IntCesantias = new IntCesantias();

?>