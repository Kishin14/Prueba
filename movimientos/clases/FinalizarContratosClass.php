<?php

require_once("../../../framework/clases/ControlerClass.php");

final class FinalizarContratos extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("FinalizarContratosLayoutClass.php");
	require_once("FinalizarContratosModelClass.php");
	
	$Layout   = new FinalizarContratosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new FinalizarContratosModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

    $Layout -> SetCampos($this -> Campos);
	
	//// LISTAS MENU ////
	$Layout ->  SetMotivoTer        ($Model -> GetMotivoTer($this -> getConex()));
	$Layout ->  SetCausalDes	    ($Model -> GetCausalDes($this -> getConex()));
	$Layout ->  setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));	
	

	//// GRID ////
	$Attributes = array(
	  id		=>'contrato',
	  title		=>'Listado de contratos finalizados no laborales',
	  sortname	=>'numero_contrato',
	  width		=>'auto',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'numero_contrato',		         index=>'liquidacion_definitiva_id',	sorttype=>'text',	width=>'100	',	align=>'center'),
		array(name=>'fecha_inicio',		             index=>'fecha_inicio',	                sorttype=>'date',	width=>'130',	align=>'center'),
		array(name=>'fecha_terminacion',		     index=>'fecha_terminacion',	        sorttype=>'date',	width=>'130',	align=>'center'),
		array(name=>'fecha_terminacion_real',	     index=>'fecha_terminacion_real',		sorttype=>'date',	width=>'130',	align=>'center'),
	  	array(name=>'empleado',						 index=>'empleado',		                sorttype=>'text',	width=>'220',	align=>'center'),
	  	array(name=>'tipo_contrato_id',				 index=>'tipo_contrato_id',		        sorttype=>'text',	width=>'150',	align=>'center'),
	  	array(name=>'cargo_id',					     index=>'cargo_id',		                sorttype=>'text',	width=>'150',	align=>'center'),
	  	array(name=>'motivo_terminacion_id',		 index=>'motivo_terminacion_id',		sorttype=>'text',	width=>'150',	align=>'center'),
	  	array(name=>'estado',					     index=>'estado',		                sorttype=>'text',	width=>'120',	align=>'center')
	  
	);
	  
    $Titles = array('No. CONTRATO',
					'FECHA INICIO',
    				'FECHA TERMINACION',
					'FECHA TERMINACION REAL',
    				'EMPLEADO',
					'TIPO CONTRATO',
					'CARGO',
					'MOTIVO TERMINACION',
					'ESTADO'
	                );
	
	$Layout -> SetGridFinalizarContratos($Attributes,$Titles,$Cols,$Model -> GetQueryFinalizarContratosGrid());

	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("FinalizarContratosModelClass.php");
    $Model = new FinalizarContratosModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  
  protected function onclickUpdate(){
 
  	require_once("FinalizarContratosModelClass.php");
    $Model = new FinalizarContratosModel();

    $Model -> Update($this -> Campos,$this -> getConex(),$this -> getUsuarioId());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('true');
	  }
	
  }


  protected function setDataContrato(){
	require_once("FinalizarContratosModelClass.php");
    $Model = new FinalizarContratosModel();
	
    $Data          		= array();
	$contrato_id 	= $_REQUEST['contrato_id'];
	 
	if(is_numeric($contrato_id)){
	  
	  $Data  = $Model -> selectContrato($contrato_id,$this -> getConex());
	  
	} 
   print json_encode($Data);
	
  }  

  
//BUSQUEDA
  protected function onclickFind(){
	require_once("FinalizarContratosModelClass.php");
    $Model = new FinalizarContratosModel();
	
    $Data          		= array();
	$contrato_id 	    = $_REQUEST['contrato_id'];
	 
	if(is_numeric($contrato_id)){
	  
	  $Data  = $Model -> selectDatosFinalizarContratosId($contrato_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
	
 	$this -> Campos[contrato_id] = array(
	   	name =>'contrato_id',
	   	id =>'contrato_id',
	   	type =>'hidden',
	   	required=>'yes',
	   	datatype=>array(
			type=>'integer'),
	   	transaction=>array(
			table =>array('contrato'),
			type	=>array('primary_key'))
  	);

   	$this -> Campos[contrato] = array(
	   	name =>'contrato',
	   	id =>'contrato',
	   	type =>'text',
			size    =>'30',
	   	suggest => array(
			name =>'finalizar contrato',
			setId =>'contrato_id',
			onclick => 'setDataContrato')
  	);

   $this -> Campos[fecha_inicio] = array(
    	name =>'fecha_inicio',
    	id  =>'fecha_inicio',
    	type =>'text',
    	required=>'yes',
		size=>10,
		disabled=>'yes',
    	datatype=>array(
     		type =>'text',
     		length =>'11'),
    	transaction=>array(
     		table =>array('contrato'),
     		type =>array('column'))
   );

	$this -> Campos[fecha_terminacion] = array(
		name 	=>'fecha_terminacion',
		id  	=>'fecha_terminacion',
		type 	=>'text',
		disabled=>'yes',
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('contrato'),
			type =>array('column'))
   );

	$this -> Campos[fecha_terminacion_real] = array(
		name 	=>'fecha_terminacion_real',
		id  	=>'fecha_terminacion_real',
		type 	=>'text',
		required=>'yes',
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('contrato'),
			type =>array('column'))
   );

	$this -> Campos[motivo_terminacion_id] = array(
	  name =>'motivo_terminacion_id',
	  id  =>'motivo_terminacion_id',
	  type =>'select',
	  options =>array(),
	  required=>'yes',
	  //tabindex=>'1',
	   datatype=>array(
	   		type =>'integer'),
	  transaction=>array(
	   		table =>array('contrato'),
	   		type =>array('column'))
	 );

	$this -> Campos[causal_despido_id] = array(
	  name =>'causal_despido_id',
	  id  =>'causal_despido_id',
	  type =>'select',
	  options =>array(),
	  required=>'yes',
	   datatype=>array(
	   		type =>'integer'),
	  transaction=>array(
	   		table =>array('contrato'),
	   		type =>array('column'))
	 );
		
	$this -> Campos[estado] = array(
		name =>'estado',
		id  =>'estado',
		type =>'select',
		disabled=>'yes',
		options => array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'R',text=>'RETIRADO'),array(value=>'F',text=>'FINALIZADO'),array(value=>'AN',text=>'ANULADO'),array(value=>'L',text=>'LICENCIA')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('contrato'),
		 	type =>array('column'))
   );


	$this -> Campos[usuario_finaliza_id] = array(
		name	=>'usuario_finaliza_id',
		id		=>'usuario_finaliza_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table =>array('contrato'),
			type =>array('column'))		
	);		

	$this -> Campos[fecha_finaliza] = array(
		name	=>'fecha_finaliza',
		id		=>'fecha_finaliza',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'text',
			length	=>'15'),
		transaction=>array(
			table =>array('contrato'),
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

	$this -> Campos[tipo_impresion] = array(
		name	=>'tipo_impresion',
		id	    =>'tipo_impresion',
		type	=>'select',
		options => array(array(value => 'CL', text => 'DESPRENDIBLE LIQUIDACION'),  array(value => 'DC', text => 'DOCUMENTO CONTABLE')),
		selected=>'C',
		required=>'yes',
		datatype=>array(type=>'text')
	);	

  			

	/**********************************
 	             Botones
	**********************************/
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
	);		
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'FinalizarContratosOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'finalizar contrato1',
			setId	=>'contrato_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$FinalizarContratos = new FinalizarContratos();

?>