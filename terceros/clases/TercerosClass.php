<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Tercero extends Controler{
	
  public function __construct(){

	parent::__construct(2);
	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("TercerosLayoutClass.php");
    require_once("TercerosModelClass.php");
	
    $Layout   = new TerceroLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TerceroModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setCambioEstado  ($Model -> getPermiso($this -> getActividadId(),'STATUS',$this -> getConex()));		
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetTiposId     ($Model -> GetTipoId($this -> getConex()));
   	$Layout -> SetTiposPersona($Model -> GetTipoPersona($this -> getConex()));
	$Layout -> setRegimen($Model -> getRegimen($this -> getConex()));
    $Layout -> setEstado        ();	 

	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("TercerosLayoutClass.php"); 
    require_once("TercerosModelClass.php");
	
    $Layout   = new TerceroLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TerceroModel();
	  
	  //// GRID ////
	$Attributes = array(
		id		=>'terceros',
		title		=>'Listado de Terceros',
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
		array(name=>'telefono',				index=>'telefono',				sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'movil',					index=>'movil',					sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'sigla',					index=>'sigla',					sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'ubicacion',				index=>'ubicacion',				sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'direccion',				index=>'direccion',				sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'email',					index=>'email',					sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'regimen',				index=>'regimen',				sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'80',	align=>'center')
	  
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
					  'TELEFONO',
					  'MOVIL',
					  'CIUDAD RESIDENCIA',
					  'DIRECCION',
					  'EMAIL',
					  'REGIMEN',
					  'ESTADO'
	  );
	  
	 $html = $Layout -> SetGridTerceros($Attributes,$Titles,$Cols,$Model -> getQueryTercerosGrid());
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
  }
  
	protected function onclickSave(){
	
		require_once("TercerosModelClass.php");
		$Model = new TerceroModel();
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
				exit('Se ingreso correctamente un nuevo tercero.');
			}
		}
	}


	protected function onclickUpdate(){
	
		require_once("TercerosModelClass.php");
		$Model = new TerceroModel();
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
				exit('Se actualizo correctamente el tercero.');
			}
		}
	}
  
  protected function onclickDelete(){

  	require_once("TercerosModelClass.php");
    $Model = new TerceroModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el tercero');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("TercerosModelClass.php");
    $Model = new TerceroModel();
	$Data  = $Model -> selectTercero($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('primary_key'))
	);
	  
	$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id		=>'tipo_identificacion_id',
		type	=>'select',
		options	=>null,
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
		//tabindex=>'2',
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
		readonly=>'readonly',
		size	=>'1',
		//tabindex=>'3',
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
		//tabindex=>'4',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
	 	transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
    $this -> Campos[segundo_apellido] = array(
		type=>'text',
		datatype=>array(
			type=>'alpha_upper',
			length=>'100'),
		name=>'segundo_apellido',
		id=>'segundo_apellido',
		value=>'',
		//tabindex=>'5',
		transaction=>array(
			table=>array('tercero'),
			type=>array('column'))
	);
	 
	$this -> Campos[primer_nombre] = array(
		name	=>'primer_nombre',
		id		=>'primer_nombre',
		type	=>'text',
		//tabindex=>'6',
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
		//tabindex=>'7',
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
		//tabindex=>'8',
                size=>'45',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[sigla] = array(
		name	=>'sigla',
		id		=>'sigla',
		type	=>'text',
		//tabindex=>'9',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[telefono] = array(
		name	=>'telefono',
		id		=>'telefono',
		type	=>'text',
		//tabindex=>'10',
		required=>'yes',
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
		//tabindex=>'11',
		datatype=>array(
			type	=>'alphanum',
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
		required=>'yes',
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
		//tabindex=>'12',
		required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'100'),
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
			table	=>array('tercero'),
			type	=>array('column'))
	);	
	
	$this -> Campos[regimen_id] = array(
		name	=>'regimen_id',
		id		=>'regimen_id',
		type	=>'select',
		options =>array(),
		//tabindex=>'12',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);	
	
	$this -> Campos[autoret_proveedor] = array(
		name	=>'autoret_proveedor',
		id		=>'autoret_proveedor',
		type	=>'select',
	 	options	=>array(array(value => 'N', text => 'NO'),array(value => 'S', text => 'SI')),
		selected=>'N',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('tercero','tenedor','proveedor'),
			type	=>array('column','column','column'))
	);

    $this -> Campos[retei_proveedor] = array(
		name	=>'retei_proveedor',
		id		=>'retei_proveedor',
		type	=>'select',
	 	options	=>array(array(value => 'N', text => 'NO'),array(value => 'S', text => 'SI')),
		selected=>'N',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('tercero','tenedor','proveedor'),
			type	=>array('column','column','column'))
	);	

	$this -> Campos[estado] = array(
		name	 =>'estado',
		id		 =>'estado',
		type	 =>'select',
		required =>'yes',
		options	 =>array(array(value => 'B',text => 'BLOQUEADO'),array(value => 'D', text => 'DISPONIBLE')),
        selected => 'B',		
		datatype =>array(type=>'text'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		//tabindex=>'15'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		//tabindex=>'16',
		disabled=>'disabled'
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		//tabindex=>'17',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TerceroOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'18',
		onclick	=>'tercerosOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'tercero',
			setId	=>'tercero_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$tercero = new Tercero();

?>