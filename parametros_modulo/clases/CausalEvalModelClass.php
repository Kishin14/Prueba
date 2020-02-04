<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CausalEvalModel extends Db{
		
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
					
	  $causal_desempeno_id    = $this -> DbgetMaxConsecutive("causal_desempeno","causal_desempeno_id",$Conex,true,1);
	
      $this -> assignValRequest('causal_desempeno_id',$causal_desempeno_id);
      $this -> DbInsertTable("causal_desempeno",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    
    $this -> Begin($Conex);
    $causal_desempeno_id = $_REQUEST['causal_desempeno_id'];
	  if($causal_desempeno_id == 'NULL'){
	    $this -> DbInsertTable("causal_desempeno",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("causal_desempeno",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("causal_desempeno",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"causal_desempeno",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosCausalEvalId($causal_desempeno_id,$Conex){
  
 	$select = "SELECT t.causal_desempeno_id, t.nombre, t.nota, t.estado FROM causal_desempeno t WHERE t.causal_desempeno_id = $causal_desempeno_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryCausalEvalGrid(){
   	$Query = "SELECT causal_desempeno_id, nombre,  IF(estado='A','ACTIVO','INACTIVO') AS estado, nota FROM causal_desempeno";
   return $Query;
   }
}

?>