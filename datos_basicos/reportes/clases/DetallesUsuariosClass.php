<?php

require_once("../../../framework/clases/ControlerClass.php");
final class DetallesUsuarios extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesUsuariosLayoutClass.php");
    require_once("DetallesUsuariosModelClass.php");
		
	$Layout                 = new DetallesUsuariosLayout();
	$Model                  = new DetallesUsuariosModel();
    $tipo 					= $_REQUEST['tipo'];
	$si_usuario				= $_REQUEST['si_usuario'];
	$usuario				= $_REQUEST['usuario'];
	$usuario_id				= $_REQUEST['usuario_id'];	
	$permiso_id				= $_REQUEST['permiso_id'];	
	$oficina_id				= $_REQUEST['oficina_id'];	
	$all_permiso			= $_REQUEST['all_permiso'];
	$all_tipos				= $_REQUEST['all_tipos'];
	$all_office				= $_REQUEST['all_office'];
	$download				= $_REQUEST['download'];

	if($si_usuario=='ALL'){$condicion_usuario=' ';} else {$condicion_usuario=' o.usuario_id ='.$usuario_id.' AND ';}
	if($all_permiso=='ALL'){$condicion_permiso=' ';} else {$condicion_permiso=' permiso_id IN('.$permiso_id.')';}
	if($all_tipos=='SI'){$condicion_tipo=' ';} else {$condicion_tipo=' AND consecutivo IN('.$tipo.')';}
	if($all_office=='SI'){$condicion_oficina=' ';} else {$condicion_oficina=$oficina_id.'=o.oficina_id AND';}
	
    	$Layout -> setIncludes();
		$data= $Model -> getReporte1($condicion_permiso,$condicion_tipo,$condicion_oficina,$condicion_usuario,$usuario_id,$tipo,$oficina_id,$permiso_id,$this -> getConex());
		$Layout -> setVar('data',$data);
		$download = $this -> requestData('download');
	
	if($download == 'true'){
	    $Layout -> exportToExcel('detallesUsuarios.tpl'); 		
	}else{	
		  $Layout -> RenderMain();
	  }
	
    
  }
}

$DetallesUsuarios = new DetallesUsuarios();

?>