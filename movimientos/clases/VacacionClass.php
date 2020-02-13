<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Vacacion extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("VacacionLayoutClass.php");
	require_once("VacacionModelClass.php");
	
	$Layout   = new VacacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new VacacionModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> setImprimir	($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
	//// LISTAS MENU ////
	$liquidacion_vacaciones_id = $_REQUEST['liquidacion_vacaciones_id'];

		if($liquidacion_vacaciones_id>0){

			$Layout -> setLiq_VacacionFrame($liquidacion_vacaciones_id);

		}

	//// GRID ////
	$Attributes = array(
	  id		=>'liquidacion_vacaciones_id',
	  title		=>'Listado de Liquidaciones Vacaciones',
	  sortname	=>'fecha_liquidacion',
	  width		=>'1150',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'liquidacion_vacaciones_id',index=>'liquidacion_vacaciones_id',	sorttype=>'text',	width=>'50',	align=>'center'),
		array(name=>'contrato_id',				index=>'contrato_id',				sorttype=>'text',	width=>'200',	align=>'left'),
	  	array(name=>'encabezado_registro_id',	index=>'encabezado_registro_id',	sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'fecha_liquidacion',		index=>'fecha_liquidacion',			sorttype=>'text',	width=>'90',	align=>'center'),
	  	array(name=>'fecha_dis_inicio',			index=>'fecha_dis_inicio',			sorttype=>'text',	width=>'90',	align=>'center'),
	  	array(name=>'fecha_dis_final',			index=>'fecha_dis_final',			sorttype=>'text',	width=>'90',	align=>'center'),
	  	array(name=>'fecha_reintegro',			index=>'fecha_reintegro',			sorttype=>'text',	width=>'90',	align=>'center'),
	  	array(name=>'dias',						index=>'dias',						sorttype=>'text',	width=>'50',	align=>'center'),
	  	array(name=>'valor',					index=>'valor',						sorttype=>'text',	width=>'80',	align=>'center'),
	  	array(name=>'concepto',					index=>'concepto',					sorttype=>'text',	width=>'360',	align=>'left'),
	  	array(name=>'observaciones',			index=>'observaciones',				sorttype=>'text',	width=>'140',	align=>'left'),
	  	array(name=>'estado',					index=>'estado',					sorttype=>'text',	width=>'80',	align=>'center')
	);
	  
    $Titles = array('No.',
    				'EMPLEADO',
    				'<span style="font-size: 10px">DOC. CONTABLE</span>',
    				'<span style="font-size: 10px">FECHA LIQUIDACION</span>',
    				'<span style="font-size: 10px">FECHA INICIO</span>',
					'<span style="font-size: 10px">FECHA FINAL</span>',
					'<span style="font-size: 10px">FECHA REINTEGRO</span>',
					'DIAS',
					'VALOR',
					'CONCEPTO',
					'OBSERVACIONES',
					'ESTADO'
	);
	
	
	
	$Layout -> SetGridVacacion($Attributes,$Titles,$Cols,$Model -> GetQueryVacacionGrid());

	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("VacacionModelClass.php");
    $Model = new VacacionModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("VacacionModelClass.php");
    $Model = new VacacionModel();
	
	$return = $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit($return);
	}
	
  }
  
  protected function onclickPrint(){
	//exit("vamos bien");
		require_once("Imp_LiquidacionVacacionesClass.php");
		$print = new Imp_LiquidacionVacaciones($this -> getEmpresaId(),$this -> getConex());
		$print -> printOut();
	  
	}
	
	 protected function getTotalDebitoCredito(){
	  
    require_once("VacacionModelClass.php");
    $Model = new VacacionModel();
	
	$liquidacion_vacaciones_id = $_REQUEST['liquidacion_vacaciones_id'];
	
	$data = $Model -> getTotalDebitoCredito($liquidacion_vacaciones_id,$this -> getConex());
	
	$this -> getArrayJSON($data);  
	  
  }
  protected function onclickUpdate(){
 
  	require_once("VacacionModelClass.php");
    $Model = new VacacionModel();
	
	$liquidacion_vacaciones_id = $_REQUEST['liquidacion_vacaciones_id'];

    $Model -> Update($liquidacion_vacaciones_id, $this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Tipo de Vacacion');
	  }
	
  }
  protected function getContabilizar(){
	
  	require_once("VacacionModelClass.php");
    $Model = new VacacionModel();
	$liquidacion_vacaciones_id 	= $_REQUEST['liquidacion_vacaciones_id'];
	$fecha 			= $_REQUEST['fecha_liquidacion'];
	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
	
	
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	
    if($mesContable && $periodoContable){
		$return=$Model -> getContabilizarReg($liquidacion_vacaciones_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());
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

	require_once("VacacionModelClass.php");
	$Model = new VacacionModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el Prima');
	}else{
		exit('Se borro exitosamente el Prima');
	}
  }
  
  protected function setDataEmpleado(){
	 require_once("VacacionModelClass.php");
	$Model = new VacacionModel();
	$empleado_id 	= $_REQUEST['empleado_id'];
	
	$Data = $Model -> getDataEmpleado($empleado_id,$this -> getConex());
	
	
	
	echo json_encode($Data);
	 
  }
  
   protected function setVencimiento($Conex){
	  
	require_once("VacacionModelClass.php");
    $Model = new VacacionModel();
	
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
	require_once("VacacionModelClass.php");
    $Model = new VacacionModel();
	
    $Data          		= array();
	$liquidacion_vacaciones_id 	= $_REQUEST['liquidacion_vacaciones_id'];
	 
	if(is_numeric($liquidacion_vacaciones_id)){
	  
	  $Data  = $Model -> selectDatosLiquidacionId($liquidacion_vacaciones_id,$this -> getConex());
	  
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
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))
	);
	
	
	$this -> Campos[liquidacion_vacaciones_id] = array(
		name	=>'liquidacion_vacaciones_id',
		id		=>'liquidacion_vacaciones_id',
		type	=>'text',
		Boostrap =>'si',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_vacaciones'),
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
			table	=>array('liquidacion_vacaciones'),
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
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id		=>'valor',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('liquidacion_vacaciones'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[concepto_item] = array(
		name	=>'concepto_item',
		id		=>'concepto_item',
		type	=>'hidden',	
		
	 	datatype=>array(
			type	=>'text',
			length	=>'450')
	);

	$this -> Campos[concepto] = array(
		name	=>'concepto',
		id		=>'concepto',
		type	=>'text',
		Boostrap =>'si',
		size	=>78,
		readonly=>'yes',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'450'),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))
		
	);
	
	$this -> Campos[dias] = array(
		name	=>'dias',
		id		=>'dias',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))
		
		
	);

	$this -> Campos[fecha_dis_inicio] = array(
		name 	=>'fecha_dis_inicio',
		id  	=>'fecha_dis_inicio',
		type 	=>'text',
		required=>'yes',
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))
	);
	$this -> Campos[fecha_dis_final] = array(
		name 	=>'fecha_dis_final',
		id  	=>'fecha_dis_final',
		type 	=>'text',
		required=>'yes',
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))
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
	$this -> Campos[fecha_reintegro] = array(
		name 	=>'fecha_reintegro',
		id  	=>'fecha_reintegro',
		type 	=>'text',
		required=>'yes',
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))
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
			table	=>array('liquidacion_vacaciones'),
			type	=>array('column'))
		
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
		 	table =>array('liquidacion_vacaciones'),
		 	type =>array('column'))
   );
	
	$this -> Campos[si_empleado] = array(
		name	=>'si_empleado',
		id		=>'si_empleado',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(array(value=>'1',text=>'UNO',selected=>'ALL'),array(value=>'ALL',text=>'TODOS',selected=>'ALL')),
		selected=>0,
		required=>'yes',
		onchange=>'Empleado_si()'
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
		options => array(array(value => 'CL', text => 'DESPRENDIBLE LIQUIDACION'),  array(value => 'DC', text => 'DOCUMENTO CONTABLE')),
		selected=>'C',
		//required=>'yes',
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
	 
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'VacacionOnReset()'
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
		size	=>'85',
		placeholder =>'Por favor digite el numero de identificación o el nombre',
		suggest=>array(
			name	=>'liquidacion_vacaciones',
			setId	=>'liquidacion_vacaciones_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$Vacacion = new Vacacion();

?>