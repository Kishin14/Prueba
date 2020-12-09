<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class Tercero extends Controler{
	
  public function __construct(){

	parent::__construct(2);
	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("UsuariosLayoutClass.php"); 
    require_once("UsuariosModelClass.php");	  
	
    $Layout   = new UsuarioLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new UsuarioModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar	($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar	($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos	($this -> Campos);
	
	$Layout -> SetTiposId	($Model -> GetTipoId($this -> getConex()));
	$Layout -> setEmpresas	($Model -> getEmpresas($this -> getConex()));	
	$Layout -> SetTiposPersona($Model -> GetTipoPersona($this -> getConex()));
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("UsuariosLayoutClass.php"); 
    require_once("UsuariosModelClass.php");	  
	
    $Layout   = new UsuarioLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new UsuarioModel();
	  
	  //// GRID ////
	  $Attributes = array(
		id		=>'terceros',
		title		=>'Listado de Usuarios',
		sortname	=>'numero_identificacion',
		width		=>'auto',
		height	=>'250'
	  );
  
	  $Cols = array(
  
		array(name=>'estado',	                index=>'estado',                sorttype=>'text',	width=>'80',	align=>'center'),	
		array(name=>'numero_identificacion',	index=>'numero_identificacion',	sorttype=>'int',	width=>'100',	align=>'center'),
		array(name=>'primer_nombre',			index=>'primer_nombre',			sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'segundo_nombre',			index=>'segundo_nombre',		sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'primer_apellido',		index=>'primer_apellido',		sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'segundo_apellido',		index=>'segundo_apellido',		sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'cargo',		index=>'cargo',		sorttype=>'text',	width=>'150',	align=>'center'),
		  array(name=>'usuario',				index=>'usuario',				sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'cliente',				index=>'cliente',				sorttype=>'text',	width=>'150',	align=>'center'),
		array(name=>'email',					index=>'email',					sorttype=>'text',	width=>'150',	align=>'center')
	  
	  );
		
	  $Titles = array('ESTADO',
					  'IDENTIFICACION',
					  'PRIMER NOMBRE',
					  'SEGUNDO NOMBRE',
					  'PRIMER APELLIDO',
					  'SEGUNDO APELLIDO',
					  'CARGO',
					  'USUARIO',
					  'CLIENTE',
					  'EMAIL'
	  );
	  
	 $html = $Layout -> SetGridTerceros($Attributes,$Titles,$Cols,$Model -> getQueryTercerosGrid());	  
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){

	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);
	 
	 print $Data  -> GetData();
  }
	  	  
  protected function onclickFind(){
    		
	require_once("UsuariosModelClass.php");	  	
    require_once("../../../framework/clases/FindRowClass.php");

    $Model = new UsuarioModel();	 
	
	$find1 = new FindRow($this -> getConex(),"tercero",$this ->Campos);	
	$Data1 = $find1 -> GetData();

		
	if(count($Data1) > 0){
	
      $this -> assignValRequest('tercero_id',$Data1[0]['tercero_id']);
	  	 
 	  $find2 = new FindRow($this -> getConex(),"usuario",$this ->Campos);		
	  $Data2 = $find2 -> GetData();	
			
	  if(count($Data2) > 0) $Data3 = $Model -> selectEmpresasUsuario($Data2[0]['usuario_id'],$this -> getConex());		
	
      if(count($Data2) > 0 && count($Data3) > 0){
	    $this -> getArrayJSON(array_merge($Data1,$Data2,$Data3));
	  }else if(count($Data2) > 0){
	     $this -> getArrayJSON(array_merge($Data1,$Data2));
	    }else{
 	       $this -> getArrayJSON($Data1);
	    }
		
    }
	  
  }
	  
  protected function onclickSave(){
      		
  	require_once("UsuariosModelClass.php");	    
    $Model = new UsuarioModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
	if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso correctamente el Usuario');
	 }	
		
  }

  protected function onclickUpdate(){
	  
  	require_once("UsuariosModelClass.php");	    
    $Model = new UsuarioModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Usuario');
	  }	
	  	
  }
	  
  protected function onclickDelete(){

  	require_once("UsuariosModelClass.php");	    
    $Model = new UsuarioModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Usuario');
	  }			
  }	  

  protected function setCampos(){
  
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tercero','usuario'),
			type	=>array('primary_key','column'))
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
	  
	$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id		=>'tipo_identificacion_id',
		type	=>'select',
		required=>'yes',
		options	=>null,
		//tabindex=>'1',
	 	datatype=>array(
			type	=>'alphanum'),
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
		name	=>'segundo_apellido',
		id		=>'segundo_apellido',
		type	=>'text',
		//tabindex=>'5',
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

	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
    	transaction=>array(
			table	=>array('usuario'),
			type	=>array('primary_key'))
	);

	$this -> Campos[usuario] = array(
    	name	=>'usuario',
		id		=>'usuario',
		type	=>'text',
		required=>'yes',
		//tabindex=>'8',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'10'),
		transaction=>array(
			table	=>array('usuario'),
			type	=>array('column'))
	);
	
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		size     =>'20',
		suggest=>array(
			name	=>'cliente_disponible',
			setId	=>'cliente_hidden'
			)
	);
		
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id	=>'cliente_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'no',		
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('usuario'),
			type	=>array('column'))
	);
	
	/*	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
    	transaction=>array(
			table	=>array('cliente'),
			type	=>array('primary_key'))
	);

	$this -> Campos[cliente] = array(
    	name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		required=>'no',
		//tabindex=>'8',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'10'),
		transaction=>array(
			table	=>array('cliente'),
			type	=>array('column'))
	);*/

	$this -> Campos[email] = array(
		name	=>'email',
    	id		=>'email',
		type	=>'text',
		required=>'yes',
		//tabindex=>'9',
		datatype=>array(
			type	=>'email'),
		transaction=>array(
			table	=>array('usuario'),
			type	=>array('column'))
	);
	 
	$this -> Campos[cargo] = array(
		name	=>'cargo',
		id		=>'cargo',
		type	=>'text',
		//tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
	 	transaction=>array(
			table	=>array('usuario'),
			type	=>array('column'))
	);
	
	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
    	id		=>'empresa_id',
		type	=>'select',
		multiple=>'multiple',
		size	=>'3',
		required=>'yes',
		//tabindex=>'10',
		datatype=>array(
			type=>'integer')
	);
	 
	$this -> Campos[activo] = array(
		name	=>'estado',
		id		=>'activo',
		type	=>'radio',
	 	value	=>'A',
		checked	=>'checked',
		//tabindex=>'11',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('usuario'),
			type	=>array('column'))
	);
	 
	$this -> Campos[inactivo] = array(
		name	=>'estado',
		id		=>'inactivo',
		type	=>'radio',
	 	value	=>'I',
		//tabindex=>'12',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('usuario'),
			type	=>array('column'))
	);
	 
 	$this -> Campos[foto] = array(
		name	=>'foto',
		id		=>'foto',
		type	=>'file',
		size	=>'40',
		//tabindex=>'14',
		path	=>'../../../framework/media/images/varios/',
 	 	datatype=>array(
			type	=>'file'),
		transaction=>array(
			table	=>array('usuario'),
			type	=>array('column'))
	);
	  	 
 	$this -> Campos[fotoimg] = array(
		name	=>'foto_file',
		id		=>'foto_img',
		type	=>'image',
		width	=>'170px',
	 	height	=>'50',
		src		=>'../../../framework/media/images/varios/'
		//tabindex=>'15'
	);
 
 
 /*botones*/
 
	$this -> Campos[guardar] = array(
		name=>'guardar',
		id=>'guardar',
		type=>'button',
		value=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'UsuarioOnSaveOnUpdateonDelete')
	);
	 
 	$this -> Campos[actualizar] = array(
		name=>'actualizar',
		id=>'actualizar',
		type=>'button',
		value=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'UsuarioOnSaveOnUpdateonDelete')
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
			onsuccess=>'UsuarioOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'usuarioOnReset(this.form)'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'usuario',
			setId	=>'tercero_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}


}

$tercero = new Tercero();

?>