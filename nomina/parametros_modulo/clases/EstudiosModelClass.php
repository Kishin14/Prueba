<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class EstudiosModel extends Db{
		
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
					
	  $nivel_escolaridad_id    = $this -> DbgetMaxConsecutive("nivel_escolaridad","nivel_escolaridad_id",$Conex,true,1);
	
      $this -> assignValRequest('nivel_escolaridad_id',$nivel_escolaridad_id);
      $this -> DbInsertTable("nivel_escolaridad",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['nivel_escolaridad_id'] == 'NULL'){
	    $this -> DbInsertTable("nivel_escolaridad",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("nivel_escolaridad",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

   public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("nivel_escolaridad",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"nivel_escolaridad",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosEstudiosId($nivel_escolaridad_id,$Conex){
  
 	$select = "SELECT n.* FROM nivel_escolaridad n WHERE n.nivel_escolaridad_id = $nivel_escolaridad_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryEstudiosGrid(){
	   	   
   $Query = "SELECT 
    nivel_escolaridad_id,
    nombre,
    descripcion,
    IF(estado='1','ACTIVO','INACTIVO') AS estado
			FROM nivel_escolaridad n ";
   return $Query;
   }
}

?>