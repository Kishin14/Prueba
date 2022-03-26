<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ARLModel extends Db{
		
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
					
	  $categoria_arl_id    = $this -> DbgetMaxConsecutive("categoria_arl","categoria_arl_id",$Conex,true,1);
	
      $this -> assignValRequest('categoria_arl_id',$categoria_arl_id);
      $this -> DbInsertTable("categoria_arl",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['categoria_arl_id'] == 'NULL'){
	    $this -> DbInsertTable("categoria_arl",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("categoria_arl",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("categoria_arl",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"categoria_arl",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosARLId($categoria_arl_id,$Conex){
  
 	$select = "SELECT t.* FROM categoria_arl t WHERE t.categoria_arl_id = $categoria_arl_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryARLGrid(){
   	$Query = "SELECT categoria_arl_id, clase_riesgo,descripcion, porcentaje, IF(estado='A','ACTIVO','INACTIVO') AS estado FROM categoria_arl";
   return $Query;
   }
}

?>