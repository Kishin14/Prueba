<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Parametros_documentoModel extends Db{
		
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
					
	  $tipo_documento_laboral_id    = $this -> DbgetMaxConsecutive("tipo_documento_laboral","tipo_documento_laboral_id",$Conex,true,1);
	
      $this -> assignValRequest('tipo_documento_laboral_id',$tipo_documento_laboral_id);
      $this -> DbInsertTable("tipo_documento_laboral",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['tipo_documento_laboral_id'] == 'NULL'){
	    $this -> DbInsertTable("tipo_documento_laboral",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("tipo_documento_laboral",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("tipo_documento_laboral",$Campos,$Conex,true,false);
    }
	
	  public function Tipo($tipo_contrato_id,$Conex){		  
		$select = "SELECT tipo_contrato_id  FROM tipo_documento_laboral WHERE tipo_contrato_id=$tipo_contrato_id"; 
		$result = $this -> DbFetchAll($select,$Conex,true);
		return $result[0]['tipo_contrato_id'];    
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tipo_documento_laboral",$Campos);
	 return $Data -> GetData();
   }

	public function GetTip($Conex){
		return $this -> DbFetchAll("SELECT tipo_contrato_id  AS value, nombre AS text FROM tipo_contrato ORDER BY nombre ASC",$Conex,
		$ErrDb = false);
	}

    public function selectDatosParametrosdocumentoId($tipo_documento_laboral_id,$Conex){
  
 	$select = "SELECT t.* FROM tipo_documento_laboral t WHERE t.tipo_documento_laboral_id = $tipo_documento_laboral_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryParametroDocumento(){
   	$Query = "SELECT tipo_documento_laboral_id, nombre_documento FROM tipo_documento_laboral";
   return $Query;
   }
}

?>