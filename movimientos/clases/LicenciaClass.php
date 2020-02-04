<?php
require_once("../../../framework/clases/ControlerClass.php");
  
final class Licencia extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("LicenciaLayoutClass.php");
	require_once("LicenciaModelClass.php");

	$Layout              = new LicenciaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new LicenciaModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));     
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	//// LISTAS MENU ////
	$Layout -> SetTipoConcepto  ($Model -> GetTipoConcepto($this -> getConex()));
	$licencia_id = $_REQUEST['licencia_id'];

	if($licencia_id>0){

		$Layout -> setLicenciaFrame($licencia_id);

	}


	//// GRID ////
	$Attributes = array(
	  id		=>'licencia',
	  title		=>'Listado de Licencias',
	  sortname	=>'licencia_id',
	  width		=>'auto',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'licencia_id',			index=>'licencia_id',		sorttype=>'text',	width=>'60',	align=>'center'),
		array(name=>'fecha_licencia',		index=>'fecha_licencia',	sorttype=>'text',	width=>'110',	align=>'center'),
	  	array(name=>'contrato',				index=>'contrato',			sorttype=>'text',	width=>'120',	align=>'center'),		
		array(name=>'concepto',				index=>'concepto',			sorttype=>'text',	width=>'180',	align=>'center'),
	  	array(name=>'diagnostico',			index=>'diagnostico',		sorttype=>'text',	width=>'180',	align=>'center'),
	  	array(name=>'fecha_inicial',		index=>'fecha_inicial',		sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'fecha_final',			index=>'fecha_final',		sorttype=>'text',	width=>'100',	align=>'center'),
	  	array(name=>'estado',				index=>'estado',			sorttype=>'text',	width=>'120',	align=>'center')
	);
	  
    $Titles = array('CODIGO',
					'FECHA NOVEDAD',
					'CONTRATO',					
    				'CONCEPTO',
					'DIAGNOSTICO',
    				'FECHA INICIAL',
    				'FECHA FINAL',
					'ESTADO'
	);
	
	$Layout -> SetGridLicencia($Attributes,$Titles,$Cols,$Model -> GetQueryLicenciaGrid());
	$Layout -> RenderMain();

  }
		
 	protected function setDiagnostico(){
		require_once("LicenciaModelClass.php");
		$Model = new LicenciaModel();
		$Data                  = array();
		$tipo_incapacidad_id   = $_REQUEST['tipo_incapacidad_id'];
		if(is_numeric($tipo_incapacidad_id)){
			$diagnostico  = $Model -> getDiagnostico($tipo_incapacidad_id,$this -> getConex());
		}
		echo json_encode($diagnostico);
	}
	  
  //BUSQUEDA
	protected function onclickFind(){
		require_once("LicenciaModelClass.php");
		$Model = new LicenciaModel();
		$Data                  = array();
		$licencia_id   = $_REQUEST['licencia_id'];
		if(is_numeric($licencia_id)){
			$Data  = $Model -> selectLicenciaId($licencia_id,$this -> getConex());
		}
		echo json_encode($Data);
	}
	  
  protected function onclickSave(){	  

  	require_once("LicenciaModelClass.php");
    $Model = new LicenciaModel();		
	//validacion si hay licencia previa
	$comprobar_licencia = $Model -> comprobar_licencia($_REQUEST['fecha_inicial'],$_REQUEST['fecha_final'],$_REQUEST['contrato_id'],$this -> getConex());
	
	if(count($comprobar_licencia)>0){ 
		exit('Ya Existe una licencia o incapacidad previamente Ingresada, <br>que se cruza con las fechas que intenta Ingresar.
		 <br>Datos Fecha Inicial:'.$comprobar_licencia[0]['fecha_inicial'].' / Fecha Final:'.$comprobar_licencia[0]['fecha_final']);
	}
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
	}else{
		exit('Se ingreso correctamente La Licencia.');
	}
	
  }

  protected function onclickUpdate(){

  	require_once("LicenciaModelClass.php");	    
    $Model = new LicenciaModel();
	//validacion si hay licencia previa
	$comprobar_licencia = $Model -> comprobar_licencia_val($_REQUEST['fecha_inicial'],$_REQUEST['fecha_final'],$_REQUEST['contrato_id'],$_REQUEST['licencia_id'],$this -> getConex());

	if(count($comprobar_licencia)>0){ 
		exit('Ya Existe una licencia o incapacidad previamente Ingresada, <br>que se cruza con las fechas que intenta Ingresar.
		 <br>Datos Fecha Inicial:'.$comprobar_licencia[0]['fecha_inicial'].' / Fecha Final:'.$comprobar_licencia[0]['fecha_final']);
	}

    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente la Licencia');
	 }		
		
  }
	  
  protected function onclickDelete(){

  	require_once("LicenciaModelClass.php");	    
    $Model = new LicenciaModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente la Licencia');
	 }		
		
  }

	protected function onclickPrint(){

		require_once("Imp_LicenciaClass.php");
		$print = new Imp_Licencia($this -> getEmpresaId(),$this -> getConex());
		$print -> printOut();
  
	}


  protected function setCampos(){
  
	$this -> Campos[licencia_id] = array(
		name	=>'licencia_id',
		id		=>'licencia_id',
		type	=>'text',
		disabled=>'yes',
		size	=>'8',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('licencia'),
			type	=>array('primary_key'))
	);

	$this -> Campos[concepto] = array(
		name	=>'concepto',
		id		=>'concepto',
		type	=>'text',
		required=>'yes',
		size	=>'90',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('licencia'),
			type	=>array('column'))
	);
	
	$this -> Campos[diagnostico] = array(
		name	=>'diagnostico',
		id		=>'diagnostico',
		type	=>'text',
		required=>'yes',
		size	=>'90',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('licencia'),
			type	=>array('column'))
	);

   $this -> Campos[fecha_licencia] = array(
		name 	=>'fecha_licencia',
		id  	=>'fecha_licencia',
		type 	=>'text',
		required=>'yes',
		size	=>'10',		
		disabled=>'yes',
		value=>date('Y-m-d'),
		datatype=>array(
			type =>'date',
			length =>'11'),
		transaction=>array(
			table =>array('licencia'),
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
			table =>array('licencia'),
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
			table =>array('licencia'),
			type =>array('column'))
   );

	
  $this -> Campos[contrato_id] = array(
	   name =>'contrato_id',
	   id =>'contrato_hidden',
	   type =>'hidden',
	   required=>'yes',
	   datatype=>array(type=>'integer'),
	   transaction=>array(
			table =>array('licencia'),
			type =>array('column'))
  );

   $this -> Campos[contrato] = array(
	   name =>'contrato',
	   id =>'contrato',
	   type =>'text',
	   size    =>'30',
	   suggest => array(
			name =>'contrato_laboral',
			setId =>'contrato_hidden')
  );


	$this -> Campos[tipo_incapacidad_id] = array(
	  name =>'tipo_incapacidad_id',
	  id  =>'tipo_incapacidad_id',
	  type =>'select',
	  options =>array(),
	  required=>'yes',
	  //tabindex=>'1',
	   datatype=>array(
	   		type =>'integer'),
	  transaction=>array(
	   		table =>array('licencia'),
	   		type =>array('column'))
	 );
	
	$this -> Campos[dias] = array(
		name =>'dias',
		id  =>'dias',
		type =>'text',
		size=>'5',
//		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
	  transaction=>array(
	   		table =>array('licencia'),
	   		type =>array('column'))
   );

	$this -> Campos[remunerado] = array(
		name =>'remunerado',
		id  =>'remunerado',
		type =>'select',
		options => array(array(value=>'1',text=>'SI',selected=>'1'),array(value=>'0',text=>'NO')),
		required=>'yes',
		datatype=>array(
			type =>'integer',
			length =>'2'),
		transaction=>array(
		 	table =>array('licencia'),
		 	type =>array('column'))
   );
		
	$this -> Campos[estado] = array(
		name =>'estado',
		id  =>'estado',
		type =>'select',
		options => array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('licencia'),
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
		// tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'LicenciaOnUpdate')
	);

	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id	   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
			displayoptions => array(
				  beforeprint => 'beforePrint',
				  form        => 0,
		  title       => 'Impresion Licencia',
		  width       => '700',
		  height      => '600'
		)

	);	

   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'LicenciaOnReset(this.form)'
	);
	 
	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		// tabindex=>'1',
		suggest=>array(
			name	=>'licencia',
			setId	=>'licencia_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}

$licencia_id = new Licencia();
?>