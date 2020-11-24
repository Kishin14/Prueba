<?php
require_once("../../../framework/clases/ControlerClass.php");
  
final class Novedad extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("NovedadLayoutClass.php");
	require_once("NovedadModelClass.php");

	$Layout              = new NovedadLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new NovedadModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));     
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	//// LISTAS MENU ////
	$Layout -> SetTipoConcepto  ($Model -> GetTipoConcepto($this -> getConex()));
	$Layout -> SetTipoDocumento ($Model -> GetTipoDocumento($this -> getConex()));
	$Layout -> SetSi_Pro		($Model -> GetSi_Pro($this -> getConex()));	
	$novedad_fija_id = $_REQUEST['novedad_fija_id'];

	if($novedad_fija_id>0){

		$Layout -> setNovedadFrame($novedad_fija_id);

	}


	//// GRID ////
	$Attributes = array(
	  id		=>'novedad',
	  title		=>'Listado de Tipos de Novedades',
	  sortname	=>'novedad_fija_id',
	  width		=>'auto',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'novedad_fija_id',		index=>'novedad_fija_id',	sorttype=>'text',	width=>'60',	align=>'center'),
		array(name=>'fecha_novedad',		index=>'fecha_novedad',		sorttype=>'text',	width=>'110',	align=>'center'),
	  	array(name=>'contrato',				index=>'contrato',			sorttype=>'text',	width=>'120',	align=>'center'),		
		array(name=>'tipo_novedad',			index=>'tipo_novedad',		sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'naturaleza',			index=>'naturaleza',		sorttype=>'text',	width=>'100',	align=>'center'),		
		array(name=>'concepto',				index=>'concepto',			sorttype=>'text',	width=>'180',	align=>'center'),
	  	array(name=>'fecha_inicial',		index=>'fecha_inicial',		sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'fecha_final',			index=>'fecha_final',		sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'valor',				index=>'valor',				sorttype=>'text',	width=>'80',	align=>'right',  format => 'currency'),
	  	array(name=>'cuotas',				index=>'cuotas',			sorttype=>'text',	width=>'80',	align=>'center'),
	  	array(name=>'valor_cuota',			index=>'valor_cuota',		sorttype=>'text',	width=>'90',	align=>'right',  format => 'currency'),		
	  	array(name=>'periodicidad',			index=>'periodicidad',		sorttype=>'text',	width=>'120',	align=>'center'),
	  	array(name=>'beneficiario',			index=>'beneficiario',		sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'doc_contable',			index=>'doc_contable',		sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'estado',				index=>'estado',			sorttype=>'text',	width=>'120',	align=>'center')
	);
	  
    $Titles = array('CODIGO',
					'FECHA NOVEDAD',
					'CONTRATO',					
					'TIPO NOVEDAD',
					'NATURALEZA',
    				'CONCEPTO',
    				'FECHA INICIAL',
    				'FECHA FINAL',
    				'VALOR',
    				'CUOTAS',
    				'VALOR CUOTA',					
					'PERIODICIDAD',
					'BENEFICIARIO',
					'DOC CONTABLE',
					'ESTADO'
	);
	
	$Layout -> SetGridNovedad($Attributes,$Titles,$Cols,$Model -> GetQueryNovedadGrid());
	$Layout -> RenderMain();

  }
  
  protected function showGrid(){
	  
	require_once("NovedadLayoutClass.php");
	require_once("NovedadModelClass.php");

	$Layout              = new NovedadLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new NovedadModel();	
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'novedad',
		title		=>'Listado de Tipos de Novedades',
		sortname	=>'novedad_fija_id',
		width		=>'auto',
		height	=>'200'
	  );
  
	  $Cols = array(
		  array(name=>'novedad_fija_id',		index=>'novedad_fija_id',	sorttype=>'text',	width=>'60',	align=>'center'),
		  array(name=>'fecha_novedad',		index=>'fecha_novedad',		sorttype=>'text',	width=>'110',	align=>'center'),
			array(name=>'contrato',				index=>'contrato',			sorttype=>'text',	width=>'120',	align=>'center'),		
		  array(name=>'tipo_novedad',			index=>'tipo_novedad',		sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'naturaleza',			index=>'naturaleza',		sorttype=>'text',	width=>'100',	align=>'center'),		
		  array(name=>'concepto',				index=>'concepto',			sorttype=>'text',	width=>'180',	align=>'center'),
			array(name=>'fecha_inicial',		index=>'fecha_inicial',		sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'fecha_final',			index=>'fecha_final',		sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'valor',				index=>'valor',				sorttype=>'text',	width=>'80',	align=>'right',  format => 'currency'),
			array(name=>'cuotas',				index=>'cuotas',			sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'valor_cuota',			index=>'valor_cuota',		sorttype=>'text',	width=>'90',	align=>'right',  format => 'currency'),		
			array(name=>'periodicidad',			index=>'periodicidad',		sorttype=>'text',	width=>'120',	align=>'center'),
			array(name=>'beneficiario',			index=>'beneficiario',		sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'doc_contable',			index=>'doc_contable',		sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'estado',				index=>'estado',			sorttype=>'text',	width=>'120',	align=>'center')
	  );
		
	  $Titles = array('CODIGO',
					  'FECHA NOVEDAD',
					  'CONTRATO',					
					  'TIPO NOVEDAD',
					  'NATURALEZA',
					  'CONCEPTO',
					  'FECHA INICIAL',
					  'FECHA FINAL',
					  'VALOR',
					  'CUOTAS',
					  'VALOR CUOTA',					
					  'PERIODICIDAD',
					  'BENEFICIARIO',
					  'DOC CONTABLE',
					  'ESTADO'
	  );
	  
	 $html =  $Layout -> SetGridNovedad($Attributes,$Titles,$Cols,$Model -> GetQueryNovedadGrid());
	 
	 print $html;
	  
  }

	protected function validarFechas(){

		require_once("NovedadModelClass.php");

		$Model = new NovedadModel();

		$fecha_inicial  = $_REQUEST['fecha_inicial']; 
		$fecha_final   	= $_REQUEST['fecha_final']; 
		$contrato   	= $_REQUEST['contrato']; 

		$Data  = $Model -> validarFechas($fecha_inicial,$fecha_final,$contrato,$this -> getConex());

		echo json_encode($Data);
		
	}
			
	protected function setDataConcepto(){
		require_once("NovedadModelClass.php");
		$Model = new NovedadModel();
		$Data                  = array();
		$concepto_area_id   		= $_REQUEST['concepto_area_id']; 
		$Data  = $Model -> selectDataConcepto($concepto_area_id,$this -> getConex());
		echo json_encode($Data);
	}

  //BUSQUEDA
  protected function onclickFind(){
	require_once("NovedadModelClass.php");
    $Model = new NovedadModel();
	
    $Data          		= array();
	$novedad_fija_id 	= $_REQUEST['novedad_fija_id'];
	 
	if(is_numeric($novedad_fija_id)){
	  
	  $Data  = $Model -> selectDatosNovedadId($novedad_fija_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
	  
  protected function onclickSave(){	  

  	require_once("NovedadModelClass.php");
    $Model = new NovedadModel();
	$concepto_area_id	= $_REQUEST['concepto_area_id'];
	$contrato_id	= $_REQUEST['contrato_id'];
	$si_empleado	= $_REQUEST['si_empleado'];
	$Data  = $Model -> selectDataConcepto($concepto_area_id,$this -> getConex());
	$proveedor  = $Model -> selectDataProveedor($contrato_id,$this -> getConex());
	
	if($si_empleado=='ALL' && $Data['contabiliza']=='SI' ){
		exit('No se puede Aplicar esta Novedad a Todos los Empleados en un solo proceso, <br>esto debido a que el Tipo de Novedad Genera una Causacion en Proveedores por cada Registro.');				
	}
	
	if(!is_numeric($proveedor) && $Data['contabiliza']=='SI' ){
		exit('El Empleado debe de Crearse primero como proveedor');				
	}


	$result = $Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('false');
	}else{
		$encabezado = $Model -> GetEnca($result[0]['novedad_fija_id'],$this -> getConex());
		if($Data['contabiliza']=='SI' && !is_numeric($encabezado[0]['encabezado_registro_id'])){
			
			if($encabezado[0]['naturaleza_partida']=='C'){
				$debito_part=0;
				$credito_part=$encabezado[0]['valor'];
			}else{
				$debito_part=$encabezado[0]['valor'];
				$credito_part=0;
			}
			if($encabezado[0]['naturaleza_contra']=='C'){
				$debito_contra=0;
				$credito_contra=$encabezado[0]['valor'];
			}else{
				$debito_contra=$encabezado[0]['valor'];
				$credito_contra=0;
			}
			$consecutivo = $Model -> SaveContab($result[0]['novedad_fija_id'],$encabezado,$debito_part,$credito_part,$debito_contra,$credito_contra,$this -> getUsuarioId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getEmpresaId(),$this -> getConex());	
			if(is_numeric($consecutivo)){ $result[0]['consecutivo']=$consecutivo; }else{ $result[0]['consecutivo']=''; }		
		}elseif($Data['contabiliza']=='SI' && is_numeric($encabezado[0]['encabezado_registro_id'])){
			exit('Ya esta contabilizado El registro');
		}

       	$this -> getArrayJSON($result);
	}
	
  }

  protected function onclickUpdate(){

  	require_once("NovedadModelClass.php");	    
    $Model = new NovedadModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente la Novedad');
	 }		
		
  }
	  
  protected function onclickDelete(){

  	require_once("NovedadModelClass.php");	    
    $Model = new NovedadModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente la Novedad');
	 }		
		
  }

	protected function onclickPrint(){

		require_once("Imp_NovedadClass.php");
		$print = new Imp_Novedad($this -> getEmpresaId(),$this -> getConex());
		$print -> printOut();
  
	}


  protected function setCampos(){
  
	$this -> Campos[novedad_fija_id] = array(
		name	=>'novedad_fija_id',
		id		=>'novedad_fija_id',
		type	=>'text',
		Boostrap =>'si',
		disabled=>'yes',
		size	=>'8',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('novedad_fija'),
			type	=>array('primary_key'))
	);

	$this -> Campos[concepto] = array(
		name	=>'concepto',
		id		=>'concepto',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size	=>'50',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('novedad_fija'),
			type	=>array('column'))
	);

   $this -> Campos[fecha_novedad] = array(
		name 	=>'fecha_novedad',
		id  	=>'fecha_novedad',
		type 	=>'text',
		required=>'yes',
		size	=>'10',		
		disabled=>'yes',
		value=>date('Y-m-d'),
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('novedad_fija'),
			type =>array('column'))
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
			table =>array('novedad_fija'),
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
			table =>array('novedad_fija'),
			type =>array('column'))
   );

	$this -> Campos[cuotas] = array(
		name	=>'cuotas',
		id		=>'cuotas',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size	=>'10',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('novedad_fija'),
			type	=>array('column'))
		
	);

	$this -> Campos[valor] = array(
		name	=>'valor',
		id		=>'valor',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size	=>'10',		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('novedad_fija'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[valor_cuota] = array(
		name	=>'valor_cuota',
		id		=>'valor_cuota',
		type	=>'text',
		required=>'yes',
		Boostrap =>'si',
		disabled=>'yes',
		readonly=>'yes',
		size	=>'10',		
		//readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('novedad_fija'),
			type	=>array('column'))
		
	);	
	
	$this -> Campos[periodicidad] = array(
		name =>'periodicidad',
		id  =>'periodicidad',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>'S',text=>'SEMANA'),array(value=>'Q',text=>'QUINCENAL'),array(value=>'M',text=>'2 QUINCENAS',selected=>'M'),array(value=>'Q1',text=>'1era QUINCENA'),array(value=>'Q2',text=>'2da QUINCENA')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('novedad_fija'),
		 	type =>array('column'))
   );

	$this -> Campos[tipo_novedad] = array(
		name =>'tipo_novedad',
		id  =>'tipo_novedad',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>'V',text=>'DEVENGADO',selected=>'V'),array(value=>'D',text=>'DEDUCIDO')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('novedad_fija'),
		 	type =>array('column'))
   );
	
	$this -> Campos[si_empleado] = array(
		name	=>'si_empleado',
		id		=>'si_empleado',
		Boostrap =>'si',
		type	=>'select',
		options	=>null,
		selected=>1,
		required=>'yes',
		onchange=>'Empleado_si();'
	);

  $this -> Campos[contrato_id] = array(
	   name =>'contrato_id',
	   id =>'contrato_hidden',
	   type =>'hidden',
	   required=>'yes',
	   datatype=>array(type=>'integer'),
	   transaction=>array(
			table =>array('novedad_fija'),
			type =>array('column'))
  );

   $this -> Campos[contrato] = array(
	   name =>'contrato',
	   id =>'contrato',
	   type =>'text',
	   Boostrap =>'si',
		size    =>'30',
	   suggest => array(
			name =>'contrato_laboral',
			setId =>'contrato_hidden')
  );

  $this -> Campos[tercero_id] = array(
	   name =>'tercero_id',
	   id =>'tercero_hidden',
	   type =>'hidden',
	   required=>'yes',
	   datatype=>array(type=>'integer'),
	   transaction=>array(
			table =>array('novedad_fija'),
			type =>array('column'))
  );

   $this -> Campos[tercero] = array(
	   name =>'tercero',
	   id =>'tercero',
	   type =>'text',
	   Boostrap =>'si',
		size    =>'30',
	   suggest => array(
			name =>'tercero',
			setId =>'tercero_hidden')
  );


	$this -> Campos[concepto_area_id] = array(
	  name =>'concepto_area_id',
	  id  =>'concepto_area_id',
	  type =>'select',
	  Boostrap =>'si',
	  options =>array(),
	  required=>'yes',
	  //tabindex=>'1',
	   datatype=>array(
	   		type =>'integer'),
	  transaction=>array(
	   		table =>array('novedad_fija'),
	   		type =>array('column'))
	 );

	$this -> Campos[tipo_documento_id] = array(
	  name =>'tipo_documento_id',
	  id  =>'tipo_documento_id',
	  type =>'select',
	  Boostrap =>'si',
	  options =>array(),
	  //required=>'yes',
	  //tabindex=>'1',
	   datatype=>array(
	   		type =>'integer'),
	  transaction=>array(
	   		table =>array('novedad_fija'),
	   		type =>array('column'))
	 );
		
	$this -> Campos[estado] = array(
		name =>'estado',
		id  =>'estado',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO'),array(value=>'P',text=>'PROCESADO')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('novedad_fija'),
		 	type =>array('column'))
   );


	$this -> Campos[documento_anexo] = array(
		name	=>'documento_anexo',
		id		=>'documento_anexo',
		type	=>'file',
		value	=>'',
		path	=>'/application/imagenes/nomina/novedad/',
		size	=>'70',		
		datatype=>array(
			type	=>'file'),
		transaction=>array(
			table	=>array('novedad_fija'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'novedad_fija_id',
			text	=>'_novedad_anexo')
	);

	  $this -> Campos[encabezado_registro_id] = array(
		   name =>'encabezado_registro_id',
		   id =>'encabezado_registro_id',
		   type =>'hidden',
		   datatype=>array(type=>'integer'),
		   transaction=>array(
				table =>array('novedad_fija'),
				type =>array('column'))
	  );

	  $this -> Campos[factura_proveedor_id] = array(
		   name =>'factura_proveedor_id',
		   id =>'factura_proveedor_id',
		   type =>'hidden',
		   datatype=>array(type=>'integer'),
		   transaction=>array(
				table =>array('novedad_fija'),
				type =>array('column'))
	  );

	  $this -> Campos[doc_contable] = array(
		   name =>'doc_contable',
		   id =>'doc_contable',
		   Boostrap =>'si',
		   type =>'text',
		   disabled=>'yes',
		   datatype=>array(type=>'text')
	  );

	  $this -> Campos[liquidacion_final] = array(
		name =>'liquidacion_final',
		id  =>'liquidacion_final',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>0,text=>'NO',selected=>0),array(value=>1,text=>'SI')),
		required=>'yes',
		datatype=>array(
			type =>'integer'),
		transaction=>array(
		 	table =>array('novedad_fija'),
		 	type =>array('column'))
   );

	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'NovedadOnSave')
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'NovedadOnUpdate')
	);

	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id	   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
			displayoptions => array(
				  beforeprint => 'beforePrint',
				  form        => 0,
		  title       => 'Impresion Novedad',
		  width       => '700',
		  height      => '600'
		)

	);	

   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'NovedadOnReset(this.form)'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		suggest=>array(
			name	=>'novedad_nomina',
			setId	=>'novedad_fija_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	$this -> Campos[busqueda_novedad] = array(
		name	=>'busqueda_novedad',
		id		=>'busqueda_novedad',
		type	=>'text',
		Boostrap =>'si',
		size	=>'85',
		suggest=>array(
			name	=>'novedad_nomina_novedad',
			setId	=>'novedad_fija_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}

$Novedad = new Novedad();
?>