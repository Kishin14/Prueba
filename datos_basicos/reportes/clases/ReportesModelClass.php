<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReportesModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
   public function GetTablas($Conex){
		return $this  -> DbFetchAll("SELECT tabla AS value, tabla AS text  FROM  log_transacciones GROUP BY tabla ORDER BY tabla 
		ASC",$Conex,$ErrDb = false);
   }

   public function GetTipo($Conex){
	$opciones=array(0 => array ( 'value' => 'ALL', 'text' => 'TODOS' ), 1 => array ( 'value' => 'IN', 'text' => 'INGRESOS'), 2 => array ( 'value' => 'AC', 'text' => 'ACTUALIZACIONES'), 3 => array ( 'value' => 'DL', 'text' => 'ELIMINACIONES') );
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

}

?>