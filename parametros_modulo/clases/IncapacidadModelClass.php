<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class IncapacidadModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
    
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $tipo_incapacidad_id    = $this -> DbgetMaxConsecutive("tipo_incapacidad","tipo_incapacidad_id",$Conex,true,1);
	
      $this -> assignValRequest('tipo_incapacidad_id',$tipo_incapacidad_id);
      $this -> DbInsertTable("tipo_incapacidad",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['tipo_incapacidad_id'] == 'NULL'){
	    $this -> DbInsertTable("tipo_incapacidad",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("tipo_incapacidad",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("tipo_incapacidad",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tipo_incapacidad",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosIncapacidadId($tipo_incapacidad_id,$Conex){
  
 	$select = "SELECT t.*, 
	REPLACE(REPLACE(REPLACE(FORMAT(t.porcentaje, 3), '.', '@'), ',', '.'), '@', ',') AS porcentaje
	FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id = $tipo_incapacidad_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryIncapacidadGrid(){
   	$Query = "SELECT tipo_incapacidad_id, nombre, 
			IF(tipo='L','LICENCIA','INCAPACIDAD') AS tipo,
			IF(diagnostico='N','NO','SI') AS diagnostico,
			IF(descuento='S','SI','NO') AS descuento,dia,porcentaje,
			IF(estado='A','ACTIVO','INACTIVO') AS estado FROM tipo_incapacidad";
   return $Query;
   }
}

?>