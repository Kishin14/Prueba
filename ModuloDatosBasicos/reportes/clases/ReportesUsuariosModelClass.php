<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReportesUsuariosModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  
   public function GetOficina($Conex){
	return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,$ErrDb = false);
   }
   
   public function GetPermiso($Conex){
	return $this -> DbFetchAll("SELECT permiso_id AS value,descripcion AS text FROM permiso",$Conex,$ErrDb = false);
   }
  
   public function GetTipo($Conex){
	return $this -> DbFetchAll("SELECT consecutivo AS value,descripcion AS text FROM actividad WHERE modulo=1 AND consecutivo!=1 AND consecutivo!=100",$Conex,$ErrDb = false);
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

}

?>