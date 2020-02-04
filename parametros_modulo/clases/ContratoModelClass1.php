<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ContratoModel extends Db{
		
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
					
	  $tipo_contrato_id    = $this -> DbgetMaxConsecutive("tipo_contrato","tipo_contrato_id",$Conex,true,1);
	
      $this -> assignValRequest('tipo_contrato_id',$tipo_contrato_id);
      $this -> DbInsertTable("tipo_contrato",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['tipo_contrato_id'] == 'NULL'){
	    $this -> DbInsertTable("tipo_contrato",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("tipo_contrato",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("tipo_contrato",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tipo_contrato",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosContratoId($tipo_contrato_id,$Conex){
  
 	$select = "SELECT t.* FROM tipo_contrato t WHERE t.tipo_contrato_id = $tipo_contrato_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryContratoGrid(){
   	$Query = "SELECT tipo_contrato_id, nombre, descripcion, periodo_prueba, 
    IF(indemnizacion='1','SI','NO') AS indemnizacion, 
    IF(liquidacion='1','SI','NO') AS liquidacion,
    IF(prestaciones_sociales='1','SI','NO') AS prestaciones_sociales,
	IF(tipo='F','FIJO','INDEFINIDO') AS tipo
    FROM tipo_contrato";
   return $Query;
   }
}

?>