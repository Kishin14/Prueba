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
	$Layout -> setAnular     	($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));
	$Layout -> setImprimir	($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
	$Layout -> SetCampos($this -> Campos);
	
	$Layout ->  setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
	
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
	
	$fecha_registro = date("Y-m-d H:i:s");
	$usuario_id = $this -> getUsuarioId();
	
	$return = $Model -> Save($this -> Campos,$usuario_id,$fecha_registro,$this -> getOficinaId(),$this -> getConex());
	
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
	$valor 			= $_REQUEST['valor'];
	$si_empleado 	= $_REQUEST['si_empleado'];

	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();	
	
	$con_fecha = date("Y-m-d H:i:s");
	
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	
    if($mesContable && $periodoContable){
		$return=$Model -> getContabilizarReg($liquidacion_vacaciones_id,$empresa_id,$oficina_id,$usuario_id,$con_fecha,$mesContable,$periodoContable,$valor,$si_empleado,$this -> getConex());
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

   protected function CalcularLiqTodos($Conex){
	  
	require_once("VacacionModelClass.php");
    $Model = new VacacionModel();
	
	$data = $Model -> getCalcularLiqTodos($this -> getConex());

	if(strlen($Model -> GetError()) > 0){
	   exit('Error al realizar calculo');
	 }else{
	    $this -> getArrayJSON($data);
	  }
	
   }

     protected function onclickCancellation(){
  
     require_once("VacacionModelClass.php");
	 
     $Model                 = new VacacionModel(); 
	 $liquidacion_vacaciones_id         = $this -> requestDataForQuery('liquidacion_vacaciones_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();
	
	 $estado=$Model -> comprobar_estado($liquidacion_vacaciones_id,$this -> getConex());
	 
	 if($estado[0]['estado']=='I'){
		 exit('No se puede Anular, La Liquidaci&oacute;n previamente estaba Anulada');

	 }else if($estado[0]['estado']=='C' && $estado[0]['estado_mes']==0){
		 
		 exit('No se puede Anular, El mes contable de la Liquidaci&oacute;n esta Cerrado');
		 
	 }else if($estado[0]['estado']=='C' && $estado[0]['estado_periodo']==0){
		 
		 exit('No se puede Anular, El periodo contable de la Liquidaci&oacute;n esta Cerrado');

	 }
	 if($estado[0]['si_empleado']=='1'){
		 $Model -> cancellation($liquidacion_vacaciones_id,$estado[0]['encabezado_registro_id'],$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
	 }elseif($estado[0]['si_empleado']=='ALL'){
		 $Model -> cancellation1($liquidacion_vacaciones_id,$estado[0]['encabezado_registro_id'],$estado[0]['fecha_liquidacion'],$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());		 
	 }
	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }
	
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
		size    =>'35',
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

	$this -> Campos[valor_pagos] = array(
		name	=>'valor_pagos',
		id		=>'valor_pagos',
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

	$this -> Campos[valor_total] = array(
		name	=>'valor_total',
		id		=>'valor_total',
		type	=>'hidden',
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
		size	=>50,
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
		readonly=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))	
	);

	$this -> Campos[dias_disfrutar] = array(
		name	=>'dias_disfrutar',
		id		=>'dias_disfrutar',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))	
	);

	$this -> Campos[dias_disfrutar_real] = array(
		name	=>'dias_disfrutar_real',
		id		=>'dias_disfrutar_real',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))	
	);

	$this -> Campos[dias_pagados] = array(
		name	=>'dias_pagados',
		id		=>'dias_pagados',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
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
		size	=>50,
		
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
		options	=>array(array(value=>'1',text=>'UNO'),array(value=>'ALL',text=>'TODOS')),
		selected=>1,
		required=>'yes',
		onchange=>'Empleado_si()',
		transaction=>array(
		 	table =>array('liquidacion_vacaciones'),
		 	type =>array('column'))
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
	
		$this -> Campos[usuario_id] = array(
		name 	=>'usuario_id',
		id  	=>'usuario_id',
		type 	=>'hidden',
		//required=>'yes',
		datatype=>array(
			type =>'integer',
			length =>'11'),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))
	);

	$this -> Campos[fecha_registro] = array(
		name 	=>'fecha_registro',
		id  	=>'fecha_registro',
		type 	=>'hidden',
		//required=>'yes',
		datatype=>array(
			type =>'text',
			length =>date('Y-m-d H:i:s')),
		transaction=>array(
			table =>array('liquidacion_vacaciones'),
			type =>array('column'))
	);

	//ANULACION
  	$this -> Campos[usuario_anulo_id] = array(
	   	name =>'usuario_anulo_id',
	   	id =>'usuario_anulo_id',
	   	type =>'hidden',
	   	//required=>'yes',
	   	datatype=>array(
			type=>'integer')
  	);

  	$this -> Campos[fecha_anulacion] = array(
	   	name =>'fecha_anulacion',
	   	id =>'fecha_anulacion',
	   	type =>'hidden',
	   	//required=>'yes',
	   	datatype=>array(
			type=>'text')
  	);

  	$this -> Campos[observacion_anulacion] = array(
	   	name =>'observacion_anulacion',
	   	id =>'observacion_anulacion',
	   	type =>'textarea',
	   	required=>'yes',
	   	datatype=>array(
			type=>'tex')
  	);

	$this -> Campos[causal_anulacion_id] = array(
		name =>'causal_anulacion_id',
		id  =>'causal_anulacion_id',
		type =>'select',
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2')
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

	  	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		disabled=>'disabled',
		onclick =>'onclickCancellation(this.form)'
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