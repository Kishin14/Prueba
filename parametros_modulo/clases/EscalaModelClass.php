<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class EscalaModel extends Db{
		
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
					
	  $escala_salarial_id    = $this -> DbgetMaxConsecutive("escala_salarial","escala_salarial_id",$Conex,true,1);
	
      $this -> assignValRequest('escala_salarial_id',$escala_salarial_id);
      $this -> DbInsertTable("escala_salarial",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
  
   public function getuvt($Conex){
  
		 $periodo_contable_id = $this -> requestDataForQuery('periodo_contable_id','integer');
		 
		 if(is_numeric($periodo_contable_id)){
		 
			  $select  = "SELECT uvt_nominal FROM uvt
			  WHERE periodo_contable_id = $periodo_contable_id"; 
				$result  = $this -> DbFetchAll($select,$Conex,true);
			   
		 }
		 
	 	return $result[0]['uvt_nominal'];
	}
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['escala_salarial_id'] == 'NULL'){
	    $this -> DbInsertTable("escala_salarial",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("escala_salarial",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("escala_salarial",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"escala_salarial",$Campos);
	 return $Data -> GetData();
   }

	public function GetPeriodo($Conex){
		return $this  -> DbFetchAll("SELECT periodo_contable_id AS value,anio AS text FROM periodo_contable ORDER BY anio ASC",$Conex,$ErrDb = false);
	  }

    public function selectDatosEscalaId($escala_salarial_id,$Conex){
  
 	$select = "SELECT e.* FROM escala_salarial e WHERE e.escala_salarial_id = $escala_salarial_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryEscalaGrid(){
   	$Query = "SELECT * FROM escala_salarial";
   return $Query;
   }
}

?>