<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ProfesionesModel extends Db{
		
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
					
	  $profesion_id    = $this -> DbgetMaxConsecutive("profesion","profesion_id",$Conex,true,1);
	
      $this -> assignValRequest('profesion_id',$profesion_id);
      $this -> DbInsertTable("profesion",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['profesion_id'] == 'NULL'){
	    $this -> DbInsertTable("profesion",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("profesion",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("profesion",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"profesion",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosProfesionesId($profesion_id,$Conex){
  
 	$select = "SELECT p.* FROM profesion p WHERE p.profesion_id = $profesion_id";
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryProfesionesGrid(){
   	$Query = "SELECT * FROM profesion";
   return $Query;
   }
}

?>