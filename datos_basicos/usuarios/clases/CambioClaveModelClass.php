<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CambioClaveModel extends Db{

  public function getUsuarioId($Conex){
	  
    $user = $_SESSION['USER'];	  
    $pass = md5($_SESSION['PASS']);
	
	$select = "SELECT * FROM usuario WHERE usuario = '$user' AND password = '$pass'";
	
	$datosUsuario = $this -> DbFetchAll($select,$Conex);
	$usuario_id       = $datosUsuario[0]['usuario_id'];	  
	
	return $usuario_id;	  
	  
  }
  
  public function getUsuario($Conex){
	  
    $user = $_SESSION['USER'];	  
    $pass = md5($_SESSION['PASS']);
	
	$select = "SELECT * FROM usuario WHERE usuario = '$user' AND password = '$pass'";
	
	$datosUsuario = $this -> DbFetchAll($select,$Conex);
	$User         = $datosUsuario[0]['usuario'];	  
	
	return $User;
	
  }
  
  public function getUsuarioNombres($Conex){
	  
    $user = $_SESSION['USER'];	  
    $pass = md5($_SESSION['PASS']);
	
	$select = "SELECT * FROM usuario WHERE usuario = '$user' AND password = '$pass'";
	
	$datosUsuario = $this -> DbFetchAll($select,$Conex);
	$usuario_id       = $datosUsuario[0]['usuario_id'];
	
	$select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM usuario WHERE usuario_id = $usuario_id)";
	
    $datosTercero   = $this -> DbFetchAll($select,$Conex);		
    $usuarioNombres = $datosTercero[0]['primer_nombre'].' '.$datosTercero[0]['segundo_nombre'].' '.$datosTercero[0]['primer_apellido'].' '.$datosTercero[0]['segundo_apellido'];

    return $usuarioNombres;
  }
  		
  public function Update($Conex){	

    $usuario_id = $_REQUEST['usuario_id'];
	$pass   = md5(trim($_REQUEST['clave']));
	
	$update = "UPDATE usuario SET password = '$pass' WHERE usuario_id = $usuario_id";
	
	$this -> query($update,$Conex);
	
	if($this -> GetError()){
      return false;
    }else{
		$_SESSION['PASS'] = $_REQUEST['clave'];
		return true;
      }

  }
   

}





?>