<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Parametros_documento extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("Parametros_documentoLayoutClass.php");
	require_once("Parametros_documentoModelClass.php");

	
	$Layout   = new Parametros_documentoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new Parametros_documentoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

    $Layout -> SetCampos($this -> Campos);
	
	//LISTA MENU
		$Layout -> SetTip($Model -> GetTip($this -> getConex()));
	

	//// GRID ////
	$Attributes = array(
	  id		=>'tipo_documento_laboral_id',
	  title		=>'Listado Documentos',
	  sortname	=>'nombre_documento',
	  width		=>'600',
	  height	=>'200'
	);

	$Cols = array(
		array(name=>'tipo_documento_laboral_id',		index=>'tipo_documento_laboral_id',		sorttype=>'text',	width=>'50',	align=>'center'),
		array(name=>'nombre_documento',		index=>'nombre_documento',		sorttype=>'text',	width=>'300',	align=>'left')
	);
	  
    $Titles = array('CODIGO',
    				'NOMBRE DOCUMENTO'
	);
	
	$Layout -> SetGridParametroDocumento($Attributes,$Titles,$Cols,$Model -> GetQueryParametroDocumento());
	$Layout -> RenderMain();

  }

  protected function onclickValidateRow(){	
  
	require_once("Parametros_documentoModelClass.php");
    $Model = new Parametros_documentoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){
	  

  	require_once("Parametros_documentoModelClass.php");
    $Model = new Parametros_documentoModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo tipo documento');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("Parametros_documentoModelClass.php");
    $Model = new Parametros_documentoModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el tipo documento');
	  }
	
  }

  protected function onclickDelete(){

	require_once("Parametros_documentoModelClass.php");
	$Model = new Parametros_documentoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
		exit('No se puede borrar el tipo documento');
	}else{
		exit('Se borro exitosamente el tipo documento');
	}
  }
  
    protected function onclickTipo(){

	require_once("Parametros_documentoModelClass.php");
	$Model = new Parametros_documentoModel();
	$tipo_contrato_id = $_REQUEST['tipo_contrato_id'];	
	$tipo = $Model -> Tipo($tipo_contrato_id,$this -> getConex());
	if($tipo > 0 || $tipo != ''){
		exit('true') ;
	}else{
		exit('false');
		}
  }


//BUSQUEDA
  protected function onclickFind(){

	require_once("Parametros_documentoModelClass.php");
    $Model = new Parametros_documentoModel();
	
    $Data          		= array();
	$tipo_documento_laboral_id 	= $_REQUEST['tipo_documento_laboral_id'];
	 
	if(is_numeric($tipo_documento_laboral_id)){
	  
	  $Data  = $Model -> selectDatosParametrosdocumentoId($tipo_documento_laboral_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
		  
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Incapacidad
	********************/
	
	$this -> Campos[tipo_documento_laboral_id] = array(
	name =>'tipo_documento_laboral_id',
	id  =>'tipo_documento_laboral_id',
	type =>'text',
	required=>'no',
	readonly=>'readonly',
	size =>'10',
	datatype=>array(
	type =>'integer',
	length =>'11'),
	transaction=>array(
	table =>array('tipo_documento_laboral'),
	type =>array('primary_key'))
	);
	
	$this -> Campos[nombre_documento] = array(
	name =>'nombre_documento',
	id =>'nombre_documento',
	type	=>'text',
	required=>'yes',
	datatype=>array(type=>'text'),
	transaction=>array(
	table =>array('tipo_documento_laboral'),
	type =>array('column'))
	);
	 
	$this -> Campos[cuerpo_mensaje] = array(
	name =>'cuerpo_mensaje',
	id =>'cuerpo_mensaje',
	type	=>'textarea',
	rows =>'35',
	cols=>'100',
	required=>'yes',
	datatype=>array(type=>'text'),	
	transaction=>array(
	table =>array('tipo_documento_laboral'),
	type =>array('column'))
	);
	
	$this -> Campos[tipo_contrato_id] = array(
			name	=>'tipo_contrato_id',
			id		=>'tipo_contrato_id',
			type	=>'select',
			datatype=>array(
				type	=>'integer',
				length	=>'9'),
			transaction=>array(
				table	=>array('tipo_documento_laboral'),
				type	=>array('column'))
		);
	
	$this -> Campos[variables] = array(
				name	=>'variables',
				id		=>'variables',
				type	=>'select',
				options	=> array(
					array(value=>'{NOMBRE}',text=>'NOMBRE',selected=>'0'),
					array(value=>'{IDENTIFICACION}',text=>'IDENTIFICACION'),
					array(value=>'{FECHA_INICIO}',text=>'FECHA_INICIO'),
					array(value=>'{CARGO}',text=>'CARGO'),
					array(value=>'{FECHA_FIN}',text=>'FECHA_FIN'),
					array(value=>'{SUELDO_BASE}',text=>'SUELDO_BASE'),
					array(value=>'{SUBSIDIO_TRANSPORTE}',text=>'SUBSIDIO_TRANSPORTE'),
					array(value=>'{TIPO_PERSONA}',text=>'TIPO_PERSONA'),
					array(value=>'{TIPO_IDENTIFICACION}',text=>'TIPO_IDENTIFICACION'),
					array(value=>'{DIRECCION}',text=>'DIRECCION'),
					array(value=>'{EMAIL}',text=>'EMAIL'),
					array(value=>'{TELEFAX}',text=>'TELEFAX'),
					array(value=>'{TELEFONO}',text=>'TELEFONO'),
					array(value=>'{MOVIL}',text=>'MOVIL'),
					array(value=>'{FECHA_NACIMIENTO_EMPLEADO}',text=>'FECHA_NACIMIENTO_EMPLEADO'),
					array(value=>'{ESTADO_CIVIL}',text=>'ESTADO_CIVIL'),
					array(value=>'{TIPO_VIVIENDA}',text=>'TIPO_VIVIENDA'),
					array(value=>'{PROFESION_EMPLEADO}',text=>'PROFESION_EMPLEADO'),
					array(value=>'{NUMERO_HIJOS_EMPLEADO}',text=>'NUMERO_HIJOS_EMPLEADO'),
					array(value=>'{CAUSAL_DESPIDO}',text=>'CAUSAL_DESPIDO'),
					array(value=>'{HORARIO_INI}',text=>'HORARIO_INI'),
					array(value=>'{HORARIO_FIN}',text=>'HORARIO_FIN'),
				 	array(value=>'{VALOR_LETRAS}',text=>'VALOR_LETRAS'),
					array(value=>'{EXPEDICION_CEDULA}',text=>'EXPEDICION_CEDULA'),
					array(value=>'{LUGAR_TRABAJO}',text=>'LUGAR_TRABAJO'),
					array(value=>'{DURACION_CONTRATO}',text=>'DURACION_CONTRATO')
					),
				datatype=>array(
					type	=>'text',
					length	=>'2')				
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
			onsuccess=>'CausalEvalOnSaveOnUpdate')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CausalEvalOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'tipo_documento_laboral',
			setId	=>'tipo_documento_laboral_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tipo_documento_laboral_id = new Parametros_documento();

?>