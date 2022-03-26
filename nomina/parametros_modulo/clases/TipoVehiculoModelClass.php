<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TipoVehiculoModel extends Db{
		
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
					
	  $vehiculo_nomina_id    = $this -> DbgetMaxConsecutive("tipo_vehiculo_nomina","vehiculo_nomina_id",$Conex,true,1);
	
      $this -> assignValRequest('vehiculo_nomina_id',$tipo_vehiculo_nomina_id);
      $this -> DbInsertTable("tipo_vehiculo_nomina",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['vehiculo_nomina_id'] == 'NULL'){
	    $this -> DbInsertTable("tipo_vehiculo_nomina",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("tipo_vehiculo_nomina",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("tipo_vehiculo_nomina",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tipo_vehiculo_nomina",$Campos);
	 return $Data -> GetData();
   }

    public function selectDatosTipoVehiculoId($vehiculo_nomina_id,$Conex){
  
 	$select = "SELECT tv.* FROM tipo_vehiculo_nomina tv WHERE tv.vehiculo_nomina_id = $vehiculo_nomina_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
  

   public function GetQueryTipoVehiculoGrid(){
   	$Query = "SELECT t.nombre,t.codigo, IF(t.servicio= 1,'PARTICULAR','PUBLICO') AS servicio, IF (t.tipo = 'C', 'CARGA', IF(t.tipo = 'P', 'PASAJERO','PROPIO')) AS tipo
			FROM tipo_vehiculo_nomina t";
   return $Query;
   }
   
   
  
}

?>