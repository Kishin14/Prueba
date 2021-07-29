<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Pago extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("PagoLayoutClass.php");
	require_once("PagoModelClass.php");
	
	$Layout   = new PagoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PagoModel();
	

	$empresa_id = $this -> getEmpresaId();
	$oficina_id = $this -> getOficinaId();	

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetTiposPago($Model -> GetTipoPago($this -> getConex()));
	$Layout -> SetDocumento($Model -> GetDocumento($this -> getConex()));
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));


	//// GRID ////
	$Attributes = array(
	  id		=>'pago',
	  title		=>'Listado de Pagos',
	  sortname	=>'fecha',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	  array(name=>'fecha',						index=>'fecha',						sorttype=>'date',	width=>'100',	align=>'left'),
	  array(name=>'ingreso_abono_nomina',		index=>'ingreso_abono_nomina',		sorttype=>'date',	width=>'120',	align=>'left'),
	  array(name=>'tipo_doc',					index=>'tipo_doc',					sorttype=>'text',	width=>'120',	align=>'left'),
	  array(name=>'num_ref',					index=>'num_ref',					sorttype=>'text',	width=>'90',	align=>'left'),	 
	  array(name=>'aplica',						index=>'aplica',					sorttype=>'text',	width=>'90',	align=>'left'),	 
	  array(name=>'empleado',					index=>'empleado',					sorttype=>'text',	width=>'140',	align=>'left'),
	  array(name=>'forma_pago',					index=>'forma_pago',				sorttype=>'text',	width=>'140',	align=>'left'),
	  array(name=>'concepto_abono_nomina',		index=>'concepto_abono_nomina',	sorttype=>'text',	width=>'200',	align=>'left'),
	  array(name=>'valor_abono_nomina',		index=>'valor_abono_nomina',		sorttype=>'text',	width=>'100',	align=>'center', format => 'currency'),
	  array(name=>'estado_abono_nomina',		index=>'estado_abono_nomina',		sorttype=>'text',	width=>'100',	align=>'left')	  
	);
	  
    $Titles = array('FECHA PAGO',
					'FECHA INGRESO',
					'DOCUMENTO',
					'No',
					'APLICA',
					'EMPLEADO',
					'FORMA PAGO',					
					'CONCEPTO',
					'VALOR',
					'ESTADO'
	);
	
	$Layout -> SetGridPago($Attributes,$Titles,$Cols,$Model -> GetQueryPagoGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

	require_once("PagoModelClass.php");
	$Model = new PagoModel();
	$empresa_id = $this -> getEmpresaId();
	$return = $Model -> Save($empresa_id,$this -> getOficinaId(),$this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
		if(is_numeric($return)){
			exit("$return");
	  	}else{
	  		exit('false');
		}
	}
  }

  protected function onclickUpdate(){
 
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Pago');
	  }
	
  }

  protected function onclickCancellation(){
  
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$Model -> cancellation($this -> getConex());
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }

  protected function onclickPrint(){
  
    require_once("Imp_Documento1Class.php");

    $print = new Imp_Documento($this -> getConex());

    $print -> printOut();
  
  }
  

