<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetLiqFinDedModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){

	$concepto                  	= $this -> requestDataForQuery('concepto','integer'); 
	$dias             			= $this -> requestDataForQuery('dias','integer'); 
	$valor          			= $this -> requestDataForQuery('valor','integer'); 
	$liquidacion_definitiva_id  = $this -> requestDataForQuery('liquidacion_definitiva_id','integer'); 
	$concepto_area_id           = $this -> requestDataForQuery('concepto_area_id','integer'); 
	$puc_id                   	= $this -> requestDataForQuery('puc_id','text'); 	
	$debito             		= $this -> requestDataForQuery('debito','text'); 
	$credito                  	= $this -> requestDataForQuery('credito','text');                   
   
	$liq_def_deduccion_id = $this -> DbgetMaxConsecutive("liq_def_deduccion","liq_def_deduccion_id",$Conex,true,true);	

     $insert = "INSERT INTO liq_def_deduccion (liq_def_deduccion_id,concepto,valor,dias,liquidacion_definitiva_id,concepto_area_id, puc_id, debito, credito)
        VALUES ($liq_def_deduccion_id,$concepto,$valor,$dias,$liquidacion_definitiva_id,$concepto_area_id, $puc_id, $debito, $credito)";
	
        $this -> query($insert,$Conex);

	return $liq_def_deduccion_id;

  }

  public function Update($Campos,$Conex){
    
    $liq_def_deduccion_id       = $this -> requestDataForQuery('liq_def_deduccion_id','integer'); 
	$concepto                  	= $this -> requestDataForQuery('concepto','integer'); 
	$dias             			= $this -> requestDataForQuery('dias','integer'); 
	$valor          			= $this -> requestDataForQuery('valor','integer'); 
	$liquidacion_definitiva_id  = $this -> requestDataForQuery('liquidacion_definitiva_id','integer'); 
	$concepto_area_id           = $this -> requestDataForQuery('concepto_area_id','integer'); 
	$puc_id                   	= $this -> requestDataForQuery('puc_id','text'); 	
	$debito             		= $this -> requestDataForQuery('debito','text'); 
	$credito                  	= $this -> requestDataForQuery('credito','text');                   
   
    $update = "UPDATE liq_def_deduccion SET concepto=$concepto, dias=$dias, valor=$valor, liquidacion_definitiva_id=$liquidacion_definitiva_id, concepto_area_id=$concepto_area_id, puc_id=$puc_id, debito=$debito, credito=$credito WHERE liq_def_deduccion_id=$liq_def_deduccion_id";
	
    $this -> query($update,$Conex);

  }

  public function Delete($Campos,$Conex){
	$liq_def_deduccion_id              = $this -> requestDataForQuery('liq_def_deduccion_id','integer'); 
    $select = "SELECT liq_def_deduccion_id FROM liq_def_deduccion WHERE liq_def_deduccion_id = $liq_def_deduccion_id ";
    $result = $this -> DbFetchAll($select,$Conex);
	if($result[0]['liq_def_deduccion_id']>0){
		$update = "UPDATE liq_def_deduccion SET estado='A'  WHERE liq_def_deduccion_id=$liq_def_deduccion_id AND estado='D'";
		$this -> query($update,$Conex,true);
		
	}else{

	  	$this -> DbDeleteTable("liq_def_deduccion",$Campos,$Conex,true,false);
	}
  
  }
  
  public function getConcepto($Conex){

    $select = "SELECT concepto_area_id AS value,descripcion AS text FROM concepto_area WHERE estado = 'A' ORDER BY concepto_area_id ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;

  }
  
  
  public function getDetallesLiqFinDed($Conex){
  
	$liquidacion_definitiva_id = $this -> requestDataForQuery('liquidacion_definitiva_id','integer');
	
	if(is_numeric($liquidacion_definitiva_id)){
	
		$select  = "SELECT l.* FROM liq_def_deduccion l WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id ORDER BY liq_def_deduccion_id ASC";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  } 

   
}



?>