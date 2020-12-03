<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class Oficina extends Controler{
	
  public function __construct(){  
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("OficinasLayoutClass.php");
    require_once("OficinasModelClass.php");	  
	
    $Layout   = new OficinaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new OficinaModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));

	$Layout -> RenderMain();
	
	$this -> getOficinasTree();	
  
  }

  protected function onclickValidateRow(){

	require_once("OficinasModelClass.php");	    
    $Model = new OficinaModel();
	  
	print $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
	  	  
  protected function onclickFind(){
	      	
    require_once("../../../framework/clases/FindRowClass.php");
	require_once("OficinasModelClass.php");	    

    $Model     = new OficinaModel();	 
	$OficinaId = $_REQUEST['oficina_id'];
    $result    = $Model -> selectOficina($OficinaId,$this -> getConex());
	 		
	$this -> getArrayJSON($result);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("OficinasModelClass.php");	    
    $Model = new OficinaModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('save');
	 }	
		
  }

  protected function onclickUpdate(){

  	require_once("OficinasModelClass.php");	    
    $Model = new OficinaModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('update');
	 }		
		
  }
	  
  protected function onclickDelete(){

  	require_once("OficinasModelClass.php");	    
    $Model = new OficinaModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente la Oficina');
	 }		
		
  }
  
  
  protected function getOptionsOficina(){
	  
	require_once("OficinasLayoutClass.php");
	require_once("OficinasModelClass.php");	  
	
	$Layout   = new OficinaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new OficinaModel();	 
	
    $EmpresaId = $_REQUEST['empresa_id'];
	$Oficinas  = $Model -> selectOficinas($EmpresaId,$this -> getConex());
	
	$field[cen_oficina_id] = array(
		name	=>'cen_oficina_id',
		id		=>'cen_oficina_id',
		type	=>'select',
		options	=>$Oficinas,
		//tabindex=>'2',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
		
	print $Layout -> getObjectHtml($field[cen_oficina_id]);
	
  }
  
  protected function getOptionsOficinaSelected(){
	  
	require_once("OficinasLayoutClass.php");
	require_once("OficinasModelClass.php");	  
	
	$Layout   = new OficinaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new OficinaModel();	 
	
    $EmpresaId = $_REQUEST['empresa_id'];
	$OficinaId = $_REQUEST['oficina_id'];
	$Oficinas  = $Model -> selectOficinasSelected($EmpresaId,$OficinaId,$this -> getConex());
	
	$field[cen_oficina_id] = array(
		name	=>'cen_oficina_id',
		id		=>'cen_oficina_id',
		type	=>'select',
		options	=>$Oficinas,
		//tabindex=>'2',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
		
	print $Layout -> getObjectHtml($field[cen_oficina_id]);
	
  }  
  
  
  protected function getOficinasTree(){
  
  	require_once("OficinasLayoutClass.php");
	require_once("OficinasModelClass.php");	  
	
	$Layout   = new OficinaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new OficinaModel();	 
	
    $Empresas = $Model -> getEmpresasTree($this -> getConex());

    $Layout -> setVar('sectionOficinasTree',1);	
    $Layout -> setVar('encabezadoTree',1);
  	$Layout -> RenderLayout('oficinas.tpl');		
	
	$j = 0;
	
	for($i = 0; $i < count($Empresas); $i++){
	
	  $j++;
  	
      $Layout -> setVar('encabezadoTree',0);	
	  $Layout -> setVar('nivelEmpresa',1);	
      $Layout -> setVar('nivelOficina',0);	  
	  $Layout -> setVar('empresa_nombre',$Empresas[$i]['empresa_nombre']);
	  $Layout -> setVar('node',$j);	 
   	  $Layout -> RenderLayout('oficinas.tpl');
	  
      $Layout -> setVar('encabezadoTree',0);
      $Layout -> setVar('nivelEmpresa',0);
      $Layout -> setVar('nivelOficina',1);		  
	  
	  $this -> getNodesTreeTop($Empresas[$i]['empresa_id'],$j,$Layout);
	
	}

    $Layout -> setVar('encabezadoTree',0);
    $Layout -> setVar('nivelEmpresa',0);
    $Layout -> setVar('nivelOficina',0);	
    $Layout -> setVar('pieTree',1);
	$Layout -> RenderLayout('oficinas.tpl');
  
  }
  
  protected function getNodesTreeTop($EmpresaId,$node,$Layout){
  
	require_once("OficinasModelClass.php");	  
	
    $Model    = new OficinaModel();	
	
	$children = $Model -> getChildrenTop($EmpresaId,$this -> getConex());
	
	if(count($children) > 0){
	
	   $j = 0;
	   
	   for($i = 0; $i < count($children); $i++){
	   
   	     $j++;
	   
	     $Layout -> setVar('oficina_nombre',$children[$i]['nombre']);
	     $Layout -> setVar('node',"$node-$j");	
	     $Layout -> setVar('child',"$node");	
	     $Layout -> setVar('ubicacion',$children[$i]['ubicacion']);			 		 
	     $Layout -> setVar('sucursal',$children[$i]['sucursal']);			 		 		 
    	 $Layout -> RenderLayout('oficinas.tpl');		 	   
	   
	     $this -> getNodesTree($children[$i]['oficina_id'],"$node-$j",$Layout);
	   }
	   
	}else{
	     return false;
	  }
  
  }
  
  protected function getNodesTree($IdParent,$node,$Layout){
  
	require_once("OficinasModelClass.php");	  
	
    $Model    = new OficinaModel();	
	
	$children = $Model -> getChildren($IdParent,$this -> getConex());
	
		
	if(count($children) > 0){
	
	   $j = 0;
	   
	   for($i = 0; $i < count($children); $i++){
	   
	     $j++;
		 
	     $Layout -> setVar('oficina_nombre',$children[$i]['nombre']);
	     $Layout -> setVar('node',"$node-$j");	
	     $Layout -> setVar('child',"$node");	
	     $Layout -> setVar('ubicacion',$children[$i]['ubicacion']);			 		 
	     $Layout -> setVar('sucursal',$children[$i]['sucursal']);		 		 		 
    	 $Layout -> RenderLayout('oficinas.tpl');
		 
	     $this -> getNodesTree($children[$i]['oficina_id'],"$node-$j",$Layout);
	   }
	   
	}else{
	     return false;
	  }
  
  }  

  protected function setCampos(){
  
	$this->Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('primary_key'))
	);
	  
	$this->Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		required=>'yes',
		options=> array(),
		//tabindex	=>'1',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
	
	$this->Campos[cen_oficina_id] = array(
		name	=>'cen_oficina_id',
		id		=>'cen_oficina_id',
		type	=>'select',
		options	=>array(),
		//tabindex=>'2',
		disabled=>'disabled',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
	 
	$this->Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		required=>'yes',
		//tabindex=>'3',
		datatype=>array(
			type	=>'alphanum_space'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
	
	$this->Campos[codigo_centro] = array(
		name	=>'codigo_centro',
		id		=>'codigo_centro',
		type	=>'text',
		required=>'yes',
		//tabindex=>'4',
		datatype=>array(
			type	=>'alphanum_space'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);

	$this->Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		//tabindex=>'5',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'ubicacion_hidden')
	);
		
	$this->Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
	
	$this->Campos[sucursal] = array(
		name	=>'sucursal',
		id		=>'sucursal',
		type	=>'hidden',
		//tabindex=>'6',
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
	
	$this->Campos[direccion] = array(
		name	=>'direccion',
		id		=>'direccion',
		type	=>'text',
		required=>'yes',
		//tabindex=>'7',
		datatype=>array(
    		type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
	
	$this->Campos[telefono] = array(
		name	=>'telefono',
		id		=>'telefono',
		type	=>'text',
		required=>'yes',
		//tabindex=>'8',
		datatype=>array(
			type	=>'alphanum',
    		length	=>'100'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
	
	$this->Campos[movil] = array(
		name	=>'movil',
		id		=>'movil',
		type	=>'text',
		required=>'yes',
		//tabindex=>'9',
		datatype=>array(
			type	=>'alphanum',
    		length	=>'100'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
	
	$this->Campos[email] = array(
		name	=>'email',
		id		=>'email',
		type	=>'text',
		required=>'yes',
		//tabindex=>'10',
		datatype=>array(
			type	=>'email'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);
	 
    $this->Campos[sucursal_si] = array(
     	name	=>'sucursal',
		id		=>'sucursal_si',
		type	=>'radio',
		value	=>1,
		//tabindex=>'11',
		datatype=>array(
			type	=>'integer',
			length	=>'1')
	);
	 
	$this->Campos[sucursal_no] = array(
    	name	=>'sucursal',
		id		=>'sucursal_no',
		type	=>'radio',
		value	=>0,
		checked	=>'checked',
		//tabindex=>'12',
		datatype=>array(
			type	=>'integer',
			length	=>'1')
	);

	$this->Campos[responsable] = array(
		name	=>'responsable',
		id	=>'responsable',
		type	=>'text',
                size    =>'40',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'tercero',
			setId	=>'responsable_hidden')
	);


	$this->Campos[responsable_id] = array(
		name	=>'responsable_id',
		id	=>'responsable_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);


	$this->Campos[plantilla] = array(
		name	=>'plantilla',
		id	    =>'plantilla',
		type	=>'text',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('oficina'),
			type	=>array('column'))
	);



 /*botones*/
	$this->Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		//tabindex=>'19',
		'property'=>array(
			name	=>'save_ajax',
			onsuccess=>'OficinaOnSaveUpdate')
	);
	 
 	$this->Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		//tabindex=>'20',
		'property'=>array(
			name	=>'update_ajax',
			onsuccess=>'OficinaOnSaveUpdate')
	);
	 
  	$this->Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		//tabindex=>'21',
		'property'=>array(
			name	=>'delete_ajax',
			onsuccess=>'OficinaOnDelete')
	);
	 
   	$this->Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'OficinaOnClear()'
	);
	 
   	$this->Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'oficina',
			onclick	=>'LlenarFormOficina',
			setId	=>'oficina_id')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}


}

$Oficina = new Oficina();

?>