<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ConceptoModel extends Db{
		
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
					
	  $tipo_concepto_id    = $this -> DbgetMaxConsecutive("tipo_concepto","tipo_concepto_laboral_id",$Conex,true,1);
	
      $this -> assignValRequest('tipo_concepto_laboral_id',$tipo_concepto_id);
      $this -> DbInsertTable("tipo_concepto",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['tipo_concepto_laboral_id'] == 'NULL'){
	    $this -> DbInsertTable("tipo_concepto",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("tipo_concepto",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("tipo_concepto",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tipo_concepto",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosConceptoId($tipo_concepto_laboral_id,$Conex){
  
 	$select = "SELECT t.* FROM tipo_concepto t WHERE t.tipo_concepto_laboral_id = $tipo_concepto_laboral_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryConceptoGrid(){
   	$Query = "SELECT tipo_concepto_laboral_id, concepto, base_salarial, fija, porc_empresa, porc_trabajador
    FROM tipo_concepto";
   return $Query;
   }
}

?>