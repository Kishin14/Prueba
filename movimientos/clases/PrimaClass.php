<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Prima extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("PrimaLayoutClass.php");
	require_once("PrimaModelClass.php");
	
	$Layout   = new PrimaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PrimaModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	$Layout -> setImprimir	($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
	//// LISTAS MENU ////
	 $liquidacion_prima_id = $_REQUEST['liquidacion_prima_id'];

		if($liquidacion_prima_id>0){

			$Layout -> setLiq_PrimaFrame($liquidacion_prima_id);

		}

	//// GRID ////
	$Attributes = array(
	  id		=>'liquidacion_prima_id',
	  title		=>'Listado de Liquidaciones Primas',
	  sortname	=>'fecha_liquidacion',
	  width		=>'1150',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'liquidacion_prima_id',		index=>'liquidacion_prima_id',	sorttype=>'text',	width=>'50',	align=>'center'),
		array(name=>'contrato_id',				index=>'contrato_id',			sorttype=>'text',	width=>'190',	align=>'left'),
	  	array(name=>'encabezado_registro_id',	index=>'encabezado_registro_id',sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'fecha_liquidacion',		index=>'fecha_liquidacion',		sorttype=>'text',	width=>'115',	align=>'center'),
	  	array(name=>'periodo',					index=>'periodo',				sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'total',					index=>'total',					sorttype=>'text',	width=>'120',	align=>'center'),
	  	array(name=>'tipo_liquidacion',			index=>'tipo_liquidacion',		sorttype=>'text',	width=>'120',	align=>'center'),
	  	array(name=>'observaciones',			index=>'observaciones',			sorttype=>'text',	width=>'340',	align=>'center'),
	  	array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'80',	align=>'center')
	);
	  
    $Titles = array('No.',
    				'EMPLEADO',
    				'<span style="font-size: 10px">DOC. CONTABLE</span>',
    				'<span style="font-size: 10px">FECHA LIQUIDACION</span>',
    				'PERIODO CONT.',
					'TOTAL',
					'TIPO LIQUIDACION',
					'OBSERVACIONES',
					'ESTADO'
	);
	
	$Layout -> SetGridPrima($Attributes,$Titles,$Cols,$Model -> GetQueryPrimaGrid());

	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("PrimaModelClass.php");
    $Model = new PrimaModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

		require_once("PrimaModelClass.php");
		$Model = new PrimaModel();

		$return = $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getConex());
		
		if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
		}else{
			exit($return);
		}
	 	
  }
	
	 protected function getTotalDebitoCredito(){
	  
    require_once("PrimaModelClass.php");
    $Model = new PrimaModel();
	
	$liquidacion_prima_id = $_REQUEST['liquidacion_prima_id'];
	$rango 				  = $_REQUEST['rango'];
	
	$data = $Model -> getTotalDebitoCredito($liquidacion_prima_id,$rango,$this -> getConex());
	
	$this -> getArrayJSON($data);  
	  
  }
  protected function onclickUpdate(){
 
  	require_once("PrimaModelClass.php");
    $Model = new PrimaModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Tipo de Prima');
	  }
	
  }
  protected function getContabilizar(){
	
  	require_once("PrimaModelClass.php");
    $Model = new PrimaModel();
	$liquidacion_prima_id 	= $_REQUEST['liquidacion_prima_id'];
	$fecha 			= $_REQUEST['fecha_liquidacion'];
	$si_empleado 	= $_REQUEST['si_empleado'];
	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
	
	
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	
    if($mesContable && $periodoContable){
		$return=$Model -> getContabilizarReg($liquidacion_prima_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$si_empleado,$this -> getConex());
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

	require_once("PrimaModelClass.php");
	$Model = new PrimaModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el Prima');
	}else{
		exit('Se borro exitosamente el Prima');
	}
  }
  
  protected function setDataEmpleado(){
	 require_once("PrimaModelClass.php");
	$Model = new PrimaModel();
	$empleado_id 	= $_REQUEST['empleado_id'];
	$fecha_liquidacion 	= $_REQUEST['fecha_liquidacion'];
	
	$Data = $Model -> getDataEmpleado($empleado_id,$fecha_liquidacion,$this -> getConex());
	
	
	
	echo json_encode($Data);
	 
  }
  
  protected function onclickPrint(){

		require_once("Imp_LiquidacionPrimaClass.php");
		$empresa_id = $this -> getEmpresaId();
		$print = new Imp_LiquidacionPrima($empresa_id,$this -> getConex());
		$print -> printOut();
	  
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

   protected function Liq_Anterior($Conex){
	  
	require_once("PrimaModelClass.php");
	$Model = new PrimaModel();
	$empleado_id 	= $_REQUEST['empleado_id'];
	$periodo 	= $_REQUEST['periodo'];
	$fecha_liquidacion 	= $_REQUEST['fecha_liquidacion'];
	$oficina_id = $this -> getOficinaId();
	
	$Data = $Model -> Liq_Anterior($empleado_id,$fecha_liquidacion,$periodo,$oficina_id,$this -> getConex());
	
	echo json_encode($Data);
   }


//BUSQUEDA
  protected function onclickFind(){
	require_once("PrimaModelClass.php");
    $Model = new PrimaModel();
	
    $Data          		= array();
	$liquidacion_prima_id 	= $_REQUEST['liquidacion_prima_id'];
	$consecutivo 	= $_REQUEST['consecutivo'];
	 
	if(is_numeric($liquidacion_prima_id) || is_numeric($consecutivo)){
	  
	  $Data  = $Model -> selectDatosLiquidacionId($liquidacion_prima_id,$consecutivo,$this -> getConex());
	  
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
		required=>'yes',
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('liquidacion_prima'),
			type =>array('column'))
	);
	
	
	$this -> Campos[liquidacion_prima_id] = array(
		name	=>'liquidacion_prima_id',
		id		=>'liquidacion_prima_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_prima'),
			type	=>array('column'))
	);
	
	$this -> Campos[consecutivo] = array(
		name	=>'consecutivo',
		id		=>'consecutivo',
		type	=>'text',
		Boostrap =>'si',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_prima'),
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
			table	=>array('liquidacion_prima'),
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
			length	=>'250')
		
	);
	
	$this -> Campos[total] = array(
		name	=>'total',
		id		=>'total',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_prima'),
			type	=>array('column'))
		
	);

	$this -> Campos[acumulado] = array(
		name	=>'acumulado',
		id		=>'acumulado',
		type	=>'text',
		Boostrap =>'si',	
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'250',
		)
	);

	$this -> Campos[diferencia] = array(
		name	=>'diferencia',
		id		=>'diferencia',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'250'),	
	);
	

		
	
	$this -> Campos[fecha_inicio_contrato] = array(
		name 	=>'fecha_inicio_contrato',
		id  	=>'fecha_inicio_contrato',
		type 	=>'text',
		required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type =>'date',
			length =>'11')
		
	);	
	

	$this -> Campos[observaciones] = array(
		name	=>'observaciones',
		id		=>'observaciones',
		type	=>'text',
		Boostrap =>'si',
		size	=>81,
		
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'450'),
		transaction=>array(
			table	=>array('liquidacion_prima'),
			type	=>array('column'))
		
	);
	
			
	$this -> Campos[estado] = array(
		name =>'estado',
		id  =>'estado',
		type =>'select',
		Boostrap =>'si',
		disabled => 'disabled',
		options => array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO',selected=>'A'),array(value => 'C', text => 'CONTABILIZADA')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('liquidacion_prima'),
		 	type =>array('column'))
   );
	
	$this -> Campos[tipo_liquidacion] = array(
		name =>'tipo_liquidacion',
		id  =>'tipo_liquidacion',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>'T',text=>'TOTAL SEMESTRE',selected=>'T'),array(value=>'P',text=>'PARCIAL SEMESTRE',selected=>'T')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('liquidacion_prima'),
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
	
	$this -> Campos[periodo] = array(
		name	=>'periodo',
		id		=>'periodo',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(array(value=>'1',text=>'PRIMER SEMESTRE',selected=>'1'),array(value=>'2',text=>'SEGUNDO SEMESTRE',selected=>'1')),
		required=>'yes'
		
	);
	
	
	
   $this -> Campos[print_out] = array(
		name	   =>'print_out',
		id		   =>'print_out',
		type	   =>'button',
		value	   =>'OK'

	);	

	$this -> Campos[tipo_impresion] = array(
		name	=>'tipo_impresion',
		id	    =>'tipo_impresion',
		type	=>'select',
		Boostrap =>'si',
		options => array(array(value => 'C', text => 'PLANILLA LIQUIDACION'),array(value => 'CL', text => 'DESPRENDIBLES LIQUIDACION'), array(value => 'DP', text => 'DESPRENDIBLE DE PAGO'), array(value => 'DC', text => 'DOCUMENTO CONTABLE')),
		selected=>'C',
		datatype=>array(type=>'text')
	);	

	$this -> Campos[desprendibles] = array(
		name	=>'desprendibles',
		id	    =>'desprendibles',
		type	=>'select',
		Boostrap =>'si',
		options => array(array(value => '1', text => '1'), array(value => '2', text => '2'), array(value => '3', text => '3'), array(value => '4', text => '4'), array(value => '5', text => '5')),
		selected=>'1',
		datatype=>array(type=>'text')
	);	

   	$this -> Campos[print_cancel] = array(
		name	   =>'print_cancel',
		id		   =>'print_cancel',
		type	   =>'button',
		value	   =>'CANCEL'

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
			onsuccess=>'PrimaOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'PrimaOnReset()'
	);
	
	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id	   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
			displayoptions => array(
				  form        => 0,
				  beforeprint => 'beforePrint',
		  title       => 'Impresion Liquidacion',
		  width       => '700',
		  height      => '600'
		)

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
		Boostrap =>'si',
		placeholder =>'Por favor digite el numero de identificación o el nombre',
		size	=>'55',
		suggest=>array(
			name	=>'liquidacion_prima',
			setId	=>'liquidacion_prima_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	$this -> Campos[busqueda_fecha] = array(
		name	=>'busqueda_fecha',
		id		=>'busqueda_fecha',
		type	=>'text',
		Boostrap =>'si',
		placeholder =>'Por favor digite el numero de liquidacion o fecha	',
		size	=>'55',
		suggest=>array(
			name	=>'liquidacion_prima_todos',
			setId	=>'consecutivo',
			onclick	=>'setDataFormWithResponse1')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$Prima = new Prima();

?>