//BUSQUEDA
  protected function onclickFind(){
	
	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	
    $Data                	 	= array();
	$abono_nomina_id = $_REQUEST['abono_nomina_id'];
	 
	if(is_numeric($abono_nomina_id)){
	  
	  $Data  = $Model -> selectDatosPagoId($abono_nomina_id,$this -> getConex());
	  
	} 
    $this -> getArrayJSON($Data);
	
  }

  protected function setDataEmpleado(){

    require_once("PagoModelClass.php");
    $Model = new PagoModel();    
    $empleado_id = $_REQUEST['empleado_id'];
    $data = $Model -> getDataEmpleado($empleado_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  protected function setDataFactura(){

    require_once("PagoModelClass.php");
    $Model = new PagoModel();    
    $abono_nomina_id = $_REQUEST['abono_nomina_id'];
    $data = $Model -> getDataFactura($abono_nomina_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  
  protected function setSolicitud(){
  
	require_once("PagoModelClass.php");
    $Model     = new PagoModel();
    $nomina_id = $_REQUEST['nomina_id'];
	$return = $Model -> SelectSolicitud($nomina_id,$this -> getConex());
	
	if(count($return) > 0){
	  $this -> getArrayJSON($return);	
	}else{
	    exit('false');
	  }
  
  }
  
  protected function getEstadoEncabezadoRegistro($Conex){
	  
  	require_once("PagoModelClass.php");
    $Model           = new PagoModel();
	$abono_nomina_id = $_REQUEST['abono_nomina_id'];	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($abono_nomina_id,$this -> getConex());
	exit("$Estado");
	  
  } 
  

  protected function getTotalDebitoCredito(){
	  
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$abono_nomina_id = $_REQUEST['abono_nomina_id'];
	$data = $Model -> getTotalDebitoCredito($abono_nomina_id,$this -> getConex());
	print json_encode($data);  
	  
  }
  protected function getContabilizar(){
	
  	require_once("PagoModelClass.php");
    $Model = new PagoModel();
	$abono_nomina_id	= $_REQUEST['abono_nomina_id'];
	$ingreso_abono_nomina 		= $_REQUEST['ingreso_abono_nomina'];
	$empresa_id = $this -> getEmpresaId();  
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();


	$return=$Model -> getContabilizarReg($abono_nomina_id,$empresa_id,$oficina_id,$usuario_id,$this -> getConex());
	if($return==true){
		exit("true");
	}else{
		exit("Error : ".$Model -> GetError());
	}	
		
  }


  protected function SetCampos(){
  
    /********************
	  Campos causar
	********************/
	
	$this -> Campos[abono_nomina_id] = array(
		name	=>'abono_nomina_id',
		id		=>'abono_nomina_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('primary_key'))
	);

	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden'

	);

	$this -> Campos[numero_soporte] = array(
		name	=>'numero_soporte',
		id		=>'numero_soporte',
		Boostrap =>'si',
		type	=>'text',
		readonly=>'yes'
	);

	$this -> Campos[empleados] = array(
		name =>'empleados',
		id  =>'empleados',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>'U',text=>'UNO',selected=>'U'),array(value=>'T',text=>'TODOS')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
		
   );


	$this -> Campos[empleado_id] = array(
		name	=>'empleado_id',
		id		=>'empleado_id',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))		
	);
	  
	$this -> Campos[empleado] = array(
		name	=>'empleado',
		id		=>'empleado',
		Boostrap =>'si',
		type	=>'text',
		size	=>45,
		suggest=>array(
			name	=>'empleado',
			setId	=>'empleado_id',
			onclick => 'setDataEmpleado')
	);

	$this -> Campos[empleado_nit] = array(
		name	=>'empleado_nit',
		id		=>'empleado_nit',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20')
	);

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')		
	);

	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')		
	);

	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))		
	);

	$this -> Campos[num_cheque] = array(
		name	=>'num_cheque',
		id		=>'num_cheque',
		type	=>'text',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'50')
	);

	$this -> Campos[valor_abono_nomina] = array(
		name	=>'valor_abono_nomina',
		id		=>'valor_abono_nomina',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20',
			presicion=>3),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))		
		
	);
	$this -> Campos[valor_abono_primas] = array(
		name	=>'valor_abono_primas',
		id		=>'valor_abono_primas',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20',
			presicion=>3),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))		
		
	);
	$this -> Campos[valor_abono_cesantias] = array(
		name	=>'valor_abono_cesantias',
		id		=>'valor_abono_cesantias',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20',
			presicion=>3),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))		
		
	);
	$this -> Campos[valor_abono_vacaciones] = array(
		name	=>'valor_abono_vacaciones',
		id		=>'valor_abono_vacaciones',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20',
			presicion=>3),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))		
		
	);
	
	$this -> Campos[valor_abono_int_cesantias] = array(
		name	=>'valor_abono_int_cesantias',
		id		=>'valor_abono_int_cesantias',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20',
			presicion=>3),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))		
		
	);
	
	$this -> Campos[valor_abono_total] = array(
		name	=>'valor_abono_total',
		id		=>'valor_abono_total',
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);


	$this -> Campos[cuenta_tipo_pago_id] = array(
		name	=>'cuenta_tipo_pago_id',
		id		=>'cuenta_tipo_pago_id',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
		
	);
	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
		
	);

	$this -> Campos[concepto_abono_nomina] = array(
		name	=>'concepto_abono_nomina',
		id		=>'concepto_abono_nomina',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
		required=>'yes',
		size    => '48',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column')),
		onclick =>'cargardiv()'
	);
	$this -> Campos[valores_abono_nomina] = array(
		name	=>'valores_abono_nomina',
		id		=>'valores_abono_nomina',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	$this -> Campos[valores_abono_primas] = array(
		name	=>'valores_abono_primas',
		id		=>'valores_abono_primas',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	$this -> Campos[valores_abono_cesantias] = array(
		name	=>'valores_abono_cesantias',
		id		=>'valores_abono_cesantias',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	$this -> Campos[valores_abono_vacaciones] = array(
		name	=>'valores_abono_vacaciones',
		id		=>'valores_abono_vacaciones',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	
	$this -> Campos[valores_abono_int_cesantias] = array(
		name	=>'valores_abono_int_cesantias',
		id		=>'valores_abono_int_cesantias',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	
	$this -> Campos[causaciones_abono_nomina] = array(
		name	=>'causaciones_abono_nomina',
		id		=>'causaciones_abono_nomina',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	
	$this -> Campos[causaciones_abono_primas] = array(
		name	=>'causaciones_abono_primas',
		id		=>'causaciones_abono_primas',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	$this -> Campos[causaciones_abono_cesantias] = array(
		name	=>'causaciones_abono_cesantias',
		id		=>'causaciones_abono_cesantias',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	
	$this -> Campos[causaciones_abono_vacaciones] = array(
		name	=>'causaciones_abono_vacaciones',
		id		=>'causaciones_abono_vacaciones',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	
	$this -> Campos[causaciones_abono_int_cesantias] = array(
		name	=>'causaciones_abono_int_cesantias',
		id		=>'causaciones_abono_int_cesantias',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);

	$this -> Campos[causaciones_abono_liq] = array(
		name	=>'causaciones_abono_liq',
		id		=>'causaciones_abono_liq',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);

	$this -> Campos[valores_abono_liq] = array(
		name	=>'valores_abono_liq',
		id		=>'valores_abono_liq',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);

	$this -> Campos[valor_abono_liq] = array(
		name	=>'valor_abono_liq',
		id		=>'valor_abono_liq',
		type	=>'text',
		Boostrap =>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20',
			presicion=>3),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))		
		
	);


	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	
	$this -> Campos[ingreso_abono_nomina] = array(
		name	=>'ingreso_abono_nomina',
		id		=>'ingreso_abono_nomina',
		type	=>'hidden',
		value	=>date("Y-m-d h:m.s"),
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[estado_abono_nomina] = array(
		name	=>'estado_abono_nomina',
		id		=>'estado_abono_nomina',
		type	=>'select',
		Boostrap =>'si',
		disabled=>'yes',
		options => array(array(value => 'A', text => 'EDICION'),array(value => 'I', text => 'ANULADA'),array(value => 'C', text => 'CONTABILIZADA')),
		selected=>'A',		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('abono_nomina'),
			type	=>array('column'))
		
	);


	/*****************************************
	        Campos Anulacion Registro
	*****************************************/
	

	$this -> Campos[anul_usuario_id] = array(
		name	=>'anul_usuario_id',
		id		=>'anul_usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer')
	);		

	$this -> Campos[anul_abono_nomina] = array(
		name	=>'anul_abono_nomina',
		id		=>'anul_abono_nomina',
		type	=>'text',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text')
	);	
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer')
	);		
	
	
	$this -> Campos[desc_anul_abono_nomina] = array(
		name	=>'desc_anul_abono_nomina',
		id		=>'desc_anul_abono_nomina',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text')
	);	

	$this -> Campos[oficina_anul] = array(
		name	=>'oficina_anul',
		id		=>'oficina_anul',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
	);

	


	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'

	);
   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		tabindex=>'14',
		onclick =>'onclickCancellation(this.form)'
	);	
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'PagoOnReset()'
	);
	 
   	$this -> Campos[contabilizar] = array(
		name	=>'contabilizar',
		id		=>'contabilizar',
		type	=>'button',
		value	=>'Contabilizar',
		onclick =>'OnclickContabilizar()'
	);		


    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
	disabled=>'disabled',
    value   =>'Imprimir',
	id_prin =>'encabezado_registro_id',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Documento Contable',
      width       => '800',
      height      => '600'
    )

    );

   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap =>'si',
		size	=>'85',
		placeholder =>'Por favor digite el consecutivo o la fecha',
		//tabindex=>'1',
		suggest=>array(
			name	=>'pago_nomina',
			setId	=>'abono_nomina_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$abono_nomina_id  = new Pago();

?>