<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CausalDesModel extends Db{
		
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
					
	  $causal_despido_id    = $this -> DbgetMaxConsecutive("causal_despido","causal_despido_id",$Conex,true,1);
	
      $this -> assignValRequest('causal_despido_id',$causal_despido_id);
      $this -> DbInsertTable("causal_despido",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['causal_despido_id'] == 'NULL'){
	    $this -> DbInsertTable("causal_despido",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("causal_despido",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("causal_despido",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"causal_despido",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosCausalDesId($causal_despido_id,$Conex){
  
 	$select = "SELECT t.* FROM causal_despido t WHERE t.causal_despido_id = $causal_despido_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryCausalDesGrid(){
   	$Query = "SELECT causal_despido_id, nombre, IF(tipo_causal='J','JUSTIFICADA','INJUSTIFICADA') AS tipo_causal, IF(estado='A','ACTIVO','INACTIVO') AS estado FROM causal_despido";
   return $Query;
   }
}

?>