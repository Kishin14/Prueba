<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class Oficina extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("AsignarPermisosLayoutClass.php");
    require_once("AsignarPermisosModelClass.php");	  
	
    $Layout   = new asignarPermisosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new asignarPermisosModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
	
    $Layout -> setCampos($this -> Campos);
	
    $Layout -> RenderMain();
	
    $this -> getOficinasTree();	
  
  }

  protected function onclickValidateRow(){

	require_once("AsignarPermisosModelClass.php");	    
    $Model = new asignarPermisosModel();
	  
	print $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
	  	  
  protected function onclickFind(){
	      	
    require_once("../../../framework/clases/FindRowClass.php");
	require_once("AsignarPermisosModelClass.php");	    

    $Model     = new asignarPermisosModel();	 
	$OficinaId = $_REQUEST['oficina_id'];
    $result    = $Model -> selectOficina($OficinaId,$this -> getConex());
	 		
	$this -> getArrayJSON($result);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("AsignarPermisosModelClass.php");	    
    $Model = new asignarPermisosModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente la Oficina');
	 }	
		
  }

  protected function onclickUpdate(){

  	require_once("AsignarPermisosModelClass.php");	    
    $Model = new asignarPermisosModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente la Oficina');
	 }		
		
  }
	  
  protected function onclickDelete(){

  	require_once("AsignarPermisosModelClass.php");	    
    $Model = new asignarPermisosModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente la Oficina');
	 }		
		
  }
 
  protected function getOficinasTree(){
  
  	require_once("AsignarPermisosLayoutClass.php");
	require_once("AsignarPermisosModelClass.php");	  
	
	$Layout   = new asignarPermisosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new asignarPermisosModel();	 
	
    $Empresas = $Model -> getEmpresasTree($this -> getConex());
	$permisos = $Model -> getPermisos($this -> getConex());		
	
    $Layout -> setVar("OFICINASASIGNADASID",$Layout -> getObjectHtml($this -> Campos[oficinas_asignadas_id]));
    $Layout -> setVar("OTORGARDENEGAR",$Layout -> getObjectHtml($this -> Campos[otorgar_denegar]));		
    $Layout -> setVar('sectionOficinasTree',1);	
    $Layout -> setVar('encabezadoTree',1);
    $Layout -> setVar('permisos',$permisos);	
  	$Layout -> RenderLayout('asignarpermisos.tpl');		
	
	$j = 0;
		
	for($i = 0; $i < count($Empresas); $i++){
	
	  $j++;
  	
      $Layout -> setVar('encabezadoTree',0);	
	  $Layout -> setVar('nivelEmpresa',1);	
      $Layout -> setVar('nivelOficina',0);	  
	  $Layout -> setVar('consecutivo',$Empresas[$i]['consecutivo']);	  	  
	  $Layout -> setVar('path_imagen',$Empresas[$i]['path_imagen']);	  
	  $Layout -> setVar('descripcion',$Empresas[$i]['descripcion']);
	  $Layout -> setVar('color',$Empresas[$i]['color']);	  
	  $Layout -> setVar('node',$j);	 
   	  $Layout -> RenderLayout('asignarpermisos.tpl');
	  
      $Layout -> setVar('encabezadoTree',0);
      $Layout -> setVar('nivelEmpresa',0);
      $Layout -> setVar('nivelOficina',1);		  
	  
	  $this -> getNodesTreeTop($Empresas[$i]['consecutivo'],$j,$Layout,$Empresas[$i]['color']);
	
	}

    $Layout -> setVar('encabezadoTree',0);
    $Layout -> setVar('nivelEmpresa',0);
    $Layout -> setVar('nivelOficina',0);	
    $Layout -> setVar('pieTree',1);
	$Layout -> RenderLayout('asignarpermisos.tpl');
  
  }
  
  protected function getNodesTreeTop($EmpresaId,$node,$Layout,$color){
  
	require_once("AsignarPermisosModelClass.php");	  
	
    $Model    = new asignarPermisosModel();	
	
	$children = $Model -> getChildrenTop($EmpresaId,$this -> getConex());
	$permisos = $Model -> getPermisos($this -> getConex());	
	
	if(count($children) > 0){
	
	   $j = 0;
	   	   
	   for($i = 0; $i < count($children); $i++){
	   
   	     $j++;
	   
	     $Layout -> setVar('oficina_nombre',$children[$i]['nombre']);
	     $Layout -> setVar('node',"$node-$j");	
	     $Layout -> setVar('child',"$node");	
	     $Layout -> setVar('consecutivo',$children[$i]['consecutivo']);	  		 
	     $Layout -> setVar('path_imagen',$children[$i]['path_imagen']);	  
  	     $Layout -> setVar('descripcion',$children[$i]['descripcion']);			 		 		 
  	     $Layout -> setVar('color',$color);			 		 	
  	     $Layout -> setVar('permisos',$permisos);			 		 			 	 		 
    	 $Layout -> RenderLayout('asignarpermisos.tpl');		 	   
	   
	     $this -> getNodesTreeTop($children[$i]['consecutivo'],"$node-$j",$Layout,$color);
	   }
	   
	}else{
	     return false;
	  }
  
  }
  
  protected function setOficinasUsuarioAplicacion(){
	  
	require_once("AsignarPermisosModelClass.php");	  
	
    $Model = new asignarPermisosModel();	
	
    $empresa_usuario_id = $_REQUEST['empresa_usuario_id'];
    $oficina_id         = $_REQUEST['oficina_id'];
	
	$Model -> setOficinas($empresa_usuario_id,$oficina_id,$this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit('false');
    }else{
	    exit('true');
	 }	
	  
  }
  
  protected function getOficinasAplicacion(){
	  
	require_once("AsignarPermisosLayoutClass.php");
	require_once("AsignarPermisosModelClass.php");	  
	
	$Layout   = new asignarPermisosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new asignarPermisosModel();		  
	
	$empresa_usuario_id = $_REQUEST['empresa_usuario_id'];
	$oficinas           = $Model -> getOficinas($empresa_usuario_id,$this -> getConex());
	
	$field = $this -> Campos[oficina_id] = array(type=>'select',multiple=>'multiple',size=>'4',name=>'oficina_id',id=>'oficina_id',
										 options=>$oficinas,required=>'required',tabindex=>'2');
	
    print $Layout -> getObjectHtml($field);
	  
  }
  
  
  protected function getOficinasAplicacionSelected(){
	  
	require_once("AsignarPermisosModelClass.php");	  
	
    $Model    = new asignarPermisosModel();		  
	
	$empresa_usuario_id = $_REQUEST['empresa_usuario_id'];
	$oficinas           = $Model -> getOficinasSelected($empresa_usuario_id,$this -> getConex());	
	
    $this -> getArrayJSON($oficinas);	  
	  
  }
  
  protected function getOpcionesAplicacion(){

	require_once("AsignarPermisosModelClass.php");	  
	
    $Model    = new asignarPermisosModel();		  
	  
	$matrizPermisos        = array();  
    $empresa_usuario_id    = $_REQUEST['empresa_usuario_id'];
    $oficinas_asignadas_id = $_REQUEST['oficinas_asignadas_id'];
	
	$opciones = $Model -> selectOpcionesAplicacion($empresa_usuario_id,$oficinas_asignadas_id,$this -> getConex());
	
	for($i = 0; $i < count($opciones); $i++){
		
		$matrizPermisos[$i]['consecutivo'] = $opciones[$i]['consecutivo'];
		$matrizPermisos[$i]['permisos']    = $Model -> selectPermisosOpcion($opciones[$i]['consecutivo'],$empresa_usuario_id,$oficinas_asignadas_id,$this -> getConex());		
		
    }
		
	$this -> getArrayJSON($matrizPermisos);
	  
  }
  
  protected function setPermisosAplicacion(){
	  
	require_once("AsignarPermisosModelClass.php");	  
	
    $Model    = new asignarPermisosModel();	
	
	$oficina_id         = $_REQUEST['oficina_id'];
	$empresa_usuario_id = $_REQUEST['empresa_usuario_id'];
	$permisosAplicacion = json_decode(str_replace('\\"','"',$_REQUEST['matrizPermisos']));
	  
	if($Model -> setPermisosAplicacion($empresa_usuario_id,$oficina_id,$permisosAplicacion,$this -> getConex())){
	  exit('Se asignaron los permisos exitosamente');
    }else{
		exit("No se asignaron los permisos");
	  }
	
	  	  
  }
  
  protected function setCampos(){

	$this->Campos[usuario] = array(
		name	=>'usuario',
		id		=>'usuario',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'opciones_usuario',
			onclick	=>'getOficinasAplicacion',
			setId	=>'empresa_usuario_id_hidden')
	);
	
	$this->Campos[empresa_usuario_id] = array(
		name	=>'empresa_usuario_id',
		id		=>'empresa_usuario_id_hidden',
		type	=>'hidden',
		required=>'yes'
	);

	$this->Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		multiple=>'multiple',
		options	=>array(),
		size	=>'4',
		required=>'yes',
		//tabindex=>'2'
	);
	
	$this->Campos[oficinas_asignadas_id] = array(
		name	=>'oficinas_asignadas_id',
		id		=>'oficinas_asignadas_id',
		type	=>'select',
		options	=>array(),
		disabled=>'disabled',
		//tabindex=>'3'
	);
 
	$this->Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		//tabindex=>'3'
	);
	
   	$this->Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		disabled=>'disabled',
		//tabindex=>'4',
		onclick	=>'onResetPermisosUsuario()'
	);
	
	$this->Campos[otorgar_denegar] = array(
		name	=>'otorgar_denegar',
		id		=>'otorgar_denegar',
		type	=>'button',
		value	=>'Actualizar permisos',
		disabled=>'disabled',
		//tabindex=>'5'
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
	}


}

$Oficina = new Oficina();

?>