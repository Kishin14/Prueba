<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Empresa extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
    require_once("EmpresasLayoutClass.php");
    require_once("EmpresasModelClass.php");
	
    $Layout   = new EmpresaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new EmpresaModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetTiposId     ($Model -> GetTipoId($this -> getConex()));
   	$Layout -> SetTiposPersona($Model -> GetTipoPersona($this -> getConex()));

	
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("EmpresasModelClass.php");
    $Model = new EmpresaModel();
	print $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  
  protected function showGrid(){
	  
	require_once("EmpresasLayoutClass.php");
    require_once("EmpresasModelClass.php");
	
    $Layout   = new EmpresaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new EmpresaModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'terceros',
		title		=>'Listado de Empresas',
		sortname	=>'numero_identificacion',
		width		=>'auto',
		height	=>'250'
	  );
  
	  $Cols = array(
	  
		array(name=>'tipo_identificacion_id',	index=>'tipo_identificacion_id',sorttype=>'text',	width=>'80',	align=>'center'),
		array(name=>'numero_identificacion',	index=>'numero_identificacion',	sorttype=>'int',	width=>'100',	align=>'center'),
		array(name=>'digito_verificacion',	index=>'digito_verificacion',	sorttype=>'int',	width=>'22',	align=>'center'),
		array(name=>'tipo_persona_id',		index=>'tipo_persona_id',		sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'primer_apellido',		index=>'primer_apellido',		sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'segundo_apellido',		index=>'segundo_apellido',		sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'primer_nombre',			index=>'primer_nombre',			sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'segundo_nombre',			index=>'segundo_nombre',		sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'razon_social',			index=>'razon_social',			sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'sigla',					index=>'sigla',					sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'ubicacion',				index=>'ubicacion',				sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'direccion',				index=>'direccion',				sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'telefono',				index=>'telefono',				sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'movil',					index=>'movil',					sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'telefax',				index=>'telefax',				sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'apartado',				index=>'apartado',				sorttype=>'text',	width=>'50',	align=>'center'),
		  array(name=>'email',					index=>'email',					sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'registro_mercantil',		index=>'registro_mercantil',	sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'escritura_constitucion',	index=>'escritura_constitucion',sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'notaria',				index=>'notaria',				sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'resolucion',				index=>'resolucion',			sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'fecha_resolucion',		index=>'fecha_resolucion',		sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'inicio_resolucion',		index=>'inicio_resolucion',		sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'fin_resolucion',			index=>'fin_resolucion',		sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'inicio_disponible_res',	index=>'inicio_disponible_res',	sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'saldo_res',				index=>'saldo_res',				sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'30',	align=>'center')
		
	  
	  );
		
	  $Titles = array('TIPO ID',
					  'IDENTIFICACION',
					  'DV',
					  'TIPO CONTRIBUYENTE',
					  'PRIMER APELLIDO',
					  'SEGUNDO APELLIDO',
					  'PRIMER NOMBRE',
					  'OTROS NOMBRES',
					  'RAZON SOCIAL',
					  'SIGLA',
					  'CIUDAD RESIDENCIA',
					  'DIRECCION',
					  'TELEFONO',
					  'MOVIL',
					  'TELEFAX',
					  'APARTADO',
					  'EMAIL',
					  'REGISTRO MERCANTIL',
					  'ESCRITURA CONSTITUCION',
					  'NOTARIA',
					  'RESOLUCION',
					  'FECHA RESOLUCION',
					  'INICIO RANGO',
					  'FINAL RANGO',
					  'INICIO DISPONIBLE',
					  'SALDO DISPONIBLE',
					  'ESTADO'
	  );
	  
	$html = $Layout -> SetGridEmpresas($Attributes,$Titles,$Cols,$Model -> GetQueryEmpresasGrid());
	 
	 print $html;
	  
  }
  
	protected function onclickSave(){
	
		require_once("EmpresasModelClass.php");
		$Model = new EmpresaModel();
		$telefono	= $_REQUEST['telefono'];
		
		if(strlen($telefono) < 7 ){
			exit("Debe digitar minimo 7 caracteres en el campo Telefono. !!");
		}elseif(strlen($telefono) > 10 ){
			exit("Debe digitar maximo 10 caracteres en el campo Telefono. !!");
		}elseif(!is_numeric($telefono)){
			exit("Debe digitar solo caracteres numericos en el campo Telefono. !!");	
		}else{
		
			$Model -> Save($this -> Campos,$this -> getConex());
			
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia.');
			}else{
				exit('Se ingreso correctamente una nueva empresa.');
			}
		}
	}


	protected function onclickUpdate(){
	
		require_once("EmpresasModelClass.php");
		$Model = new EmpresaModel();
		$telefono	= $_REQUEST['telefono'];
		
		if(strlen($telefono) < 7 ){
			exit("Debe digitar minimo 7 caracteres en el campo Telefono. !!");
		}elseif(strlen($telefono) > 10 ){
			exit("Debe digitar maximo 10 caracteres en el campo Telefono. !!");
		}elseif(!is_numeric($telefono)){
			exit("Debe digitar solo caracteres numericos en el campo Telefono. !!");	
		}else{
		
			$Model -> Update($this -> Campos,$this -> getConex());
			
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia.');
			}else{
				exit('Se actualizo correctamente la empresa.');
			}
		}
	}

  protected function onclickDelete(){

  	require_once("EmpresasModelClass.php");
    $Model = new EmpresaModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar la empresa');
	}else{
	    exit('Se borro exitosamente la empresa');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("EmpresasModelClass.php");
    $Model = new EmpresaModel();
	
    $Data                  = array();
	$tercero_id            = $_REQUEST['tercero_id'];
  	$numero_identificacion = $_REQUEST['numero_identificacion'];
	 
	if(is_numeric($tercero_id)){
	  
	  $Data  = $Model -> selectDatosEmpresaTerceroId($tercero_id,$this -> getConex());
	
	}else if(is_numeric($numero_identificacion)){
		  
     	$Data  = $Model -> selectDatosEmpresaNumeroId($numero_identificacion,$this -> getConex());
		
	  }
	  
    $this -> getArrayJSON($Data);
	
  }
  

  protected function setCampos(){
  
    /********************
	  Campos Terceros
	********************/
	
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tercero','empresa'),
			type	=>array('primary_key','column'))
	);
	
	$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id		=>'tipo_identificacion_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		//tabindex=>'1',
	 	datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	  
	$this -> Campos[tipo_persona_id] = array(
		name	=>'tipo_persona_id',
		id		=>'tipo_persona_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero_identificacion] = array(
		name	=>'numero_identificacion',
		id		=>'numero_identificacion',
		type	=>'text',
		required=>'yes',
		size	=>'12',
		//tabindex=>'3',
		datatype=>array(
			type	=>'integer',
			length	=>'20',
			precision=>'0'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[digito_verificacion] = array(
		name	=>'digito_verificacion',
		id		=>'digito_verificacion',
		type	=>'text',
		size	=>'1',
		//tabindex=>'4',
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[primer_apellido] = array(
		name	=>'primer_apellido',
		id		=>'primer_apellido',
		type	=>'text',
		//tabindex=>'5',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
	 	transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
    $this -> Campos[segundo_apellido] = array(
		name	=>'segundo_apellido',
		id		=>'segundo_apellido',
		type	=>'text',
		//tabindex=>'6',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[primer_nombre] = array(
		name	=>'primer_nombre',
		id		=>'primer_nombre',
		type	=>'text',
		//tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
	 	transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[segundo_nombre] = array(
		name	=>'segundo_nombre',
		id		=>'segundo_nombre',
		type	=>'text',
		//tabindex=>'8',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'10'),
	 	transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[razon_social] = array(
	 	name	=>'razon_social',
		id		=>'razon_social',
		type	=>'text',
		//tabindex=>'9',
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[sigla] = array(
		name	=>'sigla',
		id		=>'sigla',
		type	=>'text',
	 	//tabindex=>'10',
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		//tabindex=>'7',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ubicacion_hidden')
	);
		
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_hidden',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[direccion] = array(
		name	=>'direccion',
		id		=>'direccion',
		type	=>'text',
	 	//tabindex=>'11',
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[telefono] = array(
		name	=>'telefono',
		id		=>'telefono',
		type	=>'text',
	 	//tabindex=>'12',
		datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[movil] = array(
		name	=>'movil',
		id		=>'movil',
		type	=>'text',
	 	//tabindex=>'13',
		datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[telefax] = array(
		name	=>'telefax',
		id		=>'telefax',
		type	=>'text',
	 	//tabindex=>'12',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[apartado] = array(
		name	=>'apartado',
		id		=>'apartado',
		type	=>'text',
	 	//tabindex=>'12',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[email] = array(
		name	=>'email',
		id		=>'email',
		type	=>'text',
		//tabindex=>'12',
		datatype=>array(
			type	=>'email',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero','empresa'),
			type	=>array('column','column'))
	);	

	$this -> Campos[pagina_web] = array(
		name	=>'pagina_web',
		id		=>'pagina_web',
		type	=>'text',
		//tabindex=>'12',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);	
	 
	 /*********************************
	          Campos Empresas
	 *********************************/

 	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction	=>array(
			table	=>array('empresa'),
			type	=>array('primary_key'))
	);
	 
 	$this -> Campos[logo] = array(
		name	=>'logo',
		id		=>'logo',
		type	=>'file',
		size	=>'40',
		//tabindex=>'14',
		path	=>'../../../framework/media/images/varios/',
 	 	datatype=>array(
			type	=>'file'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	  	 
 	$this -> Campos[logoimg] = array(
		name	=>'logo_file',
		id		=>'logo_img',
		type	=>'image',
		width	=>'170px',
	 	height	=>'50',
		src		=>'../../../framework/media/images/varios/',
		//tabindex=>'15'
	);
	 
	$this -> Campos[registro_mercantil] = array(
		name	=>'registro_mercantil',
		id		=>'registro_mercantil',
		type	=>'text',
		//tabindex=>'16',
		datatype=>array(
			type	=>'alphanum',
			length	=> '100'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	$this -> Campos[camara_comercio] = array(
		name	=>'camara_comercio',
		id		=>'camara_comercio',
		type	=>'text',
		//tabindex=>'16',
		datatype=>array(
			type	=>'alphanum',
			length	=> '100'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	$this -> Campos[escritura_constitucion] = array(
		name	=>'escritura_constitucion',
		id		=>'escritura_constitucion',
		type	=>'text',
		//tabindex=>'17',
		datatype=>array(
			type	=>'alphanum',
			length	=>'100'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		//tabindex=>'17',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	 $this -> Campos[notaria] = array(
		name	=>'notaria',
		id		=>'notaria',
		type	=>'text',
		//tabindex=>'18',
		datatype=>array(
			type	=>'alphanum',
			length	=>'100'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	 
	 
	 /*
	 $this -> Campos[resolucion] = array(
		name	=>'resolucion',
		id		=>'resolucion',
		type	=>'text',
		//tabindex=>'18',
		datatype=>array(
			type	=>'alphanum',
			length	=>'100'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	$this -> Campos[fecha_resolucion] = array(
		name	=>'fecha_resolucion',
		id		=>'fecha_resolucion',
		type	=>'text',
		//tabindex=>'17',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	 $this -> Campos[inicio_resolucion] = array(
		name	=>'inicio_resolucion',
		id		=>'inicio_resolucion',
		type	=>'text',
		value	=>'0',
		size	=>'6',
		//tabindex=>'18',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	 $this -> Campos[fin_resolucion] = array(
		name	=>'fin_resolucion',
		id		=>'fin_resolucion',
		type	=>'text',
		value	=>'0',
		size	=>'6',
		//tabindex=>'18',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	 $this -> Campos[inicio_disponible_res] = array(
		name	=>'inicio_disponible_res',
		id		=>'inicio_disponible_res',
		type	=>'text',
		value	=>'0',
		size	=>'6',
		//tabindex=>'18',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	 
	 $this -> Campos[saldo_res] = array(
		name	=>'saldo_res',
		id		=>'saldo_res',
		type	=>'text',
		value	=>'0',
		size	=>'6',
		readonly=>'readonly',
		//tabindex=>'18',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('empresa'),
			type	=>array('column'))
	);
	
	
	*/
	
	$this -> Campos[estado] = array(
		name	 =>'estado',
		id		 =>'estado',
		type	 =>'select',
		required =>'yes',
		options	 =>array(array(value => 'A',text => 'ACTIVO'),array(value => 'I', text => 'INACTIVO')),
        selected => 'A',		
		datatype =>array(type=>'text'),
		transaction=>array(
			table	=>array('empresa'),
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
		//tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		//tabindex=>'20'
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
  		disabled=>'disabled',
		//tabindex=>'21',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'EmpresaOnSaveOnUpdateOnDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'empresaOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'empresa',
			setId	=>'tercero_id',
			onclick	=>'LlenarFormEmpresas')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tercero = new Empresa();

?>