<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class NovedadModel extends Db{
		
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
					
	  $causal_novedad_id    = $this -> DbgetMaxConsecutive("causal_novedad","causal_novedad_id",$Conex,true,1);
	
      $this -> assignValRequest('causal_novedad_id',$causal_novedad_id);
      $this -> DbInsertTable("causal_novedad",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['causal_novedad_id'] == 'NULL'){
	    $this -> DbInsertTable("causal_novedad",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("causal_novedad",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("causal_novedad",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"causal_novedad",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosNovedadId($causal_novedad_id,$Conex){
  
 	$select = "SELECT t.* FROM causal_novedad t WHERE t.causal_novedad_id = $causal_novedad_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryNovedadGrid(){
   	$Query = "SELECT causal_novedad_id, nombre, IF(estado='A','ACTIVO','INACTIVO') AS estado FROM causal_novedad";
   return $Query;
   }
}

?>